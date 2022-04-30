<?php
require ('../includes/head.php');

$day = date('d-m-Y');

$tableau = '
        <thead class="thead-dark">
        <tr>
			<td><center>FSLNK</center></td>
			<td><center>Client</center></td>
			<td><center>Fin <br/>Contrat</center></td>
			<td><center>Supplier</center></td>
			<td><center>VLAN</center></td>
			<td><center>PE</center></td>
			<td><center>Resil <br/> Opérateur</center></td>
			<td><center>Shut PE</center></td>
			<td><center>Dépro</center></td>
			<td><center>RT</center></td>
			<td><center>Statut</center></td>
			<td><center>Récupéré</center></td>
            <td><center>Ticket</center></td>
			<td><center>MAJ</center></td>
		</tr>
		</thead>';



if (!empty($_POST['mail_id']))
{

$si_id = $_POST['mail_id'];


 $req = $bdd->query("SELECT *
	FROM network_account 
    WHERE id = '$si_id'

    ");
 $z = $req->fetch(PDO::FETCH_ASSOC);
 
 $fslnk = $z['service_ref'];
 
 $link = $z['linknumber'];
 $operateur = $z['supplier'];
 
 $equipements = $z['eqts'];
 $name = htmlspecialchars($z['name']);
 $mail = $z['contact_mail'];
 $ad = htmlspecialchars($z['adresse']);
 $adsup = htmlspecialchars($z['adressesupp']);
 $cp = $z['cp'];
 $ville = htmlspecialchars($z['localite']);
 
 $adresse = $ad;
 
 if (!empty($adsup)){
     $adresse = ' '.$adsup;
 }
 
 $adresse .= ' '.$cp.' '.$ville;
 
 $eqts = explode(',', $equipements);
 
 
 relance($eqts,$name,$mail,$adresse,$fslnk,$link,$operateur,$si_id);

}


if (!empty($_POST['id']))
{

    // Recuperation variable du post

    $idU = $_POST['id'];
    $snU = $_POST['sn'];
    $finU = $_POST['fin'];
    $resilU = $_POST['resil'];
    $peU = $_POST['pe'];
    $deproU = $_POST['depro'];
    $rtU = $_POST['rt'];
    $relanceU = $_POST['relance'];
    $cpeU = $_POST['cpe'];
    $ticketU = $_POST['ticket'];


    $ru_visu = $bdd->query("SELECT * FROM network_resiliation WHERE si_id = '$idU' ");
    $y = $ru_visu->fetch(PDO::FETCH_ASSOC);
    $id_visu = $y['id_resil'];
    $test_depro = $y['depro'];
    $test_cpe = $y['cpe'];
    


    if (empty($id_visu))
    {

        // Creation dans la base Visu si le FSLNK n'y ai pas

        $requete = $bdd->prepare("INSERT INTO network_resiliation (si_id,fin,resil,pe,rt,ticket) 
        VALUES(:id, :sn, :fin, :resil, :pe, :rt, :ticket)");
        $requete->execute(array(
            "id" => $idU,
            "fin" => $finU,
            "resil" => $resilU,
            "pe" => $peU,
            "rt" => $rtU,
            "ticket" => $ticketU
        ));
    }
    else
    {
        // Update dans la base si le FSLNK y existe
        $up = $bdd->prepare("UPDATE `network_resiliation` SET 

            `fin`= :fin,
            `resil`= :resil,
            `pe`= :pe,
            `rt`= :rt,
            `ticket` = :ticket
             WHERE `id_resil` = :id_visu ");
        $up->execute(array(
            "id_visu" => $id_visu,

            "fin" => $finU,
            "resil" => $resilU,
            "pe" => $peU,
            "rt" => $rtU,
            "ticket" => $ticketU
        ));
    }

    if (!empty($deproU))
    {
        $up1 = $bdd->prepare("UPDATE `network_resiliation` SET `depro`= :deproU WHERE `si_id` = :idU");
        $up1->execute(array(
            "idU" => $idU,
            "deproU" => $deproU
        ));
        
        if ( $deproU == 'OK' && $test_depro != 'OK'){
        
        $collecte = '';
        $comment2 = ' <br/>// Déprovision faite le  ' .$day ;
			$up2 = $bdd->prepare("UPDATE `network_account` SET `comment`= CONCAT (comment,:comment), `collecte` = :collecte WHERE `id` = :idU ");
			$up2->execute(array(
				"idU" => $idU,
				"comment" => $comment2,
				"collecte" => $collecte
			));
        }
    }
    if (!empty($cpeU))
    {
        $up1 = $bdd->prepare("UPDATE `network_resiliation` SET `cpe`= :cpeU WHERE `si_id` = :idU");
        $up1->execute(array(
            "idU" => $idU,
            "cpeU" => $cpeU
            ));
            
            if ($cpeU == 'OK' && $test_cpe != 'OK'){
            
        $comment = ' <br/>// Routeur récuperé le  ' .$day ;
			$up2 = $bdd->prepare("UPDATE `network_account` SET `comment`= CONCAT (comment,:comment) WHERE `id` = :idU ");
			$up2->execute(array(
				"idU" => $idU,
				"comment" => $comment
			));
            }
    }
         if (!empty($relanceU))
    {
        $up1 = $bdd->prepare("UPDATE `network_resiliation` SET `relance`= :relanceU WHERE `si_id` = :idU");
        $up1->execute(array(
            "idU" => $idU,
            "relanceU" => $relanceU
            ));
            
            if ($relanceU == 'ADV'){
            
        $comment = ' <br/>// Recommandé demandé à l\'ADV le  ' .$day.' Ticket : '.$ticketU ;
			$up2 = $bdd->prepare("UPDATE `network_account` SET `comment`= CONCAT (comment,:comment) WHERE `id` = :idU ");
			$up2->execute(array(
				"idU" => $idU,
				"comment" => $comment
			));
            }
        
    }

}


$resil_insert = $bdd->query("SELECT id,resiliation
    FROM network_account 
    WHERE resiliation IS NOT NULL
    AND resiliation > '2016-12-31' 
    AND service_type IN ('Collecte Ethernet','Lan2Lan','Internet Access','Multisite MPLS','Transit IP')
    ORDER BY resiliation DESC
    ");
while ($checks = $resil_insert->fetch(PDO::FETCH_ASSOC))
{

$check_id = $checks['id'];
$check_fin = $checks['resiliation'];

 $check_resil = $bdd->query("SELECT COUNT(id_resil) AS check_count FROM network_resiliation WHERE si_id = '$check_id' ");
 
 $checks_count = $check_resil->fetch();

if ($checks_count['check_count'] < 1 ) {



     $requete = $bdd->prepare("INSERT INTO network_resiliation (si_id,fin) 
        VALUES(:id, :fin)");
        $requete->execute(array(
            "id" => $check_id,
            "fin" => $check_fin
        ));
 }else{
     
		$up1 = $bdd->prepare("UPDATE `network_resiliation` SET `fin`= :fin WHERE `si_id` = :uid");
		$up1->execute(array(
			"uid" => $check_id,
			"fin" => $check_fin
		));
	

 }

}


// Tri dans la base si_plugin


$resil = $bdd->query("SELECT *
	FROM network_resiliation 
    WHERE (depro = 'NOK' AND cpe LIKE 'NOK%' )
    OR (depro = 'NOK' OR cpe LIKE 'NOK%' )
    AND relance IN ('Relance 1','Relance 2','Relance 3','')
    ORDER BY fin ASC
    ");

echo '<center><table  class="table table-bordered table-striped">';

echo $tableau;






// variable pour les titres des colonnes

$j = 0;

while ($r = $resil->fetch(PDO::FETCH_ASSOC))
{
// ajout des titres des colonnes toute les 15 lignes

	if ($j == 15)
	{
		$j = 0;
        echo $tableau;
	    
	}
	else
	{
		$j++;
	}


$id = $r['si_id'];

        $ru_vision = $bdd->query("SELECT * FROM network_account WHERE id = '$id' ");
        $w = $ru_vision->fetch(PDO::FETCH_ASSOC);
            $si_id = $w['id'];
            $fslnk = $w['service_ref'];
            $name = $w['name'];
            $resiliation = $w['resiliation'];
            $supplier = $w['supplier'];
            $vlan = $w['vlan'];
            $eqts = $w['eqts'];
            $pe = $w['pe'];

$date = date('d-m-Y', strtotime($resiliation));





    echo '
    <tr>
        <td><center>'.$fslnk.'</center></td>
        <td><center>'.$name.'</center></td>
        <td><center>'.$date.'</center></td>
        <td><center>'.$supplier.'</center></td>
        <td style="width:65" ><center>'.$vlan.'</center></td>
        <td style="width:65" ><center>'.$pe.'</center></td>

        
        <form method="post" action="resil.php">
        

        <td><center> <input  type="date" name="resil" class="form-control" value="' . $r['resil'] . '" /> </center></td>
        <td><center> 
            <select name="pe" class="form-control">
                <option value="' . $r['pe'] . '">' . $r['pe'] . '</option>
		        <option value="OK">OK</option>
    	        <option value="NOK">NOK</option>
    	    </select>
        </center></td>
        
        <td><center> 
            <select name="depro" class="form-control">';

            if (!empty($r['depro'])) { echo '<option value="' . $r['depro'] . '">' . $r['depro'] . '</option>';  }
                
        echo '
		        <option value="NOK">NOK</option>
    	        <option value="OK">OK</option>
    	    </select>
        </center></td>
        
         <td><center> 
            <select name="rt" class="form-control">
                <option value="' . $r['rt'] . '">' . $r['rt'] . '</option>
		        <option value="OK">OK</option>
    	        <option value="NOK">NOK</option>
    	    </select>
        </center></td>
        
         <td><center> 
            <select name="relance" class="form-control">
                <option value="' . $r['relance'] . '">' . $r['relance'] . '</option>
		        <option value="Relance 1">Relance 1</option>
    	        <option value="Relance 2">Relance 2</option>
                <option value="Relance 3">Relance 3</option>
                <option value="ADV">ADV</option>
                <option value="Perdu">Perdu</option>
    	    </select>
        </center></td>
        
         <td><center> 
            <select name="cpe" class="form-control">';

            if (!empty($r['cpe'])) { echo '<option value="' . $r['cpe'] . '">' . $r['cpe'] . '</option>';  }
                
		echo '  <option value="NOK">NOK</option>
		        <option value="NOK (CPE OK)">NOK (CPE OK)</option>
		        <option value="NOK (RAD OK)">NOK (RAD OK)</option>
    	        <option value="OK">OK</option>
    	        <option value="UPGRADE">UPGRADE</option>
    	    </select>
        </center></td>
        
         <td><center> <input  type="text" name="ticket"  class="form-control"  value="' . $r['ticket'] . '" /> </center></td>

        <td><center>
            <input type="hidden" value="' . $resiliation . '" name ="fin"/>
            <input type="hidden" value="' . $si_id . '" name ="id"/>
			<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button><br/>
			</form>
		<form method="post" action="resil.php">

            <input type="hidden" value="' . $si_id . '" name ="mail_id"/>
			<button type="submit" name="mail" class="btn btn-outline-info btn-sm mb-2">Mail</button>
        </form>
    	</center></td>

    </tr>
';
}

echo '</center></table>';
require('../includes/foot.php');

?>
