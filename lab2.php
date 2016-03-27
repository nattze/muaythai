<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <p>ทดสอบ jQuery + Json </p>

	<section id="container" class="container">
		<div class="input-group">
		  <span class="input-group-btn">
			<button class="btn btn-default" type="button" id="btnGo">Go!</button>
		  </span>
		  <input type="text" class="form-control" placeholder="Search for..." id="txtSearch">
		</div><!-- /input-group -->	
		<br/>
		<div class="alert alert-info" role="alert">นี่คือ label for Info.</div>
		<!--
		<table class="table table-striped table-bordered table-hover" id="tbl1">
			<tr><td>รหัสนักศึกษา</td><td>คะแนน</td></tr>
			<tr><td>34102065</td><td>98</td></tr>
			<tr><td>34102066</td><td>79</td></tr>
			<tr><td>34102086</td><td>83</td></tr>
		</table>	-->
<?php
		$data = '{"rnField1":{"value":"sss"},"rnField2":{"selectedValues":[{"value":"danut","amount":0,"label":"danut"},{"value":"masmelllo","amount":1,"label":"มาสเมโล่"}]}
		,"rnField3":{"v1":"11","v2":"22"} }';
		
		//$data = '{"rnField1":"xxหห" }';
		//$data = '{"rnField1":{"value":"xx"} }';
		echo "data = ".$data;
		
		echo "<br/>";
		//$myvar = new stdClass();
		$myvar = json_decode($data);
		//$myvar = json_encode($data);
		$txt1 = $myvar->{'rnField1'}->{'value'};
		
		echo "<br/> show node travel";
		echo "<br/>".$txt1; /* */
		echo "<br/>".$myvar->{'rnField3'}->{'v1'};
		
		//$l1 = $myvar->{'rnField3'}->{'v1'};
		echo "<br/>";
		var_dump($myvar->{'rnField2'});
		echo "<br/>".sizeof($myvar->{'rnField2'}->{'selectedValues'}) ;
		
		//echo "<br/>".$myvar->{'rnField2'}->{'selectedValues'} ;
		$mySelect = $myvar->{'rnField2'}->{'selectedValues'} ;
		for ($i=0; $i<sizeof($myvar->{'rnField2'}->{'selectedValues'}); $i++)
			{
				$xx = "";
				$xx = $myvar->{'rnField2'}->{'selectedValues'}[$i]->{'value'};
				
				echo "<br/> i=".$i." data= ".$xx;
				
				if ($i==1){
					//change Name 
					$myvar->{'rnField2'}->{'selectedValues'}[$i]->{'value'} = "new values";
					$xx = $myvar->{'rnField2'}->{'selectedValues'}[$i]->{'value'} ;
					echo "<br/> i=".$i." new data= ".$xx;
				}
			}			
		
		//echo "<br/>"."Length V = ".$l1->length;
		

		
/* 		$json = '{"foo-bar": 12345}';

		$obj = json_decode($json);
		print  "<br/>".$obj->{'foo-bar'}; // 12345		 */
		
/* 		$json = new stdClass(); //$json จะเป็น object โดยสามารถเพิ่ม ตัวแปร ลงไปได้เลยครับ
		//ซึ่งต่างจาก การสร้าง class ปรกติซึ่งต้อง ประกาศตัวแปรก่อน
		$json->id = "portlet-systemquota";
		$json->col = 0;
		$text = json_encode($json);
		echo  $json->id; */
		//ผลลัพท์จะได้
		//{"id":"portlet-systemquota","col":0}
		// และสามารถนำค่าไปใช้งานต่อไปได้ทันทีครับ
		
?>		
	</section>
	
	<script>
		//var data = '{"rnField1":{"value":"sss"},"rnField2":{"selectedValues":[{"value":"danut","amount":0,"label":"danut"}]}}';
		var data = '{"rnField1":{"value":"sss"},"rnField2":{"selectedValues":[{"value":"danut","amount":0,"label":"danut"},{"value":"masmelllo","amount":1,"label":"มาสเมโล่"}]}}';
		objData = JSON.parse(data);
	//http://www.mkyong.com/javascript/how-to-access-json-object-in-javascript/
		$("#btnGo").click(function(){
				//var f1 = objData.rnField1[0].value;
				console.log("rnField1==");
				console.log(objData["rnField1"].value);
				console.log("rnField2==");
				console.log(objData["rnField2"].selectedValues);
				console.log("rnField2 SelectedValue==");
				var rnField2 = objData["rnField2"].selectedValues;		
				console.log(rnField2[0].value+" "+rnField2[0].amount+" "+rnField2[0].label);
				console.log(rnField2[1].value+" "+rnField2[1].amount+" "+rnField2[1].label);
				console.log("edit amount in Object 1");
				rnField2[1].amount = 2;
				console.log(rnField2[1].value+" "+rnField2[1].amount+" "+rnField2[1].label);
				for (i = 0 ; i = objData.length; ++i){
						//console.log(objData[i]);
				}
/* 				for (i = 0 ; i = objData.length; ++i){
						console.log(objData[i]);
				}
				
				objrnField1 = objData.rnField1;
				for (i = 0 ; i = objrnField1.length; ++i){
						console.log(objData[i].value);
				}				 */

				console.log("end***");
		});
	
	</script>
  </body>
</html>