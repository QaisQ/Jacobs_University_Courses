<?php
$username = filter_input(INPUT_POST, 'username');
$location = filter_input(INPUT_POST, 'location');
$first_name = filter_input(INPUT_POST, 'first_name');
$last_name = filter_input(INPUT_POST, 'last_name');
$password = filter_input(INPUT_POST, 'password');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone_number = filter_input(INPUT_POST, 'phone');

if($username == null || $location == null || $first_name == null ||
   $last_name == null || $password == null || $email == null ||$phone_number == null){
        $err_msg = "All Values Not Entered";
        include("../db_error.php");
   }else{
       require_once("../dbconnect.php");
       $query = 'INSERT INTO users(user_id, username, location, first_name, last_name, password, email, phone_number) 
       VALUES(:user_id, :username, :location, :first_name, :last_name, :password, :email, :phone_number)';
        $stm = $conn->prepare($query);

        $stm->bindValue(":user_id", null, PDO::PARAM_INT);
        $stm->bindValue(':username', $username);
        $stm->bindValue(':location', $location);
        $stm->bindValue(':first_name', $first_name);
        $stm->bindValue(':last_name', $last_name);
        $stm->bindValue(':password', $password);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':phone_number', $phone_number);
    

        $check_success = $stm->execute();
        $stm->closeCursor();

        if(!$check_success){
            $err_msg = "Error Inserting Values";
            include ("../db_error.php");
        }

        
        require_once("../dbconnect.php");
        $query = 'GRANT SELECT ON users TO :username';

        $stm = $db->prepare($query);
        $stm->bindValue(':username', $username);
        $check_error = $stm->execute();
        $stm->closeCursor();

        if(!$check_error){
            $err_msg = "Error Granting Access";
            include("../db_error.php");

        }
   }
    
    require_once('../dbconnect.php');
    $query = 'SELECT * from users ORDER BY user_id';
    $students_statement = $conn->prepare($query);
    $students_statement->execute();
    $students = $students_statement->fetchAll();
    $students_statement->closeCursor();

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
    <a href="../MainHeader/AdminMaintenance/Maintenance.php">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>
    <h1>All Users</h1>

    <h2> Sign Up Page </h2>
    <form action="add_user.php" method="post">
        Username: <input type="text"  name="username"><br>
        First Name:<input type="text"  name="first_name"><br>
        Last Name:<input type="text"  name="last_name"><br>
        Email Address:<input type="mail"  name="email"><br>
        Location:<input type="text"  name="location"><br>
        Phone Number:<input type="text"  name="phone"><br>
        Password:<input type="password" name="password"><br>
        <input type="submit" name="submit" value="Create Account"><br>
    </form> 

    <form action="search_users.php" method="POST">
              <input class = "search-bar" type="text" name="search" placeholder="Search organizations &#128269">
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
        <?php foreach ($students as $student) : ?>
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


