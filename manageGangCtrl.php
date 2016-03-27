<?php
include "myConfig.php";
include "./class/myDB.php";

$db1 = new Class_DB();

$db1->connectDB($dbhost,$dbroot,$dbpass,$dbname);

// $x2 = new Class_DB();
// $x2->connectDB($dbhost,$dbroot,$dbpass,$dbname);
// $sql = $x2->query("select * from gang");
// while($myResult2=mysqli_fetch_array($sql)){
// 
	// echo "<br>class_DB x2 : ".$myResult2[2]."  <br>";
	// echo "rows = ".$x2->get_numrows();
	// echo "<br>class_DB x2 rows : ".$x2->get_numrows();
// }
// 
// echo "<br>get MaxID = ".getMaxID($x2 ,$dbname ,"gang" ,"gangid");
// echo " and MaxSeq = ".getMaxSeq($x2 ,$dbname ,"gang" ,"gangid" ,1);

if (isset($_POST['vmode'])){
	if ($_POST['vmode'] == "search") {
		
		$sql = $db1->query("select gangid ,seq ,name ,address1 ,address2 from gang a where seq = (select max(aa.seq) from gang aa where aa.gangid=a.gangid) and cancel_flag <>'Y' and name like '%".$_POST['gangname']."%' order by gangid;");
		$mySubResult = array();
		while($myResult=mysqli_fetch_assoc($sql)){

			$mySubResult['gangs'][] = $myResult;
		}
		// $myResult=mysqli_fetch_array($sql);
		// $strResult=json_encode($myResult);
		//echo "err";
		
		if ($sql) {
			if ($db1->num_rows($sql)>0){
				$strResult=json_encode($mySubResult);
			}else{
				$strResult= '{"gangs":[{"gangid":"0"}]}';
			}

			echo $strResult;
		}else{
			//echo "failed";
			echo '{"gangs":[{"gangid":"0"}]}';
		}
	}else if ($_POST['vmode'] == "update") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"gang" ,"gangid" ,$_POST['gangid']);
		
		$str = "insert into gang (gangid,seq ,name ,address1 ,address2 ,created_date) values ("
		.$_POST['gangid'].", ".$maxSeq.",'".$_POST['gangname']."' ,'".$_POST['gangaddr1']."' ,'".$_POST['gangaddr2']."',SYSDATE() ) ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "update complete";
		}else{
			echo "update failed";
		}
	}else if ($_POST['vmode'] == "insert") {
		$maxID = getMaxID($db1 ,$dbname ,"gang" ,"gangid");
		$maxSeq = getMaxSeq($db1 ,$dbname ,"gang" ,"gangid" ,$maxID);
		
		$str = "insert into gang (gangid,seq ,name ,address1 ,address2 ,created_date) values ("
		.$maxID.", ".$maxSeq.",'".$_POST['gangname']."' ,'".$_POST['gangaddr1']."' ,'".$_POST['gangaddr2']."',SYSDATE() ) ;";
		$sql = $db1->query($str);
		if ($sql) {
			echo "insert complete";
		}else{
			echo "insert failed";
		}
	}else if ($_POST['vmode'] == "delete") {
		$maxSeq = getMaxSeq($db1 ,$dbname ,"gang" ,"gangid" ,$_POST['gangid']);
		$maxSeq = $maxSeq-1;
		$str = "update gang a set cancel_flag = 'Y' ,cancel_date = SYSDATE() "
		."where gangid = ".$_POST['gangid']." and seq = ".$maxSeq." ;";
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
