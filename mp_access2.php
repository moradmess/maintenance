<?php
session_start();
if(!empty($_SESSION['DM_INFO']))
{
    $_SESSION['DM_INFO'] = array();
} 
require_once 'classe/Equipement.class.php';
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
        <title>MP Access2</title>
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
         #b1, #b2, #b3
        {
            display: inline-block;
        }
         #page_liste
        {
            margin-top: 0px;
        }

        @media print
        {
            #barre_cherche, #footer, #bt_modifier, #temps, caption
                {
                   display: none;
                }
        }
        
         @media (min-width: 768px) and (max-width: 992px) {
           #page_liste li a, #boutton_list a button {
            width: 30px;
            height: 25px;
            font-size: 10px;
            padding-left: 9px;
        }  
        }
        
        @media (max-width: 768px)  {
         th
        {
            background-color: rgb(217,237,247);
            font-size: 4.4px;
            font-family: 'Palatino Linotype';
        }
        td
        {
            font-size: 4.4px;
            font-family: 'Times New Roman';
        } 
        #bt_modif, #bt_sup
        {
            height: 23px;
            width: 10px;
            padding-left: 1px;
            padding-top: 0px;
        }
        .glyphicon-edit
        {
            font-size: 8px;
        }
        .glyphicon-remove-sign
        {
            font-size: 8px;
        }
        #page_liste li a, #boutton_list a button {
            width: 15px;
            height: 23px;
            font-size: 7px;
            padding-left: 7px;
        }
            
        }
        @media (max-width: 768px) and (orientation: landscape) {
             th
        {
            background-color: rgb(217,237,247);
            font-size: 10px;
            font-family: 'Palatino Linotype';
        }
        td
        {
            font-size: 10px;
            font-family: 'Times New Roman';
        } 
        #bt_modif, #bt_sup
        {
            height: 23px;
            width: 23px;
            padding-left: 7px;
            padding-top: 0px;
        }
        .glyphicon-edit
        {
            font-size: 8px;
        }
        .glyphicon-remove-sign
        {
            font-size: 8px;
        }
        }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row menu">
                <?php require_once 'menu.php';?>
            </div>

               <div id="barre_cherche" class="row">
                <form class="form-inline hidden-sm hidden-xs pull-left well" method="GET" action="mp_access2.php">
                      <div class="form-group">
                      <label class="sr-only" for="mode">mode de recherche: </label>    
                          <select id="mode" name="mode" class="form-control">
                              <option value ="client">Client</option>
                              <option value ="ville">Ville</option>
                              <option value ="serie">N° de série</option>
                              <option value ="contrat">Contrat</option>
                          </select>    
                      </div> 
                          <div class="form-group">
                              <div id="parent_input" class="input-group"> 
                             <input type="text" name="chercher" placeholder="recherche" class="form-control" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                        </span>   
                              </div>
                        </div>
                </form>
                <div class="pull-right hidden-sm hidden-xs well">
                <button type="button" class="btn btn-warning" onclick="window.print();return false;"><span class="glyphicon glyphicon-print"></span> Imprimer</button>
            <a href="excel_mp_au.php?excel"><button type="submit" class="btn btn-warning" name="export_excel"><span class="glyphicon glyphicon-export"></span> Excel</button></a>
            <a href="excel_mp_au.php?word"><button type="submit" class="btn btn-warning" name="export_excel"><span class="glyphicon glyphicon-export"></span> Word</button></a>    
                </div>
                
                <form class="form-inline visible-sm visible-xs pull-left well" method="GET" action="mp_access2.php">
                      <div class="form-group form-group-sm">
                      <label class="sr-only" for="mode">mode de recherche: </label>    
                          <select id="mode" name="mode" class="form-control">
                              <option value ="client">Client</option>
                              <option value ="ville">Ville</option>
                              <option value ="serie">N° de série</option>
                              <option value ="contrat">Contrat</option>
                          </select>    
                      </div> 
                          <div class="form-group form-group-sm">
                              <div id="parent_input" class="input-group input-group-sm"> 
                             <input type="text" name="chercher" placeholder="recherche" class="form-control" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span></button>
                        </span>   
                              </div>
                        </div>
                </form>
                <div class="pull-right visible-sm well">
                <button type="button" class="btn btn-warning btn-sm" onclick="window.print();return false;"><span class="glyphicon glyphicon-print"></span> Imprimer</button>
            <a href="excel_mp_access2.php?excel"><button type="submit" class="btn btn-warning btn-sm" name="export_excel"><span class="glyphicon glyphicon-export"></span> Excel</button></a>
            <a href="excel_mp_access2.php?word"><button type="submit" class="btn btn-warning btn-sm" name="export_excel"><span class="glyphicon glyphicon-export"></span> Word</button></a>    
                </div>
                <div id="xxx" class="col-xs-12 visible-xs well">
                <button type="button" class="col-xs-3 btn btn-warning btn-sm" onclick="window.print();return false;"><span class="glyphicon glyphicon-print"></span> Imprimer</button>
            <a href="excel_mp_access2.php?excel"><button type="submit" class="col-xs-3 col-xs-offset-1 btn btn-warning btn-sm" name="export_excel"><span class="glyphicon glyphicon-export"></span> Excel</button></a>
            <a href="excel_mp_access2.php?word"><button type="submit" class="col-xs-3 col-xs-offset-1 btn btn-warning btn-sm" name="export_excel"><span class="glyphicon glyphicon-export"></span> Word</button></a>    
                </div>
            </div>
            
            <div class="row">
                <table class="table table-bordered table-striped table-condensed">
                    <?php
    if(isset($_GET['mode']) && isset($_GET['chercher']))
    {     //pour le javascript      
         $nombre_ligne_affiche = 10;
         $page_actuelle = 1;
         $nombre_de_page = 1;
         $nbLigne_total = 1;
         $mode = new Access(array($_GET['mode'] => $_GET['chercher']));
         $donnee = $mode->chercher("maintenance",$_GET['mode']); 
         $nb_ligne = count($donnee);
        if($nb_ligne == 0)
        {
            echo '<h3>Aucun résultat trouvé</h3>';
        }
        else {
        echo '<caption><h4>AU : (Nombre total: '.$nb_ligne.')</h4></caption>';
         echo '<thead><tr><th>Num de série</th><th>Version software</th><th>APF</th><th>Date d\'installation</th><th>Nom client</th><th>Ville</th><th>Contrat</th><th>Date Dernière MP</th><th>Date MP Prévue</th><th id="temps">Temps Resté</th></tr></thead>';
    echo '<tbody>';
    for ($i = 0; $i < $nb_ligne; $i++)
    {
    echo '<tr>';
    echo '<td>'.$donnee[$i][0].'</td>';  
    echo '<td>'.$donnee[$i][1].'</td>';
    echo '<td>'.$donnee[$i][2].'</td>';
    echo '<td>'.$donnee[$i][3].'</td>';
    echo '<td>'.$donnee[$i][4].'</td>';
    echo '<td>'.$donnee[$i][5].'</td>';
    echo '<td>'.$donnee[$i][6].'</td>';
    echo '<td>'.$donnee[$i][7].'</td>';
    echo '<td>'.$donnee[$i][8].'</td>';
     $tz = new DateTimeZone('Africa/Casablanca');
                    $date_aujourdhui = new DateTime('now', $tz);
                    $date_mp_prevue = new DateTime($donnee[$i][8], $tz); 
                 if($date_mp_prevue < $date_aujourdhui) {  
                    echo '<td id="temps" style="font-weight: bold; background-color: orangered">Date de la MP Prévue est dépassée</td>';
                    }
                     else {
                        $TempsRestant = $date_aujourdhui->diff($date_mp_prevue);
                        if($TempsRestant->m != 0 && $TempsRestant->d != 0) { echo '<td id="temps" style="background-color: aqua">'.$TempsRestant->m.' mois, '.$TempsRestant->d.' jrs</td>'; }
                        if($TempsRestant->m == 0 && $TempsRestant->d != 0) { echo '<td id="temps" style="background-color: aqua">'.$TempsRestant->d.' jrs</td>'; }
                        if($TempsRestant->m != 0 && $TempsRestant->d == 0) { echo '<td id="temps" style="background-color: aqua">'.$TempsRestant->m.' mois</td>'; }
                        if($TempsRestant->m == 0 && $TempsRestant->d == 0) { echo '<td id="temps" style="background-color: gold">Moins d\'un jour</td>'; }
                       }
                          unset($tz);
                       unset($date_aujourdhui);
                       unset($date_mp_prevue); 
    //vérifier la session de l'admin est ouverte pour accés à la modification                   
        if(isset($_SESSION['ADMIN']))
        {
    echo '<td id="bt_modifier"><a href="modifier_mp_access2.php?code='.$donnee[$i][9].'"><abbr title="éditer"><button id="bt_modif" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-edit"></span></button></abbr></a></td>';
    echo '<td id="bt_modifier"><a href="'.$_SERVER['REQUEST_URI'].'&amp;code='.$donnee[$i][9].'"><abbr title="supprimer"><button id="bt_sup" class="btn btn-danger btn-sm"></abbr><span class="glyphicon glyphicon-remove-sign"></span></button></a></td>';
        }
    echo '</tr>';  
        }
    }
    }
    
    else { //on n'affecte pas de recherche 
        //selectionner le nb total des lignes
        $nbLigne_total = Access::afficher_NbLigne("maintenance");
         
      if(isset($_GET['page']) && isset($_GET['lignes'])) //verifier l'existance des get (ligne et page)
     {
         if(ctype_digit($_GET['page']) && ctype_digit($_GET['lignes'])) //verifier le type int des donnees envoyees par URL
         {
            $nombre_de_page = ($nbLigne_total % $_GET['lignes'] == 0) ? $nbLigne_total/$_GET['lignes'] : (int)($nbLigne_total/$_GET['lignes'])+1;
             if($_GET['page'] <= $nombre_de_page && ($_GET['lignes'] == 10 || $_GET['lignes'] == 20 || $_GET['lignes'] == 50 || $_GET['lignes'] == 100)) //verifier les valeurs entrees des pages et ligne
             {
                if($_GET['page'] == $nombre_de_page || $_GET['page'] == $nombre_de_page - 1)
                {
                   $page_actuelle = $nombre_de_page - 2; 
                }
             else 
                {
                    $page_actuelle = (int) $_GET['page'];
                }
                $nombre_ligne_affiche = (int) $_GET['lignes'];
                $decalage = ((int) $_GET['page'] - 1) * $nombre_ligne_affiche; 
             }
          else //si les donnees ne respecte pas les régles
             {
                $_GET['page'] = 1;
                $_GET['lignes'] = 10;
                $page_actuelle = $_GET['page'];
                $nombre_ligne_affiche = $_GET['lignes'] ;
                $decalage = 0;
                $nombre_de_page = ($nbLigne_total % $nombre_ligne_affiche == 0) ? $nbLigne_total/$nombre_ligne_affiche : (int)($nbLigne_total/$nombre_ligne_affiche)+1;
             }
             
         }
      else  //si les donnees ne sont pas de type entier
         {
               $_GET['page'] = 1;
               $_GET['lignes'] = 10;
               $page_actuelle = $_GET['page'];
               $nombre_ligne_affiche = $_GET['lignes'] ;
               $decalage = 0;
               $nombre_de_page = ($nbLigne_total % $nombre_ligne_affiche == 0) ? $nbLigne_total/$nombre_ligne_affiche : (int)($nbLigne_total/$nombre_ligne_affiche)+1;
         }  
     }
     
 else {  //si les donnees n'existe pas
         $page_actuelle = 1;
         $nombre_ligne_affiche = 10;
         $decalage = 0;
         $nombre_de_page = ($nbLigne_total % $nombre_ligne_affiche == 0) ? $nbLigne_total/$nombre_ligne_affiche : (int)($nbLigne_total/$nombre_ligne_affiche)+1;  
     }
     
    echo '<caption><h4>Planning MP des Access2: (Nombre total: '.$nbLigne_total.')</h4></caption>';
    echo '<thead><tr><th>Num de série</th><th>Version software</th><th>APF</th><th>Date d\'installation</th><th>Nom client</th><th>Ville</th><th>Contrat</th><th>Date Dernière MP</th><th>Date MP Prévue</th><th id="temps">Temps Resté</th></tr></thead>';
    $donnee = Access::afficher_equip($nombre_ligne_affiche, $decalage, "maintenance");
    $nb_ligne = count($donnee);
    echo '<tbody>';
    for ($i = 0; $i < $nb_ligne; $i++)
    {
    echo '<tr>';
    echo '<td>'.$donnee[$i][0].'</td>';  
    echo '<td>'.$donnee[$i][1].'</td>';
    echo '<td>'.$donnee[$i][2].'</td>';
    echo '<td>'.$donnee[$i][3].'</td>';
    echo '<td>'.$donnee[$i][4].'</td>';
    echo '<td>'.$donnee[$i][5].'</td>';
    echo '<td>'.$donnee[$i][6].'</td>';
    echo '<td>'.$donnee[$i][7].'</td>';
    echo '<td>'.$donnee[$i][8].'</td>';
     $tz = new DateTimeZone('Africa/Casablanca');
                    $date_aujourdhui = new DateTime('now', $tz);
                    $date_mp_prevue = new DateTime($donnee[$i][8], $tz); 
                 if($date_mp_prevue < $date_aujourdhui) {  
                    echo '<td id="temps" style="font-weight: bold; background-color: orangered">Date de la MP Prévue est dépassée</td>';
                    }
                     else {
                        $TempsRestant = $date_aujourdhui->diff($date_mp_prevue);
                        if($TempsRestant->m != 0 && $TempsRestant->d != 0) { echo '<td id="temps" style="background-color: aqua">'.$TempsRestant->m.' mois, '.$TempsRestant->d.' jrs</td>'; }
                        if($TempsRestant->m == 0 && $TempsRestant->d != 0) { echo '<td id="temps" style="background-color: aqua">'.$TempsRestant->d.' jrs</td>'; }
                        if($TempsRestant->m != 0 && $TempsRestant->d == 0) { echo '<td id="temps" style="background-color: aqua">'.$TempsRestant->m.' mois</td>'; }
                        if($TempsRestant->m == 0 && $TempsRestant->d == 0) { echo '<td id="temps" style="background-color: gold">Moins d\'un jour</td>'; }
                       }
                          unset($tz);
                       unset($date_aujourdhui);
                       unset($date_mp_prevue);
    //vérifier la session de l'admin est ouverte pour accés à la modification                   
        if(isset($_SESSION['ADMIN']))
        {
    echo '<td id="bt_modifier"><a href="modifier_mp_access2.php?code='.$donnee[$i][9].'"><abbr title="éditer"><button id="bt_modif" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-edit"></span></button></abbr></a></td>';
    if(isset($_GET['page']) || isset($_GET['lignes'])) {
     echo '<td id="bt_modifier"><a href="'.$_SERVER['REQUEST_URI'].'&amp;code='.$donnee[$i][9].'"><abbr title="supprimer"><button id="bt_sup" class="btn btn-danger btn-sm"></abbr><span class="glyphicon glyphicon-remove-sign"></span></button></a></td>';
    } 
    else { 
    echo '<td id="bt_modifier"><a href="'.$_SERVER['REQUEST_URI'].'?code='.$donnee[$i][9].'"><abbr title="supprimer"><button id="bt_sup" class="btn btn-danger btn-sm"></abbr><span class="glyphicon glyphicon-remove-sign"></span></button></a></td>';
         }
        }
    echo '</tr>';
    }
    echo '</tbody>';
    }
