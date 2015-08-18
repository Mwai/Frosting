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
      echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => ""));
  ?>
<head>
<title>Google Map</title>
<link href="css/main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgn83lkm7KOm1XMw9tGX1PdLhcuXXrSRE&sensor=true"></script>
<script type="text/javascript">
$(document).ready(function() {

    var mapCenter = new google.maps.LatLng(-1.1994606,36.9271127); //Google map Coordinates
    var map;
    
    map_initialize(); // initialize google map
    
    //############### Google Map Initialize ##############
    function map_initialize()
    {
            var googleMapOptions = 
            { 
                center: mapCenter, // map center
                zoom: 17, //zoom level, 0 = earth view to higher value
                maxZoom: 18,
                minZoom: 13,
                zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL, //zoom control size
            styles:    [{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}]
            },
                scaleControl: true, // enable scale control
                mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
            };
        
               map = new google.maps.Map(document.getElementById("google_map"), googleMapOptions);            
            
            //Load Markers from the XML File, Check (map_process.php)
            $.get("map_process.php", function (data) {
                $(data).find("marker").each(function () {
                      var name         = $(this).attr('name');
                      var address     = '<p>'+ $(this).attr('address') +'</p>';
                      var address     = '<p>'+ $(this).attr('Average') +'</p>';
                      var type         = $(this).attr('type');
                      var point     = new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
                      create_marker(point, name, address, false, false, false, "http://localhost/frosting/icons/pin_blue.png");
                });
            });    
            
            //Right Click to Drop a New Marker
            google.maps.event.addListener(map, 'rightclick', function(event) {
                //Edit form to be displayed with new marker
                var EditForm = '<p><div class="marker-edit">'+
                '<form action="ajax-save.php" method="POST" name="SaveMarker" id="SaveMarker">'+
                '<label for="pName"><span>Place Name :</span><input type="text" name="pName" class="save-name" placeholder="Enter Title" maxlength="40" /></label>'+
                '<label for="pDesc"><span>Description :</span><textarea name="pDesc" class="save-desc" placeholder="Enter Address" maxlength="150"></textarea></label>'+
                '<label for="pType"><span>Type :</span> <select name="pType" class="save-type"><option value="Apartment">Apartment</option><option value="House">House</option>'+
                '<option value="Office Space">Office Space</option></select></label>'+
                '</form>'+
                '</div></p><button name="save-marker" class="save-marker">Save Marker Details</button>';

                //Drop a new Marker with our Edit Form
                create_marker(event.latLng, 'New Marker', EditForm, true, true, true, "http://localhost/frosting/icons/pin_green.png");
            });
                                        
    }
    
    //############### Create Marker Function ##############
    function create_marker(MapPos, MapTitle, MapDesc,  InfoOpenDefault, DragAble, Removable, iconPath)
    {                      
        
        //new marker
        var marker = new google.maps.Marker({
            position: MapPos,
            map: map,
            draggable:DragAble,
            animation: google.maps.Animation.DROP,
            title:"Hit me!!",
            icon: iconPath
        });
        
        //Content structure of info Window for the Markers
        var contentString = $('<div class="marker-info-win">'+
        '<div class="marker-inner-win"><span class="info-content">'+
        '<h1 class="marker-heading">'+MapTitle+'</h1>'+
        MapDesc+ 
        '</span><button name="remove-marker" class="remove-marker" title="Remove Marker">Remove Marker</button>'+
        '</div></div>');    

        
        //Create an infoWindow
        var infowindow = new google.maps.InfoWindow();
        //set the content of infoWindow
        infowindow.setContent(contentString[0]);

        //Find remove button in infoWindow
        var removeBtn     = contentString.find('button.remove-marker')[0];
        var saveBtn     = contentString.find('button.save-marker')[0];

        //add click listner to remove marker button
        google.maps.event.addDomListener(removeBtn, "click", function(event) {
            remove_marker(marker);
        });
        
        if(typeof saveBtn !== 'undefined') //continue only when save button is present
        {
            //add click listner to save marker button
            google.maps.event.addDomListener(saveBtn, "click", function(event) {
                var mReplace = contentString.find('span.info-content'); //html to be replaced after success
                var mName = contentString.find('input.save-name')[0].value; //name input field value
                var mDesc  = contentString.find('textarea.save-desc')[0].value; //description input field value
                var mType = contentString.find('select.save-type')[0].value; //type of marker
                
                if(mName =='' || mDesc =='')
                {
                    alert("Please enter Name and Description!");
                }else{
                  save_marker(marker, mName, mDesc, mType, mReplace); //call save marker function
                 }
            });
        }
        
        //add click listner to save marker button         
        google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker); // click on marker opens info window 
        });
          
        if(InfoOpenDefault) //whether info window should be open by default
        {
          infowindow.open(map,marker);
        }
    }
    
    //############### Remove Marker Function ##############
    function remove_marker(Marker)
    {
        
        /* determine whether marker is draggable 
        new markers are draggable and saved markers are fixed */
        if(Marker.getDraggable()) 
        {
            Marker.setMap(null); //just remove new marker
        }
        else
        {
            //Remove saved marker from DB and map using jQuery Ajax
            var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
            var myData = {del : 'true', latlang : mLatLang}; //post variables
            $.ajax({
              type: "POST",
              url: "map_process.php",
              data: myData,
              success:function(data){
                    Marker.setMap(null); 
                    alert(data);
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError); //throw any errors
                }
            });
        }

    }
    
    //############### Save Marker Function ##############
    function save_marker(Marker, mName, mAddress, mType, replaceWin)
    {
        //Save new marker using jQuery Ajax
        var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
        var myData = {name : mName, address : mAddress, latlang : mLatLang, type : mType }; //post variables
        console.log(replaceWin);        
        $.ajax({
          type: "POST",
          url: "map_process.php",
          data: myData,
          success:function(data){
                replaceWin.html(data); //replace info window with new html
                Marker.setDraggable(false); //set marker to fixed
                Marker.setIcon('http://localhost/frosting/icons/pin_blue.png'); //replace icon
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //throw any errors
            }
        });
    }

});
</script>
</head>
<body>             

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="../account/user_map.php">ApartRate</a>
    <span class='navbar-center navbar-brand'>Map</span>
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class='dropdown-menu'>< class='navitem-site-settings'><a href='../account/site_settings.php'><i class='fa fa-globe'></i> Site Configuration</a></li><li class='navitem-groups'><a href='../account/groups.php'><i class='fa fa-users'></i> Groups</a></li><li class='navitem-site-pages'><a href='../account/site_authorization.php'><i class='fa fa-key'></i> Authorization</a></li></ul></li></ul><ul class="nav navbar-master navbar-nav navbar-right"><li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i> <?php echo "$loggedInUser->username";?> <b class='caret'></b></a>
                <ul class='dropdown-menu'><li class='navitem-'><a href='../account/account_settings.php'><i class='fa fa-gear'></i> Account Settings</a></li><li class='navitem-'><a href='../account/logout.php'><i class='fa fa-power-off'></i> Log Out</a></li></ul></li>
    </ul></div>
</nav>

<div id="google_map"></div>
<?php echo renderTemplate("footer.html"); ?>

</body>
</html>