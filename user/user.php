<?php
require_once './user-logic.php';

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
<body class='bg-secondary'>
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
        <p class="navbar-text mb-0 mr-5"> <a href="../logout-user.php"><button type="button"
                                                                             class="btn btn-warning text-white">Logout</button></a></p>
    </div>
</nav>
<!-- NAVBAR  -->
<!-- BANNER  -->
<div class="container-fluid bg-banner d-flex align-items-center justify-content-center">
    <div class="row ">
        <div class="col-md-12 text-center ">
            <h3 class="animate-charcter">Brainster Library</h3>
        </div>
    </div>
</div>
<!-- BANNER  -->
<div class="container-fluid ">
        <div class="row filter-cards">
            <?php foreach ($categories as $category): ?>
                <div class="col-12 col-lg-4 bg-filters px-4 font-weight-bold category-filter border border-danger" 
                     data-category="<?php echo $category['id']; ?>">
                    <label class="py-4" for="category-<?php echo $category['id']; ?>">
                        <?php echo $category['title']; ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <p><h2 class="text-center py-3"> Книги </h2></p>

    <div class="container-fluid mt-2 ">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="row">

                    <?php foreach ($books as $book): ?>
                        <div class="col-12 col-md-6 col-lg-4 book-card category-<?php echo $book['category_id']; ?>">
                            <div class="card" style="width: 10rem;">
                                <img src="<?php echo $book['image_url']; ?>" class="card-img-top" alt="Book Cover">
                                <div class="card-body">
                                    <p class="bg-yellow d-inline-block font-weight-bold py-2 rounded bg-warning pl-2 pr-2"><?php echo $book['author_first_name'] . ' ' . $book['author_last_name']; ?></p>
                                    <h5 class="card-title font-weight-bold"><?php echo $book['title']; ?></h5>
                                    <p class="font-weight-bold date-tag">Категорија :  <?php echo $book['category_title']; ?></p>
                                    <div class="text-right">
                                         <a href="./book-details.php?book_id=<?php echo $book['id']; ?>" class="btn btn-primary px-4">Дознај повеќе</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

    <footer>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col">
                <h1 id="quote-text" class="text-white">Loading...</h1>
            </div>
        </div>
    </div>
</footer>

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
<script src="index.js"></script>
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

$(document).ready(function() {
 

    $(".category-filter").click(function() {
        const categoryId = $(this).data("category");
        const categoryBooks = $(".category-" + categoryId);
        const activeCategory = $(this).hasClass("active-category");

        if (!activeCategory) {
            $(".category-filter").removeClass("active-category");
            $(this).addClass("active-category");
            $(".book-card").hide();
            categoryBooks.show();
        } else {
            $(this).removeClass("active-category");
            $(".book-card").show();
        }
    });
});
</script>
</body>
</html>
