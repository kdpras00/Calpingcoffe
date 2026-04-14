@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--dark);">Laporan</h1>
            <p style="color: var(--gray);">Analitik penjualan dan produk terlaris</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="glass" style="padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem;">
        <form action="{{ route('admin.reports.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
            <div class="form-group" style="margin-bottom: 0; flex: 1;">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="form-group" style="margin-bottom: 0; flex: 1;">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <!-- Sales Table -->
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--dark); margin-bottom: 1rem;">Penjualan Harian</h2>
            <div class="glass" style="border-radius: 1rem; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB;">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray);">Tanggal</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--gray);">Pesanan</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--gray);">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr style="border-bottom: 1px solid #E5E7EB;">
                            <td style="padding: 1rem;">{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                            <td style="padding: 1rem; text-align: center;">{{ $sale->total_orders }}</td>
                            <td style="padding: 1rem; text-align: right;">Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding: 1rem; text-align: center; color: var(--gray);">Tidak ada data penjualan untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Best Sellers Table -->
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--dark); margin-bottom: 1rem;">10 Produk Terlaris</h2>
            <div class="glass" style="border-radius: 1rem; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB;">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray);">Menu</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--gray);">Terjual</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--gray);">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bestSellers as $item)
                        <tr style="border-bottom: 1px solid #E5E7EB;">
                            <td style="padding: 1rem; font-weight: 500;">{{ $item->menu->name ?? 'Unknown' }}</td>
                            <td style="padding: 1rem; text-align: center;">{{ $item->total_sold }}</td>
                            <td style="padding: 1rem; text-align: right;">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding: 1rem; text-align: center; color: var(--gray);">Tidak ada data ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
