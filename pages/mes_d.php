<?php
require ('../includes/head.php');
$direct_date = date('Y-m-d');
if (!empty($_POST['mes_direct'])){
    
    
    $semaine = date('W');
	$annee = date('Y');
	    
    
    $direct_id = $_POST['mes_direct'];
    $direct_requete = $bdd->query("SELECT * FROM network_vision WHERE si_id = '$direct_id' ");
	$recup = $direct_requete->fetch(PDO::FETCH_ASSOC);
	$recup_entre = $recup['entre'];
    
    
    	$up2 = $bdd->prepare("UPDATE `network_vision` SET `mes`= :mesu ,`location` = :location, `circuit`= :circuit ,`mes_prevu`= :mes_prevu,
			`ann_prevu`= :ann_prevu WHERE `si_id` = :id_visu");
		$up2->execute(array(
			"id_visu" => $direct_id,
			"location" => 'Client',
			"circuit" => 'OK',
			"mesu" => $direct_date,
			"mes_prevu" => $semaine,
			"ann_prevu" => $annee
		));
		$up1 = $bdd->prepare("UPDATE `network_account` SET `fs_service_delivery`= :mesu WHERE `id` = :uid");
		$up1->execute(array(
			"uid" => $direct_id,
			"mesu" => $direct_date
		));

			
			$up3 = $bdd->prepare("UPDATE `network_account` SET `collecte`= :pe WHERE `id` = :uid ");
			$up3->execute(array(
				"uid" => $direct_id,
				"pe" => $recup_entre));
				
			$up4 = $bdd->prepare("UPDATE `network_vision` SET `etat`= 'OK', `commentaire_natira`= CONCAT (commentaire_natira,:com_nat) WHERE `si_id` = :uid");
            $up4->execute(array(
                "com_nat" => ' // MES OK le '.date('d/m/Y'),
            	"uid" => $direct_id
        ));

    
}

$check_mes = $bdd->query("SELECT si_id,mes,entre
    FROM network_vision 
   WHERE mes IS NULL
    ");

while ($checks = $check_mes->fetch(PDO::FETCH_ASSOC))
{

$check_id = $checks['si_id'];
$recup_entre = $checks['entre'];

 $check_resil = $bdd->query("SELECT id,fs_service_delivery FROM network_account WHERE `id` = '$check_id' AND `fs_service_delivery` IS NOT NULL");
 
while ($checks_count = $check_resil->fetch(PDO::FETCH_ASSOC))
{
    
        $uid =  $checks_count['id'];   
        $mesu =  $checks_count['fs_service_delivery']; 

        
        $up1 = $bdd->prepare("UPDATE `network_vision` SET `mes`= :mesu WHERE `si_id` = :uid");
        $up1->execute(array(
            "uid" => $uid,
            "mesu" => $mesu
        ));
        
        	$up3 = $bdd->prepare("UPDATE `network_account` SET `collecte`= :pe WHERE `id` = :uid ");
			$up3->execute(array(
				"uid" => $check_id,
				"pe" => $recup_entre));

}
}


	
	


// semaine qu'on est

$semaine = date("W");
$semaine_4 = date("W", strtotime("+4 week"));
$semaine_3 = date("W", strtotime("+3 week"));

$Year = date("Y");
echo '<center><h3>Nous sommes en semaine ' . $semaine . '</h3></center>';

// tableau de mes de la semaine



$mes_semaine = $bdd->query("SELECT * from `network_vision` INNER JOIN network_account 
WHERE network_vision.si_id = network_account.id 
AND network_vision.mes IS NULL 
AND network_vision.mes_prevu IS NOT NULL 
AND network_vision.annuler = 0 
AND network_account.fs_service_delivery IS NULL 
AND network_account.resiliation IS NULL 
ORDER BY network_vision.ann_prevu,network_vision.mes_prevu ASC ");




echo '<center><table border="1">
        
		<tr style="background-color:#3399FF">
			<td><center>Client - FSLNK</center></td>
			<td><center>Supplier</center></td>
			<td><center>MES</center></td>
			<td><center>CPE</center></td>
			<td><center>Location</center></td>
			<td><center>Circuit</center></td>
			<td width="150"><center>Commentaire</center></td>
			<td><center>Etat Opérateur</center></td>
			<td width="150"><center>Commentaire Opérateur</center></td>
			<td><center>Ticket</center></td>
			<td><center>MES</center></td>
		</tr>
			';

while ($tS = $mes_semaine->fetch(PDO::FETCH_ASSOC))
{
    $tS_id = $tS['id'];
	$tS_si = $tS['si_id'];
	$tS_cpe = $tS['location'];
	$tS_circuit = $tS['circuit'];
	$tS_ticket = $tS['ticket'];
	$tS_prevu = $tS['mes_prevu'];
	$tS_commentaire = $tS['appel'];
	
	$tSF = $tS['service_ref'];
	$tS_fslnk = substr($tSF, -5);
	$tS_mes = $tS['fs_service_delivery'];
	$tS_name = $tS['name'];

	$tS_eqts = $tS['eqts'];
	$tS_operateur = $tS['supplier'];
	
    if(!empty($tS['natira_doe']) && $tS['natira_doe'] != '0000-00-00' ){
        if(strtotime($direct_date) >= strtotime($tS['natira_doe']) ){
        $etat_natira = 'DOE OK';}
        else{
            $etat_natira = 'DOE en cours';
        }
    }elseif(!empty($tS['natira_racco']) && $tS['natira_racco'] != 0 ){
        if($semaine >= $tS['natira_racco'] ){
        $etat_natira = 'Racco OK';}
        else{
            $etat_natira = 'Racco en cours';
        }
    }elseif(!empty($tS['natira_tirage']) && $tS['natira_tirage'] != 0  ){
        if($semaine >= $tS['natira_tirage']){
        $etat_natira = 'Tirage OK';}
        else{
            $etat_natira = 'Tirage en cours';
        }
    }elseif(!empty($tS['natira_blo']) && $tS['natira_blo'] != 0  ){
        if($semaine >= $tS['natira_blo']){
        $etat_natira = 'BLO OK';}
        else{
            $etat_natira = 'BLO en cours';
        }
    }elseif(!empty($tS['natira_vt']) && $tS['natira_vt'] != '0000-00-00'){
        if(strtotime($direct_date) >= strtotime($tS['natira_vt'])  ){
        $etat_natira = 'VT OK';}
        else{
            $etat_natira = 'VT en cours';
        }
    }else{
        $etat_natira = 'N/A';
    }

	
	
	if (empty($tS_cpe))
	{
		$war_cpe = 1;
	}

	if ($tS_circuit != 'OK')
	{
		$war_circuit = 1;
	}

	if (!empty($tS_mes))
	{
		$ready_mes = 1; }
	

	

	echo '
 	
 	<tr>';
	if ($ready_mes == 1)
	{
		$ready_mes--;
		echo '<td style="background-color:#20AE51"><center>' . $tS_name . ' - ' . $tS_fslnk . '</center></td>';
	}
	else
	{
		echo ' <td><center>' . $tS_name . ' - ' . $tS_fslnk . '</center></td>';
	}

	echo '   		<td><center>' . $tS_operateur . '</center></td>
	                <td><center>' . $tS_prevu . '</center></td>
 		                    <td><center>' . $tS_eqts . '</center></td>';
	if ($war_cpe == 1)
	{
	    $war_cpe--;
	       if($tS_prevu == $semaine_4 || $tS_prevu == $semaine_3){
		
		echo '<td style="background-color:#DBD23A"><center>' . $tS_cpe . '</center></td>';
	       }else{
	           echo '<td style="background-color:#CC3E54"><center>' . $tS_cpe . '</center></td>';
	       }
	}
	else
	{
		echo '<td><center>' . $tS_cpe . '</center></td>';
	}

	if ($war_circuit == 1)
	{
	    $war_circuit--;
	    if($tS_prevu == $semaine_4 || $tS_prevu == $semaine_3){
		
		echo '<td style="background-color:#DBD23A"><center>' . $tS_circuit . '</center></td>';
	    }else{
	        $war_circuit--;
		echo '<td style="background-color:#CC3E54"><center>' . $tS_circuit . '</center></td>';
	    }
	}
	else
	{
		echo '<td><center>' . $tS_circuit . '</center></td>';
	}

	echo '   		<td width="150"><center>' . $tS_commentaire . '</center></td>
	<td><center>';
	 
	if($tS_operateur == 'ORANGE WHOLESALE' || $tS_operateur == 'GIRONDE NUMERIQUE' || $tS_operateur == 'GIRONDE HAUT DEBIT' || $tS_operateur == 'GERS NUMERIQUE' ){
	    $recuperation_orange_state = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$tSF' AND `keyname` = 'state' ");
        $recuperation_orange_comment = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$tSF' AND `keyname` = 'ClientComment' ");
        
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
	
	
	echo '
	</center></td>
	
		<td><center>';
	
	if($tS_operateur == 'ORANGE WHOLESALE' || $tS_operateur == 'GIRONDE NUMERIQUE' || $tS_operateur == 'GIRONDE HAUT DEBIT' || $tS_operateur == 'GERS NUMERIQUE' ){

        $recuperation_orange_comment = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$tSF' AND `keyname` = 'ClientComment' ");
        $orange_comment = $recuperation_orange_comment->fetch(PDO::FETCH_ASSOC); 
	     $commentaire_orange = explode ("//",$orange_comment['value']);
   
    echo $commentaire_orange[0];
	}elseif($tS_operateur == 'Natira' || $tS_operateur == 'FullSave'){
	    echo $tS['suivi_natira_commentaire'];
	}
	
	
	echo '
	</center></td>
	<td><center>' . $tS_ticket . '</center></td>
	                
	                <form method="post" action="mes_d.php">

	                
	                <td>

	                 <input type="hidden" value="' . $tS_si . '" name ="mes_direct"/>
							
                		<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                		</form>
                		
                </tr></center>
 	';
}
echo '</table><br/>';


require('../includes/foot.php');
?>