@extends('admin.master_admin')

@section('home_admin')
    <div class="card">
        <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">


                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="true"
                        role="tab" tabindex="-1">Edit Profile</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password"
                        aria-selected="false" role="tab" tabindex="-1">Change Password</button>
                </li>


            </ul>
            <div class="tab-content pt-2">

                <div class="tab-pane fade profile-edit pt-3  active show" id="profile-edit" role="tabpanel">

                    <!-- Profile Edit Form -->
                    <form>
                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Admin</label>
                            <div class="col-md-8 col-lg-9">
                                <img src="{{ asset($admin->foto_admin) }}" width="130">
                                <div class="pt-2">
                                    <!-- Button trigger modal -->
                                    <a href="{{ route('update.profile') }}" class="btn btn-primary btn-sm"
                                        title="Upload profile image">
                                        <i class="bi bi-upload"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="fullName" type="text" class="form-control" value="{{ $admin->nama_admin }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Username</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="company" type="text" class="form-control" value="{{ $admin->username }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="job" type="text" class="form-control" value="{{ $admin->jabatan }}"
                                    disabled>
                            </div>
                        </div>

                    </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                    <!-- Change Password Form -->
                    <form method="POST" action="{{ route('password.update') }}" id="confirmForm">
                        @csrf
                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-md-8 col-lg-9">
                                <div class="input-group">
                                    <input name="oldpassword" type="password" class="form-control" id="currentPassword">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                        <i id="currentPasswordIcon" class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">  
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control" id="newPassword">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                        <i id="newPasswordIcon" class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                Password</label>
                            <div class="col-md-8 col-lg-9">
                                <div class="input-group">
                                    <input name="password_confirmation" type="password" class="form-control"
                                        id="renewPassword">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleReNewPassword">
                                        <i id="RenewPasswordIcon" class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Change Password</button>
                        </div>
                    </form><!-- End Change Password Form -->

                </div>

            </div><!-- End Bordered Tabs -->

        </div>
    </div>

    @php
        $cekRole = Auth::guard('admin')->user()->role;
    @endphp
    @if ($cekRole == 'superadmin')
        <div class="card">
            <div class="card-body pt-3">

                <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">


                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#new-admin"
                            aria-selected="true" role="tab" tabindex="-1">Tambahkan Admin</button>
                    </li>


                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane fade pt-3 active show" id="new-admin" role="tabpanel">
                        <!-- Change Password Form -->
                        <form method="POST" action="{{ route('addAdmin') }}" id="adminForm">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Nama Pegawai</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="nama_admin" type="text" class="form-control">
                                    @if ($errors->has('nama_admin'))
                                        <span class="text-danger">
                                            {{ $errors->first('nama_admin') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="username" type="text" class="form-control">
                                    @if ($errors->has('username'))
                                        <span class="text-danger">
                                            {{ $errors->first('username') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="jabatan" type="text" class="form-control">
                                    @if ($errors->has('jabatan'))
                                        <span class="text-danger">
                                            {{ $errors->first('jabatan') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Password</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="password" type="password" class="form-control">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Tambah Admin</button>
                            </div>
                        </form><!-- End Change Password Form -->

                    </div>

                </div><!-- End Bordered Tabs -->
            </div>
        </div>

        <!-- Left side columns -->
        <div class="col-lg-14">
            <div class="row">
                <!-- Top Selling -->
                <div class="col-12">
                    <div class="card top-selling1 overflow-auto">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h5 class="card-title">Daftar Admin</h5>
                                </div>
                                <div class="col-lg-2"></div>
                                <div class="col-lg-5"></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Nama pegawai</th>
                                            <th scope="col" class="text-center">Username</th>
                                            <th scope="col" class="text-center">Jabatan</th>
                                            <th scope="col" class="text-center">Foto Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allAdmin as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->nama_admin }}</td>
                                                <td class="text-center">{{ $item->username }}</td>
                                                <td class="text-center">{{ $item->jabatan }}</td>
                                                <td class="text-center"><img src="{{ asset($item->foto_admin) }}"
                                                        width="50"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- End Top Selling -->
            </div>
        </div><!-- End Left side columns -->
    @else
    @endif

    <script>
        document.getElementById('confirmForm').addEventListener('submit', function(event) {
            event.preventDefault(); // cegah data dikirimkan langsung
            Swal.fire({
                title: 'Apakah Anda yakin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('confirmForm').submit();
                }
            });
        });

        document.getElementById('adminForm').addEventListener('submit', function(event) {
            event.preventDefault(); //cegah data mengirikan lansung
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('adminForm').submit();
                }
            });
        });

        document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
            var passwordInput = document.getElementById('currentPassword');
            var passwordIcon = document.getElementById('currentPasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        });

        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            var passwordInput = document.getElementById('newPassword');
            var passwordIcon = document.getElementById('newPasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        });

        document.getElementById('toggleReNewPassword').addEventListener('click', function() {
            var passwordInput = document.getElementById('renewPassword');
            var passwordIcon = document.getElementById('renewPasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        });
    </script>

@endsection
