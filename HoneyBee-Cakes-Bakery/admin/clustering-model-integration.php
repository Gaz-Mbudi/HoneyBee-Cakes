<?php
// cluster_integration.php

$api_url = 'http://localhost:8000/cluster';  // Adjust the URL and port accordingly

// Get productId and quantity from the request or other sources
$productId = isset($_POST['productId']) ? $_POST['productId'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

// Check if productId and quantity are valid
if ($productId !== null && $quantity !== null) {
    $data = array('productId' => $productId, 'quantity' => $quantity); // Adjust data as needed

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);
    curl_close($ch);

    // Process $response in PHP and integrate it into your bakery system
    $decoded_response = json_decode($response, true);

    // Access clustering results, e.g., $decoded_response['results']

    // Further integrate the clustering results into your bakery system logic
    // For example, update a database, display relevant information, etc.
} else {
    // Handle error: Invalid productId or quantity
    echo "Invalid input parameters (productId or quantity)";
}
?>
