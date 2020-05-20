<?php
session_start();
require 'classe/Equipement.class.php';
if(empty($_SESSION['ADMIN']) || !isset($_SERVER['HTTP_REFERER']) || empty($_GET['code']) || !is_int_positive($_GET['code'])) {
    header("location:index.php");
}
    $info = new AU(array('iddmau' => $_GET['code']));
    $donnee_a_modifie = $info->chercher_code('dm_au');
    $_SESSION['DM_INFO'] = $donnee_a_modifie;         
    
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
        <title>AU</title>
    </head>
    <body>  
        <div class="container-fluid">
            <div class="row menu">
                <?php require_once 'menu.php';?>
            </div>
                             <div class="row">
                                 <form class="form-horizontal col-sm-6" method="POST" action="modifier_dm_au_program.php">
    <legend>Modifier les données AU:</legend>
                
                                <div class="row">
                <div class="form-group">
                    <label for="serie" class="col-sm-3">Num de série: </label>
                    <div class="col-sm-9">
                        <input type="number" readonly=TRUE name="serie" id="serie" value="<?php echo $_SESSION['DM_INFO']['serial_number']; ?>" class="form-control">    
                </div>
                </div> 
                </div> 

                <div class="row">
                <div class="form-group">
                    <label for="ise" class="col-sm-3">ISE: </label>
                    <div class="col-sm-9">
                        <select name="ise" id="ise" class="form-control">
                            <option <?php if($_SESSION['DM_INFO']['ise'] == 'Active') { echo 'selected';}  ?>>Active</option>
                            <option <?php if($_SESSION['DM_INFO']['ise'] == 'Inactive') { echo 'selected';}  ?>>Inactive</option>
                        </select>   
                </div>
                </div> 
                </div>

  <div class="row">
                <div class="form-group">
                     <label for="etat" class="col-sm-3">Etat: </label>
                     <div class="col-sm-9">
                        <select name="etat" id="etat" class="form-control">
                            <option <?php if($_SESSION['DM_INFO']['status'] == 'Active') { echo 'selected';}  ?>>Active</option>
                            <option <?php if($_SESSION['DM_INFO']['status'] == 'Inactive') { echo 'selected';}  ?>>Inactive</option>
                        </select>
                </div>
                </div>  
                </div>
                
                  <div id="version_soft" class="row">
                <div class="form-group">
                     <label for="soft" class="col-sm-3">Version Software: </label>
                     <div class="col-sm-9">
                     <input type="text" name="soft" id="soft" value="<?php echo $_SESSION['DM_INFO']['version_soft']; ?>" class="form-control" required>
                </div>
                </div>  
                </div>
                
                  <div class="row">
                <div class="form-group">
                     <label for="date_installe" class="col-sm-3">Date d'installation: </label>
                     <div class="col-sm-9">
                         <input type="date" readonly=TRUE id="date_installe" value="<?php echo $_SESSION['DM_INFO']['date_installe']; ?>" name="date_installe" class="form-control">
                </div>     
                </div>  
                </div>
                
                  <div class="row">
                <div class="form-group">
                    <label for="client" class="col-sm-3">Nom client: </label>
                     <div class="col-sm-9">
                        <select name="client" id="client" class="form-control" disabled>
                        <?php 
                        $client = $info->formulaire_label('client');  
                        $total = count($client); 
                        for ($i=0; $i < $total; $i++) { ?>
                            <option <?php if($client[$i]['nom_client'] == $_SESSION['DM_INFO']['nom_client']) { echo 'selected'; } ?>><?php echo $client[$i]['nom_client']; ?></option><?php
                        }
                            ?>
                        </select>

                </div>
                </div>  
                </div>

  <div class="row">
                <div class="form-group">
                     <label for="ville" class="col-sm-3">Ville: </label>
                     <div class="col-sm-9">
                         <select readonly=TRUE name="ville" id="ville" class="form-control" disabled>
                        <?php 
                        $ville = $info->formulaire_label('ville');  
                        $totale = count($ville); 
                        for ($i=0; $i < $totale; $i++) { ?>
                            <option <?php if($ville[$i]['ville'] == $_SESSION['DM_INFO']['ville']) { echo 'selected'; } ?>><?php echo $ville[$i]['ville']; ?></option><?php
                        }
                            ?>
                        </select>
                </div>
                </div>  
                </div>
                
                  <div class="row">
                <div class="form-group">
                     <label for="contrat" class="col-sm-3">Contrat: </label>
                     <div class="col-sm-9">
                    <select name="contrat" id="contrat" class="form-control">
                    <option <?php if($_SESSION['DM_INFO']['contrat'] == "MAD") { echo 'selected';} ?>>MAD</option>
    <option <?php if($_SESSION['DM_INFO']['contrat'] == "Sous Garantie") { echo 'selected';} ?>>Sous Garantie</option>
    <option <?php if($_SESSION['DM_INFO']['contrat'] == "Sous Contrat") { echo 'selected';} ?>>Sous Contrat</option>
    <option <?php if($_SESSION['DM_INFO']['contrat'] == "Hors Garantie") { echo 'selected';} ?>>Hors Garantie</option>
    <option <?php if($_SESSION['DM_INFO']['contrat'] == "Hors Contrat") { echo 'selected';} ?>>Hors Contrat</option>
                    <option <?php if($_SESSION['DM_INFO']['contrat'] == "Vente") { echo 'selected';} ?>>Vente</option>
                    <option <?php if($_SESSION['DM_INFO']['contrat'] == "NA") { echo 'selected';} ?>>NA</option>
                    <option <?php if($_SESSION['DM_INFO']['contrat'] == NULL) { echo 'selected';} ?>></option>
                    </select>
                </div>
                </div>  
                </div>
                
