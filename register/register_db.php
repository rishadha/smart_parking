<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "smart_parking";
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

class Registration extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function addUser($data) {
        $conn = $this->getConnection();

        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $phoneNumber = $data['phone_no'];

          // Ensure username is unique
          $checkUniqueUsername = "SELECT * FROM `users` WHERE `username`=?";
          $stmtUsername = $conn->prepare($checkUniqueUsername);
          $stmtUsername->bind_param("s", $username);
          $stmtUsername->execute();
          $resultCheckUsername = $stmtUsername->get_result();
  
          if ($resultCheckUsername->num_rows > 0) {
              echo "Error: Username already exists";
              return;
          }

       // Ensure phone_no is unique
       $checkUniquePhone = "SELECT * FROM `users` WHERE `phone_number`=?";
       $stmtPhone = $conn->prepare($checkUniquePhone);
       $stmtPhone->bind_param("s", $phoneNumber);
       $stmtPhone->execute();
       $resultCheckPhone = $stmtPhone->get_result();

       if ($resultCheckPhone->num_rows > 0) {
           echo "Error: Phone number already exists";
           return;
       }
       $sql = "INSERT INTO `users`(`username`, `password`, `phone_number`) VALUES (?, ?, ?)";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("sss", $username, $password, $phoneNumber);
       $stmt->execute();

       if ($stmt->affected_rows > 0) {

        // Set the session variables
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';  // Assuming a default role for registered users

        header('Location: user_success.php');
       } else {
           echo "Error: " . $conn->error;
       }

       $stmtUsername->close();
       $stmtPhone->close();
       $stmt->close();
   }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registration = new Registration();
    $registration->addUser($_POST);
}

