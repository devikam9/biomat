<?php
$hn = 'localhost';
$db = 'biomat';
$un = 'root';
$pw = 'root';

$connection = new mysqli($hn, $un, $pw, $db);
if ($connection->connect_error) die("Fatal Error");

function queryMysql($query) {
    global $connection;
    return $connection->query($query);
}