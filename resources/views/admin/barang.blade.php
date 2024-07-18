@extends('temp.admin')
@section('content')
    <title>Barang</title>
    @php
        $cek = DB::table('barangs')->where('stok', '<', 3)->count();
    @endphp
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
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
                        <a href="{{ route('barang') }}" class="nav-link active">BARANG</a>
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
            <div class="col-lg-9 col-md-8 p-4">
                <h3>DATA BARANG</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBarangModal">TAMBAH
                            BARANG</button>
                        <button class="btn btn-danger mb-3" onclick="window.print()">PRINT TO PDF</button>
                        <button id="export-btn" class="btn btn-success mb-3">EXPORT TO EXCEL</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if ($cek > 0)
                            <div class='alert alert-warning mt-3'>
                                <span class='glyphicon glyphicon-info-sign'></span> Ada <span
                                    style='color:red'>{{ $cek }}</span>
                                Barang Yang Stoknya Tersisa Sudah Kurang Dari 3 Items, Silahkan Restok!!
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">KODE BRG</th>
                                        <th scope="col">NAMA BRG</th>
                                        <th scope="col">STOK</th>
                                        <th scope="col">HARGA</th>
                                        <th scope="col">TGL INPUT</th>
                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $barang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $barang->kode_barang }}</td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->stok }}</td>
                                            <td>{{ $barang->harga }}</td>
                                            <td>{{ $barang->created_at->format('Y-m-d') }}</td>
                                            <td><button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editBarangModal{{ $barang->id }}">Edit</button>
                                                <button class="btn btn-sm btn-danger deleteBrg"
                                                    data-id="{{ $barang->id }}">Hapus</button>
                                            </td>
                                        </tr>

                                        {{-- Modal edit barang --}}
                                        <div class="modal fade" id="editBarangModal{{ $barang->id }}" tabindex="-1"
                                            aria-labelledby="editBarangModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('update_barang', $barang->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="kodeBarangEdit" class="form-label">Kode
                                                                    Barang</label>
                                                                <input type="text" class="form-control"
                                                                    id="kodeBarangEdit" value="{{ $barang->kode_barang }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="namaBarangEdit" class="form-label">Nama
                                                                    Barang</label>
                                                                <input type="text" class="form-control"
                                                                    id="namaBarangEdit" name="nama_barang"
                                                                    value="{{ $barang->nama_barang }}" autocomplete="off">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="stokBarangEdit" class="form-label">Stok
                                                                    Barang</label>
                                                                <input type="number" class="form-control"
                                                                    id="stokBarangEdit" name="stok"
                                                                    value="{{ $barang->stok }}" autocomplete="off">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="hargaBarangEdit" class="form-label">Harga
                                                                    Barang</label>
                                                                <input type="text" class="form-control"
                                                                    id="hargaBarangEdit" name="harga"
                                                                    value="{{ $barang->harga }}" autocomplete="off">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                <h2>LAPORAN STOK BARANG</h2>
            </div>
            <table id="table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">KODE BRG</th>
                        <th scope="col">NAMA BRG</th>
                        <th scope="col">STOK</th>
                        <th scope="col">HARGA</th>
                        <th scope="col">TGL INPUT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>{{ $barang->harga }}</td>
                            <td>{{ $barang->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal add barang --}}
    <div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="addBarangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah_barang') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="kodeBarang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                                autocomplete="off" value="{{ $count }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="stokBarang" class="form-label">Stok Barang</label>
                            <input type="number" class="form-control" name="stok" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="hargaBarang" class="form-label">Harga Barang</label>
                            <input type="text" class="form-control" name="harga" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
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
                        ['No.', 'KODE BRG', 'NAMA BRG', 'STOK', 'HARGA', 'TGL INPUT']
                    ];
                    let rowNumber = 1; // urutkan dari 1

                    data.forEach(row => {
                        const tanggalInput = row.created_at.split('T')[0];
                        excelData.push([
                            rowNumber++,
                            row.kode_barang,
                            row.nama_barang,
                            row.stok,
                            row.harga,
                            tanggalInput
                        ]);
                    });

                    const ws = XLSX.utils.aoa_to_sheet(excelData);
                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                    XLSX.writeFile(wb, 'data_barang.xlsx');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        document.getElementById('export-btn').addEventListener('click', getDataAndExportToExcel);
    </script>

    {{-- SweetAlert for delete barang --}}
    <script>
        $('.deleteBrg').click(function() {
            const id = $(this).data('id');
            console.log(id);
            Swal.fire({
                title: 'Konfirmasi Hapus Barang',
                text: 'Apakah Anda yakin ingin menghapus barang ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proses penghapusan barang
                    $.ajax({
                        url: '{{ route('hapus_barang') }}',
                        type: 'post',
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Berhasil!',
                                'Barang telah dihapus.',
                                'success'
                            );
                            // Refresh halaman setelah penghapusan
                            setTimeout(function() {
                                location.reload(1);
                            }, 1000);
                        },
                    });
                }
            });
        })
    </script>

    {{-- ini js logout --}}
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
