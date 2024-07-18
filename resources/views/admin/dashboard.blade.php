@extends('temp.admin')
@section('content')
<title>Dashboard</title>
@php
    $totalmember = App\Models\Member::count();
    $totalbarang = App\Models\Barang::count();
    $totalpetugas = App\Models\User::count();
@endphp
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-lg-3 col-md-4 bg-light sidebar p-0">
            <div class="sidebar-sticky">
                <img src="../storage/icon.svg" alt="Admin Image" class="img-fluid mx-auto d-block rounded-circle mb-3"
                    style="width: 100px;">
                <p class="text-center h4 mb-4">ADMIN</p>
                <hr>
                <div class="nav flex-column nav-pills">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active">DASHBOARD</a>
                    <a href="{{ route('barang') }}" class="nav-link">BARANG</a>
                    <a href="{{ route('member') }}" class="nav-link">MEMBER</a>
                    <a href="{{ route('petugas') }}" class="nav-link">PETUGAS</a>
                    <a href="{{ route('laporan') }}" class="nav-link">LAPORAN</a>
                </div>
                <hr>
                <div class="text-center">
                    <a class="btn btn-danger w-75 p-2" onclick="confirmLogout()">LOGOUT</a>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="col-lg-9 col-md-8 p-4" id="content">
            <h3 class="mb-4">DASHBOARD</h3>
            <hr>
            <!-- Content here -->
            <div class="row">
                {{-- <div class="col-lg-4 col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Pendapatan</h5>
                            <p class="card-text">Rp 500.000</p>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Member</h5>
                            <p class="card-text">{{ $totalmember }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Petugas</h5>
                            <p class="card-text">{{ $totalpetugas }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Petugas</h5>
                            <p class="card-text">{{ $totalbarang }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Logout -->
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('/logout') }}";
            }
        });
    }
</script>
@endsection
