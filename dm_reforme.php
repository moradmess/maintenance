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
        <title>Atelier</title>
         <style>
        th
        {
            background-color: rgb(217,237,247);
            font-size: 0.8em;
            font-family: 'Palatino Linotype';
        }
        td
        {
            font-size: 0.8em;
            font-family: 'Times New Roman';
        }
         #page_liste
        {
            margin-top: 0px;
        }

        @media print
        {
            #barre_cherche, #footer, #bt_modifier, caption
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
            font-size: 6px;
            font-family: 'Palatino Linotype';
        }
        td
        {
            font-size: 6px;
            font-family: 'Times New Roman';
        } 
        #bt_modif, #bt_ajout
        {
            height: 20px;
            width: 30px;
            padding-left: 0px;
            padding-top: 0px;
        }
        .glyphicon-edit
        {
            font-size: 10px;
        }
        .glyphicon-pencil
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
        #bt_modif, #bt_ajout
        {
            height: 20px;
            width: 30px;
            padding-left: 0px;
            padding-top: 0px;
        }
        .glyphicon-edit
        {
            font-size: 10px;
        }
        .glyphicon-pencil
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
                <!-- pour l"affichage en haut dans la taille xs -->
                <form class="form-horizontal visible-xs col-xs-12 well" method="GET" action="dm_reforme.php">
                      <div class="form-group form-group-sm">
                          <select id="mode" name="mode" class="form-control">
                              <option value ="client">Client</option>
                              <option value ="ville">Ville</option>
                              <option value ="serie">N° de série</option>
                              <option value ="contrat">Contrat</option>
                          </select>    
                      </div> 
                          <div class="form-group form-group-sm">
                              <div id="parent_input" class="input-group input-group-sm"> 
                             <input type="search" name="chercher" placeholder="recherche" class="form-control" required>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span></button>
                        </span>   
                              </div>
                        </div>
                </form>
                
                  <form method="GET" action="dm_reforme.php">
                        <div class="form-group">
                        <label class="radio-inline" for="client">
                        <input type="radio" id="client" name="trier" value="Client" checked> Client
                        </label>
                        </div>
                        <div class="form-group">
                        <label class="radio-inline" for="date">
                        <input type="radio" id="date" name="trier" value="Date"> Date
                        </label>
                        </div>
                        <button type="submit"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span>trier</button>
                    </form>
                    
                <form id="form_recherche" method="GET" action="dm_reforme.php">
                      <div id="label_recherche">
                          <label class="sr-only">recherche</label>
                          <select id="mode" name="mode" class="form-control">
                              <option value ="client">Client</option>
                              <option value ="ville">Ville</option>
                              <option value ="serie">N° de série</option>
                              <option value ="appareil">Appareil</option>
                          </select>    
                      </div> 
                          <div id="div_recherche">
                              <div id="parent_input"> 
                             <input type="search" name="chercher" placeholder="recherche" class="form-control" required>
                        <span class="input-group-btn">
                            <button id="bt_recherche" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>   
                              </div>
                        </div>
                </form>
                
                <div id="bt_wei">
                    <div class="row">
                        <button id="bt_imprimer" type="button" onclick="window.print();return false;"><span class="glyphicon glyphicon-print"></span></button>
                        <a id="bt_excel" href="excel_dm_reforme.php?excel"><button type="submit" name="export_excel"><span class="glyphicon glyphicon-export"></span> Excel</button></a>    
                    <a id="bt_word" href="excel_dm_reforme.php?word"><button type="submit" name="export_excel"><span class="glyphicon glyphicon-export"></span> Word</button></a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <table class="table table-bordered table-striped table-condensed">
                    <?php
