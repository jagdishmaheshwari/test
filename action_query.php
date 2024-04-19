<?php
// Validate and sanitize input fields
include('validator.php');
$full_name = filterInput($_POST['full_name']);
$mobile_no = filterInput($_POST['mobile_no']);
$email = filterInput($_POST['email']);
$subject = filterInput($_POST['subject']);
$query = filterInput($_POST['query']);

// Perform additional validation if needed (e.g., check email format, mobile number length, etc.)


// Insert the query into the database
if ($full_name && $email && $subject) {
    include('conn.php');
    // Prepare and execute SQL statement to insert contact query
    $sql = "INSERT INTO contact_queries (full_name, mobile_no, email, subject, query) VALUES ('$full_name', '$mobile_no', '$email', '$subject', '$query')";
    $result = $conn->query($sql);
    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid';
}
?>