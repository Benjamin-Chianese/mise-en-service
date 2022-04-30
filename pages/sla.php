<?php
require('../includes/head.php'); 


######## Template  formulaire #################

	  
	    
	    echo '<center><div class="mx-auto" style="width: 600px;">
	    <h3> Ajout SLA</h3>
		 <h4>Test de ping vers une IP choisis depuis le routeur (Uniquement Cisco) </h4>
	    <form method="post" action="sla.php">
	    Numéro du SLA : (Ajouter +1 sur les SLA en place)<br/>
	    <input  type="number"  class="form-control" name="num"  required value="'.$_POST['num'].'"/><br/><br/>
	    
	    IP distant : (93.93.40.15 = speedtest ou PE pour les MPLS)<br/>
	    <input  type="text"  class="form-control" name="ip"  required value="';
		if(!empty($_POST['id'])){
			echo $_POST['ip'];
		}else{
			echo'93.93.40.15';
		}
		
		
		echo '"/><br/><br/>
	    
	     Mode : <br/>
	     <select name="mode" class="form-control">
	                <option value="'.$_POST['mode'].'">'.$_POST['mode'].'</option>
                    <option value="Interface">Interface</option>
                    <option value="IP">IP</option>
        </select><br/><br/>
	    
	    Numéro interface (X) / IP source (X.X.X.X): <br/>
	    <input  type="text"  class="form-control" name="nombre" required value="'.$_POST['nombre'].'"/><br/><br/>
	    
	      Fréquence : (1 > 600, de préférence 5 secondes) secondes<br/>
	    <input  type="number"  class="form-control" name="frequence" required value="'.$_POST['frequence'].'"/><br/><br/>
	    
	    
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div</center>';


     
	  ################### Traitemement $choix SLA #########################
	    if (!empty($_POST['ip']) && !empty($_POST['mode'])){
	        
	      
	        echo '<center>----------------------------</center><br/><br/>';
	        

        $mode = $_POST['mode'];
        $ip = $_POST['ip'];


$template = "
ip sla ".$_POST['num'];
if($mode == 'IP'){
$template .="
icmp-echo ".$ip." source-ip ".$_POST['nombre'];
                    }else{
$template .="
icmp-echo ".$ip." source-interface GigabitEthernet / FastEthernet ".$_POST['nombre'];
                    }
$template .="
frequency ".$_POST['frequence']."
exit
ip sla schedule ".$_POST['num']." life forever start-time now";

echo '<center>';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Conf CPE</td>
            </tr>
        </thead>
            <tr>';

            echo "<td><textarea rows='10' cols='75'>
                   ".$template." 
                </textarea></td>
            </tr>
        </table> ";
}

 require('../includes/foot.php');
?>	
