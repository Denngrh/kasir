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
        <h2>LAPORAN DATA PENJUALAN</h2>
    </div>

    <table class="striped-table">
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
            @php
                $no = 1;
            @endphp
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

</body>

</html>
