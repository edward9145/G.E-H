<?php
include_once 'simplehtmldom_1_5/simple_html_dom.php';

define ("CACHE_FOLDER", "temp/");
define ("PROXY_URL", "http://edw.ap01.aws.af.cm/proxy.php?url=");

function file_get_html_proxy($url){
    $html = file_get_html($url);
    if($html == null){
        $proxy = 'http://edw.ap01.aws.af.cm/proxy.php?url=';
        $html = file_get_html($proxy.$url);
    }
    return $html;
}

function image_url_list($url){
    $html = file_get_html_proxy($url);
    $i = 0;
    foreach($html->find('div[class=gdtm] div') as $ele){
        $style = $ele->style;
        $href = $ele->find('a', 0)->href;
        $list[$i++] = $href;
    }
    return $list;
}

function image_0_src_by_html($html){
    $divs = $html->find('div[class=gdtm] div');
    $style = $divs[0]->style;
    $pattern = '/http(.*)jpg/';
    preg_match($pattern, $style, $matches);
    return $matches[0];
}

function image_0_src($url){
    $html = file_get_html_proxy($url);
    return image_0_src_by_html($html);
}

function image_src($url){
    $html = file_get_html_proxy($url);
    $img = $html->find('img[id=img]', 0);
    return $img->src;
}

function check_cache($name){
    $filename = CACHE_FOLDER . $name. ".jpg";
    if(file_exists($filename)){
        return $filename;
    }
    return null;
}

function cache_image($name, $src){
    $filename = CACHE_FOLDER . $name. ".jpg";
    if(file_exists($filename)){
        return $filename;
    }

    @header('Content-type: image/jpg');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $src);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    file_put_contents($filename, $output);
    $size = filesize($filename);
    if($size != $info['size_download']){
        // $failed_file = "img/failed.jpg";
        echo 'cache failed...';
        return $src;
    }
    return $filename;
}

function show_image($filename){
    echo '<img src="', $filename , '" style="width:100%"/>';
}

function cache_gallery($id, $html){
    
}

function clear_cache($dir){
    $dh = opendir($dir);
    while($file = readdir($dh)){
        if($file!='.' && $file!='..'){
            $fullpath = $dir . '/' . $file;
            if(!is_dir($fullpath)){
                unlink($fullpath);
            }
        }
    }
}


?>
