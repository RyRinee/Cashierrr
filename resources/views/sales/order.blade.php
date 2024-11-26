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
            color: black
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
            <div class="page-header">
            </div>
            <div class="row">
                @foreach ($menus as $menu)
                <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card" style="width: 16rem; font-size: 0.9rem;"">
                            <img src="{{ asset('storage/image/' . $menu->image) }}" class="card-img-top"
                                alt="{{ $menu->name }}">
                            <div class="card-body">
                                <p class="card-text text-capitalize">{{ $menu->category }}</p>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel" style="font-weight: bold;">Keranjang Anda</h5> <button
                        type="button" class="close" onclick="closeCheckoutModal()" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="cartForm" action="{{ route('transaction') }}" method="POST">
                        @csrf
                        <div id="cartItemsList"> <!-- Item cart akan ditampilkan di sini --> </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Keseluruhan:</strong>
                            <span id="checkoutTotalPrice">Rp 0</span>
                        </div>
                        <input type="hidden" name="total_amount" id="totalAmountInput">
                        <input type="hidden" name="cart_items" id="cartItemsInput">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success w-100">Checkout</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Formulir tersembunyi untuk mengirimkan data keranjang -->
    <form id="cartForm" action="{{ route('transaction') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="cart_items" id="cartItemsInput">
    </form>


    <script>
        let cartItems = [];
        let isModalOpen = false; // Flag untuk mencegah modal terbuka berulang kali
        let isFooterCartShown = false; // Untuk memastikan footer cart hanya muncul sekali

        document.addEventListener('DOMContentLoaded', () => {
            loadCartFromLocalStorage();
        });

        // Tambahkan item ke keranjang
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

            cartItemsInput.value = JSON.stringify(cartItems); // Mengonversi data keranjang menjadi JSON
            totalAmountInput.value = calculateTotal(); // Mengonversi total amount menjadi nilai

            document.getElementById('cartForm').submit(); // Mengirimkan formulir
        }

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

                // Tambahkan input tersembunyi untuk qty
                const qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.name = `qty[${item.id}]`;
                qtyInput.value = item.quantity;
                cartItemsList.appendChild(qtyInput);
            });

            cartItemCount.textContent = `${totalItems} items`;
            cartTotalPrice.textContent = `Rp ${totalPrice.toLocaleString()}`;

            footerCart.style.display = cartItems.length === 0 ? 'none' : 'flex';

            // Simpan data ke localStorage
            saveCartToLocalStorage();
        }

        function calculateTotal() {
            return cartItems.reduce((total, item) => {
                let price = parseFloat(item.price.replace('Rp ', '').replace(',', '').replace(' ', ''));
                return total + price * item.quantity;
            }, 0);
        }



        // Tampilkan modal checkout
        function openCheckoutModal(ignoreFlag = false) {
            if (!ignoreFlag && isModalOpen) return; // Cegah modal dibuka berulang kali dari tombol "Pesan"

            const cartItemsList = document.getElementById('cartItemsList');
            const checkoutTotalPrice = document.getElementById('checkoutTotalPrice');

            const cartListHtml = cartItems.map(item => `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <strong>${item.name}</strong> 
                <span>(${item.quantity} x ${item.price})</span>
            </div>
            <span>Rp ${(parseFloat(item.price.replace('Rp ', '').replace(',', '').replace(' ', '')) * item.quantity).toLocaleString()}</span>
        </div>
    `).join('');

            cartItemsList.innerHTML = cartListHtml;
            checkoutTotalPrice.textContent = `Rp ${calculateTotal().toLocaleString()}`;

            isModalOpen = true; // Set flag agar modal tidak muncul berulang kali dari tombol "Pesan"
            $('#checkoutModal').modal('show'); // Tampilkan modal
        }

        // Footer cart membuka modal tanpa memeriksa flag
        function openFooterCartModal() {
            openCheckoutModal(true); // Abaikan flag isModalOpen
        }

        // Hitung total harga
        function calculateTotal() {
            return cartItems.reduce((total, item) => {
                let price = parseFloat(item.price.replace('Rp ', '').replace(',', '').replace(' ', ''));
                return total + price * item.quantity;
            }, 0);
        }

        // Sembunyikan modal checkout
        function closeCheckoutModal() {
            $('#checkoutModal').modal('hide');
            isModalOpen = false; // Reset flag ketika modal ditutup
        }

        // Tambah jumlah item
        function increaseQuantity(button) {
            const quantitySpan = button.previousElementSibling;
            let quantity = parseInt(quantitySpan.textContent);
            quantity++;
            quantitySpan.textContent = quantity;

            // Jangan buka modal ketika kuantitas berubah
            updateItemQuantity(button, quantity);
        }

        // Kurangi jumlah item
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

                const itemName = button.closest('.card').querySelector('.card-title').textContent;
                removeFromCart(itemName);
            }
        }

        // Perbarui jumlah item di keranjang
        function updateItemQuantity(button, quantity) {
            const itemName = button.closest('.card').querySelector('.card-title').textContent;
            const itemIndex = cartItems.findIndex(item => item.name === itemName);

            if (itemIndex !== -1) {
                cartItems[itemIndex].quantity = quantity;
            }

            updateCartDisplay();
        }

        // Hapus item dari keranjang
        function removeFromCart(itemName) {
            cartItems = cartItems.filter(item => item.name !== itemName);
            updateCartDisplay();
        }

        // Fungsi menyimpan footer cart
        function saveCartToLocalStorage() {
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
        }
    </script>
@endsection
