<?php
include "./navbar.php";
include "./header.php";

// Check if the POST request is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bagId = $_POST['bag_id'];
    $userId = $_POST['user_id'];
    $qty = (int)$_POST['qty'];

    if ($qty > 0) {
        $sql = "INSERT INTO cart (user_id, bag_id, quantity) VALUES ('$userId', '$bagId', '$qty')";
        $stmt = mysqli_query($conn, $sql);

        // Initialize session cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add or update the cart
        $_SESSION['cart'][$bagId] = [
            'user_id' => $userId,
            'bag_id' => $bagId,
            'quantity' => $qty,
        ];
        echo "Item added to cart!";
    } else {
        echo "Quantity must be greater than 0.";
    }
}

?>

<div class="history">
    <h2>My Cart</h2>
    <form action="checkout.php" method="POST">
        <table border="1px solid black">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Bag Name</th>
                    <th>Total Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = $_SESSION['id']; // Fetch user ID from session
                
                // SQL query to fetch cart items
                $sql = "SELECT bags.stock AS stock ,bags.name AS bag_name, bags.price AS bag_price, cart.quantity AS cart_qty, cart.cart_id AS cart_id, cart.bag_id AS bag_id
                        FROM cart 
                        JOIN bags ON cart.bag_id = bags.id 
                        WHERE cart.user_id = ?";
                $stmt_cart = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt_cart, 'i', $id);
                mysqli_stmt_execute($stmt_cart);
                $cart_data = mysqli_stmt_get_result($stmt_cart);

                $total_price = 0; // Initialize total price
                if ($cart_data) {
                    while ($cart_item = mysqli_fetch_assoc($cart_data)) :
                        if ($cart_item) {
                            $item_total_price = $cart_item['cart_qty'] * $cart_item['bag_price'];
                            $total_price += $item_total_price;
                            // Check if cart quantity exceeds available stock
            $exceeds_stock = $cart_item['cart_qty'] > $cart_item['stock'];
                ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_bags[]" value="<?= htmlspecialchars($cart_item['bag_id']); ?>" onchange="updateTotalPrice()">
                        </td>
                        <td><?= htmlspecialchars($cart_item['bag_name']); ?></td>
                        <td>
                    <?= htmlspecialchars($cart_item['cart_qty']); ?>
                    <?php if ($exceeds_stock): ?>
                        <span style="color: red;">(Exceeds stock)</span>
                        <script>
                            alert("Warning: The quantity for '<?= htmlspecialchars($cart_item['bag_name']); ?>' exceeds the available stock.");
                        </script>
                    <?php endif; ?>
                </td>
                        <td><?= htmlspecialchars($cart_item['bag_price']); ?></td>
                        <td class="item-total-price" data-price="<?= $item_total_price; ?>">
                            <?= htmlspecialchars($item_total_price); ?>
                        </td>
                        <td>
                            <a href="./cart_update.php?bag_id=<?= $cart_item['cart_id']; ?>"><button type="button" class="Update">Update</button></a>
                            <a href="./cart_delete.php?bag_id=<?= $cart_item['cart_id']; ?>"><button type="button" class="Delete">Delete</button></a>
                        </td>
                    </tr>
                <?php 
                        }
                    endwhile;
                }
                ?>
            </tbody>
        </table>

        <!-- Display Total Price -->
        <h3 id="total-price" style="margin-left: 100px; margin-top: 30px;">Total Price: <?= htmlspecialchars($total_price); ?></h3>

        <!-- Checkout Button -->
        <button type="submit" style="margin-left: 100px;" class="ck">Checkout</button>
    </form>

    

<script>
function updateTotalPrice() {
    let total = 0;
    const checkboxes = document.querySelectorAll('input[name="selected_bags[]"]:checked');
    checkboxes.forEach((checkbox) => {
        const row = checkbox.closest('tr');
        const itemTotalPrice = parseFloat(row.querySelector('.item-total-price').getAttribute('data-price'));
        total += itemTotalPrice;
    });
    
    // Update the displayed total price
    document.getElementById('total-price').innerText = 'Total Price: ' + total.toFixed(0);

    // Update hidden input fields for payment processing
    document.getElementById('amount').value = total.toFixed(0);
    document.getElementById('total_amount').value = total.toFixed(0);
}
</script>
