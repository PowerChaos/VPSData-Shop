<?php
$user = ""; //gebruikersnaam
$pass = ""; //Passwoord
$database = "" ; //Database
$host = "localhost"; //host
if (empty($_SESSION))
{
	session_start();
}
try {
$db = new PDO('mysql:host='.$host.';dbname='.$database.'', $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
catch(PDOException $e)
    {
    die ("Connection failed: " . $e->getMessage());
    }
/* CopyRight PowerChaos 2016 */
	?>	