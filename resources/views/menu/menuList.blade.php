@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product List</h4>
                    <h6>Manage your products</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('addMenu') }}" class="btn btn-added">
                        <img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add New Product
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input" id="search-container">
                                <a class="btn btn-searchset" id="search-toggle">
                                    <img src="assets/img/icons/search-white.svg" alt="Search Icon" style="width: 15px;">
                                </a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a href="{{ route('menu.export') }}"
                                        class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Download Excel">
                                        <img src="assets/img/icons/excel.svg" alt="Excel Icon"
                                            style="width: 24px; height: 24px; margin-right: 8px;">
                                        <span>Download Excel</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($menus as $menu)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{ asset('storage/image/' . $menu->image) }}" alt="image">
                                            </a>
                                            <a href="javascript:void(0);">{{ $menu->name }}</a>
                                        </td>
                                        <td>{{ $menu->category }}</td>
                                        <td>{{ number_format($menu->price, 2) }}</td>
                                        <td>{{ $menu->stock }}</td>
                                        <td>{{ $menu->status }}</td>
                                        <td>
                                            <a class="me-3" href="#">
                                                <img src="assets/img/icons/eye.svg" alt="img">
                                            </a>
                                            <a class="me-3" href="{{ route('editMenu', $menu->id) }}">
                                                <img src="assets/img/icons/edit.svg" alt="img">
                                            </a>

                                            <a class="me-3 confirm-text" href="javascript:void(0);"
                                                data-id="{{ $menu->id }}" data-type="menu">
                                                <img src="assets/img/icons/delete.svg" alt="img" />
                                            </a>
                                            <form id="delete-form-{{ $menu->id }}"
                                                action="{{ route('deleteMenu', $menu->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Menambahkan input pencarian secara dinamis setelah tombol diklik
        document.getElementById('search-toggle').addEventListener('click', function() {
            var searchContainer = document.getElementById('search-container');
    
            // Memeriksa apakah input sudah ada, jika belum, menambahkannya
            if (!document.getElementById('search-input-field')) {
                var searchInputHTML = `
                    <form action="{{ route('menuList') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" id="search-input-field" class="form-control" placeholder="Cari menu..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-searchset">
                                <img src="assets/img/icons/search-white.svg" alt="Search Icon" style="width: 20px;">
                            </button>
                        </div>
                    </form>
                `;
                // Menambahkan input pencarian ke dalam container
                searchContainer.innerHTML = searchInputHTML;
            }
        });
    </script>
@endsection
