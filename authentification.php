<?php
if(!isset($_SERVER['HTTP_REFERER'])) {
    header("location:index.php");
}
session_start();
$login= $_POST['login'];            //login
$password= $_POST['password'];      //mot de passe
$salt1 = "-*o?#";                   // 1er salage 
$salt2 = "l@^&5s";                  // 2eme salage 
//fonction de hachage de type sha256 avec concaténation de deux chaînes de caractère du salage
$token = hash('sha256', "$salt1$password$salt2"); 
//selection le login et le mot de passe haché en utilisant la fonction prépare
require_once 'conx_base.php';
$req = $bdd->prepare('SELECT login, password FROM admin WHERE login = :login AND password = :pass'); 
$req->bindValue(':login', $login, PDO::PARAM_STR);
$req->bindValue(':pass', $token);
$req->execute();
if($donnees = $req->fetch())
    {
        $_SESSION['ADMIN'] = $donnees;
        header("location:index.php");
    }
 else {
     $_SESSION['FAKE_ADMIN'] = array($_POST['login'], $_POST['password']);
   header("location:index.php?erreur");  
    }  
 ?>