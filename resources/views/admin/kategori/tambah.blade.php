@extends('admin.master_admin')

@section('home_admin')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambah Data Kategori</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="{{ route('StoreKategori') }}" method="POST" enctype="multipart/form-data"
                id="kategoriForm">
                @csrf
                <div class="col-12">
                    <label class="form-label">Nama Jenis Sampah Baru</label>
                    <input type="text" class="form-control" name="nama_kategori">
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                    <a href="{{ url('/admin/dashboard/kategori') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form><!-- Vertical Form -->

        </div>
    </div>
    <script>
        document.getElementById('kategoriForm').addEventListener('submit', function(event) {
            event.preventDefault(); //cegah data mengirikan lansung
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Setelah ditambah, anda tidak dapat mengubah kembali',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('kategoriForm').submit();
                }
            });
        });
    </script>
@endsection
