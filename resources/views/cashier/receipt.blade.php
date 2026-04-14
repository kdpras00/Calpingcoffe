<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 80mm; /* Standard thermal receipt width */
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
        @media print {
            @page {
                margin: 0;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>Calping Cafe</h1>
        <p>Jl. Example No. 123</p>
        <p>Tel: 0812-3456-7890</p>
    </div>

    <div class="divider"></div>

    <div>
        <p>Pesanan #: {{ $order->id }}</p>
        <p>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p>Meja: {{ $order->table->number }}</p>
        <p>Kasir: {{ Auth::user()->name }}</p>
    </div>

    <div class="divider"></div>

    @foreach($order->items as $item)
    <div class="item">
        <span>{{ $item->quantity }}x {{ $item->menu->name }}</span>
        <span>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
    </div>
    @endforeach

    <div class="divider"></div>

    <div class="item total">
        <span>TOTAL</span>
        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
    </div>

    <div class="item">
        <span>Pembayaran</span>
        <span>{{ ucfirst($order->payment_status) }}</span>
    </div>

    <div class="divider"></div>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>Silakan datang kembali.</p>
    </div>
</body>
</html>
