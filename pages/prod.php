<?php
require ('../includes/head.php');

$year = date('Y');
$year_1 = date('Y',strtotime($year.'+1 YEAR'));

if(!empty($_POST['mois']) && !empty($_POST['annee'])){
// Tri dans la base si_plugin
        if($_POST['mois'] <= 9){
            $mois = '0'.$_POST['mois'];
        }else{
            $mois = $_POST['mois'];
        }
        $mois_trait = $_POST['mois'];
        $annee = $_POST['annee'];
}else{
    $mois_trait = date('n');
    if($mois_trait <= 9){
            $mois = '0'.$mois_trait;
        }else{
            $mois = $mois_trait;
        }
    
    $annee = date('Y');
}

$form_1 = '
<div class="mx-auto" style="width: 400px;"><center>
<form  method="post"  action="prod.php">';
       $form_1 .= 'Mois :  <select name="mois" class="form-control">
                    <option value="'.$mois_trait.'">'.$mois_trait.'</option>';
         for ($i = 1; $i <= 12; $i++) {           
  $form_1 .= '   <option value="'.$i.'">'.$i.'</option>';
         }
         $form_1 .= '
         </select>
         Année :  <select name="annee" class="form-control">
                    <option value="'.$annee.'">'.$annee.'</option>';
         for ($y = 2019; $y <= $year_1; $y++) {           
             $form_1 .= '   <option value="'.$y.'">'.$y.'</option>';
         }
   $form_1 .= '     </select><br/>

        <button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button>
</form>
</div></center>

';





echo $form_1;

$date = $annee.'-'.$mois.'%';


$mes = $bdd->query("SELECT *
	FROM `network_vision` 
	WHERE `mes` LIKE '".$date."'
	
	ORDER BY mes DESC");


// Tableau

$tableau = '
    <thead class="thead-dark">
		<tr>
			<td><center>Client</center></td>
			<td><center>FSLNK</center></td>
            <td><center>Contact</center></td>
            <td><center>Tel</center></td>
			<td><center>Type</center></td>
			<td><center>Supplier</center></td>
			<td><center>FSC</center></td>
			<td><center>Equipement</center></td>
			<td><center>IP</center></td>
			<td><center>Point d\'entrée</center></td>
            <td><center>PE</center></td>
			<td><center>MES</center></td>
			<td><center>Ticket</center></td>
			<td><center>PV</center></td>
		</tr>
		</thead>
';


echo '	<center><table class="table table-bordered table-striped">
        '. $tableau;

// variable pour les titres des colonnes

$j = 0;

while ($r = $mes->fetch(PDO::FETCH_ASSOC))
{




	// Variable table visu

	$id = $r['si_id'];
	$Vmes = $r['mes'];
	$Umes = date("d/m/Y", strtotime($Vmes));
	
	$ticket = $r['ticket'];

	// Rajout des donnÃ© en dynamique des info de la base visu

	$ru_vision = $bdd->query("SELECT * FROM network_account WHERE id = '$id' ");
	$w = $ru_vision->fetch(PDO::FETCH_ASSOC);

	// Variable de la base si_plugin

	$service = $w['service_type'];
	$vlan = $w['vlan'];
	$pe = $w['pe'];
	$contact = $w['contact_name'];
	$tel = $w['contact_tel'];
	$mail = $w['contact_mail'];
	$equi = $w['eqts'];
    $entre = $w['collecte'];
	$operateur = $w['supplier'];
	if($w['support'] == '24/7'){
	    $gtr = 'GTR 4h - Etendue 24h/24 et 7j/7';
	}else{
	    $gtr = 'GTR 4H heures ouvrées';
	}
	$debit_format = substr($w['bandwidth'], 0, -3);
	if($debit_format <= 100){
	    $debit = $debit_format.' Mb/s';
	}else{
	   $debit_1g =  substr($w['bandwidth'], 0, -6);
	   $debit = $debit_1g.' Gb/s';
	}
	
	        $adresse_false = $w['adresse'].' '.$w['cp'].' '.$w['localite'];
	        $adresse =str_replace(",", "",$adresse_false);
	        


	$content = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$id);


preg_match_all('/\IP<\/label><span>(.*?)\</', $content , $ip);
preg_match_all('/\<\/a> - (.*?) \(<a href/', $content , $sn);


preg_match_all('/\<li><label>Cisco (.*?)\</', $content , $modele);
$cpe = 'Cisco '.$modele[1][0];

preg_match_all("/class='(.*?)' target='_blank'>Graphes/", $content , $red);



	// ajout des titres des colonnes toute les 15 lignes

	if ($j == 15)
	{
		$j = 0;
		echo $tableau;
	}
	else
	{
		$j++;
	}



	echo '		
                        <tr>
                        <td><center>' . $w['name'] . '</center></td>
                        <td><center>' . $w['service_ref'] . '</center></td>
                        <td><center>' . $contact . '</center></td>
                        <td><center>' . $tel . '</center></td>
                        <td><center>' . $service . '</center></td>
                        <td><center>' . $operateur . '</center></td>
                        <td><center>' . $w['customer_id'] . '</center></td>
                        <td><center>' . $equi . '</center></td>';
                if($red[1][0] == 'red'){        
                        echo '	<td style="background-color:#CC3E54"><center>'.$ip[1][0].'</center></td> ';
			    }else {
			        echo '	<td><center>'.$ip[1][0].'</center></td> ';
			    }

                        
                 echo'  
                        <td><center>' . $entre . '</center></td>
                        <td><center>' . $pe . '  </center></td>
                        <td><center>' . $Umes . '</center></td>
                        <td><center>' . $ticket . '</center></td>
                        <td><center><form method="post" action="../includes/export.php">
                        <input type="hidden" value="'.$w['name'].'" name ="client"/>
                        <input type="hidden" value="'.$w['customer_id'].'" name ="fsc"/>
                        <input type="hidden" value="'.date('d/m/Y',strtotime($w['fs_service_delivery'])).'" name ="mes"/>
                        <input type="hidden" value="'.$service.'" name ="type"/>
                        <input type="hidden" value="'.$w['service_ref'].'" name ="fslnk"/>
                        <input type="hidden" value="'.$adresse.'" name ="adresse"/>
                        <input type="hidden" value="'.$debit.'" name ="debit"/>
                        <input type="hidden" value="'.$gtr.'" name ="gtr"/>
                        <input type="hidden" value="'.$ip[1][0].'" name ="ip"/>
                        <input type="hidden" value="'.$cpe.'" name ="cpe"/>
                        <input type="hidden" value="'.$sn[1][0].'" name ="sn"/>
                        <input type="hidden" value="'.$equi.'" name ="eqts"/>
                        <input type="hidden" value="'.$vlan.'" name ="vlan"/>
                        <input type="hidden" value="'.$w['order_code'].'" name ="devis"/>
                	<button type="submit" class="btn btn-outline-success btn-sm mb-2">PV</button>
                		</form>
                    </center></td>
            </tr>';
}
echo '</table>';




require('../includes/foot.php');
?>