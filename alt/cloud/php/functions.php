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
