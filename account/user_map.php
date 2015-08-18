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
  
  <?php
  include('config.php');
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "frosting";
  
  $con = mysqli_connect($servername, $username, $password, $dbname);
  
  $sql = mysqli_query($con, "SELECT name, Average FROM markers ORDER BY Average DESC");
  
  ?>
<head>
  <script src="//rawgit.com/saribe/eModal/master/dist/eModal.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
  
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>
<link href="css/main.css" rel="stylesheet" type="text/css">
<link rel="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/star-rating.css" media="all" type="text/css"/>
<script src="js/star-rating.js" type="text/javascript"></script>
<link href="stylesheet.css" rel="stylesheet" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">        </script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgn83lkm7KOm1XMw9tGX1PdLhcuXXrSRE&sensor=true"></script>

<script type="text/javascript">
function mod() {
  var url = "http://localhost/frosting/account/trial.php";
eModal.ajax(url, "Rating List");}

function my_own(title){
    // alert("can we get much higher");
    var sumRad = 0;

    var arrV1 = document.getElementsByName("Noiserating");
    var arrV2 = document.getElementsByName("Maintainancerating");
    var arrV3 = document.getElementsByName("Securityrating");
    var arrV4 = document.getElementsByName("Managementrating");
    var arrV5 = document.getElementsByName("Neighbourhoodrating");
    var arrV6 = document.getElementsByName("Petrating");

    for(var i=0; i<arrV1.length ; i++){
      if(arrV1[i].checked == true){
        sumRad += parseInt(arrV1[i].value);
      }
    }

    for(var i=0; i<arrV2.length ; i++){
      if(arrV2[i].checked == true){
        sumRad += parseInt(arrV2[i].value);
      }
    }

    for(var i=0; i<arrV3.length ; i++){
      if(arrV3[i].checked == true){
        sumRad += parseInt(arrV3[i].value);
      }
    }
    
    for(var i=0; i<arrV4.length ; i++){
      if(arrV4[i].checked == true){
        sumRad += parseInt(arrV3[i].value);
      }
    }
    
    for(var i=0; i<arrV5.length ; i++){
      if(arrV5[i].checked == true){
        sumRad += parseInt(arrV3[i].value);
      }
    }
    for(var i=0; i<arrV6.length ; i++){
      if(arrV6[i].checked == true){
        sumRad += parseInt(arrV3[i].value);
      }
    }

    document.getElementById('total').value = sumRad ;


     var mnoise = $('input[name=Noiserating]:checked', '#SaveRating').val(); //name input field value
     var mmaintainance = $('input[name=Maintainancerating]:checked', '#SaveRating').val(); //name input field value
     var msecurity = $('input[name=Securityrating]:checked', '#SaveRating').val(); //name input field value
     var mmanagement = $('input[name=Managementrating]:checked', '#SaveRating').val(); //name input field value
     var mneighbourhood = $('input[name=Neighbourhoodrating]:checked', '#SaveRating').val(); //name input field value
     var mpet = $('input[name=Petrating]:checked', '#SaveRating').val(); //name input field value
     var mtotal = $('input[name=total]', '#SaveRating').val(); //name input field value
     var mtitle = $('input[name=title]', '#SaveRating').val(); //name input field value


    console.log("we good");
     //save_rating(mnoise, mmaintenance, msecurity, mmanagement, mneighbourhood, mpet);
     //alert("the ratings: "+mnoise+" "+mpet);
     var myData = {title: mtitle, total: mtotal, noise : mnoise, maintainance : mmaintainance, security : msecurity, management : mmanagement, neighbourhood : mneighbourhood, pet : mpet }; //post variables
    
     $.ajax({
       type: "POST",
       url: "php_ratings.php",
       data: myData,
       success:function(data){
            alert("Rating has been posted"); 
         },
         error:function (xhr, ajaxOptions, thrownError){
             alert(thrownError); //throw any errors
         }
     });
     
}


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
                      var type         = $(this).attr('type');
                      var point     = new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
                      create_marker(point, name, address, false, false, false, "http://localhost/frosting/icons/pin_blue.png");
                });
            });   
          
            
            //Right Click to Drop a New Marker
            
                                        
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
        var contentString = $('<div class="marker-info-win">'+'<form name="SaveRating" id="SaveRating" method="post">'+
        '<div class="marker-inner-win"><span class="info-content">'+
        '<h1 class="marker-heading" name="marker-heading">'+MapTitle+'</h1>'+
        MapDesc+ 
        '<div class ="ratings">'+
        '<p> Noise <span class="starRating"><input  id="Noiserating5" type="radio" name="Noiserating" value="5"><label for="Noiserating5">5</label><input id="Noiserating4" type="radio" name="Noiserating" value="4"><label for="Noiserating4">4</label><input id="Noiserating3" type="radio" name="Noiserating" value="3"><label for="Noiserating3">3</label><input id="Noiserating2" type="radio" name="Noiserating" value="2"><label for="Noiserating2">2</label><input id="Noiserating1" type="radio" name="Noiserating" value="1"><label for="Noiserating1">1</label></span></p>'+
        '<p> Maintainance <span class="starRating"><input id="Maintainancerating5" type="radio" name="Maintainancerating" value="5"><label for="Maintainancerating5">5</label><input id="Maintainancerating4" type="radio" name="Maintainancerating" value="4"><label for="Maintainancerating4">4</label><input id="Maintainancerating3" type="radio" name="Maintainancerating" value="3"><label for="Maintainancerating3">3</label><input id="Maintainancerating2" type="radio" name="Maintainancerating" value="2"><label for="Maintainancerating2">2</label><input id="Maintainancerating1" type="radio" name="Maintainancerating" value="1"><label for="Maintainancerating1">1</label></span></p>'+
        '<p> Security <span class="starRating"><input id="Securityrating5" type="radio" name="Securityrating" value="5"><label for="Securityrating5">5</label><input id="Securityrating4" type="radio" name="Securityrating" value="4"><label for="Securityrating4">4</label><input id="Securityrating3" type="radio" name="Securityrating" value="3"><label for="Securityrating3">3</label><input id="Securityrating2" type="radio" name="Securityrating" value="2"><label for="Securityrating2">2</label><input id="Securityrating1" type="radio" name="Securityrating" value="1"><label for="Securityrating1">1</label></span></p>'+
        '<p> Management <span class="starRating"><input id="Managementrating5" type="radio" name="Managementrating" value="5"><label for="Managementrating5">5</label><input id="Managementrating4" type="radio" name="Managementrating" value="4"><label for="Managementrating4">4</label><input id="Managementrating3" type="radio" name="Managementrating" value="3"><label for="Managementrating3">3</label><input id="Managementrating2" type="radio" name="Managementrating" value="2"><label for="Managementrating2">2</label><input id="Managementrating1" type="radio" name="Managementrating" value="1"><label for="Managementrating1">1</label></span></p>'+
        '<p> Neighbourhood <span class="starRating"><input id="Neighbourhoodrating5" type="radio" name="Neighbourhoodrating" value="5"><label for="Neighbourhoodrating5">5</label><input id="Neighbourhoodrating4" type="radio" name="Neighbourhoodrating" value="4"><label for="Neighbourhoodrating4">4</label><input id="Neighbourhoodrating3" type="radio" name="Neighbourhoodrating" value="3"><label for="Neighbourhoodrating3">3</label><input id="Neighbourhoodrating2" type="radio" name="Neighbourhoodrating" value="2"><label for="Neighbourhoodrating2">2</label><input id="Neighbourhoodrating1" type="radio" name="Neighbourhoodrating" value="1"><label for="Neighbourhoodrating1">1</label></span></p>'+
        '<p> Pet Friendliness <span class="starRating"><input id="Petrating5" type="radio" name="Petrating" value="5"><label for="Petrating5">5</label><input id="Petrating4" type="radio" name="Petrating" value="4"><label for="Petrating4">4</label><input id="Petrating3" type="radio" name="Petrating" value="3"><label for="Petrating3">3</label><input id="Petrating2" type="radio" name="Petrating" value="2"><label for="Petrating2">2</label><input id="Petrating1" type="radio" name="Petrating" value="1"><label for="Petrating1">1</label></span></p>'+
        '<input type="hidden" id="total" name="total" />'+
        '<input type="hidden" id="title" name="title" value="'+MapTitle+'" />'+
        '</span><button onclick="my_own(\''+MapTitle+'\'); return false;" name="save-rating" class="btn btn-primary btn-xs"> Post Rating </button>'+
        '<div class="divider" style="width:5px;height:auto;display:inline-block;"/>'+
        '</span><a href ="http://localhost/frosting/account/details.php" class="btn btn-primary btn-xs" style="float: right;" >Detailed Ratings </a>'+
        '</div></div></div>');    

        
        //Create an infoWindow
        var infowindow = new google.maps.InfoWindow();
        //set the content of infoWindow
        infowindow.setContent(contentString[0]);
        //add click listner to remove marker button
      
        var saveBtn     = contentString.find('button.save-rating')[0];
        //add click listner to save marker button         
        google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker); // click on marker opens info window 
        });
          
        if(InfoOpenDefault) //whether info window should be open by default
        {
          infowindow.open(map,marker);
        }
        google.maps.event.addListener(marker, 'click', function() {
          infoWindow.close();
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
    <a class="navbar-brand" href="../account/User_map.php">ApartRate</a>
    <span class='navbar-center navbar-brand'>Map <a  onclick="mod()" href="#" class="btn btn-primary">Ratings</a></span>
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class='dropdown-menu'>< class='navitem-site-settings'><a href='../account/site_settings.php'><i class='fa fa-globe'></i> Site Configuration</a></li><li class='navitem-groups'><a href='../account/groups.php'><i class='fa fa-users'></i> Groups</a></li><li class='navitem-site-pages'><a href='../account/site_authorization.php'><i class='fa fa-key'></i> Authorization</a></li></ul></li></ul><ul class="nav navbar-master navbar-nav navbar-right"><li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i> <?php echo "$loggedInUser->username";?> <b class='caret'></b></a>
                <ul class='dropdown-menu'><li class='navitem-'><a href='../account/account_settings.php'><i class='fa fa-gear'></i> Account Settings</a></li><li class='navitem-'><a href='../account/logout.php'><i class='fa fa-power-off'></i> Log Out</a></li></ul></li>
    </ul></div>
</nav>
<!-- Collect the nav links, forms, and other content for toggling -->
  
<div id="google_map"></div>
<script src="app.js"> </script>
<?php echo renderTemplate("footer.html"); ?>

</body>
</html>