<? 
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//echo "OK";
include "includes/include_inc.php";
//echo "1";
include "includes/function.php";
//echo "2";
include "includes/include_td.php";
?>
<?
if(!isset($_GET["id"])){
	$id = 1;
}
else{
	$id = (int)$_GET["id"];
}
if(CheckId($_GET["id"]) == 0){
	header("Location: index.php?id=1");
}
if($id == 3){
	header("Location: news.php");
}

/*
if(CheckMenuId($_GET["menu_id"]) == 0){
	header("Location: index.php?menu_id=1");
}
*/

$query1 = "select * from menu where type = 'header_menu'";
$result1 = mysql_query($query1) or die(mysql_error());


//$result1 = mysqli_query($link, "select * from menu where type = 'header_menu' ");

$query2 = "select title from menu where id ='$id' ";
$result2 = mysql_query($query2) or die(mysql_error());
$row2 = @mysql_fetch_array($result2);
//$result2 = mysqli_query($link, "select title from menu where id ='$id' ");
//$row2 = @mysqli_fetch_array($result2);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="google-site-verification" content="-N9wPUsNLy6TiB771FQNPjMbHw-_VTbeBeZKCx-SGnc" />
<meta name="google-site-verification" content="-N9wPUsNLy6TiB771FQNPjMbHw-_VTbeBeZKCx-SGnc" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$row2["title"]?> | www.automas.am</title>
<meta name="title" content="automas.am - Web Page">
<meta name="keywords" content="запчасти, неисправные машины, автозапчасти, машины, низкие цены" />
<meta name="description" content="запчасти, неисправные машины, автозапчасти, машины, низкие цены" />
<meta http-equiv="Pragma" content="no-cache">
<meta name="Author" content="Mher Hovsepyan">
<meta name="URL" content="http://www.automas.am">
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js/mail.js" charset="utf-8"></script>
</head>
<body>
<div id="wrapper">
	<div id="wrapper-bgtop">
		<div id="header">
			<div id="logo">
				<h1><a href="http://www.automas.am">automas.am</a></h1>		
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
<!--
			<div id="search">
				<form method="get" action="search.php">
					<fieldset>
					<label style="color:#FFFFFF">Код запчасти (артикул):</label> <input type="text" name="search" id="search-text" size="15" />
					<input type="submit" id="search-submit" value="Поиск >>" />
					</fieldset>
				</form>
			</div>
-->			

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

			
			<div id="content">
				<div class="post">
<?


