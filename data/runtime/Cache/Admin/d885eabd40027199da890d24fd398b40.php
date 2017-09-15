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
<style>
li {
	list-style: none;
}
</style>
</head>
<body>
	<div class="wrap">
		<div id="error_tips">
			<h2><?php echo L('CACHE_CLEARED');?></h2>
			<div class="error_cont">
				<ul>
					<li><?php echo L('CACHE_CLEARED');?></li>
				</ul>
				<div class="error_return">
					<a href="javascript:close_app();" class="btn btn-default"><?php echo L('CLOSE');?></a>
				</div>
			</div>
		</div>
	</div>
	<script src="/_1back1/public/js/common.js"></script>
	<script>
		var close_timeout = setTimeout(function() {
			parent.close_current_app();
		}, 3000);

		function close_app() {
			clearTimeout(close_timeout);
			parent.close_current_app();
		}
	</script>
</body>
</html>