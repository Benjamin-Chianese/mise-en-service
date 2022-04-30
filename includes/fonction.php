<?php 


        
	    $array_pe = array(

    array(
        'pe' => 'tls00-1-mx',
        'pe_port' => 'xe-0/0/0',
        'asr_port' => 'tls00-1-asr920:Te0/0/24' ,
        
    ),
    array(
        'pe' => 'tls00-2-mx',
        'pe_port' => 'xe-0/0/0',
        'asr_port' => 'tls00-2-asr920:Te0/0/24' ,
    ),
    array(
        'pe' => 'tls00-1-7k',
        'pe_port' => 'Gi0/1',
        'asr_port' => 'tls00-1-asr920:Gi0/0/18' ,
    ),
    array(
        'pe' => 'tls00-2-7k',
        'pe_port' => 'Gi0/1',
        'asr_port' => 'tls00-1-asr920:Gi0/0/17' ,
    ),
    array(
        'pe' => 'tls00-3-7k',
        'pe_port' => 'Gi0/1',
        'asr_port' => 'tls00-1-asr920:Gi0/0/19' ,
    ),
    array(
        'pe' => 'tls00-4-7k',
        'pe_port' => 'Gi0/2',
        'asr_port' => 'tls00-4-asr920:Gi0/0/23' ,
    ),
    array(
        'pe' => 'tls01-1-7k',
        'pe_port' => 'Gi0/1',
        'asr_port' => 'tls00-1-asr920:Gi0/0/17' ,
    ),
    array(
        'pe' => 'lbg01-2-7k',
        'pe_port' => 'Gi0/1',
        'asr_port' => 'lbg01-1-m36:Gi0/24' ,
    ),
    array(
        'pe' => 'lbg01-2-mx',
        'pe_port' => 'xe-0/0/0',
        'asr_port' => 'lbg01-1-asr920:Te0/0/24' ,
    ),
);


$pe_port = array_column($array_pe, 'pe_port', 'pe');
$pe_asr_port = array_column($array_pe, 'asr_port', 'pe');

 $array_asr = array(
    ## tls00
    array(
        'asr' => 'tls00-1-asr920',
        'asr_ip' => '172.31.0.6',
    ),
    array(
        'asr' => 'tls00-2-asr920',
        'asr_ip' => '172.31.0.12',
    ),
    array(
        'asr' => 'tls00-3-asr920',
        'asr_ip' => '172.31.0.13',
    ),
    array(
        'asr' => 'tls00-4-asr920',
        'asr_ip' => '172.31.0.14',
    ),
    array(
        'asr' => 'tls00-5-asr920',
        'asr_ip' => '172.31.0.16',
    ),
    array(
        'asr' => 'tls00-6-asr920',
        'asr_ip' => '172.31.0.11',
    ),
     array(
        'asr' => 'tls00-7-asr920',
        'asr_ip' => '172.31.0.10',
    ),
    ## lbg01
    array(
        'asr' => 'lbg01-1-asr920',
        'asr_ip' => '172.31.0.19',
    ),
    array(
        'asr' => 'lbg01-2-asr920',
        'asr_ip' => '172.31.0.21',
    ),
    array(
        'asr' => 'lbg01-3-asr920',
        'asr_ip' => '172.31.0.24',
    ),
    array(
        'asr' => 'lbg01-1-m36',
        'asr_ip' => '172.31.0.1',
    ),
    array(
        'asr' => 'lbg01-2-m36',
        'asr_ip' => '172.31.0.9',
    ),
    ## tls05
    array(
        'asr' => 'tls05-1-asr920',
        'asr_ip' => '172.31.0.5',
    ),
    array(
        'asr' => 'tls05-2-asr920',
        'asr_ip' => '172.31.0.7',
    ),
    array(
        'asr' => 'tls05-3-asr920',
        'asr_ip' => '172.31.0.15',
    ),
    array(
        'asr' => 'tls05-4-asr920',
        'asr_ip' => '172.31.0.17',
    ),
    ## tls02
    array(
        'asr' => 'tls02-1-asr920',
        'asr_ip' => '172.31.0.2',
    ),
    ## tls01
    array(
        'asr' => 'tls01-1-m36',
        'asr_ip' => '172.31.0.3',
    ),
    ## tls06
    array(
        'asr' => 'tls06-1-asr920',
        'asr_ip' => '172.31.0.20',
    ),
    array(
        'asr' => 'tls06-2-asr920',
        'asr_ip' => '172.31.0.18',
    ),
    ## mur01
    array(
        'asr' => 'mur01-1-asr920',
        'asr_ip' => '172.31.0.23',
    ),
    ## col01
    array(
        'asr' => 'col01-1-asr920',
        'asr_ip' => '172.31.0.25',
    ),
    ## blm01
    array(
        'asr' => 'blm01-1-asr920',
        'asr_ip' => '172.31.0.4',
    ),
    array(
        'asr' => 'blm01-2-asr920',
        'asr_ip' => '172.31.0.22',
    ),
    array(
        'asr' => 'blm01-3-asr920',
        'asr_ip' => '172.31.0.26',
    ),
);


