<!-- Form for ajax post request, updates infection status in database -->
<?php
/// Include metadata file and file for db connection
include("../dbconnect.php");
include("../base.php");

/// Get Infection status from dropdown selection and visitor id for update query
$postData = $_POST['postData']; 
$status = $postData[1];
$id = intval($postData[0]);

/// Define, prepare and execute query to see list of visitors 
$query="UPDATE Visitor SET `infection_status`='$status' WHERE `id`=$id";
$stm = $db->prepare($query);
$success = $stm->execute();

/// Handle exceptions
if(!$success){
    print_r($stm->errorInfo()[2]);
    include("../dberror.php");
}
?>