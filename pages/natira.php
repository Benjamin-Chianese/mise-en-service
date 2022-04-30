<?php
require ('../includes/head.php');



if(!empty($_POST['id'])){
    
    
    switch ($_POST['tiroir']) {
    
    case 'MUX_TLS05-TLS00 via Ramassiers_TLS00':
        $site = 'TLS00';
        break;
    case 'Tiroir 144 vers BPE CANAL 1':
        $site = 'TLS00';
        break;
    case 'Tiroir 144 vers COGENT_MMRA':
        $site = 'TLS00';
        break;
    case 'Tiroir 36 SFR':
        $site = 'TLS00';
        break;
    case 'Tiroir 144 SPL RIN vers Canal/SFR':
        $site = 'TLS00';
        break;
    case 'Tiroir 12 Orange':
        $site = 'TLS00';
        break;
    case 'Tiroir 72 FULLSAVE-ZAYO':
        $site = 'TLS00';
        break;
    case 'Tiroir12 vers MIXART':
        $site = 'TLS00';
        break;
    case 'Tiroir12 vers bureau':
        $site = 'TLS00';
        break;
    case 'Tiroir 144 vers COGENT_MMRB':
        $site = 'TLS00';
        break;
    case 'Tiroir36 vers salle TTN':
        $site = 'TLS00';
        break;
    case 'Tiroir 36 vers COGENT':
        $site = 'TLS00';
        break;
    case 'Tiroir 144 vers BPE TLS00':
        $site = 'TLS00';
        break;
    case 'Tiroir 144  SPL vers BPE01 Suisse':
        $site = 'TLS00';
        break;
    case 'Tiroir 144 vers BPE3351_Suisse':
        $site = 'TLS00';
        break;
    case 'Tiroir12 vers OPERAMETRIX':
        $site = 'TLS00';
        break;
        
        
    case 'T96_LB01/TLS02':
        $site = 'TLS02';
        break;
    case 'TIRROIR_SPL001':
        $site = 'TLS02';
        break;
    case 'TIRROIR_SPL002':
        $site = 'TLS02';
        break;
        
    case 'MUX_TLS05-TLS00 via Ramassiers_TLS05':
        $site = 'TLS05';
        break;
    case 'MUX_TLS05-TLS02 (via O2pub)':
        $site = 'TLS05';
        break;
    case 'T12_TLS05 vers C034689':
        $site = 'TLS05';
        break;
    case 'Tir.144_TLS05-1':
        $site = 'TLS05';
        break;
    case 'Tir.144_TLS05-2':
        $site = 'TLS05';
        break;
    case 'Tiroir INFOMIL':
        $site = 'TLS05';
        break;
        
        
    case 'Tiroir_TLS06-1':
        $site = 'TLS06';
        break;
    case 'Tiroir_TLS06-2':
        $site = 'TLS06';
        break;
        
    case 'TIROIR 144 LGB01':
        $site = 'LBG01';
        break;
    case 'TIROIR 144-2':
        $site = 'LBG01';
        break;
    case 'TIROIR 144-3':
        $site = 'LBG01';
        break;
    case 'U45.1à12-MMR1(Tr3à12)_13à24-MMR2(Tr3.1à12)':
        $site = 'BLM01';
        break;
    case 'U41.1à6-MMR1.Tr23':
        $site = 'BLM01';
        break;
    case 'U40.1à12-MMR1.tr31_19à24-1à6 T37MMR1':
        $site = 'BLM01';
        break;
    case 'U39.1à12-B15 (Baie LPR)':
        $site = 'BLM01';
        break;
    case 'U36.1à12 MMR1(Tr38) 13à24 MMR1(Tr47)':
        $site = 'BLM01';
        break;
    case 'U33-37_tir144 vers MMR2':
        $site = 'BLM01';
        break;
    case 'U18-19_tir48 vers MMR1':
        $site = 'BLM01';
        break;
        
    case '144FO/1 BPE CAG10':
        $site = 'SGD02';
        break;
    case '144FO/2 BPE LAN10':
        $site = 'SGD02';
        break;
    case '144FO/3 BPE 150':
        $site = 'SGD02';
        break;
        
    case 'Tiroir 144 MUR01 (1à6)':
        $site = 'MUR01';
        break;
    
    case 'Tiroir 144 COL01':
        $site = 'COL01';
        break;
        
    case 'Tiroir 48 LSP01':
        $site = 'LSP01';
        break;
        
    case 'Tiroir 144 MON01':
        $site = 'MON01';
        break;
    
    case 'Tiroir 288 BDX02':
        $site = 'BDX02';
        break;
    case 'Tiroir_TLS07-1 (Vers TLS00)':
        $site = 'TLS07';
        break;
    case 'Tiroir_TLS07-2 (Vers LBG01)':
        $site = 'TLS07';
        break;
    case 'Tiroir 144_BLA01':
        $site = 'BLA01';
        break;

    case 'Interconnexions Opérateur MMR3':
        $site = 'BDX03';
        break;
    case 'BDX03_DEMI BAIE-FULLSAVE vers MMR1':
        $site = 'BDX03';
        break;
    case 'BDX03_DEMI BAIE-FULLSAVE vers MMR3':
        $site = 'BDX03';
        break;

    case 'Tiroir 24Fo SFR (adduction SUD_fsn-ppa-00238)':
        $site = 'BDX01';
        break;
    case 'Tiroir 24Fo SFR (adduction NORD_fsn-ppa-00239)':
        $site = 'BDX01';
        break;
}
    
$entre_format = $_POST['entre'];

	if(!empty($entre_format)){
	$entre_explode = explode(':',$entre_format);
	$entre_min = strtolower($entre_explode[0]);
	$entre_maj = ucfirst(strtolower($entre_explode[1]));
	$entreu = $entre_min.':'.$entre_maj;
	}
	elseif(!empty($_POST['entre_collecte']) && !empty($_POST['entre_port'])){
	    
	    $entreu =$_POST['entre_collecte'].':'.$_POST['entre_port'];

	}else{
	    $entreu = '';	}

    
    $up = $bdd->prepare("UPDATE `network_vision` SET 
			`site`= :site,
			`tiroir`= :tiroir,
			`tube`= :tube,
			`fibre`= :fibre,
			`etat`= :etat,
			`commentaire_natira`= :commentaire,
			`date_natira`= :date 
			WHERE `si_id` = :id");
		$up->execute(array(
			"site" => $site,
			"tiroir" => $_POST['tiroir'],
			"tube" => $_POST['tube'],
			"fibre" => $_POST['fibre'],
			"etat" => $_POST['etat'],
			"commentaire" => $_POST['commentaire'],
			"date" => date('Y-m-d'),
			"id" => $_POST['id']
		
		));
		
if (!empty($entreu))
		{
			
			$up3 = $bdd->prepare("UPDATE `network_account` SET `collecte`= :pe WHERE `id` = :uid ");
			$up3->execute(array(
				"uid" => $_POST['id'],
				"pe" => $entreu));
				
				
			$up3 = $bdd->prepare("UPDATE `network_vision` SET `entre`= :pe WHERE `si_id` = :uid ");
			$up3->execute(array(
				"uid" => $_POST['id'],
				"pe" => $entreu));

		}
        if(empty($_POST['tiroir']))
        {
            $up = $bdd->prepare("UPDATE `network_account` SET `collecte`= '' WHERE `id` = :uid ");
			$up->execute(array(
				"uid" => $_POST['id'],
				));
        }



			
			$up_ref = $bdd->prepare("UPDATE `network_account` SET `linknumber`= :ref WHERE `id` = :uid ");
			$up_ref->execute(array(
				"uid" => $_POST['id'],
				"ref" => $_POST['ref']));
		

    echo "<center><h2>Mise à jour OK</h2></center>";
}


if(!empty($_POST['page_OK'])){
    
    switch ($_POST['page_OK']) {
    case "0":
        $recuperation = $bdd->query("SELECT * from `network_vision` INNER JOIN network_account  
WHERE network_vision.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND network_vision.etat != 'OK'
AND network_vision.annuler = 0
AND network_account.resiliation IS NULL
AND network_account.service_type IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet')
ORDER BY  network_vision.prio ASC,network_vision.id DESC");
echo'
<center><form method="post" action="natira.php">
<button name="page_OK" value="0" type="submit" class="btn btn-success btn-sm mb-2">Lien en cours</button>
<button name="page_OK" value="1" type="submit" class="btn btn-outline-success btn-sm mb-2">Lien OK</button>
</form>
</center>';
        break;
    case "1":
        $recuperation = $bdd->query("SELECT * from `network_vision` INNER JOIN network_account  
WHERE network_vision.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND network_vision.etat = 'OK'
AND network_vision.annuler = 0
AND network_account.resiliation IS NULL
AND network_account.service_type IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet')
ORDER BY  network_vision.prio ASC,network_vision.id DESC");
echo'
<center><form method="post" action="natira.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Lien en cours</button>
<button name="page_OK" value="1" type="submit" class="btn btn-success btn-sm mb-2">Lien OK</button>
</form>
</center>';
        break;
   
} 
    

}else{
    $recuperation = $bdd->query("SELECT * from `network_vision` INNER JOIN network_account  
WHERE network_vision.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND network_vision.etat != 'OK'
AND network_vision.annuler = 0
AND network_account.resiliation IS NULL
AND network_account.service_type IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet')
ORDER BY  network_vision.prio ASC,network_vision.id DESC");

echo'
<center><form method="post" action="natira.php">
<button name="page_OK" value="0" type="submit" class="btn btn-success btn-sm mb-2">Lien en cours</button>
<button name="page_OK" value="1" type="submit" class="btn btn-outline-success btn-sm mb-2">Lien OK</button>
</form>
</center>';
}




echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Date MAJ</td>
                <td>Client - FSLNK </td>
                <td>Réf</td>
                <td>Port</td>
                <td>Site</td>
                <td>Tiroir</td>
                <td>Tube</td>
                <td>Fibre</td>
                <td>État</td>
                <td>Commentaire</td>
                <td>MAJ</td>
            </tr>
        </thead>';
            
        while ($r = $recuperation->fetch(PDO::FETCH_ASSOC)){
            

            
            $id_natira =$r['si_id'];
            
            
            if(!empty($r['date_natira'])){
            
            $maj = date('d-m-Y',strtotime($r['date_natira']));
            }else{
                $maj = '';
            }
            
            $ref = $r['linknumber'];
            $r_site = $r['site'];
            $tiroir = $r['tiroir'];
            $tube = $r['tube'];
            $fibre = $r['fibre'];
            $etat = $r['etat'];
            $commentaire = $r['commentaire_natira'];
            $entre = $r['collecte'];
            
            	if(!empty($entre)){

	                    $entre_explode_visu = explode(':',$entre);
	                $entre_min_visu = strtolower($entre_explode_visu[0]);
	                $entre_maj_visu = ucfirst(strtolower($entre_explode_visu[1]));
       
                }else{
                    unset($entre_min_visu);
                    unset($entre_maj_visu);
                }
                
            if (!empty($r_site)){
                
                    switch ($r_site) {
    
                     case 'TLS00':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <optgroup label="ASR"> 
                                <option value="tls00-1-asr920">tls00-1-asr920</option>
                                <option value="tls00-2-asr920">tls00-2-asr920</option>
                                <option value="tls00-3-asr920">tls00-3-asr920</option>
                                <option value="tls00-4-asr920">tls00-4-asr920</option>
                                <option value="tls00-5-asr920">tls00-5-asr920</option>
                                <option value="tls00-6-asr920">tls00-6-asr920</option>
                                <option value="tls00-7-asr920">tls00-7-asr920</option>
                                <option value="tls00-8-asr920">tls00-8-asr920</option>
                                <option value="tls00-9-asr920">tls00-9-asr920</option>
                            </optgroup>
                             <optgroup label="NCS"> 
                                <option value="tls00-1-ncs5k">tls00-1-ncs5k</option>
                                <option value="tls00-2-ncs5k">tls00-2-ncs5k</option>
                            </optgroup>
                		</optgroup>
                		</select>
                		
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

               $select_entree .=	'	</optgroup>
                <optgroup label="NCS">'; 
                         for ($i = 0; $i <= 47; $i++) {
                                 $select_entree .='	<option value="Te0/0/0/'.$i.'">Te0/0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                		</select>
';
                        break;
                        
                    case 'TLS01':
                        $select_entree = '<select name="entre_collecte" class="form-control" >
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
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
                        <optgroup label="'.$r_site.'"> 
                            <option value="tls02-1-asr920">tls02-1-asr920</option>
                            <option value="tls02-2-asr920">tls02-2-asr920</option>
                            <option value="tls02-3-asr920">tls02-3-asr920</option>
                            <option value="tls02-4-asr920">tls02-4-asr920</option>
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
                        <optgroup label="'.$r_site.'"> 
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
                        <optgroup label="'.$r_site.'"> 
                            <option value="tls06-1-asr920">TLS06-1-asr920</option>
                            <option value="tls06-2-asr920">TLS06-2-asr920</option>
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
                        <optgroup label="'.$r_site.'"> 
                            <optgroup label="ASR">
                                <option value="lbg01-1-asr920">lbg01-1-asr920</option>
                                <option value="lbg01-2-asr920">lbg01-2-asr920</option>
                                <option value="lbg01-3-asr920">lbg01-3-asr920</option>
                                <option value="lbg01-4-asr920">lbg01-4-asr920</option>
                                <option value="lbg01-5-asr920">lbg01-5-asr920</option>
                            </optgroup>
                            <optgroup label="NCS">
                                <option value="lbg01-1-ncs540">lbg01-1-ncs540</option>
                                <option value="lbg01-2-ncs540">lbg01-2-ncs540</option>
                            </optgroup>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control" >
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                <optgroup label="NCS">'; 
                         for ($i = 0; $i <= 31; $i++) {
                             if($i == 24 || $i == 25 || $i == 26 || $i == 27){
                                $select_entree .='	<option value="TF0/0/0/'.$i.'">TF0/0/0/'.$i.'</option>';
                             }else{
                                 $select_entree .='	<option value="Te0/0/0/'.$i.'">Te0/0/0/'.$i.'</option>';}
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                        
                     case 'BLM01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <optgroup label="ASR">
                                <option value="blm01-1-asr920">blm01-1-asr920</option>
                                <option value="blm01-2-asr920">blm01-2-asr920</option>
                                <option value="blm01-3-asr920">blm01-3-asr920</option>
                                <option value="blm01-4-asr920">blm01-4-asr920</option>
                                <option value="blm01-5-asr920">blm01-5-asr920</option>
                            </optgroup>
                            <optgroup label="NCS">
                                <option value="blm01-1-ncs540">blm01-1-ncs540</option>
                                <option value="blm01-1-ncs5k">blm01-1-ncs5k</option>
                            </optgroup>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control" >
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                        <optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                <optgroup label="NCS">'; 
                         for ($i = 0; $i <= 31; $i++) {
                             if($i == 24 || $i == 25 || $i == 26 || $i == 27){
                                $select_entree .='	<option value="TF0/0/0/'.$i.'">TF0/0/0/'.$i.'</option>';
                             }else{
                                 $select_entree .='	<option value="Te0/0/0/'.$i.'">Te0/0/0/'.$i.'</option>';}
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                        
                    case 'LIJ01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
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
                        <optgroup label="'.$r_site.'"> 
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
                        <optgroup label="'.$r_site.'"> 
                            <option value="mur01-1-asr920">mur01-1-asr920</option>
                            <option value="mur01-2-asr920">mur01-2-asr920</option>
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
                        
                    case 'COL01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <option value="col01-1-asr920">col01-1-asr920</option>
                            <option value="col01-2-asr920">col01-2-asr920</option>
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
                        
                    case 'LSP01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <option value="lsp01-1-asr920">lsp01-1-asr920</option>
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
                        
                    case 'MON01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <option value="mon01-1-asr920">mon01-1-asr920</option>
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
                        <optgroup label="'.$r_site.'"> 
                            <option value="sgd02-1-asr920">sgd02-1-asr920</option>
                            <option value="sgd02-2-asr920">sgd02-2-asr920</option>
                		</optgroup>
                		</select>
                	<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                		<optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	$select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>';
                        break;
                        
                        
                    case 'BDX02':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <option value="bdx02-1-asr920">bdx02-1-asr920</option>
                            <option value="bdx02-2-asr920">bdx02-2-asr920</option>
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
                    case 'TLS07':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <optgroup label = "ASR">
                                <option value="tls07-1-asr920">tls07-1-asr920</option>
                                <option value="tls07-2-asr920">tls07-2-asr920</option>
                                <option value="tls07-3-asr920">tls07-3-asr920</option>
                                <option value="tls07-4-asr920">tls07-4-asr920</option>
                            </optgroup>
                            <optgroup label = "NCS">
                                <option value="tls07-1-ncs540">tls07-1-ncs540</option>
                                <option value="tls07-2-ncs540">tls07-2-ncs540</option>
                            </optgroup>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                		<optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	        $select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }
                         $select_entree .=	'	</optgroup>
                <optgroup label="NCS">'; 
                         for ($i = 0; $i <= 31; $i++) {
                             if($i == 24 || $i == 25 || $i == 26 || $i == 27){
                                $select_entree .='	<option value="TF0/0/0/'.$i.'">TF0/0/0/'.$i.'</option>';
                             }else{
                                 $select_entree .='	<option value="Te0/0/0/'.$i.'">Te0/0/0/'.$i.'</option>';}
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;
                        
                         case 'BLA01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <option value="bla01-1-asr920">bla01-1-asr920</option>
                            <option value="bla01-2-asr920">bla01-2-asr920</option>
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

                        case 'BDX03':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <option value="bdx03-1-asr920">bdx03-1-asr920</option>
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
                    case 'BDX01':
                        $select_entree = '<select name="entre_collecte" class="form-control">
                        <option value="' . $entre_min_visu . '">' . $entre_min_visu . '</option>
                        <optgroup label="'.$r_site.'"> 
                            <optgroup label = "ASR">
                                <option value="bdx01-1-asr920">bdx01-1-asr920</option>
                            </optgroup>
                            <optgroup label = "NCS">
                                <option value="bdx01-1-ncs5k">bdx01-1-ncs5k</option>
                            </optgroup>
                		</optgroup>
                		</select>
                		<select name="entre_port" class="form-control">
                        <option value="' . $entre_maj_visu . '">' . $entre_maj_visu . '</option>
                		<optgroup label="ASR">'; 
                         for ($i = 0; $i <= 23; $i++) {
                	        $select_entree .='	<option value="Gi0/0/'.$i.'">Gi0/0/'.$i.'</option>';
                        }
                         $select_entree .=	'	 <optgroup label="NCS">'; 
                         for ($i = 0; $i <= 47; $i++) {
                                 $select_entree .='	<option value="Te0/0/0/'.$i.'">Te0/0/0/'.$i.'</option>';
                        }

                $select_entree .=	'	</optgroup>
                
                		</select>
';
                        break;   
                        
                        default:
       $select_entree = '<input  type="text" class="form-control" name="entre" value="' . $entre . '" />';
}
    }else{
        $select_entree = '<input  type="text" class="form-control" name="entre" value="' . $entre . '" />';
    }
             
  
  
  
  
    echo '<tr>
    
                <td>'.$maj.'</td>';
                
                 if(!empty($r['prio'])){
                    switch ($r['prio']){
                case 1:
                echo '<td style="background-color:#CC3E54">'.$r['name'].' - '.$r['service_ref'].' </td>';
                break;
                case 2:
                echo '<td style="background-color:#DBD23A">'.$r['name'].' - '.$r['service_ref'].' </td>';
                break;
                case 3:
                echo '<td style="background-color:#20AE51">'.$r['name'].' - '.$r['service_ref'].' </td>';
                break;
                case 4:
                 echo '
                      <td>'.$r['name'].' - '.$r['service_ref'].' </td>';
                break;

                }
                }else{
                     echo '<td>'.$r['name'].' - '.$r['service_ref'].' </td>
                       ';     
                }

                echo '<form method="post" action="natira.php">
                <td><input  type="text"  class="form-control" name="ref"  value="'.$ref.'"/></td>
                <td> '.$select_entree.'
                

                <td>' . $r_site . '</td>
                <td><select name="tiroir" class="form-control">';
                
                if(!empty($tiroir)){
                     echo '   <option value="' . $tiroir . '">' . $tiroir . '</option>
                     <option></option>';
                }else{
                  echo '<option></option>  ';
                }
                    echo '    <optgroup label="TLS00"> 
                            <option value="MUX_TLS05-TLS00 via Ramassiers_TLS00">MUX_TLS05-TLS00 via Ramassiers_TLS00</option>
                            <option value="Tiroir 144 vers BPE CANAL 1">Tiroir 144 vers BPE CANAL 1</option>
                            <option value="Tiroir 144 vers COGENT_MMRA">Tiroir 144 vers COGENT_MMRA</option>
                            <option value="Tiroir 36 SFR">Tiroir 36 SFR</option>
                            <option value="Tiroir 144 SPL RIN vers Canal/SFR">Tiroir 144 SPL RIN vers Canal/SFR</option>
                            <option value="Tiroir 12 Orange">Tiroir 12 Orange</option>
                            <option value="Tiroir 72 FULLSAVE-ZAYO">Tiroir 72 FULLSAVE-ZAYO</option>
                            <option value="Tiroir12 vers MIXART">Tiroir12 vers MIXART</option>
                            <option value="Tiroir12 vers bureau">Tiroir12 vers bureau</option>
                            <option value="Tiroir 144 vers COGENT_MMRB">Tiroir 144 vers COGENT_MMRB</option>
                            <option value="Tiroir36 vers salle TTN">Tiroir36 vers salle TTN</option>
                            <option value="Tiroir 36 vers COGENT">Tiroir 36 vers COGENT</option>
                            <option value="Tiroir 144 vers BPE TLS00">Tiroir 144 vers BPE TLS00</option>
                            <option value="Tiroir 144  SPL vers BPE01 Suisse">Tiroir 144  SPL vers BPE01 Suisse</option>
                            <option value="Tiroir 144 vers BPE3351_Suisse">Tiroir 144 vers BPE3351_Suisse</option>
                            <option value="Tiroir12 vers OPERAMETRIX">Tiroir12 vers OPERAMETRIX</option>
                		</optgroup>

                        <optgroup label="TLS02"> 
                            <option value="T96_LB01/TLS02">T96_LB01/TLS02</option>
                            <option value="TIRROIR_SPL001">TIRROIR_SPL001</option>
                            <option value="TIRROIR_SPL002">TIRROIR_SPL002</option>
                		</optgroup>
                		
                		 <optgroup label="TLS05"> 
                            <option value="MUX_TLS05-TLS00 via Ramassiers_TLS05">MUX_TLS05-TLS00 via Ramassiers_TLS05</option>
                            <option value="MUX_TLS05-TLS02 (via O2pub)">MUX_TLS05-TLS02 (via O2pub)</option>
                            <option value="T12_TLS05 vers C034689">T12_TLS05 vers C034689</option>
                            <option value="Tir.144_TLS05-1">Tir.144_TLS05-1</option>
                            <option value="Tir.144_TLS05-2">Tir.144_TLS05-2</option>
                            <option value="Tiroir INFOMIL">Tiroir INFOMIL</option>
                		</optgroup>
                		
                		<optgroup label="TLS06"> 
                            <option value="Tiroir_TLS06-1">Tiroir_TLS06-1</option>
                            <option value="Tiroir_TLS06-2">Tiroir_TLS06-2</option>
                		</optgroup>
                		
                		<optgroup label="LBG01"> 
                            <option value="TIROIR 144 LGB01">TIROIR 144 LGB01</option>
                            <option value="TIROIR 144-2">TIROIR 144-2</option>
                            <option value="TIROIR 144-3">TIROIR 144-3</option>
                		</optgroup>
                		
                		<optgroup label="BLM01"> 
                            <option value="U45.1à12-MMR1(Tr3à12)_13à24-MMR2(Tr3.1à12)">U45.1à12-MMR1(Tr3à12)_13à24-MMR2(Tr3.1à12)</option>
                            <option value="U41.1à6-MMR1.Tr23">U41.1à6-MMR1.Tr23</option>
                            <option value="U40.1à12-MMR1.tr31_19à24-1à6 T37MMR1">U40.1à12-MMR1.tr31_19à24-1à6 T37MMR1</option>
                            <option value="U39.1à12-B15 (Baie LPR)">U39.1à12-B15 (Baie LPR)</option>
                            <option value="U36.1à12 MMR1(Tr38) 13à24 MMR1(Tr47)">U36.1à12 MMR1(Tr38) 13à24 MMR1(Tr47)</option>
                            <option value="U33-37_tir144 vers MMR2">U33-37_tir144 vers MMR2</option>
                            <option value="U18-19_tir48 vers MMR1">U18-19_tir48 vers MMR1</option>
                		</optgroup>
                		
                		<optgroup label="SGD02"> 
                            <option value="144FO/1 BPE CAG10">144FO/1 BPE CAG10</option>
                            <option value="144FO/2 BPE LAN10">144FO/2 BPE LAN10</option>
                            <option value="144FO/3 BPE 150">144FO/3 BPE 150</option>
                		</optgroup>
                		
                		<optgroup label="MUR01"> 
                            <option value="Tiroir 144 MUR01 (1à6)">Tiroir 144 MUR01 (1à6)</option>
                		</optgroup>
                		
                		<optgroup label="COL01"> 
                            <option value="Tiroir 144 COL01">Tiroir 144 COL01</option>
                		</optgroup>
                		
                		<optgroup label="LSP01"> 
                            <option value="Tiroir 48 LSP01">Tiroir 48 LSP01</option>
                		</optgroup>
                		
                		<optgroup label="MON01"> 
                            <option value="Tiroir 144 MON01">Tiroir 144 MON01</option>
                		</optgroup>

                        <optgroup label="BDX01"> 
                            <option value="Tiroir 24Fo SFR (adduction SUD_fsn-ppa-00238)">Tiroir 24Fo SFR (adduction SUD_fsn-ppa-00238)</option>
                            <option value="Tiroir 24Fo SFR (adduction NORD_fsn-ppa-00239)">Tiroir 24Fo SFR (adduction NORD_fsn-ppa-00239)</option>
                		</optgroup>
                		
                		<optgroup label="BDX02"> 
                            <option value="Tiroir 288 BDX02">Tiroir 288 BDX02</option>
                		</optgroup>

                        <optgroup label="BDX03"> 
                            <option value="Interconnexions Opérateur MMR3">Interconnexions Opérateur MMR3</option>
                            <option value="BDX03_DEMI BAIE-FULLSAVE vers MMR1">BDX03_DEMI BAIE-FULLSAVE vers MMR1</option>
                            <option value="BDX03_DEMI BAIE-FULLSAVE vers MMR3">BDX03_DEMI BAIE-FULLSAVE vers MMR3</option>
                		</optgroup>

                        <optgroup label="TLS07"> 
                            <option value="Tiroir_TLS07-1 (Vers TLS00)">Tiroir_TLS07-1 (Vers TLS00)</option>
                            <option value="Tiroir_TLS07-2 (Vers LBG01)">Tiroir_TLS07-2 (Vers LBG01)</option>
                		</optgroup>

                        <optgroup label="BLA01"> 
                            <option value="Tiroir 144_BLA01">Tiroir 144_BLA01</option>
                		</optgroup>

                         
                    	</select></td>
               
               
                <td><select name="tube" class="form-control">';
                 if(!empty($tube)){
                     echo '   <option value="' . $tube . '">' . $tube . '</option>
                     <option></option>';
                }else{
                  echo '<option></option>  ';
                }

                        
                        for ($i = 1; $i <= 12; $i++) {
                	echo'	<option value="T'.$i.'">T'.$i.'</option>';
                        }
             echo '       	
                    	</select></td>
                <td><select name="fibre" class="form-control">';
                if(!empty($tube)){
                     echo '  <option value="' . $fibre . '">' . $fibre . '</option>
                     <option></option>';
                }else{
                  echo '<option></option>  ';
                }
                        
                        
                        for ($i = 1; $i <= 12; $i++) {
                	echo'	<option value="Fo'.$i.'">Fo'.$i.'</option>';
                        }
                        
             echo '     </td>
               
               
                <td><select name="etat" class="form-control">
                        <option value="' . $etat . '">' . $etat . '</option>
                		<option value="OK">OK</option>
                    	<option value="A faire">A faire</option>
                    	<option value="Port à reserver">Port à reserver</option>
                    	<option value="En cours">En cours</option>
                    	<option value="En Attente de bascule">En Attente de bascule</option>
                    	<option value="Attente demenagement">Attente demenagement</option>
                    	<option value="Standby">Standby</option>
                    	<option value="Abandonné">Abandonné</option>
                    	</select>
                </td>
                
                <td><textarea class="form-control" rows="2" cols="30" name="commentaire" >' . $commentaire . '</textarea></td>
                
                <td>
                <input type="hidden" value="' . $id_natira . '" name ="id"/>
                <input type="hidden" value="'.$_POST['page_OK'].'" name ="page_OK"/>
							
                		<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                		</form>
            </tr>';
            }
        echo '</table>';

echo '</center><br/><br/>';
require('../includes/foot.php');
?>
