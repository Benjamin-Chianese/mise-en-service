<?php
require ('../includes/head.php');
require ('../vendor/autoload.php');

use PhpIP\IPv4Block;


  echo  '<center><div class="mx-auto" style="width: 600px;">
       <h3> Création configuration MPLS</h3>
      <form method="post" action="mpls.php">
      FSLNK : <br/>
      <input  type="text"  class="form-control" name="fslnk"  required value="'.$_POST['fslnk'].'"/><br/><br/>
      Nom VRF : <br/>
      <input  type="text"  class="form-control" name="vrf"  required value="'.$_POST['vrf'].'"/><br/><br/>
      <table border="1">
          <tr>
              <td>Description Interface</td>
              <td>Vlan</td>
              <td>Passerelle client (192.168.1.254/24)</td>
              <td>DHCP</td>
              <td>Helper</td>
         </tr>
          <tr>
              <td><input  type="text"  class="form-control" name="desc_client_1" required value="'.$_POST['desc_client_1'].'"/></td>
              <td><input  type="text" class="form-control"name="vlan_client_1" required value="'.$_POST['vlan_client_1'].'"/></td>
              <td><input  type="text" class="form-control"name="lan_client_1" required value="'.$_POST['lan_client_1'].'"/></td>
               <td><select name="dhcp_client_1"  class="form-control">
                              <option value="'.$_POST['dhcp_client_1'].'">'.$_POST['dhcp_client_1'].'</option>
                                <option value="Oui">Oui</option>
                                <option value="Helper">Helper</option>
                                <option value="Non">Non</option>
                        </select></td>
                <td><input  type="text" class="form-control"name="helper_client_1"  value="'.$_POST['helper_client_1'].'"/></td>

          </tr>
                  
            </table>
             Port MX : <br/>
         <select name="port_mx"  class="form-control">';
                if(!empty($_POST['port_mx'])){
                        echo'<option value="xe-0/0/0">xe-0/0/0</option>
                                <option value="xe-2/0/1">xe-2/0/1</option>';
                }else{
	                  echo'          <option value="'.$_POST['port_mx'].'">'.$_POST['port_mx'].'</option>
                                <option value="xe-0/0/0">xe-0/0/0</option>
                                <option value="xe-2/0/1">xe-2/0/1</option>';}
                                echo'
                        </select><br/><br/>

      WAN cpe : (10.255.255.0/31)<br/>
      <input  type="text"  class="form-control" name="wan_client" required value="'.$_POST['wan_client'].'"/><br/>
      Lo RED : (<a href="https://racktables.fullsave.org/index.php?page=ipv4net&tab=default&id=5069" target="_blank">100.81.16.0</a>)<br/>
      <input  type="text"  class="form-control" name="red" required value="'.$_POST['red'].'"/><br/>
      <br/>
      
      
    <button type="submit"  name="MPLS_generation" value="generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
      </form>
      </div></center>';
      
      
      
      
       if (!empty($_POST['fslnk']) && !empty($_POST['lan_client_1']) && !empty($_POST['desc_client_1']) && !empty($_POST['wan_client']) && !empty($_POST['MPLS_generation'])){

          
          echo '<center>----------------------------</center><br/><br/>';  

          $fslnk = $_POST['fslnk'];
          $vrf = $_POST['vrf'];
           $req_ID = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk%' ");
             $w = $req_ID->fetch(PDO::FETCH_ASSOC);
             
             $fsn = $w['service_ref'];
             $fsnE = substr($fsn, -5);
         $fsnBGP = substr($fsn, -2);
         $as = '648'.$fsnBGP;
         $charset='utf-8';

              $name = $w['name'];
              $name = htmlentities( $name, ENT_NOQUOTES, $charset );
              $name = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $name );
              $name = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $name );
              $name = preg_replace( '#&[^;]+;#', '', $name );

            $red = $_POST['red'];
             
             $port_mx = $_POST['port_mx'];
             $mask_format_1 = explode('/',$_POST['lan_client_1']);
             $mask_c_1 = $mask_format_1[1];
            
            $ip_format_1 = explode('.',$mask_format_1[0]);
            
            $ip_1_1 = $ip_format_1[0];
            $ip_2_1 = $ip_format_1[1];
            $ip_3_1 = $ip_format_1[2];
            $ip_4_1 = $ip_format_1[3];
            $desc_lan_1 = $_POST['desc_client_1'];
            $lan_client_1 = $ip_1_1.'.'.$ip_2_1.'.'.$ip_3_1.'.0';
            $passerelle_client_1 = $ip_1_1.'.'.$ip_2_1.'.'.$ip_3_1.'.'.$ip_4_1;
            $mask_1 = $netmask_slash[$mask_c_1];
            
            if(!empty($_POST['lan_client_2']) && !empty($_POST['lan_client_2'])){
                
                $mask_format_2 = explode('/',$_POST['lan_client_2']);
             $mask_c_2 = $mask_format_2[1];
            
            $ip_format_2 = explode('.',$mask_format_2[0]);
            
            $ip_1_2 = $ip_format_2[0];
            $ip_2_2 = $ip_format_2[1];
            $ip_3_2 = $ip_format_2[2];
            $ip_4_2 = $ip_format_2[3];
            
            $desc_lan_2 = $_POST['desc_client_2'];
            $lan_client_2 = $ip_1_2.'.'.$ip_2_2.'.'.$ip_3_2.'.0';
            $passerelle_client_2 = $ip_1_2.'.'.$ip_2_2.'.'.$ip_3_2.'.'.$ip_4_2;
            $mask_2 = $netmask_slash[$mask_c_2];
            }
            
            if(!empty($_POST['lan_client_3']) && !empty($_POST['lan_client_3'])){
                
                $mask_format_3 = explode('/',$_POST['lan_client_3']);
             $mask_c_3 = $mask_format_3[1];
            
            $ip_format_3 = explode('.',$mask_format_3[0]);
            
            $ip_1_3 = $ip_format_3[0];
            $ip_2_3 = $ip_format_3[1];
            $ip_3_3 = $ip_format_3[2];
            $ip_4_3 = $ip_format_3[3];
            
            $desc_lan_3 = $_POST['desc_client_3'];
            $lan_client_3 = $ip_1_3.'.'.$ip_2_3.'.'.$ip_3_3.'.0';
            $passerelle_client_3 = $ip_1_3.'.'.$ip_2_3.'.'.$ip_3_3.'.'.$ip_4_3;
            $mask_3 = $netmask_slash[$mask_c_3];
            }
            
            if(!empty($_POST['lan_client_4']) && !empty($_POST['lan_client_4'])){
                
                $mask_format_4 = explode('/',$_POST['lan_client_4']);
             $mask_c_4 = $mask_format_4[1];
            
            $ip_format_4 = explode('.',$mask_format_4[0]);
            
            $ip_1_4 = $ip_format_4[0];
            $ip_2_4 = $ip_format_4[1];
            $ip_3_4 = $ip_format_4[2];
            $ip_4_4 = $ip_format_4[3];
            
            $desc_lan_4 = $_POST['desc_client_4'];
            $lan_client_4 = $ip_1_4.'.'.$ip_2_4.'.'.$ip_3_4.'.0';
            $passerelle_client_4 = $ip_1_4.'.'.$ip_2_4.'.'.$ip_3_4.'.'.$ip_4_4;
            $mask_4 = $netmask_slash[$mask_c_4];
            }
            
            $mask_format_wan = explode('/',$_POST['wan_client']);
             $mask_c_wan = $mask_format_wan[1];
            
