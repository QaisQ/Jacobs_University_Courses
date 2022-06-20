<?php
DEFINE('DB_USER', 'group20');
DEFINE('DB_PASSWORD', 'J4XEy7Gr');

$dsn = 'mysql:host=localhost;dbname=group20';

try{
    $conn = new PDO($dsn, DB_USER, DB_PASSWORD);
}catch (PDOException $error){
    $err_msg = $error->getMessage();
    include('db_error.php');
    exit();
}