<?php
include "./navbar.php";
$sql = "SELECT car.*,fuel.fuel_capacity,seat.size,transmission.transmission_type FROM car JOIN fuel ON car.fuel_id = fuel.fuel_id JOIN seat ON car.seat_id = seat.seat_id JOIN transmission ON car.transmission_id = transmission.transmission_id;";
$data = mysqli_query($conn, $sql);
?>


<div class="cars">
    <?php

    while ($result = mysqli_fetch_assoc($data)) :

    ?>
        <div class="card">
            <h3><?= $result['car_name'] ?></h3>
            <img src="../admin/uploads/<?= $result['image'] ?>" alt="">
            <div class="features">
                <!-- Fuel litre  -->
                <div class="fl">
                    <img src="../../icons/Features/GasPump.png" alt="">
                    <p><?= $result['fuel_capacity'] ?></p>
                </div>
                <!-- transmission type  -->
                <div class="tt">
                    <img src="../../icons/Features/SteeringWheel.png" alt="">
                    <p><?= $result['transmission_type'] ?></p>
                </div>
                <!-- seat capacity  -->
                <div class="sc">
                    <img src="../../icons/Features/UsersThree.png" alt="">
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
                    <?php
                    if ($result['is_book']) {
                    ?>
                        <!-- <button disabled class="rent"><a href=" ">Not Available</a></button> -->
                        <a href=""><button disabled>Not Available</button></a>
                    <?php
                    }
                    ?> <?php
                        if (!$result['is_book']) {
                        ?>
                        <button class="rent"><a href="./rent.php?carname=<?= $result['car_name'] ?>&carid=<?= $result['car_id']; ?>">Rent Now</a></button>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

</div>

<?php
include "./end.php";
?>