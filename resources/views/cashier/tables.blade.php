@extends('layouts.app')

@section('title', 'Status Meja - Cashier')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-12">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-0.5 bg-stone-900"></div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-stone-400 font-bold">Operasional Kasir</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-stone-900 font-heading uppercase tracking-tight">Status Meja</h1>
            <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mt-4">Pantau dan kelola ketersediaan meja</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white px-6 py-4 rounded-2xl shadow-sm border border-stone-100">
            <div class="relative flex items-center justify-center">
                <div class="w-2 h-2 rounded-full bg-stone-900 animate-ping absolute"></div>
                <div class="w-2 h-2 rounded-full bg-stone-900 relative"></div>
            </div>
            <span class="text-[10px] font-bold text-stone-900 uppercase tracking-[0.2em]">
                Auto Refresh: <span id="timer" class="text-stone-400 ml-1">10</span>s
            </span>
        </div>
    </div>

    <!-- Status Meja Section -->
    <div id="tables-section" class="transition-all duration-500">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            @foreach($tables as $table)
            <div class="bg-white rounded-[32px] p-8 border transition-all duration-500 flex flex-col items-center gap-6
                {{ $table->is_occupied 
                    ? 'border-red-100 shadow-sm' 
                    : 'border-stone-100 shadow-sm hover:shadow-xl hover:-translate-y-1' }}">
                
                <div class="flex flex-col items-center">
                    <span class="text-[9px] font-bold uppercase tracking-[0.3em] {{ $table->is_occupied ? 'text-red-300' : 'text-stone-300' }} mb-2">Meja</span>
                    <span class="text-6xl font-bold font-heading {{ $table->is_occupied ? 'text-red-900' : 'text-stone-900' }}">
                        {{ $table->number }}
                    </span>
                </div>
                
                <div class="flex flex-col items-center gap-6 w-full">
                    <span class="px-5 py-2 rounded-full text-[9px] font-bold uppercase tracking-widest
                        {{ $table->is_occupied 
                            ? 'bg-red-50 text-red-600' 
                            : 'bg-stone-50 text-stone-400' }}">
                        {{ $table->is_occupied ? 'Terisi' : 'Kosong' }}
                    </span>

                    @if($table->is_occupied)
                    <form action="{{ route('cashier.tables.vacate', $table) }}" method="POST" onsubmit="vacateTable(event, '{{ $table->number }}')" class="w-full">
                        @csrf
                        <button type="submit" class="w-full bg-stone-900 text-white rounded-2xl py-3.5 text-[9px] font-bold uppercase tracking-widest hover:bg-stone-800 transition-all shadow-lg shadow-stone-200">
                            Kosongkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    let timeLeft = 10;
    const timerEl = document.getElementById('timer');
    
    function refreshTables() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newTablesSection = doc.getElementById('tables-section');
                const currentTablesSection = document.getElementById('tables-section');
                if (newTablesSection && currentTablesSection) {
                    currentTablesSection.innerHTML = newTablesSection.innerHTML;
                }
                
                timeLeft = 10;
                if (timerEl) timerEl.textContent = timeLeft;
            })
            .catch(error => console.error('Error refreshing tables:', error));
    }

    setInterval(() => {
        timeLeft--;
        if (timerEl) timerEl.textContent = timeLeft;
        if (timeLeft <= 0) refreshTables();
    }, 1000);

    function vacateTable(event, tableNumber) {
        event.preventDefault();
        Swal.fire({
            title: `Kosongkan Meja ${tableNumber}?`,
            text: "QR Token meja ini akan diperbarui secara otomatis.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0c0a09',
            cancelButtonColor: '#78716c',
            confirmButtonText: 'Ya, Kosongkan',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            color: '#0c0a09',
            customClass: {
                confirmButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest',
                cancelButton: 'rounded-full px-8 py-3 uppercase text-[10px] font-bold tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) event.target.submit();
        });
    }
</script>
@endpush
@endsection
