<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/paymentwall.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/mail.php");
Paymentwall_Base::setApiType(Paymentwall_Base::API_GOODS);
Paymentwall_Base::setAppKey(''); // available in your Paymentwall merchant area
Paymentwall_Base::setSecretKey(''); // available in your Paymentwall merchant area
$pingback = new Paymentwall_Pingback($_GET, $_SERVER['REMOTE_ADDR']);
if ($pingback->validate()) {
  $productId = $pingback->getProduct()->getId();
  if ($pingback->isDeliverable()) {
	$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status = '1'");
	$stmt->execute(array(':pid' => $productId));
	$result = $stmt->fetchall(PDO::FETCH_ASSOC);
	foreach ($result as $item)
	{
		$clouds += $item[clouds];
		$user = $item[uid];
	}
	$setclouds = $db->prepare("UPDATE gebruikers SET punten = punten + :clouds WHERE id = :user ");
	$setclouds->execute(array(':clouds' => $clouds,':user' => $user));
	$payment = $db->prepare("UPDATE bestelling SET status = '2' WHERE bestel = :bestel ");
	$payment->execute(array(':bestel' => $productId));
	$mailcheck = $db->prepare("SELECT naam FROM gebruikers WHERE id = :user ");
	$mailcheck->execute(array(':user' => $user));
	$mail = $mailcheck->fetch(PDO::FETCH_ASSOC);
	if (!filter_var($mail[naam], FILTER_VALIDATE_EMAIL) === false) {
		mail_test($productId,'2',$mail[naam]);
		}
	mail_test($productId,'2');
  } else if ($pingback->isCancelable()) {
  // withdraw the product
  } 
  echo 'OK'; // Paymentwall expects response to be OK, otherwise the pingback will be resent
} else {
  echo $pingback->getErrorSummary();
}
?>