<?php

if(isset($_POST['search'])){

    $response = "<ul><li>No Results Found</li></ul>";
    require_once("../dbconnect.php");

    $q = filter_input(INPUT_POST, "q");
    $query = "SELECT * FROM volunteering_opportunities WHERE event LIKE '%$q%' OR organization_name LIKE '%$q%'";

    $stm = $conn->prepare($query);
    $stm->execute();
    $result_volunteers = $stm->fetchAll();

    if($result_volunteers > 0){
        $response = "<ul>";
        foreach ($result_volunteers as $result){
            $response .= "<li>".$result['event']." ".$result['organization_name']."</li>";
        }
        $reponse .= "</ul>";
    }
    $stm->closeCursor();

    //return to reponse 
    exit($response);
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSS for search box and responses -->
        <style type="text/css">
            ul{
                float:left;
                list-style:none;
                padding: 0px;
                border: 1px solid black;
                margin-top: 0px;
            }
            input, ul{
                width: 250px;
            }

            li:hover{
                background-color: blue;
            }
        </style>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../impct.css"/>
        
    </head>
    <body style="color: white;font-weight:700">
            <!-- search box -->
            <input type="search" placeholder="SEARCH VOLUNTEERS HERE" id="search_box">
            <div id="response"></div>


            <!-- including Jquery  -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
             crossorigin="anonymous"></script>

             <script>
                //  Take entry from searchbox and send to php using ajax
                 $(document).ready(function(){
                    $("#search_box").keyup(function(){
                        var query = $("#search_box").val();
                        if(query.length > 0){
                            $.ajax(
                                {
                                    url:'search_volunteers.php',
                                    method: "POST", 
                                    data: {
                                        search: 1,
                                        q: query
                                    },
                                    success: function(data){
                                        $("#response").html(data);
                                    },
                                    dataType: 'text'
                                }
                            )
                        }
                        
                    });

                    //update searchbox and auto-complete section when you click a suggestion
                    $(document).on('click', "li", function(){
                        var cur = $(this).text();
                        $("#search_box").val(cur);
                        $("#response").html("");
                    });
                 });
             </script>

    </body>
</html>