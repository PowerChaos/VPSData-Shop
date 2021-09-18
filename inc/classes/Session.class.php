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
*          File Name        > <!#FN> Session.class.php </#FN>                                                          
*          File Birth       > <!#FB> 2021/09/18 02:59:31.502 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/18 03:34:00.252 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 0.0.1 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/






class Session {

public function start()
{
    $session_name = 'VPS_Data_WebShop'; // Set a custom session name
    $secure = true; // Set to true if using https.
    $httponly = true; // This stops javascript being able to access the session id.
    ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
    $cookieParams = session_get_cookie_params(); // Gets current cookies params.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name); // Sets the session name to the one set above.

    if(!isset($_SESSION)) session_start();
}

public function destroy()
{
    session_destroy();
}

public function set($key, $value = null)
{
    if(is_array($key)) {
        foreach($key as $k => $v) {
            $_SESSION[$k] = $v;
        }
    }
    else {
        $_SESSION[$key] = $value;
    }
}

public function get($key)
{
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
}

public function regenerate($del_old = false)
{
    session_regenerate_id($del_old);
}

public function delete($key)
{
    unset($_SESSION[$key]);
}

public function flash($key)
{
    $key = 'flashdata_'.$key;
    $value = $this->get($key);
    $this->delete($key);
    return $value;
}

public function flashdata($key, $value)
{
    $this->set('flashdata_'.$key, $value);
}

public function array() {
    
    return $_SESSION;
    
}

}
?>