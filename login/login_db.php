<?php

session_start();
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

class Login extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function checkLogin($data) {
        $conn = $this->getConnection();

        $username = $data['username'];
        $password = $data['password'];

        $sql = "SELECT * FROM `users` WHERE `username`=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Authentication successful
                $_SESSION['username'] = $user['username'];  // Set the session variable
                $_SESSION['role'] = $user['role'];  // Assuming you have a role in your users table
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/admin_page.php");
                    
                    exit();
                } else {
                    header("Location: ../user/user_page.php");
                    exit();
                }
            } else {
                echo "Error: Incorrect password";
            }
        } else {
            echo "Error: User not found";
        }

        $stmt->close();
    }
    // public function logout() {
    //     // Unset all session variables
    //     $_SESSION = array();

    //     // Destroy the session
    //     session_destroy();
    // }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new Login();
    if ($login->checkLogin($_POST)) {
        // Authentication successful
       
        // $_SESSION variables should be set here
        $username = $_SESSION['username'];
        $role = $_SESSION['role'];

        // Redirect based on user role
        if ($role === 'admin') {
            header("Location: ../admin/admin_page.php");
        } else {
            header("Location: ../user/user_page.php");
        }
        exit();
    } else {
        // Handle login errors
        echo "Error: Incorrect username or password";
    }

    // Call the logout method to clear session data
    //$login->logout();

    // Redirect to the login page after logout
    //header("Location: login.html");
    exit();
}
