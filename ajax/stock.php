<?php
$db = new Db;
$kleur = $_POST['kleur'] ?? "";
$prod = $_POST['prod'] ?? "";

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
$(document).ready(function() {
    //clouds en prijs update
    $('#qty').on('change', function() { //begin Rating Waarde
        var dat = $('#qty').val();
        var disc = $('#disc').text();
        var free = Math.round(($('#clcheck').val() * dat) * 100) / 100;
        var prijs = Math.round(($('#check').val() * dat) * 100) / 100;
        var clouds = Math.floor($('#check').val() * dat);
        var bonus = Math.floor((prijs / 100) * disc);
        var tot = clouds + bonus;
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