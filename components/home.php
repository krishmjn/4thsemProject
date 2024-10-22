<?php
include "./header.php";
?>
<div class="des">
    
    <div class="image">
        <img id="hero-img" src="../icons/jhola/backpacks/boulder-mocha.jpg" alt="" height="600px" width="500px">
    </div>
    <div class="rectangle">
        <h2>"Carry Style, Carry Confidence." </h2>
        <p>Introducing the all new <span class="orange">Boulder Sacks</span> <br> Available Colors :  <br>
        <div class="colors">
        <div class="mocha" onclick="changeImage('../icons/jhola/backpacks/boulder-mocha.jpg')"></div>
            <div class="blue" onclick="changeImage('../icons/jhola/backpacks/boulder-blue.jpg')"></div>
            <div class="black" onclick="changeImage('../icons/jhola/backpacks/boulder-black.jpg')"></div>
            <div class="pink" onclick="changeImage('../icons/jhola/backpacks/boulder-pink.jpg')"></div>
    </div>
    </p>
    </div>
</div>

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


<script>
    function changeImage(newSrc) {
        document.getElementById("hero-img").src = newSrc;
    }
</script>


<?php
include "./footer.php"
?>