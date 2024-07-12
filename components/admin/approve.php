
<?php
include './navbar.php';
include './connection.php';

if (isset($_GET['approveid'])) {
    $key = $_GET['approveid'];

    $sql2 = "UPDATE user_bookings SET booking_status = 'approved' WHERE booking_id = '$key';
    ";
    $res2 = mysqli_query($conn, $sql2);
    if($res2){
        header("location:./bookings.php");

    }
  
}

?>
