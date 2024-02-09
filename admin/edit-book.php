<?php
require_once './start-sessions.php';
require_once '../db.php';


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $title = $_POST['newTitle'];
    $authorId = $_POST['newAuthorId'];
    $publicationYear = $_POST['newPublicationYear'];
    $pageCount = $_POST['newPageCount'];
    $imageUrl = $_POST['newImageUrl'];
    $categoryId = $_POST['newCategoryId'];

    if (empty($title) || empty($authorId) || empty($publicationYear) || empty($pageCount) || empty($imageUrl) || empty($categoryId)) {
        $_SESSION['error'] = 'All fields are required. Please fill in all the required fields.';
        header("Location: your-form-page.php"); 
        exit;
    }

    $sqlEditBook = "UPDATE books 
                    SET title = :title, 
                        author_id = :author_id, 
                        publication_year = :publication_year, 
                        page_count = :page_count, 
                        image_url = :image_url, 
                        category_id = :category_id 
                    WHERE id = :id";
    
    $stmtEditBook = $pdo->prepare($sqlEditBook);
    $stmtEditBook->bindParam(':title', $title);
    $stmtEditBook->bindParam(':author_id', $authorId);
    $stmtEditBook->bindParam(':publication_year', $publicationYear);
    $stmtEditBook->bindParam(':page_count', $pageCount);
    $stmtEditBook->bindParam(':image_url', $imageUrl);
    $stmtEditBook->bindParam(':category_id', $categoryId);
    $stmtEditBook->bindParam(':id', $bookId);
    
    if ($stmtEditBook->execute()) {
        $_SESSION['success'] = 'Book updated successfully';
        header("Location: ../admin/admin.php"); 
        exit;
    } else {
        $_SESSION['error'] = 'Failed to update book';
        header("Location: ../admin/admin.php"); 
        exit;
    }
} 