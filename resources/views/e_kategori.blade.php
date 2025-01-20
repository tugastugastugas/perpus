<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Kategori</h4>
        </div>
    </div>
    <div class="card-body">
        
        <form action="{{ route('update.kategori') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama kategori</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nama_kategori" value="{{ $kategori->nama_kategori }}">
            </div>
            
            <input type="hidden" name="id" value="{{ $kategori->id_kategori }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>