<?php
session_start();
include 'connection.php';

if(!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

//Abfrage des Usernames
$user = "SELECT * FROM users WHERE id = $userid";
foreach ($db->query($user) as $row) {
   echo $row['username'];
   $username = $row['username'];
   // $authority = $row['authority'];
}

  echo " ID: ".$userid;




// Abfrage der Authorität && ENDE
  // if($row['authority'] == 1) {
  //   include '../index.html';
  // } if($row['authority'] == 0) {
  //   include 'templates/user.php';
  // }
?>

<a href="logout.php">Logout</a>
