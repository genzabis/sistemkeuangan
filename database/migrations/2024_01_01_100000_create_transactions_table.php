<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->date('date');
            $table->integer('amount');
            $table->enum('category', [
                'Makan',
                'Transport',
                'Rokok',
                'Belanja',
                'Hiburan',
                'Tagihan',
                'Lainnya'
            ]);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
