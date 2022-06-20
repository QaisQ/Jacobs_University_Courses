<?php
    include_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="impct.css" />
</head>
<body>
    <h1>Search page</h1>

    <div class = "result-container">
    <?php
        if(isset($_POST['submit-search'])){
            # to make sure the data the user typed is safe
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            # TODO: change query 
            $sql = "SELECT * FROM article WHERE a_title LIKE '%$search%' OR a_text LIKE '%$search%' OR a_author LIKE '%$search%' OR a_date LIKE '%$search%'";
            $result = mysqli_query($conn, $sql);
            $queryResult = mysqli_num_rows($result);
            
            echo "There are".$queryResults."results found!";
            
            if($queryResult > 0){
                while($row = mysqli_fetch_assoc($result)){
                        # TODO: Change row values
                        echo "<div class = 'result-box'>
                            <h3>".$row['a_title']."</h3>
                            <p>".$row['a_text']."</p>
                            <p>".$row['a_date']."</p>
                            <p>".$row['a_author']."</p>
                            </div></a>";
                }
        }
        else{
        echo "There are no matching results";
        } 
        }
    ?>
    </div>
</body>  
</html>
