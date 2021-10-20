<?php 
if (u()){
		if ($_SESSION[ERROR] != "")
		{	
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
?>
<div class="container">
								<div class="alert alert-info">OverZicht van lopende Promo's<br>Ga naar het product om het te kopen</div>
								<table class="table table-bordered table-striped">
								  <thead>
									  <tr>	
										  <th style='width:25%'>Product Naam</th>
										  <th style='width:25%'>Product Merk</th>
										  <th style='width:25%'>Prijs in </th>
										  <th style='width:25%'>Verval Datum</th>
									  </tr>
								  </thead>
									<tfoot>
										<tr>	
										  <th style='width:25%'>Product Naam</th>
										  <th style='width:25%'>Product Merk</th>
										  <th style='width:25%'>Prijs in </th>
										  <th style='width:25%'>Verval Datum</th>
									  </tr>
									</tfoot>
									<tbody>
									<?php
										try {											
											$stmt5 = $db->prepare("SELECT * FROM bonus ORDER BY datum DESC");
											$stmt5->execute();
											$result5 = $stmt5->fetchall(PDO::FETCH_ASSOC);
											foreach($result5 as $info2) {
												$verval = ($info2[datum] < time())?"Verlopen":date('d-m-Y',$info2[datum]);
												$stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
												$stmt->execute(array(':id' => $info2[pid]));
												$result = $stmt->fetch(PDO::FETCH_ASSOC);
												$seoproduct = str_replace(" ", "-", $result[name]);
												$seoproduct = strtolower($seoproduct);
												$seomerk = strtolower($result[merk]);	
												
												$discount2 = "
												<td style='width:25%' class='info'> <a href='//$_SERVER[SERVER_NAME]/$seomerk/$seoproduct.html'>$result[name]</a></td>
												<td style='width:25%' class='info'><a href='//$_SERVER[SERVER_NAME]/$seomerk.html'>$result[merk]</a></td>
												<td style='width:25%' class='warning'>$info2[prijs] <i class='material-icons'>filter_drama</i></td>
												<td style='width:25%' class='danger'>$verval</td>";
												$table22 .= "<tr>";
												$table22 .=  "$discount2";
												$table22 .=  "</tr>";
											}
											echo $table22;		
										}	
										catch(Exception $e) {
											echo '<h2><font color=red>';
											var_dump($e->getMessage());
											die ('</h2></font> ');
										}
									?>
									</tbody>
									</table>	
</div>
									<?php
}
?>								