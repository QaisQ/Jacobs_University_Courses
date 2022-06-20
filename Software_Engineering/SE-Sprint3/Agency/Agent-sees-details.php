<?php
/// Include metadata file and file for db connection
include("../dbconnect.php");
include("../base.php");?>
<!-- Include style sheet -->
<link rel="stylesheet" href="../css/Agent-sees-details.css">

<body>
    <?php
    /// Get a list of visitors
    if ($_GET['see'] == 'visitors') {

        /// Define, prepare and execute query to see list of visitors
        $query = "SELECT id, first_name, last_name, email, address, phone_number, infection_status FROM Visitor";
        $stm = $db->prepare($query);
        $success = $stm->execute();
        $returned_values = $stm->fetchAll();

        /// Handle exceptions
        if (!$success) {
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
                echo "<tr><td>" . $row['id']  . "</td><td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td><td>" . $row['email'] . "</td>
                <td>" . $row['address'] . "</td><td>" . $row['phone_number'] . "</td>
                <td>" . $row['infection_status'] . "</td></tr>";
            }
            echo "</table>";
        } else {

            /// if visitor table empty handle exception
            echo "<h3>No visitors found.</h3>";
        }
    }

    /// Get a list of places
    elseif ($_GET['see'] == 'placeowners') {

        /// Define, prepare and execute query to see list of Places
        $query = "SELECT id, name, email FROM Place";
        $stm = $db->prepare($query);
        $success = $stm->execute();
        $returned_values = $stm->fetchAll();

        /// Handle exceptions
        if (!$success) {
            print_r($stm->errorInfo()[2]);
            include("../dberror.php");
        }

        /// Handle response
        if (!empty($returned_values)) {

            /// Show list of places and place owners
            echo "<h3>Details of Places and Place Owners</h3>";
            echo "<table>";
            echo "<tr><td>id</td><td>Place name</td><td>Owner email</td></tr>";
            foreach ($returned_values as $row) {
                echo "<tr><td>" . $row['id']  . "</td><td>" . $row['name'] . "</td>
                <td>" . $row['email'] . "</td></tr>";
            }
            echo "</table>";
        } else {

            /// if Place table empty handle exception
            echo "<h3>No places found.</h3>";
        }
    }

    elseif ($_GET['see'] == 'visitorentrydetails') {

        /// Define, prepare and execute query to see list of visitors
        $query = "SELECT citizen_id, place_id, entry_date, entry_time FROM VisitorToPlaces";
        $stm = $db->prepare($query);
        $success = $stm->execute();
        $returned_values = $stm->fetchAll();

        /// Handle Exceptions
        if (!$success) {
            print_r($stm->errorInfo()[2]);
            include("../dberror.php");
        }

        /// Handle response
        if (!empty($returned_values)) {

            /// Show list of places
            echo "<h3>Details of Visitors' entry to Places</h3>";
            echo "<table>";
            echo "<tr><td>Citizen Id</td><td>Place Id</td><td>Entry date</td><td>Entry time</td></tr>";
            foreach ($returned_values as $row) {
                echo "<tr><td>" . $row['citizen_id']  . "</td><td>" . $row['place_id'] . "</td>
                <td>" . $row['entry_date'] . "</td><td>" . $row['entry_time']  .  "</td></tr>";
            }
            echo "</table>";
        }
        else {

            /// if table is emtpy handle exception
            echo "<h3>No information found.</h3>";
        }
    }
    else {

        /// if get request is undefined handle exception
        echo "<h3> Sorry, no data available</h3>";
    }
    ?>
</body>