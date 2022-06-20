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
    
    <h1>Event Creation</h1>
    <a href="../MainHeader/AdminMaintenance/Maintenance.php">Maintenance Page</a>

    <!--Horizontal row-->
    <hr>

    <h2> Event Creation Page </h2>
    <form>
        <table>
            <tr>
                <td>
                    Email Address:
                </td>
    
                <td>
                    <input type="email"  placeholder= "Your Email" name=””>
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
                    Organization:
                </td>
    
                <td>
                    <input type="text"  placeholder= "Your Organization" name=””>
                </td>
            </tr>

            <tr>
                <td>
                    Name of the Event:
                </td>
    
                <td>
                    <input type="text"  placeholder= "Your event name" name=””>
                </td>
            </tr>

            <tr>
                <td>
                    Organization:
                </td>
    
                <td>
                    <input type="text"  placeholder= "Your Organization" name=””>
                </td>
            </tr>


            <tr>
                <td>Category: </td>
                <td>
                    <!-- <label for="Category">Choose a Chategory:</label> -->
                    <select name="categories">
                        <option value="Humanitarian">Humanitarian</option>
                        <option value="Education">Education</option>
                        <option value="Animal Welfare">Animal Welfare</option>
                        <option value="Children">Children</option>
                    </select>
                </td>

            <tr>
                <td>
                    Contact Number:
                </td>
    
                <td>
                    <input type="number"  placeholder= "Your Organization" name=””>
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