<!DOCTYPE html>
<html>
<head>
    <title>Cluster Prediction</title>
</head>
<body>
    <h2>Cluster Prediction Form</h2>
    <form method="get" action="cluster.php">
        <label for="arg_productId">Product ID:</label>
        <input type="text" id="arg_productId" name="arg_productId" required>
        <br><br>
        <label for="arg_quantity">Number of cakes:</label>
        <input type="text" id="arg_quantity" name="arg_quantity" required>
        <br><br>
        <!-- Add more input fields for other features if needed -->
        <input type="submit" name="submit" value="Predict">
    </form>

    <?php
    // cluster.php

    // Check if the form is submitted
    if (isset($_GET['submit'])) {
        $api_url = 'http://127.0.0.1:5022/segment';  // Adjust the URL and port accordingly

        // Get feature inputs from the form
        $arg_productId = isset($_GET['arg_productId']) ? $_GET['arg_productId'] : null;
        $arg_quantity = isset($_GET['arg_quantity']) ? $_GET['arg_quantity'] : null;
        // Add more variables for other features as needed

        // Check if feature inputs are valid
        if ($arg_productId !== null && $arg_quantity !== null) {
            // Prepare data array with features (for GET request, add parameters to URL)
            $api_url .= "?arg_productId=$arg_productId&arg_quantity=$arg_quantity";
            // Add more features here if needed

            // Create and execute cURL request to the clustering API
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            
            curl_close($ch);

            // Process $response in PHP and integrate it into your system
            $decoded_response = json_decode($response, true);

            // Access clustering results, e.g., $decoded_response['results']
            echo "<h3>Clustering Results:</h3>";
            echo "<pre>";
            print_r($decoded_response);
            echo "</pre>";

            // Further integrate the clustering results into your system logic
            // For example, update a database, display relevant information, etc.
        } else {
            // Handle error: Invalid feature inputs
            echo "<p style='color: red;'>Invalid input parameters (features)</p>";
        }
    }
    ?>
</body>
</html>
