<?php
require('../includes/head.php'); 
require ('../vendor/autoload.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

## Mise en place du SMTP



################# Fonction ####################
function trim_value(&$value)
{
	$value = trim($value);
}

function sendEmail ($from, $to, $object, $data) {

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = gethostbyname('smtp');
    $mail->Port = '25';
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = false;
    $mail->setFrom($from, 'Prevenance FullSave');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $object;
    $mail->Body    = $data;

    $mail->send();
    echo '<center>Mail envoyé à '.$to.'<br/></center>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

function verifEmail ($email) {
    if (filter_var ($email, FILTER_VALIDATE_EMAIL) === false) {
        return false;
    } else {
        return true;
    }
}
 function  checkUp($Listmessages,$ListUnmanaged, $mntID, $mntBEGIN, $mntEND, $mntDURATION){
	echo "<center><br/>";
	echo "<br/>";
	echo "--------------- Maintenance ----------------<br/><br/>";
	echo "ID: $mntID<br/>";
	echo "Begin: ".date('d-m-Y H:i:s',strtotime($mntBEGIN))."<br/>";
	echo "End: ".date('d-m-Y H:i:s',strtotime($mntEND))."<br/>";
	echo "Duration: $mntDURATION<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "--------------- Messages to be Sent ----------------<br/><br/>";
	foreach($Listmessages as $m => $c){
		echo "$m<br/>";
		foreach($c['services'] as $s){
			echo " $s<br/>";
		}
	}
	echo "<br/>";
	echo "<br/>";
	echo "---------------- Links Unmanaged ----------------<br/>";
	echo "<br/>";
	foreach($ListUnmanaged as $service){
		echo " * ".$service['service_ref']."<br/>";
	}
	echo "<br/></center>";
}



##################### End Fonction #############

######################

# Traitement formulaire deuxieme page 

######################
if (!empty($_POST['impact'])){
    
# Récupretation variable du POST

	    $impact = $_POST['impact'];
	    
	    $coupure = $_POST['coupure'];
	    $cause = $_POST['cause'];
	    $provider = $_POST['provider'];
	    $begin_date = $_POST['begin_date'];
	    $begin_time = $_POST['begin_time'];
	    $end_date = $_POST['end_date'];
	    $end_time = $_POST['end_time'];
	    $duration = $_POST['duree'];
	    $type = $_POST['type'];
	    

	    
# Formatage du tableau pour la requete

	    $clients =array();
	    $fs = array();
	    for ($i = 1; $i <= $impact; $i++) {
	        if(!empty($_POST['client'.$i])){
            $clients[$i] = $_POST['client'.$i]; }
	    }
	    for ($i = 1; $i <= $impact; $i++) {
	        if(!empty($_POST['fs'.$i])){
	        $fs[$i] = $_POST['fs'.$i]; }
	    }

# Suppression des espaces avant et apres les donné du array 

	    array_walk($clients, 'trim_value');
	    array_walk($fs, 'trim_value');

# Formatage DATE

	    $begin_construct = $begin_date.' '.$begin_time;
        $end_construct = $end_date.' '.$end_time;
    
	    $INTER_BEGIN = date('Y-m-d H:i:s',strtotime($begin_construct));
	    $requete_begin = date('Y-m-d',strtotime($INTER_BEGIN));
        $INTER_END = date('Y-m-d H:i:s',strtotime($end_construct));
	    $INTER_DURATION = $duration.' min';
	    $inter_num_construct = date('Ymd',strtotime($begin_date));

############# Test si ID existe dans la table de maintenance #######################

# Test de l'ancienne version 
 
                //Test if a such maintenance already exists	    
$test_maintenance = $bdd->query("SELECT COUNT(*) AS inter_count FROM maintenance WHERE `id` LIKE '".$inter_num_construct."%' ");
 
 $checks_count = $test_maintenance->fetch();


# Test si l'id existe Rajout de 1 à l'ID 

if ($checks_count['inter_count'] >= 1 ) {
    
    $inter_num = $checks_count['inter_count'] +1;
    $INTER_NUM = $inter_num_construct.''.$inter_num;
 }else{
     $INTER_NUM = $inter_num_construct.'1';
 }   
 
 ##################### Fin test table de maintenance
 
 #################### 
 # Test si la date de fin est inferieur a la date de commencement
#####################

	    if($INTER_END < $INTER_BEGIN){
	        
# Formulaire déja completer 
	        
echo '	 <div class="mx-auto" style="width: 600px;">
<center>
    <h2>End of maintenance must be before the begin ! </h2>
        <form method="post" action="voip.php">
    <table>
        <tr>
            <td>Début intervention :</td>
            <td><input  type="date" class="form-control" name="begin_date" value="'.$begin_date.'" required /></td>
            <td><input  type="time"  class="form-control" name="begin_time" value="'.$begin_time.'" required/></td>
        </tr>
        <tr>
            <td>Fin intervention :</td>
            <td><input  type="date" class="form-control" name="end_date" value="'.$end_date.'" required  /></td>
            <td><input  type="time"  class="form-control" name="end_time" value="'.$end_time.'" required/></td>
        </tr>
    </table>
        <br/><br/>
    <table>
        <tr>
            <td>Durée impact (min) :</td>
            <td><input  type="num" class="form-control" name="duree" value="'.$duration.'" required  /></td>
        </tr>
        <tr>
            <td>Type de maintenance  :</td>
            <td><select name="type" class="form-control">
                <option value="Programmé">Programmé</option>
                <option value="Urgente">Urgente</option>
                </select></td>
        </tr>
    </table>
    <br/><br/>
    
    <table>
        <tr>
            <td>Opérateur</td>
            <td>Cause</td>
            <td>Impact</td>
        </tr>
        <tr>
        
            <td><select name="provider" class="form-control">
                <option value="SEWAN">SEWAN</option>
                <option value="Natira">Natira</option>
                </select>
            </td>
            <td><input  type="text" class="form-control" name="cause" value="'.$cause.'"  /></td>
            <td><select name="coupure" class="form-control">
                <option value="'.$coupure.'">'.$coupure.'</option>
                <option value="Risque de coupure momentanée des services">Risque de coupure momentanée des services</option>
                <option value="Informatif">Informatif</option>
                <option value="Coupure franche">Coupure franche</option>
            </select>
            </td>
        </tr>
    </table>
    
    <br/><br/>
    
    <table border="1">
        <tr>
            <td><center>Autre</center></td>
            <td><center>Fullsave</center></td>
        </tr>

        ';
    for ($i = 1; $i <= $impact; $i++) {
        echo '
        <tr>
            <td><center><input  type="text" class="form-control" name="client'.$i.'" value="'.$clients[$i].'"  /></center></td>
            <td><center><input  type="text" class="form-control" name="fs'.$i.'" value="'.$fs[$i].'" /></center></td>
        </tr>   ' ;
}  
    echo '   
</table> <br/>
        <input type="hidden" value="'.$impact.'" name ="impact"/>
        <center><button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button></center>
        
        </form>

    </center></div>
    ';
    
    exit;
	        
	    }
### Fin Test si la date de fin est inferieur a la date de commencement	        


### Creation de la requete	   
	   
$add_link_number_cond = ''; 
	    if(is_array($clients) && count($clients) > 0 && $clients[1] != "" )
{
	$add_link_number_cond = " linknumber IN ('".implode("','",$clients)."')";
	//$add_link_number_cond ="linknumber LIKE '%00%' AND supplier ='ORANGE WHOLESALE' ";
}
$add_service_ref_cond = '';
if(is_array($fs) && count($fs) > 0 && $fs[1] != "")
{
	$add_service_ref_cond = " service_ref IN ('".implode("','",$fs)."')";
}

$query_cond = '';
if($add_link_number_cond != '' && $add_service_ref_cond != ''){
	$query_cond = "(".$add_link_number_cond." OR ".$add_service_ref_cond.")";
}
elseif($add_link_number_cond != '') $query_cond = $add_link_number_cond;
elseif($add_service_ref_cond != '') $query_cond = $add_service_ref_cond;


$recup = $bdd->query("SELECT * FROM network_account 
WHERE ".$query_cond."  AND fs_service_delivery IS NOT NULL AND fs_service_delivery <= '". $requete_begin."' 
AND (resiliation IS NULL OR resiliation >=  '".$requete_begin."') ;");




//SELECT LINKS AND CONTACTS

$messages = array();
$unmanaged = array();
$linkcount = 0;
$affected = array();


  for ($i=0; $row = $recup->fetch(PDO::FETCH_ASSOC); $i++) {
	array_push($affected,$row['service_ref']);
	//test if contact email is undefined
	if(trim($row['contact_mail']) == '' || $row['contact_mail'] === null){
		$unmanaged[] = $row;
	}
	else {
		//test multiple address case
		$eaddresses = explode(',', $row['contact_mail']);
		//simple email
		if(count($eaddresses) == 0)
			$eaddresses[] = $row['contact_mail'];

		foreach($eaddresses as $mail){
			$mail = strtolower(trim($mail));
			if(verifEmail(trim($mail)))
			    if(empty($row['linknumber'])){
			      $messages[$mail]['services'][] = '* '.$row['service_ref'].' - '.$row['name'].' - '.$row['service_type'].' - ' .$row['adresse'].' '.$row['cp'].' '.$row['localite'];  
			    }else{
			         $messages[$mail]['services'][] = '* '.$row['service_ref'].' - '.$row['name'].' - '.$row['service_type'].' - '.$row['linknumber'].' - ' .$row['adresse'].' '.$row['cp'].' '.$row['localite']; 
			    }
					
			else
				$unmanaged[] = $row;
		}
		
	}
	
	$linkcount++;
  }

$msgcount = count($messages);
$msgcount2 = count($unmanaged);

#### Affichage 3 eme pages

checkUp($messages,$unmanaged,$INTER_NUM,$INTER_BEGIN,$INTER_END,$INTER_DURATION);
echo "<center>We are about to send ".$msgcount." emails (".$msgcount2." unmanaged), for ".$linkcount." network links</center>";


#### Envoi en caché toute les variable necessaire pour l'envoi ou la modification du formulaire 

echo '<div class="mx-auto" style="width: 600px;">
<center>
<form method="post" action="voip.php">

<input type="hidden" value="'.$impact.'" name ="M_impact"/>
<input type="hidden" value="'.$coupure.'" name ="M_coupure"/>
<input type="hidden" value="'.$cause.'" name ="M_cause"/>
<input type="hidden" value="'.$provider.'" name ="M_provider"/>
<input type="hidden" value="'.$begin_date.'" name ="M_begin_date"/>
<input type="hidden" value="'.$begin_time.'" name ="M_begin_time"/>
<input type="hidden" value="'.$end_date.'" name ="M_end_date"/>
<input type="hidden" value="'.$end_time.'" name ="M_end_time"/>
<input type="hidden" value="'.$duration.'" name ="M_duration"/>
<input type="hidden" value="'.$type.'" name ="M_type"/>
';

for ($i = 1; $i <= $impact; $i++) {
	        if(!empty($_POST['client'.$i])){
      echo'      <input type="hidden" value="'.$_POST['client'.$i].'" name ="M_client_'.$i.'"/>'; }
	    }
for ($i = 1; $i <= $impact; $i++) {
	        if(!empty($_POST['fs'.$i])){
      echo'      <input type="hidden" value="'.$_POST['fs'.$i].'" name ="M_fs_'.$i.'"/>'; }
	    }

echo '<br/>
<button type="submit"  name="envoyer" value="envoyer" class="btn btn-outline-success btn-sm mb-2">Envoyer</button> || <button type="submit" name="modifier" value="modifier" class="btn btn-outline-warning btn-sm mb-2">Modifer</button>
</form>


</center></div>';

exit;
}


######################

# Modification de la prevenance  

######################
if (!empty($_POST['modifier'])){
    

    echo '<div class="mx-auto" style="width: 600px;">
    <center>
        <form method="post" action="voip.php">
    <table>
        <tr>
            <td>Début intervention :</td>
            <td><input  type="date" class="form-control" name="begin_date" value="'.$_POST['M_begin_date'].'" required /></td>
            <td><input  type="time"  class="form-control" name="begin_time" value="'.$_POST['M_begin_time'].'" required/></td>
        </tr>
        <tr>
            <td>Fin intervention :</td>
            <td><input  type="date" class="form-control" name="end_date" value="'.$_POST['M_end_date'].'" required  /></td>
            <td><input  type="time"  class="form-control" name="end_time" value="'.$_POST['M_end_time'].'" required/></td>
        </tr>
    </table>
        <br/><br/>
    <table>
        <tr>
            <td>Durée impact (min) :</td>
            <td><input  type="num" class="form-control" name="duree" value="'.$_POST['M_duration'].'" required  /></td>
        </tr>
         <tr>
            <td>Type de maintenance  :</td>
            <td><select name="type" class="form-control">
                <option value="Programmé">Programmé</option>
                <option value="Urgente">Urgente</option>
                </select></td>
        </tr>
    </table>
    <br/><br/>
    
     <table>
        <tr>
            <td>Opérateur</td>
            <td>Cause</td>
            <td>Impact</td>
        </tr>
        <tr>
        
            <td><select name="provider" class="form-control">
                <option value="SEWAN">SEWAN</option>
                </select>
            </td>
            <td><input  type="text" class="form-control" name="cause" value="'.$_POST['M_cause'].'"  /></td>
            <td><select name="coupure" class="form-control">
                <option value="'.$_POST['M_coupure'].'">'.$_POST['M_coupure'].'</option>
                <option value="Risque de coupure momentanée des services">Risque de coupure momentanée des services</option>
                <option value="Informatif">Informatif</option>
                <option value="Coupure franche">Coupure franche</option>
            </select>
            </td>
        </tr>
    </table>
    
    <br/><br/>
    
    <table border="1">
        <tr>
            <td><center>Autre</center></td>
            <td><center>Fullsave</center></td>
        </tr>

        ';
    for ($i = 1; $i <= $_POST['M_impact']; $i++) {
        echo '
        <tr>
            <td><center><input  type="text" class="form-control" name="client'.$i.'" value="'.$_POST['M_client_'.$i].'"  /></center></td>
            <td><center><input  type="text" class="form-control" name="fs'.$i.'" value="'.$_POST['M_fs_'.$i].'" /></center></td>
        </tr>   ' ;
}  
    echo '   
</table> <br/>
        <input type="hidden" value="'.$_POST['M_impact'].'" name ="impact"/>
        <button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button></center>
        
        </form>

    </center></div>
    ';
    

    
    exit;
    
}

######################

# Fin de la modification de la prevenance  

######################

######################

# Envoi de la prevenance 

######################
if (!empty($_POST['envoyer'])){
    
    
# Recupereation des variable en POST    

	    $impact = $_POST['M_impact'];
	    
	    $coupure = $_POST['M_coupure'];
	    $cause = $_POST['M_cause'];
	    $provider = $_POST['M_provider'];
	    $begin_date = $_POST['M_begin_date'];
	    $begin_time = $_POST['M_begin_time'];
	    $end_date = $_POST['M_end_date'];
	    $end_time = $_POST['M_end_time'];
	    $duration = $_POST['M_duration'];
	    $type = $_POST['M_type'];
	    

	    
	    
	    $begin_construct = $begin_date.' '.$begin_time;
        $end_construct = $end_date.' '.$end_time;
    
	    $INTER_BEGIN = date('Y-m-d H:i:s',strtotime($begin_construct));
	    $requete_begin = date('Y-m-d',strtotime($INTER_BEGIN));
        $INTER_END = date('Y-m-d H:i:s',strtotime($end_construct));
	    $INTER_DURATION = $duration.' min';
	 	$inter_num_construct = date('Ymd',strtotime($begin_date));

# creation de l'ID ez maintenance 
                //Test if a such maintenance already exists	    
$test_maintenance = $bdd->query("SELECT COUNT(*) AS inter_count FROM maintenance WHERE `id` LIKE '".$inter_num_construct."%' ");
 
 $checks_count = $test_maintenance->fetch();

if ($checks_count['inter_count'] >= 1 ) {
    
    $inter_num = $checks_count['inter_count'] +1;
    $INTER_NUM = $inter_num_construct.''.$inter_num;
 }else{
     $INTER_NUM = $inter_num_construct.'1';
 }   	    


# Formatage du array client 

	    $clients =array();
	    $fs = array();
	    for ($i = 1; $i <= $impact; $i++) {
	        if(!empty($_POST['M_client_'.$i])){
            $clients[] = $_POST['M_client_'.$i]; }
	    }
	    for ($i = 1; $i <= $impact; $i++) {
	        if(!empty($_POST['M_fs_'.$i])){
	        $fs[] = $_POST['M_fs_'.$i]; }
	    }
	    array_walk($clients, 'trim_value');
	    array_walk($fs, 'trim_value');
	    
# Creation de la requete SQL
	   
$add_link_number_cond = ''; 
	    if(is_array($clients) && count($clients) > 0 && $clients[0] != "" )
{
	$add_link_number_cond = " linknumber IN ('".implode("','",$clients)."')";
	//$add_link_number_cond ="linknumber LIKE '%00%' AND supplier ='ORANGE WHOLESALE' ";
}
$add_service_ref_cond = '';
if(is_array($fs) && count($fs) > 0 && $fs[0] != "")
{
	$add_service_ref_cond = " service_ref IN ('".implode("','",$fs)."')";
}

$query_cond = '';
if($add_link_number_cond != '' && $add_service_ref_cond != ''){
	$query_cond = "(".$add_link_number_cond." OR ".$add_service_ref_cond.")";
}
elseif($add_link_number_cond != '') $query_cond = $add_link_number_cond;
elseif($add_service_ref_cond != '') $query_cond = $add_service_ref_cond;


$recup = $bdd->query("SELECT * FROM network_account 
WHERE ".$query_cond."  AND fs_service_delivery IS NOT NULL AND fs_service_delivery <= '". $requete_begin."' 
AND (resiliation IS NULL OR resiliation >=  '".$requete_begin."') ;");


//SELECT LINKS AND CONTACTS

$messages = array();
$unmanaged = array();
$linkcount = 0;
$affected = array();


  for ($i=0; $row = $recup->fetch(PDO::FETCH_ASSOC); $i++) {
	array_push($affected,$row['service_ref']);
	//test if contact email is undefined
	if(trim($row['contact_mail']) == '' || $row['contact_mail'] === null){
		$unmanaged[] = $row;
	}
	else {
		//test multiple address case
		$eaddresses = explode(',', $row['contact_mail']);
		//simple email
		if(count($eaddresses) == 0)
			$eaddresses[] = $row['contact_mail'];

		foreach($eaddresses as $mail){
			$mail = strtolower(trim($mail));
			if(verifEmail(trim($mail)))
			    if(empty($row['linknumber'])){
			      $messages[$mail]['services'][] = '* '.$row['service_ref'].' - '.$row['name'].' - '.$row['service_type'].' - ' .$row['adresse'].' '.$row['cp'].' '.$row['localite'];  
			    }else{
			         $messages[$mail]['services'][] = '* '.$row['service_ref'].' - '.$row['name'].' - '.$row['service_type'].' - '.$row['linknumber'].' - ' .$row['adresse'].' '.$row['cp'].' '.$row['localite']; 
			    }
					
			else
				$unmanaged[] = $row;
		}
		
	}
	
	$linkcount++;
  }
  
$msgcount = count($messages);
$msgcount2 = count($unmanaged);

$affected_insert =implode(',',$affected);

# Ajout dans la base maintenance 



		$requete = $bdd->prepare("INSERT INTO maintenance (id,begin,end,duration,provider,cause,affected_services,impact) 
		VALUES(:id, :begin, :end, :duration, :provider, :cause, :affected, :impact)");
		$requete->execute(array(
	        "id" => $INTER_NUM,
			"begin" => $INTER_BEGIN,
			"end" => $INTER_END,
			"duration" => $duration,
			"provider" => $provider,
			"cause" => $cause,
			"affected" => $affected_insert,
			"impact" => $coupure

		));



$date_debut = date('d-m-Y H:i:s',strtotime($INTER_BEGIN));
$date_fin = date('d-m-Y H:i:s',strtotime($INTER_END));


# preparation de l'envoi du mail client

foreach($messages as $addr => $mess){
    
    $count_services = count($mess['services']);
    

    if($count_services >1){
        $count_service = $count_services -1;

        $service = $mess['services'][0];
        
        for ($i = 1; $i <= $count_service; $i++) {
	       
            $service .= '<br/>'.$mess['services'][$i];

	    }
        
    }else{
       $service = $mess['services'][0]; 
    }


# Remplissage du template mail 
    
$message_template = "Bonjour,<br/><br/>";

if($type == 'Urgente'){
    $message_template .= "Nous vous informons qu'une opération de maintenance est programmée sur votre service de téléphonie.<br/><br/>";
    	$subject = '[FullSave] Maintenance urgente '.$INTER_NUM.' Impact : '.$_POST['M_coupure'];
}else{
    $message_template .= "Nous vous informons qu'une opération de maintenance est programmée sur votre service de téléphonie.<br/><br/>";
    	$subject = '[FullSave] Maintenance planifiée '.$INTER_NUM.' Impact : '.$_POST['M_coupure'];
}



$message_template .= "Voici les détails de l'opération :<br/><br/>

Type : Maintenance ".$type."<br/>
Nature : Maintenance du cluster téléphonique <br/>
Cause : ".$cause."<br/>
Début : ".$date_debut." (CET +01h00)<br/>
Fin: ".$date_fin." (CET +01h00)<br/>
Durée prévisionnelle de coupure : ".$_POST['M_duration']." minutes<br/>
Impact : ".$_POST['M_coupure']."<br/><br/>
Services affectés: <br/>
Téléphonie Fixe
<br/><br/>
Nous vous prions de bien vouloir nous excuser de la gêne occasionnée et restons à votre disposition pour tout renseignement complémentaire.
<br/><br/>
Cordialement,
<br/><br/>
Le Support FullSave.<br/>
--<br/>
FullSave SAS<br/>
Hotel des Telecoms, 40 rue du village des entreprises, F31670 Labège<br/>
Tel: +33 (0)5 62 24 34 18 - Email: support@fullsave.com<br/>
Web: http://www.fullsave.com<br/>";


	# echo $message_template; 
	
#### envoi du mail
	
	if(sendEmail ('prevenance@fullsave.com', $addr, $subject,$message_template)){

	}
	
	echo '<center>'.$service.'</center><br/>';
	

}
echo '<center><br/>Numéro de la maintenance : '.$INTER_NUM.' fin de l\'intervention '.$date_fin.'<br/></center>';
echo '<br/><br/>';
      
##### Fin de l'envoi du mail     

}


######################

# Deuxieme page pour formulaire pour la prevenance 

######################

if (!empty($_POST['nombre_impact'])){
    $nombre_impact = $_POST['nombre_impact'];

    
    
    echo '<div class="mx-auto" style="width: 600px;">
    <center>
        <form method="post" action="voip.php">
    <table>
        <tr>
            <td>Début intervention :</td>
            <td><input  type="date" class="form-control" name="begin_date" value="'.$begin_date.'" required /></td>
            <td><input  type="time"  class="form-control" name="begin_time" value="'.$begin_time.'" required/></td>
        </tr>
        <tr>
            <td>Fin intervention :</td>
            <td><input  type="date" class="form-control" name="end_date" value="'.$end_date.'" required  /></td>
            <td><input  type="time"  class="form-control" name="end_time" value="'.$end_time.'" required/></td>
        </tr>
    </table>
        <br/><br/>
    <table>
        <tr>
            <td>Durée impact (min) :</td>
            <td><input  type="num" class="form-control" name="duree" value="'.$duration.'" required  /></td>
        </tr>
        <tr>
            <td>Type de maintenance  :</td>
            <td><select name="type" class="form-control">
                <option value="Programmé">Programmé</option>
                <option value="urgente">urgente</option>
                </select></td>
        </tr>
    </table>
    <br/><br/>
    <table>
        <tr>
            <td>Opérateur</td>
            <td>Cause</td>
            <td>Impact</td>
        </tr>
        <tr>
        
            <td><select name="provider" class="form-control">
                <option value="SEWAN">SEWAN</option>
                 <option value="Natira">Natira</option>
                </select>
            </td>
            <td><input  type="text" class="form-control" name="cause" value="'.$cause.'"  /></td>
            <td><select name="coupure" class="form-control">
                <option value="'.$coupure.'">'.$coupure.'</option>
                <option value="Risque de coupure momentanée des services">Risque de coupure momentanée des services</option>
                <option value="Informatif">Informatif</option>
                <option value="Coupure franche">Coupure franche</option>
            </select>
            </td>
        </tr>
    </table>
    
    <br/><br/>
    
    <table border="1">
        <tr>
            <td><center>Autre</center></td>
            <td><center>Fullsave</center></td>
        </tr>

        ';
    for ($i = 1; $i <= $nombre_impact; $i++) {
        echo '
        <tr>
            <td><center><input  type="text" class="form-control" name="client'.$i.'"  /></center></td>
            <td><center><input  type="text" class="form-control" name="fs'.$i.'"  /></center></td>
        </tr>   ' ;
}  
    echo '   
</table> <br/>
        <input type="hidden" value="'.$nombre_impact.'" name ="impact"/>
        <center><button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button></center>
        
        </form>

    </center></div>
    ';
    
    
    exit;
}

######################

# Premiere page pour le nombre de client impacté

######################
echo '
<div class="mx-auto" style="width: 400px;"><center>

<form  method="post" action="voip.php">

Nombre de client impacté :
        <input  type="text" id="nombre_impact" class="form-control" name="nombre_impact"  /><br/>

        <button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button>
</form>
</div></center>

';


require('../includes/foot.php'); 
?>
