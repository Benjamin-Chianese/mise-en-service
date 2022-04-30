<?php require('includes/head.php'); 





reste_routeur($bdd);

$maint = $bdd->query("SELECT count(*) AS maint from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
                 $checks_count = $maint->fetch();
      if($checks_count['maint'] > 0){
      
            echo '<center><h3>Maintenance en cours : </h3>';
            $maintenance = $bdd->query("SELECT * from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
            while ( $r = $maintenance->fetch(PDO::FETCH_ASSOC))    {
                
               echo  $r['id'].' - '.$r['affected_services'].' - '.date('d/m/Y H:i:s',strtotime($r['end'])).'<br/>';
            }
        echo '</center><br/>';
}

$date_nat = date('Y-m-d');

$maint_nat = $bdd->query("SELECT count(*) AS maint_nat from `maintenance` WHERE `begin` LIKE '".$date_nat."%' AND `provider` = 'Natira' AND `canceled` = 0");
                 $checks_count_nat = $maint_nat->fetch();
      if($checks_count_nat['maint_nat'] > 0){
      
        echo '<center><h3>Maintenance Natira : </h3>';
  echo '<table  border="1">
            <tr>
                <td>ID</td>
                <td>Début</td>
                <td>Fin</td>
                <td>Service impacté</td>
            </tr>';

          
            $maintenance_nat = $bdd->query("SELECT * from `maintenance` WHERE `begin` LIKE '".$date_nat."%' AND `provider` = 'Natira' AND `canceled` = 0");
            while ( $n = $maintenance_nat->fetch(PDO::FETCH_ASSOC))    {
            
                $ex_fsn_nat = explode(',',$n['affected_services']) ;
                $fsn_nat = $bdd->query("SELECT * FROM network_account WHERE service_ref  IN ('".implode("','",$ex_fsn_nat)."') ORDER BY collecte,service_ref ");

                
                
                echo '<tr>
                
               <td>'.$n['id'].'</td>
                <td>'.date('d-m-Y H:i', strtotime($n['begin'])).'</td>
                <td>'.date('d-m-Y H:i', strtotime($n['end'])).'</td>
                <td>';

                 while ( $ny = $fsn_nat->fetch(PDO::FETCH_ASSOC))    {
                     if(empty($ny['resiliation']) || $ny['resiliation'] == '0000-00-00'){
                     if(!empty($ny['service_tag_natira'])){
                     echo $ny['service_ref'].' - <strong>'.$ny['service_tag_natira'].'</strong> - '.$ny['name'].'<br/>';
                     }else{

                     echo $ny['service_ref'].' - '.$ny['name'].'<br/>';
                     }
                 }
                 }

        echo '</td></tr>';
                }
            echo '</table></center><br/>';

}

# semaine qu'on est 	
$semaine = date("W");
$annee = date('Y');
$annee_1Y = date('Y',strtotime($annee .'+1 YEAR'));

    # tableau de mes de la semaine
$mes_semaine = $bdd->query("SELECT * from `network_vision` WHERE `mes` IS NULL AND `mes_prevu` IS NOT NULL AND `annuler` = 0 GROUP BY mes_prevu ");

echo	'<center>

<table border="1">
        
		<tr style="background-color:#3399FF">
			<td><center> Semaine </center></td>
			<td><center> Mes </center></td>
			<td><center>CPE OK </center></td>
			<td><center>Circuit OK </center></td>
		</tr>
			';
			$avance_1Y ='';
			$avance_1 ='';
 while ( $r = $mes_semaine->fetch(PDO::FETCH_ASSOC))    {

    
        
       if ($r['mes_prevu'] <= 9){
           $mes_prevu = '0'.$r['mes_prevu'];
       }else{
           $mes_prevu = $r['mes_prevu'];
       }
        $annee_prevu = $r['ann_prevu'];

   
        
        if($mes_prevu < $semaine){
            if($annee_prevu == $annee){
            $retard = 0;
            $cpe_pret = 0;
            $circuit_pret =0;
            
            $pret_count  = $bdd->query("SELECT * from `network_vision` WHERE `mes_prevu` < '$semaine' AND `ann_prevu` = '$annee' AND `annuler` = 0 AND `mes` IS NULL");
             while ( $p = $pret_count->fetch(PDO::FETCH_ASSOC))    {
                 $retard++;
            if(!empty($p['location'])){
                $cpe_pret++;
            }
             if(!empty($p['circuit']) && $p['circuit'] == 'OK'){
                $circuit_pret++;
                    }
             } 
            }else{
                $c_1Y = 0;
                $cpe_pret_1Y = 0;
                $circuit_pret_1Y =0;
                $pret_count_1Y  = $bdd->query("SELECT * from `network_vision` WHERE `mes_prevu` = '$mes_prevu' AND `ann_prevu` = '$annee_1Y' AND `annuler` = 0 AND `mes` IS NULL");
                
                 while ( $p_1Y = $pret_count_1Y->fetch(PDO::FETCH_ASSOC))    {
                     $c_1Y++;
                if(!empty($p_1Y['location'])){
                $cpe_pret_1Y++;
                     }
                if(!empty($p_1Y['circuit']) && $p_1Y['circuit'] == 'OK'){
                $circuit_pret_1Y++;
                    }
                }
                $avance_1Y .= '
                <tr>
                <td>Semaine# '.$mes_prevu.' :</td>
                <td><center>'.$c_1Y.'</center></td>
                <td><center>'.$cpe_pret_1Y.'</center></td>
                <td><center>'.$circuit_pret_1Y.'</center></td>
                </tr>';
               
            }
   

        }else{
                $c_1 =0;
               $cpe_pret_1 = 0;
                $circuit_pret_1 =0;
                
                $pret_count_1  = $bdd->query("SELECT * from `network_vision` WHERE `mes_prevu` = '$mes_prevu' AND `ann_prevu` = '$annee' AND `annuler` = 0 AND `mes` IS NULL");
                 while ( $p_1 = $pret_count_1->fetch(PDO::FETCH_ASSOC))    {
                     $c_1++;
                if(!empty($p_1['location'])){
                $cpe_pret_1++;
                     }
                  if(!empty($p_1['circuit']) && $p_1['circuit'] == 'OK'){
                $circuit_pret_1++;
                    }
                }
                
                $avance_1 .= '
                <tr>
                <td>Semaine '.$mes_prevu.' :</td>
                <td><center>'.$c_1.'</center></td>
                <td><center>'.$cpe_pret_1.'</center></td>
                <td><center>'.$circuit_pret_1.'</center></td>
                </tr>';
                
        }
        
           
        
}
        echo '
                <tr>
                <td>Retard/différé :</td>
                <td><center>'.$retard.'</center></td>
                <td><center>'.$cpe_pret.'</center></td>
                <td><center>'.$circuit_pret.'</center></td>
                </tr>';
                echo $avance_1;
                echo $avance_1Y;
                echo '</table>';


$content = file_get_contents("https://live.sewan.fr/");


preg_match_all('/Trunk SIP
    
    
    <div class="pull-right">
        <small class="text-component-1 (.*?)" data-toggle="tooltip"/', $content , $trunk);


echo '<center><br/><br/>État Trunk SIP Sewan ';

if($trunk[1][0] != 'greens'){
    echo '<strong style="color:red;">NOK</strong>';
}else{
    echo '<strong style="color:green;">OK</strong>';
}






require('includes/foot.php'); 
?>
