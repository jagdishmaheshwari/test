<?php
include ('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include ('header.php');
    include ('../conn.php');
    include ('../validator.php');
    ?>
    <div class="container overflow-scroll">
        <?php
        if ($productId = @$_GET['productId']) {
            $productRow = $conn->query('SELECT category_name, product_name FROM product_list  LEFT JOIN category_list ON category_list.category_id = product_list.category_id WHERE product_id  = ' . $productId)->fetch_assoc();
            if ($productRow) {
                ?>
                <div class="text-center display-6 text-pri"><span class="">
                        <?php
                        echo $productRow['category_name'] . " <i class='fa fa-angle-right'></i> " . $productRow['product_name'];
                        ?>
                    </span>
                </div>
                <?php
            }
        } ?>
        <h2 class="mb-4">Manage Items
            <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal"
                onclick="$('#addItemButton').show();$('#updateItemButton').hide();"><i class="fa fa-plus"></i>
                Add Item</div>
            <div class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#specifications">Specifications <i
                    class="fa fa-angle-down"></i></div>
        </h2>
        <?php
        if (isset($_GET['productId']) & $_GET['productId'] != null) {
            $productId = $_GET['productId'];
            @$row = getDetails($conn, "product_list.product_id = $productId")[0];
            ?>
            <div id="specifications" class="collapse w-100 py-2 bg-grey">
                <div class="px-5">
                    <?php if ($row) { ?>
                        <div class="h2">
                            <b>Description : </b>
                            <?php echo $row['p_description'] ?>
                        </div>
                        <div class="h2">
                            <b>Keywords : </b>
                            <?php echo $row['p_keywords'] ?>
                        </div>
                    <?php } ?>
                    <hr>
                    <div class="row">
                        <form id="addSpecificationForm" class="col-12 col-md-5">
                            <h4 class="text-center">Add Specifications</h4>
                            <div class="form-floating">
                                <input type="text"
                                    oninput="$('#priority').val($('#n_list option[value=' + this.value + ']').text().trim())"
                                    list="n_list" id="name" autocomplete="off" placeholder="Select option" class="form-control"
                                    required>
                                <label for="">Specification Name (Ex. Made In)</label>
                            </div>
                            <div class="form-floating mt-2">
                                <input type="text" list="v_list" autocomplete="off" id="value" placeholder class="form-control"
                                    required>
                                <label for="">Specification Value (Ex. India)</label>
                            </div>
                            <input type="hidden" id="productId" value="<?php echo $productId ?>">
                            <input type="number" min="0" class="d-none" id="priority">
                            <input type="submit" class="btn w-100 btn-primary mt-3" value="Add Specification">
                        </form>
                        <datalist id="n_list">
                            <?php
                            $nSql = "SELECT priority, name FROM product_specifications GROUP BY name";
                            // SELECT DISTINCT priority, name FROM product_specifications GROUP BY name
                            $nResult = $conn->query($nSql);
                            while ($nRow = $nResult->fetch_assoc()) { ?>
                                <option value="<?php echo $nRow['name'] ?>">
                                    <?php echo trim($nRow['priority']); ?>
                                </option>
                                <?php
                            }
                            ?>
                        </datalist>
                        <datalist id="v_list">
                            <?php
                            $vSql = "SELECT DISTINCT value FROM product_specifications";
                            $vResult = $conn->query($vSql);
                            while ($vRow = $vResult->fetch_assoc()) { ?>
                                <option value="<?php echo $vRow['value'] ?>">
                                    <?php
                            }
                            ?>
                        </datalist>
                        <div class="col-12 col-md-7">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                // $productId = $_GET['productId'];
                                $specificationRow = getProductSpecification($conn, $productId);
                                foreach ($specificationRow as $specificationRow) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="btn text-success fa fa-caret-up"
                                                onclick="editPriority('product_specifications','specification_id','<?php echo $specificationRow['specification_id'] ?>','minus')">
                                            </div>
                                            <div class="btn">
                                                <?php echo $specificationRow['priority'] ?>
                                            </div>
                                            <div class="btn text-danger fa fa-caret-down"
                                                onclick="editPriority('product_specifications','specification_id','<?php echo $specificationRow['specification_id'] ?>','plus')">
                                            </div>

                                        </td>
                                        <td>
                                            <?php echo $specificationRow['name'] ?>
                                        </td>
                                        <td>
                                            <?php echo $specificationRow['value'] ?>
                                        </td>
                                        <td>
                                            <div class="btn btn-danger"
                                                onclick="deleteSpecification(<?php echo $specificationRow['specification_id'] ?>)">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <script>
                    $('#addSpecificationForm').on('submit', function () {
                        event.preventDefault();
                        var productId = $('#addSpecificationForm #productId').val();
                        var name = $('#addSpecificationForm #name').val();
                        var value = $('#addSpecificationForm #value').val();
                        var priority = $('#addSpecificationForm #priority').val();
                        if (productId.trim() === '' || name.trim() === '' || value.trim() === '') {
                            swal('Please fill required details!');
                            return;
                        }
                        $.ajax({
                            type: 'POST',
                            url: 'action_specification',
                            data: {
                                action: 'add_specification',
                                priority: priority,
                                productId: productId,
                                name: name,
                                value: value
                            },
                            success: function (response) {
                                if (response.trim() === 'success') {
                                    swal({ title: "Specification added successfully!", icon: "success" }).then(function () {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("Failed to add Specification. Please try again." + response);
                                };
                            },
                            error: function () {
                                swal("An error occurred while adding product. Please try again later.").then(function () {
                                    window.location.reload();
                                });
                            }
                        });
                    });
                </script>
                <script>
                    function deleteSpecification(specificationId) {
                        var productId = <?php echo $_GET['productId'] ?>;
                        if (specificationId === '' || productId === '') {
                            swal('Please fill required details!');
                            return;
                        }
                        $.ajax({
                            type: 'POST',
                            url: 'action_specification',
                            data: {
                                action: 'delete_specification',
                                productId: productId,
                                specificationId: specificationId,
                            },
                            success: function (response) {
                                if (response.trim() === 'success') {
                                    swal({ title: "Specification Deleted successfully!", icon: "success" }).then(function () {
                                        window.location.reload();
                                    });
                                } else {
                                    swal("Failed to add Specification. Please try again." + response);
                                };
                            }
                        });
                    };
                </script>
            </div>
            <?php
        }
        ?>
        <table class="table table-bordered table-striped" id="itemTable" style="min-width:1300px">
            <thead class="bg-grey">
                <tr>
                    <th>Priority</th>
                    <th>
                        <div class="row">
                            <div class="col-3 text-center d-flex justify-content-end align-items-center"> Product Details
                            </div>
                            <input type="text" id="productDetailsSearch" placeholder="Search"
                                class="form-control form-control-md col" />
                    </th>
                    <!-- </div> -->
                    <th clas="text-center">Item Details </th>
                    <th>Action</th>
                </tr>
                <!-- <tr>
                    <th></th>
                    <th><input type="text" id="productDetailsSearch" class="form-control form-control-sm"></th>
                    <th><input type="text" id="itemDetailsSearch" class="form-control form-control-sm"></th>
                    <th></th>
                </tr> -->
            </thead>
            <tbody>
                <?php
                $itemDetails = getDetails($conn, "product_list.product_id = $productId ORDER BY item_list.priority");
                if ($itemDetails != null) {
                    // echo "<script>initiateDataTable()</script>";
                    foreach ($itemDetails as $row) {
                        ?>
                        <tr>
                            <td class="">
                                <div class="d-flex flex-column">

                                    <div class="btn text-success fa fa-caret-up"
                                        onclick="editPriority('item_list','item_id','<?php echo $row['item_id'] ?>','minus')">
                                    </div>
                                    <div class="btn">
                                        <?php echo $row['priority'] ?>
                                    </div>
                                    <div class="btn text-danger fa fa-caret-down"
                                        onclick="editPriority('item_list','item_id','<?php echo $row['item_id'] ?>','plus')">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-3 d-flex">
                                        <i class="fa fa-circle <?php if ($row['visible']) {
                                            echo "spinner-grow spinner-grow-sm text-green";
                                        } else {
                                            echo "text-red";
                                        } ?>"></i>
                                        <img class="w-100" src="../assets/item_images/<?php echo $row['item_images'][0]; ?>">
                                    </div>
                                    <div class="col-9">
                                        <div class="h3">
                                            <?php echo $row['category_name'] ?>
                                        </div>
                                        <div class="h5">
                                            <?php echo $row['product_name'];
                                            echo " (";
                                            if ($row['gender'] == "m") {
                                                echo "Male";
                                            } elseif ($row['gender'] == "f") {
                                                echo "Female";

                                            }
                                            echo ")" ?>
                                            <div>
                                                <code><?php echo $row['product_code'] ?></code><br>
                                                <div>
                                                    <?php echo $row['p_keywords'] ?>
                                                </div><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="h2 d-flex text-sec">
                                    <span class="text-pri text-decoration-line-through">
                                        <?php echo $row['mrp'] ?><br>
                                    </span>
                                    &nbsp;
                                    <?php echo $row['price'] ?><br>
                                </div>
                                <div class="h4">
                                    <b>Color : </b>
                                    <?php echo " <i class='text-light btn' style='background:" . $row['color_code'] . "'>" . $row['color_name'] . "</i>" ?>
                                    <br>
                                    <b>Size : </b>
                                    <?php echo $row['size_name'] . "(" . $row['size_code'] . ")" ?>
                                    <br>
                                    <b>Available : </b>
                                    <?php echo $row['stock'] ?>
                                </div>
                            </td>
                            <td class="w-25">
                                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal"
                                    onclick="prefillItemDetails('<?php echo $row['item_id'] ?>','<?php echo $row['size_id'] ?>',<?php echo $row['color_id'] ?>,<?php echo $row['priority'] ?>,<?php echo $row['mrp'] ?>,<?php echo $row['price'] ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </div>
                                <div class="btn btn-danger" onclick="deleteItem('<?php echo $row['item_id'] ?>')"><i
                                        class="fa fa-trash"></i> </div>
                                <?php if ($row['visible'] == 0) { ?>
                                    <div class="btn btn-success"
                                        onclick="editVisibility('Item_List','item_id','<?php echo $row['item_id'] ?>')"><i
                                            class="fa fa-eye"></i> Show</div>
                                <?php } else { ?>
                                    <div class="btn btn-danger"
                                        onclick="editVisibility('item_list','item_id','<?php echo $row['item_id'] ?>')">
                                        <i class="fa fa-eye-slash"></i> Hide
                                    </div>
                                <?php } ?>
                                <div class="pt-1">
                                    <div class="btn btn-primary"
                                        onclick="window.location=('manage_item?productId=<?php echo $row['item_id'] ?>&itemId=<?php echo $row['item_id'] ?>')">
                                        <i class="fa fa-image"></i>
                                    </div>
                                    <div class="btn btn-primary"
                                        onclick="window.location=('manage_stock?&itemId=<?php echo $row['item_id'] ?>')">
                                        <i class="fas fa-box-open"></i> Stock
                                    </div>
                                    <div class="btn btn-warning"
                                        onclick="window.location=('clone_item?itemId=<?php echo $row['item_id']; ?>')">
                                        <i class="fas fa-clone"></i>Clone
                                    </div>
                                </div>
                            </td>
                            </tr>
                            <?php
                    }
                } else {
                    echo "<tr><th colspan='4'><h2 class='text-center'>No Items Available</h2></th><tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Add Item Modal -->
    <div class="modal fade p-0 p-sm-5" id="addItemModal" tabindex="1" aria-labelledby="addItemModalLabel"
        styles="display:block !important;" aria-hidden="tru">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  bg-grey">
                <div class="modal-header">
                    <div class="modal-title w-100 text-center" id="addItemModalLabel">Add Item</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="categoryId">Select Category</label>
                                <select class="form-select" disabled id="categoryId" name="categoryId">
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    $categorySql = "SELECT * FROM category_list";
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
                            <div class="col">
                                <label for="productId">Select Product</label>
                                <select class="form-select" disabled id="productId" name="productId">
                                    <!-- <option value="0" disabled selected>Select Product</option> -->
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col">
                                <label for="colorId">Select Color</label>
                                <select id="colorId" class="form-control" value="">
                                    <option value="0" disabled selected>Select Size</option>
                                    <?php
                                    $colorList = getColorList($conn);
                                    if ($colorList != null) {
                                        foreach ($colorList as $colorRow) { ?>
                                            <option style="background-color:<?php echo $colorRow['color_code'] ?>"
                                                value="<?php echo $colorRow['color_id'] ?>">
                                                <?php echo $colorRow['color_name'] ?>(
                                                <?php echo $colorRow['color_code'] ?>)
                                            </option>
                                        <?php }
                                    } else {
                                        echo "<script>swal('Size List not fetched!')</script>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="sizeId">Select Size</label>
                                <select id="sizeId" class="form-control" value="">
                                    <option value="0" disabled selected>Select Size</option>
                                    <?php $sizeList = getSizeList($conn);
                                    if ($sizeList != null) {
                                        foreach ($sizeList as $sizeRow) { ?>
                                            <option value="<?php echo $sizeRow['size_id'] ?>">
                                                <?php echo $sizeRow['size_name'] ?>(
                                                <?php echo $sizeRow['size_code'] ?>)
                                            </option>
                                        <?php }
                                    } else {
                                        echo "<script>swal('Size List not fetched!')</script>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="priority" class="form-label">Priority :</label>
                                <input type="number" id="priority" value="0" class="form-control col-4">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="sellingPrice" class="form-label">Maximum Retail Price:</label>
                                <input type="number" id="sellingPrice" class="form-control col-4">
                            </div>
                            <div class="col">
                                <label for="offerPrice" class="form-label">Offer Price:</label>
                                <input type="number" id="offerPrice" class="form-control col-4">
                            </div>
                        </div>
                        <div>
                            <input type="hidden" id="itemId" value="">
                            <button type="button" class="btn btn-primary float-end " id="addItemButton">Add Item</button>
                            <button type="button" class="btn btn-primary float-end " id="updateItemButton">Update
                                Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#updateItemButton').on('click', function () {
                swal('OK');
                var itemId = $('#itemId').val();
                var sizeId = $('#sizeId').val();
                var colorId = $('#colorId').val();
                var priority = $('#priority').val();
                var sellingPrice = $('#sellingPrice').val();
                var offerPrice = $('#offerPrice').val();

                $.ajax({
                    url: 'action_items',
                    type: 'POST',
                    data: {
                        action: 'update_item',
                        itemId: itemId,
                        sizeId: sizeId,
                        colorId: colorId,
                        priority: priority,
                        sellingPrice: sellingPrice,
                        offerPrice: offerPrice
                    },
                    success: function (response) {
                        if (response == 'success') {
                            swal('Success', 'Item updated successfully!', 'success').then(function () {
                                location.reload()
                            });
                        } else {
                            swal('Error', response.message, 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        swal('Error', 'An error occurred while updating the item.', 'error');
                    }
                });
            });
        });
    </script>
    <script>
        function prefillItemDetails(itemId, sizeId, colorId, priority, sellingPrice, offerPrice) {
            $('#addItemModal #itemId').val(itemId);
            $('#addItemModal #sizeId').val(sizeId);
            $('#addItemModal #colorId').val(colorId);
            $('#addItemModal #priority').val(priority);
            $('#addItemModal #sellingPrice').val(sellingPrice);
            $('#addItemModal #offerPrice').val(offerPrice);

            $('#addItemButton').hide();
            $('#updateItemButton').show();
        }
    </script>
    <script>
        function initiateDataTable() {
            var table = $('#itemTable').DataTable({ bAutoWidth: false, stateSave: true });
            $('#productDetailsSearch').on('keyup', function () {
                table.columns(1).search(this.value).draw();
            });

            $('#itemDetailsSearch').on('keyup', function () {
                table.columns(2).search(this.value).draw();
            });
        };
    </script>

    <script>
        $('#addItemButton').on('click', function () {
            var categoryId = $('#addItemForm #categoryId').val();
            var productId = $('#addItemForm #productId').val();
            var colorId = $('#addItemForm #colorId').val();
            var sizeId = $('#addItemForm #sizeId').val();
            var sellingPrice = $('#addItemForm #sellingPrice').val();
            var offerPrice = $('#addItemForm #offerPrice').val();
            var priority = $('#addItemForm #priority').val();
            if (categoryId.trim() === null || productId.trim() === null || colorId.trim() === null || sizeId.trim() === null || sellingPrice.trim() === '' || offerPrice.trim() === '' || priority.trim() === '') {
                swal('Please fill required details!');
                return;
            }
            $.ajax({
                type: 'POST',
                url: 'action_items',
                data: {
                    action: 'add_item',
                    categoryId: categoryId,
                    productId: productId,
                    colorId: colorId,
                    sizeId: sizeId,
                    sellingPrice: sellingPrice,
                    offerPrice: offerPrice,
                    priority: priority
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        swal({ title: "Item added successfully!", icon: "success" }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        swal("Failed to add Item. Please try again.").then(function () {
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
        })
    </script>
    <script>
        function deleteItem(itemId) {
            swal({
                title: "Sure Delete This Item?",
                text: "This action cannot be undone.",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
            }).then((isConfirmed) => {
                if (isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'action_items',
                        data: {
                            action: 'delete_item',
                            itemId: itemId
                        },
                        success: function (response) {
                            if (response === 'success') {
                                swal({ icon: "success", title: "Item Deleted Successfull!" }).then(function () {
                                    window.location.reload();
                                });
                            } else if (response === 'data') {
                                swal({ icon: "info", title: "There are some content which depends on this Item!" })
                            } else {
                                swal({ icon: "error", title: " Error!" + response })
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
        $('#categoryId').change(function () {
            var categoryId = $(this).val();
            $.ajax({
                url: 'action_fetch_products',
                type: 'POST',
                data: { categoryId: categoryId },
                dataType: 'json',
                success: function (products) {
                    var productsDropdown = $('#addItemForm #productId');
                    productsDropdown.empty();
                    productsDropdown.append('<option value="" disabled selected>Select from ' + products.length + ' products!</option>');
                    if (products.length > 0) {
                        $.each(products, function (index, product) {
                            productsDropdown.append('<option value="' + product.productId + '">' + product.productName + '</option>');
                        });
                    } else {
                        productsDropdown.append('<option value="" disabled selected>No products available</option>');
                    }
                },
                error: function (error) {
                    swal('unable to fetch products');
                }
            });
        });
    </script>
    <script>
        categoryId = '<?php echo $_GET['categoryId'] ?>'
        productId = '<?php echo $_GET['productId'] ?>'
        if (categoryId && productId) {
            $('#categoryId').val(categoryId).change();
            setTimeout(function () {
                $('#addItemModal #productId').val(productId).change();
            }, 200);
        }
    </script>
    <?php include ('footer.php'); ?>
<?php
} else {
    header('location: login');
}

?>