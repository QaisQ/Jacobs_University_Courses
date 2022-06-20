<?php 
    require('../dbconnect.php');
    $query = 'SELECT * from users ORDER BY user_id';
    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Up</title>
    <link rel="stylesheet" type="text/css" href="../impct.css" />
</head>
<style>
    body{
        background-color: #1893f8;
    }
</style>
<body>
    
    <h1>User Login</h1>
    <h4>Under Maintenance, Don't use!</h4>
    <hr>

    <form action="../index.html" method="post">
        Username: <input type="text"  name="username"><br>
        Password:<input type="password" name="password"><br>
        <input type="submit" name="submit" value="Log me in!"><br>
    </form> 

    
</body>
</html>