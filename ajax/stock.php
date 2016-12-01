<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
$tijd = strtotime("-1 hour", time());
$clean = $db->prepare("DELETE FROM bestelling WHERE datum <= :time AND status < '1'");
$clean->execute(array(':time' => $tijd));
if ($_POST[kleur] !=""){
if ($_POST[prod] != ""){
$stock = $db->prepare("SELECT * FROM stock WHERE pid = :stock ORDER BY naam");
$stock->execute(array(':stock' => $_POST[prod]));
}
else
{
	$stock = $db->prepare("SELECT * FROM stock WHERE naam = :stock ORDER BY naam");
	$stock->execute(array(':stock' => $_POST[kleur]));
}
$amount = $stock->fetch(PDO::FETCH_ASSOC);
$tot = $amount[stock];
switch($tot){
case "0":
	$liquid = $db->prepare("SELECT * FROM products WHERE id = :liq");
	$liquid->execute(array(':liq' => $amount[pid]));
	$vloeistoff = $liquid->fetch(PDO::FETCH_ASSOC);
	$hoeveel = ($vloeistoff[cat] == 'LIQUIDS')?"3":"1";
$tot = 10;
$bestel = "<li>Dit product is niet op voorraad</li><li>Dit product kan besteld worden</li><li>Bestellingen kunnen tot 5 dagen duren voor het beschikbaar is</li>";
echo "<select id='qty' name='qty'>";
while ($hoeveel <= $tot)
	{
	echo "<option value='$hoeveel'>$hoeveel</option>";
	$hoeveel++;
	}
echo "</select>$bestel";
break;

case '-1':
echo "<li>Dit product is niet meer Leverbaar</li>";
break;

default:
$check = $db->prepare("SELECT * FROM bestelling WHERE pid = :stock AND kleur = :kleur AND status = '0'");
$check->execute(array(':stock' => $amount[pid],
':kleur' => $amount[naam]));
$count = $check->fetchall(PDO::FETCH_ASSOC);
foreach ($count AS $info)
		{
			$total += $info[qty];
		}
$end = ($tot - $total);
	switch($end)
	{
	case "0":
		echo "<li>De laatste stuks zitten in een winkelmandje </li><li>Over een uurtje is het terug beschikbaar indien niet besteld</li>";
		break;

	default:
		echo "<select id='qty' name='qty'>";
		for ($a=1;$a <= $end;$a++)
		{
		echo "<option value='$a'>$a</option>";
		}
		echo "</select><li>We hebben Dit product op voorraad</li><li>Dit kan direct Geleverd worden</li>";
	break;
	}
}		
?>
<script>
$(document).ready(function(){
				//clouds en prijs update
		        $('#qty').on('change', function() { //begin Rating Waarde
			var dat = $('#qty').val();
			var disc = $('#disc').text();
			var free = Math.round(($('#clcheck').val() * dat) * 100) / 100;
			var prijs = Math.round(($('#check').val() * dat) * 100) / 100;
			var clouds = Math.floor($('#check').val() * dat);
			var bonus = Math.floor((prijs / 100) * disc) ;
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