//faire des recherches
    if(isset($_GET['mode']) && isset($_GET['chercher']))
    {     //pour le javascript      
         $nombre_ligne_affiche = 10;
         $page_actuelle = 1;
         $nombre_de_page = 1;
         $nbLigne_total = 1;
         $mode = new Equipement_Reforme(array($_GET['mode'] => $_GET['chercher']));
         $donnee = $mode->chercher($_GET['mode']); 
         $nb_ligne = count($donnee);
        if($nb_ligne == 0)
        {
            echo '<h3>Aucun résultat trouvé</h3>';
        }
        else {
    echo '<caption><h4>Equipements récupérés: (Nombre total: '.$nb_ligne.')</h4></caption>';
    echo '<thead><tr><th>Appareil</th><th>Num de série</th><th>Version software</th><th>Date d\'installation</th><th>Nom client</th><th>Ville</th><th>Date réforme</th></tr></thead>';
    echo '<tbody>';
    for ($i = 0; $i < $nb_ligne; $i++)
    {
    echo '<tr>';
    for($j = 0; $j < 7; $j++)
    {
        echo '<td>'.$donnee[$i][$j].'</td>';
    }
    echo '</tr>';
    }
    echo '</tbody>'; 
        }
        
    }
    
    //on n'affecte pas de recherche 
 else {
        //selectionner le nb total des lignes
        $nbLigne_total = Equipement_Reforme::afficher_NbLigne();
         
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
     
    echo '<caption><h4>Equipements récupérés: (Nombre total: '.$nbLigne_total.')</h4></caption>';
    echo '<thead><tr><th>Appareil</th><th>Num de série</th><th>Version software</th><th>Date d\'installation</th><th>Nom client</th><th>Ville</th><th>Date réforme</th></tr></thead>';
    $donnee = (isset($_GET['trier'])) ? Equipement_Reforme::afficher_equip_trier($nombre_ligne_affiche, $decalage, $_GET['trier']) : Equipement_Reforme::afficher_equip($nombre_ligne_affiche, $decalage);;
    $nb_ligne = count($donnee);
    echo '<tbody>';
    for ($i = 0; $i < $nb_ligne; $i++) {
    echo '<tr>';
    for($j = 0; $j < 7; $j++)   echo '<td>'.$donnee[$i][$j].'</td>';
    echo '</tr>';
    }
    echo '</tbody>'; 
 }
?>
                </table>
            </div>
       <?php
             if(isset($_GET['trier']))
            {
            ?>
                    <div id="footer" class="row">
                <ul id="page_liste" class="pagination pull-left">
                    <li id="first_button"><a href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=1"><<</a></li>
                    <li id="seconde_button"><a href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle-1; ?>"><</a></li>
                    <li id="button1"><a href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle; ?>"><?php echo $page_actuelle; ?></a></li>
                    <li id="button2"><a href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle+1; ?>"><?php echo $page_actuelle+1; ?></a></li>
                    <li id="button3"><a href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle+2; ?>"><?php echo $page_actuelle+2; ?></a></li>
                    <li id="last_button"><a href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $nombre_de_page; ?>">>></a></li>
                </ul>
                <div id="boutton_list" class="pull-right">
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=10&amp;page=1"><button id="button10" type="button" class="btn btn-info">10</button></a>
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=20&amp;page=1"><button id="button20" type="button" class="btn btn-info">20</button></a>
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=50&amp;page=1"><button id="button50" type="button" class="btn btn-info">50</button></a>
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?trier=<?php echo $_GET['trier']; ?>&amp;lignes=100&amp;page=1"><button id="button100" type="button" class="btn btn-info">100</button></a>
                </div>
            </div>
            <?php }
            else {  ?> 
            <div id="footer" class="row">
                <ul id="page_liste" class="pagination pull-left">
                    <li id="first_button"><a href="dm_reforme.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=1"><<</a></li>
                    <li id="seconde_button"><a href="dm_reforme.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle-1; ?>"><</a></li>
                    <li id="button1"><a href="dm_reforme.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle; ?>"><?php echo $page_actuelle; ?></a></li>
                    <li id="button2"><a href="dm_reforme.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle+1; ?>"><?php echo $page_actuelle+1; ?></a></li>
                    <li id="button3"><a href="dm_reforme.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $page_actuelle+2; ?>"><?php echo $page_actuelle+2; ?></a></li>
                    <li id="last_button"><a href="dm_reforme.php?lignes=<?php echo $nombre_ligne_affiche; ?>&amp;page=<?php echo $nombre_de_page; ?>">>></a></li>
                </ul>
                <div id="boutton_list" class="pull-right">
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?lignes=10&amp;page=1"><button id="button10" type="button" class="btn btn-info">10</button></a>
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?lignes=20&amp;page=1"><button id="button20" type="button" class="btn btn-info">20</button></a>
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?lignes=50&amp;page=1"><button id="button50" type="button" class="btn btn-info">50</button></a>
                    <a style="text-decoration: none; color: white;" href="dm_reforme.php?lignes=100&amp;page=1"><button id="button100" type="button" class="btn btn-info">100</button></a>
                </div>
            </div>
            <?php }
            ?>
         <script>
    document.getElementById('reforme').className = 'active';
    var nb_ligne_total = <?php echo $nbLigne_total; ?>, // recuperation de nombre total des lignes affichées
        test_getPage = <?php echo $test_page = (isset($_GET['page'])) ? $_GET['page'] : 0; ?>,  // test d'existance de variable get pour la page
        test_getLigne = <?php echo $test_ligne = (isset($_GET['lignes'])) ? $_GET['lignes'] : 0; ?>, // test d'existance de variable get pour les lignes
        num_de_page = <?php echo $numero_de_page = (isset($_GET['page'])) ? $_GET['page'] : 1; ?>, // recuperer numero de la page affiche
        nb_de_lignes = <?php echo $nombre_ligne_affiche; ?>, // récuperer le nb de lignes à afficher (10, 20,50, 100)
        nombre_de_page = <?php echo $nombre_de_page; ?>,  // nb de page prendre par le dernier bouton >>
        button_stepAllFirst = document.getElementById('first_button'), // le bouton <<
        button_step = document.getElementById('seconde_button'), // le bouton <
        button_1 = document.getElementById('button1'),
        button_2 = document.getElementById('button2'),
        button_3 = document.getElementById('button3'),
        button_stepAllLast = document.getElementById('last_button'), // le bouton >> 
        button_10 = document.getElementById('button10'),
        button_20 = document.getElementById('button20'),
        button_50 = document.getElementById('button50'),
        button_100 = document.getElementById('button100'),
        list_bouton = document.getElementById('boutton_list'),
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

