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
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Users"));
  ?>  

  <body>
    <script type="text/javascript">
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

    <div id="wrapper">

      <!-- Sidebar -->
        <?php
          echo renderMenu("users");
        ?>
        
      <div id="page-wrapper">
	  	<div class="row">
          <div id='display-alerts' class="col-lg-12">

          </div>
        </div>
        <div class="row" id="use">
          <div id='widget-users' class="col-lg-12">          

          </div>
  <input type="button" class= "btn btn-primary" onclick="printDiv('use')" style = "float:right" value="Print"/>

        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->
    
    <script src="../js/widget-users.js"></script>    
    <script>
        $(document).ready(function() {
                              
          alertWidget('display-alerts');
          
          userTable('widget-users');
        });
    </script>
  </body>
</html>
