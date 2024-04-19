<?php
include('../conn.php');
include('../validator.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get standard and subject ID from the request
    $categoryId = filterInput($_POST["categoryId"]);

    $sql = "SELECT * FROM product_list WHERE category_id = '$categoryId'";
    $result = $conn->query($sql);

    $products = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = array(
                'productId' => $row['product_id'],
                'productName' => $row['product_name'],
            );
        }
    }

    // Return the products as JSON
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Invalid request method'));
}

?>