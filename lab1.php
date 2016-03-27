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
    <h1>ทดสอบ jQuery + Json </h1>

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
	</section>
	
	<script>
		var data = '{"rnField1":{"value":"sss"},"rnField2":{"selectedValues":[{"value":"danut","amount":0,"label":"danut"}]}}';
		objData = eval('('+data+')');
		$("#btnGo").click(function(){
				//var f1 = objData.rnField1[0].value;
				
				console.log(data.length);
				
				
				for (i = 0 ; i = objData.length; ++i){
						console.log(objData[i]);
				}
				
				objrnField1 = objData.rnField1;
				for (i = 0 ; i = objrnField1.length; ++i){
						console.log(objData[i].value);
				}				
				//console.log("rnField1 value = "+objrnField1.value);
				
				//objrnField2 = eval('('+objData.rnField2+')'); 
				objrnField2 = objData.rnField2;
				console.log("rnField2 obj = "+objrnField2.selectedValues);
				//console.log("rnField2 object = "+objrnField2.val[0]);
				//console.log("rnField2 value = "+objrnField2.value);
				
				for (index = 0; index < objData.rnField1.length; ++index) {
					console.log("index = "+index);
					console.log(index+" rnField1="+objData.rnField1[index]);
					/*
					newTr += "<tr>";
					newTr += "<td id='stageID'>"+objData.stages[index].stageID+"</td>";
					newTr += "<td id='stageSEQ' hidden='true'>"+objData.stages[index].seq+"</td>";
					newTr += "<td id='stageName' >"+objData.stages[index].name+"</td>";
					newTr += "<td id='stageAddr1' >"+objData.stages[index].address1+"</td>";
					newTr += "<td id='stageAddr2' >"+objData.stages[index].address2+"</td>";
					newTr += "<td>"+"<p><button type='button' id='updateStage' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"+" <button type='button' id='deleteStage' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"+"</td>";
					newTr += "</tr>"; */
				}		
				console.log("end***");
		});
	
	</script>
  </body>
</html>