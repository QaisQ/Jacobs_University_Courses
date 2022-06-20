<?php
if (isset($_POST['submit-search'])) {

    require_once("../dbconnect.php");
    # to make sure the data the user typed is safe
    $search = filter_input(INPUT_POST, 'search');

    $query = "SELECT * FROM bank_details_users WHERE bank_id LIKE '%$search%' OR user_id LIKE '%$search%' OR bank_name LIKE '%$search%' OR BIC LIKE '%$search%' OR IBAN LIKE '%$search%'
            OR payment_method LIKE '%$search%'";
    
    $stm = $conn->prepare($query);
    $stm->execute();
    $results = $stm->fetchAll();
    $stm->closeCursor();


    $queryResult = mysqli_num_rows($results);

    // if($queryResults > 0){
    //     echo "There are " . $queryResults . " results found!";
    // }
    // else{
    //     echo "No matches found!";
    // }


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
                <th>Bank_ID</th>
                <th>User ID</th>
                <th>Bank Name</th>
                <th>BIC</th>
                <th>IBAN</th>
                <th>payment_method</th>
            </tr>
            <?php foreach ($results as $result) : ?>
            <tr>
                <td><?php echo $result['bank_id'];?></td>
                <td><?php echo $result['user_id'];?></td>
                <td><?php echo $result['bank_name'];?></td>
                <td><?php echo $result['BIC'];?></td>            
                <td><?php echo $result['IBAN'];?></td>
                <td><?php echo $result['payment_method'];?></td>
            </tr>
            <?php endforeach;?>
        </table>

    </div>
</body>

</html>