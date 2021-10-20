<?php  require(getenv("DOCUMENT_ROOT")."/functions/database.php"); 
if (a()){
?>
<div class="container">
<pre class='alert alert-success fade in text-center' id='statusproduct'>
Klik op een tabel om te bewerken
Promo's die ouder zijn dan 30 dagen worden weg gedaan
</pre>
								<div class="alert alert-info">Producten Promo's</div>
								<button type="button" class="btn-lg btn-primary text-center" data-toggle="modal" data-target="#modal" id="promo" onclick="product(this.id,'toevoegen');"><i class="material-icons" title="Product Toevoegen" aria-hidden="true">person_add</i><span class="sr-only">Promo Item Toevoegen</span></button>
								<table class="table table-bordered table-striped">
								  <thead>
									  <tr>	
										  <th style='width:33%'>Product ID</th>
										  <th style='width:33%'>Prijs in <i class='material-icons'>filter_drama</i></th>
										  <th style='width:34%'>Verval Datum</th>
									  </tr>
								  </thead>
									<tfoot>
										<tr>	
										  <th style='width:33%'>Product ID</th>
										  <th style='width:33%'>Prijs in <i class='material-icons'>filter_drama</i></th>
										  <th style='width:34%'>Verval Datum</th>
									  </tr>
									</tfoot>
									<tbody>
									<?php
										try {
											$tijd = strtotime("-1 month", time());
											$clean = $db->prepare("DELETE FROM bonus WHERE datum < :time");
											$clean->execute(array(':time' => $tijd));												
											$stmt5 = $db->prepare("SELECT * FROM bonus ORDER BY datum DESC");
											$stmt5->execute();
											$result5 = $stmt5->fetchall(PDO::FETCH_ASSOC);
											foreach($result5 as $info2) {
												$discount2 = "
												<td style='width:33%' class='info' id='pid:$info2[id]' contenteditable='true'>$info2[pid]</td>
												<td style='width:33%' class='warning' id='prijs:$info2[id]' contenteditable='true'>$info2[prijs]</td>
												<td style='width:34%' class='danger' id='datum:$info2[id]' contenteditable='true'>".date('d-m-Y',$info2[datum])."</td>";
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
<div class="alert alert-info">Bonus Clouds Ranks</div>
<table class="table table-bordered table-striped">
								  <thead>
									  <tr>	
										  <th>Bonus &#37;</th>
										  <th>Minimum <i class='material-icons'>filter_drama</i> Nodig</th>
									  </tr>
								  </thead>
									<tfoot>
										<tr>
											<th>Bonus &#37;</th>
											<th>Minimum <i class='material-icons'>filter_drama</i> Nodig</th>
										</tr>
									</tfoot>
									<tbody>
									<?php
										try {	
											$stmt4 = $db->prepare("SELECT * FROM discount ORDER BY clouds DESC");
											$stmt4->execute();
											$result4 = $stmt4->fetchall(PDO::FETCH_ASSOC);
											foreach($result4 as $info) {
												$discount = "<td class='danger' contenteditable='true' id='discount:$info[id]'>$info[discount]</td><td class='danger' id='clouds:$info[id]' contenteditable='true'>$info[clouds]</td>";
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
<script>
function product(val, dat) {
	$.ajax({
	type: "POST",
	url: "../ajax/products.php",
	data:'groep='+dat+'&waarde='+val,
	success: function(data){
		//alert(data);
		//alert ("del: " +dat+ " en waarde: " +val);
		$("#modal").modal('show');
		$("#modalcode").html(data);
		$('#modal').on('hidden.bs.modal', function () {
		window.location.reload();
		})
		
		
	}
	});
}
$(document).ready(function() {
	//DB edit
		$("td[contenteditable=true]").keypress(function(e){
		var message_status = $("#statusproduct");
		if (e.which == 13 ){
        var field = $(this).attr("id") ;
        var val = $(this).text() ;
		$.ajax({
		type: "POST",
		url: "../ajax/dbedit.php",
		data:'field='+field+'&waarde='+val+'&edit=bonus',
		success: function(data){
				message_status.show();
				message_status.text(data);
				//hide the message
				//setTimeout(function(){message_status.hide()},5000);
			}
    });
	return false;
	}	
});
});
</script>								
<?php
}
?>								