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

$sql = $db1->query("SELECT *,(select name from gang where gangid=a.gangid and seq=a.gangseq) Gang FROM fighter a WHERE seq = (select max(aa.seq) from fighter aa where aa.fighterID=a.fighterID) and cancel_flag <>'Y' order by fighterID;");
$rowcnt = $db1->num_rows($sql);

$sqlGang = $db1->query("SELECT CONCAT(CAST(gangid AS CHAR),'|' ,CAST(seq AS CHAR)) gangid ,Name FROM gang a WHERE seq = (select max(aa.seq) from gang aa where aa.gangid=a.gangid) and cancel_flag <>'Y' order by gangid ");

?>
	
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            	นักมวย
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
									<input type="text" class="form-control input-sm" id="txtSearchName" placeholder="ค้นหาชื่อนักมวย">
								  </div>
								  <div class="form-group">									
									<label for="listSearchGang" class="">Gang</label>
									<select class="form-control  input-sm" id="listSearchGang"></select>
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
                                            <th>ID#</th>
                                            <th hidden="true">Seq#</th>
                                            <th>Alias</th>
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>BirthDate</th>	
									
                                            <th>Address1</th>
                                            <th>Address2</th>
                                            <th>Gang</th>
                                            <th hidden="true"></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
										if ($rowcnt==0){
											echo "<tr><td colspan='9'><div >ไม่มีข้อมูล</div></td></tr>"	;
										}else{
										while($myResult=mysqli_fetch_array($sql)){
											echo "<tr>";
											echo "<td id='fighterID'>".$myResult[0]."</td>";
											echo "<td id='fighterSEQ' hidden='true'>".$myResult[1]."</td>";
											echo "<td id='fighterAlias'>".$myResult["AliasName"]."</td>";
											echo "<td id='fighterName'>".$myResult["Name"]."</td>";
											echo "<td id='fighterSurname'>".$myResult["Surname"]."</td>";
											echo "<td id='fighterDOB'>".$myResult["DOB"]."</td>";
											echo "<td id='fighterADDR1'>".$myResult["Address1"]."</td>";
											echo "<td id='fighterADDR2'>".$myResult["Address2"]."</td>";
											echo "<td id='fighterGang'>".$myResult["Gang"]."</td>";
											echo "<td id='fighterGangID' hidden='true'>".$myResult["GangID"]."|".$myResult["GangSeq"]."</td>";
											echo "<td>"."<p><button type='button' id='updateFighter' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"." <button type='button' id='deleteFighter' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"."</td>";
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
									  <input type="hidden" value="" id="hidFighterID"></input>
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
													<input type="text" class="form-control" id="txtInsFighterID" value="" disabled="disabled" ></input>
												</div>											
											</div> 
											<div class="row">
												<div class="col-md-4">
													#Alias
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsFighterAlias" placeholder="ฉายา"></input>
												</div>											
											</div>  																					
											<div class="row">
												<div class="col-md-4">
													#Name
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsFighterName" placeholder="ชื่อจริง"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#SurName
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsFighterSurname" placeholder="นามสกุล"></input>
												</div>											
											</div>   
											<div class="row">
												<div class="col-md-4">
													#BirthDate
												</div>
												<div class="col-md-5">
													<div class="form-group">
														<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="dd/mm/yyyy">
															<input id="txtInsFighterDOB" class="form-control" type="text" value="" placeholder="dd/mm/yyyy ค.ศ.">
															<span class="input-group-addon"><span class="glyphicon glyphicon-remove "></span></span>
															<span class="input-group-addon"><span class="glyphicon glyphicon-calendar "></span></span>
														</div>
														<input type="hidden" id="dtp_input2" value="" /><br/>
													</div>														
												</div>											
											</div>   																						
											<div class="row">
												<div class="col-md-4">
													#Addr1
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsFighterAddr1" placeholder="ที่อยู่"></input>
												</div>											
											</div>  
											<div class="row">
												<div class="col-md-4">
													#Addr2
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsFighterAddr2" placeholder="ที่อยู่"></input>
												</div>											
											</div>  
											<div class="row">
												<div class="col-md-4">
													#Gang
												</div>
												<div class="col-md-4">
													<select class="form-control" id="listInsFighterGangID"></select>
												</div>											
											</div> 																																	                                        </div> <!-- class="container-fluid" -->
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
													<input type="text" class="form-control" id="txtUpdFighterID" value="" disabled="disabled" ></input>
												</div>											
											</div> 
											<div class="row">
												<div class="col-md-4">
													#Alias
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdFighterAlias" placeholder="ฉายา"></input>
												</div>											
											</div>  																					
											<div class="row">
												<div class="col-md-4">
													#Name
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdFighterName" placeholder="ชื่อจริง"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#SurName
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdFighterSurname" placeholder="นามสกุล"></input>
												</div>											
											</div>   
											<div class="row">
												<div class="col-md-4">
													#BirthDate
												</div>	
												<div class="col-md-5">
													<div class="form-group">
														<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="dd/mm/yyyy">
															<input id="txtUpdFighterDOB" class="form-control" type="text" value="" placeholder="dd/mm/yyyy ค.ศ.">
															<span class="input-group-addon"><span class="glyphicon glyphicon-remove "></span></span>
															<span class="input-group-addon"><span class="glyphicon glyphicon-calendar "></span></span>
														</div>
														<input type="hidden" id="dtp_input2" value="" /><br/>
													</div>														
												</div>												
											</div>   																						
											<div class="row">
												<div class="col-md-4">
													#Addr1
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdFighterAddr1" placeholder="ที่อยู่"></input>
												</div>											
											</div>  
											<div class="row">
												<div class="col-md-4">
													#Addr2
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpdFighterAddr2" placeholder="ที่อยู่"></input>
												</div>											
											</div>  	
											<div class="row">
												<div class="col-md-4">
													#Gang
												</div>
												<div class="col-md-4">
													<select class="form-control" id="listUpdFighterGangID"></select>
												</div>											
											</div>  																																                                        </div> <!-- class="container-fluid" -->
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
/* ==================End Zone Ready for setup Page Var. =================== */

/* ================== Zone Page Action =================== */
	$("#btnSearch").click(function(){
		var str = $("#txtSearchName").val();
		var gang = $("#listSearchGang").val();
		if (gang == "0|0"){
			gang = "%";
		}
		//alert(str);		
		if (str.length==0) {
			str = "%";
		}
		searchFighter(str ,gang);
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
		$("#listSearchGang").val("0|0");

		searchFighter("%" ,"%");
	});

	$("input[id='txtInsFighterDOB'] ,input[id='txtUpdFighterDOB']").keyup(function(e){
		var key=String.fromCharCode(e.keyCode);
		if(!(key>=0&&key<=9))$(this).val($(this).val().substr(0,$(this).val().length-1));
		var value=$(this).val();
		if(value.length==2||value.length==5)$(this).val($(this).val()+'/');
	});
	$('.form_date').datetimepicker({
        language:  'th',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	
	$("#saveUpd").click(function(){
		updateFighter('update');
		$('#updModal').modal('hide');
		//location.reload();
	});
	$("#saveAdd").click(function(){
		//alert("you click Add");
		updateFighter('insert');
		$('#insModal').modal('hide');
		//location.reload();
	});	
	$("#confirmDel").click(function(){
		//alert("you click Confirm Delete");
		updateFighter('delete');
		$('#delModal').modal('hide');
		//location.reload();
	});	
	
	$("#insBtn").click(function(){
		$("#listInsFighterGangID").html($("#listGang").html());
	});
	
	$(":button[id='updateFighter']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "fighterSurname") {
				$("#txtUpdFighterSurname").val($(this).html());
			  }
			  if ($(this).attr("id") == "fighterAlias") {
				$("#txtUpdFighterAlias").val($(this).html());
			  }		
			  if ($(this).attr("id") == "fighterDOB") {
				$("#txtUpdFighterDOB").val($(this).html());
			  }					  		  					
			  if ($(this).attr("id") == "fighterName") {
				$("#txtUpdFighterName").val($(this).html());
			  }
			  if ($(this).attr("id") == "fighterID") {
				$("#txtUpdFighterID").val($(this).html());
			  }		
			  if ($(this).attr("id") == "fighterADDR1") {
				$("#txtUpdFighterAddr1").val($(this).html());
			  }	
			  if ($(this).attr("id") == "fighterADDR2") {
				$("#txtUpdFighterAddr2").val($(this).html());
			  }		
			  if ($(this).attr("id") == "fighterGangID") {
				var tmpT = $(this).html();
				var str = tmpT.split("|");
				//console.log(str[0]+"<->"+str[1]);
				$("#listUpdFighterGangID").html($("#listGang").html());
				$('#listUpdFighterGangID').val(tmpT);
			  }					  		  			  	  
			}); 
		});
	});

	$(":button[id='deleteFighter']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "fighterID") {
				$("#hidFighterID").val($(this).html());
			  }							  			  	  
			}); 
		});
	});
