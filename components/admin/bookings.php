<?php
include "./navbar.php";
include "./connection.php";
if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}



$sql = "SELECT user_bookings.* , car.car_name,user.full_name,user.phone FROM user_bookings JOIN car on user_bookings.car_id=car.car_id JOIN user ON user_bookings.user_id=user.user_id;";
$data = mysqli_query($conn, $sql);
?>
<div class="container">

    <h1 class="heading">Bookings</h1>
    <table border="1px solid black">
        <thead>
            <tr>

                <th>Car Name</th>
                <th>Full Name</th>
                <th>Phone No</th>
                <th>Pickup Date</th>
                <th>Return Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $key = 0;
            while ($result = mysqli_fetch_assoc($data)) :
                $key++;
            ?>
                <tr>
                    <td><?= $result['car_name']; ?></td>
                    <td><?= $result['full_name']; ?></td>
                    <td><?= $result['phone']; ?></td>
                    <td><?= $result['pickup_date']; ?></td>
                    <td><?= $result['return_date'] ?></td>
                    <?php
if ($result['booking_status'] == "pending") {
?>
    <td>
        <button class="Approve"><a href="approve.php?approveid=<?= $result['booking_id']; ?>">Approve</a></button>
    </td>
<?php
}
?>
<?php
if ($result['booking_status'] == "approved") {
?>
    <td>
        <button class="Delete"><a href="bookings_delete.php?deleteid=<?= $result['booking_id']; ?>&carid=<?= $result['car_id']; ?>">Delete</a></button>
    </td>
<?php
}
?>

                </tr>
            <?php endwhile; ?>

        </tbody>
    </table>
</div>

<?php

include "./end.php";
?>