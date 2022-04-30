<?php
require ('../includes/head.php');
require ('../vendor/autoload.php');

use PhpIP\IPv4Block;
use PhpIP\IPv6Block;

  echo  '<center><div class="mx-auto" style="width: 600px;">
         <h3> Création configuration CPE Internet access </h3>
        <form method="post" action="conf_cpe.php">
        FSLNK : <br/>
        <input  type="text"  class="form-control" name="fslnk"  required value="'.$_POST['fslnk'].'"/><br/><br/>
        <table border="1">
            <tr>
                <td>Description Interface</td>
                <td>Vlan</td>
                <td>Passerelle client / PA (192.168.1.254/24)</td>
                <td>DHCP</td>
                <td>Helper</td>
           </tr>
            <tr>
                <td><input  type="text"  class="form-control" name="desc_client_1" required value="'.$_POST['desc_client_1'].'"/></td>
                <td><input  type="text" class="form-control"name="vlan_client_1" required value="'.$_POST['vlan_client_1'].'"/></td>
                <td><input  type="text" class="form-control"name="lan_client_1" required value="'.$_POST['lan_client_1'].'"/></td>
                 <td><select name="dhcp_client_1"  class="form-control">';
                 if(!empty($_POST['dhcp_client_1'])){
                     echo'   <option value="'.$_POST['dhcp_client_1'].'">'.$_POST['dhcp_client_1'].'</option>';
                 }
                echo'              
                                <option value="Oui">Oui</option>
                                <option value="PA">PA</option>
                                <option value="Helper">Helper</option>
                                <option value="Non">Non</option>
                        </select></td>
                <td><input  type="text" class="form-control"name="helper_client_1"  value="'.$_POST['helper_client_1'].'"/></td>

            </tr>          
            </table>
         Port MX : <br/>
         <select name="port_mx"  class="form-control">';
                if(empty($_POST['port_mx'])){
                        echo'<option value="xe-0/0/0">xe-0/0/0</option>
                                <option value="xe-2/0/1">xe-2/0/1</option>';
                }else{
                      echo'          <option value="'.$_POST['port_mx'].'">'.$_POST['port_mx'].'</option>
                                <option value="xe-0/0/0">xe-0/0/0</option>
                                <option value="xe-2/0/1">xe-2/0/1</option>';}
                                echo'
                        </select><br/><br/>
                         CPE : <br/>
         <select name="type_cpe"  class="form-control">';
                if(empty($_POST['type_cpe'])){
                    
                        echo'
                                <option value="Huawei">Huawei</option>
';
                }else{
                      echo'          <option value="'.$_POST['type_cpe'].'">'.$_POST['type_cpe'].'</option>
                               
                               <option value="Huawei">Huawei</option>
>';}
                                echo'
                        </select><br/><br/>

        CGN POOL : (<a href="https://racktables.fullsave.org/index.php?page=ipv4net&tab=default&id=6257" target="_blank">100.89.0.0</a> prendre une /29)<br/>
        <input  type="text"  class="form-control" name="cgn_client" required value="'.$_POST['cgn_client'].'"/><br/><br/>
        WAN V4 : (Prendre un /32, pas avec une PA)<br/>
        <input  type="text"  class="form-control" name="wan_client"  value="'.$_POST['wan_client'].'"/><br/><br/>
         WAN V6 POOL : (2a01:6600:50c0:8500::46/127)<br/>
        <input  type="text"  class="form-control" name="wan_v6" required value="'.$_POST['wan_v6'].'"/><br/><br/>
         Prefix V6 POOL : (2a01:6600:6082:2a00::/56)<br/>
        <input  type="text"  class="form-control" name="prefix_v6" required value="'.$_POST['prefix_v6'].'"/><br/><br/>
        Lo25 : (<a href="https://racktables.fullsave.org/index.php?page=ipv4net&tab=default&id=5351" target="_blank">100.81.32.0</a>)<br/>
        <input  type="text"  class="form-control" name="lo25" required value="'.$_POST['lo25'].'"/><br/><br/>
        DUID : (display dhcpv6 duid : 0003000120AB48A8A19A)<br/>
        <input  type="text"  class="form-control" name="duid" required value="'.$_POST['duid'].'"/><br/><br/>
        
      <button type="submit"  name="conf_cpe_generation" value="generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
        </form>
        </div></center>';
        
        
        
        
         if (!empty($_POST['fslnk']) && !empty($_POST['lan_client_1']) && !empty($_POST['desc_client_1'])  && !empty($_POST['cgn_client']) && !empty($_POST['conf_cpe_generation'])){

            
            echo '<center>----------------------------</center><br/><br/>';  

            $fslnk = $_POST['fslnk'];
            $vrf = $_POST['vrf'];
             $req_ID = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk%' ");
             $w = $req_ID->fetch(PDO::FETCH_ASSOC);
             
             $fsn = $w['service_ref'];
             $pe =  $w['pe'];
              $charset='utf-8';

              $name = $w['name'];
              $name = htmlentities( $name, ENT_NOQUOTES, $charset );
              $name = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $name );
              $name = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $name );
              $name = preg_replace( '#&[^;]+;#', '', $name );

             $contact_name = $w['contact_name'];
             $contact_tel = $w['contact_tel'];
             $contact_mail = $w['contact_mail'];
             


             $fsnE = substr($fsn, -5);
             $fsnBGP = substr($fsn, -3);
             $as = '65'.$fsnBGP;
             
            $lo25 = $_POST['lo25'];
            $port_mx = $_POST['port_mx'];

             $desc_lan_1 = $_POST['desc_client_1'];
             $mask_format_1 = explode('/',$_POST['lan_client_1']);
             $mask_c_1 = $mask_format_1[1];
             if( $_POST['dhcp_client_1']  == 'Oui'){
                    
            $ip_format_1 = explode('.',$mask_format_1[0]);
            
            $ip_1_1 = $ip_format_1[0];
            $ip_2_1 = $ip_format_1[1];
            $ip_3_1 = $ip_format_1[2];
            $ip_4_1 = $ip_format_1[3];
            
            
            $lan_client_1 = $ip_1_1.'.'.$ip_2_1.'.'.$ip_3_1.'.0';
            $passerelle_client_1 = $ip_1_1.'.'.$ip_2_1.'.'.$ip_3_1.'.'.$ip_4_1;
            $mask_1 = $netmask_slash[$mask_c_1];
            $wildcard_1 = $wildcard_slash[$mask_c_1];
            $dhcp = $ip_1_1.'.'.$ip_2_1.'.'.$ip_3_1;
            }

            elseif($_POST['dhcp_client_1']  == 'PA'){
                    $block_PA = new IPv4Block($_POST['lan_client_1']);


                    $cidr_pa = $mask_c_1;
                    $passerelle_pa = $block_PA->getMask();
                    $pool_pa = $block_PA->getFirstIp().'/'.$mask_c_1;
                    $mask_pa = $block_PA->getMask();

                    $lan_client_1 = '192.168.1.0';
                    $passerelle_client_1 = '192.168.1.254';
                    $mask_1 = '255.255.255.0';
                    $wildcard_1 = '0.0.0.255';
                    $dhcp = '192.168.1';
            }

            
            $mask_format_wan = explode('/',$_POST['cgn_client']);
             $mask_c_wan = $mask_format_wan[1];
        

$huawei_cgn_v4 = new IPv4Block($_POST['cgn_client']);
$fin_ip = $huawei_cgn_v4->getNbAddresses() -2;
$cgn_pe = $huawei_cgn_v4[1];
$cgn_cpe = $huawei_cgn_v4[$fin_ip];
$cgn_wilcard = $huawei_cgn_v4->getDelta();


$block_wan_v6 = new IPv6Block($_POST['wan_v6']);

            $wan_v6_cpe = $block_wan_v6->getLastIp();
            $wan_v6_pe = $block_wan_v6->getFirstIp();
            

            
            
            $techno = $w['media'];
            $operateur = $w['supplier'];
            $type_cpe = $_POST["type_cpe"]; 
            

             switch ($type_cpe) {
                    case 'Huawei':
                    $type_cpe_nom = 'Huawei AR651';
                        $wan_interface = 'Gi0/0/8';
                        $vlan = 'Vlan'.$_POST['vlan_client_1'];
                    break;
                   
                }

            
            
            $debit = substr($w['bandwidth'], 0, -3);
            $hostname = 'fsn' . $fsnE;
            $adresse = $w['name'].' '.$w['adresse'].' '.$w['cp'].' '.$w['localite'];
            $fsc_brut = $w['customer_id'];
            $fsc_count = strlen($fsc_brut);
            switch ($fsc_count) {
    case 1:
        $fsc = 'FSC0000'.$fsc_brut;
        break;
    case 2:
        $fsc = 'FSC000'.$fsc_brut;
        break;
    case 3:
        $fsc = 'FSC00'.$fsc_brut;
        break;
    case 4:
        $fsc = 'FSC0'.$fsc_brut;
        break;
    case 5:
        $fsc = 'FSC'.$fsc_brut;
        break;
}


            $wiki = $fsc.'/'.$hostname;




            
  echo "<center><table border='1'>
                <tr>
                    <td>Conf CPE ".$type." : </td>
                    <td>Conf PE ".$pe."</td>
                </tr>
                 <tr>
                    <td>"; 

echo '<textarea rows="50" cols="100">';
if($type_cpe == "Huawei"){
    echo '
VARIABLES :

'.$hostname.'                           : Nom de l`\'équipement
'.$cgn_pe.'                             : Adresse IP CGN du PE (1ère IP du pool) (Prendre un subnet /29 de libre dans le pool 100.89.0.0/16)
'.$cgn_wilcard.'                        : PE Wilcard (généralement 0.0.0.7)
'.$cgn_cpe.'                            : Adresse IP CGN WAN du CPE (Dernière IP du pool) (Prendre un subnet /29 de libre dans le pool 100.89.0.0/16)
29                                      : Netmask en notation CIDR (par defaut 29)
'.$wan_v6_cpe.'                         : Adresse IPv6 WAN du CPE
'.$_POST['wan_client'].'                : Adresse IP WAN du client. (Prendre une IP /32 de libre dans les pool PA ISP et la nommer PA - FSLNKXXXXX)
'.$pe.'                                 : Le nom du PE (par exemple lbg01-2-mx)
'.$lo25.'                               : Adresse IP de la loopback. (Prendre une IP /32 de libre dans le pool 100.81.32.0/20)
Gi 0/0/0                                : Interface LAN, par defaut Gi 0/0/0 (interfaces réservée au LAN du client de Gi 0/0/0 à Gi 0/0/6)
'.$passerelle_client_1.'                : IP adresse allouée à l\'interface LAN (par defaut 192.168.1.254)
24                                      : Notation CIDR du masque de sous-réseau alloué à l\'interface LAN (par defaut 24)
'.$dhcp.'.100 : Adresse de debut du pool dhcp, par defaut 192.168.1.100
'.$dhcp.'.200 : Adresse de fin du pool dhcp, par defaut 192.168.1.199
'.$passerelle_client_1.''.$passerelle_client_1.'  : Adresse IP de la passerelle, par defaut remplacer cette variable par #LAN_IP_ADDRESS# 
141.0.202.202 141.0.202.203             : Remplacer cette variable par les IP des DNS, par defaut 141.0.202.202 141.0.202.203
prefix-from-'.$pe.'                     : Remplacer cette varialbe par "prefix-from-lbg01-2-mx" si le CPE est attaché à lbg01-2-mx ou "prefix-from-tls00-2-mx" si CPE attaché à tls00-2-mx
NET26                                   : Remplacer cette variable par le nom donné au profile apn, dans notre cas c\'est NET26
net26                                   : Le nom de l\'apn, dans notre cas mettre net26
'.$adresse.'                            : Adresse ou emplacement physique de l\'équipement
'.$lan_client_1.'                       : Adresse réseau LAN
'.$wildcard_1.'                         : Wilcard du réseau LAN
'.$w['bandwidth'].'                     : La bande passante souscrite par le client en Kbit/s, par exemple si la bande passante est de 100Mbit/s, remplacer la variable par 100000, si la bande passante est de 1Gbits remplacer la variable par 1000000



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
 rule 20 permit source '.$cgn_pe.' '.$cgn_wilcard.' 


//  *** INTERFACES  ***  //

//  *** PAR DEFAUT LES INTERFACES Gi 0/0/0 à Gi 0/0/7 APPARTIENNENT DEJA AU VLAN 1 = LAN, L\'INTERFACE Gi 0/0/0 SERA PAR DEFAUT CONNECTÉE SUR LE LAN CLINT ***  //
//  *** LES INTERFACES Gi 0/0/8 à Gi 0/0/9 SONT DES INTERFACES WAN, PAR DEFAULT, NOUS UTILISERONS Gi 0/0/8 POUR LE WAN***  //
//  *** L\'INTERFACE Gi 0/0/7 SERA UTILISÉE EN CAS D\'UN BACK-TO-BACK  ***  //


interface GigabitEthernet 0/0/8
 description WAN
 trust dscp
 ip address '.$cgn_cpe.' 29
 qos pre-nat
 qos gts cir '.$w['bandwidth'].'
 ipv6 enable
 ipv6 address auto link-local
 undo ipv6 address auto global
 undo ipv6 address auto dhcp
 ipv6 address '.$wan_v6_cpe.' 127
 dhcpv6 client pd prefix-from-'.$pe.'
interface LoopBack 25
 description ADMIN RED-NET-ISP
 ip address '.$lo25.' 32';

 if($_POST['dhcp_client_1']  == 'PA'){
echo '
interface LoopBack 50
 description ISP PA
 ip address '.$_POST['wan_client'].' 32



interface  Vlanif1
 description DATA
 ip address 192.168.1.254 24
 dhcp select interface
 dhcp server ip-range 192.168.1.100 192.168.1.200
 dhcp server gateway-list 192.168.1.254 
 dhcp server dns-list 141.0.202.202 141.0.202.203
 ipv6 enable
 ipv6 address auto link-local
 ipv6 address prefix-from-'.$pe.' ::1/64      
 undo ipv6 nd ra halt 
 shutdown

vlan 2

interface Vlanif2
description PA
ip address '.$block_PA[1].' '.$cidr_pa.'
ipv6 enable
ipv6 address prefix-from-'.$pe.' ::1:0:0:0:1/64
ipv6 address auto link-local
undo ipv6 nd ra halt
undo shutdown

interface gi0/0/6
description PA
port link-type access
port default vlan 2
undo shutdown
';
}else{
    echo '

interface  Vlanif'.$_POST['vlan_client_1'].'
 description '.$desc_lan_1.'
 ip address '.$passerelle_client_1.' '.$mask_c_1.'
 dhcp select interface
 dhcp server ip-range '.$dhcp.'.100 '.$dhcp.'.200
 dhcp server gateway-list '.$passerelle_client_1.' 
 dhcp server dns-list 141.0.202.202 141.0.202.203
 ipv6 enable
 ipv6 address auto link-local
 ipv6 address prefix-from-'.$pe.' ::1/64      
 undo ipv6 nd ra halt 
 quit';
}
echo '
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
 !!!!!!!! Attention marquer l\arret pour tapper le code pin de la SIM
 pin verification disable 


-> Si le code PIN est demandé, taper le code PIN 0000 puis valider


//  *** CONFIGUGRATION IPSLA ***  //

nqa test-instance NQA1 NQA1
 test-type icmp
 destination-address ipv4 '.$cgn_pe.'
 source-address ipv4 '.$cgn_cpe.'
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
ssh server-source -i LoopBack25
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


ntp-service unicast-server 100.80.15.4 source-interface LoopBack25
ntp-service unicast-server 100.80.15.132 source-interface LoopBack25


// *** SNMP *** //

snmp-agent complexity-check disable
snmp-agent community read fscommunity acl 2000 
snmp-agent sys-info contact support@fullsave.com
snmp-agent sys-info location "'.$adresse.'"
snmp-agent sys-info version v2c                      
snmp-agent server-source -i Loopback 25
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

 hwtacacs-server source-ip source-loopback 25
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
// *** UNE FOIS CES LIGNES ACTIVIÉES, L\'ACCES HTTPS SE FERA EN FAISANT, https://'.$lo25.':50443  *** //


http acl 2000     
http server permit interface all
http secure-server enable
http secure-server port 50443  
http server-source -i Loopback 25      

// *** ACL POUR LA NAT *** //

acl name NAT 3000  
 rule 10 permit ip source '.$lan_client_1.' '.$wildcard_1.' 
 rule 20 deny ip source 100.81.32.0 0.0.15.255


//  *** ACTIVER LA NAT ***  //

int GigabitEthernet 0/0/8
 nat outbound 3000 interface LoopBack 50

int Cellular 0/0/0
 nat outbound 3000


//  *** DEACTIVER TOUTES LES INTERFACES NON UTILISÉES  ***  //

interface GigabitEthernet0/0/1
 shutdown
interface GigabitEthernet0/0/2
 shutdown
interface GigabitEthernet0/0/3
 shutdown
interface GigabitEthernet0/0/4
 shutdown
interface GigabitEthernet0/0/5
 shutdown
interface GigabitEthernet0/0/6
 shutdown
interface GigabitEthernet0/0/7
 shutdown

 //  *** ROUTES STATIQUES RED  ***  //

ip route-static 100.80.0.0 255.255.0.0 '.$cgn_pe.'
ip route-static 100.81.0.0 255.255.0.0 '.$cgn_pe.'


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
 rule 60 permit udp destination '.$cgn_pe.' '.$cgn_wilcard.' destination-port eq 3784

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

ip ip-prefix PFIX_DEFAULT_ROUTE index 10 permit 0.0.0.0 0';

if($_POST['dhcp_client_1']  == 'PA'){
echo '

ip ip-prefix PA_CUSTOMER index 10 permit '.$block_PA[1].' '.$cidr_pa;

}else{
echo '

ip ip-prefix PA_CUSTOMER index 10 permit '.$_POST['wan_client'].' 32';
}
echo '
//  ***  ROUTE POLICY: POUR LES ROUTES ENVOYÉES DU CPE VERS LE PE  ***  //

route-policy EXPORT_TO_PE permit node 10
 if-match ip-prefix PA_CUSTOMER
 apply cost 0

route-policy EXPORT_TO_PE deny node 100


//  ***  ROUTE POLICY: POUR LA ROUTE PAR DEFAUT ENVOYÉE DU PE VERS LE CPE  ***  //

route-policy IMPORT_FROM_PE permit node 10
 if-match ip-prefix PFIX_DEFAULT_ROUTE


 // *** Activation BFD ***  // 
bfd


// *** CONFIGURATION BGP ***  //

bgp 65000
 router-id '.$lo25.'
 peer '.$cgn_pe.' as-number 39405
 peer '.$cgn_pe.' description '.$pe.'
 peer '.$cgn_pe.' bfd enable
 peer '.$cgn_pe.' bfd min-rx-interval 1000 min-tx-interval 1000 detect-multiplier 3
 
 ipv4-family unicast
  default-route imported
  import-route direct
  peer '.$cgn_pe.' enable
  peer '.$cgn_pe.' next-hop-local
  peer '.$cgn_pe.' route-policy IMPORT_FROM_PE import
  peer '.$cgn_pe.' route-policy EXPORT_TO_PE export


//  *** SAUVEGARDER LA CONFIGURATION, TOUT MOMENT FAIRE SAVE POUR SAUVEGARDER  ***  //

save    // Répondre Y à la question posée
quit
';
}
echo'
</textarea>
</td>
<td>
';
#### SUP

if($w['support'] == "24/7" || $w['vip'] == "1"){
    
    echo "
        <h3>Supervison</h3>
        FSHMON02 : <br/>
        sudo vim /etc/shinken/objects/hosts/fsn.cfg<br/><br/>
    define host{<br/>
        \thost_name ".$hostname."<br/>
        \tuse Network-FSN,SLA-24x7,Production_Reseau<br/>
        \talias ".$hostname."<br/>
        \taddress ".$lo25."<br/>
        \thostgroups Clients-FAI<br/>
        \trealm BLM01<br/>
}<br/><br/>";

}

#### Circuit






                      
### conf PE

 
echo '<textarea rows="25" cols="100">  
!Definition des interfaces:
set groups FS-INET interfaces '.$port_mx.' unit '.$w['vlan'].' description "'.$fsn.' - '.$name.'"
set groups FS-INET interfaces '.$port_mx.' unit '.$w['vlan'].' vlan-id '.$w['vlan'].'
set groups FS-INET interfaces '.$port_mx.' unit '.$w['vlan'].' family inet address '.$cgn_pe.'/29

!!!!!
! Rattachement de l\'interface à la VRF FS-INET
set groups FS-INET routing-instances FS-INET interface '.$port_mx.'.'.$w['vlan'].'

!!!!!
!Route statique pour l\'administration du/des CPE (les 2 lignes sont a recopier à chaque CPE) : 
set groups FS-INET routing-instances FS-INET routing-options static route '.$lo25.'/32 next-hop '.$cgn_cpe.'
set groups FS-INET routing-instances FS-INET routing-options static route '.$lo25.'/32 tag 5025


!!! Routage dynamique PA
set groups FS-INET routing-instances FS-INET protocols bgp group SINGLE_HOMED_CGN neighbor '.$cgn_cpe.' description "'.$fsn.' - '.$name.'"
set groups FS-INET routing-instances FS-INET protocols bgp group SINGLE_HOMED_CGN neighbor '.$cgn_cpe.' import IMPORT_ROUTES_FROM_CPE
set groups FS-INET routing-instances FS-INET protocols bgp group SINGLE_HOMED_CGN neighbor '.$cgn_cpe.' export EXPORT_DEFAULT_ROUTE_TO_CPE
set groups FS-INET routing-instances FS-INET protocols bgp group SINGLE_HOMED_CGN neighbor '.$cgn_cpe.' remove-private
set groups FS-INET routing-instances FS-INET protocols bgp group SINGLE_HOMED_CGN neighbor '.$cgn_cpe.' bfd-liveness-detection minimum-interval 1000


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

!!!! 
! Configuration de l\'interface IPV6
set groups FS-INET interfaces '.$port_mx.' unit '.$w['vlan'].' family inet6 address '.$wan_v6_pe.'/127
set groups FS-INET routing-instances FS-INET forwarding-options dhcp-relay dhcpv6 group IPv6_CLIENTS interface '.$port_mx.'.'.$w['vlan'].'
set class-of-service interfaces '.$port_mx.' unit '.$w['vlan'].' classifiers dscp-ipv6 CLASSIFIER_DSCP_IPV6_IN_FAI
!
commit check
commit and-quit

! Configuration IPV6 sur le 7K

lbg01-2-7k: 

ipv6 dhcp pool pool-lbg01-2-7k
prefix-delegation '.$_POST['prefix_v6'].' '.$_POST['duid'].' lifetime infinite infinite
</textarea>';
  echo '</td>
  </tr>
  <tr>
<td>
<textarea rows="25" cols="100"> 

Nom page Wiki   : '.$wiki.'

=== Introduction ===

Le but de cette page est de réunir l\'ensemble des informations du réseau du clients nécessaire au déploiement, maintien opérationnel & support de la solution de l\'infrastructure du client : '.$name.'


== Offre ==

le client '.$name.' à souscrit à une offre :  Internet Access
';

if($debit <= 100){
echo '

Débit : '.$debit.'Mb/s';
}
elseif($debit < 1000 && $debit > 100){
echo '

Débit : '.$debit.'Mb/s';
}elseif($debit >= 1000) {
$debit_modif = substr($debit, 0, -3);
echo '

Débit : '.$debit_modif.'Gb/s';
}

echo '

GTR : '.$w['support'].'

== Contacts ==

Client : '.$contact_name.' : '.$contact_mail.'  - '.$contact_tel.'
<br>

== Information technique ==

=== Routeur : ===
{| class="wikitable"
!Nom
!Modèle
|-
|'.$hostname.'
|'.$type_cpe_nom.'
|}

=== IP routeur : ===
{| class="wikitable"
!Interface
!IP
|-
|'.$wan_interface.'
|'.$_POST['cgn_client'].'
|-
|'.$wan_interface.'
|'.$_POST['wan_v6'].'
|-
|Loopback25
|'.$lo25.'
|-
|Loopback50
|'.$_POST['wan_client'].'
|-
|'.$vlan.'
|'.$_POST['lan_client_1'].'
|}

===Matrice de flux :===
{| class="wikitable"
!Protocole
!Port WAN
!IP local
!Port LAN
|-
|
|
|
|
|}

=== Route Statique : ===
{| class="wikitable"
!Subnet
!IP Destination
|-
|
|
|}

== Ticket d\'incident ==
{| class="wikitable"
!Numéro de ticket
!Début incident
!Fin incident
|-
|
|
|
|}
 <noinclude>{{Cartouche|[https://wiki-next.fullsave.org/R%C3%A9seau_-_FAI Réseau FAI]}}</noinclude>
</textarea>
  </td>
                </tr></table></center>';           
             
        }       


require('../includes/foot.php');
?>
