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
		
		$sql_str = "SELECT fighterID ,seq ,aliasname ,name ,surname ,dob ,address1 ,address2,(select name from gang where gangid=a.gangid and seq=a.gangseq) Gang ,gangid,gangseq FROM fighter a WHERE seq = (select max(aa.seq) from fighter aa where aa.fighterID=a.fighterID) and cancel_flag <>'Y' and ( aliasname like '%".$_POST['name']."%' or name like '%".$_POST['name']."%' or surname like '%".$_POST['name']."%' ) ".$search_gang." order by fighterID;";
		$sql = $db1->query($sql_str);
		$mySubResult = array();
		while($myResult=mysqli_fetch_assoc($sql)){

			$mySubResult['fighters'][] = $myResult;
		}
		// $myResult=mysqli_fetch_array($sql);
		// $strResult=json_encode($myResult);
		//echo "err";
		
		if ($sql) {
			if ($db1->num_rows($sql)>0){
				$strResult=json_encode($mySubResult);
			}else{
				$strResult= '{"fighters":[{"fighterid":"0"}]}';
			}

			echo $strResult;
		}else{
			//echo "failed";
			echo '{"fighters":[{"fighterid":"0"}]}';
		}
	}else if ($_POST['vmode'] == "update") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"fighter" ,"fighterid" ,$_POST['fighterid']);
		$gandId = explode("|", $_POST['fightergang']);

		// $str = "insert into fighter (fighterid,seq ,name ,address1 ,address2 ,created_date) values ("
		// .$_POST['fighterid'].", ".$maxSeq.",'".$_POST['fightername']."' ,'".$_POST['fighteraddr1']."' ,'".$_POST['fighteraddr2']."',SYSDATE() ) ;";
		$str = "insert into fighter (fighterid,seq ,gangid ,gangseq ,aliasname ,name ,surname ,dob ,address1 ,address2 ,created_date) values ("
		.$_POST['fighterid'].", ".$maxSeq.",".$gandId[0].",".$gandId[1].",'".$_POST['fighteralias']."' ,'".$_POST['fightername']."' ,'".$_POST['fightersurname']."' ,'".$_POST['fighterdob']."' ,'".$_POST['fighteraddr1']."' ,'".$_POST['fighteraddr2']."',SYSDATE() ) ;";
		
		$sql = $db1->query($str);
		if ($sql) {
			echo "update complete";
		}else{
			echo "update failed";
		}
	}else if ($_POST['vmode'] == "insert") {
		$maxID = getMaxID($db1 ,$dbname ,"fighter" ,"fighterid");
		$maxSeq = getMaxSeq($db1 ,$dbname ,"fighter" ,"fighterid" ,$maxID);
		if (isset($_POST['fightergang'])){
			$gandId = explode("|", $_POST['fightergang']);
		}else{
			$gangId = array(null,null);
		}
		
		$str = "insert into fighter (fighterid,seq ,gangid ,gangseq ,aliasname ,name ,surname ,dob ,address1 ,address2 ,created_date) values ("
		.$maxID.", ".$maxSeq.",".$gandId[0].",".$gandId[1].",'".$_POST['fighteralias']."' ,'".$_POST['fightername']."' ,'".$_POST['fightersurname']."' ,'".$_POST['fighterdob']."' ,'".$_POST['fighteraddr1']."' ,'".$_POST['fighteraddr2']."',SYSDATE() ) ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "insert complete";
		}else{
			echo "insert failed";
		}
	}else if ($_POST['vmode'] == "delete") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"fighter" ,"fighterid" ,$_POST['fighterid']);
		$maxSeq = $maxSeq-1;
		$str = "update fighter set cancel_flag = 'Y' ,cancel_date = SYSDATE() "
		."where fighterid = ".$_POST['fighterid']." and seq = ".$maxSeq." ;";
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
