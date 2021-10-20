<?php
$perm = new Gebruikers;
$db = new Db;
$mail = new email;
$bestelling = $_POST['bestelling'] ?? "";
$bes = array(':bestel' => $bestelling);
$result = $db->select('bestelling', 'bestel = :bestel AND status > 0', '', $bes);
$uid = $result[0]['uid'];
$user = array(':user' => $uid);
$getuser = $db->select('gebruikers', 'id = :user', '', $user, 'fetch');

if ($perm->check('admin')) {
    switch ($_POST['history']) {
        case '1':
            $points = $getuser['punten'];
            foreach ($result as $count) {
                $points += $count['clouds'];
            }
            $pointsupdate = array("punten" => $points);
            $db->update("gebruikers", $pointsupdate, "id =:user", $user);
            $status = array("status" => "2");
            $db->update('bestelling', $status, 'bestel = :bestel', $bes);
            $betaling = "<div class='alert'>status aangepast naar<br><pre>Betaald - Wachten op Levering</pre></div>";
            $mail->send($bestelling, '2', $getuser['naam']);
            break;
        case '2':
            $status = array("status" => "3");
            $db->update('bestelling', $status, 'bestel = :bestel', $bes);
            $betaling = "<div class='alert'>status aangepast naar<br><pre>Betaald en afgeleverd - Alles in orde</pre></div>";
            $mail->send($bestelling, '3', $getuser['naam']);
            break;
        case 'delete':
            $db->delete('bestelling', 'bestel = :bestel AND status = 1', $bes);
            $betaling = "<div class='alert'>Bestelling is verwijderd , Gelieve stock manueel aan te passen</div>";
            break;
        default: ?>
<!-- Klant info -->
<div class="row">
    <div class="form-group">
        <div class="col-md-6 col-sm-6">
            <label for="user">Gebruikersnaam of E-mail:</label>
            <input type="text" class="form-control" readonly value="<?php echo $getuser['naam'] ?>">
        </div>
        <div class="col-md-6 col-sm-6">
            <label for="tel">Telefoonnummer</label>
            <input class="form-control" readonly value="<?php echo $getuser['phone'] ?>">
        </div>
    </div>
</div>
<hr />
<div class="row">
    <div class="form-group">
        <div class="col-md-6 col-sm-6">
            <label for="vn">Voornaam</label>
            <input class="form-control" readonly value="<?php echo $getuser['voornaam'] ?>">
        </div>
        <div class="col-md-6 col-sm-6">
            <label for="an">Achternaam</label>
            <input class="form-control" readonly value="<?php echo $getuser['achternaam'] ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <div class="col-md-7 col-sm-7">
            <label for="adress">Adres</label>
            <input class="form-control" readonly value="<?php echo $getuser['adress'] ?>">
        </div>
        <div class="col-md-3 col-sm-3">
            <label for="number">Nummer</label>
            <input class="form-control" readonly value="<?php echo $getuser['nummer'] ?>">
        </div>
        <div class="col-md-2 col-sm-2">
            <label for="bus">Bus</label>
            <input class="form-control" readonly value="<?php echo $getuser['bus'] ?? "n/a" ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <div class="col-md-4 col-sm-4">
            <label for="postcode">Postcode</label>
            <input class="form-control" readonly value="<?php echo $getuser['postcode'] ?>">
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="gemeente">Gemeente</label>
            <input class="form-control" readonly value="<?php echo $getuser['gemeente'] ?>">
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="postcode">Land</label>
            <input class="form-control" readonly value="<?php echo $getuser['land'] ?>">
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
                    $clouds = "0";
                    $leverkosten = $result[0]['leverkosten'];
                    $betaalkosten = $result[0]['betaalkosten'];
                    foreach ($result as $item) {
                        $pid = array(':pid' => $item['pid']);
                        $name = $db->select('products', 'id = :pid', '', $pid, 'fetch');
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
                        $prijs += $item['prijs'];
                        $clouds += $item['clouds'];
                    }
                    $tot = ($prijs + $leverkosten + $betaalkosten)
                    ?>
    </tbody>
</table>
<div class='alert alert-info text-center'> Total amount of &euro; <?php echo $tot ?> will reward you
    <?php echo $clouds ?> <i class='material-icons'>3d_rotation</i><br>Delivery costs of &euro;
    <?php echo $leverkosten; ?> and payment fee of &euro; <?php echo $betaalkosten ?></div>
<?php
            break;
    }
    echo $betaling ?? "";
} else {
    echo "inloggen aub";
}
?>