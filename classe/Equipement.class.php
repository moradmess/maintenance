<?php

function is_int_positive ($var) {
        $var = (int) $var;
        if($var > 0)    return TRUE;
        else            return FALSE;
    }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Equipement
{
    protected   $_serie;
    protected 	$_etat;
    protected 	$_soft;
    protected 	$_dateInstalle;
    protected 	$_client;
    protected 	$_ville;
    protected 	$_contrat;
    protected   $_date_dernier_mp;
    protected   $_date_mp_prevue;
    protected   $_detail;
    protected   $_nom_intervenant;
    protected   $_code_client;
    protected   $_date_reforme; 
    protected	$_recuperation;
            
    public function __construct(array $donnees) 
        {
            $this->hydrate($donnees);
        }

    protected function hydrate(array $donnees) 
        {
            foreach ($donnees as $key => $value)
            {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
            $this->$method($value);
            }
            }
	}
    //setter   
    protected function setSerie($serie) 
    {
        //if(is_numeric($serie)){
            $this->_serie = $serie; 
    }
    protected function setEtat($etat) 
    {
            $this->_etat = $etat; 
    }
        
    protected function setSoft($soft) 
    {          
            $this->_soft = $soft; 
    }

    protected function setDateInstalle($dateInstalle) 
    {          
            $this->_dateInstalle = $dateInstalle; 
    }
    
    protected function setClient($client) 
    {          
            $this->_client = $client; 
    }
    
    protected function setVille($ville) 
    {          
        $this->_ville = $ville; 
    }
    
    protected function setContrat($contrat) 
    {          
        $this->_contrat = $contrat; 
    }

    protected function setDate_dernier_mp($date_dernier_mp) 
    {  
        $this->_date_dernier_mp = $date_dernier_mp; 
    }
    
    protected function setDate_mp_prevue($date_mp_prevue) 
    {          
            $this->_date_mp_prevue = $date_mp_prevue; 
    }

     protected function setDetail($detail) 
    {          
            $this->_detail = $detail; 
    }

     protected function setNom_intervenant($nom_intervenant) 
    {          
            $this->_nom_intervenant = $nom_intervenant; 
    }

      protected function setCode_client($code_client) 
    {
        if(is_numeric($code_client)){
            $this->_code_client = $code_client; 
            }
        else {
            $this->_code_client = 0; 
       } 
    }

     protected function setDate_reforme($date_reforme) 
    {          
            $this->_date_reforme = $date_reforme; 
    }

     protected function setRecuperation($recuperation) 
    {          
            $this->_recuperation = $recuperation; 
    }
    //getter
     public function serie() {
    return $this->_serie;    
    }
    
    public function etat() {
    return $this->_etat;    
    }
    
    public function soft() {
    return $this->_soft;    
    }
    
    public function dateInstalle() {
    return $this->_dateInstalle;    
    }
    
    public function client() {
    return $this->_client;    
    }
    
    public function ville() {
    return $this->_ville;    
    }
    
    public function contrat() {
    return $this->_contrat;    
    }
    
    public function date_dernier_mp() {
    return $this->_date_dernier_mp;    
    }
    
    public function date_mp_prevue() {
    return $this->_date_mp_prevue;    
    }

    public function detail() {
    return $this->_detail;    
    }
    public function nom_intervenant() {
    return $this->_nom_intervenant;    
    }

    public function code_client() {
    return $this->_code_client;    
    }

    public function date_reforme() {
    	return $this->_date_reforme;
    }

    public function recuperation() {
    return $this->_recuperation;
    }

    public function formulaire_label($label)
    {
        require 'conx_base.php';
        $q = ($label == "client") ? $bdd->query('SELECT DISTINCT nom_client FROM client ORDER BY nom_client') : $bdd->query('SELECT DISTINCT ville FROM client ORDER BY ville');
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;
    }
    public static function nom_client() {
        require 'conx_base.php';
        $q = $bdd->query('SELECT nom_client, ville FROM client ORDER BY nom_client');
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;
    }

    public static function Active_inactive($equipement, $etat)
    {
        require 'conx_base.php';
        switch ($equipement) {
            case 'Access2':
                $req = 'SELECT COUNT(status) AS etat FROM dm_access2 WHERE status = :etat';
                break;
            case 'AU':
                $req = 'SELECT COUNT(status) AS etat FROM dm_au WHERE status = :etat';
                break;
        }
        $q = $bdd->prepare($req);
        $q->bindValue(':etat', $etat, PDO::PARAM_STR);
        $q->execute();
        $donnee = $q->fetch();
        $q->closeCursor();
        return $donnee['etat'];
    }

}

class AU extends Equipement
{
    const REQ_DM = 'SELECT dm.ise,dm.serial_number,dm.status,dm.version_soft,dm.date_installe,c.nom_client,c.ville,dm.contrat,dm.iddmau, dm.code_client FROM dm_au dm INNER JOIN client c ON dm.code_client=c.idc';
    const REQ_MP = 'SELECT dm.ise, dm.serial_number, dm.version_soft, dm.date_installe, c.nom_client, c.ville, dm.contrat, mp.date_dernier_mp, mp.date_mp_prevue, mp.idmpau, dm.code_client FROM mp_au mp INNER JOIN dm_au dm ON mp.code_dm_au=dm.iddmau INNER JOIN client c ON dm.code_client=c.idc';
    const REQ_HISTO = 'SELECT dm.ise, dm.serial_number, dm.version_soft, dm.date_installe, c.nom_client, c.ville, dm.contrat, dm.date_interv, dm.nom_intervenant, dm.detail FROM histo_au dm INNER JOIN client c ON dm.code_client = c.idc';
    const REQ_COUNTLIGNES = 'SELECT COUNT(iddmau) AS nb_ligne FROM dm_au';
    const REQ_COUNTLIGNES_MP = 'SELECT COUNT(idmpau) AS nb_ligne FROM mp_au';
    const REQ_COUNTLIGNES_HISTO = 'SELECT COUNT(idhau) AS nb_ligne FROM histo_au';
    
