<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Detail User</h4>
        </div>
    </div>
    <div class="card-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh
            finibus leo</p>
        <form action="{{ route('update.user') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama User</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="username"
                    value="{{ $user->username }}">
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control" id="level" name="level" required>
                    <option value="{{ $user->level }}">{{ $user->level }}</option>
                    <option value="Admin">Admin</option>
                    <option value="Petugas">Petugas</option>
                    <option value="Murid">Murid</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select class="form-select" id="kelas" name="kelas" required>
                    <option value="" disabled selected>Pilih kelas</option>
                    @foreach ($kelas as $j)
                        <option value="{{ $j->id_kelas }}">{{ $j->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="id" value="{{ $user->id_user }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>