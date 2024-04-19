<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');
    // @$_POST['size_name'] = 'aacass';
    // @$_POST['size_code'] = 'asdsad';
    // @$_POST['size_id'] = 1;
    // @$_POST['action'] = 'add_size';
    //    ----------------------------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'add_size') {
        $sizeName = $_POST['size_name'];
        $sizeCode = $_POST['size_code'];
        $insertQuery = "INSERT INTO size_list (size_name, size_code) VALUES ('$sizeName', '$sizeCode')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update_size') {
        // Retrieve size details from the POST data
        $sizeName = $_POST['size_name'];
        $sizeCode = $_POST['size_code'];
        $size_id = $_POST['size_id'];

        // Insert size into the size_list table
        $insertQuery = "UPDATE size_list SET size_name='$sizeName', size_code = '$sizeCode' WHERE size_id = '$size_id'";

        if ($conn->query($insertQuery) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }
    }
    if (isset($_POST['size_id']) && $_POST['action'] == 'delete_size') {
        $sizeId = $_POST['size_id'];
        $sql = "DELETE FROM size_list WHERE size_id = $sizeId";
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