$block_wan_v4 = new IPv4Block($_POST['wan_client']);

$wan_pe = $block_wan_v4->getFirstIp();
$wan_cpe = $block_wan_v4->getLastIp();
$mask_wan = $netmask_slash[$mask_c_wan];
$wan_wilcard = $block_wan_v4->getDelta();

          $techno = $w['media'];
          $operateur = $w['supplier'];
          $debit = substr($w['bandwidth'], 0, -3);
          $hostname = 'fsn' . $fsnE;
          $adresse = $w['adresse'].' '.$w['cp'].' '.$w['localite'];

$pe =  $w['pe'];
            
            if($operateur == 'Natira'){
            $wan_interface = 'ge-0/0/7';
            }else{
                $wan_interface = 'ge-0/0/0';
            }

       
            
  echo "<center><table border='1'>
                <tr>
                    <td>Conf CPE  : </td>
                    <td>Conf PE ".$pe."</td>
                </tr>
               <tr>
                    <td>";                    
echo '<textarea rows="50" cols="75">
// *** SET TIMEZONE. ATTENTION A FAIRE EN MODE USER  *** //

clock timezone CET add 01:00:00
clock daylight-saving-time CEST repeating 02:00 last Sun Mar 03:00 last Sun Oct 01:00


//  *** HOSTNAME *** //

