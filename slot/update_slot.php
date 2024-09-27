<?php
// update_slot.php
session_start();

class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "smart_parking";
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

         // Set the timezone to 'Asia/Colombo'
         $this->conn->query("SET time_zone = 'Asia/Colombo'");
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

// Check if the form is submitted and mark_out button is clicked

// Check if the form is submitted and mark_out button is clicked
if (isset($_POST['mark_out'])) {
    // Get the slot ID from the form
    $slot_id = $_POST['slot_id'];
    $slot_num=$_POST['slot_num'];

    $_SESSION['slot_id']=$slot_id;
    
    $db = new Database();
    $conn = $db->getConnection();

    // Prepare and execute the SQL query
    $sql = "UPDATE slot SET vehicleOut = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Check for errors in the preparation
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $slot_id);
    $stmt->execute();

    // Close statement and database connection
    $stmt->close();
    $db->closeConnection();

    // Redirect to payment.php
    header("Location: ../payment/bill.php?slot_id=$slot_id&slot_num=$slot_num");
    exit();
}