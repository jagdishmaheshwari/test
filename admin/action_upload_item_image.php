<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('../conn.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset ($_FILES['image']) && !empty ($_FILES['image']['name'])) {
            $itemId = $_POST['itemId'];
            $sql = "SELECT item_list.*, product_list.product_code, product_list.product_name, color_list.color_name, category_list.category_name
            FROM item_list
            LEFT JOIN category_list ON item_list.category_id = category_list.category_id
            LEFT JOIN product_list ON item_list.product_id = product_list.product_id
            LEFT JOIN color_list ON item_list.color_id = color_list.color_id
            LEFT JOIN size_list ON item_list.size_id = size_list.size_id
            WHERE item_id = '$itemId'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $targetDirectory = '../assets/item_images/';
            $filename = $row['product_code'] . '-' . sha1($row['item_id']) . '_' . date('Ymdhis') . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $targetPath = $targetDirectory . $filename;
            $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
            $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($imageFileType, $allowedExtensions)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imageSql = "INSERT INTO item_images(item_id, image_url) VALUES($itemId, '$filename')";
                    $imageResult = $conn->query($imageSql);
                    if ($imageResult) {
                        header('location: manage_item?itemId=' . $itemId);
                    } else {
                        unlink($targetPath);
                    }
                } else {
                    echo "Error uploading the image.";
                }
            } else {
                echo "Invalid file type. Allowed types: " . implode(', ', $allowedExtensions);
            }
        } else {
            echo "No file uploaded.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    header('location: login');
}
?>