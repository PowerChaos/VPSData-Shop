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
*          File Name        > <!#FN> Gebruikers.class.php </#FN>                                                       
*          File Birth       > <!#FB> 2021/09/19 21:49:31.281 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/19 22:11:43.453 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/





class Gebruikers
{
	public function __construct()
	{
		// start db en Sessie
		$this->db = new Db;
		$this->session = new Session;
		$this->hash = new PasswordStorage;
	}
	function ChangePass($oldpass = "", $newpass = "", $newpassret = "", $id = "")
	{

		$p2 = $this->hash->verify_password($oldpass, $this->session->get('hash'));
		if (((($p2) and ($newpass == $newpassret) and (!empty($newpassret)))) or (!empty($id))) {
			$update = array("wachtwoord" => $this->hash->create_hash($newpass));
			$bind = array(":uid" => $id ? $id : $this->session->get('id'));
			$this->db->update("gebruikers", $update, "id=:uid", $bind);
			if (empty($id)) {
				$this->session->set('hash', $this->hash->create_hash($newpass));
				$this->session->destroy();
			}
			return $this->session->flashdata('error', 'Password changed, please relog');
		} else {
			return $this->session->flashdata('error', 'Passwords does not match, please try again');
		}
	} // einde verwerking password	

	//verander Rechten
	function ChangeRechten($waarde, $data)
	{
		if ($waarde > 1) {
			$update = array("rechten" => $data);
			$bind = array(":waarde" => $waarde);
			$this->db->update("gebruikers", $update, "id =:waarde", $bind);

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
			return $this->session->flashdata('error', 'Rights changed to ' . $data);
		} else {
			return $this->session->flashdata('error', 'The rights from ID ' . $waarde . ' can not be changed');
		}
	}
	//einde Verander Rechten

	//Verander Naam
	function ChangeName($waarde, $data)
	{
		$bind = array(":data" => $data);
		$tel = $this->db->select("gebruikers", "naam = :data", "", $bind, "rowcount");
		if ($tel == '1') {
			return $this->session->flashdata('error', 'User ' . $data . ' already exist, please choose a other name');
		} else {
			$update = array("naam" => $data);
			$bind = array(":waarde" => $waarde);
			$this->db->update("gebruikers", $update, "id =:waarde", $bind);
			return $this->session->flashdata('error', 'Name changed to ' . $data);
		}
	}
	//Einde Verander Naam

	// Voeg Gebruiker Toe
	function AddUser($data, $naam)
	{
		$this->hash = new PasswordStorage;
		$pass = $this->hash->create_hash($data);
		$bind = array("naam" => $naam, "wachtwoord" => $pass);
		$this->db->insert("gebruikers", $bind);
		$this->session->flashdata('error', 'user <font color="red">' . $naam . '</font> added with pass <font color="red">' . $data . '</font>');
	}

	// Register
	private function isDigits(string $s, int $minDigits = 9, int $maxDigits = 16): bool
	{
		return preg_match('/^[0-9]{' . $minDigits . ',' . $maxDigits . '}\z/', $s);
	}
	function validphone(string $telephone, int $minDigits = 9, int $maxDigits = 16): bool
	{
		if (preg_match('/^[+][0-9]/', $telephone)) { //is the first character + followed by a digit
			$count = 1;
			$telephone = str_replace(['+'], '', $telephone, $count); //remove +
		} else {
			return false;
		}

		//remove white space, dots, hyphens and brackets
		$telephone = str_replace([' ', '.', '-', '(', ')'], '', $telephone);

		//are we left with digits only?
		return $this->isDigits($telephone, $minDigits, $maxDigits);
	}
	function register($promo = '50', $email, $pass, $repass, $vn, $an, $tel, $ad, $num, $bus, $gem, $postcode, $land, $bot, $botcheck)
	{
		$email = addslashes($email);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return $this->session->flashdata('error', $email . ' is not a valid email address');
		}
		$pass = addslashes($pass);
		$repass = addslashes($repass);
		if ($pass != $repass) {

			return $this->session->flashdata('error', 'Password is not the same');
		}
		if ($bot != $botcheck) {
			return $this->session->flashdata('error', 'Anti bot fail, please press the red button');
		}
		if (!$this->validphone($tel)) {
			return $this->session->flashdata('error', 'Phone number is wrong , please use this format <pre>+32 493 48 30 33</pre>');
		}

