<?php
require(getenv("DOCUMENT_ROOT")."/functions/include.php");	
require(getenv("DOCUMENT_ROOT")."/functions/database.php");

/*
Ruimte tussen verschillende post invoer functies
*/

//verwerking Data van pass.php
switch ($_POST[info])
{
case "pass":	
	$hash = NEW PasswordStorage;
	$p2 =$hash->verify_password($_POST['oldpass'],$_SESSION['hash']);
	if (($p2)&& $_POST['newpass'] == $_POST['newpass2'])
	{
			$changepass = $db->prepare("UPDATE gebruikers SET wachtwoord=:hash WHERE id=:uid");
			$hashpass = $hash->create_hash($_POST["newpass"]);
			$changepass->execute(array(':hash' => $hashpass,':uid' => $_SESSION[id]));
			$_SESSION[relog] = "yes";			
	}
	else
	{
	$_SESSION[ERROR] = "Wachtwoord komt niet overeen<br>oud wachtwoord: $_POST[oldpass]<br>nieuw wachtwoord: $_POST[newpass] <br>Wachtwoord Herhaling: $_POST[newpass2]";	
	}
	echo ($_SESSION[relog] =="")?"<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}//pass\" />":"<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/\" />";
break;
} // einde verwerking pass.php

/*
Ruimte tussen verschillende post invoer functies
*/

 // Begin verwerking users.php
switch ($_POST['users'])
{
case "rechten":	
	$waarde = $_POST['id'];
	$data = $_POST['rechten'];
	if ($waarde > 1)
	{
	try{
	$stmt = $db->prepare("UPDATE gebruikers SET rechten =:data WHERE id =:waarde ");
	$stmt->execute(
	array(
	':waarde' => $waarde, 
	':data' => $data 
	));
	}
	catch(Exception $e) {
	echo '<h2><font color=red>';
	var_dump($e->getMessage());
	die ('</h2></font> ');
	}
		switch ($data) {
		case "3":
        $data = "admin";
        break;
		case "2":
		$data = "staff";        
        break;
		case "b":
		$data = "Geblokeerd";
		break;
		default:
		$data = "gebruiker";
		}
	$_SESSION[ERROR] = "Rechten zijn aangepast naar $data" ;
	}
	else
	{
	$_SESSION[ERROR] = "de rechten van id $waarde kan niet worden veranderd";
	}
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
break;
case "hernoem":
	$waarde = $_POST['id'];
	$data = $_POST['naam'];
	try{
	$stmt = $db->prepare("UPDATE gebruikers SET naam =:data WHERE id =:waarde ");
	$stmt->execute(
	array(
	':waarde' => $waarde, 
	':data' => $data 
	));
	}
	catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "naam is aangepast naar $data" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
break;
case "toevoegen":
	$hash = NEW PasswordStorage;
	$data = $_POST['wachtwoord'];
	$hashpass = $hash->create_hash($data);
	$naam = $_POST['naam'];
	try{	
	$stmt = $db->prepare("INSERT INTO gebruikers (naam,wachtwoord) VALUES (:naam,:data)");
	$stmt->execute(
	array(
	':naam' => $naam, 
	':data' => $hashpass,
	));
	}
	catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "Gebruiker Toegevoegd met wachtwoord: <font color='red'>$data</font>" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
break;
case "wachtwoord":
	$hash = NEW PasswordStorage;
	$waarde = $_POST['id'];
	$data = $_POST['wachtwoord'];
	$hashpass = $hash->create_hash($data);
	try{
	$stmt = $db->prepare("UPDATE gebruikers SET wachtwoord =:data WHERE id =:waarde ");
	$stmt->execute(
	array(
	':waarde' => $waarde, 
	':data' => $hashpass 
	));
	}
	catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "wachtwoord is aangepast naar $data" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/gebruikers\" />";
break;
}
 // einde verwerking users.php 

/*
	Ruimte tussen verschillende post invoer functies
*/

