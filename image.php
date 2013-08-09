<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
<!--        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<title></title>
        <link rel="stylesheet" href="css/themes/jquery.mobile-1.3.1.min.css"/>
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.mobile-1.3.1.min.js"></script>
    </head>
    <body>
    <?php
    include_once 'simplehtmldom_1_5/simple_html_dom.php';
    include_once 'func.php';
    
    $url = $_REQUEST['url'];
    
    $src = check_cache(basename($url));
    if($src != null){
        ;
    }
    else{
        $test = 'test/2.html';
        $src = image_src($url);
        $src = cache_image(basename($url), $src);
    }
    show_image($src);    
    
    echo '<a id="pc_site" href=', $url , "></a>";
    
    ?>
        <div data-role="footer" data-position="fixed" id="prev_next">
              
        </div>

            <script type="text/javascript">
            $(document).ready(function(){
                var url = $("a#pc_site").attr("href");
                $("div#prev_next").load("prevnext.php?url="+url, 
                    function(){
                        $("div#prev_next").trigger('create');   // important!
                    }
                );
            });
            </script>

    </body>
</html>
