<?php
session_start();
require 'classe/Equipement.class.php';
if(!isset($_SESSION['ADMIN']) || !isset($_SERVER['HTTP_REFERER']) || empty($_GET['code']) || !is_int_positive($_GET['code'])) {
    header("location:index.php");
}
    //selectionner les donnees a modifier via la methode GET
    $info = new AU(array('idmpau' => $_GET['code']));
    $donnee_a_modifie = $info->chercher_code('mp_au'); 
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
        <title>MP AU</title>
    </head>
    <body>  
        <div class="container-fluid">
            <div class="row menu">
                <?php require_once 'menu.php';?>
            </div>
                             <div class="row">
                                 <form class="form-horizontal col-sm-6" method="POST" action="modifier_mp_au_program.php?info=modif">
        <legend>Modifier les dates MP AU:</legend>
               <div class="row">
                <div class="form-group">
                    <label for="serie" class="col-sm-3">Num de série: </label>
                    <div class="col-sm-9">
                        <input type="number" name="serie" id="serie" value="<?php echo $_SESSION['DM_INFO']['serial_number']; ?>" class="form-control" disabled>    
                </div>
                </div> 
                </div> 

                <div class="row">
                <div class="form-group">
                    <label for="ise" class="col-sm-3">ISE: </label>
                    <div class="col-sm-9">
                        <select name="ise" id="ise" class="form-control" disabled>
                            <option <?php if($_SESSION['DM_INFO']['ise'] == 'Active') { echo 'selected';}  ?>>Active</option>
                            <option <?php if($_SESSION['DM_INFO']['ise'] == 'Inactive') { echo 'selected';}  ?>>Inactive</option>
                        </select>   
                </div>
                </div> 
                </div>
                
            <div class="row">
                <div class="form-group">
                     <label for="soft" class="col-sm-3">Version Software: </label>
                     <div class="col-sm-9">
                     <input type="text" name="soft" id="soft" value="<?php echo $_SESSION['DM_INFO']['version_soft']; ?>" class="form-control" disabled>
                </div>
                </div>  
                </div>
                
            <div class="row">
                <div class="form-group">
                     <label for="date_installe" class="col-sm-3">Date d'installation: </label>
                     <div class="col-sm-9">
                         <input type="date" id="date_installe" value="<?php echo $_SESSION['DM_INFO']['date_installe']; ?>" name="date_installe" class="form-control" disabled>
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
                         <select name="ville" id="ville" class="form-control" disabled>
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
                <select name="contrat" id="contrat" class="form-control" disabled>
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

                <div class="row">
                <div class="form-group">
                     <label for="date_dernier_mp" class="col-sm-3">Date du dernière MP: </label>
                     <div class="col-sm-9">
                         <input type="date" id="date_dernier_mp" value="<?php echo $_SESSION['DM_INFO']['date_dernier_mp']; ?>" name="date_dernier_mp" class="form-control">
                </div>     
                </div>  
                </div>

                <div class="row">
                <div class="form-group">
                     <label for="date_mp_prevue" class="col-sm-3">Date de la MP prévue: </label>
                     <div class="col-sm-9">
                         <input type="date" id="date_mp_prevue" value="<?php echo $_SESSION['DM_INFO']['date_mp_prevue']; ?>" name="date_mp_prevue" class="form-control">
                </div>     
                </div>  
                </div>
</form>          
                 </div>
        
            <div class="row">
                <div class="col-sm-6">
            <button  class="btn btn-default pull-right" data-toggle="modal" href="#infos">
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
        <button data-toggle="modal" href="#infos_histo" class="btn btn-info">Oui</button>
        <button class="btn btn-info" data-dismiss="modal">Non</button>
        </div>
        </div>
        </div>
    </div>

     <div class="modal" id="infos_histo">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" style="color: blue">Confirmation:</h4>
        </div>
        <div class="modal-body">
        <span class="glyphicon glyphicon-exclamation-sign"> Vous voulez archiver la MP ?</span>
        </div>
        <div class="modal-footer">
        <button data-toggle="modal" href="#infos_detail" class="btn btn-info">Oui</button>
        <button class="btn btn-info" id="modifier">Non</button>
        </div>
        </div>
        </div>
    </div>

    <div class="modal" id="infos_detail">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" style="color: blue">Information:</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" method="POST" action="modifier_mp_au_program.php?info=enreg">
    	   <div class="row">
            <div class="form-group">
            <label for="detail" class="col-sm-3 col-sm-offset-1">Détail: </label>
            <div class="col-sm-6" id="detail_vide">
            <textarea id="detail" onFocus="surface();" name="detail" class="form-control"></textarea>
                <div id="bb" class="alert alert-block alert-danger" style="display:none">
                Veuillez remplir ce champs
                </div>
            </div>
            </div>  
                
            </div>
            <div class="row">
                <div class="form-group">
                     <label for="nom_interv" class="col-sm-3 col-sm-offset-1">Nom d'intervenant: </label>
                     <div class="col-sm-6">
                         <select name="nom_interv" onChange="surface();" id="nom_interv" class="form-control">
                            <option>Morad Elmesoudy</option>
                            <option>Adam Bidaouch</option>
                            <option>Mohammed Neçba</option>
                        </select>
                     </div>     
                </div>  
            </div>
            <div class="row">
                <div class="form-group">
                     <label for="date_interv" class="col-sm-3 col-sm-offset-1">Date d'intervention: </label>
                     <div class="col-sm-6">
                         <input type="date" id="date_interv" name="date_interv" class="form-control">
                </div>     
                </div>  
            </div>
            <input type="hidden" id="date_mp_prevu" name="date_mp_prevu" class="form-control">
            </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-info" id="enreg_modif"><span class="glyphicon glyphicon-check"></span> Enregister</button>
        </div>
    </div>
    </div>
    </div>
</div>
                    <script>
document.getElementById('cadre_de_maintenance').className = 'active';
var click_form_modifier = document.getElementById('modifier'),
	click_form_enregistrer = document.getElementById('enreg_modif'),
    formulaire = document.getElementsByTagName('form'),
    detail = document.getElementById('detail'),
    div_detail = document.getElementById('detail_vide'),
    div_alert = document.getElementById('bb');
//pour modifier les dates d'intervention sans archivage
 click_form_modifier.addEventListener('click', function() {
        formulaire[0].submit();  
   },false);
//pour modifier les dates d'intervention avec archivage
$(function(){
$(click_form_enregistrer).on("click", function() {
if($(detail).val() == "") {
$(div_detail).addClass("has-error");
$(div_alert).show("slow").delay(4000).hide("slow");
return false;
}
else {
    formulaire[1].submit();
} 
});
});

 function surface()
        {
            var date_dernier_mp = document.getElementById("date_dernier_mp").value;
            var date_mp_prevue = document.getElementById("date_mp_prevue").value;
            var date_intervention = document.getElementById('date_interv');
            var date_mp_prevu = document.getElementById('date_mp_prevu');
             date_intervention.value = date_dernier_mp;
             date_mp_prevu.value = date_mp_prevue;
        }    
</script>
        </body>
        </html>
            