$ip_asr = array_column($array_asr, 'asr_ip', 'asr');




$array_m49 = array(

    array(
        'm49' => 'blm01-1-m49',
        'm49_port' => 'Po1',
        'asr_port' => 'blm01-1-asr920:Po2' ,
        
    ),
    array(
        'm49' => 'lbg01-1-m49',
        'm49_port' => 'Po1',
        'asr_port' => 'lbg01-1-m36:Po1' ,
        
    ),
    array(
        'm49' => 'sgd02-1-m49',
        'm49_port' => 'Gi1/27',
        'asr_port' => 'tls00-2-asr920:Gi0/0/20' ,
        
    ),
    array(
        'm49' => 'tls00-1-m49',
        'm49_port' => 'Po1',
        'asr_port' => 'tls00-1-asr920:Po10' ,
        
    ),
    array(
        'm49' => 'tls02-1-m49',
        'm49_port' => 'Po1',
        'asr_port' => 'tls02-1-asr920:Po1' ,
        
    ),
    
    );
    
    $m49_port = array_column($array_m49, 'm49_port', 'm49');
$m49_asr_port = array_column($array_m49, 'asr_port', 'm49');


	    $array_mask = array(

    array(
        'slash' => 31,
        'netmask' => '255.255.255.254',
        'Wildcard' => '0.0.0.1' ,
    ),
    array(
        'slash' => 30,
        'netmask' => '255.255.255.252',
        'Wildcard' => '0.0.0.3' ,
    ),
    array(
        'slash' => 29,
        'netmask' => '255.255.255.248',
        'Wildcard' => '0.0.0.7' ,
    ),
    array(
        'slash' => 28,
        'netmask' => '255.255.255.240',
        'Wildcard' => '0.0.0.15' ,
    ),
    array(
        'slash' => 27,
        'netmask' => '255.255.255.224',
        'Wildcard' => '0.0.0.31' ,
    ),
    array(
        'slash' => 26,
        'netmask' => '255.255.255.192',
        'Wildcard' => '0.0.0.63' ,
    ),
    array(
        'slash' => 25,
        'netmask' => '255.255.255.128',
        'Wildcard' => '0.0.0.127' ,
    ),
    array(
        'slash' => 24,
        'netmask' => '255.255.255.0',
        'Wildcard' => '0.0.0.255' ,
    ),
    array(
        'slash' => 23,
        'netmask' => '255.255.254.0',
        'Wildcard' => '0.0.1.255' ,
    ),
    array(
        'slash' => 22,
        'netmask' => '255.255.252.0',
        'Wildcard' => '0.0.3.255' ,
    ),
    array(
        'slash' => 21,
        'netmask' => '255.255.248.0',
        'Wildcard' => '0.0.7.255' ,
    ),
    array(
        'slash' => 20,
        'netmask' => '255.255.240.0',
        'Wildcard' => '0.0.15.255' ,
    ),
    array(
        'slash' => 19,
        'netmask' => '255.255.224.0',
        'Wildcard' => '0.0.31.255' ,
    ),
    array(
        'slash' => 18,
        'netmask' => '255.255.192.0',
        'Wildcard' => '0.0.63.255' ,
    ),
    array(
        'slash' => 17,
        'netmask' => '255.255.128.0',
        'Wildcard' => '0.0.127.255' ,
    ),
    array(
        'slash' => 16,
        'netmask' => '255.255.0.0',
        'Wildcard' => '0.0.255.255' ,
    ),
);

