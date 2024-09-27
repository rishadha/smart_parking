<?php

include 'Database.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <titlcustomer</title>
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="slot_das.css">
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
            <li >
                <a href="admin_page.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="slot_dash.php">
                <i class='bx bx-book-alt'></i>
                    <span class="text">slot</span>
                </a>
            </li>
            <li class="active">
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
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
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
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>

        </nav>
        <!-- NAVBAR -->

<main> 
<div class="head-title">
    <div class="left">
        <h1>Users</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Users</a>
            </li>
         </ul>
    </div>
</div>    

<div class="container">
    <table style="text-align: center;">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Role</th>
                <th>Username</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $db = new Database();
            $conn = $db->getConnection();

            $sql = "SELECT id, role, username, phone_number FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["role"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["phone_number"] . "</td>";
                    echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a>  <a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }
            $db->closeConnection();
            ?>
        </tbody>
    </table>
</div>


<main>
</section>
    <script src="admin.js"></script>
</body>
</html>