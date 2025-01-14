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
            @foreach($transaksi as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->no_transaksi }}</td>
                <td>{{ $data->nama_anak }}</td>
                <td>{{ $data->nama_wahana }}</td>
                <td>{{ $data->harga }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
