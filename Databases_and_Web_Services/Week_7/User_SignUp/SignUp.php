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
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="../impct.css" />
</head>
<style>
    body{
        background-color: #1893f8;
    }
</style>
<body>
    
    <h1>User Sign Up</h1>
    <a href="../Maintenance.html">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>
    <h1>All Users</h1>
    

    <h2> Sign Up Page </h2>
    <form action="add_user.php" method="post">
        Username: <input type="text"  name="username"><br>
        First Name:<input type="text"  name="first_name"><br>
        Last Name:<input type="text"  name="last_name"><br>
        Email Address:<input type="text"  name="email"><br>
        Location:<input type="text"  name="location"><br>
        Phone Number:<input type="text"  name="phone"><br>
        Password:<input type="password" name="password"><br>
        <input type="submit" name="submit" value="Create Account"><br>
    </form> 

    <form action="search_users.php" method="POST">
              <input class = "search-bar" type="text" name="search" placeholder="Search">
              <button class = "search-button" type = "submit" name = "submit-search">Search</button>
    </form>

    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Location</th>
            <th>Phone Number</th>           
        </tr>
        <?php foreach ($result as $student) : ?>
            <tr>
                <td><?php echo $student['user_id']?></td>
                <td><?php echo $student['username']?></td>
                <td><?php echo $student['first_name']?></td>
                <td><?php echo $student['last_name']?></td>
                <td><?php echo $student['email']?></td>
                <td><?php echo $student['location']?></td>
                <td><?php echo $student['phone_number']?></td>
            </tr>
        <?php endforeach?>
    </table>

    <a href="#">Top</a>
</body>
</html>