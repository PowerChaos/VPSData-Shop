<?php
$db = new Db;
//bewerking
$item = $_POST['item'] ?? "";
$waarde = $_POST['waarde'] ?? "";
$groep = $_POST['groep'] ?? "";
switch ($item) {
    case 'stock':
        $info = array("pid" => $_POST['id'], 'naam' => "Not Avaible", "stock" => "-1");
        $db->insert('stock', $info);
        break;
}

//weergave

switch ($groep) {
    case "stock":
        $pid = array(':pid' => $waarde);
        $result = $db->select('stock', 'pid = :pid', '', $pid);
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
            <td style='width:30%'>prijs</td>
            <td style='width:10%'>Verwijder</td>
        </tr>
    </thead>
    <tbody>
        <?php
                foreach ($result as $info) {
                    echo "<tr><td class='info' style='width:50%' id='naam:$info[id]' contenteditable='true'>$info[naam]</td>";
                    echo "<td class='success' style='width:20%' id='stock:$info[id]' contenteditable='true'>$info[stock]</td>";
                    echo "<td class='success' style='width:20%' id='stock:$info[id]' contenteditable='true'>$info[prijs]</td>";
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
                        url: "../x/edit",
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
                    url: "../x/remove",
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
                url: "../x/products",
                data: 'item=' + dat + '&id=' + val,
                success: function(data) {
                    //alert(dat+" Succesvol uitgevoerd");
                }
            });
        }
        </script>
        <?php
        break;
    case "verwijder":
        switch ($waarde) {
            case "promo":
                break;
            case "bonus":
                break;
        }
    case "toevoegen":
        switch ($waarde) {
            case "product":
                $produ = array('name' => "New", 'merk' => "New", 'cat' => "New");
                $db->insert('products', $produ);
                $last = $db->select('products', '', '', '', 'fetch', 'id', '', 'id DESC');
                $stock = array("pid" => $last['id'], 'naam' => "Not Avaible", "stock" => "-1");
                $db->insert('stock', $stock);
                echo "Nieuw Product Toegevoegt, Bewerk het nu in de lijst";
                break;
            case "promo":
                $prom = array("pid" => '0', 'prijs' => "9000", "datum" => time());
                $db->insert('bonus', $prom);
                echo "Nieuwe Promo Toegevoegt , Bewerk het nu in de lijst";
                break;
            case "bonus":
                $prom = array("discount" => '0', 'clouds' => "0");
                $db->insert('discount', $prom);
                echo "Nieuwe bonus Toegevoegt , Bewerk het nu in de lijst";
                break;
        }
        break;
}
        ?>