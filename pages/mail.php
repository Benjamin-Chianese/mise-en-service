<?php
require('../includes/head.php'); 


######## Template  formulaire #################

	  
	    
	    echo '<center><div class="mx-auto" style="width: 600px;">
	    <h3>Template Mail</h3>
	    <form method="post" action="mail.php">
	    Template :
	    <select name="template"  class="form-control">
	                            <option value="'.$_POST['template'].'">'.$_POST['template'].'</option>
                                <option value="Mise en service">Mise en service</option>
                                <option value="Prise en charge">Prise en charge</option>
                                <option value="PV FullSave">PV FullSave</option>
                                <option value="PV Marque blanche">PV Marque blanche</option>
                                <option value="Incident">Incident</option>
                        </select>
        FSLNK : 
        <input  type="text"  class="form-control" name="fslnk"  required value="'.$_POST['fslnk'].'"/><br/>
        Ticket : (Si besoin)<br/>
        <input  type="text"  class="form-control" name="ticket"  value="'.$_POST['ticket'].'"/><br/><br/>
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
        
	    </div></center>';


     
	  ################### Traitemement $choix SLA #########################
	    if (!empty($_POST['template']) && !empty($_POST['fslnk'])){
	        
	      
	        echo '<center>----------------------------</center><br/><br/>';
	        
         $template = $_POST['template'];
	        $fslnk = $_POST['fslnk'];
	        
	        ## Récuperation de l'IP admin
	        $req_ID = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk%' ");
            $w = $req_ID->fetch(PDO::FETCH_ASSOC);


                $id=$w['id'];
                $name=$w['name'];
                $service = $w['service_ref'];
                $type = $w['service_type'];
                $equipements = $w['eqts'];
                $mail = $w['contact_mail'];
                $link = $w['linknumber'];
                $operateur = $w['supplier'];
                $vlan = $w['vlan'];
                $media = $w['media'];
                $mes = date('d/m/Y',strtotime($w['fs_service_delivery']));
                $ad = htmlspecialchars($w['adresse']);
                $adsup = htmlspecialchars($w['adressesupp']);
                $cp = $w['cp'];

                $bondecommande = $w['order_code'];
                $ville = htmlspecialchars($w['localite']);
                $debit_test = substr($w['bandwidth'], 0, -3);
                if($debit_test < 1000){
                    $debit = $debit_test.' Mbps';
                }elseif($debit_test == 1000) {
                    $debit = '1 Gbps';
                }elseif($debit_test == 10000) {
                    $debit = '10 Gbps';
                }


                $ru_vision = $bdd->query("SELECT * FROM network_vision WHERE si_id = '$id' ");
	            $r = $ru_vision->fetch(PDO::FETCH_ASSOC);

                $presta = $r['natira_presta_fo'];
                $limite_mes = date('d/m/Y',strtotime($r['natira_limite_mes']));

 $adresse = $ad;
 
 if (!empty($adsup)){
     $adresse = ' '.$adsup;
 }
 
 $adresse .= ' '.$cp.' '.$ville;
 
                
                
                $eqts = explode(',', $equipements);
                $count =  count($eqts);

$content = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$id);


preg_match_all("/<li><label>(.*?)<\/label><span><a href='https:/", $content , $modele);
preg_match_all('/\<\/a> - (.*?) \(\<a/', $content , $serial);
preg_match_all("/target='_blank'\>fs(.*?)\</", $content , $ref);
preg_match_all('/\IP<\/label><span>(.*?)\</', $content , $ip);



echo '<div class="mx-auto" style="width: 1000px;">';

