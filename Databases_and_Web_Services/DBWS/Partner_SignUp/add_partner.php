<?php
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$phone_number = filter_input(INPUT_POST, 'phone_number');
$legal_certification = filter_input(INPUT_POST, 'legal_certification');
$location =filter_input(INPUT_POST, 'location');

if($name == null || $location == null || $password == null ||
$phone_number == null || $legal_certification == null || $email == null){
    $err_msg = "All NGO Values not entered";
    include("../db_error.php");
}else{
    require_once('../dbconnect.php');
    $query = 'INSERT INTO partner_organizations(organization_id, name, email, password, phone_number, legal_certification, location) VALUES(
        :organization_id, :name, :email, :password, :phone_number, :legal_certification, :location)';
    $putin = $db->prepare($query);
    $putin->bindValue(":organization_id",null, PDO::PARAM_INT);
    $putin->bindValue(":name", $name);
    $putin->bindValue(":email",$email);
    $putin->bindValue(":password",$password);
    $putin->bindValue(":phone_number",$phone_number);
    $putin->bindValue(":legal_certification",$legal_certification);
    $putin->bindValue(":location",$location);

    $check_success = $putin->execute();
    $putin->closeCursor();

    if(!$check_success){
        $err_msg = "Error Inserting NGO Values";
        include ("../db_error.php");
    }

    
}
    require_once("../dbconnect.php");
    $query = 'SELECT * FROM partner_organizations ORDER BY organization_id';
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