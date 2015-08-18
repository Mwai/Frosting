
<!DOCTYPE html>
<html>
<?php


require_once("../models/config.php");

// Request method: GET
$ajax = checkRequestMode("get");

if (!securePage(__FILE__)){
    apiReturnError($ajax);
}

setReferralPage(getAbsoluteDocumentPath(__FILE__));


?>
<!DOCTYPE html>
<html lang="en">
  <?php
      echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Ratings"));
  ?>
  
  <?php

include('config.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "frosting";

$con = mysqli_connect($servername, $username, $password, $dbname);

$sql = mysqli_query($con, "SELECT name, address, type, Average FROM markers ORDER BY Average DESC");

?>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
  
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable(); } );
  function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;
        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";
        //Print Page
        window.print();
        //Restore orignal HTML
        document.body.innerHTML = oldPage;

    }
  </script>
</head>
<body>
     <?php
            echo renderMenu("dashboard-admin");
        ?>
  <div class="row">
          <div id="widget-users" class="col-lg-12"> 
          <div class="panel panel-primary" style="width:98%;float:right"> 
          <div class="panel-heading" style="width:85%;float:right">     
            <h3 class="panel-title">
              <span class="glyphicon glyphicon-th" aria-hidden="true"></span> Ratings Index
              </h3>
            </div>
    <div id="rate" class="panel-body" style="width:98%;float:right">
    <table id = "example" class ="display" style="width:85%;float:right">
      <thead>
        <tr>
          <th>Name</th>
          <th>Location</th>
          <th>Type</th>
          <th>Rating</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($row = mysqli_fetch_array($sql)) {
        ?>
        <tr>
          <td><?=$row['name']?></td>
          <td><?=$row['address']?></td>
          <td><?=$row['type']?></td>
          <td><?=$row['Average']?></td>
          <?php }?>
        </tr>
      </tbody>
      </table>
       <input type="button" class= "btn btn-primary" onclick="printDiv('rate')" style = "float:right" value="Print"/>
    </div>
  </div>
  </div>
</div>
</body>
</html>
