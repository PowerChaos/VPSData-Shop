<?php
class email
{
	public function __construct()
	{
		// start db en Sessie
		$this->db = new Db;
		$this->session = new Session;
	}

	function send($code, $body = "inform", $email = "webmaster@vpsdata.be")
	{
		$bes = array(':bestel' => $code);
		$result = $this->db->select('bestelling', 'bestel = :bestel AND status > 0', '', $bes);
		switch ($body) {
			case '1':
				$subject = "$_SERVER[SERVER_NAME] New order Number : $code";
				$body = "<html><body>
				<table cellpadding='0' cellspacing='0' width='640' align='center' border='1'>     
				<tr>         
				<td>            
				<table cellpadding='0' cellspacing='0' width='640' align='center' border='1'>                 
				<tr>                     
				<td> VPS Data Webshop <td>                     
				<td> Order number : $code </td>                 
				</tr>             
				</table>  
				<table cellpadding='0' cellspacing='0' width='640' align='left' border='1'>  
				<thead>
					<tr>
						<th>
						Product
						</th>
						<th>
						Color
						</th>
						<th>
						Amount
						</th>
						<th>
						Prize
						</th>
						<th>
						3D Points
						</th>
					</tr>
				</thead>
			<tbody>";
				$prijs = "0";
				$clouds = "0";
				$leverkosten = $result[0]['leverkosten'];
				$betaalkosten = $result[0]['betaalkosten'];
				foreach ($result as $item) {
					$pid = array(':pid' => $item['pid']);
					$name = $this->db->select('products', 'id = :pid', '', $pid, 'fetch');
					$body .= "
		<tr>
			<td>
			{$name['name']}
			</td>
			<td>
			{$item['kleur']}
			</td>
			<td>
			{$item['qty']}
			</td>
			<td>
			&euro; {$item['prijs']}
			</td>
			<td>
			{$item['clouds']}
			</td>
		</tr>
		";
					$prijs += $item['prijs'];
					$clouds += $item['clouds'];
				}
				$tot = ($prijs + $leverkosten + $betaalkosten);
				$body .= "	
	</tbody>
	</table>
</td>     
</tr> 
</table>
	<br><br>
	Total amount of &euro; $tot will reward you
    $clouds 3D Points
	<br>Delivery costs of &euro; $leverkosten and payment fee of &euro; $betaalkosten <br><br>
	You can see your order history and pay at <a href='https://$_SERVER[SERVER_NAME]/history'>https://$_SERVER[SERVER_NAME]/history</a> in case it is not paid
	</body></html>";
				break;
			case '2':
				$subject = "$_SERVER[SERVER_NAME] Order Number: $code is Paid";
				$body = "<html><body>
	Thank you for paying your order, we confirm the payment for order $code and will inform you when we ship out the products. <br><br>
	You can see your order history at <a href='https://$_SERVER[SERVER_NAME]/history'>https://$_SERVER[SERVER_NAME]/history</a>
	</body></html>";
				break;
			case '3':
				$subject = "$_SERVER[SERVER_NAME] Order Number: $code is Shipped";
				$body = "<html><body>
	Thank you for shopping with us, Your order $code has beein shipped to the provided adress.<br><br>
	You can see your order history at  <a href='https://$_SERVER[SERVER_NAME]/history'>https://$_SERVER[SERVER_NAME]/history</a>
	</body></html>";
				break;
			case 'inform':
				$subject = "$_SERVER[SERVER_NAME] Nieuwe bestelling: $code";
				$body = "<html><body>
	Er is een nieuwe bestelling geplaats met code $code <br><br>bestelling kan worden nagezien in admin menu.
	</body></html>";
		}

		//$body = 'Hello, this is a test email from a cron job: /cron.php.';
		$headers  = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: VPS Data Shop <shop@$_SERVER[SERVER_NAME]>" . "\r\n";
		$headers .= "Reply-To: VPS Data Support <info@vpsdata.be>" . "\r\n";
		if (mail($email, $subject, $body, $headers, "-f webmaster@vpsdata.be")) {
			return true;
		}
		return "error with sending email , please contact support";
	}
}