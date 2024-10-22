<?php
include "./header.php";
include "./navbar.php";
include "./connection.php";
?>


<div class="collections">
    <div class="cards">
    <?php
        $sql = "SELECT * FROM bags";
        $data = mysqli_query($conn, $sql);
        while ($result = mysqli_fetch_assoc($data)) :

        ?>
        
        <div class="card" >
            <img src="./admin/uploads/<?= $result['image'] ?>" alt="" >
            <h2><?= $result['name'] ?></h2>
            <p style="display: inline-block;font-weight: bold;">Rs.<?= $result['price'] ?></p>
            <button><a href="./signin.php">Add to cart</a></button>
        </div>
        <?php endwhile; ?>
    </div>
</div>





<?php
include "./footer.php";
include "./end.php";
?>