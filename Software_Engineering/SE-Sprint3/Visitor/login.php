<?php 

include("../dbconnect.php");

/// prepare variables for query
$input_id = $_POST['citizen_id'];
$input_password = $_POST['password'];
    
$query = "SELECT * FROM Visitor WHERE citizen_id='".$input_id."'AND password='".$input_password."'";
    
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 1){
	$result = mysqli_fetch_assoc($result);
    session_start();
    $_SESSION['user_id'] = $result["citizen_id"];
    header('Location: login-success.html');
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