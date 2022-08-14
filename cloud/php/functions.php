<?php
require 'connection.php';
require 'config.php';

function change_filename($change_filename)
{
    // unerwünschte dateien bzw. namen der dateien beim upload umschreiben

    $change_filename = strtolower ( $change_filename );
    $change_filename = str_replace ('"', "-", $change_filename );
    $change_filename = str_replace ("'", "-", $change_filename );
    $change_filename = str_replace ("*", "-", $change_filename );
    $change_filename = str_replace ("ß", "ss", $change_filename );
    $change_filename = str_replace ("ß", "ss", $change_filename );
    $change_filename = str_replace ("ä", "ae", $change_filename );
    $change_filename = str_replace ("ä", "ae", $change_filename );
    $change_filename = str_replace ("ö", "oe", $change_filename );
    $change_filename = str_replace ("ö", "oe", $change_filename );
    $change_filename = str_replace ("ü", "ue", $change_filename );
    $change_filename = str_replace ("ü", "ue", $change_filename );
    $change_filename = str_replace ("Ä", "ae", $change_filename );
    $change_filename = str_replace ("Ö", "oe", $change_filename );
    $change_filename = str_replace ("Ü", "ue", $change_filename );
    $change_filename = htmlentities ( $change_filename );
    $change_filename = str_replace ("&", "und", $change_filename );
    $change_filename = str_replace (" ", "und", $change_filename );
    $change_filename = str_replace ("(", "-", $change_filename );
    $change_filename = str_replace (")", "-", $change_filename );
    $change_filename = str_replace (" ", "-", $change_filename );
    $change_filename = str_replace ("'", "-", $change_filename );
    $change_filename = str_replace ("/", "-", $change_filename );
    $change_filename = str_replace ("?", "-", $change_filename );
    $change_filename = str_replace ("!", "-", $change_filename );
    $change_filename = str_replace (":", "-", $change_filename );
    $change_filename = str_replace (";", "-", $change_filename );
    $change_filename = str_replace (",", "-", $change_filename );
    $change_filename = str_replace ("--", "-", $change_filename );

    $change_filename = filter_var($change_filename, FILTER_SANITIZE_URL);
    return ($change_filename);
}

function data_upload($username, $filepath)
{
  require 'connection.php';
  require 'config.php';
  $error = false;

  if(isset($_POST['upload'])){
   // Count total files
   $countfiles = count($_FILES['file']['name']);

   $target_file = $structure.$username.'/'.basename($_FILES["file"]["name"][0]);
// BUG: WIRD NICHT RICHTIG ÜBERPRÜFT -> if(empty($_FILES["file"]["name"])) {
   if(empty($_POST['upload'])) {
     echo "Es wurde keine Datei ausgewählt.";
     $error = true;
   } elseif(file_exists($target_file)) {
       echo "Die datei existiert bereits";
       // header('Location: ../DashboardMenu.php');
       $error = true;
     } elseif(!$error) {
     // Looping all files
     for($i=0;$i<$countfiles;$i++) {
      $filename = $_FILES['file']['name'][$i];
      // Upload file
      if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$structure.$username.'/'.$filename)) {
          $statement = $db->prepare("INSERT INTO data (username, filename, path) VALUES (:username, :filename, :path)");
          $result = $statement->execute(array('username' => $username, 'filename' => $filename, 'path' => $filepath));
        // unset($_POST['upload']);
        }
      }
    }
  }
}


function set_publish_data($username)
{
  require 'connection.php';
  require 'config.php';
  if(isset($_POST['publish'])){
      if(!empty($_POST['data'])) {
          foreach($_POST['data'] as $data){
              echo "Dateien Veröffentlicht: ".$data.'<br/>';
              $statement = $db->prepare("UPDATE data SET public = true WHERE filename = :filename AND username = :username");
              $result = $statement->execute(array('username' => $username, 'filename' => $data));
          }
      }
  }
}

function set_unpublished_data($username)
{
  require 'connection.php';
  require 'config.php';
  if(isset($_POST['unpublish'])){
      if(!empty($_POST['data'])) {
          foreach($_POST['data'] as $data){
              echo "Dateien nicht Veröffentlicht: ".$data.'<br/>';
              $statement = $db->prepare("UPDATE data SET public = false WHERE filename = :filename AND username = :username");
              $result = $statement->execute(array('username' => $username, 'filename' => $data));
          }
      }
  }
}


function list_public_data($username, $created_at)
{
  require 'connection.php';
  require 'config.php';

  $tbl_data = "SELECT * FROM data WHERE username = '$username' AND public = true";
  foreach ($db->query($tbl_data) as $row) {
      $file_id = $row['id'];
      $filename = $row['filename'];
      $filepath = $row['path'];
      $created_at = $row['created_at'];

      $check_image = getimagesize($filepath.$filename);
      if(!$check_image) {
        echo "<p>$filename von $username</p><br>";
      } else {
        echo "<img src=".$filepath.$filename."><p>$filename von $username hochgeladen am $created_at</p><br>";
      }
  }
}

function delete_data($username)
{
  require 'connection.php';
  require 'config.php';

  if(isset($_POST['delete'])){
      if(!empty($_POST['data'])) {
          foreach($_POST['data'] as $data){
              echo "Dateien Gelöscht: ".$data.'<br/>';
              if(unlink($structure.$username.'/'.$data)) {
                $statement = $db->prepare("DELETE FROM data WHERE username = :username AND filename = :filename");
                $result = $statement->execute(array('username' => $username, 'filename' => $data));
              }
          }
      }
  }
}
