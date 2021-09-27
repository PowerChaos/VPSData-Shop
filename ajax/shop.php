<?php
$db = new Db;
$perm = new Gebruikers;
$session = new Session;

$item = $_POST['item'] ?? "";
if (!$perm->check('user')) {
	echo "<pre>Please register/login before you can shop</pre>";
} elseif ($item == "toevoegen" && $_POST['qty'] != 'undefined') {
	$rand = $session->get('rand');
	$uid = $session->get('id');
	$pid = $_POST['waarde'] ?? "";
	$bcart = array(':pid' => $pid);
	$result = $db->select('products', 'id=:pid', '', $bcart, 'fetch');
	$qty = $_POST['qty'] ?? "0";
	$prijs = $result['prijs'];
	$totaal = (int)$prijs * (int)$qty;
	$buid = array(':uid' => $uid);
	$gebruiker = $db->select('gebruikers', 'id=:uid', '', $buid, 'fetch');
	$bgeb = array(':groep' => $gebruiker['punten']);
	$discount = $db->select('discount', 'clouds<=:groep', '1', $buid, 'fetch', '', '', 'clouds DESC');
	$disc = $discount['discount'] ?? "0";
	$korting = floor($prijs * $qty);
	$bonus = floor(($korting / 100) * $disc);
	$clouds = $korting + $bonus;
	$kleur = $_POST['kleur'] ?? "";
	$datum = time();
	if ($qty > 0) {
		$information = array(
			"uid" 		=> $uid,
			"bestel" 	=> $rand,
			"pid" 		=> $pid,
			"prijs" 	=> $totaal,
			"qty" 	=> $qty,
			"clouds" 		=> $clouds,
			"kleur" 		=> $kleur,
			"datum" 		=> $datum
		);
		$db->insert("bestelling", $information);
		echo "<pre>Product added to shoppin cart</pre>";
		$totals = $session->get('total') + $qty;
		$session->set('total', $totals);
	} //end try
} else {
	echo "<pre>This product is not avaible anymore , please choose a other product</pre>";
}