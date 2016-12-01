<?php  require(getenv("DOCUMENT_ROOT")."/functions/database.php"); 
if (u()){
?>
<div class="container">
							<div>
								<h4>Hier vind je meer informatie over hoe het korting systeem werkt.</h4>
								<hr />
								<p>Per aangekochte &euro; krijg je van ons 1 <i class='material-icons'>filter_drama</i><br />
									Deze <i class='material-icons'>filter_drama</i></i> kan je opsparen om elke maand te kiezen tussen 3 producten die U gratis kan krijgen.<br />
									Of je kan je opgespaarde <i class='material-icons'>filter_drama</i> gebruiken Voor een hogere bonus eens je een totaal aantal hebt gespaart.</p>
							</div>
							<div class="table-responsive">
								<?php
									try {	
										$stmt = $db->prepare("SELECT punten FROM gebruikers WHERE id = :id");
										$stmt->execute(array(':id' => $_SESSION['id'] ));
										$result = $stmt->fetch(PDO::FETCH_ASSOC);
										echo "<div class='alert alert-info text-center'>Je hebt in totaal $result[punten] <i class='material-icons'>filter_drama</i> gespaart!</div>";		
									}
									catch(Exception $e) {
										echo '<h2><font color=red>';
										var_dump($e->getMessage());
										die ('</h2></font> ');
									}
								?>
								<table class="table table-bordered table-striped">
								  <thead>
									  <tr>	
										  <th>Bonus <i class='material-icons'>filter_drama</i></th>
										  <th>Minimum <i class='material-icons'>filter_drama</i> Nodig</th>
									  </tr>
								  </thead>
									<tfoot>
										<tr>
											<th>Bonus <i class='material-icons'>filter_drama</i></th>
											<th>Minimum <i class='material-icons'>filter_drama</i> Nodig</th>
										</tr>
									</tfoot>
									<tbody>
									<?php
										try {	
											$stmt4 = $db->prepare("SELECT * FROM discount ORDER BY clouds DESC");
											$stmt4->execute();
											$result4 = $stmt4->fetchall(PDO::FETCH_ASSOC);
											$stmt2 = $db->prepare("SELECT punten FROM gebruikers WHERE id = :id");
											$stmt2->execute(array(':id' => $_SESSION['id'] ));
											$user = $stmt2->fetch(PDO::FETCH_ASSOC);
											$stmt3 = $db->prepare("SELECT * FROM discount WHERE clouds <= :groep ORDER BY clouds DESC LIMIT 1");
											$stmt3->execute(array(':groep' => $user[punten]));
											$punten = $stmt3->fetch(PDO::FETCH_ASSOC);
											foreach($result4 as $info) {
												$discount = ($info['id'] == $punten['id'])?"<td class=success >$info[discount] &#37;</td><td class=success >$info[clouds] <i class='material-icons'>filter_drama</i></td>":"<td class=danger >$info[discount] &#37;</td><td class=danger >$info[clouds] <i class='material-icons'>filter_drama</i></td>";
												$table2 .= "<tr>";
												$table2 .=  "$discount";
												$table2 .=  "</tr>";
											}
											echo $table2;		
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
else
{echo "Gelieven in te loggen";}	