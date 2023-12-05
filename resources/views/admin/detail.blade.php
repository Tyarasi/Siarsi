@extends('admin.master_admin')

@section('home_admin')
    <section class="section profile">
        <div class="row">
            @foreach ($detail as $date)
                @foreach ($data as $cek)
                    @php
                        $kode = $cek->kode;
                    @endphp
                    @if (substr($kode, 0, 1) === 'F')
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="card-title">Foto Kegiatan</h5>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-5">
                            </div>
                        </div>  
                        @foreach (json_decode($cek->foto_dokumentasi, true) as $key => $dokumentasi)
                            <div class="col-md-3 tambah">
                                <div class="card-image">
                                    <div class="card-body-image profile-card pt-4 d-flex flex-column align-items-center">
                                        <a href="#" data-toggle="modal" data-target="#myModal"
                                            data-photo="{{ asset($dokumentasi['foto_dokumentasi']) }}"
                                            data-caption="{{ basename($dokumentasi['foto_dokumentasi']) }}">
                                            <img src="{{ asset($dokumentasi['foto_dokumentasi']) }}" alt="Foto Dokumentasi">
                                        </a>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach (json_decode($cek->foto_dokumentasi, true) as $key => $dokumentasi)
                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-title">{{ $cek->nama_foto }}</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="modal-image" src="{{ asset($dokumentasi['foto_dokumentasi']) }}"
                                                alt="Foto Dokumentasi" style="width: 100%">
                                            <p id="modal-caption"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @elseif (substr($kode, 0, 1) === 'V')
                        <div class="row">
                            <div class="col-lg-5">
                                <h5 class="card-title">Video Kegiatan</h5>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-5">
                            </div>
                        </div>
                        @foreach (json_decode($cek->video_dokumentasi, true) as $key => $dokumentasi)
                            <div class="col-md-3">
                                <div class="card-image">
                                    <div class="card-body-image profile-card pt-4 d-flex flex-column align-items-center">
                                        <video width="200" height="150"controls>
                                            <source src="{{ asset($dokumentasi['video_dokumentasi']) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <p>{{ basename($dokumentasi['video_dokumentasi']) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        </div>
    </section>
@endsection
