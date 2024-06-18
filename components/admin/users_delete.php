<?php
include './navbar.php';
include './connection.php';

if (isset($_GET['deleteid'])) {
    $key = $_GET['deleteid'];
    $sql = "DELETE FROM `user` WHERE user_id='$key'";
    $data = mysqli_query($conn, $sql);
    if ($data) {
        
        header("location:./users.php");
    } else {
        die("Test user cant be deleted!!");
    }
}
