<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
    <?php
    include_once 'simplehtmldom_1_5/simple_html_dom.php';
    include_once 'func.php';

    $url = $_REQUEST['url'];
    echo $url, '<br />';
    
    $list = image_url_list($url);
    print_r($list);
    
    foreach ($list as $img_url){
        $src = image_src($img_url);
        $path = cache_image(basename($img_url), $src);
        show_image($path);
    }
    
    echo 'Done.';
    
    ?>
    </body>
</html>
