<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #222;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            color: #777;
        }
        .summary {
            margin-bottom: 25px;
            background-color: #fcfcfc;
            border: 1px solid #eaeaea;
            padding: 10px;
            border-radius: 4px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 6px 10px;
        }
        .summary-table td.label {
            color: #555;
            width: 120px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .data-table th {
            color: #555;
            font-size: 11px;
            background-color: #fafafa;
            border-bottom: 2px solid #ddd;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #aaa;
            padding-top: 10px;
        }
        .badge {
            font-size: 10px;
        }
        .badge-paid {
            color: #059669;
        }
        .badge-pending {
            color: #d97706;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p>Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
    </div>

    <div class="summary">
        <table class="summary-table">
            <tr>
                <td class="label">Total Pesanan</td>
                <td>{{ $orders->count() }} Pesanan</td>
                <td class="label">Total Pendapatan</td>
                <td style="font-weight: bold; font-size: 14px;">Rp {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Waktu</th>
                <th>Meja</th>
                <th>Rincian Item</th>
                <th class="text-right">Total (Rp)</th>
                <th class="text-center">Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-weight: bold;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->created_at->format('H:i') }}</td>
                <td class="text-center">{{ $order->table ? $order->table->number : '-' }}</td>
                <td>
                    @foreach($order->items as $item)
                        <div style="margin-bottom: 4px;">
                            <strong>{{ $item->quantity }}x</strong> {{ $item->menu ? $item->menu->name : 'Menu Terhapus' }}
                        </div>
                    @endforeach
                </td>
                <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="text-center">
                    <span class="badge {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-pending' }}">
                        {{ $order->payment_status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 30px;">Tidak ada data penjualan untuk tanggal ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} oleh {{ Auth::user()->name ?? 'Sistem' }}
    </div>

</body>
</html>
