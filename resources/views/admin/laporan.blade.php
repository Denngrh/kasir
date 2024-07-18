@extends('temp.admin') @section('content')
    <title>Laporan</title>
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
    </style>
    <div class="container-fluid" id="print">
        <div class="row print-none">
            <!-- Sidebar -->
            <nav class="col-lg-3 col-md-4 bg-light sidebar p-0">
                <div class="sidebar-sticky">
                    <img src="../storage/icon.svg" alt="Admin Image" class="img-fluid mx-auto d-block rounded-circle mb-3"
                        style="width: 100px;">
                    <p class="text-center h4 mb-4">ADMIN</p>
                    <hr>
                    <div class="nav flex-column nav-pills">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">DASHBOARD</a>
                        <a href="{{ route('barang') }}" class="nav-link">BARANG</a>
                        <a href="{{ route('member') }}" class="nav-link">MEMBER</a>
                        <a href="{{ route('petugas') }}" class="nav-link">PETUGAS</a>
                        <a href="{{ route('laporan') }}" class="nav-link active">LAPORAN</a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a class="btn btn-danger w-75 p-2" onclick="confirmLogout()">LOGOUT</a>
                    </div>
                </div>
            </nav>
            {{-- content --}}
            <div class="col-lg-9 col-md-8 p-4">
                <h3>DATA LAPORAN PENJUALAN</h3>
                <hr />
                <div class="row mb-3">
                    <div class="col">
                        <button class="btn btn-danger mb-3" onclick="window.print()">PRINT TO PDF</button>
                        <button id="export-btn" class="btn btn-success mb-3">EXPORT TO EXCEL</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">NO.</th>
                                        <th scope="col">INVOICE ID</th>
                                        <th scope="col">TGL PEMBELIAN</th>
                                        <th scope="col">NAMA KSR</th>
                                        <th scope="col">NAMA MEMBER</th>
                                        <th scope="col">PRODUK</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">SUBTOTAL</th>
                                        <th scope="col">BAYAR</th>
                                        <th scope="col">KEMBALIAN</th>
                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporans as $laporan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $laporan->no_nota }}</td>
                                            <td>{{ optional($laporan->created_at)->format('Y-m-d') }}</td>
                                            <td>{{ $laporan->nama_kasir }}</td>
                                            <td>{{ $laporan->nama_member }}</td>
                                            <td>{{ $laporan->produk }}</td>
                                            <td>{{ $laporan->qty }}</td>
                                            <td>{{ $laporan->subtotal }}</td>
                                            <td>{{ $laporan->bayar }}</td>
                                            <td>{{ $laporan->kembalian }}</td>
                                            <td>  <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editBarangModal{{ $laporan->id }}">View</button>
                                                <button class="btn btn-sm btn-danger deleteBrg"
                                                data-id="{{ $laporan->id }}">Hapus</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none print-show">
            <div class="header">
                <h2 >LAPORAN DATA PENJUALAN</h2>
            </div>
            <table id="table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">NO.</th>
                        <th scope="col">INVOICE ID</th>
                        <th scope="col">TGL PEMBELIAN</th>
                        <th scope="col">NAMA KSR</th>
                        <th scope="col">NAMA MEMBER</th>
                        <th scope="col">PRODUK</th>
                        <th scope="col">QTY</th>
                        <th scope="col">SUBTOTAL</th>
                        <th scope="col">BAYAR</th>
                        <th scope="col">KEMBALIAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporans as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->no_nota }}</td>
                        <td>{{ optional($laporan->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $laporan->nama_kasir }}</td>
                        <td>{{ $laporan->nama_member }}</td>
                        <td>{{ $laporan->produk }}</td>
                        <td>{{ $laporan->qty }}</td>
                        <td>{{ $laporan->subtotal }}</td>
                        <td>{{ $laporan->bayar }}</td>
                        <td>{{ $laporan->kembalian }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

      {{-- print excel --}}
      <script>
        function getDataAndExportToExcel() {
            fetch('{{ route('export_excel') }}')
                .then(response => response.json())
                .then(data => {
                    const excelData = [
                        ['NO', 'INVOICE ID', 'TGL PEMBELIAN', 'NAMA KSR', 'NAMA MEMBER', 'PRODUK', 'QTY', 'SUBTOTAL', 'BAYAR', 'KEMBALIAN']
                    ];
                    let rowNumber = 1; // urutkan dari 1

                    data.forEach(row => {
                        const tanggalInput = row.created_at.split('T')[0];
                        excelData.push([
                            rowNumber++,
                            row.no_nota,
                            tanggalInput,
                            row.nama_kasir,
                            row.nama_member,
                            row.produk,
                            row.qty,
                            row.diskon,
                            row.subtotal,
                            row.bayar,
                            row.kembalian
                        ]);
                    });

                    const ws = XLSX.utils.aoa_to_sheet(excelData);
                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                    XLSX.writeFile(wb, 'data_laporan.xlsx');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        document.getElementById('export-btn').addEventListener('click', getDataAndExportToExcel);
    </script>

    {{-- ini js logout --}}
    <script>
        function confirmLogout() {
            Swal.fire({
                title: "Konfirmasi Logout",
                text: "Apakah Anda yakin ingin logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Logout",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/logout') }}";
                }
            });
        }
    </script>
@endsection
