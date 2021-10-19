<?php

/*
<!#CR>
************************************************************************************************************************
*                                                    Copyrigths ©                                                      *
* -------------------------------------------------------------------------------------------------------------------- *
*          Authors Names    > PowerChaos                                                                               *
*          Company Name     > VPS Data                                                                                 *
*          Company Email    > info@vpsdata.be                                                                          *
*          Company Websites > https://vpsdata.be                                                                       *
*                             https://vpsdata.shop                                                                     *
*          Company Socials  > https://facebook.com/vpsdata                                                             *
*                             https://twitter.com/powerchaos                                                           *
*                             https://instagram.com/vpsdata                                                            *
* -------------------------------------------------------------------------------------------------------------------- *
*                                           File and License Informations                                              *
* -------------------------------------------------------------------------------------------------------------------- *
*          File Name        > <!#FN> order.php </#FN>                                                                  
*          File Birth       > <!#FB> 2021/09/18 00:38:17.362 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/10/02 00:44:04.925 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



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
                    $bescheck = array(':id' => $item['bestel']);
                    $pricecalc = $db->select('bestelling', 'bestel = :id AND status > 0', '', $bescheck);
                    $pay = $pricecalc[0]['betaalkosten'] + $pricecalc[0]['leverkosten'] ?? "0";
                    foreach ($pricecalc as $price) {
                        $pay += $price['prijs'];
                    }
                    switch ($item['status']) {
                        case '1':
                            $status = "Niet Betaald";
                            break;
                        case '2':
                            $status = "Betaald";
                            break;
                        case '3':
                            $status = "Betaald en Afgeleverd";
                            break;
                    }
                    $datum = date("d-m-Y \o\m H:i", $item['datum']);
                    $euro = ($item['betaling'] == 'Points') ? $pay . " <i class='material-icons'>3d_rotation</i>" : "&euro; " . $pay;
                    echo "
				<tr>
			<td style='width:20%'>
			<a href='#' id='{$item['bestel']}' data-toggle='modal' data-target='#modal' onclick=\"history('history',this.id);\">{$item['bestel']}</a>
			</td>
			<td style='width:20%'>
			{$item['levering']}
			</td>
			<td style='width:20%'>
			{$item['betaling']} ( {$euro} )
			</td>
			<td style='width:20%'>
			{$datum}
			</td>
			<td style='width:20%'>";
                    if ($item['status'] != '3') {
                        echo "<a href='#' id='{$item['bestel']}' onclick=\"history('{$item['status']}',this.id);\">{$status}</a>";
                    } else {
                        echo "{$status}";
                    }
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