<?php
session_start();
include 'login/connection.php';

if(!isset($_SESSION['userid'])) {
    header('Location: login/login.php');
    exit;
}
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

//Abfrage des Usernames
$user = "SELECT username, authority FROM users WHERE id = $userid";
foreach ($db->query($user) as $row) {
   echo $row['username'];
   $username = $row['username'];
   $authority = $row['authority'];

}
  echo " ID: ".$userid;

//Bausteine Hinzufügen && ENDE
  include 'assets/bausteine/menu.php';
?>
