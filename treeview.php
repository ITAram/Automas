<?
include "includes/include_td.php";
include "includes/function.php";
?>
<?php
$typeid = $_SESSION['typeid'] ;//$_GET['typeid'];
//print_r($_SESSION) ;
if ($_REQUEST['root'] == "source")
{
 $parent =  10001;   /*  10001; legkovye avtomobili*/

 
 }
 else 
 {
	$params = explode("_", $_REQUEST['root']);
	$parent =  $params[1];
	
 } 

$query = "SELECT
	STR_ID,
	TEX_TEXT AS STR_DES_TEXT,
	IF(
		EXISTS(
			SELECT
				*
			FROM
	        	SEARCH_TREE AS SEARCH_TREE2
			WHERE
				SEARCH_TREE2.STR_ID_PARENT <=> SEARCH_TREE.STR_ID
			LIMIT
				1
		), 'true', 'false') AS DESCENDANTS
FROM
	           SEARCH_TREE
	INNER JOIN DESIGNATIONS ON DES_ID = STR_DES_ID
	INNER JOIN DES_TEXTS ON TEX_ID = DES_TEX_ID
WHERE
	STR_ID_PARENT <=> $parent AND
	DES_LNG_ID = 16 AND
	EXISTS (
		SELECT
			*
		FROM
			           LINK_GA_STR
			INNER JOIN LINK_LA_TYP ON LAT_TYP_ID =  $typeid AND
			                          LAT_GA_ID = LGS_GA_ID
			INNER JOIN LINK_ART ON LA_ID = LAT_LA_ID
		WHERE
			LGS_STR_ID = STR_ID
		LIMIT
			1
	)
	ORDER BY STR_DES_TEXT";
	$isdirectory = 0 ;
	$isitem = 0 ;
	$result = mysql_query($query) or die(mysql_error());
	if(mysql_num_rows($result) > 0) $isdirectory = 1;
		else  $isitem = 1;
		
	
	if($isdirectory+$isitem >0)
	{
?>

[
			
<?
		$i = 0;
		while($row_content = mysql_fetch_array($result)){
					if($row_content["STR_ID"] != ""){
						$STR_ID  = $row_content["STR_ID"];
					}
					
					if($row_content["DESCENDANTS"] != ""){
						$DESCENDANTS  = $row_content["DESCENDANTS"];
					}
					
					if($row_content["STR_DES_TEXT"] != ""){
						$STR_DES_TEXT  = $row_content["STR_DES_TEXT"];
						 if ($DESCENDANTS=="false") $STR_DES_TEXT  = "<a href=searchtree.php?typeid=".$typeid."&parent=".$STR_ID.">".$STR_DES_TEXT."</a>";
					}
				
					
					
					if($i++>0) echo ",";
?>		
			
				
						
						{
							"text": "<?=$STR_DES_TEXT?>",
							"id": "<?=$typeid."_".$STR_ID?>",
							"hasChildren": <?=$DESCENDANTS?>,
							"expanded": false,
							"classes": "important"
						}
				
<?
			}
?>				
					
				
			]
 
<? } ?>