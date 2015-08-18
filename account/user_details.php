<?php


require_once("../models/config.php");

// Request method: GET
$ajax = checkRequestMode("get");

// Recommended admin-only access
if (!securePage(__FILE__)){
    apiReturnError($ajax);
}

$validator = new Validator();

// Look up specified user
$selected_user_id = $validator->requiredGetVar('id');

if (!is_numeric($selected_user_id) || !userIdExists($selected_user_id)){
	addAlert("danger", lang("ACCOUNT_INVALID_USER_ID"));
	apiReturnError($ajax, getReferralPage());
}

?>

<!DOCTYPE html>
<html lang="en">
  <?php
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "User Details"));
  ?>
<body>
  
<?php
echo "<script>selected_user_id = $selected_user_id;</script>";
?>
  
<!-- Begin page contents here -->
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
		<div class="row">
			<div id='widget-user-info' class="col-lg-6">          

			</div>
		</div>
  </div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

    <script src="../js/widget-users.js"></script>    
    <script>
		$(document).ready(function() {
			userDisplay('widget-user-info', selected_user_id);
			
			alertWidget('display-alerts');

    });

    </script>
  </body>
</html>