    private $_idmpau;
    private $_iddmau;
    private $_ise;
    
    //setter
     protected function setIdmpau($idmpau) 
    {
         if(is_numeric($idmpau)){
            $this->_idmpau = $idmpau;  
            }
        else {
            $this->_idmpau = 0; 
       } 
    }

    protected function setIddmau($iddmau) 
    {  
        if(is_numeric($iddmau)){
            $this->_iddmau = $iddmau;
            }
        else {
            $this->_iddmau = 0; 
       } 
    }
    
    protected function setIse($ise)
    {  
        $this->_ise = $ise; 
    }
    
    //getter
    public function idmpau() {
    return $this->_idmpau;    
    }

    public function iddmau() {
    return $this->_iddmau;    
    }
    
    public function ise() {
    return $this->_ise;    
    }
    
    public static function afficher_NbLigne($info) {
        require 'conx_base.php';
        switch($info)
        {
            case "equipement":
            $q = $bdd->prepare(self::REQ_COUNTLIGNES);
            break;
            case "maintenance":
            $q = $bdd->prepare(self::REQ_COUNTLIGNES_MP);
            break;
            case "historique":
            $q = $bdd->prepare(self::REQ_COUNTLIGNES_HISTO);
            break;
        }
        $q->execute();
        $donnee = $q->fetch();
        $q->closeCursor();
        return $donnee['nb_ligne'];
    }
    
    public static function afficher_equip($limit, $offset, $info) {
        require 'conx_base.php';
        switch($info) {
            case "equipement":
            $req = self::REQ_DM.' LIMIT :limit OFFSET :offset';
            break;
            case "maintenance":
            $req = self::REQ_MP.' ORDER BY mp.date_mp_prevue ASC LIMIT :limit OFFSET :offset';
            break;
            case "historique":
            $req = self::REQ_HISTO.' LIMIT :limit OFFSET :offset';
            break;
        }
        $q = $bdd->prepare($req);
        $q->bindValue(':limit', $limit, PDO::PARAM_INT);
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;   
    }

    public static function afficher_equip_trier($limit, $offset, $trier, $info) {
        require 'conx_base.php';
        switch($info) {
            case "equipement":
            $req = ($trier == "Client") ? self::REQ_DM.' ORDER BY c.nom_client LIMIT :limit OFFSET :offset' : self::REQ_DM.' ORDER BY dm.date_installe DESC LIMIT :limit OFFSET :offset';
            break;
            case "historique":
            $req = ($trier == "Client") ? self::REQ_HISTO.' ORDER BY c.nom_client LIMIT :limit OFFSET :offset' : self::REQ_HISTO.' ORDER BY dm.date_installe DESC LIMIT :limit OFFSET :offset';
            break;
        }
        $q = $bdd->prepare($req);
        $q->bindValue(':limit', $limit, PDO::PARAM_INT);
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee; 
    }
    
    public function chercher($info, $mode) {
        require 'conx_base.php';
        switch($info) {
            case 'equipement':
                switch($mode) {
                case 'client':
                $req = self::REQ_DM." WHERE c.nom_client LIKE '".addslashes($this->_client)."%' ORDER BY c.nom_client";
                break;
                case 'ville':
                $req = self::REQ_DM." WHERE c.ville LIKE '".addslashes($this->_ville)."%' ORDER BY c.nom_client";
                break;
                case 'serie':
                $req = self::REQ_DM." WHERE dm.serial_number LIKE '".$this->_serie."%' ORDER BY c.nom_client";
                break;
                case 'contrat':
                $req = self::REQ_DM." WHERE dm.contrat LIKE '".addslashes($this->_contrat)."%' ORDER BY c.nom_client";
                break; 
                }
            break;
            case 'maintenance':
                switch($mode) {
                case 'client':
                $req = self::REQ_MP." WHERE c.nom_client LIKE '".addslashes($this->_client)."%' ORDER BY c.nom_client";
                break;
                case 'ville':
                $req = self::REQ_MP." WHERE c.ville LIKE '".addslashes($this->_ville)."%' ORDER BY c.nom_client";
                break;
                case 'serie':
                $req = self::REQ_MP." WHERE dm.serial_number LIKE '".$this->_serie."%' ORDER BY c.nom_client";
                break;
                case 'contrat':
                $req = self::REQ_MP." WHERE dm.contrat LIKE '".addslashes($this->_contrat)."%' ORDER BY c.nom_client";
                break; 
                }
            break;
            case 'historique':
                switch($mode) {
                case 'client':
                $req = self::REQ_HISTO." WHERE c.nom_client LIKE '".addslashes($this->_client)."%' ORDER BY c.nom_client";
                break;
                case 'ville':
                $req = self::REQ_HISTO." WHERE c.ville LIKE '".addslashes($this->_ville)."%' ORDER BY c.nom_client";
                break;
                case 'serie':
                $req = self::REQ_HISTO." WHERE dm.serial_number LIKE '".$this->_serie."%' ORDER BY c.nom_client";
                break;
                case 'contrat':
                $req = self::REQ_HISTO." WHERE dm.contrat LIKE '".addslashes($this->_contrat)."%' ORDER BY c.nom_client";
                break; 
                }
            break;
        }
        $q = $bdd->query($req);
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;
    }
    