?>

                </table>
            </div>
            
            <div class="modal" id="myModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <h4 class="modal-title" style="color: blue">Confirmation:</h4>
</div>
<div class="modal-body">
    <span class="glyphicon glyphicon-exclamation-sign"> Vous voulez vraiment supprimer les informations ?</span>
</div>
    <div class="modal-footer">
        <a href="supprimer_mp_access2.php?code=<?php echo $_GET['code']; ?>"><button type="submit" class="btn btn-danger" id="modifier">Oui</button></a>
        <button class="btn btn-info" data-dismiss="modal" id="momo">Non</button>
</div>
</div>
</div>
</div>
            
                    <div id="footer" class="row">
                <ul id="page_liste" class="pagination pull-left">
                    <li id="first_button"><a href="mp_access2.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=1"><<</a></li>
                    <li id="seconde_button"><a href="mp_access2.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle-1; ?>"><</a></li>
                    <li id="button1"><a href="mp_access2.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle; ?>"><?php echo $page_actuelle; ?></a></li>
                    <li id="button2"><a href="mp_access2.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle+1; ?>"><?php echo $page_actuelle+1; ?></a></li>
                    <li id="button3"><a href="mp_access2.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle+2; ?>"><?php echo $page_actuelle+2; ?></a></li>
                    <li id="last_button"><a href="mp_access2.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $nombre_de_page; ?>">>></a></li>
                </ul>
                <div id="boutton_list" class="pull-right">
                    <a style="text-decoration: none; color: white;" href="mp_access2.php?lignes=10&amp;page=1"><button id="button10" type="button" class="btn btn-info">10</button></a>
                    <a style="text-decoration: none; color: white;" href="mp_access2.php?lignes=20&amp;page=1"><button id="button20" type="button" class="btn btn-info">20</button></a>
                    <a style="text-decoration: none; color: white;" href="mp_access2.php?lignes=50&amp;page=1"><button id="button50" type="button" class="btn btn-info">50</button></a>
                    <a style="text-decoration: none; color: white;" href="mp_access2.php?lignes=100&amp;page=1"><button id="button100" type="button" class="btn btn-info">100</button></a>
                </div>
            </div>
        </div>
         <script>
    document.getElementById('cadre_de_maintenance').className = 'active';
    var nb_ligne_total = <?php echo $nbLigne_total; ?>,
        test_getPage = <?php echo $test_page = (isset($_GET['page'])) ? $_GET['page'] : 0; ?>,
        test_getLigne = <?php echo $test_ligne = (isset($_GET['lignes'])) ? $_GET['lignes'] : 0; ?>,
        num_de_page = <?php echo $numero_de_page = (isset($_GET['page'])) ? $_GET['page'] : 1; ?>,
        nb_de_lignes = <?php echo $nombre_ligne_affiche; ?>,
        nombre_de_page = <?php echo $nombre_de_page; ?>,
        button_stepAllFirst = document.getElementById('first_button'),
        button_step = document.getElementById('seconde_button'),
        button_1 = document.getElementById('button1'),
        button_2 = document.getElementById('button2'),
        button_3 = document.getElementById('button3'),
        button_stepAllLast = document.getElementById('last_button'),
        button_10 = document.getElementById('button10'),
        button_20 = document.getElementById('button20'),
        button_50 = document.getElementById('button50'),
        button_100 = document.getElementById('button100'),
        pied_de_page = document.getElementById('footer'),
        lu = document.getElementById('page_liste');

