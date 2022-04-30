<?php
require ('../includes/head.php');


$day = date('d-m-Y');
   //var_dump($_POST);
if(!empty($_POST['annuler_id'])){
    
            $id = $_POST['annuler_id'];
            $comment = ' <br/>//Annuler le '.$day;
            $resil = date('Y-m-d');
            $annuler = 1;
			$up = $bdd->prepare("UPDATE `network_account` SET `comment`= CONCAT (comment,:comment), `resiliation`= :resil WHERE `id` = :id ");
		    $up->execute(array(
				"id" => $id,
				"resil" => $resil,
				"comment" => $comment
			));
			
			$up2 = $bdd->prepare("UPDATE `network_fon` SET `annuler`= :annuler WHERE `si_id` = :id ");
		    $up2->execute(array(
				"id" => $id,
				"annuler" => $annuler
			));
}


if(!empty($_POST['id'])){
  #  var_dump($_POST);
    
    
		$up = $bdd->prepare("UPDATE `network_fon` SET 
		`prio`= :prio,
		`natira_presta_gc`= :natira_presta_gc,
		`natira_presta_fo`= :natira_presta_fo,
		`natira_kmz`= :natira_kmz,
		`natira_vt`= :natira_vt,
		`natira_apd`= :natira_apd,
		`natira_voirie`= :natira_voirie,
		`natira_gc`= :natira_gc,
		`natira_aiguillage`= :natira_aiguillage,
		`natira_blo`= :natira_blo,
		`natira_tirage`= :natira_tirage,
		`natira_racco`= :natira_racco,
		`natira_doe`= :natira_doe,
		`suivi_natira_commentaire` = :commentaire,
		`natira_limite_mes` = :limite_mes
		WHERE `si_id` = :id");
			
	    $up->execute(array(
	        "prio" => $_POST['prio'],
	        "natira_presta_gc" => $_POST['presta_gc'],
	        "natira_presta_fo" => $_POST['presta_fo'],
	        "natira_kmz" => $_POST['kmz'],
	        "natira_vt" => $_POST['vt'],
	        "natira_apd" => $_POST['apd'],
	        "natira_voirie" => $_POST['voirie'],
	        "natira_gc" => $_POST['gc'],
	        "natira_aiguillage" => $_POST['aiguillage'],
	        "natira_blo" => $_POST['blo'],
	        "natira_tirage" => $_POST['tirage'],
	        "natira_racco" => $_POST['racco'],
	        "natira_doe" => $_POST['doe'],
	        "commentaire" => $_POST['commentaire'],
	        "limite_mes" => $_POST['limite_mes'],
	        "id" => $_POST['id']));
  
    
  
  if(!empty($_POST['mes'])){
      $semaine = date('W',strtotime($_POST['mes']));
	    $annee = date('Y',strtotime($_POST['mes']));
	    
		$up2 = $bdd->prepare("UPDATE `network_fon` SET `mes`= :mesu,`mes_prevu`= :mes_prevu,
			`ann_prevu`= :ann_prevu,`commentaire_natira`= CONCAT (commentaire_natira,:com_nat), `etat`= :etat WHERE `si_id` = :id_visu");
			
		$up2->execute(array(
			"id_visu" => $_POST['id'],
			"mesu" => $_POST['mes'],
			"mes_prevu" => $semaine,
			"ann_prevu" => $annee,
			"com_nat" => ' // MES OK le '.date('d/m/Y'),
			"etat" => 'OK'
		));
		
		
		$up1 = $bdd->prepare("UPDATE `network_account` SET  `fs_service_delivery`= :mesu WHERE `id` = :uid");
		$up1->execute(array(
			"uid" => $_POST['id'],
			"mesu" => $_POST['mes'],

		));
		

  }
  
}

$mes = $bdd->query("SELECT id FROM network_account 
    WHERE `fs_service_delivery` IS NULL
	AND  `resiliation` IS NULL 
    AND `service_type` NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
	ORDER BY id DESC");

while ($checks = $mes->fetch(PDO::FETCH_ASSOC))
{

$check_id = $checks['id'];


 $check_fon = $bdd->query("SELECT COUNT(si_id) AS check_count FROM network_fon WHERE si_id = '$check_id' ");
 
 $checks_count = $check_fon->fetch();

if ($checks_count['check_count'] < 1 ) {



     $requete = $bdd->prepare("INSERT INTO network_fon (si_id) 
        VALUES(:id)");
        $requete->execute(array(
            "id" => $check_id
        ));
 }

}


if(!empty($_POST['page_OK'])){

    if($_POST['page_OK'] == '0'){
$recuperation = $bdd->query("SELECT * from `network_fon` INNER JOIN network_account  
WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
ORDER BY network_fon.prio ASC,network_fon.id DESC ");

$count = $bdd->query("SELECT count(*) AS COUNT from `network_fon` INNER JOIN network_account  
WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
ORDER BY network_fon.prio ASC,network_fon.id DESC ");

echo'
<center><form method="post" action="suivi_natira_fon.php">
<button name="page_OK" value="0" type="submit" class="btn btn-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="Snef" type="submit" class="btn btn-outline-success btn-sm mb-2">Snef</button>
</form>';

    }else{
    $recuperation = $bdd->query("SELECT * from `network_fon` INNER JOIN network_account  
    WHERE network_fon.si_id = network_account.id 
    AND network_account.supplier IN ('Natira')
    AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
    AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
    AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
    AND network_fon.natira_presta_fo LIKE '".$_POST['page_OK']."'
    ORDER BY network_fon.prio ASC,network_fon.id DESC ");
    
    $count = $bdd->query("SELECT count(*) AS COUNT from `network_fon` INNER JOIN network_account  
WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
AND network_fon.natira_presta_fo LIKE '".$_POST['page_OK']."'
ORDER BY network_fon.prio ASC,network_fon.id DESC ");
    
    switch ($_POST['page_OK']){
                       
            case 'Socom':
                 echo'
<center><form method="post" action="suivi_natira_fon.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="Snef" type="submit" class="btn btn-outline-success btn-sm mb-2">Snef</button>
</form>';
                       break;
            case 'Resonance':
                 echo'
<center><form method="post" action="suivi_natira_fon.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="Snef" type="submit" class="btn btn-outline-success btn-sm mb-2">Snef</button>
</form>';
                       break;
            case 'Eiffage':
                echo'
<center><form method="post" action="suivi_natira_fon.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="Snef" type="submit" class="btn btn-outline-success btn-sm mb-2">Snef</button>
</form>';
                       break;
            case 'Axione':
                 echo'
<center><form method="post" action="suivi_natira_fon.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="Snef" type="submit" class="btn btn-outline-success btn-sm mb-2">Snef</button>
</form>';
                       break;
            case 'Snef':
                 echo'
<center><form method="post" action="suivi_natira_fon.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="Snef" type="submit" class="btn btn-success btn-sm mb-2">Snef</button>
</form>';
                       break;
                    }
    }

}else{
$recuperation = $bdd->query("SELECT *  from `network_fon` INNER JOIN network_account  
WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
ORDER BY network_fon.prio ASC,network_fon.id DESC ");

$count = $bdd->query("SELECT count(*) AS COUNT from `network_fon` INNER JOIN network_account  
WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_account.fs_service_delivery IS NULL OR network_account.fs_service_delivery = '0000-00-00' ) 
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND network_account.service_type  NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
ORDER BY network_fon.prio ASC,network_fon.id DESC ");

echo'
<center><form method="post" action="suivi_natira_fon.php">
<button name="page_OK" value="0" type="submit" class="btn btn-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="Snef" type="submit" class="btn btn-outline-success btn-sm mb-2">Snef</button>
</form>';
}

echo '

<form method="post" action="../includes/export_fon_csv.php">';
if(!empty($_POST['page_OK'])){
         echo '       <input type="hidden" value="'.$_POST['page_OK'].'" name ="page_OK"/>';
    
}else{
     echo '       <input type="hidden" value="0" name ="page_OK"/>';
}
    echo'            <input type="hidden" value="1" name ="mes"/>
                <button type="submit" class="btn btn-outline-primary btn-sm mb-2">Export</button>
                </form>';


                
                $c = $count->fetch();
echo '<h2> Nombres de ligne : '.$c['COUNT'];




echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Client - FSLNK </td>
                <td>Prio</td>
                <td>Presta GC</td>
                <td>Presta FO</td>
                <td>Lancement client</td>
                <td>Route<br/>Optique</td>
                <td>VT</td>
                <td>Validation</br>APD</td>
                <td>Arret</br>Voirie</td>
                <td>GC</td>
                <td>Aiguillage</td>
                <td>BLO</td>
                <td>Tirage</td>
                <td>Racco</br>Desserte</td>
                <td>DOE</td>
                <td>Limite</br>MES</td>
                <td>MES</td>
                <td data-width="150" >Commenataire</td>
                <td>MAJ</td>
            </tr>
        </thead>';
        while ($r = $recuperation->fetch(PDO::FETCH_ASSOC)){
            
            if(!empty($r['date_natira']) && $r['date_natira'] != '0000-00-00'  && $r['date_natira'] != '1970-01-01'){
            
            $date_ro = date('d-m-Y',strtotime($r['date_natira']));
            }else{
                $date_ro = 'N/A';
            }


            
            $id_natira =$r['si_id'];
            

            echo '
            <tr>
 
                <form method="post" action="suivi_natira_fon.php">';
if(!empty($r['prio'])){
                    switch ($r['prio']){
                       case 1:
                 echo '
                 <td style="background-color:#CC3E54">'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                       <option value="1">1</option>
	                   <option value="4"></option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';
                       break;
                       case 2:
                 echo '
                  <td style="background-color:#DBD23A">'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                       <option value="2">2</option>
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="3">3</option>
                       ';
                       break;
                       case 3:
                 echo '
                      <td style="background-color:#20AE51">'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">  
                       <option value="3">3</option>
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="2">2</option>
                       ';
                       break;
                       case 4:
                 echo '
                      <td>'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">  
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';
                       break;
                      
                        
                    }
                }else{
                     echo '
                      <td >'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                     <option value="4"></option>
	                   <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';     
                }
                echo '
                 </select></center>
                </td>
                <td><center><select name="presta_gc"  class="form-control">';
	                            if(!empty($r['natira_presta_gc'])){
                    switch ($r['natira_presta_gc']){
            case 'SOCOM TP':
                 echo '<option value="SOCOM TP">SOCOM TP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'LHERM TP':
                 echo '<option value="LHERM TP">LHERM TP</option>
	                   <option value=""></option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'STP':
                 echo '<option value="STP">STP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'CASSAGNE TP':
                 echo '<option value="CASSAGNE TP">CASSAGNE TP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       ';
                       break;

                    }
                }else{
                     echo '
	                   <option value=""></option>
	                   <option value="SOCOM TP">SOCOM TP</option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';     
                }
                echo'       </select></center></td>
                <td><center><select name="presta_fo"  class="form-control">';
	                            if(!empty($r['natira_presta_fo'])){
                    switch ($r['natira_presta_fo']){
                       
            case 'SOCOM':
                 echo '<option value="SOCOM">SOCOM</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'RESONANCE':
                 echo '<option value="RESONANCE">RESONANCE</option>
	                   <option value=""></option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'EIFFAGE':
                 echo '<option value="EIFFAGE">EIFFAGE</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'AXIONE':
                 echo '<option value="AXIONE">AXIONE</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'SNEF':
                 echo '<option value="SNEF">SNEF</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SOCOM">SOCOM</option>
                       ';
                       break;
                    }
                }else{
                     echo '
	                   <option value=""></option>
	                   <option value="SOCOM">SOCOM</option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';     
                }
                        echo'</select></center>
                </td>
                <td><center><input type="date" class="form-control" name="kmz" value ="'.$r['natira_kmz'].'"/></center></td>
                <td><center>'.$date_ro.'</center></td>
                <td><center><input type="date" class="form-control" name="vt" value ="'.$r['natira_vt'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="apd" value ="'.$r['natira_apd'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="voirie" value ="'.$r['natira_voirie'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="gc" value ="'.$r['natira_gc'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="aiguillage" value ="'.$r['natira_aiguillage'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="blo" value ="'.$r['natira_blo'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="tirage" value ="'.$r['natira_tirage'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="racco" value ="'.$r['natira_racco'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="doe" value ="'.$r['natira_doe'].'" /></center></td>';
                if(!empty($r['natira_limite_mes']) && $r['natira_limite_mes'] != '0000-00-00' ){
                    if(strtotime($day) >= strtotime($r['natira_limite_mes']) ){
                    echo '<td style="background-color:#8C2CDD"><center><input type="date" class="form-control" name="limite_mes" value ="'.$r['natira_limite_mes'].'" /></center></td>';
                    }else{
                        echo '<td><center><input type="date" class="form-control" name="limite_mes" value ="'.$r['natira_limite_mes'].'" /></center></td>';
                    }
                }else{
                    echo '<td><center><input type="date" class="form-control" name="limite_mes" value ="'.$r['natira_limite_mes'].'" /></center></td>';
                }

                
                echo '
                <td><center><input type="date" class="form-control" name="mes" value ="'.$r['mes'].'" /></center></td>
                <td><textarea class="form-control" rows="2" cols="30" name="commentaire" >' .$r['suivi_natira_commentaire']. '</textarea></td>
                <td>
                <input type="hidden" value="'.$id_natira.'" name ="id"/>
                <input type="hidden" value="'.$_POST['page_OK'].'" name ="page_OK"/>
                <button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                </form><br/>
                <form method="post" action="fon.php">
                    <input type="hidden" value="'.$id.'" name ="annuler_id"/>
                	<button type="submit" name="annuler" class="btn btn-outline-danger btn-sm mb-2">Annuler</button>
                		</form>

                </td>
            </tr>
           
           ';
  
  
  
  }
   
        echo '</table>';


echo '</center><br/><br/>';
require('../includes/foot.php');
?>