if($id == 1){
?>				

				<!-- <h2 class="title">Главная</h2> -->

				<div >
<?
$query_content = "select * from cars  LIMIT 4";
$result_content = mysql_query($query_content) or die(mysql_error());

//$result_content = mysqli_query($link, "select * from cars order by cars_id LIMIT 4");
?>								
						<table>
						
						<tr>
						<th colspan="5"><a href="cars.php?type=all">Машины на запчасти</a></th>
						</tr>
<?			
			$count = mysql_num_rows($result_content);
			$cells_count = 0;
			while($row_content = mysql_fetch_array($result_content)){                
				$image1 = "";
				$cars_title = "";
				
				if($row_content["image1"] != ""){
					$image1 = $row_content["image1"];
				}
				
				if ($cells_count % 4 == 0) echo "<tr>";
?>
						
						<td width="25%">
						<? if ($row_content["image1"] != ""){?>
						<a href="cars.php?type=<?=$row_content["cars_title"]?>"><img src="phpthumb/phpThumb.php?src=../cars_image/<?=$image1?>&w=100&fltr[]=wmi|../images/automas.png|BL" class=""/></a>
						<? } else{ ?>
						No picture
						<? } ?>
						</td>
<?
					if (($cells_count + 1) % 4 == 0 || $cells_count == $count - 1) echo "</tr>";			
						$cells_count++;
			}
?>

<?
			$query_content1 = "select * from cars  LIMIT 4";
			$result_content1 = mysql_query($query_content1) or die(mysql_error());

			//$result_content1 = mysqli_query($link, "select * from cars order by cars_id LIMIT 4");
			
			$count = mysql_num_rows($result_content1);
			$cells_count = 0;
			while($row_content = mysql_fetch_array($result_content1)){                
				$image1 = "";
				$cars_title = "";
				
				if($row_content["cars_title"] != ""){
					$cars_title = $row_content["cars_title"];
				}
				
				if ($cells_count % 4 == 0) echo "<tr>";
?>
						
						<td width="25%"><a href="cars.php?type=<?=$row_content["cars_title"]?>"><b><?=$cars_title?></b></a></td>
<?
					if (($cells_count + 1) % 4 == 0 || $cells_count == $count - 1) echo "</tr>";			
						$cells_count++;
			}
?>
						</table>
						
					<!-- <div><a href="#" class="links">&nbsp;</a></div> -->
				</div>

		<div >

		<? 
					$query_content_tecdoc = "SELECT
											MFA_ID,
											MFA_BRAND
										FROM
											MANUFACTURERS
										WHERE MFA_BRAND NOT IN ('AC', 'AIXAM', 'ALPINA', 'ALPINE', 'AMERICANMOTORS(FORD)', 'ARO', 'ASIA MOTORS', 'ASTON MARTIN', 'ASTRA', 'AUSTIN', 'AUSTIN-HEALEY', 'AUTO UNION', 'AUTOBIANCHI', 'BARKAS', 'BEDFORD', 'BENTLEY', 'BERKHOF', 'BERTONE', 'BITTER', 'BMC', 'BOND', 'BORGWARD', 'BOVA', 'BRISTOL', 'BUGATTI', 'CALLAWAY', 'CARBODIES', 'CATERHAM', 'CHECKER', 'DACIA', 'DAIMLER', 'DALLAS', 'DE LOREAN', 'DE TOMASO', 'DENNIS', 'ERF', 'FODEN TRUCKS', 'FORD OTOSAN', 'FORD USA', 'FSO', 'GAZ', 'GEO', 'GINAF', 'GINETTA', 'GLAS', 'GMC', 'GRUAU', 'HINDUSTAN', 'HOBBYCAR', 'HOLDEN', 'INDIGO', 'INNOCENTI', 'IRISBUS', 'IRMSCHER', 'ISDERA', 'ISH', 'JENSEN', 'JIANGLING LANDWIND', 'LADA', 'LAMBORGHINI', 'LDV', 'LIGIER', 'LOTUS', 'LTI', 'MAHINDRA', 'MARCOS', 'MAYBACH', 'MAZ', 'MCLAREN', 'MEGA', 'METROCAB', 'MIDDLEBRIDGE', 'MORGAN', 'MORRIS', 'MOSKVICH', 'MULTICAR', 'NSU', 'OLDSMOBILE', 'OLTCIT', 'OPTARE', 'OSCA', 'PADANE', 'PANOZ', 'PANTHER', 'PAYKAN', 'PIAGGIO', 'PININFARINA', 'PLAXTON', 'PLYMOUTH', 'PREMIER', 'PUCH', 'RANGER', 'RAYTON FISSORE', 'RELIANT', 'RILEY', 'ROLLS-ROYCE', 'SANTANA', 'SHELBY', 'SIPANI', 'SOLARIS', 'SPECTRE', 'STANDARD', 'TALBOT', 'TATA (TELCO)', 'TAZZARI', 'TEMSA', 'TERBERG-BENSCHOP', 'TESLA', 'TRABANT', 'TRIUMPH', 'TVR', 'UAZ', 'UMM', 'VAN HOOL', 'VAUXHALL', 'VECTOR', 'WARTBURG', 'WESTFIELD', 'WIESMANN', 'WOLSELEY', 'YULON', 'ZASTAVA', 'ZAZ')	
											
											
										ORDER BY
											MFA_BRAND ASC";
					$result_content_tecdoc = mysql_query($query_content_tecdoc, $linktd) or die(mysql_error());
					
					
					
					$count = mysql_num_rows($result_content_tecdoc);
					$countColumn = ceil($count / 5);
					
					$sp_name = array();
					while ($s_name = mysql_fetch_assoc($result_content_tecdoc))
					{
						 if ($s_name["MFA_BRAND"] == 'VW' ) $s_name["MFA_BRAND"] = 'VOLKSWAGEN';
						 $sp_name[] = array("spare_menu_id" => $s_name["MFA_ID"], "spare_menu_name" => $s_name["MFA_BRAND"] );
						 
			//			$sp_name[] = $s_name["spare_menu_name"];
					}
					
					$j = 0;
					echo '<table>';
					?>
						<tr>
						<th colspan="5">Автозапчасти – TecDoc</th>
						</tr>
					<?
					for ($i = 0; $i < $countColumn; $i++)
					{
						echo "<tr>";
						for ($j = 0; $j < 5; $j++)
						{
       echo '<td><b><a href="mfc_models.php?spare_menu_id='.$sp_name[$j * $countColumn + $i]["spare_menu_id"].'&brandname='.$sp_name[$j * $countColumn + $i]["spare_menu_name"].'">'.$sp_name[$j * $countColumn + $i]["spare_menu_name"].'</a></b></td>';
							//echo "<td>".$sp_name[$j * $countColumn + $i]."</td>";
						}
						echo "</tr>";
						
						$j++;
					}
					echo '</table>';
					?>

						
					<!-- <div><a href="#" class="links">&nbsp;</a></div> -->
				</div>
				
				<div >
								

					<? 
					$query_content2 = "select * from spare_menu order by spare_menu_name ASC";
					$result_content1 = mysql_query($query_content2) or die(mysql_error());
					
					//$result_content1 = mysqli_query($link, "select * from spare_menu order by spare_menu_name ASC");
					
					$count = mysql_num_rows($result_content1);
					$countColumn = ceil($count / 5);
					
					$sp_name = array();
					while ($s_name = mysql_fetch_assoc($result_content1))
					{
						 $sp_name[] = array("spare_menu_id" => $s_name["spare_menu_id"], "spare_menu_name" => $s_name["spare_menu_name"]
					    );
			//			$sp_name[] = $s_name["spare_menu_name"];
					}
					
					$j = 0;
					echo '<table>';
					?>
						<tr>
						<th colspan="5">Автозапчасти в магазине</th>
						</tr>
					<?
					for ($i = 0; $i < $countColumn; $i++)
					{
						echo "<tr>";
						for ($j = 0; $j < 5; $j++)
						{
       echo '<td><b><a href="spare.php?spare_menu_id='.$sp_name[$j * $countColumn + $i]["spare_menu_id"].'">'.$sp_name[$j * $countColumn + $i]["spare_menu_name"].'</a></b></td>';
							//echo "<td>".$sp_name[$j * $countColumn + $i]."</td>";
						}
						echo "</tr>";
						
						$j++;
					}
					echo '</table>';
					?>

						
					<!-- <div><a href="#" class="links">&nbsp;</a></div> -->
			</div><br />

<!--новости-->
<?
$query_news = "select * from news where news_status = 1 order by news_date desc LIMIT $rows_news_count";
$result_news = mysql_query($query_news) or die(mysql_error());

//$result_news = mysqli_query($link, "select * from news where news_status = 1 order by news_date desc LIMIT $rows_news_count");
?>			

				<h2 style="color:#000066">Новости</h2><br />
				<div >
<?
				while($row_news = mysql_fetch_array($result_news)){
					if($row_news["news_descr"] != ""){
						$news_descr = $row_news["news_descr"];
					}
					if($row_news["news_date"] != ""){
						$news_date = g_SqlDate2Str($row_news["news_date"]);
					}

?>
				<span style="color: #FA8801;"><b><?=$news_date?></b></span><br /><br />
				<li><?=strip_tags(TrimString($news_descr, 250));?>
				<a href="news.php?news_id=<?=(int)$row_news["news_id"]?>">Подробнее</a>
				</li><br />
<?
				}
?>								
				</div>
			
				</div>
			</div>

<? } else



