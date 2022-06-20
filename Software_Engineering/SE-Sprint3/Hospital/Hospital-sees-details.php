<!-- Deprecated file, was replaced by hospital-dashboard.php -->

<?php
/// Include metadata file and file for db connection
include("../dbconnect.php");
include("../base.php");?>
<!-- Include style sheet -->
<link rel="stylesheet" href="../css/Agent-sees-details.css">


<body>
    <?php
    /// Get a list of visitors
    if($_GET['see']== 'visitors'){

        /// Define, prepare and execute query to see list of visitors 
        $query = "SELECT id, first_name, last_name, email, address, phone_number, infection_status FROM Visitor";
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

            /// show table with visitor details
            echo "<h3>Details of Visitors</h3>";
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

            /// if visitor table empty handle exception
            echo"<h3>No visitors found.</h3>";
        }
    }
    else{

        /// if visitor table empty handle exception
        echo "<h3> Sorry, no data available</h3>";
    }
    
    ?>
</body>