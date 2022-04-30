<?php
require ('../includes/head.php');


$recuperation = $bdd->query("SELECT *
	FROM `network_account` 
	WHERE `fs_service_delivery` IS NULL
	AND  `resiliation` IS NULL
	AND `contact_name` IS NOT NULL 
	AND `contact_tel` IS NOT NULL
	AND `supplier` IN ('ORANGE WHOLESALE','GIRONDE NUMERIQUE','GIRONDE HAUT DEBIT','GERS NUMERIQUE')
	AND `service_type` IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
	ORDER BY id DESC
");

echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Client - FSLNK </td>
                <td>Réf Si-plugin</td>
                <td>Vlan Si-plugin</td>
                <td>Etat commande</td>
                <td>Ref Orange</td>
                <td>Vlan Orange</td>
                <td>Commentaire</td>
            </tr>
        </thead>';
            
        while ($r = $recuperation->fetch(PDO::FETCH_ASSOC)){
            
     $id_orange = $r['service_ref'];
     
     $recuperation_orange_comment = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$id_orange' AND `keyname` = 'ClientComment' ");
     $recuperation_orange_ref = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$id_orange' AND `keyname` = 'ProviderReference' ");
     $recuperation_orange_state = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$id_orange' AND `keyname` = 'state' ");
     $recuperation_orange_vlan = $bdd->query("SELECT value FROM `OrangeSourceInfo` WHERE `id` = '$id_orange' AND `keyname` = 'VLAN1' ");
     
         $orange_comment = $recuperation_orange_comment->fetch(PDO::FETCH_ASSOC);
         $orange_ref = $recuperation_orange_ref->fetch(PDO::FETCH_ASSOC);
         $orange_state = $recuperation_orange_state->fetch(PDO::FETCH_ASSOC);
         $orange_vlan = $recuperation_orange_vlan->fetch(PDO::FETCH_ASSOC);
         
         
    switch ($orange_state['value']) {
        case "etat.encours":
            $state = "En cours";
            break;
        case "etat.miseadispo":
            $state = "Dispo";
            break;
        case "etat.depose":
            $state = "Déposé";
            break;
        default:
            $state = $orange_state['value'];
    }

    echo'    
    
        <tr>
            <td>'.$r['name'].' - '.$r['service_ref'].' </td>
            <td>'.$r['linknumber'].' </td>
            <td>'.$r['vlan'].' </td>
            <td>'.$state.' </td>
            <td>'.$orange_ref['value'].' </td>
            <td>'.$orange_vlan['value'].' </td>
            <td>'.$orange_comment['value'].' </td>
        </tr>
     ';
 }
 
        echo '</table>';

echo '</center><br/><br/>';
require('../includes/foot.php');
?>