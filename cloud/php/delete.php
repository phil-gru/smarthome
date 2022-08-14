<?php
session_start();
require 'connection.php';
require 'config.php';

$userid = $_SESSION['userid'];

//Abfrage des Usernames
$user = "SELECT * FROM users WHERE uid = $userid";
foreach ($db->query($user) as $row) {
   $username = $row['username'];
}

if (unlink('.'.$structure.$username.'/'.$_GET['delete'])) {
  $filename = $_GET['delete'];

  $statement = $db->prepare("DELETE FROM data WHERE username = '$username' AND filename = '$filename'");
  $result = $statement->execute(array('username' => $username, 'filename' => $filename));
  header('Location: ../DashboardMenu.php?deletesuccess');
}

 ?>
