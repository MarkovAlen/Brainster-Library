<?php
require_once './start-sessions.php';
require_once '../db.php';
if (isset($_POST['newTitle'])) {
    $categoryId = $_GET['id'];
    $editedCategory = $_POST['newTitle'];

    if (empty($editedCategory)) {
        $_SESSION['error'] = 'Category title cannot be empty';
        header("Location: ../admin/admin.php?action=edit&id=$categoryId");
        exit;
    }

    $sqlEditCategory = "UPDATE categories SET title = :title WHERE id = :id";
    $stmtEditCategory = $pdo->prepare($sqlEditCategory);
    $stmtEditCategory->bindParam(':title', $editedCategory);
    $stmtEditCategory->bindParam(':id', $categoryId);

    if ($stmtEditCategory->execute()) {
        $_SESSION['success'] = 'Category updated successfully';
        header("Location: ../admin/admin.php");
        exit;
    } else {
        $_SESSION['error'] = 'Failed to update category';
        header("Location: ../admin/admin.php");
        exit;
    }
}
?>