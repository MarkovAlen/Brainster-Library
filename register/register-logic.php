<?php
session_start();
require_once '../db.php'; 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username and password are required';
        header("Location: register.php"); 
        exit;
    }
    
    if (strlen($username) < 5 || strlen($password) < 5) {
        $_SESSION['error'] = 'Username and password must be at least 5 characters long';
        header("Location: register.php"); 
        exit;
    }
    
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $_SESSION['error'] = 'Password must contain at least one uppercase letter and one number';
        header("Location: register.php");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sqlCheckUsername = "SELECT COUNT(*) FROM users WHERE username = :username";
    $stmtCheckUsername = $pdo->prepare($sqlCheckUsername);
    $stmtCheckUsername->bindParam(':username', $username);
    $stmtCheckUsername->execute();
    $usernameExists = $stmtCheckUsername->fetchColumn();

    if ($usernameExists) {
        $_SESSION['error'] = 'Username already exists';
        header("Location: register.php");
        exit;
    }

    $sqlInsertUser = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $stmtInsertUser = $pdo->prepare($sqlInsertUser);
    $stmtInsertUser->bindParam(':username', $username);
    $stmtInsertUser->bindParam(':password', $hashedPassword);

    if ($stmtInsertUser->execute()) {
        $_SESSION['reg-success'] = 'Registration successful';
        header("Location: ../login/login.php");
        exit;
    } else {
        $_SESSION['error'] = 'Registration failed';
        header("Location: register.php"); 
        exit;
    }
}
?>
