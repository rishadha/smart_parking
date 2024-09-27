<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="admin.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

    <title>Admin smart parking</title>
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
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="slot_dash.php">
                <i class='bx bx-book-alt'></i>
                    <span class="text">Slot</span>
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
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <ul class="side-menu">
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

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                    </ul>
                </div>
                <a href="generate_pdf.php" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Download PDF</span>
                </a>
            </div>

            <ul class="box-info">
                <?php
                // Include the Database class file
                include 'Database.php';
                // Create an instance of the Database class
                $database = new Database();

                // Get the database connection object
                $connection = $database->getConnection();
                // Perform a query to get the number of slots
                $sql = "SELECT COUNT(*) AS num_slots FROM slot"; // Change 'slot' to your actual table name if different
                $result = mysqli_query($connection, $sql);

                // Check if the query was successful
                if ($result) {
                    // Fetch the row as an associative array
                    $row = mysqli_fetch_assoc($result);

                    // Get the number of slots from the fetched row
                    $numSlots = $row['num_slots'];

                    // Output the number of slots in your HTML
                    echo '<li>
                                <i class="bx bxs-calendar-check"></i>
                                <span class="text">
                                    <h3>' . $numSlots . '</h3>
                                    <p>Slots</p>
                                </span>
                            </li>';
                } else {
                    // Handle the case where the query fails
                    echo '<li>Error fetching slot data</li>';
                }

                // Close the database connection
                mysqli_close($connection);
                ?>
                <?php

                // Create an instance of the Database class
                $database = new Database();

                // Get the database connection object
                $connection = $database->getConnection();
                // Perform a query to get the number of slots
                $sql = "SELECT COUNT(*) AS num_users FROM users"; // Change 'slot' to your actual table name if different
                $result = mysqli_query($connection, $sql);

                // Check if the query was successful
                if ($result) {
                    // Fetch the row as an associative array
                    $row = mysqli_fetch_assoc($result);

                    // Get the number of slots from the fetched row
                    $numUsers = $row['num_users'];

                    // Output the number of slots in your HTML
                    echo '<li>
                                <i class="bx bxs-group"></i>
                                <span class="text">
                                    <h3>' . $numUsers . '</h3>
                                    <p>Users</p>
                                </span>
                            </li>';
                } else {
                    // Handle the case where the query fails
                    echo '<li>Error fetching slot data</li>';
                }

                // Close the database connection
                mysqli_close($connection);
                ?>
                <?php
                // Create an instance of the Database class
                $database = new Database();

                // Get the database connection object
                $connection = $database->getConnection();

                // Perform a query to get the total transactions
                $sql = "SELECT COUNT(*) AS total_transactions FROM transactions"; // Change 'transactions' to your actual table name if different
                $result = mysqli_query($connection, $sql);

                // Check if the query was successful
                if ($result) {
                    // Fetch the row as an associative array
                    $row = mysqli_fetch_assoc($result);

                    // Get the total transactions from the fetched row
                    $totalTransactions = $row['total_transactions'];

                    // Output the total transactions in your HTML
                    echo '<li>
            <i class="bx bxs-dollar-circle"></i>
            <span class="text">
                <h3>' . $totalTransactions . '</h3>
                <p>Transection</p>
            </span>
          </li>';
                } else {
                    // Handle the case where the query fails
                    echo '<li>Error fetching transaction data</li>';
                }

                // Close the database connection
                mysqli_close($connection);
                ?>
            </ul>


            <div class="table-data">
                <div class="slot">
                    <div class="head">
                        <h3>Recent Slots</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Vehicle Number</th>
                                <th>Slot Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php
                            // Create an instance of the Database class
                            $database = new Database();

                            // Get the database connection object
                            $connection = $database->getConnection();

                            // Perform a query to fetch slot data
                            $sql = "SELECT slotNumber, vehicleNumber, status FROM slot"; // Assuming slotNumber, vehicleNumber, and status are column names in your slot table
                            $result = mysqli_query($connection, $sql);

                            // Check if the query was successful
                            if ($result) {
                                // Iterate over the result set and display slot data in HTML table rows
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['vehicleNumber'] . '</td>';
                                    echo '<td>' . $row['slotNumber'] . '</td>';
                                    // Apply different classes based on the status
                                    $statusClass = ($row['status'] == 'in') ? 'in' : 'out';
                                    echo '<td><span class="status ' . $statusClass . '">' . ucfirst($row['status']) . '</span></td>';
                                    echo '</tr>';
                                }
                            } else {
                                // Handle the case where the query fails
                                echo '<tr><td colspan="3">Error fetching slot data</td></tr>';
                            }

                            // Close the database connection
                            mysqli_close($connection);
                            ?>
                        </tbody>
                    </table>
                </div>



                <div class="todo">
                    <div class="head">
                        <h3>Statistics</h3>
                    </div>
                    <canvas id="myPieChart" width="200px" height="200px"></canvas>
                    <?php
                    // Include your database connection file or class
                    require_once 'database.php';

                    // Create an instance of the Database class or connect to your database
                    $database = new Database();

                    // Get the database connection object
                    $connection = $database->getConnection();

                    // Perform queries to get the counts from each table
                    $sql_slots = "SELECT COUNT(*) AS num_slots FROM slot";
                    $sql_users = "SELECT COUNT(*) AS num_users FROM users";
                    $sql_transactions = "SELECT COUNT(*) AS num_transactions FROM transactions";

                    // Execute the queries
                    $result_slots = mysqli_query($connection, $sql_slots);
                    $result_users = mysqli_query($connection, $sql_users);
                    $result_transactions = mysqli_query($connection, $sql_transactions);

                    // Initialize variables to store counts
                    $slots = 0;
                    $users = 0;
                    $transactions = 0;

                    // Check if the queries were successful and fetch the counts
                    if ($result_slots && $result_users && $result_transactions) {
                        $row_slots = mysqli_fetch_assoc($result_slots);
                        $row_users = mysqli_fetch_assoc($result_users);
                        $row_transactions = mysqli_fetch_assoc($result_transactions);

                        // Assign counts to variables
                        $slots = $row_slots['num_slots'];
                        $users = $row_users['num_users'];
                        $transactions = $row_transactions['num_transactions'];

                        // Output the counts for debugging
                        echo "Slots: " . $slots . "<br>";
                        echo "Users: " . $users . "<br>";
                        echo "Transactions: " . $transactions . "<br>";
                    } else {
                        // Handle the case where one of the queries fails
                        echo "Error fetching data from one of the tables";
                    }
                    // Close the database connection
                    mysqli_close($connection);
                    ?>

                    <script>
                        // Use PHP to echo the data into JavaScript variables
                        const slots = <?php echo $slots; ?>;
                        const users = <?php echo $users; ?>;
                        const transactions = <?php echo $transactions; ?>;

                        // Create data object for the pie chart
                        const data = {
                            labels: ['Slots', 'Users', 'Transactions'],
                            datasets: [{
                                data: [slots, users, transactions],
                                backgroundColor: ['#e815b7', '#231ced', '#f5f511'],
                                hoverBackgroundColor: ['#e815b7', '#231ced', '#f5f511']
                            }]
                        };

                        // Get the canvas element
                        const ctx = document.getElementById('myPieChart').getContext('2d');

                        // Create the pie chart
                        const myPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: data
                        });
                    </script>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->


    <script src="admin.js"></script>
</body>

</html>