
<footer>
<nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="navbar-right">
	<small class="navbar-text">@2015 by NatzWut<small>
  </div>
</nav>

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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	<script>
		$("#saveUpd").click(function(){
			updateGang('update');
			$('#updModal').modal('hide');
			location.reload();
		});
		$("#saveAdd").click(function(){
			//alert("you click Add");
			updateGang('insert');
			$('#insModal').modal('hide');
			location.reload();
		});	
		$("#confirmDel").click(function(){
			//alert("you click Confirm Delete");
			updateGang('delete');
			$('#delModal').modal('hide');
			location.reload();
		});	
		
		var x ="0";
		$("#testBut").click(function() {
			
			alert(x);
		});

		$(":button[id='updateGang']").each(function(index){
			$(this).click(function(){
				var $myTD = $(this).closest("td" ); //,":contains('gangID')"
				var $parTD = $myTD.parent();
				//console.log($parTD.html());
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
/* 				  if ($(this).attr("id") == "gangName") {
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
				  }	 */			  			  	  
				}); 
			});
		});
	
	/* Zone Customize Function */
	function updateGang(mode){
		console.log("start update");
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
				console.log("finish result = "+UpdateRst);
				alert(UpdateRst);
			} ,
			error: function(data){
				UpdateRst = 'failed';
				console.log("finish result = "+UpdateRst);
				alert(UpdateRst);
			}
		});		
		//console.log("finish result = "+UpdateRst);
		//alert(UpdateRst);
	}	
	</script>
</footer>
</section>
</body>
</html>