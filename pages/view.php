<?php
require ('../includes/head.php');

#var_dump($_POST);
$day = date('Y-m-d');
if(!empty($_POST['head_rechercher'])){
    
    $search = $_POST['head_rechercher']; 
    $select_search = $_POST['head_select'];
    
    
     echo '<center>';    
    
    if($select_search == 'FSLNK'){
        
         $r_search_fslnk     =    $bdd->query("SELECT * FROM network_account WHERE service_ref LIKE '%".$search."%' ");
        
    echo "
    <h2>Résultat FSLNK</H2>
    <table class='table table-bordered table-striped'>
            <tr>
                <td>Client</td>
                <td>CPE</td>
                <td>Circuit</td>
                <td>MES</td>
                <td>Déprovision</td>
                <td>Récuperation</td>
                <td>Résiliation</td>
                <td>Collecte</td>
                <td>Vlan</td>
                <td>PE</td>
                <td>Site</td>
                <td>Fibre</td>
                <td>Modif</td>
            </tr>
            ";
            
     while ($r = $r_search_fslnk->fetch(PDO::FETCH_ASSOC)){

            $recup_mes      =    $bdd->query("SELECT * FROM network_vision WHERE si_id = ".$r['id']." ");
                $w = $recup_mes->fetch(PDO::FETCH_ASSOC);
                
             $recup_resil      =    $bdd->query("SELECT * FROM network_resiliation WHERE si_id = ".$r['id']." ");
                $z = $recup_resil->fetch(PDO::FETCH_ASSOC);
            
    if(!empty($r['service_ref'])){
        
         if(!empty($r['fs_service_delivery'])){
            
            $mes = date('d-m-Y',strtotime($r['fs_service_delivery']));
            }else{
                $mes = '';
            }
         if(!empty($r['resiliation'])){
            
            $resil = date('d-m-Y',strtotime($r['resiliation']));
            }else{
                $resil = '';
            }

        
        
        echo "<tr>
                <td>".$r['service_ref']." - ".$r['name']." </td>
                <td>".$w['location']."</td>
                <td>".$w['circuit']."</td>
                <td>".$mes."</td>
                <td>".$z['depro']."</td>
                <td>".$z['cpe']."</td>
                <td>".$resil."</td>
                <td>".$r['collecte']."</td>
                <td>".$r['vlan']."</td>
                <td>".$r['pe']."</td>
                <td>".$w['site']."</td>
                <td>".$w['tiroir']." - ".$w['tube']." - ".$w['fibre']."</td>
                <td>
                <form method='post' action='modif.php'>
                <input type='hidden' value='".$r['service_ref']."' name ='fslnk'/>
                <button type='submit' class='btn btn-outline-primary btn-sm mb-2'>Modifier</button>
                </form>
                </td>
        </tr>";
    }
        }
        echo "</table>";
    }  
    if($select_search == 'NAME'){    
        
        $r_search_name      =    $bdd->query("SELECT * FROM network_account WHERE name LIKE '%".$search."%'  ");
        
      echo "
    <h2>Résultat Nom client</H2>
    <table class='table table-bordered table-striped'>
            <tr>
                <td>Client</td>
                <td>CPE</td>
                <td>Circuit</td>
                <td>MES</td>
                <td>Déprovision</td>
                <td>Récuperation</td>
                <td>Résiliation</td>
                <td>Collecte</td>
                <td>Vlan</td>
                <td>PE / Porte livraison</td>
                <td>Site</td>
                <td>Fibre</td>
                <td>Modif</td>
            </tr>
            ";
              
    
    while ($t = $r_search_name->fetch(PDO::FETCH_ASSOC)){
        
         $recup_mes      =    $bdd->query("SELECT * FROM network_vision WHERE si_id = ".$t['id']." ");
                $w = $recup_mes->fetch(PDO::FETCH_ASSOC);
                
             $recup_resil      =    $bdd->query("SELECT * FROM network_resiliation WHERE si_id = ".$t['id']." ");
                $z = $recup_resil->fetch(PDO::FETCH_ASSOC);
    
    if(!empty($t['name'])){
        
        
         if(!empty($t['fs_service_delivery'])){
            
            $mes = date('d-m-Y',strtotime($t['fs_service_delivery']));
            }else{
                $mes = '';
            }
         if(!empty($t['resiliation'])){
            
            $resil = date('d-m-Y',strtotime($t['resiliation']));
            }else{
                $resil = '';
            }
        
        echo "<tr>
               <td>".$t['service_ref']." - ".$t['name']." </td>
                <td>".$w['location']."</td>
                <td>".$w['circuit']."</td>
                <td>".$mes."</td>
                <td>".$z['depro']."</td>
                <td>".$z['cpe']."</td>
                <td>".$resil."</td>
                <td>".$t['collecte']."</td>
                <td>".$t['vlan']."</td>";
                
                 if ($t['service_type'] == 'Collecte Ethernet'){
              
               $supplier_recup_name = $bdd->query("SELECT DISTINCT supplier FROM `network_account`WHERE 1 ORDER BY supplier");
        
                while ($recup_name = $supplier_recup_name->fetch(PDO::FETCH_ASSOC))
                {

                    $recup_operateur_name = $recup_name['supplier'];
                    $pos_name = stripos($t['name'], $recup_operateur_name);
                    if ($pos_name !== false) {
                        $find_name = $recup_operateur_name;
                            
                        }
                }

              
              
              $supplier_req_name = $bdd->query("SELECT `collecte` FROM `network_account` WHERE `service_type` = 'Porte de livraison' AND `name` LIKE '%".$find_name."%'  AND `resiliation` IS NULL");
	           $c_name = $supplier_req_name->fetch(PDO::FETCH_ASSOC);
	           
	           $asr_explode_name = explode(':' ,$c_name['collecte']);
	 
              echo "<td>".$c_name['collecte']."</td>";
	           
	           }else{
            echo "    <td>".$t['pe']."</td>";
                
	           }
                echo "<td>".$w['site']."</td>
                <td>".$w['tiroir']." - ".$w['tube']." - ".$w['fibre']."</td>
                <td>
                <form method='post' action='modif.php'>
                <input type='hidden' value='".$t['service_ref']."' name ='fslnk'/>
                <button type='submit' class='btn btn-outline-primary btn-sm mb-2'>Modifier</button>
                </form>
                </td>
        </tr>";
    }
        }
    echo "</table>";
    }
    if($select_search == 'COLLECTE'){ 
        
         $r_search_collecte  =    $bdd->query("SELECT * FROM network_account WHERE collecte LIKE '%".$search."%' AND resiliation IS NULL ORDER BY collecte");
        
    echo "
    <h2>Résultat Collecte</H2>
    <table class='table table-bordered table-striped'>
            <tr>
                <td>Client</td>
                <td>Éqts</td>
                <td>Service</td>
                <td>Débit</td>
                <td>Vlan</td>
                <td>Collecte</td>
                <td>Xconnect ingress</td>
                <td>Xconnect egress</td>
                <td>PE</td>
                <td>Fibre</td>
            </tr>";    
        
    while ($y = $r_search_collecte->fetch(PDO::FETCH_ASSOC)){
        $pe = $y['pe'];
        $type = $y['service_type'];
        $supplier = $y['supplier'];
        
        
        $debit = substr($y['bandwidth'], 0, -3);
        
        if ($debit >= 1000) {
            $bp = substr($debit, 0, -3).' Gb/s';
        }else{
            $bp = $debit.' Mb/s';
        }
        
        
         $recup      =    $bdd->query("SELECT * FROM network_vision WHERE si_id = ".$y['id']." ");
                $w = $recup->fetch(PDO::FETCH_ASSOC);
        
    if(!empty($y['collecte'])){
        echo "<tr>
                <td>".$y['service_ref']." - ".$y['name']." </td>
                <td>".$y['eqts']."</td>
                <td>".$type."</td>
                <td>".$bp."</td>
                <td>".$y['vlan']."</td>
                <td>".$y['collecte']."</td>";
                
        ## xconnect ingress
        
        $search_m36 = stripos($y['collecte'], 'm36');
                    if ($search_m36 !== false) {
                        $m36_explode = explode(':' ,$y['collecte']);
	           $m36 = $m36_explode[0];
           
 echo "<td>".$y['collecte']." - ".$ip_asr[$m36]."</td>";
                            
                        }
        $search_m49 = stripos($y['collecte'], 'm49');
                    if ($search_m49 !== false) {
                      
              $m49_explode = explode(':' ,$y['collecte']);
	           $m49 = $m49_explode[0];
	           
	           $m49_asr = explode(':' ,$m49_asr_port[$m49]);
	
              echo "<td>".$m49_asr_port[$m49]." - ".$ip_asr[$m49_asr[0]]."</td>";
                            
                        }
        $search_asr = stripos($y['collecte'], 'asr');
                    if ($search_asr !== false) {
                        
                        $asr_explode_2 = explode(':' ,$y['collecte']);
	           $asr_2 = $asr_explode_2[0];
           
            if($asr_2 == 'lij01-1-asr920'){
                $asr_2 = 'tls01-1-m36';
              echo "<td>tls01-1-m36:Po1 - ".$ip_asr[$asr_2]."</td>";

            }else{
              echo "<td>".$y['collecte']." - ".$ip_asr[$asr_2]."</td>";
            }

                      
                            
                        }
         
         ## xconnect egress
         
          if ($type == 'Collecte Ethernet'){
              
               $supplier_recup = $bdd->query("SELECT DISTINCT supplier FROM `network_account`WHERE 1 ORDER BY supplier");
        
                while ($recup = $supplier_recup->fetch(PDO::FETCH_ASSOC))
                {

                    $recup_operateur = $recup['supplier'];
                    $pos = stripos($y['name'], $recup_operateur);
                    if ($pos !== false) {
                        $find = $recup_operateur;
                            
                        }
                }

              
              
              $supplier_req = $bdd->query("SELECT `collecte` FROM `network_account` WHERE `service_type` = 'Porte de livraison' AND `name` LIKE '%".$find."%'  AND `resiliation` IS NULL");
	           $c = $supplier_req->fetch(PDO::FETCH_ASSOC);
	           
	           $asr_explode = explode(':' ,$c['collecte']);
	           $asr = $asr_explode[0];

	           if(!empty($ip_asr[$asr])){
              echo "<td>".$c['collecte']." - ".$ip_asr[$asr]."</td>";
	           }else{
	           echo "<td>".$c['collecte']."</td>";   
	           }
          }else{
              
              
              $asr_explode = explode(':' ,$pe_asr_port[$pe]);
	           $asr = $asr_explode[0];
	           if(!empty($ip_asr[$asr])){
              echo "<td>".$pe_asr_port[$pe]." - ".$ip_asr[$asr]."</td>";
	           }else{
	                echo "<td>".$pe_asr_port[$pe]."</td>";
	           }
          }     
                
        echo "
                
                <td>".$pe."</td>
                <td>".$w['tiroir']." - ".$w['tube']." - ".$w['fibre']."</td>
        </tr>" ;
    }
        }   
    echo "</table>";
    }
    if($select_search == 'PE'){    
        
        $r_search_name      =    $bdd->query("SELECT * FROM network_account WHERE pe LIKE '%".$search."%' AND pe IS NOT NULL  ");
        
      echo "
    <h2>Résultat PE client</H2>
    <table class='table table-bordered table-striped'>
            <tr>
                <td>Client</td>
                <td>Vlan</td>
                <td>PE</td>
            </tr>
            ";
              
    
    while ($t = $r_search_name->fetch(PDO::FETCH_ASSOC)){
        
         $recup_mes      =    $bdd->query("SELECT * FROM network_vision WHERE si_id = ".$t['id']." ");
                $w = $recup_mes->fetch(PDO::FETCH_ASSOC);
                
             $recup_resil      =    $bdd->query("SELECT * FROM network_resiliation WHERE si_id = ".$t['id']." ");
                $z = $recup_resil->fetch(PDO::FETCH_ASSOC);
    
    if(!empty($t['name'])){
        
        
         if(!empty($t['fs_service_delivery'])){
            
            $mes = date('d-m-Y',strtotime($t['fs_service_delivery']));
            }else{
                $mes = '';
            }
         if(!empty($t['resiliation'])){
            
            $resil = date('d-m-Y',strtotime($t['resiliation']));
            }else{
                $resil = '';
            }
        
        echo "<tr>
               <td>".$t['service_ref']." - ".$t['name']." </td>

                <td>".$t['vlan']."</td>
                <td>".$t['pe']."</td>
        </tr>";
    }
        }
    echo "</table>";
    }
    if($select_search == 'REF'){    
        
        $r_search_name      =    $bdd->query("SELECT * FROM network_account WHERE linknumber LIKE '%".$search."%'  ");
        
      echo "
    <h2>Résultat Référence opérateur</H2>
    <table class='table table-bordered table-striped'>
            <tr>
                <td>Client</td>
                <td>CPE</td>
                <td>MES</td>
                <td>Référence</td>
                <td>Vlan</td>
                <td>PE / Porte livraison</td>
                <td>Site</td>
                <td>Fibre</td>
                <td>Modif</td>
            </tr>
            ";
              
    
    while ($t = $r_search_name->fetch(PDO::FETCH_ASSOC)){
        
         $recup_mes      =    $bdd->query("SELECT * FROM network_vision WHERE si_id = ".$t['id']." ");
                $w = $recup_mes->fetch(PDO::FETCH_ASSOC);
                
             $recup_resil      =    $bdd->query("SELECT * FROM network_resiliation WHERE si_id = ".$t['id']." ");
                $z = $recup_resil->fetch(PDO::FETCH_ASSOC);
    
    if(!empty($t['name'])){
        
        
         if(!empty($t['fs_service_delivery'])){
            
            $mes = date('d-m-Y',strtotime($t['fs_service_delivery']));
            }else{
                $mes = '';
            }
         if(!empty($t['resiliation'])){
            
            $resil = date('d-m-Y',strtotime($t['resiliation']));
            }else{
                $resil = '';
            }
        
        echo "<tr>
               <td>".$t['service_ref']." - ".$t['name']." </td>
                <td>".$t['eqts']."</td>
                <td>".$mes."</td>
                <td>".$t['linknumber']."</td>
                <td>".$t['vlan']."</td>";
                
                 if ($t['service_type'] == 'Collecte Ethernet'){
              
               $supplier_recup_name = $bdd->query("SELECT DISTINCT supplier FROM `network_account`WHERE 1 ORDER BY supplier");
        
                while ($recup_name = $supplier_recup_name->fetch(PDO::FETCH_ASSOC))
                {

                    $recup_operateur_name = $recup_name['supplier'];
                    $pos_name = stripos($t['name'], $recup_operateur_name);
                    if ($pos_name !== false) {
                        $find_name = $recup_operateur_name;
                            
                        }
                }

              
              
              $supplier_req_name = $bdd->query("SELECT `collecte` FROM `network_account` WHERE `service_type` = 'Porte de livraison' AND `name` LIKE '%".$find_name."%'  AND `resiliation` IS NULL");
	           $c_name = $supplier_req_name->fetch(PDO::FETCH_ASSOC);
	           
	           $asr_explode_name = explode(':' ,$c_name['collecte']);
	 
              echo "<td>".$c_name['collecte']."</td>";
	           
	           }else{
            echo "    <td>".$t['pe']."</td>";
                
	           }
                echo "<td>".$w['site']."</td>
                <td>".$w['tiroir']." - ".$w['tube']." - ".$w['fibre']."</td>
                <td>
                <form method='post' action='modif.php'>
                <input type='hidden' value='".$t['service_ref']."' name ='fslnk'/>
                <button type='submit' class='btn btn-outline-primary btn-sm mb-2'>Modifier</button>
                </form>
                </td>
        </tr>";
    }
        }
    echo "</table>";
    }
    if($select_search == 'MAINT'){   
        
        if(!empty($_POST['maint_id']) ){
            
            echo "<table border='1'>
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
        echo "</td></tr></table><br/><br/>";
        }

        
        $r_search_name      =    $bdd->query("SELECT * FROM maintenance WHERE id LIKE '%".$search."%' ");
        
      echo "
    <h2>Résultat Maintenance</H2>
    <table class='table table-bordered table-striped'>
            <tr>
                 <td>ID</td>
                <td>Début</td>
                <td>Fin</td>
                <td>Durée</td>
                <td>Supplier</td>
                <td>Cause</td>
                <td>Impact</td>
                <td>Service impacté</td>
                <td>Downtime</td>
            </tr>
            ";
              
    
    while ($r = $r_search_name->fetch(PDO::FETCH_ASSOC)){
        
         $ex_fsn = explode(',',$r['affected_services']) ;


        $fsn = $bdd->query("SELECT * FROM network_account WHERE service_ref  IN ('".implode("','",$ex_fsn)."') ORDER BY collecte");


       echo ' <tr>';
       if($r['canceled'] == 0){
           echo '<td>'.$r['id'].'</td>';
       }else{
           echo '<td>'.$r['id'].' (Annulé)</td>';
       }
                
       echo '
                <td>'.date('d-m-Y H:i', strtotime($r['begin'])).'</td>
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

                <form method="post" action="view.php">
                <input type="hidden" value="'.$r['id'].'" name ="maint_id"/>
                 <input type="hidden" value="'.$search.'" name ="head_rechercher"/>
                 <input type="hidden" value="'.$select_search.'" name ="head_select"/>

                <center><button type="submit" class="btn btn-outline-primary btn-sm mb-2">Downtime</button>
                </center></td>
                </form>
            </tr>';

        }
    echo "</table>";
    }
    
    
    if($select_search == 'PRESTA'){   
        
        if(!empty($_POST['id'])){
    #var_dump($_POST);
    
    
		$up = $bdd->prepare("UPDATE `network_vision` SET 
		`prio`= :prio,
		`natira_presta_gc`= :natira_presta_gc,
		`natira_presta_fo`= :natira_presta_fo,
		`natira_kmz`= :natira_kmz,
		`natira_vt`= :natira_vt,
		`natira_apd`= :natira_apd,
		`natira_voirie`= :natira_voirie,
		`natira_gc`= :natira_gc,
		`natira_aiguillage`= :natira_aiguillage,
		`natira_blo`= :natira_blo,
		`natira_tirage`= :natira_tirage,
		`natira_racco`= :natira_racco,
		`natira_doe`= :natira_doe,
		`suivi_natira_commentaire` = :commentaire,
		`natira_limite_mes` = :limite_mes
		WHERE `si_id` = :id");
			
	    $up->execute(array(
	        "prio" => $_POST['prio'],
	        "natira_presta_gc" => $_POST['presta_gc'],
	        "natira_presta_fo" => $_POST['presta_fo'],
	        "natira_kmz" => $_POST['kmz'],
	        "natira_vt" => $_POST['vt'],
	        "natira_apd" => $_POST['apd'],
	        "natira_voirie" => $_POST['voirie'],
	        "natira_gc" => $_POST['gc'],
	        "natira_aiguillage" => $_POST['aiguillage'],
	        "natira_blo" => $_POST['blo'],
	        "natira_tirage" => $_POST['tirage'],
	        "natira_racco" => $_POST['racco'],
	        "natira_doe" => $_POST['doe'],
	        "commentaire" => $_POST['commentaire'],
	        "limite_mes" => $_POST['limite_mes'],
	        "id" => $_POST['id']));
  

  
}
        if(!empty($_POST['id_fon'])){
   # var_dump($_POST);
    
    
		$up = $bdd->prepare("UPDATE `network_fon` SET 
		`prio`= :prio,
		`natira_presta_gc`= :natira_presta_gc,
		`natira_presta_fo`= :natira_presta_fo,
		`natira_kmz`= :natira_kmz,
		`natira_vt`= :natira_vt,
		`natira_apd`= :natira_apd,
		`natira_voirie`= :natira_voirie,
		`natira_gc`= :natira_gc,
		`natira_aiguillage`= :natira_aiguillage,
		`natira_blo`= :natira_blo,
		`natira_tirage`= :natira_tirage,
		`natira_racco`= :natira_racco,
		`natira_doe`= :natira_doe,
		`suivi_natira_commentaire` = :commentaire,
		`natira_limite_mes` = :limite_mes
		WHERE `si_id` = :id");
			
	    $up->execute(array(
	        "prio" => $_POST['prio'],
	        "natira_presta_gc" => $_POST['presta_gc'],
	        "natira_presta_fo" => $_POST['presta_fo'],
	        "natira_kmz" => $_POST['kmz'],
	        "natira_vt" => $_POST['vt'],
	        "natira_apd" => $_POST['apd'],
	        "natira_voirie" => $_POST['voirie'],
	        "natira_gc" => $_POST['gc'],
	        "natira_aiguillage" => $_POST['aiguillage'],
	        "natira_blo" => $_POST['blo'],
	        "natira_tirage" => $_POST['tirage'],
	        "natira_racco" => $_POST['racco'],
	        "natira_doe" => $_POST['doe'],
	        "commentaire" => $_POST['commentaire'],
	        "limite_mes" => $_POST['limite_mes'],
	        "id" => $_POST['id_fon']));

  
  
}


        $r_search_name      =    $bdd->query("SELECT * from `network_vision` INNER JOIN network_account  
WHERE network_vision.si_id = network_account.id 
AND network_account.supplier IN ('Natira')
AND (network_vision.natira_doe IS NULL OR network_vision.natira_doe = '0000-00-00')
AND network_account.service_type IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','FON')
AND (network_vision.natira_presta_gc LIKE '%".$search."%' OR network_vision.natira_presta_fo LIKE '%".$search."%')
ORDER BY network_vision.prio ASC,network_vision.id DESC
 ");
        
      echo '
    <h2>Résultat Presta</H2>

<h2>MES</H2>
     <table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Client - FSLNK </td>
                <td>Prio</td>
                <td>Presta GC</td>
                <td>Presta FO</td>
                <td>Lancement client</td>
                <td>Route<br/>Optique</td>
                <td>VT</td>
                <td>Validation</br>APD</td>
                <td>Arret</br>Voirie</td>
                <td>GC</td>
                <td>Aiguillage</td>
                <td>BLO</td>
                <td>Tirage</td>
                <td>Racco</br>Desserte</td>
                <td>DOE</td>
                <td>Limite</br>MES</td>
                <td data-width="150" >Commenataire</td>
                <td>MAJ</td>
            </tr>
        </thead>';
            
        while ($r = $r_search_name->fetch(PDO::FETCH_ASSOC)){
            
            if(!empty($r['date_natira']) && $r['date_natira'] != '0000-00-00'){
            
            $date_ro = date('d-m-Y',strtotime($r['date_natira']));
            }else{
                $date_ro = 'N/A';
            }


            
            $id_natira =$r['si_id'];
            

            echo '
            <tr>
                
                
                <form method="post" action="view.php">';

                if(!empty($r['prio'])){
                    switch ($r['prio']){
                       case 1:
                 echo '
                 <td style="background-color:#CC3E54">'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                       <option value="1">1</option>
	                   <option value="4"></option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';
                       break;
                       case 2:
                 echo '
                  <td style="background-color:#DBD23A">'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                       <option value="2">2</option>
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="3">3</option>
                       ';
                       break;
                       case 3:
                 echo '
                      <td style="background-color:#20AE51">'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">  
                       <option value="3">3</option>
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="2">2</option>
                       ';
                       break;
                       case 4:
                 echo '
                      <td>'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">  
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';
                       break;
                      
                        
                    }
                }else{
                     echo '
                      <td >'.$r['name'].' - '.$r['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                     <option value="4"></option>
	                   <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';     
                }
                echo '
                 </select></center>
                </td>
                <td><center><select name="presta_gc"  class="form-control">';
	                            if(!empty($r['natira_presta_gc'])){
                    switch ($r['natira_presta_gc']){
            case 'SOCOM TP':
                 echo '<option value="SOCOM TP">SOCOM TP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'LHERM TP':
                 echo '<option value="LHERM TP">LHERM TP</option>
	                   <option value=""></option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'STP':
                 echo '<option value="STP">STP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'CASSAGNE TP':
                 echo '<option value="CASSAGNE TP">CASSAGNE TP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       ';
                       break;

                    }
                }else{
                     echo '
	                   <option value=""></option>
	                   <option value="SOCOM TP">SOCOM TP</option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';     
                }
                echo'       </select></center></td>
                <td><center><select name="presta_fo"  class="form-control">';
	                            if(!empty($r['natira_presta_fo'])){
                    switch ($r['natira_presta_fo']){
                       
            case 'SOCOM':
                 echo '<option value="SOCOM">SOCOM</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'RESONANCE':
                 echo '<option value="RESONANCE">RESONANCE</option>
	                   <option value=""></option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'EIFFAGE':
                 echo '<option value="EIFFAGE">EIFFAGE</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'AXIONE':
                 echo '<option value="AXIONE">AXIONE</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'SNEF':
                 echo '<option value="SNEF">SNEF</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SOCOM">SOCOM</option>
                       ';
                       break;
                    }
                }else{
                     echo '
	                   <option value=""></option>
	                   <option value="SOCOM">SOCOM</option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';     
                }
                        echo'</select></center>
                </td>
                <td><center><input type="date" class="form-control" name="kmz" value ="'.$r['natira_kmz'].'"/></center></td>
                <td><center>'.$date_ro.'</center></td>
                <td><center><input type="date" class="form-control" name="vt" value ="'.$r['natira_vt'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="apd" value ="'.$r['natira_apd'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="voirie" value ="'.$r['natira_voirie'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="gc" value ="'.$r['natira_gc'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="aiguillage" value ="'.$r['natira_aiguillage'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="blo" value ="'.$r['natira_blo'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="tirage" value ="'.$r['natira_tirage'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="racco" value ="'.$r['natira_racco'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="doe" value ="'.$r['natira_doe'].'" /></center></td>';
                if(!empty($r['natira_limite_mes']) && $r['natira_limite_mes'] != '0000-00-00' ){
                    if(strtotime($day) >= strtotime($r['natira_limite_mes']) ){
                    echo '<td style="background-color:#8C2CDD"><center><input type="date" class="form-control" name="limite_mes" value ="'.$r['natira_limite_mes'].'" /></center></td>';
                    }else{
                        echo '<td><center><input type="date" class="form-control" name="limite_mes" value ="'.$r['natira_limite_mes'].'" /></center></td>';
                    }
                }else{
                    echo '<td><center><input type="date" class="form-control" name="limite_mes" value ="'.$r['natira_limite_mes'].'" /></center></td>';
                }

                
                echo 
'<td><textarea class="form-control" rows="2" cols="30" name="commentaire" >' .$r['suivi_natira_commentaire']. '</textarea></td>
                <td>
                <input type="hidden" value="'.$id_natira.'" name ="id"/>
                <input type="hidden" value="'.$search.'" name ="head_rechercher"/>
                 <input type="hidden" value="'.$select_search.'" name ="head_select"/>
                <button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                </td>
            </tr>
            </form>
           ';
  
  
  
  }
   
        echo '</table>';


$r_search_name_fon   =    $bdd->query("SELECT * from `network_fon` INNER JOIN network_account  
WHERE network_fon.si_id = network_account.id 
AND network_account.supplier IN ('Natira','FullSave')
AND (network_fon.natira_doe IS NULL OR network_fon.natira_doe = '0000-00-00')
AND (network_fon.natira_presta_gc LIKE '%".$search."%' OR network_fon.natira_presta_fo LIKE '%".$search."%')
ORDER BY network_fon.prio ASC,network_fon.id DESC
 ");
        
      echo '


<h2>FON</H2>
     <table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Client - FSLNK </td>
                <td>Prio</td>
                <td>Presta GC</td>
                <td>Presta FO</td>
                <td>Lancement client</td>
                <td>Route<br/>Optique</td>
                <td>VT</td>
                <td>Validation</br>APD</td>
                <td>Arret</br>Voirie</td>
                <td>GC</td>
                <td>Aiguillage</td>
                <td>BLO</td>
                <td>Tirage</td>
                <td>Racco</br>Desserte</td>
                <td>DOE</td>
                <td>Limite</br>MES</td>
                <td data-width="150" >Commenataire</td>
                <td>MAJ</td>
            </tr>
        </thead>';
            
        while ($f = $r_search_name_fon->fetch(PDO::FETCH_ASSOC)){
            
            if(!empty($f['date_natira'])  && $f['date_natira'] != '0000-00-00'){
            
            $date_ro_fon = date('d-m-Y',strtotime($f['date_natira']));
            }else{
                $date_ro_fon = 'N/A';
            }


            
            $id_natira_fon =$f['si_id'];
            

            echo '
            <tr>
                
                
                <form method="post" action="view.php">';

                if(!empty($f['prio'])){
                    switch ($f['prio']){
                       case 1:
                 echo '
                 <td style="background-color:#CC3E54">'.$f['name'].' - '.$f['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                       <option value="1">1</option>
	                   <option value="4"></option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';
                       break;
                       case 2:
                 echo '
                  <td style="background-color:#DBD23A">'.$f['name'].' - '.$f['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                       <option value="2">2</option>
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="3">3</option>
                       ';
                       break;
                       case 3:
                 echo '
                      <td style="background-color:#20AE51">'.$f['name'].' - '.$f['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">  
                       <option value="3">3</option>
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="2">2</option>
                       ';
                       break;
                       case 4:
                 echo '
                      <td>'.$f['name'].' - '.$f['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">  
	                   <option value="4"></option>
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';
                       break;
                      
                        
                    }
                }else{
                     echo '
                      <td >'.$f['name'].' - '.$f['service_ref'].' </td>
                <td><center><select name="prio"  class="form-control">
                     <option value="4"></option>
	                   <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       ';     
                }
                echo '
                 </select></center>
                </td>
                <td><center><select name="presta_gc"  class="form-control">';
	                            if(!empty($f['natira_presta_gc'])){
                    switch ($f['natira_presta_gc']){
            case 'SOCOM TP':
                 echo '<option value="SOCOM TP">SOCOM TP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'LHERM TP':
                 echo '<option value="LHERM TP">LHERM TP</option>
	                   <option value=""></option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'STP':
                 echo '<option value="STP">STP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';
                       break;
            case 'CASSAGNE TP':
                 echo '<option value="CASSAGNE TP">CASSAGNE TP</option>
	                   <option value=""></option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="SOCOM TP">SOCOM TP</option>
                       ';
                       break;

                    }
                }else{
                     echo '
	                   <option value=""></option>
	                   <option value="SOCOM TP">SOCOM TP</option>
                       <option value="LHERM TP">LHERM TP</option>
                       <option value="STP">STP</option>
                       <option value="CASSAGNE TP">CASSAGNE TP</option>
                       ';     
                }
                echo'       </select></center></td>
                <td><center><select name="presta_fo"  class="form-control">';
	                            if(!empty($f['natira_presta_fo'])){
                    switch ($f['natira_presta_fo']){
                       
            case 'SOCOM':
                 echo '<option value="SOCOM">SOCOM</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'RESONANCE':
                 echo '<option value="RESONANCE">RESONANCE</option>
	                   <option value=""></option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'EIFFAGE':
                 echo '<option value="EIFFAGE">EIFFAGE</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'AXIONE':
                 echo '<option value="AXIONE">AXIONE</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="SOCOM">SOCOM</option>
                       <option value="SNEF">SNEF</option>
                       ';
                       break;
            case 'SNEF':
                 echo '<option value="SNEF">SNEF</option>
	                   <option value=""></option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SOCOM">SOCOM</option>
                       ';
                       break;
                    }
                }else{
                     echo '
	                   <option value=""></option>
	                   <option value="SOCOM">SOCOM</option>
                       <option value="RESONANCE">RESONANCE</option>
                       <option value="EIFFAGE">EIFFAGE</option>
                       <option value="AXIONE">AXIONE</option>
                       <option value="SNEF">SNEF</option>
                       ';     
                }
                        echo'</select></center>
                </td>
                <td><center><input type="date" class="form-control" name="kmz" value ="'.$f['natira_kmz'].'"/></center></td>
                <td><center>'.$date_ro_fon.'</center></td>
                <td><center><input type="date" class="form-control" name="vt" value ="'.$f['natira_vt'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="apd" value ="'.$f['natira_apd'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="voirie" value ="'.$f['natira_voirie'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="gc" value ="'.$f['natira_gc'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="aiguillage" value ="'.$f['natira_aiguillage'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="blo" value ="'.$f['natira_blo'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="tirage" value ="'.$f['natira_tirage'].'" /></center></td>
                <td><center><input type="number" max="53" class="form-control" name="racco" value ="'.$f['natira_racco'].'" /></center></td>
                <td><center><input type="date" class="form-control" name="doe" value ="'.$f['natira_doe'].'" /></center></td>';
                if(!empty($f['natira_limite_mes']) && $f['natira_limite_mes'] != '0000-00-00' ){
                    if(strtotime($day) >= strtotime($f['natira_limite_mes']) ){
                    echo '<td style="background-color:#8C2CDD"><center><input type="date" class="form-control" name="limite_mes" value ="'.$f['natira_limite_mes'].'" /></center></td>';
                    }else{
                        echo '<td><center><input type="date" class="form-control" name="limite_mes" value ="'.$f['natira_limite_mes'].'" /></center></td>';
                    }
                }else{
                    echo '<td><center><input type="date" class="form-control" name="limite_mes" value ="'.$f['natira_limite_mes'].'" /></center></td>';
                }

                
                echo 
'<td><textarea class="form-control" rows="2" cols="30" name="commentaire" >' .$f['suivi_natira_commentaire']. '</textarea></td>
                <td>
                <input type="hidden" value="'.$id_natira_fon.'" name ="id_fon"/>
                <input type="hidden" value="'.$search.'" name ="head_rechercher"/>
                 <input type="hidden" value="'.$select_search.'" name ="head_select"/>
                <button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                </td>
            </tr>
            </form>
           ';
  
  
  
  }
   
        echo '</table>';


    }
    echo '</center>';
        
}
?>
