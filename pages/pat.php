<?php
require('../includes/head.php'); 



$choix_port_1 = '<center><div class="mx-auto" style="width: 600px;">	
	     <h3> Ajout PAT</h3>
        <h4>Translation de port vers une IP local </h4>
	    <form method="post" action="pat.php">
	    Combien de port à ouvrir:<br/>
	    <input  type="numb"  class="form-control" name="nmb_port"  required/><br/><br/>
        CPE :<br/>
            <select name="cpe_port"  class="form-control">
                    <option value="Huawei">Huawei</option>
                    <option value="Huawei-CGN">Huawei-CGN</option>
                    <option value="Cisco 892">Cisco 892</option>
                    <option value="Cisco 881">Cisco 881</option>
                    <option value="Pfsense">Pfsense</option>
            </select><br/><br/>
	    
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </div></center>';

	   ################### Traitemement $choix NAT pfsense #########################
	    
	   if (!empty($_POST['cpe_port_pfsense'])  && !empty($_POST['nmb_port_pfsense']) ){
	       
	       $template = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
	<title>VPN Users</title>
</head>
<body>
<table cellpadding="1" cellspacing="1" border="1">
<thead>
<tr><td rowspan="1" colspan="3">Untitled Test Case</td></tr>
</thead>
<tbody>';


 for ($i = 1; $i <= $_POST['nmb_port_pfsense']; $i++) {
     
     $template .= "<tr><td>click</td><td>link=Add<datalist><option>link=Add</option><option>//body[@id='2']/div/form/nav/a</option><option>//a[contains(@href, 'firewall_nat_edit.php?after=-1')]</option><option>//nav/a</option><option>css=a.btn.btn-sm.btn-success</option></datalist></td><td></td>
</tr>
<tr><td>select</td><td>id=proto<datalist><option>id=proto</option><option>name=proto</option><option>//select[@id='proto']</option><option>//body[@id='2']/div/form/div/div[2]/div[4]/div/select</option><option>//div[4]/div/select</option><option>css=#proto</option></datalist></td><td>label=".$_POST['protocole_'.$i]."</td>
</tr>
<tr><td>type</td><td>id=dstbeginport_cust<datalist><option>id=dstbeginport_cust</option><option>name=dstbeginport_cust</option><option>//input[@id='dstbeginport_cust']</option><option>//body[@id='2']/div/form/div/div[2]/div[9]/div[2]/input</option><option>//div[9]/div[2]/input</option><option>css=#dstbeginport_cust</option></datalist></td><td>".$_POST['port_externe_begin_'.$i]."</td>
</tr>
<tr><td>type</td><td>id=dstendport_cust<datalist><option>id=dstendport_cust</option><option>name=dstendport_cust</option><option>//input[@id='dstendport_cust']</option><option>//body[@id='2']/div/form/div/div[2]/div[9]/div[4]/input</option><option>//div[9]/div[4]/input</option><option>css=#dstendport_cust</option></datalist></td><td>".$_POST['port_externe_end_'.$i]."</td>
</tr>
<tr><td>type</td><td>id=localip<datalist><option>id=localip</option><option>name=localip</option><option>//input[@id='localip']</option><option>//body[@id='2']/div/form/div/div[2]/div[10]/div/input</option><option>//div[10]/div/input</option><option>css=#localip</option></datalist></td><td>".$_POST['ip_local_'.$i]."</td>
</tr>
<tr><td>type</td><td>id=localbeginport_cust<datalist><option>id=localbeginport_cust</option><option>name=localbeginport_cust</option><option>//input[@id='localbeginport_cust']</option><option>//body[@id='2']/div/form/div/div[2]/div[11]/div[2]/input</option><option>//div[11]/div[2]/input</option><option>css=#localbeginport_cust</option></datalist></td><td>".$_POST['port_interne_'.$i]."</td>
</tr>
<tr><td>type</td><td>id=descr<datalist><option>id=descr</option><option>name=descr</option><option>//input[@id='descr']</option><option>//body[@id='2']/div/form/div/div[2]/div[12]/div/input</option><option>//div[12]/div/input</option><option>css=#descr</option></datalist></td><td>Ticket ".$_POST['ticket']."</td>
</tr>
<tr><td>click</td><td>id=save<datalist><option>id=save</option><option>name=save</option><option>//button[@id='save']</option><option>//body[@id='2']/div/form/div[2]/button</option><option>//div[2]/button</option><option>css=#save</option></datalist></td><td></td>
</tr>";
 }
 $template .= '
</tbody></table>
</body>
</html>'; 
	   
	   echo '<center><section>
  <div id="container">
    <input type="text" value="PAT_Pfsense.html" placeholder="filename.txt">
    <button class="btn btn-outline-success btn-sm mb-2" onclick="downloadFile()">Génération Fichier</button> <output></output>
    <br/><br/>
    <div contenteditable style="display:none;">'.htmlspecialchars($template).'</div>
  </div>
</section>';
    
	   }
  

	   ################### Traitemement $choix NAT deuxieme partie #########################
	    
	   if (!empty($_POST['cpe_port_2'])  && !empty($_POST['nmb_port_2']) ){
	       
	       

	     echo '<center>
	    <form method="post" action="pat.php">
	     <h3> Ajout PAT</h3>
            <table border="1">
                <tr>
                    <td>Protocole</td>
                    <td>Port Externe</td>
                    <td>IP Local</td>
                    <td>Port Interne</td>
                </tr>';
                
                for ($i = 1; $i <= $_POST['nmb_port_2']; $i++) {
                 
                 
                 echo '<tr>
                        <td>
                            <select name="protocole_'.$i.'"  class="form-control">
                                <option value="'.$_POST['protocole_'.$i].'">'.$_POST['protocole_'.$i].'</option>
                                <option value="TCP">TCP</option>
                                <option value="UDP">UDP</option>
                                <option value="TCP/UDP">TCP/UDP</option>
                        </select>
                        </td>
                        <td><input  type="text"  class="form-control" name="port_externe_'.$i.'" value="'.$_POST['port_externe_'.$i].'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_local_'.$i.'" value="'.$_POST['ip_local_'.$i].'" /></td>
                        <td><input  type="text"  class="form-control" name="port_interne_'.$i.'" value="'.$_POST['port_interne_'.$i].'"/></td>
                        </tr>
                 ';   
                }
	  echo '  </table>
	    <input type="hidden" value="' . $_POST['nmb_port_2'] . '" name ="nmb_port_2"/>
	    <input type="hidden" value="' . $_POST['cpe_port_2'] . '" name ="cpe_port_2"/><br/>
	    
	    <button type="submit" name="nat" value="Generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </center>';
	    
	    
	   
	   echo "<center><table border='1'>
                <tr>
                    <td>Conf CPE : </td>
                </tr>
	    <tr>
                <td>";
                if($_POST['cpe_port_2'] == 'Huawei' || $_POST['cpe_port_2'] == 'Huawei-CGN'){
     echo 'interface GigabitEthernet 0/0/8 <br/>';}
    for ($i = 1; $i <= $_POST['nmb_port_2']; $i++) {
        
   if($_POST['cpe_port_2'] == 'Cisco 892' || $_POST['cpe_port_2'] == 'Cisco 881'){   
        if($_POST['cpe_port_2'] == 'Cisco 892'){
            $routeur = 'GigabitEthernet 8';
        }else {
            $routeur = 'FastEthernet 4';
        }
        
        if($_POST['protocole_'.$i] == 'TCP/UDP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         
         echo'  ip nat inside source static tcp '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' interface '.$routeur.' '.$_POST['port_externe_'.$i].'  <br/>
                ip nat inside source static udp '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' interface '.$routeur.' '.$_POST['port_externe_'.$i].'  <br/>
         ';
            
        }elseif($_POST['protocole_'.$i] == 'UDP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         echo'   ip nat inside source static udp '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' interface '.$routeur.' '.$_POST['port_externe_'.$i].'  <br/>';
        }
        elseif($_POST['protocole_'.$i] == 'TCP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         echo'   ip nat inside source static tcp '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' interface '.$routeur.' '.$_POST['port_externe_'.$i].'  <br/>';
        }
	        
   }elseif($_POST['cpe_port_2'] == 'Huawei'){

     if($_POST['protocole_'.$i] == 'TCP/UDP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         
         echo'  nat static protocol tcp  global current-interface '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' <br/>
                nat static protocol udp  global current-interface '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' <br/>
         ';
            
        }elseif($_POST['protocole_'.$i] == 'UDP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         echo'   nat static protocol udp  global current-interface '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].'<br/>';
        }
        elseif($_POST['protocole_'.$i] == 'TCP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         echo'   nat static protocol tcp  global current-interface '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].'<br/>';
        }
    }elseif($_POST['cpe_port_2'] == 'Huawei-CGN'){

     if($_POST['protocole_'.$i] == 'TCP/UDP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         
         echo'  nat static protocol tcp  global interface LoopBack 50 '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' <br/>
                nat static protocol udp  global interface LoopBack 50 '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].' <br/>
         ';
            
        }elseif($_POST['protocole_'.$i] == 'UDP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         echo'   nat static protocol udp  global interface LoopBack 50 '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].'<br/>';
        }
        elseif($_POST['protocole_'.$i] == 'TCP' && !empty($_POST['ip_local_'.$i]) && !empty($_POST['port_interne_'.$i]) && !empty($_POST['port_externe_'.$i]) ){
         echo'   nat static protocol tcp  global interface LoopBack 50 '.$_POST['port_externe_'.$i].' inside '.$_POST['ip_local_'.$i].' '.$_POST['port_interne_'.$i].'<br/>';
        }
    }              
	        
	    }
	    echo '</td>
	            </tr>
	                </table></center>';
	    exit;
  
	   }
       ################### Fin Traitemement $choix NAT deuxieme partie #########################

	   ################### Traitemement $choix NAT premiere partie #########################
	   
	      if (!empty($_POST['nmb_port']) && !empty($_POST['cpe_port'])){
	          
	          $nmb_port = $_POST['nmb_port'];
	          $cpe_port = $_POST['cpe_port'];
	          
	          if($cpe_port == 'Pfsense'){
	              
	              echo '<center>
	       <h3>Ajout Pat</h3>
	    <form method="post" action="pat.php">
	     
            <table border="1">
                <tr>
                    <td>Protocole</td>
                    <td>Port Externe Début</td>
                    <td>Port Externe Fin</td>
                    <td>IP Local</td>
                    <td>Port Interne</td>
                    
                </tr>';
                
                for ($i = 1; $i <= $nmb_port; $i++) {
                 
                 
                 echo '<tr>
                        <td>
                            <select name="protocole_'.$i.'"  class="form-control">
                                <option value="TCP">TCP</option>
                                <option value="UDP">UDP</option>
                                <option value="TCP/UDP">TCP/UDP</option>
                        </select>
                        </td>
                        <td><input  type="text"  class="form-control" name="port_externe_begin_'.$i.'" /></td>
                        <td><input  type="text"  class="form-control" name="port_externe_end_'.$i.'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_local_'.$i.'" /></td>
                        <td><input  type="text"  class="form-control" name="port_interne_'.$i.'" /></td>
                        </tr>
                 ';   
                }
	  echo '  </table>
    <table>
    <tr>
    <td>Ticket</td>
    </tr>
    <tr>
    <td><input  type="text"  class="form-control" name="ticket" /></td>
    </tr>
    </table>
	    <input type="hidden" value="' . $nmb_port . '" name ="nmb_port_pfsense"/>
	    <input type="hidden" value="' . $cpe_port . '" name ="cpe_port_pfsense"/><br/>
	    
	     <button type="submit" name="nat" value="Generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    
	    </form>
	    </center>';
	    
	    exit;
	              
	          }else{
	          
	          
	          
	       echo '<center>
	       <h3>Ajout Pat</h3>
	    <form method="post" action="pat.php">
	     
            <table border="1">
                <tr>
                    <td>Protocole</td>
                    <td>Port Externe</td>
                    <td>IP Local</td>
                    <td>Port Interne</td>
                </tr>';
                
                for ($i = 1; $i <= $nmb_port; $i++) {
                 
                 
                 echo '<tr>
                        <td>
                            <select name="protocole_'.$i.'"  class="form-control">
                                <option value="TCP">TCP</option>
                                <option value="UDP">UDP</option>
                                <option value="TCP/UDP">TCP/UDP</option>
                        </select>
                        </td>
                        <td><input  type="text"  class="form-control" name="port_externe_'.$i.'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_local_'.$i.'" /></td>
                        <td><input  type="text"  class="form-control" name="port_interne_'.$i.'" /></td>
                        </tr>
                 ';   
                }
	  echo '  </table>
	    <input type="hidden" value="' . $nmb_port . '" name ="nmb_port_2"/>
	    <input type="hidden" value="' . $cpe_port . '" name ="cpe_port_2"/><br/>
	    
	     <button type="submit" name="nat" value="Generation" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    
	    </form>
	    </center>';
	    
	    exit;
	          
	      }
	      }
	 
	      echo $choix_port_1;
	        ################### Fin Traitemement $choix NAT premiere partie ######################### 
	     ?>
	     
	    
