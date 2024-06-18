<?php
include "./navbar.php";
include "./connection.php";
$key = $_GET['updateid'];

// $sqlj="SELECT car.*, fuel.fuel_capacity , transmission.transmission_type ,seat.size FROM car JOIN fuel on car.fuel_id=fuel.fuel_id JOIN seat on car.seat_id=seat.seat_id JOIN transmission on car.transmission_id=transmission.transmission_id;";
$seatsql = "SELECT * FROM seat";
$result = mysqli_query($conn, $seatsql);
while ($row = mysqli_fetch_assoc($result)) {
    $seats[] = $row;
}

$transmissionsql = "SELECT * FROM transmission";
$result = mysqli_query($conn, $transmissionsql);
while ($row = mysqli_fetch_assoc($result)) {
    $transmissions[] = $row;
}

$fuelsql = "SELECT * FROM fuel";
$result = mysqli_query($conn, $fuelsql);
while ($row = mysqli_fetch_assoc($result)) {
    $fuels[] = $row;
}

if (!empty($_POST)) {
    $car_name = $_POST['name'];
    $fuel_litre = $_POST['fuel_id'];
    $transmission_type = $_POST['transmission_id'];
    $seat_capacity = $_POST['seat_id'];
    $rate = $_POST['rate'];
    // $image = '';
    // if (!empty($_FILES['image']['name'])) {
    //     $image = $_FILES['image']['name'];
    //     $tmp = $_FILES['image']['tmp_name'];
    //     $path = './uploads/';
    //     move_uploaded_file($tmp, $path . $image);
    // }

    $sql = "UPDATE car SET car_id='$key',car_name='$car_name',fuel_id='$fuel_litre',transmission_id='$transmission_type',
          seat_id='$seat_capacity',rate='$rate' WHERE car_id='$key'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Updated successfully";
        header("location:./cars.php");
    } else {
        die("error" . mysqli_error($conn));
    }
}

$sql = "SELECT car.*, fuel.fuel_capacity , transmission.transmission_type ,seat.size FROM car JOIN fuel on car.fuel_id=fuel.fuel_id JOIN seat on car.seat_id=seat.seat_id JOIN transmission on car.transmission_id=transmission.transmission_id WHERE car_id='$key'";
$data = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($data);
$car_name = $result['car_name'];
$fuel_litre = $result['fuel_id'];
$transmission_type = $result['transmission_id'];
// echo $result['transmission_id'];
$seat_capacity = $result['seat_id'];
$rate = $result['rate'];
// $image = $result['image'];


?>
<div class="users">
    <section class="carform update">
        <div class="regcls-btn">&times;</div>
        <form action="" method="post" enctype="multipart/form-data">
            <h2><span>UPDATE</span><br />FORM</h2>

            <label for="name">Car name</label>
            <input type="text" id="name" name="name" placeholder="Enter Car Name" value="<?php echo $car_name ?>" required /><br />

            <label for="fuel_capacity">Fuel Capcaity</label>
            <select name="fuel_id">
                <?php
                foreach ($fuels as $fuel) :
                ?>
                    <option value="<?= $fuel['fuel_id'] ?>" <?php
                                                            if ($result['fuel_id'] == $fuel['fuel_id']) {
                                                                echo "selected";
                                                            }
                                                            ?>><?= $fuel['fuel_capacity'] ?></option>
                <?php
                endforeach;
                ?>
            </select><br><br>

            <label for="cars">Transmission Type : </label>
            <select name="transmission_id">
                <?php
                foreach ($transmissions as $transmission) :
                ?>
                    <option value="<?= $transmission['transmission_id'] ?>" <?php if ($result['transmission_id'] == $transmission['transmission_id']) {
                                                                                echo "selected";
                                                                            }  ?>><?= $transmission['transmission_type'] ?></option>
                <?php
                endforeach;
                ?>
            </select><br><br>

            <label for="seat">Seat Capacity</label>
            <select name="seat_id">
                <?php
                foreach ($seats as $seat) :
                ?>
                    <option value="<?= $seat['seat_id'] ?>" <?php
                                                            if ($result['seat_id'] == $seat['seat_id']) {
                                                                echo "selected";
                                                            }
                                                            ?>><?= $seat['size'] ?></option>
                <?php
                endforeach;
                ?>
            </select><br><br>
            <label for="rate">Rate</label>
            <input type="text" id="rate" name="rate" placeholder="Enter Per Day Rate" value="<?php echo $rate ?>" required /><br />

            <!-- <label for="image">Image</label>
            <input type="file" id="image" name="image" placeholder="Choose an image" required /><br /> -->

            <button>Update</button>

        </form>
    </section>
</div>


<?php

include "./end.php";
?>