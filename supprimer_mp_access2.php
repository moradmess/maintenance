<?php
session_start();
require 'classe/Equipement.class.php';
if(empty($_SESSION['ADMIN']) || !isset($_SERVER['HTTP_REFERER']) || empty($_GET['code']) || !is_int_positive($_GET['code'])) {
    header("location:index.php");
}
header('Refresh: 1; URL=mp_access2.php');
?>
<!DOCTYPE html>
 
<!-- * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initialscale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/inventaire_style.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style type="text/css">
        	#info
        	{
        		size: 200px;
        	}
        </style>
        <title>MP Access2</title>
    </head>
    <body>  
    	<div class="container-fluid">
    		<div class="row col-md-6">
    			<?php 
		$donnee = array('idmpa' => $_GET['code']);
 		 $supprimer = new Access($donnee);
 		 $supprimer->supprimer_access_mp();
         unset($supprimer);
?>
    		</div>
    	
    	</div>