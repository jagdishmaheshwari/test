<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('header.php');
    include ('../conn.php');
    ?>
    <div class="container-fluid mt-5">
        <?php
        if (isset ($_GET['itemId']) & $_GET['itemId'] != null) {
            $itemId = $_GET['itemId'];
            // $sql = "SELECT item_list.*,category_list.description AS c_description, product_list.description AS p_description, category_list.category_name, product_list.product_name, product_list.product_name, color_list.color_code, color_list.color_name
            // FROM item_list
            // LEFT JOIN category_list ON item_list.category_id = category_list.category_id
            // LEFT JOIN product_list ON item_list.product_id = product_list.product_id
            // LEFT JOIN color_list ON item_list.color_id = color_list.color_id
            // LEFT JOIN size_list ON item_list.size_id = size_list.size_id
            // WHERE item_id = '$itemId'";
            // $result = $conn->query($sql);
            $row = getDetails($conn, $itemId)[0];
            // print_r($row);
            if ($row != null) {
                ?>
                <div class="row">
                    <div class="col-lg-8 col-12 px-5">
                        <div class="text-center display-6 c-pointer" style="font-family:math"><span
                                onclick="location=('manage_products?categoryId=<?php echo $row['category_id'] ?>')">
                                <?php echo $row['category_name'] ?>
                            </span><i class='fa fa-angle-right'></i> <span
                                onclick="location='manage_items?productId=<?php echo $row['product_id'] ?>'">
                                <?php echo $row['product_name'] ?>
                            </span>
                        </div>
                        <div class="h5">
                            <b>Description : </b>
                            <?php echo $row['p_description'] ?>
                        </div>
                        <hr>
                        <div class="h4">
                            <span><b>Original Price : </b>
                                <?php echo $row['mrp']; ?>
                            </span>
                            <span><b>Offer Price : </b>
                                <?php echo $row['price']; ?>
                            </span>
                            <br>
                            <span><b>Color : </b>
                                <?php echo $row['color_name'] ?>
                            </span>
                            <div class="btn" style="heigth:20px;background:<?php echo $row['color_code'] ?>">Color Preview</div>
                        </div>
                        <style>
                            .file-input-container>label,
                            .image-container {
                                background: var(--acc);
                                color: #fff;
                                border-radius: 10px;
                                padding: 10px;
                                min-width: 120px;
                                min-height: 90%;
                                cursor: pointer;
                                margin: 10px 10px 40px;
                            }
                        </style>
                        <div>
                            <div class="d-flex flex-wrap">
                                <?php
                                $imageSql = "SELECT * FROM item_images WHERE item_id = " . $itemId . " ORDER BY priority";
                                $imageResult = $conn->query($imageSql);
                                while ($imageRow = $imageResult->fetch_assoc()) {
                                    ?>
                                    <div class="image-container" style="max-width:140px; position: relative;">
                                        <img src="../assets/item_images/<?php echo $imageRow['image_url'] ?>" class="w-100" alt="">
                                        <div class="btns w-100 text-center"
                                            style="position:absolute;bottom:0;left: 50%; transform: translate(-50%, 55%);">
                                            <div class="">
                                                <div class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></div>
                                                <div class="btn btn-danger btn-sm"
                                                    onclick="window.location=('action_delete_item_image?imageUrl=<?php echo $imageRow['image_url'] ?>&itemId=<?php echo $imageRow['item_id'] ?>')">
                                                    <i class="fa fa-trash"></i>
                                                </div>
                                            </div>
                                            <div class=" d-flex justify-content-center">
                                                <div class="btn btn-secondary"
                                                    onclick="editPriority('item_images','image_id','<?php echo $imageRow['image_id'] ?>','minus')">
                                                    <i class="fa fa-angle-left"></i>
                                                </div>
                                                <div class="btn btn-light">
                                                    <?php echo $imageRow['priority']; ?>
                                                </div>
                                                <div class="btn btn-secondary"
                                                    onclick="editPriority('item_images','image_id','<?php echo $imageRow['image_id'] ?>','plus')">
                                                    <i class="fa fa-angle-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($imageResult->num_rows < 7) {
                                    ?>
                                    <form id="imageForm" method="POST" class="d-flex" action="action_upload_item_image"
                                        enctype="multipart/form-data">
                                        <div class="file-input-container">
                                            <label
                                                class="d-flex opacity-75 align-items-center justify-content-center flex-column text-center "
                                                for="imageInput">
                                                <i class="fa fa-upload" style="font-size:40px"></i>
                                                <h3>Upload<br>Image</h3>
                                            </label>
                                            <input type="file" onchange="$('#imageForm').submit()" id="imageInput" class="d-none"
                                                name="image" accept="image/*" required>
                                            <input type="hidden" name="itemId" value="<?php echo $itemId ?>">
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <h2 class="text-center">Preview <a href="../index" target="_blank" class="btn btn-primary"><i
                                    class="fa fa-share"></i> Visit</a></h2>
                        <div class="card p-3" style="background: <?php echo $row['color_code'] ?>">
                            <iframe src="../index" frameborder="0" style="aspect-ratio:1/1.8;"
                                class="border border-light border-5 rounded"></iframe>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<script>swal({ icon:'error', title: 'Item Id Not Found!' }).then(function () { window.history.go(-1) });</script>";
        }
        ?>
    </div>
    <?php include ('footer.php'); ?>

    <?php
} else {
    header('location: login');
}

?>