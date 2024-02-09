<?php 
require_once './admin-logic.php';
require_once './add-category.php';
require_once './delete-category.php';
require_once './edit-category.php';
require_once './add-book.php';



?>
<!DOCTYPE html>
<html>
    <head>
        <title>Document</title>
        <meta charset="utf-8" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <!-- Latest compiled and minified Bootstrap 4.6 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <!-- CSS script -->
        <link rel="stylesheet" href="style.css">
        <!-- Latest Font-Awesome CDN -->
        <script src="https://kit.fontawesome.com/64087b922b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- NAVBAR  -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <a class="navbar-brand text-center ml-lg-5 " href="#"><img src="../images/Logo.png" alt="Logo" width="50px"> <br> <span class="font-size-xs">BRAINSTER</span></a>
    <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#Modalnav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><span ><i class="fa-solid fa-bars-staggered fa-2x"></i></span></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <span class="navbar-nav mr-auto"></span>
        <p class="navbar-text mb-0 mr-5"> <a href="../logout-user.php"><button type="button"
                                                                             class="btn btn-warning text-white">Logout</button></a></p>
    </div>
</nav>
<!-- NAVBAR  -->
<div class="container mt-5">
<div class="row ">
        <div class="col mt-3 mb-3">
        <?php 
        if(isset($_SESSION['error'])){
            echo "<h3 class='text-white bg-danger text-center'>{$_SESSION['error']}</h3>";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            echo "<h3 class='text-white bg-success text-center'>{$_SESSION['success']}</h3>";
            unset($_SESSION['success']);
        }
           ?>
        </div>

    </div>
    <div class="row">
        <div class="col">
        <?php 
        if(isset($_SESSION['reg-success'])){
            echo "<h3 class='text-white bg-success text-center'>{$_SESSION['reg-success']}</h3>";
            unset($_SESSION['reg-success']);
        }
           ?>
        </div>
    </div>
    <div class="row">
        <div class="col category-btn"><button type="button" class="btn btn-primary btn-block display-crud ">Category</button></div>
    </div>
    <div class="row d-none category-btn-txt">
    <div class="col text-center">
        <form action="add-category.php" method="POST">
            <h3 class='text-center mt-5 mb-0 pb-0'>Add a category</h3>
            <label for="category" class='text-white'>Category</label>
            <input type="text" class="form-control" id="category" name="category" placeholder="Category" required>
            <button type='submit' class="btn btn-primary mt-4 add">Add</button>
        </form>
    </div>
</div>

<!-- Edit and Delete Category Form -->
<div class="row d-none category-btn-txt">
    <div class="col text-center">
        <h3 class='text-center mt-5 mb-0 pb-0'>Delete or Edit a category</h3>
        <div class="container mt-5">
        <table class="table">
        <thead>
            <tr>
                <td><h2>Title</h2></td>
                <td><h2>Edit</h2></td>
                <td><h2>Delete</h2></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['title']; ?></td>
                    <td>
                        <button class="edit-btn btn btn-success" data-target="#editForm<?php echo $category['id']; ?>">Edit</button>
                    </td>
                    <td>
                        <a href="delete-category.php?action=delete&id=<?php echo $category['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div id="editForm<?php echo $category['id']; ?>" class="collapse edit-form">
                        <form action="edit-category.php?id=<?php echo $category['id']; ?>" method="POST">
                                <div class="form-group">
                                    <label for="newTitle">Edit Title</label>
                                    <input type="text" class="form-control" id="newTitle" name="newTitle" value="<?php echo $category['title']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary update">Update</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
</div>
<div class="container mt-5">
    <!-- Add Author -->
    <div class="row">
        <div class="col author-btn"><button type="button" class="btn btn-primary btn-block display-crud">Author</button></div>
    </div>
    <div class="row d-none author-btn-txt">
        <div class="col text-center">
            <form action="add-author.php" method="POST">
                <h3 class="text-center mt-5 mb-0 pb-0">Add an author</h3>
                <label for="author_first_name" class="text-white">First Name</label>
                <input type="text" class="form-control" id="author_first_name" name="author_first_name" placeholder="Author First Name" required>

                <label for="author_last_name" class="text-white">Last Name</label>
                <input type="text" class="form-control" id="author_last_name" name="author_last_name" placeholder="Author Last Name" required>

                <label for="author_biography" class="text-white">Biography</label>
                <textarea class="form-control" id="author_biography" name="author_biography" placeholder="Author Biography" required></textarea>

                <button type="submit" class="btn btn-primary mt-4 add">Add Author</button>
            </form>
        </div>
    </div>
