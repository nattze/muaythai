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
			//$search_gang = "and gangId =".$v_gang[0]." and gangSeq=".$v_gang[1]." ";
			$search_gang = "and gangId =".$v_gang[0]." ";
		}
		
		$sql_str = "SELECT programID,seq ,promoterid ,promoterseq ,name ,detail ,(select name from promoter where promoterid=a.promoterid and seq=a.promoterseq) Promotor FROM program a WHERE seq = (select max(aa.seq) from program aa where aa.programID=a.programID) and cancel_flag <>'Y' and ( name like '%".$_POST['name']."%' ) ".$search_gang." order by programID;";
		$sql = $db1->query($sql_str);
		$mySubResult = array();
		while($myResult=mysqli_fetch_assoc($sql)){

			$mySubResult['programs'][] = $myResult;
		}
		// $myResult=mysqli_fetch_array($sql);
		// $strResult=json_encode($myResult);
		//echo "err";
		
		if ($sql) {
			if ($db1->num_rows($sql)>0){
				$strResult=json_encode($mySubResult);
			}else{
				$strResult= '{"programs":[{"programid":"0"}]}';
			}

			echo $strResult;
		}else{
			//echo "failed";
			echo '{"programs":[{"programid":"0"}]}';
		}
	}else if ($_POST['vmode'] == "update") {
		
		$maxSeq = getMaxSeq($db1 ,$dbname ,"program" ,"programid" ,$_POST['programid']);
		$promoterId = explode("|", $_POST['programpromoter']);

		// $str = "insert into fighter (fighterid,seq ,name ,address1 ,address2 ,created_date) values ("
		// .$_POST['fighterid'].", ".$maxSeq.",'".$_POST['fightername']."' ,'".$_POST['fighteraddr1']."' ,'".$_POST['fighteraddr2']."',SYSDATE() ) ;";

		$str = "insert into program (programid,seq ,promoterid ,promoterseq ,name ,detail ,created_date) values ("
		.$_POST['programid'].", ".$maxSeq.",".$promoterId[0].",".$promoterId[1].",'".$_POST['programname']."' ,'".$_POST['programdetail']."' ,SYSDATE() ) ;";
		
		$sql = $db1->query($str);
		if ($sql) {
			echo "update complete";
		}else{
			echo "update failed";
		}
	}else if ($_POST['vmode'] == "insert") {
		$maxID = getMaxID($db1 ,$dbname ,"program" ,"programid");
		$maxSeq = getMaxSeq($db1 ,$dbname ,"program" ,"programid" ,$maxID);
		if (isset($_POST['programpromoter'])){
			$promoterId = explode("|", $_POST['programpromoter']);
		}else{
			$promoterId = array(null,null);
		}
		
		$str = "insert into program (programid,seq ,promoterid ,promoterseq ,name ,detail ,created_date) values ("
		.$maxID.", ".$maxSeq.",".$promoterId[0].",".$promoterId[1].",'".$_POST['programname']."' ,'".$_POST['programdetail']."' ,SYSDATE() ) ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "insert complete";
		}else{
			echo "insert failed";
		}
	}else if ($_POST['vmode'] == "delete") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"program" ,"programid" ,$_POST['programid']);
		$maxSeq = $maxSeq-1;
		$str = "update program set cancel_flag = 'Y' ,cancel_date = SYSDATE() "
		."where programid = ".$_POST['programid']." and seq = ".$maxSeq." ;";
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
