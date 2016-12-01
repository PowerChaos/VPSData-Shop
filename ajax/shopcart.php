<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
require_once (getenv("DOCUMENT_ROOT")."/functions/database.php");
$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :pid AND status = '0'");
$stmt->execute(array(':pid' => $_SESSION[rand]));
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
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
	$count = "0";
	foreach ($result as $item)
	{
$stmt2 = $db->prepare("SELECT * FROM products WHERE id = :pid");
$stmt2->execute(array(':pid' => $item[pid]));
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);	
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
	$count++;	
	}
	?>
	</tbody>
</table>
<?php echo ($count >= '1')?"<a href='//$_SERVER[SERVER_NAME]/checkout' class='btn btn-success btn-block'>Bestel Nu</a>":"<div class='alert alert-info text-center'>Gelieven eerst iets toe te voegen om te bestellen</div>"; ?>
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
</script>
<?
}
else
{
	echo "inloggen aub";
}
?>