<?php
#var_dump($_POST);


?><html>
    <body>
        <button onclick="generate()">Génération du PV</button>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.16.8/docxtemplater.js"></script>
    <script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip-utils.js"></script>
    <!--
    Mandatory in IE 6, 7, 8 and 9.
    -->
    <!--[if IE]>
        <script type="text/javascript" src="https://unpkg.com/pizzip@3.0.6/dist/pizzip-utils-ie.js"></script>
    <![endif]-->
    
    
    <script>
    function loadFile(url,callback){
        PizZipUtils.getBinaryContent(url,callback);
    }
    
    
    function generate() {
        <?php 
        if($_POST['type'] == 'Internet Access' || $_POST['type'] == 'Multisite MPLS'){
        echo 'loadFile("templates/Fullsave_direct.docx",function(error,content)';
        }elseif($_POST['type'] == 'Collecte Ethernet'){
        echo 'loadFile("templates/Fullsave_collecte.docx",function(error,content)';
        }
        
        ?>
        {
            if (error) { throw error };
            var zip = new PizZip(content);
            var doc=new window.docxtemplater().loadZip(zip)
            <?php

         echo '   doc.setData({
                DATE_J: "'. date('d/m/Y').'",
                CLIENT: "'.$_POST['client'].'",
                FSC: "'.$_POST['fsc'].'",
                DEVIS: "'.$_POST['devis'].'",
                MES: "'.$_POST['mes'].'",
                TYPE: "'.$_POST['type'].'",
                FSLNK: "'.$_POST['fslnk'].'",
                ADRESSE: "'.$_POST['adresse'].'",
                DEBIT: "'.$_POST['debit'].'",
                GTR: "'.$_POST['gtr'].'",
                IP: "'.$_POST['ip'].'",
                VLAN: "'.$_POST['vlan'].'",
                CPE: "'.$_POST['cpe'].'",
                SN: "'.$_POST['sn'].'",
                HOSTNAME: "'.$_POST['eqts'].'"
            }); ';?>
            try {
                // render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
                doc.render()
            }
            catch (error) {
                // The error thrown here contains additional information when logged with JSON.stringify (it contains a properties object containing all suberrors).
                function replaceErrors(key, value) {
                    if (value instanceof Error) {
                        return Object.getOwnPropertyNames(value).reduce(function(error, key) {
                            error[key] = value[key];
                            return error;
                        }, {});
                    }
                    return value;
                }
                console.log(JSON.stringify({error: error}, replaceErrors));

                if (error.properties && error.properties.errors instanceof Array) {
                    const errorMessages = error.properties.errors.map(function (error) {
                        return error.properties.explanation;
                    }).join("\n");
                    console.log('errorMessages', errorMessages);
                    // errorMessages is a humanly readable message looking like this :
                    // 'The tag beginning with "foobar" is unopened'
                }
                throw error;
            }
            var out=doc.getZip().generate({
                type:"blob",
                mimeType: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            }) //Output the document using Data-URI
            <?php
            echo '
            saveAs(out,"PV_'.$_POST['fslnk'].'_'.$_POST['client'].'.docx")';
            ?>
        })
    }
    </script>
</html>



