<?php

// Get the URL parameter from the rewritten URL
$url = isset ($_GET['url']) ? $_GET['url'] : '';

// Split the URL into parts based on '/'
$parts = explode('/', $url);

// Extract the category and product information
// $category = isset ($parts[0]) ? $parts[0] : '';
// $product = isset ($parts[1]) ? $parts[1] : '';

// Include the appropriate page based on the URL structure
if (!empty ($category) && !empty ($product)) {
    // Both category and product are present, show product page
    include ('');
} elseif (!empty ($category)) {
    // Only category is present, show category page
    // include ('explore_category.php');
} else {
    include ('homepage.php');
}
?>
