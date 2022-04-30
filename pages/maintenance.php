<?php
require ('../includes/head.php');
require ('../vendor/autoload.php');



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

## Mise en place du SMTP



################# Fonction ####################


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
 

##################### End Fonction #############


if(!empty($_POST['maint_id']) ){
            
            echo "<center><table border='1'>
            <tr>
                 <td><center>Downtime maintenance ".$_POST['maint_id']."</center></td>
            </tr>
            <tr>
                <td>";
            
            $maintenance_fshmon = $bdd->query("SELECT * from `maintenance` WHERE id = '".$_POST['maint_id']."' ");
             while ( $a = $maintenance_fshmon->fetch(PDO::FETCH_ASSOC))    {
                $explode_fslnk = explode(',',$a['affected_services']) ;
                $temps = $a['duration'] *60;
                    foreach ($explode_fslnk as &$fslnk) {
                        $fsn_fshmon = $bdd->query("SELECT * FROM network_account WHERE service_ref LIKE '".$fslnk."' ");
                            while ( $b = $fsn_fshmon->fetch(PDO::FETCH_ASSOC))    {
                                if($b['support'] == '24/7' || $b['vip'] == 1){ 
                                    if(substr_count($b['eqts'], ',') > 0){
                                    $explode_fsn = explode(',',$b['eqts']) ;
                                        foreach ($explode_fsn as &$fsn) {
                    echo 'echo -e "COMMAND [$(date +%s)] SCHEDULE_HOST_DOWNTIME;'.$fsn.';'.strtotime($a['begin']).';'.strtotime($a['end']).';1;0;'.$temps.';Prevenance;'.$a['id'].'" | nc localhost 50000</br>';
                                        }
                                    }else{
                    echo 'echo -e "COMMAND [$(date +%s)] SCHEDULE_HOST_DOWNTIME;'.$b['eqts'].';'.strtotime($a['begin']).';'.strtotime($a['end']).';1;0;'.$temps.';Prevenance;'.$a['id'].'" | nc localhost 50000</br>';
                                    }
                                }
                            }
                    }
             }
        echo "</td></tr></table></center><br/><br/>";
        }



if(!empty($_POST['id']) && !empty($_POST['service'])){



$recup_maintenance = $bdd->query("SELECT * FROM maintenance WHERE id = ".$_POST['id']."");
        $y = $recup_maintenance->fetch(PDO::FETCH_ASSOC);

# Formatage du array client 

	    $fs = explode(',',$_POST['service']);
	    
# Creation de la requete SQL

$recup = $bdd->query("SELECT * FROM network_account 
WHERE service_ref IN ('".implode("','",$fs)."') ;");


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
    
$message_template = "Bonjour,<br/><br/>

Nous vous informons qu'une opération de maintenance est annulée sur votre réseau.<br/><br/>

Voici les détails de l'opération annulée :<br/><br/>

Type : Travail programmé<br/>
Nature : Intervention physique sur la liaison <br/>
Cause : ".$y['cause']."<br/>
Début : ".date('d-m-Y H:i:s',strtotime($y['begin']))." (CET +01h00)<br/>
Fin: ".date('d-m-Y H:i:s',strtotime($y['end']))." (CET +01h00)<br/>
Durée prévisionnelle de l'intervention : ".$y['duration']." minutes<br/>
Impact : ".$y['impact']."<br/><br/>


Services affectés: <br/>
".$service."
<br/><br/>
Nous vous prions de bien vouloir nous excuser de la gêne occasionné et restons à votre disposition pour tout renseignement complémentaire.
<br/><br/>
Cordialement,
<br/><br/>
Le Support FullSave.<br/>
--<br/>
FullSave SAS<br/>
Hotel des Telecoms, 40 rue du village des entreprises, F31670 Labège<br/>
Tel: +33 (0)5 62 24 34 18 - Email: support@fullsave.com<br/>
Web: http://www.fullsave.com<br/>";

	$subject = '[FullSave] Annulation : Maintenance planifiée '.$y['id'].' Impact : '.$y['impact'];

	
#### envoi du mail
	
	if(sendEmail ('prevenance@fullsave.com', $addr, $subject,$message_template)){

	}
	


}
    $req_annulation = $bdd->query("UPDATE `maintenance` SET `canceled` = '1' WHERE `id` = ".$_POST['id']."");


if($y['provider'] == 'FullSave' || $y['provider'] == 'Natira'){
    
    $explode_fslnk = explode(',',$affected_insert) ;

 foreach ($explode_fslnk as &$fslnk_c) {
      $fsn_fshmon_c = $bdd->query("SELECT * FROM network_account WHERE service_ref LIKE '".$fslnk_c."' ");
    
 }     
    $message_template_maintenance = "Bonjour,<br/><br/>

Une intervention est annulée sur le réseau.<br/><br/>

Voici les détails de l'opération annulée :<br/><br/>
Cause : ".$y['cause']."<br/>
Début : ".date('d-m-Y H:i:s',strtotime($y['begin']))." (CET +01h00)<br/>
Fin: ".date('d-m-Y H:i:s',strtotime($y['end']))." (CET +01h00)<br/>
Durée prévisionnelle de l'intervention : ".$y['duration']." minutes<br/>
Impact : ".$y['impact']."<br/><br/>
Services affectés: <br/>";
  while ( $c = $fsn_fshmon_c->fetch(PDO::FETCH_ASSOC))    {
          $message_template_maintenance .= $fslnk_c .' - '.$c['name'].'<br/>'; 
      }
 $message_template_maintenance .= "<br/><br/>

 
Cordialement,
<br/><br/>
Le Support FullSave.<br/>
--<br/>
FullSave SAS<br/>
Hotel des Telecoms, 40 rue du village des entreprises, F31670 Labège<br/>
Tel: +33 (0)5 62 24 34 18 - Email: support@fullsave.com<br/>
Web: http://www.fullsave.com<br/>";
    $subject_maintenance = 'Maintenance planifiée '.$y['id'].' Impact : '.$y['impact'];
   sendEmail ('prevenance@fullsave.com', 'maintenance@fullsave.com', $subject_maintenance,$message_template_maintenance);

}



}


