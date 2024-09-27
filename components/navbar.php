<?php
include "./header.php";
// include "./connection.php";

?>
<nav>
    <div class="logo">
        <a href="./index.php"><img src="../icons/company name/logo.svg" height="70px" width="180px" alt=""></a>

        <!-- <h3>CARRENTAL</h3> -->
    </div>

    <div class="list">
    <ul>
    <li><a href="./index.php">Home</a></li>
    <li class="dropdown">
        <a href="./collections.php" class="coll">Collections</a>
        <ul class="dropdown-menu">
            <li><a href="./collections.php">Backpacks</a></li>
            <li><a href="./collections.php">Hip Packs</a></li>
            <li><a href="./collections.php">Totes</a></li>
        </ul>
    </li>
    <li><a href="./index.php">About Us</a></li>
    <li><a href="./signin.php">Contact</a></li>
</ul>

    </div>

    <div class="option">
        <button id="sign-up"><a href="./signup.php">Sign Up</a></button>
        <button id="sign-in"><a href="./signin.php">Sign In</a></button>
    </div>

</nav>


<?php
include "./footer.php"

?>