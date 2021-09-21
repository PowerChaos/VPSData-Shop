<?php
$versie = "1.0.0";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/PowerChaos/VPSData-Shop/tags');
	$result = curl_exec($ch);
	curl_close($ch);
	///Deocde Json
	$data = json_decode($result,true);
	if ($data['message'])
	{
	echo "<div class='alert alert-danger text-center'>Your version is $version, unable to check latest version<br>try again in a hour</div>";
	}
	elseif ($data['0']['name'] > $versie)
	{
		echo "<div class='alert alert-danger text-center'>
			<a href='".$data['0']['zipball_url']."'>New Version ".$data['0']['name']." avaible</a>
				</div>";
	}
	else 
	{
		echo "<div class='alert alert-success text-center'>
		<a href='".$data['0']['zipball_url']."'>Latest Version ".$data['0']['name']." installed</a>
		</div>";
	}
?>	