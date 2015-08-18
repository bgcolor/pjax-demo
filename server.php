<?php 
function is_pjax(){
    return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
}

// 若为pjax只输出更新的内容，若为直接请求，输出整个页面
if (is_pjax()) {
    echo 'pjax content from server.php uuid ',uniqid();
    
    if (!empty($_GET['a']) && !empty($_GET['b'])) {
        echo '<br>params: ';
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
    <a href="server.php">normal link</a>
    <a href="server.php?a=1&b=2">link with params(a=1&b=2)</a>
    <div id="container">
        direct from server.php
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
            titleSuffix: '', //标题后缀
            filter: function(){},
            callback: function(){}
        });
    });
    </script>
</body>
</html>
<?php 
} 
?>