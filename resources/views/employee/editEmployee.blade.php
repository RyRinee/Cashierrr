@extends('layouts.app')
@section('content')    
<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Edit Customer Management</h4>
                    <h6>Edit/Update Customer</h6>
                </div>
            </div>

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

            @if (session('successupdate'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ session('successupdate') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="/updateEmployee/{{ $employee->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input type="text" name="name" value="{{ $employee->name }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $employee->email }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="select" name="role">
                                        <option disabled>Choose Role</option>
                                        <option value="admin" {{ $employee->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="employee" {{ $employee->role == 'employee' ? 'selected' : '' }}>Employee</option>
                                        <option value="customer" {{ $employee->role == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" value="{{ $employee->address }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="number" name="notelp" value="{{ $employee->notelp }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Avatar</label>
                                    <div class="image-upload">
                                        <input type="file" id="fileInput" name="image">
                                        <div class="image-uploads">
                                            <img src="{{asset('assets/img/icons/upload.svg')}}" alt="img">
                                            <h4>Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group" id="menuListContainer">
                                    <ul class="row" id="menuList">
                                        <!-- List of uploaded images will appear here -->
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Update</button>
                                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('fileInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const menuListContainer = document.getElementById('menuListContainer');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const menuList = document.getElementById('menuList');

                // Buat elemen baru untuk pratinjau gambar
                const listItem = document.createElement('li');
                listItem.style.display = 'flex';
                listItem.style.alignItems = 'center';
                listItem.style.marginBottom = '10px';

                listItem.innerHTML = `
                    <div style="margin-right: 10px;">
                        <img src="${e.target.result}" alt="Menu Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;" />
                    </div>
                    <div style="flex-grow: 1; overflow: hidden;">
                        <h2 style="font-size: 14px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${file.name}</h2>
                        <h3 style="font-size: 12px; color: #888; margin: 0;">${(file.size / 1024).toFixed(2)} KB</h3>
                    </div>
                    <a href="javascript:void(0);" onclick="removeImage(this)" style="color: #ff6b6b; font-weight: bold; margin-left: 10px; cursor: pointer;">x</a>
                `;

                menuList.appendChild(listItem);

                // Setelah file diunggah, tambahkan border pada container
                menuListContainer.classList.add('has-image');
            };
            reader.readAsDataURL(file);
        }
    });

    function removeImage(element) {
        const menuListContainer = document.getElementById('menuListContainer');
        const inputFile = document.getElementById('fileInput');

        element.closest('li').remove(); // Hapus pratinjau gambar yang dipilih

        // Reset input file jika semua gambar telah dihapus
        if (document.querySelectorAll('#menuList li').length === 0) {
            menuListContainer.classList.remove('has-image');
            // Kosongkan input file
            inputFile.value = '';
            document.getElementById('fileName').innerText = 'Drag and drop a file to upload';
        }
    }
</script>

<style>
    /* Styling untuk daftar gambar */
    #menuList {
        list-style: none;
        padding: 10px;
        margin: 0;
    }

    /* Styling border default */
    #menuListContainer {
        padding: 10px;
    }

    /* Styling border ketika ada gambar */
    #menuListContainer.has-image {
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>

@endsection