<?php
// Database connection
$servername = "localhost";
$dbusername = "root";   // your MySQL username
$dbpassword = "as";       // your MySQL password
$dbname = "userdata";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$username = $_POST['username'] ?? '';
$title = $_POST['title'] ?? '';
$body = $_POST['body'] ?? '';

if (empty($username) || empty($title) || empty($body)) {
    echo "All fields are required.";
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
$stmt->bind_param("ss", $title, $body);

// Execute
if ($stmt->execute()) {
    echo "Post saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>