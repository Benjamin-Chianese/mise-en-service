<?php
require('../includes/head.php'); 
require ('../vendor/autoload.php');


use PhpIP\IPv4Block;
$block = new IPv4Block('100.0.0.0/8');



echo '<br/><br/>';

            $req_ID = $bdd->query("SELECT `id`,`eqts` FROM `network_account` 
            WHERE support = '24/7' 
            AND `resiliation` IS NULL 
            AND `eqts` LIKE 'fsn0%' 
            AND `service_type` AND `service_type` IN ('Pepiniere')
            LIMIT 60, 40");
echo "<textarea>";
            while ($w = $req_ID->fetch(PDO::FETCH_ASSOC)){
            
$id=$w['id'];
$eqts = $w['eqts'];
                

#Traitement eqts
$i =0;
 if(substr_count($eqts, ',') > $i){
    $explode_fsn = explode(',',$eqts);
        foreach ($explode_fsn as &$fsn) {
            $fsn = trim($fsn);
            $content = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$id);
                preg_match_all('/\IP<\/label><span>(.*?)\</', $content , $ip_admin);
$ip = $ip_admin[1][$i];

#Choix REALM
if($block->contains($ip)){
    $realm = "BLM01";
}else{
$realm = "LBG01";
}

echo "
define host{
    host_name ".$fsn."
    use Network-FSN,SLA-24x7,Production_Reseau
    alias ".$fsn."
    address ".$ip."
    hostgroups Clients-FAI
    realm ".$realm."
}
";
$i++;
        }
}else{
    $content = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$id);
        preg_match_all('/\IP<\/label><span>(.*?)\</', $content , $ip_admin);
$ip = $ip_admin[1][0];
                
#Choix REALM
if($block->contains($ip)){
    $realm = "BLM01";
}else{
$realm = "LBG01";
}

echo "
define host{
    host_name ".$eqts."
    use Network-FSN,SLA-24x7,Production_Reseau
    alias ".$eqts."
    address ".$ip."
    hostgroups Clients-FAI
    realm ".$realm."
}
";
}

}
echo "</textarea>";


            
 require('../includes/foot.php');
?>  
