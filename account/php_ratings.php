<?php
//PHP 5 +

// database settings 
$db_username = 'root';
$db_password = '';
$db_name = 'frosting';
$db_host = 'localhost';

//mysqli
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

mysqli_query($con,"SELECT ID, ( noise + maintainance + security + management + neighbourhood + pet) AS Total FROM `ratings`");

if (mysqli_connect_errno()) 
{
    header('HTTP/1.1 500 Error: Could not connect to db!'); 
    exit();
}

if($_POST) //run only if there's a post data
{
    //make sure request is comming from Ajax
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'; 
    if (!$xhr){ 
        header('HTTP/1.1 500 Error: Request must come from Ajax!'); 
        exit();    
    }
    
    
    $mnoise         = filter_var($_POST["noise"], FILTER_SANITIZE_STRING);
    $mmaintainance     = filter_var($_POST["maintainance"], FILTER_SANITIZE_STRING);
    $msecurity        = filter_var($_POST["security"], FILTER_SANITIZE_STRING);
    $mmanagement        = filter_var($_POST["management"], FILTER_SANITIZE_STRING);
    $mneighbourhood        = filter_var($_POST["neighbourhood"], FILTER_SANITIZE_STRING);
    $mpet        = filter_var($_POST["pet"], FILTER_SANITIZE_STRING);
    $mtotal        = filter_var($_POST["total"], FILTER_SANITIZE_STRING);
    $mtitle        = filter_var($_POST["title"], FILTER_SANITIZE_STRING);

    $query = "INSERT INTO ratings (noise, maintainance, security, management, neighbourhood, pet, total, title) VALUES ('$mnoise','$mmaintainance','$msecurity', '$mmanagement', '$mneighbourhood', '$mpet', '$mtotal', '$mtitle');
              UPDATE markers m SET m.Average = (SELECT avg FROM (SELECT Title, AVG(Total) as avg FROM ratings GROUP BY Title) r WHERE m.name = r.Title);
              UPDATE markers m SET m.noise = (SELECT avg FROM (SELECT Title, AVG(noise) as avg FROM ratings GROUP BY Title) r WHERE m.name = r.Title);
              UPDATE markers m SET m.maintainance = (SELECT avg FROM (SELECT Title, AVG(maintainance) as avg FROM ratings GROUP BY Title) r WHERE m.name = r.Title);
              UPDATE markers m SET m.security = (SELECT avg FROM (SELECT Title, AVG(security) as avg FROM ratings GROUP BY Title) r WHERE m.name = r.Title);
              UPDATE markers m SET m.management = (SELECT avg FROM (SELECT Title, AVG(management) as avg FROM ratings GROUP BY Title) r WHERE m.name = r.Title);
              UPDATE markers m SET m.neighbourhood = (SELECT avg FROM (SELECT Title, AVG(neighbourhood) as avg FROM ratings GROUP BY Title) r WHERE m.name = r.Title);
              UPDATE markers m SET m.pet = (SELECT avg FROM (SELECT Title, AVG(pet) as avg FROM ratings GROUP BY Title) r WHERE m.name = r.Title)";



   
    $results = $mysqli->multi_query($query);
    if (!$results) {  
          header('HTTP/1.1 500 Error: Could not post rating!'); 
          exit();
    } 
}

