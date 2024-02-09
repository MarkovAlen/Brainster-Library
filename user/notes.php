<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['book_id'], $_POST['content'])) {
        $book_id = $_POST['book_id'];
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id']; 

        $sql = "INSERT INTO private_notes (user_id, book_id, content) VALUES (:user_id, :book_id, :content)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $response = ['status' => 'success'];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to create private note'];
            echo json_encode($response);
            exit;
        }
    }

    if (isset($_POST['delete_note_id'])) {
        $note_id = $_POST['delete_note_id'];
        $user_id = $_SESSION['user_id'];

        $sql = "DELETE FROM private_notes WHERE id = :note_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':note_id', $note_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $response = ['status' => 'success'];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to delete private note'];
            echo json_encode($response);
            exit;
        }
    }

    if (isset($_POST['update_note_id'], $_POST['update_content'])) {
        $note_id = $_POST['update_note_id'];
        $content = $_POST['update_content'];
        $user_id = $_SESSION['user_id']; 

        $sql = "UPDATE private_notes SET content = :content WHERE id = :note_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':note_id', $note_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $response = ['status' => 'success'];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to update private note'];
            echo json_encode($response);
            exit;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['book_id'])) {
        $book_id = $_GET['book_id'];
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM private_notes WHERE user_id = :user_id AND book_id = :book_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->execute();
        $private_notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['private_notes' => $private_notes]);
        exit;
    }
}
?>
