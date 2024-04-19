<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');
    include('../validator.php');

    $productId = $_POST['productId'];
    $name = $_POST['name'];
    $value = $_POST['value'];
    $sql = "INSERT INTO product_specifications(name, value, product_id) VALUES('$name', '$value','$productId')";
    $result = $conn->query($sql);
    if ($result) {
        header('location: manage_product?productId=' . $productId);
    } else {
        echo "<script>swal('Something went wrong please try again!').then(function (){window.history.go(-1)})</script>";
    }
} else {
    header('location: login');
}
?>