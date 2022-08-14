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

$target_dir = '.'.$structure.$username.'/';
$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
$filename = basename($_FILES["uploadfile"]["name"]);
$error = false;

if (file_exists($target_file)) {
  echo "Die datei existiert bereits";
  header('Location: ../DashboardMenu.php');
  $error = true;
} else {
  if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
    echo "Datei erfolgreich hochgeladen";
    $statement = $db->prepare("INSERT INTO data (username, filename, path) VALUES (:username, :filename, :path)");
    $result = $statement->execute(array('username' => $username, 'filename' => $filename, 'path' => $target_file));
    header('Location: ../DashboardMenu.php?uploadsuccess');

  } else {
    echo "Fehler.";
  }
}

?>
