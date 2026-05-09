<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
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

    <!--Admin welcome message-->
    <div class="container">
        <h1 style="text-align: center;">
            Welcome, ADMIN
        </h1>
        <!--User appointment update UI-->
        <div class="row">
            <div class="col">
                    <input type="text" placeholder="User ID to edit..." name="idtoedit">
                    <input type="date" placeholder="date" name="newdate">
                    <input type="time" placeholder="time" name="newtime">
                    <button type="submit">Apply new time</button>
            </div>
            <div class="col">
                <input type="number" placeholder="Appointment Number to edit..." name="appointtocancel">
                <br>
                <br>
                <br>
                <button type="submit" style="margin-top: 20px;">Cancel Appointment</button>
            </div>
        </div>
        <hr>
        <!--User contact form-->
        <div class="row">
            <div class="col">
                <form>
                <div class="mb-3">
                    <input type="text" class="form-control" id="idtocontact" placeholder="User ID to contact..." required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Send to Client</button>
            </form>
            </div>
        </div>
        <hr>
        <!--Image upload UI-->
        <div class="row">
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <div class="col">
        <div class="square" style="border: 1px solid black;">
            <br><br><br><br><br>
            Select Image File to Upload:
            <input type="file" name="file" id="fileInput" required>
            <br><br><br><br><br><br>
        </div>
    </div>
    <div class="col">
        <!-- Photo Name -->
        <div class="mb-3">
            <input type="text" class="form-control" name="photoname" placeholder="Photo name..." required>
        </div>
        <!-- Date of Photo Creation -->
        <div class="mb-3">
            Date of photo creation...
            <input type="date" class="form-control" name="photodate" placeholder="Date of image creation..." required>
        </div>
        <!-- Client Name -->
        <div class="mb-3">
            <input type="text" class="form-control" name="photousername" placeholder="Name of client..." required>
        </div>
        <!-- Optional Session ID -->
        <div class="mb-3">
            <input type="number" class="form-control" name="session_id" placeholder="Session ID (optional)">
        </div>
        <!-- Private Checkbox -->
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="private" id="privateCheckbox">
            <label class="form-check-label" for="privateCheckbox">Private (Uncheck to share on site)</label>
        </div>
        <!-- Submit Button -->
        <button type="submit" name="upload" value="upload" class="btn btn-success">Upload</button>
        <?php
        if (isset($_GET['photo_id'])) {
            $photoId = $_GET['photo_id'];
            echo "The uploaded photo ID is: " . $photoId;
        }
        ?>

    </div>
    </form>
</div>
        <hr>
        <!--Image search by ID UI-->
        <div class="row">
            <!-- Search Image -->
            <input type="number" id="searchImageID" placeholder="Search image by ID..." name="searchimages">
            <button id="searchButton" class="btn btn-primary">Search</button>

            <!-- Image Display Section -->
            <div class="col" style="padding-top: 2%;">
                <div id="imageContainer" style="border: 1px solid black; height: 200px; text-align: center; display: flex; justify-content: center; align-items: center;">
                    Image will appear here...
                </div>
            </div>

            <!-- Image Details -->
            <div class="col">
                <div class="mb-3">
                    <input type="text" class="form-control" id="photonameresult" placeholder="Photo name..." readonly>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="photodateresult" placeholder="Photo date..." readonly>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" id="photoidresult" placeholder="Photo ID..." readonly>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" id="photouseridresult" placeholder="User's ID..." readonly>
                </div>
            </div>

            <!-- Image Deletion Section -->
            <div class="col">
                <p>Image Deletion...</p>
                <div class="mb-3">
                    <input type="number" class="form-control" id="photoidtodelete" placeholder="Image ID..." required>
                </div>
                <button type="submit" id="deleteButton" class="btn btn-success">Delete</button>
            </div>
        </div>

        <form method="POST" action="logout.php">
            <button type="submit" class="btn btn-success" name="logout">Log Out</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Tiera Thompson | Follow me on <a href="https://www.instagram.com/brunerlanephotography">Instagram</a></p>
    </footer>

    <script src="script.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>