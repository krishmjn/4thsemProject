<?php
include "./navbar.php";
include "./connection.php";
$folder = "/images";
if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}
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
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = './uploads/';
        move_uploaded_file($tmp, $path . $image);
    }

    $sql = "INSERT INTO car(car_name,fuel_id,transmission_id,seat_id,rate,image)
    VALUES('$car_name','$fuel_litre','$transmission_type','$seat_capacity','$rate','$image')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Data inserted";
    } else {
        die("error" . mysqli_error($conn));
    }
}

$sql = "SELECT car.*,fuel.fuel_capacity,seat.size,transmission.transmission_type FROM car JOIN fuel ON car.fuel_id=fuel.fuel_id JOIN seat ON car.seat_id=seat.seat_id JOIN transmission ON car.transmission_id=transmission.transmission_id;";
$data = mysqli_query($conn, $sql);
?>
<div class="users">
    <section class="carform">
        <div class="regcls-btn">&times;</div>
        <form action="" method="post" enctype="multipart/form-data">
            <h2><span>CARS</span><br />FORM</h2>

            <label for="name">Car name</label>
            <input type="text" id="name" name="name" placeholder="Enter Car Name" required /><br />

            <label for="fuel_capacity">Fuel Capcaity</label>
            <select name="fuel_id">
                <?php
                foreach ($fuels as $fuel) :
                ?>
                    <option value="<?= $fuel['fuel_id'] ?>"><?= $fuel['fuel_capacity'] ?></option>
                <?php
                endforeach;
                ?>
            </select><br><br>

            <label for="cars">Transmission Type : </label>
            <select name="transmission_id">
                <?php
                foreach ($transmissions as $transmission) :
                ?>
                    <option value="<?= $transmission['transmission_id'] ?>"><?= $transmission['transmission_type'] ?></option>
                <?php
                endforeach;
                ?>
            </select><br><br>

            <label for="seat">Seat Capacity</label>
            <select name="seat_id">
                <?php
                foreach ($seats as $seat) :
                ?>
                    <option value="<?= $seat['seat_id'] ?>"><?= $seat['size'] ?></option>
                <?php
                endforeach;
                ?>
            </select><br><br>

            <label for="rate">Rate</label>
            <input type="text" id="rate" name="rate" placeholder="Enter Per Day Rate" required /><br />

            <label for="img">Image</label>
            <input type="file" id="img" name="image" placeholder="Choose an image" required /><br />

            <button>ADD CAR</button>
        </form>
    </section>

    <!-- <h1>Cars</h1><br> -->

    <table border="1px solid black">
        <thead>
            <tr>
                <th>ID</th>
                <th>Car name</th>
                <th>Fuel Capcaity</th>
                <th>Transmission Type</th>
                <th>Seat Capacity</th>
                <th>Rate</th>
                <th>Img</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $key = 0;
            while ($result = mysqli_fetch_assoc($data)) :
                $key++;
            ?>
                <tr>
                    <td><?= $key; ?></td>
                    <td><?= $result['car_name']; ?></td>
                    <td><?= $result['fuel_capacity']; ?></td>
                    <td><?= $result['transmission_type']; ?></td>
                    <td><?= $result['size']; ?></td>
                    <td><?= $result['rate']; ?></td>
                    <td><img src="./uploads/<?= $result['image'] ?>" height="50" width="80" alt=""></td>
                    <td>
                        <button class="Update"><a href="update.php?updateid=<?= $result['car_id']; ?>">Update</a></button>
                        <button class="Delete"><a href="delete.php?deleteid=<?= $result['car_id']; ?>">Delete</a></button>
                    </td>
                </tr>
            <?php endwhile; ?>

        </tbody>
    </table>

</div>


<?php 

include "./end.php";
?>