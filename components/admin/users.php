<?php
include "./navbar.php";
include "./connection.php";

// Fetch all users
$sql = "SELECT * FROM user";
$data = mysqli_query($conn, $sql);

// Fetch all user bookings
$bookingSql = "SELECT user_id FROM user_bookings";
$bookingData = mysqli_query($conn, $bookingSql);

// Store user IDs with bookings in an array
$userBookings = [];
while ($booking = mysqli_fetch_assoc($bookingData)) {
    $userBookings[] = $booking['user_id'];
}

if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}
?>

<div class="container">
    <h1 class="heading">Users</h1>
    <table border="1px solid black">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Password</th>
                <th>Driving License</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($result = mysqli_fetch_assoc($data)) :
            ?>
                <tr>
                    <td><?= $result['user_id'] ?></td>
                    <td><?= $result['full_name']; ?></td>
                    <td><?= $result['email']; ?></td>
                    <td><?= $result['phone']; ?></td>
                    <td><?= $result['password']; ?></td>
                    <td><?= $result['driving_license_no']; ?></td>
                    <td>
                        <?php if (in_array($result['user_id'], $userBookings)) : ?>
                            <!-- User has bookings, do not allow delete -->
                            <button class="Delete" disabled>Delete</button>
                        <?php else : ?>
                            <!-- User does not have bookings, allow delete -->
                            <button class="Delete"><a href="users_delete.php?deleteid=<?= $result['user_id']; ?>">Delete</a></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include "./end.php"; ?>