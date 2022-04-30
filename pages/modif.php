<?php
require ('../includes/head.php');

#var_dump($_POST);
	   
 if (!empty($_POST['modif_button']) ){
     

	        echo '<center>----------------------------</center><br/><br/>';
            
            $id = $_POST['id'];
            $service_ref = $_POST['service_ref'];
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
			$collecte = $_POST['collecte'];
			$pe = $_POST['pe'];
			$nro = $_POST['nro'];
			$eqts = $_POST['eqts'];
			$resil = $_POST['resil'];
			$mes = $_POST['mes'];
			$comment = $_POST['comment'];
           $devis = $_POST['devis'];
           $tag = $_POST['tag'];
			
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
            
            if(empty($resil) || $resil == '' || $resil == '0000-00-00'){
                $resil = NULL;
            }
            if(empty($commande) || $commande == '' || $commande == '0000-00-00'){
                $commande = NULL;
            }
            
            if(empty($mes) || $mes == '' || $mes == '0000-00-00'){
                $mes = NULL;
            }
            
            
             if(!empty($_POST['provider_voip']) && !empty($_POST['provider_techno'])){
                 if($_POST['provider_voip'] == 'Sewan'){
                $cluster = $_POST['provider_voip'].'-'.$_POST['provider_techno'].'-'.$_POST['provider_cluster'];
                 }else{
                     $cluster = $_POST['provider_voip'].'-'.$_POST['provider_techno'];
                 }
            }


            $up = $bdd->prepare("UPDATE `network_account` SET 
			`customer_id`= :fsc,
			`name`= :name,
			`siret`= :siret,
			`adresse`= :adresse,
			`adressesupp`= :adressesupp,
			`cp`= :cp,
			`localite`= :localite,
			`contact_name`= :contact_name,
			`contact_tel`= :contact_tel,
			`contact_mail` = :contact_mail,
			`support`= :support,
			`gtr`= :gtr,
			`service_type`= :service_type,
			`secours`= :secours,
			`media`= :media,
			`bandwidth`= :bandwidth,
			`pe`= :pe,
			`mesure`= :mesure,
			`supplier`= :supplier,
			`porte`= :porte,
			`linknumber`= :linknumber,
			`line`= :line,
			`pair_count`= :pair_count,
			`vlan`= :vlan,
			`collecte`= :collecte,
			`nro`= :nro,
			`eqts`= :eqts,
			`fs_service_delivery`= :mes,
			`resiliation`= :resil,
			`commande` = :commande,
			`comment` = :comment,
			`cluster` = :cluster,
			`vip` = :vip,
			`order_code` = :devis,
            `service_tag_natira` = :tag
			 WHERE `id` = :id ");
		$up->execute(array(
			"fsc" => $fsc,
            "name"=> $name,
            "siret" => $siret,
            "adresse" => $adresse,
            "adressesupp" => $adressesupp,
            "cp" => $cp,
            "localite" => $localite,
            "contact_name" => $contact_name,
            "contact_tel" => $contact_tel,
            "contact_mail" => $contact_mail,
            "support" => $support,
            "gtr" => $gtr,
            "service_type" => $service_type,
            "secours" => $secours,
            "media" => $media,
            "bandwidth" => $bandwidth,
            "pe" => $pe,
            "mesure" => $mesure,
            "supplier" => $supplier,
            "porte" => $porte,
            "linknumber" => $linknumber,
            "line" => $line,
            "pair_count" => $pair_count,
            "vlan" => $vlan,
            "collecte" => $collecte,
            "nro" => $nro,
            "eqts" => $eqts,
            "mes" => $mes,
            "resil" => $resil,
            "commande" => $commande,
            "comment" => $comment,
            "cluster" => $cluster,
            "vip" => $vip,
			"devis" => $devis,
            "tag" => $tag,
            "id" => $id
		));

			
 
    echo '<center><h3>Mise à jour du '.$service_ref.'</h3></center>';
     
  
 } 	   
 echo '<center><div class="mx-auto" style="width: 600px;">

	    <form method="post" action="modif.php">
	    <h3>Modifier</h3>
	    FSLNK : <br/>
     <input  type="text" name="fslnk" class="form-control" required value="'.$_POST['fslnk'].'"/><br/><br/>
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Chercher</button>
	    </form>
	    </center></div>';
	    
	    if (!empty($_POST['fslnk']) ){
 


	        $fslnk = $_POST['fslnk'];
	        
	        ## Récuperation de l'IP admin
	        $req_ID = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk%' ");
            $w = $req_ID->fetch(PDO::FETCH_ASSOC);
                
                $service_ref = $w['service_ref'];
                $tag = $w['service_tag_natira'];
                $id = $w['id'];
                $fsc=$w['customer_id'];
                $name=$w['name'];
                $siret = $w['siret'];
                $adresse = $w['adresse'];
                $adressesupp = $w['adressesupp'];
                $cp = $w['cp'];
                $localite = $w['localite'];
                $contact_name = $w['contact_name'];
                $contact_tel = $w['contact_tel'];
                $contact_mail = $w['contact_mail'];
                $support = $w['support'];
                $gtr = $w['gtr'];
                $commande = $w['commande'];
                $service_type = $w['service_type'];
                $secours = $w['secours'];
                $media = $w['media'];
                $bandwidth = $w['bandwidth'];
                $pe = $w['pe'];
                $mesure = $w['mesure'];
                $supplier = $w['supplier'];
                $porte = $w['porte'];
                $linknumber = $w['linknumber'];
                $line = $w['line'];
                $pair_count = $w['pair_count'];
                $vlan = $w['vlan'];
                $collecte = $w['collecte'];
                $nro = $w['nro'];
                $eqts = $w['eqts'];
                $resil = $w['resiliation'];
                $mes = $w['fs_service_delivery'];
                $comment = $w['comment'];
                 switch ($w['vip']) {
                    case 0:
                        $vip = 'Non';
                        break;
                    case 1:
                        $vip = 'Oui';
                        break;
                }
            $devis = $w['order_code'];
                  $explode_cluster = explode('-',$w['cluster']);
                
                $provider_voip = $explode_cluster[0];
                $provider_techno = $explode_cluster[1];
                $provider_cluster = $explode_cluster[2];

            
echo'<center> 

    <form method="post" class="form-inline" action="modif.php">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <td><center>Client '.$service_ref.'</center></td>
            <td><center>Aspect Technique</center></td>
        </tr>
        </thead>
        <tr>
            <td><center><br/><br/>
            FSC : <input  type="numb" name="fsc" class="form-control"  value="'.$fsc.'" />
            Nom : <input  type="text" name="name"  class="form-control" value="'.$name.'" />
            Siret : <input  type="text" name="siret"  class="form-control" value="'.$siret.'" /><br/><br/>
            Adresse : <input  type="text" name="adresse" class="form-control"  value="'.$adresse.'" />
            Adresse Supp : <input  type="text" name="adressesup"  class="form-control" value="'.$adressesupp.'" /><br/><br/>
            Code Postal : <input  type="text" name="cp"  class="form-control" value="'.$cp.'" />
            Localité : <input  type="text" name="localite"  class="form-control" value="'.$localite.'" /><br/><br/>
            Nom de Contact : <input  type="text" name="contact_name"  class="form-control" value="'.$contact_name.'" />
            Téléphone : <input  type="text" name="contact_tel" class="form-control"  value="'.$contact_tel.'" />
            Mail : <input  type="text" name="contact_mail" class="form-control"  value="'.$contact_mail.'" /><br/><br/>
            
            Support GTR : <select name="support" class="form-control">
                    <option value="'.$support.'">'.$support.'</option>
                    <option value="5/7HO">5/7HO</option>
                    <option value="24/7">24/7</option>
            </select> - 
            <select name="gtr" class="form-control" >
                    <option value="'.$gtr.'">'.$gtr.'</option>
                    <option value="2">2h</option>
                    <option value="4">4h</option>
                    <option value="j+1">j+1</option>
                    <option value="j+7">j+7</option>
            </select>
            
            VIP : <select name="vip" class="form-control">
                    <option value="'.$vip.'">'.$vip.'</option>
                    <option value="Non">Non</option>
                    <option value="Oui">Oui</option>
            </select>

            <br/><br/>
            Commande : <input  type="date" name="commande" class="form-control"  value="'.$commande.'" />
            MES : <input  type="date" name="mes" class="form-control"  value="'.$mes.'" />
            Résiliation : <input  type="date" name="resil" class="form-control"  value="'.$resil.'" /><br/><br/>
            Commentaire :<br/>
            <textarea class="form-control" rows="2" cols="30" name="comment" >' . $comment . '</textarea>
            </center></td>
            
            <td><center><br/><br/>
            Service : <select name="service" class="form-control">
                    <option value="'.$service_type.'">'.$service_type.'</option>';
    $service_type_req = $bdd->query("SELECT DISTINCT service_type FROM `network_account`WHERE 1 ORDER BY service_type");
        
        while ($s = $service_type_req->fetch(PDO::FETCH_ASSOC))
{

     echo '   <option value="'.$s['service_type'].'">'.$s['service_type'].'</option>';
   
}
            echo '    </select>
            Media : <select name="media" class="form-control">
                    <option value="'.$media.'">'.$media.'</option>';
    $media_req = $bdd->query("SELECT DISTINCT media FROM `network_account` WHERE 1 ORDER BY media");
        
        while ($m = $media_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$m['media'].'">'.$m['media'].'</option>';
   
}
     echo '       </select>
            Bande passante : <input  type="numb" name="bandwidth"   value="'.$bandwidth.'" />
           
            <br/><br/>
            
            Mesure : <select name="mesure" class="form-control" >
                    <option value="'.$mesure.'">'.$mesure.'</option>';
                   $mesure_req = $bdd->query("SELECT DISTINCT mesure FROM `network_account` WHERE 1 ORDER BY mesure");
        
        while ($n = $mesure_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$n['mesure'].'">'.$n['mesure'].'</option>';
   
}
      echo'      </select><br/><br/>
            Supplier : <select name="supplier" class="form-control">
                    <option value="'.$supplier.'">'.$supplier.'</option>';
                   $supplier_req = $bdd->query("SELECT DISTINCT supplier FROM `network_account` WHERE 1 ORDER BY supplier");
        
        while ($r = $supplier_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$r['supplier'].'">'.$r['supplier'].'</option>';
   
}
     echo '       </select>
     
     PE : <select name="pe" class="form-control">
                    <option value="'.$pe.'">'.$pe.'</option>';
                   $pe_req = $bdd->query("SELECT DISTINCT pe FROM `network_account` WHERE 1 ORDER BY pe");
        
        while ($p = $pe_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$p['pe'].'">'.$p['pe'].'</option>';
   
}
     echo '       </select>
            Porte : <select name="porte" class="form-control">
                    <option value="'.$porte.'">'.$porte.'</option>
                    <option value="CELAN">CELAN</option>
                    <option value="CELAN-TLS00">CELAN-TLS00</option>
                    <option value="CELAN-MRS01">CELAN-MRS01</option>
                    <option value="DSLE">DSLE</option>
                    <option value="SPL-TLS00">SPL-TLS00</option>
                    <option value="SPL-LB01">SPL-LB01</option>
            </select>
            Secours : <select name="secours"  class="form-control">
                    <option value="'.$secours.'">'.$secours.'</option>
                    <option value="non">Non</option>
                    <option value="oui">Oui</option>
            </select>
            <br/><br/>
            Réf Fournisseur : <input  type="text" class="form-control" name="linknumber"  value="'.$linknumber.'" />
            Service Tag : <input  type="text" class="form-control" name="tag"  value="'.$tag.'" /><br/><br/>
            Ligne : <input  type="text" name="line"  class="form-control" value="'.$line.'" />
            Paires : <input  type="numb" name="pair_count" class="form-control"  value="'.$pair_count.'" /><br/><br/>
            Vlan : <input  type="numb" name="vlan" class="form-control"  value="'.$vlan.'" />
            Collecte : <input  type="numb" name="collecte" class="form-control"  value="'.$collecte.'" /><br/><br/>
            Réf Devis : <input  type="text" name="devis"  class="form-control" value="'.$devis.'" />
            
            NRO : <select name="nro" class="form-control">
            
                    <option value="'.$nro.'">'.$nro.'</option>';
        $nro_req = $bdd->query("SELECT DISTINCT nro FROM `network_account` WHERE 1 ORDER BY nro");
        
        while ($o = $nro_req->fetch(PDO::FETCH_ASSOC))
{

     echo'   <option value="'.$o['nro'].'">'.$o['nro'].'</option>';
   
}
     echo '       </select>
     
            Eqts : <input  type="numb" name="eqts" class="form-control"  value="'.$eqts.'" /><br/><br/> 
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
    <input type="hidden" value="'.$service_ref.'" name ="service_ref"/>
    <input type="hidden" value="'.$fslnk.'" name ="fslnk"/>
<input type="hidden" value="'.$id.'" name ="id"/>
    <div class="mx-auto" style="width: 600px;">
 <button type="submit" name="modif_button" value="1" class="btn btn-outline-success btn-sm mb-2">Modifier</button>
 </div>
            </form></center>';
         
         
         
}


 

echo '</center>';
require('../includes/foot.php');

