<?php  
 session_start();  
 $host = "localhost";  
 $username = "group20";
 $username_readOnly = "group20read_only";  
 $password = "J4XEy7Gr";  
 $database = "group20";  
 $message = "";  
 try  
 {  
      $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = '<label>All fields are required</label>';
           }  
           else  
           {
               if($_POST["username"] === $username && $_POST["password"] === $password)
               {
                    $_SESSION["username"] = $_POST["username"];
                    header("location:Maintenance.php");
               }
               elseif($_POST["username"] === $username_readOnly && $_POST["password"] === $password)
               {
                    $_SESSION["username"] = $_POST["username"];
                    header("location:Maintenance_readOnly.php");
               }
               else
               {
                   $message = '<label>Wrong Data</label>';
               }
               echo '<br /><br /><a href="Maintenance_logout.php">Logout</a>'; 
                
                // $query = "SELECT * FROM users WHERE username = :username AND password = :password";  
                // $statement = $connect->prepare($query);  
                // $statement->execute(  
                //      array(  
                //           'username'=>$_POST["username"],  
                //           'password'=>$_POST["password"]  
                //      )  
                // );  
                // $count = $statement->rowCount();  
                // if($count > 0)  
                // {  
                //      $_SESSION["username"] = $_POST["username"];  
                //      header("location:Maintenance.php");  
                // }  
                // else  
                // {  
                //     $message = '<label>Wrong Data</label>';  
                // }  
                // echo '<br /><br /><a href="Maintenance_logout.php">Logout</a>'; 
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Page Login</title>
    <link rel="stylesheet" type="text/css" href="../../impct.css" />
</head>
<style>
    body{
        background-color: #1893f8;
    }
</style>

<body>  

    <h1>Maintenance Page Login</h1> 
    <h4><a href="../../index.html">Home Page</a></h4>
    <!--Horizontal row-->
    <hr>
    <!---<h1>All Users</h1>--->

    <br />  
    <div class="container" style="width:500px;">  
        <?php  
            if(isset($message)){  

                echo '<label class="text-danger">'.$message.'</label>';  
            }  
        ?>  
        <form method="post">  

            Username: <input type="text"  name="username" class="form-control" placeholder="Enter admin username"><br>
            Password:<input type="password" name="password" class="form-control" placeholder="Enter admin password"><br>
            <input type="submit" name="login" class="btn btn-info" value="Get Access" />  

        </form>  
    </div>  
    <br />  

</body> 
</html>