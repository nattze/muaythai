<?php
include "myConfig.php";
include "./class/myDB.php";

$db1 = new Class_DB();

$db1->connectDB($dbhost,$dbroot,$dbpass,$dbname);

/*
select * ,RIGHT(resultcode, 3) from result_std
where resultcode like 'WinType%';

*/

if (isset($_POST['vmode'])){
	//var vmode = $_POST['vmode']);
	if ($_POST['vmode'] == "search") {	
		
		$search_type = "";
		if ($_POST['gang']=="%"){
			$search_type = "";
		}else{
			$search_type = "and resultcode like '".$_POST['gang']."%' ";
		}
		
		$sql_str = "SELECT ResultCode ,descThai ,descEng ,Cancel from result_std aa where ( resultcode like '%".$_POST['name']."%' or descThai like '%".$_POST['name']."%' or descEng like '%".$_POST['name']."%' ) ".$search_type." order by ResultCode ;";
		$sql = $db1->query($sql_str);
		$mySubResult = array();
		while($myResult=mysqli_fetch_assoc($sql)){

			$mySubResult['resultstd'][] = $myResult;
		}
		// $myResult=mysqli_fetch_array($sql);
		// $strResult=json_encode($myResult);
		//echo "err";
		
		if ($sql) {
			if ($db1->num_rows($sql)>0){
				$strResult=json_encode($mySubResult);
			}else{
				$strResult= '{"resultstd":[{"ResultCode":"0"}]}';
			}

			echo $strResult;
		}else{
			//echo "failed";
			echo '{"resultstd":[{"ResultCode":"0"}]}';
		}
	}else if ($_POST['vmode'] == "update") {
		$str = "update result_std set "
		."descthai = '".$_POST['resultthai']."' ,desceng ='".$_POST['resulteng']."' ,cancel = '".$_POST['resultcancel']."' where resultcode = '".$_POST['resultcode']."' ;";
		
		$sql = $db1->query($str);
		if ($sql) {
			echo "update complete";
		}else{
			echo "update failed";
		}
	}else if ($_POST['vmode'] == "insert") {

		$rstType="DamageType";
		if (isset($_POST['resultcode'])){
			if (substr($_POST['resultcode'],0,7)=="WinType"){
				$rstType = 	"WinType";
			}else if (substr($_POST['resultcode'],0,7)=="TKOType"){
				$rstType = 	"TKOType";
			}else if (substr($_POST['resultcode'],0,10)=="DamageType"){
				$rstType = 	"DamageType";
			}	
		}

		$sql = "select max(resultcode) from result_std where resultcode like '".$rstType."%' ;";
		$rst = $db1->query($sql);
		while($myResult=mysqli_fetch_array($rst)){
			$maxRst = $myResult[0];
		}

		$sql = "select lpad(RIGHT(resultcode, 3)+1 ,3,'0') from result_std where resultcode ='".$maxRst."' ;";
		$rst = $db1->query($sql);
		while($myResult=mysqli_fetch_array($rst)){
			$newRstCode = $rstType.$myResult[0];
		}
				
		$str = "insert into result_std (resultcode ,descthai ,desceng ,cancel) values ("
		."'".$newRstCode."' ,'".$_POST['resultthai']."' ,'".$_POST['resulteng']."' ,'".$_POST['resultcancel']."' ) ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "insert complete";
		}else{
			echo "insert failed";
		}
	}else if ($_POST['vmode'] == "delete") {
		$str = "delete from result_std "
		."where resultcode = '".$_POST['resultcode']."' ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "delete complete";
		}else{
			echo "delete failed";
		}
	}
	
}else{
	echo "not found mode please contact Admin";
}



?>
