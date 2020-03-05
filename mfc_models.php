<?
include "includes/include_td.php";
include "includes/function.php";
?>
<?
if(isset($_GET["spare_menu_id"]) && $_GET["spare_menu_id"] != ""){
	$spare_menu_id = $_GET["spare_menu_id"];
}

if(isset($_GET["brandid"]) && $_GET["brandid"] != ""){
	$brandid = $_GET["brandid"];
}
if(isset($_GET["brandname"]) && $_GET["brandname"] != ""){
	$brandname = $_GET["brandname"];
}

$query1 = "select * from menu where type = 'header_menu'";
$result1 = mysql_query($query1) or die(mysql_error());

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

							<a href="mfc_firms.php">Все марки</a><br><br><br>
						
			<div id="content">
				<div class="post">
				<h2 class="title">Все модели <?=$brandname?></h2>
				<div class="entry">
								
<? 
			
		

$query = "SELECT
	MOD_ID,
	TEX_TEXT AS MOD_CDS_TEXT,
	MOD_PCON_START,
	MOD_PCON_END 
FROM
	           MODELS
	INNER JOIN COUNTRY_DESIGNATIONS ON CDS_ID = MOD_CDS_ID
	INNER JOIN DES_TEXTS ON TEX_ID = CDS_TEX_ID
WHERE
	MOD_MFA_ID = ".$spare_menu_id." 
	AND
	CDS_LNG_ID = 16
ORDER BY
	TEX_TEXT
";
			
			$result = mysql_query($query) or die(mysql_error());
			
			
?>

						<table>
						
						<tr>
							<th><div align="center"><strong>Модель</strong></div></th>
                           
                            <th><div align="center"><strong>Выпуск</strong></div></th>
                           
                           
						</tr>
						
						
<?

			if(mysql_num_rows($result) > 0){
				while($row_content = mysql_fetch_array($result)){
					$MOD_CDS_TEXT = "";
					
					$years = "";
					

					if($row_content["MOD_CDS_TEXT"] != ""){
						$MOD_CDS_TEXT  = $row_content["MOD_CDS_TEXT"];
					}
					
					if($row_content["MOD_PCON_START"] != ""){
						$years  = substr($row_content["MOD_PCON_START"],0,4);
					}
					
					if($row_content["MOD_PCON_END"] != ""){
						$years   = $years ."-".substr($row_content["MOD_PCON_END"],0,4);
					}
					else
					$years   = $years ."-наст.время"
?>						

						
						<tr class="rowc">
						<td width="50%"><a href="mfc_modifications.php?modelid=<?=$row_content["MOD_ID"]?>&spare_id=<?=$spare_menu_id?>&brandname=<?=$brandname?>&modelname=<?=$row_content["MOD_CDS_TEXT"]?>"><?=$MOD_CDS_TEXT?></a></td>
						
						
						
						
						<td width="50%"><a href="mfc_modifications.php?modelid=<?=$row_content["MOD_ID"]?>&spare_id=<?=$spare_menu_id?>&brandname=<?=$brandname?>&modelname=<?=$row_content["MOD_CDS_TEXT"]?>"><?=$years?></a></td>
						
						
						</tr>
<?
				}
			}
			else{
?>
					<tr><td colspan=5>По Вашему запросу ничего не найдено</td></tr>
<? 
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
