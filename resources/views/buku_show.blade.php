<div class="container mt-5">
    <div class="row">
        <!-- Cover Buku -->
        <div class="col-md-4 text-center">
            <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="Cover Buku" class="img-fluid rounded shadow"
                style="width: 100%; max-width: 500px; height:90%">
        </div>

        <!-- Data Buku -->
        <div class="col-md-8">
            <h3>{{ $buku->nama_buku }}</h3>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th scope="row">Kategori</th>
                        <td>{{ $buku->kategori->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Pengarang</th>
                        <td>{{ $buku->pengarang }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Genre</th>
                        <td>{{ $buku->genre }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Penerbit</th>
                        <td>{{ $buku->penerbit }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tahun Terbit</th>
                        <td>{{ $buku->tahun_terbit }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- File Buku -->
            @if($buku->file_buku)
                <p><strong>Download:</strong> <a href="{{ asset('storage/' . $buku->file_buku) }}"
                        class="btn btn-sm btn-success" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-cloud-download-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.5a.5.5 0 0 1 1 0V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0m-.354 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V11h-1v3.293l-2.146-2.147a.5.5 0 0 0-.708.708z" />
                        </svg> Download
                    </a></p>
            @endif

            <!-- Tombol Aksi -->
            <a href="javascript:void(0);" class="btn btn-secondary" onclick="window.history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708z" />
                </svg> Back
            </a>

            <hr>
        </div>
    </div>
</div>