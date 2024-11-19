@extends('layouts.app')
@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Employee Management</h4>
                        <h6>Add/Update Empployee</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('createEmployee') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Employee Name</label>
                                        <input type="text" name="name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email">
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
                                            <option>Choose Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="employee">Employee</option>
                                            <option value="customer">Customer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="number" name="notelp">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Avatar</label>
                                        <div class="image-upload">
                                            <input type="file" id="fileInput" name="image">
                                            <div class="image-uploads">
                                                <img src="assets/img/icons/upload.svg" alt="img">
                                                <h4>Drag and drop a file to upload</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="form-group" id="menuListContainer">
                                        <ul class="row" id="menuList">
                                            <!-- List of uploaded images will appear here -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-submit me-2">Submit</button>
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

                    // Create new list item
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

                    // After file is uploaded, add border to the container
                    menuListContainer.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            }
        });

        function removeImage(element) {
            const menuListContainer = document.getElementById('menuListContainer');
            const inputFile = document.getElementById('fileInput');

            element.closest('li').remove(); // Remove the selected image preview

            // Reset the file input if all images are removed
            if (document.querySelectorAll('#menuList li').length === 0) {
                menuListContainer.classList.remove('has-image');
                // Reset the file input to empty (remove the selected file)
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
