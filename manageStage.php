<?php
include "manage_header.php";

$db1 = new Class_DB();

$db1->connectDB($dbhost,$dbroot,$dbpass,$dbname);
/*
 		$sql = $db1->query("SELECT fighterID ,seq ,aliasname ,name ,surname ,dob ,address1 ,address2,(select name from gang where gangid=a.gangid and seq=a.gangseq) Gang ,gangid,gangseq FROM fighter a WHERE seq = (select max(aa.seq) from fighter aa where aa.fighterID=a.fighterID) and cancel_flag <>'Y' and ( aliasname like 'J%' ) order by fighterID; ");
		$mySubResult = array();
		while($myResult=mysqli_fetch_assoc($sql)){

			$mySubResult['gangs'][] = $myResult;
		}

		// $myResult=mysqli_fetch_array($sql);
		// $strResult=json_encode($myResult);
		
		if ($sql) {
			$strResult=json_encode($mySubResult);

			echo $strResult; 
		}else{
			echo "failed";
		} */

/*  Zone setup page Var. */
$sql = $db1->query("SELECT * FROM page_info a WHERE pagename = '".basename(__FILE__, '.php')."';");
$cntrow =$db1->num_rows($sql);

if($cntrow==0){
	$pageName = "";
}else{
	while ($myResult = mysqli_fetch_array($sql)) 
	{
		$pageName = $myResult["pagetitle"];
	}	
}
echo "<input type='hidden' id='pagename' value='".$pageName."' ></input>";
echo "<input type='hidden' id='pageid' value='".basename(__FILE__, '.php')."' ></input>";
/* End Zone setup page Var. */

$sql = $db1->query("SELECT * FROM stage a WHERE seq = (select max(aa.seq) from stage aa where aa.stageID=a.stageID) and cancel_flag <>'Y' order by stageID;");
$rowcnt = $db1->num_rows($sql);

//$sqlGang = $db1->query("SELECT CONCAT(CAST(gangid AS CHAR),'|' ,CAST(seq AS CHAR)) gangid ,Name FROM gang a WHERE seq = (select max(aa.seq) from gang aa where aa.gangid=a.gangid) and cancel_flag <>'Y' order by gangid ");

