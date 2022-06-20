<?php
if (isset($_POST['submit-search'])) {

    require_once("../dbconnect.php");
    # to make sure the data the user typed is safe
    $search = filter_input(INPUT_POST, 'search');

    $query = "SELECT * FROM volunteering_opportunities WHERE volunteering_id LIKE '%$search%' OR event LIKE '%$search%' OR organization_name LIKE '%$search%' OR email LIKE '%$search%' 
            OR contact_number LIKE '%$search%' OR location LIKE '%$search%' OR duration LIKE '%$search%'";
    
    $stm = $conn->prepare($query);
    $stm->execute();
    $results = $stm->fetchAll();
    $stm->closeCursor();


    $queryResult = mysqli_num_rows($results);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="../impct.css" />
</head>

<body>
    <h1>Search page</h1>

    <div class="result-container">

        <table border="1">
            <tr>
                <th>Volunteering ID</th>
                <th>Event</th>
                <th>Host</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Location</th>
                <th>Duration</th>
            </tr>
            <?php foreach ($results as $result) : ?>
                <tr>
                    <td><?php echo $result['volunteering_id']?></td>
                    <td><?php echo $result['event']?></td>
                    <td><?php echo $result['organization_name']?></td>
                    <td><?php echo $result['email']?></td>
                    <td><?php echo $result['contact_number']?></td>
                    <td><?php echo $result['location']?></td>
                    <td><?php echo $result['duration']?></td>
                </tr>
            <?php endforeach ?>
        </table>

    </div>
</body>

</html>