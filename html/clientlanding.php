<?php
session_start();

// Check if the user is logged in and is a client
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'client') {
    // If not, redirect to the login page
    header("Location: login.php");
    exit(); // Always use exit after header redirection
}

// Include the database connection file
require_once 'db.php';

// Establish a database connection
$conn = getDatabaseConnection();

// Check if the connection is successful
if (!$conn) {
    die("Failed to connect to the database.");
}

// Additional client-specific functionality can be added here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Bruner Lane Photography</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!--Main nav bar-->
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <ul class="nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="https://www.brunerlanephotography.com/">HOME</a></li>
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
                <a href="https://www.brunerlanephotography.com/" class="navbar-brand mx-auto">
                    <img src="../img/Logo.png" alt="Photographer Logo" draggable="false" style="height: 50; width: 60%;">
                </a>
    
                <ul class="nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="clients.html">CLIENTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="appointment.html">SCHEDULE</a></li>
                    <li class="nav-item"><a class="nav-link" href="weddings.html">ELOPEMENTS/WEDDINGS</a></li>
                    <li class="nav-item"><a class="nav-link" href="../php/login.php">SIGN IN</a></li>
                </ul>
            </div>
        </nav>
        <!--Mobile Hamburger menu-->
        <input type="checkbox" id="hamburger-input" class="burger-shower" />
        <label id="hamburger-menu" for="hamburger-input">
            <nav id="sidebar-menu">
                <img src="../img/Logo.png" alt="Photographer Logo" draggable="false" style="height: 10%; width: 60%;">
                <ul>
                <li><a href="https://www.brunerlanephotography.com/">HOME</a></li>
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
    <!--User dashboard-->
    <div class="container">
        <h1 style="text-align: center;">
            Welcome, USER
        </h1>
        <div class="row">
            <div class="col">
                <h2>
                    List of appointments:
                </h2>
                <h3>
                    There would be a list of all the user's appointments here.
                </h3>
            </div>
        <div class="col">
            <h3>
                Send a message to Tiera!    
            </h3>
            <form>
            <div class="mb-3">
                <textarea class="form-control" id="message" rows="4" placeholder="Message here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Send</button>
        </form>
        </div>
            <!--Photo Gallery, ideally self-populating with signed-in user's photos-->
    <section class="container" id="gallery">       
        <div class="row">
            <div class="gallery">
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/94890b03bf833fd7160e3b592ba422e1-78dcc553.jpg" alt="Image 1">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/3c05a18e0f331dda7c19a10cc1c79c16-d61127d2-1000.jpg" alt="Image 2">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/95_Chandanaakshay_Potraitshoot_DSC06128-Edit_A-ec2f82d5.jpg" alt="Image 3">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/9f30b263d8ca6e5565468a4491325d4e-06b4e8e3-1000.jpg" alt="Image 4">
                </div>
                 
            </div>
        </div>
        <div class="row">
            <div class="gallery">
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC_0428-f9e949cd.jpg" alt="Image 5">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC_0160-5194dc68.jpg" alt="Image 6">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC-0932-cb892139.jpg" alt="Image 7">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC_0488-69636a79.jpg" alt="Image 8">
                </div>
            </div>
        </div>
    
        
        <div class="row">
            <div class="gallery">
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/dbef9e172c67542cfb4fe5d08eb031dc-74261718.jpg" alt="Image 1">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/b9a77e99516bfad2e68abd0e9a310649-1d19ac72.jpg" alt="Image 2">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/a7df50f617d53f9bfd48b4f85c104277-73262258.jpg" alt="Image 3">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC_0392-5518678e.jpg" alt="Image 4">
                </div>
                 
            </div>
        </div>
        <div class="row">
            <div class="gallery">
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/Before_and_After-1-69a3ca7a-1000.jpg" alt="Image 5">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/Cris_Valerio3076-70c9ba04.jpg" alt="Image 6">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC_0133-efa92c28.jpg" alt="Image 7">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC_0488-69636a79.jpg" alt="Image 8">
                </div>
            </div>
        </div>
    
        
        <div class="row">
            <div class="gallery">
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/image9-686590ab.jpg" alt="Image 1">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/947eecf2604edd2c7880560dfaeea7ee-295821d6.jpg" alt="Image 2">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/05924deeb1223994ff3b23268a5f74a2-cedb6c17.jpg" alt="Image 3">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/DSC_0392-5518678e.jpg" alt="Image 4">
                </div>
                 
            </div>
        </div>
        <div class="row">
            <div class="gallery">
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/Lulu-11-47f88406.jpg" alt="Image 5">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/6c20614bb7944546aa85b1239c8f81a3-09094868.jpg" alt="Image 6">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/2e8af44c979bf6846db6872f90d3aa32-ec9ccee0.jpg" alt="Image 7">
                </div>
                <div class="gallery-item">
                    <img draggable="false" src="../img/BrunerLanePhotographs/59ae4945f054af2f083471d3afeb88a3-14ef0288.jpg" alt="Image 8">
                </div>
            </div>
        </div>
        </div>
        <form method="POST" action="logout.php">
            <button type="submit" class="btn btn-success" name="logout">Log Out</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Tiera Thompson | Follow me on <a href="https://www.instagram.com/brunerlanephotography">Instagram</a></p>
    </footer>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>