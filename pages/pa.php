<?php
require('../includes/head.php'); 
require ('../vendor/autoload.php');

use PhpIP\IPv4Block;
use PhpIP\IPv6Block;


######## Template  formulaire #################

	  
	    
	    echo '<center><div class="mx-auto" style="width: 600px;">
	    <h3> Ajout PA</h3>
	    <form method="post" action="pa.php">
	    FSLNK : <br/>
	    <input  type="text"  class="form-control" name="fslnk"  required value="'.$_POST['fslnk'].'"/><br/><br/>
	    PA : (185.249.187.28/30)<br/>
	    <input  type="text"  class="form-control" name="pa" required value="'.$_POST['pa'].'"/><br/><br/>
        IP WAN/CGN CPE : (185.125.185.152)<br/>
	    <input  type="text"  class="form-control" name="ip" required value="'.$_POST['ip'].'"/><br/><br/>
	    
	    
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';

	   
################### Fin template Formulaire #########################


	  ################### Traitemement $choix PA #########################
	    if (!empty($_POST['fslnk']) && !empty($_POST['pa'])){
	        
	      
	        echo '<center>----------------------------</center><br/><br/>';
	        
	        $pa_format = $_POST['pa'];
	        $fslnk = $_POST['fslnk'];
	        
	        ## Récuperation de l'IP admin
	        $req_ID = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk%' ");
            $w = $req_ID->fetch(PDO::FETCH_ASSOC);
            
                $id=$w['id'];
                $name=$w['name'];
                $service = $w['service_ref'];
                $eqts = $w['eqts'];
                $mail = $w['contact_mail'];
            
             $pe_format = explode('-',$w['pe']);
             $pe = $pe_format[2];
             
            
            
            $content = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$id);
            preg_match_all("/<li><label>(.*?)<\/label><span><a href='https:/", $content , $modele);
           
   
            if(in_array('Huawei AR651',$modele[1]) || in_array('En place</label></li><li><label>Huawei AR651',$modele[1])){
                $cpe = 'Huawei AR651';
                $port = 'GigabitEthernet 0/0/6';
            }elseif(in_array('Cisco C892FSP',$modele[1]) ||in_array('En place</label></li><li><label>Cisco C892FSP',$modele[1]) ){
                $cpe = 'Cisco C892FSP';
                $port = 'GigabitEthernet 7';
            }elseif(in_array('Cisco 881',$modele[1]) || in_array('En place</label></li><li><label>Cisco 881',$modele[1]) ){
                $cpe = 'Cisco 881';
                $port = 'FastEthernet 3';
            }elseif(in_array('Juniper SRX 320',$modele[1]) || in_array('En place</label></li><li><label>Juniper SRX 320',$modele[1])){
                $cpe = 'Juniper SRX 320';
                $port = 'GigabitEthernet-0/0/1';
            }
        

            ## traitement PA
            $mask_format_wan = explode('/',$_POST['pa']);
             $mask_c_wan = $mask_format_wan[1];

            $block = new IPv4Block($_POST['pa']);

            $fin_ip = $block->getNbAddresses() -2;
            $nbr_utilisable = $block->getNbAddresses() -3;


$conf_cpe_cisco ="
conf t     
vlan 2

interface Vlan2
description PA
ip address ".$block[1]." ".$block->getMask()."
no autostate
no sh

interface ".$port."
description PA
switchport mode access
switchport access vlan 2
no sh
end
wr";

$conf_cpe_huawei ="
system-view  

//  ***  PAR DEFAUT, ON SUPPRIME LE NAT :  ***  //

interface GigabitEthernet0/0/8
  undo nat outbound 3000 interface LoopBack 50

undo ip ip-prefix PA_CUSTOMER index 10

undo interface LoopBack50

vlan 2

interface Vlanif2
description PA
ip address ".$block[1]." ".$block->getMask()."
ipv6 enable
ipv6 address prefix-from-".$w['pe']." ::1:0:0:0:1/64
ipv6 address auto link-local
undo ipv6 nd ra halt

undo shutdown

interface ".$port."
description PA
port link-type access
port default vlan 2
undo sh
save
### CGN
# Ajouter en plus sur les conf CGN et pas besoin de configurer le PE

ip ip-prefix PA_CUSTOMER index 10 permit ".$block[1]." ".$mask_c_wan."

";

$conf_pe ="
configure exclusive
set groups FS-INET routing-instances FS-INET routing-options static route ".$pa_format." next-hop ".$_POST['ip']."
commit check                

!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

commit and-quit";

$envoi_mail='Voici les informations de votre PA :
        
Subnet : '.$pa_format;
if($nbr_utilisable > 1){
$envoi_mail .= '
Nombre d\'IP utilisable : '.$nbr_utilisable.'
Vos IP : '.$block[2].' - '.$block[$fin_ip];  
}else {
 $envoi_mail .='
Votre IP : '.$block[2];
}
$envoi_mail .= ' 
Votre masque : '.$block->getMask().'
Votre passerelle : '.$block[1].' 
       
Vous pouvez des à présent vous brancher sur le port '.$port.' de votre routeur '.$eqts.'  

Cordialement.';
            
            
            echo "<center><table border='1'>
                <tr>
                    <td>Conf CPE : ".$eqts." - ".$cpe."</td>
                    <td><textarea rows='16' cols='75'>";
                    if(in_array('Cisco C892FSP',$modele[1]) ||in_array('En place</label></li><li><label>Cisco C892FSP',$modele[1]) || in_array('Cisco 881',$modele[1]) || in_array('En place</label></li><li><label>Cisco 881',$modele[1]) ){
                        echo $conf_cpe_cisco;
                    }elseif(in_array('Huawei AR651',$modele[1]) || in_array('En place</label></li><li><label>Huawei AR651',$modele[1])){
                        echo $conf_cpe_huawei;
                    }else{echo 'Non géré';}
            echo  "</textarea></td>
                </tr>
                <tr>
                    <td>Conf PE : ".$w['pe']."</td>
                    <td><textarea rows='10' cols='75'>".$conf_pe."</textarea></td>
                </tr>
                <tr>
                   <td>Mail : ".$mail." </td>
                    <td><textarea rows='10' cols='75'>".$envoi_mail."</textarea></td>
                </tr>";
                

       echo '  
        </table></center><br/><br/>
           ';    
	    }
	    ################### Fin Traitemement $choix PA #########################

     

 require('../includes/foot.php');
?>	    
	    