system-view
sysname '.$hostname.'


// *** BANNER AT LOGIN *** //


header login information "
========================================================================
Caution : This is a private router of the FullSave company.
Any unauthorized access will be prosecuted.
Attention : ce routeur est un routeur prive propriete de FullSave
Toute utilisation frauduleuse fera l\'objet de poursuites.
Merci de contacter FullSave au 05.62.24.34.18 en cas de probleme d\'acces.
=========================================================================
"

//  *** ACTIVER L\'IPV6 ***  //

ipv6

//   *** ACL AMDIN  *** //

acl name ADMIN 2000  
 rule 5 permit source 100.80.0.192 0.0.0.7 
 rule 10 permit source 100.80.0.224 0.0.0.7 
 rule 15 permit source 100.80.15.0 0.0.0.255 
 rule 20 permit source '.$wan_pe.' '.$wan_wilcard.' 


//  *** INTERFACES  ***  //

//  *** PAR DEFAUT LES INTERFACES Gi 0/0/0 à Gi 0/0/7 APPARTIENNENT DEJA AU VLAN 1 = LAN, L\'INTERFACE Gi 0/0/0 SERA PAR DEFAUT CONNECTÉE SUR LE LAN CLINT ***  //
//  *** LES INTERFACES Gi 0/0/8 à Gi 0/0/9 SONT DES INTERFACES WAN, PAR DEFAULT, NOUS UTILISERONS Gi 0/0/8 POUR LE WAN***  //
//  *** L\'INTERFACE Gi 0/0/7 SERA UTILISÉE EN CAS D\'UN BACK-TO-BACK  ***  //


interface GigabitEthernet 0/0/8
 description WAN
 trust dscp
 ip address '.$wan_cpe.' 31
 qos pre-nat
 qos gts cir '.$w['bandwidth'].'

interface LoopBack 15
 description ADMIN RED-NET-ISP
 ip address '.$red.' 32

interface  Vlanif'.$_POST['vlan_client_1'].'
 description '.$desc_lan_1.'
 ip address '.$passerelle_client_1.' '.$mask_c_1;
 if($_POST['dhcp_client_1']  == 'Oui'){
 echo'
 dhcp select interface
 dhcp server ip-range '.$ip_1_1.'.'.$ip_2_1.'.'.$ip_3_1.'.100 '.$ip_1_1.'.'.$ip_2_1.'.'.$ip_3_1.'.200
 dhcp server gateway-list '.$passerelle_client_1.' 
 dhcp server dns-list 141.0.202.202 141.0.202.203';
 }
 echo '
 quit

//  *** ACTIVATION DU MODULE 4G *** //

apn profile NET26
 apn net26

dialer-rule
 dialer-rule 1 ip permit
 dialer-rule 1 ipv6 permit

interface Cellular0/0/0
 trust dscp
 dialer enable-circular
 dialer-group 1
 apn-profile NET26
 dialer timer autodial 10
 dialer number *99# autodial
 modem auto-recovery dial action modem-reboot fail-times 128
 modem auto-recovery services-unavailable action modem-reboot test-times 0 interval 3600
 ip address negotiate
 pin verify
 pin verification disable 

-> Si le code PIN est demandé, taper le code PIN 0000 puis valider

//  *** CONFIGUGRATION IPSLA ***  //

nqa test-instance NQA1 NQA1
 test-type icmp
 destination-address ipv4 '.$wan_pe.'
 source-address ipv4 '.$wan_cpe.'
 frequency 15
 source-interface GigabitEthernet0/0/8
 start now
#

// ** Route statique IPv6 ** //
ipv6 route-static :: 0 GigabitEthernet0/0/8 FE80::1 track nqa NQA1 NQA1

//  *** CONFIGURATION ROUTE PAR DEFAUT VIA LA 4G  ***  //

ip route-static 0.0.0.0 0.0.0.0 Cellular0/0/0 preference 255

//  *** ACTIVATION SSH *** //

