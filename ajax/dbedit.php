<?php
//Basis Waarden
require(getenv("DOCUMENT_ROOT")."/functions/include.php");
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
$edit = $_POST['edit'];
$waarde = $_POST['waarde'];
$split_data = explode(':', $_POST[field]);
$id = $split_data[1];
$field = $split_data[0];
// Basis Waarden
switch($edit){
	case "stock" : //stock Edit page
		switch ($field){
			case "naam":
			$stmt = $db->prepare("UPDATE stock SET naam = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "stock":
		$stmt = $db->prepare("UPDATE stock SET stock = :waarde WHERE id = :id ");
		$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		}
	echo "$field met success aangepast naar \n\n $waarde";
break;
	case "product" : //product Edit Page
		switch ($field){
			case "merk":
				$stmt = $db->prepare("UPDATE products SET merk = :waarde WHERE id = :id ");
				$stmt->execute(array(
				':id' => $id, 
				':waarde' => strtoupper($waarde),
				));
			break;
			case "prijs":
				$stmt = $db->prepare("UPDATE products SET prijs = :waarde WHERE id = :id ");
				$stmt->execute(array(
				':id' => $id, 
				':waarde' => $waarde,
				));
			break;
			case "name":
				$stmt = $db->prepare("UPDATE products SET name = :waarde WHERE id = :id ");
				$stmt->execute(array(
				':id' => $id, 
				':waarde' => $waarde,
				));
			break;
			case "over":
				$stmt = $db->prepare("UPDATE products SET over = :waarde WHERE id = :id ");
				$stmt->execute(array(
				':id' => $id, 
				':waarde' => $waarde,
				));
			break;
			case "cat":
				$stmt = $db->prepare("UPDATE products SET cat = :waarde WHERE id = :id ");
				$stmt->execute(array(
				':id' => $id, 
				':waarde' => strtoupper($waarde),
				));
			break;
			}
			echo "$field met iD $id success aangepast naar \n\n $waarde";
break;
	case "bonus" : //Bonus Edit Pagina
		switch ($field){
			case "pid":
			$stmt = $db->prepare("UPDATE bonus SET pid = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
			case "prijs":
			$stmt = $db->prepare("UPDATE bonus SET prijs = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
			case "datum":
			$stmt = $db->prepare("UPDATE bonus SET datum = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => strtotime($waarde),
			));
		break; //Clouds
		case "discount":
			$stmt = $db->prepare("UPDATE discount SET discount = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;//Clouds
			case "clouds":
			$stmt = $db->prepare("UPDATE discount SET clouds = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		}
	echo "$field met success aangepast naar \n\n $waarde";
break;
	case "gebruiker": //profiel pagina
		switch ($field){
			case "naam":
			$stmt = $db->prepare("UPDATE gebruikers SET naam = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "birth":
			$stmt = $db->prepare("UPDATE gebruikers SET birth = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "voornaam":
			$stmt = $db->prepare("UPDATE gebruikers SET voornaam = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "achternaam":
			$stmt = $db->prepare("UPDATE gebruikers SET achternaam = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "phone":
			$stmt = $db->prepare("UPDATE gebruikers SET phone = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "adress":
			$stmt = $db->prepare("UPDATE gebruikers SET adress = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "nummer":
			$stmt = $db->prepare("UPDATE gebruikers SET nummer = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "bus":
			$stmt = $db->prepare("UPDATE gebruikers SET bus = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "gemeente":
			$stmt = $db->prepare("UPDATE gebruikers SET gemeente = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		case "postcode":
			$stmt = $db->prepare("UPDATE gebruikers SET postcode = :waarde WHERE id = :id ");
			$stmt->execute(array(
			':id' => $id, 
			':waarde' => $waarde,
			));
		break;
		}
	echo "$field met success aangepast naar \n\n $waarde";
break;
}
?>