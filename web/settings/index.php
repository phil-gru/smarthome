<?php
session_start();
include '../login/connection.php';

if(!isset($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit;
}
//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

//Abfrage des Usernames
$user = "SELECT * FROM users WHERE id = $userid";
foreach ($db->query($user) as $row) {
   echo $row['username'];
   $username = $row['username'];
   $email = $row['email'];
}
  echo " ID: ".$userid;

#Beginn der Einstellungen
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $change_username = $_POST['change_username'];

        $statement = $db->prepare("UPDATE users SET username = :change_username WHERE id = $userid");
        $result = $statement->execute(array('change_username'=>$change_username));
  }
?>

<a href="../DashboardMenu.php">Zurueck</a>

<form method="POST">
  Username:<br>
  <input type="text"  size="40"  maxlength="250" name="change_username" placeholder="<?php echo ''.$username ?>">

  <input type="submit" name="save" value="Save">
</form>
