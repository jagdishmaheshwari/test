<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');
    include('../validator.php');

    // @$_POST['categoryName'] = 'aacass';
    // @$_POST['description'] = 'asdsad';
    // @$_POST['categoryId'] = 1;
    // @$_POST['action'] = 'delete_category';
    //    ----------------------------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'add_category') {
        $categoryName = filterInput($_POST["categoryName"]);
        $categoryDescription = filterInput($_POST["description"]);
        $sql = "INSERT INTO category_list (category_name, description) VALUES ('$categoryName', '$categoryDescription')";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update_category') {
        $categoryId = filterInput($_POST["categoryId"]);
        $categoryName = filterInput($_POST["categoryName"]);
        $categoryDescription = filterInput($_POST["description"]);
        $sql = "UPDATE category_list  SET category_name = '$categoryName',  description = '$categoryDescription' WHERE category_id = '$categoryId'";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete_category') {
        $category_id = $_POST['categoryId'];
        $productQuery = "SELECT COUNT(*) as count FROM product_list WHERE category_id = $category_id";
        $productResult = $conn->query($productQuery);
        if ($productResult) {
            $productCount = $productResult->fetch_assoc()['count'];
            if ($productCount == 0) {
                // No products, proceed with deletion
                $deleteQuery = "DELETE FROM category_list WHERE category_id = $category_id";
                $deleteResult = $conn->query($deleteQuery);
                if ($deleteResult) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                // Products are associated with this category
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