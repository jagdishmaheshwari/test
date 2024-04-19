<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('header.php');
    include ('../conn.php');
    ?>
    <div class="container mt-5 overflow-scroll">
        <div>
            <h1 class="text-center">Manage Stock</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Image</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $itemCondition = "";
                    $itemId = @$_GET['itemId'];
                    if (isset ($itemId)) {
                        $itemCondition .= 'item_list.item_id = ' . $itemId;
                    }
                    $items = getDetails($conn, $itemCondition);
                    foreach ($items as $item) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $item['item_id'] ?>
                            </td>
                            <td>
                                <img src="../assets/item_images/<?php echo @$item['item_images'][0] ?>" style="width:100px"
                                    alt="">
                            </td>
                            <td>
                                <?php echo $item['product_name'] ?><br>
                                <?php echo $item['category_name'] ?><br>
                                <?php echo $item['p_description'] ?><br>
                                Available :
                                <?php echo $item['stock'] ?><br>
                            </td>
                            <td>
                                <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStockModal"
                                    onclick="stockPreview('../assets/item_images/<?php echo @$item['item_images'][0] ?>', '<?php echo $item['category_name'] ?>', '<?php echo $item['product_name'] ?>', '<?php echo $item['price'] ?>', '<?php echo $item['mrp'] ?>', '<?php echo $item['size_name'] . '(' . $item['size_code'] . ')' ?>', '<?php echo $item['color_code'] ?>',<?php echo $item['item_id'] ?>);$('.openbtn').click();">
                                    <i class="fa fa-plus"></i> ADD
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Add Stock Modal -->
        <div class="modal fade" id="addStockModal" aria-labelledby="addStockModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <h5 class="modal-title" id="addStockModalLabel">Add Stock for item id <span class="itemId"></span>
                        </h5>
                        <div class="btn " data-bs-dismiss="modal" aria-label="Close">
                            <span class="fa fa-close"></span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form id="addStockForm">
                            <div id="itemPreviewContent">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="src/img/logo.png" id="itemImage" class="w-100" alt="">
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="h1 text-pri"><span id="categoryName">Category Name</span></div>
                                        <div class="h3 text-sec"><span id="productName">Product Name</span></div>
                                        <div class="h2">
                                            <div class="text-pri">Price : <span id="price" class="text-sec">000</span>
                                                <span class="text-decoration-line-through text-acc" id="mrp">0000</span>
                                            </div>
                                        </div>
                                        <label class="form-control bg-pri" id="color">COLOR</label>
                                        <div class="h1">Size : <span id="sizeName"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stockLocation">Location</label>
                                <select class="form-control border border-success" id="stockLocation" name="stockLocation" required>
                                    <option value="">Select Location</option>
                                    <option value="Naranpar">Naranpar</option>
                                    <option value="Bhuj">Bhuj</option>
                                    <option value="Bhujodi">Bhujodi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" min="1" class="form-control border border-success" id="quantity" name="quantity" placeholder="Enter quantity" required>
                            </div>
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea id="remark" class="form-control border-2 border-warning" ></textarea>
                            </div>
                            <input type="hidden" value="" id="itemId">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addStockBtn">Add Stock</button>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------- MODAL END------------------------------------------------->
    <script>
        function stockPreview(image, categoryName, productName, price, mrp, sizeName, color, itemId) {
            $('#itemPreviewContent #itemImage:first').attr('src', image);
            $('#categoryName').text(categoryName);
            // $('#itemImage').src(image);
            $('#productName').text(productName);
            $('#price').text(price);
            $('#mrp').text(mrp);
            $('.itemId').text(itemId);
            $('#itemId').val(itemId);
            // $('#color').text(color);
            $('#sizeName').text(sizeName);
            $('#color').css('background', color);
        }
    </script>
    <script>
        $('#addStockBtn').on('click', function () {
            itemId = $('#itemId').val();
            stockLocation = $('#stockLocation').val();
            quantity = $('#quantity').val();
            var remark = $('#remark').val();
            $.ajax({
                url: 'action_stock',
                type: 'POST',
                data: {
                    action: 'add_stock',
                    itemId: itemId,
                    remark: remark,
                    stockLocation: stockLocation,
                    quantity: quantity
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        swal({ icon: 'success', title: 'Stock added successfully!' }).then(function () {
                            location.reload();
                        });
                    } else {
                        swal({ icon: 'info', title: response['error'] });
                    }
                }
            });
        })
    </script>
</div>
<?php include ('footer.php'); ?>
<?php
} else {
    header('location: login');
}

?>