<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
function mail_test($code,$body="1",$email="bestelling@$_SERVER['SERVER_NAME']")
{
global $db;
switch($body)
{
case '1':
	$subject = "$_SERVER[SERVER_NAME] Nieuwe Bestelling Nummer: $code";
	$body ="<html><body>
	<table>
	<thead>
		<tr>
			<th>
				Product
			</th>
			<th>
				Kleur
			</th>
			<th>
				Hoeveelheid
			</th>
			<th>
				Prijs
			</th>
			<th>
				Clouds
			</th>
		</tr>
	</thead>
	<tbody>";
		$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :code AND status = '1'");
		$stmt->execute(array(':code' => $code));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		foreach ($result as $item)
		{
		$stmt2 = $db->prepare("SELECT * FROM products WHERE id = :pid");
		$stmt2->execute(array(':pid' => $item[pid]));
		$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);	
		$body .="
		<tr>
			<td>
			{$result2[name]}
			</td>
			<td>
			{$item[kleur]}
			</td>
			<td>
			{$item[qty]}
			</td>
			<td>
			&euro; {$item[prijs]}
			</td>
			<td>
			{$item[clouds]}
			</td>
		</tr>
		";
	$prijs += $item['prijs'];
	$clouds += $item['clouds'];
	$verzending = $item['levering'];
	$betaling = $item['betaling'];
	}
	$body .="	
	</tbody>
	</table>
	<br><br>
	totaal bedrag : &euro; $prijs Exclusief Verzend kosten <br>
	totaal Clouds Bonus : $clouds<br>
	Verzending : $verzending<br>
	Betaling : $betaling <br><br>
	u kan uw bestelling zien op <a href='https://$_SERVER[SERVER_NAME]/history'>https://$_SERVER[SERVER_NAME]/history</a>
	</body></html>";
break;
case '2':
	$subject = "$_SERVER[SERVER_NAME] Bestel Nummer: $code Betaald";
	$body ="<html><body>
	<table>
	<thead>
		<tr>
			<th>
				Product
			</th>
			<th>
				Kleur
			</th>
			<th>
				Hoeveelheid
			</th>
			<th>
				Prijs
			</th>
			<th>
				Clouds
			</th>
		</tr>
	</thead>
	<tbody>";
		$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :code AND status = '2'");
		$stmt->execute(array(':code' => $code));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		foreach ($result as $item)
		{
		$stmt2 = $db->prepare("SELECT * FROM products WHERE id = :pid");
		$stmt2->execute(array(':pid' => $item[pid]));
		$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);	
		$body .="
		<tr>
			<td>
			{$result2[name]}
			</td>
			<td>
			{$item[kleur]}
			</td>
			<td>
			{$item[qty]}
			</td>
			<td>
			&euro; {$item[prijs]}
			</td>
			<td>
			{$item[clouds]}
			</td>
		</tr>
		";
	$prijs += $item['prijs'];
	$clouds += $item['clouds'];
	$verzending = $item['levering'];
	$betaling = $item['betaling'];
	}
	$body .="	
	</tbody>
	</table>
	<br><br>
	totaal bedrag : &euro; $prijs Exclusief Verzend kosten <br>
	totaal Clouds Bonus : $clouds<br>
	Verzending : $verzending<br>
	Betaling : $betaling <br><br>
	u kan uw bestelling zien op <a href='https://$_SERVER[SERVER_NAME]/history'>https://$_SERVER[SERVER_NAME]/history</a>
	</body></html>";
break;
case '3':
	$subject = "$_SERVER[SERVER_NAME] Bestelling Nummer: $code Afgeleverd";
	$body ="<html><body>
	<table>
	<thead>
		<tr>
			<th>
				Product
			</th>
			<th>
				Kleur
			</th>
			<th>
				Hoeveelheid
			</th>
			<th>
				Prijs
			</th>
			<th>
				Clouds
			</th>
		</tr>
	</thead>
	<tbody>";
		$stmt = $db->prepare("SELECT * FROM bestelling WHERE bestel = :code AND status = '1'");
		$stmt->execute(array(':code' => $code));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
		foreach ($result as $item)
		{
		$stmt2 = $db->prepare("SELECT * FROM products WHERE id = :pid");
		$stmt2->execute(array(':pid' => $item[pid]));
		$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);	
		$body .="
		<tr>
			<td>
			{$result2[name]}
			</td>
			<td>
			{$item[kleur]}
			</td>
			<td>
			{$item[qty]}
			</td>
			<td>
			&euro; {$item[prijs]}
			</td>
			<td>
			{$item[clouds]}
			</td>
		</tr>
		";
	$prijs += $item['prijs'];
	$clouds += $item['clouds'];
	$verzending = $item['levering'];
	$betaling = $item['betaling'];
	}
	$body .="	
	</tbody>
	</table>
	<br><br>
	totaal bedrag : &euro; $prijs Exclusief Verzend kosten <br>
	totaal Clouds Bonus : $clouds<br>
	Verzending : $verzending<br>
	Betaling : $betaling <br><br>
	u kan uw bestelling zien op <a href='https://$_SERVER[SERVER_NAME]/history'>https://$_SERVER[SERVER_NAME]/history</a>
	</body></html>";
break;
}

 //$body = 'Hello, this is a test email from a cron job: /cron.php.';
   $headers .= "MIME-Version: 1.0" . "\r\n"; 
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 $headers .= "From: Vaporama Shop <shop@$_SERVER[SERVER_NAME]>" . "\r\n";
 $headers .= "Reply-To: Vaporama Shop <shop@$_SERVER[SERVER_NAME]>" . "\r\n";
 mail($email,$subject,$body,$headers,"-f errorshop@powerchaos.com");
}