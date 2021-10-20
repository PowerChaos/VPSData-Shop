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
*          File Name        > <!#FN> producten.php </#FN>                                                              
*          File Birth       > <!#FB> 2021/09/18 00:38:17.362 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/24 23:10:19.391 </#FT>                                                    *
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
<script type="text/javascript" class="init">
$(document).ready(function() {
    $('table.table').DataTable({
        scrollY: '50vh',
        scrollCollapse: false,
        paging: false,
        aaSorting: []
    });
});

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
</script>
<div class="container">
    <button type="button" class="btn-lg btn-primary text-center" data-toggle="modal" data-target="#modal" id="product"
        onclick="product(this.id,'toevoegen');"><i class="material-icons" title="Product Toevoegen"
            aria-hidden="true">person_add</i><span class="sr-only">Product Toevoegen</span></button>
    <br><br>

    <pre class='alert alert-success fade in text-center' id='statusproduct'>
Klik op een tabel om te bewerken
</pre>
    <table border=1 id='product' class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td style='width:10%'>Product</td>
                <td style='width:10%'>Merk</td>
                <td style='width:15%'>category</td>
                <td style='width:10%'>Prijs</td>
                <td style='width:45%'>Info</td>
                <td style='width:15%'>Rating</td>
                <td style='width:5%'>Actie</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $result = $db->select('products', '', '', '', '', '*', '', 'id DESC');
                foreach ($result as $info) {
                    // Rating
                    $starcount = "0";
                    $totstar = "0";
                    $brat = array(':pid' => $info['id']);
                    $rating = $db->select('rating', 'pid = :pid', '', $brat);
                    $ratingcount = $db->select('rating', 'pid = :pid', '', $brat, 'rowcount');
                    foreach ($rating as $star) {
                        $starcount += $star['rating'];
                    }
                    $totstar = ($ratingcount > '0') ? ($starcount / $ratingcount) : "0";
                    // Einde Rating		
                    echo "<tr><td class='warning  no-enter' style='width:10%' id='name:$info[id]' contenteditable='true'>$info[name]</td>";
                    echo "<td class='success' style='width:10%' id='merk:$info[id]' contenteditable='true'>$info[merk]</td>";
                    echo "<td class='info' style='width:15%' id='cat:$info[id]' contenteditable='true'>$info[cat]</td>";
                    echo "<td class='danger' style='width:10%' id='prijs:$info[id]' contenteditable='true'>$info[prijs]</td>";
                    echo "<td class='warning' style='width:45%' id='over:$info[id]' contenteditable='true'>$info[over]</td>";
                    echo "<td class='info' style='width:15%'><input id='stars' name='stars' class='rating rating-loading' value='" . round($totstar) . "' data-min='0' data-max='5' data-step='1' data-size='ms' data-show-clear='false' data-readonly='true' data-show-caption='false'><p>( $ratingcount Stemmen )</p></input></td>";
                    echo "<td class=active style='width:5%'>id: $info[id] <br>";

                ?>
            <div class="dropdown pull-right">
                <button class="btn btn-warning btn-sm dropdown-toggle" type="button"
                    data-toggle="dropdown">Opties</button>
                <ul class="dropdown-menu">
                    <form action="../a/afbeelding" method="POST" id="image<?php echo $info['id'] ?>" name="image">
                        <input type="hidden" name="afbeelding" value="toevoegen">
                        <input type="hidden" name="id" value="<?php echo $info['id'] ?>">
                        <li><a href='#' class="btn btn-sm"
                                onClick='document.getElementById("image<?php echo $info['id'] ?>").submit();'><i
                                    class='material-icons' title='afbeelding' aria-hidden='true'>insert_photo</i>
                                Afbeelding<span class='sr-only'>Afbeelding</span></a></li>
                    </form>
                    <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                            onclick='product(this.id,"stock");'><i class="material-icons">store</i> Stock<span
                                class='sr-only'>Stock</span></a></li>
                    <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                            onclick='remove(this.id,"product");'><i class='material-icons' title='verwijder'
                                aria-hidden='true'>delete_forever</i> Verwijder<span
                                class='sr-only'>verwijder</span></a></li>
                    <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                            onclick='remove(this.id,"rating");'><i class="material-icons">star_border</i> Reset
                            Rating<span class='sr-only'>Reset Rating</span></a></li>
                </ul>
            </div>
            </td>
            <?php
                }
                echo "</tbody></table>";
                echo "</div>";
                ?>
            <script>
            $(document).ready(function() {
                //DB edit
                $("td[contenteditable=true]").keypress(function(e) {
                    if (e.which == 13) {
                        return false;
                    }
                });

                $("td[contenteditable=true]").blur(function(e) {
                    var message_status = $("#statusproduct");
                    var field = $(this).attr("id");
                    var val = $(this).text();
                    $.ajax({
                        type: "POST",
                        url: "../x/edit",
                        data: 'field=' + field + '&waarde=' + val + '&edit=products',
                        success: function(data) {
                            message_status.show();
                            message_status.text(data);
                            //hide the message
                            //setTimeout(function(){message_status.hide()},5000);
                        }
                    });
                });
            });
            </script>
            <?php
        }
            ?>