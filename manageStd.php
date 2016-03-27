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


$sql = $db1->query("SELECT ResultCode ,descThai ,descEng ,Cancel from result_std aa where 1=1 order by ResultCode;");
$rowcnt = $db1->num_rows($sql);

$sqlGang = $db1->query("SELECT CONCAT(CAST(gangid AS CHAR),'|' ,CAST(seq AS CHAR)) gangid ,Name FROM gang a WHERE seq = (select max(aa.seq) from gang aa where aa.gangid=a.gangid) and cancel_flag <>'Y' order by gangid ");

/*
select * ,RIGHT(resultcode, 3) from result_std
where resultcode like 'WinType%';

*/
?>
	
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            	ข้อมูลมาตรฐาน
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
									<label for="txtSearchName" class="">CodeName</label>
									<input type="text" class="form-control input-sm" id="txtSearchName" placeholder="ค้นหารหัส">
								  </div>
								  <div class="form-group">									
									<label for="listSearchRst" class="">Type</label>
									<select class="form-control  input-sm" id="listSearchRst"></select>
								  </div>								  
								  <button type="button" id="btnSearch" class="btn btn-default btn-sm" >OK</button>
								  <button type="button" id="btnSearchClear" class="btn btn-default btn-sm" >Clear</button>
								  
								</div>		
								
								</div>
								</div>
							</div>	
							<!-- /filter zone -->
							
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="gangTable">
                                    <thead>
                                        <tr>
                                            <th>Code#</th>
                                            <th>ThaiDescr</th>
                                            <th>EngDescr</th>
                                            <th>Cancel</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
										if ($rowcnt==0){
											echo "<tr><td colspan='5'><div >ไม่มีข้อมูล</div></td></tr>"	;
										}else{
										while($myResult=mysqli_fetch_array($sql)){
											echo "<tr>";
											echo "<td id='resultCode'>".$myResult["ResultCode"]."</td>";
											echo "<td id='resultThai'>".$myResult["descThai"]."</td>";
											echo "<td id='resultEng'>".$myResult["descEng"]."</td>";
											echo "<td id='resultCancel'>".$myResult["Cancel"]."</td>";
											echo "<td>"."<p><button type='button' id='updateResult' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"." <button type='button' id='deleteResult' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"."</td>";
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
									  <input type="hidden" value="" id="hidResultCode"></input>
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
													#CodeType
												</div>
												<div class="col-md-4">
													<select class="form-control" id="txtInsResultCode"></select>
												</div>											
											</div> 
											<div class="row">
												<div class="col-md-4">
													#ThaiDescr
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsResultThai" placeholder="คำอธิบายไทย"></input>
												</div>											
											</div>  																					
											<div class="row">
												<div class="col-md-4">
													#EngDescr
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsResultEng" placeholder="คำอธิบายอังกฤษ"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#Cancel
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsResultCancel" disabled placeholder=""></input>
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
													#Code
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdResultCode" value="" disabled="disabled" ></input>
												</div>											
											</div> 
											<div class="row">
												<div class="col-md-4">
													#ThaiDescr
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdResultThai" placeholder="คำอธิบายไทย"></input>
												</div>											
											</div>  																					
											<div class="row">
												<div class="col-md-4">
													#EngDescr
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdResultEng" placeholder="คำอธิบายอังกฤษ"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#Status
												</div>
												<div class="col-md-4">
													<div class="checkbox">
													  <label><input type="checkbox" class="" value="Y" id="txtUpdResultCancel">Cancel</label>
													</div>													
												</div>											
											</div>     																																                                        </div> <!-- class="container-fluid" -->
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
echo "<select id='listGang' class='form-control'>";
echo "<option value='0|0'>------ เลือกค่าย ------</option>";
while($myResult=mysqli_fetch_array($sqlGang)){
	echo "<option value='".$myResult["gangid"]."'>".$myResult["Name"]."</option>";
}
echo "</select>";
echo "<select id='listGrpRst' class='form-control'>";
echo "<option value=''>------ เลือกประเภท ------</option>";
echo "<option value='WinType'>"."ประเภทคำตัดสิน"."</option>";
echo "<option value='TKOType'>"."ประเภทการยุติการชก"."</option>";
echo "<option value='DamageType'>"."ประเภทการบาดเจ็บ"."</option>";
echo "</select>";


?>

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
	$("#listGang").hide();
	$("#listGrpRst").hide();
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
	
	$("#listSearchGang").html($("#listGang").html());
	$("#listSearchRst").html($("#listGrpRst").html());
	$("#listSearchRst").val("DamageType");
	
/* ==================End Zone Ready for setup Page Var. =================== */

/* ================== Zone Page Action =================== */
	$("#insBtn").click(function(){
		$("#txtInsResultCode").html($("#listGrpRst").html());
	});
	
	$("#saveAdd").click(function(){
		//alert("you click Add");
		updateResult('insert');
		$('#insModal').modal('hide');
		//location.reload();
		//document.location.reload(true);
	});	

	$("#saveUpd").click(function(){
		updateResult('update');
		$('#updModal').modal('hide');
		//location.reload();
	});

	$("#confirmDel").click(function(){
		//alert("you click Confirm Delete");
		updateResult('delete');
		$('#delModal').modal('hide');
		//location.reload();
	});	
	
	$(":button[id='updateResult']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			//console.log("In Doc. on evn cick button update gand id = "+$("#updateResult").attr('id')+" gangName ="+$("#gangName").html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "resultCode") {
				$("#txtUpdResultCode").val($(this).html());
			  }
			  if ($(this).attr("id") == "resultThai") {
				$("#txtUpdResultThai").val($(this).html());
			  }		
			  if ($(this).attr("id") == "resultEng") {
				$("#txtUpdResultEng").val($(this).html());
			  }	
			  if ($(this).attr("id") == "resultCancel") {
				if ($(this).html()=="Y"){
					$("#txtUpdResultCancel").prop("checked",true);
				}else{
					$("#txtUpdResultCancel").prop("checked",false);
				}
				//$("#txtUpdResultCancel").val($(this).html());
			  }				  			  	  
			}); 
		});
	});

	$(":button[id='deleteResult']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "resultCode") {
				$("#hidResultCode").val($(this).html());
			  }							  			  	  
			}); 
		});
	});	

	$("#btnSearch").click(function(){
		var str = $("#txtSearchName").val();
		var type = $("#listSearchRst").val();
		if (type == ""){
			type = "%";
		}
		//alert(str);		
		if (str.length==0) {
			str = "%";
		}
		searchResult(str ,type);
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
		$("#listSearchRst").val("DamageType");

		searchResult("%" ,"DamageType");
	});	
