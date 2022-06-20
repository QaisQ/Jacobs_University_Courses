<?php
require("../dbconnect.php");
$query = 'SELECT * FROM bank_details_users ORDER BY bank_id';
$stm = $db->prepare($query);
$stm->execute();
$bank_details_users = $stm->fetchAll();
$stm->closeCursor();
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
    
    <h1>Bank Details</h1>
    <a href="../Maintenance.html">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>

    <h1>Bank Details Page for Users</h1>
    <table border="1">
        <tr>
            <th>Email Address</th>
            <th>Password</th>
            <th>Organization</th>
            <th>Bank Name</th>
            <th>BIC</th>
            <th>IBAN</th>
        </tr>
        <?php foreach ($bank_details_users as $bank_details_user) : ?>
            <tr>
                <td><?php echo $bank_details_user['bank_id'];?></td>
                <td><?php echo $bank_details_user['email'];?></td>
                <td><?php echo $bank_details_user['password'];?></td>
                <td><?php echo $bank_details_user['organization'];?></td>            
                <td><?php echo $bank_details_user['bank_name'];?></td>
                <td><?php echo $bank_details_user['BIC'];?></td>
                <td><?php echo $bank_details_user['IBAN'];?></td>
            </tr>
        <?php endforeach;?>
    </table>

    <h2>Bank Details Page for Users</h2>
    <form action="add_bank_user.php" method="post">
        Name:<input type="text"  name="email"><br>
        Email Address:<input type="password" name="password"><br>
        Password:<input type="text" name="organization"><br>
        Phone Number:<input type="text" name="bank_name"><br>
        Legal_Certification: <input type="number" name="BIC"><br>
        Location:<input type="number"  name="IBAN"><br>
        <input type="submit" name="submit"><br>
    </form> 

    <!-- <a href="#">Top</a> -->
</body>
</html>