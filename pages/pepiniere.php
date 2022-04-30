<?php
require ('../includes/head.php');


$recup_fslnk = $bdd->query("SELECT *
	FROM `network_account`
	ORDER BY id DESC
   LIMIT 1");

 $y = $recup_fslnk->fetch(PDO::FETCH_ASSOC);
 



$fslnk_format = substr($y['service_ref'], -5);
intval($fslnk_format);
$fslnk_format_1 = $fslnk_format +1;
$fslnk_ajout = 'FSLNK0'.$fslnk_format_1;
$eqts = 'fsn0'.$fslnk_format_1;

echo '<center><div class="mx-auto" style="width: 600px;">

	    <form method="post" action="pepiniere.php">
	    <h3>Création client pepiniere</h3>
	    Pépinière : <select name="pepi" class="form-control">
                    <option value="'.$_POST['pepi'].'">'.$_POST['pepi'].'</option>
                    <option value="Basso Cambo">Basso Cambo</option>
                    <option value="Biotech1">Biotech1</option>
                    <option value="Biotech2">Biotech2</option>
                    <option value="Bordelongue">Bordelongue</option>
                    <option value="Bordelongue01">Bordelongue01</option>
                    <option value="Montaudran1">Montaudran1</option>
                    <option value="Montaudran2">Montaudran2</option>
                    <option value="Perget">Perget</option>
                    <option value="Pierre Potier">Pierre Potier</option>
                    <option value="Ramier">Ramier</option>
            </select><br/><br/>
            Nom :
             <input  type="text" name="client_pepi" class="form-control" placeholder ="Ex: LDLC" required value="'.$_POST['client_pepi'].'"/>
             Port :
             <input  type="number" min="1" max="48" name="port_pepi" class="form-control" placeholder ="Ex: 1,12" required value="'.$_POST['port_pepi'].'"/><br/><br/>
            Vlan :
             <input  type="numb" name="vlan_pepi" class="form-control" required value="'.$_POST['vlan_pepi'].'"/>
            <br/><br/>
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Créer</button>
	    </form>
	    </center>';



 if (!empty($_POST['pepi']) && !empty($_POST['client_pepi']) && !empty($_POST['port_pepi']) && !empty($_POST['vlan_pepi']) ){

  echo '<center>----------------------------</center><br/><br/>';
	        

	        
	            $fsc=317;
                $support = '24/7';
                $gtr = 4;
                $service_type = 'Pepiniere';
                $secours = 'non';
                $media = 'fibre';
                $bandwidth = '100000';
                $mesure = 'max';
                $supplier = 'FullSave';
                $vlan = $_POST['vlan_pepi'];
                $pe = 'tls00-2-mx';
	            $mes= date('Y-m-d');
	            if($_POST['port_pepi'] <= 9){
	               $port ='P0'.$_POST['port_pepi'];
	            }else{
	                $port = 'P'.$_POST['port_pepi'];
	            }
	            
	            
	            
	      switch($_POST['pepi']){
	        case 'Basso Cambo':
                $name='BASSOCAMBO-'.$port.' '.$_POST['client_pepi'];
                $adresse = '42, avenue du G';
                $cp = '31100';
                $localite = 'Toulouse';
                $contact_name = 'Stéphanie SERRES';
                $contact_tel = '05 61 40 76 80';
                $contact_mail = 'stephanie.serres@semidias.fr';
                #$eqts = 'bassocambo-'.$port;
            break;
            case 'Biotech1':
                $name='BIOTECH1-'.$port.' '.$_POST['client_pepi'];
                $adresse = 'Parc Technologique du Canal, 3 rue des Satellites';
                $cp = '31400';
                $localite = 'Toulouse';
                $contact_name = 'Elodie ALBAULT';
                $contact_tel = '09 80 08 48 60';
                $contact_mail = 'elodie.albault@semidias.fr';
                #$eqts = 'biotech1-'.$port;
            break;
            case 'Biotech2':
                $name='BIOTECH2-'.$port.' '.$_POST['client_pepi'];
                $adresse = '19 chemin de la loge';
                $cp = '31400';
                $localite = 'Toulouse';
                $contact_name = 'Elodie ALBAULT';
                $contact_tel = '09 80 08 48 60';
                $contact_mail = 'elodie.albault@semidias.fr';;
                #$eqts = 'biotech2-'.$port;
            break;
            case 'Bordelongue':
                $name='BORDELONGUE-'.$port.' '.$_POST['client_pepi'];
                $adresse = 'Portes Sud – Batiment 3 - 12 Rue louis Courtois de Viçose ';
                $cp = '31100';
                $localite = 'Toulouse';
                $contact_name = 'Alya NAJLAOUI';
                $contact_tel = '09 80 08 48 71';
                $contact_mail = 'alya.najlaoui@semidias.fr';
                #$eqts = 'bordelongue-'.$port;
            break;
            case 'Bordelongue01':
                $name='BORDELONGUE01-'.$port.' '.$_POST['client_pepi'];
                $adresse = 'Portes Sud – Batiment 3 - 12 Rue louis Courtois de Viçose ';
                $cp = '31100';
                $localite = 'Toulouse';
                $contact_name = 'Alya NAJLAOUI';
                $contact_tel = '09 80 08 48 71';
                $contact_mail = 'alya.najlaoui@semidias.fr';
                #$eqts = 'bordelongue01-'.$port;
            break;
            case 'Montaudran1':
                $name='MONTAUDRAN1-'.$port.' '.$_POST['client_pepi'];
                $adresse = '3 Avenue Didier Daurat';
                $cp = '31400';
                $localite = 'Toulouse';
                $contact_name = 'Chrystel Grialet';
                $contact_tel = '05 61 24 30 20';
                $contact_mail = 'chrystel.grialet@semidias.fr';
                #$eqts = 'montaudran1-'.$port;
            break;
            case 'Montaudran2':
                $name='MONTAUDRAN2-'.$port.' '.$_POST['client_pepi'];
                $adresse = '3 Avenue Didier Daurat';
                $cp = '31400';
                $localite = 'Toulouse';
                $contact_name = 'Chrystel Grialet';
                $contact_tel = '05 61 24 30 20';
                $contact_mail = 'chrystel.grialet@semidias.fr';
                #$eqts = 'montaudran2-'.$port;
            break;
            case 'Perget':
                $name='PERGET-'.$port.' '.$_POST['client_pepi'];
                $adresse = '23, boulevard Victor Hugo B';
                $cp = '31770';
                $localite = 'Colomiers';
                $contact_name = 'Bénédicte ZACCARIOTTO';
                $contact_tel = '05 62 12 14 07';
                $contact_mail = 'benedicte.raynaud@semidias.fr';
                #$eqts = 'perget-'.$port;
            break;
            case 'Ramier':
                $name='RAMIER-'.$port.' '.$_POST['client_pepi'];
                $adresse = '19 chemin de la loge';
                $cp = '31400';
                $localite = 'Toulouse';
                $contact_name = 'Alya NAJLAOUI';
                $contact_tel = '05 51 04 30 48';
                $contact_mail = 'alya.najlaoui@semidias.fr';
                #$eqts = 'ramier-'.$port;
            break;
            case 'Pierre Potier':
                $name='PIERREPOTIER-'.$port.' '.$_POST['client_pepi'];
                $adresse = '1 Place Pierre Potier _ Oncopole entr_e B';
                $cp = '31100';
                $localite = 'Toulouse';
                $contact_name = 'Nathalie MONMONT';
                $contact_tel = '09 80 08 48 70';
                $contact_mail = 'nathalie.monmont@semidias.fr';
                #$eqts = 'pierrepotier-'.$port;
            break;
	      }

    $requete = $bdd->prepare("INSERT INTO network_account (service_ref,customer_id,name,adresse,cp,localite,contact_name,contact_tel,contact_mail,service_type,secours,media
    ,bandwidth,mesure,supplier,vlan,pe,fs_service_delivery,support,gtr,eqts) 
    
		VALUES(:service_ref, :customer_id, :name, :adresse , :cp, :localite, :contact_name, :contact_tel, :contact_mail, :service_type, :secours, :media,
		:bandwidth, :mesure, :supplier, :vlan, :pe, :fs_service_delivery, :support, :gtr, :eqts)");
	$variable_req = array(
			"service_ref" => $fslnk_ajout,
			"customer_id" => $fsc,
			"name" => $name,
			"adresse" => $adresse,
			"cp" => $cp,
			"localite" => $localite,
			"contact_name" => $contact_name,
			"contact_tel" => $contact_tel,
			"contact_mail" => $contact_mail,
			"service_type" => $service_type,
			"secours" => $secours,
			"media" => $media,
			"bandwidth" => $bandwidth,
			"mesure" => $mesure,
			"supplier" => $supplier,
			"vlan" => $vlan,
			"pe" => $pe,
			"fs_service_delivery" => $mes,
			"support" => $support,
			"gtr" => $gtr,
			"eqts" => $eqts
		);
	$requete->execute($variable_req);

    echo '<center><h2>Création du '.$fslnk_ajout.' OK</h2></center>';

     
 }




require('../includes/foot.php');

