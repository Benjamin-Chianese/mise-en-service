<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


<?php 
require('SQL.php');
require('conf.php'); 
require('fonction.php');  

#echo $db_host.' | '.$db_name.' | '.$db_user.' | '.$db_mdp.' | '.$_SERVER['SERVER_ADDR'].'<br/>';

date_default_timezone_set('Europe/Paris');
$url =  $_SERVER['REQUEST_URI'];  
        
    $url_explode = explode('/', $url);
    $page_explode = explode('.', $url_explode[2]);
    $page = $page_explode[0];
    //echo $page;
    $date = date('Y-m-d H:i:s');


$user = $_SERVER['HTTP_X_REMOTE_USER'];




## group network

if (hasPermission("network")  || hasPermission("adv") || hasPermission("devops") || hasPermission("fibre")) {
    


?>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../index.php">Index</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
         <li class="nav-item dropdown">
        
<?php 


$port_reserve = $bdd->query("SELECT count(*) AS port from `network_vision` WHERE  etat = 'Port à reserver'");
                 $checks_reserve = $port_reserve->fetch();
      if($checks_reserve['port'] > 0){
        echo '  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#E50000">
                 Mise en service
                 </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/mes.php">FAI Prévision</a>
        <a class="dropdown-item" href="../pages/mes_d.php">FAI à faire</a>
         <div class="dropdown-divider"></div>
        <a class="dropdown-item" style="color:#E50000" href="../pages/port.php">Reservation Port</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/orange.php">Orange API</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/prod.php">Prod</a>
        <a class="dropdown-item" href="../pages/cpe.php">CPE</a>
        <a class="dropdown-item" href="../pages/legende.php">Légende</a>
        </div>';
}else{
   echo ' <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Mise en service
                 </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/mes.php">FAI Prévision</a>
        <a class="dropdown-item" href="../pages/mes_d.php">FAI à faire</a>
         <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/port.php">Reservation Port</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/orange.php">Orange API</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/prod.php">Prod</a>
        <a class="dropdown-item" href="../pages/cpe.php">CPE</a>
        <a class="dropdown-item" href="../pages/legende.php">Légende</a>
        </div>';
}

?>
         
        
      </li>
      
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Fiche Si_plugins
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/creation.php">Création</a>
        <a class="dropdown-item" href="../pages/upgrade.php">Upgrade</a>
        <a class="dropdown-item" href="../pages/copie.php">Copie</a>
        <a class="dropdown-item" href="../pages/pepiniere.php">Pépinière</a>
            <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/modif.php">Modifier</a>
        </div>
      </li>
      <?php  if($page == 'odroid') {echo '<li class="nav-item active">';}else{echo '<li class="nav-item">';} ?>
       <a class="nav-link" href="../pages/odroid.php">Odroid<span class="sr-only">(current)</span></a>
      </li> 
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Templates
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/mail.php">Mail</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/conf_cpe.php">Conf IA</a>
        <a class="dropdown-item" href="../pages/mpls.php">Conf MPLS</a>
        <a class="dropdown-item" href="../pages/rad.php">Conf RAD</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/pa.php">PA</a>
        <a class="dropdown-item" href="../pages/pat.php">PAT</a>
        <a class="dropdown-item" href="../pages/rotary.php">Rotary</a>
        <a class="dropdown-item" href="../pages/sla.php">SLA</a>
        <a class="dropdown-item" href="../pages/dhcp.php">DHCP</a>
        <a class="dropdown-item" href="../pages/capture.php">Capture</a>
        <a class="dropdown-item" href="../pages/vlan.php">Vlan Guest</a>
        <a class="dropdown-item" href="../pages/ipsec.php">IPSEC</a>
        <a class="dropdown-item" href="../pages/vrrp.php">VRRP</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Outils
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/mdp.php">MDP</a>
        <a class="dropdown-item" href="../pages/user_vpn.php">Users VPN</a>
        <a class="dropdown-item" href="../pages/wiki-client.php">Wiki-client</a>
        <a class="dropdown-item" href="../pages/downtime.php">Downtime</a>
        </div>
      </li>

     
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Prévenance
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/prevenances.php">Réseau</a>
        <a class="dropdown-item" href="../pages/voip.php">VOIP</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/maintenance.php">Maintenance</a>
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Résiliation
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/resil.php">Résiliation</a>
            <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/adv.php">ADV</a>
        </div>
      </li>
      
       <?php $maint = $bdd->query("SELECT count(*) AS maint from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
                 $checks_count = $maint->fetch();
      if($checks_count['maint'] > 0){
      
     echo ' <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Maintenance en cours
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            $maintenance = $bdd->query("SELECT * from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
            while ( $r = $maintenance->fetch(PDO::FETCH_ASSOC))    {
               echo'  <a class="dropdown-item" >'.$r['id'].' - '.$r['affected_services'].' - '.date('d/m/Y H:i:s',strtotime($r['end'])).'</a>';
            }
        
echo '   </div>
      </li>';
      }?>
      
      <?php  if($page == 'erreur') {echo '<li class="nav-item active">';}else{echo '<li class="nav-item">';} ?>
       <a class="nav-link" href="../pages/erreur.php">Erreur<span class="sr-only">(current)</span></a>
      </li> 

      <?php  if($page == 'ref') {echo '<li class="nav-item active">';}else{echo '<li class="nav-item">';} ?>
       <a class="nav-link" href="../pages/ref.php">Ref<span class="sr-only">(current)</span></a>
      </li> 
     <?php  if($page == 'manger') {echo '<li class="nav-item active">';}else{echo '<li class="nav-item">';} ?>
       <a class="nav-link" href="../pages/manger.php">Où Manger<span class="sr-only">(current)</span></a>
      </li> 
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="../pages/view.php">
      <input class="form-control mr-sm-2" type="search" name="head_rechercher" placeholder="Recherche" value="<?php echo $_POST['head_rechercher']; ?>" aria-label="Search">
         <select  class="form-control" id="sel1" name="head_select" >
             <?php 
                        switch ($_POST['head_select']){
                            case 'FSLNK':
                             echo '<option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'NAME':
                             echo '<option value="NAME">Nom client</option>
                                   <option value="FSLNK">FSLNK</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'COLLECTE':
                             echo '<option value="COLLECTE">Collecte</option>
                                   <option value="NAME">Nom client</option>
                                   <option value="FSLNK">FSLNK</option>
                                   <option value="PE">PE</option>
                                   <option value="REF">Réf OP</option>
                                   <option value="MAINT">Maintenance</option>
                                   <option value="PRESTA">Préstataire</option>
                    	           ';
                             break;
                            case 'PE':
                             echo '
                                    <option value="PE">PE</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                              case 'REF':
                             echo '
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                    	   break;
                    	   case 'MAINT':
                             echo '
                                    <option value="MAINT">Maintenance</option>
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'PRESTA':
                             echo '
                                    <option value="PRESTA">Préstataire</option>
                                    <option value="MAINT">Maintenance</option>
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>';
                             break;
                             default:
                                echo '<option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                       }

            ?>
    	</select> 

      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Chercher</button>
    </form>
  </div>
</nav>





<?php


## group autre

}elseif(hasPermission("fibre")){
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../index.php">Index</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Fiche Si_plugins
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/creation.php">Création</a>
        <a class="dropdown-item" href="../pages/upgrade.php">Upgrade</a>
        <a class="dropdown-item" href="../pages/copie.php">Copie</a>
        <a class="dropdown-item" href="../pages/pepiniere.php">Pépinière</a>
            <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/modif.php">Modifier</a>
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Prévenance
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/prevenances.php">Réseau</a>
        <a class="dropdown-item" href="../pages/voip.php">VOIP</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/maintenance.php">Maintenance</a>
        </div>
      </li>
      
       <?php $maint = $bdd->query("SELECT count(*) AS maint from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
                 $checks_count = $maint->fetch();
      if($checks_count['maint'] > 0){
      
     echo ' <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Maintenance en cours
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            $maintenance = $bdd->query("SELECT * from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
            while ( $r = $maintenance->fetch(PDO::FETCH_ASSOC))    {
               echo'  <a class="dropdown-item" >'.$r['id'].' - '.$r['affected_services'].' - '.date('d/m/Y H:i:s',strtotime($r['end'])).'</a>';
            }
        
echo '   </div>
      </li>';
      }?>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="../pages/view.php">
      <input class="form-control mr-sm-2" type="search" name="head_rechercher" placeholder="Recherche" value="<?php echo $_POST['head_rechercher']; ?>" aria-label="Search">
         <select  class="form-control" id="sel1" name="head_select" >
             <?php 
                        switch ($_POST['head_select']){
                            case 'FSLNK':
                             echo '<option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'NAME':
                             echo '<option value="NAME">Nom client</option>
                                   <option value="FSLNK">FSLNK</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'COLLECTE':
                             echo '<option value="COLLECTE">Collecte</option>
                                   <option value="NAME">Nom client</option>
                                   <option value="FSLNK">FSLNK</option>
                                   <option value="PE">PE</option>
                                   <option value="REF">Réf OP</option>
                                   <option value="MAINT">Maintenance</option>
                                   <option value="PRESTA">Préstataire</option>
                    	           ';
                             break;
                            case 'PE':
                             echo '
                                    <option value="PE">PE</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                              case 'REF':
                             echo '
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                    	   break;
                    	   case 'MAINT':
                             echo '
                                    <option value="MAINT">Maintenance</option>
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'PRESTA':
                             echo '
                                    <option value="PRESTA">Préstataire</option>
                                    <option value="MAINT">Maintenance</option>
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>';
                             break;
                             default:
                                echo '<option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                       }

            ?>
    	</select> 

      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Chercher</button>
    </form>
  </div>
</nav>





<?php

}
else {
?>    
    
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../index.php">Index</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <?php if($page == 'mes_com') {echo '<li class="nav-item active">';}else{echo '<li class="nav-item">';} ?>
        <a class="nav-link" href="../pages/mes_com.php">MES<span class="sr-only">(current)</span></a>
      </li>
    
      <?php if($page == 'maintenance') {echo '<li class="nav-item active">';}else{echo '<li class="nav-item">';} ?>
        <a class="nav-link" href="../pages/maintenance.php">Maintenance<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Outils
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../pages/mdp.php">MDP</a>
        <a class="dropdown-item" href="../pages/user_vpn.php">Users VPN</a>
        <a class="dropdown-item" href="../pages/wiki-client.php">Wiki-client</a>
        <a class="dropdown-item" href="../pages/downtime.php">Downtime</a>
        </div>
      </li>
      
       <?php $maint = $bdd->query("SELECT count(*) AS maint from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
                 $checks_count = $maint->fetch();
      if($checks_count['maint'] > 0){
      
     echo ' <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Maintenance en cours
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            $maintenance = $bdd->query("SELECT * from `maintenance` WHERE `begin` <= '".$date."' AND `end` >= '".$date."' AND `canceled` = 0");
            while ( $r = $maintenance->fetch(PDO::FETCH_ASSOC))    {
               echo'  <a class="dropdown-item" >'.$r['id'].' - '.$r['affected_services'].' - '.date('d/m/Y H:i:s',strtotime($r['end'])).'</a>';
            }
        
echo '   </div>
      </li>';
      }?>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="../pages/view.php">
      <input class="form-control mr-sm-2" type="search" name="head_rechercher" placeholder="Recherche" value="<?php echo $_POST['head_rechercher']; ?>" aria-label="Search">
         <select  class="form-control" id="sel1" name="head_select" >
             <?php 
                       switch ($_POST['head_select']){
                            case 'FSLNK':
                             echo '<option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'NAME':
                             echo '<option value="NAME">Nom client</option>
                                   <option value="FSLNK">FSLNK</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'COLLECTE':
                             echo '<option value="COLLECTE">Collecte</option>
                                   <option value="NAME">Nom client</option>
                                   <option value="FSLNK">FSLNK</option>
                                   <option value="PE">PE</option>
                                   <option value="REF">Réf OP</option>
                                   <option value="MAINT">Maintenance</option>
                                   <option value="PRESTA">Préstataire</option>
                    	           ';
                             break;
                            case 'PE':
                             echo '
                                    <option value="PE">PE</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                              case 'REF':
                             echo '
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                    	   break;
                    	   case 'MAINT':
                             echo '
                                    <option value="MAINT">Maintenance</option>
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="PRESTA">Préstataire</option>';
                             break;
                            case 'PRESTA':
                             echo '
                                    <option value="PRESTA">Préstataire</option>
                                    <option value="MAINT">Maintenance</option>
                                    <option value="REF">Réf OP</option>
                                    <option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>';
                             break;
                             default:
                                echo '<option value="FSLNK">FSLNK</option>
                    	           <option value="NAME">Nom client</option>
                    	           <option value="COLLECTE">Collecte</option>
                    	           <option value="PE">PE</option>
                    	           <option value="REF">Réf OP</option>
                    	           <option value="MAINT">Maintenance</option>
                    	           <option value="PRESTA">Préstataire</option>';
                       }

            ?>
    	</select> 

      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Chercher</button>
    </form>
  </div>
</nav>




<?php


}
switch ($page){
    case 'mes':
        echo '<title>Mise en service - MES</title>';
        break;
    case 'mes_d':
        echo '<title>Mise en service - MES Direct</title>';
        break;
    case 'port':
        echo '<title>Mise en service - Reservation Port</title>';
        break;
    case 'mail':
        echo '<title>Mise en service - Mail</title>';
        break;
    case 'prod':
        echo '<title>Mise en service - Prod</title>';
        break;
    case 'cpe':
        echo '<title>Mise en service - CPE</title>';
        break;
    case 'legende':
        echo '<title>Mise en service - Légende</title>';
        break;
    case 'pa':
        echo '<title>Mise en service - PA</title>';
        break;
    case 'sla':
        echo '<title>Mise en service - SLA</title>';
        break;
    case 'mpls':
        echo '<title>Mise en service - CPE MPLS</title>';
        break;
    case 'RAD':
        echo '<title>Mise en service - RAD</title>';
        break;
    case 'dhcp':
        echo '<title>Mise en service - DHCP</title>';
        break;
    case 'pat':
        echo '<title>Mise en service - PAT</title>';
        break;
    case 'rotary':
        echo '<title>Mise en service - Rotary</title>';
        break;
    case 'vlan':
        echo '<title>Mise en service - Vlan Guest</title>';
        break;
    case 'ipsec':
        echo '<title>Mise en service - IPSEC</title>';
        break;
    case 'vrrp':
        echo '<title>Mise en service - VRRP</title>';
        break;
    case 'capture':
        echo '<title>Mise en service - Capture</title>';
        break;
    case 'natira':
        echo '<title>Mise en service - Natira</title>';
        break;
    case 'prevenances':
        echo '<title>Mise en service - Réseau</title>';
        break;
    case 'maintenance':
        echo '<title>Mise en service - Maintenance</title>';
        break;
    case 'voip':
        echo '<title>Mise en service - VOIP</title>';
        break;
    case 'resil':
        echo '<title>Mise en service - Résiliation</title>';
        break;
    case 'adv':
        echo '<title>Mise en service - ADV</title>';
        break;
    case 'creation':
        echo '<title>Mise en service - Creation</title>';
        break;
    case 'upgrade':
        echo '<title>Mise en service - Upgrade</title>';
        break;
    case 'copie':
        echo '<title>Mise en service - Copie</title>';
        break;
    case 'pepiniere':
        echo '<title>Mise en service - Pepiniere</title>';
        break;
    case 'modif':
        echo '<title>Mise en service - Modifier</title>';
        break;
    case 'view':
        echo '<title>Mise en service - Recherche</title>';
        break;
    case 'odroid':
        echo '<title>Mise en service - Odroid</title>';
        break;
    case 'conf_cpe':
        echo '<title>Mise en service - CPE IA</title>';
        break;
    case 'mdp':
        echo '<title>Mise en service - MDP</title>';
        break;
    case 'user_vpn':
        echo '<title>Mise en service - Users VPN</title>';
        break;
    case 'downtime':
        echo '<title>Mise en service - Downtime</title>';
        break;
    default:
        echo '<title>Mise en service</title>';
}

?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>




<br/><br/><br/><br/>
