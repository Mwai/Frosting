<?php


require_once("models/config.php");

setReferralPage(getAbsoluteDocumentPath(__FILE__));

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) {
	addAlert("danger", "I'm sorry, you cannot request an activation email while logged in.  Please log out first.");
	apiReturnError(false, SITE_ROOT);
}

?>

<!DOCTYPE html>
<html lang="en">
  <?php
	echo renderTemplate("head.html", array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Resend Activation"));
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
        <h3 class="text-muted">UserFrosting</h3>
      </div>
      <div class="jumbotron">
        <h1>Account Activation</h1>
        <p class="lead">Please enter your username and the email address you used to sign up, and an activation email will be resent.</p> 
		<form class='form-horizontal' role='form' name='resend' action='api/user_resend_activation.php' method='post'>
		  <div class="row">
			<div id='display-alerts' class="col-lg-12">
  
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="text" class="form-control" placeholder="Username" name = 'username' value=''>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-offset-3 col-md-6">
			  <input type="email" class="form-control" placeholder="Email" name='email'>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-12">
			  <button type="submit" class="btn btn-success submit" value='Resend'>Resend Activation</button>
			</div>
		  </div>
		</form>
      </div>	
      <?php echo renderTemplate("footer.html"); ?>

    </div> <!-- /container -->

	<script>
        $(document).ready(function() {          
			// Load the header
			$(".navbar").load("header-loggedout.php", function() {
				$(".navbar .navitem-login").addClass('active');
			});
		  	
			alertWidget('display-alerts');
			  
		  	$("form[name='resend']").submit(function(e){
				var form = $(this);
				var url = APIPATH + 'user_resend_activation.php';
				$.ajax({  
				  type: "POST",  
				  url: url,  
				  data: {
					username:	form.find('input[name="username"]').val(),
					email:		form.find('input[name="email"]').val(),
					ajaxMode:	"true"
				  }		  
				}).done(function(result) {
				  resultJSON = processJSONResult(result);
				  alertWidget('display-alerts');
				});
				// Prevent form from submitting twice
				e.preventDefault();
		    });
		});
	</script>
  </body>
</html>