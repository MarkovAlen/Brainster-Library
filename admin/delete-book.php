<?php
require_once './start-sessions.php';
require_once '../db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../login/login.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $bookId = $_GET['id'];

    $sqlCheckComments = "SELECT COUNT(*) FROM comments WHERE book_id = :book_id";
    $stmtCheckComments = $pdo->prepare($sqlCheckComments);
    $stmtCheckComments->bindParam(':book_id', $bookId);

    $stmtCheckComments->execute();
    $commentCount = $stmtCheckComments->fetchColumn();

    if ($commentCount > 0) {
        $sqlDeleteComments = "DELETE FROM comments WHERE book_id = :book_id";
        $stmtDeleteComments = $pdo->prepare($sqlDeleteComments);
        $stmtDeleteComments->bindParam(':book_id', $bookId);

        if ($stmtDeleteComments->execute()) {
            $_SESSION['success'] = 'Associated comments deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete associated comments';
        }
    }

    $sqlCheckPrivateNotes = "SELECT COUNT(*) FROM private_notes WHERE book_id = :book_id";
    $stmtCheckPrivateNotes = $pdo->prepare($sqlCheckPrivateNotes);
    $stmtCheckPrivateNotes->bindParam(':book_id', $bookId);

    $stmtCheckPrivateNotes->execute();
    $privateNotesCount = $stmtCheckPrivateNotes->fetchColumn();

    if ($privateNotesCount > 0) {
        $sqlDeletePrivateNotes = "DELETE FROM private_notes WHERE book_id = :book_id";
        $stmtDeletePrivateNotes = $pdo->prepare($sqlDeletePrivateNotes);
        $stmtDeletePrivateNotes->bindParam(':book_id', $bookId);

        if ($stmtDeletePrivateNotes->execute()) {
            $_SESSION['success'] = 'Associated private notes deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete associated private notes';
        }
    }

    $sqlDeleteBook = "DELETE FROM books WHERE id = :id";
    $stmtDeleteBook = $pdo->prepare($sqlDeleteBook);
    $stmtDeleteBook->bindParam(':id', $bookId);

    if ($stmtDeleteBook->execute()) {
        $_SESSION['success'] = 'Book deleted successfully';
    } else {
        $_SESSION['error'] = 'Failed to delete book';
    }

    header("Location: ../admin/admin.php");
    exit;
}