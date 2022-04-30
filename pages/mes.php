<?php
require ('../includes/head.php');

$day = date('d-m-Y');

#var_dump($_POST);


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
			
			$up2 = $bdd->prepare("UPDATE `network_vision` SET `annuler`= :annuler WHERE `si_id` = :id ");
			$up2->execute(array(
				"id" => $id,
				"annuler" => $annuler
			));
}

if (!empty($_POST['id']))
{
    $semaine_J = date('W');
    $anne_j = date('Y');
	// Recuperation variable du post
    
	$uid = $_POST['id'];
	$fsn = $_POST['fsn'];
	$mes_format = $_POST['mes_prev'];
	
	
	$entre_format = $_POST['entre'];
	
	if(!empty($entre_format)){
	$entre_explode = explode(':',$entre_format);
	$entre_min = strtolower($entre_explode[0]);
	$entre_maj = ucfirst(strtolower($entre_explode[1]));
	$entreu = $entre_min.':'.$entre_maj;
	}elseif(!empty($_POST['entre_collecte']) && !empty($_POST['entre_port'])){
	    $entreu =$_POST['entre_collecte'].':'.$_POST['entre_port'];
	}else{
	    $entreu = '';	}
	
	$vlanu = $_POST['vlan'];
	$peu = $_POST['pe'];
	$circuitu = $_POST['circuit'];
	$locationu = $_POST['location'];
	$mesu = $_POST['mes'];
	$ticketu = $_POST['ticket'];
	$lienu = $_POST['lien'];
	$appelu = $_POST['appel'];
	
	$ru_visu = $bdd->query("SELECT * FROM network_vision WHERE si_id = '$uid' ");
	$y = $ru_visu->fetch(PDO::FETCH_ASSOC);
	$id_visu = $y['id'];
	$annee_visu = $y['ann_prevu'];
	
	if(!empty($locationu )){
	    $cpeu = date('Y-m-d');
	}
	

	$mes_visu = $y['mes_prevu'];
	$annee_visu = $y['ann_prevu'];

    if(!empty($mes_format)){
    	if (!empty($mes_visu) && $mes_visu == $mes_format ){

    		$mes_prevu = $mes_visu;
    	    $ann_prevu = $annee_visu;
    	    
    	    }else{

    		if($mes_format >= $semaine_J){

    		$mes_prevu = $mes_format;
    	    $ann_prevu = date('Y');
    
    	        }else {

    	   $mes_prevu = $mes_format;
    	  $ann_prevu = date('Y',strtotime($anne_j.'+1 YEAR'));
    	        }
        
    	        }
	    }

	else{
	    $mes_prevu = '0';
	    $ann_prevu ='0';
	}


	if (empty($id_visu))
	{
   
		// Creation dans la base Visu si le FSLNK n'y ai pas

		$requete = $bdd->prepare("INSERT INTO network_vision (si_id,mes_prevu,ann_prevu,entre,cpe,circuit,location,ticket,appel) 
		VALUES(:uid, :mes_prevu, :ann_prevu, :entreu, :cpeu, :circuitu, :locationu, :ticketu, :appelu)");
	$variable_req = array(
			"uid" => $uid,
			"mes_prevu" => $mes_prevu,
			"ann_prevu" => $ann_prevu,
			"entreu" => $entreu,
			"cpeu" => $cpeu,
			"circuitu" => $circuitu,
			"locationu" => $locationu,
			"ticketu" => $ticketu,
			"appelu" => $appelu
		);
	$requete->execute($variable_req);

	}
	else
	{

		// Update dans la base si le FSLNK y existe

		$up = $bdd->prepare("UPDATE `network_vision` SET 
			`mes_prevu`= :mes_prevu,
			`ann_prevu`= :ann_prevu,
			`entre`= :entreu,
			`cpe`= :cpeu,
			`circuit`= :circuitu,
			`location`= :locationu,
			`ticket`= :ticketu,
			`appel` = :appelu
			 WHERE `id` = :id_visu ");
		$up->execute(array(
			"id_visu" => $id_visu,
			"mes_prevu" => $mes_prevu,
			"ann_prevu" => $ann_prevu,
			"entreu" => $entreu,
			"cpeu" => $cpeu,
			"circuitu" => $circuitu,
			"locationu" => $locationu,
			"ticketu" => $ticketu,
			"appelu" => $appelu
		));

	}

	// Si Equipement posÃ© ajout dans la base de si-plugin

	if (!empty($fsn))
	{

		// traitement pour le nom de l'equipement

		$fsnE = substr($fsn, -5);
		$fsnu = 'fsn' . $fsnE;
		$re = $bdd->query("SELECT `eqts` FROM network_account WHERE id = '$uid' ");
		$y = $re->fetch(PDO::FETCH_ASSOC);
		$eqts = $y['eqts'];
		if (empty($eqts))
		{
			$up1 = $bdd->prepare("UPDATE `network_account` SET `eqts`= :fsnu WHERE `id` = :uid");
			$up1->execute(array(
				"uid" => $uid,
				"fsnu" => $fsnu
			));
		}
	}

	// Si PE posÃ© ajout dans la base de si-plugin

	if (!empty($peu))
	{
		$up1 = $bdd->prepare("UPDATE `network_account` SET `pe`= :peu WHERE `id` = :uid");
		$up1->execute(array(
			"uid" => $uid,
			"peu" => $peu
		));
	}

	// Si Vlan posÃ© ajout dans la base de si-plugin

	if (!empty($vlanu))
	{
		$up1 = $bdd->prepare("UPDATE `network_account` SET `vlan`= :vlanu WHERE `id` = :uid");
		$up1->execute(array(
			"uid" => $uid,
			"vlanu" => $vlanu
		));
	}
	
	if (!empty($entreu))
		{
			
			$up3 = $bdd->prepare("UPDATE `network_account` SET `collecte`= :pe WHERE `id` = :uid ");
			$up3->execute(array(
				"uid" => $uid,
				"pe" => $entreu));

		}

	// Si MES posÃ© ajout dans la base de visu et de si-plugin

	if (!empty($mesu))
	{
	    $semaine = date('W',strtotime($mesu));
	    $annee = date('Y',strtotime($mesu));
	    
		$up2 = $bdd->prepare("UPDATE `network_vision` SET `mes`= :mesu,`mes_prevu`= :mes_prevu,
			`ann_prevu`= :ann_prevu WHERE `id` = :id_visu");
			
		$up2->execute(array(
			"id_visu" => $id_visu,
			"mesu" => $mesu,
			"mes_prevu" => $semaine,
			"ann_prevu" => $annee
		));
		$up1 = $bdd->prepare("UPDATE `network_account` SET `fs_service_delivery`= :mesu WHERE `id` = :uid");
		$up1->execute(array(
			"uid" => $uid,
			"mesu" => $mesu
		));
		
		
		$up3 = $bdd->prepare("UPDATE `network_vision` SET `etat`= 'OK' WHERE `si_id` = :uid");
		$up3->execute(array(
			"uid" => $uid
		));
	}
	
	

}	



// Tri dans la base si_plugin

$mes = $bdd->query("SELECT *
	FROM `network_account` 
	WHERE `fs_service_delivery` IS NULL
	AND  `resiliation` IS NULL
	AND `contact_name` IS NOT NULL 
	AND `contact_tel` IS NOT NULL
	AND `service_type` IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
	ORDER BY id DESC");
	
//  Compte les routeurs a faire 

reste_routeur($bdd);


// semaine qu'on est

$semaine = date("W");
$semaine_4 = date("W", strtotime("+4 week"));
$Year = date("Y");
echo '<center><h3>Nous sommes en semaine ' . $semaine . '</h3></center>';

// Tableau

echo  '
	<center><table class="table table-bordered table-striped" >
	    <thead class="thead-dark">
		<tr>
			<td  width="100"><center>Client</center></td>
			<td><center>FSLNK</center></td>
			<td><center>Type</center></td>
			<td><center>CPE</center></td>
			<td><center>Point d\'entrée</center></td>
			<td><center>Vlan</center></td>
			<td><center>PE</center></td>
			<td><center>MES<br/>Prévu</center></td>
			<td><center>CPE</center></td>
			<td><center>Circuit</center></td>
			<td><center>Appel / Commentaires</center></td>
			<td><center>Commentaires<br/>Commerce</center></td>
			<td><center>Ticket</center></td>
			<td><center>Etat Orange</center></td>
			<td width="200"><center>Com Orange</center></td>
			<td><center>MAJ</center></td>
		</tr>
		</thead>

';


// variable pour les titres des colonnes

$j = 0;
$semaineC = date("W", strtotime("+4 week"));
$semaineD = date("W", strtotime("+2 week"));



while ($r = $mes->fetch(PDO::FETCH_ASSOC))
{
    
    

	// Variable table Si-plugin

	$id = $r['id'];
	$service = $r['service_type'];
	$fslnk = $r['service_ref'];
	$fslnkE = substr($fslnk, -5);
	$vlan = $r['vlan'];
	$pe = $r['pe'];
	$debit = $r['bandwidth'];
	$operateur = $r['supplier'];
	$techno = $r['media'];
	$porte = $r['porte'];


   
	// Rajout des donnÃ© en dynamique des info de la base visu

	$ru_vision = $bdd->query("SELECT * FROM network_vision WHERE si_id = '$id' ");
	$w = $ru_vision->fetch(PDO::FETCH_ASSOC);

	// Variable de la bse visu
    $entre = '';
	$entre = $w['entre'];
	if(!empty($entre)){

	                    $entre_explode_visu = explode(':',$entre);
	                $entre_min_visu = strtolower($entre_explode_visu[0]);
	                $entre_maj_visu = ucfirst(strtolower($entre_explode_visu[1]));
       
   }
	
	if(!empty($w['natira_limite_mes']) && $w['natira_limite_mes'] != '0000-00-00'){
	 $semaine_suivi_natira = date('W', strtotime($w['natira_limite_mes']));
	}else{
	    $semaine_suivi_natira = 'N/A';
	}
	
	$mes_prev = $w['mes_prevu'];
	$ann_prev = $w['ann_prevu'];
	$circuit = $w['circuit'];
	$location = $w['location'];
	$contact = $w['contact'];
	$appel = $w['appel'];
	$outils = $w['outils'];
	$ticket = $w['ticket'];
	$lien = $w['lien'];
	$site = trim($w['site']);
	$etat_natira = $w['etat'];
    $presta = $w['natira_presta_fo'];
	$com_commerce =$w['contact'];

	// Choix automatique de l'equipement

	if ($service == 'Lan2Lan' OR $service == 'Collecte Ethernet' OR $service == 'Transit IP')
	{
		if ($debit <= 1000000)
			{
				$type = 'RAD';
			}
			
			elseif ($debit > 1000000)
			{
				$type = 'RAD 10G';

			}
	}
	elseif ($service == 'Porte de collecte' || $service == 'Porte de livraison'){
	    $type = 'Port ASR';
	}
	else
	{
		$type = 'Huawei';

			

			
		}
		
	


	if (!empty($location) && $circuit == 'OK')
	{
		$ready = 1;
	}
	elseif (empty($mes_prev) || $mes_prev == '0')
	{
		$noDate = 1;
	}
	elseif ($semaineD >= $mes_prev && $ann_prev == $Year)
	{
		if (empty($location))
		{
			$urgent = 1;
		}

		if ($circuit != 'OK')
		{
			$urgent = 1;
		}
	}
	elseif ($semaineC >= $mes_prev && $mes_prev > $semaine && $ann_prev == $Year)
	{
		if (empty($location))
		{
			$warning = 1;
		}

		if ($circuit != 'OK')
		{
			$warning = 1;
		}
	}
	


	// ajout des titres des colonnes toute les 15 lignes

	if ($j == 15)
	{
		$j = 0;
		 echo  '

		<thead class="thead-dark">
		<tr>
			<td  width="100"><center>Client</center></td>
			<td><center>FSLNK</center></td>
			<td><center>Type</center></td>
			<td><center>CPE</center></td>
			<td><center>Point d\'entrée</center></td>
			<td><center>Vlan</center></td>
			<td><center>PE</center></td>
			<td><center>MES<br/>Prévu</center></td>
			<td><center>CPE</center></td>
			<td><center>Circuit</center></td>
			<td><center>Appel / Commentaires</center></td>
			<td><center>Commentaires<br/>Commerce</center></td>
			<td><center>Ticket</center></td>
			<td><center>Etat Orange</center></td>
			<td width="200"><center>Com Orange</center></td>
			<td><center>MAJ</center></td>
		</tr>
	</thead>

';
		
	}
	else
	{
		$j++;
	}

		echo '<tr>';


	// colorisation urgent

	if ($urgent == 1)
	{
		$urgent--;
		echo '<td style="background-color:#CC3E54"><center>' . $r['name'] . '</center></td>';
	}
	elseif ($warning == 1)
	{
		$warning--;
		echo '<td style="background-color:#DBD23A"><center>' . $r['name'] . '</center></td>';
	}
	elseif ($ready == 1)
	{
		$ready--;
		echo '<td style="background-color:#20AE51"><center>' . $r['name'] . '</center></td>';
	}
	elseif ($noDate == 1)
	{
		$noDate--;
		echo '<td style="background-color:#6699ff"><center>' . $r['name'] . '</center></td>';
	}
	else
	{
		echo '<td><center>' . $r['name'] . '</center></td>';
	}


    // colorisation operateur
    
     switch ($operateur)
	{
	case 'Natira':
		$color = '5db280';
		break;

	case 'FullSave':
		$color = '5db280';
		break;

	case 'ORANGE WHOLESALE':
		$color = 'FF9900';
		break;

	case 'GIRONDE NUMERIQUE':
		$color = 'FF9900';
		break;

	case 'GIRONDE HAUT DEBIT':
		$color = 'FF9900';
		break;

	case 'GERS NUMERIQUE':
		$color = 'FF9900';
		break;

	default;
	$color = 'FFFF66';
	break;
}

	echo '
    	 				
    	 				
                		<td><center>' . $fslnkE . '</center></td>
                		<td><center>' . $service . '</center></td>';



   
      	
if($operateur == 'Natira' || $operateur == 'FullSave'){
        if(!empty($etat_natira) && $etat_natira == 'Port à reserver'){
            unset($etat_natira);
            $color_natira = 'CC3E54';
             $select_entree = $r['collecte'];
             
             
        }
        
        $select_entree = $r['collecte'];
}else{
    
           if($operateur == 'ORANGE WHOLESALE'){
        if ($porte == 'CELAN'){
        $select_entree = 'tls00-1-ncs5k:Be19';
		}elseif ($porte == 'CELAN-TLS00') {
		     $select_entree = 'tls00-2-ncs5k:Be21';
        }elseif ($porte == 'CELAN-MRS01') {
		     $select_entree = 'tls00-2-ncs5k:Be31';
		
        }elseif ($porte == 'DSLE') {
		     $select_entree = 'lbg01-1-m36:Gi0/4"';
        }else{
           $select_entree = 'tls00-1-ncs5k:Be19'; 
        }
    }elseif($operateur == 'COVAGE'){
        $operateur = 'CLEO'; 
        $supplier_req = $bdd->query("SELECT `collecte` FROM `network_account` WHERE `service_type` = 'Porte de collecte' AND `supplier` = '".$operateur."'");
	             $w = $supplier_req->fetch(PDO::FETCH_ASSOC);
	           $select_entree = $w['collecte'];
    }else{
    $supplier_req = $bdd->query("SELECT `collecte` FROM `network_account` WHERE `service_type` = 'Porte de collecte' AND `supplier` = '".$operateur."'");
	             $w = $supplier_req->fetch(PDO::FETCH_ASSOC);
	           $select_entree = $w['collecte'];  

    }

    

}

echo '          		<td style="background-color:#' . $color . '"><center>' . $type . '</center></td>';
echo '          	
                <form name ="primary" method="post" action="mes.php">';
                		
        

                    if(!empty($color_natira)){
                       
                        echo '
                        <td style="background-color:#'.$color_natira.'"><center>'.$select_entree.'</center></td>';
                            unset($color_natira);
                    }else{
                    echo '		<td><center>'.$select_entree.' </center></td>';
                    }
    echo'            		
                		
                		<td><center>	<input style="width:60" class="form-control" size="200" type="number" max="4096" name="vlan" value="' . $vlan . '" /> </center></td>
                		<td><center>	<select name="pe"  class="form-control">
        <option value="' . $pe . '">' . $pe . '</option>';
        
        echo '

    	<option value="tls00-2-mx">tls00-2-mx</option>
    	<option value="lbg01-2-mx">lbg01-2-mx</option>
    	
    	<option value="tls00-1-mx2">tls00-1-mx2</option>
    	<option value="tls00-2-mx2">tls00-2-mx2</option>
    	
    	<option value="lbg01-1-mx2">lbg01-1-mx2</option>
    	<option value="lbg01-2-mx2">lbg01-2-mx2</option>
    	
    	<option value="blm01-1-mx2">blm01-1-mx2</option>
    	<option value="blm01-2-mx2">blm01-2-mx2</option>
    	';
        
        
        if($operateur == 'Natira' || $operateur == 'FullSave'){
        echo '
   						</select> </center></td>
                		<td><center>	<input style="width:60" type="number" class="form-control" min="1" max="53" name="mes_prev" value="'.$mes_prev.'"/> <br/> '.$semaine_suivi_natira.'	</center></td>
                	    	</select></center></td>';
        } else{
            echo '
   						</select> </center></td>
                		<td><center>	<input style="width:60" type="number" class="form-control" min="1" max="53" name="mes_prev" value="'.$mes_prev.'"/>	</center></td>
                	    	</select></center></td>';
        }	    	
        
        
           echo '     	    	

                		<td><center><select name="location" class="form-control">
           <option value="'.$location.'">'.$location.'</option>
    <option value="NOK">NOK</option>';
    if(!empty($presta)){
        echo '<option value="Caisse '.$presta.'">Caisse '.$presta.'</option>
			  <option value="Stock FAI">Stock FAI</option>';
    }else{
         echo '<option value="Stock FAI">Stock FAI</option>';
    }
        echo '
        <option value="Client">Client</option>
        <option value="UPS">UPS</option>
        </select></center></td>


                		<td><center>	<select name="circuit" class="form-control">
        <option value="' . $circuit . '">' . $circuit . '</option>
		<option value="OK">OK</option>
    	<option value="NOK">NOK</option>
    </select>
   <td><center>	<textarea class="form-control" rows="2" cols="30" name="appel" >' . $appel . '</textarea> </center></td>
    <td><center>'.$com_commerce.'</center></td>

    	
    	<td><center>	<input style="width:65" class="form-control" type="text" name="ticket" value="' . $ticket . '"/>	</center></td>
                		<td><center>';
	 
	if($operateur == 'ORANGE WHOLESALE' || $operateur == 'GIRONDE NUMERIQUE' || $operateur == 'GIRONDE HAUT DEBIT' || $operateur == 'GERS NUMERIQUE' ){
	    $recuperation_orange_state = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$fslnk' AND `keyname` = 'state' ");
        
	    $orange_state = $recuperation_orange_state->fetch(PDO::FETCH_ASSOC);
	    
         
    switch ($orange_state['value']) {
        case "etat.encours":
            echo "En cours";
            break;
        case "etat.miseadispo":
            echo "Dispo";
            break;
        case "etat.depose":
            echo "Déposé";
            break;
        default:
            $state = $orange_state['value'];
    }

	}
	
	
	echo '
	</center></td>
	
		<td><center>';
	
	if($operateur == 'ORANGE WHOLESALE' || $operateur == 'GIRONDE NUMERIQUE' || $operateur == 'GIRONDE HAUT DEBIT' || $operateur == 'GERS NUMERIQUE' ){

        $recuperation_orange_comment = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$fslnk' AND `keyname` = 'ClientComment' ");
        $orange_comment = $recuperation_orange_comment->fetch(PDO::FETCH_ASSOC); 
	     $commentaire_orange = explode ("//",$orange_comment['value']);
   
    echo $commentaire_orange[0];
	}
	
	
	echo '
	</center></td>

                		


                		<td><center>
                		    
                		    <input type="hidden" value="' . $select_entree . '" name ="entre"/>
                			<input type="hidden" value="' . $id . '" name ="id"/>
                			<input type="hidden" value="' . $r['service_ref'] . '" name ="fsn"/>
							
                	<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                	</form>
                		<form method="post" action="mes.php">
                    <input type="hidden" value="'.$id.'" name ="annuler_id"/>
                	<button type="submit" name="annuler" class="btn btn-outline-danger btn-sm mb-2">Annuler</button>
                		</form>
                		
                		</center></td>

                		</tr>';
						unset($type);
}


require('../includes/foot.php');
?>
