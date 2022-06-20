<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="../impct.css" />
</head>
<style>
    body{
        background-color: #1893f8;
    }
</style>
<body>
    
    <h1>Category Assignment</h1>
    <a href="../MainHeader/AdminMaintenance/Maintenance.php">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>

    <h2> Choose your organization and specify the categories </h2>
    <form>
        <table>
            <tr>
                <td>
                    Organization name:
                </td>
    
                <td>
                    <input type=”text”  placeholder= "NGO name">
                </td>
            </tr>
            <tr>
                <td>
                    Organization's Email Address:
                </td>
    
                <td>
                    <input type=”mail”  placeholder= "NGOemail@gmail.com">
                </td>
            </tr>
            <tr>
                <td>
                    Password:
                </td>
    
                <td>
                    <input type="Password" placeholder = "Your Password" name="pwd" minlength="8">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="button" value="Submit">
                </td>
            </tr>
        </table>
    </form> 

    <a href="#">Top</a>
</body>
</html>