var formulaire = document.getElementsByTagName('form'),
    div_form_recherche = document.getElementById("label_recherche"),
    input_client = document.getElementById("client"),
    input_date = document.getElementById("date"),
    div_recherche = document.getElementById("div_recherche"),
    button_recherche = document.getElementById("bt_recherche"),
    div_trois_buttons = document.getElementById("bt_wei"),
    b1 = document.getElementById("bt_imprimer"),
    b2 = document.getElementById("bt_excel"),
    b3 = document.getElementById("bt_word");
    
function myFunction(x) {
  if (x.matches) { // If media query matches
    //sm et xs
        formulaire[1].setAttribute('class', 'form-horizontal col-sm-2 col-xs-6 well');  //remplacer l'attribute class dans la formulaire de triage
        formulaire[1].setAttribute('style', 'padding-top: 9px !important;'); //ajouter l'attribute style dans la balise <form> de triage
        input_client.parentElement.setAttribute('style', 'font-size: 12px;'); //ajouter l'attribute style dans la balise <label> client de triage
        input_client.setAttribute('style', 'height:10px; width:10px;'); //ajouter l'attribute style dans la balise <input> client de triage
        input_date.parentElement.setAttribute('style', 'font-size: 12px;'); //ajouter l'attribute style dans la balise <label> date de triage
        input_date.setAttribute('style', 'height:10px; width:10px;'); //ajouter l'attribute style dans la balise <input> date de triage
        formulaire[1].lastElementChild.setAttribute('class', 'btn btn-default btn-sm'); //ajouter une classe à la balise <button> de triage
        
        formulaire[2].setAttribute('class', 'form-horizontal visible-sm col-sm-7 well');  //remplacer l'attribute class dans la formulaire de rechercher
        formulaire[2].firstElementChild.setAttribute('class', 'form-group form-group-sm');  //ajouter l'attribute class dans le 1er div de formulaire de rechercher
        formulaire[2].firstElementChild.setAttribute('style', 'padding-top: 7px !important;');  //ajouter l'attribute class dans le div select de formulaire de rechercher
        div_recherche.setAttribute('class', 'form-group form-group-sm');  //ajouter l'attribute class dans le div input de formulaire de rechercher
        div_recherche.firstElementChild.setAttribute('class', 'input-group input-group-sm');  //ajouter l'attribute class dans le div div input de formulaire de rechercher
        button_recherche.setAttribute('class', 'btn btn-default btn-sm');  //ajouter class à button de formulaire recherche
        
        div_trois_buttons.setAttribute('class', 'col-sm-3 col-xs-6 well');  //remplacer l'attribute class dans lu div de tois boutons
        b1.setAttribute('class', 'btn btn-warning btn-sm center-block');  //ajouter dans l'attribute class du boutton imprimer
        b2.setAttribute('style', 'text-decoration: none;');  //ajouter dans l'attribute style du a de boutton excel
        b2.firstElementChild.setAttribute('style', 'margin-top: 5px; margin-bottom: 5px;');  //ajouter dans l'attribute style de boutton excel
        b2.firstElementChild.setAttribute('class', 'btn btn-warning btn-sm center-block');  //ajouter dans l'attribute class du boutton excel
        b3.setAttribute('style', 'text-decoration: none;');  //ajouter dans l'attribute style du a de boutton word
        b3.firstElementChild.setAttribute('class', 'btn btn-warning btn-sm center-block');  //ajouter dans l'attribute class du boutton word
} else {
        formulaire[1].setAttribute('class', 'form-inline col-md-3 well');  //remplacer l'attribute class dans la formulaire de triage
        formulaire[1].removeAttribute('style'); //supprimer l'attribute style dans la balise <form> de triage
        input_client.parentElement.removeAttribute('style'); //supprimer l'attribute style dans la balise <label> client de triage
        input_client.removeAttribute('style'); //supprimer l'attribute style dans la balise <input> client de triage
        input_date.parentElement.removeAttribute('style'); //supprimer l'attribute style dans la balise <label> date de triage
        input_date.removeAttribute('style'); //supprimer l'attribute style dans la balise <input> date de triage
        formulaire[1].lastElementChild.setAttribute('class','btn btn-default'); //modifier une classe à la balise <button> de triage
        
        formulaire[2].setAttribute('class', 'form-inline col-lg-4 col-lg-offset-1 col-md-5 well');  //remplacer l'attribute class dans la formulaire de rechercher
        formulaire[2].firstElementChild.setAttribute('class', 'form-group');  //modifier l'attribute class dans le 1er div de formulaire de rechercher
        formulaire[2].firstElementChild.removeAttribute('style');  //supprimer l'attribute class dans le div select de formulaire de rechercher
        div_recherche.setAttribute('class', 'form-group');  //modifier l'attribute class dans le div input de formulaire de rechercher
        div_recherche.firstElementChild.setAttribute('class', 'input-group');  //modifier l'attribute class dans le div div input de formulaire de rechercher
        button_recherche.setAttribute('class', 'btn btn-default');  //modifier class à button de formulaire recherche
        
        div_trois_buttons.setAttribute('class', 'col-lg-3 col-lg-offset-1 col-md-4 well');  //remplacer l'attribute class dans lu div de tois boutons
        b1.setAttribute('class', 'col-md-2 btn btn-warning');  //modifier dans l'attribute class du boutton imprimer
        b2.removeAttribute('style');  //supprimer dans l'attribute style du a de boutton excel
        b2.firstElementChild.removeAttribute('style', 'margin-top = 5px; margin-bottom= 5px;');  //supprimer dans l'attribute style de boutton excel*/
        b2.firstElementChild.setAttribute('class', 'col-md-4 col-md-offset-1 btn btn-warning');  //modifier dans l'attribute class du boutton excel
        b3.removeAttribute('style');  //supprimer dans l'attribute style du a de boutton word
        b3.firstElementChild.setAttribute('class', 'btn btn-warning col-md-4 col-md-offset-1');  //modifier dans l'attribute class du boutton word*/
        
  }
}

var x = window.matchMedia("(max-width: 992px)")
myFunction(x) // Call listener function at run time
x.addListener(myFunction) // Attach listener function on state changes
        </script>
    </body>
</html>