/* ==================End Zone Page Action =================== */

});

/* Zone Customize Function */
function searchFighter(i_name ,i_gang){
	var objData;
	var UpdateRst;	
	//alert(str);
	$.ajax({
		url:'manageFighterCtrl.php',
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

			if (objData.fighters.length>0){
				//$("#alertMsg").html(objData.gangs[0].name);
				//$('#alertModal').modal('show');	
				//console.log($("#gangTable tbody").html());		
				var newTr="";
 				for (index = 0; index < objData.fighters.length; ++index) {
					//console.log(index+" name="+objData.gangs[index].name);
					newTr += "<tr>";
					newTr += "<td id='fighterID'>"+objData.fighters[index].fighterID+"</td>";
					newTr += "<td id='fighterSEQ' hidden='true'>"+objData.fighters[index].seq+"</td>";
					newTr += "<td id='fighterAlias' >"+objData.fighters[index].aliasname+"</td>";
					newTr += "<td id='fighterName' >"+objData.fighters[index].name+"</td>";
					newTr += "<td id='fighterSurname' >"+objData.fighters[index].surname+"</td>";
					newTr += "<td id='fighterDOB' >"+objData.fighters[index].dob+"</td>";
					newTr += "<td id='gangADDR1' >"+objData.fighters[index].address1+"</td>";
					newTr += "<td id='gangADDR2' >"+objData.fighters[index].address2+"</td>";
					newTr += "<td id='fighterGang' >"+objData.fighters[index].Gang+"</td>";
					newTr += "<td id='fighterGangID' hidden='true'>"+objData.fighters[index].gangid+"|"+objData.fighters[index].gangseq+"</td>";
					newTr += "<td>"+"<p><button type='button' id='updateFighter' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"+" <button type='button' id='deleteFighter' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"+"</td>";
					newTr += "</tr>"; /**/
				}
				if(objData.fighters[0].gangid>0){
					$("#gangTable tbody").html(newTr);
					//$("#gangTable tbody").replaceWith(newTr);
					//console.log("button update gand id = "+$("#updateGang").attr('id')+" gangName ="+$("#gangName").html());
					$(":button[id='updateFighter']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "fighterSurname") {
								$("#txtUpdFighterSurname").val($(this).html());
							  }
							  if ($(this).attr("id") == "fighterAlias") {
								$("#txtUpdFighterAlias").val($(this).html());
							  }		
							  if ($(this).attr("id") == "fighterDOB") {
								$("#txtUpdFighterDOB").val($(this).html());
							  }					  		  					
							  if ($(this).attr("id") == "fighterName") {
								$("#txtUpdFighterName").val($(this).html());
							  }
							  if ($(this).attr("id") == "fighterID") {
								$("#txtUpdFighterID").val($(this).html());
							  }		
							  if ($(this).attr("id") == "fighterADDR1") {
								$("#txtUpdFighterAddr1").val($(this).html());
							  }	
							  if ($(this).attr("id") == "fighterADDR2") {
								$("#txtUpdFighterAddr2").val($(this).html());
							  }		
							  if ($(this).attr("id") == "fighterGangID") {
								var tmpT = $(this).html();
								var str = tmpT.split("|");
								//console.log(str[0]+"<->"+str[1]);
								$("#listUpdFighterGangID").html($("#listGang").html());
								$('#listUpdFighterGangID').val(tmpT);
							  }					  		  			  	  
							}); 
						});
					});	
					
					$(":button[id='deleteFighter']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "fighterID") {
								$("#hidFighterID").val($(this).html());
							  }							  			  	  
							}); 
						});
					});					
				}else { //case no result
					$("#gangTable tbody").html("<tr><td colspan='9'>No Result Data</td></tr>");
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

function updateFighter(mode){
	//console.log("start update");
	var UpdateRst ="";
	var v_fighterid;
	var v_fighteralias;
	var v_fightername;
	var v_fightersurname;
	var v_fighterdob;
	var v_fighteraddr1;
	var v_fighteraddr2;
	var v_fightergang;
	
	if (mode=="insert") {
		v_fighterid = $("#txtInsFighterID").val();
		v_fighteralias = $("#txtInsFighterAlias").val();
		v_fightername = $("#txtInsFighterName").val();
		v_fightersurname = $("#txtInsFighterSurname").val();
		v_fighterdob = $("#txtInsFighterDOB").val();
		v_fighteraddr1 = $("#txtInsFighterAddr1").val();
		v_fighteraddr2 = $("#txtInsFighterAddr2").val();
		v_fightergang = $("#listInsFighterGangID").val();
	}else if (mode=="update"){
		v_fighterid = $("#txtUpdFighterID").val();
		v_fighteralias = $("#txtUpdFighterAlias").val();
		v_fightername = $("#txtUpdFighterName").val();
		v_fightersurname = $("#txtUpdFighterSurname").val();
		v_fighterdob = $("#txtUpdFighterDOB").val();
		v_fighteraddr1 = $("#txtUpdFighterAddr1").val();
		v_fighteraddr2 = $("#txtUpdFighterAddr2").val();
		v_fightergang = $("#listUpdFighterGangID").val();
	}else if (mode=="delete"){
		v_fighterid = $("#hidFighterID").val();
		v_fighteralias = "";
	}		
	// console.log("mode="+mode);
	// console.log("v_fighterid="+v_fighterid);
	$.ajax({
		url:'manageFighterCtrl.php',
		type: 'post',
		data: {vmode:mode,fighterid:v_fighterid,fighteralias:v_fighteralias,fightername:v_fightername,fightersurname:v_fightersurname,fighterdob:v_fighterdob,fighteraddr1:v_fighteraddr1,fighteraddr2:v_fighteraddr2,fightergang:v_fightergang},
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