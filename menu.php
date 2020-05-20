<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
<div class="collapse navbar-collapse menu_plan">
<ul class="nav navbar-nav">
<li id="visite">
    <a href="index.php">Accueil</a>
</li>    
<li id="cadre_de_maintenance" class= "dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">MP<b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="mp_au.php">AU</a></li>
<li><a href="mp_access2.php">Access2</a></li>
</ul>
</li>
<li class= "dropdown" id="equipement">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">Equipement <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="dm_au.php">AU</a></li>
<li><a href="dm_access2.php">Access2</a></li>
</ul>
</li>
<li class= "dropdown" id="historique">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">Historique MP<b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="histo_au.php">AU</a></li>
<li><a href="histo_access2.php">Access2</a></li>
</ul>
</li>
<li id="reforme">
    <a href="dm_reforme.php">Atelier</a>
</li>
<li id="client">
    <a href="client.php">Client</a>
</li>
</ul> 
<?php
if(isset($_SESSION['ADMIN']))
{
    ?>
     <a href="log_out.php"><button type="button" class="btn btn-default navbar-btn navbar-right" style="font-weight: bold;"><span class="glyphicon glyphicon-log-out"></span> Log out</button></a>

<?php }
?>
</div>
           </nav> 
