<?php

$host = "localhost";
$port = "5432";
$dbname = "gotest";
$user = "postgres";
$password = "123789"; 
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string) or die('failed');  