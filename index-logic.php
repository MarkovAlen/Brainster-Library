<?php
require_once './db.php';
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
$sql = "SELECT books.id, books.title, authors.first_name AS author_first_name, authors.last_name AS author_last_name,books.category_id, books.publication_year, books.page_count, books.image_url, categories.title AS category_title
        FROM books
        INNER JOIN authors ON books.author_id = authors.id
        INNER JOIN categories ON books.category_id = categories.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>