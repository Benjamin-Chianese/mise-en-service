<?php
require ('../includes/head.php');
var_dump($_POST);

if(!empty($_POST['id']) && !empty($_POST['ref'])){
	$up = $bdd->prepare("UPDATE `network_account` SET  `service_tag_natira`= :ref WHERE `id` = :id ");
			$up->execute(array(
				"id" => $_POST['id'],
				"ref" => $_POST['ref']
			));

}

echo '</center><br/><br/>';
$mes = $bdd->query("SELECT * FROM network_account WHERE 
 service_type IN ('Internet Access','Collecte Ethernet','Multisite MPLS','Lan2Lan')
AND resiliation IS NULL 
AND fs_service_delivery IS NOT NULL
AND (service_tag_natira IS NULL OR service_tag_natira = '') 

AND collecte NOT LIKE '%blm01-1-asr920%' 
AND collecte NOT LIKE '%blm01-2-asr920%'
AND collecte NOT LIKE '%blm01-3-asr920%'
AND collecte NOT LIKE '%lbg01-1-asr920%'
AND collecte NOT LIKE '%lbg01-2-asr920%'
AND collecte NOT LIKE '%lbg01-3-asr920%'
AND collecte NOT LIKE '%tls02-1-asr920%'
AND collecte NOT LIKE '%tls02-2-asr920%'
AND collecte NOT LIKE '%tls00-2-asr920%'
AND collecte NOT LIKE '%tls00-1-asr920%'
AND collecte NOT LIKE '%tls00-5-asr920%'
AND collecte NOT LIKE '%tls00-6-asr920%'
AND collecte NOT LIKE '%-e45%'
AND collecte NOT LIKE '%-m36%'
AND collecte NOT LIKE '%-m49%'
AND collecte NOT LIKE '%fsn%'
GROUP BY collecte ");


// Tableau

$tableau = '
    <thead class="thead-dark">
		<tr>
			<td><center>Client</center></td>
			<td><center>FSLNK</center></td>
			<td><center>Vlan</center></td>
			<td><center>Opérateur</center></td>
			<td><center>Collecte</center></td>
			<td><center>Réf</center></td>
            <td><center>MAJ</center></td>
		</tr>
		</thead>
';


echo '	<center><table class="table table-bordered table-striped">
        '. $tableau;



while ($r = $mes->fetch(PDO::FETCH_ASSOC))
{



	echo '		
                        <tr>
                        <td><center>' . $r['name'] . '</center></td>
                        <td><center>' . $r['service_ref'] . '</center></td>
						<td><center>' . $r['vlan'] . '</center></td>
                        <td><center>' . $r['supplier'] . '</center></td>
						<td><center>' . $r['collecte'] . '</center></td>
						<form method="post" action="ref.php">
						<td><input type="text"  class="form-control" name="ref" required/></td>
                		<td> 
	                <input type="hidden" value="'.$r['id'].'" name ="id"/>
                		<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button>  
						</form>                      
                    </center></td>
            </tr>';
}
echo '</table>';

require('../includes/foot.php');
?>