//verwerking Data van admin/groep.php
switch($_POST['groep']){
case "gebruikers":
	$id = $_POST['gid']; 
	$gebruikers = $_POST['gebruikers'];
	foreach($gebruikers as $a => $b)
	{
		try{
			$stmt = $db->prepare("SELECT user FROM groep WHERE id = :gid");
			$stmt->execute(array(':gid' => $id));
			$users = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($users['user']))
			{
				$str = arr($users['user']);
				sort($str);
				if (!in_array($gebruikers[$a], $str)) {
					$gebruikers[$a] = $users['user'].','.$gebruikers[$a];
				}
				else
				{
					$gebruikers[$a] = $users['user'];	
				}
			}
			$stmt = $stmt = $db->prepare("UPDATE groep SET user =:user WHERE id =:gid ");
			$stmt->execute(
			array(
			':gid' => $id, 
			':user' => $gebruikers[$a] 
			));
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
	}
	$_SESSION[ERROR] = "Gegevens Succesvol ingevoerd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
break;
case "eigenaars":
	$id = $_POST['gid']; 
	$gebruikers = $_POST['gebruikers'];
	foreach($gebruikers as $a => $b)
	{
		try{
			$stmt = $db->prepare("SELECT * FROM gebruikers WHERE id = :gid");
			$stmt->execute(array(':gid' => $gebruikers[$a]));
			$users = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
		if (!empty($users['gid']))
		{
			$_SESSION[ERROR] = "Gebruiker $users[naam] kan maar in 1 Groep zitten" ;
		}
		else
		{
			try{
				$stmt = $stmt = $db->prepare("UPDATE gebruikers SET groep =:gid WHERE id =:user ");
				$stmt->execute(
				array(
				':gid' => $id, 
				':user' => $gebruikers[$a] 
				));
			}
			catch(Exception $e) {
				echo '<h2><font color=red>';
				var_dump($e->getMessage());
				die ('</h2></font> ');
			}
			$_SESSION[ERROR] = "Gegevens Succesvol ingevoerd" ;
		}
	}
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
break;
case "toevoegen":	
	$groep = $_POST['groepen'];
	foreach($groep as $a => $b)
	{
		try{
			$stmt = $stmt = $db->prepare("INSERT INTO groep (naam) VALUES (:naam)");
			$stmt->execute(
			array(
			':naam' => $groep[$a] 
			));
		}
		catch(Exception $e) {
			echo '<h2><font color=red>';
			var_dump($e->getMessage());
			die ('</h2></font> ');
		}
	}
	$_SESSION[ERROR] = "Groep Succesvol Toegevoegd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
break;
case "verwijder":
		$id = $_POST['id']; 
	
	try{
		$stmt = $db->prepare("DELETE FROM groep WHERE id = :id");
		$stmt->execute(array(':id' => $id));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}	
	$_SESSION[ERROR] = "Groep id $id Succesvol verwijderd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
break;
case "groepnaam":
	$waarde = $_POST['waarde'];
	$data = $_POST['data'];
	try{
		$stmt = $stmt = $db->prepare("UPDATE groep SET naam =:data WHERE id =:waarde ");
		$stmt->execute(
		array(
		':waarde' => $waarde, 
		':data' => $data 
		));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "Groepsnaam is aangepast naar $data" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
break;
}

/*
	Ruimte tussen verschillende post invoer functies
*/
 
switch($_POST['delete']){
case "eigenaars":
	$id = $_POST['id'];
	$gid = $_POST['groep'];
	try{
		$stmt = $stmt = $db->prepare("UPDATE gebruikers SET groep =:gid WHERE id =:user ");
		$stmt->execute(
		array(
		':gid' => "", 
		':user' => $id 
		));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "Eigenaar $id is uit groep $gid verwijderd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
break;
case "gebruikers":
	$id = $_POST['id'];
	$gid = $_POST['groep'];
	
	try{
		$stmt = $db->prepare("SELECT * FROM groep WHERE id=:gid");
		$stmt->execute(array(':gid' => $gid));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}	
	
	$str = arr($result['user']);
	sort($str);
	if(($key = array_search($id, $str)) !== false) {
		unset($str[$key]);
	}
	$name = implode(",",$str);
	
	try{
		$stmt = $db->prepare("UPDATE groep SET user =:user WHERE id =:gid ");
		$stmt->execute(
		array(
		':gid' => $gid, 
		':user' => $name 
		));
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}
	$_SESSION[ERROR] = "gebruiker $id is uit groep $gid verwijderd" ;
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/a/groepen\" />";
break;
	
}
// einde verwerking groep.php
 
/*
	Ruimte tussen verschillende post invoer functies
*/

//verwerking ajax/products.php
switch($_POST['products']){
case "stock":

break;
case "bewerk":

break;
} 

// einde verwerking ajax/products.php
 
/*
	Ruimte tussen verschillende post invoer functies
*/
		
//verwerking login.php

if ($_POST['register'] == 'register') //Gebruiker registeren
{					
								$promo = "50"; //Bonus Clouds bij register
							//Hash van variables
								$hash = NEW PasswordStorage;
								$username = $_POST['user'];
								$username = addslashes($username);
								$pass = $_POST['pass1'];
								$pass = addslashes ($pass);
								$passret = $_POST['pass2'];
								$passret = addslashes ($passret);
							//Normale Post Variables
								$vn = $_POST['vn'];
								$an = $_POST['an'];
								$tel = $_POST['tel'];
								$birth = $_POST['birth'];
								$adress = $_POST['adress'];
								$number = $_POST['number'];
								$bus = $_POST['bus'];
								$gemeente = $_POST['gemeente'];
								$postcode = $_POST['postcode'];
								$land = $_POST['land'];
							//explode the date to get month, day and year		
									$birthday = explode("/", $birth);
							//Age Check
							$age = (date("Y") - $birthday[0]);
							if ($age == date("Y")){$age = "";}
						//empty check
						$control = array("$vn","$an","$birth","$adress","$number","$gemeente","$postcode","$age");
						if ((!in_array("",$control)) AND ( $_POST['code'] == $_POST['checkcode']) AND ($age >='18'))
						{
							try {							
							//Database Check
								$stmt = $db->prepare("SELECT * FROM `gebruikers` WHERE `naam` = :username");
								$stmt->execute(array(':username' => $username));
								$result = $stmt->fetch(PDO::FETCH_ASSOC);
								$count = $stmt->RowCount();
									if ($count =="0") //Gebruikersnaam bezet ?
									{
									if ($pass == $passret ) //pass nakijken 
									{
										/*hash password safety */
										$hashpass = $hash->create_hash($pass);
										/* End hashing pass */	
										
									$infostmt = $db->prepare("INSERT INTO gebruikers (naam,wachtwoord,punten,voornaam,achternaam,phone,birth,adress,nummer,bus,gemeente,postcode,land) 
									VALUES (:user,:pass,:punten,:vn,:an,:tel,:birth,:adress,:number,:bus,:gemeente,:postcode,:land)");
								$infostmt->execute(array(
								':user' => $username,
								':pass' => $hashpass,
								':punten' => $promo,
								':vn' => $_POST[vn],
								':an' => $_POST[an],
								':tel' => $_POST[tel],
								':birth' => $_POST[birth],
								':adress' => $_POST[adress],
								':number' => $_POST[number],
								':bus' => $_POST[bus],
								':gemeente' => $_POST[gemeente],
								':postcode' => $_POST[postcode],
								':land' => $_POST[land]
							));
								$_SESSION[ERROR] = "Succesvol Geregistreert" ;
									} //end passcheck 
									else {
												$_SESSION[REGERROR] ="Wachtwoord komt niet overeen";
									}
									} //end count
									else{
												$_SESSION[REGERROR] ="Gebruikersnaam bestaat al , Kies andere naam aub";
									} 
								} //Try
								catch(Exception $e) {
									echo '<h2><font color=red>';
									var_dump($e->getMessage());
									die ('</h2></font> ');
								}
						} //empty Control								
								elseif ($_POST['checkcode'] =="")
								{
									$_SESSION[REGERROR] ="Duw op de RODE voor de capcha , is verplicht";
		
								}
								elseif (($age < "18") AND ($age !=""))
								{
												$_SESSION[REGERROR] ="Registratie onder 18 NIET toegelaten <br /> Uw leeftijd van <b><i>$age</i></b> is NIET Meerderjarig";

								}
								elseif ($age =="")
								{
												$_SESSION[REGERROR] ="GeboorteDatum Klopt Niet,Gelieve juiste datum in te geven";
								}
								else
								{
												$_SESSION[REGERROR] ="Een verplicht veld is leeg , gelieven alles in te vullen.";
								}							
echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/login\" />";
}
// einde verwerking login.php	

/*
	Ruimte tussen verschillende post invoer functies
*/
 
//Geen Direct Acces
if (empty($_POST)) // Geen direct acces :D
{
echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://{$_SERVER['SERVER_NAME']}/\" />";	
}
?>