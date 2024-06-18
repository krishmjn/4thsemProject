<?php
include "./navbar.php";

$key = $_GET['updateid'];

if (!empty($_POST)) {

    $pickup_date = $_POST['date1'];
    $return_date = $_POST['date2'];




    $sql = "UPDATE user_bookings SET pickup_date='$pickup_date',
          return_date='$return_date' WHERE user_id='$key'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Updated successfully";
        header("location:./profile.php");
    } else {
        die("error" . mysqli_error($conn));
    }
}

$sql = "SELECT * FROM `user_bookings` WHERE user_id='$key'";
$data = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($data);

$pickup_date = $result['pickup_date'];
$return_date = $result['return_date'];


?>
<div class="users">


    <section class="carform">
        <form action="" method="post">
            <h2><span>RENTNOW</span><br />CARRENTAL</h2>


            <div class="pr">
                <div class="pickup">
                    <label for="date1">Pickup Date</label>
                    <input type="date" id="date1" name="date1" value="<?php echo $pickup_date; ?>" placeholder="Date Here" required />
                </div>
                <div class="return">
                    <label for="date2">Return Date</label>
                    <input type="date" id="date2" name="date2" value="<?php echo $return_date; ?>" placeholder="Date Here" required /><br />
                </div>
            </div>
            <button>Update</button>
        </form>
    </section>
</div>