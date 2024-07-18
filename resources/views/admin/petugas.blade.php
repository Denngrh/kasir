@extends('temp.admin') @section('content')
    <title>Petugas</title>
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
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">DASHBOARD</a>
                        <a href="{{ route('barang') }}" class="nav-link">BARANG</a>
                        <a href="{{ route('member') }}" class="nav-link">MEMBER</a>
                        <a href="{{ route('petugas') }}" class="nav-link active">PETUGAS</a>
                        <a href="{{ route('laporan') }}" class="nav-link">LAPORAN</a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <a class="btn btn-danger w-75 p-2" onclick="confirmLogout()">LOGOUT</a>
                    </div>
                </div>
            </nav>
            {{-- content --}}
            <div class="col-lg-9 col-md-8 p-4">
                <h3>DATA PETUGAS</h3>
                <hr />
                <div class="row mb-3">
                    <div class="col">
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPetugasModal">
                            TAMBAH PETUGAS
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class='table-responsive'>
                            <table id="table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">USERNAME</th>
                                        <th scope="col">NAMA PETUGAS</th>
                                        <th scope="col">EMAIL</th>
                                        <th scope="col">TGL INPUT</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->nama_petugas }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ optional($user->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editPetugasModal{{ $user->id }}">
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger deletePetugas"
                                                    data-id="{{ $user->id }}">Hapus</button>
                                            </td>
                                        </tr>
                                        {{-- Modal edit petugas --}}
                                        <div class="modal fade" id="editPetugasModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="editPetugasModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPetugasModalLabel">
                                                            Edit Petugas
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('update_petugas', $user->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="noUsername" class="form-label">Username</label>
                                                                <input type="text" class="form-control" id="noUsername"
                                                                    autocomplete="off" name="username"
                                                                    value="{{ $user->username }}" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="namaPetugas" class="form-label">Nama
                                                                    Petugas</label>
                                                                <input type="text" class="form-control" id="namaPetugas"
                                                                    autocomplete="off" name="nama_petugas"
                                                                    value="{{ $user->nama_petugas }}" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="emailPetugas" class="form-label">Email
                                                                    Petugas</label>
                                                                <input type="email" class="form-control" id="emailPetugas"
                                                                    autocomplete="off" name="email"
                                                                    value="{{ $user->email }}" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="passwordPetugas" class="form-label">Password
                                                                    Petugas</label>
                                                                <input type="password" class="form-control"
                                                                    id="passwordPetugas" autocomplete="off"
                                                                    name="password" value="{{ $user->password }}" />
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">
                                                                Update
                                                            </button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
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
    </div>

    {{-- Modal tambah petugas --}}
    <div class="modal fade" id="addPetugasModal" tabindex="-1" aria-labelledby="addPetugasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPetugasModalLabel">
                        Tambah Petugas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah_petugas') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="noUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="noUsername" autocomplete="off"
                                name="username" />
                        </div>
                        <div class="mb-3">
                            <label for="namaPetugas" class="form-label">Nama Petugas</label>
                            <input type="text" class="form-control" id="namaPetugas" autocomplete="off"
                                name="nama_petugas" />
                        </div>
                        <div class="mb-3">
                            <label for="emailPetugas" class="form-label">Email Petugas</label>
                            <input type="email" class="form-control" id="emailPetugas" autocomplete="off"
                                name="email" />
                        </div>
                        <div class="mb-3">
                            <label for="passwordPetugas" class="form-label">Password Petugas</label>
                            <input type="password" class="form-control" id="passwordPetugas" autocomplete="off"
                                name="password" />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Close
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- SweetAlert for delete member --}}
    <script>
        $('.deletePetugas').click(function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi Hapus Petugas',
                text: 'Apakah Anda yakin ingin menghapus Petugas ini?',
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
                        url: '{{ route('hapus_petugas') }}',
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
                                'Petugas telah dihapus.',
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
