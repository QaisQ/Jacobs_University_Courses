<?php
if (isset($_POST['submit-search'])) {

    require_once("../dbconnect_readOnly.php");
    # to make sure the data the user typed is safe
    $search = filter_input(INPUT_POST, 'search');

    $query = "SELECT * FROM users WHERE username LIKE '%$search%' OR location LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%'
            OR email LIKE '%$search%' OR phone_number LIKE '%$search%'";
    
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

        <form action="search_users.php" method="POST">
              <input class = "search-bar" type="text" name="search" placeholder="Search users &#128269">
              <button class = "search-button" type = "submit" name = "submit-search">Search</button>
        </form>

        <table border="1">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Location</th>
                <th>Phone Number</th>
            </tr>
            <?php foreach ($results as $result) : ?>
                <tr>
                    <td><?php echo $result['user_id'] ?></td>
                    <td><?php echo $result['username'] ?></td>
                    <td><?php echo $result['first_name'] ?></td>
                    <td><?php echo $result['last_name'] ?></td>
                    <td><?php echo $result['email'] ?></td>
                    <td><?php echo $result['location'] ?></td>
                    <td><?php echo $result['phone_number'] ?></td>
                </tr>
            <?php endforeach ?>
        </table>

    </div>
</body>

</html>