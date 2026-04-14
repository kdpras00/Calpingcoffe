@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-coffee-900 uppercase tracking-tighter">Kelola Pengguna</h1>
            <p class="text-xs font-mono font-bold text-coffee-600 uppercase tracking-widest mt-1">Kelola akses kasir dan barista</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-tuku-mustard text-coffee-900 font-black text-xs uppercase tracking-widest border-2 border-coffee-900 shadow-[4px_4px_0px_0px_rgba(43,30,22,1)] hover:shadow-[6px_6px_0px_0px_rgba(43,30,22,1)] hover:-translate-y-1 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Pengguna baru
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white border-4 border-coffee-900 shadow-[12px_12px_0px_0px_rgba(43,30,22,1)] overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-coffee-900 text-white text-[10px] font-mono font-bold uppercase tracking-widest">
                        <th class="px-6 py-4">Nama Pengguna</th>
                        <th class="px-6 py-4">Alamat Email</th>
                        <th class="px-6 py-4">Role Akses</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-coffee-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-coffee-50 transition-colors group">
                        <td class="px-6 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 border-2 border-coffee-900 bg-white flex items-center justify-center text-coffee-900 font-heading font-black text-xl shadow-[4px_4px_0px_0px_rgba(43,30,22,1)]">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-black text-coffee-900 uppercase tracking-tighter">{{ $user->name }}</span>
                                    <p class="text-[10px] font-mono font-bold text-coffee-400 uppercase tracking-widest mt-1">Dibuat: {{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-xs font-mono font-bold text-coffee-500 lowercase tracking-wider">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap">
                            @if($user->role === 'kasir')
                                <span class="px-3 py-1 bg-blue-500 text-white text-[9px] font-black uppercase tracking-widest border-2 border-coffee-900">
                                    Staff Kasir
                                </span>
                            @elseif($user->role === 'barista')
                                <span class="px-3 py-1 bg-tuku-mustard text-coffee-900 text-[9px] font-black uppercase tracking-widest border-2 border-coffee-900">
                                    Barista
                                </span>
                            @else
                                <span class="px-3 py-1 bg-coffee-100 text-coffee-900 text-[9px] font-black uppercase tracking-widest border-2 border-coffee-900">
                                    {{ ucfirst($user->role) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-6 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 text-sm">
                                <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 bg-white border-2 border-coffee-900 text-coffee-900 text-[10px] font-black uppercase tracking-widest hover:bg-tuku-mustard transition-all shadow-[2px_2px_0px_0px_rgba(43,30,22,1)]">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-coffee-900 text-white border-2 border-coffee-900 hover:bg-red-600 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center text-xs font-mono font-bold text-coffee-400 uppercase tracking-widest">
                            Belum ada pengguna terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
