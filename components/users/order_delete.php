<?php
include "../connection.php"; // Include your database connection file

// Check if the order_id is set in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Prepare the SQL statement to delete the order
    $sql = "DELETE FROM customer_ordesrs WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $sql)) {
        // If the query is successful, redirect with a success message
        header("Location: profile.php?message=Order deleted successfully");
        exit();
    } else {
        // If there was an error, redirect with an error message
        header("Location: profile.php?error=Error deleting order: " . mysqli_error($conn));
        exit();
    }
} else {
    // If no order_id is set, redirect back to bookings page
    header("Location: profile.php?error=No order ID provided");
    exit();
}
?>
