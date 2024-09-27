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

class Slot
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function isValidPhoneNumber($phoneNumber)
    {
        return preg_match("/^[0-9]{10}$/", $phoneNumber);
    }

    public function addSlot($data)
    {
        $conn = $this->db->getConnection();

        // Check if 'reservationTime' key exists before accessing it
        $reservationTime = isset($data['reservationTime']) ? mysqli_real_escape_string($conn, $data['reservationTime']) : '';

        $slotNumber = mysqli_real_escape_string($conn, $data['slotNumber']);

        // Check if the slot is already reserved
        $checkReservationQuery = "SELECT * FROM slot WHERE slotNumber = '$slotNumber' AND status = 'IN'";
        $result = $conn->query($checkReservationQuery);

        if ($result->num_rows > 0) {
            echo "Slot already reserved for the selected time.";
            $this->db->closeConnection();
            exit;
        }

        $vehicleCategory = mysqli_real_escape_string($conn, $data['vehicleCategory']);
        $vehicleName = mysqli_real_escape_string($conn, $data['vehicleName']);
        $vehicleNumber = mysqli_real_escape_string($conn, $data['vehicleNumber']);
        $ownerName = mysqli_real_escape_string($conn, $data['ownerName']);
        $ownerContact = mysqli_real_escape_string($conn, $data['ownerContact']);
        $nic = mysqli_real_escape_string($conn, $data['nic']);
        $ownerAddress = mysqli_real_escape_string($conn, $data['ownerAddress']);

        // Validate phone number
        if (!$this->isValidPhoneNumber($ownerContact)) {
            echo "Invalid phone number. Please enter a 10-digit phone number.";
            $this->db->closeConnection();
            exit;
        }

        // Start a transaction to ensure consistency
        $conn->begin_transaction();

        $user = $_SESSION['username'];
        $reserveTime = date("Y-m-d H:i:s");

        //    echo $reserveTime;
//    echo $reservationTime;


        // SQL query to insert data into the database
        $sql = "INSERT INTO slot (slotNumber, vehicleCategory, vehicleName, vehicleNumber, ownerName, ownerContact, nic, ownerAddress, reservationTime, status, added_by)
           VALUES ('$slotNumber', '$vehicleCategory', '$vehicleName', '$vehicleNumber', '$ownerName', '$ownerContact', '$nic', '$ownerAddress', '$reserveTime', 'IN', '$user')";

        if ($conn->query($sql) === TRUE) {
            header('Location: record_success.php');
            $reserveTime = date("Y-m-d H:i:s");

            //    // Set the status to 'reserved' and record the reservation time
            //    $reserveQuery = "UPDATE slot SET status = 'IN', reservationTime = '$reserveTime' WHERE slotNumber = '$slotNumber'";
            //    $conn->query($reserveQuery);

            $conn->commit(); // Commit the transaction
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->rollback(); // Rollback the transaction in case of an error
        }

        $this->db->closeConnection();
    }
}
// Handle form submission


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $slotHandler = new Slot($db);
    $slotHandler->addSlot($_POST);


}

