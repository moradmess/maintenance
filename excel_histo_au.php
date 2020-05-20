<?php
if(!isset($_SERVER['HTTP_REFERER'])) {
    header("location: index.php");
}
 if(isset($_GET['word']))
            {
              header("Content-Type: application/doc");
              header("Content-Disposition: attachment; filename=Historique_MP_AU.doc");  
            }
            else
            {
              header("Content-Type: application/xls");
              header("Content-Disposition: attachment; filename=Historique_MP_AU.xls");   
            }
require_once 'classe/Equipement.class.php';
?>
<html>
    <head>
      <meta charset="UTF-8"> 
      <style>
          table, th, tr, td
          {
              border: 1px solid black;
              border-collapse: collapse;
          }
      </style>
    </head>
<body>
<?php
    echo '<table>';
       echo '<thead><tr><th>ISE</th><th>Num de série</th><th>Version software</th><th>Date d\'installation</th><th>Nom client</th><th>Ville</th><th>Contrat</th><th>Date d\'intervention</th><th>Nom intervenant</th><th>Detail</th></tr></thead>';
       echo '<tbody>';
       require_once 'conx_base.php';
       $req = $bdd->query('SELECT dm.ise, dm.serial_number, dm.version_soft, dm.date_installe, c.nom_client, c.ville, dm.contrat, dm.date_interv, dm.nom_intervenant, dm.detail FROM histo_au dm INNER JOIN client c ON dm.code_client = c.idc');
       $donnee = $req->fetchAll();
       $nb_ligne = count($donnee);
       for($i = 0; $i < $nb_ligne; $i++)
       {
           echo '<tr>';
           echo '<td>'.$donnee[$i][0].'</td><td>'.$donnee[$i][1].'</td><td>'.$donnee[$i][2].'</td><td>'.$donnee[$i][3].'</td><td>'.$donnee[$i][4].'</td><td>'.$donnee[$i][5].'</td><td>'.$donnee[$i][6].'</td><td>'.$donnee[$i][7].'</td><td>'.$donnee[$i][8].'</td><td>'.$donnee[$i][9].'</td>';   
           echo '</tr>';
       }
       $req->closeCursor();
       echo '</tbody>';
       echo '</table>';
//}
?>    
</body>
</html>
