<?
include "includes/include_td.php";
include "includes/function.php";
?>
<?
if(isset($_GET["spare_id"]) && $_GET["spare_id"] != ""){
	$spareid = $_GET["spare_id"];
}

if(isset($_GET["spare_name"]) && $_GET["spare_name"] != ""){
	$spare_name = $_GET["spare_name"];
}

if(isset($_GET["brandname"]) && $_GET["brandname"] != ""){
	$brandname = $_GET["brandname"];
}
if(isset($_GET["modelname"]) && $_GET["modelname"] != ""){
	$modelname = $_GET["modelname"];
}
if(isset($_GET["brandid"]) && $_GET["brandid"] != ""){
	$brandid = $_GET["brandid"];
}
if(isset($_GET["modelid"]) && $_GET["modelid"] != ""){
	$modelid = $_GET["modelid"];
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

			<h2 class="title">Информация о детали </h2><br>
			<h2 class="title"><?=$spare_name?></h2>
			
			<div id="pics">
			
								
<? 
			
			
			
			$query = "
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
	LGA_ART_ID =  ".$spareid." AND
	(GRA_LNG_ID = 16 OR GRA_LNG_ID = 255) AND
	GRA_DOC_TYPE <> 2
ORDER BY
	GRA_GRD_ID"
;
			 
			$result = mysql_query($query) or die(mysql_error());

		
?>

						<table>
						<tr align="left">
						
						
<?

			if(mysql_num_rows($result) > 0){
				while($row_content = mysql_fetch_array($result)){
					if($row_content["PATH"] != ""){
						$PATH  = $row_content["PATH"];
					}
					

?>						
					<? if(!empty($PATH)){?>
						<td align="left" ><img src="<?=$PATH?>" class=""/></td>
						<? } else{?>
						no image
						<? } ?>
						
						
						
					
						
					
<?
				}
			}
				
?>						</tr>
						</table>
						
	
			</div>

			
			<!-- end #pics -->
			
			
			<div id="params">
				<div class="post">
			
								
<? 
					
			$query = "
SELECT distinct
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
ACR_ART_ID = ".$spareid;
			 
			$result = mysql_query($query) or die(mysql_error());

	
?>

						
<?

			if(mysql_num_rows($result) > 0){
?>				
				
				<div >
				
				<table>
						
						<tr>
                            <th><div align="center"><strong>Критерий</strong></div></th>
                            <th><div align="center"><strong>Значение</strong></div></th>
                           
						</tr>
				
<?				
				while($row_content = mysql_fetch_array($result)){
					
					$criteria = "";
					$value = "";
					

					if($row_content["CRITERIA_DES_TEXT"] != ""){
						$criteria  = $row_content["CRITERIA_DES_TEXT"];
					}
					if($row_content["CRITERIA_VALUE_TEXT"] != ""){
						$value  = $row_content["CRITERIA_VALUE_TEXT"];
					}
					

?>						
						<tr class="rowc">
						<td align="left" width="50%"><?=$criteria?></td>
						<td width="50%"><?=$value?></td>
						
						</tr>
<?
				}
					
?>
				</table>
				</div>
<?		}
			
?>					
						
						
				
			

				</div>
			</div>
			<!-- end #params -->
		
	<div id="info">
			
<? 
			
			$query = "
SELECT distinct
	TMT_TEXT AS AIN_TMO_TEXT
FROM
	ARTICLE_INFO
	INNER JOIN TEXT_MODULES ON TMO_ID = AIN_TMO_ID
	INNER JOIN TEXT_MODULE_TEXTS ON TMT_ID = TMO_TMT_ID
WHERE
	AIN_ART_ID = ".$spareid." AND
	TMO_LNG_ID = 16
	
"
;
			 
			$result = mysql_query($query) or die(mysql_error());

		
?>

						<table>
						
						
<?

			if(mysql_num_rows($result) > 0){
				while($row_content = mysql_fetch_array($result)){
					if($row_content["AIN_TMO_TEXT"] != ""){
						$AIN_TMO_TEXT  = $row_content["AIN_TMO_TEXT"];
					}
					

?>						
						<tr class="rowc">
						<td align="left" width="100%"><?=$AIN_TMO_TEXT?></td>
						</tr>
<?
				}
			}
			
				
?>						
						</table>
						
					
			</div>

			
			<!-- end #info -->
				
			<div id= "brands">
			
			
				
				<? 
			
			
			if($spareid=='' or  modelname =='') {
			?>
					<p align="center">По Вашему запросу ничего не найдено</p>
			<? 
			}
			else {
			//$query = "SELECT * FROM spare WHERE  code like '%".$search1."%'  or REPLACE(REPLACE(REPLACE(code,'.',''),'-',''),' ','') like '%".$searchreg."%' ";
			
			$query = "
SELECT DISTINCT
	TYP_ID,
	MFA_BRAND,
	DES_TEXTS7.TEX_TEXT AS MOD_CDS_TEXT,
	DES_TEXTS.TEX_TEXT AS TYP_CDS_TEXT,
	TYP_PCON_START,
	TYP_PCON_END,
	TYP_CCM,
	TYP_KW_FROM,
	TYP_KW_UPTO,
	TYP_HP_FROM,
	TYP_HP_UPTO,
	TYP_CYLINDERS,
	ENGINES.ENG_CODE,
	DES_TEXTS2.TEX_TEXT AS TYP_ENGINE_DES_TEXT,
	DES_TEXTS3.TEX_TEXT AS TYP_FUEL_DES_TEXT,
	IFNULL(DES_TEXTS4.TEX_TEXT, DES_TEXTS5.TEX_TEXT) AS TYP_BODY_DES_TEXT,
	DES_TEXTS6.TEX_TEXT AS TYP_AXLE_DES_TEXT,
	TYP_MAX_WEIGHT
	
	
FROM
	           LINK_ART
	INNER JOIN LINK_LA_TYP ON LAT_LA_ID = LA_ID
	INNER JOIN TYPES ON TYP_ID = LAT_TYP_ID
	INNER JOIN COUNTRY_DESIGNATIONS ON COUNTRY_DESIGNATIONS.CDS_ID = TYP_CDS_ID
	INNER JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = COUNTRY_DESIGNATIONS.CDS_TEX_ID
	INNER JOIN MODELS ON MOD_ID = TYP_MOD_ID
	INNER JOIN MANUFACTURERS ON MFA_ID = MOD_MFA_ID
	INNER JOIN COUNTRY_DESIGNATIONS AS COUNTRY_DESIGNATIONS2 ON COUNTRY_DESIGNATIONS2.CDS_ID = MOD_CDS_ID
	INNER JOIN DES_TEXTS AS DES_TEXTS7 ON DES_TEXTS7.TEX_ID = COUNTRY_DESIGNATIONS2.CDS_TEX_ID
	 LEFT JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = TYP_KV_ENGINE_DES_ID
	 LEFT JOIN DES_TEXTS AS DES_TEXTS2 ON DES_TEXTS2.TEX_ID = DESIGNATIONS.DES_TEX_ID
	 LEFT JOIN DESIGNATIONS AS DESIGNATIONS2 ON DESIGNATIONS2.DES_ID = TYP_KV_FUEL_DES_ID
	 LEFT JOIN DES_TEXTS AS DES_TEXTS3 ON DES_TEXTS3.TEX_ID = DESIGNATIONS2.DES_TEX_ID
	 LEFT JOIN LINK_TYP_ENG ON LTE_TYP_ID = TYP_ID
	 LEFT JOIN ENGINES ON ENG_ID = LTE_ENG_ID
	 LEFT JOIN DESIGNATIONS AS DESIGNATIONS3 ON DESIGNATIONS3.DES_ID = TYP_KV_BODY_DES_ID
	 LEFT JOIN DES_TEXTS AS DES_TEXTS4 ON DES_TEXTS4.TEX_ID = DESIGNATIONS3.DES_TEX_ID
	 LEFT JOIN DESIGNATIONS AS DESIGNATIONS4 ON DESIGNATIONS4.DES_ID = TYP_KV_MODEL_DES_ID
	 LEFT JOIN DES_TEXTS AS DES_TEXTS5 ON DES_TEXTS5.TEX_ID = DESIGNATIONS4.DES_TEX_ID
	 LEFT JOIN DESIGNATIONS AS DESIGNATIONS5 ON DESIGNATIONS5.DES_ID = TYP_KV_AXLE_DES_ID
	 LEFT JOIN DES_TEXTS AS DES_TEXTS6 ON DES_TEXTS6.TEX_ID = DESIGNATIONS5.DES_TEX_ID
WHERE
	LA_ART_ID = ".$spareid." AND
	MOD_ID = ".$modelid." AND
	COUNTRY_DESIGNATIONS.CDS_LNG_ID = 16 AND
	COUNTRY_DESIGNATIONS2.CDS_LNG_ID = 16 AND
	(DESIGNATIONS.DES_LNG_ID IS NULL OR DESIGNATIONS.DES_LNG_ID = 16) AND
	(DESIGNATIONS2.DES_LNG_ID IS NULL OR DESIGNATIONS2.DES_LNG_ID = 16) AND
	(DESIGNATIONS3.DES_LNG_ID IS NULL OR DESIGNATIONS3.DES_LNG_ID = 16) AND
	(DESIGNATIONS4.DES_LNG_ID IS NULL OR DESIGNATIONS4.DES_LNG_ID = 16) AND
	(DESIGNATIONS5.DES_LNG_ID IS NULL OR DESIGNATIONS5.DES_LNG_ID = 16)
ORDER BY
	MFA_BRAND,
	MOD_CDS_TEXT,
	TYP_CDS_TEXT,
	TYP_PCON_START,
	TYP_CCM";
 
			 
			$result = mysql_query($query) or die(mysql_error());


?>

						
<?

			if(mysql_num_rows($result) > 0){
				
?>
			
			<div class="post">
				<h2 class="title">Применяется в следующих моделях</h2>
				
						
					<a href="detailstd.php?spare_id=<?=$spareid?>">Все марки</a><br><br><br>
					<a href="detailstdbybrand.php?spare_id=<?=$spareid?>&brandid=<?=$brandid?>&brandname=<?=$brandname?>">Все модели <?=$brandname?></a><br><br><br>
					
						<h3 class="title">Все модификации  <?=$brandname?> <?=$modelname?></h2>
				<div class="entry">
				<table>
						<tr class="rowc">
                         
						   <th><div align="center"><strong>Модель</strong></div></th>
						    <th><div align="center"><strong>Модификация</strong></div></th>
                          
                            <th><div align="center"><strong>Дата выпуска</strong></div></th>
                            
							<th><div align="center"><strong>Информация</strong></div></th>
                          
                                 
						</tr>
<?				while($row_content = mysql_fetch_array($result)){
					
					
					$TYP_CDS_TEXT = "";

				if($row_content["TYP_ID"] != ""){
						$TYP_ID  = $row_content["TYP_ID"];
				}
				
				if($row_content["TYP_CDS_TEXT"] != ""){
						$TYP_CDS_TEXT  = $row_content["TYP_CDS_TEXT"];
					}
					if($row_content["TYP_PCON_START"] != ""){
						$TYP_PCON_START  = substr($row_content["TYP_PCON_START"],0,4)
							."/" .substr($row_content["TYP_PCON_START"],-2);
					}
					
				if($row_content["TYP_PCON_END"] != ""){
						$TYP_PCON_END  = substr($row_content["TYP_PCON_END"],0,4)
							."/" .substr($row_content["TYP_PCON_END"],-2);
					}
					else 
						$TYP_PCON_END  = 'наст. время';
				if($row_content["TYP_CCM"] != ""){
						$TYP_CCM  = $row_content["TYP_CCM"];
					}
					
				if($row_content["TYP_KW_FROM"] != ""){
						$TYP_KW_FROM  = $row_content["TYP_KW_FROM"];
					}
					
				if($row_content["TYP_KW_UPTO"] != ""){
						$TYP_KW_UPTO  = $row_content["TYP_KW_UPTO"];
					}
					
				if($row_content["TYP_HP_FROM"] != ""){
						$TYP_HP_FROM  = $row_content["TYP_HP_FROM"];
					}
					
				if($row_content["TYP_HP_UPTO"] != ""){
						$TYP_HP_UPTO  = $row_content["TYP_HP_UPTO"];
					}
					
					
					
				if($row_content["TYP_CYLINDERS"] != ""){
						$TYP_CYLINDERS  = $row_content["TYP_CYLINDERS"];
					}
					if($row_content["ENG_CODE"] != ""){
						$ENG_CODE  = $row_content["ENG_CODE"];
					}
					
				if($row_content["TYP_ENGINE_DES_TEXT"] != ""){
						$TYP_ENGINE_DES_TEXT  = $row_content["TYP_ENGINE_DES_TEXT"];
					}
					if($row_content["TYP_FUEL_DES_TEXT"] != ""){
						$TYP_FUEL_DES_TEXT  = $row_content["TYP_FUEL_DES_TEXT"];
					}
					
				if($row_content["TYP_BODY_DES_TEXT"] != ""){
						$TYP_BODY_DES_TEXT  = $row_content["TYP_BODY_DES_TEXT"];
					}
?>						
						<tr class="rowc">
					
						
					<td width="11%"><a href="tree.php?typeid=<?=$TYP_ID?>"><?=$modelname?></a></td>
						<td width="50%"><a href="tree.php?typeid=<?=$TYP_ID?>"><?=$TYP_CDS_TEXT?>;[<?=$ENG_CODE?>] <?=$TYP_ENGINE_DES_TEXT?>;<? if (empty($TYP_HP_TO)) echo $TYP_HP_FROM; else echo $TYP_HP_TO; ?>  л.с.;<?=$TYP_BODY_DES_TEXT?></a></td>
						<td width="15%"><a href="tree.php?typeid=<?=$TYP_ID?>"><?=$TYP_PCON_START?>-<?=$TYP_PCON_END?></a></td>
						
						<td width="25%"><a href="tree.php?typeid=<?=$TYP_ID?>">Обьем двиг.(куб. см):<?=$TYP_CCM?>, Кол. цил. <?=$TYP_CYLINDERS?></a></td>
						</tr>
<?
				}
			}
?>			
			</table>
			</div>
				</div>
<?			
			}	
?>						
						
	
				
			</div>
			
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
