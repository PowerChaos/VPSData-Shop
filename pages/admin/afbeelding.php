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
*          File Name        > <!#FN> afbeelding.php </#FN>                                                             
*          File Birth       > <!#FB> 2021/09/18 00:38:17.361 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/10/02 00:44:20.529 </#FT>                                                    *
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
    $id = $_POST['id'] ?? "";
    $img = array(':pid' => $id);
    if ($id != "") {
        $result = $db->select('images', 'pid=:pid', '', $img);
    } else {
        $result = $db->select('images', '', '', '', '', '', '', 'pid');
    }
?>
<div class="container">
    <script src="../template/boot/js/ajaxupload.js"></script>
    <?php if ($_POST['afbeelding'] == 'toevoegen') {
            $name = $db->select('products', 'id=:pid', '', $img, 'fetch');
        ?>
    <br><br>
    <div id="upload" class='alert alert-info text-center'><span>Upload Foto's voor
            <?php echo $name['name'] ?><span></div>
    <span id="status" class="text-center"></span>
    <span id="files" class="text-center"></span>
    <table border=1 id='product' class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td style='width:100%' class='text-center'>Afbeelding</td>
            </tr>
        </thead>
        <tbody>
            <?php
                    foreach ($result as $info) {
                        echo "<tr><td class='warning text-center' style='width:100%' data-toggle='modal' data-target='#modal' id='$info[id]' onclick='remove(this.id,\"image\")'><img src='$info[img]' height='120' alt='$name[name]'></td>";
                    }
                    echo "</tbody></table>";
                    ?>
            <script type="text/javascript" class="init">
            $(document).ready(function() {
                $('table.table').DataTable({
                    aaSorting: [],
                    scrollY: '50vh',
                    scrollCollapse: false,
                    paging: false,
                    //dom: '<"top"ilf<"clear">>rt<"bottom"p<"clear">>',
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
            //uploader
            $(function() {
                var prod = <?php echo $id ?>;
                var btnUpload = $('#upload');
                var status = $('#status');
                new AjaxUpload(btnUpload, {
                    action: '../x/upload',
                    data: {
                        prod: prod
                    },
                    name: 'uploadfile',
                    onSubmit: function(file, ext) {
                        /*  if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                              // extension is not allowed 
                              status.text('Only JPG, PNG or GIF files are allowed');
                              return false;
                          }*/
                        status.text('Uploading...');
                    },
                    onComplete: function(file, response) {
                        //On completion clear the status
                        status.text('');
                        //Add uploaded file to list
                        if (response) {
                            $('<li></li>').appendTo('#files').html(response + '<br />' + file)
                                .addClass('success');
                            //$('<li></li>').appendTo('#files').text(response).addClass('error');
                            //setTimeout(location.reload.bind(location), 3000);
                            if (response == "Success") {
                                window.location.reload();
                            }
                        } else {
                            $('<li></li>').appendTo('#files').text(file).addClass('error');
                        }
                    }
                });

            });
            </script>
            <?php }
        echo "</div>";
    }
            ?>