</form>
                 </div>
             <div class="row">
                <div class="col-sm-6">
            <button data-toggle="modal" href="#infos" class="btn btn-default pull-right">
            <span class="glyphicon glyphicon-edit"></span> Modifier</button>   
                </div>
            </div>
            
             <div class="modal" id="infos">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <h4 class="modal-title" style="color: blue">Confirmation:</h4>
</div>
<div class="modal-body">
    <span class="glyphicon glyphicon-exclamation-sign"> Vous voulez vraiment modifier les informations ?</span>
</div>
    <div class="modal-footer">
        <button class="btn btn-info" id="modifier">Oui</button>
        <button class="btn btn-info" data-dismiss="modal">Non</button>
</div>
</div>
</div>
</div>
        </div>
                    <script>
   document.getElementById('equipement').className = 'active';
var click_form = document.getElementById('modifier'), 
    formulaire = document.getElementsByTagName('form')[0],
    etat = document.getElementById('etat'),
    version_soft = document.getElementById('version_soft');

var etat_choisi = etat.options[etat.selectedIndex].value;
/* créaction du champs réforme avec oui ou non*/
     //creation element div
    var div_row = document.createElement('div');
    div_row.id = 'hhhh';
    div_row.className = 'row';
    //creaction element div
    var div_formGroup = document.createElement('div');
    div_formGroup.className = 'form-group';
    //creation element label
    var label = document.createElement('label');
    label.for = 'atelier';
    label.className = 'col-sm-3';
    var label_text = document.createTextNode("Récuperation à l'atelier");
    //creation de l'element div
    var div_col = document.createElement('div');
    div_col.className = 'col-sm-9';
    //creaction de l'element select
    var select = document.createElement('select');
    select.name = 'atelier';
    select.id = 'atelier';
    select.className = 'form-control';
    //creaction de l'element option
    var option1 = document.createElement('option'); 
    var option1_text = document.createTextNode("Non");
        //creaction de l'element option
    var option2 = document.createElement('option'); 
    var option2_text = document.createTextNode("Oui");
    //creaction du champs reforme
    option1.appendChild(option1_text);
    option2.appendChild(option2_text);
    select.appendChild(option1);
    select.appendChild(option2);
    div_col.appendChild(select);
    label.appendChild(label_text);
    div_formGroup.appendChild(label);
    div_formGroup.appendChild(div_col);
    div_row.appendChild(div_formGroup);

    //créaction du champs date réforme
    var div_dateR = document.createElement('div');
    div_dateR.id = 'refor';
    div_dateR.className = 'row';
    //creaction element div
    var div_dateR2 = document.createElement('div');
    div_dateR2.className = 'form-group';
    //creation element label
    var label_dateR = document.createElement('label');
    label_dateR.for = 'date_reforme';
    label_dateR.className = 'col-sm-3';
    var label_dateR_text = document.createTextNode("Date Récuperation");
    //creation de l'element div
    var div_dateR3 = document.createElement('div');
    div_dateR3.className = 'col-sm-9';
    //creaction de l'element input
    var input_dateR = document.createElement('input');
    input_dateR.type = 'date';
    input_dateR.id = 'date_reforme';
    input_dateR.name = 'date_reforme';
    input_dateR.className = 'form-control';

    div_dateR3.appendChild(input_dateR);
    label_dateR.appendChild(label_dateR_text);
    div_dateR2.appendChild(label_dateR);
    div_dateR2.appendChild(div_dateR3);
    div_dateR.appendChild(div_dateR2);

if(etat_choisi == "Inactive")
{
    	formulaire.insertBefore(div_row, version_soft);
    	var recuperation_select = document.getElementById('atelier');
		recuperation_select.addEventListener('change', function() {
		if(recuperation_select.options[recuperation_select.selectedIndex].innerHTML == 'Oui')
    		{
    		//insertion
    		formulaire.insertBefore(div_dateR, version_soft);
    		} 
    		if(recuperation_select.options[recuperation_select.selectedIndex].innerHTML == 'Non')
    		{
    		var date_recuperation = document.getElementById('refor');
    	 	formulaire.removeChild(date_recuperation);
    		} 
		}, false);
}


	etat.addEventListener('change', function() {
	if(etat.options[etat.selectedIndex].innerHTML == 'Inactive')
    {
    //insertion
    formulaire.insertBefore(div_row, version_soft);

    	var recuperation_select = document.getElementById('atelier');
		recuperation_select.addEventListener('change', function() {
		if(recuperation_select.options[recuperation_select.selectedIndex].innerHTML == 'Oui')
    		{
    		//insertion
    		formulaire.insertBefore(div_dateR, version_soft);
    		} 
    		if(recuperation_select.options[recuperation_select.selectedIndex].innerHTML == 'Non')
    		{
    		var date_recuperation = document.getElementById('refor');
    	 	formulaire.removeChild(date_recuperation);
    		} 
		}, false); 
    } 

    if(etat.options[etat.selectedIndex].innerHTML == 'Active')
    {
    	 var recuperation = document.getElementById('hhhh');
    	 formulaire.removeChild(recuperation);
    	 var date_recuperation = document.getElementById('refor');
    	 formulaire.removeChild(date_recuperation);
    }
}, false); 


 click_form.addEventListener('click', function() {
        formulaire.submit();  
   },false);
</script>
        </body>
        </html>
            