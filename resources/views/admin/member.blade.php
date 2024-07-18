@extends('temp.admin') @section('content')
<title>Member</title>
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
                    <a href="{{ route('member') }}" class="nav-link active">MEMBER</a>
                    <a href="{{ route('petugas') }}" class="nav-link">PETUGAS</a>
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
            <h3>DATA MEMBER</h3>
            <hr />
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        TAMBAH MEMBER
                    </button>
                    <button class="btn btn-success mb-3" id="updateDiskonBtn">UPDATE DISKON</button>
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
                                <th scope="col">NAMA</th>
                                <th scope="col">ALAMAT</th>
                                <th scope="col">NO HP</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">DISKON</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->nama_member }}</td>
                                    <td>{{ $member->alamat }}</td>
                                    <td>{{ $member->nomer_hp }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->diskon }} %</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editMemberModal{{ $member->id_member }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteMember"
                                            data-id_member="{{ $member->id_member }}">Hapus</button>
                                    </td>
                                </tr>

                                {{-- Modal edit member --}}
                                <div class="modal fade" id="editMemberModal{{ $member->id_member }}" tabindex="-1"
                                    aria-labelledby="editMemberModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editMemberModalLabel">
                                                    Edit Member
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('update_member', $member->id_member) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="nama_member" class="form-label">Nama Member</label>
                                                        <input type="text" class="form-control" id="nama_member" name="nama_member"
                                                            autocomplete="off" value="{{ $member->nama_member }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email Member</label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            autocomplete="off"  value="{{ $member->email }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nomer_hp" class="form-label">No. Telephone Member</label>
                                                        <input type="number" class="form-control" id="nomer_hp" name="nomer_hp"
                                                            autocomplete="off" value="{{ $member->nomer_hp }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat Member</label>
                                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                                            autocomplete="off"  value="{{ $member->alamat }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="diskonMemberEdit" class="form-label">Diskon
                                                            Member</label>
                                                        <input type="number" class="form-control" id="diskonMemberEdit"
                                                            autocomplete="off" name="diskon" value="{{ $member->diskon }}"/>
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

{{-- Modal tambah member --}}
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">
                    Tambah Member
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tambah_member') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_member" class="form-label">Nama Member</label>
                        <input type="text" class="form-control" id="nama_member" name="nama_member"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Member</label>
                        <input type="email" class="form-control" id="email" name="email"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="nomer_hp" class="form-label">No. Telephone Member</label>
                        <input type="number" class="form-control" id="nomer_hp" name="nomer_hp"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Member</label>
                        <input type="text" class="form-control" id="alamat" name="alamat"
                            autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert for delete member --}}
<script>
    $('.deleteMember').click(function() {
        const id_member = $(this).data('id_member');
        Swal.fire({
            title: 'Konfirmasi Hapus Member',
            text: 'Apakah Anda yakin ingin menghapus Member ini?',
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
                    url: '{{ route('hapus_member') }}',
                    type: 'post',
                    data: {
                        id_member: id_member
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Berhasil!',
                            'Member telah dihapus.',
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
<script>
    $('#updateDiskonBtn').click(function() {
        $.ajax({
            url: '{{ route('update_diskon_member') }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                // Tampilkan pesan sukses jika berhasil
                Swal.fire(
                    'Berhasil!',
                    'Diskon berhasil diupdate.',
                    'success'
                );
                // Refresh halaman setelah update berhasil
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(error) {
                // Tampilkan pesan error jika terjadi kesalahan
                console.error(error);
                Swal.fire(
                    'Gagal!',
                    'Terjadi kesalahan saat melakukan update diskon.',
                    'error'
                );
            }
        });
    });
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
