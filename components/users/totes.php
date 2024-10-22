<?php
include "./header.php";
include "./navbar.php";
// include "./connection.php";
?>


<div class="collections">

<div class="title">
    <h1>Totes</h1>
</div>
    <div class="cards">
    <?php
      $sql = "SELECT * FROM bags WHERE category='Totes'"; 
        $data = mysqli_query($conn, $sql);
        while ($result = mysqli_fetch_assoc($data)) :

        ?>
        
        <div class="card" >
            <img src="../admin/uploads/<?= $result['image'] ?>" alt="" >
            <h2><?= $result['name'] ?></h2>
            <p style="display: inline-block;font-weight: bold;">Rs.<?= $result['price'] ?></p>
            <button><a href="./rent.php?id=<?= $result['id'] ?>">Add to cart</a></button>
        </div>
        <?php endwhile; ?>
    </div>
</div>





<?php
include "./footer.php";
include "./end.php";
?>
