<?php
require ('../includes/head.php');
if(!empty($_POST['id'])){
    
    $up1 = $bdd->prepare("UPDATE `network_vision` SET `etat`= 'En cours' WHERE `si_id` = :uid");
		$up1->execute(array(
			"uid" => $_POST['id']
		));
}

$recuperation = $bdd->query("SELECT * from `network_vision` INNER JOIN network_account  
WHERE network_vision.si_id = network_account.id 
AND network_account.service_type IN ('Lan2Lan','Internet Access','Multisite MPLS','Collecte Ethernet')
AND  network_vision.etat = 'Port à reserver'
ORDER BY network_vision.si_id DESC");

echo '<center>	<h3>Réservation des ports</h3>
    <table border="1">
    <thead class="thead-dark">
		<tr>
			<td><center>Client</center></td>
			<td><center>FSLNK</center></td>
            <td><center>Point d\'entrée</center></td>
            <td><center>cmd</center></td>
            <td><center>MAJ</center></td>
        </tr>';
            
            while ($r = $recuperation->fetch(PDO::FETCH_ASSOC)){
             
            $id_natira =$r['si_id'];
            $fslnk = $r['service_ref'];

           $port = explode(':',$r['collecte']);
            
                echo '<form method="post" action="port.php">
                <tr>
                    <td><center> '.$r['name'].' </center></td>
                    <td><center> '.$fslnk.' </center></td>
                    <td><center> '.$r['collecte'].' </center></td>
                    <td><center>int '.$port[1].' <br/> des BOOKED : '.$r['name'].' '.$fslnk.'</center></td>
                     <input type="hidden" value="'.$id_natira.'" name ="id"/>
                    <td><center><button type="submit" class="btn btn-outline-success btn-sm mb-2">Reservé</button></center></td>
                    </form>
                </tr>
                ';
            }
           echo  '</table></center>';
require('../includes/foot.php');
?>
