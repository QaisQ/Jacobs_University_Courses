<?php
include("../dbconnect.php");
?>

<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="../css/qr.css">

<head>
    <title>Corona Archive</title> 
</head>

<body>
	<h1 class="title">Place Has Successfully Entered Archive</h1>
    
    <?php
    /// Get QR code for place
    if ($_GET['qrcode']) {
        $qr = $_GET['qrcode'];
        echo ("<img src='http://chart.apis.google.com/chart?chs=150x150&amp;cht=qr&amp;chl=$qr&amp;choe=UTF-8' alt='my alt' />");
    } else {
        echo '<script>alert("No QR code text found!")</script>';
    }
    ?>
	
	<!--Script For the Downloading the QR code image:-->

	<script>
		var d = document.getElementById("downloadid");
		d.addEventListener("click", function(e) {
		var div = document.getElementById("data_id");
		var opt = {
		margin: [20, 20, 20, 20],
		filename: `filname.pdf`,
		image: {
		   type: 'jpg',
		   quality: 0.98
		},
		html2canvas: {
		  scale: 2,
		  useCORS: true
		},
		jsPDF: {
		unit: 'mm',
		format: 'letter',
		orientation: 'portrait'
		}
		};
		html2pdf().from(div).set(opt).save();
		});
	</script>
	
	<div> <a href="logout.php"><button class="logout-button">LOG OUT</button></a></div>
	
</body>