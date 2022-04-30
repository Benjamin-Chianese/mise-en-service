<?php
require('../includes/head.php'); 



echo '<br/><center>

	    <table border="1">
	    <tr>
	        <th>Couleur Client</th>
	        <th>Condition</th>
	    </tr>
	    
	    <tr>
	    <td style="background-color:#CC3E54" >Rouge</td>
	    <td>Semaine actuel ou passée avec CPE NOK et Circuit NOK</td>
	    </tr>
	    
	    <tr>
	    <td style="background-color:#DBD23A" >Jaune</td>
	    <td>Semaine +2 avec CPE NOK et Circuit NOK</td>
	    </tr>
	    
	    <tr>
	    <td style="background-color:#20AE51" >Vert</td>
	    <td>CPE OK et Circuit OK</td>
	    </tr>
	    
	    <tr>
	    <td style="background-color:#6699ff" >Bleu</td>
	    <td>Date mes Prévu non remplie</td>
	    </tr>
	    
	    
    </table>
    <br/>
    
	   <table border="1"> 
	    <tr>
	        <th>Couleur CPE</th>
	        <th>Condition</th>
	    </tr>
	    
	    <tr>
	    <td style="background-color:#5db280" >Vert</td>
	    <td>Natira ou Fullsave</td>
	    </tr>
	    
	     <tr>
	    <td style="background-color:#FF9900" >Orange</td>
	    <td>Orange GHD GN</td>
	    </tr>
	    
	     <tr>
	    <td style="background-color:#FFFF66" >Jaune</td>
	    <td>Autres</td>
	    </tr>
     </table>
	    
	    ';
	    
require('../includes/foot.php');

?>