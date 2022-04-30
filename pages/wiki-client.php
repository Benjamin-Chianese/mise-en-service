<?php
require ('../includes/head.php');
require ('../vendor/autoload.php');

  echo  '<center><div class="mx-auto" style="width: 600px;">
	     <h3> Création Fiche Wiki-client IA</h3>
	    <form method="post" action="wiki-client.php">
	    FSLNK : <br/>
	    <input  type="text"  class="form-control" name="fslnk"  required value="'.$_POST['fslnk'].'"/><br/><br/>
	    <table border="1">
	        <tr>
	            <td>Vlan</td>
	            <td>Passerelle client / PA (192.168.1.254/24)</td>
	       </tr>
	        <tr>
	            <td><input  type="text" class="form-control"name="vlan_client_1"  value="'.$_POST['vlan_client_1'].'"/></td>
	            <td><input  type="text" class="form-control"name="lan_client_1"  value="'.$_POST['lan_client_1'].'"/></td>
	        </tr>	       
            </table>
                         CPE : <br/>
         <select name="type_cpe"  class="form-control">';
                if(empty($_POST['type_cpe'])){
                    
                        echo'   <option value="Cisco 892">Cisco 892</option>
                                <option value="Cisco 881">Cisco 881</option>
                                <option value="Juniper SRX 320">Juniper SRX 320</option>
                                <option value="Huawei AR651">Huawei AR651</option>
                                <option value="ME3400">ME3400</option>
                                <option value="RAD EXT 203">RAD EXT 203</option>
                                <option value="RAD EXT 205">RAD EXT 205</option>
                                <option value="RAD ETX 2I-10G">RAD EXT 2I-10G</option>
                                
                                ';
                }else{
	                  echo'          <option value="'.$_POST['type_cpe'].'">'.$_POST['type_cpe'].'</option>
                               
                                <option value="Cisco 892">Cisco 892</option>
                                <option value="Cisco 881">Cisco 881</option>
                                <option value="Juniper SRX 320">Juniper SRX 320</option>
                                <option value="Huawei AR651">Huawei AR651</option>
                                <option value="ME3400">ME3400</option>
                                <option value="RAD EXT 203">RAD EXT 203</option>
                                <option value="RAD EXT 205">RAD EXT 205</option>
                                <option value="RAD ETX 2I-10G">RAD EXT 2I-10G</option>';}
                                echo'
                        </select><br/><br/>

	    WAN POOL : (141.0.202.202/31)<br/>
	    <input  type="text"  class="form-control" name="wan_client" value="'.$_POST['wan_client'].'"/><br/><br/>
	     WAN V6 POOL : (2a01:6600:50c0:8500::46/127)<br/>
	    <input  type="text"  class="form-control" name="wan_v6" value="'.$_POST['wan_v6'].'"/><br/><br/>
        Loopback : (<a href="https://racktables.fullsave.org/index.php?page=ipv4net&tab=default&id=5351" target="_blank">100.81.32.0</a>)<br/>
	    <input  type="text"  class="form-control" name="lo25" required value="'.$_POST['lo25'].'"/><br/><br/>
	    
	  <button type="submit"  name="conf_cpe_generation" value="generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';
	    
	    
	    
	    
	     if (!empty($_POST['fslnk']) && !empty($_POST['lo25']) && !empty($_POST['conf_cpe_generation'])){

	        
	        echo '<center>----------------------------</center><br/><br/>';  

            $fslnk = $_POST['fslnk'];
            $lo25 = $_POST['lo25'];
            $type_cpe = $_POST["type_cpe"]; 
	
               $req_ID = $bdd->query("SELECT * FROM network_account WHERE  service_ref LIKE '%$fslnk%' ");
               $w = $req_ID->fetch(PDO::FETCH_ASSOC);


            
            $fsn = $w['service_ref'];
            $debit = substr($w['bandwidth'], 0, -3);
            $fsc_brut = $w['customer_id'];  
            $operateur = $w['supplier'];
            $name = $w['name'];
            $contact_name = $w['contact_name'];
            $contact_tel = $w['contact_tel'];
            $contact_mail = $w['contact_mail'];
            $adresse = $w['adresse'].' '.$w['cp'].' '.$w['localite'];
            $eqts = $w['eqts'];
            $service_type = $w['service_type'];


                $fsnE = substr($fsn, -5);

                

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


                $wiki = $fsc.'/'.$eqts;

                    
        

              $charset='utf-8';
              $name = htmlentities( $name, ENT_NOQUOTES, $charset );
              $name = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $name );
              $name = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $name );
              $name = preg_replace( '#&[^;]+;#', '', $name );


		     switch ($type_cpe) {
                    case 'Cisco 892':
                        $wan_interface = 'Gi8';
                        $vlan = 'Vlan'.$_POST['vlan_client_1'];
                    break;
                    case 'Cisco 881':
                        $wan_interface = 'Fa4';
                        $vlan = 'Vlan'.$_POST['vlan_client_1'];
                    break;
                    case 'Huawei AR651':
                        $wan_interface = 'Gi0/0/8';
                        $vlan = 'Vlan'.$_POST['vlan_client_1'];
                    break;
                    case 'Juniper SRX 320':
                        if($operateur == 'Natira'){
                            $wan_interface = 'ge-0/0/7';
                        }else{
                            $wan_interface = 'ge-0/0/0';
                        }
                        $vlan = 'Irb0';
                    break;    
                }
            

            
  echo '<center><table border="1">
                <tr>
                    <td>'.$wiki.'</td>
                  
                </tr>
	             

  <tr>
<td>
<textarea rows="25" cols="100"> 
=== Introduction ===

Le but de cette page est de réunir l\'ensemble des informations du réseau du clients nécessaire au déploiement, maintien opérationnel & support de la solution de l\'infrastructure du client : '.$name.'


== Offre ==

le client '.$name.' à souscrit à une offre : '.$service_type.'
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
|'.$eqts.'
|'.$type_cpe.'
|}

=== IP routeur : ===
{| class="wikitable"
!Interface
!IP';
if(!empty($_POST['wan_client'])){
echo'
|-
|'.$wan_interface.'
|'.$_POST['wan_client'];
}
if(!empty($_POST['wan_v6'])){
echo'
|-
|'.$wan_interface.'
|'.$_POST['wan_v6'];
}
echo'
|-
|Loopback
|'.$lo25;
if(!empty($vlan)){
echo'
|-
|'.$vlan.'
|'.$_POST['lan_client_1'];
}
echo'
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
