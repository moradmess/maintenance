<?php
session_start();
require 'classe/Equipement.class.php';
if(empty($_SESSION['ADMIN']) || !isset($_SERVER['HTTP_REFERER']) || empty($_GET['code']) || !is_int_positive($_GET['code'])) {
    header("location:index.php");
}
header('Refresh: 1; URL=mp_au.php');
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
        <title>MP AU</title>
    </head>
    <body>  
    	<div class="container-fluid">
    		<div class="row col-md-6">
    			<?php 
		$donnee = array('idmpau' => $_GET['code']);
 		 $supprimer = new AU($donnee);
 		 $supprimer->supprimer_au_mp();
         unset($supprimer);
?>
    		</div>
    	
    	</div>