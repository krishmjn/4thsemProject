<?php
include "./navbar.php";
include "./connection.php";

$key = $_GET['updateid'];

if (!empty($_POST)) {
    $car_name = $_POST['name'];
    $fuel_litre = $_POST['fuel_capacity'];
    $transmission_type = $_POST['transmission'];
    $seat_capacity = $_POST['seat'];
    $rate = $_POST['rate'];
    $engine = $_POST['engine'];
    $fuel_type = $_POST['fuelType'];
    // $quantity = $_POST['quantity'];
    $modal = $_POST['modal'];
    $mileage = $_POST['mileage'];

    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = './uploads/';
        move_uploaded_file($tmp, $path . $image);
        $image_sql = ", image='$image'";
    } else {
        $image_sql = "";
    }

    $sql = "UPDATE car SET 
            car_name='$car_name', 
            fuel_capacity='$fuel_litre', 
            transmission_type='$transmission_type', 
            seat_capacity='$seat_capacity', 
            rate='$rate',
            engine='$engine', 
            fuelType='$fuel_type', 
            -- Quantity='$quantity', 
            modal='$modal', 
            mileage='$mileage' 
            $image_sql 
            WHERE car_id='$key'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Updated successfully";
        header("location:./cars.php");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

$sql = "SELECT * FROM `car` WHERE car_id='$key'";
$data = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($data);

if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}

?>

<div class="users">
    <section class="carform update">
        <div class="regcls-btn">&times;</div>
        <form action="" method="post" enctype="multipart/form-data">
            <h2><span>Update</span> Cars</h2>

            <label for="name">Car name</label>
            <input type="text" id="name" name="name" value="<?= $result['car_name'] ?>" required /><br />

            <label for="fuel_capacity">Fuel Capacity</label>
            <input type="text" id="fuel_capacity" name="fuel_capacity" value="<?= $result['fuel_capacity'] ?>" required /><br />

            <label for="transmission">Transmission Type</label>
            <select name="transmission" id="transmission">
                <option value="Automatic" <?= $result['transmission_type'] == "Automatic" ? "selected" : "" ?>>Automatic</option>
                <option value="Manual" <?= $result['transmission_type'] == "Manual" ? "selected" : "" ?>>Manual</option>
            </select> <br><br>

            <label for="fuelType">Fuel Type</label>
            <select name="fuelType" id="fuelType">
                <option value="Diesel" <?= $result['fuelType'] == "Diesel" ? "selected" : "" ?>>Diesel</option>
                <option value="Petrol" <?= $result['fuelType'] == "Petrol" ? "selected" : "" ?>>Petrol</option>
                <option value="Ev" <?= $result['fuelType'] == "Ev" ? "selected" : "" ?>>Ev</option>
                <option value="Hybrid" <?= $result['fuelType'] == "Hybrid" ? "selected" : "" ?>>Hybrid</option>
            </select> 

            <!-- <label for="quantity">Quantity</label>
            <select name="quantity" id="fuelType">
                <option value="1" <?= $result['Quantity'] == "1" ? "selected" : "" ?>>1</option>
                <option value="2" <?= $result['Quantity'] == "2" ? "selected" : "" ?>>2</option>
                <option value="3" <?= $result['Quantity'] == "3" ? "selected" : "" ?>>3</option>
                <option value="4" <?= $result['Quantity'] == "4" ? "selected" : "" ?>>4</option>
            </select> <br><br> -->

            <label for="modal">Modal Number</label>
            <input type="text" id="modal" name="modal" value="<?= $result['modal'] ?>" required /><br />

            <label for="engine">Engine Displacement</label>
            <input type="text" id="engine" name="engine" value="<?= $result['engine'] ?>" required /><br />

            <label for="mileage">Mileage</label>
            <input type="text" id="mileage" name="mileage" value="<?= $result['mileage'] ?>" required /><br />

            <label for="seat">Seat Capacity</label>
            <input type="text" id="seat" name="seat" value="<?= $result['seat_capacity'] ?>" required /><br />

            <label for="rate">Rate</label>
            <input type="text" id="rate" name="rate" value="<?= $result['rate'] ?>" required /><br />

            <label for="img">Image</label>
            <input type="file" id="img" name="image" /><br />
            <img src="./uploads/<?= $result['image'] ?>" height="50" width="80" alt=""><br />

            <button>Update</button>
        </form>
    </section>
</div>
