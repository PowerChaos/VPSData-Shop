<?php
//show admin pages + staff pages +  normal pages 
if ($_SESSION['admin'] === "1")
{
function showpage()
{
$file = getenv("DOCUMENT_ROOT")."/pages/".$_GET['page'].".php";
$admin = getenv("DOCUMENT_ROOT")."/pages/admin/".$_GET['admin'].".php";
$staff = getenv("DOCUMENT_ROOT")."/pages/staff/".$_GET['staff'].".php";
if (file_exists($file))
{
include ("$file");
}
else if (file_exists("$admin")) 
{
include ("$admin");
}
else if (file_exists("$staff")) 
{
include ("$staff");
}
else
{
include (getenv("DOCUMENT_ROOT")."/pages/home.php");
}
}
}
// show only staff + normal pages
else if ($_SESSION['staff'] === "1")
{
function showpage()
{
$file = getenv("DOCUMENT_ROOT")."/pages/".$_GET['page'].".php";
$staff = getenv("DOCUMENT_ROOT")."/pages/staff/".$_GET['staff'].".php";
if (file_exists($file))
{
include ("$file");
}
else if (file_exists("$staff")) 
{
include ("$staff");
}
else
{
include (getenv("DOCUMENT_ROOT")."/pages/home.php");
}
}
}
else
{
// show normal pages only
function showpage()
{
$file = getenv("DOCUMENT_ROOT")."/pages/".$_GET['page'].".php";
if (file_exists($file))
{
include ("$file");
}
else
{
include (getenv("DOCUMENT_ROOT")."/pages/home.php");
}
}
}

//our settings hotlink
function settings($file)
{
include (getenv("DOCUMENT_ROOT")."/settings/$file.php");
}

function template($file)
{
include (getenv("DOCUMENT_ROOT")."/template/boot/$file.php");
}
 
//our admin template hotlink
function admin($file)
{
include (getenv("DOCUMENT_ROOT")."/pages/admin/$file.php");
}
/* CopyRight PowerChaos 2016 */
?>