<?php
require ('../includes/head.php');

$day = date('d-m-Y');
$direct_date = date('Y-m-d');


if(!empty($_POST['si_id']) ){
	$up = $bdd->prepare("UPDATE `network_vision` SET 
			`contact`= :contact
			 WHERE `si_id` = :id ");
		$up->execute(array(
			"id" => $_POST['si_id'],
			"contact" => $_POST['contact']
		));

}

// Tri dans la base si_plugin

$mes = $bdd->query("SELECT *
	FROM `network_account` 
	WHERE `fs_service_delivery` IS NULL
	AND  `resiliation` IS NULL
	AND `contact_name` IS NOT NULL 
	AND `contact_tel` IS NOT NULL
	AND `service_type` IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet')
	ORDER BY id DESC");
	





// semaine qu'on est

$semaine = date("W");
echo '<center><h3>Nous sommes en semaine ' . $semaine . '</h3></center>
	<center><table class="table table-bordered table-striped" >';

// Tableau

$tableau=  '

	    <thead class="thead-dark">
		<tr>
			<td width="100"><center>Client</center></td>
			<td width="100"><center>FSLNK</center></td>
			<td width="100"><center>Opérateur</center></td>
			<td width="100"><center>MES<br/>Prévu</center></td>
			<td width="100"><center>CPE</center></td>
			<td width="100"><center>Suivi<br/>Déploiement</center></td>
			<td width="300"><center>Commentaires<br/>Déploiement</center></td>
			<td width="300"><center>Commentaires<br/>Delivery</center></td>
			<td width="300"><center>Commentaires<br/>Commerce</center></td>
			<td width="50"><center>Maj</center></td>
		</tr>
		</thead>

';

echo $tableau;

while ($r = $mes->fetch(PDO::FETCH_ASSOC))
{
    
    

	// Variable table Si-plugin

	$id = $r['id'];
	
	$service = $r['service_type'];
	$fslnk = $r['service_ref'];
	$fslnkE = substr($fslnk, -5);
	
	$tS_operateur = $r['supplier'];
	
	// Rajout des donnÃ© en dynamique des info de la base visu

	$ru_vision = $bdd->query("SELECT * FROM network_vision WHERE si_id = '$id' ");
	$w = $ru_vision->fetch(PDO::FETCH_ASSOC);


		  
	
	$mes_prev = $w['mes_prevu'];
	$circuit = $w['circuit'];
	$location = $w['location'];
	$contact = $w['contact'];
	$appel = $w['appel'];


    if(!empty($w['natira_doe']) && $w['natira_doe'] != '0000-00-00' ){
        if(strtotime($direct_date) >= strtotime($w['natira_doe']) ){
        $etat_natira = 'DOE OK';}
        else{
            $etat_natira = 'DOE Prévu le :<br/> '.$w['natira_doe'];
        }
    }elseif(!empty($w['natira_racco']) && $w['natira_racco'] != 0 ){
        if($semaine >= $w['natira_racco'] ){
        $etat_natira = 'Racco OK';}
        else{
            $etat_natira = 'Racco Prévu <br/> semaine :<br/> '.$w['natira_racco'];
        }
    }elseif(!empty($w['natira_tirage']) && $w['natira_tirage'] != 0  ){
        if($semaine >= $w['natira_tirage']){
        $etat_natira = 'Tirage OK';}
        else{
            $etat_natira = 'Tirage Prévu <br/> semaine :<br/> '.$w['natira_tirage'];
        }
    }elseif(!empty($w['natira_blo']) && $w['natira_blo'] != 0  ){
        if($semaine >= $w['natira_blo']){
        $etat_natira = 'BLO OK';}
        else{
            $etat_natira = 'BLO Prévu <br/> semaine :<br/> '.$w['natira_blo'];
        }
    }elseif(!empty($w['natira_vt']) && $w['natira_vt'] != '0000-00-00'){
        if(strtotime($direct_date) >= strtotime($w['natira_vt'])  ){
        $etat_natira = 'VT OK';}
        else{
            $etat_natira = 'VT Prévu <br/> semaine :<br/> '.$w['natira_vt'];
        }
    }else{
        $etat_natira = 'N/A';
    }



	// ajout des titres des colonnes toute les 15 lignes

	if ($j == 15)
	{
		$j = 0;
		 echo  $tableau;
		
	}
	else
	{
		$j++;
	}

		echo '<tr>
                		<td><center>'.$r['name'].'</center></td>
                		<td><center>'.$fslnkE.'</center></td>
						<td><center>'.$r['supplier'].'</center></td>
                		<td><center>'.$mes_prev.'</center></td>
                		<td><center>'.$location.'</center></td>
                		<td><center>';
if($tS_operateur == 'ORANGE WHOLESALE' || $tS_operateur == 'GIRONDE NUMERIQUE' || $tS_operateur == 'GIRONDE HAUT DEBIT' || $tS_operateur == 'GERS NUMERIQUE' ){
	    $recuperation_orange_state = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$fslnk' AND `keyname` = 'state' ");
        $recuperation_orange_comment = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$fslnk' AND `keyname` = 'ClientComment' ");
        
	    $orange_state = $recuperation_orange_state->fetch(PDO::FETCH_ASSOC);
	    $orange_comment = $recuperation_orange_comment->fetch(PDO::FETCH_ASSOC); 
	    
         
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

	}elseif($tS_operateur == 'Natira'){
	   echo $etat_natira;
	}
                		
                		echo'</center></td>
                			<td  width="250"><center>';
	
	if($tS_operateur == 'ORANGE WHOLESALE' || $tS_operateur == 'GIRONDE NUMERIQUE' || $tS_operateur == 'GIRONDE HAUT DEBIT' || $tS_operateur == 'GERS NUMERIQUE' ){

        $recuperation_orange_comment = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$fslnk' AND `keyname` = 'ClientComment' ");
        $orange_comment = $recuperation_orange_comment->fetch(PDO::FETCH_ASSOC); 
	     $commentaire_orange = explode ("//",$orange_comment['value']);
   
    echo $commentaire_orange[0];
	}elseif($tS_operateur == 'Natira' || $tS_operateur == 'FullSave'){
	    echo $w['suivi_natira_commentaire'];
	}
	
	
	echo '
	</center></td>
                		<td  width="250"><center>'. $appel.'</center></td>
						<form method="post" action="mes_com.php">
                		<td  width="250"><textarea class="form-control" rows="5" cols="30" name="contact" >'.$contact.'</textarea></td>
                		<td> 
	                <input type="hidden" value="'.$id.'" name ="si_id"/>
                		<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                		</form></td>
            </tr>';
}


require('../includes/foot.php');
?>
