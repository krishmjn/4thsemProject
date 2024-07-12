<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'testproject');
if (!$conn) {
    die("Connection failed " . mysqli_connect_error());
}
