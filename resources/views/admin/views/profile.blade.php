@extends('admin.master_admin')

@section('home_admin')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update Foto Profile</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="{{ url('/admin/profile/foto/edit/' . $admin->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <input class="form-control" type="file" name="foto_admin" id="foto_admin">
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Kembali</a></button>
                </div>
            </form><!-- Vertical Form -->

        </div>
    </div>
@endsection
