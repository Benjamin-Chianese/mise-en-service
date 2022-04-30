<?php
require ('../includes/head.php');


$porte = array(
        'Equadex' => array (
            'ncs' => "tls00-2-ncs5k",
            'port' => 'Te0/0/0/11',
            'lo' => '172.31.3.9'
        ),
        'Adista' => array (
            'ncs' => "lbg01-1-ncs540",
            'port' => 'Te0/0/0/2',
            'lo' => '172.31.3.0'
        ),
        'Pacwan' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/12',
            'lo' => '172.31.3.8'
        ),
        'Eurafibre' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/9',
            'lo' => '172.31.3.8'
        ),
        'Ineonet' =>array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/13',
            'lo' => '172.31.3.8'
        ),
        'Appliwave' =>array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/10',
            'lo' => '172.31.3.8'
        ),
        'OVEA livraison' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/14',
            'lo' => '172.31.3.8'
        ),
        'Sewan' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/3',
            'lo' => '172.31.3.8'
        ),
        'Webaxys' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/17',
            'lo' => '172.31.3.8'
        ),
        'LTI-Network' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Gi0/0/0/15',
            'lo' => '172.31.3.8'
        ),
        'AZA Telecom' => array (
            'ncs' => "blm01-1-ncs540",
            'port' => 'Te0/0/0/2',
            'lo' => '172.31.3.4'
        ),
        'Celeste' => array (
            'ncs' => "blm01-1-ncs540",
            'port' => 'Te0/0/0/3',
            'lo' => '172.31.3.4'
        ),
        'tls00-2-mx:xe-0/0/0' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/0',
            'lo' => '172.31.3.8'
        ),
        'tls00-2-mx:xe-2/0/1' => array (
            'ncs' => "tls00-2-ncs5k",
            'port' => 'Te0/0/0/0',
            'lo' => '172.31.3.9'
        ),
        'lbg01-2-mx:xe-0/0/0' => array (
            'ncs' => "lbg01-1-ncs540",
            'port' => 'Te0/0/0/0',
            'lo' => '172.31.3.0'
        ),
        'QUANTIC TELECOM LIVRAISON' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/27',
            'lo' => '172.31.3.8'
        ),
        'QUANTIC TELECOM COLLECTE' => array (
            'ncs' => "tls00-2-ncs5k",
            'port' => 'Te0/0/0/29',
            'lo' => '172.31.3.9'
        ),
        'IP MAX PARIS LIVRAISON' => array (
            'ncs' => "tls00-1-ncs5k",
            'port' => 'Te0/0/0/28',
            'lo' => '172.31.3.8'
        )

);

