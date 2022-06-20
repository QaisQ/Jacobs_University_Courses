<?php
if (isset($_POST['submit-search'])) {

    require_once("dbconnect_readOnly.php");
    # to make sure the data the user typed is safe
    $search = filter_input(INPUT_POST, 'search');

    $query = "SELECT * FROM partner_organizations WHERE organization_id LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%' OR legal_certification LIKE '%$search%'
            OR location LIKE '%$search%'";
    
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
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Legal Certification</th>
                <th>Location</th>
            </tr>
            <?php foreach ($results as $organization) : ?>
            <tr>
                <td><?php echo $organization['organization_id'];?></td>
                <td><?php echo $organization['name'];?></td>
                <td><?php echo $organization['email'];?></td>
                <td><?php echo $organization['phone_number'];?></td>            
                <td><?php echo $organization['legal_certification'];?></td>
                <td><?php echo $organization['location'];?></td>
            </tr>
            <?php endforeach;?>
        </table>

    </div>
</body>

</html>