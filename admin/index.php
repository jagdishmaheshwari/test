<?php
if (isset ($_SESSION['AdminID'])) {
    // header('location: dashboard');
} else {
    header('location: login');
}
?>