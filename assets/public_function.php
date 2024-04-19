<?php
// function getDetails($conn, $categoryCondition = "", $productsCondition = "", $itemCondition = "", $itemCondition = "", $itemId = "")
// {
//     $details = [];
//     $categoryCondition = $categoryCondition !== "" ? "WHERE $categoryCondition" : "";
//     $categorySql = "SELECT category_id FROM category_list $categoryCondition";
//     $categoryResult = $conn->query($categorySql);
//     while ($categoryList = $categoryResult->fetch_assoc()) {
//         $categoryId = $categoryList['category_id'];
//         $productsCondition = $productsCondition !== "" ? " AND $productsCondition" : "";
//         $productSql = "SELECT product_id FROM product_list WHERE category_id = $categoryId $productsCondition";
//         $productResult = $conn->query($productSql);
//         // $productResult = mysqli_query($conn,$productSql);

//         if ($productResult && $productResult->num_rows > 0) {
//             while ($productList = $productResult->fetch_assoc()) {
//                 $productId = $productList['product_id'];
//                 $itemCondition = $itemCondition !== "" ? "AND $itemCondition" : "";
//                 $itemsSql = "SELECT item_list.*, product_list.description AS p_description, category_list.description AS c_description, category_list.category_name, product_list.product_name, color_list.color_code, color_list.color_name
//                              FROM item_list
//                              LEFT JOIN category_list ON item_list.category_id = category_list.category_id
//                              LEFT JOIN product_list ON item_list.product_id = product_list.product_id
//                              LEFT JOIN color_list ON item_list.color_id = color_list.color_id
//                              LEFT JOIN size_list ON item_list.size_id = size_list.size_id 
//                              WHERE product_list.product_id = $productId $itemCondition";
//                 $itemResult = $conn->query($itemsSql);

//                 if ($itemResult && $itemResult->num_rows > 0) {
//                     while ($row = $itemResult->fetch_assoc()) {
//                         // Fetch item images for each item
//                         $row['item_images'] = getItemImages($conn, $row['item_id']);
//                         $details[] = $row;
//                     }
//                 }
//             }
//         }
//     }

//     return $details;
// }
function getDetails($conn, $itemCondition = "", $itemId = "")
{
    // $categoryCondition = $categoryCondition !== "" ? "WHERE $categoryCondition" : "";
    // $categorySql = "SELECT category_id FROM category_list $categoryCondition";
    // $categoryResult = $conn->query($categorySql);

    // if ($categoryResult->num_rows > 0) {
    $details = [];
    //     while ($categoryList = $categoryResult->fetch_assoc()) {
    //         $categoryId = $categoryList['category_id'];

    //         // Construct product SQL query with condition
    //         $productSql = "SELECT product_id FROM product_list WHERE category_id = $categoryId";
    //         if (!empty ($productsCondition)) {
    //             $productSql .= " AND $productsCondition";
    //         }
    //         $productResult = $conn->query($productSql);

    //         if ($productResult->num_rows > 0) {
    //             while ($productList = $productResult->fetch_assoc()) {
    //                 $productId = $productList['product_id'];
    // $itemId = $itemId !== "" ? "AND item_id = '$itemId'" : "";
    $itemsSql = "SELECT item_list.*, product_list.description AS p_description, category_list.description AS c_description, category_list.category_name, product_list.product_name, product_list.product_code, product_list.gender, color_list.color_code, color_list.color_name, size_list.size_name, size_list.size_code, product_list.priority AS p_priority, product_list.visible AS p_visible,     product_list.keywords AS p_keywords,    COALESCE(stock.total_quantity, 0) AS stock FROM 
    item_list
LEFT JOIN 
    category_list ON item_list.category_id = category_list.category_id
LEFT JOIN 
    product_list ON item_list.product_id = product_list.product_id
LEFT JOIN 
    color_list ON item_list.color_id = color_list.color_id
LEFT JOIN 
    size_list ON item_list.size_id = size_list.size_id
LEFT JOIN 
 (SELECT item_id, SUM(quantity) AS total_quantity FROM stock GROUP BY item_id) AS stock ON item_list.item_id = stock.item_id WHERE 1=1 ";
    if (!isset($_SESSION['AdminID'])) {
        $itemsSql .= ' AND item_list.visible = 1';
    }
    if (!empty($itemId)) {
        $itemsSql .= " AND item_list.item_id = '$itemId'";
    }
    if (!empty($itemCondition)) {
        $itemsSql .= " AND $itemCondition";
    }
    // prd($itemsSql);
    $result = $conn->query($itemsSql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['item_images'] = getItemImages($conn, $row['item_id']);
            $details[] = $row;
        }
        $result->free_result();
        return $details;
    } else {
        return false;
    }
}
//             }
//         }

