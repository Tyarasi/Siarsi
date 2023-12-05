@extends('user.master_home')
@section('home_content')
    <div class="row mb-4">
        @if (empty($data))
        @else
            <h2 class="col-12 tm-text-primary">Dokumentasi Kegiatan</h2>
        @endif
        <div class="col-12 d-flex justify-content-end align-items-center">
            <form action="{{ url('/dashboard/dokumentasi/' . $id) }}" method="GET" id="filterForm">
                @csrf
                <input type="date" class="ddyymm" placeholder="DD/MM/YYYY" name="tanggal" id="tanggalInput">
            </form>
        </div>
        <div class="col-12 d-flex justify-content-start align-items-center">
            <form action="{{ url('/dashboard/dokumentasi/' . $id) }}" method="GET" id="filterKg">
                @csrf
                <select class="form-control" onchange="submitForm()" name="filter">
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                    @endforeach
                </select>

            </form>
        </div>
    </div>
    <div class="row tm-mb-90 tm-gallery">
        @if (empty($data))
            <h2 class="col-12 tm-text-primary">Dokumentasi pada tanggal tersebut tidak ada</h2>
        @else
        @foreach (array_slice($data, 0, 8) as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                @php
                    $fotoArray = json_decode($item->foto_dokumentasi, true);
                    $fotoTerpilih = isset($fotoArray[0]) ? $fotoArray[0] : '';
                    $videoArray = json_decode($item->video_dokumentasi, true);
                    $videoTerpilih = isset($videoArray[0]) ? $videoArray[0] : '';
                @endphp
                <figure class="effect-ming tm-video-item">
                    @if ($fotoTerpilih != null)
                        @foreach ($fotoTerpilih as $foto)
                            <img src="{{ asset($foto) }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;">
                        @endforeach
                    @else
                        @foreach ($videoTerpilih as $video)
                            <video src="{{ asset($video) }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;" controls></video>
                        @endforeach
                    @endif
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2>{{ $item->nama }}</h2>
                        <a href="{{ url('/dashboard/dokumentasi/detail/' . $item->id) }}">View more</a>
                    </figcaption>
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-black-light"></span>
                    <span class="tm-text-black-light">{{ date('Y/m/d', strtotime($item->tanggal)) }}</span>
                </div>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-black-light">{{ $item->keterangan }}</span>
                </div>
            </div>
        @endforeach
        @endif
    </div>
    <script>
        function submitForm() {
            document.getElementById('filterForm').submit();
        }

        function submitForm() {
            document.getElementById('filterKg').submit();
        }

        const filterForm = document.getElementById('filterForm');
        const tanggalInput = document.getElementById('tanggalInput');

        // Menambahkan event listener untuk peristiwa pengiriman form atau perubahan input tanggal
        filterForm.addEventListener('submit', handleFormSubmit);
        tanggalInput.addEventListener('change', handleFormSubmit);

        function handleFormSubmit(event) {
            event.preventDefault(); // Mencegah pengiriman form secara default

            // Lakukan operasi lain yang diinginkan, seperti mengirim data ke server atau memperbarui tampilan

            // Contoh: Mengirim form secara manual dengan mengubah action URL dan metode
            filterForm.action = '{{ url('/dashboard/dokumentasi/' . $id) }}';
            filterForm.method = 'GET';
            filterForm.submit();
        }

        // Fungsi yang akan dijalankan saat input tanggal berubah
        function handleDateChange(event) {
            // Lakukan operasi lain yang diinginkan saat tanggal berubah
        }
    </script>
@endsection

{{-- <!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio">
    <div class="container">
        <h2 class="rapat"><b></b></h2>
        <div class="row">
            <div class="col-lg-6 col-md-6 d-flex justify-content-start">
                <form action="{{ url('/dashboard/dokumentasi/' . $id) }}" method="GET" id="filterForm">
                    @csrf
                    <div class="dropdown">
                        <select class="btn-in" onchange="submitForm()" name="filter">
                            <option disabled selected>Kategori</option>
                            @foreach ($kategoris as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <div class="col-lg-6 col-md-6 d-flex justify-content-end">
                <form action="{{ url('/dashboard/dokumentasi/' . $id) }}" method="GET" id="filterTggl">
                    @csrf
                    <input type="date" class="ddyymm" placeholder="DD/MM/YYYY" name="tanggal">
                </form>
            </div>
        </div>
        <br>
        {{-- List Foto --}}
{{-- <span>
            <h4 class="set-text"><b>Dokumentasi Kegiatan</b></h4>
        </span>
        <div class="row portfolio-container">
            @foreach (array_slice($data, 0, 3) as $item)
                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <div class="portfolio-wrap" style="position: relative;"
                        onclick="window.location.href = '{{ url('/dashboard/dokumentasi/detail/' . $item->id) }}'">
                        @php
                            $fotoArray = json_decode($item->foto_dokumentasi, true);
                            $fotoTerpilih = isset($fotoArray[0]) ? $fotoArray[0] : '';
                            $videoArray = json_decode($item->video_dokumentasi, true);
                            $videoTerpilih = isset($videoArray[0]) ? $videoArray[0] : '';
                            
                        @endphp
                        @if ($fotoTerpilih != null)
                            @foreach ($fotoTerpilih as $foto)
                                <img src="{{ asset($foto) }}" class="img-fluid card-image rounded" alt="">
                            @endforeach
                        @else
                            @foreach ($videoTerpilih as $video)
                                <video src="{{ asset($video) }}" class="img-fluid card-image rounded" alt=""
                                    controls></video>
                            @endforeach
                        @endif
                        <div class="portfolio-info">
                            {{ $item->keterangan }}
                        </div>
                        <div class="out-text">{{ date('Y/m/d', strtotime($item->tanggal)) }} || {{ $item->nama }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-lg-12" style="text-align: end;">
            <a href="index.html" type="button" class="btn" style="border: none; padding: 5px 20px; line-height: 1;">
                <span style="display: flex; align-items: center;">Selengkapnya <i
                        class="bi bi-chevron-right"></i></span>
            </a>
        </div>
    </div> --}}
{{-- </section> --}}
{{-- <script>
    function submitForm() {
        document.getElementById('filterForm').submit();
    }

    const filterTggl = document.getElementById('filterTggl');
    const tanggalInput = document.querySelector('input[name="tanggal"]');

    // Menambahkan event listener untuk peristiwa pengiriman form atau perubahan input tanggal
    filterTggl.addEventListener('submit', handleFormSubmit);
    tanggalInput.addEventListener('input', handleFormSubmit);

    function handleFormSubmit(event) {
        event.preventDefault(); // Mencegah pengiriman form secara default

        // Lakukan operasi lain yang diinginkan, seperti mengirim data ke server atau memperbarui tampilan

        // Contoh: Mengirim form secara manual dengan mengubah action URL dan metode
        filterForm.action = '{{ url('/dashboard/dokumentasi/' . $id) }}';
        filterTggl.method = 'GET';
        filterTggl.submit();
    }

    // Fungsi yang akan dijalankan saat input tanggal berubah
    function handleDateChange(event) {
        // Lakukan operasi lain yang diinginkan saat tanggal berubah
    }
</script> --}}
