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
*          File Name        > <!#FN> Permission.class.php </#FN>                                                       
*          File Birth       > <!#FB> 2021/09/19 22:22:39.487 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/19 22:22:55.225 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 0.0.1 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/




class Permission{
	protected $rank;
	protected $groep;
	
    public function __construct() {
        // start db en Sessie
       $this->session = new Session; 
       }

    public function rank($rank)
	{
        $this->session = new Session;
		switch ($rank)
		{
			case "user":
              return  $this->session->set('loggedin','1');
		break;
			case "admin":
               return $this->session->set('admin','1');
		break;
			case "staff":
			if ($this->session->get('admin') == 1 || $this->session->get('staff') == 1 )
				return true;
			break;
		}
	}	
}
?>	