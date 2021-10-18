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
*          File Name        > <!#FN> login.php </#FN>                                                                  
*          File Birth       > <!#FB> 2021/09/18 00:38:17.366 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/20 21:33:36.861 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/
$reg = new Gebruikers;
$ship = new Shipping;
$session = new Session;

if ($session->get('faillogin') >= '5') {
    $free = strtotime('-15 minutes');
    $left = $this->session->get('timer');
    $timeleft = ($left - $free);
    echo " <pre><center>you failed to login to many times , please try again in {$timeleft} seconds ( " . ceil($timeleft / 60) . " minutes ).</center></pre>";

    if ($free >= $left) {
        echo "{$free} vs {$left}";
        $session->delete('faillogin');
        $session->delete('timer');
    }
} else if (!$reg->check('user')) {
    $register = $_POST['register'] ?? "";
    if ($register == 'register') {
        echo $reg->register('50', $_POST['user'], $_POST['pass1'], $_POST['pass2'], $_POST['vn'], $_POST['an'], $_POST['tel'], $_POST['adress'], $_POST['number'], $_POST['bus'], $_POST['gemeente'], $_POST['postcode'], $_POST['land'], $_POST['vat'], $_POST['code'], $_POST['checkcode']);
    }
?>
<div class="shoping">
    <div class="container">
        <div class="shpng-grids">
            <div class="col-md-12 shpng-grid">
                <h3>Free 3D points</h3>
                <p>Get 50 Free 3D points when registering </p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="container">
    <div class="registration">
        <div class="registration_left">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
            <script src="//<?php echo $_SERVER['SERVER_NAME'] ?>/template/boot/js/login.js"></script>
            <h2>Existing user</h2>
            <div class="registration_form">
                <!-- Form -->
                <form id="login-form" method="post">
                    <div id="error">
                        <!-- error will be shown here ! -->
                    </div>

                    <div class="form-group">
                        <input type="username" class="form-control" placeholder="UserName" name="username"
                            id="username" />
                        <span id="check-username"></span>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password"
                            id="password" />
                    </div>

                    <hr />

                    <div class="form-group">
                        <button type="submit" class="btn btn-default" name="btn-login" id="btn-login" value='login'>
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Login
                            </butt on>
                    </div>
                    <div class="forget">
                        <a href="#" id='forget'>Forgot Password</a>
                    </div>
                </form>
                <!-- /Form -->
            </div>
        </div>
        <div class="registration_left">
            <h2>New user? <span> Register here </span></h2>
            <div class="registration_form">
                <!-- Form -->
                <form action="" method="post">
                    <input type="hidden" name="register" value="register">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <label for="user">E-mail* :</label>
                                <input name="user" required="required" type="text" class="form-control"
                                    placeholder="Your Email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-8 col-sm-8">
                                <label for="tel">Phone Number*</label>
                                <input name="tel" type="text" class="form-control"
                                    placeholder="Phone number including country code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label for="pass1">Password *</label>
                                <input name="pass1" required class="form-control" type="password"
                                    placeholder="Password">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="pass2">Repeat password *</label>
                                <input name="pass2" required class="form-control" type="password"
                                    placeholder="Repeat Password">
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label for="vn">First Name *</label>
                                <input name="vn" type="text" required class="form-control" placeholder="John">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="an">Last Name *</label>
                                <input name="an" type="text" required class="form-control" placeholder="Doe">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-7 col-sm-7">
                                <label for="adress">Adress*</label>
                                <input name="adress" type="text" required class="form-control"
                                    placeholder="Street name">
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label for="number">Number*</label>
                                <input name="number" type="text" required class="form-control" placeholder="125">
                            </div>
                            <div class="col-md-2 col-sm-2">
                                <label for="bus">Bus</label>
                                <input name="bus" type="text" class="form-control" placeholder="3A">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4">
                                <label for="postcode">Zip code*</label>
                                <input name="postcode" type="text" required class="form-control" placeholder="1000">
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <label for="gemeente">City*</label>
                                <input name="gemeente" type="text" required class="form-control" placeholder="Brussel">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6">
                                <label for="land">Country*</label>
                                <select class="form-control" name="land">
                                    <option>Select Country</option>
                                    <?php
                                        foreach ($ship->land() as $code => $land) {
                                            echo "<option value='$code'>$land[name]</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="vat">VAT</label>
                                <input name="vat" type="text" class="form-control" placeholder="BE0743874489">
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="form-group">
                            <div class='alert alert-danger code'>Please press the button against anti bot</div>
                            <div class="col-md-12 col-sm-12">
                                <?php $code = rand(); ?>
                                <input type="hidden" name="code" value="<?php echo $code ?>">
                                <div class="col-md-4">
                                    <label for="checkcode">
                                        <button type="button" class="btn btn-danger" id='code'>Antibot button</button>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <label for="checkcode">AntiBot Code*</label>
                                    <input name="checkcode" id="codecheck" type="text"
                                        placeholder="Click button to generate code" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <br />
                    <label class="checkbox nomargin"><input class="checked-agree" required="required" type="checkbox"
                            name="checkbox"><i></i>i agree with our <a href='#' data-toggle="modal" data-target="#modal"
                            id="tos" onclick="tos(this.id);" aria-hidden="true">TOS</a>.</label><br />
                    </fieldset>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" name="userregister" class="btn btn-primary reg"><i
                                    class="fa fa-check"></i> REGISTER</button>
                        </div>
                    </div>
                </form>
                <!-- /Form -->
            </div>
        </div>

        <div class="clearfix"></div>
        <script>
        $(document).ready(function() {
            $('.reg').hide();
            $("#code").click(function() {
                $("#codecheck").val("<?php echo $code ?>");
                $('.reg').show();
                $('.code').hide();
            });
            $("#forget").click(function() {
                alert(
                    'Please send a email to info@<?php echo $_SERVER['SERVER_NAME'] ?> \nto request a pass reset'
                );
            });
        });
        </script>
    </div>
</div>
<?php
} else {
    echo "<div class='container'>You are already logged in and registered</div>";
}
?>