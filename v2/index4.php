<?php

//Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
//$redis->delete('mylist');die();

$arrs = $redis->LRANGE("mylist",0 , -1);

if(!in_array($_SERVER['REMOTE_ADDR'] , $arrs)){
    $redis->rpush("mylist",$_SERVER['REMOTE_ADDR']);
    $arrs = $redis->LRANGE("mylist",0 , -1);
}
$arrs = array_flip($arrs);

var_dump($arrs);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://cdn.bootcss.com/phaser/2.6.2/phaser.min.js"></script>

    <script src="/src/static/js/jquery.js"></script>
    <script src="/src/static/js/jquery.json.js"></script>
    <script src="/src/static/js/console.js"></script>
    <script src="/src/config.js" charset="utf-8"></script>
    <script src="/src/static/js/comet.js" charset="utf-8"></script>
    <script src="/src/static/js/chat.js" charset="utf-8"></script>
    <script type="text/javascript" src="/src/static/js/swfupload.js"></script>
    <script type="text/javascript" src="/src/static/js/swfupload.queue.js"></script>
    <script type="text/javascript" src="/src/static/js/fileprogress.js"></script>
    <script type="text/javascript" src="/src/static/js/handlers.js"></script>

    <script type="text/javascript">
        //$.facebox.settings.closeImage = 'http://www.swoole.com/static//images/closelabel.png';
        //$.facebox.settings.loadingImage = 'http://www.swoole.com/static/images/loading.gif';
//        $(document).ready(function($){
//            $('a[rel=facebox]').facebox();
//        });
        <?php
            $id = $arrs[$_SERVER['REMOTE_ADDR']];
            $name = $_SERVER['REMOTE_ADDR'];
            $user = json_decode('{"id":"'.$id.'","username":"'.$name.'","usertype":"0","nickname":"'.$name.'","realname":"","intro":"","sex":"","email":"","mobile":"","php_level":"0","skill":"","company":"","blog":"http:\/\/blog.sina.com.cn\/engowiththewind","birth_year":"0","work_year":"0","avatar":"http:\/\/tva4.sinaimg.cn\/crop.0.0.180.180.180\/753ee9b5jw1e8qgp5bmzyj2050050aa8.jpg","education":"","certificate":"","province":"\u5317\u4eac","city":"\u671d\u9633\u533a","active_days":"0","vip":"0","gold":"0","login_times":"0"}');
            $debug = true;
        ?>
        var user = <?=json_encode($user)?>;
        var debug = <?=$debug?>;
        var ip = "<?=$_SERVER['REMOTE_ADDR']?>";

        var arr = new Array();
        <?php
        foreach($arrs as $k=>$v){

            ?>
        arr['<?=$k?>'] = <?=$v?>;

        <?php
            }
        ?>
    </script>
    <link type="text/css" rel="stylesheet" href="http://www.swoole.com/static/css/facebox.css"/>


    <style>
        body {
            padding-top: 60px;
        }
    </style>
    <!-- <link href="/static/css/bootstrap-responsive.css" rel="stylesheet"> -->
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


</head>
<body>
<div id="phaser"></div>
</body>
<script>
    var game = new Phaser.Game(781, 261, Phaser.AUTO, '#phaser', { preload: preload, create: create, update: update ,over: over });

    function preload() {

//        game.load.image('lazur', 'assets/pics/thorn_lazur.png');
        game.load.spritesheet('mummy', 'assets/sprites/metalslug_mummy37x45.png', 37, 45, 18);
        game.load.image('lazur', 'assets/center.png');
        //game.load.spritesheet('mummy', 'assets/paobu.png', 140, 153, 4);

    }

    var back;
    var mummy;
    var anim;
    var loopText;

    function create() {

        back = game.add.image(0, 0, 'lazur');
        back.scale.set(1);
        back.smoothed = false;

        <?php
            $arr = [0,1,2,3];
            foreach($arr as $k=>$v){
            ?>
                mummy<?='_'.$v?> = game.add.sprite(0, <?=$k * 70?>, 'mummy', 5);
                mummy<?='_'.$v?>.scale.set(1);
                mummy<?='_'.$v?>.smoothed = false;
                anim<?='_'.$v?> = mummy<?='_'.$v?>.animations.add('run');
            <?php
            }
        ?>



        cursors = game.input.keyboard.createCursorKeys();
        game.input.keyboard.addKeyCapture([ Phaser.Keyboard.SPACEBAR ]);



//
//        anim.onStart.add(animationStarted, this);
//        anim.onLoop.add(animationLooped, this);
//        anim.onComplete.add(animationStopped, this);
//
//        anim.play(20, true);

    }

    function animationStarted(sprite, animation) {

        game.add.text(32, 32, 'Animation started', { fill: 'white' });

    }

    function animationLooped(sprite, animation) {

        if (animation.loopCount === 1)
        {
            loopText = game.add.text(32, 64, 'Animation looped', { fill: 'white' });
        }
        else
        {
            loopText.text = 'Animation looped x2';
            animation.loop = false;
        }

    }

    function animationStopped(sprite, animation) {

        game.add.text(32, 64+32, 'Animation stopped', { fill: 'white' });

    }

    function update(key) {
        if(typeof(key) == 'object'){
            key = "<?=$arrs[$_SERVER['REMOTE_ADDR']]?>";
        }else{
            key = arr[key];
            if(key === undefined){
                return false;
            }
        }

        var peple = 'mummy_' + key;
        var anim = 'anim_' + key;

        //alert(JSON.parse(peple));return false;

        game.physics.enable(window[peple]); // 加入物理运动
        window[peple].body.velocity.x = 0;
        window[peple].body.velocity.y = 0;
        if (game.input.keyboard.downDuration(Phaser.Keyboard.SPACEBAR))
        {
            window[peple].body.velocity.x = 300;
            //window[peple].body.velocity.x = 10;
            //anim.play(1, true)
            window[anim].loop = true;
            window[anim].next(1);
        }
        // 设置苹果与游戏边缘碰撞，
        window[peple].body.collideWorldBounds = true;
        window[peple].body.onWorldBounds = new Phaser.Signal();
        window[peple].body.onWorldBounds.add(function(apple, up, down, left, right) {
            if (right) {
                msg.cmd = 'message';
                msg.from = client_id;
                msg.to = $('#userlist').val();
                msg.channal = 0;
                msg.data = "<?=$_SERVER['REMOTE_ADDR'].'获得了胜利'?>";
                msg.type = 'text';
                ws.send($.toJSON(msg));
                game.state.add('over' , over);
                game.state.start('over', true, false, 1323);
            }
        });

    }

    var over = function(game){
        alert("<?=$_SERVER['REMOTE_ADDR'].'获得了胜利'?>");
    }

    function moves(id){
        if(id.indexOf("胜利") > 0 )
        {
            alert(id);
            return false;
        }
        var key = arr[id];
        var peple = 'mummy_' + key;
        var anim = 'anim_' + key;

        game.physics.enable(window[peple]); // 加入物理运动
        window[peple].x = window[peple].x + 16;
        //anim.play(1, true)
        window[anim].loop = true;
        window[anim].next(1);
    }
</script>
</html>
