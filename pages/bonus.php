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
*          File Name        > <!#FN> bonus.php </#FN>                                                                  
*          File Birth       > <!#FB> 2021/09/18 00:38:17.364 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/24 00:08:07.991 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/


$perm = new Gebruikers;
$sesison = new Session;
$db = new Db;
if ($perm->check('user')) {

?>
<div class="container">
    <div class="alert alert-info">Our current products that you can buy with <i class='material-icons'>3d_rotation</i>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style='width:25%'>Name</th>
                <th style='width:25%'>Brand</th>
                <th style='width:25%'><i class='material-icons'>3d_rotation</i></th>
                <th style='width:25%'>Expires</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style='width:25%'>Name</th>
                <th style='width:25%'>Brand</th>
                <th style='width:25%'><i class='material-icons'>3d_rotation</i></th>
                <th style='width:25%'>Expires</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
				$bonus = $db->select('bonus', '', '', '', '', '', '', 'datum DESC');
				foreach ($bonus as $info) {
					$verval = ($info['datum'] < time()) ? "Expired" : date('d-m-Y', $info['datum']);
					$bbon = array(':id' => $info['pid']);
					$order = $db->select('products', 'id = :id', '', $bbon, 'fetch');
					$seoproduct = str_replace(" ", "-", $order['name']);
					$seoproduct = strtolower($seoproduct);
					$seomerk = strtolower($order['merk']);
					$discount = "
												<td style='width:25%' class='info'> <a href='//$_SERVER[SERVER_NAME]/$seomerk/$seoproduct.html'>$order[name]</a></td>
												<td style='width:25%' class='info'><a href='//$_SERVER[SERVER_NAME]/$seomerk.html'>$order[merk]</a></td>
												<td style='width:25%' class='warning'>$info[prijs] <i class='material-icons'>filter_drama</i></td>
												<td style='width:25%' class='danger'>$verval</td>";
					$table .= "<tr>";
					$table .=  "$discount";
					$table .=  "</tr>";
				}
				echo $table;
				?>
        </tbody>
    </table>
</div>
<?php
} else {
	$session->flashdata('error', 'Please login to see this page');
}
?>