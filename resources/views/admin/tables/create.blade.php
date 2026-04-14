@extends('layouts.app')

@section('title', 'Tambah Meja Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.tables.index') }}" class="inline-flex items-center text-sm text-stone-500 hover:text-stone-700 dark:text-stone-400 dark:hover:text-stone-200 mb-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Meja
        </a>
        <h1 class="text-3xl font-bold text-stone-800 dark:text-stone-100">Tambah Meja Baru</h1>
        <p class="text-stone-500 dark:text-stone-400 mt-1">Buat meja baru dengan QR code otomatis</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-stone-900 rounded-lg shadow-sm border border-stone-200 dark:border-stone-800 p-6">
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf

            <!-- Table Number -->
            <div class="mb-6">
                <label for="number" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                    Nomor Meja <span class="text-red-500">*</span>
                </label>
                <input type="text" id="number" name="number" value="{{ old('number') }}" required
                    class="w-full px-4 py-2 border border-stone-300 dark:border-stone-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:bg-stone-800 dark:text-stone-100"
                    placeholder="Contoh: 1, 2, A1, VIP-1">
                @error('number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                    QR code akan dibuat otomatis setelah meja disimpan
                </p>
            </div>

            <!-- Info Box -->
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-200">Informasi</h4>
                        <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                            Setelah meja dibuat, QR code akan tersedia untuk dicetak atau diunduh. Pelanggan dapat memindai QR code untuk melihat menu dan memesan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-3 pt-4 border-t border-stone-200 dark:border-stone-700">
                <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                    Buat Meja
                </button>
                <a href="{{ route('admin.tables.index') }}" class="flex-1 bg-stone-200 hover:bg-stone-300 dark:bg-stone-700 dark:hover:bg-stone-600 text-stone-700 dark:text-stone-200 font-medium py-2.5 px-4 rounded-lg transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
