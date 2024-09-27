<?php
include "./header.php";
include "../connection.php";

?>

<nav>
    <div class="logo">
        <a href="./users_home.php"><img src="../../icons/company name/logo.svg" height="70px" width="180px" alt=""></a>
        <!-- <h3>CARRENTAL</h3> -->
    </div>

    <div class="list">
        <ul>
            <li><a href="./users_home.php">Home</a></li>
            <li><a target="_blank" href="./carlisting.php">Collections</a></li>
            <li><a href="./users_home.php">About Us</a></li>
            <li><a target="_blank" href="./carlisting.php">Contact</a></li>
        </ul>
    </div>

    <!-- <div class="dropdown">
        <p> Welcome user !</p>
    </div> -->

    <div class="dropdown">
        <button class="dropbtn"><?= $_SESSION['name']; ?>
            <img src="../../icons/dropdown.png" alt="">
        </button>
        <div class="dropdown-content">
            <a href="./profile.php">Profile</a>
            <a href="./logout.php">Logout</a>
        </div>

</nav>