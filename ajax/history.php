<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status > '0'");
$stmt->execute(array(':pid' => $_POST[bestelling]));
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
$adress = $db->prepare("SELECT * FROM gebruikers WHERE id = :pid");
$adress->execute(array(':pid' => $_SESSION['id']));
$location = $adress->fetch(PDO::FETCH_ASSOC);
$coordinates1 = get_coordinates('Nispen', 'Antwerpseweg 101', '4709','nl');
$coordinates2 = get_coordinates($location[gemeente],$location[adress].' '.$location[nummer], $location[postcode],$location[land]);
if ( !$coordinates1 || !$coordinates2 )
{
   $totprice = '0';
}
else
{
    $dist = GetDrivingDistance($coordinates1['lat'], $coordinates2['lat'], $coordinates1['long'], $coordinates2['long']);
	$split_data = explode(' ', $dist[distance]);
	$dis = $split_data[0];
	$dis = str_replace(".","",$dis);
	if ($dis < '50'):
    $totprice = '15';
	elseif ($dis < '100'):
    $totprice = '35';
	elseif ($dis < '150'):
    $totprice = '50';
	else:
	$totprice = '0';
endif;
	}
	
if (u()){
?>
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
	$prijs = "0";
	foreach ($result as $item)
	{
		switch ($item[levering])
		{
			case 'Express':
			break;
			case 'Post':
			$totprice = 5.00;
			break;
			default:
			$totprice = 0.00;
			break;
		}	
$stmt2 = $db->prepare("SELECT * FROM products WHERE id = :pid");
$stmt2->execute(array(':pid' => $item[pid]));
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);	
		echo"
		<tr>
			<td style='width:40%'>
			{$result2[name]}
			</td>
			<td style='width:10%'>
			{$item[kleur]}
			</td>
			<td style='width:10%'>
			{$item[qty]}
			</td>
			<td style='width:20%'>
			&euro; {$item[prijs]}
			</td>
			<td style='width:20%'>
			{$item[clouds]} <i class='material-icons'>filter_drama</i>
			</td>
		</tr>
		";
	$prijs += $item[prijs] ;
	$clouds += $item[clouds]; 
	}
	$tot = ($prijs + $totprice)
	?>
	</tbody>
</table>
<div class='alert alert-info text-center'> Totaal bedrag van &euro; <?php echo $tot ?> is goed voor <?php echo $clouds ?> <i class='material-icons'>filter_drama</i><br>Levering kosten zijn &euro; <?php echo $totprice;?> </div>
<?php
	switch($_POST[history])
	{
		case 'history':
		break;
	case 'status':
		$stmt2 = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status = '1' ");
		$stmt2->execute(array(':pid' => $_POST[bestelling]));
		$status = $stmt2->fetch(PDO::FETCH_ASSOC);
		switch($status[betaling]){
		case "Cash":
		if ($status[levering] == "Express"){
		$betaling = "<div class='alert alert-success'> u kan <font color='red'>&euro; $tot </font>Contant Betalen bij Levering<br>Gelieven deze nummer door te geven<br><pre>$_POST[bestelling]</pre></div>";
		}
		else
		{
		$betaling = "<div class='alert alert-success'>u kan <font color='red'>&euro; $tot </font>in de winkel betalen met cash geld<br>Gelieven deze nummer mee te nemen<br><pre>$_POST[bestelling]</pre></div>";
		}
		break;
		case "Overschrijving":
		$betaling = "<div class='alert alert-success'>Gelieven exact <font color='red'> &euro; $tot </font> over te schrijven naar <br>
		<pre>
		IBAN: NL44 INGB 0005 1597 25
		BIC: INGBNL2A
		MEDEDELING: $_POST[bestelling]
		</pre> <br> dit kan een paar dagen duren voordat het bevestigt is</div>";
		break;
		case 'Paymentwall':
		$betaling = "<div class='alert alert-success'>Nog niet beschikbaar</div>";
		break;
		}
		break;
		}
	echo $betaling;
	}
else
{
	echo "inloggen aub";
}
?>