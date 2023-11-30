<!DOCTYPE html>
<html>
<head>
    <title>Cluster Prediction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #333;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2>Cluster Prediction Form</h2>
    <form method="get" action="cluster.php">
        <label for="arg_productId">Product ID:</label>
        <input type="text" id="arg_productId" name="arg_productId" required>
        <label for="arg_quantity">Number of cakes:</label>
        <input type="text" id="arg_quantity" name="arg_quantity" required>
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
    
            // Process the response
            if ($response === false) {
                echo "Error occurred while processing the request";
            } else {
                // Decode the response
                $decoded_response = json_decode($response, true);
            
                if ($decoded_response === null) {
                    echo "Invalid response format";
                    // Display the raw API response for debugging
                    echo "<pre>" . htmlspecialchars($response) . "</pre>";
                } else {
                    // Display clustering result (only the number)
                    echo "<h3>Clustering Result:</h3>";
                    if (is_array($decoded_response) && count($decoded_response) > 0) {
                        echo "<p style='font-size: 24px; font-weight: bold;'>" . $decoded_response[0] . "</p>";
                    } else {
                        echo "Invalid or empty response";
                    }
                }
            }
            }
        } else {
            // Handle error: Invalid feature inputs
            echo "<p style='color: red;'>Invalid input parameters (features)</p>";
        }
    ?>
</body>
</html>
