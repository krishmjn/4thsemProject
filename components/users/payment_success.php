<?php
include "../connection.php";  // Ensure your database connection is included
session_start();  // Start the session

// Step 1: Check if the 'data' parameter exists in the URL
if (isset($_GET['data'])) {
    // Step 2: Extract the value of 'data' parameter from the URL
    $encodedData = $_GET['data'];

    // Step 3: Decode the base64-encoded data
    $decodedData = base64_decode($encodedData);

    // Step 4: Convert the decoded data into an associative array (JSON object)
    $data = json_decode($decodedData, true);  // true means to return an associative array

    // Step 5: Check if the status exists
    if (isset($data['status'])) {
        $status = $data['status'];  // Extract the status value

        // Step 6: Check the status and display the relevant message
        if ($status === 'COMPLETE') {
            echo "<h2>Payment Complete</h2>";
            echo "<p>Thank you for your purchase! Your payment was completed successfully.</p>";
        
            // Step 7: Retrieve the selected bags from the session
            if (isset($_SESSION['selected_bags']) && is_array($_SESSION['selected_bags'])) {
                $selected_bags = $_SESSION['selected_bags'];  // Get the selected bag IDs from session
                $user_id = $_SESSION['id'];  // Get the user ID from the session
        
                // Step 8: Loop through each selected bag ID
                foreach ($selected_bags as $bagId) {
                    // Fetch the quantity of the selected bag from the cart
                    $sql_qty = "SELECT quantity FROM cart WHERE user_id = ? AND bag_id = ?";
                    $stmt_qty = mysqli_prepare($conn, $sql_qty);
                    
                    if (!$stmt_qty) {
                        die("Failed to prepare statement for fetching quantity: " . mysqli_error($conn));
                    }
        
                    // Bind parameters and execute the query to get the quantity
                    mysqli_stmt_bind_param($stmt_qty, 'ii', $user_id, $bagId);
                    mysqli_stmt_execute($stmt_qty);
                    mysqli_stmt_bind_result($stmt_qty, $quantity);
                    mysqli_stmt_fetch($stmt_qty);
                    mysqli_stmt_close($stmt_qty);
        
                    // Check if we successfully fetched the quantity
                    if (isset($quantity) && $quantity > 0) {
                        // Insert the order into the customer_orders table
                        $sql_order = "INSERT INTO customer_ordesrs (user_id, bag_id, quantity) VALUES (?, ?, ?)";
                        $stmt_order = mysqli_prepare($conn, $sql_order);
        
                        if (!$stmt_order) {
                            die("Failed to prepare statement for order: " . mysqli_error($conn));
                        }
        
                        // Bind the parameters and execute the order insertion
                        mysqli_stmt_bind_param($stmt_order, 'iii', $user_id, $bagId, $quantity);
                        if (mysqli_stmt_execute($stmt_order)) {
                            echo "<p>Added Bag ID $bagId to the orders.</p>";
        
                            // Step: Reduce the stock of the bag in the bags table by the ordered quantity
                            $sql_update_stock = "UPDATE bags SET stock = stock - ? WHERE id = ?";
                            $stmt_update_stock = mysqli_prepare($conn, $sql_update_stock);
        
                            if (!$stmt_update_stock) {
                                die("Failed to prepare statement for updating stock: " . mysqli_error($conn));
                            }
        
                            // Bind parameters (quantity and bag ID) and execute the stock update
                            mysqli_stmt_bind_param($stmt_update_stock, 'ii', $quantity, $bagId);
                            if (mysqli_stmt_execute($stmt_update_stock)) {
                                echo "<p>Stock for Bag ID $bagId has been updated.</p>";
                            } else {
                                echo "<p>Failed to update stock for Bag ID $bagId.</p>";
                            }
        
                            // Close the prepared statement for stock update
                            mysqli_stmt_close($stmt_update_stock);
                        } else {
                            echo "<p>Failed to add Bag ID $bagId to the orders.</p>";
                        }
        
                        // Close the prepared statement for the order
                        mysqli_stmt_close($stmt_order);
        
                        // Step: Remove the item from the cart after successful order insertion
                        $sql_delete = "DELETE FROM cart WHERE user_id = ? AND bag_id = ?";
                        $stmt_delete = mysqli_prepare($conn, $sql_delete);
                        mysqli_stmt_bind_param($stmt_delete, 'ii', $user_id, $bagId);
                        mysqli_stmt_execute($stmt_delete);
                        mysqli_stmt_close($stmt_delete);
                    }
                }
        
                echo "<p>The items have been added to your orders and removed from the cart.</p>";
                header("Location: ./profile.php");
                exit();  // Redirect and prevent further code execution
            } else {
                echo "<p>No items were selected to add to the orders.</p>";
            }
        
            echo "<p><a href='../profile.php'>Go to your profile</a></p>";
        }
        elseif ($status === 'FAILED') {
            echo "<h2>Payment Failed</h2>";
            echo "<p>We are sorry, but your payment was not successful. Please try again.</p>";
            echo "<p><a href='../checkout.php'>Go back to checkout</a></p>";
        } else {
            // If the status is not recognized
            echo "<h2>Invalid Payment Status</h2>";
            echo "<p>The payment status could not be verified. Please try again.</p>";
            echo "<p><a href='../checkout.php'>Go back to checkout</a></p>";
        }
    } else {
        // If there's no valid status in the decoded data
        echo "<h2>Invalid Data</h2>";
        echo "<p>The payment status could not be retrieved. Please try again later.</p>";
        echo "<p><a href='../checkout.php'>Go back to checkout</a></p>";
    }
} else {
    // If no 'data' parameter is found in the URL
    echo "<h2>Invalid Request</h2>";
    echo "<p>No payment status received. Please try again.</p>";
    echo "<p><a href='../checkout.php'>Go back to checkout</a></p>";
}
