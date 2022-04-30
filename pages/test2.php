<?php
require('../includes/head.php'); 





  
	   ################### Traitemement $choix NAT deuxieme partie #########################
	    
	  

	     echo '<center>
	    <form method="post" action="test2.php">
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
        $ex_desc = explode(',',$desc);

$template .= "
<tr>
<td>type</td>
<td>name=vlan_id</td>
<td>".$ex_desc[0]."</td>
</tr>

<tr>
<td>type</td>
<td>name=vlan_descr</td>
<td>".$ex_desc[1]."</td>
</tr>
<tr>
<td>click</td>
<td>name=submit</td>
<td></td>
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
	      

