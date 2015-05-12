<?php
$LastModified = gmdate("D d M Y H:i:s", filemtime($HTTP_SERVER_VARS[SCRIPT_FILENAME]));
header("Last-Modified: $LastModified GMT");
header("ETag: $LastModified");
ob_start();
include "./config/dbconn_2.inc.php";

if (!$_COOKIE['SET_COOK']) {
	$SET_COOK=md5(uniqid(rand()));
	setcookie("SET_COOK","$SET_COOK",time()+600,"/");
	//setcookie("SET_COOK","$SET_COOK","0","/");

	$date=date("Y-m-d");

	$cou=mysql_query("select * from Mcount where wdate='$date'",$dbconn);
	$cou_row=mysql_fetch_row($cou);

	if (!$cou_row[0]) {
		$count=mysql_query("INSERT INTO Mcount values ('$date',1)",$dbconn);
	}else{
		$count=mysql_query("UPDATE Mcount SET count=count+1 where wdate='$date'",$dbconn);
	}


	$course=$_SERVER["HTTP_REFERER"];
	$IP=$_SERVER["REMOTE_ADDR"];
	$DateTime=date("Y-m-d H:i:s");
	//	echo "$HTTP_REFERER";
	$query = "INSERT INTO Log_analysis VALUES (";
	$query.= "'$DateTime',";
	$query.= "'$course',";
	$query.= "'$IP')";
	$result=mysql_query($query,$dbconn);
	//setcookie("SET_TIME","$DateTime","0","/");
}
?>