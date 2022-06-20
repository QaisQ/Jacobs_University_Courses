<?php
// DEFINE('DB_USER', 'group20user');
// DEFINE('DB_PASSWORD', 'group20user');

// $dsn = 'mysql:host=localhost;dbname=group20';

// try{
//     $db = new PDO($dsn, DB_USER, DB_PASSWORD);
// }catch (PDOException $error){
//     $err_msg = $error->getMessage();
//     include('db_error.php');
//     exit();
// }

$servername ='localhost';
$username = 'group20';
$password = 'J4XEy7Gr';
$dbname = 'group20';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if($conn){
    die('Error connecting to SQL server:' .mysql_error());
}
?>

