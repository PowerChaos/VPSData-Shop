<?php
function sesions()
{
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}	
if ($_GET['action'] == "logout")
{
    $_SESSION = array();
    session_destroy();
	session_start();
	session_regenerate_id(true);
    $_SESSION['ERROR'] = "Succesvol Uitgelogd";
}

if ($_GET['session'] == "expired" )
{
//change below text to your own sesion expire error
$_SESSION = array();
session_destroy(); 
$_SESSION['ERROR'] = "Sessie Verlopen ,log opnieuw in";
}

if ($_SESSION['relog'] == "yes")
{
$_SESSION = array();
session_destroy();
session_regenerate_id(true);
$_SESSION[ERROR] =  "Uw wachtwoord is gewijzigt, opnieuw inloggen is noodzakelijk";
}

if ($_SESSION['loggedin'] == 1)
{
echo "<meta http-equiv='refresh' content='3600;URL=http://{$_SERVER['SERVER_NAME']}/sessionexpired'>";	
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
}
/* CopyRight PowerChaos 2016 */
?>