$slash_netmask = array_column($array_mask, 'slash', 'netmask');
$slash_wildcard = array_column($array_mask, 'slash', 'Wildcard');
$netmask_slash = array_column($array_mask, 'netmask', 'slash');
$netmask_wildcard = array_column($array_mask, 'netmask', 'Wildcard');
$wildcard_slash = array_column($array_mask, 'Wildcard', 'slash');
$wildcard_netmask = array_column($array_mask, 'Wildcard', 'netmask');


function reste_routeur ($bdd){
 
  
  ## Requete RT

$username = "snetworkapi";
$password = "tooyeix8euxuek5gaghepahf0auGiewi";
$remote_url = 'https://racktables.fullsave.org/fullsave/v2/supportedhw/';

//Initiate cURL.
$ch = curl_init($remote_url);
 
//Specify the username and password using the CURLOPT_USERPWD option.
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  

//Tell cURL to return the output as a string instead
//of dumping it to the browser.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Execute the cURL request.
$response = curl_exec($ch);
 
//Check for errors.
if(curl_errno($ch)){
    //If an error occured, throw an Exception.
    throw new Exception(curl_error($ch));
}

$mondict = json_decode($response,TRUE);

$stock_srx= $mondict['Router']['Huawei AR651']['stock'];
$stock_rad = $mondict['Access']['RAD ETX-203AX-CONSP/GE30/2SFP/4UTP']['stock'];
$stock_rad_205 = $mondict['Access']['RAD ETX-205AX']['stock'];
$stock_rad_10g = $mondict['Access']['RAD ETX-2I-10G-B/ACACI/4SFPP/8S']['stock'];
    


    $compte = $bdd->query("SELECT *
	FROM `network_account` 
	WHERE `fs_service_delivery` IS NULL
	AND  `resiliation` IS NULL
	AND `contact_name` IS NOT NULL 
	AND `contact_tel` IS NOT NULL 
	AND `service_type` IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP')
	ORDER BY id DESC");


$rad = 0;
$rad_conf = 0;

$rad_205 = 0;
$rad_205_conf = 0;

$rad_10g = 0;
$rad_10g_conf = 0;

$srx = 0;
$srx_conf = 0;

$count_natira = 0;
$count_orange = 0;
$count_autre = 0;

$count_natira_mois = 0;
$count_orange_mois = 0;
$count_autre_mois = 0;

$count_natira_mois_1 = 0;
$count_orange_mois_1 = 0;
$count_autre_mois_1 = 0;

$count_natira_annee = 0;
$count_orange_annee = 0;
$count_autre_annee = 0;

while ($nbRouteurs = $compte->fetch(PDO::FETCH_ASSOC))
{
    $nbRouteur_id = $nbRouteurs['id'];
    $nbRouteur_service = $nbRouteurs['service_type'];
	$nbRoutuer_techno = $nbRouteurs['media'];
	$nbRouteur_debit = $nbRouteurs['bandwidth'];
	$nbRouteur_operateur = $nbRouteurs['supplier'];
    $nbRouteur_service = $nbRouteurs['service_type'];
    
	$compte_vision = $bdd->query("SELECT * FROM network_vision WHERE si_id = '$nbRouteur_id' ");
	$nbCR = $compte_vision->fetch(PDO::FETCH_ASSOC);
	$nbC_location = $nbCR['location'];
	


	if ($nbRouteur_service == 'Lan2Lan' OR $nbRouteur_service == 'Collecte Ethernet' OR $nbRouteur_service == 'Transit IP')
	{
		
			if ($nbRouteur_debit <= 1000000 ){
                if (!empty($nbC_location) && $nbC_location != 'NOK')
                {
                            $rad_conf++;
                }$rad++;
            }		
			elseif ($nbRouteur_debit > 1000000)
			{
				if (!empty($nbC_location) && $nbC_location != 'NOK')
				{
					$rad_10g_conf++;
				}
                $rad_10g++;
					
				
			}
	}
	else
	{
				if (!empty($nbC_location) && $nbC_location != 'NOK')
				{
					$srx_conf++;
				}
                $srx++;
          

		}
		
		
	

		
		
		if($nbRouteur_operateur == 'ORANGE WHOLESALE' || $nbRouteur_operateur == 'GIRONDE NUMERIQUE' 
		|| $nbRouteur_operateur == 'GIRONDE HAUT DEBIT' || $nbRouteur_operateur == 'GERS NUMERIQUE'){
    			$count_orange++;
    					
    					
		    }elseif($nbRouteur_operateur == 'Natira'){
		       $count_natira++;
    					
    					
		    }else{
		        $count_autre++;
    					
		    }
}





$date_count_mois = date('Y-m-');
	  $compte_mois = $bdd->query("SELECT *
	FROM `network_account` 
	WHERE `fs_service_delivery` LIKE '%".$date_count_mois."%'
	AND  `resiliation` IS NULL
	AND `service_type` IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP')
	ORDER BY id DESC");



while ($r = $compte_mois->fetch(PDO::FETCH_ASSOC)){
   
    
    if($r['supplier'] == 'ORANGE WHOLESALE' || $r['supplier'] == 'GIRONDE NUMERIQUE' 
		|| $r['supplier'] == 'GIRONDE HAUT DEBIT' || $r['supplier'] == 'GERS NUMERIQUE'){
    			
    					$count_orange_mois++;
    					
		    }elseif($r['supplier'] == 'Natira'){
		       
    					$count_natira_mois++;
    					
		    }else{
		       
    					$count_autre_mois++;
		    }
}

$date_count_mois_1 =  date( "Y-m-", strtotime( " -1 month" ) );

	  $compte_mois_1 = $bdd->query("SELECT *
	FROM `network_account` 
	WHERE `fs_service_delivery` LIKE '%".$date_count_mois_1."%'
	AND  `resiliation` IS NULL
	AND `service_type` IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP')
	ORDER BY id DESC");



while ($r_1 = $compte_mois_1->fetch(PDO::FETCH_ASSOC)){
   
    
    if($r_1['supplier'] == 'ORANGE WHOLESALE' || $r_1['supplier'] == 'GIRONDE NUMERIQUE' 
		|| $r_1['supplier'] == 'GIRONDE HAUT DEBIT' || $r_1['supplier'] == 'GERS NUMERIQUE'){
    			
    					$count_orange_mois_1++;
    					
		    }elseif($r_1['supplier'] == 'Natira'){
		       
    					$count_natira_mois_1++;
    					
		    }else{
		       
    					$count_autre_mois_1++;
		    }
}


$date_count_annee = date('Y');
	  $compte_annee = $bdd->query("SELECT *
	FROM `network_account` 
	WHERE `fs_service_delivery` LIKE '%".$date_count_annee."%'
	AND  `resiliation` IS NULL
	AND `service_type` IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP')
	ORDER BY id DESC");



while ($t = $compte_annee->fetch(PDO::FETCH_ASSOC)){
   
    
    if($t['supplier'] == 'ORANGE WHOLESALE' || $t['supplier'] == 'GIRONDE NUMERIQUE' 
		|| $t['supplier'] == 'GIRONDE HAUT DEBIT' || $t['supplier'] == 'GERS NUMERIQUE'){
    			
    					$count_orange_annee++;
    					
		    }elseif($t['supplier'] == 'Natira'){
		       
    					$count_natira_annee++;
    					
		    }else{
		       
    					$count_autre_annee++;
		    }
}

$rad_reste = $rad - $rad_conf ;
$rad_10g_reste = $rad_10g - $rad_10g_conf ;
$srx_reste = $srx - $srx_conf ;
$count_total = $count_autre + $count_orange + $count_natira;
$count_mois_total = $count_autre_mois + $count_orange_mois + $count_natira_mois;
$count_mois_1_total = $count_autre_mois_1 + $count_orange_mois_1 + $count_natira_mois_1;
$count_annee_total = $count_autre_annee + $count_orange_annee + $count_natira_annee;

echo '
<center>

<table border="1">
        	<tr>
			<td><center>CPE :</center></td>
			<td><center>RAD 203</center></td>
            <td><center>RAD 205</center></td>
			<td><center>Huawei</center></td>
            <td><center>RAD 10G</center></td>

			<td><center>Lien :</center></td>
			<td><center>Natira</center></td>
			<td><center>Orange</center></td>
			<td><center>Autres</center></td>
			<td><center>Total</center></td>
		</tr>
		<tr>
			<td><center>Total : </center></td>
			<td><center>' . $rad . '</center></td>
            <td><center>NA</center></td>
			<td><center>' . $srx . '</center></td>
            <td><center>' . $rad_10g . '</center></td>
			<td><center>En cours : </center></td>
			<td><center>' .$count_natira. '</center></td>
			<td><center>' .$count_orange. '</center></td>
			<td><center>' .$count_autre. '</center></td>
			<td><center>' .$count_total. '</center></td>
		</tr>
		<tr>
			<td><center>Configuré : </center></td>
			<td><center>' . $rad_conf . '</center></td>
            <td><center>NA</center></td>
			<td><center>' . $srx_conf . '</center></td>
            <td><center>' . $rad_10g_conf . '</center></td>
			<td><center>Livré mois en cours : </center></td>
			<td><center>' .$count_natira_mois. '</center></td>
			<td><center>' .$count_orange_mois. '</center></td>
			<td><center>' .$count_autre_mois. '</center></td>
			<td><center>' .$count_mois_total. '</center></td>
		</tr>
		<tr>
			<td><center>Reste à faire : </center></td>
			<td><center>' . $rad_reste . '</center></td>
            <td><center>NA</center></td>
			<td><center>' . $srx_reste . '</center></td>
            <td><center>' . $rad_10g_reste . '</center></td>
            <td><center>Livré mois dernier : </center></td>
			<td><center>' .$count_natira_mois_1. '</center></td>
			<td><center>' .$count_orange_mois_1. '</center></td>
			<td><center>' .$count_autre_mois_1. '</center></td>
			<td><center>' .$count_mois_1_total. '</center></td>
		</tr>
		<tr>
			<td><center>Stock RT : </center></td>';
			
			    if($rad_reste >= $stock_rad|| $stock_rad <= 15 ){
			
		echo '	<td style="background-color:#CC3E54"><center>'.$stock_rad.'</center></td> ';
			    }else {
			        echo '	<td><center>'.$stock_rad.'</center></td> ';
			    }if( $stock_rad_205 <= 5 ){
			
		echo '	<td style="background-color:#CC3E54"><center>'.$stock_rad_205.'</center></td> ';
			    }else {
			        echo '	<td><center>'.$stock_rad_205.'</center></td> ';
			    }
	        	if($srx_reste >= $stock_srx || $stock_srx <= 15){
			
		echo '	<td style="background-color:#CC3E54"><center>'.$stock_srx.'</center></td> ';
			    }else {
			        echo '	<td><center>'.$stock_srx.'</center></td> ';
			    }
                if($rad_10g_reste >= $stock_rad_10g || $stock_rad_10g <= 10){
			
		echo '	<td style="background-color:#CC3E54"><center>'.$stock_rad_10g.'</center></td> ';
			    }else {
			        echo '	<td><center>'.$stock_rad_10g.'</center></td> ';
			    }
			
echo'		
            <td><center>Livré année en cours : </center></td>
			<td><center>' .$count_natira_annee. '</center></td>
			<td><center>' .$count_orange_annee. '</center></td>
			<td><center>' .$count_autre_annee. '</center></td>
			<td><center>' .$count_annee_total. '</center></td>
			</tr>

</table></center>
<br/>';


}


function  relance ($eqts,$name,$mail,$adresse,$fslnk,$link,$operateur,$si_id){
    
$count =  count($eqts);

$content = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$si_id);


preg_match_all('/\<li><label>Cisco (.*?)\</', $content , $modele);
preg_match_all('/\<\/a> - (.*?) \(\<a/', $content , $serial);
preg_match_all("/target='_blank'\>fs(.*?)\</", $content , $ref);

    
$message = "
<center>
    <table border='1'>
        <tr>
            <td>@Mail : </td>
            <td>".$mail."</td>
        </tr>
        <tr>
            <td>Objet : </td>
            <td>Fullsave - Résiliation de votre lien - ".$fslnk." - ".$name." </td>
        <tr>
            <td>Mail : </td>
            <td>
Bonjour,<br/><br/>

Nous vous confirmons la bonne réception et la prise en compte de votre demande de résiliation.<br/>

Cette résiliation concerne le site avec la référence ".$fslnk.", situé au ".$adresse."<br/><br/>

Conformément aux engagements contractuels la résiliation de ces services implique la restitution du matériel installé dans vos locaux pour assurer le service :<br/><br/>";

for($i = 0; $i < $count; $i++) {
    
    if(!empty($modele[1][$i]) || !empty($serial[1][$i])){
    
     $message.= 'Cisco '.$modele[1][$i].' - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
    }
}

if(!empty($link)){
    $message.= '<br/>Equipement '.$operateur.' - Référence : '.$link;
}

$message.= "<br/><br/>Nous vous proposons de déposer ce matériel à nos locaux de Labège à l'adresse suivante 40 Rue du Village d'Entreprises, 31670 Labège ou ceux de Toulouse à  l'adresse suivante 131C chemin du sang de serp, 31200 Toulouse.<br/>
Si cela vous était impossible, un bon de retour vous sera envoyé afin de confier cela à un transporteur.<br/><br/>

Cordialement,
            </td>
        </tr>
    </table>
</center>
<br/><br/>";


echo $message;
}










function port_collect ($bdd,$operateur,$site,$entre,$porte){
    
   if(!empty($entre)){
       
	                    $entre_explode_visu = explode(':',$entre);
	                $entre_min_visu = strtolower($entre_explode_visu[0]);
	                $entre_maj_visu = ucfirst(strtolower($entre_explode_visu[1]));
       
   }
      	
if($operateur == 'Natira' || $operateur == 'FullSave'){
    switch ($site) {
    
                     case 'TLS00':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="tls00-1-asr920">tls00-1-asr920</option>
                            <option value="tls00-2-asr920">tls00-2-asr920</option>
                            <option value="tls00-3-asr920">tls00-3-asr920</option>
                            <option value="tls00-4-asr920">tls00-4-asr920</option>
                            <option value="tls00-5-asr920">tls00-5-asr920</option>
                            <option value="tls00-6-asr920">tls00-6-asr920</option>
                            <option value="tls00-1-m49">tls00-1-m49</option>
                		</optgroup>
                		</select>
                		
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                 <optgroup label="M49">'; 
                         for ($i = 0; $i <= 28; $i++) {
                	$select_entree .='	<option value="Gi1/'.$i.'">Gi1/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                		</select>
';
                        break;
                        
                    case 'TLS01':
                        $select_entree = '<select name="entre_collecte" class="form-control" >
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="tls01-1-m36">tls01-1-m36</option>
                            <option value="tls01-2-c35">tls01-2-c35</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="m36">'; 
                         for ($i = 0; $i <= 24; $i++) {
                	$select_entree .='	<option value="Gi0/'.$i.'">Gi0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                 <optgroup label="c35">'; 
                         for ($i = 0; $i <= 52; $i++) {
                	$select_entree .='	<option value="Gi0/'.$i.'">Gi0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                		</select>
';
                        break;
                        
                    case 'TLS02':
                        $select_entree = '<select name="entre_collecte" class="form-control" >
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="tls02-1-asr920">tls02-1-asr920</option>
                            <option value="tls02-1-m49">tls02-1-m49</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                 <optgroup label="M49">'; 
                         for ($i = 0; $i <= 28; $i++) {
                	$select_entree .='	<option value="Gi1/'.$i.'">Gi1/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                		</select>
';
                        break;
                        
                    case 'TLS05':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="tls05-1-asr920">tls05-1-asr920</option>
                            <option value="tls05-2-asr920">tls05-2-asr920</option>
                            <option value="tls05-3-asr920">tls05-3-asr920</option>
                            <option value="tls05-4-asr920">tls05-4-asr920</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control" >
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                        
                    case 'TLS06':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="TLS06-1-asr920">TLS06-1-asr920</option>
                            <option value="TLS06-2-asr920">TLS06-2-asr920</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                		<optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                        
                    case 'LBG01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="lbg01-1-asr920">lbg01-1-asr920</option>
                            <option value="lbg01-2-asr920">lbg01-2-asr920</option>
                            <option value="lbg01-3-asr920">lbg01-3-asr920</option>
                            <option value="lbg01-1-m36">lbg01-1-m36</option>
                            <option value="lbg01-2-m36">lbg01-2-m36</option>
                            <option value="lbg01-1-m49">lbg01-1-m49</option>
                            <option value="lbg01-2-c35">lbg01-2-c35</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control" >
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                       <optgroup label="c35">'; 
                         for ($i = 0; $i <= 52; $i++) {
                	$select_entree .='	<option value="Gi0/'.$i.'">Gi0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                 <optgroup label="M49">'; 
                         for ($i = 0; $i <= 28; $i++) {
                	$select_entree .='	<option value="Gi1/'.$i.'">Gi1/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                <optgroup label="m36">'; 
                         for ($i = 0; $i <= 24; $i++) {
                	$select_entree .='	<option value="Gi0/'.$i.'">Gi0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                		</select>
';
                        break;
                        
                     case 'BLM01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="blm01-1-asr920">blm01-1-asr920</option>
                            <option value="blm01-2-asr920">blm01-2-asr920</option>
                            <option value="blm01-1-m49">blm01-1-m49</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control" >
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                 <optgroup label="M49">'; 
                         for ($i = 0; $i <= 28; $i++) {
                	$select_entree .='	<option value="Gi1/'.$i.'">Gi1/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                		</select>
';
                        break;
                        
                    case 'LIJ01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="lij01-1-asr920">lij01-1-asr920</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control" >
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                		<optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                        
                    case 'LBZ01':
                        $select_entree = '<select name="entre_collecte" class="form-control" >
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="lbz01-1-asr920">lbz01-1-asr920</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                		<optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                        
                    case 'MUR01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="mur01-1-asr920">mur01-1-asr920</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                		<optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                    
                    case 'SGD02':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$site.'"> 
                            <option value="sgd02-1-c35">sgd02-1-c35</option>
                            <option value="sgd02-1-m49">sgd02-1-m49</option>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                       <optgroup label="c35">'; 
                         for ($i = 0; $i <= 52; $i++) {
                	$select_entree .='	<option value="Gi0/'.$i.'">Gi0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                 <optgroup label="M49">'; 
                         for ($i = 0; $i <= 28; $i++) {
                	$select_entree .='	<option value="Gi1/'.$i.'">Gi1/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                		</select>
';
                        break;
                        
                        
                        
                        
                        default:
       $select_entree = '<input  type="text" class="form-control" name="entre" value="' . $entre . '" />';
}

}else{
    
           if($operateur == 'ORANGE WHOLESALE'){
        if ($porte == 'CELAN'){
        $select_entree = '<input  type="text" class="form-control" name="entre" value="tls01-1-m36:Po1" />';
        }elseif ($porte == 'DSLE') {
		     $select_entree = '<input  type="text" class="form-control" name="entre" value="lbg01-1-m36:Gi0/4" />';
        }else {
		     $select_entree = '<input  type="text" class="form-control" name="entre" value="tls01-1-m36:Po1" />';
        }
    }else{
    $supplier_req = $bdd->query("SELECT `collecte` FROM `network_account` WHERE `service_type` = 'Porte de collecte' AND `supplier` = '".$operateur."'");
	             $w = $supplier_req->fetch(PDO::FETCH_ASSOC);
	           $entre = $w['collecte'];  
	       $select_entree = '<input  type="text" class="form-control" name="entre" value="' . $entre . '" />';
    }

    

}

}





function hasPermission($ldap_group)
{
    $groups = [];
    foreach (explode(" ", $_SERVER['HTTP_X_REMOTE_GROUP']) as $group) {
        array_push($groups, explode("=", explode(",", $group)[0])[1]);
    }
    if (in_array($ldap_group, $groups)) {
        return True;
    } else {
        Return False;
    }
}

function valideChaine($chaineNonValide)
    {
      $chaineNonValide = preg_replace('`\s+`', ' ', trim($chaineNonValide));
      $chaineNonValide = str_replace("'", " ", $chaineNonValide);
      $chaineNonValide = str_replace(",", " ", $chaineNonValide);
      $chaineNonValide = preg_replace("`_+`", ' ', trim($chaineNonValide));
      $chaineValide=strtr($chaineNonValide,
"ÀÁÂàÄÅàáâàäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏ" .
"ìíîïÙÚÛÜùúûüÿÑñ",
"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
    echo $chaineValide;
      return ($chaineValide);
    }
    

?>
