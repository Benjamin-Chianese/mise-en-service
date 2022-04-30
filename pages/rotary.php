<?php
require('../includes/head.php'); 


 $choix_rotary = '<center><div class="mx-auto" style="width: 600px;">
	      <h3> Ajout Rotary</h3>
         <h4>Ouverture de range de port vers une IP local </h4>
	    <form method="post" action="rotary.php">
	    IP local:<br/>
	    <input  type="text"  class="form-control" name="ip_rotary"  required value="'.$_POST['ip_rotary'].'" /><br/><br/>
	     Protocole :<br/>
	     <select name="protocole"  class="form-control">
                                <option value="TCP">TCP</option>
                                <option value="UDP">UDP</option>
                                <option value="TCP/UDP">TCP/UDP</option>
                        </select><br/><br/>
        CPE :<br/>
	     <select name="cpe"  class="form-control">
                                <option value="Huawei">Huawei</option>
                                <option value="Cisco">Cisco</option>
                        </select><br/><br/>
         Plage NAT : (X-X)<br/>
	    <input  type="numb"  class="form-control" name="nat_begin" required value="'.$_POST['nat_begin'].'"/> - <input  type="numb"  class="form-control" name="nat_end" required value="'.$_POST['nat_end'].'"/><br/><br/>
	    
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';

echo $choix_rotary;


if (!empty($_POST['ip_rotary']) && !empty($_POST['nat_begin']) && !empty($_POST['nat_end'])){

$conf_cisco='
ip nat pool ROTARY '.$_POST['ip_rotary'].' '.$_POST['ip_rotary'].' netmask 255.255.255.0 type rotary<br/>
                ip nat inside destination list ROTARY pool ROTARY<br/><br/>
                ip access-list extended ROTARY<br/>
                    ';
	        
	         if($_POST['protocole'] == 'TCP/UDP' ){
         $conf_cisco.='   permit udp any any range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>
                 permit tcp any any range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>
         ';   
        }elseif($_POST['protocole'] == 'UDP' ){
          $conf_cisco.='  permit udp any any range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>';
        }
        elseif($_POST['protocole'] == 'TCP' ){
          $conf_cisco.='   permit tcp any any range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>';
        }

$conf_huawei ="
acl number 3010<br/>
description Rotary_client_".$_POST['ip_rotary']."<br/>";
 if($_POST['protocole'] == 'TCP/UDP' ){
         $conf_huawei.='   rule 5 permit tcp destination-port range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>
                 rule 10 permit udp destination-port range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>
         ';   
        }elseif($_POST['protocole'] == 'UDP' ){
          $conf_huawei.='  rule 5 permit udp destination-port range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>';
        }
        elseif($_POST['protocole'] == 'TCP' ){
          $conf_huawei.='   rule 5 permit tcp destination-port range '.$_POST['nat_begin'].' '.$_POST['nat_end'].'  <br/>';
        }
$conf_huawei .="
interface GigabitEthernet0/0/8<br/>
nat static global interface LoopBack50 inside ".$_POST['ip_rotary']." acl 3010<br/>";

        
	   echo '     <center><table border="1">
                <tr>
                    <td>Conf CPE : </td>
                </tr>
	             <tr>
                    <td>';
                    if($_POST['cpe'] == 'Cisco' ){
                        echo $conf_cisco;
                    }elseif($_POST['cpe'] == 'Huawei'){
                        echo $conf_huawei;
                    }                
	     echo '</td>
	            </tr></table></center>';
	     exit;   
	    }
