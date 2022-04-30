<?php
require('../includes/head.php'); 





  
	   ################### Traitemement $choix NAT deuxieme partie #########################
	    
	  

	     echo '<center>
	    <form method="post" action="test4.php">
	     <h3> Création user VPN</h3>

             <textarea name="description">

             </textarea>  
	  


	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </center>';
	    

	      
	      if (!empty($_POST['description']) ){
	          
$description = $_POST['description'];
$i =0;

        

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

 if(substr_count($description, '|') > $i){
    $explode_description = explode('|',$description);
      foreach ($explode_description as &$desc) {

$fsc_count = strlen($desc);
                switch ($fsc_count) {
                    case 1:
                        $fsc = 'FSC0000'.$desc;
                    break;
                    case 2:
                        $fsc = 'FSC000'.$desc;
                    break;
                    case 3:
                        $fsc = 'FSC00'.$desc;
                    break;
                    case 4:
                        $fsc = 'FSC0'.$desc;
                    break;
                    case 5:
                        $fsc = 'FSC'.$desc;
                    break;
                }


$template .= "
<tr><td>open</td><td>https://wiki-client.fullsave.org/Accueil<datalist><option>https://wiki-client.fullsave.org/Accueil</option></datalist></td><td></td>
</tr>
<tr><td>click</td><td>id=searchInput<datalist><option>id=searchInput</option><option>name=search</option><option>xpath=//input[@id='searchInput']</option><option>xpath=//div[@id='simpleSearch']/input</option><option>xpath=//input</option><option>css=#searchInput</option></datalist></td><td></td>
</tr>
<tr><td>type</td><td>id=searchInput<datalist><option>id=searchInput</option><option>name=search</option><option>xpath=//input[@id='searchInput']</option><option>xpath=//div[@id='simpleSearch']/input</option><option>xpath=//input</option><option>css=#searchInput</option></datalist></td><td>".$fsc."</td>
</tr>
<tr><td>submit</td><td>id=searchform<datalist><option>id=searchform</option></datalist></td><td></td>
</tr>
<tr><td>click</td><td>link=".$fsc."<datalist><option>link=".$fsc."</option><option>xpath=//a[contains(text(),'".$fsc."')]</option><option>xpath=//div[@id='mw-content-text']/div/p/strong/a</option><option>xpath=(.//*[normalize-space(text()) and normalize-space(.)='Recherche avancée'])[1]/following::a[1]</option><option>xpath=(.//*[normalize-space(text()) and normalize-space(.)='Correspondances dans les titres des pages'])[1]/preceding::a[1]</option><option>xpath=(.//*[normalize-space(text()) and normalize-space(.)='".$fsc."/fsn00628'])[1]/preceding::a[1]</option><option>xpath=//*/text()[normalize-space(.)='".$fsc."']/parent::*</option><option>xpath=//a[contains(@href, '/index.php?title=".$fsc."&amp;action=edit&amp;redlink=1')]</option><option>xpath=//strong/a</option><option>css=a.new</option></datalist></td><td></td>
</tr>
<tr><td>click</td><td>id=wpTextbox1<datalist><option>id=wpTextbox1</option><option>name=wpTextbox1</option><option>xpath=//textarea[@id='wpTextbox1']</option><option>xpath=//form[@id='editform']/div[2]/div[3]/div/div[2]/div/textarea</option><option>xpath=//textarea</option><option>css=#wpTextbox1</option></datalist></td><td></td>
</tr>
<tr><td>type</td><td>id=wpTextbox1<datalist><option>id=wpTextbox1</option><option>name=wpTextbox1</option><option>xpath=//textarea[@id='wpTextbox1']</option><option>xpath=//form[@id='editform']/div[2]/div[3]/div/div[2]/div/textarea</option><option>xpath=//textarea</option><option>css=#wpTextbox1</option></datalist></td><td>== Documents ==

[https://my.fullsave.com/index.php/apps/files/?dir=%2FClients%2FFSC00001%20(FullSave) Lien vers les documents]

{{Special:PrefixIndex/{{FULLPAGENAME}}/}}</td>
</tr>
<tr><td>click</td><td>id=wpSave<datalist><option>id=wpSave</option><option>name=wpSave</option><option>xpath=//input[@id='wpSave']</option><option>xpath=//form[@id='editform']/div[4]/div[3]/input</option><option>xpath=//div[3]/input</option><option>css=#wpSave</option></datalist></td><td></td>
</tr>

";
  }
}
	          
	          
$template .= "
</tbody></table>
</body>
</html>";


echo '<center><section>
  <div id="container">
    <input type="text" value="User_VPN.html" placeholder="filename.txt">
    <button class="btn btn-outline-success btn-sm mb-2" onclick="downloadFile()">Génération Fichier</button> <output></output>
    <br/><br/>
    <div contenteditable style="display:none;">'.htmlspecialchars($template).'</div>
  </div>
</section>';







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
	      

