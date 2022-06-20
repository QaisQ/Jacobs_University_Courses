<?php 

include("../dbconnect.php");

/// prepare variables for query
$input_email = $_POST['email'];
$input_password = $_POST['password'];
    
$query = "SELECT * FROM Hospital WHERE email='".$input_email."'AND password='".$input_password."'";
    
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 1){
	$result = mysqli_fetch_assoc($result);
    session_start();
    $_SESSION['user_id'] = $result["email"];
    header('Location: hospital-dashboard.php');
	die();
}
else{
	echo '
	<script>
		alert("Wrong Credentials! Please try again.");
		history.back();
	</script>';
	die();
}

?>