<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $category_id = $_POST['category_id'];

        $productQuery = "SELECT COUNT(*) as count FROM products WHERE category_id = $category_id";
        $productResult = $conn->query($productQuery);

        if ($productResult) {
            $productCount = $productResult->fetch_assoc()['count'];

            if ($productCount == 0) {
                // No products, proceed with deletion
                $deleteQuery = "DELETE FROM product_category WHERE category_id = $category_id";
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


} else {
    header('location: login');
}