@extends('layouts.app2')

@section('content')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    /* Pastikan ada jarak antara navbar dan konten */
    body {
        margin-top: 80px;
        /* Sesuaikan dengan tinggi navbar */
    }

    /* Container utama */
    .container {
        margin-left: 450px;
        padding: 20px;
        max-width: 800px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 100vh;
        /* Pastikan container memenuhi tinggi halaman */
        overflow-y: auto;
        /* Memungkinkan konten menggulir jika terlalu panjang */
        transition: margin-left 0.3s ease;
        /* Menambahkan animasi transisi */
    }

    /* Kelas untuk menggeser konten saat sidebar disembunyikan */
    .container.shifted {
        margin-left: 390px;
        /* Pindahkan konten ke kiri ketika sidebar disembunyikan */
    }

    .font-weight-bold {
        font-weight: 700 !important;
    }

    .form-check-inline {
        margin-right: 1rem;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        font-size: 1.1rem;
    }

    /* Kelas untuk item transaksi */
    .transaction-item {
        margin-top: 10px;
        margin-bottom: 0.5rem;
        display: flex;
        width: 100%;
        justify-content: space-between;
        /* Membuat nama item di kiri dan harga di kanan */
        align-items: center;
    }

    .transaction-item .item-name {
        text-align: left;
        /* Nama item di kiri */
        margin-right: 500px;
        white-space: nowrap;
    }

    .transaction-item .item-price {
        text-align: right;
        /* Harga item di kanan */
        white-space: nowrap;
    }

    .divider {
        border-top: 2px solid #ddd;
        margin: 1rem 0;
        width: 100%;
    }

    @media (max-width: 768px) {
        .container {
            margin-left: 0;
            padding: 10px;
        }

        .form-check-inline {
            margin-right: 0.5rem;
        }
    }
</style>

<div class="container mt-4">
    <h3 class="font-weight-bold">Konfirmasi Pesanan</h3>
    <div id="transactionItemsList" class="content-wrapper">
        <!-- Daftar item transaksi akan ditambahkan di sini dengan JavaScript -->
    </div>
    <hr class="divider">
    <div class="d-flex justify-content-between w-100">
        <strong>Total Keseluruhan:</strong>
        <span id="transactionTotalPrice">Rp 0</span>
    </div>

    <hr>

    <!-- Pilihan Lokasi Makan -->
    <div class="form-group mt-3 w-100">
        <label class="font-weight-bold">Pilih Lokasi Makan:</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="diningOption" id="dineIn" value="dine-in" onclick="toggleDineInOptions(true)">
            <label class="form-check-label" for="dineIn">Makan di Tempat</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="diningOption" id="takeAway" value="take-away" onclick="toggleDineInOptions(false)" checked>
            <label class="form-check-label" for="takeAway">Bawa Pulang</label>
        </div>
    </div>

    <!-- Opsi Meja jika makan di tempat -->
    <div id="dineInOptions" style="display: none;" class="w-100">
        <div class="form-group">
            <label for="tableNumber" class="font-weight-bold">Nomor Meja (1-20):</label>
            <input type="number" class="form-control" id="tableNumber" min="1" max="20" placeholder="Masukkan nomor meja">
        </div>
        <div class="form-group">
            <label for="customerName" class="font-weight-bold">Atas Nama:</label>
            <input type="text" class="form-control" id="customerName" placeholder="Masukkan nama">
        </div>
    </div>
    <hr class="divider">

    <!-- Pilihan Metode Pembayaran -->
    <div class="form-group mt-3 w-100">
        <label class="font-weight-bold">Pilih Metode Pembayaran:</label>
        <div class="d-flex flex-wrap">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentOption" id="cashPayment" value="cash" onclick="toggleCashInput(true)">
                <label class="form-check-label" for="cashPayment">Cash</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentOption" id="qrPayment" value="qr" onclick="toggleCashInput(false)">
                <label class="form-check-label" for="qrPayment">Scan QR</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentOption" id="ewalletPayment" value="ewallet" onclick="toggleCashInput(false)">
                <label class="form-check-label" for="ewalletPayment">E-Wallet</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentOption" id="bankingPayment" value="banking" onclick="toggleCashInput(false)">
                <label class="form-check-label" for="bankingPayment">Banking</label>
            </div>
        </div>
    </div>

   <!-- Input Cash Amount jika pembayaran Cash -->
<div id="cashAmountInput" style="display: none;" class="form-group">
    <label for="cashAmount" class="font-weight-bold">Jumlah Uang Tunai:</label>
    <input type="text" class="form-control" id="cashAmount" placeholder="Masukkan jumlah uang tunai" oninput="formatRupiah(this)">
    <small id="paymentMessage" class="text-danger" style="display: none;">Jumlah uang tidak mencukupi.</small>
</div>

    <button type="button" class="btn btn-primary w-100 mt-4 font-weight-bold" onclick="confirmOrder()">Bayar</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const transactionItemsList = document.getElementById('transactionItemsList');
        transactionItemsList.innerHTML = '';

        let totalTransactionPrice = 0;

        cartItems.forEach(item => {
            const transactionItem = document.createElement('div');
            transactionItem.classList.add('transaction-item');
            transactionItem.innerHTML = `
                <div class="item-name">${item.name} (x${item.quantity})</div>
                <div class="item-price">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</div>
            `;
            transactionItemsList.appendChild(transactionItem);
            totalTransactionPrice += item.price * item.quantity;
        });

        document.getElementById('transactionTotalPrice').innerText = 'Rp ' + totalTransactionPrice.toLocaleString('id-ID');
        localStorage.removeItem('cartItems');

        // Simpan total harga ke variabel untuk digunakan dalam verifikasi cash
        window.totalTransactionPrice = totalTransactionPrice;
    });

    function toggleDineInOptions(show) {
        document.getElementById('dineInOptions').style.display = show ? 'block' : 'none';
    }

    function toggleCashInput(show) {
        const cashInput = document.getElementById('cashAmountInput');
        cashInput.style.display = show ? 'block' : 'none';
        document.getElementById('paymentMessage').style.display = 'none'; // Reset pesan
    }

    // Fungsi untuk format input ke format Rupiah dengan koma pemisah ribuan
    function formatRupiah(input) {
        let value = input.value.replace(/[^,\d]/g, '').toString();
        let split = value.split(',');
        let rupiah = split[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        input.value = 'Rp ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);
    }

    function confirmOrder() {
        const paymentMethod = document.querySelector('input[name="paymentOption"]:checked').value;
        const diningOption = document.querySelector('input[name="diningOption"]:checked').value;
        let confirmationMessage = Pesanan Anda dikonfirmasi dengan metode pembayaran: ${paymentMethod} dan pilihan: ${diningOption === 'dine-in' ? 'Makan di Tempat' : 'Bawa Pulang'}.;

        if (diningOption === 'dine-in') {
            const tableNumber = document.getElementById('tableNumber').value;
            const customerName = document.getElementById('customerName').value;
            confirmationMessage += \nNomor Meja: ${tableNumber}, Atas Nama: ${customerName}.;
        }

        if (paymentMethod === 'cash') {
            const cashAmountInput = document.getElementById('cashAmount').value;
            const cashAmount = parseFloat(cashAmountInput.replace(/[^,\d]/g, '').replace(',', '.'));
            if (isNaN(cashAmount) || cashAmount < window.totalTransactionPrice) {
                document.getElementById('paymentMessage').style.display = 'block';
                return;
            }
            confirmationMessage += \nJumlah Tunai: Rp ${cashAmount.toLocaleString('id-ID')};
        }

        alert(confirmationMessage);
    }
</script>
@endsection