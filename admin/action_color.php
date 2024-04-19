<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');

    // @$_POST['color_name'] = 'aacass';
    // @$_POST['color_code'] = 'asdsad';
    // @$_POST['color_id'] = 1;
    // @$_POST['action'] = 'add_color';
    //    ----------------------------------------------------------------------------------
    if ( $_POST['action'] == 'add_color') {
        $colorName = $_POST['colorName'];
        $colorCode = $_POST['colorCode'];
        $insertQuery = "INSERT INTO color_list (color_name, color_code) VALUES ('$colorName', '$colorCode')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update_color') {
        // Retrieve color details from the POST data
        $colorName = $_POST['colorName'];
        $colorCode = $_POST['colorCode'];
        $colorId = $_POST['colorId'];

        // Insert color into the color_list table
        $insertQuery = "UPDATE color_list SET color_name='$colorName', color_code='$colorCode' WHERE color_id = '$colorId'";

        if ($conn->query($insertQuery) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
    }
    if (isset($_POST['colorId']) && $_POST['action'] == 'delete_color') {
        $colorId = $_POST['colorId'];
        $sql = "DELETE FROM color_list WHERE color_id = $colorId";
        $result = $conn->query($sql);
        if ($result) {
            echo 'success';
        } else {
            echo 'error';
        }
    }



    // ---------------------------------------------------------------------------------
} else {
    header('location: login');
}
?>