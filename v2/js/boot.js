var bootState = function(game){
	
	this.init = function(){
		if(!game.device.desktop){//移动设备适应
			game.scale.scaleMode = Phaser.ScaleManager.EXACT_FIT;
		}
   		game.scale.pageAlignHorizontally = true;
	}

	this.preload = function(){
		//game.load.image('loading','assets/loading.gif');
        // 添加进度文字
        var progressText = game.add.text(game.world.centerX, game.world.centerY, '0%', {
            fontSize: '60px',
            fill: '#ffffff'
        });
        progressText.anchor.setTo(0.5, 0.5);
        // 监听加载完一个文件的事件
        game.load.onFileComplete.add(function(progress) {
            progressText.text = progress + '%';
        });
        // 监听加载完毕事件
        game.load.onLoadComplete.add(onLoad);
        // 最小展示时间，示例为3秒
        var deadLine = false;
        setTimeout(function() {
            deadLine = true;
        }, 3000);
        // 加载完毕回调方法
        function onLoad() {
            if (deadLine) {
                // 已到达最小展示时间，可以进入下一个场景
                game.state.start('created');
            } else {
                // 还没有到最小展示时间，1秒后重试
                setTimeout(onLoad, 1000);
            }
        }
	};
	
	this.create = function(){
		game.state.start('loader'); //启动资源加载场景
	};
}