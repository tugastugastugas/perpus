<div class="container-fluid py-4" style="margin-top: 60px;">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4" style="padding: 20px;">
                <div class="container">
                    <h1>Select User Level</h1>
                    <div class="button-group">
                        <a href="{{ route('menu.permissions', 'Admin') }}" class="btn btn-primary">Admin</a>
                        <a href="{{ route('menu.permissions', 'Petugas') }}" class="btn btn-secondary">Petugas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>