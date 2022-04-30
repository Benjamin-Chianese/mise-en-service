<?php
require('SQL.php');

if(!empty($_POST['mes'])){
    if($_POST['page_OK'] == '0'){
    $export = $bdd->query("SELECT * from `network_fon` INNER JOIN network_account  
   WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
ORDER BY network_fon.prio ASC,network_fon.id DESC");

    
        }else{
        $export = $bdd->query("SELECT * from `network_fon` INNER JOIN network_account  
        WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
AND network_fon.natira_presta_fo LIKE '".$_POST['page_OK']."'
ORDER BY network_fon.prio ASC,network_fon.id DESC ");

 
    }
	
}else{

    
}


    $export->execute();
	$data = $export -> fetchAll(PDO::FETCH_ASSOC);

	
	
	$datas = array();
	
	foreach ($data as $d){
	    
	    if(!empty($d['natira_kmz']) && $d['natira_kmz'] != '0000-00-00'){
	        $kmz = date('d/m/Y',strtotime($d['natira_kmz']));
	    }else{ $kmz ='N/A';}
	    if(!empty($d['date_natira']) && $d['date_natira'] != '0000-00-00'){
	        $ro = date('d/m/Y',strtotime($d['date_natira']));
	    }else{ $ro ='N/A';}
	     if(!empty($d['natira_vt']) && $d['natira_vt'] != '0000-00-00'){
	        $vt = date('d/m/Y',strtotime($d['natira_vt']));
	    }else{ $vt ='N/A';}
	     if(!empty($d['natira_doe']) && $d['natira_doe'] != '0000-00-00'){
	        $doe = date('d/m/Y',strtotime($d['natira_doe']));
	    }else{ $doe ='N/A';}
	    if(!empty($d['natira_limite_mes']) && $d['natira_limite_mes'] != '0000-00-00'){
	        $limite_mes = date('d/m/Y',strtotime($d['natira_limite_mes']));
	    }else{ $limite_mes ='N/A';}
	    
	    $commentaire = utf8_encode($d['suivi_natira_commentaire']);
		
		$datas[] = array(
			'Client'=>$d['name'],
			'FSLNK'=>$d['service_ref'],
			'Prio'=>$d['prio'],
			'Presta GC'=>$d['natira_presta_gc'],
			'Presta FO'=>$d['natira_presta_fo'],
			'Lancement client'=>$kmz,
			'Route Optique'=>$ro,
			'VT'=>$vt,
			'GC'=>$d['natira_gc'],
			'Aiguillage'=>$d['natira_aiguillage'],
			'Tirage'=>$d['natira_tirage'],
			'Racco / Desserte'=>$d['natira_racco'],
			'DOE'=>$doe,
			'Limite MES'=>$limite_mes,
			'Commentaire'=>$commentaire
		);
	}


#var_dump($datas);
require 'class.csv.php';
		 if($_POST['page_OK'] == '0'){
		CSV::export($datas,'Export-Général');
		 }else{
		CSV::export($datas,'Export-Fon-'.$_POST['page_OK']);   
		 }
?>