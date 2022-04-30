<?php
require('../includes/head.php'); 



echo  '<center><div class="mx-auto" style="width: 600px;">
	    <h3> Ajout Vlan Guest</h3>
	    <form method="post" action="vlan.php">
	    IP guest: (X.X.X.X/XX)<br/>
	    <input  type="text"  class="form-control" name="ip_guest"  required value="'.$_POST['ip_guest'].'" /><br/><br/>
	    IP lan: (X.X.X.X/XX)<br/>
	    <input  type="text"  class="form-control" name="ip_lan"  required value="'.$_POST['ip_lan'].'" /><br/><br/>
	 
	    <button type="submit"  class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';



 if (!empty($_POST['ip_guest']) && !empty($_POST['ip_lan'])){


	        
	        echo '<center>----------------------------</center><br/><br/>';  
	        
	            $mask_guest_format = explode('/',$_POST['ip_guest']);
                $mask_guest = $mask_guest_format[1];
                $ip_guest_format = explode('.',$mask_guest_format[0]);
                
                $guest_1 = $ip_guest_format[0];
                $guest_2 = $ip_guest_format[1];
                $guest_3 = $ip_guest_format[2];
                $guest_4 = $ip_guest_format[3];
	        
                $guest = $guest_1.'.'.$guest_2.'.'.$guest_3.'.'.$guest_4;
            
                $mask_lan_format = explode('/',$_POST['ip_lan']);
                $mask_lan = $mask_lan_format[1];
                $ip_lan_format = explode('.',$mask_lan_format[0]);
                
                $lan_1 = $ip_lan_format[0];
                $lan_2 = $ip_lan_format[1];
                $lan_3 = $ip_lan_format[2];
                $lan_4 = $ip_lan_format[3];
            
            
	        
	        echo '     <center><table border="1">
                <tr>
                    <td>Conf CPE : </td>
                </tr>
	             <tr>
                    <td>
                    vlan 2<br/>
                    int vlan2<br/>
                    description GUEST</br>
                    ip address '.$guest.' '.$netmask_slash[$mask_guest].'</br>
                    ip access-group 101 in</br>
                    ip nat inside</br>
                    ip virtual-reassembly in</br></br>
                    
                    int gi7 / int fa3</br>
                    description GUEST<br/>
                    switchport mode access<br/>
                    switchport access vlan 2<br/>
                    no sh<br/>
            
                    exit</br></br>
                    access-list 101 remark NAT_GUEST<br/>
                    access-list 101 deny   ip '.$guest_1.'.'.$guest_2.'.'.$guest_3.'.0 '.$wildcard_slash[$mask_guest].' '.$lan_1.'.'.$lan_2.'.'.$lan_3.'.0 '.$wildcard_slash[$mask_lan].'</br>
                    access-list 101 permit ip any any</br>
                    access-list 110 permit ip '.$guest_1.'.'.$guest_2.'.'.$guest_3.'.0 '.$wildcard_slash[$mask_guest].' any</br>
                    
                    <br/><br/>
                    
                    int vlan1<br/>
                    ip access-group 100 in</br>
                    exit<br/>
                    access-list 100 remark NAT_LAN<br/>
                    access-list 100 deny   ip '.$lan_1.'.'.$lan_2.'.'.$lan_3.'.0 '.$wildcard_slash[$mask_lan].' '.$guest_1.'.'.$guest_2.'.'.$guest_3.'.0 '.$wildcard_slash[$mask_guest].'</br>
                    access-list 100 permit ip any any</br>
                    end<br/>
                    
                    wr<br/>
                    ';
                    
                     echo '</td>
	            </tr></table></center>';
	     exit;   
	    }
