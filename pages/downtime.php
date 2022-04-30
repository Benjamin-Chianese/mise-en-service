<?php
require('../includes/head.php'); 

echo '<div class="mx-auto" style="width: 400px;"><center>

<form  method="post" action="downtime.php">



Nombre de client impacté :
        <input  type="number" id="nombre_impact" class="form-control" name="nombre_impact"  /><br/>

        <button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button>
</form>
</div></center>';

if (!empty($_POST['impact'])){

 echo '<center><table border="1">
            <tr>
                <td><center>Downtime</center></td>
            </tr>';
         
         $nb= $_POST['impact']; 

echo '<tr>
                                            
                <td>';
            for ($i = 1; $i <= $nb; $i++) {
                    if(!empty($_POST['fs'.$i])){
 
            $begin_construct = $_POST['begin_date'].' '.$_POST['begin_time'];
            $end_construct = $_POST['end_date'].' '.$_POST['end_time'];
            
            $temps = $_POST['duree'] *60;
            

             
                                            
                    echo 'echo -e "COMMAND [$(date +%s)] SCHEDULE_HOST_DOWNTIME;'.$_POST['fs'.$i].';'.strtotime($begin_construct).';'.strtotime($end_construct).';1;0;'.$temps.';Prevenance;Manuel" | nc localhost 50000</br>';
                                        
                                            
                                        

                    }

            }
        
        
       echo " </td></tr></table></center><br/><br/>";
            }




if (!empty($_POST['nombre_impact'])){
    $nombre_impact = $_POST['nombre_impact'];
    
     echo '<div class="mx-auto" style="width: 600px;">
    <center>
        <form method="post" action="downtime.php">
        <table>
        <tr>
            <td>Début intervention :</td>
            <td><input  type="date" class="form-control" name="begin_date" value="'.$begin_date.'" required /></td>
            <td><input  type="time"  class="form-control" name="begin_time" value="'.$begin_time.'" required/></td>
        </tr>
        <tr>
            <td>Fin intervention :</td>
            <td><input  type="date" class="form-control" name="end_date" value="'.$end_date.'" required  /></td>
            <td><input  type="time"  class="form-control" name="end_time" value="'.$end_time.'" required/></td>
        </tr>
    </table>
        <br/><br/>
    <table>
        <tr>
            <td>Durée intervention (min) :</td>
            <td><input  type="num" class="form-control" name="duree" value="'.$duration.'" required  /></td>
        </tr>
    </table>
    <br/><br/>
    
    <table border="1">
        <tr>
            <td><center>Machines</center></td>
        </tr>

        ';
    for ($i = 1; $i <= $nombre_impact; $i++) {
        echo '
        <tr>
            <td><center><input  type="text" class="form-control" name="fs'.$i.'"  /></center></td>
        </tr>   ' ;
}  
    echo '   
</table> <br/>
        <input type="hidden" value="'.$nombre_impact.'" name ="impact"/>
        <center><button type="submit" class="btn btn-outline-success btn-sm mb-2">Valider</button></center>
        
        </form>

    </center></div>
    ';

}


