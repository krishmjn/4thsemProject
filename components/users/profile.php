<?php
include "./navbar.php";
include "./header.php";
// Check if user is logged in
if (!isset($_SESSION['is_login'])) {
    header('Location: ./login.php');
    exit();
}

$id = $_SESSION['id'];
// Fetch user's bag orders
$sql_orders = "SELECT customer_ordesrs.order_id, customer_ordesrs.quantity, bags.id AS bag_id, 
                      user.full_name, user.phone, bags.price
               FROM customer_ordesrs
               JOIN bags ON customer_ordesrs.bag_id = bags.id
               JOIN user ON customer_ordesrs.user_id = user.user_id
               WHERE user.user_id = '$id'";

$data_orders = mysqli_query($conn, $sql_orders);
if (!$data_orders) {
    // Display the MySQL error message
    echo "Error executing query: " . mysqli_error($conn);
    exit();
}

// Fetch user profile information
$sql_profile = "SELECT full_name, phone FROM user WHERE user_id = '$id'";
$data_profile = mysqli_query($conn, $sql_profile);
$user_profile = mysqli_fetch_assoc($data_profile);
?>

<div class="container">
<h1>Manage your account</h1>

<div class="profile">
    <div class="info">
        <h2>Personal Profile</h2>
        <?php
        $sqlu = "SELECT * FROM user WHERE user_id='$id'";
        $user = mysqli_query($conn, $sqlu);
        
        $user_info = mysqli_fetch_assoc($user); ?>
        <p>Full Name : <?= $user_info['full_name']; ?><br>Phone : <?= $user_info['phone']; ?><br>Email : <?= $user_info['email']; ?><br>Password : <?= $user_info['password']; ?></p>
    </div>

</div>
<div class="action">
    <a href="./profile_update.php?userid=<?= $user_info['user_id']; ?>"><button class="Update">Update</button></a>
</div>

    <h1 class="heading">Your Bag Orders</h1>
    <table border="1px solid black">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Bag ID</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are orders to display
            if (mysqli_num_rows($data_orders) > 0) {
                while ($result = mysqli_fetch_assoc($data_orders)) {
                    // Calculate total price
                    $total_price = $result['price'] * $result['quantity'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($result['order_id']); ?></td>
                        <td><?= htmlspecialchars($result['full_name']); ?></td>
                        <td><?= htmlspecialchars($result['bag_id']); ?></td>
                        <td><?= htmlspecialchars($result['price']); ?></td>
                        <td><?= htmlspecialchars($result['quantity']); ?></td>
                        <td><?= htmlspecialchars($total_price); ?></td>
                       
                        <td>
                            <button class="Delete">
                                <a href="order_delete.php?order_id=<?= $result['order_id']; ?>">Delete</a>
                            </button>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='8'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    
    
</div>

<?php
include "./end.php";
?>
