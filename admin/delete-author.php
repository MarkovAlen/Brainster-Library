<?php
require_once './start-sessions.php';
require_once '../db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the request contains the author ID
    if (isset($_GET['id'])) {
        $authorId = $_GET['id'];

        // Soft delete the author by setting is_deleted to 1
        $sqlDeleteAuthor = "UPDATE authors SET is_deleted = 1 WHERE id = :id";
        $stmtDeleteAuthor = $pdo->prepare($sqlDeleteAuthor);
        $stmtDeleteAuthor->bindParam(':id', $authorId);

        if ($stmtDeleteAuthor->execute()) {
            $_SESSION['success'] = 'Author deleted successfully';
            header("Location: ../admin/admin.php");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete author';
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