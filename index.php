<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
<!--        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<title>E-H Gallery</title>
        
        <link rel="stylesheet" href="css/themes/jquery.mobile-1.3.1.min.css"/>

	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery.mobile-1.3.1.min.js"></script>
        
        <script type="text/javascript">
        
        function do_search(){
            var search = $("input:text");
            var filters = $("input:checkbox");
            var args = [];
            for(i=0; i<filters.length; i++) 
                args[i] = filters[i].name + "=" + (filters[i].checked?1:0);
            args[i] = search[0].name + "=" + search[0].value;
            args[i+1] = "f_apply=Apply+Filter";
            var request = args.join("&");
            
            var url = "index.php?url=" + escape("http://g.e-hentai.org/?" + request);
            location.href = url;
        }
        
        function select_all(){
            var filters = $("input:checkbox");
            for(i=0; i<filters.length; i++) 
                filters[i].checked = true;
            $("input:checkbox").checkboxradio('refresh');
        }

        function reverse_select(){
            var filters = $("input:checkbox");
            for(i=0; i<filters.length; i++) 
                filters[i].checked = !filters[i].checked;
            $("input:checkbox").checkboxradio('refresh');
        }

        $(document).ready(function(){
            $("form").submit(function(e){
                e.preventDefault();
            });
        });
        </script>
        
    </head>
    <body>
        <?php
        include_once 'simplehtmldom_1_5/simple_html_dom.php';
        include_once 'func.php';

        $url = GEH_URL;
        if($_REQUEST['url']) $url = $_REQUEST['url'];
        ?>
        
<!--        <div data-role="page" >-->
            <div data-role="header" data-position="fixed" data-theme="c">
                <table>
                    <tr>  
                <td><input type="button" name="f_apply" value="Search" data-icon="search" data-inline="true" onclick="do_search();"></td>
                <td><input type="text" name="f_search" id="f_search"></td>
                    </tr>
                </table>
                
                <div data-role="collapsible" data-inset="false" data-theme="c" data-content-theme="d" data-mini="true">
                    <h4>Search Filters</h4>
                    <div data-role="navbar">
                        <ul>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_doujinshi" >DOUJINSHI</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_manga" >MANGA</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_artistcg" >ARTIST CG</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_gamecg" >GAME CG</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_western" >WESTERN</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_non-h" >NON-H</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_imageset" >IMAGE SET</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_cosplay" >COSPLAY</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_asianporn" >ASIAN</label></li>
                        <li><label data-corners="false"><input data-mini="true" type="checkbox" name="f_misc" >MISC</label></li>
                        <li><input type="button" value="Select All" onclick="select_all();"></li>
                        <li><input type="button" value="Reverse Select" onclick="reverse_select();"></li>
                        </ul>
                    </div>
                </div>
            </div>
	
<!--            <div data-role="fieldcontain">
                <label for="f_search">
                    <input type="button" name="f_apply" value="Search" data-icon="search" data-mini="true" data-inline="true" onclick="do_search();">
                </label>
                <input type="text" name="f_search" id="f_search">
            </div>-->
        <div data-role="content" >    
    <?php
    
    $test = 'test/geh.html';
    $html = file_get_html_proxy($url);
    
    $gallery_php = 'gallery.php?url=';

    foreach($html->find('div.it2') as $ele){
        $arc = $ele->next_sibling();
        $arc = $arc->next_sibling();
        $arc = $arc->children(0);
        $href = $arc->href;
        $title = $arc->plaintext;

        echo "\n", '<a href="', $gallery_php, $href ,'" target="_blank">', $title , '</a>';
        echo '<div>';
        
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
        echo '</div>';
        echo '<br />', "\n";
    }

//    print_pages($url);
    echo '<a data-role="button" href="', $url,'">PC Site</a>';
    ?>
        </div>

        <div data-role="footer" data-position="fixed">
            <?php
                print_pages($url);
            ?>
        </div>
	            
<!--        </div>-->
    </body>
</html>
