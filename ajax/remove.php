<?php
$db = new Db;
$session = new Session;
$id = $_POST['id'] ?? "";
$img = array(':id' => $id);
$confirm = $_POST['confirm'] ?? "";
switch ($confirm) {
	case "image":
		$db->delete('images', 'id=:id', $img);
		$session->flashdata('error', 'Afbeelding ' . $id . ' successvol verwijderd');
		break;
	case "product":
		$db->delete('stock', 'pid=:id', $img);
		$db->delete('products', 'id=:id', $img);
		$db->delete('bestelling', 'pid=:id', $img);
		$db->delete('images', 'pid=:id', $img);
		$db->delete('rating', 'pid=:id', $img);
		$session->flashdata('error', 'Product ' . $id . ' successvol verwijderd');
		break;
	case "rating":
		$db->delete('rating', 'pid=:id', $img);
		$session->flashdata('error', 'Product ' . $id . ' rating reset succesfull');
		break;
	case "stock":
		$db->delete('stock', 'id=:id', $img);
		$session->flashdata('error', 'stock  ' . $id . ' succesvol verwijderd');
		break;
	case "shopcart":
		$db->delete('bestelling', 'id=:id', $img);
		$session->flashdata('error', 'Product id ' . $id . ' is uit bestel lijst verwijderd');
		break;
}
?>
<script>
function werkbij(val, dat) {
    $.ajax({
        type: "POST",
        url: "../x/remove",
        data: 'confirm=' + dat + '&id=' + val,
        success: function(data) {
            //alert(dat+" Succesvol uitgevoerd");
            window.location.reload();
        }
    });
}
</script>
<?php
switch ($_POST['groep']) {
	case "image":
?>
<table border=1 class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <center>verwijder Afbeelding <font color='red'>id <?php echo $_POST['waarde']; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="delete" id="<?php echo $_POST['waarde']; ?>"
                        onclick="werkbij(this.id,'image');"><i class='material-icons' title='verwijder'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">verwijder</span></button>
                </center>
            </td>
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
            <th>
                <center>verwijder Product <font color='red'>id <?php echo $_POST['waarde']; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <?php if ($_POST['waarde'] != "1") {
						?>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="delete" id="<?php echo $_POST['waarde']; ?>"
                        onclick="werkbij(this.id,'product');"><i class='material-icons' title='verwijder'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">verwijder</span></button>
                </center>
                <?php
						} else {
							echo "<center>Not possible to delete first product, it give database errors</center>";
						}
						?>
            </td>
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
            <th>
                <center>Reset Rating van Product ID <font color='red'>id <?php echo $_POST['waarde']; ?>
                    </font> naar 0
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $_POST['waarde']; ?>"
                        onclick="werkbij(this.id,'rating');"><i class='material-icons' title='Reset'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center>
            </td>
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
            <th>
                <center>Bevestig verwijdering van stock <font color='red'>id
                        <?php echo $_POST['waarde']; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $_POST['waarde']; ?>"
                        onclick="werkbij(this.id,'stock');"><i class='material-icons' title='Reset'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center>
            </td>
        </tr>
    </tbody>
</table>
<br>
<?php
		break;
}
?>