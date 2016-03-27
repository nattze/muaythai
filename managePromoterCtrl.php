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
		
		$sql_str = "SELECT promoterID ,seq ,name ,dob FROM promoter a WHERE seq = (select max(aa.seq) from promoter aa where aa.promoterID=a.promoterID) and cancel_flag <>'Y' and ( name like '%".$_POST['name']."%') ".$search_gang." order by promoterID;";
		$sql = $db1->query($sql_str);
		$mySubResult = array();
		while($myResult=mysqli_fetch_assoc($sql)){

			$mySubResult['promoters'][] = $myResult;
		}
		// $myResult=mysqli_fetch_array($sql);
		// $strResult=json_encode($myResult);
		//echo "err";
		
		if ($sql) {
			if ($db1->num_rows($sql)>0){
				$strResult=json_encode($mySubResult);
			}else{
				$strResult= '{"promoters":[{"promoterid":"0"}]}';
			}

			echo $strResult;
		}else{
			//echo "failed";
			echo '{"promoters":[{"promoterid":"0"}]}';
		}
	}else if ($_POST['vmode'] == "update") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"promoter" ,"promoterid" ,$_POST['promoterid']);

		$str = "insert into promoter (promoterid ,seq  ,name  ,dob ,created_date) values ("
		.$_POST['promoterid'].", ".$maxSeq." ,'".$_POST['promotername']."' ,'".$_POST['promoterdob']."',SYSDATE() ) ;";
		
		$sql = $db1->query($str);
		if ($sql) {
			echo "update complete";
		}else{
			echo "update failed";
		}
	}else if ($_POST['vmode'] == "insert") {
		$maxID = getMaxID($db1 ,$dbname ,"promoter" ,"promoterid");
		$maxSeq = getMaxSeq($db1 ,$dbname ,"promoter" ,"promoterid" ,$maxID);
		
		$str = "insert into promoter (promoterid,seq ,name ,dob,created_date) values ("
		.$maxID.", ".$maxSeq.",'".$_POST['promotername']."' ,'".$_POST['promoterdob']."',SYSDATE() ) ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "insert complete";
		}else{
			echo "insert failed";
		}
	}else if ($_POST['vmode'] == "delete") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"promoter" ,"promoterid" ,$_POST['promoterid']);
		$maxSeq = $maxSeq-1;
		$str = "update promoter set cancel_flag = 'Y' ,cancel_date = SYSDATE() "
		."where promoterid = ".$_POST['promoterid']." and seq = ".$maxSeq." ;";
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
