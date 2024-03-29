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
*          File Name        > <!#FN> history.php </#FN>                                                                
*          File Birth       > <!#FB> 2021/09/18 00:38:17.364 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/22 02:34:39.566 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/

$perm = new Gebruikers;
$session = new Session;
$db = new Db;

if ($perm->check('user')) {
    $bes = array(':id' => $session->get('id'));
    $result = $db->select('bestelling', 'uid = :id AND status > 0', '', $bes, '', '*', 'bestel', 'status ASC,datum DESC');
?>
<div class="container">
    <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th style="width:20%">
                    Order Code
                </th>
                <th style="width:15%">
                    Delivery
                </th>
                <th style="width:20%">
                    Payment
                </th>
                <th style="width:15%">
                    Order date
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
                            $status = "Waiting for payment";
                            break;
                        case '2':
                            $status = "Paid - Waiting for shipping";
                            break;
                        case '3':
                            $status = "Order Completed";
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
                    if ($item['status'] == '1') {
                        echo "<a href='#' id='{$item['bestel']}' data-toggle='modal' data-target='#modal' onclick=\"history('status',this.id);\">{$status}</a>
            <br><a href='#' id='{$item['bestel']}' onclick=\"history('delete',this.id);\"><i class='material-icons'>backspace</i></a>";
                    } else {
                        echo $status;
                    }
                    echo "</td>
		</tr>
		";
                }
                ?>
        </tbody>
    </table>
    <script
        src='https://www.paypal.com/sdk/js?client-id=AbTs5Wq7-ieArfQRPSS27DTUGDW_OTHupSXeIve1wIBkLrpAWsmuiCg4h-jwDSUvJPehJ8zA3IBeF2my&enable-funding=venmo&currency=EUR'
        data-sdk-integration-source='button-factory'></script>
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
        switch (status) {
            case 'delete':
                if (confirm('Please confirm that you like to cancel this order , this can not be undone')) {
                    $confirming = '1'
                }
                break;
            default:
                $confirming = '1'
                break;
        }
        if ($confirming) {
            $.ajax({
                type: "POST",
                url: "../x/history",
                data: 'bestelling=' + dat + '&history=' + status,
                success: function(data) {
                    $("#modal").modal('show');
                    $("#modalcode").html(data);
                    if (status == 'status' || status == 'delete') {
                        $('#modal').on('hidden.bs.modal', function() {
                            window.location.reload();
                        })
                    }
                }
            });
        }
    }
    </script>
</div>
<div class="clearfix"></div>
<?php
} else {
    $session->flashdata('error', 'Please login to use this page');
}
?>