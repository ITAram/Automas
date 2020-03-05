<?
function createCarsList($spare_menu_id) {

	$query2 = "select * from spare_menu";
	$result2 = mysql_query($query2) or die(mysql_error());
	while($row = @mysql_fetch_array($result2)){
		if ($_GET["spare_menu_id"] == $row["spare_menu_id"])
			echo "<option selected value=\"" . $row["spare_menu_id"] . "\">" . $row["spare_menu_name"] . "</option>";
		else
			echo "<option value=\"" . $row["spare_menu_id"] . "\">" . $row["spare_menu_name"] . "</option>";
	}
}

function createYearList($yearID) {
	$date = date("Y");
	for ($i = 2006; $i <= $date; $i++)
		if ($yearID && $yearID == $i)
			echo "<option selected value=\"" . $i . "\">" . $i . "</option>";
		else
			echo "<option value=\"" . $i . "\">" . $i . "</option>";
}
function createMonthListRus($monthID) {
	$months = array(1 => "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
	for ($i = 1; $i <= 12; $i++)
		if ($monthID && $monthID == $i)
			echo "<option selected value=\"" . $i . "\">" . $months[$i] . "</option>";
		else
			echo "<option value=\"" . $i . "\">" . $months[$i] . "</option>";
}
function createMonthListEng($monthID) {
	$months = array(1 => "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	for ($i = 1; $i <= 12; $i++)
		if ($monthID && $monthID == $i)
			echo "<option selected value=\"" . $i . "\">" . $months[$i] . "</option>";
		else
			echo "<option value=\"" . $i . "\">" . $months[$i] . "</option>";
}
function g_Str2SqlDate($strDate, $pings = 0)
{
	
	if ((strlen($strDate) >= 8) && (strlen($strDate) <= 10))
	{
		$tempDate = explode('/', $strDate);

		// See if we got what we thought we should
		if (count ($tempDate) == 3)
		{
			
			$daynum = $tempDate[0] + 0;
			$month = $tempDate[1] + 0;
			$year = $tempDate[2] + 0;
		}
		else
		return '';
	}
	else
	return '';

	$month   = (($month   <  10) ? '0'  . $month   : $month);
	// prepend ZERO, maybe
	$daynum  = (($daynum  <  10) ? '0'  . $daynum   : $daynum);
	// prepend ZERO, maybe
	
	$ret_val = $year. '-' . $month  . '-' . $daynum ;
	if ($pings==1) $ret_val =  "'".$ret_val."'";

	return $ret_val;

}      // g_Date2SqlDate ()
function g_SqlDate2Str( $strSqlDate )
{

	$err = false;
	if (strlen($strSqlDate) == 10)
	{
		$tempDate = explode('-', $strSqlDate);

		// See if we got what we thought we should
		if (count ($tempDate) == 3)
		{
			$year = $tempDate[0];
			$month = $tempDate[1];
			$daynum = $tempDate[2];
		}
		else
		$err = true;
	}
	else
	$err = true;
	if (! $err )
	// mm/dd/yyyy
	return $daynum . '/' . $month . '/' . $year;
	else
	return '';

}      // g_SqlDate2Str ()
function TrimString($string, $maxLength)
{
	$startPos = 0;
	$pos = @strpos($string, " ", $maxLength);
		if ($pos === false)
		{
			$length = strlen($string);
		}
		else
		{
			$length = $pos;
		}
			$new_string = substr ($string, $startPos, $length);
			return $new_string;
}
function CheckId($id)  
	{    

		if (is_numeric($id))	
		return 1;
		else 
		return 0;
	}	
function CheckNewsId($news_id)  
	{    

		if (is_numeric($news_id))	
		return 1;
		else 
		return 0;
	}	
function copyFile($folderPath, $sourceName, $up_filename) {
	if (!file_exists($folderPath)) mkdir($folderPath, 0777);
	if (is_uploaded_file($sourceName['tmp_name'])) {
		if (!@move_uploaded_file($sourceName['tmp_name'], $folderPath . $up_filename)) {
			return false;
		}
	}
	return true;
}

function user_item($table, $showfield, $fieldwhere, $rowname)
{
	$query = @mysql_query("SELECT $showfield FROM $table WHERE $fieldwhere='$rowname'");
	$row = @mysql_fetch_array($query);	
	return str_replace('"', "&quot;", $row[$showfield]);
}

?>
