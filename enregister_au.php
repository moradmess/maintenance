<?php
if(!isset($_SERVER['HTTP_REFERER'])) {
    header("location:index.php");
}
header('Refresh: 1; URL=dm_au.php');
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
         /* ajuster la taille d'affichage de message de bon enregistrement des données  */ 
        	#info
        	{
        		size: 200px;
        	}
        </style>
        <title>AU</title>
    </head>
    <body>  
    	<div class="container-fluid">
    		<div class="row col-md-6">
    			<?php 
$donnees = array(
 											 'serie' => $_POST['serie'],
                                             'ise' => $_POST['ise'],
                                             'soft' => $_POST['soft'],
                                             'dateInstalle' => $_POST['date_installe'],
                                             'client' => $_POST['client'],
                                             'ville' => strtoupper($_POST['ville']), //majuscule
                                             'contrat' => $_POST['contrat'],
                                         ); 

 $enregistrer = new AU($donnees);
 $enregistrer->enregistrer_au();
?>	
    		</div>
    	
    	</div>