<?php
require_once './start-sessions.php';
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['book_title'];
    $authorId = $_POST['book_author_id']; 
    $yearOfRelease = $_POST['book_year'];
    $numberOfPages = $_POST['book_pages'];
    $imageUrl = $_POST['book_image_url'];
    $categoryId = $_POST['book_category_id']; 

    if (empty($title) || empty($yearOfRelease) || empty($numberOfPages) || empty($imageUrl)) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: ../admin/admin.php"); 
        exit;
    }

    // Assuming your table for books is named "books"
    $sqlInsertBook = "INSERT INTO books (title, author_id, publication_year, page_count, image_url, category_id) 
                      VALUES (:title, :authorId, :yearOfRelease, :numberOfPages, :imageUrl, :categoryId)";
    
    $stmtInsertBook = $pdo->prepare($sqlInsertBook);
    $stmtInsertBook->bindParam(':title', $title);
    $stmtInsertBook->bindParam(':authorId', $authorId);
    $stmtInsertBook->bindParam(':yearOfRelease', $yearOfRelease);
    $stmtInsertBook->bindParam(':numberOfPages', $numberOfPages);
    $stmtInsertBook->bindParam(':imageUrl', $imageUrl);
    $stmtInsertBook->bindParam(':categoryId', $categoryId);

    if ($stmtInsertBook->execute()) {
        $_SESSION['success'] = 'Book added successfully';
        header("Location: ../admin/admin.php"); 
        exit;
    } else {
        $_SESSION['error'] = 'Failed to add book';
        header("Location: ../admin/admin.php"); 
        exit;
    }
}