ssh server permit interface all
ssh server-source -i LoopBack15
stelnet server enable 
user-interface vty 0 4
 acl 2000 inbound
 authentication-mode aaa
 user privilege level 15
 protocol inbound ssh
 quit

// *** GENERATION DE CLE RSA PLUS FORTE ***  //

rsa local-key-pair create 

-> Repondre Yes (Y) à la question posée
-> Choisir comme modulus 4096 puis valider, attendre que la clé soit générée.

// *** PAR DEFAUT LE COMPTE "admin" N\'A PAS ACCES EN SSH, ACTIVER CELA EN FAISANT ***  //

aaa
local-user admin service-type terminal http ssh

//  CONFIGUGRATION NTP  //

ntp-service unicast-server 100.80.15.4 source-interface LoopBack15
ntp-service unicast-server 100.80.15.132 source-interface LoopBack15

// *** SNMP *** //

snmp-agent complexity-check disable
snmp-agent community read fscommunity acl 2000 
snmp-agent sys-info contact support@fullsave.com
snmp-agent sys-info location "'.$adresse.'"
snmp-agent sys-info version v2c                      
snmp-agent server-source -i LoopBack 15
snmp-agent trap enable

// *** ACTIVATION TACACS *** //

hwtacacs enable 
hwtacacs-server template TACACS
 hwtacacs-server authentication 100.80.15.5
 hwtacacs-server authentication 100.80.15.133 secondary
 hwtacacs-server authorization 100.80.15.5
 hwtacacs-server authorization 100.80.15.133 secondary
 hwtacacs-server accounting 100.80.15.5
 hwtacacs-server accounting 100.80.15.133 secondary
 hwtacacs-server source-ip source-LoopBack 15
 hwtacacs-server shared-key cipher %^%#:wNuQ\"Mv+KwiAJA(,{;/\'e/PxTX83y>|.,_/;J4%^%#

aaa
 authentication-scheme AAA
  authentication-mode hwtacacs local
 authorization-scheme AAA
  authorization-mode hwtacacs local
 accounting-scheme AAA
  accounting-mode hwtacacs
  accounting start-fail online
 accounting-scheme AAA
  accounting-mode hwtacacs
  accounting realtime 3
  accounting start-fail online
 domain default_admin
  authentication-scheme AAA
  accounting-scheme AAA
  authorization-scheme AAA
  hwtacacs-server TACACS

// *** ACTIVATION DE L\'INTERFACE WEB DU CPE  ***  //
// *** UNE FOIS CES LIGNES ACTIVIÉES, L\'ACCES HTTPS SE FERA EN FAISANT, https://'.$red.':50443  *** //

http acl 2000     
http server permit interface all
http secure-server enable
http secure-server port 50443  
http server-source -i LoopBack 15      

//  *** DEACTIVER TOUTES LES INTERFACES NON UTILISÉES  ***  //

int gi0/0/1
 shutdown
int gi0/0/2
 shutdown
int gi0/0/3
 shutdown
int gi0/0/4
 shutdown
int gi0/0/5
 shutdown
int gi0/0/6
 shutdown
int gi0/0/7
 shutdown

//  *** DEFAULT QOS IMPLEMENTATION  FOR WAN INTERFACE  ***  //

---------------------- REALTIME_FAI --------------------------------------

traffic classifier CLASS_REALTIME_FAI
 if-match dscp ef 

traffic behavior BEHA_REALTIME_FAI       
 queue ef bandwidth pct 10                
 statistic enable 

----------------------NETWORK_CONTROL_FAI --------------------------------

acl name NETWORK_CONTROL_FAI  
 rule 10 permit tcp destination-port eq bgp 
 rule 20 permit tcp source-port eq bgp 
 rule 30 permit udp source-port eq snmp destination 10.80.0.0 0.0.255.255 
 rule 40 permit udp source-port eq snmptrap destination 10.80.0.0 0.0.255.255 
 rule 50 permit tcp source 100.81.32.0 0.0.15.255 source-port eq 22 destination 10.80.0.0 0.0.255.255
 rule 60 permit udp destination '.$wan_pe.' '.$wan_wilcard.' destination-port eq 3784

traffic classifier CLASS_NETWORK_CONTROL_FAI
 if-match dscp cs2
 if-match acl NETWORK_CONTROL_FAI

