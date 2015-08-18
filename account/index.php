<?php

require_once("../models/config.php");

// Request method: GET
$ajax = checkRequestMode("get");

// User must be logged in
if (!isUserLoggedIn()){
  addAlert("danger", lang("LOGIN_REQUIRED"));
  apiReturnError($ajax, SITE_ROOT . "login.php");
}

setReferralPage(getAbsoluteDocumentPath(__FILE__));

// Automatically forward to the user's default home page
$home_page = SITE_ROOT . fetchUserHomePage($loggedInUser->user_id);

header( "Location: $home_page" ) ;
exit();

?>