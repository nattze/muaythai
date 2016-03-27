<?php

//$con=mysql_connect($dbhost ,$dbroot ,$dbpass);
//mysql_select_db($dbname ,$con);

$testVar = "ทดสอบ";

class Class_DB
{
	private $chaset="UTF-8";
	private $rs1;
	private $link;
	public function _construct()
	{

	}
	
	function connectDB($host,$root,$pw,$db_name)
	{
		//$link = mysqli_connect($host,$root,$pw) or die(mysqli_error());
		//mysqli_select_db($db_name);
		$this->link = mysqli_connect($host,$root,$pw);
		if ($this->link) 
		{
			//echo "Connected successfully <br>";
			//echo "Connection number = $link->thread_id";
			//mysqli_set_charset($this->link,$this->chaset);
			mysqli_set_charset($this->link,"utf8");
			$result = mysqli_query($this->link ,"use ".$db_name);
			//mysqli_select_db($link ,$db_name);
			//mysqli_close($link);
			//return $link;
		}
		else 
		{
			die('Could not connect: ' . mysqli_error());
		}	
	}
	
	function closeDB()
	{
		mysqli_close($this->ilink);
	}
	
	public function query($strsql)
	{
		return mysqli_query($this->link ,$strsql);
		//return rs1;
	}
	
	public function num_rows($myRs)
	{
		//$myRs = $this->rs1;
		$myNum = mysqli_num_rows($myRs);
		return $myNum;
	}
}

// echo "<br>get MaxID = ".getMaxID($x2 ,$dbname ,"gang" ,"gangid");
// echo " and MaxSeq = ".getMaxSeq($x2 ,$dbname ,"gang" ,"gangid" ,getMaxID($x2 ,$dbname ,"gang" ,"gangid"));

function getMaxID($conn ,$dbname ,$tblname ,$tblkey){ 
	$haveTable = $conn->query("SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$dbname."' and TABLE_NAME='".$tblname."';");
	$numrow =$conn->num_rows($haveTable);
	//echo "Found Table Rows = ".$numrow."<br>";
	if ($numrow = 0 ) {
		return 0;
	}else{
		$selectID = $conn->query("SELECT IFNULL(max(".$tblkey."), 0)+1 maxID FROM ".$tblname." ;");
		//$getMax = $selectID[0];
		$maxID=mysqli_fetch_array($selectID);
		
		return $maxID['maxID'];			
	}	
	return 0;
}

function getMaxSEQ($conn ,$dbname ,$tblname ,$tblkey ,$tblmaxkey){ 
	$haveTable = $conn->query("SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$dbname."' and TABLE_NAME='".$tblname."';");
	$numrow =$conn->num_rows($haveTable);
	//echo "Found Table Rows = ".$numrow."<br>";
	if ($numrow = 0 ) {
		return 0;
	}else{
		$selectID = $conn->query("SELECT IFNULL(max(seq), 0)+1 maxSEQ FROM ".$tblname." WHERE ".$tblkey."= ".$tblmaxkey." ;");
		//SELECT IFNULL(max(seq), 0)+1 maxSEQ from gang WHERE gangid = 1
		$maxID=mysqli_fetch_array($selectID);
		
		return $maxID['maxSEQ'];			
	}	
	return 0;
}
?>
