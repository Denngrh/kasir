@extends('temp.admin')
@section('content')
    <title>
        Dashboard</title>
    @php
        $count = DB::table('barangs')->where('stok', '<', 3)->count();
    @endphp
    <style>
        .navbar {
            min-height: 60px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }

        .vertical-line {
            border-left: 1px solid #ccc;
            height: 40px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .info {
            padding-top: 8px;
            margin-right: 15px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }
    </style>
    <main id="print">
        <nav class="navbar navbar-expand-lg print-none">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="../storage/icon.svg" alt="Logo" style="width: 50px; height: auto; margin-right: 10px;">
                    <span style="margin-top: 3px;">A-Z MARKET</span>
                </a>

                <div class="vertical-line"></div>
                <span class="info" id="jam">JAM: </span>

                <div class="vertical-line"></div>
                <span class="info" id="tanggal">TANGGAL: </span>

                <div class="vertical-line"></div>
                <span class="info">NAMA KASIR: <span id="nama-kasir">
                        @if (Session::has('nama_petugas'))
                            {{ Session::get('nama_petugas') }}
                        @endif
                    </span></span>

                <div class="vertical-line"></div>
                <button class="btn btn-outline-danger ms-2 logout-button" type="button"
                    onclick="confirmLogout()">LOGOUT</button>
            </div>
        </nav>

        <div class="row print-none">
            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">TAMBAH
                                MEMBER</button>
                        </div>
                        @if ($count > 0)
                            <div class='alert alert-warning mt-3'>
                                <span class='glyphicon glyphicon-info-sign'></span> Ada <span
                                    style='color:red'>{{ $count }}</span>
                                Barang Yang Stoknya Tersisa Sudah Kurang Dari 3 Items, Silahkan Laporkan Ke admin!!!
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <p class="text-center mb-0 fs-5 fw-bold mt-2">PILIH PRODUK</p>
                        <select id="rfc" name="rfc[]" class="form-control me-2" multiple>
                            @foreach ($barangs as $barang)
                                @if ($barang->stok > 0)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endif
                            @endforeach
                        </select>
                        <table id="table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">KODE BRG</th>
                                    <th scope="col">NAMA BRG</th>
                                    {{-- <th scope="col">QTY</th>
                                    <th scope="col">TOTAL</th> --}}
                                    <th scope="col">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="hasil_cari">
                            </tbody>
                            {{-- <tbody>
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $barang->kode_barang }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->stok }}</td>
                                        <td>{{ $barang->harga }}</td>
                                    </tr>
                                @endforeach
                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <p class="fs-5 fw-bold">KASIR</p>
                            <p class="fs-5 fw-bold mt-3">PILIH PRODUK</p>
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                {{-- <select id="rfc" name="rfc[]" class="form-control me-2" multiple>
                                    @foreach ($barangs as $barang)
                                        @if ($barang->stok > 0)
                                            <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                        @endif
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="baru" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">KODE BRG</th>
                                        <th scope="col">NAMA BRG</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">TOTAL</th>
                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualans as $jual)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jual->kode_barang }}</td>
                                            <td>{{ $jual->nama_barang }}</td>
                                            <td>{{ $jual->stok }}</td>
                                            <td>
                                                <input type="number" name="qty" style="width: 80px"
                                                    class="form-control input-number" value="{{ $jual->jumlah }}"
                                                    data-penjualan-id="{{ $jual->id }}"
                                                    data-kode-brg="{{ $jual->kode_barang }}"
                                                    data-harga="{{ $jual->harga }}" data-target="#qty{{ $jual->id }}"
                                                    data-jml="#jml{{ $jual->id }}">
                                            </td>
                                            <td>
                                                <span class="total">{{ $jual->jumlah * $jual->harga }}</span>
                                            </td>
                                            <td>
                                                {{-- <form action="{{ route('admin.hapusData', $jual->id) }}" method="post"
                                                    id="hapusData{{ $jual->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger hapusData" data-id="{{ $jual->id }}"
                                                        type="button">Hapus</button>
                                                </form> --}}
                                                <button class="btn btn-sm btn-danger deleteBrg"
                                                data-id="{{ $jual->id }}">Hapus</button>
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

        <!-- Area untuk menampilkan jumlah -->
        <div id="quantity-output"></div>

        <div class="row mt-3 print-none">

            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <p class="fs-5 fw-bold">TRANSAKSI</p>
                    </div>
                    <form action="{{ route('tambahData') }}" method="post" id="print">
                        @foreach ($barangs as $brg)
                            <input type="text" class="form-control form-control-sm bg-white stok"
                                id="stok{{ $brg->kode_barang }}" value="{{ $brg->stok }}" readonly>
                        @endforeach
                        <div class="row">
                            @foreach ($penjualans as $penjualan)
                                <input type="text" class="form-control form-control-sm bg-white" name="id[]"
                                    value="{{ $penjualan->kode_barang }}" readonly>
                                <input type="number" name="jumlah[]" id="jml{{ $penjualan->id }}"
                                    value="{{ $penjualan->jumlah }}">
                            @endforeach
                            <input type="number" name="total" id="totalDanDiskon" value="{{ $totalHarga }}">
                            <input type="number" id="totalQty" name="jml">
                            <input type="text" value="{{ $noNota }}" name="noNota">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="member">Member</label>
                                    <select id="select" name="rfc" class="form-control">
                                        <option value="">SELECT MEMBER</option>
                                        @foreach ($members as $member)
                                            <option data-diskon="{{ $member->diskon }}"
                                                value="{{ $member->id_member }}">
                                                {{ $member->nama_member }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" id="totalDanDiskon">
                                <input type="number" id="totDiskon">
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <input type="text" class="form-control" id="diskon" name="diskon" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bayar">Bayar</label>
                                    <input type="text" class="form-control" id="bayar" name="bayar">
                                </div>
                                <div class="form-group kembalian">
                                    <label for="kembalian">Kembalian</label>
                                    <input type="text" class="form-control" id="kembali" readonly name="kembalian">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <p class="fs-5 fw-bold">SUBTOTAL</p>
                            <input type="text" name="total" id="total" value="{{ $totalHarga }}">
                            <input type="text" name="totalSetelahDiskon" id="totalSetelahDiskon" class="form-control"
                                readonly="readonly">
                        </div>
                        <div class="card mt-3 mx-auto" style="width: 200px;">
                            <div class="card-body text-center">
                                <h1 class="fs-4" id="total-harga">
                                    Rp.{{ number_format($totalHarga) }}
                                </h1>
                                <br>
                                <button type="button" id="checkout" class="btn btn-success mt-3" >Checkout</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="d-none pt-5 px-4 print-show">
            <div class="row">
                <div id="logo">
                    <img src="../storage/icon.svg">
                </div>
                <div class="col-12 text-center mb-2">
                    <h1 style="font-size:50px;font-weight:700;">A-Z MARKET</h1>
                    <h5 class="mb-0">Sindang Palay</h5>
                    <h5 class="mb-2">Tel : 081234567</h5>
                </div>
                <div class="col-7">
                    <h5 class="mb-0" style="text-transform: uppercase;">INVOICE : {{ $noNota }}</h5>
                    <h5 class="mb-0" style="text-transform: uppercase;">KASIR : {{ Auth::user()->nama_petugas }}</h5>
                </div>
                <div class="col-5">
                    <h5 class="mb-0" style="text-transform: uppercase;">TANGGAL : {{ date('d-m-Y') }}</h5>
                    <h5 class="mb-0" style="text-transform: uppercase;">PUKUL : <span id="hours"></span></h5>
                </div>
                <div class="col-12 bg-secondary border my-3"></div>
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-1 text-center">
                            <h5 style="font-weight:700;">QTY</h5>
                        </div>
                        <div class="col">
                            <h5 style="font-weight:700;">PRODUK</h5>
                        </div>
                        <div class="col text-center">
                            <h5 style="font-weight:700;">HARGA</h5>
                        </div>
                        <div class="col text-end">
                            <h5 style="font-weight:700;">SUBTOTAL</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div id="data-print"></div>
                </div>
                <div class="col-12 bg-secondary border my-3"></div>
                <div class="col-12">
                    <div class="row" id="cekMember">
                        <div class="col">
                            <h4>Total Belanja</h4>
                            <h4>Bayar</h4>
                            <h4>Kembalian</h4>
                        </div>
                        <div class="col text-end">
                            <h4><span id="totalBelanja"></span></h4>
                            <h4><span id="pembayaran"></span></h4>
                            <h4><span id="kembalian"></span></h4>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
                <div class="col-12 bg-secondary border my-3"></div>
                <div id="notices">
                    <div>NOTICE:</div>
                    <div class="notice">"TERIMA KASIH TELAH MEMBELI DI TOKO KAMI!!"</div>
                </div>
            </div><!-- end row -->
        </div><!-- end box print -->
    </main>




    {{-- Modal add member --}}
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Tambah Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('insert_member') }}" method="post">
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


    <script>
        $(document).ready(function() {
            $('#checkout').on('click', function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#print').submit();
                        // window.print()
                    }
                });
            })
        })
        $(document).ready(function() {
            $("#select").change(function() {
                var member = $(this).val();
                var cekMember = $('#cekMember');
                if (member) {
                    cekMember.html(`
                <div class="col">
                    <h4>Total Belanja</h4>
                    <h4>Diskon</h4>
                    <h4>Total</h4>
                    <h4>Bayar</h4>
                    <h4>Kembalian</h4>
                    </div>
                    <div class="col text-end">
                        <h4><span id="totalBelanja"></span></h4>
                        <h4><span id="diskons"></span></h4>
                        <h4><span id="totalDiskon"></span></h4>
                        <h4><span id="pembayaran"></span></h4>
                        <h4><span id="kembalian"></span></h4>
                        </div>`);
                }
            });
        });
        // var shoppingCart = []

        $(document).ready(function() {
            // $('#checkout').hide();

            // $('#bayar').change(function() {
            //     if ($('#kembali').val() === "") {
            //         $('#checkout').hide();
            //     } else if ($('#total').val() === "0") {
            //         $('#checkout').hide();
            //     } else {
            //         $('#checkout').show();
            //     }

            //     if ($('#bayar').val() === "") {
            //         $('#kembali').val("");
            //     }
            // });


            $("#rfc").change(function() {
                var selectedBarangs = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('cari_barang') }}?cari_barang=yes",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "selectedBarangs": selectedBarangs,
                    },
                    beforeSend: function() {
                        $("#hasil_cari").hide();
                    },
                    success: function(html) {
                        $("#hasil_cari").show();
                        $("#hasil_cari").html(html);
                        hitungSubtotal(); // Hitung subtotal setelah memilih produk
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('ambil_barang') }}?ambil_barang=yes",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "selectedBarangs": selectedBarangs,
                    },
                    beforeSend: function() {
                        $("#data-print").hide();
                    },
                    success: function(html) {
                        $("#data-print").show();
                        $("#data-print").html(html);
                        hitungSubtotal(); // Hitung subtotal setelah memilih produk
                    }
                });

            });

        });

        // validasi stok jumlah
        $('input[name="qty"]').on('input', function() {
            var newValue = $(this).val();
            var kodeBrg = $(this).data('kode-brg');
            var stok = parseInt($('#stok' + kodeBrg).val());

            if (newValue > stok) {
                alert('Jumlah melebihi stok yang tersedia!');
                $(this).val(stok);
            }
        });

        // data jumlah di table ke input
        $('input[name="qty"]').on('change', function() {
            // Mendapatkan nilai baru dari input jumlah (qty)
            var newValue = $(this).val();

            // Mendapatkan data yang terkait dari atribut data
            var penjualanId = $(this).data('penjualan-id');
            var targetInput = $(this).data('jml');

            // Memperbarui nilai dari input jumlah (jml)
            $(targetInput).val(newValue);
        });

        // stok di print
        function handleInputChange(input) {
            var targetId = $(input).data('target');
            var targetElement = $(targetId);
            targetElement.text(input.value);
        }

        var inputs = $('input[data-target]');

        inputs.each(function() {
            $(this).on('input', function() {
                handleInputChange(this);
            });

            handleInputChange(this);
        });

        // menyatukan semua jumlah barang
        $(document).ready(function() {
            $('input.input-number').on('change', function() {
                var totalQty = 0;
                $('input.input-number').each(function() {
                    totalQty += parseFloat($(this).val()) || 0;
                });
                $('#totalQty').val(totalQty);
                $('#qty').val(totalQty)
            }).change();
        });

        // update otomatis harga
        $(document).ready(function() {
            // Fungsi untuk menangani perubahan input number
            function handleInputNumberChange(inputElement) {
                var jumlah = $(inputElement).val();
                var penjualan_id = $(inputElement).data('penjualan-id');
                var harga = $(this).data('harga');
                var stok = parseInt($('.stok').val());

                // Validasi jumlah
                if (jumlah == '') {
                    return;
                }
                if (jumlah < 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Jumlah tidak boleh kurang dari 1'
                    });
                    $(inputElement).val(1);
                    return;
                } else if (jumlah >= 1000) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Jumlah tidak boleh lebih dari 1000'
                    });
                    $(inputElement).val(stok);
                    return;
                }


                $.ajax({
                    url: "{{ route('updateHarga') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        jumlah: jumlah,
                        penjualan_id: penjualan_id
                    },
                    success: function(response) {
                        if (response.success) {
                            // Mengambil total harga dari respons
                            var totalHarga = response.totalHarga;

                            // Memperbarui tampilan jumlah dan total pada halaman tanpa memuat ulang
                            $(inputElement).closest('tr').find('.total').text("Rp." + response.penjualan
                                .total.toLocaleString());
                            $('#subtotal' + penjualan_id).text("Rp." + response.penjualan
                                .total.toLocaleString());
                            // Memperbarui total harga pada elemen HTML
                            $('#total-harga').text('Rp.' + number_format(totalHarga));
                            $('#total').val(totalHarga);
                            $('#totalBelanja').text('Rp.' + number_format(totalHarga));
                            $('#totalDanDiskon').val(totalHarga);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });

            }
            // Tambahkan event listener pada setiap input number yang baru ditambahkan
            $(document).on('input', '.input-number', function() {
                handleInputNumberChange(this);
            });
        });



        // diskon
        $(document).ready(function() {
            var diskon;

            $('#select').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                diskon = parseFloat(selectedOption.data('diskon'));
            });

            $('#bayar').on('input', function() {
                var totalHarga = parseFloat($('#total').val());
                var amountPaid = parseFloat($(this).val());
                var selectedMember = $('#select').val();

                // Cek jika total harga melebihi 50000 dan member dipilih
                if (totalHarga > 50000 && selectedMember) {
                    var totalSetelahDiskon = totalHarga * (1 - diskon / 100);

                    // Tampilkan diskon dan total setelah diskon
                    $('#diskon').val(diskon);

                    // Update harga yang ditampilkan menjadi harga yang sudah didiskon
                    $('#total-harga').html("Rp." + number_format(totalSetelahDiskon));
                    $('#totalSetelahDiskon').val(totalSetelahDiskon);
                    $('#totalDiskon').text('Rp.' + totalSetelahDiskon.toLocaleString());
                    $('#totalDanDiskon').val(totalSetelahDiskon);

                    // Bayar sesuai dengan total setelah diskon
                    totalHarga = totalSetelahDiskon;
                } else {
                    $('#total-harga').html("Rp." + number_format(totalHarga));
                    $('#totalDanDiskon').val(totalHarga);
                }

                // Hitung kembalian
                var change = amountPaid - totalHarga;
                if (change >= 0) {
                    $('#kembali').val(change);
                    $('#bayar').removeClass('is-invalid');
                } else if ($('#bayar').val() == '') {
                    $('#bayar').removeClass('is-invalid');

                } else {
                    $('#kembali').val('');
                    $('#bayar').addClass('is-invalid');
                }

                $('#pembayaran').text('Rp.' + amountPaid.toLocaleString())
                $('#kembalian').text('Rp.' + change.toLocaleString())
            });

            $('#select').change(function() {
                // Panggil event handler input bayar untuk memperbarui diskon dan total setelah diskon
                $('#bayar').trigger('input');
            });
        });

        function number_format(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>





    {{-- Js Waktu Realtime --}}
    <script>
        function updateTime() {
            var now = new Date();
            var jam = now.getHours().toString().padStart(2, '0');
            var menit = now.getMinutes().toString().padStart(2, '0');
            var detik = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('jam').textContent = 'Jam: ' + jam + ':' + menit + ':' + detik;
            document.getElementById('hours').textContent = jam + ':' + menit + ':' + detik;

            var bulan = (now.getMonth() + 1).toString().padStart(2, '0');
            var tanggal = now.getDate().toString().padStart(2, '0');
            var tahun = now.getFullYear();
            document.getElementById('tanggal').textContent = 'Tanggal: ' + tahun + '-' + bulan + '-' + tanggal;
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>
     <script>
        $('.deleteBrg').click(function() {
            const id = $(this).data('id');
            console.log(id);
            Swal.fire({
                title: 'Konfirmasi Hapus Dari Keranjang',
                text: 'Apakah Anda yakin ingin menghapus Dari Keranjang?',
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
    {{-- Logout Alert --}}
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
