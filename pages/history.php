<?php
if (u()){
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
		if ($_SESSION[ERROR] != "")
		{	
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}
$stmt = $db->prepare("SELECT * FROM bestelling WHERE uid = :pid AND status > '0' GROUP BY(bestel) ORDER BY status ASC,datum DESC");
$stmt->execute(array(':pid' => $_SESSION[id]));
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
?>
<div class="container">
<table class="table table-bordered table-striped table-responsive">
	<thead>
		<tr>
			<th style="width:20%">
				Bestel Code
			</th>
			<th style="width:15%">
				Levering
			</th>
			<th style="width:20%">
				Betaling
			</th>
			<th style="width:15%">
				Bestel Datum
			</th>
			<th style="width:30%">
				Status
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($result as $item)
	{
		switch($item[status]){
		case '1':
			$status = "Niet Betaald - Wachten op Betaling";
			break;
			case '2':
			$status = "Betaald - Wachten op Levering";
			break;
			case '3':
			$status = "Betaald en Afgeleverd - Alles in orde";
			break;
		}
		$datum = date("d-m-Y \o\m H:i",$item[datum]);
		echo"
				<tr>
			<td style='width:20%'>
			<a href='#' id='{$item[bestel]}' data-toggle='modal' data-target='#modal' onclick=\"history('history',this.id);\">{$item[bestel]}</a>
			</td>
			<td style='width:20%'>
			{$item[levering]}
			</td>
			<td style='width:20%'>
			{$item[betaling]}
			</td>
			<td style='width:20%'>
			{$datum}
			</td>
			<td style='width:20%'>
			<a href='#' id='{$item[bestel]}' data-toggle='modal' data-target='#modal' onclick=\"history('status',this.id);\">{$status}</a>
			</td>
		</tr>
		";
	}
?>
</tbody>
</table>
<script>
$(document).ready(function(){
//Bestel Bevestigen
 $('table.table').DataTable( {
	aaSorting: []	
    } );				
}); //einde document Ready

function history(status,dat) {
			$.ajax({
			type: "POST",
			url: "../ajax/history.php",
			data:'bestelling='+dat+'&history='+status,
			success: function(data){
			 $("#modal").modal('show');
			$("#modalcode").html(data);			
			}
			});
}
</script>
</div>
<div class="clearfix"></div>
<?php
	}
else
{
	echo "inloggen aub";
}
?>