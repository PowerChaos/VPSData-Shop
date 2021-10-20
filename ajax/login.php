<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
require(getenv("DOCUMENT_ROOT")."/functions/PasswordStorage.php");

//verwerking Data van home.php Login Form
//LOGIN CONFIG
if(isset($_POST['btn-login']))
{

       // convert username and password from _GET to _SESSION
    $hash = NEW PasswordStorage;
    $username = $_POST["username"];
    $username = addslashes($username);
	$pass = $_POST["password"];
    $pass = addslashes ($pass);
try{	
$stmt = $db->prepare("SELECT * FROM gebruikers WHERE naam=:username LIMIT 1");
$stmt->execute(array(':username' => $username));
$result = $stmt->rowCount();
}
catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
}	
            if ($result != 0)
            {
	try{		
				$stmt = $db->prepare("SELECT * FROM gebruikers WHERE naam=:username LIMIT 1");
				$stmt->execute(array(':username' => $username));
				$passhash = $stmt->fetch(PDO::FETCH_ASSOC);
				$result2 = $hash->verify_password($pass,$passhash['wachtwoord']);				
		}
	catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
	}
	
	if ($result2 != 0)
            {
				try{
			$stmt = $db->prepare('SELECT * FROM gebruikers WHERE naam =:username LIMIT 1');
			$stmt->execute(array(':username' => $username));
			$changepass = $db->prepare("UPDATE gebruikers SET wachtwoord=:hash WHERE naam =:uid");
			$hashpass = $hash->create_hash($pass);
			$changepass->execute(array(':hash' => $hashpass,':uid' => $username));
			$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
					}
	catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die('</h2></font> ');
	}
	$_SESSION['loggedin'] = 1;
	$_SESSION['id'] = $result2['id'];
	$_SESSION['naam'] = $result2['naam'];
	$_SESSION['hash'] = $passhash['wachtwoord'];
	$_SESSION['groep'] = $result2['groep'];
	
	if ($result2['rechten'] == '3')
	{
		$_SESSION['admin'] = "1";
		$check = "Welkom Admin $_SESSION[naam]";
		echo "1";
	}
	elseif ($result2['rechten'] == '2')
	{
		$_SESSION['staff'] = "1";
		$check = "Welkom Staff $_SESSION[naam]";
		echo "1";
	}
	elseif ($passhash['rechten'] =='b')
		{
					echo "0";
		}
	else
	{
		$check = "Welkom Gebruiker $_SESSION[naam]";
		echo "1";
	}
		
	$_SESSION[ERROR] = "$check";
	}
		 else 
        {
            echo "Niets Gevonden met $username en $pass";
		}		
			}				
else
 {
            echo "gebruiker $username bestaat niet";
			
 }
 } //Einde verwerking Data van home.php Login Form
 else
 {
	 echo "geen post ?";
 }
 /* CopyRight PowerChaos 2016 */
 ?>