$date = date('Y-m-d H:i:s');


$maintenance = $bdd->query("SELECT * from `maintenance` WHERE `end` >= '".$date."' AND `canceled` = 0");

echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>ID</td>
                <td>Début</td>
                <td>Fin</td>
                <td>Durée</td>
                <td>Supplier</td>
                <td>Cause</td>
                <td>Impact</td>
                <td>Service impacté</td>
                <td>Annuler</td>
            </tr>
        </thead>';


 while ( $r = $maintenance->fetch(PDO::FETCH_ASSOC))    {
     
     
     $ex_fsn = explode(',',$r['affected_services']) ;


        $fsn = $bdd->query("SELECT * FROM network_account WHERE service_ref  IN ('".implode("','",$ex_fsn)."') ");


      echo ' <tr>';
       if($r['canceled'] == 0){
           echo '<td>'.$r['id'].'</td>';
       }else{
           echo '<td>'.$r['id'].' (Annulé)</td>';
       }


       echo '         <td>'.date('d-m-Y H:i', strtotime($r['begin'])).'</td>
                <td>'.date('d-m-Y H:i', strtotime($r['end'])).'</td>
                <td>'.$r['duration'].' min</td>
                <td>'.$r['provider'].'</td>
                <td>'.$r['cause'].'</td>
                <td>'.$r['impact'].'</td>
                <td>';

                 while ( $y = $fsn->fetch(PDO::FETCH_ASSOC))    {

                     if(!empty($y['service_tag_natira'])){
                     echo $y['service_ref'].' - <strong>'.$y['service_tag_natira'].'</strong> - '.$y['name'].'<br/>';
                     }else{

                     echo $y['service_ref'].' - '.$y['name'].'<br/>';
                     }

                 }
                
                echo '</td>
                <td><center>';
                if($r['canceled'] == 0){
           echo '<form method="post" action="maintenance.php">
                <input type="hidden" value="'.$r['id'].'" name ="id"/>
                 <input type="hidden" value="'.$r['affected_services'].'" name ="service"/>
                <button type="submit" class="btn btn-outline-danger btn-sm mb-2">Annuler</button><br/>
                </form>';
       }
echo '
                <form method="post" action="maintenance.php">
                <input type="hidden" value="'.$r['id'].'" name ="maint_id"/>
                <button type="submit" class="btn btn-outline-primary btn-sm mb-2">Downtime</button>
                </form>
            </center></td>
            </tr>
        ';
        
 }
echo '</table>';



require('../includes/foot.php');
?>
