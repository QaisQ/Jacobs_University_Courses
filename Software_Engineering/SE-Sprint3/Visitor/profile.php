<?php
	include '../dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="../css/qr.css">
<link rel="stylesheet" href="../css/registration-login.css">
  
<head>
    <title>Corona Archive</title> 
</head>

<?php
session_start();
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
$statusMsg = $sessData['status']['msg'];
$statusMsgType = $sessData['status']['type'];
unset($_SESSION['sessData']['status']);
}
?>
<div class="container">
<?php
    if(!empty($sessData['userLoggedIn']) && !empty($sessData['userID'])){
        include 'user.php';
        $user = new User();
        $conditions['where'] = array(
            'id' => $sessData['userID'],
        );
        $conditions['return_type'] = 'single';
        $userData = $user->getRows($conditions);
?>
<h2>Welcome <?php echo $userData['first_name']; ?>!</h2>
<a href="userAccount.php?logoutSubmit=1" class="logout">Logout</a>
<div class="regisFrm">
    <p><b>Citizen ID: </b><?php echo $userData['citizen_id'].' '.$userData['last_name']; ?></p>
    <p><b>Name: </b><?php echo $userData['first_name'].' '.$userData['last_name']; ?></p>
	<p><b>Email: </b><?php echo $userData['email']; ?></p>
    <p><b>Phone: </b><?php echo $userData['phone_number']; ?></p>
    <p><b>Address: </b><?php echo $userData['address']; ?></p>
    <p><b>Infection Status: </b><?php echo $userData['infection_status']; ?></p>	

<li><a href=profile.php>Update Profile<a></li><br>

<?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
<div class="regisFrm">
    <form action="userAccount.php" method="post">
        <input type="email" name="email" placeholder="EMAIL" required="">
        <input type="password" name="password" placeholder="PASSWORD" required="">
        <div class="send-button">
            <input type="submit" name="loginSubmit" value="LOGIN">
        </div>
    </form>
</div>
<?php } ?>
</div>