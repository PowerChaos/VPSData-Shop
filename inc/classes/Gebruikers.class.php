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
*          File Version     > <!#FV> 0.0.1 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/





class Gebruikers
{	
public function __construct() {
 // start db en Sessie
$this->db = new Db;
$this->session = new Session; 
}
	function ChangePass($oldpass="",$newpass="",$newpassret="",$id="")
	{
		$hash = new PasswordStorage;
		$p2= $hash->verify_password($oldpass,$this->session->get('hash'));
		if (((($p2) AND ($newpass == $newpassret) AND (!empty($newpassret)))) OR (!empty($id)))
		{
		$update = array("wachtwoord" => $hash->create_hash($newpass));
		$bind = array(":uid" => $id?$id:$this->session->get('id'));				
		$this->db->update("gebruikers",$update,"id=:uid",$bind);
		if (empty($id)){
		$this->session->set('hash',$hash->create_hash($newpass));
		}
		echo "<div class='alert alert-success'>Password changed</div>";		
		}
		else
		{
		echo "<div class='alert alert-danger text-center'>Wachtwoord komt niet overeen<br>oud wachtwoord: $oldpass<br>nieuw wachtwoord: $newpass <br>Wachtwoord Herhaling: $newpassret</div>";	
		}
	} // einde verwerking password	
	
	//verander Rechten
	function ChangeRechten($waarde,$data)
	{
		if ($waarde > 1)
		{
		$update = array("rechten" => $data);
		$bind = array(":waarde" => $waarde);				
		$this->db->update("gebruikers",$update,"id =:waarde",$bind);
		
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
		$this->session->flashdata('error','Rights changed to '.$data);
		}
		else
		{
		$this->session->flashdata('error','The rights from ID '. $waarde . ' can not be changed');
		}
	}
	//einde Verander Rechten

	//Verander Naam
	function ChangeName($waarde,$data)
	{
			$bind = array(":data" => $data);
			$tel = $this->db->select("gebruikers","naam = :data","",$bind,"rowcount");
			if ($tel == '1')
			{
				$this->session->flashdata('error','User '.$data.' exist already, please choose other name');
			}
		else
		{	
		$update = array("naam" => $data);
		$bind = array(":waarde" => $waarde);				
		$this->db->update("gebruikers",$update,"id =:waarde",$bind);
		$this->session->flashdata('error','Name changed to '.$data);
		}
	} 
	//Einde Verander Naam
	
	// Voeg Gebruiker Toe
	function AddUser($data,$naam)
	{
		$hash = NEW PasswordStorage;
		$pass = $hash->create_hash($data);
		$bind = array("naam" => $naam,"wachtwoord" => $pass);				
		$this->db->insert("gebruikers",$bind);
		$this->session->flashdata('error','user <font color="red">'.$naam.'</font> added with pass <font color="red">'.$data.'</font>');
	}
}
?>