<?php
define('HOST','localhost');
$database = 'gestcom';
  define('DB_NAME',$database);
  define('USER','root');
  define('PASS','');

  try {
  	    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
  	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	    $message = true;
  } catch (PDOException $e) {
  	    
  }
?>