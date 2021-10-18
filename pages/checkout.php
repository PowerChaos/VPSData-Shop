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
*          File Name        > <!#FN> checkout.php </#FN>                                                               
*          File Birth       > <!#FB> 2021/09/18 00:38:17.364 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/23 22:57:05.289 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$session = new Session;
$perm = new Gebruikers;
$ship = new Shipping;
$db = new Db;
$brand = array(':rand' => $session->get('rand'));
$bid = array(':id' => $session->get('id'));
$order = $db->select('bestelling', 'bestel = :rand AND status = 0', '', $brand);
$land = $db->select('gebruikers', 'id = :id', '', $bid, 'fetch');

if ($perm->check('user')) {
    if ($land['vat']) {
        echo "<div class='alert alert-warning text-center'>Please register on <a href='https://cp.vpsdata.be'> our billing system </a> and contact our support with your order number to get a valid invoice.<br>
        The webshop is only for non business accounts, prices always include tax and only a payment confirmation will be send ( no invoice ) </div>";
    }
?>
<div class="container" id="success">
    <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th style="width:40%">
                    Product
                </th>
                <th style="width:10%">
                    Kleur
                </th>
                <th style="width:10%">
                    Hoeveelheid
                </th>
                <th style="width:20%">
                    Prijs
                </th>
                <th style="width:20%">
                    Clouds
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $prijs = '0';
                $clouds = '0';
                $t = '0';
                $amount = '0';
                $tijdslot = time();
                foreach ($order as $item) {
                    $bpid = array(':pid' => $item['pid']);
                    $product = $db->select('products', 'id = :pid', '', $bpid, 'fetch');
                    $btime = array(':prod' => $product['id'], ':tm' => $tijdslot);
                    $clknop = $db->select('bonus', 'pid = :prod AND datum > :tm', '', $btime, 'fetch');
                    $clprijs = $clknop['prijs'] ?? "1";
                    echo "
				<tr>
			<td style='width:40%'>
			{$product['name']} <a href='#' id='$item[id]' onclick=\"remove(this.id,'shopcart','{$product['name']}');\"><span class='glyphicon glyphicon-remove'></span></a>
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
                    $prijs += $item['prijs'];
                    $clouds += $item['qty'] * $clprijs;
                    $amount += $item['qty'];
                    $t++;
                }
                $paypalfee = round((($prijs / 100) * 5), 2);
                $delivery = $ship->dpd($land['land']);
                $verzending = $delivery;
                $support = "100";
                while ($amount > '20') {
                    $support += $support;
                    $verzending += $delivery;
                    $amount -= '20';
                }
                ?>
        </tbody>
    </table>
    <div class='row'>
        <div class='col-md-6'>
            Select Delivery option:
            <select id='shipping' name='shipping'>
                <option value='Afhaal:0'>Local Store</option>
                <?php
                    if ($delivery) {
                        echo "<option value='DPD:{$verzending}'>DPD Delivery Europe ( + &euro; {$verzending})";
                    } else {
                        echo "<option value='Support:100'>Contact support for shipping rates ( + &euro; {$support})";
                    }
                    ?>
                </option>
            </select>
        </div>
        <div class="col-md-6">
            Select Payment:
            <select id='pay' name='pay'>
                <option value='Cash:0'>Cash (Local Store)</option>
                <option value='Overschrijving:0'>Wire Transfer</option>
                <option value='Paypal:<?php echo $paypalfee ?>'>Paypal ( + &euro;<?php echo $paypalfee ?> )</option>
                <?php echo (($t == "1") and ($land['punten'] >= $clouds) and ($clouds > '1')) ? "<option value='Points:{$clouds}' style='background-color: silver'>Pay {$clouds} 3D Points</option>" : ""; ?>
            </select>
        </div>
    </div>
    <br>
    <?php echo ($prijs > "0") ? "<a href='#' id='bestel' class='btn btn-success btn-block bestel'>Order now for &euro; <prijs id='total'>$prijs</prijs></a>" : "<div class='alert alert-info text-center'>Please add a product first</div>"; ?>
    <?php if (($clouds > '1') && ($t > '1')) { ?>
    <div class="shoping">
        <div class="container">
            <div class="shpng-grids">
                <div class="col-md-12 shpng-grid">
                    <h3><i class='material-icons'>3d_rotation</i> payment avaible</h3>
                    <p>You got to many differend products in your cart, please use only a single product to pay with <i
                            class='material-icons'>3d_rotation</i></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<script>
function remove(val, dat, name) {
    if (confirm('are you sure you like to remove ' + name + ' from your shopping cart ?')) {
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

function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
}
$(document).ready(function() {
    //Bestel Bevestigen
    $('#bestel').on('click', function() {
        var dat = $('#shipping').val();
        var pay = $('#pay').val();
        if ((dat != "Afhaal:0") && (pay == "Cash:0")) {
            alert('Cash is only to pickup from the local store');
            return false;
        }
        if (pay == 'Points:<?php echo $clouds ?>') {
            if (confirm(
                    'Are you sure you want to spend <?php echo $clouds ?> 3D Points on this product ?'
                )) {
                $.ajax({
                    type: "POST",
                    url: "../x/bestel",
                    data: 'confirm=bestel&ship=' + dat + '&pay=' + pay,
                    success: function(data) {
                        $('#success').html(data);
                    }
                });
            }
            return false;
        };
        if (confirm('Please confirm that you like to order')) {
            $.ajax({
                type: "POST",
                url: "../x/bestel",
                data: 'confirm=bestel&ship=' + dat + '&pay=' + pay,
                success: function(data) {
                    $('#success').html(data);
                }
            });
        }
    });

    $('#shipping').on('change', function() {
        var prijs = <?php echo $prijs ?>;
        var dat = $('#shipping').val();
        var pay = $('#pay').val();
        var arr = dat.split(':');
        var arr2 = pay.split(':');
        var ship = (arr[1] * 1) + (arr2[1] * 1);
        var tot = roundToTwo(prijs + ship);
        $('#total').html(tot);
    });

    $('#pay').on('change', function() {
        var prijs = <?php echo $prijs ?>;
        var dat = $('#shipping').val();
        var pay = $('#pay').val();
        var arr = dat.split(':');
        var arr2 = pay.split(':');
        var ship = (arr[1] * 1) + (arr2[1] * 1);
        var tot = roundToTwo(prijs + ship);
        $('#total').html(tot);
    });

}); //einde document Ready
</script>
<script
    src='https://www.paypal.com/sdk/js?client-id=AbTs5Wq7-ieArfQRPSS27DTUGDW_OTHupSXeIve1wIBkLrpAWsmuiCg4h-jwDSUvJPehJ8zA3IBeF2my&enable-funding=venmo&currency=EUR'
    data-sdk-integration-source='button-factory'></script>
<?php
} else {
    $session->flashdata('error', 'Please login to use this page');
}
?>