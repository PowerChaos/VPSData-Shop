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
*          File Name        > <!#FN> voting.php </#FN>                                                                 
*          File Birth       > <!#FB> 2021/09/18 00:38:17.351 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/26 02:53:49.356 </#FT>                                                    *
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
$prod = $_POST['prod'] ?? "";
$rating = $_POST['rating'] ?? "";
$user = $session->get('id');
if ($perm->check('user')) {
	$rat = array(':pid' => $prod, ':uid' => $user);
	$cnt = $db->select('rating', 'pid = :pid AND uid = :uid', '', $rat);
	if (!$cnt) {
		$information = array(
			"pid" 		=> $prod,
			"rating" 	=> $rating,
			"uid" 		=> $user
		);
		$db->insert("rating", $information);
		echo "Thank you for voting , You voted $rating <i class='material-icons'>star</i>";
	} else {

		$bind = array(':pid' => $prod, 'uid' => $user);
		$update = array('rating' => $rating);
		$db->update('rating', $update, "pid = :pid AND uid = :uid", $bind);
		echo " Your vote has been changed to $rating <i class='material-icons'>star</i>";
	}
} else {
	echo "Please login before voting";
}