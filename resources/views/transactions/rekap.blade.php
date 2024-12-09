@extends('layouts.app')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Transaction Recap</h4>
                        <h6>Manage your transaction recap</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-top">
                            <form method="GET" action="{{ route('rekap') }}">
                                <ul class="list-inline mb-0">
                                    <!-- Filter Tahun -->
                                    <li class="list-inline-item">
                                        <div class="form-group">
                                            <label for="year">Tahun</label>
                                            <input type="number" name="year" 
                                                   value="{{ request()->year ?? now()->year }}" 
                                                   class="form-control" placeholder="Tahun" required>
                                        </div>
                                    </li>

                                    <!-- Filter Bulan -->
                                    <li class="list-inline-item">
                                        <div class="form-group">
                                            <label for="month">Bulan</label>
                                            <select name="month" class="form-control">
                                                <option value="">Pilih Bulan</option>
                                                @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $month)
                                                    <option value="{{ $index + 1 }}" 
                                                        {{ request()->month == ($index + 1) ? 'selected' : '' }}>
                                                        {{ $month }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </li>

                                    <!-- Pilihan Hari atau Minggu -->
                                    <li class="list-inline-item">
                                        <div class="form-group">
                                            <label for="day_or_week">Pilih Hari atau Minggu</label>
                                            <select name="day_or_week" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="day" {{ request()->day_or_week == 'day' ? 'selected' : '' }}>Satu Hari</option>
                                                <option value="week" {{ request()->day_or_week == 'week' ? 'selected' : '' }}>Satu Minggu</option>
                                            </select>
                                        </div>
                                    </li>

                                    <!-- Input Tanggal jika memilih Satu Hari -->
                                    @if(request()->day_or_week == 'day')
                                        <li class="list-inline-item">
                                            <div class="form-group">
                                                <label for="day">Tanggal</label>
                                                <input type="date" name="day" class="form-control" value="{{ request()->day }}">
                                            </div>
                                        </li>
                                    @endif

                                    <!-- Input Minggu jika memilih Satu Minggu -->
                                    @if(request()->day_or_week == 'week')
                                        <li class="list-inline-item">
                                            <div class="form-group">
                                                <label for="week">Minggu</label>
                                                <select name="week" class="form-control">
                                                    <option value="">Pilih Minggu</option>
                                                    @for ($i = 1; $i <= 52; $i++)
                                                        <option value="{{ $i }}" {{ request()->week == $i ? 'selected' : '' }}>Minggu {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </li>
                                    @endif

                                    <!-- Tombol Filter -->
                                    <li class="list-inline-item">
                                        <button class="btn btn-primary mt-1" type="submit">Filter</button>
                                    </li>

                                </ul>
                            </form>
                            <ul>

                                <li>
                                    <a href="{{ route('transaction.exportRekap', ['export' => 'excel']) }}" class="btn btn-outline-primary d-flex align-items-center" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Download Excel">
                                        <img src="assets/img/icons/excel.svg" alt="Excel Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                                        <span>Download Excel</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recapTotals as $date => $total)
                                        <tr>
                                            <td>{{ $date }}</td>
                                            <td>{{ number_format($total, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">Tidak ada data transaksi untuk filter yang dipilih.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
