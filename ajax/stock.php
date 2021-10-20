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
*          File Name        > <!#FN> stock.php </#FN>                                                                  
*          File Birth       > <!#FB> 2021/09/18 00:38:17.349 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/10/02 00:27:59.554 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$db = new Db;
$split = $_POST['kleur'] ?? "";
$prod = $_POST['prod'] ?? "";
$split_data = explode(':', $split);
$kleur = $split_data[1];
$prijsje = $split_data[0];

$tijd = strtotime("-1 hour", time());
$clean = array(':time' => $tijd);
$db->delete("bestelling", "datum <= :time AND status < 1", $clean);
if ($kleur) {
	if ($prod) {
		$bprod = array(':pid' => $prod);
		$amount = $db->select('stock', 'pid=:pid', '', $bprod, 'fetch', '*', '', 'naam ASC');
	} else {
		$bkleur = array(':kleur' => $kleur);
		$amount = $db->select('stock', 'naam=:kleur', '', $bkleur, 'fetch', '*', '', 'naam ASC');
	}
	$tot = $amount['stock'] ?? "-1";
	switch ($tot) {
		case "0":
			$tot = 10;
			$bestel = "<li>This product is out of stock</li><li>This product can be ordered</li><li>Order can be delayed up to 15 days before it is back in stock</li>";
			echo "<select id='qty' name='qty'>";
			$hoeveel = "1";
			while ($hoeveel <= $tot) {
				echo "<option value='$hoeveel'>$hoeveel</option>";
				$hoeveel++;
			}
			echo "</select>$bestel";
			break;

		case '-1':
			echo "<li>This product is out of order, please choose a other product</li>";
			break;
		default:
			$bam = array(':kleur' => $amount['naam'], ':pid' => $amount['pid']);
			$count = $db->select('bestelling', 'pid = :pid AND kleur=:kleur AND status = 0', '', $bam);
			$total = '0';
			foreach ($count as $info) {
				$total += $info['qty'];
			}
			$end = ($tot - $total);
			switch ($end) {
				case "0":
					echo "<li>Some one just ordered the last one</li><li>in 1 hour will it be back avaible if not ordered</li>";
					break;

				default:
					echo "<select id='qty' name='qty'>";
					for ($a = 1; $a <= $end; $a++) {
						echo "<option value='$a'>$a</option>";
					}
					echo "</select><li>Product is avaible</li><li>We can ship this product today</li>";
					break;
			}
	}
?>
<script>
function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
}
$(document).ready(function() {
    let prijsje = <?php echo $prijsje ?>;
    let dat = $('#qty').val();
    let disc = $('#disc').text();
    let free = Math.round(($('#clcheck').val() * dat) * 100) / 100;
    let prijs = Math.round(((parseFloat($('#check').val()) + parseFloat(prijsje)) * dat) * 100) / 100;
    let clouds = Math.round((parseFloat($('#check').val()) + parseFloat(prijsje)) * dat);
    let bonus = Math.round((prijs / 100) * disc);
    let tot = Math.round(clouds + bonus);
    $('#clouds').html(clouds);
    $('#bon').html(tot);
    $('#prijs').html(prijs);
    $('#free').html(free);

    //clouds en prijs update
    $('#qty').on('change', function() { //begin Rating Waarde
        let prijsje = <?php echo $prijsje ?>;
        let dat = $('#qty').val();
        let disc = $('#disc').text();
        let free = Math.round(($('#clcheck').val() * dat) * 100) / 100;
        let prijs = Math.round(((parseFloat($('#check').val()) + parseFloat(prijsje)) * dat) * 100) /
            100;
        let clouds = Math.round((parseFloat($('#check').val()) + parseFloat(prijsje)) * dat);
        let bonus = Math.round((prijs / 100) * disc);
        let tot = Math.round(clouds + bonus);
        $('#clouds').html(clouds);
        $('#bon').html(tot);
        $('#prijs').html(prijs);
        $('#free').html(free);
    });

}); //einde document Ready	
</script>
<?php
}
?>