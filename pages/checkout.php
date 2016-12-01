<?php
require (getenv("DOCUMENT_ROOT")."/functions/include.php");
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
		if ($_SESSION[ERROR] != "")
		{	
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}
$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status = '0'");
$stmt->execute(array(':pid' => $_SESSION[rand]));
$adress = $db->prepare("SELECT * FROM gebruikers WHERE id = :pid");
$adress->execute(array(':pid' => $_SESSION['id']));
$location = $adress->fetch(PDO::FETCH_ASSOC);
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
$coordinates1 = get_coordinates('Nispen', 'Antwerpseweg 101', '4709','nl');
$coordinates2 = get_coordinates($location[gemeente],''.$location[adress].' '.$location[nummer].'', $location[postcode],$location[land]);
if ( !$coordinates1 || !$coordinates2 )
{
   $totprice = '0';
   echo "<pre>Wij kunnen uw adress niet verifieren, Kijk in profiel na of alles Correct is ingevuld</pre>";
}
else
{
    $dist = GetDrivingDistance($coordinates1['lat'], $coordinates2['lat'], $coordinates1['long'], $coordinates2['long']);
	$split_data = explode(' ', $dist[distance]);
	$dis = $split_data[0];
	$dis = str_replace(".","",$dis);
	$dis = explode(',', $dis);
	if ($dis[0] <= '50'):
    $totprice = '15';
	elseif ($dis[0] <= '100'):
    $totprice = '35';
	elseif ($dis[0] <= '150'):
    $totprice = '50';
	else:
	$totprice = '0';
	echo "<pre>$dis</pre>";
endif;
	}

if (u()){
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
	foreach ($result as $item)
	{
$stmt2 = $db->prepare("SELECT * FROM products WHERE id = :pid");
$stmt2->execute(array(':pid' => $item[pid]));
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$cl = $db->prepare("SELECT * FROM bonus WHERE pid = :pid AND datum > :tm");
$cl->execute(array(':pid' => $item[pid],':tm' => time(),));
$clknop = $cl->fetch(PDO::FETCH_ASSOC);	
		echo"
				<tr>
			<td style='width:40%'>
			{$result2[name]} <a href='#' id='$item[id]' onclick=\"remove(this.id,'shopcart','{$result2[name]}');\"><span class='glyphicon glyphicon-remove'></span></a>
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
	$prijs += $item['prijs'];
	$clouds += $item['qty'] * $clknop['prijs'];
	$t++;
	}
	?>
	</tbody>
</table>
<div class='row'>
<div class='col-md-6'>
Selecteer Levering:
<select id='shipping' name='shipping'>
<option value='Afhaal:0'>AfHalen</option>
<?php if (($prijs >= '75') AND ($totprice > '1')) {?>
<option value='Express:<?php echo $totprice ?>'>Express Levering voor <?php echo $dist[distance].'  (+ &euro;'.$totprice ?>)  </option>
<?php } ?>
<option value='Post:10'>Post ( + &euro; 10) </option>
</select>
</div>
<div class="col-md-6">
Selecteer Betaling:
<select id='pay' name='pay'>
<option value='Cash'>Cash (afhaal/express)</option>
<option value='Overschrijving'>Overschrijving</option>
<option value='Paymentwall'>Andere ( 10% + &euro; 0.5 extra)</option>
<?php echo (($t == "1") AND ($location[punten] >= $clouds) AND ($clouds > '0') )?"<option value='Clouds' style='background-color: silver'>Betaal met Clouds</option>":""; ?>
</select>
</div>
</div>
<br>
<?php echo ($prijs > "0")?"<a href='#' id='bestel' class='btn btn-success btn-block bestel'>Bestel Nu voor &euro; <prijs id='total'>$prijs</prijs></a>":"<div class='alert alert-info text-center'>Gelieven eerst iets toe te voegen om te bestellen</div>"; ?>
<?php echo ($clouds > "0")?"<a href='#' id='clouds' class='btn btn-info btn-block clouds'>Bestel Nu voor $clouds <i class='material-icons'>filter_drama</i></a>":""; ?>
<?php if ($prijs < '75'){ ?>
<div class="shoping">
	 <div class="container">
		 <div class="shpng-grids">
			 <div class="col-md-12 shpng-grid">
				 <h3>Voor 14.00 uur besteld ? Zelfde Dag in huis</h3>
				 <p>Bestel boven &euro; 75 voor Express Levering optie</p>
			 </div>
			 <div class="clearfix"></div>
		 </div>
	 </div>
</div>
<?php } ?>
</div>
<script>
function remove(val,dat,name) {
	if (confirm('Bent u zeker dat u product '+name+' Wilt verwijderen uit Shoppingcart ?')){
	{
	$.ajax({
	type: "POST",
	url: "../ajax/remove.php",
	data:'confirm='+dat+'&id='+val,
	success: function(data){
	//alert(dat+" Succesvol uitgevoerd");
	window.location.reload();
	}
	});
}
}
}
function bestel(val,dat,pay) {

}
$(document).ready(function(){
//Bestel Bevestigen
		$('#bestel').on('click', function() { 
			var dat = $('#shipping').val();
			var pay = $('#pay').val();
			if (( dat == "Post:10" ) && ( pay == "Cash"))
			{
				alert('Sorr maar Cash by Verzending gaat niet');
				return false;
			}
			else if (( dat == "Express:<?php echo $totprice?>" ) && ( pay == "Overschrijving"))
			{
				alert('Sorr maar Cash by Verzending gaat niet');
				return false;
			}
			else{
			if ((dat == "Post:10") && ('<?php echo $location[land] ?>' == 'be'))
			{
			alert('Dit geld aleen voor in belgie\n\nBpost heeft ons Bevestigt dat het mogelijk is om te versturen Binnen Belgie\nDe wet van belgie is ingewikkeld\n\nWij zijn NIET aansprakelijk mocht het NIET aankomen')
			}				
			if(confirm('Bent u zeker dat u dit wilt bestellen ? ')){

			$.ajax({
			type: "POST",
			url: "../ajax/bestel.php",
			data:'confirm=bestel&ship='+dat+'&pay='+pay,
			success: function(data){
			 $('#success').html(data);
			}
			});
			}
			}
		});	
		
				$('#clouds').on('click', function() { 
			var dat = $('#shipping').val();
			var pay = $('#pay').val();
			if (( dat == "Afhaal:0" ) && ( pay == "Clouds"))
			{			
			if(confirm('Bent u zeker dat u dit wilt met Clouds ')){

			$.ajax({
			type: "POST",
			url: "../ajax/bestel.php",
			data:'confirm=bestel&ship='+dat+'&pay='+pay,
			success: function(data){
			 $('#success').html(data);
			}
			});
			}
			}
			else
			{
			alert('Selecteer Clouds om met Clouds te betalen\nOptie is niet zichtbaar bij\n\nmeer dan 1 product\nNiet genoeg Clouds\n\nAfhalen Verplicht');
				return false;	
			}
		});

		$('#shipping').on('change', function() {			
			var prijs = <?php echo $prijs ?>;
			var dat = $('#shipping').val();
			var arr = dat.split(':');
			var ship = (arr[1] * 1 );
			var tot = prijs + ship;
			 $('#total').html(tot);
			});			
				
}); //einde document Ready
</script>
<?
}
else
{
	echo "inloggen aub";
}
?>