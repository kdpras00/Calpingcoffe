@extends('layouts.app')

@section('title', 'Kelola Meja')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-stone-900 uppercase tracking-tighter">Kelola Meja</h1>
            <p class="text-xs font-mono font-bold text-stone-600 uppercase tracking-widest mt-1">Kelola meja dan kode QR pelanggan</p>
        </div>
        <a href="{{ route('admin.tables.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-tuku-mustard text-stone-900 font-black text-xs uppercase tracking-widest border-2 border-stone-900 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Meja baru
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white border-4 border-stone-900 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-stone-900 text-white text-[10px] font-mono font-bold uppercase tracking-widest">
                        <th class="px-6 py-4">Nomor Meja</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">QR Code</th>
                        <th class="px-6 py-4 text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-stone-100">
                    @forelse($tables as $table)
                    <tr class="hover:bg-stone-50 transition-colors group">
                        <td class="px-6 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 border-2 border-stone-900 bg-white flex items-center justify-center text-stone-900 font-heading font-black text-xl shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]">
                                    {{ $table->number }}
                                </div>
                                <div>
                                    <span class="font-black text-stone-900 uppercase tracking-tighter">Meja Nomor {{ $table->number }}</span>
                                    <p class="text-[10px] font-mono font-bold text-stone-400 uppercase tracking-widest mt-1">ID: {{ $table->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-center">
                            @if($table->status === 'available')
                                <span class="inline-block px-3 py-1 bg-green-500 text-white text-[10px] font-black uppercase tracking-widest border-2 border-stone-900 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    Tersedia
                                </span>
                            @elseif($table->status === 'occupied')
                                <span class="inline-block px-3 py-1 bg-red-500 text-white text-[10px] font-black uppercase tracking-widest border-2 border-stone-900 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                    Terisi
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-stone-200 text-stone-900 text-[10px] font-black uppercase tracking-widest border-2 border-stone-900">
                                    {{ ucfirst($table->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-center">
                            <div class="inline-block p-1 bg-white border-2 border-stone-900 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]">
                                <img src="{{ route('admin.tables.qr', $table) }}" alt="QR Code Meja {{ $table->number }}" class="w-20 h-20 grayscale hover:grayscale-0 transition-all">
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.tables.print', $table) }}" target="_blank" title="Cetak" class="p-2 bg-white border-2 border-stone-900 text-stone-900 hover:bg-stone-900 hover:text-white transition-all shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                </a>
                                <a href="{{ route('admin.tables.download', $table) }}" title="Unduh" class="p-2 bg-white border-2 border-stone-900 text-stone-900 hover:bg-tuku-mustard transition-all shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                                <form action="{{ route('admin.tables.clear', $table) }}" method="POST" class="inline" onsubmit="confirmClear(event)">
                                    @csrf
                                    <button type="submit" title="Reset" class="p-2 bg-white border-2 border-stone-900 text-stone-900 hover:bg-red-500 hover:text-white transition-all shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" class="inline" onsubmit="confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus" class="p-2 bg-stone-900 text-white border-2 border-stone-900 hover:bg-red-600 transition-all shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-stone-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <p class="text-xs font-mono font-bold text-stone-400 uppercase tracking-widest">Belum ada data meja</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmClear(event) {
        event.preventDefault();
        const form = event.target;
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua pesanan aktif di meja ini akan dibatalkan dan meja akan menjadi kosong.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Kosongkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target;
        
        Swal.fire({
            title: 'Hapus Meja?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
@endsection
