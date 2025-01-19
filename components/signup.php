<?php
include "./connection.php";
include "./header.php";

if (!empty($_POST)) {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Validate phone number starts with '9' and is 10 digits long
    if (!preg_match('/^9\d{9}$/', $phone)) {
        die("Error: Invalid phone number. It must start with '9' and be 10 digits long.");
    }

    // Strict email validation (restrict to common domains)
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|edu|gov)$/', $email)) {
        die("Error: Invalid email address. Use a valid domain like .com");
    }

    // Insert data into the database
    $sql = "INSERT INTO user(full_name, email, phone, password)
    VALUES('$full_name', '$email', '$phone', '$password')";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Data inserted";
        header("location: ./signin.php");
        exit;
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>

<div class="popup2">
    <form action="" method="post">
        <h2><span>JHOLA</span><br /></h2>
        
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your Full Name" required /><br />

        <label for="email">Email Address</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Enter your Email Address" 
            required 
            title="Enter a valid email address with a common domain like .com, .org, etc." /><br />

        <label for="phone">Phone</label>
        <input 
            type="text" 
            id="phone" 
            name="phone" 
            placeholder="Enter your Phone Number" 
            minlength="10" 
            maxlength="10" 
            pattern="9\d{9}" 
            title="Phone number must start with '9' and be 10 digits long." 
            required /><br />

        <label for="password">Password</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Enter password" 
            minlength="8" 
            maxlength="16" 
            required /><br />

        <button>Sign Up</button>
    </form>
</div>
