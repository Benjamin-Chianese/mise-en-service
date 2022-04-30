<?php
require ('../includes/head.php');

$day = date('d-m-Y');

if(!empty($_POST['annuler_id'])){
    
            $id = $_POST['annuler_id'];
            $comment = ' <br/>//Annuler le '.$day;
            $resil = date('Y-m-d');
            $annuler = 1;
			$up = $bdd->prepare("UPDATE `network_account` SET `comment`= CONCAT (comment,:comment), `resiliation`= :resil WHERE `id` = :id ");
			$up->execute(array(
				"id" => $id,
				"resil" => $resil,
				"comment" => $comment
			));
			
			$up2 = $bdd->prepare("UPDATE `network_fon` SET `annuler`= :annuler WHERE `si_id` = :id ");
			$up2->execute(array(
				"id" => $id,
				"annuler" => $annuler
			));
}




if (!empty($_POST['id']))
{
    
    

    $semaine_J = date('W');
    $anne_j = date('Y');
	// Recuperation variable du post
    
	$uid = $_POST['id'];
	$fsn = $_POST['fsn'];
	$mes_format = $_POST['mes_prev'];
    $mesu = $_POST['mes'];
	$contactu = $_POST['contact'];
	$appelu = $_POST['appel'];



    $ru_visu = $bdd->query("SELECT * FROM network_fon WHERE si_id = '$uid' ");
	$y = $ru_visu->fetch(PDO::FETCH_ASSOC);
	$id_visu = $y['id'];
		$mes_visu = $y['mes_prevu'];
	$annee_visu = $y['ann_prevu'];

    if(!empty($mes_format)){
    	if (!empty($mes_visu) && $mes_visu == $mes_format ){

    		$mes_prevu = $mes_format;
    	    $ann_prevu = date('Y');
    	    
    	    }else{

    		if($mes_format >= $semaine_J){

    		$mes_prevu = $mes_format;
    	    $ann_prevu = date('Y');
    
    	        }else {

    	   $mes_prevu = $mes_format;
    	  $ann_prevu = date('Y',strtotime($anne_j.'+1 YEAR'));
    	        }
        
    	        }
	    }

	else{
	    $mes_prevu = '0';
	     $ann_prevu ='0';
	}
	
	
	if (empty($id_visu))
	{
   
		// Creation dans la base Visu si le FSLNK n'y ai pas

		$requete = $bdd->prepare("INSERT INTO network_fon (si_id,mes_prevu,ann_prevu,contact,appel) 
		VALUES(:uid, :mes_prevu, :ann_prevu, :contactu, :appelu)");
	$variable_req = array(
			"uid" => $uid,
			"mes_prevu" => $mes_prevu,
			"ann_prevu" => $ann_prevu,
			"contactu" => $contactu,
			"appelu" => $appelu
		);
	$requete->execute($variable_req);

	}
	else
	{

		// Update dans la base si le FSLNK y existe

		$up = $bdd->prepare("UPDATE `network_fon` SET 
			`mes_prevu`= :mes_prevu,
			`ann_prevu`= :ann_prevu,
			`contact`= :contactu,
			`appel` = :appelu
			 WHERE `id` = :id_visu ");
		$up->execute(array(
			"id_visu" => $id_visu,
			"mes_prevu" => $mes_prevu,
			"ann_prevu" => $ann_prevu,
			"contactu" => $contactu,
			"appelu" => $appelu
		));

	}
	
		if (!empty($mesu))
	{
	    $semaine = date('W',strtotime($mesu));
	    $annee = date('Y',strtotime($mesu));
	    
		$up2 = $bdd->prepare("UPDATE `network_fon` SET `mes`= :mesu,`mes_prevu`= :mes_prevu,
			`ann_prevu`= :ann_prevu,`commentaire_natira`= CONCAT (commentaire_natira,:com_nat), `etat`= :etat WHERE `id` = :id_visu");
			
		$up2->execute(array(
			"id_visu" => $id_visu,
			"mesu" => $mesu,
			"mes_prevu" => $semaine,
			"ann_prevu" => $annee,
			"com_nat" => ' // MES OK le '.date('d/m/Y'),
			"etat" => 'OK'
		));
		
		
		$up1 = $bdd->prepare("UPDATE `network_account` SET  `comment`= CONCAT (comment,:comment), `fs_service_delivery`= :mesu WHERE `id` = :uid");
		$up1->execute(array(
			"uid" => $uid,
			"mesu" => $mesu,
			"comment" => $appelu
		));
		

		
	}

}

// Tri dans la base si_plugin

$mes = $bdd->query("SELECT id,resiliation
    FROM network_account 
    WWHERE `fs_service_delivery` IS NULL
	AND  `resiliation` IS NULL 
    AND `service_type` NOT IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet','Transit IP','Porte de collecte','Porte de livraison')
	ORDER BY id DESC");

while ($checks = $mes->fetch(PDO::FETCH_ASSOC))
{

$check_id = $checks['id'];


 $check_fon = $bdd->query("SELECT COUNT(si_id) AS check_count FROM network_fon WHERE si_id = '$check_id' ");
 
 $checks_count = $check_fon->fetch();

if ($checks_count['check_count'] < 1 ) {



     $requete = $bdd->prepare("INSERT INTO network_fon (si_id) 
        VALUES(:id)");
        $requete->execute(array(
            "id" => $check_id
        ));
 }

}

	


// Tableau

echo  '
	<center><table class="table table-bordered table-striped" >
	    <thead class="thead-dark">
		<tr>
			<td><center>Client</center></td>
			<td><center>FSLNK</center></td>
			<td><center>Type</center></td>
			<td><center>Contact</center></td>
			<td><center>MES<br/>Prévu</center></td>
			<td><center>MES</center></td>
			<td><center>Commentaires</center></td>
			<td><center>MAJ</center></td>
		</tr>
		</thead>

';


while ($r = $mes->fetch(PDO::FETCH_ASSOC))
{
    
    

	// Variable table Si-plugin

	$id = $r['id'];
	$service = $r['service_type'];
	$fslnk = $r['service_ref'];
	$fslnkE = substr($fslnk, -5);

	// Rajout des donnÃ© en dynamique des info de la base visu

	$ru_vision = $bdd->query("SELECT * FROM network_fon WHERE si_id = '$id' ");
	$w = $ru_vision->fetch(PDO::FETCH_ASSOC);

	// Variable de la bse visu
	  
	
	$mes_prev = $w['mes_prevu'];
	$ann_prev = $w['ann_prevu'];
	$contact = $w['contact'];
	$appel = $w['appel'];


	// ajout des titres des colonnes toute les 15 lignes

	if ($j == 15)
	{
		$j = 0;
		 echo  '

		<thead class="thead-dark">
		<tr>
            <td ><center>Client</center></td>
			<td><center>FSLNK</center></td>
			<td><center>Type</center></td>
			<td><center>Contact</center></td>
			<td><center>MES<br/>Prévu</center></td>
			<td><center>MES</center></td>
			<td><center>Commentaires</center></td>
			<td><center>MAJ</center></td>
		</tr>
	</thead>

';
		
	}
	else
	{
		$j++;
	}

		echo '<tr>';


		echo '          <td><center>' . $r['name'] . '</center></td>
                		<td><center>' . $fslnkE . '</center></td>
                		<td><center>' . $service . '</center></td>
                		
                <form method="post" action="fon.php">
                		<td><center>	<textarea class="form-control" rows="2" cols="30" name="contact" >' . $contact . '</textarea> </center></td>
                		<td><center>	<input style="width:60" type="number" class="form-control" min="1" max="53" name="mes_prev" value="'.$mes_prev.'"/>	</center></td>
                		<td><center>	<input type="date" class="form-control" name="mes" />	</center></td>
                		<td><center>	<textarea class="form-control" rows="2" cols="30" name="appel" >' . $appel . '</textarea> </center></td>
                        <td><center>
                			<input type="hidden" value="' . $id . '" name ="id"/>
                			<input type="hidden" value="' . $r['service_ref'] . '" name ="fsn"/>
							
                	<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>
                	</form>
                		<form method="post" action="fon.php">
                    <input type="hidden" value="'.$id.'" name ="annuler_id"/>
                	<button type="submit" name="annuler" class="btn btn-outline-danger btn-sm mb-2">Annuler</button>
                		</form>
                		
                		</center></td>

                		</tr>';
}


require('../includes/foot.php');
?>
