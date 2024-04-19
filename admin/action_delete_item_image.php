<?php
include ('admin_session.php');
if (isset ($_SESSION['AdminID'])) {
    include ('../conn.php');
    include ('../assets/public_function.php');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $imageUrl = $_GET['imageUrl'];
        $itemId = $_GET['itemId'];
        $targetDirectory = '../assets/item_images/';
        // print_r($image);
        $imageCount = count($conn->query("SELECT * FROM item_images WHERE image_url = '$imageUrl'")->fetch_all());

        $sql = "DELETE FROM item_images WHERE image_url = '$imageUrl' AND item_id = $itemId";
        $result = $conn->query($sql);
        if($result){
            $targetPath = $targetDirectory . $imageUrl;
            if($imageCount == 1){
                unlink($targetPath);
            }
        }
        header('location: manage_item?itemId='.$itemId);
    } else {
        echo "Invalid request.";
    }
} else {
    header('location: login');
}
?>