?>
	
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            	จัดการเวที
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">	
							<!-- filter zone -->
							<button type="button" id = "btn-filter" class="btn btn-success btn-sm" data-toggle="collapse" data-target="#divFilter">
							  <span class="glyphicon glyphicon-collapse-down"></span> Filter
							</button>
							<div id="divFilter" class="collapse">
								<div class="container-fluid">
								<div class="row">
								<div class="form-inline bg-success">
								  <div class="form-group">									
									<label for="txtSearchName" class="">Name</label>
									<input type="text" class="form-control input-sm" id="txtSearchName" placeholder="ค้นหาชื่อ Stage">
								  </div>							  
								  <button type="button" id="btnSearch" class="btn btn-default btn-sm" >OK</button>
								  <button type="button" id="btnSearchClear" class="btn btn-default btn-sm" >Clear</button>
								  
								</div>		
								
								</div>
								</div>
							</div>	
							<!-- /filter zone -->
							
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="stageTable">
                                    <thead>
                                        <tr>
                                            <th>ID#</th>
                                            <th hidden="true">Seq#</th>
                                            <th>Name</th>
                                            <th>Address1</th>	
											<th>Address2</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
										if ($rowcnt==0){
											echo "<tr><td colspan='6'><div >ไม่มีข้อมูล</div></td></tr>"	;
										}else{
										while($myResult=mysqli_fetch_array($sql)){
											echo "<tr>";
											echo "<td id='stageID'>".$myResult[0]."</td>";
											echo "<td id='stageSEQ' hidden='true'>".$myResult[1]."</td>";
											echo "<td id='stageName'>".$myResult["Name"]."</td>";
											echo "<td id='stageAddr1'>".$myResult["Address1"]."</td>";
											echo "<td id='stageAddr2'>".$myResult["Address2"]."</td>";
											echo "<td>"."<p><button type='button' id='updateStage' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"." <button type='button' id='deleteStage' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"."</td>";
											echo "</tr>";
										}
										}
									?>                                    	
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <button type="button" id="insBtn" class="btn btn-info" data-toggle="modal" data-target="#insModal">Add</button>
							
							<!-- Modal delModal -->
							<div class="modal fade bs-example-modal-sm" id="delModal">
							  <div class="modal-dialog modal-sm">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><small class="text-warning"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> ยืนยันการลบข้อมูล</small></h4>
								  </div>
								  <div class="modal-body">
									<div class="alert alert-warning alert-dismissible" role="alert">
									  <input type="hidden" value="" id="hidStageID"></input>
									  <p><strong>Warning!</strong> ต้องการลบข้อมูลใช่หรือไม่?</p>
									  <p>
									  <button type="button" class="btn btn-danger  btn-sm" id="confirmDel">Confirm</button>
									  <button type="button" class="btn btn-default  btn-sm" data-dismiss="modal">Cancel</button>
									  <p>
									</div>
								  </div>
								</div><!-- /.modal-content -->
							  </div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<!-- /Modal delModal -->
							
                            <!-- Modal insModal -->
                            <div class="modal fade" id="insModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><small class="text-info"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> เพิ่มข้อมูล</small></h4>
                                        </div>
                                        <div class="modal-body">
										<div class="container-fluid">
											<div class="row">
												<div class="col-md-4">
													#ID
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsStageID" value="" disabled="disabled" ></input>
												</div>											
											</div>   																					
											<div class="row">
												<div class="col-md-4">
													#Name
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsStageName" placeholder="ชื่อจริง"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#Address1
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsStageAddr1" placeholder="ที่อยู่"></input>
												</div>											
											</div>   
											<div class="row">
												<div class="col-md-4">
													#Address2
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsStageAddr2" placeholder="ที่อยู่"></input>
												</div>											
											</div>   											
										</div> <!-- class="container-fluid" -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default  btn-sm" data-dismiss="modal">Close</button>
                                            <button type="button" id="saveAdd" class="btn btn-primary  btn-sm">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal insModal -->
                            
                            <!-- Modal updModal -->
                            <div class="modal fade" id="updModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"><small class="text-info"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> แก้ไขข้อมูล</small></h4>
                                        </div>
                                        <div class="modal-body">
										<div class="container-fluid">
											<div class="row">
												<div class="col-md-4">
													#ID
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdStageID" value="" disabled="disabled" ></input>
												</div>											
											</div>   																					
											<div class="row">
												<div class="col-md-4">
													#Name
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdStageName" placeholder="ชื่อจริง"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#Address1
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdStageAddr1" placeholder="ที่อยู่"></input>
												</div>											
											</div>   		 																						
											<div class="row">
												<div class="col-md-4">
													#Address2
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdStageAddr2" placeholder="ที่อยู่"></input>
												</div>											
											</div>   																																											</div> <!-- class="container-fluid" -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default  btn-sm" data-dismiss="modal">Close</button>
                                            <button type="button" id="saveUpd" class="btn btn-primary  btn-sm">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal updModal -->

							<!-- Modal alertModal -->
							<div class="modal fade bs-example-modal-sm" id="alertModal">
							  <div class="modal-dialog modal-sm">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><small class="text-info"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Message</small></h4>
								  </div>
								  <div class="modal-body">
									<div class="alert alert-info alert-dismissible" role="alert">
									  <p id="alertMsg" class="text-info text-center"></p>
									  <p class="text-right">
									  <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" id="btnOK">OK</button>
									  <p>
									</div>  
								  </div>
								</div><!-- /.modal-content -->
							  </div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<!-- /Modal alertModal -->							
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->

            </div>
        </div>
        <!-- /#page-wrapper -->


