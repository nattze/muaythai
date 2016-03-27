<?php
include "myConfig.php";
include "./class/myDB.php";

$db1 = new Class_DB();

$db1->connectDB($dbhost,$dbroot,$dbpass,$dbname);

if (isset($_POST['vmode'])){
	//var vmode = $_POST['vmode']);
	if ($_POST['vmode'] == "search") {	
		
		$search_gang = "";
		if ($_POST['gang']=="%"){
			$search_gang = "";
		}else{
			$v_gang = explode("|", $_POST['gang']);
			$search_gang = "and gangId =".$v_gang[0]." ";
		}
		
		$sql_str = "SELECT stageID ,seq ,name ,address1 ,address2 FROM stage a WHERE seq = (select max(aa.seq) from stage aa where aa.stageID=a.stageID) and cancel_flag <>'Y' and ( name like '%".$_POST['name']."%') ".$search_gang." order by stageID;";
		$sql = $db1->query($sql_str);
		$mySubResult = array();
		while($myResult=mysqli_fetch_assoc($sql)){

			$mySubResult['stages'][] = $myResult;
		}
		// $myResult=mysqli_fetch_array($sql);
		// $strResult=json_encode($myResult);
		//echo "err";
		
		if ($sql) {
			if ($db1->num_rows($sql)>0){
				$strResult=json_encode($mySubResult);
			}else{
				$strResult= '{"stages":[{"stageid":"0"}]}';
			}

			echo $strResult;
		}else{
			//echo "failed";
			echo '{"stages":[{"stageid":"0"}]}';
		}
	}else if ($_POST['vmode'] == "update") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"stage" ,"stageid" ,$_POST['stageid']);

		$str = "insert into stage (stageid ,seq  ,name  ,address1 ,address2  ,created_date) values ("
		.$_POST['stageid'].", ".$maxSeq." ,'".$_POST['stagename']."' ,'".$_POST['stageaddr1']."' ,'".$_POST['stageaddr2']."',SYSDATE() ) ;";
		
		$sql = $db1->query($str);
		if ($sql) {
			echo "update complete";
		}else{
			echo "update failed";
		}
	}else if ($_POST['vmode'] == "insert") {
		$maxID = getMaxID($db1 ,$dbname ,"stage" ,"stageid");
		$maxSeq = getMaxSeq($db1 ,$dbname ,"stage" ,"stageid" ,$maxID);
		
		$str = "insert into stage (stageid,seq ,name ,address1 ,address2 ,created_date) values ("
		.$maxID.", ".$maxSeq.",'".$_POST['stagename']."' ,'".$_POST['stageaddr1']."' ,'".$_POST['stageaddr2']."',SYSDATE() ) ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "insert complete";
		}else{
			echo "insert failed";
		}
	}else if ($_POST['vmode'] == "delete") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"stage" ,"stageid" ,$_POST['stageid']);
		$maxSeq = $maxSeq-1;
		$str = "update stage set cancel_flag = 'Y' ,cancel_date = SYSDATE() "
		."where stageid = ".$_POST['stageid']." and seq = ".$maxSeq." ;";
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
