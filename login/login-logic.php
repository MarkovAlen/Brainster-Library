<?php
session_start();
require_once '../db.php';
require_once './login.php';
if (isset($_POST['username']) && isset($_POST['password']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT id, password, is_admin FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false && isset($row['password'])) {
        $storedPassword = $row['password'];
        $is_admin = $row['is_admin'];

        if (password_verify($password, $storedPassword)) {
            $_SESSION['reg-success'] = 'Successful login';
            $_SESSION['user_id'] = $row['id'];

            if ($is_admin) {
                $_SESSION['is_admin'] = true;
                header("Location: ../admin/admin.php"); 
            } else {
                header("Location: ../user/user.php"); 
            }

            exit;
        } else {
            $_SESSION['error'] = 'Wrong credentials';
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = 'User not found';
        header("Location: login.php");
        exit;
    }
}
?>