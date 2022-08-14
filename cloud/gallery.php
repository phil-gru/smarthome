<?php
session_start();
require 'php/connection.php';
require 'php/config.php';
require 'php/functions.php';

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
   $uuid = $row['uuid'];
   $created_at = $row['created_at'];
   $admin_rights = $row['admin_rights'];
}

//Abfrage der dateien
// echo "<table><tr><th>ID</th><input type".'checkbox'."><label><th>Datei Name</th></label><th>Dateien Pfad</th><th>Erstellt am</th><th>Lösch-Link</th></tr>";
$tbl_data = "SELECT * FROM data WHERE uuid = '$uuid'";
foreach ($db->query($tbl_data) as $row) {
    $file_id = $row['id'];
    $filename = $row['filename'];
    $filepath = $row['path'];
    $created_at = $row['created_at'];
    $public = $row['public'];
}

?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="text/javascript" src="assets/js/index.js"></script>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <title>Cloud | Galarie</title>
  </head>

  <header>
    <nav>
        <div class="nav">
            <ul>
                <div>
                </li><a href="DashboardMenu.php">Home</a></li>
                </li><a href="gallery.php">Galarie</a></li>
                <?php if ($admin_rights == 1) { ?>
                </li><a href="./myadminsettings.php">Adminsettings</a></li>
                <?php } ?>
            </ul>
        </div>
        <div>
            <a style="float: right; padding: 2% 2%;" href="settings.php" target="_blank"><button class="button-profile"><?php echo "$username" ?></button></a>
        </div>
    </nav>
  </header>

  <body>
    <?php
    // NOTE: VERÖFFENTLICHTE DATEIEN ANZEIGEN
      list_public_data($username, $uuid);

    ?>
    <a href="logout.php">Logout</a>
  </body>
</html>
