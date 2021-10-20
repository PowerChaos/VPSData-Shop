<?php

if (a()){
require(getenv("DOCUMENT_ROOT")."/functions/database.php");	
		if ($_SESSION[ERROR] != "")
		{	
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}


$id = $_POST['id'];
if ($id != ""){			
$stmt = $db->prepare("SELECT * FROM images where pid = :pid");
$stmt->execute(array(':pid' => $id));
}
else{
$stmt = $db->prepare("SELECT * FROM images ORDER BY pid");
$stmt->execute();
}
$result = $stmt->fetchall(PDO::FETCH_ASSOC);
?>
<script type="text/javascript" class="init">
$(document).ready(function() {
 $('table.table').DataTable( {
	aaSorting: [],
	scrollY:        '50vh',
	scrollCollapse: true,
	paging:         false,
	//dom: '<"top"ilf<"clear">>rt<"bottom"p<"clear">>',
    } );	
	} );
function remove(val, dat) {
	$.ajax({
	type: "POST",
	url: "//<?php echo $_SERVER['SERVER_NAME']?>/ajax/remove.php",
	data:'groep='+dat+'&waarde='+val,
	success: function(data){
		//alert(data);
		//alert ("del: " +dat+ " en waarde: " +val);
		$("#modal").modal('show');
		$("#modalcode").html(data);
		}
	});
}
//uploader
	$(function(){
		var prod=<?php echo $id ?>;
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: '//<?php echo $_SERVER['SERVER_NAME']?>/ajax/upload.php',
			data: {prod: prod},
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response){
					$('<li></li>').appendTo('#files').html(response+'<br />'+file).addClass('success');
					//$('<li></li>').appendTo('#files').text(response).addClass('error');
					//setTimeout(location.reload.bind(location), 3000);
					//window.location.reload();
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
		
	});
</script>	
<div class="container">
<table border=1 id='product' class="table table-striped table-bordered table-hover">
  <thead>
  <tr>	
	<td style='width:100%' class='text-center'>Afbeelding</td>
	</tr>
</thead>
<tbody>	
<?php
$stmt2 = $db->prepare("SELECT * FROM products where id = :id");
$stmt2->execute(array(':id' => $id));
$info2 = $stmt2->fetch(PDO::FETCH_ASSOC);
foreach($result as $info) {	
echo "<tr><td class='warning text-center' style='width:100%' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='remove(this.id,\"image\")'><img src='$info[img]' height='120' alt='$info2[name]'></td>";
}
echo "</tbody></table>";
?>
<script src="//<?php echo $_SERVER['SERVER_NAME']?>/template/boot/js/ajaxupload.js"></script>
<?php if ($_POST['afbeelding'] == 'toevoegen'){ ?>
<br><br>
		<div id="upload" class='alert alert-info text-center' ><span>Upload Foto's voor <?php echo $info2[name] ?><span></div>
		<span id="status" class="text-center"></span>
		<span id="files" class="text-center"></span>
<?php }
echo "</div>";
}

?>