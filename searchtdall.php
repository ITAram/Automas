<?
include "includes/include_td.php";
include "includes/function.php";
?>
<?
if(isset($_GET["search"]) && $_GET["search"] != ""){
	$search1 = $_GET["search"];
}
if($id == 3){
	header("Location: news.php");
}

$query1 = "select * from menu where type = 'header_menu'";
$result1 = mysql_query($query1) or die(mysql_error());

//$result1 = mysqli_query($link, "select * from menu where type = 'header_menu' ");

$query2 = "select spare_menu_name from spare_menu where spare_menu_id ='$spare_menu_id' ";
$result2 = mysql_query($query2) or die(mysql_error());
$row2 = @mysql_fetch_array($result2);

//$result2 = mysqli_query($link, "select spare_menu_name from spare_menu where spare_menu_id ='$spare_menu_id' ");
//$row2 = @mysqli_fetch_array($result2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$row2["spare_menu_name"]?> | www.automas.am</title>
<meta name="title" content="automas.am - Web Page">
<meta name="keywords" content="запчасти, неисправные машины, автозапчасти, машины, низкие цены" />
<meta name="description" content="запчасти, неисправные машины, автозапчасти, машины, низкие цены" />
<meta http-equiv="Pragma" content="no-cache">
<meta name="Author" content="Aram Tovmasyan">
<meta name="URL" content="http://www.automas.am">
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
		<div id="header">
			<div id="logo">
				<h1><a href="#">automas.am</a></h1>		
				<p><em>Интернет магазин автозапчастей</em></p>		
			</div>
			<hr />
			<!-- end #logo -->
			<div id="menu">
				<ul>
<?
while($row1 = @mysql_fetch_array($result1)){
	$class_active = "";
	if($row1["title"] != ""){
				$title = $row1["title"];
	}
?>
					<li><a href="index.php?id=<?=(int)$row1["id"]?>"><?=$title?></a></li>
<?
}
?>
				</ul>
			</div>
			<div id="search">
				<form method="get" action="search.php">
					<fieldset>
					<label style="color:#FFFFFF">Код запчасти (артикул):</label> <input type="text" name="search" id="search-text" size="15" />
					<input type="submit" id="search-submit" value="Поиск >>" />
					</fieldset>
				</form>
			</div>
			
		</div>
		<div>
		<div id="searchtd">
				<form method="get" action="searchtd.php">
					<fieldset>
					<label style="color:#FFFFFF">Код запчасти (артикул):</label> <?=$search?><input type="text" name="search" id="search-text" size="15" />
					<input type="submit" id="search-submit-td" value="Поиск в базе TECDOC>>" />
					</fieldset>
				</form>
		</div>
		</div>
		<!-- end #header -->
		<!-- end #header-wrapper -->
		<div id="page">
			<?
				$query_left = "select * from menu where type ='left_menu'";
				$result_left = mysql_query($query_left) or die(mysql_error());
				//$result_left = mysqli_query($link, "select * from menu where type ='left_menu'");
			?>
			<div id="sidebar">
				<li>
					<ul>
					<?
					while($row_left = @mysql_fetch_array($result_left)){
						if($row_left["title"] != ""){
									$title_left = $row_left["title"];
						}
					?>					
						<li><a href="index.php?id=<?=(int)$row_left["id"]?>"><?=$title_left?></a></li>
					<?
					}
					?>	
					</ul>
				</li>
			</div>

			<div id="content">
				<div class="post">
				<h2 class="title">Результаты поиска</h2>
				<div class="entry">
								
