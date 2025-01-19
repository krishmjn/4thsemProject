<?php
// include "../connection.php";
include "./header.php";
include "./navbar.php";

// Initialize totalPrice variable
$totalPrice = 0;

// Check if the POST request contains selected items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_bags']) && !empty($_POST['selected_bags'])) {
        $selected_bags = $_POST['selected_bags'];
        $_SESSION['selected_bags'] = $selected_bags;
        $userId = $_SESSION['id'];
        echo "<h1>Confirm your order </h1>";

        // Fetch the selected items and display them in a card layout
        echo '<div class="cart-items-container">';
        foreach ($selected_bags as $bagId) {
            // Fetch the item details from the cart
            $sql_item = "SELECT bags.name AS bag_name, bags.price AS bag_price, cart.quantity AS cart_qty, bags.image AS bag_image
                         FROM cart
                         JOIN bags ON cart.bag_id = bags.id
                         WHERE cart.user_id = ? AND cart.bag_id = ?";
            $stmt_item = mysqli_prepare($conn, $sql_item);

            if (!$stmt_item) {
                die("Failed to prepare statement for item details: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_item, 'ii', $userId, $bagId);
            mysqli_stmt_execute($stmt_item);
            $result_item = mysqli_stmt_get_result($stmt_item);

            if ($result_item && mysqli_num_rows($result_item) > 0) {
                $item = mysqli_fetch_assoc($result_item);
                $bagName = $item['bag_name'];
                $bagPrice = $item['bag_price'];
                $cartQty = $item['cart_qty'];
                $bagImage = $item['bag_image'];  // Assuming you have a 'bag_image' column in the 'bags' table
                $itemTotalPrice = $bagPrice * $cartQty;
                $totalPrice += $itemTotalPrice; // Accumulate the total price
                // Display the item in a card format
                echo '<div class="cart-item-card">';
                echo '<img src="../admin/uploads/' . htmlspecialchars($bagImage) . '" alt="' . htmlspecialchars($bagName) . '" class="cart-item-image">';

                echo '<div class="cart-item-details">';
                echo '<h3>' . htmlspecialchars($bagName) . '</h3>';
                echo '<p>Price: Rs' . number_format($bagPrice) . '</p>';
                echo '<p>Quantity: ' . htmlspecialchars($cartQty) . '</p>';
                echo '<p>Total: Rs' . number_format($itemTotalPrice) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        }
        echo '</div>';
    } else {
        echo "<script>alert('No items selected for checkout.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
    exit;
}

// Prepare payment details
$cart_id = '12345'; // Replace with your actual cart ID
$transaction_uuid = time(); // Current timestamp
$amount = $totalPrice; // Set amount to total price
$tax_amount = "0"; // Set tax amount if needed
$total_amount = $totalPrice; // Total amount now reflects the sum of all items
$product_code = 'EPAYTEST';

// Prepare the message for the hash
$secret_key = '8gBm/:&EnhH.1/q'; // Your secret key
$signature = hash_hmac('sha256', "total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=$product_code", $secret_key, true);
$signature_base64 = base64_encode($signature); // Base64 encode if needed
?>

<form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
    <input type="hidden" id="amount" name="amount" value="<?= htmlspecialchars($amount) ?>" required>
    <input type="hidden" id="tax_amount" name="tax_amount" value="<?= htmlspecialchars($tax_amount); ?>" required>
    <input type="hidden" id="total_amount" name="total_amount" value="<?= htmlspecialchars($total_amount); ?>" required>
    <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="<?= htmlspecialchars($transaction_uuid) ?>" required>
    <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
    <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
    <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
    <input type="hidden" id="success_url" name="success_url" value="http://localhost/4thsemproject/components/users/payment_success.php" required>
    
    <input type="hidden" id="failure_url" name="failure_url" value="http://localhost/4thsemproject/components/users/payment_fail.php    " required>
    <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
    <input type="hidden" id="signature" name="signature" value="<?= htmlspecialchars($signature_base64); ?>" required>
    <img src="../../icons/images.png" alt="" height="70px" width="150px" style="display: inline-block;margin-left: 80px;">
    <button type="submit" style="border: none;background-color: green;color: white;padding: 5px;width:130px;border-radius: 10px;margin-bottom: 100px;cursor: pointer;">Pay with esewa</button>
</form>

<!-- CSS to style the card layout -->
<style>
.cart-items-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin: 20px;
}

.cart-item-card {
    width: 250px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    padding: 20px;
    text-align: center;
    background-color: #fff;
}

.cart-item-card img {
    width: 100%;
    height: auto;
    max-height: 200px;
    border-radius: 10px;
    object-fit: cover;
}

.cart-item-details h3 {
    font-size: 18px;
    margin: 10px 0;
}

.cart-item-details p {
    font-size: 14px;
    color: #555;
    margin: 5px 0;
}
</style>

<?php
include "./end.php";
?>