traffic behavior BEHA_NETWORK_CONTROL_FAI
 queue llq bandwidth pct 5
 statistic enable
 
---------------------- MISSION_CRITICAL_FAI ------------------------------

traffic classifier CLASS_MISSION_CRITICAL_FAI
 if-match dscp af11
 if-match dscp af21
 if-match dscp af31

traffic behavior BEHA_MISSION_CRITICAL_FAI
 queue af bandwidth pct 30                
 statistic enable 

---------------------VIDEO_STREAMING_FAI ---------------------------------

traffic classifier CLASS_VIDEO_STREAMING_FAI
 if-match dscp af41

traffic behavior BEHA_VIDEO_STREAMING_FAI
 queue af bandwidth pct 30
 statistic enable 

----------------------BEST_EFFORT_FAI---------------------------------------

traffic behavior BEHA_BEST_EFFORT_FAI    
 queue wfq                                
 statistic enable 

-----------------------TRAFFIC POLICY DEFINITION --------------------------

traffic policy WAN_FAI
 classifier CLASS_REALTIME_FAI behavior BEHA_REALTIME_FAI
 classifier CLASS_NETWORK_CONTROL_FAI behavior BEHA_NETWORK_CONTROL_FAI
 classifier CLASS_MISSION_CRITICAL_FAI behavior BEHA_MISSION_CRITICAL_FAI
 classifier CLASS_VIDEO_STREAMING_FAI behavior BEHA_VIDEO_STREAMING_FAI
 classifier default-class  behavior BEHA_BEST_EFFORT_FAI

-----------------------TRAFFIC POLICY APPLY TO WAN INTERFACE ---------------

interface GigabitEthernet0/0/8
 traffic-policy WAN_FAI outbound

interface Cellular0/0/0
 traffic-policy WAN_FAI outbound

//  *** DEFINITION DES PREFIXES IP  ***  //

ip ip-prefix PFIX_DEFAULT_ROUTE index 10 permit 0.0.0.0 0

ip ip-prefix PFIX_LOOPBACK index 10 permit 100.81.16.0 20 less-equal 32

ip ip-prefix PFIX_CUSTOMER index 10 permit '.$lan_client_1.' '.$mask_c_1.'

//  ***  ROUTE POLICY: POUR LES ROUTES ENVOYÉES DU CPE VERS LE PE  ***  //

route-policy EXPORT_TO_PE permit node 10
 if-match ip-prefix PFIX_CUSTOMER

route-policy EXPORT_TO_PE permit node 20
 if-match ip-prefix PFIX_LOOPBACK

route-policy EXPORT_TO_PE deny node 100

//  ***  ROUTE POLICY: POUR LA ROUTE PAR DEFAUT ENVOYÉE DU PE VERS LE CPE  ***  //

route-policy IMPORT_FROM_PE permit node 10
 if-match ip-prefix PFIX_DEFAULT_ROUTE

// *** CONFIGURATION BGP ***  //

bgp '.$as.'
 router-id '.$red.'
 peer '.$wan_pe.' as-number 39405
 peer '.$wan_pe.' description '.$pe.':'.$port_mx.'
 
 ipv4-family unicast
  default-route imported
  import-route direct
  peer '.$wan_pe.' enable
  peer '.$wan_pe.' next-hop-local
  peer '.$wan_pe.' route-policy IMPORT_FROM_PE import
  peer '.$wan_pe.' route-policy EXPORT_TO_PE export

   network '.$red.' 32
!!!
!Si plusieurs LANs, ajouter autant de ligne que de LAN
  network '.$lan_client_1.' '.$mask_c_1.'         
 

//  *** SAUVEGARDER LA CONFIGURATION, TOUT MOMENT FAIRE SAVE POUR SAUVEGARDER  ***  //

save    // Répondre Y à la question posée
quit
</textarea>
</td>
<td>
';
#### Circuit



$collecte_explode = explode(':', $w['collecte']);
$collecte = $collecte_explode[0];
$collecte_port = $collecte_explode[1];


 if($w['support'] == "24/7" || $w['vip'] == "1"){
    
    echo "
        <h3>Supervison</h3>
        FSHMON02 : <br/>
        sudo vim /etc/shinken/objects/hosts/fsn.cfg<br/><br/>
    define host{<br/>
        \thost_name ".$hostname."<br/>
        \tuse Network-FSN,SLA-24x7,Production_Reseau<br/>
        \talias ".$hostname."<br/>
        \taddress ".$wan_cpe."<br/>
        \thostgroups Clients-FAI<br/>
        \trealm LBG01<br/>
}<br/><br/>";
 }




