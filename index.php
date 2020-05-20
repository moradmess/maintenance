<?php 
session_start();
if(!empty($_SESSION['DM_INFO']))
{
    $_SESSION['DM_INFO'] = null;
}
if(isset($_GET['erreur'])) {
    if(isset($_SERVER['HTTP_REFERER']))  $authentification = (int) $_GET['erreur'];
    else header("location: index.php");
}
else {
     $authentification = 1;
}
if($_SERVER['REQUEST_URI'] == "/index.php" || $_SERVER['REQUEST_URI'] == "/") {
    if(!empty($_SESSION['FAKE_ADMIN']))
    {
    $_SESSION['FAKE_ADMIN'] = array();
    } 
} 
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
        <title>Maintenance</title>
        <style>
            .separateur
            {
            background-color: rgb(233,233,233);
            height: 2px;
            margin-top: 10px;
            }
            
            .piedDePage
            {
               margin-top: 21px;
               background-color: rgb(217,237,247);
               padding: 10px;
               border-radius: 5px;
               border: 1px solid rgb(188,232,241);
               font-family: 'Palatino Linotype', sans-serif;
            }
            
            img {
            max-width: 100%;
            height: auto;
            width: auto\9; /* ie8 */
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <header>
             <div class="row menu">
                <?php require_once 'menu.php'; ?>
            </div>   
            </header>
 <?php 
 if(isset($_SESSION['ADMIN']))
 {
     ?>
                <section class="jumbotron">
                     <h3 style="text-align: center; font-family: Dayrom; font-weight: bold; color: blue;">Interface des équipements biomédicaux de notre Société Mabiotech</h3>
                     <p style="font-family: 'Palatino Linotype';">À travers cet interface qui assure la meilleure <code>organisation</code> et <code>manipulation</code>
                    des données, Vous pouvez actualiser facilement les données des équipements, 
                    suivez quotidiennement les maintenances préventives du parc des équipements dans les différents sites au Maroc</p>      
                 </section>
<?php }
    else {
 ?>
 
             <div class="row">
                 <section class="jumbotron col-md-9">
                     <h3 style="text-align: center; font-family: Dayrom; font-weight: bold; color: blue;">Interface des équipements biomédicaux de notre Société Mabiotech</h3>
                     <p style="font-family: 'Palatino Linotype';">À travers cet interface qui assure la meilleure <code>organisation</code> et <code>manipulation</code>
                    des données, Vous pouvez actualiser facilement les données des équipements, 
                    suivez quotidiennement les maintenances préventives du parc des équipements dans les différents sites au Maroc</p>      
                 </section>
                 
                 <div class="col-md-3">
                     <aside>
                     <div class="panel panel-info">
            <div class="panel-heading">
            <h3 class="panel-title">Espace Admin</h3>
            </div>
                   <div id="affiche" class="panel-body">
                          <div id="bb" class="alert alert-block alert-danger" style="display:none">
                Les informations saisies sont incorrectes
                </div>
                       <form method="POST" action="authentification.php">
                           <div class="form-group">
                               <label for="login">Login : </label>
                               <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <input id="login" name="login" type="text" class="form-control" value="<?php if(!empty($_SESSION['FAKE_ADMIN'])) { echo $_SESSION['FAKE_ADMIN'][0]; } ?>">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="password">Password : </label>
                             <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-lock"></span>
                            <input id="password" name="password" type="password" class="form-control" value="<?php if(!empty($_SESSION['FAKE_ADMIN'])) { echo $_SESSION['FAKE_ADMIN'][1]; } ?>">
                            </div>
                            </div>
                           <button id="bt_login" class="btn btn-primary pull-right" name="utilisateur"><span class="glyphicon glyphicon-log-in"></span> Log in</button>
                       </form>
                   </div>
                </div>     
                     </aside>
                 </div>
             </div>
<?php }
?>
             <section class="row">
       		 <center><img alt="société Mabiotech" class="img-rounded" src="images/mabiotech.jpg"/></center>
       		 <div class="separateur"></div>
            </section>
         
    <footer class="row piedDePage">
        <div class="col-md-5">Service Aprés Vente</div>
        <div class="col-md-4">Mabiotech</div>
        <div class="col-md-3"><span class="glyphicon glyphicon-home"></span> 24, Z.I Ain Attiq-Temara-Rabt</div>
    </footer>
            
</div>
        <script>
document.getElementById('visite').className = 'active';
var authen = <?php echo $authentification; ?>,
    bt_login = document.getElementById('bt_login'),
    div_auth = document.getElementById('affiche'),
    div_alert = document.getElementById('bb');
    
if(authen == 0) {
div_auth.className += ' has-error';
div_alert.removeAttribute("style");
}

        </script>
    </body> 
</html>