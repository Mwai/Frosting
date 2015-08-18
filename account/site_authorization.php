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
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Authorization Management"));
  ?>
  <body>

    <div id="wrapper">

      <!-- Sidebar -->
        <?php
          echo renderMenu("site-pages");
        ?>
        
      <div id="page-wrapper">
	  	<div class="row">
		  <div id='display-alerts' class="col-lg-12">
  
		  </div>
		</div>
		<div class="row">
		  <div id='display-alerts-instant' class="col-lg-12">
  
		  </div>
		</div>
		<div class="row">
		  <div class="col-lg-12">
			<h2>Page-level authorization</h2>
			<div id="widget-site-pages">
			
			</div>
		  </div>
		</div>  
	  </div>
	</div>
	
	</div>
	</div>
	<script src="../js/widget-pages.js"></script>
	<script src="../js/widget-permits.js"></script>	    
	<script>
        $(document).ready(function() {          

		  alertWidget('display-alerts');
		  
		  actionPermitsWidget('widget-group-access', {type: 'group'});
		  actionPermitsWidget('widget-user-access', {type: 'user'});
		  sitePagesWidget('widget-site-pages', { display_errors_id: 'display-alerts-instant'});
		});
	</script>
  </body>
</html>