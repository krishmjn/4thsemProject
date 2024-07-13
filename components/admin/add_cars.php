
<?php
include "./navbar.php";
include "./connection.php";
$folder = "/images";
if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}

if (!empty($_POST)) {
    $car_name = $_POST['name'];
    $fuel_litre = $_POST['fuel_capacity'];
    $transmission_type = $_POST['transmission'];
    $seat_capacity = $_POST['seat'];
    $rate = $_POST['rate'];
    $engine = $_POST['engine'];
    $fue = $_POST['fuelType'];
    // $qty = $_POST['quantity'];
    $modal = $_POST['modal'];
    $mileage = $_POST['mileage'];

    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = './uploads/';
        move_uploaded_file($tmp, $path . $image);
    }

    $sql = "INSERT INTO car(car_name, fuel_capacity, transmission_type, seat_capacity, rate, image, engine, modal, mileage, fuelType)
            VALUES('$car_name', '$fuel_litre', '$transmission_type', '$seat_capacity', '$rate', '$image', '$engine', '$modal', '$mileage', '$fue')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Data inserted";
        header("location:./cars.php");
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

?>
<section class="carform">
        <div class="regcls-btn">&times;</div>
        <form action="" method="post" enctype="multipart/form-data">
            <h2><span>Add</span>Cars</h2>

            <label for="name">Car name</label>
            <input type="text" id="name" name="name" placeholder="Enter Car Name" required /><br />

            <label for="fuel_capacity">Fuel Capacity</label>
            <input type="text" id="fuel_capacity" name="fuel_capacity" placeholder="Enter Fuel Capacity Of Your Car" required /><br />

            <label for="cars">Transmission Type : </label>
            <select name="transmission" id="transmission">
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select> <br><br>

            <label for="cars">Fuel Type : </label>
            <select name="fuelType" id="fuelType">
                <option value="Diesel">Diesel</option>
                <option value="Petrol">Petrol</option>
                <option value="Ev">Ev</option>
                <option value="Hybrid">Hybrid</option>
            </select>

            <!-- <label for="cars">Quantity : </label>
            <select name="quantity" id="quantity">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select> <br><br> -->

            <label for="modal">Modal Number</label>
            <input type="text" id="modal" name="modal" placeholder="Enter Modal Number" required /><br />

            <label for="engine">Engine Displacement</label>
            <input type="text" id="engine" name="engine" placeholder="Enter Engine Displacement" required /><br />

            <label for="mileage">Mileage</label>
            <input type="text" id="mileage" name="mileage" placeholder="Enter Mileage" required /><br />

            <label for="seat">Seat Capacity</label>
            <input type="text" id="seat" name="seat" placeholder="Enter Seat Capacity" required /><br />

            <label for="rate">Rate</label>
            <input type="text" id="rate" name="rate" placeholder="Enter Per Day Rate" required /><br />

            <label for="img">Image</label>
            <input type="file" id="img" name="image" placeholder="Choose an image" required /><br />

            <button>ADD CAR</button>
        </form>
    </section>