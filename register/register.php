<?php
 require_once './register-logic.php';

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
        <p class="navbar-text mb-0 mr-5"> <a href="../login/login.php"><button type="button" class="btn btn-warning text-white">Login</button></a></p>
        <p class="navbar-text mb-0 mr-5"> <a href="../index.php"><button type="button" class="btn btn-dark text-white">Home</button></a></p>
    </div>
</nav>
<!-- NAVBAR  -->
<div class="container">
        
        <h1 class='text-center pt-5 pb-5'>Register</h1>
        <form action="register-logic.php" method='POST'>
          <div class="row">
            <div class="col-6 offset-3 mb-3">
                <span>
                 <?php 
        if(isset($_SESSION['error'])){
            echo "<h3 class='text-white bg-danger text-center'>{$_SESSION['error']}</h3>";
            unset($_SESSION['error']);
        }
           ?>
           </span>
              <label for="username" class='text-white'>username</label>
              <input type="text" class="form-control" id='username' placeholder="username " name='username'/>
            </div>
          </div>
          <div class="row">
            <div class="col-6 offset-3 mb-3">
              <label for="password" class='text-white'>password</label>
              <input type="password" class="form-control" id='password' placeholder="password " name='password'/>
            </div>
          </div>
          <div class="row">
            <div class="col-6 offset-3 mt-4 mb-5">
            <button type="submit" class="btn btn-primary btn-block" name='submit'>Register</button>
            </div>
          </div>
        </form>
        </div>
        <!-- jQuery library -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="ha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        
        <!-- Latest Compiled Bootstrap 4.6 JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    </body>
</html>