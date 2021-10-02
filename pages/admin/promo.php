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
                <th style='width:30%'>Product ID</th>
                <th style='width:30%'>Prijs in <i class='material-icons'>3d_rotation</i></th>
                <th style='width:30%'>Verval Datum</th>
                <th style='width:10%'>verwijder</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style='width:30%'>Product ID</th>
                <th style='width:30%'>Prijs in <i class='material-icons'>3d_rotation</i></th>
                <th style='width:30%'>Verval Datum</th>
                <th style='width:10%'>verwijder</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
                $tijd = strtotime("-3 month", time());
                $bdel = array(':time' => $tijd);
                $db->delete('bonus', 'datum < :tijd', $bdel);
                $bonus = $db->select('bonus', '', '', '', '', '*', '', 'datum DESC');
                $table = "";
                foreach ($bonus as $info) {
                    $discount = "
												<td style='width:30%' class='info' id='pid:$info[id]' contenteditable='true' promo='bonus'>$info[pid]</td>
												<td style='width:30%' class='warning' id='prijs:$info[id]' contenteditable='true' promo='bonus'>$info[prijs]</td>
												<td style='width:30%' class='danger' id='datum:$info[id]' contenteditable='true' promo='bonus'>" . date('d-m-Y', $info['datum']) . "</td>
                                                <td style='width:10%' class='danger'><a href='#' data-toggle='modal' data-target='#modal' id='$info[id]' onclick=\"remove(this.id,'promo');\"><i class='material-icons' title='verwijder' aria-hidden='true'>delete_forever</i></a></td>";
                    $table .= "<tr>";
                    $table .= $discount;
                    $table .= "</tr>";
                }
                echo $table;
                ?>
        </tbody>
    </table>
    <button type="button" class="btn-lg btn-primary text-center" data-toggle="modal" data-target="#modal" id="bonus"
        onclick="product(this.id,'toevoegen');"><i class="material-icons" title="Bonus Toevoegen"
            aria-hidden="true">3d_rotation</i><span class="sr-only">Bonus Item Toevoegen</span></button>
    <div class="alert alert-info">Bonus Points Ranks</div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Bonus &#37;</th>
                <th>Minimum <i class='material-icons'>3d_rotation</i> Nodig</th>
                <th>verwijder</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Bonus &#37;</th>
                <th>Minimum <i class='material-icons'>3d_rotation</i> Nodig</th>
                <th>verwijder</th>
            </tr>
        </tfoot>
        <tbody>
            <?php
                $discounts = $db->select('discount', '', '', '', '', '*', '', 'clouds DESC');
                $table2 = "";
                foreach ($discounts as $info2) {
                    $discount2 = "<td class='danger' contenteditable='true' promo='discount' id='discount:$info2[id]'>$info2[discount]</td>
                    <td class='danger' id='clouds:$info2[id]' contenteditable='true' promo='discount'>$info2[clouds]</td>
                    <td class='danger'><a href='#' data-toggle='modal' data-target='#modal' id='$info2[id]' onclick=\"remove(this.id,'bonus');\"><i class='material-icons' title='verwijder' aria-hidden='true'>delete_forever</i></a></td>";
                    $table2 .= "<tr>";
                    $table2 .= $discount2;
                    $table2 .= "</tr>";
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

    function remove(val, dat) {
        $.ajax({
            type: "POST",
            url: "../x/remove",
            data: 'groep=' + dat + '&waarde=' + val,
            success: function(data) {
                //alert(data);
                //alert ("del: " +dat+ " en waarde: " +val);
                $("#modal").modal('show');
                $("#modalcode").html(data);
            }
        });
    }
    $(document).ready(function() {
        //DB edit
        $("td[contenteditable=true]").keypress(function(e) {
            var message_status = $("#statusproduct");
            if (e.which == 13) {
                var edit = $(this).attr("promo");
                var field = $(this).attr("id");
                var val = $(this).text();
                $.ajax({
                    type: "POST",
                    url: "../x/edit",
                    data: 'field=' + field + '&waarde=' + val + '&edit=' + edit,
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