### conf PE

 
echo '<textarea rows="25" cols="100">     
set groups SERVICE-'.$vrf.' interfaces '.$port_mx.' unit '.$w['vlan'].' description "'.$fsn.' - '.$name.'"
set groups SERVICE-'.$vrf.' interfaces '.$port_mx.' unit '.$w['vlan'].' vlan-id '.$w['vlan'].'
set groups SERVICE-'.$vrf.' interfaces '.$port_mx.' unit '.$w['vlan'].' family inet address '.$wan_pe.'/31

set groups SERVICE-'.$vrf.' policy-options policy-statement IMPORT_VRF_'.$vrf.' term ACCEPT_IN from community COM_'.$vrf.'
set groups SERVICE-'.$vrf.' policy-options policy-statement IMPORT_VRF_'.$vrf.' term ACCEPT_IN then accept
set groups SERVICE-'.$vrf.' policy-options policy-statement IMPORT_VRF_'.$vrf.' term LAST then reject
set groups SERVICE-'.$vrf.' policy-options policy-statement EXPORT_VRF_'.$vrf.' term ACCEPT_OUT from next-hop '.$wan_cpe.'
set groups SERVICE-'.$vrf.' policy-options policy-statement EXPORT_VRF_'.$vrf.' term ACCEPT_OUT then community set COM_'.$vrf.'
set groups SERVICE-'.$vrf.' policy-options policy-statement EXPORT_VRF_'.$vrf.' term ACCEPT_OUT then accept
set groups SERVICE-'.$vrf.' policy-options policy-statement EXPORT_VRF_'.$vrf.' term LAST then reject

set groups SERVICE-'.$vrf.' policy-options community COM_'.$vrf.' members target:'.$w['customer_id'].':1

set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' instance-type vrf
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' interface '.$port_mx.'.'.$w['vlan'].'

set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' route-distinguisher '.$w['customer_id'].':1

set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' vrf-import IMPORT_ROUTE_FROM_RED
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' vrf-import IMPORT_VRF_'.$vrf.'
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' vrf-export EXPORT_ROUTE_TO_RED
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' vrf-export EXPORT_VRF_'.$vrf.'
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' vrf-table-label

set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' routing-options static route '.$red.' next-hop '.$wan_cpe.'
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' routing-options static route '.$red.' tag 5015

set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' protocols bgp group eBGP_'.$vrf.'_'.$fsn.' type external
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' protocols bgp group eBGP_'.$vrf.'_'.$fsn.' local-address '.$wan_pe.'
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' protocols bgp group eBGP_'.$vrf.'_'.$fsn.' family inet unicast
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' protocols bgp group eBGP_'.$vrf.'_'.$fsn.' peer-as '.$as.'
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' protocols bgp group eBGP_'.$vrf.'_'.$fsn.' local-as 39405
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' protocols bgp group eBGP_'.$vrf.'_'.$fsn.' neighbor '.$wan_cpe.'

!!!!!
!Si Pfsense pour transit MPLS 
set groups SERVICE-'.$vrf.' routing-instances '.$vrf.' protocols bgp group eBGP_'.$vrf.'_'.$fsn.' neighbor '.$wan_cpe.' export EXPORT-ROUTES-TO-MPLS-VCPE

set apply-groups SERVICE-'.$vrf.'

!!!!!
!QoS sur l\'interface :';
if($debit < 1000){
echo '
set class-of-service interfaces '.$port_mx.' unit '.$w['vlan'].' output-traffic-control-profile TRAFFIC_CONTROL_'.$debit.'Mbps';
}elseif($debit == 1000) {
  echo '
set class-of-service interfaces '.$port_mx.' unit '.$w['vlan'].' output-traffic-control-profile TRAFFIC_CONTROL_1Gbps';  
}
echo '
set class-of-service interfaces '.$port_mx.' unit '.$w['vlan'].' classifiers dscp CLASSIFIER_DSCP_IN_FAI
</textarea>';
 }
  echo '</td>
  
              </tr></table></center>';           
          
          
               exit;   
      


require('../includes/foot.php');
?>
