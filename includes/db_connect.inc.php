<?php

$conn = mysqli_connect('localhost', 'root', '', 'webtech');

if(mysqli_connect_errno()){
  echo "Error: " . mysqli_connect_err();
  die();
}

?>
