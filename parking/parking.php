<?php
session_start();
include '../admin/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slots</title>
    <link rel="stylesheet" href="parking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="../slot/img/car-logo1.png" type="image/x-icon">
    <!-- Link File CSS -->
    <link rel="stylesheet" href="../slot/slot.css">
    <link href="responsive.css" rel="..slot/stylesheet" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <!-- My CSS -->
  
</head>

<body>
    
<header>
        <nav class="custom_nav-container navbar-expand-lg">
            <img src="../slot/img/car-logo1.png" class="logo" alt="">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="menu navbar-nav">
                    <a href="../user/user_page.php" class="nav-link">Home</a>
                    <a href="../about/about.html" class="nav-link">About</a>
                    <a href="../parking/parking.php" class="nav-link">Book Here</a>
                    <a href="../slot/slot.php" class="nav-link">Slot</a>
                    <a href="../login/login.html" class="nav-link">Logout</a>
                    
                </div>

              
            </div>
        </nav>
    </header>
    <br/>
    <br/>
    <div class="parking-area">
    <div class="header">
        <br/><br/>
        <H1> Book your slot for paking </H1>
    </div>
    <?php

        // Create a new instance of the Database class
        $database = new Database();

        // Get the database connection
        $connection = $database->getConnection();
        // Query to fetch status of each slot
        $query = "SELECT slotNumber, status FROM slot WHERE status = 'IN'";
        $result = mysqli_query($connection, $query);

        // Initialize an empty status array
        $status_array = array();

        // Fetch status values and populate status array
        while ($row = mysqli_fetch_assoc($result)) {
            $status_array[$row['slotNumber']] = $row['status'];
        }
        ?>


<div class="parking-row">
    <?php
    // Loop through slots 1 to 5
    for ($i = 1; $i <= 8; $i++) {
        // Check status of slot $i in your database
        $query = "SELECT status FROM slot WHERE slotNumber = $i";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $status = isset($row['status']) ? $row['status'] : ''; // Check if status is set

            // Apply different CSS class based on the status
            if ($status == "IN") {
                // Apply booked class
                echo '<div class="parking-slot booked"><div class="slot-number">' . $i . '</div></div>';
            } else {
                // Apply default class
                echo '<div class="parking-slot" onclick="showForm(' . $i . ')"><div class="slot-number">' . $i . '</div></div>';
            }
        } else {
            // Handle query error
            //echo '<div class="parking-slot"><div class="slot-number">' . $i . '</div></div>'; // Default class if query fails
        }
    }
    ?>
</div>
        <div class="road-line"></div></br></br></br>
        <div class="road-dash-line"></div> </br></br></br>
        <div class="road-line">
        </br>
        <div class="parking-row">
        <div class="parking-row">
    <?php
    // Loop through slots 1 to 5
    for ($i = 9; $i <= 16; $i++) {
        // Check status of slot $i in your database
        $query = "SELECT status FROM slot WHERE slotNumber = $i";
        $result = mysqli_query($connection, $query);

        if ($result) {
        
            $row = mysqli_fetch_assoc($result);
            $status = isset($row['status']) ? $row['status'] : ''; // Check if status is set

            // Apply different CSS class based on the status
            if ($status == "IN") {
                // Apply booked class
                echo '<div class="parking-slot booked"><div class="slot-number">' . $i . '</div></div>';
            } else {
                // Apply default class
                echo '<div class="parking-slot" onclick="showForm(' . $i . ')" ><div class="slot-number">' . $i . '</div></div>';
            }
        } else {
            // Handle query error
            echo '<div class="parking-slot"><div class="slot-number">' . $i . '</div></div>'; // Default class if query fails
        }
    }
    ?>
</div>


    </div>
        <br/>

        <div class="button-row">
            <!-- Go Back button -->
            <form class="back-button" action="../user/user_page.php">
                <button type="submit" class="btn-close">Go Back</button>
            </form>

            <!-- Logout button -->
            <form class="logout-button" action="../login/login.html">
                <button type="submit" class="btn-submit">Logout</button>
            </form>
        </div>
        
    </div>

    <!-- Add this form within the body of your HTML document -->
<div class="form-container" id="formContainer"  >
    <h2 class="h1"> Enter The Information</h2>

    <form id="parkingForm" action="infor_db.php" method="post">

    <label for="slotNumber">Slot Number:</label>
    <input type="text" id="slotNumber" name="slotNumber" readonly>
    
        <label for="vehicleCategory">Vehicle Category:</label>
        <select id="vehicleCategory" name="vehicleCategory">
            <option value="2-wheeler">2 Wheeler</option>
            <option value="3-wheeler">3 Wheeler</option>
            <option value="4-wheeler">4 Wheeler</option>
        </select>

        <label for="vehicleName">Vehicle Name:</label>
        <input type="text" id="vehicleName" name="vehicleName" required>

        <label for="vehicleNumber">Vehicle Number:</label>
        <input type="text" id="vehicleNumber" name="vehicleNumber" required>

        <label for="ownerName">Owner Name:</label>
        <input type="text" id="ownerName" name="ownerName" required>

        <label for="ownerContact">Owner Contact Number:</label>
        <input type="tel" id="ownerContact" name="ownerContact" pattern="[0-9]{10}" required>
        <small>*Enter a 10-digit phone number.</small>

        <label for="nic">NIC:</label>
        <input type="tel" id="nic" name="nic" required>

        <label for="ownerAddress">Owner Address:</label>
        <textarea id="ownerAddress" name="ownerAddress" rows="1" required></textarea>

    </form>
    <button type="submit" onclick="document.getElementById('parkingForm').submit()">Submit</button>
    <button type="close" onclick="hideForm()">Close</button>
</div>


    <script src="parking.js"></script>
</body>

</html>