<?php	

	// $msg_info = $x2->get_MsgInfo();
	// echo "message found = ".sizeof($msg_info);
	// echo "<br>show message = ";
	// for ($i=0;$i<=sizeof($msg_info)-1;$i++){
		// echo $msg_info[$i]."<br>";
// 		
	// }
	
	unset($db1);
	// unset($x2);

?>
<script>


$(document).ready(function(){
/* ================== Zone Ready for setup Page Var. =================== */
	$("#pageH1").html($("#pagename").val());
	$("title").html($("#pagename").val());
	$("#subPageName").html("("+$("#pagename").val()+")");
	
	$("#myNavMenu li").each(function(){
		if ($(this).attr("id") == $("#pageid").val()){	
			$(this).addClass("active");	
		}
	});
	
	$("#btnOK").click(function(){
		document.location.reload(true);
	});	
	
/* ==================End Zone Ready for setup Page Var. =================== */

/* ================== Zone Page Action =================== */
	$("#btnSearch").click(function(){
		var str = $("#txtSearchName").val();

		searchStage(str ,"%");
	});
	
	$( "#txtSearchName" ).keypress(function( ev ) {
		var keycode = (ev.keyCode ? ev.keyCode : ev.which);
		if (keycode == '13') {
			$("#btnSearch").click();
		}		
		//console.log( keycode );
	});
	
	$("#btnSearchClear").click(function(){
		$("#txtSearchName").val("");

		searchStage("%" ,"%");
	});
	
	$("#saveUpd").click(function(){
		updateStage('update');
		$('#updModal').modal('hide');
		//location.reload();
	});
	$("#saveAdd").click(function(){
		//alert("you click Add");
		updateStage('insert');
		$('#insModal').modal('hide');
		//location.reload();
	});	
	$("#confirmDel").click(function(){
		//alert("you click Confirm Delete");
		updateStage('delete');
		$('#delModal').modal('hide');
		//location.reload();
	});	
	
	$(":button[id='updateStage']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "stageAddr1") {
				$("#txtUpdStageAddr1").val($(this).html());
			  }		
			  if ($(this).attr("id") == "stageAddr2") {
				$("#txtUpdStageAddr2").val($(this).html());
			  }				  
			  if ($(this).attr("id") == "stageName") {
				$("#txtUpdStageName").val($(this).html());
			  }
			  if ($(this).attr("id") == "stageID") {
				$("#txtUpdStageID").val($(this).html());
			  }							  		  			  	  
			}); 
		});
	});

	$(":button[id='deleteStage']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "stageID") {
				$("#hidStageID").val($(this).html());
			  }							  			  	  
			}); 
		});
	});
/* ==================End Zone Page Action =================== */

});

