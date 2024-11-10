<div class="container">
    <h1>Pengaturan Website</h1>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="site_name">Nama Website</label>
            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $setting->site_name ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" class="form-control" id="logo" name="logo">
            @if (isset($setting->logo))
            <img src="{{ asset('storage/logos/' . $setting->logo) }}" alt="Logo" style="max-width: 100px; margin-top: 10px;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </form>
</div>