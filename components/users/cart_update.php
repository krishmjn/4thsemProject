<?php
include "./navbar.php";
include "./header.php";
// Get the cart ID from the URL
$cart_id = $_GET['bag_id'];

if (!$cart_id) {
    die("Error: cart_id not provided in the URL.");
}

if (!empty($_POST)) {
    $quantity = (int)$_POST['quantity'];

    // Update the cart information for the given cart ID
    $sql = "UPDATE cart SET quantity='$quantity' WHERE cart_id='$cart_id'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Updated successfully";
        header("Location: ./cart.php"); // Redirect to the cart page
        exit(); // Ensure no further code is executed after the redirect
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

// Retrieve the current cart item details for the given cart ID
$sql = "SELECT * FROM cart WHERE cart_id='$cart_id'";
$data = mysqli_query($conn, $sql);

if (!$data) {
    die("Error fetching cart item: " . mysqli_error($conn));
}

$result = mysqli_fetch_assoc($data);

if (!$result) {
    die("Error: Cart item not found for cart_id = $cart_id.");
}

$quantity = $result['quantity'];
?>

<div class="users">
    <section class="cartform">
        <form action="" method="post">
            <h2><span>UPDATE CART ITEM</span></h2>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($quantity); ?>" required />
            </div>
            <button type="submit">Update</button>
        </form>
    </section>
</div>


