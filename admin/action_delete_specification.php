<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');
    include('../validator.php');

    $productId = $_GET['productId'];
    $specification_id = $_GET['specification_id'];
    $sql = "DELETE FROM product_specifications WHERE specification_id = '$specification_id'";
    $result = $conn->query($sql);
    if ($result) {
        header('location: manage_product?productId=' . $productId);
    } else {
        echo "<script>swal('Not Deleted!').then(function (){window.history.go(-1)})</script>";
    }
} else {
    header('location: login');
}
?>