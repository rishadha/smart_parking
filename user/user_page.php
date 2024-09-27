<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars</title>

    <!-- Link Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="img/car-logo1.png" type="image/x-icon">
    <!-- Link File CSS -->
    <link rel="stylesheet" href="style.css">
    <link href="responsive.css" rel="stylesheet" />
</head>
<body>
    <header>
        <nav class="custom_nav-container navbar-expand-lg">
            <img src="img/car-logo1.png" class="logo" alt="">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="menu navbar-nav">
                    <a href="user_page.php" class="nav-link">Home</a>
                    <a href="../about/about.html" class="nav-link">About</a>
                    <a href="../parking/parking.php" class="nav-link">Book Here</a>
                    <a href="../slot/slot.php" class="nav-link">Slot</a>
                    <a href="../login/login.html" class="nav-link">Logout</a>
                    

                </div>

              
            </div>
        </nav>
    </header>
    
    <div class="hero_area">
        <div class="hero">
            <div class="text">
                <h4>Powerful, Fun and</h4>
                <h1>Fierce to <br> <span>Drive</span></h1>
                <p>Real Poise, Real Power, Real Performance.</p>
                <a href="../slot/slot.php" class="btn">place Booking </a>
            </div>
        </div>
    </div>

    <script>
        let heroBg = document.querySelector('.hero');

        setInterval(() => {
            heroBg.style.backgroundImage = "url(img/bg-light.jpg)"
            
            setTimeout(() => {
                heroBg.style.backgroundImage = "url(img/bg.jpg)"
            }, 1000);
        }, 2200);
    </script>
</body>
</html>

