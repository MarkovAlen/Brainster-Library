<?php
require_once './start-sessions.php';
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['category'];
    if (empty($title)) {
        $_SESSION['error'] = 'Category title cannot be empty';
        header("Location: ../admin/admin.php");
        exit;
    }
    
    $sqlInsertCategory = "INSERT INTO categories (title) VALUES (:title)";
    $stmtInsertCategory = $pdo->prepare($sqlInsertCategory);
    $stmtInsertCategory->bindParam(':title', $title);

    if ($stmtInsertCategory->execute()) {
        $_SESSION['success'] = 'Category added successfully';
        header("Location: ../admin/admin.php"); 
        exit;
    } else {
        $_SESSION['error'] = 'Failed to add category';
        header("Location: ../admin/admin.php");
        exit;
    }
   
        $title = $_POST['category'];
        if (empty($title)) {
            $_SESSION['error'] = 'Category title cannot be empty';
            header("Location: ../admin/admin.php");
            exit;
        }
    
}