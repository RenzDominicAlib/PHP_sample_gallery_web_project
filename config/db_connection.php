<?php 

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'kingdom');
// Check the Connection
if (!$conn) {
  echo 'Connection error: ' . mysqli_connect_error($conn);
}

 ?>