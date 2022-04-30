<?php require ('../includes/head.php'); 



if (!empty($_POST['mes_direct'])){
    
    $idu = $_POST['mes_direct'];
    $location = $_POST['location'];
    $date = date('Y-m-d');
    
    
    $up = $bdd->prepare("UPDATE `network_vision` SET `cpe` = :cpe ,`location` = :location WHERE `id` = :id_visu");
	$up->execute(array(
			"id_visu" => $idu,
			"cpe" => $date,
			"location" => $location
		));

    
}


// Récuperation des routeurs confé

if(!empty($_POST['page_OK'])){
    
    switch ($_POST['page_OK']) {
    case "0":
    $cpe_recup = $bdd->query("SELECT *
    FROM `network_vision` 
	WHERE `location` IN ('Caisse SOCOM','UPS','Caisse RESONANCE','Client','Caisse AXIONE','Eiffage','Socom','Resonance','Axione','Stock FAI')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");
echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-outline-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-outline-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
        break;

    case "Socom":
    $cpe_recup = $bdd->query("SELECT *
    FROM `network_vision` 
	WHERE `location` IN ('Caisse SOCOM','Socom')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");
echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-outline-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-outline-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
        break;

         case "Axione":
    $cpe_recup = $bdd->query("SELECT *
    FROM `network_vision` 
	WHERE `location` IN ('Caisse AXIONE','Axione')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");
echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-outline-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-outline-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
        break;

         case "Resonance":
    $cpe_recup = $bdd->query("SELECT *
    FROM `network_vision` 
	WHERE `location` IN ('Caisse RESONANCE','Resonance')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");
echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-outline-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-outline-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
        break;

         case "Eiffage":
    $cpe_recup = $bdd->query("SELECT *
    FROM `network_vision` 
	WHERE `location` IN ('Eiffage')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");
echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-outline-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-outline-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
        break;

         case "UPS":
    $cpe_recup = $bdd->query("SELECT *
    FROM `network_vision` 
	WHERE `location` IN ('UPS')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");
echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-outline-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
        break;

        case "Stock Fai":
    $cpe_recup = $bdd->query("SELECT *
    FROM `network_vision` 
	WHERE `location` IN ('Stock FAI')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");
echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-outline-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-outline-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
        break;
   
} 
    

}else{
    $cpe_recup = $bdd->query("SELECT *
	FROM `network_vision` 
	WHERE `location` IN ('Caisse SOCOM','UPS','Caisse RESONANCE','Client','Caisse AXIONE','Eiffage','Socom','Resonance','Axione','Stock FAI')
	AND `mes` IS NULL
	AND `annuler` = 0
	ORDER BY location");

echo'
<center><form method="post" action="cpe.php">
<button name="page_OK" value="0" type="submit" class="btn btn-success btn-sm mb-2">Général</button>
<button name="page_OK" value="Socom" type="submit" class="btn btn-outline-success btn-sm mb-2">Socom</button>
<button name="page_OK" value="Axione" type="submit" class="btn btn-outline-success btn-sm mb-2">Axione</button>
<button name="page_OK" value="Resonance" type="submit" class="btn btn-outline-success btn-sm mb-2">Résonance</button>
<button name="page_OK" value="Eiffage" type="submit" class="btn btn-outline-success btn-sm mb-2">Eiffage</button>
<button name="page_OK" value="UPS" type="submit" class="btn btn-outline-success btn-sm mb-2">UPS</button>
<button name="page_OK" value="Stock Fai" type="submit" class="btn btn-outline-success btn-sm mb-2">Stock FAI</button>
</form>
</center>';
}





  echo '<div><center><table class="table table-bordered table-striped">
      <thead class="thead-dark">
    <tr>
			<td><center>FSLNK</center></td>
			<td><center>Client</center></td>
			<td><center>CPE</center></td>
			<td><center>Date</center></td>
			<td><center>MAJ</center></td>
		</tr>
	</thead>
';
 while ( $w = $cpe_recup->fetch(PDO::FETCH_ASSOC))    {
 
 $si_id = $w['si_id'];
 $vision_id = $w['id'];
 
 if($w['cpe'] == '0000-00-00'){
     $visu_date = 'N/A';
 }else{
    $visu_date = date('d-m-Y', strtotime($w['cpe']));
 }
 
 
 
  # récuperation fslnk et nom
 
 $name_recup = $bdd->query("SELECT * FROM network_account WHERE id = '$si_id' ");
 
  $r = $name_recup->fetch(PDO::FETCH_ASSOC);

		echo '<tr>';


echo' 
        <td><center>'.$r['service_ref'].'</center></td>
        <td><center>'.$r['name'].'</center></td>
        <td><center>'.$w['location'].'</center></td>
        <td><center>'.$visu_date.'</center></td>
        
         <form method="post" action="cpe.php">
        <td><center>
		';
  

		switch ($w['location']) {
    case 'Caisse SOCOM':
        echo '
        <select name="location" class="form-control">
        <option value="Socom">Socom</option>
        <option value="Caisse '.$w['natira_presta_fo'].'">Caisse '.$w['natira_presta_fo'].'</option>
        </select>
         <input type="hidden" value="'.$vision_id.'" name ="mes_direct"/>
			<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button></center></td>';
        break;
    case 'Caisse RESONANCE':
        echo '
        <select name="location" class="form-control">
        <option value="Resonance">Resonance</option>
        <option value="Caisse '.$w['natira_presta_fo'].'">Caisse '.$w['natira_presta_fo'].'</option>
        </select>
        <input type="hidden" value="'.$vision_id.'" name ="mes_direct"/>
			<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button></center></td>';
        break;
    case 'Caisse AXIONE':
        echo '
        <select name="location" class="form-control">
        <option value="Axione">Axione</option>
        <option value="Caisse '.$w['natira_presta_fo'].'">Caisse '.$w['natira_presta_fo'].'</option>
        </select>
         <input type="hidden" value="'.$vision_id.'" name ="mes_direct"/>
			<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button></center></td>';
        break;
    case 'UPS':
       echo' <select name="location" class="form-control">
		    <option value="Client">Client</option>
		    <option value="Eiffage">Eiffage</option>
            <option value="UPS">UPS</option>
         </select>
            <input type="hidden" value="'.$vision_id.'" name ="mes_direct"/>
			<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button></center></td>';
        break;
    case 'Stock FAI':
       echo' <select name="location" class="form-control">
		    <option value="Client">Client</option>';
            if(!empty($w['natira_presta_fo'])){
             echo'<option value="Caisse '.$w['natira_presta_fo'].'">Caisse '.$w['natira_presta_fo'].'</option>';
            }
		  echo '<option value="Eiffage">Eiffage</option>
            <option value="UPS">UPS</option>
         </select>
            <input type="hidden" value="'.$vision_id.'" name ="mes_direct"/>
             <input type="hidden" value="'.$_POST['page_OK'].'" name ="page_OK"/>
			<button type="submit" class="btn btn-outline-success btn-sm mb-2">Maj</button></center></td>';
        break;
	default:
       echo '';
}
	 

		            
			   echo '  
			    
        </form>

    </tr>';
 }
 echo '</table></center></div>';
 
 require('../includes/foot.php');
