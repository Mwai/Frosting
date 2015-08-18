
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
      echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Detailed Ratings"));
  ?>


  <?php

include('config.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "frosting";

$con = mysqli_connect($servername, $username, $password, $dbname);

$sql = mysqli_query($con, "SELECT name, Average,Noise,maintainance,security,management,neighbourhood,pet FROM markers ORDER BY Average DESC");

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
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="../account/User_map.php">ApartRate</a>
    <span class='navbar-center navbar-brand'>Map <a  onclick="mod()" href="#" class="btn btn-primary">Ratings</a></span>
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class='dropdown-menu'>< class='navitem-site-settings'><a href='../account/site_settings.php'><i class='fa fa-globe'></i> Site Configuration</a></li><li class='navitem-groups'><a href='../account/groups.php'><i class='fa fa-users'></i> Groups</a></li><li class='navitem-site-pages'><a href='../account/site_authorization.php'><i class='fa fa-key'></i> Authorization</a></li></ul></li></ul><ul class="nav navbar-master navbar-nav navbar-right"><li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i> <?php echo "$loggedInUser->username";?> <b class='caret'></b></a>
                <ul class='dropdown-menu'><li class='navitem-'><a href='../account/account_settings.php'><i class='fa fa-gear'></i> Account Settings</a></li><li class='navitem-'><a href='../account/logout.php'><i class='fa fa-power-off'></i> Log Out</a></li></ul></li>
    </ul></div>
</nav>
    <div class="row">
          <div id="widget-users" class="col-lg-12"> 
          <div class="panel panel-primary"> 
          <div class="panel-heading">     
            <h3 class="panel-title">
              <span class="glyphicon glyphicon-th" aria-hidden="true"></span> Detailed Ratings
              </h3>
            </div>
    <div id="rate" class="panel-body">
    <table id = "example" class ="display">
      <thead>
        <tr>
          <th>Name</th>
          <th>Noise</th>
           <th>Maintainance</th>
            <th>Security</th>
             <th>Management</th>
              <th>Neighbourhood</th>
               <th>Pet Friendliness</th>
                <th>Rating Index</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($row = mysqli_fetch_array($sql)) {
        ?>
        <tr>
          <td><?=$row['name']?></td>
          <td><?=$row['Noise']?></td>
          <td><?=$row['maintainance']?></td>
          <td><?=$row['security']?></td>
          <td><?=$row['management']?></td>
          <td><?=$row['neighbourhood']?></td>
          <td><?=$row['pet']?></td>
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
