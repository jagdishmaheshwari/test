<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('../conn.php');
    include ('../validator.php');
    // include ('../assets/public_function.php');
    include ('header.php');


    $conn->begin_transaction();
    $itemId = $_GET['itemId'];
    $itemDetails = getDetails($conn, itemId: $itemId)[0];
    $categoryId = $itemDetails['category_id'];
    $productId = $itemDetails['product_id'];
    $colorId = $itemDetails['color_id'];
    $sizeId = $itemDetails['size_id'];
    $sellingPrice = $itemDetails['mrp'];
    $offerPrice = $itemDetails['price'];
    $priority = $itemDetails['priority'];
    $sql = "INSERT INTO item_list (category_id, product_id, color_id, size_id, mrp, price, priority) VALUES ('$categoryId', '$productId', '$colorId', '$sizeId', '$sellingPrice', '$offerPrice', '$priority')";
    $result = $conn->query($sql);

    if ($result) {
        // If item insertion is successful, fetch the last inserted item_id
        $insertedItemId = $conn->insert_id;
        $imageValues = [];
        $imageArray = $itemDetails['item_images'];

        foreach ($imageArray as $image) {
            $imageValues[] = "($insertedItemId, '$image')";
        }

        $imageValuesString = implode(", ", $imageValues);
        $imageResult = true;

        if ($imageValuesString != null) {
            $imageSql = "INSERT INTO item_images (item_id, image_url) VALUES $imageValuesString";
            $imageResult = $conn->query($imageSql);
        } else {

        }
        if ($imageResult) {
            $conn->commit();
            echo "<script>swal({icon:'success',title:'Clone Created Sucessfull!'}).then(function(){location.replace('manage_item?itemId=" . $insertedItemId . "')})</script>";
        } else {
            $conn->rollback();
            echo "<script>swal({icon:'error',title:'Failed to Clone!'}).then(function(){window.history.go(-1)})</script>";
        }
    } else {
        $conn->rollback();
        echo "<script>swal({icon:'error',title:'Something went wrong!'})</script>";
    }

} else {
    header('location: login');
}

?>