<?php


// Request method: GET
require_once('models/config.php');

if ($can_register){
	echo "
		<li class='navitem-home'><a href='index.php'>Home</a></li>
        <li class='navitem-login'><a href='login.php'>Login</a></li>
        <li class='navitem-register'><a href='register.php'>Register</a></li>";
} else {
	echo "
		<li class='navitem-home'><a href='index.php'>Home</a></li>
        <li class='navitem-login'><a href='login.php'>Login</a></li>";
}

?>
