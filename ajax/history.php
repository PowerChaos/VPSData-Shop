<?php
$perm = new Gebruikers;
$db = new Db;
$bestelling = $_POST['bestelling'] ?? "";
$bes = array(':bestel' => $bestelling);
$result = $db->select('bestelling', 'bestel = :bestel AND status > 0', '', $bes);

if ($perm->check('user')) {
?>
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
	switch ($_POST['history']) {
		case 'history':
			break;
		case 'status':
			$status = $db->select('bestelling', 'bestel = :bestel AND status = 1 ', '', $bes, 'fetch') ?? "betaald";
			switch ($status['betaling']) {
				case "Cash":
					$betaling = "<div class='alert alert-success'>You can pay <font color='red'>&euro; $tot </font> in the warenhouse.<br>Please use following code:<br><pre>$bestelling</pre></div>";
					break;
				case "Overschrijving":
					$betaling = "<div class='alert alert-success'>Please wire transfer <font color='red'> &euro; $tot </font> to the following adress<br>
		<pre>
		IBAN: BE24 9733 8346 0838
		BIC: ARSPBE22
		NOTICE: $bestelling
		</pre> <br> Please note, this can take a couple of days before it is confirmed</div>";
					break;
				case 'Paypal':
					$betaling = "<div class='alert alert-success'> <div id='smart-button-container'>
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
						  purchase_units: [{'description':'$bestelling','amount':{'currency_code':'EUR','value':$tot}}]
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
				</script></div>";
					break;
			}
			break;
	}
	echo $betaling ?? "";
} else {
	echo "Please login first before you can see history :D";
}
?>