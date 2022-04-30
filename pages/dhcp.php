<?php
require('../includes/head.php'); 



$choix_dhcp =  '<center><div class="mx-auto" style="width: 600px;">
	     <h3> Ajout DHCP</h3>
          <h4>Changement de pool IP ou de plage DHCP  </h4>
	    <form method="post" action="dhcp.php">
        CPE :<br/>
            <select name="cpe"  class="form-control">
                    <option value="Huawei">Huawei</option>
                    <option value="Cisco">Cisco</option>
            </select><br/><br/>
	    Paserelle : (X.X.X.X/XX)<br/>
	    <input  type="text"  class="form-control" name="paserelle"  required value="'.$_POST['paserelle'].'"/><br/><br/>
	    Plage DHCP : (X-X)<br/>
	    <input  type="numb"  class="form-control" name="dhcp_begin" required value="'.$_POST['dhcp_begin'].'"/> - <input  type="numb"  class="form-control" name="dhcp_end" required value="'.$_POST['dhcp_end'].'"/><br/><br/>
	    
	    
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	   </div> </center>';


echo $choix_dhcp;

  ################### Traitemement $choix DHCP #########################
	
	    if (!empty($_POST['paserelle']) ){

	       
	        echo '<center>----------------------------</center><br/><br/>';

	        
	        $paserelle_format = $_POST['paserelle'];
	        
	        $mask_format = explode('/',$paserelle_format);
            $mask_c = $mask_format[1];
            

             $ip_format = explode('.',$paserelle_format);
            
            $ip_1 = $ip_format[0];
            $ip_2 = $ip_format[1];
            $ip_3 = $ip_format[2];
            $ip_4 = $ip_format[3];

            $ip_N = $ip_1.'.'.$ip_2.'.'.$ip_3;
            
            $dhcp_begin = $_POST['dhcp_begin'] - 1 ;
            $dhcp_end = $_POST['dhcp_end'] + 1 ;


$conf_cisco ='
            ! Supression ancien DHCP <br/><br/>
            no ip dhcp excluded-address 192.168.1.1 192.168.1.99 <br/>
            no ip dhcp excluded-address 192.168.1.200 192.168.1.254<br/><br/>

            no ip dhcp pool 0<br/><br/>
            
            no access-list 110 permit ip 192.168.1.0 0.0.0.255 any<br/><br/>
            
            ! --------------------------------------<br/><br/>
            !Ajout nouveau DHCP<br/><br/>
            
            ip dhcp excluded-address '.$ip_N.'.1 '.$ip_N.'.'.$dhcp_begin.'<br/>
            ip dhcp excluded-address '.$ip_N.'.'.$dhcp_end.' '.$ip_N.'.254<br/><br/>

            ip dhcp pool 0 <br/>
            network '.$ip_N.'.0 '.$netmask_slash[$mask_c] .'<br/>
            dns-server 141.0.202.202 141.0.202.203<br/>
            default-router '. $mask_format[0].'<br/><br/>

            interface Vlan1<br/>
            ip address '. $mask_format[0].' '.$netmask_slash[$mask_c].'<br/><br/>
            
            access-list 110 remark NAT<br/>
            access-list 110 permit ip '.$ip_N.'.0 '.$wildcard_slash[$mask_c].' any<br/><br/><br/>
            
';
$conf_huawei ='
            ! Supression ancien DHCP <br/><br/>
            interface Vlanif 1<br/>
            undo dhcp server ip-range 192.168.1.100 192.168.1.199 <br/><br/>
            acl name NAT 3000  <br/>
            undo rule 10 permit ip source 192.168.1.0 0.0.0.255<br/>
            <br/>
            ! --------------------------------------<br/><br/>
            !Ajout nouveau DHCP<br/><br/>
            
            interface Vlanif 1<br/>
            ip address '. $mask_format[0].' '.$netmask_slash[$mask_c].'<br/>
            undo dhcp server ip-range '.$ip_N.'.'.$dhcp_begin.' '.$ip_N.'.'.$dhcp_end.' <br/><br/>
            acl name NAT 3000  <br/>
            rule 10 permit ip source '.$ip_N.'.0 '.$wildcard_slash[$mask_c].'<br/><br/><br/>
            
            
';

       echo '    <center><table border="1">
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

                echo'</td>
	            </tr>
	                </table></center>
 ';

           
          exit;
	    }    
	    
	   ?>
