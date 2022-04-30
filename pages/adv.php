<?php
require ('../includes/head.php');

$day = date('d-m-Y');




if (!empty($_POST['recomand'])){

    $reco_id = $_POST['recomand'];
    $status = $_POST['status']; 
    $date = date('Y-m-d');

    $ru_visu = $bdd->query("SELECT * FROM network_resiliation WHERE id_resil = '$reco_id' ");

     $y = $ru_visu->fetch(PDO::FETCH_ASSOC);
     $id_si = $y['si_id'];
     $test_relance = $y['relance'];
    $suppr = 1;
    
    if($status == 'Clôture'){
    
 $up = $bdd->prepare("UPDATE `network_resiliation` SET `suppr`= :suppr, `relance`= :status WHERE `id_resil` = :uid ");
			$up->execute(array("uid" => $reco_id,"suppr" => $suppr,"status" => $status));

        $comment = ' <br/>// Clôture du dossier le '.$day ;
			$up2 = $bdd->prepare("UPDATE `network_account` SET `comment`= CONCAT (comment,:comment) WHERE `id` = :idU ");
			$up2->execute(array(
				"idU" => $id_si,
				"comment" => $comment
			));
			
    }
    if($status == 'Traitement' && $test_relance != 'Traitement'){
        
         $up = $bdd->prepare("UPDATE `network_resiliation` SET `traitement`= :date, `relance`= :status  WHERE `id_resil` = :uid ");
			$up->execute(array("uid" => $reco_id,"date" => $date,"status" => $status ));
			
                $comment = ' <br/>// Traitement ADV le '.$day ;
			$up2 = $bdd->prepare("UPDATE `network_account` SET `comment`= CONCAT (comment,:comment) WHERE `id` = :idU ");
			$up2->execute(array(
				"idU" => $id_si,
				"comment" => $comment
			));
    }
    

}


$pépiniaire_req = $bdd->query("SELECT count(*) AS count_pepiniaire
	FROM `network_account` 
	WHERE `service_type` = 'Pepiniere'
	AND `resiliation` IS NULL
");

 $r = $pépiniaire_req->fetch();
 
 echo '<center><h3>Nombre de client pépiniere : <strong>'.$r['count_pepiniaire'].'</strong></h3></center><br/><br/>';

$reco = $bdd->query("SELECT * FROM network_resiliation WHERE  relance IN ('ADV','Traitement') AND suppr = '0' ORDER BY fin ASC");

echo '
    <center><table class="table table-bordered table-striped">
        <tr style="background-color:#3399FF">
			<td><center>FSLNK</center></td>
			<td><center>Client</center></td>
			<td><center>Fin <br/>Contrat</center></td>
			<td><center>Supplier</center></td>
			<td><center>Date<br/>Traitement </center></td>
            <td><center>Statut</center></td>
            <td><center>Eqts</center></td>
            <td><center>Ticket</center></td>
            <td><center>Validé</center></td>
		</tr>';
while ($y = $reco->fetch(PDO::FETCH_ASSOC))
    {
        $id_reco = $y['id_resil'];
        $si_id = $y['si_id'];
        $relance = $y['relance'];
        $traitement = $y['traitement'];
        
              $reco_acco = $bdd->query("SELECT * FROM network_account WHERE id = '$si_id' ");
            $w = $reco_acco->fetch(PDO::FETCH_ASSOC);

            $fslnk = $w['service_ref'];
            $name = $w['name'];
            $resiliation = date('d-m-Y', strtotime($w['resiliation']));
            $supplier = $w['supplier'];

        $cpe = '';
        
        switch($y['cpe']){
            
        case 'NOK':
                if($supplier == 'Natira' || $supplier == 'FullSave'){
                    $cpe = 'CPE NOK';
                }else{
                    $cpe = 'CPE + RAD NOK';
                }
		break;
		
		case 'NOK (CPE OK)':
                if($supplier != 'Natira' || $supplier != 'FullSave'){
                    $cpe = 'RAD NOK';
                }
		break;
		
		case 'NOK (RAD OK)':
                if($supplier != 'Natira' || $supplier != 'FullSave'){
                    $cpe = 'CPE NOK';
                }
		break;

        }
        
        if($y['traitement'] != '0000-00-00' ){
      $traitement =  date('d-m-Y', strtotime($y['traitement']));
        }else{
            $traitement = '';
        }
            
echo '	    <tr>
			<td><center>'.$fslnk.'</center></td>
			<td><center>'.$name.'</center></td>
			<td><center>'.$resiliation.'</center></td>
			<td><center>'.$supplier.'</center></td>
			<td><center>'.$traitement.'</center></td>
			
			<form method="post" action="adv.php">
			
            <td><center><select name="status" class="form-control">
        <option value="' . $relance . '">' . $relance . '</option>
		<option value="Traitement">Traitement</option>
    	<option value="Clôture">Clôture</option>
                </select></center></td>
                
            <td><center>'.$cpe.'</center></td>
            <td><center>'.$y['ticket'].'</center></td>
            
             
	       <td>
	       <input type="hidden" value="'.$id_reco.'" name ="recomand"/>
	       <button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button>
	       </form>
	       </td>

		</tr>';
		
    }
    
echo '</table></center><br/><br/>';
require('../includes/foot.php');
?>

