<?php
require(getenv("DOCUMENT_ROOT") . "/functions/include.php");
require(getenv("DOCUMENT_ROOT") . "/functions/database.php");
//bewerking
switch ($_POST['item']) {
	case 'stock':
		$stmt = $db->prepare("INSERT INTO stock (pid,naam,stock) VALUES (:id,'Niet Beschikbaar','-1')");
		$stmt->execute(array(':id' => $_POST['id']));
		break;
}

//weergave
$waarde = $_POST['waarde'];
switch ($_POST['groep']) {
	case "stock":
		$stmt = $db->prepare("SElECT * FROM stock WHERE pid =:id");
		$stmt->execute(array(':id' => $waarde));
		$result = $stmt->fetchall(PDO::FETCH_ASSOC);
?>
<pre class='alert alert-success fade in text-center' id='statusstock'>
		Klik op een tabel om te bewerken<br> zet -1 als product niet meer leverbaar is
		</pre>
<button type="button" class="btn-sm btn-primary text-center" data-toggle="modal" data-target="#modal"
    id="<?php echo $waarde ?>" onclick="extra(this.id,'stock');"><i class="material-icons" title="kenmerk Toevoegen"
        aria-hidden="true">person_add</i><span class="sr-only">kenmerk Toevoegen</span></button>
<br><br>
<table border=1 id='product' class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td style='width:60%'>Naam</td>
            <td style='width:30%'>Stock</td>
            <td style='width:10%'>Verwijder</td>
        </tr>
    </thead>
    <tbody>
        <?php
				foreach ($result as $info) {
					echo "<tr><td class='info' style='width:70%' id='naam:$info[id]' contenteditable='true'>$info[naam]</td>";
					echo "<td class='success' style='width:20%' id='stock:$info[id]' contenteditable='true'>$info[stock]</td>";
					echo "<td class='warning' style='width:10%' id='$info[id]' onclick=\"werkbij(this.id,'stock');\"><i class='material-icons' title='verwijder' aria-hidden='true'>delete_forever</i></td></tr>";
				}
				echo "</tbody></table>";
				?>
        <script>
        $(document).ready(function() {
            //DB edit
            $("td[contenteditable=true]").keypress(function(e) {
                var message_status = $("#statusstock");
                if (e.which == 13) {
                    var field = $(this).attr("id");
                    var val = $(this).text();
                    $.ajax({
                        type: "POST",
                        url: "../ajax/dbedit.php",
                        data: 'field=' + field + '&waarde=' + val + '&edit=stock',
                        success: function(data) {
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

        function werkbij(val, dat) {
            if (confirm(
                "Zet op -1 als het product NIET meer beschikbaar is\nklik op OK om Dit kenmerk te verwijderen")) {
                ;
                $.ajax({
                    type: "POST",
                    url: "../ajax/remove.php",
                    data: 'confirm=' + dat + '&id=' + val,
                    success: function(data) {
                        //alert(dat+" Succesvol uitgevoerd");
                        window.location.reload();
                    }
                });
            }
        }

        function extra(val, dat) {
            alert("er is een nieuw kenmerk toegevoegt aan product id " + val);
            $.ajax({
                type: "POST",
                url: "../ajax/products.php",
                data: 'item=' + dat + '&id=' + val,
                success: function(data) {
                    //alert(dat+" Succesvol uitgevoerd");
                }
            });
        }
        </script>
        <?php
			break;
		case "bewerk":
			?>
        <form action="../invoer" method="POST" class='text-center'>
            <input type="hidden" name="product" value="verwijder">
            <input type="hidden" name="id" value="<?php echo $waarde ?>">
            <input type="submit" value="Bevestig Verwijdering van groep <?php echo $waarde ?>" class="btn btn-danger">
        </form>
        <?php
			break;
		case "toevoegen":
			switch ($waarde) {
				case "product":
					$stmt = $db->prepare("INSERT INTO products (name,merk,cat,over,prijs) VALUES ('1 Nieuw Product','Nieuw','Nieuw','Nieuw Product Toegevoegt','00.00')");
					$stmt->execute();
					$last = $db->lastInsertId();
					/*$stmt = $db->prepare("INSERT INTO stock (pid,naam,stock) VALUES (:id,'0 mg','0')");
					$stmt->execute(array(':id' => $last));
					$stmt = $db->prepare("INSERT INTO stock (pid,naam,stock) VALUES (:id,'5 mg','0')");
					$stmt->execute(array(':id' => $last));
					$stmt = $db->prepare("INSERT INTO stock (pid,naam,stock) VALUES (:id,'10 mg','0')");
					$stmt->execute(array(':id' => $last)); */
					$stmt = $db->prepare("INSERT INTO stock (pid,naam,stock) VALUES (:id,'Nog Niet Beschikbaar','-1')");
					$stmt->execute(array(':id' => $last));
					echo "Nieuw Product Toegevoegt , Bewerk het nu in de lijst";
					break;
				case "promo":
					$stmt = $db->prepare("INSERT INTO bonus (pid,prijs,datum) VALUES ('0','9000','" . time() . "')");
					$stmt->execute();
					echo "Nieuw Promo Toegevoegt , Bewerk het nu in de lijst";
					break;
			}
			break;
	}
		?>