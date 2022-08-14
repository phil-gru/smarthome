<?php
session_start();
include 'php/connection.php';

if(isset($_GET['login'])) {
    $username = $_POST['username'];
    $passwort = $_POST['passwort'];

    $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $user = $statement->fetch();
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['password'])) {
        $_SESSION['userid'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $errorMessage = "username oder Passwort war ungültig<br>";
    }

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
<?php
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>

<form action="?login=1" method="post">
Username:<br>
<input type="text" size="40" maxlength="250" name="username"><br><br>

Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>

<input type="submit" value="Abschicken">
<p>Noch kein Konto?</p>
<a href="signup.php">Registrieren</a>

</form>
</body>
</html>