if($template == 'Incident'){

echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Note Sup : </td> <td>Ticket : '.$_POST['ticket'].' - Début incident '.date("d-m-Y H:i").'</td>
            </tr>
            <tr>
                <td>Mail client : </td> <td>'.$mail.'</td>
            </tr>
            <tr>
                <td>Objet : </td> <td> Fullsave - Incident '.$service.' - '.$name.'</td>
            </tr>
        </thead>
            <tr>';
            echo "<td>Mail : </td> <td>
                     Bonjour,<br/><br/>

                    Nous vous informons que le service situé au ".$adresse." est remonté comme non fonctionnel dans notre supervision.<br/><br/>

                    Seriez-vous au courant d'une raison de cette panne ?<br/><br/>

                    Nous souhaiterions que vous redémarriez les équipements suivants : <br/><br/>";
                    
                    for($i = 0; $i < $count; $i++) {
    
    if(!empty($modele[1][$i]) || !empty($serial[1][$i])){
     if(in_array('RAD ETX-203AX-CONSP/GE30/2SFP/4UTP',$modele[1]) || in_array('En place</label></li><li><label>RAD ETX-203AX-CONSP/GE30/2SFP/4UTP',$modele[1])){
           echo  'RAD ETX-203 - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
        }elseif(in_array('Huawei AR651',$modele[1]) || in_array('En place</label></li><li><label>Huawei AR651',$modele[1])){
            echo  'Huawei AR651 - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
        }elseif(in_array('Cisco C892FSP',$modele[1]) ||in_array('En place</label></li><li><label>Cisco C892FSP',$modele[1]) ){
            echo  'Cisco C892FSP - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
        }elseif(in_array('Cisco 881',$modele[1]) || in_array('En place</label></li><li><label>Cisco 881',$modele[1]) ){
            echo  'Cisco 881 - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
        }elseif(in_array('Juniper SRX 320',$modele[1]) || in_array('En place</label></li><li><label>Juniper SRX 320',$modele[1])){
            echo  'Juniper SRX 320 - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
        }elseif(in_array('RAD ETX-2I-10G-B/ACACI/4SFPP/8S',$modele[1]) || in_array('En place</label></li><li><label>RAD ETX-2I-10G-B/ACACI/4SFPP/8S',$modele[1])){
            echo  'RAD ETX-2I-10G - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
        }elseif(in_array('Cisco ME 3400G-2CS-A',$modele[1]) || in_array('En place</label></li><li><label>Cisco ME 3400G-2CS-A',$modele[1])){
            echo  'Cisco ME 3400 - SN : '.$serial[1][$i].' - Référence routeur : fs'.$ref[1][$i].'<br/>';
        }
     
    }
}

if(!empty($link) ){
    if ($operateur == 'Natira' || $operateur == 'FullSave'){
    }else{
    echo  '<br/>Equipement '.$operateur.' - Référence : '.$link.'<br/>';
    }
}
echo "            
                <br/>
                Si le service ne remonte pas merci répondre aux questions suivantes :<br/><br/>
                Le site à t-il de l'électricité ?<br/>
                Y a t-il des travaux à proximité ?<br/><br/>
                Pouvez-vous nous fournir l'état des voyants suivant : <br/><br/>";

        if(in_array('RAD ETX-203AX-CONSP/GE30/2SFP/4UTP',$modele[1]) || in_array('En place</label></li><li><label>RAD ETX-203AX-CONSP/GE30/2SFP/4UTP',$modele[1]) || in_array('RAD ETX-2I-10G-B/ACACI/4SFPP/8S',$modele[1]) || in_array('En place</label></li><li><label>RAD ETX-2I-10G-B/ACACI/4SFPP/8S',$modele[1])){
            echo 'Voyant RAD :<br/>
                PWR :<br/>
                WAN :<br/>
                ETH :<br/>';
        }elseif(in_array('Huawei AR651',$modele[1]) || in_array('En place</label></li><li><label>Huawei AR651',$modele[1])){
                echo "
                Voyant CPE :<br/>
                PWR :</br>
                SYS :</br>
                GE8 :</br>";
        }elseif(in_array('Cisco C892FSP',$modele[1]) ||in_array('En place</label></li><li><label>Cisco C892FSP',$modele[1]) ){
                echo "
                Voyant CPE :<br/>
                OK :</br>";
                if ($operateur == 'Natira' || $operateur == 'FullSave' ){
            echo 'SFP8 : </br>';
                }else{
            echo 'GE8 :</br>';}
        }elseif(in_array('Cisco 881',$modele[1]) || in_array('En place</label></li><li><label>Cisco 881',$modele[1]) ){
                echo "
                Voyant CPE :<br/>
                OK :</br>
                FE4 :</br>";
        }elseif(in_array('Juniper SRX 320',$modele[1]) || in_array('En place</label></li><li><label>Juniper SRX 320',$modele[1])){
                echo "
                Voyant CPE :<br/>
                PWR :</br>";
        if ($operateur == 'Natira' || $operateur == 'FullSave' ){
            echo '0/7 : </br>';
                }else{
            echo '0/0 :</br>';}
        }elseif(in_array('Cisco ME 3400G-2CS-A',$modele[1]) || in_array('En place</label></li><li><label>Cisco ME 3400G-2CS-A',$modele[1])){
                echo "
                Voyant CPE :<br/>
                OK :</br>
                Gi0/4 : </br>";
        }

        if ($operateur == 'Natira' || $operateur == 'FullSave'){
    }else{
    echo  '<br/>Voyant RAD :<br/>
                PWR :<br/>
                WAN :<br/>
                ETH :<br/>';
    }
  
        

echo "<br/>Cordialement
                </td>
            </tr>
        </table> ";

    }elseif($template == 'Mise en service' ){
        echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Mail : '.$mail.'</td>
            </tr>
            <tr>
                <td>Objet :  Fullsave - Mise en service '.$service.' - '.$name.'</td>
            </tr>
        </thead>
            <tr>';
            echo "<td>
                    Bonjour,<br/><br/>

Nous revenons vers vous suite à la commande référencée en objet, dont voici les modalités de livraison :<br/>

Comme demandé dans le bon de commande ".$bondecommande.", un agent Fullsave va procéder à la livraison et à l'installation de l'équipement.<br/>

Je vous envoie en pièce jointe la fiche pour le paramétrage réseau de votre nouvel accès pour le site ".$name." au ".$adresse.".<br/>

Sans retour de votre part sous une semaine, nous mettrons une configuration par défault.<br/><br/>

    Par ailleurs, nous vous rappelons qu'il est à votre charge de prévoir :<br/>
- La réservation nécessaire pour la mise en place des équipements dans un lieu adéquat (idéalement réserver 2U en baie informatique),<br/>
- La desserte interne si besoin (liaison entre l’arrivée des lignes France Telecom ou des fibres, et l’emplacement de vos équipements),<br/>
- Une alimentation électrique 220V secourue (idéalement sur un onduleur).<br/><br/>

Pour tous vos échanges ultérieurs avec notre support, merci de préciser le numéro de service suivant : ".$service."<br/>
<br/><br/>

                    Cordialement
                </td>
            </tr>
        </table> ";
        
    }elseif($template == 'PV FullSave'){
        echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Mail : '.$mail.'</td>
            </tr>
            <tr>
                <td>Objet :  Fullsave - PV de mise en service '.$service.' - '.$name.'</td>
            </tr>
        </thead>
            <tr>';
            echo "<td>
                     Bonjour,<br/><br/>

                    Vous bénéficiez à présent d’un service ".$type." depuis le ".$mes.", conformément à la commande souscrite auprès de FullSave, et dont vous trouverez la description ci-après.
<br/><br/>
La référence du lien est le ".$service.". Il est à rappeler pour tous les échanges avec notre support technique.
<br/><br/>
Vous trouverez en pièce jointe le procès-verbal de livraison associée à la livraison du service. Conformément à nos Conditions Générales de Ventes, une copie signée de ce document doit être renvoyée par mail à votre interlocuteur FullSave dans un délai de 7 jours à compter de la date d’envoi du présent document. Le cas échéant, le service sera considéré comme livré sans réserve.
<br/><br/>
Notre équipe Support se tient à votre disposition pour vous fournir tout complément d’information technique au 05.62.24.34.18 ou par mail à support@fullsave.com. Nous vous invitons également à suivre le compte Twitter @FullSave, par lequel vous trouverez des informations sur nos services, ainsi qu’en cas de dysfonctionnement majeur de nos services.
<br/><br/>
En vous remerciant pour votre confiance.<br/>
L’équipe FullSave
                <br/><br/>
                    Cordialement
                </td>
            </tr>
        </table> ";
    }elseif($template == 'PV Marque blanche'){
        echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Mail : '.$mail.'</td>
            </tr>
            <tr>
                <td>Objet :  Fullsave - PV de mise en service '.$service.' - '.$name.'</td>
            </tr>
        </thead>
            <tr>';
            echo "<td>
                     Bonjour,<br/><br/>

Vous bénéficiez à présent d’un service ".$type." depuis le ".$mes.", conformément à la commande souscrite auprès de FullSave, et dont vous trouverez la description ci-après. Ce service est à destination du client ".$name.".<br/><br/>

La référence du lien est le ".$service.". Il est à rappeler pour tous les échanges avec notre support technique.<br/><br/>

Vous trouverez en pièce jointe le procès-verbal de livraison associée à la livraison du service. Conformément à nos Conditions Générales de Ventes, une copie signée de ce document doit être renvoyée par mail à votre interlocuteur FullSave dans un délai de 7 jours à compter de la date d’envoi du présent document. Le cas échéant, le service sera considéré comme livré sans réserve.<br/><br/>

Notre équipe Support se tient à votre disposition pour vous fournir tout complément d’information technique au 05.62.24.34.18 ou par mail à support@fullsave.com. Nous vous invitons également à suivre le compte Twitter @FullSave, par lequel vous trouverez des informations sur nos services, ainsi qu’en cas de dysfonctionnement majeur de nos services.<br/><br/>

En vous remerciant pour votre confiance.<br/>
L’équipe FullSave

                <br/><br/>
                    Cordialement
                </td>
            </tr>
        </table> ";
    }elseif($template == 'Prise en charge'){
        echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Mail : '.$mail.'</td>
            </tr>
            <tr>
                <td>Objet :  [Fullsave] Lancement de la commande '.$bondecommande.' - '.$name.'</td>
            </tr>
        </thead>
            <tr><td>';
            if($media == 'fibre'){
            
                  echo "   Bonjour,<br/><br/>

Je suis la personne en charge du suivi de votre projet de raccordement en Très Haut Débit.<br/><br/>

Les travaux de déploiement du lien ".$name." à ".$debit." ont été lancés à l'adresse ci-dessous :<br/>
".$adresse."<br/><br/>

Ce lien portera la référence ".$service.".<br/><br/>";

if(!empty($operateur) && ($operateur == 'Natira' || $operateur == 'FullSave')){
echo "
Vous allez prochainement être contacté par l’entreprise ".$presta." pour planifier une première visite technique sur site.<br/>
En complément, vous trouverez en pièce jointe la fiche pour le paramétrage réseau de votre nouvel accès. Sans retour de votre part sous une semaine, nous mettrons une configuration par défaut.<br/><br/>

La date prévisionnelle de livraison est fixée au ".$limite_mes.".<br/><br/>";
}else{
 echo "Vous allez prochainement être contacté par notre prestataire local pour planifier une première visite technique sur site.<br/>
En complément, vous trouverez en pièce jointe la fiche pour le paramétrage réseau de votre nouvel accès. Sans retour de votre part sous une semaine, nous mettrons une configuration par défaut.<br/><br/>";
}
echo "
Vous trouverez, en cliquant sur le lien suivant, une fiche pratique précisant les principales étapes du projet de raccordement ainsi que les pré-requis techniques :<br/>
https://www.fullsave.com/fullsave-etapes-raccordement-fibre-optique/<br/><br/>


Ce délai pourra cependant être étendu :<br/><br/>

· En cas de non-conformité du site avec les pré-requis techniques, pouvant nécessiter la réalisation de votre part.<br/><br/>

· Si vous êtes locataires, et si les autorisations du propriétaire ne peuvent être obtenues dans les meilleurs délais.<br/><br/>

· Si l’adduction du bâtiment est saturée ou inexistante.<br/><br/>

· Si l’étude du parcours dans le réseau révèle une incapacité de passage dans les installations existantes (conduite cassée, absence de conduite, fourreau saturé etc.) et nécessite des opérations de Génie-civil pour réparer ou créer les accès requis. Il est alors nécessaire de disposer d’autorisations supplémentaires pouvant complexifier la réalisation (impact sur la circulation routière et la gêne occasionnée, travaux de nuit imposés etc.)<br/><br/>

Restant à votre écoute,<br/><br/>
                <br/><br/>
                    Cordialement
                ";
            }else{
                echo "Bonjour,<br/><br/>

Je suis la personne en charge du suivi de votre projet de raccordement.<br/><br/>

Les travaux de déploiement du lien ".$debit." ont été lancés à l'adresse ci-dessous :<br/>
".$adresse."<br/><br/>

Ce lien portera la référence ".$service.".<br/><br/>

Vous allez prochainement être contacté par l’entreprise Locale mandaté par Orange pour planifier une première visite technique sur site.<br/>
En complément, vous trouverez en pièce jointe la fiche pour le paramétrage réseau de votre nouvel accès. Sans retour de votre part sous une semaine, nous mettrons une configuration par défaut.<br/><br/>

Vous trouverez, en cliquant sur le lien suivant, une fiche pratique précisant les principales étapes du projet de raccordement ainsi que les pré-requis techniques :<br/>
https://www.fullsave.com/fullsave-etapes-raccordement-fibre-optique/<br/><br/>


Ce délai pourra cependant être étendu :<br/><br/>

· En cas de non-conformité du site avec les pré-requis techniques, pouvant nécessiter la réalisation de votre part.<br/><br/>

· Si vous êtes locataires, et si les autorisations du propriétaire ne peuvent être obtenues dans les meilleurs délais.<br/><br/>

· Si l’adduction du bâtiment est saturée ou inexistante.<br/><br/>

· Si l’étude du parcours dans le réseau révèle une incapacité de passage dans les installations existantes (conduite cassée, absence de conduite, fourreau saturé etc.) et nécessite des opérations de Génie-civil pour réparer ou créer les accès requis. Il est alors nécessaire de disposer d’autorisations supplémentaires pouvant complexifier la réalisation (impact sur la circulation routière et la gêne occasionnée, travaux de nuit imposés etc.)<br/><br/>

Restant à votre écoute,<br/><br/>
                <br/><br/>
                    Cordialement";
            }
           echo " </td></tr>
        </table> ";
    }
    echo '</div></center>';
}

 require('../includes/foot.php');
?>	
