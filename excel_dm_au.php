<?php
if(!isset($_SERVER['HTTP_REFERER'])) {
    header("location: index.php");
}
       if(isset($_GET['word']))
            {
              header("Content-Type: application/doc");
              header("Content-Disposition: attachment; filename=AU.doc");  
            }
            else
            {
              header("Content-Type: application/xls");
              header("Content-Disposition: attachment; filename=AU.xls");   
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
        echo '<thead><tr><th>ISE</th><th>Num de série</th><th>Etat</th><th>Version software</th><th>Date d\'installation</th><th>Nom client</th><th>Ville</th><th>Contrat</th></tr></thead>';
       echo '<tbody>';
    require_once 'conx_base.php';
    $req = $bdd->query('SELECT au.ise,au.serial_number,au.status,au.version_soft,au.date_installe,c.nom_client,c.ville,au.contrat FROM dm_au au INNER JOIN client c ON au.code_client=c.idc');
    $donnee = $req->fetchAll();
    $nb_ligne = count($donnee);
    for($i = 0; $i < $nb_ligne; $i++)
       {
           echo '<tr>';
           for($j = 0; $j <= 7; $j++)
           {
              echo '<td>'.$donnee[$i][$j].'</td>';
           }
            echo '</tr>';
       }
    $req->closeCursor();
    echo '</tbody>';
    echo '</table>';
?>    
</body>
</html>

