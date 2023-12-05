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
                        <div class="card top-selling overflow-auto">

                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="card-title">Foto Kegiatan</h5>
                                    </div>
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-5">
                                    </div>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Foto dokumentasi</th>
                                            <th scope="col" class="text-center">Nama kegiatan</th>
                                            <th scope="col" class="text-center">Keterangan kegiatan</th>
                                            <th scope="col" class="text-center">Tanggal kegiatan</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($data as $foto)
                                                <th scope="row" class="text-center">
                                                    <img src="{{ asset($foto['foto_dokumentasi']) }}" alt="">
                                                </th>
                                                <td>{{ $foto['nama_foto'] }}</td>
                                                <td>{{ $foto['keterangan_foto'] }}</td>
                                                <td>{{ $foto['tanggal_foto'] }}</td>
                                                <td>
                                                    <a href="{{ url('/admin/dashboard/foto/edit/' . $foto['id']) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="{{ url('admin/dashboard/foto/detail/' . $foto['id']) }}"
                                                        class="btn btn-info btn-sm"><i class="bi bi-download"></i></a>
                                                    <a href="{{ url('/admin/dashboard/foto/delete/' . $foto['id']) }}"
                                                        class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
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
@endsection
