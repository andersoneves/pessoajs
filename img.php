<?php
var_dump($_POST);
var_dump($_FILES);
$img = $_FILES['arquivo']['name'];
$tmp = $_FILES['arquivo']['tmp_name'];
$path="img/".$img;
move_uploaded_file($tmp,$path)
?>