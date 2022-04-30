<?php
require('../includes/head.php'); 



$choix_port_1 = '<center><div class="mx-auto" style="width: 600px;">	
	     <h3> Ajout Machine C3RB</h3>
	    <form method="post" action="c3rb.php">
	    Combien Machine à créer:<br/>
	    <input  type="numb"  class="form-control" name="nmb_vm"  required/><br/><br/>
       
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';


  
	   ################### Traitemement $choix NAT deuxieme partie #########################
	    
	   if (!empty($_POST['nmb_vm_2']) ){

	     echo '<center>
	    <form method="post" action="c3rb.php">
	     <h3> Ajout VM</h3>
            <table border="1">
                <tr>
                    <td>Nom VM</td>
                    <td>IP LAN</td>
                    <td>IP WAN</td>
                </tr>';
                
                for ($i = 1; $i <= $_POST['nmb_vm_2']; $i++) {
                 
                 
                 echo '<tr>

                        <td><input  type="text"  class="form-control" name="nom_vm_'.$i.'" value="'.$_POST['nom_vm_'.$i].'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_local_'.$i.'" value="'.$_POST['ip_local_'.$i].'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_wan_'.$i.'" value="'.$_POST['ip_wan_'.$i].'"/></td>
                        </tr>
                 ';   
                }
	  echo '  </table>
	    <input type="hidden" value="' . $_POST['nmb_vm_2'] . '" name ="nmb_vm_2"/>
<br/>
	    
	    <button type="submit" name="vm" value="Generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </center>';
	    
	    
	   
	   echo "<center><table border='1'>
                <tr>
                    <td>Conf C3RB : </td>
                </tr>
	    <tr>
                <td>";
    for ($i = 1; $i <= $_POST['nmb_vm_2']; $i++) {
        
    echo "    

object network C3RB-".$_POST['nom_vm_'.$i]."</br>
 host ".$_POST['ip_local_'.$i]."</br>
object network C3RB-".$_POST['nom_vm_'.$i]."_PUB</br>
 host ".$_POST['ip_wan_'.$i]."</br>
</br>
object-group network SERVER_WEB</br>
 network-object object C3RB-".$_POST['nom_vm_'.$i]."</br>
object-group network SERVER_FTP</br>
 network-object object C3RB-".$_POST['nom_vm_'.$i]."</br>
object-group network SERVER_SFTP</br>
 network-object object C3RB-".$_POST['nom_vm_'.$i]."</br>
object-group network SERVER_FTP_RANGE</br>
 network-object object C3RB-".$_POST['nom_vm_'.$i]."</br>
</br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5011 5016 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5031 5035 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5041 5047 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5062 5063 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5081 5082 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5091 5092 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5101 5102 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." range 5151 5152 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." eq 5021 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." eq 5051 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." eq 5071 </br>
access-list aclout extended permit tcp any object C3RB-".$_POST['nom_vm_'.$i]." eq 5111 </br>
</br>
nat (c3rb-lan,outside) source static C3RB-".$_POST['nom_vm_'.$i]." C3RB-".$_POST['nom_vm_'.$i]."_PUB </br>
";
      
	            
	        
	    }
	    echo '</td>
	            </tr>
	                </table></center>';
	    exit;
  
	   }
       ################### Fin Traitemement $choix NAT deuxieme partie #########################

	   ################### Traitemement $choix NAT premiere partie #########################
	   
	      if (!empty($_POST['nmb_vm'])){
	          
	          $nmb_vm = $_POST['nmb_vm'];

	          
	       echo '<center>
	       <h3>Ajout VM</h3>
	    <form method="post" action="c3rb.php">
	     
            <table border="1">
                <tr>
                    <td>Nom VM (Ex: FSH27)</td>
                    <td>IP LAN</td>
                    <td>IP WAN</td>
                </tr>';
                
                for ($i = 1; $i <= $nmb_vm; $i++) {
                 
                 
                 echo '<tr>
                        <td><input  type="text"  class="form-control" name="nom_vm_'.$i.'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_local_'.$i.'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_wan_'.$i.'" /></td>
                        </tr>
                 ';   
                }
	  echo '  </table>
	    <input type="hidden" value="' . $nmb_vm . '" name ="nmb_vm_2"/><br/>
	    
	     <button type="submit" name="vm" value="Generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    
	    </form>
	    </center>';
	    
	    exit;
	          
	      }
	      
	      echo $choix_port_1;
	      ################### Fin Traitemement $choix NAT premiere partie ######################### 
