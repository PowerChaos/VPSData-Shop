<?php

/*
<!#CR>
************************************************************************************************************************
*                                                    Copyrigths ©                                                      *
* -------------------------------------------------------------------------------------------------------------------- *
*          Authors Names    > PowerChaos                                                                               *
*          Company Name     > VPS Data                                                                                 *
*          Company Email    > info@vpsdata.be                                                                          *
*          Company Websites > https://vpsdata.be                                                                       *
*                             https://vpsdata.shop                                                                     *
*          Company Socials  > https://facebook.com/vpsdata                                                             *
*                             https://twitter.com/powerchaos                                                           *
*                             https://instagram.com/vpsdata                                                            *
* -------------------------------------------------------------------------------------------------------------------- *
*                                           File and License Informations                                              *
* -------------------------------------------------------------------------------------------------------------------- *
*          File Name        > <!#FN> shop.php </#FN>                                                                   
*          File Birth       > <!#FB> 2021/09/18 00:38:17.349 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/10/02 00:28:09.362 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$db = new Db;
$perm = new Gebruikers;
$session = new Session;

$item = $_POST['item'] ?? "";
if (!$perm->check('user')) {
	echo "<pre>Please register/login before you can shop</pre>";
} elseif ($item == "toevoegen" && $_POST['qty'] != 'undefined') {
	$split = $_POST['kleur'] ?? "";
	$split_data = explode(':', $split);
	$kleur = $split_data[1];
	$prijsje = $split_data[0];

	$rand = $session->get('rand');
	$uid = $session->get('id');
	$pid = $_POST['waarde'] ?? "";
	$bcart = array(':pid' => $pid);
	$result = $db->select('products', 'id=:pid', '', $bcart, 'fetch');
	$qty = $_POST['qty'] ?? "0";
	$prijs =  $result['prijs'] + $prijsje;
	$totaal = (float)$prijs * (int)$qty;
	$buid = array(':uid' => $uid);
	$gebruiker = $db->select('gebruikers', 'id=:uid', '', $buid, 'fetch');
	$bgeb = array(':groep' => $gebruiker['punten']);
	$discount = $db->select('discount', 'clouds <= :groep', '1', $bgeb, '', '*', '', 'clouds DESC');
	$disc = $discount[0]['discount'] ?? "0";
	$bonus = floor(($totaal / 100) * $disc);
	$clouds = $totaal + $bonus;
	$datum = time();
	if ($qty > 0) {
		$information = array(
			"uid" 		=> $uid,
			"bestel" 	=> $rand,
			"pid" 		=> $pid,
			"prijs" 	=> $totaal,
			"qty" 		=> $qty,
			"clouds" 		=> $clouds,
			"kleur" 		=> $kleur,
			"datum" 		=> $datum
		);
		$db->insert("bestelling", $information);
		echo "<pre>Product <b>$result[name]</b> added to shoppin cart</pre>";
		$totals = $session->get('total') + $qty;
		$session->set('total', $totals);
	} //end try
} else {
	echo "<pre>This product is not avaible anymore , please choose a other product</pre>";
}