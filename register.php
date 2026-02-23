<?php
require 'vendor/autoload.php';
use Ramsey\Uuid\Uuid;
header('Content-Type: application/json');

$uname = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$pass  = $_POST['password'] ?? '';

if (!$uname || !$email || !$pass) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=userdata", "root", "as");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$uname, $email]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Username or email already exists.']);
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $uuid4=Uuid::uuid4();
    $uuid=$uuid4->toString();
    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password,uuid) VALUES (?, ?, ?, ?)");
    $stmt->execute([$uname, $email, $hashedPassword,$uuid]);

    echo json_encode(['success' => true, 'message' => 'User registered successfully!']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>