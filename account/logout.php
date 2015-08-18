<?php


require_once("../models/config.php");

// Request method: GET
$ajax = checkRequestMode("get");

if (!securePage(__FILE__)){
    apiReturnError($ajax);
}

setReferralPage(getAbsoluteDocumentPath(__FILE__));

//Log the user out
if(isUserLoggedIn())
{
	$loggedInUser->userLogOut();
}

// Forward to index root page
header("Location: " . SITE_ROOT);
die();

?>

