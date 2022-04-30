<?php
require('../includes/head.php'); 



######## Template  formulaire #################

	  
	    
	    echo '<center><div class="mx-auto" style="width: 600px;">
	    <h3> Ajout Capture</h3>
        <h4>Captude de paquet (Uniquement ASA) </h4>
	    <form method="post" action="capture.php">
	    IP source : (X.X.X.X) ou (any)<br/>
	    <input  type="text"  class="form-control" name="ip_source"  required value="'.$_POST['ip_source'].'"/><br/><br/>
	    
	    IP distant : (X.X.X.X) ou (any)<br/>
	    <input  type="text"  class="form-control" name="ip_distant"  required value="'.$_POST['ip_distant'].'"/><br/><br/>
	    
	     Nom de l\'interface : (inside,outside)<br/>
	    <input  type="text"  class="form-control" name="interface"  required value="'.$_POST['interface'].'"/><br/><br/>

	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div</center>';


     
	  ################### Traitemement $choix SLA #########################
	    if (!empty($_POST['ip_source']) && !empty($_POST['ip_distant'])&& !empty($_POST['interface']) ){
	        
	      
	        echo '<center>----------------------------</center><br/><br/>';
	        
        $source = strtolower($_POST['ip_source']);
        $distant = strtolower($_POST['ip_distant']);

$template = "
!Mise en place";
                    if($source == 'any' && $distant != 'any'){
$template .="
capture CAPOUT interface ".$_POST['interface']." real-time match ip any host ".$_POST['ip_distant'];
                    }elseif( $distant == 'any' && $source != 'any'){
$template .="
capture CAPOUT interface ".$_POST['interface']." real-time match ip host ".$_POST['ip_source']." any";
                    }elseif( $distant == 'any' && $source == 'any'){
$template .="
capture CAPOUT interface ".$_POST['interface']." real-time match ip any any";
                    }else{
$template .="
capture CAPOUT interface ".$_POST['interface']." real-time match ip host ".$_POST['ip_source']." host ".$_POST['ip_distant'];
                    }
                    
$template .="

!Voir capture
show capture CAPOUT

!Clear capture
clear capture CAPOUT

!Supprimer capture
no capture CAPOUT ";

echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Conf ASA</td>
            </tr>
        </thead>
            <tr>';
            echo "<td>";


echo "<td><textarea rows='10' cols='75'>
                   ".$template." 
                </textarea></td>
            </tr>
        </table> ";
}

 require('../includes/foot.php');
?>	
