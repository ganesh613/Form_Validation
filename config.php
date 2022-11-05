<?php 

$sname="localhost";
$uname="root";
$pass="";
$dname="userdetails";

$linkDB = mysqli_connect($sname,$uname,$pass,$dname);
 if ($linkDB){
 	// echo "connected";
 }
 else{
 	// echo "not connected";
 }

 ?>