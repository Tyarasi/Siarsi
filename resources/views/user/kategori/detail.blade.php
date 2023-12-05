@extends('user.master_home')

@section('home_content')
    <div class="row mb-4">
        <h2 class="col-12 tm-text-primary">Data dokumentasi</h2>
    </div>
    <div class="row tm-mb-90 tm-gallery">
        @if (is_array($fotos))
            @foreach ($fotos as $key => $dokumentasi)
                @if ($dokumentasi['foto_dokumentasi'] !== 'Filter')
                    @php
                        $kode = 'F';
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <figure class="effect-ming tm-video-item">
                            <img src="{{ asset($dokumentasi['foto_dokumentasi']) }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;"/>
                            <figcaption class="d-flex align-items-center justify-content-center">
                                <h2>View</h2>
                                <a href="{{ url('/dashboard/dokumentasi/view/' . $id . '/' . $kode . '/' . $key) }}">View
                                    more</a>
                            </figcaption>
                        </figure>
                        <div class="d-flex justify-content-between tm-text-gray">
                            <span class="tm-text-gray-light">18 Oct 2020</span>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        @if (is_array($videos))
            @foreach ($videos as $key => $dokumentasi)
                @if ($dokumentasi['video_dokumentasi'] !== 'Filter')
                    @php
                        $kode = 'V';
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <figure class="effect-ming tm-video-item">
                            <video src="{{ asset($dokumentasi['video_dokumentasi']) }}" alt="Image"
                                class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;"></video>
                            <figcaption class="d-flex align-items-center justify-content-center">
                                <h2>View</h2>
                                <a href="{{ url('/dashboard/dokumentasi/view/' . $id . '/' . $kode . '/' . $key) }}">View
                                    more</a>
                            </figcaption>
                        </figure>
                        <div class="d-flex justify-content-between tm-text-gray">
                            <span class="tm-text-gray-light">18 Oct 2020</span>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection

{{-- <style>
    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* Gaya untuk tombol play */
        /* Misalnya, menggunakan icon play dari Font Awesome */
        width: 60px;
        height: 60px;
        background-color: transparent;
        border: none;
        color: #fff;
        font-size: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .play-button:before {
        content: "";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
    }
</style> --}}
{{-- <!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <h2 class="rapat"><b>DA</b></h2>
        <br>
        <div class="row portfolio-container">
            {{-- @foreach ($foto as $item)
                @php
                    $fotoArray = json_decode($item->foto_dokumentasi, true);
                @endphp
                @foreach ($fotoArray as $item)
                    @php
                        $cek = $item['foto_dokumentasi'];
                    @endphp
                    <div class="col-lg-3 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap" style="position: relative;">
                            <img src="{{ asset($item['foto_dokumentasi']) }}" class="img-fluid card-image rounded"
                                alt="">
                            <div class="detail-text">Download</div>
                        </div>
                    </div>

                @endforeach
            @endforeach --}}
{{-- @if (is_array($fotos))
    @foreach ($fotos as $key => $dokumentasi)
        @if ($dokumentasi['foto_dokumentasi'] !== 'Filter')
            <div class="col-lg-3 col-md-6 portfolio-item filter-card">
                <div class="portfolio-wrap" style="position: relative;">
                    <img src="{{ asset($dokumentasi['foto_dokumentasi']) }}" class="img-fluid card-image" alt="">
                    <div class="portfolio-info">
                        <a href="{{ asset($dokumentasi['foto_dokumentasi']) }}" target="_blank">Lihat</a>
                        <form id="downloadForm" method="POST" action="{{ route('foto.download') }}">
                            @csrf
                            <input type="hidden" name="path"
                                value="{{ basename($dokumentasi['foto_dokumentasi']) }}">
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('downloadForm').submit();">Download</a>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif


@if (is_array($videos))
    @foreach ($videos as $key => $dokumentasi)
        @if ($dokumentasi['video_dokumentasi'] !== 'Filter')
            <div class="col-lg-3 col-md-6 portfolio-item filter-card">
                <div class="portfolio-wrap" style="position: relative;">
                    <video src="{{ asset($dokumentasi['video_dokumentasi']) }}" class="img-fluid card-image rounded"
                        alt="" controls></video>
                    <div class="portfolio-info">
                        <a href="{{ asset($dokumentasi['video_dokumentasi']) }}" target="_blank">Lihat</a>
                        <form id="downloadForm" method="POST" action="{{ route('video.download') }}">
                            @csrf
                            <input type="hidden" name="path"
                                value="{{ basename($dokumentasi['video_dokumentasi']) }}">
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('downloadForm').submit();">Download</a>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif
</div>
</div> --}}
{{-- </section> --}}
