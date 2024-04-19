<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');
    include('../validator.php');

    // @$_POST['productName'] = 'aacass';
    // @$_POST['description'] = 'asdsad';
    // @$_POST['productId'] = 1;
    // @$_POST['action'] = 'delete_product';
    //    ----------------------------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'add_product') {
        $categoryId = filterInput($_POST["categoryId"]);
        $productCode = filterInput($_POST["productCode"]);
        $productName = filterInput($_POST["productName"]);
        $description = filterInput($_POST["description"]);
        $visible = filterInput($_POST["visible"]);
        $priority = filterInput($_POST["priority"]);
        $sql = "INSERT INTO product_list (category_id, product_code , product_name , description, visible, priority) VALUES ('$categoryId', '$productCode', '$productName', '$description', '$visible', '$priority')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'reply_query') {
        $queryId = filterInput($_POST["queryId"]);
        $response = filterInput($_POST["response"]);
        $sql = "UPDATE contact_queries  SET response ='$response', status = 1 WHERE query_id = '$queryId'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete_product') {
        $product_id = $_POST['productId'];
        $productQuery = "SELECT COUNT(*) as count FROM item_list WHERE product_id = $product_id";
        $productResult = $conn->query($productQuery);
        if ($productResult) {
            $productCount = $productResult->fetch_assoc()['count'];
            if ($productCount == 0) {
                $deleteQuery = "DELETE FROM product_list WHERE product_id = $product_id";
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
            // Error in the product query
            echo "error";
        }
    }

    // ---------------------------------------------------------------------------------
} else {
    header('location: login');
}
?>