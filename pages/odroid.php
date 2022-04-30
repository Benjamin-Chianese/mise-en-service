<?php
require('../includes/head.php'); 

if(!empty($_POST['id'])){
    
    $id = $_POST['id'];

    
    $up = $bdd->prepare("UPDATE `odroid` SET `location`= :location WHERE `id` = :id ");
	$up->execute(array(
				"id" => $id,
				"location" => $_POST['location']
				      )
				);
				
}

if(!empty($_POST['fsn']) && !empty($_POST['sim'])){
    
    
    $requete = $bdd->prepare("INSERT INTO `odroid` (fsn,sim) VALUES(:fsn, :sim)");
		
		$requete->execute(array(
			"fsn" => $_POST['fsn'],
			"sim" => $_POST['sim']
			               )
			               );
}

echo '<center>
        <div class="mx-auto" style="width: 600px;">
            <table class="table table-bordered table-striped" >
	            <thead class="thead-dark">
		        <tr>
			        <td><center>Odroid</center></td>
			        <td><center>Carte SIM</center></td>
			        <td><center>Ajouter</center></td>
		        </tr>
		        </thead>
		<form method="post" action="odroid.php">
		        <tr>
        	        <td><center><input type="text" class="form-control" name="fsn" required placeholder="fsn4GXXX"/></center></td>
        	        <td><center><input type="text" class="form-control" name="sim" required /></center></td>
        	        <td><center><button type="submit"  class="btn btn-outline-success btn-sm mb-2">Ajouter</button></center></td>
        	   </tr>
        </form>
            </table>
        </div>
    </center><br/>
';

echo '
        <br/>
        <center>
        <div class="mx-auto" style="width: 600px;">
        <table class="table table-bordered table-striped" >
	    <thead class="thead-dark">
		<tr>
			
			<td><center>Odroid</center></td>
			<td><center>Carte SIM</center></td>
			<td><center>Localisation (FSLNK)</center></td>
			<td><center>MAJ</center></td>
		</tr>
		</thead>
		';
        
        $recup = $bdd->query("SELECT * FROM `odroid` ORDER BY fsn ");

        while ($r = $recup->fetch(PDO::FETCH_ASSOC)){
echo '
    <form method="post" action="odroid.php">
        <tr>
			<td><center>'.$r['fsn'].'</center></td>
			<td><center>'.$r['sim'].'</center></td>
			<td><center><input type="text" class="form-control" name="location" value="'.$r['location'].'"/></center></td>
			<input type="hidden" value="'.$r['id'].'" name ="id"/>
			<td><center><button type="submit"  class="btn btn-outline-success btn-sm mb-2">MAJ</button></center></td>
		</form>
		</tr>  
            ';
        
        }
echo '  
        </table>
        </div>
        </center>';

require('../includes/foot.php'); 
?>