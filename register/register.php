<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Parking (Pvt)</title>
    <link rel="stylesheet" href="register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Include GSAP library directly from CDN -->
    <script src="gsap.min.js"></script>
</head>
<body>
    <div class="background"></div>
    <div class="text-item">
        <h2>Welcome! <br><span></span></h2>
        <p>Welcome to Smart Parking! PLease Create An account here! </p>
        <div class="social-icon"></div>
    </div>
    <div class="container">
        <div class="item">
            <h2 class="logo">Smart Parking (Pvt)</h2>
        </div>
        <div class="register-section">
            <div class="form-box register">
                <form action="register_db.php" method="post">
                    <h2 class="h2">Create An Account</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input type="text" name="username" required placeholder="Username">
                       
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-phone'></i></span>
                        <input type="text" name="phone_no" required placeholder="Phone Number">
                       
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="password" required placeholder="Password">
                        
                        <span class="toggle-password" onclick="togglePasswordVisibility(this)"></span>
                    </div>
                    
                    <button class="btn" onclick="handleLogin()">Register</button>
                    <div class="forgot-password"><a href="forgot_password.php">Forgot Password? </a></div></form></div>  
                
                <div class="register">Already Have An Account<a href="../login/login.html"> Login </a></div>

                </form>
            </div>
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html>
