<?php
include "manage_header.php";

$db1 = new Class_DB();

$db1->connectDB($dbhost,$dbroot,$dbpass,$dbname);
/*
		$sql = $db1->query("select gangid ,seq ,name ,address1 ,address2 from gang a where seq = (select max(aa.seq) from gang aa where aa.gangid=a.gangid) and cancel_flag <>'Y' and gangid=2 ");
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
			echo '{"gangs":[{"gangid":"0"}]}';
		}  */

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

$sql = $db1->query("SELECT * FROM gang a WHERE seq = (select max(aa.seq) from gang aa where aa.gangid=a.gangid) and cancel_flag <>'Y' order by gangid;");

?>

        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            	ค่ายมวย
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
									<input type="text" class="form-control input-sm" id="txtSearchName" placeholder="ค้นหาค่าย">
								  </div>
								  <button type="button" id="btnSearchGang" class="btn btn-default btn-sm" >OK</button>
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
                                            <th>Name</th>
                                            <th>Address1</th>
                                            <th>Address2</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
										while($myResult=mysqli_fetch_array($sql)){
											echo "<tr>";
											echo "<td id='gangID'>".$myResult[0]."</td>";
											echo "<td id='gangSEQ' hidden='true'>".$myResult[1]."</td>";
											echo "<td id='gangName'>".$myResult[2]."</td>";
											echo "<td id='gangADDR1'>".$myResult[3]."</td>";
											echo "<td id='gangADDR2'>".$myResult[4]."</td>";
											echo "<td>"."<p><button type='button' id='updateGang' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"." <button type='button' id='deleteGang' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"."</td>";
											echo "</tr>";
										}
									?>                                    	
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#insModal">Add</button>
							
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
									  <input type="hidden" value="" id="hidGangID"></input>
									  <p><strong>Warning!</strong> ต้องการลบข้อมูลใช่หรือไม่?</p>
									  <p>
									  <button type="button" class="btn btn-danger btn-sm" id="confirmDel">Confirm</button>
									  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
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
													<input type="text" class="form-control" id="txtInsGangID" value="" disabled="disabled" ></input>
												</div>											
											</div> 										
											<div class="row">
												<div class="col-md-4">
													#Name
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsGangName" placeholder="ชื่อค่าย"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#Addr1
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsGangAddr1" placeholder="ที่อยู่ค่าย"></input>
												</div>											
											</div>  
											<div class="row">
												<div class="col-md-4">
													#Addr2
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtInsGangAddr2" placeholder="ที่อยู่ค่าย"></input>
												</div>											
											</div>  																						                                        </div> <!-- class="container-fluid" -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                            <button type="button" id="saveAdd" class="btn btn-primary btn-sm">Save changes</button>
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
                                            <h4 class="modal-title" id="myModalLabel"><small class="text-info"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> แก้ไขข้อมูล</small></h4>
                                        </div>
                                        <div class="modal-body">
										<div class="container-fluid">
											<div class="row">
												<div class="col-md-4">
													#ID
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpGangID" value="yy" disabled="disabled" ></input>
												</div>											
											</div> 										
											<div class="row">
												<div class="col-md-4">
													#Name
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpGangName" value="yy"></input>
												</div>											
											</div>    
											<div class="row">
												<div class="col-md-4">
													#Addr1
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpGangAddr1" value="xxxx"></input>
												</div>											
											</div>  
											<div class="row">
												<div class="col-md-4">
													#Addr2
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" id="txtUpGangAddr2" value="xxxx"></input>
												</div>											
											</div>  																						                                        </div> <!-- class="container-fluid" -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                            <button type="button" id="saveUpd" class="btn btn-primary btn-sm">Save changes</button>
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

	unset($db1);

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

	$("#divFilter").on("hide.bs.collapse", function(){
		$("#btn-filter").html('<span class="glyphicon glyphicon-collapse-down"></span> Filter');
	});
	$("#divFilter").on("show.bs.collapse", function(){
		$("#btn-filter").html('<span class="glyphicon glyphicon-collapse-up"></span> Hide');
	});
  
	//$('#alertModal').modal('show');
/* ==================End Zone Ready for setup Page Var. =================== */	

/* ================== Zone Page Action =================== */
	$("#saveUpd").click(function(){
		updateGang('update');
		$('#updModal').modal('hide');
		//location.reload();
		//document.location.reload(true);
	});	
	$("#btnSearchGang").click(function(){
		var str = $("#txtSearchName").val();
		//alert(str);		
		if (str.length==0) {
			str = "%";
		}
		searchGang(str);
	});
	
	$( "#txtSearchName" ).keypress(function( ev ) {
		var keycode = (ev.keyCode ? ev.keyCode : ev.which);
		if (keycode == '13') {
			$("#btnSearchGang").click();
		}		
		//console.log( keycode );
	});
	
	$("#btnSearchClear").click(function(){
		$("#txtSearchName").val("");

		searchGang("%");
	});
	
	$("#saveAdd").click(function(){
		//alert("you click Add");
		updateGang('insert');
		$('#insModal').modal('hide');
		//location.reload();
		//document.location.reload(true);
	});	
	$("#confirmDel").click(function(){
		//alert("you click Confirm Delete");
		updateGang('delete');
		$('#delModal').modal('hide');
		//location.reload();
		//document.location.reload(true);
	});	

	$(":button[id='updateGang']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			//console.log("In Doc. on evn cick button update gand id = "+$("#updateGang").attr('id')+" gangName ="+$("#gangName").html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "gangName") {
				$("#txtUpGangName").val($(this).html());
			  }
			  if ($(this).attr("id") == "gangID") {
				$("#txtUpGangID").val($(this).html());
			  }		
			  if ($(this).attr("id") == "gangADDR1") {
				$("#txtUpGangAddr1").val($(this).html());
			  }	
			  if ($(this).attr("id") == "gangADDR2") {
				$("#txtUpGangAddr2").val($(this).html());
			  }				  			  	  
			}); 
		});
	});

	$(":button[id='deleteGang']").each(function(index){
		$(this).click(function(){
			var $myTD = $(this).closest("td" ); //,":contains('gangID')"
			var $parTD = $myTD.parent();
			//console.log($parTD.html());
			$parTD.find('td').each (function() {
			  if ($(this).attr("id") == "gangID") {
				$("#hidGangID").val($(this).html());
			  }							  			  	  
			}); 
		});
	});
