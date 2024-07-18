@foreach ($hasil1 as $hasil)
    <tr data-max-qty="{{ $hasil->stok }}">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $hasil->kode_barang }}</td>
        <td class="nama-barang">{{ $hasil->nama_barang }}</td>
        {{-- <td><input type="number" class="form-control qty" value="1" min="1" data-penjualan-id="{{ $hasil->id }}" data-harga="{{ $hasil->harga }}"></td>
        <td class="harga" >{{ $hasil->harga }}</td> --}}
        <td><a href="{{ route('jual') }}?jual=jual&id={{ $hasil->kode_barang }}" class="btn btn-primary">Tambah</a></td>
    </tr>
@endforeach

