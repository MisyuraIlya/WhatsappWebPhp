<?php
session_start();
$action = $_POST["action"];


switch ($action) {

  case 'logout':
  session_destroy();
  die('{"success":true}');
    break;

  default:
    die('{"success":false}');
    break;
}


 ?>
