<?php
$db = new Db;
$perm = new Gebruikers;

if ($perm->check('admin')) {
    $result = $db->select('bestelling', 'status > 0', '', '', '', '*', 'bestel', 'status ASC,datum DESC');
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
                foreach ($result as $item) {
                    switch ($item['status']) {
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
                    $datum = date("d-m-Y \o\m H:i", $item['datum']);
                    echo "
				<tr>
			<td style='width:20%'>
			<a href='#' id='{$item['bestel']}' data-toggle='modal' data-target='#modal' onclick=\"history('history',this.id);\">{$item['bestel']}</a>
			</td>
			<td style='width:20%'>
			{$item['levering']}
			</td>
			<td style='width:20%'>
			{$item['betaling']}
			</td>
			<td style='width:20%'>
			{$datum}
			</td>
			<td style='width:20%'>
			<a href='#' id='{$item['bestel']}' onclick=\"history('{$item['status']}',this.id);\">{$status}</a>";
                    if ($item['status'] == '1') {
                        echo "<br><a href='#' id='{$item['bestel']}' onclick=\"history('delete',this.id);\"><i class='material-icons'>backspace</i></a>";
                    }
                    echo " 
			</td>
		</tr>
		";
                }
                ?>
        </tbody>
    </table>
    <script>
    $(document).ready(function() {
        //Bestel Bevestigen
        $('table.table').DataTable({
            scrollY: '50vh',
            scrollCollapse: false,
            paging: false,
            aaSorting: []
        });
    }); //einde document Ready

    function history(status, dat) {
        $confirming = "";
        switch (status) {
            case '1':
                if (confirm(' wilt u deze order aanpassen naar de volgende status?\nBetaald - Wachten op Levering')) {
                    $confirming = '1'
                }
                break;
            case '2':
                if (confirm(
                        ' wilt u deze order aanpassen naar de volgende status?\n	Betaald en Afgeleverd - Alles in orde'
                    )) {
                    $confirming = '1'
                }
                break;
            case 'delete':
                if (confirm('Wilt u deze bestelling Verwijderen ? Dit kan niet worden ongedaan gemaakt')) {
                    $confirming = '1'
                }
                break;
            case 'history':
                $confirming = '1'
                break;
        }
        if ($confirming) {
            $.ajax({
                type: "POST",
                url: "../x/order",
                data: 'bestelling=' + dat + '&history=' + status,
                success: function(data) {
                    $("#modal").modal('show');
                    $("#modalcode").html(data);
                    $('#modal').on('hidden.bs.modal', function() {
                        window.location.reload();
                    })
                }
            });
        }
    }
    </script>
</div>
<div class="clearfix"></div>
<?php
}
?>