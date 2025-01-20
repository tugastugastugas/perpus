<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Kelas</h4>
        </div>
    </div>
    <div class="card-body">
        
        <form action="{{ route('update.kelas') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Kelas</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nama_kelas" value="{{ $kelas->nama_kelas }}">
            </div>
            
            <input type="hidden" name="id" value="{{ $kelas->id_kelas }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>