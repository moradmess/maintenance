<?php
session_start();
if(empty($_SESSION['ADMIN']) || empty($_SESSION['DM_INFO']) || ($_GET['info'] != "modif" && $_GET['info'] != "enreg")) {
    header("location:index.php");
}
header('Refresh: 1; URL=mp_au.php');
require 'classe/Equipement.class.php';
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
		     $info = $_GET['info'];
		     if($info == 'modif')
		     {
		     	 $donnees = array(
                                             'date_dernier_mp' => $_POST['date_dernier_mp'],
                                             'date_mp_prevue' => $_POST['date_mp_prevue'],
                                             'idmpau' => $_SESSION['DM_INFO']['idmpau'],
                                         );  
		     }
 			else {
 				$donnees = array(
 											'ise' => $_SESSION['DM_INFO']['ise'],
 											'serie' => $_SESSION['DM_INFO']['serial_number'],
 											'soft' => $_SESSION['DM_INFO']['version_soft'],
 											'dateInstalle' => $_SESSION['DM_INFO']['date_installe'],
 											'code_client' => $_SESSION['DM_INFO']['code_client'],
 											'contrat' => $_SESSION['DM_INFO']['contrat'],
 											'date_dernier_mp' => $_POST['date_interv'],
                                             'nom_intervenant' => $_POST['nom_interv'],
                                             'detail' => $_POST['detail'],
                                             'date_mp_prevue' => $_POST['date_mp_prevu'],
                                             'idmpau' => $_SESSION['DM_INFO']['idmpau'],
                                         );  
 			}
 		 $modifier = new AU($donnees);
 	     $modifier->modifier_au_mp($info);
         unset($modifier);
?>	
    		</div>
    	
    	</div>