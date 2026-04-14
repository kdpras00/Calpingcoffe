@extends('layouts.app')

@section('title', 'Cetak QR Code - Meja #' . $table->number)

@section('content')
<div class="print-container" style="max-width: 800px; margin: 2rem auto; padding: 2rem;">
    <!-- Print Header -->
    <div class="text-center mb-4">
        <h1 class="text-3xl font-bold text-stone-900 mb-2">Calping Kopi</h1>
        <p class="text-stone-600">QR Code untuk Meja #{{ $table->number }}</p>
    </div>

    <!-- QR Code Display -->
    <div class="qr-display" style="background: white; padding: 3rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
        <div style="display: inline-block; padding: 2rem; background: white; border: 4px solid #78350f; border-radius: 1rem;">
            <img src="{{ route('admin.tables.qr', $table) }}" alt="QR Code Meja {{ $table->number }}" style="width: 400px; height: 400px; display: block;">
        </div>
        
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 2rem; font-weight: 700; color: #78350f; margin-bottom: 0.5rem;">MEJA #{{ $table->number }}</h2>
            <p style="color: #57534e; font-size: 1.125rem;">Scan untuk melihat menu dan memesan</p>
        </div>
    </div>

    <!-- Instructions -->
    <div style="margin-top: 2rem; padding: 1.5rem; background: #fef3c7; border-radius: 0.75rem; border-left: 4px solid #f59e0b;">
        <h3 style="font-weight: 600; color: #78350f; margin-bottom: 0.5rem;">Cara Menggunakan:</h3>
        <ol style="color: #78350f; margin-left: 1.5rem; line-height: 1.75;">
            <li>Scan QR code menggunakan kamera smartphone</li>
            <li>Pilih menu yang diinginkan</li>
            <li>Lakukan pembayaran</li>
            <li>Tunggu pesanan Anda siap!</li>
        </ol>
    </div>

    <!-- Print Buttons (hidden when printing) -->
    <div class="no-print" style="margin-top: 2rem; text-align: center; gap: 1rem; display: flex; justify-content: center;">
        <button onclick="window.print()" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
            🖨️ Cetak QR Code
        </button>
        <a href="{{ route('admin.tables.download', $table) }}" class="btn" style="padding: 0.75rem 2rem; font-size: 1rem; background: #e7e5e4; color: #44403c; text-decoration: none; display: inline-block;">
            ⬇️ Download SVG
        </a>
        <a href="{{ route('admin.tables.index') }}" class="btn" style="padding: 0.75rem 2rem; font-size: 1rem; background: #e7e5e4; color: #44403c; text-decoration: none; display: inline-block;">
            ← Kembali
        </a>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            background: white;
        }
        
        .print-container {
            max-width: 100%;
            margin: 0;
            padding: 1rem;
        }
        
        .qr-display {
            box-shadow: none !important;
            page-break-inside: avoid;
        }
    }
    
    @page {
        size: A4;
        margin: 1cm;
    }
</style>
@endpush
@endsection
