
<!DOCTYPE html>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy</title>
    <style>
        /* Styles for Popup */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .close-btn {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: orangered;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php
    // include "../connection.php";
    include "./navbar.php";
    include "./header.php";
    
    $id = $_GET['id'];
    $_SESSION['bag_id']=$id;

  

 if(!empty($_POST)){

 }
  

    $sql3 = "SELECT * FROM bags WHERE id='$id'";
    $resCar = mysqli_query($conn, $sql3);
    if ($resCar) {
        $result = mysqli_fetch_assoc($resCar);
        if ($result) {
            $name = $result['name'];
            $volume = $result['volume'];
            $colour = $result['colour'];
            $category = $result['category'];
            $price = $result['price'];
            $image = $result['image'];
            $fabric = $result['fabric'];

        } else {
            $errors[] = "No bag found with the specified ID.";
        }
    } else {
        $errors[] = "Error fetching bag details: " . mysqli_error($conn);
    }
    ?>


    <div class="rentContainer">

        <section class="carDetails">
            <div class="img">
                <img src="../admin/uploads/<?= $result['image'] ?>" alt="">
            </div>
            <div class="detailss">
                <h3><?= $name ?></h3><br>
                <div class="infocar">
                    <!-- Fuel litre  -->
                    <div class="det">
                <label for="">Price : </label>
                        
                        <p><?= $result['price'] ?></p>
                    </div>
                    <!-- transmission type  -->
                    <div class="det">
                <label for="">Volume : </label>

                        <p><?= $result['volume'] ?></p>
                    </div>
                    <!-- seat capacity  -->
                    <div class="det">
                <label for="">Category : </label>

                        <p><?= $result['category'] ?></p>
                    </div>
                    <div class="det">
                <label for="">Colour : </label>

                        <p><?= $result['colour'] ?></p>
                    </div>
                    <div class="det">
                <label for="">Fabric : </label>

                        <p><?= $result['fabric'] ?></p>
                    </div>
                     <div class="det">
                <label for="">Stock available : </label>

                        <p><?= $result['stock'] ?></p>
                    </div>
                </div>
                <div class="carts">
                <button class="add" id="add">+</button>
                <input type="text" class="label" name="qty" id="quant">
                <button class="sub" id="sub">-</button><br>
                <!-- <button type="submit"><a href="./profile.php?id=<?= $_SESSION['id']?>&bag_id=<?= $id?>">Add to cart</a></button> -->
                 <button id="addToCart">Add to cart</button>
            </div>
            </div>
           

        </section>



      
    </div>

    <script>
   var qt = 0;

document.getElementById("add").addEventListener("click", () => {
    qt += 1; // Increment the value of qt
    document.getElementById("quant").value = qt;
});

document.getElementById("sub").addEventListener("click", () => {
    if (qt > 0) { // Ensure qt doesn't go below 0
        qt -= 1; // Decrement the value of qt
    }
    document.getElementById("quant").value = qt;
});
// Add to Cart functionality with Ajax
document.getElementById('addToCart').addEventListener('click', function() {
    var qty = document.getElementById('quant').value;
    var bagId = '<?= $id ?>'; // Bag ID from PHP
    var userId = '<?= $_SESSION['id'] ?>'; // User ID from PHP session

    // Check if the quantity is valid before sending the request
    if (qty <= 0) {
        alert('Please select the number of quantities.');
        return; // Exit the function if quantity is invalid
    }

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            // After successful request, redirect to cart.php
            alert('Item added to cart successfully!');
            window.location.href = './cart.php'; // Redirect to cart.php
        } else {
            alert('Error adding item to cart.');
        }
    };

    // Send the request with parameters
    xhr.send('qty=' + qty + '&bag_id=' + bagId + '&user_id=' + userId);
});


    </script>


</body>

</html>


<?php

include "./end.php";
?>