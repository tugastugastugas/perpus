<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Transaksi</th>
                <th>Nama Anak</th>
                <th>Nama Wahana</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalHarga = 0; // Variabel untuk menyimpan total harga
            @endphp

            @foreach($transaksi as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->no_transaksi }}</td>
                <td>{{ $data->nama_anak }}</td>
                <td>{{ $data->nama_wahana }}</td>
                <td>{{ $data->harga }}</td>
            </tr>
            @php
                $totalHarga += (float) str_replace(['Rp', ',', ' '], '', $data->harga); // Menghitung total harga dengan menghapus format
            @endphp
            @endforeach
        </tbody>
    </table>

    <div class="total-row">
        <p>Total Harga: Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
    </div>
</body>
</html>
