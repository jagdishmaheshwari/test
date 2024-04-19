<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['end'])) {
    session_destroy();
    header('location: login');
}
?>