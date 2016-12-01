<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/paymentwall.php");

$split_data = explode(':', $_POST[ship]);
$extra = $split_data[1];
$ship = $split_data[0];

$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status = '0'");
$stmt->execute(array(':pid' => $_SESSION[rand]));
$adress = $db->prepare("SELECT * FROM gebruikers WHERE id = :pid");
$adress->execute(array(':pid' => $_SESSION['id']));
$location = $adress->fetch(PDO::FETCH_ASSOC);
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
$coordinates1 = get_coordinates('Nispen', 'Antwerpseweg 101', '4709','nl');
$coordinates2 = get_coordinates($location[gemeente],$location[adress].' '.$location[nummer], $location[postcode],$location[land]);
if ( !$coordinates1 || !$coordinates2 )
{
	echo var_dump($coordinates2);
   $totprice = '0';
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
endif;
	}
?>

<div class='alert alert-info'> Danku voor uw bestelling Nummer <font color='red'><?php echo $_SESSION[rand] ?></font></div>
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
	$counter = '1';
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
	$stmt3 = $db->prepare("UPDATE stock SET stock = stock - :stock WHERE pid = :pid AND naam = :kleur AND stock >'0' " );
	$stmt3->execute(array(
	':pid' => $item[pid],
	':kleur' => $item[kleur],
	':stock' => $item[stock]));	
	$prijs += $item['prijs'];
	$clo += $item['qty'] * $clknop['prijs'];
	$clouds += $item[clouds];
	$counter++;
	}
	?>
	</tbody>
</table>
<?php
//verzending switch
switch ($ship){
 case 'Afhaal':
 $shipping = "Danku voor uw bestelling , u kan uw bestelling nu afhalen";
 break;
 case 'Post':
 $shipping = "Danku voor uw bestelling, Deze bestelling word zo snel mogelijk per post opgestuurt";
 break;
 case 'Express':
	if (date('H') < 14) {
	$shipping = "Danku voor uw bestelling <font color='yellow'>$_SESSION[rand]</font> , Deze bestelling word vandaag nog geleverd ";
	}
	else
	{
	$shipping = "Danku voor uw bestelling <font color='yellow'>$_SESSION[rand]</font> , Deze bestelling word Morgen na 14.00 uur geleverd";
	}
 break;
} 
//betaling switch
switch($_POST[pay]){
	case "Cash":
	$update = $db->prepare("UPDATE bestelling SET status = '1', levering = '$ship', betaling = 'Cash' WHERE bestel = :bestel ");
	if ($ship == "Express"){
	$tp = $prijs + ($extra * 1);
	$betaling = "u kan <font color='red'>&euro; $tp </font>Contant Betalen bij Levering<br>Gelieven deze nummer door te geven<br><pre>$_SESSION[rand]</pre>";
	}
	else
	{
	$betaling = "u kan <font color='red'>&euro; $prijs </font>in de winkel betalen met cash geld<br>Gelieven deze nummer mee te nemen<br><pre>$_SESSION[rand]</pre>";
	}
	break;
	case "Overschrijving":
	$update = $db->prepare("UPDATE bestelling SET status = '1', levering = '$ship', betaling = 'Overschrijving' WHERE bestel = :bestel ");
	$tp = $prijs + ($extra * 1);
	$betaling = "Gelieven exact <font color='red'> &euro; $tp </font> over te schrijven naar <br>
	<pre>
	IBAN: NL44 INGB 0005 1597 25
	BIC: INGBNL2A
	MEDEDELING: $_SESSION[rand]
	</pre> <br> dit kan een paar dagen duren voordat het bevestigt is";
	break;
	case 'Paymentwall':
	$update = $db->prepare("UPDATE bestelling SET status = '1', levering = '$ship', betaling = 'Paymentwall' WHERE bestel = :bestel ");
	$tp = $prijs + ($extra * 1);
	$extra += round((($tp / 100) * 10), 2);
	$extra += "0.50";
	$tp += round((($tp / 100) * 5), 2);
	$tp += "0.50";
	//paymentwall
	Paymentwall_Config::getInstance()->set(array(
    'api_type' => Paymentwall_Config::API_GOODS,
    'public_key' => '', //PAymentwal Public Key
    'private_key' => '' //Paymentwall Private Key
	));
$widget = new Paymentwall_Widget(
    $_SESSION[rand],   // id of the end-user who's making the payment
    'm2_1',        // widget code, e.g. p1; can be picked inside of your merchant account
    array(         // product details for Flexible Widget Call. To let users select the product on Paymentwall's end, leave this array empty
        new Paymentwall_Product(
            $_SESSION[rand],                           // id of the product in your system
            $tp,                                   // price
            'EUR',                                  // currency code
            'Vaporama bestelling '.$_SESSION[rand].'',                      // product name
            Paymentwall_Product::TYPE_FIXED // this is a time-based product; for one-time products, use Paymentwall_Product::TYPE_FIXED and omit the following 3 array elements
			// 1,                                      // duration is 1
            //Paymentwall_Product::PERIOD_TYPE_MONTH, //               month
            //true                                    // recurring
        )
    )
    //array('email' => 'user@hostname.com')           // additional parameters
);
//paymentwall
	$betaling = "<div class='alert alert-danger'>Paymentwall is aan het laden , Gelieven even te wachten</div>".$widget->getHtmlCode()."";
	break;
	case 'Clouds':
	$update = $db->prepare("UPDATE bestelling SET status = '2', levering = '$ship', betaling = 'Clouds' WHERE bestel = :bestel ");
	$setclouds = $db->prepare("UPDATE gebruikers SET punten = punten - :clouds WHERE id = :user ");
	$setclouds->execute(array(':clouds' => $clouds,':user' => $location[id]));
	$betaling = "Dit product is besteld voor $clouds <i class='material-icons'>filter_drama</i><br><br>Gelieven deze nummer mee te nemen voor het afhalen<br><pre>$_SESSION[rand]</pre>";
	$clouds = $clo;
	break;
}
$update->execute(array(':bestel' => $_SESSION[rand]));
if (!filter_var($location[naam], FILTER_VALIDATE_EMAIL) === false) {
mail_test($_SESSION[rand],'1',$location[naam]);
}
mail_test($_SESSION[rand]);
unset($_SESSION['rand']);
?>
<div class='alert alert-warning text-center'> Totale prijs voor deze bestelling is &euro; <?php echo ($prijs + ($extra * 1)) ?> waarvan &euro;<?php echo ($extra * 1)?> Leverings Kosten</div>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading"><?php echo $shipping ?></div>
      <div class="panel-body"><?php echo $betaling ?></div>
    </div>
  </div>