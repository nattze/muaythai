<!DOCTYPE html>
<?php
include "myConfig.php";
include "./class/myDB.php";

?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>xxx</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="js/locales/bootstrap-datetimepicker.th.js" charset="UTF-8"></script>	
	
    	
	<!-- DataTables CSS -->
	<!--<link rel="stylesheet" type="text/css" href="DataTables/media/css/jquery.dataTables.css"> -->
	  
	<!-- jQuery -->
	<!--<script type="text/javascript" charset="utf8" src="DataTables/media/js/jquery.js"></script> -->
	  
	<!-- DataTables -->
	<!--<script type="text/javascript" charset="utf8" src="DataTables/media/js/jquery.dataTables.js"></script> -->    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->    
</head>

<body>
<header>
    <h1 hidden="true" id="pageH1"></h1>
</header>

<section id="container" class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img alt="Brand" src="./favicon.ico"> <?php echo $proj_name; ?> <small id="subPageName"></small> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
	
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<!-- 
      <ul class="nav navbar-nav">
        <li ><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown active">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="active"><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
	-->  
      <ul class="nav navbar-nav navbar-right" id="myNavMenu">
        <li id="match"><a href="#">Match</a></li>
        <li class="dropdown">
          <a href="#" id="datamanagement" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Data Management <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="manageGang"><a href="./manageGang.php">จัดการค่าย</a></li>
            <li id="manageFighter" ><a href="./manageFighter.php">จัดการนักมวย</a></li>
            <li id="managePromoter"><a href="./managePromoter.php">จัดการผู้จัดแข่ง</a></li>
			<li id="manageStage"><a href="./manageStage.php">จัดการเวที</a></li>
			<li id="manageProgram"><a href="./manageProgram.php">จัดการรายการแข่ง</a></li>
            <li role="separator" class="divider"></li>
            <li id="manageStd"><a href="./manageStd.php">จัดการข้อมูล Result</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
