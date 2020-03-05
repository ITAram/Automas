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
if(isset($_GET["brandid"]) && $_GET["brandid"] != ""){
	$brandid = $_GET["brandid"];
}
if(isset($_GET["brandname"]) && $_GET["brandname"] != ""){
	$brandname = $_GET["brandname"];
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
<meta name="Author" content="Mher Hovsepyan">
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

			
			
			<div id="pics">
			<h2 class="title">Информация о детали </h2><br>
			<h2 class="title"><?=$spare_name?></h2>
								
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
SELECT  distinct
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
			
			
			if($spareid=='' ||  $brandid =='') {
			?>
					<p align="center">По Вашему запросу ничего не найдено</p>
			<? 
			}
			else {
			//$query = "SELECT * FROM spare WHERE  code like '%".$search1."%'  or REPLACE(REPLACE(REPLACE(code,'.',''),'-',''),' ','') like '%".$searchreg."%' ";
			
			$query = "
SELECT distinct 
	MANUFACTURERS.MFA_ID AS MFA_ID,
	MANUFACTURERS.MFA_BRAND,
	MODELS.MOD_ID AS MOD_ID,
	DES_TEXTS7.TEX_TEXT AS MOD_CDS_TEXT
	
FROM
	           LINK_ART
	INNER JOIN LINK_LA_TYP ON LAT_LA_ID = LA_ID
	INNER JOIN TYPES ON TYP_ID = LAT_TYP_ID
	
	INNER JOIN MODELS ON MOD_ID = TYP_MOD_ID
	INNER JOIN COUNTRY_DESIGNATIONS AS COUNTRY_DESIGNATIONS2 ON COUNTRY_DESIGNATIONS2.CDS_ID = MOD_CDS_ID
	INNER JOIN DES_TEXTS AS DES_TEXTS7 ON DES_TEXTS7.TEX_ID = COUNTRY_DESIGNATIONS2.CDS_TEX_ID
	INNER JOIN MANUFACTURERS ON MFA_ID = MOD_MFA_ID
WHERE
	LA_ART_ID = ".$spareid." 
	AND MFA_ID = ".$brandid." 
	AND COUNTRY_DESIGNATIONS2.CDS_LNG_ID = 16
ORDER BY
	
	MOD_CDS_TEXT";
 
			 
			$result = mysql_query($query) or die(mysql_error());


?>

						
<?

			if(mysql_num_rows($result) > 0){
				
?>
			
			<div class="post">
				<h2 class="title">Применяется в следующих моделях</h2>
				<div >
				<table>
						
						
						<tr class="rowc">
							<a href="detailstd.php?spare_id=<?=$spareid?>">Все марки</a><br><br><br>
						</tr>
						
						<tr class="rowc">
							 <?=$brandname?><br><br><br>
						</tr>
						
<?				while($row_content = mysql_fetch_array($result)){
					
					
					$MOD_CDS_TEXT = "";
					

				
					if($row_content["MOD_CDS_TEXT"] != ""){
						$MOD_CDS_TEXT  = $row_content["MOD_CDS_TEXT"];
					}
					
			
?>						
						<tr class="rowc">
							
						
						<a href="detailstdbymodel.php?spare_id=<?=$spareid?>&brandid=<?=$row_content["MFA_ID"]?>&modelid=<?=$row_content["MOD_ID"]?>&brandname=<?=$brandname?>&modelname=<?=$MOD_CDS_TEXT?>&spare_name=<?=urlencode($spare_name)?>"><?=$MOD_CDS_TEXT?></a>&nbsp
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
