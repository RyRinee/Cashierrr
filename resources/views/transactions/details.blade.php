@extends('layouts.app')
@section('content')
    
<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Transaction List</h4>
                    <h6>Manage your transaction</h6>
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
                                    <a href="{{ route('transaction.export') }}" class="btn btn-outline-primary d-flex align-items-center" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
                                        <img src="assets/img/icons/excel.svg" alt="Excel Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                                        <span>Download Excel</span>
                                    </a>
                                </li>
                                <li>

                                    <!-- Filter Dropdown -->
                                    <select id="filterPeriod" class="form-select">
                                        <option value="all">All</option>
                                        <option value="day" {{ request('filter') == 'day' ? 'selected' : '' }}>Per Hari</option>
                                        <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Per Minggu</option>
                                        <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Per Bulan</option>
                                    </select>

                                    {{-- <div class="form-group">
                                        <label>Category</label>
                                        <select class="select" name="category">
                                            <option>Choose Category</option>
                                            <option value="makanan">Food</option>
                                            <option value="minuman">Drink</option>
                                        </select>
                                    </div> --}}
                                    
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
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Total</th>
                                    <th>Biller</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)    
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->id }}</td>
                                    <td><span class="badges bg-lightgreen">Completed</span></td>
                                    <td><span class="badges bg-lightgreen">Paid</span></td>
                                    <td>{{ $transaction->total_amount }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td class="text-center">
                                        <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                            aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item"
                                                    data-bs-toggle="modal" data-bs-target="#showpayment-{{ $transaction->id }}"><img
                                                        src="assets/img/icons/dollar-square.svg" class="me-2"
                                                        alt="img">Show Payments</a>
                                            </li>
                                        </ul>
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
</div>

@foreach ($transactions as $transaction)  
    <div class="modal fade" id="showpayment-{{ $transaction->id }}" tabindex="-1" aria-labelledby="showpayment" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Show Payments</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Id Transaction</th>
                                    <th>Menu Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->details as $item)         
                                    <tr class="bor-b1">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->transaction_id }}</td>
                                        <td>{{ $item->menu->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


<div class="modal fade" id="createpayment" tabindex="-1" aria-labelledby="createpayment" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Customer</label>
                            <div class="input-groupicon">
                                <input type="text" value="2022-03-07" class="datetimepicker">
                                <div class="addonset">
                                    <img src="assets/img/icons/calendars.svg" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Reference</label>
                            <input type="text" value="INV/SL0101">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Received Amount</label>
                            <input type="text" value="0.00">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Paying Amount</label>
                            <input type="text" value="0.00">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Payment type</label>
                            <select class="select">
                                <option>Cash</option>
                                <option>Online</option>
                                <option>Inprogress</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label>Note</label>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-submit">Submit</button>
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editpayment" tabindex="-1" aria-labelledby="editpayment" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Payment</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Customer</label>
                            <div class="input-groupicon">
                                <input type="text" value="2022-03-07" class="datetimepicker">
                                <div class="addonset">
                                    <img src="assets/img/icons/datepicker.svg" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Reference</label>
                            <input type="text" value="INV/SL0101">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Received Amount</label>
                            <input type="text" value="0.00">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Paying Amount</label>
                            <input type="text" value="0.00">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Payment type</label>
                            <select class="select">
                                <option>Cash</option>
                                <option>Online</option>
                                <option>Inprogress</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label>Note</label>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-submit">Submit</button>
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
      document.getElementById('filterPeriod').addEventListener('change', function() {
            var filter = this.value;
            var url = new URL(window.location.href);
            url.searchParams.set('filter', filter); // Mengatur parameter filter di URL
            window.location.href = url.toString(); // Redirect ke URL dengan parameter filter
        });
    // Menambahkan input pencarian secara dinamis setelah tombol diklik
    document.getElementById('search-toggle').addEventListener('click', function() {
        var searchContainer = document.getElementById('search-container');

        // Memeriksa apakah input sudah ada, jika belum, menambahkannya
        if (!document.getElementById('search-input-field')) {
            var searchInputHTML = `
                <form action="{{ route('transactionDetails') }}" method="GET">
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