    public function chercher_code($mode) {
        require 'conx_base.php';
        if($mode == "dm_au") {
            $q =  self::REQ_DM." WHERE dm.iddmau = :id";
            $req = $bdd->prepare($q);
            $req->bindValue(':id', $this->_iddmau, PDO::PARAM_INT);
        } else {
            $q = self::REQ_MP." WHERE mp.idmpau = :id";
            $req = $bdd->prepare($q);
            $req->bindValue(':id', $this->_idmpau, PDO::PARAM_INT);
        }
        $req->execute(); 
        $donnee = $req->fetch();
        $req->closeCursor(); 
        return $donnee;
    }
    
    public function enregistrer_au() {
        require 'conx_base.php';
           	$tz = new DateTimeZone('Africa/Casablanca');
       		$date = new DateTime($this->_dateInstalle, $tz);
       		$date->add(new DateInterval('P6M'));
       		$date_mp_pre = $date->format('Y-m-d');
        //vérifier si le client saisie se trouve
        $q = $bdd->prepare('SELECT idc FROM client WHERE nom_client = :nom AND ville = :ville');
        $q->bindValue(':nom', $this->_client, PDO::PARAM_STR);
        $q->bindValue(':ville', $this->_ville, PDO::PARAM_STR);
        $q->execute();
        $donnee = $q->fetch();
        $id = (int) $donnee['idc'];
        $q->closeCursor(); 
        
       if($id != 0)
           {
            $req = $bdd->prepare('INSERT INTO dm_au(ise, serial_number, status, version_soft, date_installe, code_client, contrat) VALUES(:ise, :serie, :status, :soft, :date_installe, :code_client, :contrat)');                
                $req->bindValue(':ise', $this->_ise, PDO::PARAM_STR);
                $req->bindValue(':serie', $this->_serie, PDO::PARAM_INT);
                $req->bindValue(':status', 'Active', PDO::PARAM_STR);
                $req->bindValue(':soft', $this->_soft, PDO::PARAM_STR);
                $req->bindValue(':date_installe', $this->_dateInstalle);
                $req->bindValue(':code_client', $id, PDO::PARAM_INT);
                $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
                $req->execute();
                $req->closeCursor();
        }
        else
        {
            $req = $bdd->prepare('INSERT INTO client(nom_client, ville) VALUES(:client, :ville)');
            $req->bindValue(':client', $this->_client, PDO::PARAM_STR);
            $req->bindValue(':ville', $this->_ville, PDO::PARAM_STR);
            $req->execute();
            $req->closeCursor();
            //Selectionner le dernier id dans la table client
            $req_idc = $bdd->query('SELECT MAX(idc) AS max_id FROM client');
            $donnee_idc = $req_idc->fetch();
            //enregistrer le nouvel equipement
            $req_in = $bdd->prepare('INSERT INTO dm_au(ise, serial_number, status, version_soft, date_installe, code_client, contrat) VALUES(:ise, :serie, :status, :soft, :date_installe, :code_client, :contrat)'); $req_in->bindValue(':ise', $this->_ise, PDO::PARAM_STR);
                $req_in->bindValue(':serie', $this->_serie, PDO::PARAM_INT);
                $req_in->bindValue(':status', 'Active', PDO::PARAM_STR);
                $req_in->bindValue(':soft', $this->_soft, PDO::PARAM_STR);
                $req_in->bindValue(':date_installe', $this->_dateInstalle);
                $req_in->bindValue(':code_client', $donnee_idc['max_id'], PDO::PARAM_INT);
                $req_in->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
                $req_in->execute();
                $req_in->closeCursor();
                $req_idc->closeCursor();
        }
        //Selectionner le dernier id dans la table dm_au
        $req_id = $bdd->query('SELECT MAX(iddmau) AS max_id FROM dm_au');
        $donnee_id = $req_id->fetch(); 
        //enregistrer la MP
        $rq = $bdd->prepare('INSERT INTO mp_au(code_dm_au, date_dernier_mp, date_mp_prevue) VALUES(:code, :date_fonc, :date_mp_prevue)');  
   	    $rq->bindValue(':code', $donnee_id['max_id'], PDO::PARAM_INT);  
        $rq->bindValue(':date_fonc', $this->_dateInstalle);
        $rq->bindValue(':date_mp_prevue', $date_mp_pre);
        $rq->execute();
        $rq->closeCursor();
        $req_id->closeCursor();
        unset($tz);
        unset($date);
        $bdd = null;
         echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont enregistrées avec succés</p>
              </div>';
    }  
    
