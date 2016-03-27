<!DOCTYPE html>
<?php
include "myConfig.php";
include "./class/myDB.php";

	$pageName = "หน้าจอจัดการค่ายมวย";
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $pageName; ?></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
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
    <h1 hidden="true"><?php echo $pageName; ?></h1>
</header>