//         /////////////////////////////////////   WELL WORKING FUNCTION \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//     }
// }
// function getDetails($conn, $categoryCondition = "", $productsCondition = "", $itemCondition = "", $itemCondition = "", $itemId = "")
// {
//     // if (isset ($categoryCondition)) {
//         $categoryCondition = $categoryCondition !== "" ? "WHERE $categoryCondition" : "";
//         $categorySql = "SELECT category_id FROM category_list $categoryCondition";
//         if ($conn->query($categorySql)->num_rows > 0) {
//             $details = [];
//             while ($categoryList = $conn->query($categorySql)->fetch_assoc()) {
//                 $categoryId = $categoryList['category_id'];
//                 $productsCondition = $productsCondition !== "" ? "AND $productsCondition" : "";
//                 $productSql = "SELECT product_id FROM product_list  LEFT JOIN category_list ON product_list.category_id = category_list.category_id  WHERE product_list.category_id = $categoryId $productsCondition";
//                 if ($conn->query($productSql)->num_rows > 0) {
//                     while ($productList = $conn->query($productSql)->fetch_assoc()) {
//                         $productId = $productList['product_id'];
//                         $itemCondition = $itemCondition !== "" ? "AND $itemCondition" : "";
//                         $itemsSql = "SELECT item_id FROM item_list LEFT JOIN product_list ON product_list.product_id = item_list.product_id WHERE product_list.product_id = $productId $itemCondition";
//                         if ($conn->query($itemsSql)->num_rows > 0 && isset ($itemId)) {
//                             while ($itemList = $conn->query($itemsSql)->fetch_assoc()) {
//                                 $itemId = $itemList['item_id'];
//                                 $itemCondition = $itemCondition !== "" ? "AND $itemCondition" : "";
//                                 $itemId = $itemId !== "" ? "WHERE item_id = $itemId" : "";
//                                 $itemSql = "SELECT item_list.*, product_list.description AS p_description, category_list.description AS c_description,  category_list.category_name, product_list.product_name, color_list.color_code, color_list.color_name
//                                 FROM item_list
//                                 LEFT JOIN category_list ON item_list.category_id = category_list.category_id
//                                 LEFT JOIN product_list ON item_list.product_id = product_list.product_id
//                                 LEFT JOIN color_list ON item_list.color_id = color_list.color_id
//                                 LEFT JOIN size_list ON item_list.size_id = size_list.size_id 
//                                 $itemId $itemCondition";
//                                 $result = $conn->query($itemSql);
//                                 if ($result) {
//                                     $details = [];
//                                     while ($row = $result->fetch_assoc()) {
//                                         // Fetch item images for each item
//                                         $row['item_images'] = getItemImages($conn, $row['item_id']);
//                                         $details[] = $row;
//                                     }
//                                     // $result->free_result();
//                                 } else {
//                                     return false;
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }
//             return $details;
//         // }
//     }
// }

function getProductSpecification($conn, $productId)
{
    $productId = filterInput($productId);
    $sql = "SELECT * FROM product_specifications WHERE product_id = $productId ORDER BY priority";
    $result = $conn->query($sql);
    if ($result) {
        return $result;
    }
}


function getItemImages($conn, $itemId)
{
    $itemId = $conn->real_escape_string($itemId);

    $sql = "SELECT image_url FROM item_images WHERE item_id = $itemId ORDER BY priority ASC";
    $result = $conn->query($sql);

    if ($result) {
        $itemImages = [];
        while ($row = $result->fetch_assoc()) {
            $itemImages[] = $row['image_url'];
        }
        $result->free_result();

        return $itemImages;
    } else {
        // Handle query error
        return false;
    }
}

function getItemDetails($conn, $itemId, $itemCondition = "")
{
    $itemId = $conn->real_escape_string($itemId);
    $itemCondition = $itemCondition !== "" ? "AND $itemCondition" : "";
    $sql = "SELECT item_list.*, product_list.description AS p_description, category_list.description AS c_description,  category_list.category_name, product_list.product_name, color_list.color_code, color_list.color_name
            FROM item_list
            LEFT JOIN category_list ON item_list.category_id = category_list.category_id
            LEFT JOIN product_list ON item_list.product_id = product_list.product_id
            LEFT JOIN color_list ON item_list.color_id = color_list.color_id
            LEFT JOIN size_list ON item_list.size_id = size_list.size_id 
            WHERE item_id = $itemId $itemCondition";
    $result = $conn->query($sql);

    if ($result) {
        $itemDetails = $result->fetch_assoc();
        $result->free_result();
        $itemDetails['item_images'] = getItemImages($conn, $itemId);

        return $itemDetails;
    } else {
        return false;
    }
}

