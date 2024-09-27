<?php
session_start();

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

        // Set the timezone to 'Asia/Colombo'
        $this->conn->query("SET time_zone = 'Asia/Colombo'");
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

$slotid = $_GET['slot_id'];
$slotNumber = $_GET['slot_num'];

// Rest of your code...
$db = new Database();

// Retrieve the logged-in user's username from the session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Create an instance of the Database class
$conn = $db->getConnection();

// Fetch data from the database based on username and status
$query = "SELECT slot.*, users.username
          FROM `slot`
          JOIN `users` ON slot.ownerName = users.username
          WHERE slot.ownerName = ? AND slot.status = 'IN' AND slot.id=$slotid";

$stmt = $conn->prepare($query);

// Check for errors in the preparation
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $username); // Use 's' for string type
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables
$carNumber = $ownerName = $reservationTime = $vehicleOut = '';

// Check if data is retrieved successfully
if ($result->num_rows > 0) {
    $slotData = $result->fetch_assoc();
    // $slotNumber = $slotData['slotNumber'];
    $carNumber = $slotData['vehicleNumber'];
    $ownerName = $slotData['ownerName'];
    $reservationTime = $slotData['created_at'];
    $vehicleOut = $slotData['vehicleOut'];
}

// Close the database connection
$db->closeConnection();
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
    <link rel="stylesheet" href="../slot/slot.css">
    <link rel="stylesheet" href="../payment/payment.css">
    <link href="responsive.css" rel="stylesheet" />


    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="../about/css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,600,700&display=swap"
        rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="../about/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="../about/css/responsive.css" rel="stylesheet" />
    <style>
        .pay-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .pay-button:hover {
            background-color: #0056b3;
        }

        .cancel-button {
            background-color: #ddd;
            color: #555;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .cancel-button:hover {
            background-color: #0056b3;
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
                </div>
            </div>
        </nav>
    </header>
    <br />
    <br /><br />
    <br /><br />
    <div class="container">
        <h2> Payment </h2>
        </br>
        <p>Welcome to our convenient and affordable parking service! At our facility,
            we understand the importance of flexibility and fair pricing.
            With us, you pay only for the time you use, with each 05 minutes of parking charged at just Rs. 30.
            Whether you're running a quick errand or need a longer stay, our transparent pricing
            ensures you always get great value for your money. Say goodbye to overpriced parking fees and
            hello to simplicity and savings. Park with us today and experience hassle-free parking at its
            finest! </P>
    </div>
    <section class="about_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6 px-0">
                    <div class="img_container">
                        <div class="img-box">
                            <img src="../about/images/logo.jpeg" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6 px-0">
                    <div class="detail-box">
                        <div class="heading_container ">
                            <h2>Bill</h2>
                            <div class="bill-container">
                                <form
                                    action="checkout.php?slotNumber=<?php echo isset($slotNumber) ? $slotNumber : ''; ?>"
                                    method="POST">
                                    <div class="bill-item">
                                        <span class="bill-label"
                                            style="font-weight: bold; font-size: 24px; margin: 0 auto; display: block; width: fit-content;">
                                            Slot Number
                                            <?php echo isset($slotNumber) ? $slotNumber : ''; ?>
                                        </span>
                                        <input type="hidden" name="slotNumber"
                                            value="<?php echo isset($slotNumber) ? $slotNumber : ''; ?>">
                                    </div>

                                    <div class="bill-item">
                                        <span class="bill-label">Car Number:</span>
                                        <span class="bill-value">
                                            <?php echo isset($carNumber) ? $carNumber : ''; ?>
                                            <input type="hidden" name="carNumber"
                                                value="<?php echo isset($carNumber) ? $carNumber : ''; ?>">
                                        </span>
                                    </div>
                                    <div class="bill-item">
                                        <span class="bill-label">Owner Name:</span>
                                        <span class="bill-value">
                                            <?php echo isset($ownerName) ? $ownerName : ''; ?>
                                            <input type="hidden" name="ownerName"
                                                value="<?php echo isset($ownerName) ? $ownerName : ''; ?>">
                                        </span>
                                    </div>
                                    <div class="bill-item">
                                        <span class="bill-label">Reservation Time:</span>
                                        <span class="bill-value">
                                            <?php echo isset($reservationTime) ? $reservationTime : ''; ?>
                                            <input type="hidden" name="reservationTime"
                                                value="<?php echo isset($reservationTime) ? $reservationTime : ''; ?>">
                                        </span>
                                    </div>
                                    <div class="bill-item">
                                        <span class="bill-label">Vehicle Out:</span>
                                        <span class="bill-value">
                                            <?php echo isset($vehicleOut) ? $vehicleOut : ''; ?>
                                            <input type="hidden" name="vehicleOut"
                                                value="<?php echo isset($vehicleOut) ? $vehicleOut : ''; ?>">
                                        </span>
                                    </div>
                                    <?php
                                    // Convert the database values to DateTime objects
                                    $reservationTime = new DateTime($slotData['created_at']);
                                    $vehicleOut = new DateTime($slotData['vehicleOut']);
                                    // Calculate time duration in minutes
                                    $timeDifference = $vehicleOut->getTimestamp() - $reservationTime->getTimestamp();
                                    $timeDuration = round($timeDifference / 60); // convert seconds to minutes and round
                                    ?>
                                    <div class="bill-item">
                                        <span class="bill-label">Time Duration</span>
                                        <span class="bill-value">
                                            <?php echo $timeDuration; ?> minutes
                                            <input type="hidden" name="timeDuration"
                                                value="<?php echo $timeDuration; ?>">
                                        </span>
                                    </div>

                                    <?php

                                    // Calculate payment based on the rate of 30/= per 5 minutes
                                    $ratePerFiveMinutes = 30;
                                    $payment = ceil($timeDuration / 5) * $ratePerFiveMinutes;

                                    $exchangeRate = 312.72;
                                    // Convert payment to US Dollars
                                    $paymentInUSD = $payment / $exchangeRate;
                                    ?>
                                    <div class="bill-item">
                                        <span class="bill-label">Payment</span>
                                        <span class="bill-value">
                                            <?php echo $payment; ?> LKR
                                            <input type="hidden" name="payment" value="<?php echo $payment; ?>">
                                        </span>
                                    </div>

                                    <div class="bill-item">
                                        <span class="bill-label">Payment USD</span>
                                        <span class="bill-value">
                                            <?php echo $paymentInUSD; ?> USD
                                            <input type="hidden" name="paymentInUSD"
                                                value="<?php echo $paymentInUSD; ?>">
                                        </span>
                                    </div>

                                    <div class="bill-item">

                                        <span class="bill-value">
                                            <button class="pay-button" onclick="goToPaymentPage()">Pay Now</button>
                                            <button class="cancel-button" onclick="goToSlotPage()">Cancel </button>
                                        </span>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
    </section>

    <script>
        function goToSlotPage() {
            window.location.href = "../slot/slot.php";
        }
        function goToPaymentPage() {
            window.location.href = "../payment/payment.php";
        }
    </script>

</body>

</html>