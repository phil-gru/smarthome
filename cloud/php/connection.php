<?php
require 'config.php';
try {
  $db = new PDO($dbmysql, $dbuser, $dbpassword);
} catch (PDOException $e) {
  print $e->getMessage();
}
?>
