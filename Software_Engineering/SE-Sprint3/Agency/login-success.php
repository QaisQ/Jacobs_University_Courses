<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="../css/maintenance.css">

<head>
    <title>Corona Archive</title> 
</head>

<body>
    <h1>Agent Dashboard</h1>
    <br/>
    <button><a href="./Agent-sees-details.php?see=visitors"> See the list of Visitors</a></button>
    <button><a href="./Agent-sees-details.php?see=placeowners"> See the list of Places with Place owners</a></button>
    <button><a href="./Agent-sees-details.php?see=visitorentrydetails"> See Visitor entry to Place details</a></button><br/><br/>
    <form action="./agent-search-visitor.php?search=searchedValue" method="post"> 
        Search for visitors: <input type="text" name="searched_value"/>
        <input type="Submit" value="Submit"/> 
    </form>     
</body>

</html>