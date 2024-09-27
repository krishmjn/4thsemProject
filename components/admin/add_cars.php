
<?php
include "./navbar.php";
include "./connection.php";
$folder = "/images";
if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}

if (!empty($_POST)) {
    $bag_name = $_POST['name'];
    $fabric=$_POST['fabric'];
    $volume=$_POST['volume'];
    $category=$_POST['category'];
    $price=$_POST['price'];
    $stock=$_POST['stock'];
    $colour=$_POST['colour'];

    

    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $path = './uploads/';
        move_uploaded_file($tmp, $path . $image);
    }

    $sql = "INSERT INTO bags(name, price, category, colour, stock, fabric, volume)
            VALUES('$bag_name', '$price', '$category', '$colour', '$stock', '$fabric', '$volume')";
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
            <h2><span>Add</span>Bags</h2>

            <label for="name">Bag name</label>
            <input type="text" id="name" name="name" placeholder="Enter Bag Name" required /><br />

            <label for="fabric">Fabric</label>
            <input type="text" id="fuel_capacity" name="fabric" placeholder="Enter Fabric Used" required /><br />

            <label for="cars">Category : </label>
            <select name="category" id="transmission">
                <option value="Backpacks">Backpacks</option>
                <option value="Totes">Totes</option>
                <option value="HipPacks">Hip Packs</option>

            </select> <br><br>

            <label for="rate">Price</label>
            <input type="text" id="rate" name="price" placeholder="Enter PRice" required /><br />

            <label for="rate">Stock</label>
            <input type="text" id="rate" name="stock" placeholder="Enter Stocks Available" required /><br />
            <label for="rate">Colour</label>
            <input type="text" id="rate" name="colour" placeholder="Enter Stocks Available" required /><br />
            <label for="rate">Volume</label>
            <input type="text" id="rate" name="volume" placeholder="Enter Stocks Available" required /><br />

           

            
            <label for="img">Image</label>
            <input type="file" id="img" name="image" placeholder="Choose an image" required /><br />

            <button>ADD BAG</button>
        </form>
    </section>