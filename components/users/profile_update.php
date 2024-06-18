<?php
include "./header.php";
include "../connection.php";
$key = $_GET['userid'];

if (!empty($_POST)) {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $driving_license_no = $_POST['license'];

    // $sql = "INSERT INTO user(full_name,email,phone,password,driving_license_no)
    // VALUES('$full_name','$email','$phone','$password','$driving_license_no')";

    $sql = "UPDATE user SET full_name='$full_name',email='$email',phone='$phone',password='$password',driving_license_no='$driving_license_no'  WHERE user_id='$key'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Data inserted";
        header("location: ./profile.php");
    } else {
        die("error" . mysqli_error($conn));
    }
}
$sql = "SELECT * FROM `user` WHERE user_id='$key'";
$data = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($data);
$full_name = $result['full_name'];
$phone = $result['phone'];
$email = $result['email'];
$password = $result['password'];
$driving_license_no = $result['driving_license_no'];

?>

<div class="popup2">

    <form action="" method="post">
        <h2><span>RENTNOW</span><br />CARRENTAL</h2>
        <label for="name">Full name</label>
        <input type="text" id="name" name="name" value="<?php echo $full_name; ?>" placeholder="Enter your Full Name" /><br />

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your Email Address" value="<?php echo $email; ?>" /><br />

        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your Phone Number" maxlength="10" value="<?php echo $phone; ?>" /><br />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" minlength="8" maxlength="16" placeholder="Enter password" value="<?php echo $password; ?>" /><br />


        <label for="license">Driving license</label>
        <input type="text" id="license" name="license" placeholder="Enter your Driving License No." value="<?php echo $driving_license_no; ?>"><br>

        <button>Update</button>
    </form>
</div>