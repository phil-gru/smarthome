<?php
session_start();
require 'php/connection.php';
// require 'php/connection-server.php';

if(isset($_GET['signup'])) {
  $error = false;
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  if (strlen($username) == 0) {
    echo 'Bitte geben einen username ein.';
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
        echo 'Der username ist bereits vergeben.';
        $error = true;
    }
  }
  //User wird registriert
  if (!$error) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $result = $statement->execute(array('username' => $username, 'password' => $password_hash));
//note: Soll nur auf Speicher-Server erstellt werden?
//Ordner erstellen + Oderner struktur in == /php/config.php
    // if (!mkdir($target_desk_dir.'desk.'.$username, 0777, true)) {
    //     die('Es konnte kein ordner erstellt werden... !Fehler!');
    // }
    // if (!copy($target_desk_dir.'index.php', $target_desk_dir.'desk.'.$username.'/index.php')) {
    //   die('Einrichtung des Desk ist schiefgelaufen :/');
    // }

    header('Location: login.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Philipp | Signup</title>
		<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <form action="?signup=1" method="post">
      <input type="text" maxlength="255" placeholder="E-Mail" name="username">
      <input type="password" maxlength="255" placeholder="Passwort" name="password">
      <input type="password" maxlength="255" placeholder="Passwort wiederholen" name="password2">
      <input type="submit">
    </form>
    <a href="DashboardMenu.php">Zu Hauptseite</a>
  </body>
</html>
