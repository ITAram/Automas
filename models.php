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
					<label style="color:#FFFFFF">Код запчасти (артикул):</label> <input type="text" name="search" id="search-text" size="15" value="<?=$search1?>"/>
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
		

$query = "SELECT
	MFA_ID,
	MFA_BRAND
FROM
	MANUFACTURERS
ORDER BY
	MFA_BRAND
";
			
			$result = mysql_query($query) or die(mysql_error());
			
			
?>

						<table>
						
						
						
						
<?

			if(mysql_num_rows($result) > 0){
				while($row_content = mysql_fetch_array($result)){
					

					if($row_content["MFA_ID"] != ""){
						$MFA_ID  = $row_content["MFA_ID"];
					}
					
					if($row_content["MFA_BRAND"] != ""){
						$MFA_BRAND  = $row_content["MFA_BRAND"];
					}
					
					
?>						

						
						<tr class="rowc">
						<td align="center" width="20%"><?=$MFA_ID?></td>
						
						
						
						
						<td width="60%"><?=$MFA_ID?></td>
						
						
						</tr>
<?
				}
			}
			else{
?>
					<tr><td colspan=5>По Вашему запросу ничего не найдено</td></tr>
<? 
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
