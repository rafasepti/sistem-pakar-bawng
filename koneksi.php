<?php
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http") . 
"://" . $_SERVER['HTTP_HOST'] . 
str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
  
//membuat koneksi ke database  
$host = 'localhost';  
  $user = 'root';        
  $password = '';        
  $database = 'sbp';    
      
  $konek_db = mysqli_connect($host, $user, $password, $database);      
?>