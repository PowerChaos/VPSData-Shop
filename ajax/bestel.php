<?php
$db = new Db;
$session = new Session;
$perm = new Gebruikers;
$order = $_POST['confirm'] ?? "";
$bestelling = $_POST['order'] ?? "";
if ($order == 'paypal') {
	$paypal = array(':bestel' => $bestelling);
	$paypalupdate = array("status" => "2");
	$db->update("bestelling", $paypalupdate, "bestel = :bestel", $paypal);
} elseif ($perm->check('user')) {

	$shipvalue = $_POST['ship'] ?? "";
	$payvalue = $_POST['pay'] ?? "";
	$rand = $session->get('rand');
	$user = $session->get('id');

	$split_data = explode(':', $shipvalue);
	$ship = $split_data[0]; // soort pay:amount
	$extra = $split_data[1]; //bedrag pay:amount

	$split_datapay = explode(':', $payvalue);
	$pay = $split_datapay[0]; // soort pay:amount
	$payam = $split_datapay[1]; // bedrag pay:amount

	$bbes = array(':bestel' => $rand);
	$result = $db->select('bestelling', 'bestel = :bestel AND status = 0', '', $bbes);
	$userbind = array(':id' => $user);
	$userdb = $db->select('gebruikers', 'uid = :id', '', $userbind, 'fetch');

?>

<div class='alert alert-info'> Thank you for ordering , your order number : <font color='red'><?php echo $rand ?></font>
</div>
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
                Points
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
			$prijs = '0';
			$clouds = '0';
			foreach ($result as $item) {
				$bpid = array(':pid' => $item['pid']);
				$result2 = $db->select('products', 'id = :pid', '', $bpid, 'fetch');
				$bbon = array(':pid' => $item['pid'], ':tm' => time());
				$clknop = $db->select('bonus', 'pid = :pid AND datum > :tm', '', $bbon, 'fetch');
				echo "
				<tr>
			<td style='width:40%'>
			{$result2['name']}
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
				$bind = array(":pid" => $item['pid'], ':kleur' => $item['kleur']);
				$stockfind = $db->select('stock', 'pid =:pid AND naam = :kleur', '', $bind, 'fetch');
				$stockcheck = $stockfind['stock'] - $item['qty'];
				$update = array("stock" => $stockcheck);
				$db->update("stock", $update, "pid =:pid AND naam = :kleur AND stock > 0", $bind);
				$prijs += $item['prijs'];
				$clouds += $item['clouds'];
			}
			?>
    </tbody>
</table>
<?php
	//verzending switch
	switch ($ship) {
		case 'Afhaal':
			$shipping = "Thank you for your order , you can now pick it up at our warenhouse";
			break;
		case 'DPD':
			$shipping = "Thank you for ordering , it will be shipped with DPD as soon as possible";
			break;
	}
	//betaling switch
	$payupdate = array("status" => '1', 'levering' => $ship, 'betaling' => $pay);
	$db->update("bestelling", $payupdate, "bestel = :bestel", $bbes);
	$tp = round($prijs + $extra + $payam, 2);
	switch ($pay) {
		case "Cash":
			$betaling = "Please pay <font color='red'>&euro; $tp </font> at the warenhouse<br>Please take your order number with you<br><pre>$rand</pre>";
			break;
		case "Overschrijving":
			$betaling = "Please wire transfer <font color='red'> &euro; $tp </font> to the following account <br>
	<pre>
	IBAN: BE24 9733 8346 0838
	BIC: ARSPBE22
	MEDEDELING: $rand
	</pre> <br>As soon our bank confirm the wire transfer we ship the products.";
			break;
		case 'paypal':
			$betaling = "
			<div id='smart-button-container'>
      <div style='text-align: center;'>
        <div id='paypal-button-container'></div>
      </div>
    </div>
  <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'pill',
          color: 'gold',
          layout: 'vertical',
          label: 'pay',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{'description':'$rand','amount':{'currency_code':'EUR','value':$tp}}]
          });
        },

        onApprove: function(data, actions) {
			return actions.order.capture().then(function(details) {
            
            // Full available details
            //console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
			$.ajax({
                type: 'POST',
                url: '../x/bestel',
                data: 'confirm=paypal&order='+details.purchase_units[0].description,
                success: function() {
					//alert(details.purchase_units[0].description);
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>Thank you for your payment!<br>Payment is confirmed</h3>';
                }
            });

            // Show a success message within this page, e.g.
            

            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>";
			break;
		case 'Clouds':
			$payupdate = array("status" => '2', 'levering' => $ship, 'betaling' => $pay);
			$db->update("bestelling", $payupdate, "pid =:pid AND naam = :kleur AND stock > 0", $bbes);

			$cloudstotal = $userdb['punten'] - $clouds;
			$cloudupdate = array("punten" => $cloudstotal);
			$db->update("gebruikers", $cloudupdate, "id =:id", $userbind);
			$betaling = "This product is ordered for  $clouds <i class='material-icons'>3d_rotation</i> including shipping.<br><br>in case of pickup please provide following number <pre>$rand</pre>";
			break;
	}
	//mail_test($rand);
	$session->delete('rand');
	$session->set('rand', uniqid())
	?>
<div class='alert alert-warning text-center'> Total price for this order is &euro;
    <?php echo ($prijs + $extra + $payam) ?> Where &euro;<?php echo $extra ?> for shipping cost and
    &euro;<?php echo $payam ?> transaction costs</div>
<div class="panel-group">
    <div class="panel panel-primary">
        <div class="panel-heading"><?php echo $shipping ?></div>
        <div class="panel-body"><?php echo $betaling ?></div>
    </div>
</div>
<?php
}
?>