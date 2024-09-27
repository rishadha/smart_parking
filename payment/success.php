<?php
session_start(); // Ensure session is started

require './database.php';

// Check if the slot id is set in the session
if (isset($_SESSION['slot_id']) && $_SESSION['slot_id'] !== '') {
    $slot_id = $_SESSION['slot_id'];

    // Prepare the update statement
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "UPDATE slot SET status = 'OUT' WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $slot_id); // Assuming 'id' is numeric

    // Execute the statement
    $stmt->execute();

    // Close the statement and the connection
    $stmt->close();
    $conn->close();

    // Clear the slot ID from the session
    unset($_SESSION['slot_id']);
} else {
    // Display an error message if the slot id is not found in the session
    echo "Error: Slot ID not found in session.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Stripe Example</title>
    <meta charset="UTF-8" />

    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .success-message {
            text-align: center;
            margin-right: 50px;
        }

        .success-message p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .success-image {
            margin-top: 20px;
        }

        .success-image img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="success-message">
            <p>Success</p>
            <p>Thank you for your payment!</p>
        </div>
        <div class="success-image">
            <img src="../admin/assets/img/right.png" alt="Success">
        </div>
    </div>



</body>

</html>