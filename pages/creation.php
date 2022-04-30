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

echo $fslnk_ajout;

            
 echo'<center> 
    <h3>Création</h3>
    <form method="post" class="form-inline" action="creation.php">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <td><center>Client</center></td>
            <td><center>Aspect Technique</center></td>
        </tr>
        </thead>
        <tr>
            <td><center><br/><br/>
            FSC : <input  type="numb" name="fsc" class="form-control"  value="'.$_POST['fsc'].'" />
            Nom : <input  type="text" name="name"  class="form-control" value="'.$_POST['name'].'" />
            Siret : <input  type="text" name="siret"  class="form-control" value="'.$_POST['siret'].'" /><br/><br/>
            Adresse : <input  type="text" name="adresse" class="form-control"  value="'.$_POST['adresse'].'" />
            Adresse Supp : <input  type="text" name="adressesup"  class="form-control" value="'.$_POST['adressesup'].'" /><br/><br/>
            Code Postal : <input  type="text" name="cp"  class="form-control" value="'.$_POST['cp'].'" />
            Localité : <input  type="text" name="localite"  class="form-control" value="'.$_POST['localite'].'" /><br/><br/>
            Nom de Contact : <input  type="text" name="contact_name"  class="form-control" value="'.$_POST['contact_name'].'" />
            Téléphone : <input  type="text" name="contact_tel" class="form-control"  value="'.$_POST['contact_tel'].'" />
            Mail : <input  type="text" name="contact_mail" class="form-control"  value="'.$_POST['contact_mail'].'" /><br/><br/>
            
            Support GTR : <select name="support" class="form-control">
                    <option value="'.$_POST['support'].'">'.$_POST['support'].'</option>
                    <option value="5/7HO">5/7HO</option>
                    <option value="24/7">24/7</option>
            </select> - 
            <select name="gtr" class="form-control" >
                    <option value="'.$_POST['gtr'].'">'.$_POST['gtr'].'</option>
                    <option value="2">2h</option>
                    <option value="4">4h</option>
                    <option value="j+1">j+1</option>
                    <option value="j+7">j+7</option>
            </select>
            VIP : <select name="vip" class="form-control">
                    <option value="Non">Non</option>
                    <option value="Oui">Oui</option>
            </select>

            <br/><br/>
             Commentaire :<br/>
            <textarea class="form-control" rows="2" cols="30" name="comment" >' . $comment . '</textarea>

            </center></td>
            
            <td><center><br/><br/>
            Service : <select name="service" class="form-control">
                    <option value="'.$_POST['service'].'">'.$_POST['service'].'</option>';
    $service_type_req = $bdd->query("SELECT DISTINCT service_type FROM `network_account`WHERE 1 ORDER BY service_type");
        
        while ($s = $service_type_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$s['service_type'].'">'.$s['service_type'].'</option>';
   
}
            echo '    </select>
            Media : <select name="media" class="form-control">
                    <option value="'.$_POST['media'].'">'.$_POST['media'].'</option>';
    $media_req = $bdd->query("SELECT DISTINCT media FROM `network_account`WHERE 1 ORDER BY media");
        
        while ($m = $media_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$m['media'].'">'.$m['media'].'</option>';
   
}
     echo '       </select>
            Bande passante : <input  type="numb" name="bandwidth"   value="'.$_POST['bandwidth'].'" />
            <select name="bandwith_unit"  class="form-control">
                    <option value="'.$_POST['bandwith_unit'].'">'.$_POST['bandwith_unit'].'</option>
                    <option value="Mb/s">Mb/s</option>
                    <option value="Gb/s">Gb/s</option>
            </select><br/><br/>
            
            Mesure : <select name="mesure" class="form-control" >
                    <option value="'.$_POST['mesure'].'">'.$_POST['mesure'].'</option>';
                   $mesure_req = $bdd->query("SELECT DISTINCT mesure FROM `network_account`WHERE 1 ORDER BY mesure");
        
        while ($n = $mesure_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$n['mesure'].'">'.$n['mesure'].'</option>';
   
}
      echo '      </select><br/><br/>
            Supplier : <select name="supplier" class="form-control">
                    <option value="'.$_POST['supplier'].'">'.$_POST['supplier'].'</option>';
                   $supplier_req = $bdd->query("SELECT DISTINCT supplier FROM `network_account`WHERE 1 ORDER BY supplier");
        
        while ($r = $supplier_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$r['supplier'].'">'.$r['supplier'].'</option>';
   
}
     echo '       </select>
            Porte : <select name="porte" class="form-control">
                    <option value="'.$_POST['porte'].'">'.$_POST['porte'].'</option>
                    <option value="CELAN">CELAN</option>
                    <option value="CELAN-TLS00">CELAN-TLS00</option>
                    <option value="CELAN-MRS01">CELAN-MRS01</option>

                    <option value="DSLE">DSLE</option>
                    <option value="SPL-TLS00">SPL-TLS00</option>
                    <option value="SPL-LB01">SPL-LB01</option>
            </select>
            Secours : <select name="secours"  class="form-control">
                    <option value="'.$_POST['secours'].'">'.$_POST['secours'].'</option>
                    <option value="non">Non</option>
                    <option value="oui">Oui</option>
            </select>
            <br/><br/>
            Réf Fournisseur : <input  type="text" class="form-control" name="linknumber"  value="'.$_POST['linknumber'].'" />
            Ligne : <input  type="text" name="line"  class="form-control" value="'.$_POST['line'].'" /><br/><br/>
            Paires : <input  type="numb" name="paire" class="form-control"  value="'.$_POST['paire'].'" />
            Vlan : <input  type="numb" name="vlan" class="form-control"  value="'.$_POST['vlan'].'" /><br/><br/>
            Commande : <input  type="date" name="commande" class="form-control"  value="'.$_POST['commande'].'" /><br/><br/>
            Réf Devis : <input  type="text" name="devis"  class="form-control" value="'.$devis.'" /><br/><br/>
             TOIP :
             <select name="provider_voip"  class="form-control">
                    <option value="'.$provider_voip.'">'.$provider_voip.'</option>
                    <option value=""></option>
                    <option value="Sewan">Sewan</option>
                    <option value="Etoilediese">Etoilediese</option>
            </select> - 
            <select name="provider_techno"  class="form-control">
                    <option value="'.$provider_techno.'">'.$provider_techno.'</option>
                    <option value=""></option>
                    <option value="Wildix">Wildix</option>
                    <option value="Trunk">Trunk</option>
            </select> - 
            <select name="provider_cluster"  class="form-control">
                    <option value="'.$provider_cluster.'">'.$provider_cluster.'</option>
                    <option value=""></option>
                    <option value="trunkfsc4.sewan.fr">trunkfsc4.sewan.fr</option>
                    <option value="trunkfsc7.sewan.fr">trunkfsc7.sewan.fr</option>
                    <option value="sbc1.bw.sewan.fr">sbc1.bw.sewan.fr</option>
                    <option value="trunkfsc8.sewan.fr">trunkfsc8.sewan.fr</option>
                    <option value="trunkfshc.sewan.fr">trunkfshc.sewan.fr</option>
                    <option value="trunkfsc9.sewan.fr">trunkfsc9.sewan.fr</option>
            </select><br/><br/>
            </center></td>
        </tr>
    </table><br/><br/>

    <div class="mx-auto" style="width: 600px;">
 <button type="submit" class="btn btn-outline-success btn-sm mb-2">Créer</button>
 </div>
            </form></center>';
            

 
