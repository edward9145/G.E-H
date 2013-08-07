<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
    <?php
    
    error_reporting(E_ALL);
    include_once 'simplehtmldom_1_5/simple_html_dom.php';
    include_once 'func.php';
    
    $url = $_REQUEST['url']; 
    $src = check_cache(basename($url));
    if($src != null){
        show_image($src);
        exit();
    }
    
    $test = 'test/2.html';
    $src = image_src($url);
    
    $src = cache_image(basename($url), $src);
    show_image($src);
    
    ?>
    </body>
</html>
