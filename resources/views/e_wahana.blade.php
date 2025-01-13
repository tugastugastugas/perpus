<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Wahana</h4>
        </div>
    </div>
    <div class="card-body">
        
        <form action="{{ route('update.wahana') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama Wahana</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nama_wahana" value="{{ $wahana->nama_wahana }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Harga</label>
                <input type="text" class="form-control" id="exampleInputharga1" name="harga" value="{{ $wahana->harga }}">
            </div>
            
            <input type="hidden" name="id" value="{{ $wahana->id_wahana }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>