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
*          File Name        > <!#FN> versie.php </#FN>                                                                 
*          File Birth       > <!#FB> 2021/09/18 00:38:17.363 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/24 00:23:05.823 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$versie = "2.0.0";

$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/PowerChaos/VPSData-Shop/tags');
$result = curl_exec($ch);
curl_close($ch);
///Deocde Json
$data = json_decode($result, true);
$checklimit = $data['message'] ?? "";
if ($checklimit) {
	echo "<div class='alert alert-danger text-center'>Your version is $version, unable to check latest version<br>try again in a hour</div>";
} elseif ($data['0']['name'] > $versie) {
	echo "<div class='alert alert-danger text-center'>
			<a href='" . $data['0']['zipball_url'] . "'>New Version " . $data['0']['name'] . " avaible</a>
				</div>";
} else {
	echo "<div class='alert alert-success text-center'>
		<a href='" . $data['0']['zipball_url'] . "'>Latest Version " . $data['0']['name'] . " installed</a>
		</div>";
}