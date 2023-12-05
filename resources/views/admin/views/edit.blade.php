@extends('admin.master_admin')

@section('home_admin')
    <style>
        .preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1px;
        }

        .preview-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            flex-basis: calc(20% - 10px);
            /* Atur lebar masing-masing kolom (33.33% untuk 3 kolom) */
        }

        .preview-video {
            width: 150px;
            height: 100px;
            margin-right: 10px;
        }

        .preview-image {
            width: 150px;
            height: 100px;
            margin-right: 10px;
        }

        .preview-delete {
            display: flex;
            align-items: center;
            color: red;
            cursor: pointer;
        }
    </style>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit data</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="{{ route('update.data') }}" method="POST" enctype="multipart/form-data"
                id="editForm">
                @csrf
                @php
                    $admin_id = Auth::guard('admin')->user()->id;
                @endphp
                <input type="hidden" name="admin_id" value="{{ $admin_id }}">
                @foreach ($allData as $item)
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" name="nama" value="{{ $item->nama }}">

                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Keterangan Kegaiatan</label>
                        <textarea class="form-control" name="keterangan" style="height: 101px;">{{ $item->keterangan }}</textarea>
                    </div>

                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Default select example" name="id_kategori">
                            @foreach ($kategori as $ktgr)
                                <option value="{{ $ktgr->id }}">{{ $ktgr->nama_kategori }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-12">
                        <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Kegiatan</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tanggal" value="{{ $item->tanggal_foto }}">
                            <input type="hidden" name="nama_admin" value="{{ $item->nama_admin }}">
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="col-12">
                        <div id="dokumentasiPreviewContainer" class="preview-container"></div>
                    </div>
                    <div class="col-12">
                        <input type="file" name="dokumentasi[]" class="form-control-file" id="dokumentasiInput"
                            accept="image/*,video/*" multiple>
                        @if ($errors->has('dokumentasi'))
                            <span class="text-danger">
                                {{ $errors->first('dokumentasi') }}
                            </span>
                        @elseif ($errors->has('dokumentasi.*'))
                            <span class="text-danger">
                                {{ $errors->first('dokumentasi.*') }}
                            </span>
                        @endif
                    </div>
                @endforeach
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                    <button type="reset" class="btn btn-secondary">Kembali</a></button>
                </div>
            </form><!-- Vertical Form -->

        </div>
    </div>
    <script>
        var dokumentasiInput = document.getElementById('dokumentasiInput');
        var dokumentasiPreviewContainer = document.getElementById('dokumentasiPreviewContainer');
        var dokumentasiPreviewItems = [];

        dokumentasiInput.addEventListener('change', function() {
            dokumentasiPreviewContainer.innerHTML = '';

            var files = this.files;
            var fileArray = Array.from(files); // Konversi objek FileList menjadi array

            for (var i = 0; i < fileArray.length; i++) {
                (function(file) { // Buat IIFE untuk mengisolasi file di setiap iterasi
                    var reader = new FileReader();

                    reader.addEventListener('load', function(event) {
                        var previewItem = document.createElement('div');
                        previewItem.classList.add('preview-item');

                        if (file.type.startsWith('image')) {
                            var imageElement = document.createElement('img');
                            imageElement.src = event.target.result;
                            imageElement.classList.add('preview-image');
                            previewItem.appendChild(imageElement);
                        } else if (file.type.startsWith('video')) {
                            var videoElement = document.createElement('video');
                            videoElement.src = event.target.result;
                            videoElement.classList.add('preview-video');
                            videoElement.controls = true;
                            previewItem.appendChild(videoElement);
                        }

                        var deleteButton = document.createElement('span');
                        deleteButton.classList.add('preview-delete');
                        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteButton.addEventListener('click', function() {
                            previewItem.remove();
                            var index = dokumentasiPreviewItems.indexOf(previewItem);
                            if (index !== -1) {
                                fileArray.splice(index, 1); // Hapus file dari array
                            }
                            updateInputFiles(); // Perbarui elemen input file setelah menghapus
                        });

                        previewItem.appendChild(deleteButton);
                        dokumentasiPreviewContainer.appendChild(previewItem);
                        dokumentasiPreviewItems.push(previewItem); // Tambahkan elemen preview ke array
                    });

                    reader.readAsDataURL(file);
                })
                (fileArray[i]); // Pass file sebagai argument ke IIFE
            }

            function updateInputFiles() {
                var newInputFiles = new DataTransfer(); // Buat objek DataTransfer baru
                fileArray.forEach(function(file) {
                    newInputFiles.items.add(file); // Tambahkan file ke objek DataTransfer
                });
                dokumentasiInput.files = newInputFiles
                    .files; // Perbarui files pada elemen input dengan objek DataTransfer yang diperbarui
            }
        });
    </script>
    <script>
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault(); //cegah data mengirikan lansung
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Pastikan data yang anda ubah sudah benar',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editForm').submit();
                }
            });
        });

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault(); //cegah data mengirikan lansung
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Pastikan data yang anda ubah sudah benar',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editForm').submit();
                }
            });
        });
    </script>
@endsection
