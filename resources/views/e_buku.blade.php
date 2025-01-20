<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Buku</h4>
        </div>
    </div>
    <div class="card-body">

        <form action="{{ route('update.buku') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="kategori">Kategori Buku</label>
                <select name="kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}"
                        {{ $kat->id_kategori == $buku->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="nama_buku">Nama Buku</label>
                <input type="text" class="form-control" id="nama_buku" name="nama_buku" value="{{ $buku->nama_buku }}" required>
            </div>

            <div class="form-group">
                <label for="pengarang">Pengarang</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ $buku->pengarang }}" required>
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="{{ $buku->genre }}" required>
            </div>

            <div class="form-group">
                <label for="penerbit">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ $buku->penerbit }}" required>
            </div>

            <div class="form-group">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="date" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" required>
            </div>

            <div class="form-group">
                <label for="cover_buku">Cover Buku</label>
                <input type="file" class="form-control" id="cover_buku" name="cover_buku">
                @if($buku->cover_buku)
                <p>Current Cover:</p>
                <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="Cover Buku" width="100">
                @endif
            </div>

            <div class="form-group">
                <label for="file_buku">File Buku</label>
                <input type="file" class="form-control" id="file_buku" name="file_buku">
                @if($buku->file_buku)
                <p>Current File:</p>
                <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank">Download</a>
                @endif
            </div>

            <!-- Hidden input for Buku ID -->
            <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">

            <button type="submit" class="btn btn-primary">Update Buku</button>
            <a href="{{ route('buku') }}" class="btn btn-danger">Cancel</a>
        </form>

    </div>
</div>