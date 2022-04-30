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

}

    


    
    $up = $bdd->prepare("UPDATE `network_fon` SET 
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
			"id" => $_POST['id']));
		

			$up_ref = $bdd->prepare("UPDATE `network_account` SET `linknumber`= :ref WHERE `id` = :uid ");
			$up_ref->execute(array(
				"uid" => $_POST['id'],
				"ref" => $_POST['ref']));
		

    echo "<center><h2>Mise à jour OK</h2></center>";
}


$recuperation = $bdd->query("SELECT * from `network_fon` INNER JOIN network_account  
WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND network_account.service_type NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
ORDER BY network_fon.si_id DESC");



echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Date MAJ</td>
                <td>Client - FSLNK </td>
                <td>Réf</td>
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
            
            
            if(!empty($r['date_natira']) && $r['date_natira'] != '0000-00-00'){
            
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

            
        
           
  
  
  
  
    echo '<tr>
    
                <td>'.$maj.'</td>
                <td>'.$r['name'].' - '.$r['service_ref'].' </td>
                <form method="post" action="natira_fon.php">
                <td><input  type="text"  class="form-control" name="ref"  value="'.$ref.'"/></td>
                <td>' . $r_site . '</td>
                <td><select name="tiroir" class="form-control">';

                if(!empty($tiroir)){
                       echo ' <option value="' . $tiroir . '">' . $tiroir . '</option>
                       <option value=""></option>';
                    }else{
                    echo'<option value=""></option>';
                    }
                        
                echo '      <optgroup label="TLS00"> 
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
                            <option value="BDX01_ODF-A_Tiroir 24">BDX01_ODF-A_Tiroir 24</option>
                		</optgroup>
                		<optgroup label="BDX02"> 
                            <option value="Tiroir 288 BDX02">Tiroir 288 BDX02</option>
                		</optgroup>

                        <optgroup label="TLS07"> 
                            <option value="Tiroir_TLS07-1 (Vers TLS00)">Tiroir_TLS07-1 (Vers TLS00)</option>
                            <option value="Tiroir_TLS07-2 (Vers LBG01)">Tiroir_TLS07-2 (Vers LBG01)</option>
                		</optgroup>
                        <optgroup label="BLA01"> 
                            <option value="Tiroir 144_BLA01">Tiroir 144_BLA01</option>
                		</optgroup>

                         <optgroup label="BDX03"> 
                            <option value="Interconnexions Opérateur MMR3">Interconnexions Opérateur MMR3</option>
                            <option value="BDX03_DEMI BAIE-FULLSAVE vers MMR1">BDX03_DEMI BAIE-FULLSAVE vers MMR1</option>
                            <option value="BDX03_DEMI BAIE-FULLSAVE vers MMR3">BDX03_DEMI BAIE-FULLSAVE vers MMR3</option>
                		</optgroup>

                    	</select></td>


                <td><select name="tube" class="form-control">';
                
                 if(!empty($tube)){
                       echo ' <option value="' . $tube . '">' . $tube . '</option>
                       <option value=""></option>';
                    }else{
                    echo'<option value=""></option>';
                    }

                        
                        for ($i = 1; $i <= 12; $i++) {
                	echo'	<option value="T'.$i.'">T'.$i.'</option>';
                        }
             echo '       	
                    	</select></td>
                <td><select name="fibre" class="form-control">';
                 if(!empty($fibre)){
                       echo ' <option value="' . $fibre . '">' . $fibre . '</option>
                       <option value=""></option>';
                    }else{
                    echo'<option value=""></option>';
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
                <input type="hidden" value="'.$id_natira.'" name ="id"/>
							
                		<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                		</form>
            </tr>';
            }
        echo '</table>';

echo '</center><br/><br/>';
require('../includes/foot.php');
?>
