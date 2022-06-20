<?php 

    /// Include file for db connection
	include("../dbconnect.php");

	/// prepare variables for query
	$citizen_id = $_POST['citizen_id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_number = $_POST['phone_number'];
	$address = $_POST['address'];
	$password = $_POST['password'];

	/// Make sure that either email or number is provided
	if(empty($email) && empty($phone_number)) {
		echo '
		<script>
			alert("Please provide at least one type of contact (email / phone number)");
			history.back();
		</script>';
		die();
	}

	/// Define, prepare and execute query to compare data entered by visitor on login 
	$query = "INSERT INTO Visitor(citizen_id, first_name, last_name, email, address, phone_number, password)
	VALUES ('$citizen_id', '$first_name', '$last_name', '$email', '$address', '$phone_number', '$password')";
	
	/// Handle exceptions
	if (mysqli_query($conn, $query)) {
		session_start();
		$_SESSION['user_id'] = $citizen_id;
		header('Location: login-success.html');
		die();
	} else {
		?>
		<script>
			var error = "<?php echo 'Error: ' .  mysqli_error($conn);?>";
		</script>
		<?php	
		echo '
		<script>
			alert(error);
			history.back();
		</script>';
		die();
	}

	mysqli_close($conn);

?>