<script>
var container = document.querySelector('#container');
var typer = container.querySelector('[contenteditable]');
var output = container.querySelector('output');

const MIME_TYPE = 'text/plain';

// Rockstars use event delegation!
document.body.addEventListener('dragstart', function(e) {
  var a = e.target;
  if (a.classList.contains('dragout')) {
    e.dataTransfer.setData('DownloadURL', a.dataset.downloadurl);
  }
}, false);

document.body.addEventListener('dragend', function(e) {
  var a = e.target;
  if (a.classList.contains('dragout')) {
    cleanUp(a);
  }
}, false);

document.addEventListener('keydown', function(e) {
  if (e.keyCode == 27) {  // Esc
    document.querySelector('details').open = false;
  } else if (e.shiftKey && e.keyCode == 191) { // shift + ?
    document.querySelector('details').open = true;
  }
}, false);

var cleanUp = function(a) {
  a.textContent = 'Downloaded';
  a.dataset.disabled = true;

  // Need a small delay for the revokeObjectURL to work properly.
  setTimeout(function() {
    window.URL.revokeObjectURL(a.href);
  }, 1500);
};

var downloadFile = function() {
  window.URL = window.webkitURL || window.URL;

  var prevLink = output.querySelector('a');
  if (prevLink) {
    window.URL.revokeObjectURL(prevLink.href);
    output.innerHTML = '';
  }

  var bb = new Blob([typer.textContent], {type: MIME_TYPE});

  var a = document.createElement('a');
  a.download = container.querySelector('input[type="text"]').value;
  a.href = window.URL.createObjectURL(bb);
  a.textContent = 'Download ready';

  a.dataset.downloadurl = [MIME_TYPE, a.download, a.href].join(':');
  a.draggable = true; // Don't really need, but good practice.
  a.classList.add('dragout');

  output.appendChild(a);

  a.onclick = function(e) {
    if ('disabled' in this.dataset) {
      return false;
    }

    cleanUp(this);
  };
};
</script>
