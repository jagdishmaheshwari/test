<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');
    include('../validator.php');

    // @$_POST['productName'] = 'aacass';
    // @$_POST['description'] = 'asdsad';
    // @$_POST['productId'] = 1;
    // @$_POST['action'] = 'delete_product';
    //    ----------------------------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'add_specification') {
        $productId = $_POST['productId'] !== "" ? $_POST['productId'] : "1";
        $name = $_POST['name'];
        $value = $_POST['value'];
        if ($priority = $_POST['priority'] ?? '');
        $sql = "INSERT INTO product_specifications(name, value, product_id, priority) VALUES('$name', '$value','$productId','$priority')";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'delete_specification') {
        $productId = $_POST['productId'];
        $specificationId = $_POST['specificationId'];
        $sql = "DELETE FROM product_specifications WHERE specification_id = '$specificationId'";
        $result = $conn->query($sql);
        if ($result) {
            echo "success";
        } else {
            echo "error";
        }
    }



    // ---------------------------------------------------------------------------------
} else {
    header('location: login');
}
?>