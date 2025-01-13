<div class="row">
    <!-- Tabel 1 -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Bermain</h4>
                    <br>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addWahanaModal">Add Anak</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable1" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anak</th>
                                <th>Nama Wahana</th>
                                <th>Durasi</th>
                                <th>Countdown</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($playActive as $data)
                                <tr data-id="{{ $data->id_play }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_anak }}</td>
                                    <td>{{ $data->nama_wahana }}</td>
                                    <td>{{ $data->durasi }}</td>
                                    <td class="countdown" data-start="{{ $data->start }}" data-end="{{ $data->end }}">
                                        Loading...
                                    </td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                        <form action="{{ route('play.destroy', $data->id_play) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>     
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Anak</th>
                                <th>Nama Wahana</th>
                                <th>Durasi</th>
                                <th>Countdown</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel 2 -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Selesai</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anak</th>
                                <th>Nama Wahana</th>
                                <th>Durasi</th>
                                <th>Countdown</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($playCompleted as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_anak }}</td>
                                    <td>{{ $data->nama_wahana }}</td>
                                    <td>{{ $data->durasi }}</td>
                                    <td>Waktu Habis</td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                        <form action="{{ route('play.destroy', $data->id_play) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Anak</th>
                                <th>Nama Wahana</th>
                                <th>Durasi</th>
                                <th>Countdown</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tabel Wahana -->
<div class="modal fade" id="addWahanaModal" tabindex="-1" aria-labelledby="addWahanaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWahanaModalLabel">Tambah Anak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_anak') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_wahana" class="form-label">Nama Anak</label>
                        <input type="text" class="form-control" id="nama_anak" name="nama_anak" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_wahana" class="form-label">Nomor Hp Orang Tua</label>
                        <input type="text" class="form-control" id="nohp" name="nohp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wahana</label>
                        <select class="form-select" id="wahana" name="wahana" required>
                            <option value="" disabled selected>Pilih Wahana</option>
                            @foreach ($wahana as $j)
                                <option value="{{ $j->id_wahana }}">{{ $j->nama_wahana }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durasi</label>
                        <select class="form-select" id="durasi" name="durasi" required>
                            <option value="" disabled selected>Pilih Durasi</option>
                            <option value="1 Jam">1 Jam</option>
                            <option value="2 Jam">2 Jam</option>
                            <option value="3 Jam">3 Jam</option>
                            <option value="4 Jam">4 Jam</option>
                            <option value="5 Jam">5 Jam</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- BUAT COUNTDOWN -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
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

            // Update countdown every second
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    });
</script>

<!-- UPDATE COUNTDOWN -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countdownElements = document.querySelectorAll('.countdown');

        countdownElements.forEach(element => {
            const start = new Date(element.dataset.start).getTime();
            const end = new Date(element.dataset.end).getTime();
            const row = element.closest('tr'); // Ambil baris tabel

            function updateCountdown() {
                const now = new Date().getTime();
                const remaining = end - now;

                if (remaining <= 0) {
                    element.textContent = "Waktu Habis";

                    // Pindahkan data ke tabel sebelah via AJAX
                    const id = row.dataset.id; // Pastikan id data tersedia di atribut row
                    fetch(`/update-status/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ status: 'completed' }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hapus row dari tabel saat ini
                                row.remove();

                                // Tambahkan row ke tabel "Selesai"
                                const selesaiTable = document.querySelector('#datatable2 tbody');
                                selesaiTable.appendChild(row);
                            }
                        });
                    return;
                }

                const hours = Math.floor((remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remaining % (1000 * 60)) / 1000);

                element.textContent = `${hours}h ${minutes}m ${seconds}s`;
            }

            // Update countdown setiap detik
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    });

</script>