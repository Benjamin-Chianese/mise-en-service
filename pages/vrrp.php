<?php
require('../includes/head.php'); 


######## Template  formulaire #################

	  
	    
	    echo '<center><div class="mx-auto" style="width: 600px;">
	    <h3> Ajout VRRP</h3>
	    <form method="post" action="vrrp.php">
	    FSLNK Nominal : <br/>
	    <input  type="text"  class="form-control" name="fslnk_n"  required value="'.$_POST['fslnk_n'].'"/><br/><br/>
	    FSLNK Secours : <br/>
	    <input  type="text"  class="form-control" name="fslnk_s"  required value="'.$_POST['fslnk_s'].'"/><br/><br/>
	    
	     LAN : (X.X.X.X/XX)<br/>
	      <input  type="text"  class="form-control" name="lan" required value="'.$_POST['lan'].'"/><br/><br/>

	    
	    
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div</center>';


     
	  ################### Traitemement $choix SLA #########################
	    if (!empty($_POST['fslnk_n']) && !empty($_POST['fslnk_s'])){
	        
	      
	        echo '<center>----------------------------</center><br/><br/>';
	        
	        ### traitement nominal
	        
	        $fslnk_N = $_POST['fslnk_n'];
	        $req_fslnk_N = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk_N%' ");
            $n = $req_fslnk_N->fetch(PDO::FETCH_ASSOC);
            
            
             $fsn_N = $n['service_ref'];
		     $fsnBGP_N = substr($fsn_N, -3);
		     $as_N = '65'.$fsnBGP_N;

            $content_N = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$n['id']);
            preg_match_all('/\En place<\/label><\/li><li><label>(.*?)\</', $content_N , $cpe_test_N);
            
            if(empty($cpe_test_N[1])){
                preg_match_all('/<b>199<\/b><br\ \/>\n<li><label>(.*?)<\/label>/', $content_N , $cpe_N);
            }else{
                $cpe_N = $cpe_test_N;
            }
           
            if($cpe_N[1][0] == 'Cisco C892FSP' ){
                $port_N = 'GigabitEthernet 8';
            }else{
                $port_N = 'FastEthernet 4';
            }

            preg_match_all('/\IP<\/label><span>(.*?)\</', $content_N , $ip_N);

            $traitement_pe_N = explode('.',$ip_N[1][0]);
            
            $ip_N_1 = $traitement_pe_N[0];
            $ip_N_2 = $traitement_pe_N[1];
            $ip_N_3 = $traitement_pe_N[2];
            $traitement_N_4 = $traitement_pe_N[3];
            $ip_N_4 =$traitement_N_4 -1;
            
            $pe_N = $ip_N_1.'.'.$ip_N_2.'.'.$ip_N_3.'.'.$ip_N_4;
            
            
            ## traitement routeur secours
            $fslnk_S = $_POST['fslnk_s'];
            $req_fslnk_S = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk_S%' ");
            $s = $req_fslnk_S->fetch(PDO::FETCH_ASSOC);
            
            
             $fsn_S = $s['service_ref'];
		     $fsnBGP_S = substr($fsn_S, -3);
		     $as_S = '65'.$fsnBGP_S;
            $content_S = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$s['id']);
             preg_match_all('/\En place<\/label><\/li><li><label>(.*?)\</', $content_S , $cpe_test_S);
            
            if(empty($cpe_test_S[1])){
                preg_match_all('/<b>199<\/b><br\ \/>\n<li><label>(.*?)<\/label>/', $content_S , $cpe_S);
            }else{
                $cpe_S = $cpe_test_S;
            }
           
            if($cpe_S[1][0] == 'Cisco C892FSP' ){
                $port_S = 'GigabitEthernet 8';
            }else{
                $port_S = 'FastEthernet 4';
            }

            preg_match_all('/\IP<\/label><span>(.*?)\</', $content_S , $ip_S);

            $traitement_pe_S = explode('.',$ip_S[1][0]);
            
            $ip_S_1 = $traitement_pe_S[0];
            $ip_S_2 = $traitement_pe_S[1];
            $ip_S_3 = $traitement_pe_S[2];
            $traitement_S_4 = $traitement_pe_S[3];
            $ip_S_4 =$traitement_S_4 -1;

            $pe_S = $ip_S_1.'.'.$ip_S_2.'.'.$ip_S_3.'.'.$ip_S_4;

            ## Traitement LAN 
            
            
            $mask_format = explode('/',$_POST['lan']);
            $mask_c = $mask_format[1];
            
            $mask = $netmask_slash[$mask_c];
           
            
               $ip_format = explode('.',$mask_format[0]);
            
            $ip_1 = $ip_format[0];
            $ip_2 = $ip_format[1];
            $ip_3 = $ip_format[2];
            $ip_4 = $ip_format[3];
            
            if($ip_4 == '254'){
            $ip_lan_N = $ip_4 -1;
            $ip_lan_S = $ip_4 -2;
            }else{
            $ip_lan_N = $ip_4 +1;
            $ip_lan_S = $ip_4 +2;
            }


