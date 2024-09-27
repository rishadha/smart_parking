<?php
// Include the database connection file
include './database.php';


$slotNumber = isset($_POST['slotNumber']) ? $_POST['slotNumber'] : '';
$carNumber = isset($_POST['carNumber']) ? $_POST['carNumber'] : '';
$ownerName = isset($_POST['ownerName']) ? $_POST['ownerName'] : '';
$reservationTime = isset($_POST['reservationTime']) ? $_POST['reservationTime'] : '';
$vehicleOut = isset($_POST['vehicleOut']) ? $_POST['vehicleOut'] : '';
$timeDuration = isset($_POST['timeDuration']) ? $_POST['timeDuration'] : '';
$payment = isset($_POST['payment']) ? $_POST['payment'] : '';
$paymentInUSD = isset($_POST['paymentInUSD']) ? $_POST['paymentInUSD'] : '';

$transactionId = crc32(uniqid());

$db = new Database();

$conn = $db->getConnection();

// Assuming you have already initialized variables like $slotNumber, $carNumber, $ownerName, $reservationTime, $vehicleOut, $timeDuration, $payment, $paymentInUSD.

// Prepare SQL INSERT statement
$sql = "INSERT INTO transactions (id,slot_number, car_number, owner_name, reservation_time, vehicle_out_time, time_duration, payment, payment_in_usd)
        VALUES ('$transactionId','$slotNumber', '$carNumber', '$ownerName', '$reservationTime', '$vehicleOut', '$timeDuration', '$payment', '$paymentInUSD')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully with transaction ID: " . $transactionId;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>








<?php
require __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/database.php";

// Check if 'slot_number' parameter exists in $_GET
if (!isset($_GET['slotNumber'])) {
    echo "Slot number is missing.";
    exit; // Stop further execution
}

// Extract 'slot_number' parameter from $_GET
$slotNumber = $_GET['slotNumber'];

$stripe_secret_key = "sk_test_51N2EheDYfSD2I0DwXD8s4uGPQhi30XbTTJNYRcO0BqLM1JS6yzE0qhs14Y47t9csWLXFkmwShhorJ2antPqGjXq4001fVj6TnR";

\Stripe\Stripe::setApiKey($stripe_secret_key);



$db = new Database();
$conn = $db->getConnection();
$sql = "SELECT slot_number, time_duration, payment_in_usd FROM transactions WHERE slot_number = '$slotNumber'"; // Modify this query as needed
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Transaction details found, fetch the data
        $transactionData = $result->fetch_assoc();

        // Define an array to hold line items
        $line_items = [];


        // Add line item for payment
        $line_items[] = [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => $transactionData['payment_in_usd'] * 100, // Assuming payment is the price in USD
                "product_data" => [
                    "name" => "Payment for Parking" . " USD" // Name of the product
                ]
            ]
        ];

        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "http://localhost/parking/payment/success.php",
            "cancel_url" => "http://localhost/parking/payment/bill.php",
            "locale" => "auto",
            "line_items" => $line_items // Use the constructed line_items array
        ]);

        http_response_code(303);
        header("Location: " . $checkout_session->url);
    } else {
        // Transaction not found
        echo "Transaction not found.";
    }
} else {
    // Query execution failed
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>