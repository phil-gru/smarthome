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
   $created_at = $row['created_at'];
   $admin_rights = $row['admin_rights'];
}

//Abfrage der dateien
// echo "<table><tr><th>ID</th><input type".'checkbox'."><label><th>Datei Name</th></label><th>Dateien Pfad</th><th>Erstellt am</th><th>Lösch-Link</th></tr>";
$tbl_data = "SELECT * FROM data WHERE username = '$username' LIMIT 25";
foreach ($db->query($tbl_data) as $row) {
    $file_id = $row['id'];
    $filename = $row['filename'];
    $filepath = $row['path'];
    $created_at = $row['created_at'];
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
    <?php
        $dir = $structure.$username.'/';
        $dir_content = scandir($structure.$username.'/');

        for ($i=2; $i < count($dir_content); $i++) { ?>
          <p>
            <?php echo $dir_content[$i]; ?>
            <?php echo "erstellt am: ".$created_at; ?>
            <a href="php/download.php?download=<?php $dir ?><?php echo $dir_content[$i]; ?>"> <button class="button">download</button></a>
            <a href="php/delete.php?delete=<?php $dir ?><?php echo $dir_content[$i]; ?>"><button class="">delete</button></a>
          </p>
        <?php } ?>
      <form action="php/upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="uploadfile"><br>
        <input class="button" type="submit" value="upload">
      </form>
    <a href="logout.php">Logout</a>
  </body>
</html>
