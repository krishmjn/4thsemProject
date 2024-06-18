<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Popup</title>
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
    include "../connection.php";
    include "./header.php";
    $key = $_GET['carname'];
    $car_id = $_GET['carid'];

    $errors = [];
    if (!empty($_POST)) {
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $is_book = true;

        // Perform date validation
        if (strtotime($date1) < strtotime('today') || strtotime($date2) < strtotime('today')) {
            $errors[] = "Please select pickup and return dates from today onwards.";
        } elseif (strtotime($date2) < strtotime($date1)) {
            $errors[] = "Return date must be after pickup date.";
        }


        if (empty($errors)) {
            $sql = "INSERT INTO user_bookings(user_id,pickup_date,return_date,car_id)
        VALUES('$id','$date1','$date2','$car_id')";

            $sql2 = "UPDATE car SET is_book = '$is_book' WHERE car_id = '$car_id';
        ";
            $res2 = mysqli_query($conn, $sql2);

            $res = mysqli_query($conn, $sql);


            if ($res) {
                // Successful insertion
                header("location: ./profile.php");
                exit;
            } else {
                // Error in query
                $errors[] = "Error: " . mysqli_error($conn);
            }
        }
    }

    // Output errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='overlay' id='overlay'></div>";
            echo "<div class='popup' id='popup'>";
            echo "<h2>Error:</h2>";
            echo "<p>$error</p>";
            echo "<button class='close-btn' onclick='closePopup()'>Close</button>";
            echo "</div>";
            echo "<script>document.getElementById('overlay').style.display = 'block'; document.getElementById('popup').style.display = 'block';</script>";
        }
    }
    ?>

    <section class="carform">
        <form action="" method="post">
            <h2><span>RENTNOW</span><br />CARRENTAL</h2>
            <div class="pr">
                <div class="pickup">
                    <label for="date1">Pickup Date</label>
                    <input type="date" id="date1" name="date1" placeholder="Date Here" required />
                </div>
                <div class="return">
                    <label for="date2">Return Date</label>
                    <input type="date" id="date2" name="date2" placeholder="Date Here" required /><br />
                </div>
            </div>
            <button>Rent Now</button>
        </form>
    </section>

    <script>
        function closePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    </script>

</body>

</html>