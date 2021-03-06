<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<title>Gallery</title>
        
        <link rel="stylesheet" href="css/themes/jquery.mobile-1.3.1.min.css"/>

	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.mobile-1.3.1.min.js"></script>
    </head>
    <body>
    <?php
    include_once 'simplehtmldom_1_5/simple_html_dom.php';
    include_once 'func.php';
    
    $url = $_REQUEST['url'];
    
    $result = parse_url($url);
    $path = $result['path'];
    $arr = explode('/', $path);
    $id = $arr[2];
    
    $query = array();
    parse_str($result['query'], $query);
    $p_id = 0;
    if($query['p'] > 0) $p_id = $query['p'];
    
    $cache_filename = CACHE_FOLDER. $id . '_' . $p_id . '.txt';
    $img0_src = CACHE_FOLDER. $id . '_' . $p_id .'.jpg';
    
    if(file_exists($cache_filename) && file_exists($img0_src)){
        ;
    }
    else{
    
        $test = 'test/a.html';
        $html = file_get_html_proxy($url);

        $image_php = 'image.php?url=';
        $src = image_0_src_by_html($html);
        $img0_src = cache_image(basename($img0_src, ".jpg"), $src);
        // echo $src, ' ', $img0_src, '<br />', "\n";

        if(!file_exists($cache_filename)){
            $fp = fopen($cache_filename, 'w');
            if($fp){
                fwrite($fp, "<table>\n");
                $i = 0;
                foreach($html->find('div[class=gdtm] div') as $ele){
                    if($i++%2==0) fwrite($fp, '<tr>');
                    fwrite($fp, '<td>');
                    $style = $ele->style;
                    $style = preg_replace('/http(.*)jpg/', $img0_src, $style);
                    $href = $ele->find('a', 0)->href;
                    fwrite($fp, '<a href="'. $image_php. stringToHex($href). '" rel="external">'.
                         '<div style="'. $style. '"></div>'.
                         '</a>'. "\n");
                    fwrite($fp, '</td>');
                    if($i%2==0) fwrite($fp, '</tr>');
                }
                fwrite($fp, "</table>\n");
            }
            else{
                echo "cache failed";
                // when cache failed, load from DOM
                echo '<table>';
                $i = 0;
                foreach($html->find('div[class=gdtm] div') as $ele){
                    if($i++%2==0) echo '<tr>';
                    echo '<td>';
                    $style = $ele->style;
                    $style = preg_replace('/http(.*)jpg/', $img0_src, $style);
                    $href = $ele->find('a', 0)->href;
                    echo '<a href="', $image_php, stringToHex($href), '" rel="external">',
                         '<div style="', $style, '"></div>',
                         '</a>', "\n";
                    echo '</td>';
                    if($i%2==0) echo '</tr>';
                }
                echo '</table>';
            }
            fclose($fp);
        }

    }
    
    echo file_get_contents($cache_filename);
    
    echo '<a data-role="button" href="download.php?url=', $url, '"> Download </a><br >';
    echo $url, '<br>';
    echo $img0_src, '<br />', "\n";
    ?>
        <div data-role="footer" data-position="fixed">
            <?php
                print_prev_next($url, $p_id);
            ?>
        </div>
    </body>
</html>
