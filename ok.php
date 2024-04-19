<?php
// URL endpoint to send the POST request
$url = 'http://192.168.113.41:3000/api/products/';

// Data to be sent in the POST request (in this example, form data)
$postData = ["name" => "Nameeeee","quantity" => 99,"price" => 90000];

// Initialize curl session
$ch = curl_init($url);

// Set curl options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string instead of outputting it directly
curl_setopt($ch, CURLOPT_POST, true); // Set request method to POST
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // Set POST data

// Execute curl session and capture the response
echo "<pre>";
$response = curl_exec($ch);
echo "</pre>";

// Check for curl errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close curl session
curl_close($ch);

// Output the response from the server
echo $response;
?>