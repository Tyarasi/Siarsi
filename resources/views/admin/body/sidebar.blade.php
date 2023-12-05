<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('admin.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('index.daftar') }}">
                <i class="bi bi-grid"></i>
                <span>Daftar Dokumentasi</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('index.kategori') }}">
                <i class="bi bi-grid"></i>
                Kategori Kegiatan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('index.admin') }}">
                <i class="bi bi-file-earmark-person"></i>
                Admin
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('index.rekap') }}">
                <i class="bi bi-file-earmark-person"></i>
                Rekapitulasi Kegiatan
            </a>
        </li>

    </ul>

</aside>