		//empty check
		$control = array("$vn", "$an", "$ad", "$num", "$gem", "$postcode", "$tel", "$land", "$pass", "$repass");
		if (in_array("", $control)) {
			return $this->session->flashdata('error', 'Mandatory field is empty');
		}
		//Database Check
		$bind = array(':email' => $email);
		$count = $this->db->select('gebruikers', 'naam = :email', '', $bind, 'rowcount');
		if (!$count) {
			$hashpass = $this->hash->create_hash($pass);
			$information = array(
				"naam" 		=> $email,
				"wachtwoord" 	=> $hashpass,
				"punten" 		=> $promo,
				"voornaam" 	=> $vn,
				"achternaam" 	=> $an,
				"phone" 		=> $tel,
				"adress" 		=> $ad,
				"nummer" 		=> $num,
				"bus" 			=> $bus,
				"gemeente" 	=> $gem,
				"postcode" 	=> $postcode,
				"land" 		=> $land
			);
			$this->db->insert("gebruikers", $information);
			return $this->session->flashdata('error', 'Succesfull Registered , you can now login');
		} else {
			return $this->session->flashdata('error', 'Email already exist , please try again');
		}
	}
	//login
	function login($email, $pass)
	{
		$email = addslashes($email);
		$pass = addslashes($pass);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return $this->session->flashdata('error', $email . ' is not a valid email address');
		}
		$update = array("wachtwoord" => $this->hash->create_hash($pass));
		$bind = array(":email" => $email);
		$user = $this->db->select('gebruikers', 'naam = :email', '', $bind, 'fetch');
		if (!$user) {
			return $this->session->flashdata('error', $email . ' is not a valid email address');
		}
		$passcheck = $this->hash->verify_password($pass, $user['wachtwoord']);
		if ($passcheck) {
			$random = uniqid();
			$this->db->update("gebruikers", $update, "naam=:email", $bind);
			$this->session->set('loggedin', '1');
			$this->session->set('id', $user['id']);
			$this->session->set('naam', $user['naam']);
			$this->session->set('hash', $user['wachtwoord']);
			$this->session->set('groep', $user['groep']);
			$this->session->set('rand', $random);
			switch ($user['rechten']) {
				case '3':
					$this->session->set('admin', '1');
					$this->session->flashdata('error', 'Welkom Admin <pre>' . $user['naam'] . '</pre>');
					echo 1;
					break;
				case '2':
					$this->session->set('staff', '1');
					$this->session->flashdata('error', 'Welkom Staff <pre>' . $user['naam'] . '</pre>)');
					echo 1;
					break;
				case 'b':
					$this->session->set('loggedin', '0');
					echo 0;
					break;
				default:
					$this->session->flashdata('error', 'Welkom user <pre>' . $user['naam'] . '</pre>)');
					echo 1;
					break;
			}
		} else {
			echo "No valid login found, please try again";
			$fails = $this->session->get('faillogin');
			$fails++;
			$this->session->set('faillogin', $fails);
			$this->session->set('timer', time());
			if ($fails >= '5') {
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=../login\" />";
			}
		}
	}
	// einde verwerking login.php
	//check gebruikers
	function check($rank)
	{
		switch ($rank) {
			case "user":
				return ($this->session->get('loggedin') == 1) ? true : false;
				break;
			case "admin":
				return ($this->session->get('admin') == 1) ? true : false;
				break;
			case "staff":
				if ($this->session->get('admin') == 1 || $this->session->get('staff') == 1)
					return true;
				break;
		}
	}
}
