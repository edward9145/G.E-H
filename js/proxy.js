$(document).ready(function(){
$("a").each(function(i, obj){
	obj.href = "proxy.php?url="+obj.href;
});

});
