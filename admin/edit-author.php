<?php
require_once './start-sessions.php';
require_once '../db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['id'])) {
        $authorId = $_GET['id'];
        
        $newFirstName = $_POST['newFirstName'];
        $newLastName = $_POST['newLastName'];
        $newBiography = $_POST['newBiography'];

        if (empty($newFirstName) || empty($newLastName) || empty($newBiography)) {
            $_SESSION['error'] = 'All fields must be filled';
            header("Location: ../admin/admin.php");
            exit;
        }

        $sqlUpdateAuthor = "UPDATE authors SET first_name = :first_name, last_name = :last_name, biography = :biography WHERE id = :id";
        $stmtUpdateAuthor = $pdo->prepare($sqlUpdateAuthor);
        $stmtUpdateAuthor->bindParam(':first_name', $newFirstName);
        $stmtUpdateAuthor->bindParam(':last_name', $newLastName);
        $stmtUpdateAuthor->bindParam(':biography', $newBiography);
        $stmtUpdateAuthor->bindParam(':id', $authorId);

        if ($stmtUpdateAuthor->execute()) {
            $_SESSION['success'] = 'Author updated successfully';
            header("Location: ../admin/admin.php");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update author';
            header("Location: ../admin/admin.php");
            exit;
        }
    } else {
        $_SESSION['error'] = 'Author ID not provided';
        header("Location: ../admin/admin.php");
        exit;
    }
} else {
    $_SESSION['error'] = 'Invalid request method';
    header("Location: ../admin/admin.php");
    exit;
}