<?php
/// Include metadata file and file for db connection
include("../dbconnect.php");
?>

<!-- Include style sheet -->
<link rel="stylesheet" href="../css/Agent-sees-details.css"> 
<!-- /// include back button -->
<button onclick="history.go(-1);">Back </button>

<?php
/// static search for visitors, can search for any of the specified attributes
if($_POST['Submit']='searchedValue'){

    /// get Post variable
    $searched_value = $_POST['searched_value'];
    
    /// Define, prepare and execute query to compare data entered by agent on search 
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

        /// return table of search results if available
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
    }else{
        /// show exception if no visitors are found
        echo "<button onclick=history.go(-1);>Back </button>";
        echo"<h3>No visitors found with searched values</h3>";
    }
}else{
    /// handle exception if post is incorrect
    echo "<h3> Sorry, no data available</h3>";
}

?>