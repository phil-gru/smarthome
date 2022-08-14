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
   $created_at = $row['created_at'];
   $admin_rights = $row['admin_rights'];
}

?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <title>Cloud | Menü</title>
  </head>

  <header>
    <nav>
        <div class="nav">
            <ul>
                <div>
                </li><a href="#">Home</a></li>
                <?php if ($admin_rights == 1) { ?>
                </li><a href="./myadminsettings.php">Myadminsettings</a></li>
                <?php } ?>
                </div>
            </ul>
        </div>
        <div>
            <a style="float: right; padding: 2% 2%;" href="settings.php" target="_blank"><button class="button-profile"><?php echo "$username" ?></button></a>
        </div>
    </nav>
  </header>

  <body>
    <p>Neues Rezept Hinzufügen:</p>
      <form action="" method="post">
        <input placeholder="Name" type="text" name="nameRecipe"><br>
        <textarea name="ingredients" placeholder="Zutaten" rows="8" cols="80"></textarea><br>
        <textarea name="comment" placeholder="Kommentar" rows="8" cols="80"></textarea><br>
        <input type="submit" value="create">
      </form>
    <a href="logout.php">Logout</a>
  </body>
</html>
