<?
include "includes/include_td.php";
include "includes/function.php";
?>
<?


$query1 = "select * from menu where type = 'header_menu'";
$result1 = mysql_query($query1) or die(mysql_error());
$query2 = "select spare_menu_name from spare_menu where spare_menu_id ='$spare_menu_id' ";
$result2 = mysql_query($query2) or die(mysql_error());
$row2 = @mysql_fetch_array($result2);


session_start();
 if(isset($_GET["typeid"]) && $_GET["typeid"] != "")
	{
	$typeid = $_GET["typeid"];
	
	$_SESSION['typeid'] = $_GET["typeid"];
	}
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




<link rel="stylesheet" href="/jquery/jquery.treeview.css" />
  <!-- <link rel="stylesheet" href="/jquery/red-treeview.css" />
 	<link rel="stylesheet" href="/jquery/screen.css" />
	-->
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
	<script src="/jquery/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="/jquery/jquery.treeview.js" type="text/javascript"></script>
	<script src="/jquery/jquery.treeview.async.js" type="text/javascript"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		$("#black").treeview({
			url: "treeview.php?"
		})
	});
	</script>
	
	
	
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
			
					
		
<?


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
						WHERE TYP_ID = $typeid ";
			
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
?>
				
			
	
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
			
			
								
								
		
					<div class="tree">	
						<table>
									<tr>
										<th>Запчасти <?=$MFA_BRAND?> <?=$MODELTYPE?> (<?=$TYP_PCON_START?> - <?=$TYP_PCON_END?> ) </th>
									</tr>
									<!--<h2 class="title">Запчасти <?=$MFA_BRAND?> <?=$MODELTYPE?> (<?=$TYP_PCON_START?> - <?=$TYP_PCON_END?> ) </h2>-->
									<tr><td>
									<ul id="black">
									</ul>
									</td></tr>
			</table>			
					
		</div>
		
	</div>
	<div id="footer-bgcontent">
		<div id="footer">
			<p>Copyright (c) 2010 automas.am All rights reserved. Design by <a href="#">Company name</a>.</p>
		</div>
	</div>	
	</div>


</body>
</html>
