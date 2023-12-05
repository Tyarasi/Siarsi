@extends('admin.master_admin')

@section('home_admin')
    <section class="section profile">
        <div class="row">
            <div class="row">
                <div class="col-lg-5">
                    <h5 class="card-title">Video Kegiatan</h5>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-5">
                    <a href="{{ url('/video/downloadall/' . $video['id']) }}"
                        class="btn btn-primary btn-sm float-end">Download
                        All</a>
                </div>
            </div>



            @foreach (json_decode($video->video_dokumentasi, true) as $key => $dokumentasi)
                <div class="col-md-3 tambah">
                    <div class="card-image">
                        <div class="card-body-image profile-card pt-4 d-flex flex-column align-items-center">
                            <video width="200" height="150"controls>
                                <source src="{{ asset($dokumentasi['video_dokumentasi']) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <p>{{ basename($dokumentasi['video_dokumentasi']) }}</p>
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <form method="POST" action="{{ route('video.download') }}">
                                    @csrf
                                    <input type="hidden" name="path"
                                        value="{{ basename($dokumentasi['video_dokumentasi']) }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Download</button>
                                </form>
                                <a href="{{ route('delete.video', ['id' => $video->id, 'index' => $key]) }}"
                                    class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Modal -->
            @foreach (json_decode($video->video_dokumentasi, true) as $key => $dokumentasi)
                <div class="modal" id="myModal{{ $key }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title">{{ $video->nama_video }}</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <video width="100%" controls>
                                    <source src="{{ asset($dokumentasi['video_dokumentasi']) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <p id="modal-caption"></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
