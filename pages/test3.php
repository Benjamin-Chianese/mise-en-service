<?php
require('../includes/head.php'); 





  
	   ################### Traitemement $choix NAT deuxieme partie #########################
	    
	  

	     echo '<center>
	    <form method="post" action="test3.php">
	     <h3>Génération conf</h3>

             <textarea name="description">

             </textarea>  
	  


	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </center>';
	    

	      
	      if (!empty($_POST['description']) ){
	          
$description = $_POST['description'];
$i = 0;
    
preg_match_all('/Te0\/0\/0\/0\.(.*?) /', $description , $vlan);

$count = count($vlan);

var_dump($count);
echo '<br/>';
var_dump($vlan);
echo '<br/>';

while ($i <= $vlan){
    echo 'no service instance'.$vlan[0][$i].' ethernet<br/>';
	$i++;
}

      
 } 
	      
	      

