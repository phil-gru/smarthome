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
}

if ($admin_rights == 0) {
  Header('Location: DashboardMenu.php');
}

if(isset($_GET['addUser'])) {
  $error = false;
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  if (strlen($username) == 0) {
    echo 'Bitte geben einen Username ein.';
    $error = true;
  }
  if (strlen($password) == 0) {
    echo 'Bitte gebe ein Passwort ein.';
    $error = true;
  }
  if ($password != $password2) {
    echo 'Die Passwörter müssen miteinander übereinstimmen.';
    $error = true;
  }
//Ist username schon vergeben
  if (!$error) {
    $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $user = $statement->fetch();

    if($user !== false) {
        echo 'Der Username ist bereits vergeben.';
        $error = true;
    }
  }
//User wird registriert
  if (!$error) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $result = $statement->execute(array('username' => $username, 'password' => $password_hash));

    echo "Der Benutzer wurde erstellt.";
//Ordner erstellen + Oderner struktur in == /php/config.php
    if (!mkdir($structure.$username, 0777, true)) {
        die('Es konnte kein ordner erstellt werden... (fehler)');
    }
  }
}
- ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Cloud | Admin Settings</title>
  </head>
  <body>
    <h3>Benutzer Hinzufügen</h3>
    <form action="?addUser" method="post">
      <input type="text" maxlength="255" placeholder="Username" name="username">
      <input type="password" maxlength="255" placeholder="Passwort" name="password">
      <input type="password" maxlength="255" placeholder="Passwort wiederholen" name="password2">
      <input type="submit" value="Hinzufügen">
    </form>
    <a href="DashboardMenu.php">Zurück</a>
  </body>
</html>
