<?php
include "./header.php";
?>
<div class="des">
    <div class="rectangle">
        <img src="../icons/Rectangle 4.png" alt="">
        <h2>"Hit the road with ease! <br> Find <br>your perfect ride today." </h2>
    </div>
    <div class="image">
        <img src="../icons/pngwing 1.png" alt="">
    </div>
</div>

<div class="clist">
    <div class="lt">
        <img src="../icons/left triangle.png" alt="">
    </div>
    <div class="company">
        <img src="../icons/company name/Group 1.png" alt="">
    </div>
    <div class="rt">
        <img src="../icons/right triangle.png" alt="">
    </div>
</div>

<div class="carDeals">
    <h2>Most popular car rental deals</h2>

    <div class="cards" id="Cards">
        <?php
        $sql = "SELECT car.*,fuel.fuel_capacity,seat.size,transmission.transmission_type FROM car JOIN fuel ON car.fuel_id = fuel.fuel_id JOIN seat ON car.seat_id = seat.seat_id JOIN transmission ON car.transmission_id = transmission.transmission_id;";
        $data = mysqli_query($conn, $sql);
        while ($result = mysqli_fetch_assoc($data)) :

        ?>
            <div class="card">
                <h3><?= $result['car_name'] ?></h3>
                <img src="./admin/uploads/<?= $result['image'] ?>" alt="">
                <div class="features">
                    <!-- Fuel litre  -->
                    <div class="fl">
                        <img src="../icons/Features/GasPump.png" alt="">
                        <p><?= $result['fuel_capacity'] ?></p>
                    </div>
                    <!-- transmission type  -->
                    <div class="tt">
                        <img src="../icons/Features/SteeringWheel.png" alt="">
                        <p><?= $result['transmission_type'] ?></p>
                    </div>
                    <!-- seat capacity  -->
                    <div class="sc">
                        <img src="../icons/Features/UsersThree.png" alt="">
                        <p><?= $result['size'] ?></p>
                    </div>
                </div>

                <div class="details">
                    <div class="rate">
                        <p><?= $result['rate'] ?></p>
                        <p>Rate per day</p>
                    </div>
                    <!-- rent button  -->
                    <div class="rb">
                        <button class="rent"><a href="./signin.php">RentNow</a></button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

    </div>
</div>

<?php
include "./footer.php"
?>