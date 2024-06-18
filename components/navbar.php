<?php
include "./header.php";
// include "./connection.php";

?>
<nav>
    <div class="logo">
        <a href="./index.php"><img src="../icons/logo.svg" height="100px" width="180px" alt=""></a>

        <!-- <h3>CARRENTAL</h3> -->
    </div>

    <div class="list">
        <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./signin.php">Car Listing</a></li>

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