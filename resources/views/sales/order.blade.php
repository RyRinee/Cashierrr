@extends('layouts.app2')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .page-wrapper {
            padding: 20px;
            margin-top: 50px;
        }

        .content {
            padding: 20px;
        }

        .btn-order {
            width: 100%;
            padding: 10px 20px;
            font-size: 14px;
            border: 1px solid #fc8543;
            color: #fc8543;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-order:hover {
            background-color: #fc8543;
            color: black;
        }

        .quantity-btns {
            display: none;
            align-items: center;
            gap: 10px;
            justify-content: center;
        }

        .quantity-btns button {
            width: 35px;
            height: 35px;
            padding: 5px 10px;
            font-size: 14px;
            background-color: none;
            border: 1px solid #fc8543;
            color: black;
            border-radius: 50%;
            cursor: pointer;
        }

        .quantity-btns button:hover {
            background-color: #fc8543;
            color: black;
        }

        .quantity-number {
            font-size: 16px;
            font-weight: bold;
        }

        /* Footer Cart */
        .footer-cart {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 400px;
            height: 50px;
            background-color: none;
            border: 1px solid #fc8543;
            color: #fc8543;
            border-radius: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
            transition: background-color 0.3s ease;
        }

        .footer-cart:hover {
            background-color: #ffa16e;
            color: black;
        }

        .footer-cart .cart-item-count {
            font-size: 14px;
            font-weight: 400;
        }

        .footer-cart .cart-total-price {
            display: flex;
            align-items: center;
            font-size: 16px;
        }

        .footer-cart .cart-total-price .price-amount {
            font-weight: bold;
            margin-right: 5px;
        }

        /* Modal Header Styling */
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-header h5 {
            font-weight: bold;
            color: #333;
        }

        .modal-header .close {
            font-size: 20px;
            color: #333;
        }

        /* Modal Footer */
        .modal-footer {
            border-top: none;
        }

        .modal-footer .btn-success {
            background-color: #fc8543;
            border: none;
        }

        .modal-footer .btn-success:hover {
            background-color: #ff7023;
        }

        /* Additional Styles for Checkout Modal */
        .checkout-content {
            display: flex;
            flex-direction: row;
        }

        .checkout-content .cart-items {
            max-height: 400px;
            overflow-y: auto;
        }

        .checkout-content .checkout-info {
            max-height: 400px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .checkout-content {
                flex-direction: column;
            }
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-lg-3,
        .col-sm-6,
        .col-12 {
            flex: 1;
            max-width: calc(25% - 20px);
            min-width: 240px;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .col-lg-3 {
                max-width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .col-lg-3 {
                max-width: 100%;
            }
        }

        .card-img-top {
            margin: 1rem;
            width: calc(100% - 2rem);
            /* Mengurangi margin dari lebar gambar */
            height: auto;
            object-fit: cover;
            border-radius: 5px;
            box-sizing: border-box;
            /* Agar margin dihitung dalam lebar gambar */
        }
    </style>

    <div class="page-wrapper ms-0">
        <div class="content">
            <div class="page-wrapper ms-0 mb-0>
                <div class="col-lg-12 col-sm-12 tabs_wrapper">
                <ul class="tabs owl-carousel owl-theme owl-product border-0">
                    <li class="active" id="all" data-category="all">
                        <div class="product-details">
                            <img src="assets/img/product/product62.png" alt="img" />
                            <h6>All</h6>
                        </div>
                    </li>
                    <li id="makanan" data-category="makanan">
                        <div class="product-details">
                            <img src="assets/img/product/product62.png" alt="img" />
                            <h6>Makanan</h6>
                        </div>
                    </li>
                    <li id="minuman" data-category="minuman">
                        <div class="product-details">
                            <img src="assets/img/product/product62.png" alt="img" />
                            <h6>Minuman</h6>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
        <div class="row" id="menu-container">
            @foreach ($menus as $menu)
                @if ($menu->stock > 0)
                    <div class="col-lg-3 col-sm-6 col-12 menu-item"
                        data-category="{{ strtolower($menu->category) === 'makanan' ? 'makanan' : 'minuman' }}">
                        <div class="card" style="width: 16rem; font-size: 0.9rem;">
                            <img src="{{ asset('storage/image/' . $menu->image) }}" class="card-img-top"
                                alt="{{ $menu->name }}">
                            <div class="card-body">
                                <p class="card-text text-capitalize">{{ $menu->category }}</p>
                                <p class="card-text text-capitalize">{{ $menu->stock }}</p>
                                <h5 class="card-title">{{ $menu->name }}</h5>
                                <p class="card-text">Rp.{{ $menu->price }}</p>
                                <button class="btn btn-order"
                                    onclick="addToCart('{{ $menu->name }}', '{{ $menu->price }}', this)">Pesan</button>
                                <div class="quantity-btns" style="display: none;">
                                    <button onclick="decreaseQuantity(this)">-</button>
                                    <span class="quantity-number">1</span>
                                    <button onclick="increaseQuantity(this)">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
    </div>

    <!-- Footer Cart -->
    <div id="footerCart" class="footer-cart" onclick="openFooterCartModal()">
        <span class="cart-item-count">0 items</span>
        <span class="cart-total-price">
            <span class="price-amount">0</span> <i class="fa-solid fa-bag-shopping"></i>
        </span>
    </div>


    <!-- Modal untuk Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel" style="font-weight: bold;">Keranjang Anda</h5>
                    <button type="button" class="close" onclick="closeCheckoutModal()" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="cartForm" action="{{ route('transaction') }}" method="POST">
                        @csrf
                        <div class="checkout-content d-flex">
                            <!-- Daftar Item Keranjang -->
                            <div id="cartItemsList" class="cart-items w-50 border-end pe-3">
                                <h5>Item dalam Keranjang</h5>
                            </div>

                            <!-- Informasi Checkout -->
                            <div class="checkout-info w-50 ps-3">
                                <div class="d-flex justify-content-between">
                                    <strong>Total Keseluruhan:</strong>
                                    <span id="checkoutTotalPrice">Rp 0</span>
                                </div>

                                <!-- Hidden fields untuk data transaksi -->
                                <input type="hidden" name="total_amount" id="totalAmountInput">
                                <input type="hidden" name="cart_items" id="cartItemsInput">
                                <input type="hidden" name="payment_method" id="paymentMethodInput">

                                <!-- Metode Pembayaran -->
                                <h5 class="mt-3">Metode Pembayaran</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method_option"
                                        id="cashPayment" value="Cash" checked onchange="toggleQRIS()">
                                    <label class="form-check-label" for="cashPayment">Cash</label>
                                </div>
                                {{-- <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method_option"
                                        id="qrisPayment" value="QRIS" onchange="toggleQRIS()">
                                    <label class="form-check-label" for="qrisPayment">QRIS</label>
                                </div> --}}

                                <!-- Input untuk jumlah yang dibayar -->
                                <div id="cashAmountSection" class="form-group mt-3">
                                    <label for="cashAmount">Jumlah yang Dibayar:</label>
                                    <input type="number" name="cash_amount" class="form-control" id="cashAmount"
                                        placeholder="Masukkan jumlah uang yang dibayar" oninput="validatePayment()">
                                    <small id="error-message" style="color: red; display: none;">Jumlah uang yang
                                        dimasukkan
                                        kurang dari total yang harus dibayar.</small>
                                </div>

                                <!-- QRIS QR Code -->
                                <div id="qrisQRCode" class="mt-3" style="display: none; text-align: center;">
                                    <p><strong>Scan QR Code:</strong></p>
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <img src="storage/qrcode.png" alt="QRIS QR Code"
                                            style="width: 40%; max-width: 150px;">
                                    </div>
                                </div>

                                <!-- Tombol Checkout -->
                                <div class="modal-footer p-0 mt-3">
                                    <button type="submit" class="btn btn-success w-100"
                                        id="checkoutButton">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
      

        document.querySelectorAll('.tabs li').forEach(tab => {
            tab.addEventListener('click', function() {
                // Hapus kelas 'active' dari semua tab
                document.querySelectorAll('.tabs li').forEach(t => t.classList.remove('active'));

                // Tambahkan kelas 'active' ke tab yang diklik
                this.classList.add('active');

                const selectedCategory = this.getAttribute('data-category');

                // Filter menu berdasarkan kategori
                document.querySelectorAll('.menu-item').forEach(item => {
                    if (selectedCategory === 'all' || item.getAttribute('data-category') ===
                        selectedCategory) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Menampilkan semua menu secara default
        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.menu-item').forEach(item => {
                item.style.display = 'block';
            });
        });

        let cartItems = []; // Menyimpan item dalam keranjang
        let isModalOpen = false; // Flag untuk mencegah modal terbuka berulang kali
        let isFooterCartShown = false; // Untuk memastikan footer cart hanya muncul sekali

        // Fungsi untuk menyimpan data keranjang ke localStorage
        function saveCartToLocalStorage() {
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
        }

        // Fungsi untuk memperbarui tampilan keranjang
        function updateCartDisplay() {
            const cartItemCount = document.querySelector('.cart-item-count');
            const cartTotalPrice = document.querySelector('.cart-total-price .price-amount');
            const footerCart = document.getElementById('footerCart');
            const cartItemsList = document.getElementById('cartItemsList');

            let totalItems = 0;
            let totalPrice = 0;

            cartItemsList.innerHTML = ''; // Clear existing items

            cartItems.forEach(item => {
                totalItems += item.quantity;
                let price = parseFloat(item.price.replace('Rp ', '').replace(',', '').replace(' ', ''));
                totalPrice += price * item.quantity;

                // Tambahkan elemen untuk menampilkan item
                const itemDiv = document.createElement('div');
                itemDiv.className = 'd-flex justify-content-between align-items-center mb-2';
                itemDiv.innerHTML = `
        <div>
            <strong>${item.name}</strong> 
            <span>(${item.quantity} x ${item.price})</span>
        </div>
        <span>Rp ${(price * item.quantity).toLocaleString()}</span>
        `;
                cartItemsList.appendChild(itemDiv);
            });

            cartItemCount.textContent = `${totalItems} items`;
            cartTotalPrice.textContent = `Rp ${totalPrice.toLocaleString()}`;

            footerCart.style.display = cartItems.length === 0 ? 'none' : 'flex';

            // Simpan data ke localStorage
            saveCartToLocalStorage();
        }

        // Fungsi untuk menghitung total harga
        function calculateTotal() {
            return cartItems.reduce((total, item) => {
                let price = parseFloat(item.price.replace('Rp ', '').replace(',', '').replace(' ', ''));
                return total + price * item.quantity;
            }, 0);
        }

        console.log("Script loaded successfully");

        // Fungsi untuk menambahkan item ke keranjang
        function addToCart(itemName, itemPrice, button) {
            const quantityBtns = button.nextElementSibling;

            // Sembunyikan tombol "Pesan" dan tampilkan kontrol kuantitas
            button.style.display = 'none';
            quantityBtns.style.display = 'flex';

            // Tambahkan item ke keranjang
            const itemIndex = cartItems.findIndex(item => item.name === itemName);
            if (itemIndex === -1) {
                cartItems.push({
                    name: itemName,
                    price: itemPrice,
                    quantity: 1
                });
            } else {
                cartItems[itemIndex].quantity += 1;
            }

            updateCartDisplay();

            // Tampilkan footer cart 
            if (!isFooterCartShown) {
                const footerCart = document.getElementById('footerCart');
                footerCart.style.display = 'flex'; // Tampilkan footer cart
                isFooterCartShown = true;
            }
        }

        function redirectToTransaction() {
            const cartItemsInput = document.getElementById('cartItemsInput');
            const totalAmountInput = document.getElementById('totalAmountInput');
            const paymentMethodInput = document.getElementById('paymentMethodInput');

            const cartItemsList = document.getElementById('cartItemsList');
            const items = [];

            // Ambil item dari cartItems dan konversi ke JSON
            for (let i = 0; i < cartItems.length; i++) {
                const item = cartItems[i];
                items.push({
                    name: item.name,
                    price: item.price,
                    quantity: item.quantity
                });
            }

            cartItemsInput.value = JSON.stringify(items);
            totalAmountInput.value = calculateTotal();
            paymentMethodInput.value = document.querySelector('input[name="payment_method_option"]:checked').value;

            document.getElementById('cartForm').submit(); // Mengirimkan formulir
        }




        // Fungsi untuk menampilkan modal checkout
        function openCheckoutModal(ignoreFlag = false) {
            if (!ignoreFlag && isModalOpen) return; // Cegah modal dibuka berulang kali dari tombol "Pesan"

            updateCartDisplay(); // Memperbarui tampilan sebelum membuka modal

            const checkoutTotalPrice = document.getElementById('checkoutTotalPrice');
            checkoutTotalPrice.textContent = `Rp ${calculateTotal().toLocaleString()}`;

            isModalOpen = true; // Set flag agar modal tidak muncul berulang kali dari tombol "Pesan"
            $('#checkoutModal').modal('show'); // Tampilkan modal
        }

        // Footer cart membuka modal tanpa memeriksa flag
        function openFooterCartModal() {
            openCheckoutModal(true); // Abaikan flag isModalOpen
        }

        // Fungsi untuk menyembunyikan modal checkout
        function closeCheckoutModal() {
            $('#checkoutModal').modal('hide');
            isModalOpen = false; // Reset flag ketika modal ditutup
        }

        // Fungsi untuk menambah jumlah item
// Fungsi untuk menambah jumlah item
function increaseQuantity(button) {
    const quantitySpan = button.previousElementSibling;
    let quantity = parseInt(quantitySpan.textContent);
    const stock = parseInt(button.closest('.card-body').querySelector('.card-text:nth-child(2)').textContent); // Ambil stok dari elemen card

    // Hanya tambahkan kuantitas jika masih ada stok
    if (quantity < stock) {
        quantity++;
        quantitySpan.textContent = quantity;

        // Perbarui kuantitas item di keranjang tanpa membuka modal
        updateItemQuantity(button, quantity);
    } else {
        alert('Maaf, Stok tidak cukup!');
    }
}

        // Fungsi untuk mengurangi jumlah item
        function decreaseQuantity(button) {
            const quantitySpan = button.nextElementSibling;
            let quantity = parseInt(quantitySpan.textContent);

            if (quantity > 1) {
                quantity--;
                quantitySpan.textContent = quantity;
                updateItemQuantity(button, quantity);
            } else {
                const quantityBtns = button.closest('.quantity-btns');
                const orderButton = quantityBtns.previousElementSibling;

                quantityBtns.style.display = 'none';
                orderButton.style.display = 'inline-block';

                const itemName = button.closest('.card-body').querySelector('.card-title').textContent;
                removeFromCart(itemName);
            }
        }

        // Fungsi untuk memperbarui jumlah item di keranjang
        function updateItemQuantity(button, quantity) {
            const cardBody = button.closest('.card-body');
            if (!cardBody) {
                console.error("Card body not found");
                return;
            }
            const itemNameElem = cardBody.querySelector('.card-title');
            if (!itemNameElem) {
                console.error("Item name not found");
                return;
            }
            const itemName = itemNameElem.textContent;
            const itemIndex = cartItems.findIndex(item => item.name === itemName);

            if (itemIndex !== -1) {
                cartItems[itemIndex].quantity = quantity;
            }

            updateCartDisplay();
        }

        // Fungsi untuk menghapus item dari keranjang
        function removeFromCart(itemName) {
            cartItems = cartItems.filter(item => item.name !== itemName);
            updateCartDisplay();
        }

        // Fungsi untuk menampilkan dan mengelola metode pembayaran QRIS
        function toggleQRIS() {
            const paymentMethod = document.querySelector('input[name="payment_method_option"]:checked').value;
            const qrisQRCode = document.getElementById('qrisQRCode');
            const cashAmountSection = document.getElementById('cashAmountSection');

            // Cek apakah metode pembayaran QRIS dipilih
            if (paymentMethod === 'QRIS') {
                qrisQRCode.style.display = 'block'; // Tampilkan QRIS
                cashAmountSection.style.display = 'none'; // Sembunyikan kolom jumlah uang
            } else {
                qrisQRCode.style.display = 'none'; // Sembunyikan QRIS
                cashAmountSection.style.display = 'block'; // Tampilkan kolom jumlah uang
            }
        }

        // Fungsi untuk memvalidasi jumlah yang dibayar
        function validatePayment() {
            const cashAmount = parseFloat(document.getElementById('cashAmount').value);
            const totalAmount = calculateTotal(); // Total yang harus dibayar
            const errorMessage = document.getElementById('error-message');
            const checkoutButton = document.getElementById('checkoutButton');

            // Periksa apakah jumlah uang yang dimasukkan kurang dari total
            if (cashAmount < totalAmount) {
                // Tampilkan pesan error
                errorMessage.style.display = 'block';
                // Nonaktifkan tombol checkout
                checkoutButton.disabled = true;
            } else {
                // Sembunyikan pesan error
                errorMessage.style.display = 'none';
                // Aktifkan tombol checkout
                checkoutButton.disabled = false;
            }
        }

        // Memanggil fungsi redirectToTransaction saat tombol checkout ditekan
        document.getElementById('checkoutButton').addEventListener('click', (event) => {
            event.preventDefault();
            redirectToTransaction();
        });
    </script>
@endsection
