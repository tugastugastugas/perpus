<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Buku</h4>
                    <br>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New Buku</button>
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
                                    <img src="{{ asset('storage/' . $data->cover_buku) }}" alt="Cover Buku" style="width: 200px; height: auto; cursor: pointer;" onclick="openFullscreen(this)">
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
                        <label for="genre" class="form-label">Genre</label>
                        <input type="text" class="form-control" id="genre" name="genre" required>
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


<script>
    function openFullscreen(imgElement) {
    var modal = document.createElement('div');
    modal.classList.add('modal');
    var modalImg = document.createElement('img');
    modalImg.src = imgElement.src; // Set gambar modal sesuai gambar yang diklik
    modal.appendChild(modalImg);

    // Menambahkan tombol close
    var closeBtn = document.createElement('span');
    closeBtn.classList.add('close');
    closeBtn.innerHTML = '&times;';
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };
    modal.appendChild(closeBtn);

    // Menampilkan modal
    document.body.appendChild(modal);
    modal.style.display = "flex"; // Menampilkan modal dengan gambar
}
</script>