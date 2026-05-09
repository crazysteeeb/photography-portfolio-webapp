<?php
// Database credentials
$servername = "mysql.brunerlanephotography.com"; 
$username = "brunerlanephotog"; 
$password = "sRfP?-6z"; 
$dbname = "brunerlanephotography_co"; 

// Function to establish a database connection
function getDatabaseConnection() {
    global $servername, $username, $password, $dbname;
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
?>
