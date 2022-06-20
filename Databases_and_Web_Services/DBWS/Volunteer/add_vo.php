<?php

$event = filter_input(INPUT_POST, 'event');
$organization_name = filter_input(INPUT_POST, 'host');
$email = filter_input(INPUT_POST, 'email');
$contact_number = filter_input(INPUT_POST, 'contact');
$location = filter_input(INPUT_POST, 'location');
$duration = filter_input(INPUT_POST, 'duration');

if($event == null || $location == null || $organization_name == null ||
$contact_number == null || $duration == null || $email == null){
    $err_msg = "All Volenteering values not entered";
    include("../db_error.php");
}else{
    require_once('../dbconnect.php');
    $query = 'INSERT INTO volunteering_opportunities(event, email, contact_number, location, duration, organization_name) VALUES(:event, :email, :contact_number, :location, :duration, :organization_name)';
    
    $try = $db->prepare($query);

    // $try->bindValue(':volunteering_id', null, PDO::PARAM_INT);
    $try->bindValue(':event', $event);
    $try->bindValue(':email', $email);
    $try->bindValue(':contact_number', $contact_number);
    $try->bindValue(':location', $location);
    $try->bindValue(':duration', $duration);
    $try->bindValue(':organization_name', $organization_name);

    $check_success = $try->execute();

    $try->closeCursor();

    if(!$check_success){
        $err_msg = "Error Inserting NGO Values";
        include ("../db_error.php");
    }
}
require_once('../dbconnect.php');
$query = 'SELECT * FROM volunteering_opportunities';
$stm = $db->prepare($query);
$stm->execute();
$opportunities = $stm->fetchAll();
$stm->closeCursor();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../impct.css" />
    <title>Volunteering opportunity creation</title>
</head>
<style>
    body{
        background-color: #1893f8;
    }
</style>
<body>
    <h1>Volunteer Here</h1>
    <a href="../Maintenance.html">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>
<h1>Open Volunteering Opportunities</h1>
<table>
    <tr>
        <th>Volunteering ID</th>
        <th>Event</th>
        <th>Host</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Location</th>
        <th>Duration</th>
    </tr>
    <?php foreach ($opportunities as $opportunity) : ?>
        <tr>
            <td><?php echo $opportunity['volunteering_id']; ?></td>
            <td><?php echo $opportunity['event']; ?></td>
            <td><?php echo $opportunity['organization_name']; ?></td>
            <td><?php echo $opportunity['email']; ?></td>
            <td><?php echo $opportunity['contact_number']; ?></td>
            <td><?php echo $opportunity['location']; ?></td>
            <td><?php echo $opportunity['duration']; ?></td>
        </tr>
        <?php endforeach;?>
</table>

<h2>Create Open Volunteer Calls</h2>

<form>
<form action="add_vo.php" method="post">
        Event:<input type="text"  name="event"><br>
        Host:<input type="text" name="host"><br>
        Email:<input type="text"  name="email"><br>
        Contact (Phone):<input type="text" name="contact"><br>
        Location:<input type="text"  name="location"><br>
        Duration: <input type="text" name="duration"><br>
        <input type="submit" name="submit" value="Add Volunteering Opportunity"><br>
    </table>
</form>

<a href="#">Top</a>


    
</body>
</html>