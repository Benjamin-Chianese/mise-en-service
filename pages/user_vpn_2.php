<?php
require('../includes/head.php'); 
require ('../vendor/autoload.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail ($from, $to, $object, $data) {

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = gethostbyname('smtp');
    $mail->Port = '25';
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = false;
    $mail->setFrom($from, 'Support Fullsave');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $object;
    $mail->Body    = $data;
    $mail->addAttachment('../includes/templates/installation_openvpn_gui_v1.pdf');

    $mail->send();
    echo '<center>Mail envoyé à '.$to.'<br/></center>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

#Ouvrir session curl


$login =  json_encode(array('login'=>'smes','password'=>'ObEOEX26teY8enngskgDg2K5') );

$c = curl_init('https://api.fullsave.io/login');

curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($c, CURLOPT_POST,1);
curl_setopt($c, CURLOPT_POSTFIELDS, $login );
curl_setopt( $c, CURLOPT_HEADER, 0);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);

$output = curl_exec($c);
if($output === false)
{
	trigger_error('Erreur curl : '.curl_error($c),E_USER_WARNING);
}
/*Si tout c'est bien passé on affiche le contenu de la requête*/
else
{   
    $json_output = json_decode($output,true);
	$token = $json_output['token']['id'];
}



# Fonction envoi SMS
function send_sms($numero,$mdp,$token_send) {

$token = 'Authorization: token '.$token_send;

$sms =  json_encode(array('to'=> $numero,'message'=>'FullSave - Voici votre mot de passe VPN : '.$mdp) );

$s = curl_init('https://api.fullsave.io/sms/v1/sms');

curl_setopt($s, CURLOPT_HTTPHEADER, array('Content-Type: application/json',$token));
curl_setopt($s, CURLOPT_POST,1);
curl_setopt($s, CURLOPT_POSTFIELDS, $sms );
curl_setopt($s, CURLOPT_HEADER, 0);
curl_setopt($s, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($s, CURLOPT_SSL_VERIFYPEER, 0);

$output_s = curl_exec($s);
if($output_s === false)
{
	trigger_error('Erreur curl : '.curl_error($s),E_USER_WARNING);
}
/*Si tout c'est bien passé on affiche le contenu de la requête*/
else{
    echo '<center>SMS envoyé à '.$numero.'<br/></center>';
}
    
}

# Fonction fermer session curl
function close_curl($token) {

$token = 'Authorization: token '.$token;
$l = curl_init('https://api.fullsave.io/logout');

curl_setopt($l, CURLOPT_HTTPHEADER, array('Content-Type: application/json',$token));
curl_setopt($l, CURLOPT_POST,1);
curl_setopt($l, CURLOPT_HEADER, 0);
curl_setopt($l, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($l, CURLOPT_SSL_VERIFYPEER, 0);

$output_l = curl_exec($l);
if($output_l === false)
{
	trigger_error('Erreur curl : '.curl_error($l),E_USER_WARNING);
}

}




 if(!empty($_POST['login_mail_1']) && !empty($_POST['mdp_mail_1']) && !empty($_POST['addr_mail_1']) && !empty($_POST['client_vpn_1']) && !empty($_POST['nbr_mail'])){
	        
	        
	         for ($i = 1; $i <= $_POST['nbr_mail']; $i++) {

	             
	             $numero_envoi = substr($_POST['tel_mail_'.$i], 1);
	              $numero = '0033'.$numero_envoi;
	              
	              $mdp = $_POST['mdp_mail_'.$i];
	             
	          $addr = $_POST['addr_mail_'.$i];
	          $subject = 'FullSave - Accès à votre compte VPN';
	          $mail_template = "
	          Bonjour, <br/><br/>
	          Dans le cadre de la mise en service de votre accès VPN nomade, vous trouverez ci-dessous les instructions liées à son utilisation.<br/>
	          La documentation d'installation de l'application OpenVPN est jointe à cet e-mail, celle-ci vous détaille les étapes d’installation pas à pas.<br/>
              Veuillez prendre en compte le lien suivant vous permettant de télécharger l'application OpenVPN valable 30 jours: <br/>
	          ".$_POST['client_vpn_'.$i]."<br/><br/>
	          Merci de tenir compte du fait que cet exécutable contient vos certificat de sécurité et qu'il est par conséquent personnel.<br/><br/>
	          Vous pourrez vous connecter à votre VPN avec votre identifiant : ".$_POST['login_mail_'.$i]."<br/>
	          Votre mot de passe vous sera communiqué par SMS<br/><br/>
              En vous remerciant pour votre confiance, nous restons disponibles au support pour toute information complémentaire..<br/>
	          ";
            
            $mail_template .='<br />Cordialement.
<hr style="height: 1px; background-color: #465661; width: 100%; border: none; margin-top:20px;">
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<a href="https://www.fullsave.com" title="Site web FullSave" style="text-decoration: none;">
			<img src="https://www.fullsave.com/sites/default/files/pictures/fullsave-2019.png" alt="FullSave" style="border: none;"/>
			</a>
		</td>
		<td style="padding-top: 3px;">
			<span style="font-family: Helvetica; font-size: 11pt; color: #09A4D9;"><strong>Support Fullsave</span><br />
			<span style="font-family: Helvetica; font-size: 10pt; color: #465661; line-height: 1.6;">
				<a href="mailto:support@fullsave.com" style="color: #465661; text-decoration: underline;">support@fullsave.com</a><br />
				05 62 24 34 18 (support) <br />
				40 rue du village d\'entreprises - 31670 Lab&egrave;ge - France<br />
				<a href="https://www.fullsave.com" style="color: #09A4D9; text-decoration: none;">www.fullsave.com</a> //
				<a href="https://www.facebook.com/leballonfullsave" style="color: #09A4D9; text-decoration: none;">facebook.com/leballonfullsave</a> //
				<a href="https://twitter.com/fullsave" style="color: #09A4D9; text-decoration: none;">@fullsave</a>
			</span>
		</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" style="width: 520px;">
	<tr>
		<td style="text-align: justify">
			<span style="font-family: Helvetica; font-size: 9pt; color: #465661; line-height: 1.4;">Ce message contient des informations confidentielles. 
			Si vous n\'êtes pas le destinataire désigné, nous vous remercions de bien vouloir nous en aviser immédiatement et de détruire ce message, sans faire un quelconque usage de son contenu,
			ni le communiquer ou le diffuser, ni en prendre aucune copie, électronique ou non. La sécurité des envois de messages électroniques ne peut être assurée.
			L\'expéditeur ne saurait être tenu pour responsable des erreurs ou omissions qui résulteraient d\'un envoi par message électronique.<br /></span>
		</td>
	</tr>
</table>';	          
	         sendEmail('support@fullsave.com',$addr,$subject,$mail_template);
             send_sms($numero,$mdp,$token);
             
	          } 
	          close_curl($token);

   

	          
	   ?>


<?php
	 exit;         
	      }
	      
	      
	      ################### Fin Traitemement $choix NAT premiere partie #########################
       
	     
