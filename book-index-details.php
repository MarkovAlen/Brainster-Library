<?php
session_start();
$book = null;
try {
    if (isset($_GET['book_id'])) {
        $bookId = $_GET['book_id'];
        require_once './db.php';
    
        $sql = "SELECT books.title AS bookTitle,
        authors.first_name AS author_first_name,
        authors.last_name AS author_last_name,
        books.publication_year,
        books.page_count,
        books.image_url,
        categories.title,
        categories.id AS categoryId
        FROM books
        INNER JOIN categories ON books.category_id = categories.id
        INNER JOIN authors ON books.author_id = authors.id
        WHERE books.id = :bookId";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($book) {
            $sql = "SELECT * FROM comments WHERE book_id = :bookId AND is_approved = 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $stmt->execute();
            $approvedComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <meta charset="utf-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>

    <!-- Latest compiled and minified Bootstrap 4.6 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
          crossorigin="anonymous">
    <!-- CSS script -->
    <link rel="stylesheet" href="../style.css">
    <!-- Latest Font-Awesome CDN -->
    <script src="https://kit.fontawesome.com/64087b922b.js" crossorigin="anonymous"></script>
</head>
<body>
<!-- NAVBAR  -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <a class="navbar-brand text-center ml-lg-5 " href="#"><img src="./images/Logo.png" alt="Logo" width="50px"> <br>
        <span class="font-size-xs">BRAINSTER</span></a>
    <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#Modalnav"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><span><i class="fa-solid fa-bars-staggered fa-2x"></i></span></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <span class="navbar-nav mr-auto"></span>
        <p class="navbar-text mb-0 mr-5"> <a href="./index.php"><button type="button"
                                                                             class="btn btn-warning text-white">Home</button></a></p>
    </div>
</nav>
<!-- NAVBAR  -->

<?php
if ($book) {
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="book-card category-<?php echo $book['categoryId']; ?>">
                <div class="card" style="width: 20rem;">
                    <img src="<?php echo $book['image_url']; ?>" class="card-img-top" alt="Book Cover">
                    <div class="card-body">
                        <p class="bg-yellow d-inline-block font-weight-bold py-2 rounded bg-warning pl-2 pr-2"><?php echo $book['author_first_name'] . ' ' . $book['author_last_name']; ?></p>
                        <h5 class="card-title font-weight-bold"><?php echo $book['bookTitle']; ?></h5>
                        <p class="font-weight-bold date-tag">Категорија :  <?php echo $book['title']; ?></p>
                        <p class="font-weight-bold date-tag">Година на издавање : <?php echo $book['publication_year']; ?></p>
                        <p class="font-weight-bold date-tag">Број на страници : <?php echo $book['page_count']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-5">
            <h3 class="mt-3">Comments:</h3>
            <?php
            if ($approvedComments) {
                echo '<table class="table table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>User</th>';
                echo '<th>Comment</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($approvedComments as $comment) {
                    $userId = $comment['user_id'];
                    $sql = "SELECT username FROM users WHERE id = :userId";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    echo '<tr>';
                    echo '<td>' . $user['username'] . '</td>';
                    echo '<td>' . $comment['content'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No comments available for this book.</p>';
            }
            ?>
        </div>
    </div>
</div>
</div>

<footer>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col">
                <h1 id="quote-text" class="text-dark">Loading...</h1>
            </div>
        </div>
    </div>
</footer>

<?php }?>

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="ha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>

<!-- Latest Compiled Bootstrap 4.6 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>
        <script>
              function loadRandomQuote() {
    fetch('http://api.quotable.io/random')
        .then(response => response.json())
        .then(data => {
            const quoteText = data.content;
            const footerElement = document.getElementById('quote-text');
            footerElement.textContent = `"${quoteText}" - ${data.author}`;
        })
        .catch(error => {
            console.error('Error fetching random quote:', error);
        });
}

window.addEventListener('load', loadRandomQuote);
        </script>
</body>
</html>