#var_dump($porte);

  echo  '<center><div class="mx-auto" style="width: 600px;">
	     <h3> Collecte Natira </h3>(que pour le nouvelle boucle)
	    <form method="post" action="collecte.php">
	    Équipement Point Entrée : <br/>
	    <select name="type_pe"  class="form-control">';
	    if(!empty($_POST['type_pe'])){
                    switch ($_POST['type_pe']){
                       case 'ASR':
                 echo '<option value="ASR">ASR</option>
                        <option value="NCS">NCS</option> ';
                       break;
                       case 'NCS':
                 echo '<option value="NCS">NCS</option>
                 <option value="ASR">ASR</option>          ';
                       break;
                       }
                       }else{
                             echo '   <option value="ASR">ASR</option>
                                <option value="NCS">NCS</option>';
                                }
                echo'        </select>
            <br/><br/>
            EAS : <br/>
	    <select name="EAS"  class="form-control">';
	    if(!empty($_POST['EAS'])){
                    switch ($_POST['EAS']){
                       case 'Oui':
                 echo '<option value="Oui">Oui</option>
                        <option value="Non">Non</option> ';
                       break;
                       case 'Non':
                 echo '<option value="Non">Non</option>
                 <option value="Oui">Oui</option>          ';
                       break;
                       }
                       }else{
                             echo '   <option value="Oui">Oui</option>
                                <option value="Non">Non</option>';
                                }
                 echo '       </select>
            <br/><br/>
	    <table border="1">
	        <tr>
	            <td>#</td>
	            <td>Hostname</td>
	            <td>Interface</td>
	            <td>Lo0</td>
	       </tr>
	        <tr>
	            <td>Local</td>
	            <td><input  type="text" class="form-control"name="local_hostname" required value="'.$_POST['local_hostname'].'"/></td>
	            <td><input  type="text" class="form-control"name="local_interface" required value="'.$_POST['local_interface'].'"/></td>
	            <td><input  type="text" class="form-control"name="local_lo0" required value="'.$_POST['local_lo0'].'"/></td>
                
	        </tr>
	        <tr>
	            <td>Remote</td>
	            <td><select name="remote" class="form-control">
                        <option value="'.$_POST['remote'].'">'.$_POST['remote'].'</option>';
                         ksort($porte);
                       foreach ( $porte as $k => $v) {
                           if(!empty($_POST['remote'] != $k)){
                           echo '<option value="'.$k.'">'.$k.'</option>'; 
                           }
                        }  
                        echo '   
                		</select></td>
                <td style="background-color:grey"></td>
                <td style="background-color:grey"></td>
	        </tr>
	        <tr>
	            <td>EAS</td>
	            <td><input  type="text" class="form-control"name="eas_hostname" value="'.$_POST['eas_hostname'].'"/></td>
	            <td><input  type="text" class="form-control"name="eas_interface" value="'.$_POST['eas_interface'].'"/></td>
	            <td style="background-color:grey"></td>
	        </tr>
	       
            </table>
            <br/><br/>
	    <table border="1">
	        <tr>
	            <td>S-Vlan</td>
	            <td>Natira Tag</td>
	            <td>Service ID</td>

	       </tr>
	        <tr>
	            <td><input  type="text" class="form-control"name="svlan" required value="'.$_POST['svlan'].'"/></td>
	            <td><input  type="text" class="form-control"name="tag" required value="'.$_POST['tag'].'"/></td>
	            <td><input  type="text" class="form-control"name="service_id" required value="'.$_POST['service_id'].'"/></td>
	        </tr>

	        
            </table>
<br/><br/>
<table border="1">
	        <tr>
	            <td>Nom Client</td>
	            <td>Réf Opérateur</td>
                <td>Débit (Mb/s)</td>
	       </tr>
	        <tr>
	            <td><input  type="text" class="form-control"name="nom_client" required value="'.$_POST['nom_client'].'"/></td>
	            <td><input  type="text" class="form-control"name="ref_ope" required value="'.$_POST['ref_ope'].'"/></td>
                <td><input  type="text" class="form-control"name="debit" required value="'.$_POST['debit'].'"/></td>
	        </tr>
	        
            </table>
