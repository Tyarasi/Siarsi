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
    flex-basis: calc(20% - 10px); /* Atur lebar masing-masing kolom (33.33% untuk 3 kolom) */
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
      <h5 class="card-title">Tambah Data Foto</h5>

      <!-- Vertical Form -->
      <form class="row g-3" action="{{ route('StoreFoto')}}" method="POST" enctype="multipart/form-data" id="my-dropzone" class="dropzone">
        @csrf
        <div class="col-12">
          <label class="form-label">Nama Foto</label>
          <input type="text" class="form-control" name="nama_foto">
          @if ($errors->has('nama_foto'))
              <span class="text-danger">
                  {{ $errors->first('nama_foto') }}
              </span>
          @endif
        </div>
        
        <div class="col-12">
          <label for="inputDate" class="col-sm-2 col-form-label">Kategori Foto</label>
          <div class="col-sm-10">
            <select class="form-select" aria-label="Default select example" name="id_kategori">
              @foreach ($kategori as $ktgr)
              <option value="{{$ktgr->id}}">{{ $ktgr->nama_kategori}}</option>
              @endforeach
            </select>
            @if ($errors->has('id_kategori'))
              <span class="text-danger">
                  {{ $errors->first('id_kategori') }}
              </span>
            @endif
          </div>
        </div>

        <div class="col-12">
            <label class="form-label">Keterangan Foto</label>
            <textarea class="form-control"  name="keterangan_foto" style="height: 101px;"></textarea>
            @if ($errors->has('keterangan_foto'))
              <span class="text-danger">
                  {{ $errors->first('keterangan_foto') }}
              </span>
            @endif
          </div>
        <div class="col-12">
            <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Foto</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="tanggal_foto">
                @if ($errors->has('tanggal_foto'))
                  <span class="text-danger">
                      {{ $errors->first('tanggal_foto') }}
                  </span>
                @endif
            </div>
        </div>

        <div class="col-12">
          <div id="imagePreviewContainer" class="preview-container"></div>
        </div>

        <div class="col-12">  
          <input class="form-control" type="file" id="imageInput" name="foto_dokumentasi[]" multiple>
          @if ($errors->has('foto_dokumentasi'))
            <span class="text-danger">
              {{ $errors->first('foto_dokumentasi') }}
            </span>
            @elseif ($errors->has('foto_dokumentasi.*'))
            <span class="text-danger">
                {{ $errors->first('foto_dokumentasi.*') }}
            </span>
        @endif
        </div>

       
       

        <div class="text-right">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="" class="btn btn-secondary">Kembali</a></button>
        </div>
      </form><!-- Vertical Form -->
      
    </div>
  </div>
  <script>
    var imageInput = document.getElementById('imageInput');
    var imagePreviewContainer = document.getElementById('imagePreviewContainer');

    imageInput.addEventListener('change', function() {
    imagePreviewContainer.innerHTML = '';

    var files = this.files;
    var fileArray = Array.from(files); // Konversi objek FileList menjadi array
    var previewItems = []; // Simpan referensi ke elemen preview untuk penghapusan

  for (var i = 0; i < files.length; i++) {
    var file = files[i];

    if (file) {
      var reader = new FileReader();

      reader.addEventListener('load', function(event) {
        var previewItem = document.createElement('div');
        previewItem.classList.add('preview-item');

        var imageElement = document.createElement('img');
        imageElement.src = event.target.result;
        imageElement.classList.add('preview-image');

        var deleteButton = document.createElement('span');
        deleteButton.classList.add('preview-delete');
        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
        deleteButton.addEventListener('click', function() {
          previewItem.remove();
          var index = previewItems.indexOf(previewItem);
          if (index !== -1) {
            fileArray.splice(index, 1); // Hapus file dari array
          }
          updateInputFiles(); // Perbarui elemen input file setelah menghapus
        });

        previewItem.appendChild(imageElement);
        previewItem.appendChild(deleteButton);
        imagePreviewContainer.appendChild(previewItem);
        previewItems.push(previewItem); // Tambahkan elemen preview ke array
      });

      reader.readAsDataURL(file);
    }
  }

  function updateInputFiles() {
    var newInputFiles = new DataTransfer(); // Buat objek DataTransfer baru
    fileArray.forEach(function(file) {
      newInputFiles.items.add(file); // Tambahkan file ke objek DataTransfer
    });
    imageInput.files = newInputFiles.files; // Perbarui files pada elemen input dengan objek DataTransfer yang diperbarui
  }
});
</script>
  
@endsection