/* Zone Customize Function */
function searchStage(i_name ,i_gang){
	var objData;
	var UpdateRst;	
	//alert(str);
	$.ajax({
		url:'manageStageCtrl.php',
		type: 'post',
		data: {vmode:'search',name:i_name ,gang:i_gang},
		success: function(data){
			//UpdateRst = data;
			//alert("data="+data);
			//alert("UpdateRst="+UpdateRst);
			//console.log("finish result = "+UpdateRst);
			//setInterval(function () {console.log("finish result = "+UpdateRst);}, 10000);	
			//alert(UpdateRst);	
					
			objData = eval('('+data+')');

			if (objData.stages.length>0){
				//$("#alertMsg").html(objData.gangs[0].name);
				//$('#alertModal').modal('show');	
				//console.log($("#stageTable tbody").html());		
				var newTr="";
 				for (index = 0; index < objData.stages.length; ++index) {
					//console.log(index+" name="+objData.gangs[index].name);
					newTr += "<tr>";
					newTr += "<td id='stageID'>"+objData.stages[index].stageID+"</td>";
					newTr += "<td id='stageSEQ' hidden='true'>"+objData.stages[index].seq+"</td>";
					newTr += "<td id='stageName' >"+objData.stages[index].name+"</td>";
					newTr += "<td id='stageAddr1' >"+objData.stages[index].address1+"</td>";
					newTr += "<td id='stageAddr2' >"+objData.stages[index].address2+"</td>";
					newTr += "<td>"+"<p><button type='button' id='updateStage' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"+" <button type='button' id='deleteStage' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"+"</td>";
					newTr += "</tr>"; /**/
				}
				if(objData.stages[0].stageID>0){
					$("#stageTable tbody").html(newTr);
					//$("#stageTable tbody").replaceWith(newTr);
					//console.log("button update gand id = "+$("#updateGang").attr('id')+" gangName ="+$("#gangName").html());
					$(":button[id='updateStage']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "stageAddr1") {
								$("#txtUpdStageAddr1").val($(this).html());
							  }		
							  if ($(this).attr("id") == "stageAddr2") {
								$("#txtUpdStageAddr2").val($(this).html());
							  }					  		  					
							  if ($(this).attr("id") == "stageName") {
								$("#txtUpdStageName").val($(this).html());
							  }
							  if ($(this).attr("id") == "stageID") {
								$("#txtUpdStageID").val($(this).html());
							  }							  		  			  	  
							}); 
						});
					});	
					
					$(":button[id='deleteStage']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "stageID") {
								$("#hidStageID").val($(this).html());
							  }							  			  	  
							}); 
						});
					});					
				}else { //case no result
					$("#stageTable tbody").html("<tr><td colspan='6'>No Result Data</td></tr>");
				}
			}				

		} ,
		error: function(data){
			UpdateRst = 'failed';
			//console.log("finish result = "+UpdateRst);
			//alert(UpdateRst);
			$("#alertMsg").html(UpdateRst);
			$('#alertModal').modal('show');			
		}
	});	
	//alert(objData);
}

function updateStage(mode){
	//console.log("start update");
	var UpdateRst ="";
	var v_stageid;
	var v_stagealias;
	var v_stagename;
	var v_stagesurname;
	var v_stagedob;
	var v_stageaddr1;
	var v_stageaddr2;
	var v_stagegang;
	
	if (mode=="insert") {
		v_stageid = $("#txtInsStageID").val();
		v_stagename = $("#txtInsStageName").val();
		v_stageaddr1 = $("#txtInsStageAddr1").val();
		v_stageaddr2 = $("#txtInsStageAddr2").val();
	}else if (mode=="update"){
		v_stageid = $("#txtUpdStageID").val();
		v_stagename = $("#txtUpdStageName").val();
		v_stageaddr1 = $("#txtUpdStageAddr1").val();
		v_stageaddr2 = $("#txtUpdStageAddr2").val();
	}else if (mode=="delete"){
		v_stageid = $("#hidStageID").val();
		v_stagealias = "";
	}		
	// console.log("mode="+mode);
	// console.log("v_stageid="+v_stageid);
	$.ajax({
		url:'manageStageCtrl.php',
		type: 'post',
		data: {vmode:mode,stageid:v_stageid,stagename:v_stagename,stageaddr1:v_stageaddr1,stageaddr2:v_stageaddr2},
		success: function(data){
			UpdateRst = data;
			//console.log("finish result = "+UpdateRst);
			//alert(UpdateRst);
			$("#alertMsg").html(UpdateRst);
			$('#alertModal').modal('show');			
		} ,
		error: function(data){
			UpdateRst = 'failed';
			//console.log("finish result = "+UpdateRst);
			//alert(UpdateRst);
			$("#alertMsg").html(UpdateRst);
			$('#alertModal').modal('show');			
		}
	});		
	//console.log("finish result = "+UpdateRst);
}

</script>
	    
<?php
include "manage_footer.php";
?>