<?php
session_start();
require 'php/connection.php';
require 'php/config.php';

if(!isset($_SESSION['userid'])) {
  header('Location: login.php');
  exit;
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

//Abfrage der User informationen
$tbl_user = "SELECT * FROM users WHERE uid = $userid";
foreach ($db->query($tbl_user) as $row) {
   $username = $row['username'];
   $admin_rights = $row['admin_rights'];
   // $current_password['password'];
}
//Passwort ändern::
if (isset($_GET['password'])) {
  // $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];
  $new_password2 = $_POST['new_password2'];
  $error = false;

  $statement = $db->prepare("SELECT * FROM users WHERE username = $username");
  $result = $statement->execute(array('username' => $username));
  $user = $statement->fetch();

  // Überprüfung des Passworts
  // if (password_verify($old_password, $user['password'])) {
  //   echo "Das aktuelle Passwort ist falsch.";
  // }

  if (strlen($new_password) == 0) {
    echo 'Bitte gebe ein neues Passwort ein.<br>';
    $error = true;
  }
  if ($new_password != $new_password2) {
    echo 'Die Passwörter müssen miteinander übereinstimmen.<br>';
    $error = true;
  }

  if (!$error) {
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $statement = $db->prepare("UPDATE `users` SET `password` = :password WHERE uid = $userid");
    $result = $statement->execute(array('password' => $password_hash));

    echo "Passwort wurde geändert.";
  } else {
    echo "Es ist etwas schief gelaufen.";
  }
  print_r($userid);
  // print_r($verify_password);
}
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <title>Cloud | Settings</title>
 		<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
   </head>
   <body>
     <?php if ($change_username == true): ?>
       <h4>Username ändern:</h4>
       <form action="?changeUsername" method="post">
         <!-- <input type="text" maxlength="255" placeholder="Altes Passwort" name="old_password"> -->
         <input type="text" maxlength="255" placeholder="Neuer username" name="new_username">
         <input type="submit">
       </form>
     <?php endif; ?>


     <h4>Passwort ändern:</h4>
     <form action="?changePassword" method="post">
       <!-- <input type="text" maxlength="255" placeholder="Altes Passwort" name="old_password"> -->
       <input type="password" maxlength="255" placeholder="Neues Passwort" name="new_password">
       <input type="password" maxlength="255" placeholder="Neues Passwort wiederholen" name="new_password2">
       <input type="submit">
     </form>
     <a href="javascript:window.close();">Seite schließen</a>
   </body>
 </html>
