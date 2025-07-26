<?php
/* Database credentials. 
May need to be changed when moving to new host!*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'koinuko');
define('DB_PASSWORD', 'O3OQxUBltUv5eVum2Mrs');
define('DB_NAME', 'closet');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($link === null){
    $link = '';
} 
 
// Check connection
if($link === false){
    die("ERROR: Could not connect to database.");
} 
?>