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
        $gender = filterInput($_POST["gender"]);
        $keywords = filterInput($_POST["keywords"]);

        $sql = "INSERT INTO product_list (category_id, product_code , product_name , description, gender, keywords, visible, priority) VALUES ('$categoryId', '$productCode', '$productName', '$description', '$gender', '$keywords', '$visible', '$priority')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update_product') {
        $productId = filterInput($_POST["productId"]);
        $categoryId = filterInput($_POST["categoryId"]);
        $productCode = filterInput($_POST["productCode"]);
        $productName = filterInput($_POST["productName"]);
        $description = filterInput($_POST["description"]);
        $priority = filterInput($_POST["priority"]);
        $gender = filterInput($_POST["gender"]);
        $keywords = filterInput($_POST["keywords"]);
        $visible = filterInput($_POST["visible"]);
        $sql = "UPDATE product_list  SET category_id ='$categoryId', product_code = '$productCode',   product_name = '$productName',  description = '$description', priority = '$priority', keywords = '$keywords', gender='$gender', visible = '$visible' WHERE product_id = '$productId'";
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