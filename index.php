<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
<!--        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
        <title>E-H Gallery</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/themes/jquery.mobile-1.3.1.min.css"/>

	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.mobile-1.3.1.min.js"></script>
    </head>
    <body>
    <?php
    error_reporting(E_ALL);
    include_once 'simplehtmldom_1_5/simple_html_dom.php';
    include_once 'func.php';
    
    $test = 'test/geh.html';
    $geh = 'http://g.e-hentai.org/';
    $html = file_get_html_proxy($geh);
    
    $gallery_php = 'gallery.php?url=';

    foreach($html->find('div.it2') as $ele){
        $arc = $ele->next_sibling();
        $arc = $arc->next_sibling();
        $arc = $arc->children(0);
        $href = $arc->href;
        $title = $arc->plaintext;
        // echo $arc->outertext, "<br />";
        echo "\n", '<a href="', $gallery_php, $href ,'">', $title;
        
        $img = $ele->find('img', 0);
        if($img != null){
            echo $img; 
        }
        else{
            $addr = explode('~', $ele->plaintext);
            $src = 'http://' . $addr[1] . '/' . $addr[2];
//            $src = cache_image(basename($src,".jpg"), $src);
            echo '<img src="', $src, '" alt="', $addr[3],'" />';
        }
        
        echo '</a><br />', "\n";
    }

    ?>
    </body>
</html>
