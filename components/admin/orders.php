<?php
include "./navbar.php";
include "./connection.php";
if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}


$id = $_SESSION['admin_id'];

$sql = "SELECT customer_ordesrs.order_id,customer_ordesrs.quantity, bags.id, user.full_name, user.phone, bags.price
        FROM customer_ordesrs
        JOIN bags ON customer_ordesrs.bag_id = bags.id
        JOIN user ON customer_ordesrs.user_id = user.user_id";
$data = mysqli_query($conn, $sql);
if (!$data) {
    // Display the MySQL error message
    echo "Error executing query: " . mysqli_error($conn);
    exit();
}
?>
<div class="container">

    <h1 class="heading">Bookings</h1>
    <table border="1px solid black">
        <thead>
            <tr>

                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Bag Id</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $key = 0;
            while ($result = mysqli_fetch_assoc($data)) :
                $key++;
                $total_price = $result['price'] * $result['quantity'];

            ?>
                <tr>
                    <td><?= $result['order_id']; ?></td>
                    <td><?= $result['full_name']; ?></td>
                    <td><?= $result['id']; ?></td>
                    <td><?= $result['price']; ?></td>
                    <td><?= $result['quantity'] ?></td>
                    <td><?= $total_price ?></td>
                    <td><?= $result['phone'] ?></td>
                     
          

                </tr>
            <?php endwhile; ?>

        </tbody>
    </table>
</div>

