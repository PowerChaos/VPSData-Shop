<?php
require_once(getenv("DOCUMENT_ROOT") . "/inc/include.php");
$perm = new Gebruikers;
$db = new Db;
$post = new Post;
$bestelling = $_POST['bestelling'];
$bes = array(':bestel' => $bestelling);
$result = $db->select('bestelling', 'bestel = :bestel AND status > 0', '', $bes);

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
					3D Points
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$prijs = "0";
			switch ($result[0]['levering']) {
				case 'Express':
					break;
				case 'Post':
					$totprice = 5.00;
					break;
				default:
					$totprice = 0.00;
					break;
			}
			foreach ($result as $item) {
				$name = $db->select('products', 'id = :bestel', '', $bes, 'fetch');
				echo "
		<tr>
			<td style='width:40%'>
			{$name['name']}
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
				$prijs += $item[prijs];
				$clouds += $item[clouds];
			}
			$tot = ($prijs + $totprice)
			?>
		</tbody>
	</table>
	<div class='alert alert-info text-center'> Total amount of &euro; <?php echo $tot ?> will reward you <?php echo $clouds ?> <i class='material-icons'>3d_rotation</i><br>Delivery costs are &euro; <?php echo $totprice; ?> </div>
<?php
	switch ($_POST[history]) {
		case 'history':
			break;
		case 'status':
			$status = $db->select('bestelling', 'bestel = :bestel AND status > 1', '', $bes, 'fetch');
			switch ($status['betaling']) {
				case "Cash":
					$betaling = "<div class='alert alert-success'>u kan <font color='red'>&euro; $tot </font>in de winkel betalen met cash geld<br>Gelieven deze nummer mee te nemen<br><pre>$bestelling</pre></div>";
					break;
				case "Overschrijving":
					$betaling = "<div class='alert alert-success'>Gelieven exact <font color='red'> &euro; $tot </font> over te schrijven naar <br>
		<pre>
		IBAN: NL44 INGB 0005 1597 25
		BIC: INGBNL2A
		MEDEDELING: $bestelling
		</pre> <br> dit kan een paar dagen duren voordat het bevestigt is</div>";
					break;
				case 'Paypal':
					$betaling = "<div class='alert alert-success'>Nog niet beschikbaar</div>";
					break;
			}
			break;
	}
	echo $betaling;
} else {
	echo "Please login first before you can see history :D";
}
?>