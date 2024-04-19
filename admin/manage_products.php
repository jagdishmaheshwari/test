<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('header.php');
    include ('../conn.php');
    include ('../validator.php');
    @$categoryId = $_GET['categoryId'];

    if ($categoryId) {
        $productsCondition = "product_list.category_id = '$categoryId' ";
        $productsCondition .= "GROUP BY product_list.product_id ORDER BY product_list.priority";
        $productDetails = getProductList($conn, productsCondition: $productsCondition);
        ?>
        <div class="container overflow-scroll">
            <?php
            if ($categoryId = @$_GET['categoryId']) {
                $categoryRow = $conn->query('SELECT category_name FROM category_list WHERE category_id  = ' . $categoryId)->fetch_assoc();
                if ($categoryRow) {
                    ?>
                    <div class="text-center display-5 text-pri"><span class="h2"></span>
                        <?php
                        echo $categoryRow['category_name'];
                        ?>
                    </div>
                    <?php
                }
            } ?>
            <h2>Manage Products <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal"><i
                        class="fa fa-plus"></i> Add Product</button>
            </h2>
            <table class="table table-bordered table-striped table-hover " id="productTable">
                <thead class="bg-grey">
                    <tr>
                        <th>Priority</th>
                        <th>
                            <div class="row">
                                <div class="col-4">Product Details</div>
                                <div class="col-8"><input type="text" id="productDetailsSearch"
                                        placeholder="Search product details" class="form-control"></div>
                            </div>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if ($productDetails != null) {
                        echo "<script>initiateDataTable()</script>";
                        foreach ($productDetails as $productDetails) {
                            ?>
                            <tr>
                                <td>
                                    <div style="d-flex flex-column">

                                        <div class="w-100 btn text-success fa fa-caret-up"
                                            onclick="editPriority('product_list','product_id','<?php echo $productDetails['product_id'] ?>','minus')">
                                        </div>
                                        <div class="text-center">
                                            <?php echo $productDetails['priority'] ?>
                                        </div>
                                        <div class="w-100 btn text-danger fa fa-caret-down"
                                            onclick="editPriority('product_list','product_id','<?php echo $productDetails['product_id'] ?>','plus')">
                                        </div>
                                    </div>
                                    <!-- <span class="fa fa-circle text-danger"></span> -->
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-2 d-flex">
                                            <i class="fa fa-circle <?php if ($productDetails['visible']) {
                                                echo "spinner-grow spinner-grow-sm text-green";
                                            } else {
                                                echo "text-red";
                                            } ?>"></i>
                                            <img class="w-100"
                                                src="../assets/item_images/<?php echo $productDetails['item_images'][0]; ?>">

                                        </div>
                                        <div class="col-10">
                                            <div class="h3">
                                                <?php echo $productDetails['category_name'] ?>
                                            </div>
                                            <div class="h5">
                                                <?php echo $productDetails['product_name'];
                                                echo " (";
                                                if ($productDetails['gender'] == "m") {
                                                    echo "Male";
                                                } elseif ($productDetails['gender'] == "f") {
                                                    echo "Female";

                                                }
                                                echo ")" ?>
                                                <div>
                                                    <code><?php echo $productDetails['product_code'] ?></code><br>
                                                    <div>
                                                        <?php echo $productDetails['keywords'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                </td>
                                <td style="min-width:170px">
                                    <div class="btn btn-primary my-1" title="Edit" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal"
                                        onclick="prefillProductDetails('<?php echo $productDetails['category_id'] ?>','<?php echo $productDetails['product_id'] ?>', '<?php echo $productDetails['product_code'] ?>', '<?php echo $productDetails['product_name'] ?>', '<?php echo $productDetails['priority'] ?>', '<?php echo $productDetails['gender'] ?>', '<?php echo $productDetails['keywords'] ?>', '<?php echo $productDetails['description'] ?>', '<?php echo $productDetails['visible'] ?>');">
                                        <i class="fa fa-edit"></i>
                                    </div>
                                    <div class="btn btn-danger" title="Delete"
                                        onclick="deleteProduct('<?php echo $productDetails['product_id'] ?>')"><i
                                            class="fa fa-trash"></i>
                                    </div>
                                    <?php if ($productDetails['visible'] == 0) { ?>
                                        <div class="btn btn-success" title="Make visible"
                                            onclick="editVisibility('product_list','product_id','<?php echo $productDetails['product_id'] ?>')">
                                            <i class="fa fa-eye"></i>
                                        </div>
                                    <?php } else { ?>
                                        <div class="btn btn-danger" title="Hide"
                                            onclick="editVisibility('product_list','product_id','<?php echo $productDetails['product_id'] ?>')">
                                            <i class="fa fa-eye-slash"></i>
                                        </div>
                                    <?php } ?>
                                    <div class="btn btn-success"
                                        onclick="window.location=('manage_items?productId=<?php echo $productDetails['product_id'] ?>&categoryId=<?php echo $productDetails['category_id'] ?>')">
                                        <i class="fa fa-bars"></i> Manage Item
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                        <tr>
                            <td colspan="3" class="h4 text-center text-danger">No product available for this category</td>
                        </tr>
                        </tr>


                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- <style>
        #addProductModal .modal-dialog {
            min-width: 100%;
        }

        #editProductModal .modal-dialog {
            min-width: 100%;
        }
    </style> -->
        <!-- Add Product Modal -->
        <style>
            .modal-dialog {
                min-width: 100%;
            }
        </style>
        <div class="modal fade p-0 p-sm-5" id="addProductModal" tabindex="1" aria-labelledby="addProductModalLabel"
            styl="display:block !important;opacity:1" aria-hidden="tru">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addProductForm">
                            <div class="mb-3">
                                <label for="categoryId">Select Category</label>
                                <select class="form-control" id="categoryId" disabled name="categoryId">
                                    <option value="0" disabled selected>Select Category</option>
                                    <?php $categorySql = "SELECT * FROM category_list";
                                    $categoryResult = $conn->query($categorySql);
                                    if ($categoryResult) {
                                        while ($categoryRow = $categoryResult->fetch_assoc()) { ?>
                                            <option value="<?php echo $categoryRow['category_id'] ?>">
                                                <?php echo $categoryRow['category_name'] ?>
                                            </option>
                                        <?php }
                                    } else {
                                        echo "<script>swal('Category List not fetched!')</script>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productCode" class="form-label">Product Code:</label>
                                <input type="text" class="form-control" oninput="$(this).val($(this).val().toUpperCase())"
                                    id="productCode" name="" required>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-8">
                                    <label for="productName" class="form-label col-8">Product Name:</label>
                                    <input type="text" class="form-control col-8" id="productName" required>
                                </div>
                                <div class="col-4">
                                    <label for="productName" class="form-label col-4">Priority:</label>
                                    <input type="number" id="priority" class="form-control col-4">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Suitable For Gender:</label>
                                <div>
                                    <input type="radio" name="gender" id="Female" class="form-check-input" value="f" checked>
                                    <label for="Female"> Female</label>
                                    <input type="radio" name="gender" id="Male" class="form-check-input" value="m"> <label
                                        for="Male"> Male</label>
                                    <input type="radio" name="gender" id="Everyone" class="form-check-input" value="a"> <label
                                        for="Everyone">Everyone</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="productCode" class="form-label">Description:</label>
                                <textarea type="product" class="form-control" id="description" name="description"
                                    style="height:70px !important" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="keywords" class="form-label">Keywords:</label>
                                <textarea name="" id="keywords" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <input type="checkbox" class="mx-2" style="scale:2" id="visible" value="1" checked> <label
                                for="visible">Visible</label>
                            <div>
                                <button type="button" class="btn btn-primary float-end" onclick="addProduct()">Add
                                    Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Product Modal -->
        <div class="modal fade p-0 p-sm-5" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true" stle="display:block !important;opacity:1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm">
                            <div class="mb-3">
                                <label for="categoryId">Select Category</label>
                                <select class="form-control" id="categoryId" name="categoryId">
                                    <option value="0" disabled selected>Select Category</option>
                                    <?php $categorySql = "SELECT * FROM category_list";
                                    $categoryResult = $conn->query($categorySql);
                                    if ($categoryResult) {
                                        while ($categoryRow = $categoryResult->fetch_assoc()) { ?>
                                            <option value="<?php echo $categoryRow['category_id'] ?>">
                                                <?php echo $categoryRow['category_name'] ?>
                                            </option>
                                        <?php }
                                    } else {
                                        echo "<script>swal('Category List not fetched!')</script>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productCode" class="form-label">Product Code:</label>
                                <input type="text" class="form-control" oninput="$(this).val($(this).val().toUpperCase())"
                                    id="productCode" name="" required>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-8">
                                    <label for="productName" class="form-label col-8">Product Name:</label>
                                    <input type="text" class="form-control col-8" id="productName" required>
                                </div>
                                <div class="col-4">
                                    <label for="productName" class="form-label col-4">Priority:</label>
                                    <input type="number" id="priority" class="form-control col-4">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Suitable For Gender:</label>
                                <div>
                                    <input type="radio" name="gender" id="Female" class="form-check-input" value="f" checked>
                                    <label for="Female"> Female</label>
                                    <input type="radio" name="gender" id="Male" class="form-check-input" value="m"> <label
                                        for="Male"> Male</label>
                                    <input type="radio" name="gender" id="Everyone" class="form-check-input" value="a"> <label
                                        for="Everyone">Everyone</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="productCode" class="form-label">Description:</label>
                                <textarea type="product" class="form-control" id="description" name="description"
                                    style="height:70px !important" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="keywords" class="form-label">Keywords:</label>
                                <textarea name="" id="keywords" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <input type="checkbox" class="mx-2" style="scale:2" id="visible" value="1" checked> <label
                                for="visible">Visible</label>
                            <input type="hidden" id="productId">
                            <div>
                                <button type="button" class="btn btn-primary float-end" onclick="updateProduct()">Update
                                    Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function prefillProductDetails(categoryId, productId, productCode, productName, priority, gender, keywords, description, visible) {
                $('#editProductForm #categoryId').val(categoryId);
                $('#editProductForm #productId').val(productId);
                $('#editProductForm #productName').val(productName);
                $('#editProductForm #productCode').val(productCode.toUpperCase());
                $('#editProductForm #priority').val(priority);
                $('#editProductForm #description').val(description);
                $('#editProductForm #keywords').val(keywords);
                $('#editProductForm #visible').prop('checked', visible == 1);
                $('#editProductForm #editProductModal').modal('show');
            }
        </script>
        <script>
            function updateProduct() {
                // Fetch data from the form
                var productId = $('#editProductModal #productId').val();
                var categoryId = $('#editProductModal #categoryId').val();
                var productCode = $('#editProductModal #productCode').val();
                var productName = $('#editProductModal #productName').val();
                var description = $('#editProductModal #description').val();
                var priority = $('#editProductModal #priority').val();
                var gender = $("#editProductModal input[name='gender']:checked").val();
                var keywords = $('#editProductModal #keywords').val();
                var visible = $('#visible').prop('checked') ? 1 : 0;
                // Check if product name and code are not empty
                if (productName.trim() === '' || productCode.trim() === '' || productId.trim() === '') {
                    swal('Please enter product name and code.');
                }

                $.ajax({
                    type: 'POST',
                    url: 'action_product', // Replace with your server-side script URL
                    data: {
                        action: 'update_product',
                        productId: productId,
                        categoryId: categoryId,
                        productCode: productCode,
                        productName: productName,
                        description: description,
                        gender: gender,
                        keywords: keywords,
                        priority: priority,
                        visible: visible
                    },
                    success: function (response) {
                        if (response.trim() === 'success') {
                            swal({ title: "Product Updated successfully!", icon: "success" }).then(function () {
                                window.location.reload();
                            });
                        } else {
                            swal({ title: "Product ID already exist!.", icon: "info", text: "Example - BANDHNI9091293GH" });
                        }
                    },
                    error: function () {
                        swal('An error occurred while Updating product. Please try again later.').then(function () {
                            window.location.reload();
                        });
                    }
                });
            }
        </script>
        <script>
            categoryId = '<?php echo $_GET['categoryId'] ?>';
            $('#addProductForm #categoryId').val(categoryId).change();
            function addProduct() {
                var categoryId = $('#addProductForm #categoryId').val();
                var productCode = $('#addProductForm #productCode').val();
                var productName = $('#addProductForm #productName').val();
                var description = $('#addProductForm #description').val();
                var visible = $('#visible').prop('checked') ? 1 : 0;
                var priority = $('#addProductForm #priority').val();
                var keywords = $('#addProductForm #keywords').val();
                var gender = $("input[name='gender']:checked").val();
                // Check if product name and code are not empty
                if (categoryId.trim() === '' || productCode.trim() === '' || productName.trim() === '' || description.trim() === '' || priority.trim() === '' || gender.trim() === '' || keywords.trim() === '') {
                    swal('Please fill required details!');
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: 'action_product',
                    data: {
                        action: 'add_product',
                        categoryId: categoryId,
                        productCode: productCode,
                        productName: productName,
                        description: description,
                        priority: priority,
                        gender: gender,
                        keywords: keywords,
                        visible: visible
                    },
                    success: function (response) {
                        if (response.trim() === 'success') {
                            swal({ title: "Product added successfully!", icon: "success" }).then(function () {
                                window.location.reload();
                            }); // Refresh the product list
                        } else {
                            swal("Failed to add product. Please try again.").then(function () {
                                // window.location.reload();
                            });
                        };
                    },
                    error: function () {
                        swal("An error occurred while adding product. Please try again later.").then(function () {
                            window.location.reload();
                        });
                    }
                });

            }
        </script>
        <script>
            function deleteProduct(productId) {
                swal({
                    title: "Sure Delete Product?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    buttons: ["Cancel", "Confirm"],
                    dangerMode: true,
                }).then((isConfirmed) => {
                    if (isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: 'action_product',
                            data: {
                                action: 'delete_product',
                                productId: productId
                            },
                            success: function (response) {
                                if (response === 'success') {
                                    swal({ icon: "success", title: "Product Deleted Successfull!" }).then(function () {
                                        window.location.reload();
                                    });
                                } else if (response === 'data') {
                                    swal({ icon: "info", title: "There are some products associated with this product!" + swal })
                                } else {
                                    swal({ icon: "error", title: "Something went wrong please try again leterrrrr!!" })
                                }
                            },
                            error: function () {
                                swal({ icon: "error", title: "Something went wrong please try again!" })
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            function initiateDataTable() {
                var table = $('#productTable').DataTable({
                    stateSave: true
                });

                // Apply individual column search
                $('#productDetailsSearch').on('keyup', function () {
                    table.columns(1).search(this.value).draw();
                });
            };
        </script>
        <?php include ('footer.php'); ?>
    <?php
    } else {
        echo "<script>window.location=('manage_category');</script>";
    }
} else {
    header('location: login');
}

?>