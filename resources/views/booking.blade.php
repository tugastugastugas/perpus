<div class="row">
    <!-- Tabel 1 -->
    <div class="col-md-6" style="padding-left: 20px;">
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
                                <td>{{ $data->durasi }} Jam</td>
                                <td class="countdown" data-start="{{ $data->start }}" data-end="{{ $data->end }}">
                                    Loading...
                                </td>
                                <td>{{ $data->status }}</td>
                                <td>
                                    @if ($data->status == 'pending')
                                    <button class="btn btn-primary btn-sm open-transaksi-modal"
                                        data-id-play="{{ $data->id_play }}" data-bs-toggle="modal"
                                        data-bs-target="#transaksiModal">Transaksi
                                    </button>
                                    @endif
                                    @if ($data->status == 'active')
                                    <button class="btn btn-success btn-sm open-add-time-modal"
                                        data-id-play="{{ $data->id_play }}"
                                        data-current-harga="{{ $data->current_harga }}"
                                        data-harga-per-jam="{{ $data->harga_per_jam }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addTimeModal">Tambah Waktu
                                    </button>
                                    @endif
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
                                <td>{{ $data->durasi }} Jam</td>
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
                        <input type="text" class="form-control" id="nohp" name="nohp" value="62" required
                            oninput="checkPrefix(this)">
                    </div>

                    <script>
                        function checkPrefix(input) {
                            if (!input.value.startsWith("62")) {
                                input.value = "62" + input.value.substring(2);
                            }
                        }
                    </script>
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
                            <option value="1">1 Jam</option>
                            <option value="2">2 Jam</option>
                            <option value="3">3 Jam</option>
                            <option value="4">4 Jam</option>
                            <option value="5">5 Jam</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Transaksi -->
<div class="modal fade" id="transaksiModal" tabindex="-1" aria-labelledby="transaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('transaksi.store')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="transaksiModalLabel">Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_play" id="modal-id-play">
                    <div class="mb-3">
                        <label for="modal-no-transaksi" class="form-label">No Transaksi</label>
                        <input type="text" class="form-control" id="modal-no-transaksi" name="no_transaksi" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modal-harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="modal-harga" name="harga" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modal-bayar" class="form-label">Bayar</label>
                        <input type="number" class="form-control" id="modal-bayar" name="bayar" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal-kembalian" class="form-label">Kembalian</label>
                        <input type="number" class="form-control" id="modal-kembalian" name="kembalian" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH WAKTU -->
<div class="modal fade" id="addTimeModal" tabindex="-1" role="dialog" aria-labelledby="addTimeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTimeModalLabel">Tambah Waktu Bermain</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('play.addTime') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id_play" name="id_play">
                    <div class="form-group">
                        <label for="durasi">Pilih Durasi</label>
                        <select id="durasi" name="durasi" class="form-control">
                            <option value="" disabled selected>Pilih durasi</option>
                            <option value="1">1 Jam</option>
                            <option value="2">2 Jam</option>
                            <option value="3">3 Jam</option>
                            <option value="4">4 Jam</option>
                            <option value="5">5 Jam</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Total Harga</label>
                        <input type="text" id="harga" name="harga" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bayar">Bayar</label>
                        <input type="number" id="bayar" name="bayar" class="form-control" min="0" step="1000">
                    </div>
                    <div class="form-group">
                        <label for="kembalian">Kembalian</label>
                        <input type="text" id="kembalian" name="kembalian" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
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
    document.addEventListener('DOMContentLoaded', function() {
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


<!-- TRANSAKSI -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const transaksiModal = document.getElementById('transaksiModal');
        const idPlayInput = document.getElementById('modal-id-play');
        const noTransaksiInput = document.getElementById('modal-no-transaksi');
        const hargaInput = document.getElementById('modal-harga');
        const bayarInput = document.getElementById('modal-bayar');
        const kembalianInput = document.getElementById('modal-kembalian');

        // Tambahkan event listener untuk tombol
        document.querySelectorAll('.open-transaksi-modal').forEach(button => {
            button.addEventListener('click', function() {
                const idPlay = button.getAttribute('data-id-play');

                // Reset form modal
                idPlayInput.value = '';
                noTransaksiInput.value = '';
                hargaInput.value = '';
                bayarInput.value = '';
                kembalianInput.value = '';

                // Ambil data transaksi berdasarkan id_play
                fetch(`/transaksi/data/${idPlay}`)
                    .then(response => response.json())
                    .then(data => {
                        // Isi modal dengan data dari server
                        idPlayInput.value = idPlay;
                        noTransaksiInput.value = data.no_transaksi;
                        hargaInput.value = data.harga;
                    })
                    .catch(error => {
                        console.error('Error fetching transaksi data:', error);
                    });
            });
        });

        // Hitung kembalian
        bayarInput.addEventListener('input', function() {
            const bayar = parseInt(bayarInput.value) || 0;
            const harga = parseInt(hargaInput.value) || 0;
            const kembalian = bayar - harga;
            kembalianInput.value = kembalian > 0 ? kembalian : 0;
        });
    });
</script>

<!-- Add Time -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addTimeModal');
    const durasiSelect = modal.querySelector('#durasi');
    const hargaInput = modal.querySelector('#harga');
    const bayarInput = modal.querySelector('#bayar');
    const kembalianInput = modal.querySelector('#kembalian');
    const idPlayInput = modal.querySelector('#id_play'); // Tambahkan ini

    document.querySelectorAll('.open-add-time-modal').forEach(button => {
        button.addEventListener('click', function() {
            // Tambahkan baris ini untuk set id_play
            const idPlay = this.dataset.idPlay;
            idPlayInput.value = idPlay;

            const currentHarga = parseFloat(this.dataset.currentHarga) || 0;
            const hargaPerJam = parseFloat(this.dataset.hargaPerJam) || 0;

            // Reset input
            hargaInput.value = 0; // Ubah ini
            bayarInput.value = '';
            kembalianInput.value = '';

            // Hapus event listener sebelumnya
            durasiSelect.removeEventListener('change', calculateTotalHarga);
            bayarInput.removeEventListener('input', calculateKembalian);

            // Tambahkan event listener baru
            durasiSelect.addEventListener('change', calculateTotalHarga);
            bayarInput.addEventListener('input', calculateKembalian);

            function calculateTotalHarga() {
                const selectedDurasi = parseInt(durasiSelect.value, 10) || 0;
                const tambahanHarga = selectedDurasi * hargaPerJam;
                const totalHargaBaru = tambahanHarga; // Tambahkan currentHarga

                hargaInput.value = totalHargaBaru.toFixed(2);
                
                // Hitung ulang kembalian jika sudah ada input bayar
                if (bayarInput.value) {
                    calculateKembalian();
                }
            }

            function calculateKembalian() {
                const totalHarga = parseFloat(hargaInput.value) || 0;
                const bayar = parseFloat(bayarInput.value) || 0;

                if (bayar < totalHarga) {
                    kembalianInput.value = 'Bayar kurang';
                    return;
                }

                const kembalian = bayar - totalHarga;
                kembalianInput.value = kembalian.toFixed(2);
            }
        });
    });
});
</script>