<? 
			$searchreg = ereg_replace("[^A-Za-z0-9]", "", $search1);
			if($searchreg=='') {
			?>
					<p align="center">По Вашему запросу ничего не найдено !</p>
			<? 
			}
			else {
			//$query = "SELECT * FROM spare WHERE  code like '%".$search1."%'  or REPLACE(REPLACE(REPLACE(code,'.',''),'-',''),' ','') like '%".$searchreg."%' ";
			
$query = "SELECT 
	SUPPLIERS.SUP_BRAND AS BRA_BRAND,
	SUPPLIERS.SUP_BRAND AS BRAND,
	ARTICLES.ART_ARTICLE_NR AS NUMBER,
	ART_LOOKUP.ARL_KIND,
	ART_LOOKUP.ARL_ART_ID AS ARL_ART_ID,
	DES_TEXTS.TEX_TEXT AS ART_COMPLETE_DES_TEXT,
	PRI_PRICE,
	PRI_CURRENCY_CODE
FROM
	           ART_LOOKUP
	LEFT JOIN BRANDS ON BRANDS.BRA_ID = ART_LOOKUP.ARL_BRA_ID
	INNER JOIN ARTICLES ON ARTICLES.ART_ID = ART_LOOKUP.ARL_ART_ID
	INNER JOIN SUPPLIERS ON SUPPLIERS.SUP_ID = ARTICLES.ART_SUP_ID
	INNER JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = ARTICLES.ART_COMPLETE_DES_ID
	INNER JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = DESIGNATIONS.DES_TEX_ID
	LEFT JOIN PRICES ON ART_LOOKUP.ARL_ART_ID = PRICES.PRI_ART_ID
	
WHERE
	ART_LOOKUP.ARL_SEARCH_NUMBER = '".$searchreg."'  
	/*AND ART_LOOKUP.ARL_KIND <=3*/
	AND isnull(BRANDS.BRA_BRAND)
	AND DESIGNATIONS.DES_LNG_ID = 16
";
			
			$result = mysql_query($query) or die(mysql_error());

			$query_zam = "SELECT 
	BRANDS.BRA_BRAND,
	SUPPLIERS.SUP_BRAND AS BRAND,
	concat(ifnull(ARTICLES.ART_ARTICLE_NR,''),'&',ifnull(ART_LOOKUP.ARL_DISPLAY_NR,''),'&',ifnull(ART_LOOKUP.ARL_SEARCH_NUMBER,''),'&',CAST(ART_LOOKUP.ARL_KIND  AS char) )  AS NUMBER,
	ART_LOOKUP.ARL_KIND,
	ART_LOOKUP.ARL_ART_ID AS ARL_ART_ID,
	DES_TEXTS.TEX_TEXT AS ART_COMPLETE_DES_TEXT,
	PRI_PRICE,
	PRI_CURRENCY_CODE
FROM
	           ART_LOOKUP
	LEFT JOIN BRANDS ON BRANDS.BRA_ID = ART_LOOKUP.ARL_BRA_ID
	LEFT JOIN ARTICLES ON ARTICLES.ART_ID = ART_LOOKUP.ARL_ART_ID
	LEFT JOIN SUPPLIERS ON SUPPLIERS.SUP_ID = ARTICLES.ART_SUP_ID
	LEFT JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = ARTICLES.ART_COMPLETE_DES_ID AND DESIGNATIONS.DES_LNG_ID = 16
	LEFT JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = DESIGNATIONS.DES_TEX_ID
	LEFT JOIN PRICES ON ART_LOOKUP.ARL_ART_ID = PRICES.PRI_ART_ID
	
WHERE
	ART_LOOKUP.ARL_SEARCH_NUMBER = '".$searchreg."'  
	/*AND ART_LOOKUP.ARL_KIND >3*/
	AND NOT isnull(BRANDS.BRA_BRAND)

UNION	
SELECT 
	BRANDS.BRA_BRAND,
	SUPPLIERS.SUP_BRAND AS BRAND,
		concat(ifnull(ARTICLES.ART_ARTICLE_NR,''),'#',ifnull(ART_LOOKUP.ARL_DISPLAY_NR,''),'#',ifnull(ART_LOOKUP.ARL_SEARCH_NUMBER,''),'#',CAST(ART_LOOKUP.ARL_KIND  AS char) )  AS NUMBER,
	ART_LOOKUP.ARL_KIND,
	ARTICLES.ART_ID AS ARL_ART_ID,
	DES_TEXTS.TEX_TEXT AS ART_COMPLETE_DES_TEXT,
	PRI_PRICE,
	PRI_CURRENCY_CODE
FROM
	      ARTICLES     
	LEFT JOIN ART_LOOKUP ON ARTICLES.ART_ID = ART_LOOKUP.ARL_ART_ID
	LEFT JOIN BRANDS ON BRANDS.BRA_ID = ART_LOOKUP.ARL_BRA_ID
	
	LEFT JOIN SUPPLIERS ON SUPPLIERS.SUP_ID = ARTICLES.ART_SUP_ID
	LEFT JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = ARTICLES.ART_COMPLETE_DES_ID AND DESIGNATIONS.DES_LNG_ID = 16
	LEFT JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = DESIGNATIONS.DES_TEX_ID
	LEFT JOIN PRICES ON ART_LOOKUP.ARL_ART_ID = PRICES.PRI_ART_ID
	
WHERE
	REPLACE(ARTICLES.ART_ARTICLE_NR,' ','') = '".$searchreg."'  
	/*AND ART_LOOKUP.ARL_KIND >3
	AND NOT isnull(BRANDS.BRA_BRAND)*/
order by BRAND
";
			
			$result_zam = mysql_query($query_zam) or die(mysql_error());
			
			$num_rows = mysql_num_rows($result) + mysql_num_rows($result_zam);
?>
<tr><td colspan=5>Найдено <?=$num_rows?> строк</td></tr>
						<table>
						
						<tr>
							<th><div align="center"><strong>Фирма</strong></div></th>
                            <th><div align="center"><strong>Proizv</strong></div></th>
                            <th><div align="center"><strong>Артикул</strong></div></th>
                            <th><div align="center"><strong>Информация</strong></div></th>
                            <th><div align="center"><strong>Описание</strong></div></th>
                           
                            <th><div align="center"><strong>Ожидаемый срок дн.<b>?</b></strong></div></th>
                            <th><div align="center"><strong>Цена</strong></div></th>
                            <th><div align="center"><strong>Заказать</strong></div></th>
						</tr>
						<tr><td colspan=5>Запрошенный артикул</td></tr>
						
<?

			if(mysql_num_rows($result) > 0){
				while($row_content = mysql_fetch_array($result)){
					$proizv = "";
					$firm = "";
					$nal = "";
					
					$description = "";
					$price = "";
					$currency = "";

					if($row_content["BRA_BRAND"] != ""){
						$proizv  = $row_content["BRA_BRAND"];
					}
					if($row_content["BRAND"] != ""){
						$firm  = $row_content["BRAND"];
					}
					if($row_content["NUMBER"] != ""){
						$nal  = $row_content["NUMBER"];
					}
				
					if($row_content["ART_COMPLETE_DES_TEXT"] != ""){
						$description  = $row_content["ART_COMPLETE_DES_TEXT"];
					}
					if($row_content["PRI_PRICE"] != ""){
						$price  = $row_content["PRI_PRICE"];
					}
					if($row_content["PRI_PRICE"] != "" AND $row_content["PRI_CURRENCY_CODE"] != ""){
						$currency  = $row_content["PRI_CURRENCY_CODE"];
					}
					
					$queryimage = "
							SELECT
								CONCAT(
									'images/',
									GRA_TAB_NR, '/',
									GRA_GRD_ID, '.',
									IF(LOWER(DOC_EXTENSION)='jp2', 'jpg', LOWER(DOC_EXTENSION))
								) AS PATH
							FROM
										   LINK_GRA_ART
								INNER JOIN GRAPHICS ON GRA_ID = LGA_GRA_ID
								INNER JOIN DOC_TYPES ON DOC_TYPE = GRA_DOC_TYPE
							WHERE
								LGA_ART_ID =  ".$row_content["ARL_ART_ID"]." AND
								(GRA_LNG_ID = 16 OR GRA_LNG_ID = 255) AND
								GRA_DOC_TYPE <> 2
							ORDER BY
								GRA_GRD_ID"
							;
			 
					$resultimage = mysql_query($queryimage) ;
					$imagescount = mysql_num_rows($resultimage);
		
					$queryparams = "
						SELECT
							DES_TEXTS.TEX_TEXT AS CRITERIA_DES_TEXT,
							IFNULL(DES_TEXTS2.TEX_TEXT, ACR_VALUE) AS CRITERIA_VALUE_TEXT
						FROM
									  ARTICLE_CRITERIA
							LEFT JOIN DESIGNATIONS AS DESIGNATIONS2 ON DESIGNATIONS2.DES_ID = ACR_KV_DES_ID
							LEFT JOIN DES_TEXTS AS DES_TEXTS2 ON DES_TEXTS2.TEX_ID = DESIGNATIONS2.DES_TEX_ID
							LEFT JOIN CRITERIA ON CRI_ID = ACR_CRI_ID
							LEFT JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = CRI_DES_ID
							LEFT JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = DESIGNATIONS.DES_TEX_ID
						WHERE
							
							(DESIGNATIONS.DES_LNG_ID IS NULL OR DESIGNATIONS.DES_LNG_ID = 16) AND
							(DESIGNATIONS2.DES_LNG_ID IS NULL OR DESIGNATIONS2.DES_LNG_ID = 16) AND
						ACR_ART_ID = ".$row_content["ARL_ART_ID"];
									 
					$resultparams = mysql_query($queryparams) ;
					$paramscount = mysql_num_rows($resultparams);
?>						

						
						<tr class="rowc">
						<td align="center" width="10%"></td>
						<td align="center" width="10%"><?=$firm?></td>
						<td width="60%"><?=$nal?></td>
						
						<td align = "center"><a style="hover:none; text-decoration:none" href="detailstd.php?spare_id=<?=$row_content["ARL_ART_ID"]?>">
							<? if($paramscount>0) {?>
							<img src="images/cars/params.gif" />
							<? } ?>
							<? if($imagescount>0) {?>
								<img src="images/cars/photo.gif" />
							<? } ?>
							<img src="images/cars/i.gif" />
						</a></td>
						
						<td width="10%"><?=$description?></td>
						
						<td width="5%"><?=$srok?></td>
						<td width="5%"><?=$price?> <?=$currency?></td>
						<td><a href="zakaz.php?spare_id=<?=$row_content["ARL_ART_ID"]?>"><img src="images/basket.png" /></a></td>
						</tr>
<?
				}
			}
			else{
?>
					<tr><td colspan=5>Оригинал по такому номеру не найден</td></tr>
<? 
				}
				
				
		if(mysql_num_rows($result_zam) > 0){
		
		?>
		<tr><td colspan=5>Аналоги (заменители) для запрошенного артикула</td></tr>
	<?
				while($row_content = mysql_fetch_array($result_zam)){
					
					$proizv  = "";
					$firm = "";
					$nal = "";
					
					$description = "";
					$price = "";
					$currency = "";

					if($row_content["BRA_BRAND"] != ""){
						$proizv  = $row_content["BRA_BRAND"];
					}
					if($row_content["BRAND"] != ""){
						$firm  = $row_content["BRAND"];
					}
					if($row_content["NUMBER"] != ""){
						$nal  = $row_content["NUMBER"];
					}
				
					if($row_content["ART_COMPLETE_DES_TEXT"] != ""){
						$description  = $row_content["ART_COMPLETE_DES_TEXT"];
					}
					if($row_content["PRI_PRICE"] != ""){
						$price  = $row_content["PRI_PRICE"];
					}
					if($row_content["PRI_PRICE"] != "" AND $row_content["PRI_CURRENCY_CODE"] != ""){
						$currency  = $row_content["PRI_CURRENCY_CODE"];
					}
					

			$queryimage = "
SELECT
	CONCAT(
		'images/',
		GRA_TAB_NR, '/',
		GRA_GRD_ID, '.',
		IF(LOWER(DOC_EXTENSION)='jp2', 'jpg', LOWER(DOC_EXTENSION))
	) AS PATH
FROM
	           LINK_GRA_ART
	INNER JOIN GRAPHICS ON GRA_ID = LGA_GRA_ID
	INNER JOIN DOC_TYPES ON DOC_TYPE = GRA_DOC_TYPE
WHERE
	LGA_ART_ID =  ".$row_content["ARL_ART_ID"]." AND
	(GRA_LNG_ID = 16 OR GRA_LNG_ID = 255) AND
	GRA_DOC_TYPE <> 2
ORDER BY
	GRA_GRD_ID"
;
			 
			$resultimage = mysql_query($queryimage);
			$imagescount = mysql_num_rows($resultimage);
		
			$queryparams = "
						SELECT
							DES_TEXTS.TEX_TEXT AS CRITERIA_DES_TEXT,
							IFNULL(DES_TEXTS2.TEX_TEXT, ACR_VALUE) AS CRITERIA_VALUE_TEXT
						FROM
									  ARTICLE_CRITERIA
							LEFT JOIN DESIGNATIONS AS DESIGNATIONS2 ON DESIGNATIONS2.DES_ID = ACR_KV_DES_ID
							LEFT JOIN DES_TEXTS AS DES_TEXTS2 ON DES_TEXTS2.TEX_ID = DESIGNATIONS2.DES_TEX_ID
							LEFT JOIN CRITERIA ON CRI_ID = ACR_CRI_ID
							LEFT JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = CRI_DES_ID
							LEFT JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = DESIGNATIONS.DES_TEX_ID
						WHERE
							
							(DESIGNATIONS.DES_LNG_ID IS NULL OR DESIGNATIONS.DES_LNG_ID = 16) AND
							(DESIGNATIONS2.DES_LNG_ID IS NULL OR DESIGNATIONS2.DES_LNG_ID = 16) AND
						ACR_ART_ID = ".$row_content["ARL_ART_ID"];
									 
			$resultparams = mysql_query($queryparams) ;
			$paramscount = mysql_num_rows($resultparams);

?>						
						
						<tr class="rowc">
						<td align="center" width="10%"><?=$proizv?></td>
						<td align="center" width="10%"><?=$firm?></td>
						<td width="60%"><?=$nal?></td>
						
						<td align = "center"><a style="hover:none; text-decoration:none" href="detailstd.php?spare_id=<?=$row_content["ARL_ART_ID"]?>">
							<? if($paramscount>0) {?>
							<img src="images/cars/params.gif" />
							<? } ?>
							<? if($imagescount>0) {?>
							<img src="images/cars/photo.gif" />
							<? } ?>
							<img src="images/cars/i.gif" />
						</a></td>
						
						<td width="10%"><?=$description?></td>
						
						<td width="5%"><?=$srok?></td>
						<td width="5%"><?=$price?> <?=$currency?></td>
						<td><a href="zakaz.php?spare_id=<?=$row_content["ARL_ART_ID"]?>"><img src="images/basket.png" /></a></td>
						</tr>
<?
				}
			}
			}	
?>						




					</table>
						
					<!-- <div><a href="#" class="links">&nbsp;</a></div> -->
			</div>

				</div>
			</div>
			<!-- end #content -->
		<div id="right_sidebar">
				<ul>
					<li>
						
					</li>
				</ul>
			</div>
			<!-- end #sidebar -->
			<div style="clear: both;">&nbsp;</div>
		</div>
		<!-- end #page -->
	</div>
	<div id="footer-bgcontent">
		<div id="footer">
			<p>Copyright (c) 2010 automas.am All rights reserved. Design by <a href="#">Company name</a>.</p>
		</div>
	</div>
<!-- end #footer -->
</div>
</body>
</html>