echo '</div><center><div class="mx-auto" style="width: 1000px;">';

    echo '<table  class="table table-bordered table-striped">
         <thead class="thead-dark">
            <tr>
                <td>Conf CPE Nominal</td>
                <td>Conf CPE Secours</td>
            </tr>
        </thead>
            <tr>';
            echo "<td>
                    ip sla 1<br/>
                    icmp-echo ".$pe_N." source-interface ".$port_N."<br/>
                    frequency 10<br/>
                    exit<br/>
                    ip sla schedule 1 start-time now life forever<br/>
                    !<br/>
                    track 1 ip sla 1<br/>
                    exit<br/>
                    interface vlan 1<br/>
                    ip address ".$ip_1.".".$ip_2.".".$ip_3.".".$ip_lan_N." ".$mask."<br/>
                    vrrp 1 ip ".$ip_1.".".$ip_2.".".$ip_3.".".$ip_4."<br/>
                    vrrp 1 preempt delay minimum 50<br/>
                    vrrp 1 priority 120<br/>
                    vrrp 1 track 1 decrement 60<br/>
                    
                    !<br/><br/>
                    CONF SUR MPLS<br/>
                    !<br/>
                    ip access-list extended ACL_METRIC_NOMINAL<br/>
                    permit ip any any<br/>
                    exit<br/>
                     !<br/>
                    route-map RM_METRIC_NOMINAL permit 10<br/>
                    match ip address ACL_METRIC_NOMINAL<br/>
                    set metric 50<br/>
                    !<br/>
                    router bgp ".$as_N."<br/>
                    address-family ipv4<br/>
                    neighbor ".$pe_N." route-map RM_METRIC_NOMINAL out<br/>
                </td>
                <td>
                    ip sla 1<br/>
                    icmp-echo ".$pe_S." source-interface ".$port_S."<br/>
                    frequency 10<br/>
                    exit<br/>
                    ip sla schedule 1 start-time now life forever<br/>
                    !<br/>
                    track 1 ip sla 1<br/>
                    exit<br/>
                    interface vlan 1<br/>
                    ip address ".$ip_1.".".$ip_2.".".$ip_3.".".$ip_lan_S." ".$mask."<br/>
                    vrrp 1 ip ".$ip_1.".".$ip_2.".".$ip_3.".".$ip_4."<br/>
                    vrrp 1 preempt delay minimum 50<br/>
                    vrrp 1 priority 90<br/>
                    !<br/><br/>
                    CONF SUR MPLS<br/>
                    !<br/>
                    ip access-list extended ACL_METRIC_SECOURS<br/>
                    permit ip any any<br/>
                    exit<br/>
                    !<br/>
                    route-map RM_METRIC_SECOURS permit 10<br/>
                    match ip address ACL_METRIC_SECOURS<br/>
                    set metric 100<br/>
                    !<br/>
                    router bgp ".$as_S."<br/>
                    address-family ipv4<br/>
                    neighbor ".$pe_S." route-map RM_METRIC_SECOURS out<br/>
                    <br/>
                </td>
            </tr>
        </table></div></center>";
}

 require('../includes/foot.php');
?>	
