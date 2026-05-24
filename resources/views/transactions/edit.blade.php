<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}" id="transactionForm">
                        @csrf
                        @method('PATCH')

                        <!-- Nama Transaksi -->
                        <div class="mb-4">
                            <x-input-label for="name" value="Nama Transaksi" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $transaction->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-4">
                            <x-input-label for="date" value="Tanggal" />
                            <input type="date" id="date" name="date" value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Nominal -->
                        <div class="mb-4">
                            <x-input-label for="amount" value="Nominal (Rp)" />
                            <input type="number" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" required min="1"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Contoh: 50000">
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Masukkan nominal tanpa titik atau koma</p>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <x-input-label for="category" value="Kategori" />
                            <select id="category" name="category" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category', $transaction->category) == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Catatan -->
                        <div class="mb-6">
                            <x-input-label for="notes" value="Catatan (Opsional)" />
                            <textarea id="notes" name="notes" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Tambahkan catatan jika diperlukan">{{ old('notes', $transaction->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Batal
                            </a>
                            <x-primary-button>
                                Update Transaksi
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Client-side validation
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            const amount = document.getElementById('amount').value;
            const category = document.getElementById('category').value;
            
            if (amount < 1) {
                e.preventDefault();
                alert('Nominal harus minimal Rp 1');
                return false;
            }
            
            if (!category) {
                e.preventDefault();
                alert('Silakan pilih kategori');
                return false;
            }
        });
    </script>
</x-app-layout>
