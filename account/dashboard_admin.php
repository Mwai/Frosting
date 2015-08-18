<?php

// UserCake authentication
require_once("../models/config.php");

// Request method: GET
$ajax = checkRequestMode("get");

if (!securePage(__FILE__)){
    apiReturnError($ajax);
}


setReferralPage(getAbsoluteDocumentPath(__FILE__));

// Admin page
?>
<!DOCTYPE html>
<html lang="en">
  <?php
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Admin Dashboard"));
  ?>

  <body>    
    <div id="wrapper">

      <!-- Sidebar -->
        <?php
            echo renderMenu("dashboard-admin");
        ?>

      <div id="page-wrapper">
        
        
        <!-- /.row -->

        <!-- /.row -->


      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->
    
    <script src="../js/raphael/2.1.0/raphael-min.js"></script>
    <script src="../js/morris/morris-0.4.3.js"></script>
    <script src="../js/morris/chart-data-morris.js"></script>
    <script>
        $(document).ready(function() {          
          alertWidget('display-alerts');
          
          // Initialize the transactions tablesorter
          $('#transactions .table').tablesorter({
              debug: false
          });
          
        });      
    </script>
  </body>
</html>
