<?php
require(getenv("DOCUMENT_ROOT")."/functions/include.php");
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
switch($_POST['confirm'])
{
	case "image":
		$id = $_POST['id'];
		$stmt = $db->prepare("DELETE FROM images WHERE id =:id");
		$stmt->execute(array(':id' => $id));
	$_SESSION[ERROR] = "Afbeelding $id successvol verwijderd";	
break;
	case "product":
		$id = $_POST['id'];
		$db->beginTransaction();	
			$stmt = $db->prepare("DELETE FROM stock WHERE pid =:id");
			$stmt->execute(array(':id' => $id));	
			$stmt = $db->prepare("DELETE FROM products WHERE id =:id");
			$stmt->execute(array(':id' => $id));
			$stmt = $db->prepare("DELETE FROM bestelling WHERE pid =:id");
			$stmt->execute(array(':id' => $id));
			$stmt = $db->prepare("DELETE FROM images WHERE pid =:id");
			$stmt->execute(array(':id' => $id));
			$stmt = $db->prepare("DELETE FROM rating WHERE pid =:id");
			$stmt->execute(array(':id' => $id));
		$db->commit();	
	$_SESSION[ERROR] = "Product $id successvol verwijderd";	
break;
	case "rating":
		$id = $_POST['id'];
		$stmt = $db->prepare("DELETE FROM rating WHERE pid =:id");
		$stmt->execute(array(':id' => $id));
	$_SESSION[ERROR] = "Rating van Product ID $id is terug op 0";	
break;
	case "stock":
		$id = $_POST['id'];
		$stmt = $db->prepare("DELETE FROM stock WHERE id =:id");
		$stmt->execute(array(':id' => $id));

	$_SESSION[ERROR] = "Stock ID $id is verwijderd";	
break;
case "shopcart":
	$id = $_POST['id'];
	try{
	$stmt = $db->prepare("DELETE FROM bestelling WHERE id =:id");
	$stmt->execute(array(':id' => $id));
	}
	catch(Exception $e) {
    echo '<h2><font color=red>';
    var_dump($e->getMessage());
	die ('</h2></font> ');
	}	
	$_SESSION[ERROR] = "Product id $id is uit bestel lijst verwijderd";	
break;
}	
?>
<script>
function werkbij(val,dat) {
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
</script>
<?php
switch($_POST['groep'])
{
case "image":
?>
	<table border=1 class="table table-striped table-bordered table-hover">
	<thead>
	<tr>
    <th><center>verwijder Afbeelding <font color='red'>id <?php echo $_POST['waarde'];?></font></center></th>
	</tr>
	</thead>
	<tbody>	
	<tr class='info'>
	<td><center><button TYPE="submit" class='btn btn-danger' VALUE="delete" id="<?php echo $_POST['waarde']; ?>" onclick="werkbij(this.id,'image');"><i class='material-icons' title='verwijder' aria-hidden='true'>delete_forever</i><span class="sr-only">verwijder</span></button></center></td>
	</tr>
	</tbody>
	</table>
	<br>
<?php	
break;
case "product":
?>
	<table border=1 class="table table-striped table-bordered table-hover">
	<thead>
	<tr>
    <th><center>verwijder Product <font color='red'>id <?php echo $_POST['waarde'];?></font></center></th>
	</tr>
	</thead>
	<tbody>	
	<tr class='info'>
	<td><center><button TYPE="submit" class='btn btn-danger' VALUE="delete" id="<?php echo $_POST['waarde']; ?>" onclick="werkbij(this.id,'product');"><i class='material-icons' title='verwijder' aria-hidden='true'>delete_forever</i><span class="sr-only">verwijder</span></button></center></td>
	</tr>
	</tbody>
	</table>
	<br>
<?php	
break;
case "rating":
?>
	<table border=1 class="table table-striped table-bordered table-hover">
	<thead>
	<tr>
    <th><center>Reset Rating van Product ID <font color='red'>id <?php echo $_POST['waarde'];?></font> naar 0</center></th>
	</tr>
	</thead>
	<tbody>	
	<tr class='info'>
	<td><center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $_POST['waarde']; ?>" onclick="werkbij(this.id,'rating');"><i class='material-icons' title='Reset' aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center></td>
	</tr>
	</tbody>
	</table>
	<br>
<?php	
break;
case "stock":
?>
	<table border=1 class="table table-striped table-bordered table-hover">
	<thead>
	<tr>
    <th><center>Bevestig verwijdering van stock <font color='red'>id <?php echo $_POST['waarde'];?></font></center></th>
	</tr>
	</thead>
	<tbody>	
	<tr class='info'>
	<td><center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $_POST['waarde']; ?>" onclick="werkbij(this.id,'stock');"><i class='material-icons' title='Reset' aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center></td>
	</tr>
	</tbody>
	</table>
	<br>
<?php	
break;
}
?>