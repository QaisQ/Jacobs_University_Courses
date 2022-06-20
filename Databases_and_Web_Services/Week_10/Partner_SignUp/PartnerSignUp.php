<?php
require("../dbconnect.php");
$query = 'SELECT * FROM partner_organizations ORDER BY organization_id';
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
    
    <h1>Partner Sign Up</h1>
    <a href="../MainHeader/AdminMaintenance/Maintenance.php">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>

    <h1>Partner NGOs</h1>

    
    <h2> Partner Organization Sign Up</h2>
    <form action="add_partner.php" method="post">
        Name:<input type="text"  name="name"><br>
        Email Address:<input type="text" name="email"><br>
        Password:<input type="password" name="password"><br>
        Phone Number:<input type="text" name="phone_number"><br>
        Legal_Certification: <input type="text" name="legal_certification"><br>
        Location:<input type="text"  name="location"><br>
        <input type="submit" name="submit"><br>
    </form> 

    <form action="search_partners.php" method="POST">
              <input class = "search-bar" type="text" name="search" placeholder="Search organizations &#128269">
              <button class = "search-button" type = "submit" name = "submit-search">Search</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Legal Certification</th>
            <th>Location</th>
        </tr>
        <?php foreach ($result as $organization) : ?>
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

    

    <a href="#">Top</a>
</body>
</html>