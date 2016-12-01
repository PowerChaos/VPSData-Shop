<?php
/*
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
$b = 53;
for ($a=1;$a <= $b;$a++)
{
$db->beginTransaction();
$stmt = $db->prepare("INSERT INTO `stock` ( `pid`, `naam`, `stock`) VALUES
($a,'0 mg','0')");
$stmt->execute();
$stmt = $db->prepare("INSERT INTO `stock` ( `pid`, `naam`, `stock`) VALUES
($a,'6 mg','0')");
$stmt->execute();
$stmt = $db->prepare("INSERT INTO `stock` ( `pid`, `naam`, `stock`) VALUES
($a,'12 mg','0')");
$stmt->execute();
$stmt = $db->prepare("INSERT INTO `stock` ( `pid`, `naam`, `stock`) VALUES
($a,'18 mg','0')");
$stmt->execute();
$db->commit();
}
echo "Succes";
*/
?>