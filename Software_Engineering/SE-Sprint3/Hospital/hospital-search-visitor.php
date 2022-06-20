<!-- Deprecated file, was replaced by hospital-dashboard.php -->

<?php
/// Include metadata file and file for db connection
include("../dbconnect.php");
include("../base.php");
?>
<!-- Include style sheet -->
<link rel="stylesheet" href="../css/Agent-sees-details.css"> 
<button onclick="history.go(-1);">Back </button>

<?php

/// Get a list of visitors given an approximate search
if($_POST['Submit']='searchedValue'){

    /// Define, prepare and execute query to see list of visitors 
    $searched_value = $_POST['searched_value'];
    $query = "SELECT * FROM Visitor WHERE `first_name` LIKE '%$searched_value%' OR
       `last_name`='%$searched_value%' OR `email`='%$searched_value%'";
    $stm = $db->prepare($query);
    $success = $stm->execute();
    $returned_values = $stm->fetchAll();
    
    /// Handle exceptions
    if(!$success){
        print_r($stm->errorInfo()[2]);
        include("../dberror.php");
    }

    /// Handle response
    if(!empty($returned_values)){

        /// show table with searched visitor results
        echo "<h3>Searched Visitor</h3>";
        echo "<table>"; 
        echo "<tr><td>id</td><td>first_name</td><td>last_name</td><td>email</td>
        <td>address</td><td>phone_number</td><td>infection_status</td></tr>";
        foreach ($returned_values as $row) {
            echo "<tr><td>". $row['id']  . "</td><td>" .$row['first_name']."</td>
            <td>" .$row['last_name']."</td><td>" .$row['email']."</td>
            <td>" .$row['address']."</td><td>" .$row['phone_number']."</td>
            <td>" .$row['infection_status']."</td></tr>";
          }
          echo "</table>"; 
    }
    else{

        /// handle exception
        echo"<h3>No visitors found with searched values</h3>";
    }
}
else{

    /// handle exception
    echo "<h3> Sorry, no data available</h3>";
}

?>

<script>
 $( "#autocomplete" ).autocomplete({
    source: [
        <?php
		include("../dbconnect.php");
        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
        $result = mysqli_query($conn, "SELECT DISTINCT");
        $first = true;
        ?>	
        <?php while ($array = mysqli_fetch_assoc($result)) { ?> 
        <?php if ($first == true)
        {
            echo ' "'.$array["first_name"].'"';
            $first = false;
        } else {
            echo ', "'.$array["first_name"].'"';
        }        
        ?>
        <?php}?> 
    ]
    <?php $conn->close(); ?>
});
	</script>