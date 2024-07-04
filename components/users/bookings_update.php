<?php
include "./navbar.php";

// Get the booking ID from the URL
$booking_id = $_GET['bookingid'];

if (!$booking_id) {
    die("Error: bookingid not provided in the URL.");
}

if (!empty($_POST)) {
    $pickup_date = $_POST['date1'];
    $return_date = $_POST['date2'];

    // Update the booking dates for the given booking ID
    $sql = "UPDATE user_bookings SET pickup_date='$pickup_date', return_date='$return_date' WHERE booking_id='$booking_id'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Updated successfully";
        header("Location: ./profile.php");
        exit(); // Ensure no further code is executed after the redirect
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

// Retrieve the current booking dates for the given booking ID
$sql = "SELECT * FROM user_bookings WHERE booking_id='$booking_id'";
$data = mysqli_query($conn, $sql);

if (!$data) {
    die("Error fetching booking: " . mysqli_error($conn));
}

$result = mysqli_fetch_assoc($data);

if (!$result) {
    die("Error: Booking not found for booking_id = $booking_id.");
}

$pickup_date = $result['pickup_date'];
$return_date = $result['return_date'];
?>

<div class="users">
    <section class="carform">
        <form action="" method="post">
            <h2><span>RENTNOW</span><br />CARRENTAL</h2>
            <div class="pr">
                <div class="pickup">
                    <label for="date1">Pickup Date</label>
                    <input type="date" id="date1" name="date1" value="<?= htmlspecialchars($pickup_date); ?>" placeholder="Date Here" required />
                </div>
                <div class="return">
                    <label for="date2">Return Date</label>
                    <input type="date" id="date2" name="date2" value="<?= htmlspecialchars($return_date); ?>" placeholder="Date Here" required /><br />
                </div>
            </div>
            <button>Update</button>
        </form>
    </section>
</div>