
<!DOCTYPE html>
<html>
<head>
  <?php

include('config.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "frosting";

$con = mysqli_connect($servername, $username, $password, $dbname);

$sql = mysqli_query($con, "SELECT name, address, type, Average FROM markers ORDER BY Average DESC");

?>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.css">
  
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable(); } );
  </script>
</head>
<body>
  <div>
    <table id = "example" class ="display">
      <thead>
        <tr>
          <th>Name</th>
          <th>Location</th>
          <th>Type</th>
          <th>Rating Index</th>

        </tr>
      </thead>
      <tbody>
        <?php
        while($row = mysqli_fetch_array($sql)) {
        ?>
        <tr>
          <td><?=$row['name']?></td>
          <td><?=$row['address']?></td>
          <td><?=$row['type']?></td>
          <td><?=$row['Average']?></td>
          <?php }?>
        </tr>
      </tbody>
      </table>
  </div>
</body>
</html>
