@extends('admin.master_admin')

@section('home_admin')
<style>
  .tambah{
    margin-top:15px; 
  }
</style>


  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-14">
        <div class="row">
          <!-- Top Selling -->
          <div class="col-12">
            <div class="card top-selling overflow-auto">

              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-lg-5">
                  <h5 class="card-title">Video Kegiatan</h5>
                  </div>
                  <div class="col-lg-2"></div>
                  <div class="col-lg-5">
                  </div>
                </div>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col" class="text-center sticky-top">Video dokumentasi</th>
                      <th scope="col" class="text-center sticky-top">Nama kegiatan</th>
                      <th scope="col" class="text-center sticky-top">Keterangan kegiatan</th>
                      <th scope="col" class="text-center sticky-top">Tanggal kegiatan</th>
                      <th scope="col" class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $item)
                      <tr>
                        <td class="text-center">
                          @if ($item['video_dokumentasi'])
                          <a href="{{ url('admin/dashboard/video/detail/'.$item['id']) }}">
                              <video width="100" height="100" controls>
                                  <source src="{{ asset($item['video_dokumentasi']) }}">
                              </video>
                          </a>
                      @else
                          Video tidak tersedia
                      @endif
                        </td>
                        <td class="text-center">{{ $item['nama_video'] }}</td>
                        <td>{{ $item['keterangan_video'] }}</td>
                        <td>{{ $item['tanggal_video'] }}</td>
                        <td class="aksi">
                          <a href="{{ url('/admin/dashboard/video/edit/'.$item['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                          <a href="{{ url('/admin/dashboard/video/detail/'.$item['id']) }}" class="btn btn-info btn-sm"><i class="bi bi-download"></i></a>
                          <a href="{{ url('/admin/dashboard/video/delete/'.$item['id']) }}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
            </div>
          </div><!-- End Top Selling -->

        </div>
      </div><!-- End Left side columns -->

    </div>
  </section>
  
@endsection