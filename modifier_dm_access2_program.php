<?php
session_start();
if(empty($_SESSION['ADMIN']) || empty($_SESSION['DM_INFO'])) {
    header("location:index.php");
}
header('Refresh: 1; URL=dm_access2.php');
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
        <title>Access2</title>
    </head>
    <body>  
    	<div class="container-fluid">
    		<div class="row col-md-6">
    			<?php 
		if(isset($_POST['atelier']))
		{
			if(isset($_POST['date_reforme']))
			{
				 $donnees = array(
                                             'soft' => $_POST['soft'],
                                             'recuperation' => $_POST['atelier'],
                                             'etat' => $_POST['etat'],
                                             'date_reforme' => $_POST['date_reforme'],
                                             'iddma' => $_SESSION['DM_INFO']['iddma'],
                                             'code_client' => $_SESSION['DM_INFO']['code_client'],
                                             'dateInstalle' => $_SESSION['DM_INFO']['date_installe'],
                                             'serie' => $_SESSION['DM_INFO']['serial_number'],
                                         ); 
			}
			else
			{
				$donnees = array(
                                             'apf' => $_POST['apf'],
                                             'etat' => $_POST['etat'],
                                             'soft' => $_POST['soft'],
                                             'recuperation' => $_POST['atelier'],
                                             'contrat' => $_POST['contrat'],
                                             'iddma' => $_SESSION['DM_INFO']['iddma'],
                                         ); 
			}
		}

		else
		{
			$donnees = array(
                                             'etat' => $_POST['etat'],
                                             'soft' => $_POST['soft'],
                                             'apf' => $_POST['apf'],
                                             'contrat' => $_POST['contrat'],
                                             'iddma' => $_SESSION['DM_INFO']['iddma'],
                                         );  
		}
 			 
 
 		 $modifier = new Access($donnees);
 		 $modifier->modifier_access_dm();
         unset($modifier);
?>	
    		</div>
    	
    	</div>
