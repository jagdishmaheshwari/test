<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Request Example</title>
</head>
<body>
    <div id="customerInfo"></div>

    <script>
        // Function to make AJAX request
        function fetchDataByMobile(mobileNumber) {
            // URL to fetch data from
            const url = `https://kalidasdigitalservice.000webhostapp.com/action_fetch_customer.php?mobile=${mobileNumber}`;

            // Create a new XMLHttpRequest object
            const xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('GET', url, true);

            // Set up callback function for when request completes
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Request was successful, parse response
                    const response = JSON.parse(xhr.responseText);
                    displayCustomerInfo(response); // Display data in div
                } else {
                    // Request failed, handle error
                    console.error('Request failed with status:', xhr.status);
                }
            };

            // Send the request
            xhr.send();
        }

        // Function to display customer information in div
        function displayCustomerInfo(data) {
            const customerInfoDiv = document.getElementById('customerInfo');
            customerInfoDiv.innerHTML = ''; // Clear previous content

            // Create HTML content to display key-value pairs
            const content = Object.entries(data).map(([key, value]) => {
                return `<p><strong>${key}:</strong> ${value}</p>`;
            }).join('');

            // Update div content with generated HTML
            customerInfoDiv.innerHTML = content;
        }

        // Example usage: Fetch data by mobile number and display in div
        const mobileNumber = '9586661184'; // Replace with desired mobile number
        fetchDataByMobile(mobileNumber);
    </script>
</body>
</html>


<?php
// die();
// require_once 'class/db.php'; // Include the CrudOperations class

// $DB = new DB();

// $table = "item_list";
// $conditions = ["visible = 1", "category_id=2"];
// $records = $DB->get($table, $conditions=['item_id'=>'634']);
// $a = 1;


// echo json_encode($records);


// $table = "item_list";
// $conditions = ["visible = 1", "category_id=2"];
// $records = $DB->read($table, $conditions);
// prd($records);
?>