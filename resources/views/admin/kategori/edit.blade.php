@extends('admin.master_admin')

@section('home_admin')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Data Kategori</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="{{ url('/admin/dashboard/kategori/update/' . $kategori->id) }}" method="POST"
                enctype="multipart/form-data" id="kategoriForm">
                @csrf
                <div class="col-12">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" name="nama_kategori" value="{{ $kategori->nama_kategori }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Keterangan Kategori</label>
                    <textarea class="form-control" name="keterangan_kategori" style="height: 101px;">{{ $kategori->keterangan_kategori }}</textarea>
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
                text: 'Pastikan data yang anda edit sudah benar',
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
