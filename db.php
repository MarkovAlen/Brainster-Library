<?php
try{
$pdo = new \PDO("mysql:host=localhost;dbname=project2","root","");
}catch(\PDOException $e){
    echo "database down";
    die();
}