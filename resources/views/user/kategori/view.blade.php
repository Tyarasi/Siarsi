@extends('user.master_home')
@section('home_content')
    {{-- @if ($kode == 'F')
        <div class="row mb-4">
            @foreach ($data as $item)
                <h2 class="col-12 tm-text-primary">{{ $item->nama_foto }}</h2>
            @endforeach
        </div>
        <div class="row tm-mb-90">
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                <img src="{{ asset($ambilData->foto_dokumentasi) }}" alt="Image" class="img-fluid"
                    style="object-fit: cover;width: 2500px;height: 550px;">
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="tm-bg-gray tm-video-details">
                    <div class="text-center mb-5">
                        <form method="POST" action="{{ route('foto.download') }}">
                            @csrf
                            <input type="hidden" name="path" value="{{ basename($ambilData->foto_dokumentasi) }}">
                            <button type="submit" class="btn btn-primary tm-btn-big">Download</a>
                        </form>
                    </div>
                    <div class="mb-4 d-flex flex-wrap">
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Tanggal </span>
                            <span class="tm-text-primary">
                                @foreach ($data as $item)
                                    {{ $item->tanggal_foto }}
                                @endforeach
                            </span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary">JPG/PNG</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="tm-text-gray-dark mb-3">keterangan</h3>
                        @foreach ($data as $item)
                            <p>
                                {{ $item->keterangan_foto }}
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @elseif ($kode == 'V')
        <div class="row mb-4">
            @foreach ($data as $item)
                <h2 class="col-12 tm-text-primary">{{ $item->nama_video }}</h2>
            @endforeach
        </div>
        <div class="row tm-mb-90">
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                <video autoplay muted loop controls id="tm-video" style="object-fit: cover;width: 780px;height: 550px;">
                    <source src="{{ asset($ambilData->video_dokumentasi) }}" type="video/mp4">
                </video>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="tm-bg-gray tm-video-details">
                    <div class="text-center mb-5">
                        <form method="POST" action="{{ route('video.download') }}">
                            @csrf
                            <input type="hidden" name="path" value="{{ basename($ambilData->video_dokumentasi) }}">
                            <button type="submit" class="btn btn-primary tm-btn-big">Download</a>
                        </form>
                    </div>
                    <div class="mb-4 d-flex flex-wrap">
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Tanggal: </span>
                            <span class="tm-text-primary">
                                @foreach ($data as $item)
                                    {{ $item->tanggal_video }}
                                @endforeach
                            </span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary">MP4</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="tm-text-gray-dark mb-3">Keterangan</h3>
                        <p>
                            @foreach ($data as $item)
                                <p>
                                    {{ $item->keterangan_video }}
                                </p>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}
    <div class="row mb-4">
        @if ($kode === 'F')
            @foreach ($data as $item)
                <h2 class="col-12 tm-text-primary">{{ $item->nama_foto }}</h2>
            @endforeach
        @elseif ($kode === 'V')
            @foreach ($data as $item)
                <h2 class="col-12 tm-text-primary">{{ $item->nama_video }}</h2>
            @endforeach
        @endif

    </div>
    <div class="row tm-mb-90">
        @php
            $arrayData = json_decode($dokumentasi, true);
            $keyInt = intval($key);
        @endphp
        <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
            <div id="carouselExampleControls" class="carousel slide" data-interval="false">
                <div class="carousel-inner">
                    @while ($keyInt < $index)
                        <div class="carousel-item {{ $keyInt === intval($key) ? 'active' : '' }}">
                            @if ($kode === 'F')
                                @php
                                    $ambilData = $arrayData[$keyInt] ?? null;
                                @endphp
                                <img class="img-fluid" style="object-fit: cover;width: 2500px;height: 550px;"
                                    src="{{ asset($ambilData['foto_dokumentasi']) }}" alt="Image">
                            @elseif ($kode === 'V')
                                @php
                                    $ambilData = $arrayData[$keyInt] ?? null;
                                @endphp
                                <video class="img-fluid" style="object-fit: cover;width: 2500px;height: 550px;" controls>
                                    <source src="{{ asset($ambilData['video_dokumentasi']) }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                        @php
                            $keyInt++;
                        @endphp
                    @endwhile
                </div>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
            <div class="tm-bg-gray tm-video-details">
                <div class="text-center mb-5">
                    @if ($kode === 'F')
                        @php
                            $arrayData = json_decode($dokumentasi, true);
                            $keyInt = intval($key);
                            $ambilData = $arrayData[$keyInt] ?? null;
                        @endphp
                        <form method="POST" action="{{ route('foto.download') }}">
                            @csrf
                            <input type="hidden" name="path" value="{{ basename($ambilData['foto_dokumentasi']) }}">
                            <button type="submit" class="btn btn-primary tm-btn-big">Download</a>
                        </form>
                    @elseif ($kode === 'V')
                        @php
                            $arrayData = json_decode($dokumentasi, true);
                            $keyInt = intval($key);
                            $ambilData = $arrayData[$keyInt] ?? null;
                        @endphp
                        <form method="POST" action="{{ route('video.download') }}">
                            @csrf
                            <input type="hidden" name="path" value="{{ basename($ambilData['video_dokumentasi']) }}">
                            <button type="submit" class="btn btn-primary tm-btn-big">Download</a>
                        </form>
                    @endif

                </div>
                <div class="mb-4 d-flex flex-wrap">
                    <div class="mr-4 mb-2">
                        <span class="tm-text-gray-dark">Tanggal </span>
                        <span class="tm-text-primary">
                            12 / 10 / 2002
                        </span>
                    </div>
                    <div class="mr-4 mb-2">
                        <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary">JPG/PNG</span>
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="tm-text-gray-dark mb-3">keterangan</h3>

                    <p>
                        Lore Ipsum
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi carousel
        $(document).ready(function() {
            $('.carousel').carousel();
        });
    </script>
@endsection