/* ==================End Zone Page Action =================== */	
});


/* Zone Customize Function */
function searchGang(str){
	var objData;
	var UpdateRst;	
	//alert(str);
	$.ajax({
		url:'manageGangCtrl.php',
		type: 'post',
		data: {vmode:'search',gangname:str},
		success: function(data){
			//UpdateRst = data;
			//alert("data="+data);
			//alert("UpdateRst="+UpdateRst);
			//console.log("finish result = "+UpdateRst);
			//setInterval(function () {console.log("finish result = "+UpdateRst);}, 10000);	
			//alert(UpdateRst);	
					
			objData = eval('('+data+')');

			if (objData.gangs.length>0){
				//$("#alertMsg").html(objData.gangs[0].name);
				//$('#alertModal').modal('show');	
				//console.log($("#gangTable tbody").html());
				
				var newTr="";
 				for (index = 0; index < objData.gangs.length; ++index) {
					//console.log(index+" name="+objData.gangs[index].name);
					newTr += "<tr>";
					newTr += "<td id='gangID'>"+objData.gangs[index].gangid+"</td>";
					newTr += "<td id='gangSEQ' hidden='true'>"+objData.gangs[index].seq+"</td>";
					newTr += "<td id='gangName' >"+objData.gangs[index].name+"</td>";
					newTr += "<td id='gangADDR1' >"+objData.gangs[index].address1+"</td>";
					newTr += "<td id='gangADDR2' >"+objData.gangs[index].address2+"</td>";
					newTr += "<td>"+"<p><button type='button' id='updateGang' class='btn btn-info btn-xs' data-toggle='modal' data-target='#updModal'>Edit</button>"+" <button type='button' id='deleteGang' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delModal'>Delete</button></p>"+"</td>";
					newTr += "</tr>"; /**/
				}
				if(objData.gangs[0].gangid>0){
					$("#gangTable tbody").html(newTr);
					//$("#gangTable tbody").replaceWith(newTr);
					//console.log("button update gand id = "+$("#updateGang").attr('id')+" gangName ="+$("#gangName").html());
					$(":button[id='updateGang']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							//console.log("IN Ajax on evn cick button update gand id = "+$("#updateGang").attr('id')+" gangName ="+$("#gangName").html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "gangName") {
								$("#txtUpGangName").val($(this).html());
							  }
							  if ($(this).attr("id") == "gangID") {
								$("#txtUpGangID").val($(this).html());
							  }		
							  if ($(this).attr("id") == "gangADDR1") {
								$("#txtUpGangAddr1").val($(this).html());
							  }	
							  if ($(this).attr("id") == "gangADDR2") {
								$("#txtUpGangAddr2").val($(this).html());
							  }				  			  	  
							}); 
						});
					});		/*	*/	
					$(":button[id='deleteGang']").each(function(index){
						$(this).click(function(){
							var $myTD = $(this).closest("td" ); //,":contains('gangID')"
							var $parTD = $myTD.parent();
							//console.log($parTD.html());
							$parTD.find('td').each (function() {
							  if ($(this).attr("id") == "gangID") {
								$("#hidGangID").val($(this).html());
							  }							  			  	  
							}); 
						});
					});					
				}else { //case no result
					$("#gangTable tbody").html("<tr><td colspan='6'>No Result Data</td></tr>");
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

function updateGang(mode){
	//console.log("start update");
	var UpdateRst ="";
	var v_gangid;
	var v_gangname;
	var v_gangaddr1;
	var v_gangaddr2;
	
	if (mode=="insert") {
		v_gangid = $("#txtInsGangID").val();
		v_gangname = $("#txtInsGangName").val();
		v_gangaddr1 = $("#txtInsGangAddr1").val();
		v_gangaddr2 = $("#txtInsGangAddr2").val();
	}else if (mode=="update"){
		v_gangid = $("#txtUpGangID").val();
		v_gangname = $("#txtUpGangName").val();
		v_gangaddr1 = $("#txtUpGangAddr1").val();
		v_gangaddr2 = $("#txtUpGangAddr2").val();
	}else if (mode=="delete"){
		v_gangid = $("#hidGangID").val();
		v_gangname = "";
		v_gangaddr1 = "";
		v_gangaddr2 = "";
	}		
	$.ajax({
		url:'manageGangCtrl.php',
		type: 'post',
		data: {vmode:mode,gangid:v_gangid,gangname:v_gangname,gangaddr1:v_gangaddr1,gangaddr2:v_gangaddr2},
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
	//alert(UpdateRst);
}	
</script>
	    
<?php
include "manage_footer.php";
?>