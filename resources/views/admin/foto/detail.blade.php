@extends('admin.master_admin')

<style>
    .filter {
        margin-top: 12px;
        margin-left: 537px;
    }

    .small-font {
        font-size: 12px;
    }
</style>
@section('home_admin')
    <section class="section profile">
        <div class="row">
            <div class="row">
                <div class="col-lg-4">
                    <h5 class="card-title">Dokumentasi Kegiatan</h5>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-6 ">
                    <a href="{{ url('/foto/downloadall/' . $id) }}" class="btn btn-primary btn-sm float-end">Download
                        All</a>
                    <br>
                    <div class="col-lg-5 " style="margin-left:255px ">
                        <form action="{{ url('/admin/dashboard/data/detail/' . $id) }}" method="GET" id="filterForm">
                            @csrf
                            @foreach ($data as $item)
                                @php
                                    $kode_foto = $item->kode_foto;
                                    $kode_video = $item->kode_video;
                                @endphp
                                <select class="float-end tambah small-font" onchange="submitForm()" name="filter">
                                    <option disabled selected>Filter Data</option>
                                    <option value="{{ $kode_foto }}">Foto</option>
                                    <option value="{{ $kode_video }}">Video</option>
                                </select>
                            @endforeach
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                </div>
                <div class="col-lg-2"></div>

            </div>

            @if (is_array($fotos))
                @foreach ($fotos as $key => $dokumentasi)
                    @if ($dokumentasi['foto_dokumentasi'] !== 'Filter')
                        <div class="col-md-3 tambah">
                            <div class="card-image">
                                <div class="card-body-image profile-card pt-4 d-flex flex-column align-items-center">
                                    <a href="#" data-toggle="modal" data-target="#myModal"
                                        data-photo="{{ asset($dokumentasi['foto_dokumentasi']) }}"
                                        data-caption="{{ basename($dokumentasi['foto_dokumentasi']) }}">
                                        <img src="{{ asset($dokumentasi['foto_dokumentasi']) }}" alt="Foto Dokumentasi">
                                    </a>
                                    <p>{{ basename($dokumentasi['foto_dokumentasi']) }}</p>
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <form method="POST" action="{{ route('foto.download') }}">
                                            @csrf
                                            <input type="hidden" name="path"
                                                value="{{ basename($dokumentasi['foto_dokumentasi']) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Download</button>
                                        </form>
                                        <a href="{{ route('delete.foto', ['id' => $id, 'index' => $key]) }}"
                                            class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
            {{-- @if ($fotos === null)
                    <div class="col-md-3 tambah">
                        <div class="card-image">
                            <img src="{{ asset('\backend\img\Images not found.png') }}" alt="Foto Dokumentasi">
                        </div>
                    </div>
                @endif
            @endif --}}
            {{-- Dibawah Ini adalah videos --}}
            @if (is_array($videos))
                @foreach ($videos as $key => $dokumentasi)
                    @if ($dokumentasi['video_dokumentasi'] !== 'Filter')
                        <div class="col-md-3 tambah">
                            <div class="card-image">
                                <div class="card-body-image profile-card pt-4 d-flex flex-column align-items-center">
                                    <video width="200" height="150"controls>
                                        <source src="{{ asset($dokumentasi['video_dokumentasi']) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p>{{ basename($dokumentasi['video_dokumentasi']) }}</p>
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <form method="POST" action="{{ route('video.download') }}">
                                            @csrf
                                            <input type="hidden" name="path"
                                                value="{{ basename($dokumentasi['video_dokumentasi']) }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Download</button>
                                        </form>
                                        <a href="{{ route('delete.video', ['id' => $id, 'index' => $key]) }}"
                                            class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
            {{-- @if ($videos === null)
                    <div class="col-md-3 tambah">
                        <div class="card-image">
                            <div class="card-body-image profile-card pt-4 d-flex flex-column align-items-center">
                                <img src="{{ asset('backend/img/Konten V not Found.png') }}" alt="Foto Dokumentasi">
                            </div>
                        </div>
                    </div>
                @endif
            @endif --}}



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
    </script>
@endsection
