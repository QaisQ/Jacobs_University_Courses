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

// $servername ='localhost';
// $username = 'group20';
// $password = 'J4XEy7Gr';
// $dbname = 'group20';

// $conn = new mysqli($servername, $username, $password);
// if(!$conn->connect_error){
//     die('Error connecting to SQL server:' .mysql_error());
// }else{
//     echo "Database connected";
// }
?>

