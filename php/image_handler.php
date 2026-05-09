<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db.php'; // Include your database connection file

header('Content-Type: application/json'); // Set the response format to JSON

$conn = getDatabaseConnection(); // Get the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // Determine the requested action

    if ($action === 'search') {
        $photo_id = $_POST['id'];

        if (empty($photo_id)) {
            echo json_encode(['error' => 'Photo ID is required.']);
            exit();
        }

        // Prepare the SQL query to fetch the image and details
        $stmt = $conn->prepare("SELECT * FROM photos WHERE photo_id = ?");
        $stmt->bind_param("i", $photo_id); // Bind the parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $photo = $result->fetch_assoc();

            // Use finfo to detect MIME type from the binary data
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($photo['photo']); // Detect MIME type of the binary data
            $photo['photoType'] = $mimeType; // Set the MIME type

            // Convert BLOB to base64
            $photo['photo'] = base64_encode($photo['photo']); // Convert BLOB to base64
            echo json_encode($photo); // Send the image data
        } else {
            echo json_encode(['error' => 'Image not found']);
        }

        $stmt->close(); // Close the statement
    } elseif ($action === 'delete') {
        $photo_id = $_POST['id'];

        if (empty($photo_id)) {
            echo json_encode(['error' => 'Photo ID is required to delete.']);
            exit();
        }

        // Prepare the SQL query to delete the image
        $stmt = $conn->prepare("DELETE FROM photos WHERE photo_id = ?");
        $stmt->bind_param("i", $photo_id); // Bind the parameter
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => 'Image deleted successfully']);
        } else {
            echo json_encode(['error' => 'Image not found or could not be deleted']);
        }

        $stmt->close(); // Close the statement
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close(); // Close the database connection
?>
