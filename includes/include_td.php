<?
error_reporting(1);
/*
$host = "localhost";
$login = "root";
$password = "";
$base = "automas";
*/
/*
$link = mysqli_connect("217.113.0.106", "automas_root", "grigor@123","automas_mfc");

if (!$link) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'Success... ' . mysqli_get_host_info($link) . "\n";
*/
$linktd = mysql_connect("localhost", "automas_root", "auto@123mas");
if (!$linktd)
echo 'MYSQL remote server connection problem: '. mysql_error();
mysql_select_db("automas_mfc",$linktd);

session_start();
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");

$rows_show_count = 10;
$rows_news_count = 3;
$rows_search_count = 10;

//error_reporting(0);
/*
$host = "localhost";
$login = "client";
$password = ",O.TxJzW.kIL";
$base = "automas_automas";
$rows_show_count = 10;
$rows_news_count = 3;
$rows_search_count = 10;

mysqli_query($link, "DROP TABLE automas.sadasdasd");
echo mysqli_error();

$link = mysqli_connect($host, $login, $password, $base);
mysqli_query($link, "SET NAMES 'utf8'");
*/
/* check connection */
/*
if (mysqli_connect_errno()){
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} */

?>