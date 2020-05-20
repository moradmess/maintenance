<?php
session_start();
if(!empty($_SESSION['DM_INFO']))
{
    $_SESSION['DM_INFO'] = array();
} 
require_once 'classe/Equipement.class.php';
 $client = Equipement::nom_client();  
 $total = count($client);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initialscale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/inventaire_style.css">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Client</title>
        <style>
        th
        {
            background-color: rgb(217,237,247);
            font-size: 1em;
            font-family: 'Palatino Linotype';
        }
        td
        {
            font-size: 1em;
            font-family: 'Times New Roman';
        }
        
        @media (max-width: 768px)  {
         th
        {
            background-color: rgb(217,237,247);
            font-size: 8px;
            font-family: 'Palatino Linotype';
        }
        td
        {
            font-size: 8px;
            font-family: 'Times New Roman';
        } 
            
        }
        @media (max-width: 768px) and (orientation: landscape) {
        th
        {
            background-color: rgb(217,237,247);
            font-size: 13px;
            font-family: 'Palatino Linotype';
        }
        td
        {
            font-size: 13px;
            font-family: 'Times New Roman';
        } 
        }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row menu">
                <?php require_once 'menu.php'; ?>
            </div>
            <div class="row">
                <caption><h4>Nombre total des clients: <?php echo $total; ?></h4></caption>
                 <form id="form_recherche" class="form form-inline hidden-xs" method="POST" action="client.php">
                      <div class="form-group">
                          <label for="nom_client">Choisir le laboratoire:</label>
                         <select name="nom_client" id="nom_client" class="form-control">
                        <?php 
                        for ($i=0; $i < $total; $i++) { ?>
                        <option <?php if(isset ($_POST['nom_client']) && $client[$i]['nom_client'].' // '.$client[$i]['ville'] == $_POST['nom_client']) { echo "selected"; }  ?>>
                        <?php echo $client[$i]['nom_client'].' // '.$client[$i]['ville']; ?>
                        </option><?php
                        }
                            ?>
                        </select>   
                      </div> 
                          <div id="div_recherche" class="form-group">
                            <button id="bt_recherche" class="btn btn-info" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                              </div>
                    </form>
                    
                    <form class="form form-inline visible-xs" method="POST" action="client.php">
                     <div class="form-group">
                          <label for="nom_client">Choisir le laboratoire:</label>
                         <select name="nom_client" id="nom_client" class="form-control">
                        <?php 
                        for ($i=0; $i < $total; $i++) { ?>
                        <option <?php if(isset ($_POST['nom_client']) && $client[$i]['nom_client'].' // '.$client[$i]['ville'] == $_POST['nom_client']) { echo "selected"; }  ?>>
                        <?php echo $client[$i]['nom_client'].' // '.$client[$i]['ville']; ?>
                        </option><?php
                        }
                            ?>
                        </select>   
                      </div> 
                          <div id="div_recherche" class="form-group">
                            <button id="bt_recherche" class="btn btn-info btn-sm btn-block" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                              </div>
                    </form>
             </div>
             <div class="row" style="margin-top: 20px;">
    <?php
    if(isset($_POST['nom_client'])) {
    $value = explode("//", $_POST['nom_client']); //split
    $client = trim($value[0]); //Supprimer les espaces au DEBUT ET FIN de chaine
    $ville = trim($value[1]);  //Supprimer les espaces au DEBUT ET FIN de chaine
    require 'conx_base.php';
        $req_idc = 'SELECT idc FROM client WHERE nom_client = :client AND ville = :ville';
        $q = $bdd->prepare($req_idc); 
        $q->bindValue(':client', $client, PDO::PARAM_STR);
        $q->bindValue(':ville', $ville, PDO::PARAM_STR);
        $q->execute();
        $donnee_idc = $q->fetch();
        $q->closeCursor();
        //selectionner les donnees de la table AU
        $req_au = 'SELECT iddmau, serial_number, status, version_soft, date_installe, contrat FROM dm_au WHERE code_client = :id';
        $q1 = $bdd->prepare($req_au); 
        $q1->bindValue(':id', $donnee_idc['idc'], PDO::PARAM_INT);
        $q1->execute();
        $donnee = $q1->fetchAll();
        $q1->closeCursor();
        $nb_ligne = count($donnee);
        //selectionner les donnees de la table Access2
        $req_access = 'SELECT iddma, serial_number, status, version_soft, date_installe, contrat FROM dm_access2 WHERE code_client = :id';
        $q2 = $bdd->prepare($req_access); 
        $q2->bindValue(':id', $donnee_idc['idc'], PDO::PARAM_INT);
        $q2->execute();
        $donnees = $q2->fetchAll();
        $q2->closeCursor();
        $nb_lig = count($donnees);
    if($nb_ligne == 0 && $nb_lig == 0) {
        echo "<h3>Aucun résultat trouvé</h3>";
    }
    else {
    echo '<table class = "table table-bordered table-striped table-condensed">';
    echo '<thead><tr><th>Appareil</th><th>Num de série</th><th>Etat</th><th>Version software</th><th>Date d\'installation</th><th>Contrat</th><th>Date dernière MP</th><th>Date MP prévue</th></tr></thead>';
    echo '<tbody>';
    for ($i = 0; $i < $nb_ligne; $i++)
    {
    $req_mp_au = 'SELECT date_dernier_mp, date_mp_prevue FROM mp_au WHERE code_dm_au = :id';
    $q3 = $bdd->prepare($req_mp_au);
    $q3->bindValue(':id', $donnee[$i][0], PDO::PARAM_INT);
    $q3->execute();
    $donnee_date_au = $q3->fetch();
    $q3->closeCursor();
    if($donnee_date_au != NULL) {
    echo '<tr>';
    echo '<td>AU</td>';
    echo '<td>'.$donnee[$i][1].'</td>';
    echo '<td>'.$donnee[$i][2].'</td>';
    echo '<td>'.$donnee[$i][3].'</td>';
    echo '<td>'.$donnee[$i][4].'</td>';
    echo '<td>'.$donnee[$i][5].'</td>';
    echo '<td>'.$donnee_date_au['date_dernier_mp'].'</td>';
    echo '<td>'.$donnee_date_au['date_mp_prevue'].'</td>'; 
    echo '</tr>';
        }
    else {
    echo '<tr>';
    echo '<td>AU</td>';
    echo '<td>'.$donnee[$i][1].'</td>';
    echo '<td>'.$donnee[$i][2].'</td>';
    echo '<td>'.$donnee[$i][3].'</td>';
    echo '<td>'.$donnee[$i][4].'</td>';
    echo '<td>'.$donnee[$i][5].'</td>';
    echo '<td>---</td>';
    echo '<td>---</td>'; 
    echo '</tr>'; 
        }
    }
     for ($i = 0; $i < $nb_lig; $i++)
    {
    $req_mp_access = 'SELECT date_dernier_mp, date_mp_prevue FROM mp_access2 WHERE code_dm_a = :id';
    $q4 = $bdd->prepare($req_mp_access);
    $q4->bindValue(':id', $donnees[$i][0], PDO::PARAM_INT);
    $q4->execute();
    $donnee_date_access = $q4->fetch();
    $q4->closeCursor();
    if($donnee_date_access != NULL) {
    echo '<tr>';
    echo '<td>Access2</td>';
    echo '<td>'.$donnees[$i][1].'</td>';
    echo '<td>'.$donnees[$i][2].'</td>';
    echo '<td>'.$donnees[$i][3].'</td>';
    echo '<td>'.$donnees[$i][4].'</td>';
    echo '<td>'.$donnees[$i][5].'</td>';
    echo '<td>'.$donnee_date_access['date_dernier_mp'].'</td>';
    echo '<td>'.$donnee_date_access['date_mp_prevue'].'</td>'; 
    echo '</tr>';
        }
    else {
    echo '<tr>';
    echo '<td>Access2</td>';
    echo '<td>'.$donnees[$i][1].'</td>';
    echo '<td>'.$donnees[$i][2].'</td>';
    echo '<td>'.$donnees[$i][3].'</td>';
    echo '<td>'.$donnees[$i][4].'</td>';
    echo '<td>'.$donnees[$i][5].'</td>';
    echo '<td>---</td>';
    echo '<td>---</td>'; 
    echo '</tr>'; 
        }
    }
    echo '</tbody>'; 
    echo '</table>';
    }
    }
                 ?>
             </div>
                
            </div>
        <script>
        document.getElementById('client').className = 'active';
        </script>
    </body>
</html>