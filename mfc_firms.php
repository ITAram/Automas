<?
include "includes/include_td.php";
include "includes/function.php";
?>
<?


$query1 = "select * from menu where type = 'header_menu'";
$result1 = mysql_query($query1) or die(mysql_error());

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

							<div class="entry">
								

					<? 
					$query_content2 = "SELECT
											MFA_ID,
											MFA_BRAND
										FROM
											MANUFACTURERS
										WHERE MFA_BRAND NOT IN ('AC', 'AIXAM', 'ALPINA', 'ALPINE', 'AMERICANMOTORS(FORD)', 'ARO', 'ASIA MOTORS', 'ASTON MARTIN', 'ASTRA', 'AUSTIN', 'AUSTIN-HEALEY', 'AUTO UNION', 'AUTOBIANCHI', 'BARKAS', 'BEDFORD', 'BENTLEY', 'BERKHOF', 'BERTONE', 'BITTER', 'BMC', 'BOND', 'BORGWARD', 'BOVA', 'BRISTOL', 'BUGATTI', 'CALLAWAY', 'CARBODIES', 'CATERHAM', 'CHECKER', 'DACIA', 'DAIMLER', 'DALLAS', 'DE LOREAN', 'DE TOMASO', 'DENNIS', 'ERF', 'FODEN TRUCKS', 'FORD OTOSAN', 'FORD USA', 'FSO', 'GAZ', 'GEO', 'GINAF', 'GINETTA', 'GLAS', 'GMC', 'GRUAU', 'HINDUSTAN', 'HOBBYCAR', 'HOLDEN', 'INDIGO', 'INNOCENTI', 'IRISBUS', 'IRMSCHER', 'ISDERA', 'ISH', 'JENSEN', 'JIANGLING LANDWIND', 'LADA', 'LAMBORGHINI', 'LDV', 'LIGIER', 'LOTUS', 'LTI', 'MAHINDRA', 'MARCOS', 'MAYBACH', 'MAZ', 'MCLAREN', 'MEGA', 'METROCAB', 'MIDDLEBRIDGE', 'MORGAN', 'MORRIS', 'MOSKVICH', 'MULTICAR', 'NSU', 'OLDSMOBILE', 'OLTCIT', 'OPTARE', 'OSCA', 'PADANE', 'PANOZ', 'PANTHER', 'PAYKAN', 'PIAGGIO', 'PININFARINA', 'PLAXTON', 'PLYMOUTH', 'PREMIER', 'PUCH', 'RANGER', 'RAYTON FISSORE', 'RELIANT', 'RILEY', 'ROLLS-ROYCE', 'SANTANA', 'SHELBY', 'SIPANI', 'SOLARIS', 'SPECTRE', 'STANDARD', 'TALBOT', 'TATA (TELCO)', 'TAZZARI', 'TEMSA', 'TERBERG-BENSCHOP', 'TESLA', 'TRABANT', 'TRIUMPH', 'TVR', 'UAZ', 'UMM', 'VAN HOOL', 'VAUXHALL', 'VECTOR', 'WARTBURG', 'WESTFIELD', 'WIESMANN', 'WOLSELEY', 'YULON', 'ZASTAVA', 'ZAZ')	
											
											
										ORDER BY
											MFA_BRAND ASC";
					$result_content1 = mysql_query($query_content2) or die(mysql_error());
					
					
					
					$count = mysql_num_rows($result_content1);
					$countColumn = ceil($count / 5);
					
					$sp_name = array();
					while ($s_name = mysql_fetch_assoc($result_content1))
					{
						 $sp_name[] = array("spare_menu_id" => $s_name["MFA_ID"], "spare_menu_name" => $s_name["MFA_BRAND"]
					    );
			//			$sp_name[] = $s_name["spare_menu_name"];
					}
					
					$j = 0;
					echo '<table>';
					?>
						<tr>
						<th colspan="5">Автозапчасти</th>
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
			</div><br />
			
			
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
