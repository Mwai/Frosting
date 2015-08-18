<?php
header('Location: ../404.php');
?>
<?php
    
    include('config.php');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "frosting";
    
    $con = mysqli_connect($servername, $username, $password, $dbname);
    
    $sql = mysqli_query($con, "SELECT name, Average FROM markers ORDER BY Average DESC");
    
    
    if (mysqli_num_rows($sql) > 0) {?>

      <table id ="data" class="display">
       <thead>
        <tr>
          <td>Name</td>
          <td>Average</td>
        </tr>
      </thead>
     </table>

         <?php
        while($row = mysqli_fetch_assoc($sql)) {
             $name = $row['name']; 
             $Average = $row['Average'];
             
                    
             echo "
                          
             <table id='data' class='display'>
             <tr>
             <td>$name</td>
             <td>$Average</td>
             </tr>
             </table>
             ";

        }
    } else {
        echo "0 results";
    }
    mysqli_close($con);
    ?>