    public function modifier_au_dm() {
    require 'conx_base.php';
        if ($this->_etat == "Inactive") {
        	if($this->_recuperation == 'Non')
        	{
        	   //suppression du planning MP
       			$q =$bdd->prepare('DELETE FROM mp_au WHERE code_dm_au = :id');		
        		$q->bindParam(':id', $this->_iddmau);
        		$q->execute();
        		$q->closeCursor();
        		//modifier les donnees
        		$req = $bdd->prepare('UPDATE dm_au SET ise = :ise, status = :status, version_soft = :version_soft, contrat = :contrat WHERE iddmau = :id');  
                $req->bindValue(':ise', $this->_ise, PDO::PARAM_STR);                                  
                $req->bindValue(':status', $this->_etat, PDO::PARAM_STR);
                $req->bindValue(':version_soft', $this->_soft, PDO::PARAM_STR);
                $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
                $req->bindValue(':id', $this->_iddmau, PDO::PARAM_INT);
                $req->execute();
                $req->closeCursor();
        	    echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont modifiées avec succés</p>
              </div>';
        	}
        	if($this->_recuperation == 'Oui')
        	{
        		$req = $bdd->prepare('INSERT INTO dm_reforme(appareil, serial_number, version_soft,date_installe, code_client, date_reforme) VALUES(:appareil, :serie, :version_soft, :date_installe, :code_client, :date_reforme)');                                    
            	$req->bindValue(':appareil', "AU", PDO::PARAM_STR);
            	$req->bindValue(':serie', $this->_serie, PDO::PARAM_INT);
            	$req->bindValue(':version_soft', $this->_soft, PDO::PARAM_STR);
            	$req->bindValue(':date_installe', $this->_dateInstalle);
            	$req->bindValue(':code_client', $this->_code_client, PDO::PARAM_INT);
            	$req->bindValue(':date_reforme', $this->_date_reforme);
            	$req->execute();
            	$req->closeCursor();
            	//suppression du planning de la MP
            	$q =$bdd->prepare('DELETE FROM mp_au WHERE code_dm_au = :id');		
        		$q->bindValue(':id', $this->_iddmau, PDO::PARAM_INT);
        		$q->execute();
        		$q->closeCursor();
            	//suppression du park des DM
            	$q1 =$bdd->prepare('DELETE FROM dm_au WHERE iddmau = :id');		
        		$q1->bindValue(':id', $this->_iddmau, PDO::PARAM_INT);
        		$q1->execute();
        		$q1->closeCursor(); 
        	 	echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont enregistrer dans la section atelier avec succés</p>
              </div>';
        	}
        }
        if($this->_etat == "Active")
        {
        //selectionner le planning de MP
        $rq = $bdd->prepare('SELECT * FROM mp_au WHERE code_dm_au = :code');
        $rq->bindValue(':code', $this->_iddmau, PDO::PARAM_INT);
       	$rq->execute();
       	$donnee = $rq->fetch();
       	$rq->closeCursor();
       	//si le planning de MP d'un équipement choisi ne pas enregister
        	if ($donnee == NULL) {
    	    $tz = new DateTimeZone('Africa/Casablanca');
       		$date = new DateTime('now', $tz);
       		$date_aujourdhui = $date->format('Y-m-d');
       		$date->add(new DateInterval('P6M'));
       		$date_mp_pre = $date->format('Y-m-d');		
       		$req = $bdd->prepare('INSERT INTO mp_au(code_dm_au, date_dernier_mp, date_mp_prevue) VALUES(:code, :date_fonc, :date_mp_prevue)');  
   	        $req->bindValue(':code', $this->_iddmau, PDO::PARAM_INT);  
        	$req->bindValue(':date_fonc', $date_aujourdhui);
        	$req->bindValue(':date_mp_prevue', $date_mp_pre);
        	$req->execute();
        	$req->closeCursor();
            unset($tz);
            unset($date);
        	}
        //modification des information
        $req = $bdd->prepare('UPDATE dm_au SET ise = :ise, status = :status, version_soft = :version_soft, contrat = :contrat WHERE iddmau = :id');  
        $req->bindValue(':ise', $this->_ise, PDO::PARAM_STR);                                  
        $req->bindValue(':status', $this->_etat, PDO::PARAM_STR);
        $req->bindValue(':version_soft', $this->_soft, PDO::PARAM_STR);
        $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
        $req->bindValue(':id', $this->_iddmau, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
        echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont modifiées avec succés</p>
              </div>';
        }
        $bdd = null;
    }
             

    public function modifier_au_mp($info) {
        require 'conx_base.php';
        //modifier les dates de MP
        $q = $bdd->prepare('UPDATE mp_au SET date_dernier_mp = :date_dernier_mp, date_mp_prevue = :date_mp_prevue WHERE idmpau = :id');  
        $q->bindValue(':date_dernier_mp', $this->_date_dernier_mp);                                  
        $q->bindValue(':date_mp_prevue', $this->_date_mp_prevue);
        $q->bindValue(':id', $this->_idmpau, PDO::PARAM_INT);
        $q->execute();
        $q->closeCursor();
  
        if($info == 'enreg')
        {
        $req = $bdd->prepare('INSERT INTO histo_au(ise, serial_number, version_soft, date_installe, code_client, contrat, date_interv, nom_intervenant, detail) VALUES(:ise, :serial_number, :version_soft, :date_installe, :code_client, :contrat, :date_interv, :nom_intervenant, :detail)');  
        $req->bindValue(':ise', $this->_ise, PDO::PARAM_STR);                                
        $req->bindValue(':serial_number', $this->_serie, PDO::PARAM_INT);
        $req->bindValue(':version_soft', $this->_soft, PDO::PARAM_STR);
        $req->bindValue(':date_installe', $this->_dateInstalle);
        $req->bindValue(':code_client', $this->_code_client, PDO::PARAM_INT);
        $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
        $req->bindValue(':date_interv', $this->_date_dernier_mp);
        $req->bindValue(':nom_intervenant', $this->_nom_intervenant, PDO::PARAM_STR);
        $req->bindValue(':detail', $this->_detail, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        }
            $bdd = null;
              echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont modifiées avec succés</p>
              </div>';
    }
    
    public function supprimer_au_mp() {
            require 'conx_base.php';
            $req_supp = $bdd->prepare('DELETE FROM mp_au WHERE idmpau = :id');                                    
            $req_supp->bindValue(':id', $this->_idmpau, PDO::PARAM_INT);
            $req_supp->execute();
            $req_supp->closeCursor();
            $bdd = null;
              echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont supprimées avec succés</p>
              </div>';
    }
        
}


class Access extends Equipement
{
    const REQ_DM = 'SELECT dm.serial_number,dm.status,dm.version_soft,dm.apf,dm.date_installe,c.nom_client,c.ville,dm.contrat,dm.iddma, dm.code_client FROM dm_access2 dm INNER JOIN client c ON dm.code_client=c.idc';
    const REQ_MP = 'SELECT dm.serial_number,dm.version_soft,dm.apf,dm.date_installe,c.nom_client,c.ville,dm.contrat,mp.date_dernier_mp, mp.date_mp_prevue, mp.idmpa, dm.code_client FROM dm_access2 dm INNER JOIN mp_access2 mp ON mp.code_dm_a = dm.iddma INNER JOIN client c ON dm.code_client=c.idc';
    const REQ_HISTO = 'SELECT dm.serial_number,dm.version_soft,dm.apf,dm.date_installe,c.nom_client,c.ville,dm.contrat,dm.date_mp, dm.nom_intervenant, dm.detail FROM histo_access2 dm INNER JOIN client c ON dm.code_client=c.idc';
    const REQ_COUNTLIGNES = 'SELECT COUNT(iddma) AS nb_ligne FROM dm_access2';
    const REQ_COUNTLIGNES_MP = 'SELECT COUNT(idmpa) AS nb_ligne FROM mp_access2';
    const REQ_COUNTLIGNES_HISTO = 'SELECT COUNT(idha) AS nb_ligne FROM histo_access2';

    private $_iddma;
    private $_apf;
    private $_idmpa;
    //setter
    protected function setIddma($iddma) 
    {  
        if(is_numeric($iddma)){
             $this->_iddma = $iddma;
            }
        else {
            $this->_iddma = 0; 
       } 
    }

    protected function setApf($apf) 
    {          
            $this->_apf = $apf; 
    }

    protected function setIdmpa($idmpa) 
    {  
         if(is_numeric($idmpa)){
             $this->_idmpa = $idmpa;
            }
        else {
            $this->_idmpa = 0; 
       } 
    }
    //getter
    public function iddma() {
    return $this->_iddma;    
    }

    public function apf() {
    return $this->_apf;    
    }

    public function idmpa() {  
    return $this->_idmpa; 
    }
    
    public static function afficher_NbLigne($info) {
        require 'conx_base.php';
        switch($info)
        {
            case "equipement":
            $q = $bdd->prepare(self::REQ_COUNTLIGNES);
            break;
            case "maintenance":
            $q = $bdd->prepare(self::REQ_COUNTLIGNES_MP);
            break;
            case "historique":
            $q = $bdd->prepare(self::REQ_COUNTLIGNES_HISTO);
            break;
        }
        $q->execute();
        $donnee = $q->fetch();
        $q->closeCursor();
        return $donnee['nb_ligne'];
    }
    
    public static function afficher_equip($limit, $offset, $info) {
        require 'conx_base.php';
        switch($info) {
            case "equipement":
            $req = self::REQ_DM.' LIMIT :limit OFFSET :offset';
            break;
            case "maintenance":
            $req = self::REQ_MP.' ORDER BY mp.date_mp_prevue ASC LIMIT :limit OFFSET :offset';
            break;
            case "historique":
            $req = self::REQ_HISTO.' LIMIT :limit OFFSET :offset';
            break;
        }
        $q = $bdd->prepare($req);
        $q->bindValue(':limit', $limit, PDO::PARAM_INT);
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;   
    }

    public static function afficher_equip_trier($limit, $offset, $trier, $info) {
        require 'conx_base.php';
        switch($info) {
            case "equipement":
            $req = ($trier == "Client") ? self::REQ_DM.' ORDER BY c.nom_client LIMIT :limit OFFSET :offset' : self::REQ_DM.' ORDER BY dm.date_installe DESC LIMIT :limit OFFSET :offset';
            break;
            case "historique":
            $req = ($trier == "Client") ? self::REQ_HISTO.' ORDER BY c.nom_client LIMIT :limit OFFSET :offset' : self::REQ_HISTO.' ORDER BY dm.date_installe DESC LIMIT :limit OFFSET :offset';
            break;
        }
        $q = $bdd->prepare($req);
        $q->bindValue(':limit', $limit, PDO::PARAM_INT);
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee; 
    }
    
    public function chercher($info, $mode) {
        require 'conx_base.php';
        switch($info) {
            case 'equipement':
                switch($mode) {
                case 'client':
                $req = self::REQ_DM." WHERE c.nom_client LIKE '".addslashes($this->_client)."%' ORDER BY c.nom_client";
                break;
                case 'ville':
                $req = self::REQ_DM." WHERE c.ville LIKE '".addslashes($this->_ville)."%' ORDER BY c.nom_client";
                break;
                case 'serie':
                $req = self::REQ_DM." WHERE dm.serial_number LIKE '".$this->_serie."%' ORDER BY c.nom_client";
                break;
                case 'contrat':
                $req = self::REQ_DM." WHERE dm.contrat LIKE '".addslashes($this->_contrat)."%' ORDER BY c.nom_client";
                break; 
                }
            break;
            case 'maintenance':
                switch($mode) {
                case 'client':
                $req = self::REQ_MP." WHERE c.nom_client LIKE '".addslashes($this->_client)."%' ORDER BY c.nom_client";
                break;
                case 'ville':
                $req = self::REQ_MP." WHERE c.ville LIKE '".addslashes($this->_ville)."%' ORDER BY c.nom_client";
                break;
                case 'serie':
                $req = self::REQ_MP." WHERE dm.serial_number LIKE '".$this->_serie."%' ORDER BY c.nom_client";
                break;
                case 'contrat':
                $req = self::REQ_MP." WHERE dm.contrat LIKE '".addslashes($this->_contrat)."%' ORDER BY c.nom_client";
                break; 
                }
            break;
            case 'historique':
                switch($mode) {
                case 'client':
                $req = self::REQ_HISTO." WHERE c.nom_client LIKE '".addslashes($this->_client)."%' ORDER BY c.nom_client";
                break;
                case 'ville':
                $req = self::REQ_HISTO." WHERE c.ville LIKE '".addslashes($this->_ville)."%' ORDER BY c.nom_client";
                break;
                case 'serie':
                $req = self::REQ_HISTO." WHERE dm.serial_number LIKE '".$this->_serie."%' ORDER BY c.nom_client";
                break;
                case 'contrat':
                $req = self::REQ_HISTO." WHERE dm.contrat LIKE '".addslashes($this->_contrat)."%' ORDER BY c.nom_client";
                break; 
                }
            break;
        }
        $q = $bdd->query($req);
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;
    }
    
    public function chercher_code($mode) {
        require 'conx_base.php';
        if($mode == "dm_a") {
        $q = self::REQ_DM." WHERE dm.iddma = :id";
        $req = $bdd->prepare($q);
        $req->bindValue(':id', $this->_iddma, PDO::PARAM_INT);
        } else {
        $q = self::REQ_MP." WHERE mp.idmpa = :id";
        $req = $bdd->prepare($q);
        $req->bindValue(':id', $this->_idmpa, PDO::PARAM_INT);
        }
        $req->execute(); 
        $donnee = $req->fetch();
        $req->closeCursor(); 
        return $donnee;
    }
    
 public function enregistrer_access() {
        require 'conx_base.php';
        	$tz = new DateTimeZone('Africa/Casablanca');
       		$date = new DateTime($this->_dateInstalle, $tz);
       		$date->add(new DateInterval('P6M'));
       		$date_mp_pre = $date->format('Y-m-d');
        //vérifier si le client saisie se trouve
        $q = $bdd->prepare('SELECT idc FROM client WHERE nom_client = :nom AND ville = :ville');
        $q->bindValue(':nom', $this->_client, PDO::PARAM_STR);
        $q->bindValue(':ville', $this->_ville, PDO::PARAM_STR);
        $q->execute();
        $donnee = $q->fetch();
        $id = (int) $donnee['idc'];
        $q->closeCursor(); 
        
       if($id != 0)
           {
            $req = $bdd->prepare('INSERT INTO dm_access2(serial_number, status, version_soft, apf, date_installe, code_client, contrat) VALUES(:serie, :status, :soft, :apf, :date_installe, :code_client, :contrat)');
                $req->bindValue(':serie', $this->_serie, PDO::PARAM_INT);
                $req->bindValue(':status', 'Active', PDO::PARAM_STR);
                $req->bindValue(':soft', $this->_soft, PDO::PARAM_STR);
                $req->bindValue(':apf', $this->_apf, PDO::PARAM_STR);
                $req->bindValue(':date_installe', $this->_dateInstalle);
                $req->bindValue(':code_client', $id, PDO::PARAM_INT);
                $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
                $req->execute();
                $req->closeCursor(); 
        }
        else
        {
            $reqq = $bdd->prepare('INSERT INTO client(nom_client, ville) VALUES(:client, :ville)');
            $reqq->bindValue(':client', $this->_client, PDO::PARAM_STR);
            $reqq->bindValue(':ville', $this->_ville, PDO::PARAM_STR);
            $reqq->execute();
            $reqq->closeCursor();
            //Selectionner le dernier id dans la table client
            $req_id = $bdd->query('SELECT MAX(idc) AS max_id FROM client');
            $donnee_id = $req_id->fetch();
            //enregistrer le nouvel equipement
            $req = $bdd->prepare('INSERT INTO dm_access2(serial_number, status, version_soft, apf, date_installe, code_client, contrat) VALUES(:serie, :status, :soft, :apf, :date_installe, :code_client, :contrat)');
                $req->bindValue(':serie', $this->_serie, PDO::PARAM_INT);
                $req->bindValue(':status', 'Active', PDO::PARAM_STR);
                $req->bindValue(':soft', $this->_soft, PDO::PARAM_STR);
                $req->bindValue(':apf', $this->_apf, PDO::PARAM_STR);
                $req->bindValue(':date_installe', $this->_dateInstalle);
                $req->bindValue(':code_client', $donnee_id['max_id'], PDO::PARAM_INT);
                $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
                $req->execute();
                $req->closeCursor(); 
                $req_id->closeCursor(); 
        }
         //Selectionner le dernier id dans la table dm_access2
            $req_id = $bdd->query('SELECT MAX(iddma) AS max_id FROM dm_access2');
            $donnee_id = $req_id->fetch();
				//enregistrer les donnees MP
			$rq = $bdd->prepare('INSERT INTO mp_access2(code_dm_a, date_dernier_mp, date_mp_prevue) VALUES(:code, :date_fonc, :date_mp_prevue)');  
   	        $rq->bindValue(':code', $donnee_id['max_id'], PDO::PARAM_INT);  
        	$rq->bindValue(':date_fonc', $this->_dateInstalle);
        	$rq->bindValue(':date_mp_prevue', $date_mp_pre);
        	$rq->execute();
        	$rq->closeCursor();
        	$req_id->closeCursor();     
            unset($tz);
            unset($date);
            $bdd = null;
         echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont enregistrées avec succés</p>
              </div>';
    }  
    
    public function modifier_access_dm() {
        require 'conx_base.php';
        if($this->_etat == "Active")
        {
        $rq = $bdd->prepare('SELECT * FROM mp_access2 WHERE code_dm_a = :code');
        $rq->bindValue(':code', $this->_iddma, PDO::PARAM_INT);
       	$rq->execute();
       	$donnee = $rq->fetch();
       	$rq->closeCursor();
       	//si le planning de MP d'un équipement choisi ne pas enregister
        	if ($donnee == NULL) {
    	    $tz = new DateTimeZone('Africa/Casablanca');
       		$date = new DateTime('now', $tz);
       		$date_aujourdhui = $date->format('Y-m-d');
       		$date->add(new DateInterval('P6M'));
       		$date_mp_pre = $date->format('Y-m-d');		
       		$req = $bdd->prepare('INSERT INTO mp_access2(code_dm_a, date_dernier_mp, date_mp_prevue) VALUES(:code, :date_fonc, :date_mp_prevue)');  
   	        $req->bindValue(':code', $this->_iddma, PDO::PARAM_INT);  
        	$req->bindValue(':date_fonc', $date_aujourdhui);
        	$req->bindValue(':date_mp_prevue', $date_mp_pre);
        	$req->execute();
        	$req->closeCursor();
        	unset($tz);
            unset($date);
        	}

        $req = $bdd->prepare('UPDATE dm_access2 SET status = :status, version_soft= :soft, apf = :apf, contrat = :contrat WHERE iddma = :id');                                    
        $req->bindValue(':status', $this->_etat, PDO::PARAM_STR);
        $req->bindValue(':soft', $this->_soft, PDO::PARAM_STR);
        $req->bindValue(':apf', $this->_apf, PDO::PARAM_STR);
        $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
        $req->bindValue(':id', $this->_iddma, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
        echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont modifiées avec succés</p>
              </div>';
        }
      if ($this->_etat == "Inactive") {
        	if($this->_recuperation == 'Non')
        	{
        		//modifier les donnees
        $req = $bdd->prepare('UPDATE dm_access2 SET status = :status, version_soft= :soft, apf = :apf, contrat = :contrat WHERE iddma = :id');                                    
        $req->bindValue(':status', $this->_etat, PDO::PARAM_STR);
        $req->bindValue(':soft', $this->_soft, PDO::PARAM_STR);
        $req->bindValue(':apf', $this->_apf, PDO::PARAM_STR);
        $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
        $req->bindValue(':id', $this->_iddma, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
        		//suppression du planning MP
       			$q =$bdd->prepare('DELETE FROM mp_access2 WHERE code_dm_a = :id');		
        		$q->bindValue(':id', $this->_iddma, PDO::PARAM_INT);
        		$q->execute();
        		$q->closeCursor();
        	    echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont modifiées avec succés</p>
              </div>';
        	}
        	if($this->_recuperation == 'Oui')
        	{
        		$req = $bdd->prepare('INSERT INTO dm_reforme(appareil, serial_number, version_soft,date_installe, code_client, date_reforme) VALUES(:appareil, :serie, :version_soft, :date_installe, :code_client, :date_reforme)');                                    
            	$req->bindValue(':appareil', "Access2", PDO::PARAM_STR);
            	$req->bindValue(':serie', $this->_serie, PDO::PARAM_INT);
            	$req->bindValue(':version_soft', $this->_soft, PDO::PARAM_STR);
            	$req->bindValue(':date_installe', $this->_dateInstalle);
            	$req->bindValue(':code_client', $this->_code_client, PDO::PARAM_INT);
            	$req->bindValue(':date_reforme', $this->_date_reforme);
            	$req->execute();
            	$req->closeCursor();
            	//suppression du planning de la MP
            	$q =$bdd->prepare('DELETE FROM mp_access2 WHERE code_dm_a = :id');		
        		$q->bindValue(':id', $this->_iddma, PDO::PARAM_INT);
        		$q->execute();
        		$q->closeCursor();
            	//suppression du park des DM
            	$q1 =$bdd->prepare('DELETE FROM dm_access2 WHERE iddma = :id');		
        		$q1->bindValue(':id', $this->_iddma, PDO::PARAM_INT);
        		$q1->execute();
        		$q1->closeCursor(); 
        	 	echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont enregistrer dans la section atelier avec succés</p>
              </div>';
        	}
        }	
        $bdd = null;
    }

    public function modifier_access_mp($info) {
        require 'conx_base.php';
        //modifier les dates de la MP
       $q = $bdd->prepare('UPDATE mp_access2 SET date_dernier_mp = :date_dernier_mp, date_mp_prevue = :date_mp_prevue WHERE idmpa = :id');  
        $q->bindValue(':date_dernier_mp', $this->_date_dernier_mp);                                  
        $q->bindValue(':date_mp_prevue', $this->_date_mp_prevue);
        $q->bindValue(':id', $this->_idmpa, PDO::PARAM_INT);
        $q->execute();
        $q->closeCursor();
         if($info == 'enreg')
        {
        $req = $bdd->prepare('INSERT INTO histo_access2(serial_number, version_soft, apf, date_installe, code_client, contrat, date_mp, nom_intervenant, detail) VALUES (:serial_number, :version_soft, :apf, :date_installe, :code_client, :contrat, :date_interv, :nom_intervenant, :detail)');  
        $req->bindValue(':serial_number', $this->_serie, PDO::PARAM_INT);
        $req->bindValue(':version_soft', $this->_soft, PDO::PARAM_STR);
        $req->bindValue(':apf', $this->_apf, PDO::PARAM_STR); 
        $req->bindValue(':date_installe', $this->_dateInstalle);
        $req->bindValue(':code_client', $this->_code_client, PDO::PARAM_INT);
        $req->bindValue(':contrat', $this->_contrat, PDO::PARAM_STR);
        $req->bindValue(':date_interv', $this->_date_dernier_mp);
        $req->bindValue(':nom_intervenant', $this->_nom_intervenant, PDO::PARAM_STR);
        $req->bindValue(':detail', $this->_detail, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        }
            $bdd = null;
              echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont modifiées avec succés</p>
              </div>';
    }
    
     public function supprimer_access_mp() {
            require 'conx_base.php';
            $req_supp = $bdd->prepare('DELETE FROM mp_access2 WHERE idmpa = :id');
            $req_supp->bindValue(':id', $this->_idmpa, PDO::PARAM_INT);
            $req_supp->execute();
            $req_supp->closeCursor();
            $bdd = null;
              echo '<div class="alert alert-info alert-dismissable">                       
              <button type="button" class="close" datadismiss="alert">x</button>
              <p id="info">Les informations sont supprimées avec succés</p>
              </div>';
    }
}


class Equipement_Reforme extends Equipement
{
    const REQUETE_REFORME = 'SELECT r.Appareil, r.serial_number, r.version_soft, r.date_installe, c.nom_client, c.ville, r.date_reforme FROM dm_reforme r INNER JOIN client c ON r.code_client=c.idc';
    const REQ_COUNTLIGNES = 'SELECT COUNT(idr) AS nb_ligne FROM dm_reforme';
    private $_idr;
    private $_appareil;
    //setter
    protected function setIdr($idr) 
    {  
        if(is_numeric($idr)) {
              $this->_idr = $idr;
            }
        else {
            $this->_idr = 0; 
       } 
    }

    protected function setAppareil($Appareil) 
    {  
        $this->_appareil = $Appareil; 
    }
    //getter
    public function idr() {
    return $this->_idr;    
    }

    public function appareil() {
    return $this->_appareil;    
    }
    
    public static function afficher_NbLigne() {
        require 'conx_base.php';
        $q = $bdd->prepare(self::REQ_COUNTLIGNES);   
        $q->execute();
        $donnee = $q->fetch();
        $q->closeCursor();
        return $donnee['nb_ligne'];   
    }
    
    public static function afficher_equip($limit, $offset) {
        require 'conx_base.php';
        $req = self::REQUETE_REFORME.' ORDER BY date_reforme LIMIT :limit OFFSET :offset';
        $q = $bdd->prepare($req);
        $q->bindValue(':limit', $limit, PDO::PARAM_INT);
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;   
    }
    
    public static function afficher_equip_trier($limit, $offset, $trier) {
        require 'conx_base.php';
        $req = ($trier == "Client") ? self::REQUETE_REFORME.' ORDER BY c.nom_client LIMIT :limit OFFSET :offset' : self::REQUETE_REFORME.' ORDER BY r.date_installe DESC LIMIT :limit OFFSET :offset';
        $q = $bdd->prepare($req);
        $q->bindValue(':limit', $limit, PDO::PARAM_INT);
        $q->bindValue(':offset', $offset, PDO::PARAM_INT);
        $q->execute();
        $donnee = $q->fetchAll();
        $q->closeCursor();
        return $donnee;   
    }
    
    public function chercher($mode) {
        require 'conx_base.php';
        switch ($mode) {
            case 'client':
            $req = self::REQUETE_REFORME." WHERE c.nom_client LIKE '".addslashes($this->_client)."%' ORDER BY c.nom_client";
                break;
            case 'ville':
            $req = self::REQUETE_REFORME." WHERE c.ville LIKE '".addslashes($this->_ville)."%' ORDER BY c.nom_client";
                break;
            case 'serie':
            $req = self::REQUETE_REFORME." WHERE r.serial_number LIKE '".$this->_serie."%' ORDER BY c.nom_client";
                break;
            case 'appareil':
            $req = self::REQUETE_REFORME." WHERE r.Appareil LIKE '".addslashes($this->_appareil)."%' ORDER BY c.nom_client";
                break;
        }
        $q = $bdd->query($req);
        $donnee = $q->fetchAll();
        $q->closeCursor(); 
        return $donnee;
    }
    
}
