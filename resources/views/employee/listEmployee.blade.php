@extends('layouts.app')
@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Customer List</h4>
                    <h6>Manage your Customers</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('addEmployee') }}" class="btn btn-added"><img src="assets/img/icons/plus.svg"
                            alt="img">Add Customer</a>
                </div>
            </div>

            @if (session('successdelete'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('successdelete') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg"
                                        alt="img"></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a href="{{ route('employee.export') }}" class="btn btn-outline-primary d-flex align-items-center" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
                                        <img src="assets/img/icons/excel.svg" alt="Excel Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                                        <span>Download Excel</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Profile</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $employees as $employee)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);" class="product-img">
                                            <img src="{{ asset('storage/image/' . $employee->image) }}" alt="image">
                                        </a>
                                    </td>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->email}}</td>
                                    <td>{{$employee->address}}</td>
                                    <td>{{$employee->notelp}}</td>
                                    <td>
                                        <a class="me-3" href="{{route('editEmployee', $employee->id)}}">
                                            <img src="assets/img/icons/edit.svg" alt="img">
                                        </a>

                                        <a class="me-3 confirm-text" href="javascript:void(0);" data-id="{{ $employee->id }}" data-type="employee">
                                            <img src="assets/img/icons/delete.svg" alt="img" />
                                        </a>
                                        <form id="delete-form-{{ $employee->id }}" action="{{ route('deleteEmployee', $employee->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>                                        
                                    </td>
                                </tr>
                                @endforeach
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