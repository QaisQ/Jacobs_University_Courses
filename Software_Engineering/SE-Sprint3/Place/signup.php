<?php 

    /// Include file for db connection
    include("../dbconnect.php");

    /// Prepare variables for query
    $place_name =  $_POST['name'];
    $email = $_POST['email'];
    $address =  $_POST['address'];
    $password =  $_POST['password'];

    /// Define, prepare and execute query to compare data entered by place on login 
	$query = "INSERT INTO Place(name, email, address, password, QR_Code)
	VALUES ('$place_name', '$email', '$address', '$password', '$place_name')"; /// set unique place name as string to be converted to QR

    /// Handle exceptions
    if (mysqli_query($conn, $query)) {
		session_start();
		$_SESSION['user_id'] = $email;
		header('Location: login-success.php');
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