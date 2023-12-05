@extends('admin.master_admin')

@section('home_admin')
    <style>
        .tambah {
            margin-top: 10px;
        }

        .filter {
            margin-top: 18px;
            margin-right: 20px;
        }

        .small-font {
            font-size: 12px;
        }
        .nama-kolom {
            width: 80px;
        }
    </style>
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-14">
                <div class="row">
                    <div class="col-12">
                        <div class="card top-selling1 overflow-auto">
                            <div class="col-lg-5">
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-5 filter">
                                <form action="{{ route('index.daftar') }}" method="GET" id="filterForm">
                                    @csrf
                                    <select class="float-end tambah small-font" onchange="submitForm()" name="filter">
                                        <option disabled selected>Filter Data</option>
                                        <option value="today">Today</option>
                                        <option value="this_month">Month</option>
                                        <option value="this_year">Years</option>
                                    </select>
                                </form>
                            </div>
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="card-title">Daftar Kegiatan</h5>
                                    </div>
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-5">
                                        <a href="{{ route('tambah.data') }}"
                                            class="btn btn-primary btn-sm float-end tambah small-font">Tambah Data</a>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center small-font nama-kolom">Nama</th>
                                                <th scope="col" class="text-center small-font">Keterangan</th>
                                                <th scope="col" class="text-center small-font">Kategori</th>
                                                <th scope="col" class="text-center small-font">Tanggal</th>
                                                <th scope="col" class="text-center small-font">Diupload Oleh</th>
                                                <th scope="col" class="text-center small-font">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @foreach ($paginatedData as $item)
                                            <tr>
                                                <td class="small-font">{{ $item->nama }}</td>
                                                <td class="small-font">{{ $item->keterangan }}</td>
                                                <td class="text-center small-font">
                                                    @php
                                                        $id = $item->kategori_id;
                                                        $kategoris = App\Models\Kategori::find($id);
                                                    @endphp

                                                    {{ $kategoris->nama_kategori }}
                                                </td>
                                                <td class="text-center small-font">{{ $item->tanggal }}</td>
                                                <td class="text-center small-font">{{ $item->nama_admin }}</td>
                                                <td>
                                                    <div style="display: flex; align-items: center;">
                                                        <a href="{{ url('/admin/dashboard/data/detail/' . $item->id) }}"
                                                            class="btn btn-primary btn-sm small-font"
                                                            style="margin-right: 10px;">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ url('/admin/dashboard/daftar/edit/' . $item->id) }}"
                                                            class="btn btn-primary btn-sm small-font"
                                                            style="margin-right: 10px;">Edit</a>
                                                        <button class="btn btn-danger btn-sm small-font"
                                                            onclick="deleteData({{ $item->id }})"
                                                            style="margin-right: 10px;">Hapus</button>

                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            {{ $paginatedData->links() }}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script>
        function redirectToDetail(selectElement) {
            var selectedValue = selectElement.value;
            if (selectedValue !== '') {
                window.location.href = selectedValue;
            }
        }

        function submitForm() {
            document.getElementById('filterForm').submit();
        }

        //Delete Multiple
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
                    window.location.href = '/admin/dashboard/daftar/delete/' + id;
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Data berhasil dihapus.',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                '/admin/dashboard/daftar/';
                        }
                    });
                }
            });
        }
    </script>
@endsection
