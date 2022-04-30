<?php
require('../includes/head.php'); 



$choix_port_1 = '<center><div class="mx-auto" style="width: 600px;">	
	     <h3> Création user VPN</h3>
	    <form method="post" action="user_vpn.php">
	    Combien de compte à créer :<br/>
	    <input  type="numb"  class="form-control" name="nmbr_compte"  required/><br/><br/>
      
	    
	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    ';


  
	   ################### Traitemement $choix NAT deuxieme partie #########################
	    
	   if (!empty($_POST['nmbr_compte']) ){

	     echo '<center>
	    <form method="post" action="user_vpn.php">
	     <h3> Création user VPN</h3>
            <table border="1">
                <tr>
                    <td>Nom</td>
                    <td>Prénom</td>
                    <td>Numéro (0600000000)</td>
                    <td>Mail</td>
                </tr>';
                
                for ($i = 1; $i <= $_POST['nmbr_compte']; $i++) {
                 
                 
                 echo '<tr>
                        
                        <td><input  type="text"  class="form-control" name="nom_'.$i.'" value="'.$_POST['nom_'.$i].'" /></td>
                        <td><input  type="text"  class="form-control" name="prenom_'.$i.'" value="'.$_POST['prenom_'.$i].'" /></td>
                        <td><input  type="text"  class="form-control" name="numero_'.$i.'" value="'.$_POST['numero_'.$i].'" /></td>
                        <td><input  type="text"  class="form-control" name="mail_'.$i.'" value="'.$_POST['mail_'.$i].'" /></td>
                        </tr>
                 ';   
                }
	  echo '  </table></br><br/>
	  <table>
                <tr>

	      <td> Style login : 
	        <select name="login" class="form-control">
                    <option value="1">p.nom</option>
                    <option value="2">pnom</option>
                    <option value="3">prenom.nom</option>
                    <option value="4">prenomnom</option>
                    <option value="5">n.prenom</option>
                    <option value="6">nprenom</option>
                    <option value="7">nom.prenom</option>
                    <option value="8">nomprenom</option>
                    
            </select>
            </td>
            <td>Nom CA : (si vide il prend par défault) <input  type="text"  class="form-control" name="ca" value="" /></td>
            </tr>
        </table></br>

	  
	    <input type="hidden" value="'.$_POST['nmbr_compte'].'" name ="nmbr_compte_2"/>

	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </center>';
	    
    exit;
	          
	      }
	      
	      if (!empty($_POST['nom_1']) ){
	          

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

	     $form_mail = '<table border="1">
                <tr>
                    <td>Login</td>
                    <td>MDP</td>
                    <td>Numéro</td>
                    <td>Lien client VPN</td>
                </tr>
        <form method="post" action="user_vpn_2.php">
<div class="form-row align-items-center">'; 
	     $liste_login;
	     
	     $caract = "abcdefghijkmnpqrstuvwyxzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
	          for ($i = 1; $i <= $_POST['nmbr_compte_2']; $i++) {
	        $mdp_gen;      

# Traitement prenom pour login
   
if(strstr($_POST['prenom_'.$i],'-')){
    $prenom_copose_eplode = explode ("-",$_POST['prenom_'.$i]);
    $prenom_recup = substr(trim($prenom_copose_eplode[0]),0,1);
    $prenom_recup .= substr(trim($prenom_copose_eplode[1]),0,1);
    
    $prenom_recup_complet = trim($prenom_copose_eplode[0]);
    $prenom_recup_complet .= trim($prenom_copose_eplode[1]);
}elseif(strstr($_POST['prenom_'.$i],' ')){
    $prenom_copose_eplode = explode (" ",$_POST['prenom_'.$i]);
    $prenom_recup = substr(trim($prenom_copose_eplode[0]),0,1);
    $prenom_recup .= substr(trim($prenom_copose_eplode[1]),0,1);
    
    $prenom_recup_complet = trim($prenom_copose_eplode[0]);
    $prenom_recup_complet .= trim($prenom_copose_eplode[1]);

}else{
    $prenom_recup = substr(trim($_POST['prenom_'.$i]),0,1);
    $prenom_recup_complet = trim($_POST['prenom_'.$i]);
}

# Traitement nom pour login

if(strstr($_POST['nom_'.$i],'-')){
    $nom_copose_eplode = explode ("-",$_POST['nom_'.$i]);
    $nom_recup = substr(trim($nom_copose_eplode[0]),0,1);
    $nom_recup .= substr(trim($nom_copose_eplode[1]),0,1);
    
    $nom_recup_complet = trim($nom_copose_eplode[0]);
    $nom_recup_complet .= trim($nom_copose_eplode[1]);
}elseif(strstr($_POST['nom_'.$i],' ')){
    $nom_copose_eplode = explode (" ",$_POST['nom_'.$i]);
    $nom_recup = substr(trim($nom_copose_eplode[0]),0,1);
    $nom_recup .= substr(trim($nom_copose_eplode[1]),0,1);
    $nom_recup_complet = trim($nom_copose_eplode[0]);
    $nom_recup_complet .= trim($nom_copose_eplode[1]);

}else{
    $nom_recup = substr(trim($_POST['nom_'.$i]),0,1);
    $nom_recup_complet = trim($_POST['nom_'.$i]);
}


	              switch ($_POST['login']) {
    case 1:
        
	    $login_trait = $prenom_recup.'.'.$nom_recup_complet;
        break;
    case 2:
	    $login_trait = $prenom_recup.''.$nom_recup_complet;
        break;
    case 3:
	    $login_trait = $prenom_recup_complet.'.'.$nom_recup_complet;
        break;
    case 4:
	    $login_trait = $prenom_recup_complet.''.$nom_recup_complet;
        break;
    case 5:
	    $login_trait = $nom_recup.'.'.$prenom_recup_complet;
        break;
    case 6:
	    $login_trait = $nom_recup.''.$prenom_recup_complet;
        break;
    case 7:
	    $login_trait = $nom_recup_complet.'.'.$prenom_recup_complet;
        break;
    case 8:
	    $login_trait = $nom_recup_complet.''.$prenom_recup_complet;
        break;
}
	              
	              $find = array("."," ","-");
                  $replace = array("");
	              $tel = str_replace($find,$replace,$_POST['numero_'.$i]);
	             
	              $login = strtolower($login_trait);
	              

        
        
        

for($j = 1; $j <= 12; $j++) {

// On compte le nombre de caractères
$Nbr = strlen($caract);

// On choisit un caractère au hasard dans la chaine sélectionnée :
$Nbr = random_int(0,($Nbr-1));

// Pour finir, on écrit le résultat :
$mdp_gen .= $caract[$Nbr];

}
$mdp = $mdp_gen;
unset($mdp_gen);

$nom_prenom =strtoupper(trim($_POST['nom_'.$i]))." ".ucfirst(strtolower(trim($_POST['prenom_'.$i])));

 
	          
$form_mail .= ' <tr>
                    <td>'.$login.'</td>
                    <td>'.$mdp.'</td>
                    <td>'.$tel.'</td> 
<td><input  type="text" required name="client_vpn_'.$i.'" value="" /></td>
</tr>

<input type="hidden" value="'.$login.'" name ="login_mail_'.$i.'"/>
<input type="hidden" value="'.$tel.'" name ="tel_mail_'.$i.'"/>
<input type="hidden" value="'.trim($_POST['mail_'.$i]).'" name ="addr_mail_'.$i.'"/>
<input type="hidden" value="'.$mdp.'" name ="mdp_mail_'.$i.'"/>
<input type="hidden" value="'.$_POST['nmbr_compte_2'].'" name ="nbr_mail"/>

	   ';


$ca = $_POST['ca'];


$template .= "<textarea><tr><td>click</td><td>link=Add<datalist><option>link=Add</option><option>//body[@id='3']/div/form/nav/a</option><option>//a[contains(@href, '?act=new')]</option><option>//nav/a</option><option>css=a.btn.btn-sm.btn-success</option></datalist></td><td></td>
</tr>
<tr><td>doubleClick</td><td>id=usernamefld<datalist><option>id=usernamefld</option><option>name=usernamefld</option><option>//input[@id='usernamefld']</option><option>//body[@id='2']/div/form/div/div[2]/div[3]/div/input</option><option>//div/input</option><option>css=#usernamefld</option></datalist></td><td></td>
</tr>
<tr><td>type</td><td>id=usernamefld<datalist><option>id=usernamefld</option><option>name=usernamefld</option><option>//input[@id='usernamefld']</option><option>//body[@id='2']/div/form/div/div[2]/div[3]/div/input</option><option>//div/input</option><option>css=#usernamefld</option></datalist></td><td>".$login."</td>
</tr>
<tr><td>click</td><td>id=passwordfld1<datalist><option>id=passwordfld1</option><option>name=passwordfld1</option><option>//input[@id='passwordfld1']</option><option>//body[@id='2']/div/form/div/div[2]/div[4]/div/input</option><option>//div[4]/div/input</option><option>css=#passwordfld1</option></datalist></td><td></td>
</tr>
<tr><td>type</td><td>id=passwordfld1<datalist><option>id=passwordfld1</option><option>name=passwordfld1</option><option>//input[@id='passwordfld1']</option><option>//body[@id='2']/div/form/div/div[2]/div[4]/div/input</option><option>//div[4]/div/input</option><option>css=#passwordfld1</option></datalist></td><td>".$mdp."</td>
</tr>
<tr><td>type</td><td>id=passwordfld2<datalist><option>id=passwordfld2</option><option>name=passwordfld2</option><option>//input[@id='passwordfld2']</option><option>//body[@id='2']/div/form/div/div[2]/div[4]/div[2]/input</option><option>//div[2]/input</option><option>css=#passwordfld2</option></datalist></td><td>".$mdp."</td>
</tr>
<tr><td>type</td><td>id=descr<datalist><option>id=descr</option><option>name=descr</option><option>//input[@id='descr']</option><option>//body[@id='2']/div/form/div/div[2]/div[5]/div/input</option><option>//div[5]/div/input</option><option>css=#descr</option></datalist></td><td>".$nom_prenom."</td>
</tr>
<tr><td>click</td><td>id=showcert<datalist><option>id=showcert</option><option>name=showcert</option><option>//input[@id='showcert']</option><option>//body[@id='2']/div/form/div/div[2]/div[19]/div/label/input</option><option>//div[19]/div/label/input</option><option>css=#showcert</option></datalist></td><td></td>
</tr>
<tr><td>click</td><td>id=name<datalist><option>id=name</option><option>name=name</option><option>//input[@id='name']</option><option>//body[@id='2']/div/form/div[2]/div[2]/div/div/input</option><option>//div[2]/div[2]/div/div/input</option><option>css=#name</option></datalist></td><td></td>
</tr>
<tr><td>type</td><td>id=name<datalist><option>id=name</option><option>name=name</option><option>//input[@id='name']</option><option>//body[@id='2']/div/form/div[2]/div[2]/div/div/input</option><option>//div[2]/div[2]/div/div/input</option><option>css=#name</option></datalist></td><td>".$login."</td>
</tr>
";
if (!empty($ca)){
    $template .= "<tr><td>click</td><td>id=caref<datalist><option>id=caref</option><option>name=caref</option><option>//select[@id='caref']</option><option>//body[@id='3']/div/form/div[2]/div[2]/div[2]/div/select</option><option>//div[2]/div/select</option><option>css=#caref</option></datalist></td><td></td>
</tr>
<tr><td>select</td><td>id=caref<datalist><option>id=caref</option><option>name=caref</option><option>//select[@id='caref']</option><option>//body[@id='3']/div/form/div[2]/div[2]/div[2]/div/select</option><option>//div[2]/div/select</option><option>css=#caref</option></datalist></td><td>label=".$ca."</td>
</tr>";
}
$template .= "<tr><td>click</td><td>id=save<datalist><option>id=save</option><option>name=save</option><option>//button[@id='save']</option><option>//body[@id='2']/div/form/div[4]/button</option><option>//div[4]/button</option><option>css=#save</option></datalist></td><td></td>
</tr>";

	          }
	          
	          
$template .= "
</tbody></table>
</body>
</html>";


echo $choix_port_1;
echo '<center><section>
  <div id="container">
    <input type="text" value="User_VPN.html" placeholder="filename.txt">
    <button class="btn btn-outline-success btn-sm mb-2" onclick="downloadFile()">Génération Fichier</button> <output></output>
    <br/><br/>
    <div contenteditable style="display:none;">'.htmlspecialchars($template).'</div>
  </div>
</section>';


echo '</br></br>';
 $form_mail .= '</table>
 <input type="hidden" value="'.htmlspecialchars($choix_port_1).'" name ="choix_port_1"/>

 <button type="submit" class="btn btn-outline-success btn-sm mb-2">Mail</button>
	    </form></div>';
echo $form_mail;
echo '</div></center>';





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

<?php
	 exit;         
	      }
	      
	      echo $choix_port_1;
	      
	      ################### Fin Traitemement $choix NAT premiere partie #########################
