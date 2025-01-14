<div class="row">
    <!-- Tabel 1 -->
    <div class="col-md-6" style="padding-left: 20px;">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Bermain</h4>
                    <br>
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
                                <td>{{ $data->status }}</td>
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
                                <td>{{ $data->status }}</td>
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
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- BUAT COUNTDOWN -->
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
            const namaAnak = row.querySelector('td:nth-child(2)').textContent; // Ambil Nama Anak
            const namaWahana = row.querySelector('td:nth-child(3)').textContent; // Ambil Nama Wahana
            const durasi = row.querySelector('td:nth-child(4)').textContent; // Ambil Durasi

            let isWhatsappSent = false;

            function updateCountdown() {
                const now = new Date().getTime();
                const remaining = end - now;

                if (remaining <= 0) {
                    element.textContent = "Waktu Habis";

                    // Pastikan tidak ada pengiriman berulang
                    if (!isWhatsappSent) {
                        isWhatsappSent = true;

                       

                        // Pindahkan data ke tabel sebelah via AJAX
                        const id = row.dataset.id;

                        fetch(`/update-status/${id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    status: 'completed'
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Hapus row dari tabel saat ini
                                    row.remove();

                                    // Tambahkan row ke tabel "Selesai"
                                    const selesaiTable = document.querySelector('#datatable2 tbody');
                                    selesaiTable.appendChild(row);

                                    // Kirim pesan WhatsApp
                                    fetch(`/send-whatsapp/${id}`, {
                                            method: 'GET',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                            },
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'success') {
                                                console.log('Pesan WhatsApp berhasil dikirim!');
                                            } else {
                                                console.log('Gagal mengirim pesan WhatsApp.');
                                            }
                                        });
                                }
                            });

                        // Mainkan suara otomatis
                        playVoiceMessage(namaAnak, namaWahana, durasi);
                    }

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

        function playVoiceMessage(namaAnak, namaWahana, durasi) {
    const apiKey = '1fa7ef6f4da041789b6060e401cf9ae7'; // Ganti dengan API Key dari VoiceRSS
    const text = `Waktu untuk anak ${namaAnak} pada wahana ${namaWahana} sudah habis! Waktu untuk anak ${namaAnak} pada wahana ${namaWahana} sudah habis! Waktu untuk anak ${namaAnak} pada wahana ${namaWahana} sudah habis!`;

    // URL untuk API VoiceRSS
    const url = `https://api.voicerss.org/?key=${apiKey}&hl=id-id&src=${encodeURIComponent(text)}`;

    // Buat audio element
    const audio = new Audio(url);
    audio.play();
}



    });
</script>

