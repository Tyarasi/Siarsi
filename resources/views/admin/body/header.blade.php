<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('backend/img/Logo Dipersip.png') }}" alt="">
            <span class="d-none d-lg-block">Siarsi Admin</span> 
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
    <!--<div class="search-bar">-->
    <!--    <form class="search-form d-flex align-items-center" method="GET" action="{{ route('admin.index') }}">-->
    <!--        <input type="text" name="search" placeholder="Search Kategori">-->
    <!--        <button type="submit" title="Search"><i class="bi bi-search"></i></button>-->
    <!--    </form>-->
    <!--</div>-->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset(Auth::guard('admin')->user()->foto_admin) }}" alt="Profile">
                    <span class="d-none d-md-block dropdown-toggle ps-2"></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header text-left">
                        <img src="{{ asset(Auth::guard('admin')->user()->foto_admin) }}" class="rounded-circle me-2"
                            width="30" height="30">
                        <span>{{ Auth::guard('admin')->user()->nama_admin }}</span>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#" id="logoutBtn">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
                <script>
                    document.getElementById('logoutBtn').addEventListener('click', function(event) {
                        event.preventDefault(); // Mencegah tindakan default dari link

                        Swal.fire({
                            title: 'Sign Out',
                            text: 'Apakah Anda yakin ingin keluar?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Sign Out',
                            cancelButtonText: 'Cancel',
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Lakukan proses sign out di sini, seperti redirect atau AJAX request
                                window.location.href = "{{ route('logout') }}";
                            }
                        });
                    });
                </script>
            </li>
        </ul>
    </nav>

</header>
