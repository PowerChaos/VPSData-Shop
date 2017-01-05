<?php
//Our functions to show the pages and other things, so do not remove
require_once (getenv("DOCUMENT_ROOT")."/functions/sessions.php");
sesions();
include (getenv("DOCUMENT_ROOT")."/functions/include.php");
//first we include our sesions , else users can not login , so do not remove :D

//here we show the header , feel free to adjust to fit your own template (pages/template/)
template("header");
//my sidebar , depending on template you need it or not ( pages/template/)
template("sidebar");
//here you can start your content based on pages , just put your page in /pages/ and call it like /?page=home
showpage();
//Here is the footer -> read the footer.php file in "/pages/template/"
template("footer");
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
/* CopyRight PowerChaos 2016 */
?>