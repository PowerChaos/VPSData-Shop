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
*          File Name        > <!#FN> Page.class.php </#FN>                                                             
*          File Birth       > <!#FB> 2021/09/18 02:47:28.181 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/18 03:31:43.408 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/






class Page {
private $info;
private $file;
private $perm;
private $page;
private $rank;
private $show;
private $ajax;

public function __construct() {
	// start db en Sessie
   $this->session = new Session; 
	   }

protected function Template($info)
{
include (getenv("DOCUMENT_ROOT")."/template/boot/$info.php");
}

public function Showpage($perm,$page)
{
	$ajax = '0';	
	switch ($perm)
	{	
	case "admin":
		if ($this->session->get('admin'))
		{
		$file = getenv("DOCUMENT_ROOT")."/pages/admin/".$page.".php";
		break;
		}
		else
		{
		goto home;
			break;
		}	
	case "staff":
		if ($this->session->get('admin') || $this->session->get('staff'))
		{
		$file = getenv("DOCUMENT_ROOT")."/pages/staff/".$page.".php";
		break;
		}
		else
		{
		goto home;
			break;
		}
	case 'logout':
	$this->session->destroy();
	return header("Refresh:0; url=../?logout=success");
	case 'ajax':
	$file = getenv("DOCUMENT_ROOT")."/pages/".$page.".php";
	$ajax = '1';	
	break;
	default:
		home:
		$file = getenv("DOCUMENT_ROOT")."/pages/".$page.".php";
		break;
	}
if (file_exists($file))
{
if ($ajax != '1')
{	
$this->Template("header");
$this->Template("sidebar");
include ("$file");
$this->Template("footer");
}
else
{
	include ("$file");
}
}
else
{	
$this->Template("header");
$this->Template("sidebar");
include (getenv("DOCUMENT_ROOT")."/pages/home.php");
$this->Template("footer");
}
}
}
?>