<?php

@define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
@define('DB_USERNAME', getenv('DB_USERNAME') ?: 'your_db_username');
@define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'your_db_password');
@define('DB_NAME', getenv('DB_NAME') ?: 'hybreed_courier');

 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>

