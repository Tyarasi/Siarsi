@extends('user.master_home')

@section('search')
    <div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll"
        data-image-src="{{ asset('frontend/img/tes.jpg') }}">
        <form class="d-flex tm-search-form" action="{{ route('home') }}">
            <input class="form-control tm-search-input" type="text" name="search" placeholder="Search" aria-label="Search" />
            <button class="btn btn-outline-success tm-search-btn" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
@endsection
@section('home_content')
    {{-- Isi tengah --}}
    <div class="row mb-4">
        @if ($kategori->isEmpty())
        @else
        <h2 class="col-12 tm-text-primary">Kategori Dokumentasi Kegiatan</h2>
        @endif
    </div>
    <div class="row tm-mb-90 tm-gallery">
         @if ($kategori->isEmpty())
            <div class="col-12">
                <h2 class="col-12 tm-text-primary">Kategori Tidak Ada / Tidak Diketemukan</h2>
            </div>
        @else
        @foreach ($kategori as $index => $item)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                <figure class="effect-ming tm-video-item">
                    @if ($index == 0)
                        <img src="{{ asset('frontend/img/k1.jpg') }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;">
                    @elseif ($index == 1)
                        <img src="{{ asset('frontend/img/k2.jpeg') }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;">
                    @elseif ($index == 2)
                        <img src="{{ asset('frontend/img/k3.jpg') }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;">
                    @elseif ($index == 3)
                        <img src="{{ asset('frontend/img/k4.jpeg') }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;">
                    @else
                        <img src="{{ asset('frontend/img/k5.jpg') }}" alt="Image" class="img-fluid" style="object-fit: cover;width: 350px;height: 190px;">
                    @endif
                    <figcaption class="d-flex align-items-center justify-content-center">
                        <h2>{{ $item->nama_kategori }}</h2>
                        <a href="{{ url('/dashboard/dokumentasi/' . $item->id) }}">View more</a>
                    </figcaption>
                </figure>
                <div class="d-flex justify-content-between tm-text-gray">
                    <span class="tm-text-black-light">{{ $item->keterangan_kategori }}</span>
                </div>

            </div>
        @endforeach
         @endif
        @if (isset($pesan))
            <p>{{ $pesan }}</p>
        @endif
    </div>

   @if ($kategori instanceof \Illuminate\Pagination\LengthAwarePaginator && $kategori->hasPages())
    <div class="row tm-mb-90">
        <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
            <a href="{{ $kategori->previousPageUrl() }}"
                class="btn btn-primary tm-btn-prev mb-2{{ $kategori->onFirstPage() ? ' disabled' : '' }}">Previous</a>
            <div class="tm-paging d-flex">
                @foreach ($kategori->getUrlRange(1, $kategori->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                        class="tm-paging-link{{ $kategori->currentPage() === $page ? ' active' : '' }}">{{ $page }}</a>
                @endforeach
            </div>
            <a href="{{ $kategori->nextPageUrl() }}"
                class="btn btn-primary tm-btn-next{{ !$kategori->hasMorePages() ? ' disabled' : '' }}">Next Page</a>
        </div>
    </div>
@endif

    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <script>
        $(window).on("load", function() {
            $("body").addClass("loaded");
        });
    </script>
@endsection


{{-- @extends('user.master_home')
@section('home_content')
    <!-- ======= Portfolio Section ======= -->
    <section id="hero">
        <div data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <div class="carousel-inner" role="listbox">
                <!-- Slider -->
                <div class="carousel-item active">
                    <div class="carousel-container">
                        <div id="myCarousel" class="carousel" data-ride="carousel">
                            <!-- Carousel indicators -->
                            <ol class="carousel-indicators" style="left: 330px;">
                                <li data-target="#myCarousel" data-slide-to="1"
                                    style="background-color: #6082BA; width: 8px; height: 8px;"></li>
                                <li data-target="#myCarousel" data-slide-to="0" class="active"
                                    style="background-color: white; width: 16px; height: 16px; border-radius: 50%;">
                                </li>
                                <li data-target="#myCarousel" data-slide-to="2"
                                    style="background-color: #6082BA; width: 8px; height: 8px;"></li>
                            </ol>


                            <!-- Wrapper for carousel items -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="row">
                                        <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                                            <span class="responsive">
                                                <img src="{{ asset('frontend/assets/img/image-2@2x.png') }}"
                                                    style="width: 100%; height: 350px;">
                                            </span>
                                        </div>
                                        <div class="col-12 col-md-6"
                                            style="text-align: justify; display: flex; justify-content: center; align-items: center;">
                                            <div class="row row-demo-grid">
                                                <div class="col-12 col-md-12">
                                                    <h4 class="siarsi"><b>SIARSI</b></h4>
                                                </div>
                                                <div class="col-12 col-md-12" style="margin-bottom: 30px;">
                                                    <a class="ket">Sistem Informasi Arsip Dokumentasi Perpusatakaan
                                                        Prov
                                                        Riau</a>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <a href="#about"
                                                        class="btn-get-started animate__animated animate__fadeInUp scrollto">Info
                                                        Selengkapnya &#129058;</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                                            <span class="responsive">
                                                <img src="{{ asset('frontend/assets/img/image-3@2x.png') }}"
                                                    style="width: 100%; height: 350px;">
                                            </span>
                                        </div>
                                        <div class="col-12 col-md-6"
                                            style="text-align: justify; display: flex; justify-content: center; align-items: center;">
                                            <div class="row row-demo-grid">
                                                <div class="col-12 col-md-12">
                                                    <h4 class="siarsi"><b>SIARSI</b></h4>
                                                </div>
                                                <div class="col-12 col-md-12" style="margin-bottom: 30px;">
                                                    <a class="ket">Sistem Informasi Arsip Dokumentasi Perpusatakaan
                                                        Prov
                                                        Riau</a>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <a href="#about"
                                                        class="btn-get-started animate__animated animate__fadeInUp scrollto">Info
                                                        Selengkapnya &#129058;</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="portfolio" class="portfolio">
        <div class="container">

            <h2 class="rapat"><b>Kategori Kegiatan</b></h2>
            <div class="row portfolio-container">
                @foreach ($kategori->take(1) as $index => $item)
                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap" style="position: relative;"
                            onclick="window.location.href = '{{ url('/dashboard/dokumentasi/' . $item->id) }}'">
                            @if ($index == 0)
                                <img src="frontend/assets/img/image-8@2x.png" class="img-fluid card-image rounded"
                                    alt="">
                            @elseif ($index == 1)
                                <img src="frontend/assets/img/image-3@2x.png" class="img-fluid card-image rounded"
                                    alt="">
                            @elseif ($index == 2)
                                <img src="frontend/assets/img/image-3@2x.png" class="img-fluid card-image rounded"
                                    alt="">
                            @elseif ($index == 3)
                                <img src="frontend/assets/img/image-3@2x.png" class="img-fluid card-image rounded"
                                    alt="">
                            @else
                                <img src="frontend/assets/img/image-3@2x.png" class="img-fluid card-image rounded"
                                    alt="">
                            @endif
                            <a class="out-text">{{ $item->nama_kategori }}</a>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="col-lg-12" style="text-align: end;">
                <a href="#" id="loadMoreButton" class="btn"
                    style="border: none; padding: 5px 20px; line-height: 1;" data-page="1">
                    <span style="display: flex; align-items: center;">Selengkapnya <i
                            class="bi bi-chevron-right"></i></span>
                </a>
            </div>

        </div>
    </section>
    <script>
        $(document).ready(function() {
            var isLoadMore = true;

            $('#loadMoreButton').click(function() {
                if (isLoadMore) {
                    var page = $(this).data('page'); // Mendapatkan nomor halaman saat ini
                    var button = $(this); // Menyimpan referensi tombol

                    $.ajax({
                        url: '{{ url('/') }}',
                        type: 'GET',
                        dataType: 'html',
                        data: {
                            page: page
                        }, // Kirim nomor halaman ke server
                        success: function(response) {
                            $('.portfolio-container').append(
                                response); // Tambahkan data tambahan

                            // Periksa apakah ada data lebih lanjut
                            if (response.trim() !== '') {
                                page++; // Tambahkan nomor halaman
                                button.data('page', page); // Perbarui atribut data-page tombol
                            } else {
                                isLoadMore = false;
                                button.html(
                                    '<span style="display: flex; align-items: center;">Kembali <i class="bi bi-chevron-left"></i></span>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    // Logika untuk kembali ke tampilan sebelumnya
                    // ...

                    // Setelah selesai kembali ke tampilan sebelumnya
                    isLoadMore = true;
                    $('#loadMoreButton').html(
                        '<span style="display: flex; align-items: center;">Selengkapnya <i class="bi bi-chevron-right"></i></span>'
                    );
                }
            });
        });
    </script>
@endsection --}}
