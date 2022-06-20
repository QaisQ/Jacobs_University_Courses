<?php
  /// Include metadata file and file for db connection
  include("../dbconnect.php");
  include("../base.php");?>
  <!-- Include Jquery scripts and stylesheet -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
  <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet"/>

  <h1>Visitor Details</h1>
  <p>As a Hospital Agent you have the funcionality of updating the Infection Status of a patient.</p><br/>
  <div class="container">
    <table id="visitorList" class="display" width="80%" >
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Address</th>
          <th>Phone Number</th>
          <th>Infection Status</th>
          <th>Select</th>
        </tr>
      </thead>
    </table>
  </div>
  <script> 


<?php 
    /// Define, prepare and execute query to see list of visitors 
    $query = "SELECT id, first_name, last_name, email, address, phone_number, infection_status FROM Visitor";
    $stm = $db->prepare($query);
    $success = $stm->execute();
    $returned_values = $stm->fetchAll();

    /// Handle Exceptions
    if(!$success){
        print_r($stm->errorInfo()[2]);
        include("../dberror.php");
    }

    /// print received values
    // array_map(function ($var) {
    //     echo $var['first_name'], " ", $var['last_name'], " ",$var['amount'], " ", $var['email'], " ", $var['address'], " ", $var['phone_number'], " ", $var['infection_status'];
    // }, $returned_values);    
?>


/*
 * Render the document using built in jquery .ready() function
*/
/// Code adapted from source https://stackoverflow.com/questions/51713239/update-cell-with-drop-down-selected-value
$(document).ready(function() {

    /// Declare array fetched from query to Visitor table
    var array = <?php echo json_encode($returned_values); ?>;

    /*
     * Get three options from the dropdown
     * and render the choice.
    */
    function getSelectOptions(value) {
      var select = $("<select><option value='0'>Select</option><option value='1'>Positive</option><option value='2'>Negative</option>");
      if (value) {
        select.val(value).find(':selected').attr('selected', true);
      }
      return select.html()
    }

    /*
     * Define jquery datatable to be used.
     * Useful link for datatables: https://datatables.net/
    */
    var table = $('#visitorList').DataTable({
        data: array,
        "columnDefs": [{
            "targets": -1,
            "render": function(data, type, row, meta) {
            return "<select class='mySelect' data-col='" + meta.col + "'>" +
                  getSelectOptions(data) + "</select>";
            }
        }],
    });

    /*
     * Updates the Infected column by using the select column
     * Uses {@link [./status.php] [To post data to the Visitor table]}
    */
    $('#visitorList').on('change', 'select.mySelect', function() {

        /// define variables to traverse table and prepare post request variables
        var colIndex = +$(this).data('col')
        var row = $(this).closest('tr')[0];
        var data = table.row(row).data();
        var id = $(this).prev('id')

        data[colIndex] = this.value
        data[colIndex-1] = $(this).find(':selected').text();
        table.row(row).data(data).draw();

        var postData = [data[0], data[6]];
        // console.log(postData[0]);
        // console.log(postData[1]);

        /// Post request to update infection status in database.
        /// 
        /// For more information regarding ajax visit: https://api.jquery.com/jquery.ajax/
        $.ajax({
            url: "./status.php",
            type: "post",
            data: {postData:postData},
            success: function(response) {
                alert("Infection status set successfully!");
            } 
        });
    })
});

</script>