<?php

require_once("../models/config.php");

set_error_handler('logAllErrors');

// Request method: POST
$ajax = checkRequestMode("post");

// User must be logged in
checkLoggedInUser($ajax);

// Create a new group with the specified name and home page id
// POST: group_name, home_page_id
$validator = new Validator();
$group_name = $validator->requiredPostVar('group_name');
$home_page_id = $validator->requiredPostVar('home_page_id');

// Add alerts for any failed input validation
foreach ($validator->errors as $error){
  addAlert("danger", $error);
}

if (count($validator->errors) > 0){
    apiReturnError($ajax, getReferralPage());
}

//Forms posted
if($group_name) {
	if (!createGroup($group_name, $home_page_id)){
        apiReturnError($ajax, getReferralPage());
	}
} else {
	addAlert("danger", lang("PERMISSION_CHAR_LIMIT", array(1, 50)));
    apiReturnError($ajax, getReferralPage());
}

restore_error_handler();

// Allows for functioning in either ajax mode or synchronous request mode
apiReturnSuccess($ajax, getReferralPage());
?>
