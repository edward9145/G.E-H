<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Clean Cache Files</title>
    </head>
    <body>
    <?php
    // TODO clear cache files in ./temp/*.*
    include_once 'func.php';
    
    $password = $_REQUEST["pw"];
    if(md5($password) == 'ecec42be306bb09b0623c0a167d7fd30'){
        clear_cache($cache_folder);
        echo 'Cache cleaned.';
    }
    else{
        echo "Cache clean failed...";
    }
    
    
    ?>
    </body>
</html>
