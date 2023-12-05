@extends('user.master_home')
@section('home_content')
    <div class="row tm-mb-50">

        <div class="col-md-6 col-12">
            <div class="tm-about-2-col">
                <h2 class="tm-text-primary mb-4">
                    Visi
                </h2>
                <p class="mb-4">
                    “Terwujudnya Dinas Perpustakaan dan Kearsipan Provinsi Riau yang Profesional dalam Pengelolaan
                    Perpustakaan, Arsip dan Dokumentasi sebagai sumber pengetahuan dan Informasi untuk mencapai Sumber Daya
                    Manusia Riau yang berkualitas menunjang visi Riau 2020”
                </p>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="tm-about-2-col">
                <h2 class="tm-text-primary mb-4">
                    Misi
                </h2>
                <p class="mb-4">
                    1. Peningkatan kualitas Sumber Daya Manusia Dinas Perpustakaan dan Kearsipan Provinsi Riau
                    <br>
                    2. Peningkatan pelayanan Perpustakaan, Kearsipan dan Dokumentasi kepada masyarakat
                    <br>
                    3. Peningkatan minat dan budaya baca masyarakat serta pentingnya nilai guna arsip
                    <br>
                    4. Peningkatan kualitas prasarana dan sarana Dinas Perpustakaan dan Kearsipan Provinsi Riau
                    <br>
                    5. Peningkatan upaya-upaya pembinaan dalam rangka pemantapan pengelolaan Perpustakaan Arsip dan
                    Dokumentasi
                    <br>
                    6. Peningkatan upaya dokumentasi pada usaha pembangunan Provinsi Riau


            </div>
        </div>

    </div> <!-- row -->
    <div class="row mb-4">
        <h2 class="col-12 tm-text-primary">
            About
        </h2>
    </div>
    <div class="row tm-mb-74 tm-row-1640">
        <div class="col-lg-5 col-md-6 col-12 mb-3">
            <img src="{{ asset('frontend/img/img-about.png') }}" alt="Image" class="img-fluid"
                style="object-fit: cover;width: 550px;height:   350px;">
        </div>
        <div class="col-lg-7 col-md-6 col-12">
            <div class="tm-about-img-text">
                <p class="mb-4">
                    Berdasarkan Peraturan Daerah Provinsi Riau Nomor: 28 Tahun 2001 tentang Pembentukan Susunan Organisasi
                    dan Tata Kerja Badan Perpustakaan dan Arsip Provinsi Riau, kedua lembaga ini disatukan menjadi Badan
                    Perpustakaan dan Arsip, sebagai amanat dari Undang-Undang Nomor: 22 Tahun 1999 tentang Pemerintahan
                    Daerah yang sekarang telah di revisi menjadi Undang-undang Nomor 23 Tahun 2014 Tentang Pemerintahan
                    Daerah. Berdasarkan UndangUndang Nomor. 23 Tahun 2017 Badan Perpustakaan, Arsip dan Dokumentasi Provinsi
                    Riau berganti nama menjadi Dinas Perpustakaan dan Kearsipan Provinsi Riau</p>
                <p>
                    Berdasarkan Perda Provinsi Riau Nomor: 28 Tahun 2001 Tentang Pembentukan, Susunan Organisasi dan Tata
                    Kerja Badan Perpustakaan dan Arsip Provinsi Riau; kedua Lembaga ini disatukan menjadi Badan Perpustakaan
                    dan Arsip, sebagai amanat dari Undang-undang Nomor: 22 Tahun 1999 Tentang
                    Pemerintahan Daerah. Dengan diundangkannya UU No.43 Tahun 2007 tentang Perpustakaan, dan Peraturan
                    Pemerintah No. 24 Tahun 2014 tentang Pelaksanaan UU No. 43 Tahun 2007 tentang Perpustakaan, diharapkan
                    setiap orang mengetahuinya, demikian juga Pemangku Kepentingan / Stakeholders Perpustakaan.</p>
                <p>Kita tahu bahwa terbitnya UU No. 43 Tahun 2007 tentang Perpustakaan bertujuan untuk meningkatkan
                    kecerdasan kehidupan bangsa melalui pengembangan dan pendayagunaan perpustakaan sebagai sumber informasi
                    berupa karya tulis, karya cetak, dan karya rekam.</p>
            </div>
        </div>
    </div>
@endsection
