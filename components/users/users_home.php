<?php
include "./navbar.php";
// include "../connection.php"; 

if (!isset($_SESSION['is_login'])) {
    header('location:./../signin.php');
    exit();
}
?>

<div class="des">
<div class="carousel-container">
  <div class="carousel-slide">
    <img src="../../icons/jhola/backpacks/boulder-mocha.jpg" alt="Boulder Mocha Bag" height="600px" width="500px">
    <img src="../../icons/jhola/totes/brown_tote.jpg" alt="Another Bag" height="600px" width="500px">
    <img src="../../icons/jhola/Hip Packs/blue_white.jpg" alt="Yet Another Bag" height="600px" width="500px">
  </div>
</div>
   
    
    <div class="rectangle">
        <h2>"Carry Style, Carry Confidence." </h2>
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
            <img src="../admin/uploads/<?= $result['image'] ?>" alt="" >
            <h2><?= $result['name'] ?></h2>
            <p style="display: inline-block;font-weight: bold;">Rs.<?= $result['price'] ?></p>
            <?php if ($result['stock'] > 0) : ?>
                <button><a href="./rent.php?id=<?= $result['id'] ?>">Add to cart</a></button>
            <?php else : ?>
                <span style="color: red; font-weight: bold;">Out of Stock</span>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>

       
     
    </div>
</div>
<script>
  const slideContainer = document.querySelector('.carousel-slide');
  const slides = document.querySelectorAll('.carousel-slide img');

  let currentIndex = 0;
  const totalSlides = slides.length;

  function autoSlide() {
    currentIndex++;
    if (currentIndex >= totalSlides) {
      currentIndex = 0;
    }
    slideContainer.style.transform = `translateX(${-currentIndex * 500}px)`; // 500px is the width of each image
  }

  setInterval(autoSlide, 3000); // Slide every 3 seconds
</script>



<?php
include "./end.php";
include "./footer.php"
?>