<?php
session_start();


//echo "<br/> <br/> <br/><br/>Slot ID set in session: " . $_SESSION['slot_id'];
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "smart_parking";
    protected $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}

// Retrieve the logged-in user's username from the session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot</title>

    <!-- Link Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="img/car-logo1.png" type="image/x-icon">
    <!-- Link File CSS -->
    <link rel="stylesheet" href="slot.css">
    <link rel="stylesheet" href="slot1.css">
    <link href="responsive.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .notification-dropdown {
            position: absolute;
            top: 30px;
            /* Adjust as needed */
            right: 10px;
            /* Adjust as needed */
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            display: none;
            /* Initially hidden */
        }
    </style>
</head>

<body>
    <header>
        <nav class="custom_nav-container navbar-expand-lg">
            <img src="img/car-logo1.png" class="logo" alt="">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="menu navbar-nav">
                    <a href="../user/user_page.php" class="nav-link">Home</a>
                    <a href="../about/about.html" class="nav-link">About</a>
                    <a href="../parking/parking.php" class="nav-link">Book Here</a>
                    <a href="../slot/slot.php" class="nav-link">Slot</a>
                    <a href="../login/login.html" class="nav-link">Logout</a>
                    <label for="switch-mode" class="switch-mode"></label>
                    <a href="#" class="notification" onclick="toggleNotification()">
                        <i class='bx bxs-bell'></i>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <br />
    <br /><br />
    <br /><br />

    <div class="container">
        <h2>Slots</h2>
        <table>
            <tr>
                <th>Slot Number</th>
                <th>Vehicle Category</th>
                <th>Vehicle Name</th>
                <th>vehicle-in</th>
                <th>vehicle-out</th>
                <th>status</th>
                <th></th>
                <!-- Add more table headers for other slot details -->
            </tr>
            <tr>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "smart_parking";
                
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Step 2: Prepare and execute the SQL query
                $username = $_SESSION['username']; // Assuming you have defined this variable

                $sql = "SELECT s.*, u.username, u.phone_number
                        FROM slot s
                        JOIN users u ON s.added_by = u.username 
                        -- AND s.ownerContact = u.phone_number
                        WHERE u.username = ? ORDER BY reservationTime";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();

                // Step 3: Fetch data and display in HTML table
                if ($result = $stmt->get_result()) {
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                       
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["slotNumber"] . "</td>";
                            echo "<td>" . $row["vehicleCategory"] . "</td>";
                            echo "<td>" . $row["vehicleName"] . "</td>";
                            echo "<td>" . $row["reservationTime"] . "</td>";
                            echo "<td>" . $row["vehicleOut"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";

                            if ($row["status"]=='OUT') {
                                $disable="disabled";
                            } else {
                                $disable="";
                            }

                            echo "
                            <td>
                                <form action='update_slot.php' method='post'>
                                    <input type='hidden' name='slot_id' value='" . $row["id"] . "'>
                                    <input type='hidden' name='slot_num' value='" . $row["slotNumber"] . "'>
                                    <button type='submit' name='mark_out' $disable>Mark Out</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                        
                        // echo "</table>";
                    } else {
                        echo "No rows found.";
                    }
                } else {
                    // Error handling
                    echo "Error executing query: " . $conn->error;
                }

                // echo $sql;

                ?>
            </tr>
        </table>
    </div>


    <div id="notification-container" class="notification-container">
        <div id="notification-dropdown" class="notification-dropdown">
            <p style="font-awesome ">
            <h4>Your notification messages here</h4>
            </p>
            <?php
            // Include your database connection file
            
            // Connect to the database
            $db = new Database();
            $conn = $db->getConnection();

            // Query to fetch all columns from the 'model' table
            $sql = "SELECT * FROM model WHERE owner_name = ?"; // Update 'condition_here' with appropriate conditions if needed
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            // Execute the query
            $result = $stmt->get_result();

            // Check if the query was successful and if there are rows returned
            if ($result && $result->num_rows > 0) {
                // Fetch each row from the result set
                while ($row = $result->fetch_assoc()) {
                    // Output the data in the desired format
                    echo "<div class='container' style='border: 1px solid #ccc; padding: 10px; '>";
                    echo "<span style='text-decoration: underline;'>Slot Number " . $row['slot_number'] . " " . $row['owner_name'] . " </span>";
                    echo "<div class='column'> " . " " . $row['duration'] . " minutes " . $row['payment'] . " " . "</div>";
                    echo "<div class='column' colspan='3'>" . $row['description'] . "</div>";
                    echo "</div>";
                }
            } else {
                // Handle case when no data is found
                echo "No Notifications Here!.";
            }

            // Close the database connection
            $db->closeConnection();
            ?>

        </div>
    </div>

    <script>
        function toggleNotification() {
            var dropdown = document.getElementById("notification-dropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none"; // Hide the dropdown if it's already visible
            } else {
                dropdown.style.display = "block"; // Show the dropdown if it's hidden
            }
        }

        document.addEventListener('click', function (event) {
            var dropdown = document.getElementById("notification-dropdown");
            var container = document.getElementById("notification-container");
            if (event.target !== container && event.target.closest(".notification") === null) {
                dropdown.style.display = "none"; // Hide the dropdown if clicked outside the container or notification icon
            }
        });
    </script>
</body>

</html>