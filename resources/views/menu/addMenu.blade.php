@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Add</h4>
                    <h6>Create new product</h6>
                </div>
            </div>


            {{-- Pesan Alert --}}
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oops! </strong> Ada beberapa masalah dengan input Anda:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('successcreate'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('successcreate') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('createMenu') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" name="name">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="select" name="category">
                                        <option>Choose Category</option>
                                        <option value="makanan">Food</option>
                                        <option value="minuman">Drink</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" name="price">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" name="stock">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Product Image</label>
                                    <div class="image-upload">
                                        <input type="file" name="image" id="fileInput">
                                        <div class="image-uploads">
                                            <img src="assets/img/icons/upload.svg" alt="img" id="imagePreview">
                                            <h4 id="fileName">Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="productlist.html" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            var fileInput = event.target;
            var file = fileInput.files[0]; // Ambil file pertama yang dipilih
            
            if (file) {
                // Menampilkan nama file pada elemen <h4> dengan id 'fileName'
                document.getElementById('fileName').textContent = file.name;
                
                // Ganti ikon gambar dengan nama file
                document.getElementById('imagePreview').style.display = 'none'; // Sembunyikan ikon upload
                
                // Menampilkan thumbnail gambar (opsional)
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imagePreview = document.createElement('img');
                    imagePreview.src = e.target.result;
                    imagePreview.alt = file.name;
                    imagePreview.style.maxWidth = '100px'; // Anda bisa mengatur ukuran gambar preview sesuai keinginan
                    document.querySelector('.image-uploads').appendChild(imagePreview);
                };
                reader.readAsDataURL(file);
            } else {
                // Jika tidak ada file, tampilkan pesan default
                document.getElementById('fileName').textContent = 'Drag and drop a file to upload';
                document.getElementById('imagePreview').style.display = 'block'; // Tampilkan ikon upload kembali
            }
        });
    </script>
    
@endsection
