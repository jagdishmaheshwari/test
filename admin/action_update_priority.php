<?php
include('admin_session.php');
if (isset($_SESSION['AdminID'])) {
    include('../conn.php');
    $table_name = $_POST['tableName'];
    $column = $_POST['column'];
    $id = $_POST['id'];
    $action = $_POST['action'];

    if (isset($action) && $action == 'plus') {
        $sql = "UPDATE $table_name SET priority =  priority+1 WHERE $column = $id";
    } elseif (isset($action) && $action == 'minus') {
        $sql = "UPDATE $table_name SET priority = priority-1 WHERE $column = $id";
    }
    $result = $conn->query($sql);
    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    header('location: login');
}
?>