<br/><br/>
	    
	  <button type="submit"  name="generation" value="generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';
	    
	    echo '<center>';
	    if(!empty($_POST['type_pe'])){

            $porte_collecte = $porte[$_POST['remote']];

            if($_POST['remote'] == 'tls00-2-mx:xe-0/0/0' || $_POST['remote'] == 'tls00-2-mx:xe-2/0/1' || $_POST['remote'] == 'lbg01-2-mx:xe-0/0/0'){
                    $operateur = 'FULLSAVE';
            }else{
                $operateur = strtoupper($_POST['remote']);
            }
	        if($_POST['type_pe'] == 'ASR'){
	            if($_POST['EAS'] == 'Oui'){
	                echo '
	                <table border="1">
	                    <tr>    
        	                <td>'.$_POST['local_hostname'].'</td>
        	                <td>'.$porte_collecte['ncs'].'</td>
        	           </tr>
        	           <tr>
        	                <td>
        	                 interface '.$_POST['local_interface'].'<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             mtu 9216<br/>
                             no ip address<br/>
                             negotiation auto<br/>
                             no shut<br/>
                              !<br/>
                             service instance 10 ethernet<br/>
                              description '.$_POST['eas_hostname'].':'.$_POST['eas_interface'].'<br/>
                              encapsulation dot1q 10<br/>
                              rewrite ingress tag pop 1 symmetric<br/>
                              bridge-domain 10<br/>
                            !<br/>
                             service instance '.$_POST['svlan'].' ethernet<br/>
                              description '.$_POST['tag'].' - '.$porte_collecte['ncs'].':'.$porte_collecte['port'].'.'.$_POST['svlan'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              encapsulation dot1q '.$_POST['svlan'].'<br/>';
                            if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }else{
                              echo 'service-policy output QoS-DEFAULT<br/>';
                            }
                              echo 'xconnect '.$porte_collecte['lo'].' '.$_POST['service_id'].' encapsulation mpls<br/>
                              end<br/>                    
                              <br/>
                            </td>
                            
                            <td>
                            interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' l2transport<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             encapsulation dot1q '.$_POST['svlan'].'<br/>
                             mtu 9230<br/>';
                             if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }
                             echo'!<br/>
                            l2vpn<br/>
                             xconnect group '.$porte_collecte['ncs'].'_'.$_POST['local_hostname'].'<br/>
                             !<br/>
                              p2p '.$_POST['tag'].'<br/>
                               interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' <br/>
                               neighbor ipv4 '.$_POST['local_lo0'].' pw-id '.$_POST['service_id'].'<br/>
                               !<br/>
                               description '.$_POST['local_hostname'].':'.$_POST['local_interface'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              !
                            </td>
                        </tr>
                    </table>

	                ';
	            }else{
	                echo '
	                <table border="1">
	                    <tr>    
        	                <td>'.$_POST['local_hostname'].'</td>
        	                <td>'.$porte_collecte['ncs'].'</td>
        	           </tr>
        	           <tr>
        	                <td>
        	                 interface '.$_POST['local_interface'].'<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             mtu 9216<br/>
                             no ip address<br/>
                             negotiation auto<br/>
                             no shut <br/>
                            !<br/>
                              service instance '.$_POST['svlan'].' ethernet<br/>
                              description '.$_POST['tag'].' - '.$porte_collecte['ncs'].':'.$porte_collecte['port'].'.'.$_POST['svlan'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              encapsulation untagged<br/>
                              rewrite ingress tag push dot1q '.$_POST['svlan'].' symmetric<br/>';
                              if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }else{
                              echo 'service-policy output QoS-DEFAULT<br/>';
                            }
                              echo '
                              xconnect '.$porte_collecte['lo'].' '.$_POST['service_id'].' encapsulation mpls<br/>
                              end<br/>
                              <br/>
                            </td>
                            
                            <td>
                            interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' l2transport<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             encapsulation dot1q '.$_POST['svlan'].'<br/>
                             mtu 9230<br/>';
                             if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }
                             echo'
                             !<br/>
                            l2vpn<br/>
                             xconnect group '.$porte_collecte['ncs'].'_'.$_POST['local_hostname'].'<br/>
                             !<br/>
                              p2p '.$_POST['tag'].'<br/>
                               interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' <br/>
                               neighbor ipv4 '.$_POST['local_lo0'].' pw-id '.$_POST['service_id'].'<br/>
                               !<br/>
                               description '.$_POST['local_hostname'].':'.$_POST['local_interface'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              !
                            </td>
                            
                        </tr>
                    </table>

	                ';
	            }
	            
	        }elseif($_POST['type_pe'] == 'NCS'){
	            if($_POST['EAS'] == 'Oui'){
	                echo '
	                <table border="1">
	                    <tr>    
        	                <td>'.$_POST['local_hostname'].'</td>
        	                <td>'.$porte_collecte['ncs'].'</td>
        	           </tr>
        	           <tr>
        	                <td>
        	                 interface '.$_POST['local_interface'].'<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             mtu 9230<br/>
                             !<br/>
                             interface '.$_POST['local_interface'].'.10 l2transport<br/>
                             description '.$_POST['eas_hostname'].':'.$_POST['eas_interface'].'<br/>
                             encapsulation dot1q 10<br/>
                             rewrite ingress tag pop 1 symmetric<br/>
                             mtu 9230<br/>
                             !<br/>
                             interface '.$_POST['local_interface'].'.'.$_POST['svlan'].' l2transport<br/>
                             description '.$_POST['tag'].' - '.$porte_collecte['ncs'].':'.$porte_collecte['port'].'.'.$_POST['svlan'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                             encapsulation dot1q '.$_POST['svlan'].'<br/>
                             ';
                              if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }
                            echo'mtu 9234<br/>
                            !<br/>
                             l2vpn<br/>
                             bridge group Admin<br/>
                             bridge-domain EAS<br/>
                             interface '.$_POST['local_interface'].'.10<br/>
                             xconnect group '.$_POST['local_hostname'].'_'.$porte_collecte['ncs'].'<br/>
                             !<br/>
                              p2p '.$_POST['tag'].'<br/>
                               interface '.$_POST['local_interface'].'.'.$_POST['svlan'].' <br/>
                               neighbor ipv4 '.$porte_collecte['lo'].' pw-id '.$_POST['service_id'].'<br/>
                               !<br/>
                               description '.$porte_collecte['ncs'].':'.$porte_collecte['port'].'.'.$_POST['svlan'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              !
                        
                            
                            </td>
                            
                            <td>
                            interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' l2transport<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             encapsulation dot1q '.$_POST['svlan'].'<br/>
                             mtu 9230<br/>';
                             if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }
                             echo'!<br/>
                            l2vpn<br/>
                             xconnect group '.$porte_collecte['ncs'].'_'.$_POST['local_hostname'].'<br/>
                             !<br/>
                              p2p '.$_POST['tag'].'<br/>
                               interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' <br/>
                               neighbor ipv4 '.$_POST['local_lo0'].' pw-id '.$_POST['service_id'].'<br/>
                               !<br/>
                               description '.$_POST['local_hostname'].':'.$_POST['local_interface'].'.'.$_POST['svlan'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              !
                            </td>
                        </tr>
                    </table>

	                ';
	            }else{
	                echo '
	                <table border="1">
	                    <tr>    
        	                <td>'.$_POST['local_hostname'].'</td>
        	                <td>'.$porte_collecte['ncs'].'</td>
        	           </tr>
        	           <tr>
        	                <td>
                             interface '.$_POST['local_interface'].'.'.$_POST['svlan'].' l2transport<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             encapsulation dot1q '.$_POST['svlan'].'<br/>
                             ';
                             if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }
                            echo'mtu 9230<br/>
                            !<br/>
                             l2vpn<br/>
                             xconnect group '.$_POST['local_hostname'].'_'.$porte_collecte['ncs'].'<br/>
                             !<br/>
                              p2p '.$_POST['tag'].'<br/>
                               interface '.$_POST['local_interface'].'.'.$_POST['svlan'].' <br/>
                               neighbor ipv4 '.$porte_collecte['lo'].' pw-id '.$_POST['service_id'].'<br/>
                               !<br/>
                               description '.$porte_collecte['ncs'].':'.$porte_collecte['port'].'.'.$_POST['svlan'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              <br/>
                            </td>
                            
                            <td>
                            interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' l2transport<br/>
                             description '.$_POST['nom_client'].' #'.$operateur.'<br/>
                             encapsulation dot1q '.$_POST['svlan'].'<br/>
                             mtu 9230<br/>';
                             if($_POST['debit'] < 1000){
                              echo 'service-policy output '.$_POST['debit'].'M<br/>'; 
                            }
                             echo'
                             !<br/>
                            l2vpn<br/>
                             xconnect group '.$porte_collecte['ncs'].'_'.$_POST['local_hostname'].'<br/>
                             !<br/>
                              p2p '.$_POST['tag'].'<br/>
                               interface '.$porte_collecte['port'].'.'.$_POST['svlan'].' <br/>
                               neighbor ipv4 '.$_POST['local_lo0'].' pw-id '.$_POST['service_id'].'<br/>
                               !<br/>
                               description '.$_POST['local_hostname'].':'.$_POST['local_interface'].' #'.$operateur.' - '.$_POST['ref_ope'].'<br/>
                              !
                            </td>
                            
                        </tr>
                    </table>

	                ';
	            }
            }
        }                   
               
	    
echo '</center>';


require('../includes/foot.php');
?>
