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
*          File Name        > <!#FN> promo.php </#FN>                                                                  
*          File Birth       > <!#FB> 2021/09/18 00:38:17.363 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/24 23:10:26.181 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$perm = new Gebruikers;
$db = new Db;
if ($perm->check('admin')) {
?>
<div class="container">
    <pre class='alert alert-success fade in text-center' id='statusproduct'>
Klik op een tabel om te bewerken
inactieve Promo's worden opgeruimt na 3 maanden
</pre>
    <div class="alert alert-info">Producten Promo's</div>
    <button type="button" class="btn-lg btn-primary text-center" data-toggle="modal" data-target="#modal" id="promo"
        onclick="product(this.id,'toevoegen');"><i class="material-icons" title="Product Toevoegen"
            aria-hidden="true">person_add</i><span class="sr-only">Promo Item Toevoegen</span></button>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style='width:33%'>Product ID</th>
                <th style='width:33%'>Prijs in <i class='material-icons'>3d_rotation</i></th>
                <th style='width:34%'>Verval Datum</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style='width:33%'>Product ID</th>
                <th style='width:33%'>Prijs in <i class='material-icons'>3d_rotation</i></th>
                <th style='width:34%'>Verval Datum</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
				$tijd = strtotime("-3 month", time());
				$bdel = array(':time' => $tijd);
				$db->delete('bonus', 'datum < :tijd', $bdel);
				$bonus = $db->select('bonus', '', '', '', '', '*', '', 'datum DESC');
				foreach ($bonus as $info) {
					$discount = "
												<td style='width:33%' class='info' id='pid:$info[id]' contenteditable='true'>$info[pid]</td>
												<td style='width:33%' class='warning' id='prijs:$info[id]' contenteditable='true'>$info[prijs]</td>
												<td style='width:34%' class='danger' id='datum:$info[id]' contenteditable='true'>" . date('d-m-Y', $info['datum']) . "</td>";
					$table .= "<tr>";
					$table .=  "$discount";
					$table .=  "</tr>";
				}
				echo $table;
				?>
        </tbody>
    </table>
    <div class="alert alert-info">Bonus Points Ranks</div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Bonus &#37;</th>
                <th>Minimum <i class='material-icons'>3d_rotation</i> Nodig</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Bonus &#37;</th>
                <th>Minimum <i class='material-icons'>3d_rotation</i> Nodig</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
				$discounts = $db->select('discount', '', '', '', '', '*', '', 'clouds DESC');
				foreach ($discounts as $info2) {
					$discount2 = "<td class='danger' contenteditable='true' id='discount:$info2[id]'>$info2[discount]</td><td class='danger' id='clouds:$info2[id]' contenteditable='true'>$info2[clouds]</td>";
					$table2 .= "<tr>";
					$table2 .=  "$discount2";
					$table2 .=  "</tr>";
				}
				echo $table2;
				?>
        </tbody>
    </table>
    <script>
    function product(val, dat) {
        $.ajax({
            type: "POST",
            url: "../x/products",
            data: 'groep=' + dat + '&waarde=' + val,
            success: function(data) {
                //alert(data);
                //alert ("del: " +dat+ " en waarde: " +val);
                $("#modal").modal('show');
                $("#modalcode").html(data);
                $('#modal').on('hidden.bs.modal', function() {
                    window.location.reload();
                })


            }
        });
    }
    $(document).ready(function() {
        //DB edit
        $("td[contenteditable=true]").keypress(function(e) {
            var message_status = $("#statusproduct");
            if (e.which == 13) {
                var field = $(this).attr("id");
                var val = $(this).text();
                $.ajax({
                    type: "POST",
                    url: "../x/edit",
                    data: 'field=' + field + '&waarde=' + val + '&edit=bonus',
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
    </script>
    <?php
}
	?>