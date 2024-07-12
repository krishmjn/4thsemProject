<?php
include "./navbar.php";
include "./connection.php";
$folder = "/images";
if (!isset($_SESSION['is_login'])) {
    header('location:./login.php');
    exit();
}


$limit = 5; // Number of entries to show in a page.
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

// Fetch the total number of records
$sql = "SELECT COUNT(car_id) FROM car";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);

// Fetch records for the current page
$sql = "SELECT * FROM car LIMIT $start_from, $limit";
$data = mysqli_query($conn, $sql);

if (!$data) {
    die("Error fetching data: " . mysqli_error($conn));
}
?>
<style>
    .pagination {
        display: flex;
        justify-content: center;
        /* margin-top: 5px; */
    }
    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
        margin: 0 4px;
    }
    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }
    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }
   
</style>
<div class="users">
    <button class="Update"><a href="./add_cars.php">Add Car</a></button>
  <div class="con">

    <table border="1px solid black" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Car name</th>
                <th>Fuel Capacity</th>
                <th>Transmission Type</th>
                <th>Seat Capacity</th>
                <th>Rate</th>
                <th>Engine</th>
                <th>Model</th>
                <th>Mileage</th>
                <th>Fuel Type</th>
                <th>Quantity</th>
                <th>Img</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $key = $start_from;
            while ($result = mysqli_fetch_assoc($data)) {
                $key++;
                ?>
                <tr>
                    <td><?= $key; ?></td>
                    <td><?= $result['car_name']; ?></td>
                    <td><?= $result['fuel_capacity']; ?></td>
                    <td><?= $result['transmission_type']; ?></td>
                    <td><?= $result['seat_capacity']; ?></td>
                    <td><?= $result['rate']; ?></td>
                    <td><?= $result['engine']; ?></td>
                    <td><?= $result['modal']; ?></td>
                    <td><?= $result['mileage']; ?></td>
                    <td><?= $result['fuelType']; ?></td>
                    <td><?= $result['Quantity']; ?></td>
                    <td><img src="./uploads/<?= $result['image'] ?>" height="50" width="80" alt=""></td>
                    <td>
                        <button class="Update"><a href="update.php?updateid=<?= $result['car_id']; ?>">Update</a></button>
                        <button class="Delete"><a href="delete.php?deleteid=<?= $result['car_id']; ?>">Delete</a></button>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>

    </table>

    <!-- Pagination Links -->
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo "<a href='cars.php?page=" . ($page - 1) . "'>&laquo; Previous</a>";
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<a class='active' href='cars.php?page=" . $i . "'>" . $i . "</a>";
            } else {
                echo "<a href='cars.php?page=" . $i . "'>" . $i . "</a>";
            }
        }

        if ($page < $total_pages) {
            echo "<a href='cars.php?page=" . ($page + 1) . "'>Next &raquo;</a>";
        }
        ?>
    </div>
    </div>
</div>
