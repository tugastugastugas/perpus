<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Status Bermain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .col-md-6 {
            flex: 0 0 48%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card {
            padding: 20px;
        }

        .card-header {
            color: #fff;
            padding: 15px;
            border-bottom: 3px solid #0056b3;
            text-align: center;
        }

        .card-title {
            margin: 0;
            font-size: 1.5em;
            font-weight: 600;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f1f1f1;
            color: #333;
            font-weight: 600;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f7ff;
            cursor: pointer;
        }

        .countdown {
            font-weight: bold;
            color: #ff5722;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            color: #fff;
            font-weight: 600;
        }

        .status-completed {
            background-color: #28a745;
        }

        .status-active {
            background-color: #17a2b8;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
            }
        }
    </style>
</head>
<body>

<div class="row">
    <!-- Tabel 1 -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Bermain</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anak</th>
                            <th>Nama Wahana</th>
                            <th>Durasi</th>
                            <th>Countdown</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($playActive as $data)
                        <tr data-id="{{ $data->id_play }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_anak }}</td>
                            <td>{{ $data->nama_wahana }}</td>
                            <td>{{ $data->durasi }} Jam</td>
                            <td class="countdown" data-start="{{ $data->start }}" data-end="{{ $data->end }}">
                                Loading...
                            </td>
                            <td><span class="status-badge status-active">Active</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabel 2 -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Selesai</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anak</th>
                            <th>Nama Wahana</th>
                            <th>Durasi</th>
                            <th>Countdown</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($playCompleted as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_anak }}</td>
                            <td>{{ $data->nama_wahana }}</td>
                            <td>{{ $data->durasi }} Jam</td>
                            <td>Waktu Habis</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElements = document.querySelectorAll('.countdown');

        countdownElements.forEach(element => {
            const start = new Date(element.dataset.start).getTime();
            const end = new Date(element.dataset.end).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const remaining = end - now;

                if (remaining <= 0) {
                    element.textContent = "Waktu Habis";
                    return;
                }

                const hours = Math.floor((remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remaining % (1000 * 60)) / 1000);

                element.textContent = `${hours}h ${minutes}m ${seconds}s`;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    });
</script>

</body>
</html>
