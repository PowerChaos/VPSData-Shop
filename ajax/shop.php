<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
if (!u()){
	echo "<pre>Gelieven eerst te registeren of in te loggen Voordat u kan winkelen</pre>";
}
elseif ($_POST['item'] == "toevoegen")
{
$_SESSION['rand'] = ($_SESSION['rand'] =="")?uniqid():$_SESSION['rand'];
$uid = $_SESSION['id'];
$pid = $_POST['waarde'];
$stmt = $db->prepare("SELECT * FROM products WHERE id = :pid");
$stmt->execute(array(':pid' => $pid));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$qty = $_POST['qty'];
$prijs = $result['prijs']; 
$totaal = $prijs * $qty;
								$stmt3 = $db->prepare("SELECT * FROM gebruikers WHERE id = :user");
								$stmt3->execute(array(':user' => $_SESSION[id]));
								$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
								$stmt4 = $db->prepare("SELECT * FROM discount WHERE clouds <= :groep ORDER BY clouds DESC LIMIT 1");
								$stmt4->execute(array(':groep' => $row3[punten]));
								$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
								$disc = ($row4[discount] =="")?"0":$row4[discount];
								$korting = floor($prijs * $qty);
								$bonus = floor(($korting / 100) * $disc);
								$clouds = $korting + $bonus;
$kleur = $_POST['kleur'];
$datum = time();
if ($qty > 0)
{
try {							
								$infostmt = $db->prepare("INSERT INTO bestelling (uid,bestel,pid,prijs,qty,clouds,kleur,datum) 
								VALUES (:uid,:bestel,:pid,:prijs,:qty,:clouds,:kleur,:datum)");
								$infostmt->execute(array(
								':uid' => $uid,
								':bestel' => $_SESSION[rand],
								':pid' => $pid,
								':prijs' => $totaal,
								':qty' => $qty,
								':clouds' => $clouds,
								':kleur' => $kleur,
								':datum' => $datum
							));
								echo "<pre>Product Succesvol Toegevoegt aan winkelmandje</pre>" ;
								$_SESSION['total']++;
									} //end try
								catch(Exception $e) {
									echo '<h2><font color=red>';
									var_dump($e->getMessage());
									die ('</h2></font> ');
								}	
	
}
else
{
echo "<pre>Dit product is niet meer leverbaar , Gelieven een ander product te kiezen</pre>";	
}
}	