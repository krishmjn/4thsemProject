<?php



include "./connection.php";
include "./navbar.php";
if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}
?>
<h1 class="container heading">Welcome Admin</h1>

