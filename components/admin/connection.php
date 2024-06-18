<?php

session_start();
$conn=mysqli_connect('localhost','root','','project-modified');
if(!$conn){
    die("Connection failed " . mysqli_connect_error());
}

?>