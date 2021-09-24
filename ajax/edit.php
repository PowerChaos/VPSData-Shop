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
*          File Name        > <!#FN> edit.php </#FN>                                                                   
*          File Birth       > <!#FB> 2021/09/24 00:41:41.138 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/24 00:41:54.168 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/


$db = new Db;
$perm = new Gebruikers;

if ($_POST['edit'] == "gebruikers") {
	$table = $_POST['edit'];
	$field = $_POST['field'];
	$waarde = $_POST['waarde'];
	$split_data = explode(':', $field);
	$value = $split_data[0];
	if (($value == 'phone') && !$perm->validphone($waarde)) {
		echo $waarde . ' is not a valid, please use +32 493 48 30 33 format';
		exit;
	}
	$db->ajaxedit($table, $waarde, $field);
	exit;
}