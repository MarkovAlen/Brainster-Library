<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];
    require_once '../db.php';

    // Retrieve book details
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            $user_id = $_SESSION['user_id'];
            $comment_content = $_POST['comment'];

            $sql = "INSERT INTO comments (user_id, book_id, content, is_approved)
                    VALUES (:user_id, :book_id, :content, 0)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->bindParam(':content', $comment_content, PDO::PARAM_STR);
            $stmt->execute();

            // Redirect back to the same page after submitting a comment
            header("Location: book-details.php?book_id=$bookId");
            exit;
        }
        // Fetch unapproved comments for the current user
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM comments WHERE book_id = :bookId AND user_id = :user_id AND is_approved = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $unapprovedComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // delete comment 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id'])) {
        $delete_comment_id = $_POST['delete_comment_id'];
        $user_id = $_SESSION['user_id'];
        
        $sql = "DELETE FROM comments WHERE id = :comment_id AND user_id = :user_id AND is_approved = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':comment_id', $delete_comment_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    
        header("Location: book-details.php?book_id=$bookId");
        exit;
    }
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
    <a class="navbar-brand text-center ml-lg-5 " href="#"><img src="../images/Logo.png" alt="Logo" width="50px"> <br>
        <span class="font-size-xs">BRAINSTER</span></a>
    <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#Modalnav"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><span><i class="fa-solid fa-bars-staggered fa-2x"></i></span></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <span class="navbar-nav mr-auto"></span>
        <p class="navbar-text mb-0 mr-5"> <a href="./user.php"><button type="button"
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
            <div class="book-card category-<?php echo $book['categoryId']; ?>" style="width: 20rem;">
                <div class="card">
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
        <div class="col-md-6">
            <h3 class="mt-3">Comments:</h3>
            <?php
            if ($unapprovedComments) {
                echo '<table class="table table-striped table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Comment</th>';
                echo '<th scope="col">Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($unapprovedComments as $comment) {
                    echo '<tr>';
                    echo '<td>' . $comment['content'] . '</td>';
                    echo '<td>';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="delete_comment_id" value="' . $comment['id'] . '">';
                    echo '<button type="submit" class="btn btn-danger">Delete</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            }
            ?>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($approvedComments) {
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
                    }
                    ?>
                </tbody>
            </table>

            <h3 class="mt-3">Add a Comment:</h3>
            <form action="" method="post">
                <div class="form-group">
                    <label for="comment">Your Comment:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>
</div>
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <h3>Add Private Note</h3>
            <form id="add-note-form">
                <input type="hidden" id="book_id" name="book_id" value="<?php echo $bookId; ?>">
                <div class="form-group">
                    <label for="note_content">Note Content:</label>
                    <textarea class="form-control" id="note_content" name="content" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Note</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <h3>Private Notes</h3>
            <ul id="private-notes-list">
                
            </ul>
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


<?php
}
?>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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



   $(document).ready(function () {
    $('#add-note-form').submit(function (e) {
        e.preventDefault();

        var book_id = $('#book_id').val();
        var note_content = $('#note_content').val();

        $.ajax({
            type: 'POST',
            url: 'notes.php', 
            data: { book_id: book_id, content: note_content },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#note_content').val('');
                    loadPrivateNotes(book_id);
                } else {
                    alert('Failed to create private note');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX request failed:', error);
                alert('Failed to create private note');
            }
        });
    });

    function loadPrivateNotes(book_id) {
        $.get('notes.php?book_id=' + book_id, function (response) {
            var notesHtml = '';
            if (response.private_notes) {
                $.each(response.private_notes, function (index, note) {
                    notesHtml += '<li>';
                    notesHtml += '<p>' + note.content + '</p>';
                    notesHtml += '<button class="mr-2 mb-3 btn btn-sm btn-primary edit-note" data-note-id="' + note.id + '">Edit</button>';
                    notesHtml += '<button class="btn mb-3 btn-sm btn-danger delete-note" data-note-id="' + note.id + '">Delete</button>';
                    notesHtml += '<hr>';
                    notesHtml += '</li>';
                });
            } else {
                notesHtml = 'No private notes available.';
            }
            $('#private-notes-list').html(notesHtml);
            
            $('.edit-note').click(function () {
                var noteId = $(this).data('note-id');
                var newContent = prompt('Edit Note:', $(this).prev().text());
                if (newContent !== null) {
                    $.ajax({
                        type: 'POST',
                        url: 'notes.php',
                        data: { update_note_id: noteId, update_content: newContent },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                loadPrivateNotes(book_id);
                            } else {
                                alert('Failed to update private note');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log('AJAX request failed:', error);
                            alert('Failed to update private note');
                        }
                    });
                }
            });

            $('.delete-note').click(function () {
                var noteId = $(this).data('note-id');
                if (confirm('Are you sure you want to delete this note?')) {
                    $.ajax({
                        type: 'POST',
                        url: 'notes.php',
                        data: { delete_note_id: noteId },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                loadPrivateNotes(book_id);
                            } else {
                                alert('Failed to delete private note');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log('AJAX request failed:', error);
                            alert('Failed to delete private note');
                        }
                    });
                }
            });
        }, 'json');
    }

    loadPrivateNotes(<?php echo $bookId; ?>);
});
</script>


</body>
</html>