function getProductList($conn, $productsCondition = "")
{
    $productsCondition = $productsCondition !== "" ? "WHERE $productsCondition" : "";
    $sql = "SELECT product_list.*, item_list.item_id, category_list.description AS c_description,  category_list.category_name, product_list.product_name, product_list.keywords, product_list.product_code, product_list.gender, color_list.color_code, color_list.color_name
            FROM item_list
            RIGHT JOIN product_list ON item_list.product_id = product_list.product_id
            LEFT JOIN category_list ON item_list.category_id = category_list.category_id
            LEFT JOIN color_list ON item_list.color_id = color_list.color_id
            LEFT JOIN size_list ON item_list.size_id = size_list.size_id 
            $productsCondition";
    $result = $conn->query($sql);

    $productDetails = [];
    while ($row = $result->fetch_assoc()) {
        // Check if there are item details available
        if ($row['item_id'] !== null) {
            $itemId = $row['item_id'];
            $row['item_images'] = getItemImages($conn, $itemId);
        } else {
            // No items associated, set item_images to empty array
            $row['item_images'] = [];
        }
        $productDetails[] = $row;
    }
    return $productDetails;
}
// function getProductList($conn, $productsCondition = "")
// {
//     $productsCondition = $productsCondition !== "" ? "WHERE $productsCondition" : "";
//     $sql = "SELECT product_id FROM product_list 
//     LEFT JOIN category_list ON product_list.category_id = product_list.category_id
//     $productsCondition";
//     $result = $conn->query($sql);
//     if ($result) {
//         $productList = array();
//         while ($row = $result->fetch_assoc()) {
//             $productList[] = $row;
//         }
//         $result->free_result();
//         return $productList;
//     } else {
//         return false;
//     }
// }
function getSizeList($conn)
{
    $sql = "SELECT * FROM size_list";
    $result = $conn->query($sql);
    return $result;
}
function getColorList($conn)
{
    $sql = "SELECT * FROM color_list";
    $result = $conn->query($sql);
    return $result;
}
function getCategoryList($conn, $categoryCondition = "")
{
    $categoryCondition = $categoryCondition !== "" ? "WHERE $categoryCondition" : "";
    $sql = "SELECT category_id FROM category_list
    $categoryCondition";
    $result = $conn->query($sql);
    if ($result) {
        $categoryList = array();
        while ($row = $result->fetch_assoc()) {
            $categoryList[] = $row;
        }
        $result->free_result();
        return $categoryList;
    } else {
        return false;
    }
}
// include('../conn.php');
// print_r(getItemList($conn, filterCondition: "1=1 AND visible = 1 ORDER BY item_list.priority LIMIT 1"));
?>




<!-- 



function getDetails($conn, $categoryCondition = "", $productsCondition = "", $itemCondition = "", $itemId = "")
{
    $categoryCondition = $categoryCondition !== "" ? "WHERE $categoryCondition" : "";
    $categorySql = "SELECT category_id FROM category_list $categoryCondition";
    $categoryResult = $conn->query($categorySql);

    if ($categoryResult->num_rows > 0) {
        $details = [];
        while ($categoryList = $categoryResult->fetch_assoc()) {
            $categoryId = $categoryList['category_id'];

            // Construct product SQL query with condition
            $productSql = "SELECT product_id FROM product_list WHERE category_id = $categoryId";
            if (!empty ($productsCondition)) {
                $productSql .= " AND $productsCondition";
            }
            $productResult = $conn->query($productSql);

            if ($productResult->num_rows > 0) {
                while ($productList = $productResult->fetch_assoc()) {
                    $productId = $productList['product_id'];
                    // $itemId = $itemId !== "" ? "AND item_id = '$itemId'" : "";
                    $itemsSql = "SELECT item_list.*, product_list.description AS p_description, category_list.description AS c_description, category_list.category_name, product_list.product_name,product_list.product_code, product_list.gender, color_list.color_code, color_list.color_name, size_list.size_name, size_list.size_code, product_list.priority AS p_priority, product_list.visible AS p_visible, product_list.keywords AS p_keywords
                            FROM item_list
                            LEFT JOIN category_list ON item_list.category_id = category_list.category_id
                            LEFT JOIN product_list ON item_list.product_id = product_list.product_id
                            LEFT JOIN color_list ON item_list.color_id = color_list.color_id
                            LEFT JOIN size_list ON item_list.size_id = size_list.size_id WHERE item_list.product_id = $productId ";
                    if (!empty ($itemId)) {
                        $itemsSql .= " AND item_id = $itemId";
                    }
                    if (!empty ($itemCondition)) {
                        $itemsSql .= " AND $itemCondition";
                    }
                    // echo "<pre>";
                    // echo $itemsSql;
                    // echo "</pre>";

                    $result = $conn->query($itemsSql);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            // Fetch item images for each item
                            $row['item_images'] = getItemImages($conn, $row['item_id']);
                            $details[] = $row;
                        }
                        $result->free_result();
                    } else {
                        return false;
                    }
                }
            }
        }

        return $details;
        /////////////////////////////////////   WELL WORKING FUNCTION \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    }
}
 -->
<?php
// Assuming $conn is the database connection object

// Function to get the visitor's IP address
function getVisitorIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function logVisitor($conn, $item_id)
{
    $ip_address = getVisitorIP();

    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM logs_visitors WHERE item_id = ? AND ip_address = ? AND DATE(visit_timestamp) = ?");
    $stmt->bind_param("iss", $item_id, $ip_address, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    if ($count == 0) {
        $insertStmt = $conn->prepare("INSERT INTO logs_visitors (item_id, ip_address) VALUES (?, ?)");
        $insertStmt->bind_param("is", $item_id, $ip_address);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $stmt->close();
}

if (!function_exists('prd')) {
    function prd($a)
    {
        echo "<pre>";
        if (is_array($a)) {
            print_r($a);
        } else {
            echo $a;
        }
        echo "</pre>";
        die();
    }
}



?>
