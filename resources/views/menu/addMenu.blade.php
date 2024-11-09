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
                            <!-- Form input untuk memilih gambar -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Image</label>
                                    <div class="image-upload">
                                        <input type="file" name="image" id="fileInput">
                                        <div class="image-uploads">
                                            <img src="assets/img/icons/upload.svg" alt="img" id="imagePreview">
                                            <h4 id="fileName">Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 ">
                                <div class="form-group" id="productListContainer">
                                    <ul class="row" id="productList">
                                        <!-- List of uploaded images will appear here -->
                                    </ul>
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
            const file = event.target.files[0];
            const productListContainer = document.getElementById('productListContainer');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const productList = document.getElementById('productList');

                    // Create new list item
                    const listItem = document.createElement('li');
                    listItem.style.display = 'flex';
                    listItem.style.alignItems = 'center';
                    listItem.style.marginBottom = '10px';

                    listItem.innerHTML = `
                <div style="margin-right: 10px;">
                  <img src="${e.target.result}" alt="Product Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;" />
                </div>
                <div style="flex-grow: 1; overflow: hidden;">
                  <h2 style="font-size: 14px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${file.name}</h2>
                  <h3 style="font-size: 12px; color: #888; margin: 0;">${(file.size / 1024).toFixed(2)} KB</h3>
                </div>
                <a href="javascript:void(0);" onclick="removeImage(this)" style="color: #ff6b6b; font-weight: bold; margin-left: 10px; cursor: pointer;">x</a>
              `;

                    productList.appendChild(listItem);

                    // After file is uploaded, add border to the container
                    productListContainer.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            }
        });

        function removeImage(element) {
            const productListContainer = document.getElementById('productListContainer');
            const inputFile = document.getElementById('fileInput');

            element.closest('li').remove(); // Remove the selected image preview

            // Reset the file input if all images are removed
            if (document.querySelectorAll('#productList li').length === 0) {
                productListContainer.classList.remove('has-image');
                // Reset the file input to empty (remove the selected file)
                inputFile.value = '';
                document.getElementById('fileName').innerText = 'Drag and drop a file to upload';
            }
        }
    </script>

    <style>
        /* Styling untuk daftar gambar */
        #productList {
            list-style: none;
            padding: 10px;
            margin: 0;
        }

        /* Styling border default */
        #productListContainer {
            padding: 10px;
        }

        /* Styling border ketika ada gambar */
        #productListContainer.has-image {
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>

@endsection
