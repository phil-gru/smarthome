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
// NOTE: DATEIEN HOCHLADEN
  data_upload($username, $uuid, $structure.$uuid.'/');
// NOTE: DATEIEN WERDEN VERÖFFENTLICHT
  set_publish_data($username, $uuid);
// NOTE: DATEIEN WERDEN NICHT VERÖFFENTLICHT
  set_unpublished_data($username, $uuid);
// NOTE: VERÖFFENTLICHTE DATEIEN ANZEIGEN
  // list_public_data($username, $uuid, $created_at);
// NOTE: DATEIEN WERDEN GELÖSCHT
  delete_data($username, $uuid);
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="text/javascript" src="assets/js/index.js"></script>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <title>Cloud | Menü</title>
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
        $dir = $structure.$uuid.'/';
        $dir_content = scandir($structure.$uuid.'/');
        echo '<table style="width:100%">
          <tr>
            <th>Dateiname</th>
            <th>Aktionen</th>
            <th>Hochgeladen am</th>
            <th>Bild Vorschau</th>
          </tr>';
        for ($i=2; $i < count($dir_content); $i++) { ?>
          <p>
             <?php
             $extension = pathinfo($dir.$dir_content[$i], PATHINFO_EXTENSION);
             $basename = pathinfo($dir.$dir_content[$i], PATHINFO_FILENAME);
             // NOTE: DATEIEN UMBENENNEN
               rename_data($username, $uuid, $dir_content[$i], $extension);
              ?>
              <form method="post" action="">
             <tr>
               <!-- <td><form style="margin: 8px;" action='' method='post'><input type="text" size="40" maxlength="255" value="<?php echo $basename; ?>" name="filename"><?php echo '.'.$extension; ?><br><br></td> -->
               <td><?php echo $dir_content[$i]; ?><br><br></td>
               <td><a href="<?php echo $dir.$dir_content[$i]; ?>" download><button type="button" class="button">Herunterladen</button></a><input type="checkbox" name='data[]' value="<?php echo $dir_content[$i]; ?>"></td>
                 <!-- <input style="margin: 8px;" class="button" type='submit' name="rename" value='Umbenennen'></form> -->

                 <!-- <input class="button" type='submit' name='upload' value='Umbennen'></form> -->
               <td><?php echo $created_at; ?></td>
               <td><?php $check_image = getimagesize($dir.$dir_content[$i]);
                if(!$check_image) { echo 'Kein Bild Vorhanden'; } else { echo '<img src="'.$dir.$dir_content[$i].'">'; }?>
              </td>
             </tr>
          </p>
        <?php } ?>
        </table>
              <input class="button" type="submit" name="delete" value="Löschen">
              <input class="button" type="submit" name="unpublish" value="Nicht Veröffentlichen">
              <input class="button" type='submit' name='publish' value='Veröffentlichen'>
            </form>
      <!-- <p><?php echo sizeFilter(get_folderSize($dir)); ?> / <?php echo round_up(intval(sizeFilter($max_folderSize)), -2); ?> MB</p> -->
      <form style="margin: 8px;" method='post' action='' enctype='multipart/form-data'>
       <input type="file" name="file[]" id="file" multiple>
       <input class="button" type='submit' name='upload' value='Hochladen'>
      </form>
    <a href="logout.php">Logout</a>
  </body>
</html>
