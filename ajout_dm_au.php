<?php
session_start();
if(empty($_SESSION['ADMIN']) || !isset($_SERVER['HTTP_REFERER'])) {
    header("location:index.php");
}
require 'classe/Equipement.class.php';
$info = new AU(array());
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
                                 <form class="form-horizontal col-sm-6" method="POST" action="enregister_au.php">
  <legend>Ajouter un équipement AU:</legend>
  <div class="row">
                <div class="form-group">
                    <label for="serie" class="col-sm-3">Num de série: </label>
                    <div class="col-sm-9">
                        <input type="number" placeholder="2018200501" name="serie" id="serie" min="1000000000" max="9999999999" class="form-control">    
                </div>
                </div> 
                </div> 


                  <div class="row">
                <div class="form-group">
                     <label for="ise" class="col-sm-3">ISE: </label>
                     <div class="col-sm-9">
                         <select name="ise" id="ise" class="form-control">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                </div>
                </div>    
                </div>
                
                <div class="row">
                <div class="form-group">
                     <label for="soft" class="col-sm-3">Version Software: </label>
                     <div class="col-sm-9">
                     <input type="text" placeholder="1.91" name="soft" id="soft" class="form-control" required>
                </div>
                </div>  
                </div>
                
                  <div class="row">
                <div class="form-group">
                     <label for="date_installe" class="col-sm-3">Date d'installation: </label>
                     <div class="col-sm-9">
                         <input type="date" id="date_installe" name="date_installe" class="form-control" required>
                </div>     
                </div>  
                </div>
                
                  <div class="row">
                <div class="form-group">
                    <label for="cli" class="col-sm-3">Nom client: </label>
                     <div class="col-sm-9">
                        <select name="client" id="cli" class="form-control">
                        <?php 
                        $client = $info->formulaire_label('client');  
                        $total = count($client); 
                        for ($i=0; $i < $total; $i++) { ?>
                            <option><?php echo $client[$i]['nom_client']; ?></option><?php
                        }
                            ?>
                            <option style="font-weight: bold;">Autre</option>
                        </select>

                </div>
                </div>  
                </div>

               <div id="v" class="row">
                <div class="form-group">
                     <label for="ville" class="col-sm-3">Ville: </label>
                     <div class="col-sm-9">
                         <select name="ville" id="ville" class="form-control">
                        <?php 
                        $ville = $info->formulaire_label('ville');  
                        $totale = count($ville); 
                        for ($i=0; $i < $totale; $i++) { ?>
                            <option><?php echo $ville[$i]['ville']; ?></option><?php
                        }
                            ?>
                            <option style="font-weight: bold;">Autre</option>
                        </select>
                </div>
                </div>  
                </div>
                
                <div id="ppp" class="row">
                <div class="form-group">
                     <label for="contrat" class="col-sm-3">Contrat: </label>
                     <div class="col-sm-9">
                         <select name="contrat" id="contrat" class="form-control">
                            <option>MAD</option>
                            <option>Sous Garantie</option>
                            <option>Sous Contrat</option>
                            <option>Hors Garantie</option>
                            <option>Hors Contrat</option>
                            <option>Vente</option>
                            <option>NA</option>
                        </select>
                </div>
                </div>  
                </div>                    

                <div class="form-group">
                    <button type="submit" name="enregistrer" class="btn btn-default pull-right">
                <span class="glyphicon glyphicon-check"></span> Enregistrer</button>
                </div>    
</form>
                 </div>
        <script>
document.getElementById('equipement').className = 'active';
var ville = document.getElementById('v'),
    contrat = document.getElementById('ppp');
//création du champs "Autre client"
//creation ses elements html
var div_client = document.createElement('div');
div_client.className = 'row';
div_client.id = 'client';
var div2_client = document.createElement('div');
div2_client.className = 'form-group';
var div3_client = document.createElement('div');
div3_client.className = 'col-sm-9';
var label_client = document.createElement('label');
label_client.htmlFor = 'client';
label_client.className = 'col-sm-3';
var input_client = document.createElement('input');
input_client.type = 'text';
input_client.id = 'client';
input_client.name = 'client';
input_client.placeholder = 'Saisir client...';
input_client.className = 'form-control';
//collecter ses elements html
div3_client.appendChild(input_client);
div2_client.appendChild(label_client);
div2_client.appendChild(div3_client);
div_client.appendChild(div2_client);

//création du champs "Autre ville"
//creation ses elements html
var div_ville = document.createElement('div');
div_ville.className = 'row';
div_ville.id = 'ville';
var div2_ville = document.createElement('div');
div2_ville.className = 'form-group';
var div3_ville = document.createElement('div');
div3_ville.className = 'col-sm-9';
var label_ville = document.createElement('label');
label_ville.htmlFor = 'ville';
label_ville.className = 'col-sm-3';
var input_ville = document.createElement('input');
input_ville.type = 'text';
input_ville.id = 'ville';
input_ville.name = 'ville';
input_ville.placeholder = 'Saisir ville...';
input_ville.className = 'form-control';
//collecter ses elements html
div3_ville.appendChild(input_ville);
div2_ville.appendChild(label_ville);
div2_ville.appendChild(div3_ville);
div_ville.appendChild(div2_ville); 

var cadre = document.getElementById('cli'),
    formulaire = document.getElementsByTagName('form')[0],
    v = document.getElementById('ville');
  
    cadre.addEventListener('change', function() {
    if(cadre.options[cadre.selectedIndex].innerHTML == 'Autre')
    {
        cadre.setAttribute("disabled","");
        formulaire.insertBefore(div_client, ville);
    } 
}, false);

    v.addEventListener('change', function () {
      if(v.options[v.selectedIndex].innerHTML == 'Autre')
    {
        v.setAttribute("disabled","");
        formulaire.insertBefore(div_ville, contrat);
    }
}, false)

 liste_equip.addEventListener('change', function() {
   if(liste_equip.options[liste_equip.selectedIndex].innerHTML == 'Autre')
{
    liste_equip.parentNode.replaceChild(input_equipement,liste_equip);
}
}, false);
 
 /*  enregis.addEventListener('click', function() {
       cadre.removeAttribute('disabled'); 
   },false);
 
$(function (){
$(".close").click(function() {
$(".alert").hide("slow");
});
});*/
</script>
        </div>
        </body>
        </html>
            
