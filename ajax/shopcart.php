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
*          File Name        > <!#FN> shopcart.php </#FN>                                                               
*          File Birth       > <!#FB> 2021/09/18 00:38:17.349 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/10/02 00:28:04.661 </#FT>                                                    *
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

$bestel = $session->get('rand');
$bcart = array(':bestel' => $bestel);
$result = $db->select('bestelling', 'bestel=:bestel AND status =0', '', $bcart);
if ($perm->check('user')) {
?>
<table class="table table-bordered table-striped table-responsive">
    <thead>
        <tr>
            <th style="width:40%">
                Product
            </th>
            <th style="width:10%">
                Color
            </th>
            <th style="width:10%">
                Amount
            </th>
            <th style="width:20%">
                Price
            </th>
            <th style="width:20%">
                Points
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
			$count = "0";
			foreach ($result as $item) {
				$bcart = array(':pid' => $item['pid']);
				$result2 = $db->select('products', 'id=:pid', '', $bcart, 'fetch');
				echo "
				<tr>
			<td style='width:40%'>
			{$result2['name']} <a href='#' id='$item[id]' onclick=\"remove(this.id,'shopcart','{$result2['name']}');\"><span class='glyphicon glyphicon-remove'></span></a>
			</td>
			<td style='width:10%'>
			{$item['kleur']}
			</td>
			<td style='width:10%'>
			{$item['qty']}
			</td>
			<td style='width:20%'>
			&euro; {$item['prijs']}
			</td>
			<td style='width:20%'>
			{$item['clouds']} <i class='material-icons'>3d_rotation</i>
			</td>
		</tr>
		";
				$count++;
			}
			?>
    </tbody>
</table>
<?php echo ($count >= '1') ? "<a href='../checkout' class='btn btn-success btn-block'>Order Now</a>" : "<div class='alert alert-info text-center'>Please add a product first to be able to checkout</div>"; ?>
<script>
function remove(val, dat, name) {
    if (confirm('Please confirm to remove product ' + name + '')) {
        {
            $.ajax({
                type: "POST",
                url: "../x/remove",
                data: 'confirm=' + dat + '&id=' + val,
                success: function(data) {
                    //alert(dat+" Succesvol uitgevoerd");
                    window.location.reload();
                }
            });
        }
    }
}
</script>
<?php
} else {
	$session->flashdata('error', 'Please login to use this page');
}
?>