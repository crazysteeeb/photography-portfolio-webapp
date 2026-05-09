<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "mysql.brunerlanephotography.com";
$username = "brunerlanephotog";
$password = "sRfP?-6z";
$dbname = "brunerlanephotography_co";

// Establishing the connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Unified query to check both admin and client tables
    $query = "
        SELECT 'admin' as user_type, admin_id as user_id, admin_password as password 
        FROM admin WHERE admin_username = ? 
        UNION 
        SELECT 'client' as user_type, client_id as user_id, client_password as password 
        FROM clients WHERE email = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
        die('MySQL error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $input_username, $input_username); // Bind for both username fields
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // Verify password
        if (password_verify($input_password, $user['password'])) {
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['user_id'] = $user['user_id'];

            if ($user['user_type'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: clientlanding.php");
            }
            exit();
        } else {
            $error_message = "Invalid password. Please try again.";
        }
    } else {
        $error_message = "No account found with the provided credentials.";
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Bruner Lane Photography - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!--Header with the Logo and Navigation-->
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <ul class="nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="https://brunerlanephotography.com">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">ABOUT</a></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="portfolio.html" id="portfolioDropdown" role="button" aria-expanded="false">PORTFOLIO</a>
                        <ul class="dropdown-menu" aria-labelledby="portfolioDropdown">
                            <li><a class="dropdown-item" href="families.html">Families</a></li>
                            <li><a class="dropdown-item" href="couples.html">Couples</a></li>
                            <li><a class="dropdown-item" href="seniors.html">Seniors</a></li>
                            <li><a class="dropdown-item" href="babies.html">Babies</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="packages.html">INVESTMENTS</a></li>
                </ul>
    
                <!-- Centered Logo -->
                <a href="https://brunerlanephotography.com" class="navbar-brand mx-auto">
                    <img src="../img/Logo.png" alt="Photographer Logo" draggable="false" style="height: 50; width: 60%;">
                </a>
    
                <ul class="nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="clients.html">CLIENTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="appointment.html">SCHEDULE</a></li>
                    <li class="nav-item"><a class="nav-link" href="weddings.html">ELOPEMENTS/WEDDINGS</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">SIGN IN</a></li>
                </ul>
            </div>
        </nav>
        <!--Mobile Hamburger menu-->
        <input type="checkbox" id="hamburger-input" class="burger-shower" />
        <label id="hamburger-menu" for="hamburger-input">
        <nav id="sidebar-menu">
            <img src="../img/Logo.png" alt="Photographer Logo" draggable="false" style="height: 10%; width: 60%;">
            <ul>
            <li><a href="https://brunerlanephotography.com">HOME</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="portfolio.html">PORTFOLIO</a></li>
            <li><a href="families.html">Families</a></li>
            <li><a href="couples.html">Couples</a></li>
            <li><a href="seniors.html">Seniors</a></li>
            <li><a href="babies.html">Babies</a></li>
            <li><a href="packages.html">INVESTMENTS</a></li>
            <li><a href="clients.html">CLIENTS</a></li>
            <li><a href="appointment.html">SCHEDULE</a></li>
            <li><a href="weddings.html">ELOPEMENTS/WEDDINGS</a></li>
            <li><a href="login.php">SIGN IN</a></li>
            </ul>
        </nav>
        </label>

        <div class="overlay"></div>
    </header>

    <!-- Login Form -->
    <form action="" method="post" class="container mt-5">
        <div class="imgcontainer text-center">
            <h2>Sign in to make and view appointments</h2>
            <img src="../img/BrunerLanePhotographs/b9a77e99516bfad2e68abd0e9a310649-1d19ac72.jpg" alt="Avatar" draggable="false" class="cow" style="max-height: 20%; width: 10%;">
        </div>

        <div class="container">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username or Email" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit" class="btn btn-primary">Login</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>

        <?php if (!empty($error_message)): ?>
            <p class="text-danger text-center mt-3"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </form>

    <footer>
        <p>&copy; 2024 Tiera Thompson | Follow me on <a href="https://www.instagram.com/brunerlanephotography">Instagram</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
