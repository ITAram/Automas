<?
include "includes/include_td.php";
include "includes/function.php";
?>
<?
if(isset($_GET["parent"]) && $_GET["parent"] != ""){
	$parent = $_GET["parent"];
}
if(isset($_GET["typeid"]) && $_GET["typeid"] != ""){
	$typeid = $_GET["typeid"];
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
				<form method="get" action="searchtd.php">
					<fieldset>
					<label style="color:#FFFFFF">Код запчасти (артикул):</label> <input type="text" name="search" id="search-text" size="10" value="<?=$search1?>"/>
					<input type="submit" id="search-submit" value="Поиск >>" />
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
			
								
<? 
			
			if($parent=='') {
			?>
					<p align="center">По Вашему запросу ничего не найдено !</p>
			<? 
			}
			else {
			//$query = "SELECT * FROM spare WHERE  code like '%".$search1."%'  or REPLACE(REPLACE(REPLACE(code,'.',''),'-',''),' ','') like '%".$searchreg."%' ";
			$query1 = "SELECT 
							DES_TEXTS.TEX_TEXT AS TYP_CDS_TEXT,
							MFA_BRAND,
							TYP_PCON_START,
							TYP_PCON_END
						FROM   TYPES
							INNER JOIN COUNTRY_DESIGNATIONS ON COUNTRY_DESIGNATIONS.CDS_ID = TYP_CDS_ID
							INNER JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = COUNTRY_DESIGNATIONS.CDS_TEX_ID
							INNER JOIN MODELS ON TYP_MOD_ID = MOD_ID 
							INNER JOIN MANUFACTURERS ON MOD_MFA_ID = MFA_ID
						WHERE TYP_ID = $typeid";
			
			$result1 = mysql_query($query1) or die(mysql_error());
			
			
			if(mysql_num_rows($result1) > 0){
				$row_content = mysql_fetch_array($result1);
				if($row_content["TYP_CDS_TEXT"] != ""){
						$MODELTYPE  = $row_content["TYP_CDS_TEXT"] ;
						
					}
			if($row_content["MFA_BRAND"] != ""){
						$MFA_BRAND  = $row_content["MFA_BRAND"] ;
						
					}
			
			if($row_content["TYP_PCON_START"] != ""){
						$TYP_PCON_START  = substr($row_content["TYP_PCON_START"],0,4)
							."/" .substr($row_content["TYP_PCON_START"],-2);
					}
					
			if($row_content["TYP_PCON_END"] != ""){
						$TYP_PCON_END  = substr($row_content["TYP_PCON_END"],0,4)
							."/" .substr($row_content["TYP_PCON_END"],-2);
					}
					else $TYP_PCON_END  = "наст.время";
			
			}
			
			$query2 = "SELECT 
							LA_ART_ID 
							,SUPPLIERS.SUP_BRAND
							,DES_TEXTS.TEX_TEXT
							,ART_ARTICLE_NR
							
						FROM
									   LINK_GA_STR
							INNER JOIN LINK_LA_TYP ON LAT_TYP_ID =  $typeid AND
													  LAT_GA_ID = LGS_GA_ID
							INNER JOIN LINK_ART ON LA_ID = LAT_LA_ID
							INNER JOIN ARTICLES ON LA_ART_ID = ART_ID
							INNER JOIN SUPPLIERS ON ART_SUP_ID = SUP_ID
							INNER JOIN DESIGNATIONS ON DESIGNATIONS.DES_ID = ART_COMPLETE_DES_ID
							INNER JOIN DES_TEXTS ON DES_TEXTS.TEX_ID = DESIGNATIONS.DES_TEX_ID
						WHERE
							LGS_STR_ID =  $parent
							AND (DESIGNATIONS.DES_LNG_ID IS NULL OR DESIGNATIONS.DES_LNG_ID = 16)
    
						ORDER BY
							SUP_BRAND
							,TEX_TEXT";
			$result = mysql_query($query2) or die(mysql_error());
			
			

?>
						
						<div id="content">
				
				<h2 class="title"><a href="tree.php?typeid=<?=$typeid?>">Запчасти <br><?=$MFA_BRAND?> <?=$MODELTYPE?> (<?=$TYP_PCON_START?> - <?=$TYP_PCON_END?> )</a> </h2>
				<div class="entry">
						
						
						<table>
			
						<tr>
							
                            <th><div align="center"><strong>Фирма</strong></div></th>
                            <th><div align="center"><strong>Артикул</strong></div></th>
                            <th><div align="center"><strong>Информация</strong></div></th>
                            
						</tr>
						
						
<?			
			
			if(mysql_num_rows($result) > 0){
?>			
			
<?			
				$ARTNUMBER = "";
				$SPARE_NAME ="";
				while($row_content = mysql_fetch_array($result)){
					
					
					$NEWSPARE_NAME = "";
					
					if($row_content["SUP_BRAND"] != ""){
						$firm  = $row_content["SUP_BRAND"];
					}
					if($row_content["TEX_TEXT"] != ""){
						$NEWSPARE_NAME  = $row_content["TEX_TEXT"];
						IF ($SPARE_NAME!=$NEWSPARE_NAME)
						{
								$SPARE_NAME = $NEWSPARE_NAME;
								$NEW = 1;
						}
						ELSE $NEW = 0 ;
					}
					
					if($row_content["ART_ARTICLE_NR"] != ""){
						$ARTNUMBER  = $row_content["ART_ARTICLE_NR"] ;
						
					}
				
					
					
					if(!empty($row_content["LA_ART_ID"])){
					/* IMAGE OF THE ARTICLE
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
								LGA_ART_ID =  ".$row_content["LA_ART_ID"]." AND
								(GRA_LNG_ID = 16 OR GRA_LNG_ID = 255) AND
								GRA_DOC_TYPE <> 2
							ORDER BY
								GRA_GRD_ID"
							;
			 
					$resultimage = mysql_query($queryimage) ;
					$imagescount = mysql_num_rows($resultimage);
					*/
					$queryparams = "
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
						ACR_ART_ID = ".$row_content["LA_ART_ID"];
									 
					$resultparams = mysql_query($queryparams) ;
					$paramscount = mysql_num_rows($resultparams);
					
					
					}
?>						
					<? if($NEW==1) {?>
						<tr><td colspan=5><?=$SPARE_NAME?></td></tr>
					<? } ?>
						<tr class="rowc">
						
						<td align="center" width="10%"><a style="hover:none; text-decoration:none" href="searchtdlist.php?search=<?=$ARTNUMBER?>&brand_name=<?=$firm?>&artnumber=<?=$ARTNUMBER?>"><?=$firm?> </a></td></td>
						<td width="10%"><a style="hover:none; text-decoration:none" href="searchtdlist.php?search=<?=$ARTNUMBER?>&brand_name=<?=$firm?>&artnumber=<?=$ARTNUMBER?>"><?=$ARTNUMBER?></a></td>
						
						<td width="80%" align = "left">
							<? if($paramscount>0) {?>
							
									<table>
												
										
									<?				
										while($row_content_parmas = mysql_fetch_array($resultparams)){
											
											$criteria = "";
											$value = "";
											

											if($row_content_parmas["CRITERIA_DES_TEXT"] != ""){
												$criteria  = $row_content_parmas["CRITERIA_DES_TEXT"];
											}
											if($row_content_parmas["CRITERIA_VALUE_TEXT"] != ""){
												$value  = $row_content_parmas["CRITERIA_VALUE_TEXT"];
											}
											

									?>						
												<tr >
												<td align="left" ><a style="hover:none; text-decoration:none" href="searchtdlist.php?search=<?=$ARTNUMBER?>&brand_name=<?=$firm?>&artnumber=<?=$ARTNUMBER?>"><?=$criteria?>: <?=$value?><a></td>							
												</tr>
									<?
										}
											
									?>
										</table>
							
							<? } ?>
							
							
						</td>
						
						
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
