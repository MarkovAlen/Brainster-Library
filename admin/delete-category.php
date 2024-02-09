<?php
require_once './start-sessions.php';
require_once '../db.php';

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $categoryId = $_GET['id'];

        $sqlDeleteCategory = "UPDATE categories SET is_deleted = 1 WHERE id = :id";
        $stmtDeleteCategory = $pdo->prepare($sqlDeleteCategory);
        $stmtDeleteCategory->bindParam(':id', $categoryId);

        if ($stmtDeleteCategory->execute()) {
            $_SESSION['success'] = 'Category deleted successfully';
            header("Location: ../admin/admin.php");
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete category';
            header("Location: ../admin/admin.php");
            exit;
        }
    }