################### Traitement de variable $choix Nouveau ###################

 if (!empty($_POST['fsc']) ){
     


	        echo '<center>----------------------------</center><br/><br/>';

             $fsc = $_POST['fsc'];
			$siret = $_POST['siret'];
			$name = $_POST['name'];
			$adresse = $_POST['adresse'];
			$adressesupp = $_POST['adressesup'];
			$cp = $_POST['cp'];
			$localite = $_POST['localite'];
			$contact_name = $_POST['contact_name'];
			$contact_tel = $_POST['contact_tel'];
			$contact_mail = $_POST['contact_mail'];
			$service_type = $_POST['service'];
			$secours = $_POST['secours'];
			$media = $_POST['media'];
			$bandwidth = $_POST['bandwidth'];
			$mesure = $_POST['mesure'];
			$supplier = $_POST['supplier'];
			$porte = $_POST['porte'];
			$linknumber = $_POST['linknumber'];
			$line = $_POST['line'];
			$pair_count = $_POST['pair_count'];
			$vlan = $_POST['vlan'];
			$commande = $_POST['commande'];
			$support = $_POST['support'];
			$gtr = $_POST['gtr'];
			$comment = $_POST['comment'];
			$devis = $_POST['devis'];
            $bandwidth_unit  = $_POST['bandwith_unit'];
            if($bandwidth_unit == 'Mb/s'){
                $unit = '000';
            }elseif($bandwidth_unit == 'Gb/s'){
                $unit = '000000';
            }
			
            $bandwidth_full = $bandwidth.''.$unit;

            switch ($_POST['vip']) {
                    case 'Non':
                        $vip = 0;
                        break;
                    case 'Oui':
                        $vip = 1;
                        break;
                }

			
			if(empty($pair_count) || $pair_count == ''){
                $pair_count = NULL;
            }

            if(empty($commande) || $commande == '' || $commande == '0000-00-00'){
                $commande = NULL;
            }

			
			if(empty($contact_name)){
			    $contact_name = '*';
			}
			if(empty($contact_tel)){
			    $contact_tel = '*';
			}
			 if(!empty($_POST['provider_voip']) && !empty($_POST['provider_techno'])){
                 if($_POST['provider_voip'] == 'Sewan'){
                $cluster = $_POST['provider_voip'].'-'.$_POST['provider_techno'].'-'.$_POST['provider_cluster'];
                 }else{
                     $cluster = $_POST['provider_voip'].'-'.$_POST['provider_techno'];
                 }
            }

echo $bandwidth_full;
$requete = $bdd->prepare("INSERT INTO network_account (service_ref,customer_id,siret,name,adresse,adressesupp,cp,localite,contact_name,contact_tel,contact_mail,service_type,secours,media
    ,bandwidth,mesure,supplier,porte,linknumber,line,pair_count,vlan,commande,support,gtr,comment,cluster,vip,order_code) 
    
		VALUES(:service_ref, :customer_id, :siret, :name, :adresse, :adressesupp, :cp, :localite, :contact_name, :contact_tel, :contact_mail, :service_type, :secours, :media,
		:bandwidth, :mesure, :supplier, :porte, :linknumber, :line, :pair_count, :vlan, :commande, :support, :gtr, :comment, :cluster,:vip,:devis)");
	$variable_req = array(
			"service_ref" => $fslnk_ajout,
			"customer_id" => $fsc,
			"siret" => $siret,
			"name" => $name,
			"adresse" => $adresse,
			"adressesupp" => $adressesupp,
			"cp" => $cp,
			"localite" => $localite,
			"contact_name" => $contact_name,
			"contact_tel" => $contact_tel,
			"contact_mail" => $contact_mail,
			"service_type" => $service_type,
			"secours" => $secours,
			"media" => $media,
			"bandwidth" => $bandwidth_full,
			"mesure" => $mesure,
			"supplier" => $supplier,
			"porte" => $porte,
			"linknumber" => $linknumber,
			"line" => $line,
			"pair_count" => $pair_count,
			"vlan" => $vlan,
			"commande" => $commande,
			"support" => $support,
			"gtr" => $gtr,
			"cluster" => $cluster,
			"comment" => $comment,
			"vip" => $vip,
			"devis" => $devis

			
    );
    

$requete->execute($variable_req);

    echo '<center><h2>Création du '.$fslnk_ajout.' OK</h2></center>';
     
 }
 

echo '</center>';
require('../includes/foot.php');

?>
