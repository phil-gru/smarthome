<?php

//Datenbank ausfüllen -> dbhost; dbname; dbuser; dbpassword;
$dbmysql = 'mysql:host=localhost;dbname=cloud';
$dbuser = 'root';
$dbpassword = '';
//Ordner struktur des Users (upload folder):
$structure = './upload/';
//Datei-Upload /Größe/
$large = '500000000'; //500000000 (Byte) entspricht 500000 (Kilobyte) bzw. 500 (Megabyte)
//fremden benutzer signup
$signup = true; //TRUE = standard
$change_username = true; // TRUE = standard
