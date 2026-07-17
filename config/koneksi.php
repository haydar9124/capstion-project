<?php

$host = "sql313.infinityfree.com";
$user = "if0_42309829";
$pass = "pujDQPfYMSlzCn";
$db   = "if0_42309829_ewarung";

$conn = mysqli_connect($host,$user,$pass,$db);

if(!$conn){
    die("Koneksi gagal : ".mysqli_connect_error());
}
?>