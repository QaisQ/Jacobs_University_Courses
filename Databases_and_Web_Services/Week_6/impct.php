<?php

	$dbServername = "localhost";

	//Users
	$username = $_POST['username'];
	$name = $_POST['name'];
	$location = $_POST['location'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$phone_number = $_POST['phone_number'];

	//Partner Organizations
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$phone_number = $_POST['phone_number'];
	$legal_certification = $_POST['legal_certification'];
	$location = $_POST['location'];

	//Volunteering Opportunity
    $name = $_POST['name'];
    $email = $_POST['email'];
    $organization_id = $_POST['organization_id'];
    $category_id = $_POST['category_id'];
	$category_id = $_POST['category_id'];
    $location = $_POST['location'];
    $duration = $_POST['duration'];

	//Fundraisers
	$name = $_POST['name'];
    $email = $_POST['email'];
    $organization_id = $_POST['organization_id'];
    $login_key = $_POST['login_key'];
	$category_id = $_POST['category_id'];
	$contact_number = $_POST['contact_number']; 

	//Bank Details Users
	$user_id = $_POST['user_id'];
    $bank_name = $_POST['bank_name'];
    $BIC = $_POST['BIC'];
    $IBAN = $_POST['IBAN'];
    $payment_method = $_POST['payment_method'];

	//Bank Details Partners
	$organization_id = $_POST['organization_id'];
    $bank_name = $_POST['bank_name'];
    $BIC = $_POST['BIC'];
    $IBAN = $_POST['IBAN'];
    $payment_method = $_POST['payment_method'];

	//Feed
	$author_id = $_POST['author_id'];
    $content = $_POST['content'];
    $caption = $_POST['caption'];
    $emergency_status = $_POST['emergency_status'];
    $likes = $_POST['likes'];

	//Category
	$organization_id = $_POST['organization_id'];
    $category_name = $_POST['category_name'];


	// Database connection
	$conn = new mysqli('localhost','root','','test');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		
		$stmt1 = $conn->prepare("insert into users(username, name, location, email, password, phone_number) values(?, ?, ?, ?, ?, ?)");
		$stmt1->bind_param("sssssi", $username, $name, $location, $email, $password, $phone_number);
		$execval = $stmt1->execute();

		$stmt2 = $conn->prepare("insert into partner_organization(name, email, password, phone_number, legal_certification, location) values(?, ?, ?, ?, ?, ?)");
		$stmt2->bind_param("sssiss", $name, $email, $password, $phone_number, $legal_certification, $location);
		$execval = $stmt2->execute();

		$stmt3 = $conn->prepare("insert into volunteering_opportunities(name, email, organization_id, category_id, contact_number, location, duration) values(?, ?, ?, ?, ?, ?, ?)");
		$stmt3->bind_param("ssiiisi", $name, $email, $organization_id, $category_id, $contact_number, $location, $duration);
		$execval = $stmt3->execute();

		$stmt4 = $conn->prepare("insert into fundraisers(name, email, organization_id, login_key, category_id, contact_number) values(?, ?, ?, ?, ?, ?)");
		$stmt4->bind_param("ssiiii", $name, $email, $organization_id, $login_key, $category_id, $contact_number);
		$execval = $stmt4->execute();

		$stmt5 = $conn->prepare("insert into bank_details_users(user_id, bank_name, BIC, IBAN, payment_method) values(?, ?, ?, ?, ?)");
		$stmt5->bind_param("issss", $user_id, $bank_name, $BIC, $IBAN, $payment_method);
		$execval = $stmt5->execute();

		$stmt6 = $conn->prepare("insert into bank_details_partners(organization_id, bank_name, BIC, IBAN, payment_method) values(?, ?, ?, ?, ?)");
		$stmt6->bind_param("issss", $organization_id, $bank_name, $BIC, $IBAN, $payment_method);
		$execval = $stmt6->execute();

		$stmt7 = $conn->prepare("insert into feed(author_id, content, caption, emergency_status, likes) values(?, ?, ?, ?, ?)");
		$stmt7->bind_param("isssi", $author_id, $content, $caption, $emergency_status, $likes);
		//The second 's' above should be BLOB type
		$execval = $stmt7->execute();

		$stmt8 = $conn->prepare("insert into category(organization_id, category_name) values(?,?)");
		$stmt8->bind_param("is", $organization_id, $category_id);
		$execval = $stmt8->execute();

		echo $execval;
		echo "Registration successfully...";

		$stmt1->close();
		$stmt2->close();
		$stmt3->close();
		$stmt4->close();
		$stmt5->close();
		$stmt6->close();
		$stmt7->close();
		$stmt8->close();

		$conn->close();
	}
?>