</div>

<!-- Author List Table -->
<div class="container mt-5">
    <div class="row d-none author-btn-txt">
        <table class="table">
            <thead>
                <tr>
                    <td><h2>First Name</h2></td>
                    <td><h2>Last Name</h2></td>
                    <td><h2>Biography</h2></td>
                    <td><h2>Edit</h2></td>
                    <td><h2>Delete</h2></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authors as $author): ?>
                    <tr>
                        <td><?php echo $author['first_name']; ?></td>
                        <td><?php echo $author['last_name']; ?></td>
                        <td><?php echo $author['biography']; ?></td>
                        <td>
                            <button class="edit-btn btn btn-success" data-target="#editForm<?php echo $author['id']; ?>">Edit</button>
                        </td>
                        <td>
                            <a href="delete-author.php?action=delete&id=<?php echo $author['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div id="editForm<?php echo $author['id']; ?>" class="collapse edit-form">
                                <form action="edit-author.php?id=<?php echo $author['id']; ?>" method="POST">
                                    <div class="form-group">
                                        <label for="newFirstName">Edit First Name</label>
                                        <input type="text" class="form-control" id="newFirstName" name="newFirstName" value="<?php echo $author['first_name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="newLastName">Edit Last Name</label>
                                        <input type="text" class="form-control" id="newLastName" name="newLastName" value="<?php echo $author['last_name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="newBiography">Edit Biography</label>
                                        <textarea class="form-control" id="newBiography" name="newBiography" required><?php echo $author['biography']; ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary update">Update</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Add Book -->
<div class="container mt-5">
    <div class="row">
        <div class="col book-btn"><button type="button" class="btn btn-primary btn-block display-crud">Book</button></div>
    </div>
    <div class="row d-none book-btn-txt">
        <div class="col text-center">
            <form action="add-book.php" method="POST">
                <h3 class="text-center mt-5 mb-0 pb-0">Add a Book</h3>
                
                <!-- Title -->
                <label for="book_title" class="text-white">Title</label>
                <input type="text" class="form-control" id="book_title" name="book_title" placeholder="Book Title" required>
                
                <!-- Author (select from existing authors) -->
                <label for="book_author_id" class="text-white">Author</label>
                <select class="form-control" id="book_author_id" name="book_author_id" required>
                    <option value="" disabled selected>Select an Author</option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?php echo $author['id']; ?>"><?php echo $author['first_name'] . ' ' . $author['last_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <!-- Year of Release -->
                <label for="book_year" class="text-white">Year of Release</label>
                <input type="text" class="form-control" id="book_year" name="book_year" placeholder="Year of Release" required>
                
                <!-- Number of Pages -->
                <label for="book_pages" class="text-white">Number of Pages</label>
                <input type="text" class="form-control" id="book_pages" name="book_pages" placeholder="Number of Pages" required>
                
                <!-- Image URL -->
                <label for="book_image_url" class="text-white">Image URL</label>
                <input type="text" class="form-control" id="book_image_url" name="book_image_url" placeholder="Image URL" required>
                
                <!-- Category (select from existing categories) -->
                <label for="book_category_id" class="text-white">Category</label>
                <select class="form-control" id="book_category_id" name="book_category_id" required>
                    <option value="" disabled selected>Select a Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="btn btn-primary mt-4 add">Add Book</button>
            </form>
        </div>
    </div>
</div>

