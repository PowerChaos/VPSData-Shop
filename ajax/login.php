<?php
$reg = new Gebruikers;
  //ajax call
  if ($_POST['btn-login'] == 'login') {
    die($reg->login($_POST["username"], $_POST["password"]));
  }