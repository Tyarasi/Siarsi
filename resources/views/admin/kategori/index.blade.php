@extends('admin.master_admin')

@section('home_admin')
    <style>
        .tambah {
            margin-top: 15px;
        }
    </style>
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-14">
                <div class="row">
                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling1 overflow-auto">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="card-title">Jenis Sampah</h5>
                                    </div>
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-5">
                                        <a href="{{ route('tambah.kategori') }}"
                                            class="btn btn-primary btn-sm float-end tambah">Tambah Kategori</a>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Nama Kategori</th>
                                                <th scope="col" class="text-center">Keterangan Kategori</th>
                                                <th scope="col" class="text-center">Total Pencarian</th>
                                                <th scope="col" class="text-center">Jumlah Kunjungan</th>
                                                <th scope="col" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @foreach ($kategori as $as)
                                                    <td class="text-center">{{ $as->nama_kategori }}</td>
                                                    <td>{{ $as->keterangan_kategori }}</td>
                                                    <td class="text-center">{{ $as->views }}</td>
                                                    <td class="text-center">{{ $as->click_count }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ url('/admin/dashboard/kategori/edit/' . $as->id) }}"
                                                            class="btn btn-primary btn-sm small-font"
                                                            style="margin-right: 10px;">Edit</a>
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="deleteData({{ $as->id }})">Delete</button>
                                                    </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- End Top Selling -->

                    </div>
                </div><!-- End Left side columns -->

            </div>
    </section>

    <script>
        function deleteData(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Setelah dihapus, anda tidak dapat memulihkan data kembali',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/dashboard/kategori/delete/' + id;
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Data berhasil dihapus.',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect atau lakukan tindakan lain setelah menekan tombol OK
                            window.location.href =
                                '/admin/dashboard/kategori'; // Contoh pengalihan ke halaman kategori setelah penghapusan
                        }
                    });
                }
            });
        }
    </script>
    @if (Session::has('success'))
        <script>
            Swal.fire({
                title: 'Sukses',
                text: "{{ Session::get('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
