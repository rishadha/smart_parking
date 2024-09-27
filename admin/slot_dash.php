<?php

include 'Database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>slot</title>
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="slot_das.css">
    <link rel="stylesheet" href="model.css">
    <link rel="stylesheet" href="admin.css">

</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <img src="assets/img/car-logo1.png" alt="Car Logo" width="70" height="70">
            <!-- Replace "path/to/car-logo1.png" with the actual path to your image -->
            <span class="text">Smart parking(pvt)</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="admin_page.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="slot_dash.php">
                    <i class='bx bx-book-alt'></i>
                    <span class="text">slot</span>
                </a>
            </li>
            <li>
                <a href="customer_dash.php">
                    <i class='bx bx-user'></i>
                    <span class="text">Customer</span>
                </a>
            </li>
            <li>
                <a href="transection_dash.php">
                    <i class='bx bx-transfer'></i>
                    <span class="text">Transection</span>
                </a>
            </li>

        </ul>
        <ul class="side-menu">
            <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            <li>
                <a href="../login/login.html" class="logout">
                    <i class='bx bx-log-out'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>

            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>


        </nav>
        <!-- NAVBAR -->

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Slot</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">slot</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container">

                <table>
                    <thead>
                        <tr>
                            <th>Slot ID</th>
                            <th>slotNumber</th>
                            <th>vehicleCategory</th>
                            <th>vehicleName</th>
                            <th>vehicleNumber</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Nic</th>
                            <th>Address</th>
                            <th>Reservation</th>
                            <th>vehicleOut</th>
                            <th>Status</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $db = new Database();
                        $conn = $db->getConnection();

                        $sql = "SELECT * FROM slot";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $durationInMinutes = 0;
                                $payment = 0;

                                // Calculate time duration in minutes if vehicleOut and created_at are set
                                if (!empty($row["vehicleOut"]) && !empty($row["created_at"])) {
                                    $reservationTime = strtotime($row["created_at"]);
                                    $vehicleOut = strtotime($row["vehicleOut"]);
                                    $durationInSeconds = $vehicleOut - $reservationTime;
                                    $durationInMinutes = round($durationInSeconds / 60); // Convert to minutes and round
                        
                                    // Calculate payment
                                    $payment = ($durationInMinutes / 5) * 30;
                                }
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["slotNumber"] . "</td>";
                                echo "<td>" . $row["vehicleCategory"] . "</td>";
                                echo "<td>" . $row["vehicleName"] . "</td>";
                                echo "<td>" . $row["vehicleNumber"] . "</td>";
                                echo "<td>" . $row["ownerName"] . "</td>";
                                echo "<td>" . $row["ownerContact"] . "</td>";
                                echo "<td>" . $row["nic"] . "</td>";
                                echo "<td>" . $row["ownerAddress"] . "</td>";
                                echo "<td>" . $row["created_at"] . "</td>";
                                echo "<td>" . $row["vehicleOut"] . "</td>";
                                echo "<td>" . $row["status"] . "</td>";
                                // Check if the slot status is "IN"
                                if ($row["status"] == "IN") {
                                    // If status is "IN", display the button with the notification form
                                    echo "<td>
                                   <button class='send-notification-btn' data-id='" . $row['id'] . "' onclick='openNotificationForm(" . $row['id'] . ", \"" . $row['slotNumber'] . "\", \"" . $row['ownerName'] . "\", " . $durationInMinutes . ", " . $payment . " )'>

                                        <i class='fas fa-paper-plane'></i> 
                                        Notify 
                                    </button>
                                </td>";

                                    // Calculate payment
                                    $payment = ($durationInMinutes / 5) * 30;
                                } else {
                                    // If status is not "IN", display an empty cell
                                    echo "<td></td>";
                                }
                                // Add button (if needed)
                                // echo "<td><a href='add.php'>Add</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No slots found</td></tr>";
                        }
                        $db->closeConnection();
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="notification-modal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="closeNotificationForm()">&times;</span>
                    <h2>Send Notification</h2>
                    <form id="notification-form" action="model_db.php" method="POST">
                        <div class="form-group">
                            <label for="slot-id">Slot ID:</label>
                            <input type="text" id="slot-id" name="slot_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="slot-number">Slot Number:</label>
                            <input type="text" id="slot-number" name="slot_number" readonly>
                        </div>
                        <div class="form-group">
                            <label for="owner-name">Owner Name:</label>
                            <input type="text" id="owner-name" name="owner_name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration:</label>
                            <input type="text" id="duration" name="duration" readonly>
                        </div>
                        <div class="form-group">
                            <label for="payment">Payment</label>
                            <input type="text" id="payment" name="payment" readonly>
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" rows="4"></textarea>
                        </div>
                        <button type="submit" class="send-notification-btn"><i class="fas fa-paper-plane"></i>
                            Send</button>
                    </form>
                </div>
            </div>

            <main>

                </div>

    </section>
    <script src="admin.js"></script>
    <script>
        function openNotificationForm(id, slotNumber, ownerName, duration, payment) {
            // Open the notification form
            document.getElementById('notification-modal').style.display = "block";

            // Populate the form with slotNumber, ownerName, and slotId
            document.getElementById('slot-id').value = id;
            document.getElementById('slot-number').value = slotNumber;
            document.getElementById('owner-name').value = ownerName;
            document.getElementById('duration').value = duration;
            document.getElementById('payment').value = payment;
        }

        function closeNotificationForm() {
            // Close the notification form
            document.getElementById('notification-modal').style.display = "none";
        }
    </script>





</body>

</html>