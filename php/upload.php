<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Ensure the user is logged in and has admin privileges
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once 'db.php';
$conn = getDatabaseConnection();

// Check if the connection is successful
if (!$conn) {
    die("Failed to connect to the database.");
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form inputs
    $photoName = isset($_POST['photoname']) ? trim($_POST['photoname']) : null;
    $photoDate = isset($_POST['photodate']) ? trim($_POST['photodate']) : null;
    $photoUserName = isset($_POST['photousername']) ? trim($_POST['photousername']) : null;
    $isPrivate = isset($_POST['private']) ? 1 : 0;

    // If session_id is not provided, set it to NULL
    $sessionId = isset($_POST['session_id']) && !empty($_POST['session_id']) ? intval($_POST['session_id']) : null;

    // Validate required fields
    if (empty($photoName) || empty($photoDate) || empty($photoUserName) || !isset($_FILES['file'])) {
        echo "All fields are required. Please try again.";
        exit();
    }

    // Validate the uploaded file
    $file = $_FILES['file'];
    if ($file['error'] !== 0) {
        echo "File upload error: " . $file['error'];
        exit();
    }

    // Validate file type (e.g., allow only images)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo "Invalid file type. Only JPEG, PNG, and GIF files are allowed.";
        exit();
    }

    // Read file content into a blob
    $fileContent = file_get_contents($file['tmp_name']);
    if (!$fileContent) {
        echo "Failed to read the uploaded file.";
        exit();
    }

    // Debug: Save the content to a local file (optional)
    file_put_contents("debug_uploaded_image.jpg", $fileContent); // Save locally for inspection

    // Insert the data into the database, with session_id being nullable
    // Prepare the statement
    $query = "INSERT INTO photos (session_id, photo, private, date, name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Failed to prepare the query: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("ibiss", $sessionId, $dummyBlob, $isPrivate, $photoDate, $photoName); 
    // Use a dummy variable for the BLOB (it will be sent with send_long_data)

    // Send the actual BLOB data
    $stmt->send_long_data(1, $fileContent); // Send the binary data for the second parameter

    // Execute the query
    if ($stmt->execute()) {
        // Get the inserted photo_id
        $photoId = $stmt->insert_id;

        // Redirect to admin page with the new photo_id
        header("Location: admin.php?photo_id=" . $photoId);
        exit();
    } else {
        echo "Failed to execute query: " . $stmt->error;
        exit();
    }


    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
