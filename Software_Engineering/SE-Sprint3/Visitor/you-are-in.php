<?php
include("../dbconnect.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="../css/registration-login.css">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registration-login.css">
	<title>Corona Archive</title>
</head>

<body>
    <h3 class="title">You're In.</h3>
    <?php
   
    $query1 = "SELECT * FROM Visitor WHERE email='" . $_SESSION['email'] . "' ";
    $stm1 = $db->prepare($query1);
    $success1 = $stm1->execute();
    $returned_values1 = $stm1->fetch(PDO::FETCH_ASSOC);
    // print_r($returned_values1['id']);

    // getting qrcode parameter from url to look place details 
    $query2 = "SELECT * FROM Place WHERE QR_Code='" . $_GET['qrcodetext'] . "' ";
    $stm2 = $db->prepare($query2);
    $success2 = $stm2->execute();
    $returned_values2 = $stm2->fetch(PDO::FETCH_ASSOC);
    // print_r($returned_values2['id']);

    $query = "INSERT INTO VisitorToPlaces(citizen_id, place_id, entry_date, entry_time, exit_date,exit_time)
    VALUES (:citizen_id, :place_id, :entry_date, :entry_time, :exit_date, :exit_time)";

    $stm = $db->prepare($query);

    $stm->bindValue(":citizen_id", $returned_values1['id']);
    $stm->bindValue(":place_id", $returned_values2['id']);
    $stm->bindValue(":entry_date", date("Y/m/d"));
    $stm->bindValue(":entry_time",  date("h:i:s"));
    $stm->bindValue(":exit_date", NULL);
    $stm->bindValue(":exit_time", NULL);

    $successInsertVisotrdetails = $stm->execute();
    $stm->closeCursor();

    if ($successInsertVisotrdetails) {
        echo("Your data has been successfully saved as a visitor of this place.<br>");
    }

    ?>
</body>

</html>