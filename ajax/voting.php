<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
if (u())
{
$rat = $db->prepare("SELECT * FROM rating WHERE pid = :pid AND uid = $_SESSION[id]");
$rat->execute(array(':pid' => $_POST[prod]));
$cnt = $rat->RowCount();
if ($cnt < '1')
{		
$infostmt = $db->prepare("INSERT INTO rating (pid,rating,uid) 
								VALUES (:pid,:rating,:uid)");
								$infostmt->execute(array(
								':uid' => $_SESSION[id],
								':pid' => $_POST[prod],
								':rating' => $_POST[rating]
							));
								echo "Danku voor uw stem , u heeft $_POST[rating] <i class='material-icons'>star</i> gestemt";
}
else
{
	$upt = $db->prepare("UPDATE rating SET rating = :rating WHERE pid = :pid AND uid = :uid");
	$upt->execute(array(':pid' => $_POST[prod],
	':uid' => $_SESSION[id],
	':rating' => $_POST[rating]));
	echo " uw Stem is aangepast naar $_POST[rating] <i class='material-icons'>star</i>";
}
}
else
{
echo "Gelieven eerst in te loggen voordat u kan stemmen";
}
?>