<?php
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$organization = filter_input(INPUT_POST, 'organization');
$bank_name = filter_input(INPUT_POST, 'bank_name');
$BIC = filter_input(INPUT_POST, 'BIC');
$IBAN =filter_input(INPUT_POST, 'IBAN');

if($email == null || $password == null || $organization == null ||
$bank_name == null || $BIC == null || $IBAN == null){
    $err_msg = "All bank details not entered";
    include("../db_error.php");
}else{
    require_once('../dbconnect.php');
    $query = 'INSERT INTO bank_details_users(bank_id, email, password, organization, bank_name, BIC, IBAN) VALUES(
        :bank_id, :email, :password, :organization, :bank_name, :BIC, :IBAN)';
    $putin = $db->prepare($query);
    $putin->bindValue(":bank_id",null, PDO::PARAM_INT);
    $putin->bindValue(":email", $email);
    $putin->bindValue(":password",$password);
    $putin->bindValue(":organization",$organization);
    $putin->bindValue(":bank_name",$bank_name);
    $putin->bindValue(":BIC",$BIC);
    $putin->bindValue(":IBAN",$IBAN);

    $check_success = $putin->execute();
    $putin->closeCursor();

    if(!$check_success){
        $err_msg = "Error Inserting bank details Values";
        include ("../db_error.php");
    }

    
}
    require_once("../dbconnect.php");
    $query = 'SELECT * FROM bank_details_users ORDER BY bank_id';
    $stm = $db->prepare($query);
    $stm->execute();
    $organizations = $stm->fetchAll();
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
    
    <h1>Partner Sign Up</h1>
    <a href="../Maintenance.html">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>

    <h1>Partner NGOs</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Legal Certification</th>
            <th>Location</th>
        </tr>
        <?php foreach ($organizations as $organization) : ?>
            <tr>
                <td><?php echo $organization['organization_id'];?></td>
                <td><?php echo $organization['name'];?></td>
                <td><?php echo $organization['email'];?></td>
                <td><?php echo $organization['phone_number'];?></td>            
                <td><?php echo $organization['legal_certification'];?></td>
                <td><?php echo $organization['location'];?></td>
            </tr>
        <?php endforeach;?>
    </table>

    <h2> Partner Organization Sign Up</h2>
    <form action="add_partner.php" method="post">
        Name:<input type="text"  name="name"><br>
        Email Address:<input type="mail"  name="email"><br>
        Password:<input type="password" name="password"><br>
        Phone Number:<input type="text"  name="phone"><br>
        Legal_Certification: <input type="text" name="legal"><br>
        Location:<input type="text"  name="location"><br>
        <input type="submit" name="submit"><br>
    </form> 

    <!-- <a href="#">Top</a> -->
</body>
</html>