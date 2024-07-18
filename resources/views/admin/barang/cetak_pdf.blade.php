<!DOCTYPE html>
<html>

<head>
    <title>Pdf</title>
    <style type="text/css">
        table {
            font-family: 'Arial';
        }

        .striped-table {
            border-collapse: collapse;
            width: 100%;
        }

        .striped-table th,
        .striped-table td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
        }

        .striped-table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN STOK BARANG</h2>
    </div>

    <table class="striped-table">
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
            @php
                $no = 1;
            @endphp
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>{{ $barang->harga }}</td>
                    <td>{{ $barang->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
