<?php
include "./header.php";
include "./connection.php";
if (!empty($_POST)) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $sql = "SELECT * FROM admin WHERE email='$email' AND pasword='$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $num_of_rows = mysqli_num_rows($result);
    if ($num_of_rows > 0) {
        $student = mysqli_fetch_assoc($result);
        echo $student;
        $_SESSION['name'] = $row['full_name'];
        $_SESSION['is_login'] = true;
        $_SESSION['admin_id'] = $row['id'];

        echo "successfull";
        header("location:./index.php");

        exit();
    } else {
        echo "Invalid username and password";
    }
}


?>

<div class="popup1">

    <form action="" method="post">
        <h2><span>JHOLA</h2>
        <br /><br />

        <label for="Email">Email Address</label>
        <input type="email" id="Email" name="Email" placeholder="Enter your email address" /><br />

        <label for="Password">Password</label>
        <input type="password" id="Password" name="Password" placeholder="Enter your password" /><br /><br />

        <button>Sign In</button><br />

    </form>
</div>