<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
try {
    $bdd = new PDO('mysql:host=localhost;dbname=id12957902_maintenance;charset=utf8', 'id12957902_morad', 'mamesou');
    // set the PDO error mode to exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $ex) {
    die('Erreur : ' . $ex->getMessage());
}

