<?php
include "./navbar.php";
include "./header.php";
// Check if bag_id is set in the URL
if (isset($_GET['bag_id'])) {
    $cart_id = $_GET['bag_id'];

    // SQL query to delete the item from the cart
    $sql = "DELETE FROM cart WHERE cart_id='$cart_id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Item deleted from cart successfully.";
        header("Location: ./cart.php"); // Redirect back to the cart page
        exit(); // Ensure no further code is executed after the redirect
    } else {
        die("Error deleting item: " . mysqli_error($conn)); // Error handling
    }
} else {
    echo "Error: No bag ID specified.";
}
?>