//gestion des boutons de défilements
if(nombre_de_page == 1) //si le nombre de page à afficher est un
{
    pied_de_page.parentNode.removeChild(pied_de_page);  //enlever les boutons de défilements et les boutons de ligne afficher
}

else if(nombre_de_page == 2)  //si le nombre de page à afficher est deux
{
    lu.removeChild(button_stepAllFirst);
    lu.removeChild(button_step);
    lu.removeChild(button_stepAllLast);
    if(nb_ligne_total < 30 && test_getPage == 0 && test_getLigne == 0)
    {
        lu.removeChild(button_3);
        if(num_de_page == nombre_de_page - 1) //on active le deuxième bouton si la condition est vrai
        {
            button_1.className = 'active';
        }
        if(num_de_page == nombre_de_page) //on active le troixième bouton si la condition est vrai
        {
            button_2.className = 'active';
        }
    }
    else
    {
        lu.removeChild(button_1);
        if(num_de_page == nombre_de_page - 1) //on active le deuxième bouton si la condition est vrai
        {
            button_2.className = 'active';
        }
        if(num_de_page == nombre_de_page) //on active le troixième bouton si la condition est vrai
        {
            button_3.className = 'active';
        }
    } 
}

else if(nombre_de_page == 3) //si le nombre de page à afficher est trois
{
    //on laisse les trois boutons de défilement 
   lu.removeChild(button_stepAllFirst);
   lu.removeChild(button_step);
   lu.removeChild(button_stepAllLast); 
    if(num_de_page == nombre_de_page - 2) //on active le premier bouton si la condition est vrai
    {
        button_1.className = 'active';
    }
    if(num_de_page == nombre_de_page - 1) //on active le deuxième bouton si la condition est vrai
    {
        button_2.className = 'active';
    }
    if(num_de_page == nombre_de_page) //on active le troixième bouton si la condition est vrai
    {
        button_3.className = 'active';
    }
}

