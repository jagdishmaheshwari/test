<?php
function filterProducts($conn)
{
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('error' => 'Only POST requests are allowed'));
        return;
    }

    // Retrieve filter parameters from the POST request
    $color = isset($_POST['color']) ? $_POST['color'] : null;
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $price_min = isset($_POST['price_min']) ? $_POST['price_min'] : null;
    $price_max = isset($_POST['price_max']) ? $_POST['price_max'] : null;

    // Construct the SQL query based on the received filter parameters
    $query = "SELECT * FROM item_list WHERE 1=1"; // Start with a base query

    if (!empty($color)) {
        $color = implode("','", $color);
        $query .= " AND color IN ('$color')";
    }

    if (!empty($size)) {
        $size = implode("','", $size);
        $query .= " AND size IN ('$size')";
    }

    if (!empty($price_min)) {
        $query .= " AND price >= $price_min";
    }

    if (!empty($price_max)) {
        $query .= " AND price <= $price_max";
    }

    $result = $conn->query($query);

    // Check for errors
    if (!$result) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Internal server error'));
        return;
    }

    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}?>