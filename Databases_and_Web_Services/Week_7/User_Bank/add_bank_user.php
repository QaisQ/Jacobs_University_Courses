<?php


$user_id = filter_input(INPUT_POST, 'user_id');
$bank_name = filter_input(INPUT_POST, 'bank_name');
$bic = filter_input(INPUT_POST, 'bic');
$iban =filter_input(INPUT_POST, 'iban');
$payment_method = filter_input(INPUT_POST, 'payment_method');

if($user_id == null || $bank_name == null || $bic == null ||
$iban == null || $payment_method == null){
    $err_msg = "All bank details not entered";
    include("../db_error.php");
}else{
    require_once('../dbconnect.php');
    $query = 'INSERT INTO bank_details_users(user_id, bank_name, BIC, IBAN, payment_method) VALUES(
        :user_id, :bank_name, :BIC, :IBAN, :payment_method)';
    $putin = $conn->prepare($query);
    $putin->bindValue(":user_id",$user_id);
    $putin->bindValue(":bank_name", $bank_name);
    $putin->bindValue(":BIC",$bic);
    $putin->bindValue(":IBAN",$iban);
    $putin->bindValue(":payment_method",$payment_method);

    $check_success = $putin->execute();
    $putin->closeCursor();

    if(!$check_success){
        $err_msg = "Error Inserting bank details Values";
        include ("../db_error.php");
    }

    
}
    require_once("../dbconnect.php");
    $query = 'SELECT * FROM bank_details_users ORDER BY bank_id';
    $stm = $conn->prepare($query);
    $check_success = $stm->execute();
    $accounts = $stm->fetchAll();
    $stm->closeCursor();
    if(!$check_success){
        $err_msg = "Showing Results Not Working";
        include('../db_error.php');
    }

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


    <h2>Bank Details Page for Users</h2>
    <form action="add_bank_user.php" method="post">
        User Id:<input type="number"  name="user_id"><br>
        Bank Name:<input type="text" name="bank_name"><br>
        BIC: <input type="number" name="bic"><br>
        IBAN:<input type="number"  name="iban"><br>
        Payment Method: <input type = "text" name = "payment_method"><br>
        <input type="submit" name="submit" value="Create Bank Account for User"><br>
        
    </form> 

    <form action="search_userBanks.php" method="POST">
              <input class = "search-bar" type="text" name="search" placeholder="Search">
              <button class = "search-button" type = "submit" name = "submit-search">Search</button>
    </form>

    <table border="1">
        <tr>
            <th>Bank_ID</th>
            <th>User ID</th>
            <th>Bank Name</th>
            <th>BIC</th>
            <th>IBAN</th>
            <th>payment_method</th>
        </tr>
        <?php foreach ($accounts as $bank_details_user) : ?>
            <tr>
                <td><?php echo $bank_details_user['bank_id'];?></td>
                <td><?php echo $bank_details_user['user_id'];?></td>
                <td><?php echo $bank_details_user['bank_name'];?></td>
                <td><?php echo $bank_details_user['BIC'];?></td>            
                <td><?php echo $bank_details_user['IBAN'];?></td>
                <td><?php echo $bank_details_user['payment_method'];?></td>
            </tr>
        <?php endforeach;?>
    </table>

    <a href="#">Top</a>
</body>
</html>