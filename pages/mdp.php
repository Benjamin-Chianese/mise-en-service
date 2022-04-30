<?php
require('../includes/head.php'); 



######## Template  formulaire #################

	  
	    
	    echo '<center><div class="mx-auto" style="width: 600px;">
	    <h3>Crétion MDP</h3>
	    <form method="post" action="mdp.php">
	    Nombre de mot de passe : (1 à 30)<br/>
	    <input  type="number"  class="form-control" min="1" max="30"name="nombre"  required value="';
		if(!empty($_POST['nombre'])){
			echo $_POST['nombre'];
		}else{
			echo '5';
		}
		echo'"/><br/><br/>
	    
	    Longueur du mot de passe : (4 à 30)<br/>
	    <input  type="number"  class="form-control" min="12" max="30" name="longueur"  required value="';
		if(!empty($_POST['longueur'])){
			echo $_POST['longueur'];
		}else{
			echo '12';
		}
		
		
		echo '"/><br/><br/>

	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div</center>';


     
	  ################### Traitemement $choix SLA #########################
	    if (!empty($_POST['longueur']) && !empty($_POST['nombre'])){
	        
	      
	        echo '<center>----------------------------</center><br/><br/>';
	        
        $nombre = strtolower($_POST['nombre']);
        $longueur = strtolower($_POST['longueur']);
        $caract = "abcdefghijkmnpqrstuvwyxzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        
        
        for($nbrPasswd = 1; $nbrPasswd <= $nombre ; $nbrPasswd++)
{
for($i = 1; $i <= $longueur; $i++) {

// On compte le nombre de caractères
$Nbr = strlen($caract);

// On choisit un caractère au hasard dans la chaine sélectionnée :
$Nbr = random_int(0,($Nbr-1));

// Pour finir, on écrit le résultat :
print $caract[$Nbr];

}

    echo "<br>";
    
}
}
 require('../includes/foot.php');
?>	
