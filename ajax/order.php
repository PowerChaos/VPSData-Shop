<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status > '0' ");
$stmt->execute(array(':pid' => $_POST[bestelling]));
$user = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status > '0' ");
$user->execute(array(':pid' => $_POST[bestelling]));
$uid = $user->fetch(PDO::FETCH_ASSOC);
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
$adress = $db->prepare("SELECT * FROM gebruikers WHERE id = :pid");
$adress->execute(array(':pid' => $uid[uid]));
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
	
if (a()){
switch($_POST[history])
	{
	case '1':
		$update = $db->prepare("UPDATE bestelling SET status = '2' WHERE bestel = :bestel ");
		$setclouds = $db->prepare("UPDATE gebruikers SET punten = punten + :clouds WHERE id = :user ");
		$betaling = "<div class='alert'>status aangepast naar<br><pre>Betaald - Wachten op Levering</pre></div>";
		$update->execute(array(':bestel' => $_POST[bestelling]));
		$clouds = '0';
		foreach ($result as $item)
		{
		$clouds += $item[clouds];
		}
		$setclouds->execute(array(':clouds' => $clouds,':user' => $location[id]));			
		echo $betaling;
		if (!filter_var($location[naam], FILTER_VALIDATE_EMAIL) === false) {
		mail_test($_POST[bestelling],'2',$location[naam]);
		}
	break;
	case '2':
		$update = $db->prepare("UPDATE bestelling SET status = '3' WHERE bestel = :bestel ");
		$betaling = "<div class='alert'>status aangepast naar<br><pre>Betaald en afgeleverd - Alles in orde</pre></div>";
		$update->execute(array(':bestel' => $_POST[bestelling]));	
		echo $betaling;
		if (!filter_var($location[naam], FILTER_VALIDATE_EMAIL) === false) {
		mail_test($_POST[bestelling],'3',$location[naam]);
		}
	break;
	case '3':
		$update = $db->prepare("DELETE FROM bestelling WHERE bestel = :bestel ");
		$betaling = "<div class='alert'>Bestelling is verwijderd , Gelieve stock manueel aan te passen</div>";
		$update->execute(array(':bestel' => $_POST[bestelling]));
		echo $betaling;	
	break;
	default: ?>
	<!-- Klant info -->
					<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label for="user">Gebruikersnaam of E-mail:</label>
													<input type="text" class="form-control" readonly value="<?php echo $location[naam] ?>" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-8 col-sm-8">
												<label for="tel">Telefoonnummer</label>
													<input class="form-control" readonly value="<?php echo $location[tel] ?>">
											</div>
											<div class="col-md-4 col-sm-4">
												<label for="birth">Geboorte Datum</label>
													<input class="form-control" readonly value="<?php echo $location[birth]?>">
											</div>
										</div>
									</div>		
									<hr />
									<div class="row">
										<div class="form-group">
												<div class="col-md-6 col-sm-6">
												<label for="vn">Voornaam</label>
													<input class="form-control" readonly value="<?php echo $location[voornaam] ?>">
											</div>
											<div class="col-md-6 col-sm-6">
												<label for="an">Achternaam</label>
													<input class="form-control" readonly value="<?php echo $location[achternaam] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-7 col-sm-7">
												<label for="adress">Adres</label>
													<input class="form-control" readonly value="<?php echo $location[adress] ?>">
											</div>
											<div class="col-md-3 col-sm-3">
												<label for="number">Nummer</label>
													<input class="form-control" readonly value="<?php echo $location[nummer] ?>">
											</div>
											<div class="col-md-2 col-sm-2">
												<label for="bus">Bus</label>
													<input class="form-control" readonly value="<?php echo $location[bus] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-md-4 col-sm-4">
												<label for="postcode">Postcode</label>
													<input class="form-control" readonly value="<?php echo $location[postcode] ?>">
											</div>
											<div class="col-md-8 col-sm-8">
												<label for="gemeente">Gemeente</label>
													<input class="form-control" readonly value="<?php echo $location[gemeente] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-md-12 col-sm-12">
												<label for="postcode">Afstand vanaf Winkel</label>
													<input class="form-control" readonly value="<?php echo $dist[distance] ?>">
											</div>
										</div>
									</div>
									
			 </div>
<!-- klant info einde -->


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
	break;
	}
	}
else
{
	echo "inloggen aub";
}
?>