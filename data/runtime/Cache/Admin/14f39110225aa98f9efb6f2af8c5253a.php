<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/_1back1/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/_1back1/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/_1back1/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/_1back1/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		form .input-alias{margin-bottom: 0px;padding:3px;width:90px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
		.table-list .fa{font-size:20px;cursor:pointer;}
		.table-list .fa-check{color:#7bb33d;}
		.table-list .fa-close{color:#d41e24;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/_1back1/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/_1back1/",
	    WEB_ROOT: "/_1back1/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/_1back1/public/js/jquery.js"></script>
    <script src="/_1back1/public/js/wind.js"></script>
    <script src="/_1back1/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<body>
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<?php if(is_array($commend_menus)): $i = 0; $__LIST__ = array_slice($commend_menus,0,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="col-sm-3">
            	<?php $bg_class = $key%4==0?'btn-success':($key%4==1?'btn-info':($key%4==2?'btn-danger':'btn-warning')) ?>
            	<a href="javascript:top.openapp('<?php echo U($val['app'].'/'.$val['model'].'/'.$val['action'].'?'.$val['data']);?>','<?php echo ($val['id']); echo ($val['app']); ?>','<?php echo ($val['name']); ?>',true);" title="<?php echo ($val['name']); ?>">
                <div class="widget style1 <?php echo ((isset($bg_class) && ($bg_class !== ""))?($bg_class):'btn-default'); ?>">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-<?php echo ((isset($val['icon']) && ($val['icon'] !== ""))?($val['icon']):'list'); ?> fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <h2 class="font-bold"><?php echo ($val['name']); ?></h2>
                            <span>更多</span>
                        </div>
                    </div>
                </div>
				</a>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
		<div class="row">
			<div class="col-sm-6">
	        	<div class="panel panel-success">
			      <div class="panel-heading">
			        <h3 class="panel-title">未来一周气温变化</h3>
			      </div>
			      <div class="panel-body">
			        <div style="height:300px;">
						<table id="weather" class="table table-hover">
							<tr><td>正在加载中...</td></tr>
						</table>
					</div>
			      </div>
			    </div>
	        </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
			      <div class="panel-heading">
			        <h3 class="panel-title">某地区蒸发量和降水量</h3>
			      </div>
			      <div class="panel-body">
			        <div class="echarts" id="echarts-bar-chart" style="height:300px;">
			        	
			        </div>
			      </div>
			    </div>
            </div>
	    </div>
	</div>
	<script src="/_1back1/public/js/common.js"></script>
    <script src="/_1back1/public/js/echarts/echarts.min.js"></script>
	<script>
	var t = echarts.init(document.getElementById("echarts-bar-chart")), n = {
        title: {
            text: "某蒸发量和降水量"
        },
        tooltip: {
            trigger: "axis"
        },
        legend: {
            data: ["蒸发量", "降水量"]
        },
        grid: {
            x: 30,
            x2: 40,
            y2: 24
        },
        calculable: !0,
        xAxis: [{
            type: "category",
            data: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
        }],
        yAxis: [{
            type: "value"
        }],
        series: [{
            name: "蒸发量",
            type: "bar",
            data: [2, 4.9, 7, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20, 6.4, 3.3],
            markPoint: {
                data: [{
                    type: "max",
                    name: "最大值"
                }, {
                    type: "min",
                    name: "最小值"
                }]
            },
            markLine: {
                data: [{
                    type: "average",
                    name: "平均值"
                }]
            }
        }, {
            name: "降水量",
            type: "bar",
            data: [2.6, 5.9, 9, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6, 2.3],
            markPoint: {
                data: [{
                    name: "年最高",
                    value: 182.2,
                    xAxis: 7,
                    yAxis: 183,
                    symbolSize: 18
                }, {
                    name: "年最低",
                    value: 2.3,
                    xAxis: 11,
                    yAxis: 3
                }]
            },
            markLine: {
                data: [{
                    type: "average",
                    name: "平均值"
                }]
            }
        }]
    };
    t.setOption(n), window.onresize = t.resize;
	</script>
	<script type="text/javascript">
		function loadweather(){
			var $table = $('#weather');
			var loading = '<thead><tr><th><span class="loding-text">正在加载中</span><span class="loading-process">.</span></th></tr></thead>';
			$table.html(loading);
			var weather_interval = window.setInterval(function(){
				$process = $table.find('.loading-process');
				$count = $process.text().length;
				$target = ($count+1) %10;
				$target_process = [];
				for(i=0;i<=$target; i++){
					$target_process.push('.');
				}
				$process.text($target_process.join(''));
			},150);
			$.ajax({
					url: '<?php echo U("Main/getList");?>',
					success:function(data){
	
						if(data){
							var html = [];
							html.push("<thead><tr><th colspan='5'>" + data.data.city + "</th></tr></thead>");
							for(var i = 0;i < data.data.showday;i++)
							{
								html.push("<tbody><tr><td>" + data.data.date[i]+ "</td>");
								html.push("<td><img src = " + data.data.pictureUrl[i] + "></td>");
								html.push("<td>" + data.data.temperature[i] + "</td>");
								html.push("<td>" + data.data.wind[i] +"</td>");
								html.push("<td>" + data.data.weather[i] + "</td></tr></tbody>");
							}
	
							html = html.join('');
							$table.html(html);
						}else{
							$table.html('<tr><td>'+ data.info +'</td></tr>')
						}
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						$table.html('<tr><td>更新失败</td></tr>')
					},
					complete:function(XMLHttpRequest, textStatus){
						window.clearInterval(weather_interval);
					}
				}
			);
		}
		$(function(){
			loadweather();// 首次加载 自动ajax一次获取内容
			$('#weather').parents('.bd').prev().find('.wm-refresh').click(function(){
				loadweather();
			});
		})
	</script>
</body>
</html>