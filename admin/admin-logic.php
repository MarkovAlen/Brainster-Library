<?php
require_once './start-sessions.php';
require_once '../db.php'; 

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login/login.php");
    exit;
}
// List categories
$sql = "SELECT * FROM categories WHERE is_deleted = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
//List authors
$sql = "SELECT * FROM authors WHERE is_deleted = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
//list books 
$sql = "SELECT books.id, books.title, authors.first_name AS author_first_name, authors.last_name AS author_last_name, books.publication_year, books.page_count, books.image_url, categories.title AS category_title
        FROM books
        INNER JOIN authors ON books.author_id = authors.id
        INNER JOIN categories ON books.category_id = categories.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
// comments 
$sqlApproved = "SELECT * FROM comments WHERE is_approved = 1";
$stmtApproved = $pdo->query($sqlApproved);
$approvedComments = $stmtApproved->fetchAll(PDO::FETCH_ASSOC);

$sqlUnapproved = "SELECT * FROM comments WHERE is_approved = 0";
$stmtUnapproved = $pdo->query($sqlUnapproved);
$unapprovedComments = $stmtUnapproved->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM comments WHERE is_approved = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$unapprovedComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM comments WHERE is_approved = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$approvedComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM comments WHERE is_approved = 0";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$unapprovedComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM comments WHERE is_approved = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$approvedComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT comments.id AS comment_id, comments.content AS comment_content, 
               users.username AS user_name, books.title AS book_title, comments.is_approved AS is_approved
        FROM comments
        INNER JOIN users ON comments.user_id = users.id
        INNER JOIN books ON comments.book_id = books.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve_comment_id'])) {
        $commentId = $_POST['approve_comment_id'];

        $sql = "UPDATE comments SET is_approved = 1 WHERE id = :comment_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->execute();
    } elseif (isset($_POST['unapprove_comment_id'])) {
        $commentId = $_POST['unapprove_comment_id'];

        $sql = "UPDATE comments SET is_approved = 0 WHERE id = :comment_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    header("Location: admin.php"); 
    exit;
}


?>
