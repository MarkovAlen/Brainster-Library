<?php
require_once './start-sessions.php';
require_once '../db.php';

    $authorFirstName = $_POST['author_first_name'];
    $authorLastName = $_POST['author_last_name'];
    $authorBio = $_POST['author_biography'];

    if (empty($authorFirstName) || empty($authorLastName)) {
        $_SESSION['error'] = 'Author first name and last name cannot be empty';
        header("Location: ../admin/admin.php");
        exit;
    }

    $sqlInsertAuthor = "INSERT INTO authors (first_name, last_name, biography) VALUES (:first_name, :last_name, :biography)";
    $stmtInsertAuthor = $pdo->prepare($sqlInsertAuthor);
    $stmtInsertAuthor->bindParam(':first_name', $authorFirstName);
    $stmtInsertAuthor->bindParam(':last_name', $authorLastName);
    $stmtInsertAuthor->bindParam(':biography', $authorBio);

    if ($stmtInsertAuthor->execute()) {
        $_SESSION['success'] = 'Author added successfully';
        header("Location: ../admin/admin.php"); 
        exit;
    } else {
        $_SESSION['error'] = 'Failed to add author';
        header("Location: ../admin/admin.php");
        exit;
    }
