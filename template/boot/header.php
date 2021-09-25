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
*          File Name        > <!#FN> header.php </#FN>                                                                 
*          File Birth       > <!#FB> 2021/09/18 00:38:17.379 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/18 03:47:27.078 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$db = new Db;

//site variables
$page = $_GET['page'] ?? null;
$product = $_GET['product'] ?? null;
$merk = $_GET['merk'] ?? null;
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <?php
	function tokenTruncate($string, $your_desired_width)
	{
		$parts = preg_split('/([\s\n\r]+)/', $string, '', PREG_SPLIT_DELIM_CAPTURE);
		$parts_count = count($parts);

		$length = 0;
		$last_part = 0;
		for (; $last_part < $parts_count; ++$last_part) {
			$length += strlen($parts[$last_part]);
			if ($length > $your_desired_width) {
				break;
			}
		}

		return implode(array_slice($parts, 0, $last_part));
	}
	if ($page != "") {
		if ($product != "") {
			$header = $product;
		} elseif ($merk != "") {
			$header = $merk;
		} else {
			$header = $page;
		}
		$titel = "VPS Data - " . $header;
	} else {
		$header = '3D printing made easy';
		$titel = $header;
	}
	$head = str_replace("-", " ", $header);
	$bind = array(":id" => $head);
	$seodesc = $db->select('products', 'name = :id', '', $bind, 'fetch');
	if ($seodesc) {
		$meta = tokenTruncate($seodesc['over'], 155);
	} else {
		$meta = "Welcome to $head by VPS Data - 3D Printing made easy";
	}
	?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $meta ?>">
    <meta name="author" content="PowerChaos">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $titel ?></title>
    <!-- JQuery -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- bootstrap -->
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../template/boot/css/style.css">

    <!-- Datatables -->
    <script type="text/javascript"
        src="//cdn.datatables.net/t/bs-3.3.6/jq-2.2.0,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,af-2.1.1,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2,cr-1.3.1,fc-3.2.1,fh-3.1.1,kt-2.1.1,r-2.0.2,rr-1.1.1,sc-1.4.1,se-1.1.2/datatables.min.js">
    </script>
    <link rel="stylesheet"
        href="//cdn.datatables.net/t/bs-3.3.6/jq-2.2.0,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.11,af-2.1.1,b-1.1.2,b-colvis-1.1.2,b-flash-1.1.2,b-html5-1.1.2,b-print-1.1.2,cr-1.3.1,fc-3.2.1,fh-3.1.1,kt-2.1.1,r-2.0.2,rr-1.1.1,sc-1.4.1,se-1.1.2/datatables.min.css">

    <!-- Flexslider-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/jquery.flexslider.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/flexslider.min.css">

    <!-- rating -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.1/js/star-rating.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.1/css/star-rating.min.css">

    <!-- box dropdown -->
    <link rel="stylesheet" href="../template/boot/css/dropdown.min.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <!-- end Fonts -->
</head>

<body>