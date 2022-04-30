<?php
require ('../includes/head.php');


	$mes = $bdd->query("SELECT * FROM `network_account` WHERE (`resiliation` <= '2020-12-17' OR `resiliation` IS NULL) AND (`vip` = '1' OR `gtr` ='24/7') ");

echo"<textarea>";
while ($r = $mes->fetch(PDO::FETCH_ASSOC))
{
	$id = $r['id'];
	$fsn = $r['service_ref'];
    $fsnE = substr($fsn, -5);
	$hostname = 'fsn' . $fsnE;

$content = file_get_contents("https://si-plugins.fullsave.io/plugins/accesreseauv2/account.php?id=".$id);


preg_match_all('/\IP<\/label><span>(.*?)\</', $content , $ip);

echo "

define host{
    host_name ".$hostname."
    use Network-FSN,SLA-24x7,Production_Reseau
    alias ".$hostname."
    address ".$ip[1][0]."
    hostgroups Clients-FAI
    realm LBG01
}";

}
echo"</textarea>";
require('../includes/foot.php');
?>

