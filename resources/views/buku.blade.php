<style>
    .genre-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Jarak antar checkbox */
    }

    .form-check {
        width: calc(20% - 10px); /* Membagi ke 5 kolom dalam baris */
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Buku</h4>
                    <br>

                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor"
                            class="bi bi-journal-plus" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5" />
                            <path
                                d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                            <path
                                d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                        </svg> Add New Buku
                    </button>
                    <br><br>
                    <form action="{{ route('buku.filter', ['kategori' => request('kategori')]) }}" method="GET"
                        id="filterForm">
                        <div class="d-flex">
                            <select class="form-select me-2" id="kategoriFilter" name="kategori"
                                onchange="this.form.submit()">
                                <option value="" disabled selected>Pilih kategori</option>
                                <option value="">Semua Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="search" class="form-control" placeholder="Cari buku..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary ms-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                @if(!$kelasSudahUpload)
                    <div class="alert alert-warning">
                        <strong>Perhatian!</strong> Kelas Anda belum meng-upload buku. Silakan upload buku terlebih dahulu
                        untuk melihat daftar buku.
                    </div>
                @else
                    <div class="table-responsive">
                        <div class="row">
                            @foreach($buku as $data)
                                @if(!request('kategori') || $data->id_kategori == request('kategori'))
                                    <div class="col-md-3">
                                        <div class="card mb-4">
                                            <img src="{{ asset('storage/' . $data->cover_buku) }}" class="card-img-top buku"
                                                alt="Cover Buku" style="height: 700px; width: auto;">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">{{ $data->nama_buku }}</h6>
                                                <a href="{{ route('buku.show', $data->id_buku) }}" class="btn btn-sm btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-ui-radios-grid" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.5 15a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m9-9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m0 9a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5M16 3.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-9 9a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m5.5 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-9-11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 2a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                    </svg> Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_buku') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 buku">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="" disabled selected>Pilih kategori</option>
                            @foreach ($kategori as $j)
                                <option value="{{ $j->id_kategori }}">{{ $j->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_buku" class="form-label">Nama Buku</label>
                        <input type="text" class="form-control" id="nama_buku" name="nama_buku" required>
                    </div>
                    <div class="mb-3">
                        <label for="pengarang" class="form-label">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <div class="genre-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Fiksi" id="genreFiksi"
                                    name="genre[]">
                                <label class="form-check-label" for="genreFiksi">Fiksi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Non-Fiksi" id="genreNonFiksi"
                                    name="genre[]">
                                <label class="form-check-label" for="genreNonFiksi">Non-Fiksi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Biografi" id="genreBiografi"
                                    name="genre[]">
                                <label class="form-check-label" for="genreBiografi">Biografi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Education" id="genreEducation"
                                    name="genre[]">
                                <label class="form-check-label" for="genreEducation">Education</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Guide Book" id="genreGuideBook"
                                    name="genre[]">
                                <label class="form-check-label" for="genreGuideBook">Guide Book</label>
                            </div>
                            <!-- Tambahkan genre lainnya sesuai kebutuhan -->

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Action" id="genreAction"
                                    name="genre[]">
                                <label class="form-check-label" for="genreAction">Action</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Adventure" id="genreAdventure"
                                    name="genre[]">
                                <label class="form-check-label" for="genreAdventure">Adventure</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Komedi" id="genreKomedi"
                                    name="genre[]">
                                <label class="form-check-label" for="genreKomedi">Komedi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Drama" id="genreDrama"
                                    name="genre[]">
                                <label class="form-check-label" for="genreDrama">Drama</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Romance" id="genreRomance"
                                    name="genre[]">
                                <label class="form-check-label" for="genreRomance">Romance</label>
                            </div>
                            <!-- Tambahkan genre lainnya sesuai kebutuhan -->

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Crime" id="genreCrime"
                                    name="genre[]">
                                <label class="form-check-label" for="genreCrime">Crime</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Mystery" id="genreMystery"
                                    name="genre[]">
                                <label class="form-check-label" for="genreMystery">Mystery</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Fantasy" id="genreFantasy"
                                    name="genre[]">
                                <label class="form-check-label" for="genreFantasy">Fantasy</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="History" id="genreHistory"
                                    name="genre[]">
                                <label class="form-check-label" for="genreHistory">History</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Horror" id="genreHorror"
                                    name="genre[]">
                                <label class="form-check-label" for="genreHorror">Horror</label>
                            </div>
                            <!-- Tambahkan genre lainnya sesuai kebutuhan -->

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Thriller" id="genreThriller"
                                    name="genre[]">
                                <label class="form-check-label" for="genreThriller">Thriller</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Cyberpunk" id="genreCyberpunk"
                                    name="genre[]">
                                <label class="form-check-label" for="genreCyberpunk">Cyberpunk</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="SliceOfLife" id="genreSliceOfLife"
                                    name="genre[]">
                                <label class="form-check-label" for="genreSliceOfLife">Slice Of Life</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Animal" id="genreAnimal"
                                    name="genre[]">
                                <label class="form-check-label" for="genreAnimal">Animal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Other" id="genreOther"
                                    name="genre[]">
                                <label class="form-check-label" for="genreOther">Other</label>
                            </div>
                            <!-- Tambahkan genre lainnya sesuai kebutuhan -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover</label>
                        <input type="file" class="form-control" id="cover" name="cover_buku" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="file_buku" class="form-label">File Buku</label>
                        <input type="file" class="form-control" id="file_buku" name="file_buku"
                            accept=".pdf,.epub,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('kategoriFilter').addEventListener('change', function () {
        const selectedCategory = this.value;
        const filterForm = document.getElementById('filterForm');
        filterForm.action = "{{ route('buku.filter', '') }}" + "/" + selectedCategory;
        filterForm.submit();
    });
</script>