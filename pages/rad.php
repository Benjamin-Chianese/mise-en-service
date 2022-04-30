<?php
require ('../includes/head.php');

  echo  '<center><div class="mx-auto" style="width: 600px;">
	     <h3> Création configuration RAD </h3>
	    <form method="post" action="rad.php">
	    FSLNK : <br/>
	    <input  type="text"  class="form-control" name="fslnk"  required value="'.$_POST['fslnk'].'"/><br/><br/>
	    <table border="1">
	        <tr>
	            <td>Vlan</td>
	            <td>Débit (Mb/s)</td>
	       </tr>
	        <tr>
	            <td><input  type="text" class="form-control"name="vlan_client_1" required value="'.$_POST['vlan_client_1'].'"/></td>
	            <td><input  type="text" class="form-control"name="m_client_1" required value="'.$_POST['m_client_1'].'"/></td>
	        </tr>
	        <tr>
	            <td><input  type="text" class="form-control"name="vlan_client_2"  value="'.$_POST['vlan_client_2'].'"/></td>
	            <td><input  type="text" class="form-control"name="m_client_2"  value="'.$_POST['m_client_2'].'"/></td>
	        </tr>
	         <tr>
	            <td><input  type="text" class="form-control"name="vlan_client_3"  value="'.$_POST['vlan_client_3'].'"/></td>
	            <td><input  type="text" class="form-control"name="m_client_3"  value="'.$_POST['m_client_3'].'"/></td>
	        </tr>
	         <tr>
	            <td><input  type="text" class="form-control"name="vlan_client_4"  value="'.$_POST['vlan_client_4'].'"/></td>
	            <td><input  type="text" class="form-control"name="m_client_4"  value="'.$_POST['m_client_4'].'"/></td>
	        </tr>
	       
            </table>
	    IP Admin : (BDI10 - ASR de collecte)<br/>
	    <input  type="text"  class="form-control" name="admin" required value="'.$_POST['admin'].'"/><br/><br/>

	    
	  <button type="submit"  name="rad_generation" value="generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';
	    
	    
	    
	    
	     if (!empty($_POST['fslnk']) && !empty($_POST['vlan_client_1']) && !empty($_POST['m_client_1']) && !empty($_POST['admin'])){


	        echo '<center>----------------------------</center><br/><br/>';  

	        $fslnk = $_POST['fslnk'];

	         $req_ID = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk%' ");
             $w = $req_ID->fetch(PDO::FETCH_ASSOC);
             
             $fsn = $w['service_ref'];
             $fsnE = substr($fsn, -5);

            
	        $debit_1 = $_POST['m_client_1'];
	        $debit_2 = $_POST['m_client_2'];
	        $debit_3 = $_POST['m_client_3'];
	        $debit_4 = $_POST['m_client_4'];
	        
	        $vlan_1 = $_POST['vlan_client_1'];
	        $vlan_2 = $_POST['vlan_client_2'];
	        $vlan_3 = $_POST['vlan_client_3'];
	        $vlan_4 = $_POST['vlan_client_4'];
	        
	        $ip_format = explode('.',$_POST['admin']);
            
            $ip_1 = $ip_format[0];
            $ip_2 = $ip_format[1];
            $ip_3 = $ip_format[2];
            $ip_4 = $ip_format[3];
 

            $admin = $ip_1.'.'.$ip_2.'.'.$ip_3.'.'.$ip_4;
            $admin_gateway = $ip_1.'.'.$ip_2.'.'.$ip_3.'.1';

	            
	        $hostname = 'fsn' . $fsnE;
	        $adresse = $w['adresse'].' '.$w['cp'].' '.$w['localite'];


            

            
  echo '<center><div class="mx-auto" style="width: 800px;"><table border="1">
                <tr>
                    <td>Conf RAD: </td>
                </tr>
	             <tr>
                    <td>        
            
<br/>
config router 1<br/><br/>


interface 32<br/>
shut<br/>
exit<br/>
exit<br/>

<br/><br/>

flows<br/><br/>

flow "mng_access_default_in"<br/>
shut<br/>
exit<br/>
flow "mng_access_default_out"<br/>
shut<br/>
exit<br/>
exit<br/>

<br/><br/>

port svi 1<br/>
no shut<br/>
exit<br/>
exit<br/>

<br/><br/>

bridge 1<br/>
port 1 <br/>
exit<br/>
port 2  <br/>
exit<br/>
port 3 <br/>
exit<br/>
port 4 <br/>
exit<br/>
port 5 <br/>
exit<br/>
port 6  <br/>
exit<br/>
port 7 <br/>
exit<br/>

<br/><br/>

vlan 10<br/>
exit<br/>

<br/><br/>

vlan '.$vlan_1.'<br/>
exit<br/>';

if (!empty($vlan_2)){
echo 'vlan '.$vlan_2.'<br/>
exit<br/>';}
if (!empty($vlan_3)){
echo 'vlan '.$vlan_3.'<br/>
exit<br/>';}
if (!empty($vlan_4)){
echo 'vlan '.$vlan_4.'<br/>
exit<br/>';}
echo '
exit<br/>

<br/><br/>

qos<br/>

shaper-profile "5M" <br/>
bandwidth cir 5000 cbs 32767 <br/>
compensation 4<br/>
exit<br/>

<br/><br/>

shaper-profile "'.$debit_1.'M" <br/>
bandwidth cir '.$debit_1.'000 cbs 32767 <br/>
compensation 4<br/>
exit  <br/>';

if (!empty($debit_2)){
echo '
shaper-profile "'.$debit_2.'M" <br/>
bandwidth cir '.$debit_2.'000 cbs 32767 <br/>
compensation 4<br/>
exit  <br/>';}

if (!empty($debit_3)){
echo '
shaper-profile "'.$debit_3.'M" <br/>
bandwidth cir '.$debit_3.'000 cbs 32767 <br/>
compensation 4<br/>
exit <br/> ';}

if (!empty($debit_4)){
echo '
shaper-profile "'.$debit_4.'M" <br/>
bandwidth cir '.$debit_4.'000 cbs 32767 <br/>
compensation 4<br/>
exit<br/>  ';
}

echo '
<br/><br/>


queue-group-profile "UPLINK"<br/>
queue-block 0/1<br/>
shaper profile "5M"<br/>
exit<br/><br/>

queue-block 0/2<br/>
shaper profile "'.$debit_1.'M"<br/>
exit<br/>';

if (!empty($debit_2)){
echo 'queue-block 0/3<br/>
shaper profile "'.$debit_2.'M"<br/>
exit<br/>';}

if (!empty($debit_3)){
echo 'queue-block 0/4<br/>
shaper profile "'.$debit_3.'M"<br/>
exit<br/>';}

if (!empty($debit_4)){
echo 'queue-block 0/5<br/>
shaper profile "'.$debit_4.'M"<br/>
exit<br/>';}

echo '
exit<br/>
exit<br/>
<br/><br/>

port<br/>
l2cp-profile L2CP_OPTION_2 <br/>
    mac "01-80-c2-00-00-01" discard <br/>
    protocol lacp tunnel <br/>
    protocol stp tunnel <br/>
    protocol lldp tunnel <br/>
    protocol cdp tunnel<br/>
    protocol pvstp tunnel <br/>
    protocol pagp tunnel <br/>
    protocol udld tunnel <br/>
    protocol link-oam tunnel <br/>
    protocol e-lmi tunnel <br/>
    protocol 802.1x tunnel <br/>
    exit<br/>
ethernet 1 <br/>
egress-mtu 9216 <br/>
queue-group profile "UPLINK"<br/>
no shut<br/>
exit<br/>
ethernet 2 <br/>
egress-mtu 9216 <br/>
exit<br/>
ethernet 3 <br/>
egress-mtu 9216 <br/>
l2cp profile L2CP_OPTION_2<br/>
exit<br/>
ethernet 4 <br/>
egress-mtu 9216 <br/>
l2cp profile L2CP_OPTION_2<br/>
exit<br/>
ethernet 5 <br/>
egress-mtu 9216 <br/>
l2cp profile L2CP_OPTION_2<br/>
exit<br/>
ethernet 6 <br/>
egress-mtu 9216 <br/>
l2cp profile L2CP_OPTION_2<br/>
exit<br/>
exit<br/>

<br/><br/>

flows<br/>
classifier-profile "ALL" match-any <br/>
match all <br/>
exit<br/><br/>

classifier-profile "UNTAGGED" match-any <br/>
match untagged<br/>
exit<br/><br/>


<br/><br/>

classifier-profile "VLAN'.$vlan_1.'" match-any <br/>
match vlan '.$vlan_1.'<br/>
exit<br/>';

if (!empty($vlan_2)){
echo 'classifier-profile "VLAN'.$vlan_2.'" match-any <br/>
match vlan '.$vlan_2.'<br/>
exit<br/>';
}

if (!empty($vlan_3)){
echo 'classifier-profile "VLAN'.$vlan_3.'" match-any <br/>
match vlan '.$vlan_3.'<br/>
exit<br/>';
}

if (!empty($vlan_4)){
echo 'classifier-profile "VLAN'.$vlan_4.'" match-any <br/>
match vlan '.$vlan_4.'<br/>
exit<br/>';
}

echo '
<br/>

classifier-profile "VLAN10" match-any <br/>
match vlan 10<br/>
exit<br/>
<br/><br/>

flow "VLAN10-IN" <br/>
classifier "VLAN10" <br/>
no policer <br/>
ingress-port ethernet 1 <br/>
egress-port bridge-port 1 1 <br/>
reverse-direction block 0/1 <br/>
no shutdown<br/>
exit <br/>
<br/><br/>
flow "VLAN10-OUT" <br/>
classifier "UNTAGGED" <br/>
no policer <br/>
vlan-tag push vlan 10 p-bit fixed 7 <br/>
ingress-port svi 1 <br/>
egress-port bridge-port 1 7 <br/>
reverse-direction <br/>
no shutdown<br/>
exit <br/>

<br/><br/>



flow "VLAN'.$vlan_1.'-IN-E1" <br/>
classifier VLAN'.$vlan_1.' <br/>
no policer <br/>
ingress-port ethernet 1 <br/>
egress-port bridge-port 1 1 <br/>
reverse-direction block 0/2 <br/>
no shutdown <br/>
exit<br/>

<br/><br/>


flow "VLAN'.$vlan_1.'-OUT-E3" <br/>
classifier "ALL" <br/>
no policer <br/>
vlan-tag push vlan '.$vlan_1.' p-bit copy <br/>
ingress-port ethernet 3 <br/>
egress-port bridge-port 1 3<br/>
reverse-direction block 0/1 <br/>
no shutdown <br/>
exit<br/>';


if (!empty($vlan_2)){
echo 'flow "VLAN'.$vlan_2.'-IN-E1" <br/>
classifier VLAN'.$vlan_2.' <br/>
no policer <br/>
ingress-port ethernet 1 <br/>
egress-port bridge-port 1 1 <br/>
reverse-direction block 0/3 <br/>
no shutdown <br/>
exit<br/>

<br/><br/>


flow "VLAN'.$vlan_2.'-OUT-E4" <br/>
classifier "ALL" <br/>
no policer <br/>
vlan-tag push vlan '.$vlan_2.' p-bit copy <br/>
ingress-port ethernet 4 <br/>
egress-port bridge-port 1 4<br/>
reverse-direction block 0/1 <br/>
no shutdown <br/>
exit<br/>';
}

if (!empty($vlan_3)){
echo 'flow "VLAN'.$vlan_3.'-IN-E1" <br/>
classifier VLAN'.$vlan_3.' <br/>
no policer <br/>
ingress-port ethernet 1 <br/>
egress-port bridge-port 1 1 <br/>
reverse-direction block 0/4 <br/>
no shutdown <br/>
exit<br/>

<br/><br/>


flow "VLAN'.$vlan_3.'-OUT-E5" <br/>
classifier "ALL" <br/>
no policer <br/>
vlan-tag push vlan '.$vlan_3.' p-bit copy <br/>
ingress-port ethernet 5 <br/>
egress-port bridge-port 1 5<br/>
reverse-direction block 0/1 <br/>
no shutdown <br/>
exit<br/>';
}

if (!empty($vlan_4)){
echo 'flow "VLAN'.$vlan_4.'-IN-E1" <br/>
classifier VLAN'.$vlan_4.' <br/>
no policer <br/>
ingress-port ethernet 1 <br/>
egress-port bridge-port 1 1 <br/>
reverse-direction block 0/5 <br/>
no shutdown <br/>
exit<br/>

<br/><br/>


flow "VLAN'.$vlan_4.'-OUT-E6" <br/>
classifier "ALL" <br/>
no policer <br/>
vlan-tag push vlan '.$vlan_4.' p-bit copy <br/>
ingress-port ethernet 6 <br/>
egress-port bridge-port 1 6<br/>
reverse-direction block 0/1 <br/>
no shutdown <br/>
exit<br/>';
}

echo '
exit<br/>
<br/><br/> 

router 1 <br/>
interface 1 <br/>
address '.$admin.'/24 <br/>
bind svi 1 <br/>
no shutdown <br/>
exit<br/>
static-route 0.0.0.0/0 address '.$admin_gateway.'<br/>
exit<br/>

<br/><br/>

management snmp <br/>
community "read" <br/>
name "fscommunity" <br/>
sec-name "v2_read" <br/>
no shutdown <br/>
exit<br/>
community "trap" <br/>
name "fscommunity" <br/>
sec-name "v2_trap" <br/>
no shutdown <br/>
exit<br/>
community "write" <br/>
name "fscommunity" <br/>
sec-name "v2_write" <br/>
no shutdown <br/>
exit<br/>
target-params "tp" <br/>
message-processing-model snmpv2c <br/>
version snmpv2c <br/>
security name "v2_trap" level no-auth-no-priv<br/> 
no shutdown <br/>
exit<br/>

<br/><br/>

target "SNMP-HOST-1" <br/>
target-params "tp" <br/>
address udp-ipv4-domain 100.80.15.1 <br/>
no shutdown <br/>
tag-list "unmasked" <br/>
exit<br/>

target "SNMP-HOST-2" <br/>
target-params "tp" <br/>
address udp-ipv4-domain 100.80.15.129<br/>
no shutdown <br/>
tag-list "unmasked" <br/>
exit<br/>

target "SNMP-HOST-3" <br/>
target-params "tp"<br/> 
address udp-ipv4-domain 100.80.0.193<br/>
no shutdown <br/>
tag-list "unmasked" <br/>
exit<br/>

target "SNMP-HOST-4" <br/>
target-params "tp" <br/>
address udp-ipv4-domain 100.80.15.12<br/>
no shutdown <br/>
tag-list "unmasked" <br/>
exit<br/>
target "SNMP-HOST-5" <br/>
    target-params "tp" <br/>
    address udp-ipv4-domain 100.80.0.225 <br/>
    no shutdown <br/>
    tag-list "unmasked"<br/>
exit<br/>
exit<br/>
exit<br/>

<br/><br/>

system <br/>
name '.$hostname.'<br/>
location "'.$adresse.'"<br/>
contact "FullSave au 05.62.24.34.18 ou support@fullsave.com"<br/>
date-and-time<br/>
date-format dd-mm-yyyy<br/>
zone utc +01:00<br/>
summer-time recurring last sunday march 02:00 last sunday october 03:00<br/>
date '.date('d-m-Y').'<br/>
sntp<br/>
server 1<br/>
address 100.80.15.4  <br/>
prefer <br/>
no shutdown<br/>
exit<br/>
server 2<br/>
address 100.80.15.132 <br/>
no shutdown<br/>
exit<br/>
exit<br/>
exit<br/>';
echo "
login-message 
'\r\n========================================================================\r\nCaution : this is a private equipment of the FullSave company.\r\nAny unauthorized access will be prosecuted.\r\n \r\nAttention : ceci est un equipement prive propriet de FullSave.\r\nToute utilisation frauduleuse fera l\'objet de poursuites.\r\n\r\nMerci de contacter FullSave au 05.62.24.34.18 en cas de probleme d\'acces.\r\n=========================================================================\r\n'<br/>
exit<br/>";


echo'
<br/><br/>

management access <br/>
auth-policy 1st-level tacacs+ 2nd-level local<br/>
exit<br/>
tacacsplus <br/>
group "TACACSPLUS" <br/>
accounting shell system commands <br/>
exit<br/>
server 100.80.15.5 <br/>
key KQAK273KQJ2ykrxB<br/>
timeout 15 <br/>
group "TACACSPLUS" <br/>
no shutdown <br/>
exit<br/>
server 100.80.15.133 <br/>
key KQAK273KQJ2ykrxB<br/>
timeout 15 <br/>
group "TACACSPLUS" <br/>
no shutdown <br/>
exit<br/>
exit<br/>

<br/><br/>

login-user "fsadmin" <br/>
level su <br/>
password Dk#fR34-2-Dfpw <br/>
exit<br/>

<br/><br/>

login-user "su" <br/>
password Xqf96bxKSluy <br/>
exit<br/>
exit<br/>

<br/><br/>

port<br/>
ethernet 2 <br/>
shut<br/>
exit<br/><br/>';


if (empty($vlan_2)){
echo 'ethernet 4 <br/>
shut<br/>
exit<br/><br/>';}

if (empty($vlan_3)){
echo 'ethernet 5 <br/>
shut<br/>
exit<br/><br/>';}

if (empty($vlan_4)){
echo 'ethernet 6 <br/>
shut<br/>
exit<br/><br/>';}


echo '
ethernet 101 <br/>
shutdown <br/>
exit<br/><br/>

exit<br/><br/>

save<br/>

 
</td>
  
	            </tr></table> </div></center>';           
	        
	        
 
	    }


require('../includes/foot.php');
?>
