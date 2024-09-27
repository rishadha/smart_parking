<?php

//Dear Rishadha. You park your vehicle in slot number 5 for 1583 minutes. The payment for that is 15830.
// to notification send by admin

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include 'Database.php';

    // Extract form data
    $slotId = $_POST['slot_id'];
    $slotNumber = $_POST['slot_number'];
    $ownerName = $_POST['owner_name'];
    $duration = $_POST['duration'];
    $payment = $_POST['payment'];
    $description = $_POST['description'];

    // Insert data into the database
    $db = new Database();
    $conn = $db->getConnection();

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO model(slot_id, slot_number, owner_name,  duration, payment, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $slotId, $slotNumber, $ownerName, $duration, $payment, $description);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        // Data inserted successfully
        echo "Send Notification sucessfully!";
    } else {
        // Error inserting data
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $db->closeConnection();
} else {
    // If the form is not submitted, redirect or display an error message
    echo "Form submission error";
}
?>
