@extends('admin.master_admin')

@section('home_admin')
    @php
        
    @endphp
    <style>
        .dash {
            height: 150px
        }
    </style>
    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="col-lg-12">
            <div class="row">

                <div class="col-lg-3 ">
                    <div class="card info-card sales-card">
                        <div class="card-body dash">
                            <h5 class="card-title text-center">Kategori yang diminati</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div class="ps-3">
                                    @foreach ($countJlmhSeacrh as $data)
                                        <h6>{{ $data->nama_kategori }}</h6>
                                        <span class="text-success small pt-1 fw-bold">{{ $data->views }}</span> <span
                                            class="text-muted small pt-2 ps-1">Total Pencarian</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card info-card sales-card">
                        <div class="card-body dash">
                            <h5 class="card-title text-center">Last Access Admin</h5>

                            <a href="{{ route('history.admin') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div class="ps-1">
                                        <span class="text-success small pt-2 ps-1">{{ $lastAccess->username }}</span>
                                        <h5>
                                            <span class="text-muted small"
                                                style="font-size: 12px; padding-top: 2px; padding-left: 1px;">{{ $lastAccess->last_access }}</span>
                                        </h5>
                                        <span class="text-muted small pt-2 ps-1">See Detail >></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="card info-card sales-card">

                        <div class="card-body dash">
                            <h5 class="card-title text-center">Total Pengunjung</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $visitorCount }} Kunjungan</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 ">
                    <div class="card info-card sales-card">
                        <div class="card-body dash">
                            <h5 class="card-title text-center">Kategori yang sering dilihat</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div class="ps-3">
                                    @foreach ($countJlmhview as $data)
                                        <h6>{{ $data->nama_kategori }}</h6>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>

        {{-- <div class="row">
            <!-- Top Selling -->
            <div class="col-12">
                <div class="card top-selling overflow-auto">

                    <form action="{{ route('admin.index') }}" method="GET">
                        @csrf
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><button class="dropdown-item" type="submit" name="filter"
                                        value="today">Today</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="this_month">This
                                        Month</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="this_year">This
                                        Year</button></li>
                            </ul>
                        </div>
                    </form>

                    <div class="card-body pb-0">
                        <h5 class="card-title">Data Kegiatan</h5>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama kegiatan</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paginatedData as $data)
                                    <tr>
                                        <th scope="row" class="text-center">{{ $loop->iteration }}.</th>
                                        <td class="text-center">{{ $data->namaData }}</td>
                                        <td class="text-center">{{ $data->namaKategori }}</td>
                                        <td class="fw-bold">{{ $data->dateData }}</td>
                                        @php
                                            $kode = $data->kodeData;
                                        @endphp
                                        @if (substr($kode, 0, 1) === 'V')
                                            <td class="fw-bold">Video</td>
                                        @elseif (substr($kode, 0, 1) === 'F')
                                            <td class="fw-bold">Foto</td>
                                        @endif
                                        <td><a href="{{ url('admin/dashboard/detail/' . $data->kodeData) }}"
                                                class="btn btn-info btn-sm">Detail</a></td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <!-- Pagination with icons -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            </ul>
                        </nav><!-- End Pagination with icons -->
                    </div>
                </div>
            </div><!-- End Top Selling -->

        </div> --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Diagram Dokumentasi Kegiatan</h5>

                <!-- Bar Chart -->
                <canvas id="barChart"
                    style="max-height: 400px; display: block; box-sizing: border-box; height: 314px; width: 628px;"
                    width="943" height="471"></canvas>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        new Chart(document.querySelector('#barChart'), {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode($bulanLabels) !!},
                                datasets: {!! json_encode($datasets) !!}
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>

                <!-- End Bar CHart -->

            </div>
        </div>

    </section>
@endsection
