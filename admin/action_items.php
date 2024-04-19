<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('../conn.php');
    include ('../validator.php');

    // @$_POST['productName'] = 'aacass';
    // @$_POST['description'] = 'asdsad';
    // @$_POST['productId'] = 1;
    // @$_POST['action'] = 'delete_product';
    //    ----------------------------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'add_item') {
        $categoryId = filterInput($_POST["categoryId"]);
        $productId = filterInput($_POST["productId"]);
        $colorId = filterInput($_POST["colorId"]);
        $sizeId = filterInput($_POST["sizeId"]);
        $sellingPrice = filterInput($_POST["sellingPrice"]);
        $offerPrice = filterInput($_POST["offerPrice"]);
        $priority = filterInput($_POST["priority"]);

        $sql = "INSERT INTO item_list (category_id, product_id , color_id , size_id, mrp, price, priority) VALUES ('$categoryId', '$productId', '$colorId', '$sizeId', '$sellingPrice', '$offerPrice', '$priority')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update_item') {
        $itemId = $_POST["itemId"];
        $sizeId = $_POST["sizeId"];
        $colorId = $_POST["colorId"];
        $priority = $_POST["priority"];
        $sellingPrice = $_POST["sellingPrice"];
        $offerPrice = $_POST["offerPrice"];
        $sql = "UPDATE item_list 
            SET size_id = '$sizeId', color_id = '$colorId', priority = '$priority', mrp = '$sellingPrice', price = '$offerPrice'
            WHERE item_id = '$itemId'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete_item') {
        $item_id = $_POST['itemId'];
        $imageQuery = "SELECT COUNT(*) as count FROM item_images WHERE item_id = $item_id";
        $imageResult = $conn->query($imageQuery);
        if ($imageResult) {
            $imageCount = $imageResult->fetch_assoc()['count'];
            if ($imageCount == 0) {
                $deleteQuery = "DELETE FROM item_list WHERE item_id = $item_id";
                $deleteResult = $conn->query($deleteQuery);
                if ($deleteResult) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                echo "data";
            }
        } else {
            echo "error";
        }
    }

    // ---------------------------------------------------------------------------------
} else {
    header('location: login');
}
?>