<!-- Book List Table -->
<div class="container mt-5">
    <div class="row d-none book-btn-txt">
        <table class="table">
            <thead>
                <tr>
                    <td><h2>Title</h2></td>
                    <td><h2>Author</h2></td>
                    <td><h2>Year of Release</h2></td>
                    <td><h2>Number of Pages</h2></td>
                    <td><h2>Image URL</h2></td>
                    <td><h2>Category</h2></td>
                    <td><h2>Edit</h2></td>
                    <td><h2>Delete</h2></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                    <td><?php echo $book['title']; ?></td>
        <td><?php echo $book['author_first_name'] . ' ' . $book['author_last_name']; ?></td>
        <td><?php echo $book['publication_year']; ?></td>
        <td><?php echo $book['page_count']; ?></td>
        <td class="shorten-link" data-toggle="tooltip" data-placement="top" title="<?php echo $book['image_url']; ?>">
        <?php echo $book['image_url']; ?></td>
        <style>
        .shorten-link {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        }
       </style>
        <td><?php echo $book['category_title']; ?></td>
        <td><button class="edit-btn btn btn-success" data-target="#editForm<?php echo $book['id']; ?>">Edit</button>
                        </td>
                        <td>
                            <a href="delete-book.php?action=delete&id=<?php echo $book['id']; ?>" class="btn btn-danger delete-book">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                        <div id="editForm<?php echo $book['id']; ?>" class="collapse edit-form">
    <form action="edit-book.php?id=<?php echo $book['id']; ?>" method="POST">
        <div class="form-group">
            <label for="newTitle">Title</label>
            <input type="text" class="form-control" id="newTitle" name="newTitle" value="<?php echo $book['title']; ?>" required>
        </div>
        <div class="form-group">
            <label for="newAuthorId">Author</label>
            <select class="form-control" id="newAuthorId" name="newAuthorId" required>
                <?php foreach ($authors as $author): ?>
                    <option value="<?php echo $author['id']; ?>"><?php echo $author['first_name'] . ' ' . $author['last_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="newPublicationYear">Year of Release</label>
            <input type="text" class="form-control" id="newPublicationYear" name="newPublicationYear" value="<?php echo $book['publication_year']; ?>" required>
        </div>
        <div class="form-group">
            <label for="newPageCount">Number of Pages</label>
            <input type="text" class="form-control" id="newPageCount" name="newPageCount" value="<?php echo $book['page_count']; ?>" required>
        </div>
        <div class="form-group">
            <label for="newImageUrl">Image URL</label>
            <input type="text" class="form-control" id="newImageUrl" name="newImageUrl" value="<?php echo $book['image_url']; ?>" required>
        </div>
        <div class="form-group">
            <label for="newCategoryId">Category</label>
            <select class="form-control" id="newCategoryId" name="newCategoryId" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary update">Update</button>
    </form>
</div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="container mt-5">
<div class="row">
        <div class="col comments-btn"><button type="button" class="btn btn-primary btn-block display-crud ">Comments</button></div>
    </div>
    <div class="row d-none comments-btn-txt">
    <div class="container mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Book</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?php echo $comment['user_name']; ?></td>
                        <td><?php echo $comment['book_title']; ?></td>
                        <td><?php echo $comment['comment_content']; ?></td>
                        <td><?php echo $comment['is_approved'] ? 'Approved' : 'Unapproved'; ?></td>
                        <td>
                            <form action="./admin-logic.php" method="post" class="d-inline">
                                <input type="hidden" name="approve_comment_id" value="<?php echo $comment['comment_id']; ?>">
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="./admin-logic.php" method="post" class="d-inline">
                                <input type="hidden" name="unapprove_comment_id" value="<?php echo $comment['comment_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Unapprove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
</div>
</div>
       <script src="admin.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Latest Compiled Bootstrap 4.6 JavaScript -->
        
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

        <script>

        $(function() {
       $('.category-btn').on('click', function() {
        $('.category-btn-txt').removeClass('d-none');
        $('.author-btn-txt').addClass('d-none');
        $('.book-btn-txt').addClass('d-none');
        $('.comments-btn-txt').addClass('d-none');
       });
        
       $('.author-btn').on('click', function() {
           $('.author-btn-txt').removeClass('d-none');
           $('.category-btn-txt').addClass('d-none');
           $('.book-btn-txt').addClass('d-none');
           $('.comments-btn-txt').addClass('d-none');
      });

    $('.book-btn').on('click', function() {
         $('.book-btn-txt').removeClass('d-none');
         $('.category-btn-txt').addClass('d-none');
         $('.author-btn-txt').addClass('d-none');
         $('.comments-btn-txt').addClass('d-none');

     });
     $('.comments-btn').on('click', function() {
         $('.comments-btn-txt').removeClass('d-none');
         $('.category-btn-txt').addClass('d-none');
         $('.author-btn-txt').addClass('d-none');
         $('.book-btn-txt').addClass('d-none');
     });


        $('.edit-btn').click(function(event) {
        event.preventDefault(); 
        var targetId = $(this).attr('data-target'); 
        $(targetId).collapse('toggle');
    });
    $('.delete-book').on('click', function(event) {
            event.preventDefault();
            
            var deleteUrl = $(this).attr('href');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this book!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });

        
});
</script>
    </body>
</html>