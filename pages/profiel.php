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
*          File Name        > <!#FN> profiel.php </#FN>                                                                
*          File Birth       > <!#FB> 2021/09/18 00:38:17.367 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/21 23:45:04.376 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/





$perm = new Gebruikers;
$ship = new Shipping;
$session = new Session;
$db = new Db;


if ($perm->check('user')) {
    $bind = array(':id' => $session->get('id'));
    $result = $db->select('gebruikers', 'id = :id', '', $bind, 'fetch');
    $id = $result['id'];
    $zone = $ship->land($result['land']);
?>
<div class="container">
    <div class="registration">
        <pre class='alert alert-success fade in text-center' id='statusgebruiker'>
Click on a field to edit it , press ENTER to confirm the new field value
</pre>
        <div class="registration_form">
            <!-- Form -->
            <div class="row">
                <div class="form-group">
                    <div class="col-md-8 col-sm-8">
                        <label for="user">E-mail:</label>
                        <input id="naam:<?php echo $id ?>" class="form-control" contenteditable="false" readonly
                            value="<?php echo $result['naam'] ?>">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="tax">vat</label>
                        <input id="vat:<?php echo $id ?>" class="form-control" contenteditable="false" readonly
                            value="<?php echo $result['vat'] ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-8 col-sm-8">
                        <label for="tel">Phone Number</label>
                        <input id="phone:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['phone'] ?>">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="land">Shipping Zone</label>
                        <input id="land:<?php echo $id ?>" class="form-control" contenteditable="false" readonly
                            value="<?php echo $zone ?>">
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        <label for="vn">First Name</label>
                        <input id="voornaam:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['voornaam'] ?>">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="an">Last Name</label>
                        <input id="achternaam:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['achternaam'] ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-7 col-sm-7">
                        <label for="adress">Adress</label>
                        <input id="adress:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['adress'] ?>">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="number">Number</label>
                        <input id="nummer:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['nummer'] ?>">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="bus">Bus</label>
                        <input id="bus:<?php echo $id ?>" class="form-control " contenteditable="true"
                            value="<?php echo $result['bus'] ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-4 col-sm-4">
                        <label for="postcode">Zip Code</label>
                        <input id="postcode:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['postcode'] ?>">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="gemeente">City</label>
                        <input id="gemeente:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['gemeente'] ?>">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="land">Country</label>
                        <select id="land:<?php echo $id ?>" class="form-control" contenteditable="true"
                            value="<?php echo $result['land'] ?>">
                            <?php
                                foreach ($ship->land() as $code => $land) {
                                    if ($code == $result['land']) {
                                        echo "<option value='$code' selected>$land[name]</option>";
                                    } else {
                                        echo "<option value='$code'>$land[name]</option>";
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>
            </div>


            <!-- /Form -->
        </div>
    </div>


    <script>
    $(document).ready(function() {
        //DB edit
        $("input[contenteditable=true]").keypress(function(e) {
            var message_status = $("#statusgebruiker");
            if (e.which == 13) {
                var field = $(this).attr("id");
                var val = $(this).val();
                if ((val == "") && (field != 'bus:<?php echo $id ?>')) {
                    alert('Emtpy value\'s are bad');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "../x/edit",
                        data: 'field=' + field + '&waarde=' + encodeURIComponent(val) +
                            '&edit=gebruikers',
                        success: function(data) {
                            message_status.show();
                            message_status.text(data);
                            //hide the message
                            //setTimeout(function(){message_status.hide()},5000);
                        }
                    });
                }
                return false;
            }
        });
        $("select[contenteditable=true]").change(function(e) {
            var message_status = $("#statusgebruiker");
            var field = $(this).attr("id");
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "../x/edit",
                data: 'field=' + field + '&waarde=' + encodeURIComponent(val) +
                    '&edit=gebruikers',
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
} else {
    $session->flashdata('error', 'Please login first before accessing this page');
}
    ?>