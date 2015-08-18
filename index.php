<?php

require_once("models/config.php");

// Public page

setReferralPage(getAbsoluteDocumentPath(__FILE__));

//Forward the user to their default page if he/she is already logged in
if(isUserLoggedIn()) {
	addAlert("warning", "You're already logged in!");
    header("Location: account");
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <?php
	echo renderTemplate("head.html", array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Welcome to ApartRate"));
  ?>
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<style>#googlemaps { 
         height: 100%; 
         width: 100%; 
         position:absolute; 
         top: 0; 
         left: 0; 
         z-index: -99; /* Set z-index to 0 as it will be on a layer below the contact form */
       }</style>
       <script>
        
         var map;    
         $(document).ready(function(){
       
            var mapOptions = {
               zoom: 17,
               center: new google.maps.LatLng(-1.1994606,36.9271127),
              disableDefaultUI: true,
              styles: [{"featureType":"all","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"on"},{"color":"#f3f4f4"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"weight":0.9},{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#83cead"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#7fc8ed"}]}],
              streetViewControl: true,
               mapTypeId: google.maps.MapTypeId.ROADMAP
               
               //mapTypeId: google.maps.MapTypeId.TERRAIN
           };
       
           map = new google.maps.Map($('#googlemaps')[0], mapOptions);
       
       
           // ----- Add the layer with the county information
        
         });//end document ready
        
        
       </script>
  <body>
      <div id="googlemaps">
      </div>
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills navbar pull-right">
        </ul>
        <h3 class="text-muted">ApartRate</h3>
      </div>
      <div class="jumbotron">
        <h1>Welcome to ApartRate!</h1>
        <p class="lead">Browse Nairobi's Apartment Ratings and Reviews.</p>
		<div class="row">
			<div class="col-sm-12">
			  <a href="login.php" class="btn btn-success" role="button" value='Login'>Login</a>
			</div>
        </div>
        <div class="jumbotron-links">
        </div>
      </div>	
      <?php echo renderTemplate("footer.html"); ?>

    </div> <!-- /container -->

  </body>
</html>

<script>
	$(document).ready(function() {
		alertWidget('display-alerts');
        // Load navigation bar
        $(".navbar").load("header-loggedout.php", function() {
            $(".navbar .navitem-home").addClass('active');
        });
        // Load jumbotron links
        $(".jumbotron-links").load("jumbotron_links.php");     
	});
</script>
