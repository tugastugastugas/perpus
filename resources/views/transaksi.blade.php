<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Transaksi</h4>
                    <a href="{{ route('transaksi.print') }}" class="btn btn-primary mt-3">Cetak PDF</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Transaksi</th>
                                <th>Nama Anak</th>
                                <th>Nama Wahana</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->no_transaksi }}</td>
                                    <td>{{ $data->nama_anak }}</td>
                                    <td>{{ $data->nama_wahana }}</td>
                                    <td>{{ $data->harga }}</td>
                                    <td>
                                        <form action="{{ route('transaksi.destroy', $data->id_transaksi) }}" method="POST"
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
                                <th>No Transaksi</th>
                                <th>Nama Anak</th>
                                <th>Nama Wahana</th>
                                <th>Harga</th>
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
                <h5 class="modal-title" id="addUserModalLabel">Tambah Wahana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('t_wahana') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_wahana" class="form-label">Nama Wahana</label>
                        <input type="text" class="form-control" id="nama_wahana" name="nama_wahana" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="harga" class="form-control" id="harga" name="harga" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>