{


 ?>
				<div >
								
<? 

	$query_pages = "select * from pages
						LEFT JOIN menu ON pages.id = menu.id
						 where  pages.id = $id and menu.id = $id  order by pages.pages_date desc";
	$result_pages = mysql_query($query_pages) or die(mysql_error());

/*	$result_pages = mysqli_query($link, "select * from pages
						LEFT JOIN menu ON pages.id = menu.id
						 where  pages.id = $id and menu.id = $id  order by pages.pages_date desc"); */

			if(mysql_num_rows($result_pages) > 0){
				while($row_content = mysql_fetch_array($result_pages)){
					if($row_content["description"] != ""){
						$description  = $row_content["description"];
					}
?>
			<h2><?=$row_content["pages_title"]?></h2><br>
			<p><?=$description;?></p>
<?
				}
			}	
?>						
					<!-- <div><a href="#" class="links">&nbsp;</a></div> -->
					</div>
				</div>
		</div>
	<br />
<? }

?>			
			<!-- end #content -->
			<?
					$query_right = "select * from reclam";
					$result_right = mysql_query($query_right) or die(mysql_error());


					//$result_right = mysqli_query($link, "select * from reclam order by num");
			?>
			<div id="right_sidebar">
				<ul>
					<?
                    while($row_right = @mysql_fetch_array($result_right)){
                        if($row_right["reclam_link"] != ""){
                           $reclam_link = $row_right["reclam_link"];
                        }
                        if($row_right["reclam_image"] != ""){
                           $reclam_image = $row_right["reclam_image"];
                        }
                    ?>
                    <li><a href="http://<?=$reclam_link?>"><img src="reclam_image/<?=$reclam_image?>" width="180px" class=""/></a></li>
                    <?
                    }
                    ?>
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
<div align="center" style="padding-top: 2px;">
<!-- Circle.Am: DO NOT MODIFY THIS CODE: Start -->
<script type="text/javascript">document.write(unescape("%3Cscript src='http://www.circle.am/service/circlecode.php?sid=5128&amp;bid=235' type='text/javascript'%3E%3C/script%3E"));</script>
<noscript>
<div><a href='http://www.circle.am/?w=5128'><img src='http://www.circle.am/service/?sid=5128&amp;bid=235' alt='Circle.Am: Rating and Statistics for Armenian Web Resources' /></a></div>
</noscript>
<!-- Circle.Am: End -->
<!-- begin of Top100 logo -->
<a href="http://top100.rambler.ru/home?id=2109134">
<img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-blue.gif" alt="Rambler's Top100"
width="88" height="31" border="0" /></a>
<!-- end of Top100 logo -->

<a href="http://top.hayastan.com/index.php?act=in&amp;site=2105" target="_blank"><img src="http://top.hayastan.com/index.php?act=image&amp;site=2105" border="0" alt="Current Position" /></a>
</div>
		
	</div>
<!-- end #footer -->
</div>
<!-- begin of Top100 code -->

<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2109134"></script>
<noscript>
<img src="http://counter.rambler.ru/top100.cnt?2109134" alt="" width="1" height="1" border="0" />

</noscript>
<!-- end of Top100 code -->
</body>
</html>
