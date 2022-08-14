<?php
session_start();
include 'php/connection.php';

if(isset($_GET['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $username));
    $user = $statement->fetch();
    //Überprüfung des passwords
    if ($user !== false && password_verify($password, $user['password'])) {
        $_SESSION['userid'] = $user['uid'];
        header('Location: index.php');
        exit;
    } else {
        $errorMessage = "username oder password war ungültig<br>";
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
<input type="password" size="40"  maxlength="250" name="password"><br>

<input type="submit" value="Abschicken">
<p>Noch kein Konto?</p>
<a href="signup.php">Registrieren</a>

</form>
</body>
</html>