/* ==================End Zone Page Action =================== */

});

/* Zone Customize Function */
function searchResult(i_name ,i_gang){
	var objData;
	var UpdateRst;	
	//alert(str);
	$.ajax({
		url:'manageStdCtrl.php',
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

			if (objData.resultstd.length>0){
				//$("#alertMsg").html(objData.gangs[0].name);
				//$('#alertModal').modal('show');	
				//console.log($("#gangTable tbody").html());		
				var newTr="";
 				for (index = 0; index < objData.resultstd.length; ++index) {
					//console.log(index+" name="+objData.resultstd[index].ResultCode);			
					newTr += "<tr>";
					newTr += "<td id='resultCode'>"+objData.resultstd[index].ResultCode+"</td>";
					newTr += "<td id='resultThai' >"+objData.resultstd[index].descThai+"</td>";
					newTr += "<td id='resultEng' >"+objData.resultstd[index].descEng+"</td>";
					newTr += "<td id='resultCancel' >"+(objData.resultstd[index].Cancel==null?"":objData.resultstd[index].Cancel)+"</td>";
					newTr += "<td>"+"<p><button type='button' id='updateResult' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"+" <button type='button' id='deleteResult' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"+"</td>";
					newTr += "</tr>"; /**/
				}
				if(objData.resultstd[0].ResultCode!="0"){ 
					$("#gangTable tbody").html(newTr);
					//$("#gangTable tbody").replaceWith(newTr);
					//console.log("button update gand id = "+$("#updateGang").attr('id')+" gangName ="+$("#gangName").html());
					$(":button[id='updateResult']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							//console.log("In Doc. on evn cick button update gand id = "+$("#updateResult").attr('id')+" gangName ="+$("#gangName").html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "resultCode") {
								$("#txtUpdResultCode").val($(this).html());
							  }
							  if ($(this).attr("id") == "resultThai") {
								$("#txtUpdResultThai").val($(this).html());
							  }		
							  if ($(this).attr("id") == "resultEng") {
								$("#txtUpdResultEng").val($(this).html());
							  }	
							  if ($(this).attr("id") == "resultCancel") {
								if ($(this).html()=="Y"){
									$("#txtUpdResultCancel").prop("checked",true);
								}else{
									$("#txtUpdResultCancel").prop("checked",false);
								}
								//$("#txtUpdResultCancel").val($(this).html());
							  }				  			  	  
							}); 
						});
					});

					$(":button[id='deleteResult']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "resultCode") {
								$("#hidResultCode").val($(this).html());
							  }							  			  	  
							}); 
						});
					});			
				}else { //case no result
					$("#gangTable tbody").html("<tr><td colspan='5'>No Result Data</td></tr>");
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

function updateResult(mode){
	//console.log("start update");
	var UpdateRst ="";
	var v_resultCode;
	var v_resultThai;
	var v_resultEng;
	var v_resultCancel;
	
	if (mode=="insert") {	
		v_resultCode = $("#txtInsResultCode").val();
		v_resultThai = $("#txtInsResultThai").val();
		v_resultEng = $("#txtInsResultEng").val();
		v_resultCancel = $("#txtInsResultCancel").val();		
	}else if (mode=="update"){
		v_resultCode = $("#txtUpdResultCode").val();
		v_resultThai = $("#txtUpdResultThai").val();
		v_resultEng = $("#txtUpdResultEng").val();
		if ($("#txtUpdResultCancel").prop("checked")) {
			v_resultCancel = "Y";
		}else{
			v_resultCancel = "";
		}
		//v_resultCancel = $("#txtUpdResultCancel").val();
	}else if (mode=="delete"){
		v_resultCode = $("#hidResultCode").val();
		//v_fighteralias = "";
	}		
	// console.log("mode="+mode);
	// console.log("v_fighterid="+v_fighterid);
	$.ajax({
		url:'manageStdCtrl.php',
		type: 'post',
		data: {vmode:mode,resultcode:v_resultCode,resultthai:v_resultThai,resulteng:v_resultEng,resultcancel:v_resultCancel},
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