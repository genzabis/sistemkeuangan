<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::forUser(Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');
        
        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->where('date', '>=', Carbon::createFromFormat('Y-m-d', $request->start_date));
        }
        
        if ($request->filled('end_date')) {
            $query->where('date', '<=', Carbon::createFromFormat('Y-m-d', $request->end_date));
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        $transactions = $query->paginate(15);
        $categories = Transaction::CATEGORIES;
        
        return view('transactions.index', compact('transactions', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Transaction::CATEGORIES;
        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|integer|min:1',
            'category' => 'required|in:' . implode(',', Transaction::CATEGORIES),
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama transaksi harus diisi',
            'date.required' => 'Tanggal harus diisi',
            'amount.required' => 'Nominal harus diisi',
            'amount.min' => 'Nominal minimal Rp 1',
            'category.required' => 'Kategori harus dipilih',
        ]);
        
        Transaction::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'category' => $validated['category'],
            'notes' => $validated['notes'] ?? null,
        ]);
        
        return redirect()->route('dashboard')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Pastikan user hanya bisa edit transaksi miliknya
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        $categories = Transaction::CATEGORIES;
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Pastikan user hanya bisa update transaksi miliknya
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'amount' => 'required|integer|min:1',
            'category' => 'required|in:' . implode(',', Transaction::CATEGORIES),
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama transaksi harus diisi',
            'date.required' => 'Tanggal harus diisi',
            'amount.required' => 'Nominal harus diisi',
            'amount.min' => 'Nominal minimal Rp 1',
            'category.required' => 'Kategori harus dipilih',
        ]);
        
        $transaction->update($validated);
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Pastikan user hanya bisa hapus transaksi miliknya
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        $transaction->delete();
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
