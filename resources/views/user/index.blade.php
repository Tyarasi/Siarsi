@extends('user.master_index')

@section('home_content')

<!-- Card with header and footer -->
<!-- End Card with header and footer -->
<div class="container-fluid">
  
      <div class="row"> 
        <div class="col-lg-4">
            
            <div class="card">
              <div class="card-body">
                <p>Dokumentasi Kegiatan Pada Rabu, 8 Maret 2023</p>
              </div>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="card">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
              <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                  Tanggal , 08 Maret 2023
                </button>
                <div class="modal fade" id="verticalycentered" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="card">
              <div class="card-body">
                  <center><h5 class="card-title">Slides only</h5></center>

                  <!-- Slides only carousel -->
                  <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="frontend/img/example.png" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="frontend/img/cta-bg.jpg" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="frontend/img/slider.jpg" class="d-block w-100" alt="...">
                      </div>
                    </div>
                  </div><!-- End Slides only carousel-->
              </div>
          </div>
      </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <center><h5 class="card-title">Slides only</h5></center>

                    <!-- Slides only carousel -->
                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img src="frontend/img/slider.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                          <img src="frontend/img/cta-bg.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                          <img src="frontend/img/slider.jpg" class="d-block w-100" alt="...">
                        </div>
                      </div>
                    </div><!-- End Slides only carousel-->
                </div>
                <div class="card-text">Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen.</div>
            </div>
        </div>

        </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarCenteredExample"
      aria-controls="navbarCenteredExample"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div
      class="collapse navbar-collapse justify-content-center"
      id="navbarCenteredExample"
    >
      <!-- Left links -->
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="page-item">
          <a class="nav-link active" aria-current="page" href="#"><span>Sebelumnya</span></a>
        </li>
        <li class="page-item"><a class="nav-link active" aria-current="page" href="#"><span>1</span></a></li>
        <li class="page-item"><a class="nav-link active" aria-current="page" href="#"><span>2</span></a></li>
        <li class="page-item"><a class="nav-link active" aria-current="page" href="#"><span>3</span></a></li>
        <li class="page-item">
          <a class="nav-link active" aria-current="page" href="#">Selanjutnya</a>
        </li>
      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>

@endsection