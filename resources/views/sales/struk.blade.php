<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body onload="window.print()">
    <div class="card bg-white">
        <div class="card-body">
            <h5 class="card-title">Transaksi Berhasil</h5>
            <div class="mb-2">------------------------------------</div>
            <p class="card-text">Nama Customer: {{ $transaction->customername }}</p>
            <p class="card-text">Nama Kasir: {{ $transaction->user->name }}</p>
            <p class="card-text">Kode Struk: {{ $transaction->id }}</p>
            <div class="mb-2">------------------------------------</div>
            <div class="mt-2">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Menu</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->details as $detail)
                            <tr>
                                <td>{{ $detail->menu->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="2">Total</th>
                            <th>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Uang yang Diberikan</th>
                            <th>Rp {{ number_format($paymentAmount, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Kembalian</th>
                            <th>Rp {{ number_format($paymentAmount - $transaction->total_amount, 0, ',', '.') }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mb-2">------------------------------------</div>
            <p class="card-text">Terima Kasih Atas Pesanannya :)</p>
        </div>
    </div>
</body>
</html>
