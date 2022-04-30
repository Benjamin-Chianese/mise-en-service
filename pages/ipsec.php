<?php
require('../includes/head.php'); 


if(empty($_POST['psk'])){
 $nombre = strtolower($_POST['nombre']);
        $longueur = strtolower($_POST['longueur']);
        $caract = "abcdefghijkmnpqrstuvwyxzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        
        
       
for($i = 1; $i <= 20; $i++) {

// On compte le nombre de caractères
$Nbr = strlen($caract);

// On choisit un caractère au hasard dans la chaine sélectionnée :
$Nbr = random_int(0,($Nbr-1));

// Pour finir, on écrit le résultat :
$psk .= $caract[$Nbr];

    }

}else{
    $psk = $_POST['psk'];
}
$choix_ipsec =  '<center><div class="mx-auto" style="width: 600px;">
	     <h3> Ajout VPN IPSEC</h3>
	    <form method="post" action="ipsec.php">
	     
	     
        <table border="1">
	    <tr>
	        <td>Nom Distant : </td>
	        <td>Peer Distant : </td>
	    </tr>
	    <tr>   
	        <td> <input  type="text"  class="form-control" name="nom_distant"  required value="'.$_POST['nom_distant'].'" /></td>
	        <td> <input  type="text"  class="form-control" name="ip_distant"  required value="'.$_POST['ip_distant'].'" /></td>
	    </tr>
	    </table><br/><br/>
	    
	    <table border="1">
	    <tr>
	        <td>Crypto Map  : (ex : RA_VPN 230)</td>
	        <td>PSK : </td>
	    </tr>
	    <tr>   
	        <td> <input  type="text"  class="form-control" name="crypto_map"  required value="'.$_POST['crypto_map'].'" /></td>
	            <td> <input  type="text"  class="form-control" name="psk"  required value="'.$psk.'" /></td></tr>
	    </table><br/>
	    
	     <table>
	    <tr>
            <td>IKEV</td>
	        <td>Transform set : (ex : L2L_VPN_SET )</td>
	        
	    </tr>
	    <tr>
            <td> <select name="ike"  class="form-control">
                               <option value="1">1</option>
                                <option value="2">2</option>
                        </select></td>
	        <td> <input  type="text"  class="form-control" name="transform"  required value="'.$_POST['transform'].'" /></td>
	    </tr>
	    </table><br/>
	    

	    Phase 1 :<br/><br/>
	    <table border="1">
	    <tr>
	        <td>Encryption : </td>
	        <td>Hash : </td>
	        <td>DH Group : </td>
	        <td>Lifetime : </td>
	       </tr>
	       <tr>
	       <td>
	     <select name="crypto_phase1"  class="form-control">
                            <optgroup label="IKE v1">
                                <option value="aes">AES</option>
                                <option value="aes-192">AES-192</option>
                                <option value="aes-256">AES-256</option>
                                <option value="3des">3DES</option>
                                <option value="des">DES</option>
                            <optgroup label="IKE v2">
                                <option value="aes-gcm-192">AES-GCM-192</option>
                                <option value="aes-gcm-256">AES-GCM-256</option>
                        </select>
        </td>
        <td>
	     <select name="hash_phase1"  class="form-control">
                            <optgroup label="IKE v1">
                                <option value="sha">SHA-1</option>
                                <option value="md5">MD5</option>
                            <optgroup label="IKE v2">
                                <option value="sha256">SHA-256</option>
                                <option value="sha384">SHA-384</option>
                                <option value="sha512">SHA-512</option>
                        </select>
        </td>
        <td>
	     <select name="dh_phase1"  class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                        </select>
        </td>
        
        <td>     
	    <input  type="text"  class="form-control" name="life_phase1"  required value="'.$_POST['life_phase1'].'" />
	    </td><tr></table><br/>
	    
	     Phase 2 :<br/><br/>
	     
	     <table border="1">
	    <tr>
	        <td>Encryption : </td>
	        <td>Hash : </td>
	        <td>PFS : </td>
	        <td>Lifetime : </td>
	       </tr>
        <tr>
	    <td> <select name="crypto_phase2"  class="form-control">
                            <optgroup label="IKE v1">
                                <option value="aes">AES</option>
                                <option value="aes-192">AES-192</option>
                                <option value="aes-256">AES-256</option>
                                <option value="3des">3DES</option>
                                <option value="des">DES</option>
                            <optgroup label="IKE v2">
                                <option value="aes-gcm">AES-GCM</option>
                                <option value="aes-gcm-192">AES-GCM-192</option>
                                <option value="aes-gcm-256">AES-GCM-256</option>
                                <option value="aes-gmac">AES-GMAC</option>
                                <option value="aes-gmac-192">AES-GMAC-192</option>
                                <option value="aes-gmac-256">AES-GMAC-256</option>
                </select></td>
	     <td><select name="hash_phase2"  class="form-control">
                            <optgroup label="IKE v1">
                                <option value="sha">SHA-1</option>
                                <option value="md5">MD5</option>
                            <optgroup label="IKE v2">
                                <option value="sha256">SHA-256</option>
                                <option value="sha384">SHA-384</option>
                                <option value="sha512">SHA-512</option>
                        </select></td>

	     <td><select name="pfs_phase2"  class="form-control">
                            <optgroup label="IKE v1">
	                            <option value="0">None</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="5">5</option>
                            <optgroup label="IKE v2">
                                <option value="14">14</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="24">24</option>
                        </select></td>

	    <td><input  type="text" name="life_phase2"  required value="'.$_POST['life_phase2'].'" /></td><tr></table><br/>
	    
	    
         Encryption Network : <br/><br/>
         <table border="1">
	    <tr>
	        <td>Interface : </td>
	        <td>Local : </td>
	        <td>Distant : </td>
	       </tr>
	       
	       ';
          for ($j = 1; $j <= 4; $j++) {
	   $choix_ipsec.= '
	   <tr><td> <input  type="text"  class="form-control" name="interface_'.$j.'" placeholder="inside,dmz,etc" value="'.$_POST['interface_'.$j].'" /></td>
	   <td><input  type="text"  class="form-control" name="local_'.$j.'"  placeholder="X.X.X.X/XX" value="'.$_POST['local_'.$j].'"/></td> 
	   <td><input  type="text"  class="form-control" name="distant_'.$j.'"  placeholder="X.X.X.X/XX" value="'.$_POST['distant_'.$j].'"/></td></tr>
	   ';
	    
          }
	   $choix_ipsec .= ' </tr></table>
	   <br/>
	   <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	   </div> </center>';
	   
	   
	   echo $choix_ipsec;
	   
	   
	   if (!empty($_POST['ip_distant']) && !empty($_POST['local_1']) && !empty($_POST['distant_1'])){
	   
	   
	    echo '<center>----------------------------</center><br/><br/>
	        ';  
	        
	        
echo "<center><table border='1'>
                <tr>
                    <td>Conf ASA : </td>
                </tr>
	             <tr>
                    <td>";

                        
                        $objet_dyn = array();
                        
                        
                        for ($i = 1; $i <= 4; $i++) {
                            
                        ## lan local
                        
                        if(!empty($_POST['local_'.$i]) && !empty($_POST['distant_'.$i])){
                        $mask_lan_format = explode('/',$_POST['local_'.$i]);
                        $mask_lan = $mask_lan_format[1];
                        $objet_lan = "obj-".$mask_lan_format[0];
                        $lan_local = $mask_lan_format[0];
                        
                          ## lan distant
                        $mask_distant_format = explode('/',$_POST['distant_'.$i]);
                        $mask_distant = $mask_distant_format[1];
                        $objet_distant = "obj-".$mask_distant_format[0];
                        $lan_distant = $mask_distant_format[0];
                        
                         $objet_dyn[$i]= array( 'interface' => $_POST['interface_'.$i], 'local' => $objet_lan, 'distant'=> $objet_distant, 'mask_local' => $mask_lan
                         ,'mask_distant' => $mask_distant, 'lan_local' => $lan_local,'lan_distant' => $lan_distant );
                         
                            
                        }
                        }
                        echo "! LAN Local<br/><br/>";
                       
                             for ($i = 1; $i <= 4; $i++) {
                                  if(!empty($objet_dyn[$i])){
                                      $mask_objet = $objet_dyn[$i]['mask_local'];
                         echo "! ".$_POST['local_'.$i]."<br/><br/>";
                        if($mask_objet == '32'){
                        echo "
                        object network ".$objet_dyn[$i]['local']."<br/>
                        host ".$objet_dyn[$i]['lan_local']."<br/><br/>
                        
                        ";}else{echo "
                        object network ".$objet_dyn[$i]['local']."<br/>
                        subnet ".$objet_dyn[$i]['lan_local']." ".$netmask_slash[$mask_objet]."<br/><br/>";
                        }
                             }
                             }
                             
                       echo "<br/><br/>! ------------------<br/><br/>"  ;    
                       echo "! LAN Distant <br/><br/>";
                         for ($i = 1; $i <= 4; $i++) {
                             
                              if(!empty($objet_dyn[$i])){
                                  $mask_objet = $objet_dyn[$i]['mask_distant'];
                        echo "! ".$_POST['distant_'.$i]." <br/><br/>";
                        if( $mask_objet == '32'){
                        echo "
                        object network ".$objet_dyn[$i]['distant']."<br/>
                        host ".$objet_dyn[$i]['lan_distant']."<br/><br/>
                        
                        ";}else{echo "
                        object network ".$objet_dyn[$i]['distant']."<br/>
                        subnet ".$objet_dyn[$i]['lan_distant']." ".$netmask_slash[$mask_objet]."<br/><br/>
                        
                        ";}
                              }
                         }
                        
                        
                        
                    echo "<br/><br/>! ------------------<br/><br/>"  ;
                    echo "! Phase 1 <br/><br/>";
                    
                    if($_POST['ike'] == '1'){
                        echo " crypto ikev1 policy ##<br/>
                    authentication pre-share<br/>
                    encryption ".$_POST['crypto_phase1']."<br/>
                    hash ".$_POST['hash_phase1']."<br/>
                    group ".$_POST['dh_phase1']."<br/>
                    lifetime ".$_POST['life_phase1']."<br/><br/>";

                    }elseif($_POST['ike'] == '2'){
                        echo "crypto ikev2 policy ##<br/>
                                encryption ".$_POST['crypto_phase1']."<br/>
                                integrity ".$_POST['hash_phase1']."<br/>
                                group ".$_POST['dh_phase1']."<br/>
                                prf ".$_POST['hash_phase1']."<br/>
                                lifetime seconds ".$_POST['life_phase1']."<br/><br/>";
                    }
                   
                
                
                echo "<br/><br/>! ------------------<br/><br/>"   ;   
                   echo "! ACL <br/><br/>";
                    for ($i = 1; $i <= 4; $i++) {
                        if(!empty($objet_dyn[$i])){
                   echo "access-list ".ucfirst($_POST['nom_distant'])." extended permit ip object ".$objet_dyn[$i]['local']." object ".$objet_dyn[$i]['distant']."<br/>";
                        }
                    }
                    echo "<br/>";
        
                    echo "<br/><br/>! ------------------<br/><br/>"   ;       
                     echo "! NAT <br/><br/>";
                    for ($i = 1; $i <= 4; $i++) {
                        if(!empty($objet_dyn[$i])){
                   echo "nat (".$objet_dyn[$i]['interface'].",outside) source static ".$objet_dyn[$i]['local']." ".$objet_dyn[$i]['local']." destination static ".$objet_dyn[$i]['distant']." ".$objet_dyn[$i]['distant']." no-proxy-arp<br/>";
                        }
                    }
                    echo "<br/>";
                    echo "<br/><br/>! ------------------<br/><br/>"  ;
                    echo "! Phase 2 <br/><br/>"; 
                    if($_POST['ike'] == '1'){
                        echo "crypto ipsec ikev1 transform-set ".$_POST['transform']." esp-".$_POST['crypto_phase2']." esp-".$_POST['hash_phase2']."-hmac<br/><br/>";
                    }elseif($_POST['ike'] == '2'){
                        echo "crypto ipsec ikev2 ipsec-proposal ".$_POST['transform']."<br/>
                             protocol esp encryption ".$_POST['crypto_phase2']."<br/>
                             protocol esp integrity ".$_POST['hash_phase2']."<br/>
                        <br/>";
                    }

                   
                    
                    echo "
                    crypto map ".$_POST['crypto_map']." match address ".ucfirst($_POST['nom_distant'])."<br/>";
                    
                    if($_POST['pfs_phase2'] != '0'){
                    echo "crypto map ".$_POST['crypto_map']." set pfs group".$_POST['pfs_phase2']."<br/>"; }
                    
                    echo "crypto map ".$_POST['crypto_map']." set peer ".$_POST['ip_distant']." <br/>";
                    if($_POST['ike'] == '1'){
                        echo "crypto map ".$_POST['crypto_map']." set ikev1 transform-set ".$_POST['transform']."<br/>";
                    }elseif($_POST['ike'] == '2'){
                        echo "crypto map ".$_POST['crypto_map']." set ikev2 ipsec-proposal ".$_POST['transform']."<br/>";
                    }
                    echo "
                    crypto map ".$_POST['crypto_map']." set security-association lifetime seconds ".$_POST['life_phase2']."<br/>
                    <br/>
                    tunnel-group ".$_POST['ip_distant']." type ipsec-l2l<br/>
                    tunnel-group ".$_POST['ip_distant']." ipsec-attributes<br/>";
                    if($_POST['ike'] == '1'){
                        echo "ikev1 pre-shared-key ".$_POST['psk']."<br/><br/>";
                    }elseif($_POST['ike'] == '2'){
                        echo "ikev2 remote-authentication pre-shared-key ".$_POST['psk']."<br/>
                            ikev2 local-authentication pre-shared-key ".$_POST['psk']."<br/>
                        <br/>";
                    }
                    

                    
                       

                    
                     echo '</td>
	            </tr></table></center>';

	     exit;   
	    }

