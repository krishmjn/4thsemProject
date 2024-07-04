<?php
include "./connection.php";
include "./header.php";

if (!empty($_POST)) {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $driving_license_no = $_POST['license'];

    $sql = "INSERT INTO user(full_name,email,phone,password,driving_license_no)
    VALUES('$full_name','$email','$phone','$password','$driving_license_no')";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Data inserted";
        header("location: ./signin.php");
    } else {
        die("error" . mysqli_error($conn));
    }
}

?>
<div class="popup2">

    <form action="" method="post">
        <h2><span>RENTNOW</span><br />CARRENTAL</h2>
        <label for="name">Full name</label>
        <input type="text" id="name" name="name" placeholder="Enter your Full Name" required /><br />

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your Email Address" required/><br />

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="Enter your Phone Number" minlength="10" maxlength="10" required/><br />

        <label for="password">Password</label>

        <input type="password" id="password" name="password" placeholder="Enter password" minlength="8" maxlength="16" required/><br />


        <label for="license">Driving license</label>
        <input type="text" id="license" name="license" placeholder="Enter your Driving License No." required><br>

        <button>Sign Up</button>
    </form>
</div>