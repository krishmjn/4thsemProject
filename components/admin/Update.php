<?php
include "./navbar.php";
include "./connection.php";

$key = $_GET['updateid'];

if (!empty($_POST)) {
    $bag_name = $_POST['name'];
    $category = $_POST['category'];
    $colour = $_POST['colour'];
    $price = $_POST['price'];
    $volume = $_POST['volume'];
    $fabric = $_POST['fabric'];
    $stock = $_POST['stock']; // Adding the stock field

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

    // Corrected SQL query without comment
    $sql = "UPDATE bags SET 
            name='$bag_name', 
            category='$category', 
            colour='$colour', 
            price='$price', 
            volume='$volume', 
            fabric='$fabric',
            stock='$stock' 
            $image_sql 
            WHERE id='$key'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo "Updated successfully";
        header("location:./bags.php");  // Assuming this still redirects to `cars.php`. Update if needed.
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

$sql = "SELECT * FROM `bags` WHERE id='$key'";
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
            <h2><span>Update</span> Bags</h2>

            <label for="name">Bag name</label>
            <input type="text" id="name" name="name" value="<?= $result['name'] ?>" required /><br />

            <label for="fuel_capacity">Category</label>
            <input type="text" id="fuel_capacity" name="category" value="<?= $result['category'] ?>" required /><br />

            <label for="transmission">Colour</label>
            <input type="text" id="transmission" name="colour" value="<?= $result['colour'] ?>" required /><br /><br>

            <label for="seat">Price</label>
            <input type="text" id="seat" name="price" value="<?= $result['price'] ?>" required /><br />

            <label for="rate">Volume</label>
            <input type="text" id="rate" name="volume" value="<?= $result['volume'] ?>" required /><br />

            <label for="engine">Fabric</label>
            <input type="text" id="engine" name="fabric" value="<?= $result['fabric'] ?>" required /><br />

            <!-- New Stock field -->
            <label for="stock">Stock</label>
            <input type="text" id="stock" name="stock" value="<?= $result['stock'] ?>" required /><br />

            <label for="img">Image</label>
            <input type="file" id="img" name="image" /><br />
            <img src="./uploads/<?= $result['image'] ?>" height="50" width="80" alt=""><br />

            <button>Update</button>
        </form>
    </section>
</div>
