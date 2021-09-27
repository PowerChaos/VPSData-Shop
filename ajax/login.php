<?php
$reg = new Gebruikers;
//ajax call
$login = $_POST['btn-login'] ?? "";
if ($login == 'login') {
  die($reg->login($_POST["username"], $_POST["password"]));
}