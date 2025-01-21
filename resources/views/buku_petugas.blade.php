<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Buku</h4>
                    <br>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addUserModal"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                            fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5" />
                            <path
                                d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                            <path
                                d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                        </svg> Add New Buku
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Kode Buku</th>
                                <th>Nama Buku</th>
                                <th>Pengarang</th>
                                <th>Genre</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Cover</th>
                                <th>Download</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->kategori->nama_kategori }}</td>
                                <td>{{ $data->kode_buku }}</td>
                                <td>{{ $data->nama_buku }}</td>
                                <td>{{ $data->pengarang }}</td>
                                <td>{{ $data->genre }}</td>
                                <td>{{ $data->penerbit }}</td>
                                <td>{{ $data->tahun_terbit }}</td>
                                <td>
                                    @if($data->cover_buku)
                                    <img src="{{ asset('storage/' . $data->cover_buku) }}" alt="Cover Buku" style="width: 200px; height: auto; cursor: pointer;">
                                    @else
                                    Tidak ada gambar
                                    @endif
                                </td>

                                <td>
                                    @if($data->file_buku)
                                    <a href="{{ asset('storage/' . $data->file_buku) }}" class="btn btn-primary btn-sm" download>Download</a>
                                    @else
                                    Tidak ada file
                                    @endif
                                </td>
                                <td>{{ $data->tanggal_upload }}</td>
                                <td>
                                    <a href="{{ route('e_buku', $data->id_buku) }}">
                                        <button class="btn btn-danger">
                                            <i class="now-ui-icons ui-1_check"></i> Edit
                                        </button>
                                    </a>
                                    <form action="{{ route('buku.destroy', $data->id_buku) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Kode Buku</th>
                                <th>Nama Buku</th>
                                <th>Pengarang</th>
                                <th>Genre</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Cover</th>
                                <th>Download</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menambah Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_buku') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
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
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Fiksi" id="genreFiksi"
                                    name="genre[]">
                                <label class="form-check-label" for="genreFiksi">
                                    Fiksi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Non-Fiksi" id="genreNonFiksi"
                                    name="genre[]">
                                <label class="form-check-label" for="genreNonFiksi">
                                    Non-Fiksi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Komedi" id="genreKomedi"
                                    name="genre[]">
                                <label class="form-check-label" for="genreKomedi">
                                    Komedi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Drama" id="genreDrama"
                                    name="genre[]">
                                <label class="form-check-label" for="genreDrama">
                                    Drama
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Romance" id="genreRomantis"
                                    name="genre[]">
                                <label class="form-check-label" for="genreRomantis">
                                    Romance
                                </label>
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
                        <input type="file" class="form-control" id="file_buku" name="file_buku" accept=".pdf,.epub,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

