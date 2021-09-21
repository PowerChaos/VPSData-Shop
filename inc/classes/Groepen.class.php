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
*          File Name        > <!#FN> Groepen.class.php </#FN>                                                          
*          File Birth       > <!#FB> 2021/09/19 22:02:56.845 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/19 22:11:52.173 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/




class Groepen
{	
public function __construct() {
 // start db en Sessie
$this->db = new Db;
$this->session = new Session; 
}
	function Splitter($string, $separator = ',')
	{
	//Explode on comma
	$vals = explode($separator, $string);

	//Trim whitespace
	$vals = array_map("trim", $vals);

	//Return empty array if no items found
	//http://php.net/manual/en/function.explode.php#114273
	return array_diff($vals, array(""));
	}

	function AddGebruikers($id,$gebruikers) // Voeg gebruikers toe aan groep
	{
		foreach($gebruikers as $a => $b)
		{
			$users = $this->db->select('groep',"id = {$id}",'','','fetch','user');
			if (!empty($users['user']))
			{
				$str = $this->Splitter($users['user']);
				sort($str);
				if (!in_array($gebruikers[$a], $str)) {
					$gebruikers[$a] = $users['user'].','.$gebruikers[$a];
				}
				else
				{
					$gebruikers[$a] = $users['user'];	
				}
			}
		$update = array("user" => $gebruikers[$a]);
		$bind = array(":uid" => $id);				
		$this->db->update("groep",$update,"id=:uid",$bind);
		}
        $this->session->flashdata('error','users with id: '.$gebruikers[$a].' added to group id: '.$id.'<br>');
	} // Einde Gebruikers Groep
	
	function AddEigenaars($id,$gebruikers) // Voeg eigenaar toe aan groep
	{
		foreach($gebruikers as $a => $b)
		{
			$users = $this->db->select('gebruikers',"id = {$gebruikers[$a]}",'','','fetch');
				if (!empty($users['groep']))
				{
                $this->session->flashdata('error','user '.$users['naam'].'is already in group id '.$users['groep'].'<br>');    
				}
				else
				{
					$update = array("groep" => $id);
					$bind = array(":id" => $gebruikers[$a]);				
				$this->db->update("gebruikers",$update,"id=:id",$bind);
                $this->session->flashdata('error','user '.$users['naam'].'added to group id: '.$id.'<br>'); 
				}
		}
	} // Einde Eigenaars Groep
	
	function AddGroep($gebruikers) // groep Toevoegen
	{
		foreach($gebruikers as $a => $b)
		{
		$update = array("naam" => $gebruikers[$a]);			
		$this->db->insert("groep",$update);
        $this->session->flashdata('error','Group '.$gebruikers[$a].' succesfull added<br>'); 
		}
	} // Einde Groep Toevoegen
	
	function DelGroep($id) // groep verwijderen
	{
		$bind = array(":id" => $id);			
		$this->db->delete("groep","id = :id",$bind);
        $this->session->flashdata('error','Group id: '.$id.' succesfull removed<br>'); 
	} // Einde Groep verwijderen
	
	function DelEigenaar($id,$groep) // eigenaar uit groep verwijderen
	{
		$update = array("groep" => '');
		$bind = array(":id" => $id);				
		$this->db->update("gebruikers",$update,"id=:id",$bind);
        $this->session->flashdata('error','Owner id: '.$id.' succesfull removed from Group id: '.$groep.'<br>'); 
	} // Einde eigenaar uit Groep verwijderen
	
	function DelGebruiker($id,$groep) // gebruiker uit groep verwijderen
	{			
		$result = $this->db->select("groep","id=$groep","","","fetch");
			$str = $this->Splitter($result['user']);
			sort($str);
			if(($key = array_search($id, $str)) !== false) {
			unset($str[$key]);
			}
		$name = implode(",",$str);
		$update = array("user" => $name);
		$bind = array(":groep" => $groep);		
		$this->db->update("groep",$update,"id=:groep",$bind);
        $this->session->flashdata('error','User id: '.$id.' succesfull removed from Group id:'.$groep.'<br>'); 
	} // Einde gebruiker uit Groep verwijderen

		function GroepNaam($groep,$naam) // Verander Groep Naam
	{
		$update = array("naam" => $naam);
		$bind = array(":id" => $groep);				
		$this->db->update("groep",$update,"id=:id",$bind);
        $this->session->flashdata('error','Group name changed to '.$naam.'<br>'); 
	} // Einde Verander Groep Naam
	
} // Einde Class
?>