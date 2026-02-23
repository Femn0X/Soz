<?php
session_start();
header('Content-Type: application/json');

$uname = $_POST['username'] ?? '';
$pass  = $_POST['password'] ?? '';

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=userdata", "root", "as");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$uname]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        echo json_encode(['success' => true, 'redirect' => 'main.html']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
