<?php
//46.21.172.131
$host       = 'localhost';
$username   = '';
$password   = '';
$database   = '';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: '.mysqli_connect_error());