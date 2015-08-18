<?php 
function is_pjax(){
    return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
}

header("Content-Type: text/html; charset=utf-8");

// 若为pjax只输出更新的内容，若为直接请求，输出整个页面
if (is_pjax()) {
    echo '来自server.php的pjax返回 uuid: ',uniqid();
    
    if (!empty($_GET['a']) && !empty($_GET['b'])) {
        echo '<br>参数: ';
        echo 'a=',$_GET['a'],'b=',$_GET['b'];
    }
    
    exit;
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pjax Test</title>
</head>
<body>
    <a href="server.php">普通链接</a>
    <a href="server.php?a=1&b=2">参数链接(a=1&b=2)</a>
    <a href="http://www.baidu.com">外链</a>
    <a href="avoid.php">阻止内部链接</a>
    <div id="container">
        直接请求server.php
    </div>
    <script src="jquery.js" type="text/javascript"></script>
    <script src="jquery.pjax.js" type="text/javascript"></script>
    <script>
    $(function(){
        $.pjax({
            selector: 'a',
            container: '#container', //内容替换的容器
            show: 'fade',  //展现的动画，支持默认和fade, 可以自定义动画方式，这里为自定义的function即可。
            cache: false,  //是否使用缓存
            storage: true,  //是否使用本地存储
            titleSuffix: '来自pjax', //标题后缀
            filter: function(href){
                if(href.indexOf('avoid') != -1){
                    return true;
                }
            },
            callback: function(){}
        });
    });
    </script>
</body>
</html>
<?php 
} 
?>