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
            <li><a  href="./collections.php">Collections</a>
            <ul class="dropdown-menu">
            <li><a href="./backpacks.php">Backpacks</a></li>
            <li><a href="./hip.php">Hip Packs</a></li>
            <li><a href="./totes.php">Totes</a></li>
        </ul>
        <!-- </li>
            <li><a href="../about.php">About Us</a></li>
        </ul> -->
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
            <a href="./cart.php">Cart</a>
            <a href="./logout.php">Logout</a>

        </div>

</nav>