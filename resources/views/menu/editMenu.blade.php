@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Edit</h4>
                    <h6>Update your product</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" value="Macbook pro" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="select">
                                    <option>Computers</option>
                                    <option>Mac</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sub Category</label>
                                <select class="select">
                                    <option>None</option>
                                    <option>option1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Brand</label>
                                <select class="select">
                                    <option>None</option>
                                    <option>option1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="select">
                                    <option>Piece</option>
                                    <option>Kg</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" value="PT0002" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Minimum Qty</label>
                                <input type="text" value="5" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" value="50" />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control">
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</textarea>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Tax</label>
                                <select class="select">
                                    <option>Choose Tax</option>
                                    <option>2%</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Discount Type</label>
                                <select class="select">
                                    <option>Percentage</option>
                                    <option>10%</option>
                                    <option>20%</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" value="1500.00" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label> Status</label>
                                <select class="select">
                                    <option>Active</option>
                                    <option>Open</option>
                                </select>
                            </div>
                        </div>
                        <!-- Form input untuk memilih gambar -->
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Product Image</label>
                                <div class="image-upload">
                                    <input type="file" name="image" id="fileInput" />
                                    <div class="image-uploads">
                                        <img src="assets/img/icons/upload.svg" alt="img" id="imagePreview" />
                                        <h4 id="fileName">Drag and drop a file to upload</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group" id="productListContainer">
                                <ul class="row" id="productList">
                                    <!-- List of uploaded images will appear here -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <a href="javascript:void(0);" class="btn btn-submit me-2">Update</a>
                            <a href="productlist.html" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>



    <script>
        document
            .getElementById("fileInput")
            .addEventListener("change", function(event) {
                const file = event.target.files[0];
                const productListContainer = document.getElementById(
                    "productListContainer"
                );

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const productList = document.getElementById("productList");

                        // Create new list item
                        const listItem = document.createElement("li");
                        listItem.style.display = "flex";
                        listItem.style.alignItems = "center";
                        listItem.style.marginBottom = "10px";

                        listItem.innerHTML = `
                <div style="margin-right: 10px;">
                  <img src="${
                    e.target.result
                  }" alt="Product Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;" />
                </div>
                <div style="flex-grow: 1; overflow: hidden;">
                  <h2 style="font-size: 14px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${
                    file.name
                  }</h2>
                  <h3 style="font-size: 12px; color: #888; margin: 0;">${(
                    file.size / 1024
                  ).toFixed(2)} KB</h3>
                </div>
                <a href="javascript:void(0);" onclick="removeImage(this)" style="color: #ff6b6b; font-weight: bold; margin-left: 10px; cursor: pointer;">x</a>
              `;

                        productList.appendChild(listItem);

                        // After file is uploaded, add border to the container
                        productListContainer.classList.add("has-image");
                    };
                    reader.readAsDataURL(file);
                }
            });

        function removeImage(element) {
            const productListContainer = document.getElementById(
                "productListContainer"
            );
            const inputFile = document.getElementById("fileInput");

            element.closest("li").remove(); // Remove the selected image preview

            // Reset the file input if all images are removed
            if (document.querySelectorAll("#productList li").length === 0) {
                productListContainer.classList.remove("has-image");
                // Reset the file input to empty (remove the selected file)
                inputFile.value = "";
                document.getElementById("fileName").innerText =
                    "Drag and drop a file to upload";
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
