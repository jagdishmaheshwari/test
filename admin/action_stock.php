<?php
include ('../conn.php');
include('../validator.php');
if ($_SERVER["REQUEST_METHOD"] === "POST" and $_POST['action'] == 'add_stock') {
    if (isset ($_POST["itemId"], $_POST["stockLocation"], $_POST["quantity"])) {
        $itemId = filterInput($_POST["itemId"]);
        $location = filterInput($_POST["stockLocation"]);
        $remark = filterInput($_POST["remark"]);
        $quantity = filterInput($_POST["quantity"]);

        if ($itemId && $location && $quantity !== false && $quantity) {
            $sql = "INSERT INTO stock (item_id, location, quantity, remark) VALUES ('$itemId', '$location', $quantity, '$remark')";
            if ($conn->query($sql)) {
                $response = array("success" => true);
            }
        } else {
            $response = array("success" => false, "error" => "Invalid input data.");
        }
    } else {
        $response = array("success" => false, "error" => "Missing parameters.");
    }
} else {
    $response = array("success" => false, "error" => "Invalid request method.");
}
header("Content-Type: application/json");
echo json_encode($response);
?>