else //si le nombre de page à afficher est supérieur à trois
{
    if(num_de_page <= nombre_de_page - 2)
    {
        //on active le premier bouton 
       button_1.className = 'active';
       if(num_de_page == 1) //si le nombre de page est un
       {
           //on supprime les deux premier boutons step 
           button_step.parentNode.removeChild(button_step);
           button_stepAllFirst.parentNode.removeChild(button_stepAllFirst);
       }
    }
    else
    {  //on supprime le dernier bouton step
        button_stepAllLast.parentNode.removeChild(button_stepAllLast);
        if(num_de_page == nombre_de_page - 1)
        {
        button_2.className = 'active';
        }
        if(num_de_page == nombre_de_page)
        {
        button_3.className = 'active';
        }   
    }
}

//selectionner le button cliquer
switch(nb_de_lignes)
{
    case 10:
        button_10.className = 'btn btn-primary'
        break;
        case 20:
            button_20.className = 'btn btn-primary'
        break;
        case 50:
            button_50.className = 'btn btn-primary'
        break;
        case 100:
            button_100.className = 'btn btn-primary'
        break;
    default:
        break;
}
var id_sup = <?php echo $test_page = (isset($_GET['code'])) ? (int) $_GET['code'] : 0; ?>;
if(id_sup !== 0) {
$('#myModal').modal('show');
}
else {
$('#myModal').modal('hide');
}

var sup_annuler = document.getElementById("momo");

 sup_annuler.addEventListener('click', function() {
        window.history.back();  
   },false);
        </script>
    </body>
</html>
        