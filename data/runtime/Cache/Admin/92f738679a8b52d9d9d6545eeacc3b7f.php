<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh_CN" style="overflow: hidden;">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">
<meta charset="utf-8">
<title><?php echo L('ADMIN_CENTER');?></title>

<meta name="description" content="This is page-header (.page-header &gt; h1)">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="/_1back1/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
<link href="/_1back1/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
<link href="/_1back1/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css?page=index"  rel="stylesheet" type="text/css">
<!--[if IE 7]>
	<link rel="stylesheet" href="/_1back1/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
<![endif]-->
<link rel="stylesheet" href="/_1back1/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/simplebootadminindex.min.css?">
<link href="/_1back1/public/js/artDialog/skins/default.css" rel="stylesheet" />
<!--[if lte IE 8]>
	<link rel="stylesheet" href="/_1back1/public/simpleboot/css/simplebootadminindex-ie.css?" />
<![endif]-->
<style>
.navbar .nav_shortcuts .btn{margin-top: 5px;}
.macro-component-tabitem{width:101px;}

/*-----------------导航hack--------------------*/
.nav-list>li.open{position: relative;}
.nav-list>li.open .back {display: none;}
.nav-list>li.open .normal {display: inline-block !important;}
.nav-list>li.open a {padding-left: 7px;}
.nav-list>li .submenu>li>a {background: #fff;}
.nav-list>li .submenu>li a>[class*="fa-"]:first-child{left:20px;}
.nav-list>li ul.submenu ul.submenu>li a>[class*="fa-"]:first-child{left:30px;}
.list-inline.menu_nav>li{padding-right: 5px;padding-left: 0px;}
/*----------------导航hack--------------------*/
.toggle-menu{position: absolute;top: 45%;bottom: 0;width:15px;height:80px;line-height:80px;padding:0;display:block;}
.menu-launch #sidebar{width:189px;}
.menu-launch .toggle-menu{left:189px;}
.menu-launch .main-content{margin-left:190px;}
.menu-launch .fa-angle-left{display:inline;}
.menu-launch .fa-angle-right{display:none;}
.menu-frap #sidebar{width:0px;}
.menu-frap .toggle-menu{left:0px;}
.menu-frap .main-content{margin-left:0px;}
.menu-frap .fa-angle-left{display:none;}
.menu-frap .fa-angle-right{display:inline;}
</style>
<script>
//全局变量
var GV = {
	HOST:"<?php echo ($_SERVER['HTTP_HOST']); ?>",
    ROOT: "/_1back1/",
    WEB_ROOT: "/_1back1/",
    JS_ROOT: "public/js/"
};
</script>
<?php $submenus=$menus; ?>

<?php function getsubmenu($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li>
						<?php $menu_name=L($menu['lang']); $menu_name=$menu['lang']==$menu_name?$menu['name']:$menu_name; ?>
						<?php if(empty($menu['items'])){ ?>
							<a href="javascript:openapp('<?php echo ($menu["url"]); ?>','<?php echo ($menu["id"]); ?>','<?php echo ($menu_name); ?>',true);">
								<i class="fa fa-<?php echo ((isset($menu["icon"]) && ($menu["icon"] !== ""))?($menu["icon"]):'desktop'); ?>"></i>
								<span class="menu-text">
									<?php echo ($menu_name); ?>
								</span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-<?php echo ((isset($menu["icon"]) && ($menu["icon"] !== ""))?($menu["icon"]):'desktop'); ?> normal"></i>
								<span class="menu-text normal">
									<?php echo ($menu_name); ?>
								</span>
								<b class="arrow fa fa-angle-right normal"></b>
								<i class="fa fa-reply back"></i>
								<span class="menu-text back">返回</span>
								
							</a>
							
							<ul  class="submenu">
									<?php getsubmenu1($menu['items']) ?>
							</ul>	
						<?php } ?>
						
					</li>
					
				<?php } ?>
<?php } ?>

<?php function getsubmenu1($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li>
						<?php $menu_name=L($menu['lang']); $menu_name=$menu['lang']==$menu_name?$menu['name']:$menu_name; ?>
						<?php if(empty($menu['items'])){ ?>
							<a href="javascript:openapp('<?php echo ($menu["url"]); ?>','<?php echo ($menu["id"]); ?>','<?php echo ($menu_name); ?>',true);">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text">
									<?php echo ($menu_name); ?>
								</span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text">
									<?php echo ($menu_name); ?>
								</span>
								<b class="arrow fa fa-angle-right"></b>
							</a>
							<ul  class="submenu">
									<?php getsubmenu2($menu['items']) ?>
							</ul>	
						<?php } ?>
						
					</li>
					
				<?php } ?>
<?php } ?>

<?php function getsubmenu2($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li>
						<?php $menu_name=L($menu['lang']); $menu_name=$menu['lang']==$menu_name?$menu['name']:$menu_name; ?>
						
						<a href="javascript:openapp('<?php echo ($menu["url"]); ?>','<?php echo ($menu["id"]); ?>','<?php echo ($menu_name); ?>',true);">
							&nbsp;<i class="fa fa-angle-double-right"></i>
							<span class="menu-text">
								<?php echo ($menu_name); ?>
							</span>
						</a>
					</li>
					
				<?php } ?>
<?php } ?>


<?php if(APP_DEBUG): ?><style>
#think_page_trace_open{left: 0 !important;
right: initial !important;}			
</style><?php endif; ?>

</head>

<body style="min-width:900px;" screen_capture_injected="true">
	<div id="loading"><i class="loadingicon"></i><span><?php echo L('LOADING');?></span></div>
	<div id="right_tools_wrapper">
		<span id="right_tools_clearcache" title="清除缓存" onclick="javascript:openapp('<?php echo U('admin/setting/clearcache');?>','right_tool_clearcache','清除缓存');"><i class="fa fa-trash-o right_tool_icon"></i></span>
		<span id="refresh_wrapper" title="<?php echo L('REFRESH_CURRENT_PAGE');?>" ><i class="fa fa-refresh right_tool_icon"></i></span>
	</div>
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a href="<?php echo U('admin/index/index');?>" class="navbar-brand" style="color:#ffffff;font-size:20px;font-family: Telex, sans-serif;"> <small> 
					<?php echo L('ADMIN_CENTER');?>
				</small>
				</a>
				<div class="pull-left nav_shortcuts" >
					
					<ul class="list-inline menu_nav">
						<li>
							<a class="btn btn-small btn-warning" href="/_1back1/" title="<?php echo L('WEBSITE_HOME_PAGE');?>" target="_blank">
								<i class="fa fa-home"></i>
							</a>
						</li>
						<?php if(is_array($commend_menus)): $i = 0; $__LIST__ = $commend_menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
							<?php $bg_class = $key%4==0?'btn-success':($key%4==1?'btn-info':($key%4==2?'btn-danger':'btn-warning')) ?>
							<?php if(sp_auth_check(sp_get_current_admin_id(),$val['app'].'/'.$val['model'].'/'.$val['action'])): ?><a class="btn btn-small <?php echo ((isset($bg_class) && ($bg_class !== ""))?($bg_class):'btn-default'); ?>" href="javascript:openapp('<?php echo U($val['app'].'/'.$val['model'].'/'.$val['action'].'?'.$val['data']);?>','<?php echo ($val['id']); echo ($val['app']); ?>','<?php echo ($val['name']); ?>',true);" title="<?php echo ($val['name']); ?>">
								<i class="fa fa-<?php echo ((isset($val['icon']) && ($val['icon'] !== ""))?($val['icon']):'list'); ?>"></i>
							</a><?php endif; ?>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
						<li>
							<a class="btn btn-small btn-success" href="javascript:;" title="全屏显示" onclick="kaishi()">
								<i class="fa fa-expand"></i>
							</a>
						</li>
						<li>
							<a class="btn btn-small btn-warning" href="javascript:;" title="退出全屏" onclick="guanbi()">
								<i class="fa fa-compress"></i>
							</a>
						</li>
						<li>
							<?php if(APP_DEBUG && sp_auth_check(sp_get_current_admin_id(),'admin/menu/index')): ?><a class="btn btn-small btn-default" href="javascript:openapp('<?php echo U('admin/menu/index');?>','index_menu','<?php echo L('ADMIN_MENU_INDEX');?>');" title="<?php echo L('ADMIN_MENU_INDEX');?>">
								<i class="fa fa-list"></i>
							</a><?php endif; ?>
						</li>
					</ul>
					
				</div>
				<ul class="nav simplewind-nav pull-right">
					<li class="light-blue">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
    						<?php if($admin['avatar']): ?><img class="nav-user-photo" width="30" height="30" src="<?php echo sp_get_image_url($admin['avatar']);?>" alt="<?php echo ($admin["user_login"]); ?>">
							<?php else: ?>
								<img class="nav-user-photo" width="30" height="30" src="/_1back1/admin/themes/simplebootx/Public/assets/images/logo-18.png" alt="<?php echo ($admin["user_login"]); ?>"><?php endif; ?>
							<span class="user-info">
								<?php echo L('WELCOME_USER',array('username'=>empty($admin['user_nicename'])?$admin['user_login']:$admin['user_nicename']));?>
							</span>
							<i class="fa fa-caret-down"></i>
						</a>
						<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
							<?php if(sp_auth_check(sp_get_current_admin_id(),'admin/setting/site')): ?><li><a href="javascript:openapp('<?php echo U('setting/site');?>','index_site','<?php echo L('ADMIN_SETTING_SITE');?>');"><i class="fa fa-cog"></i> <?php echo L('ADMIN_SETTING_SITE');?></a></li><?php endif; ?>
							<?php if(sp_auth_check(sp_get_current_admin_id(),'admin/user/userinfo')): ?><li><a href="javascript:openapp('<?php echo U('user/userinfo');?>','index_userinfo','<?php echo L('ADMIN_USER_USERINFO');?>');"><i class="fa fa-user"></i> <?php echo L('ADMIN_USER_USERINFO');?></a></li><?php endif; ?>
							<?php if(sp_auth_check(sp_get_current_admin_id(),'admin/setting/password')): ?><li><a href="javascript:openapp('<?php echo U('setting/password');?>','index_password','<?php echo L('ADMIN_SETTING_PASSWORD');?>');"><i class="fa fa-lock"></i> <?php echo L('ADMIN_SETTING_PASSWORD');?></a></li><?php endif; ?>
							<li><a href="<?php echo U('Public/logout');?>"><i class="fa fa-sign-out"></i> <?php echo L('LOGOUT');?></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="main-container container-fluid left-menu <?php echo empty($menu_settings['is_menu_frap'])?'menu-launch':'menu-frap'; ?>">

		<div class="sidebar" id="sidebar">
			<!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">
			</div> -->
			<div id="nav_wraper">
			<ul class="nav nav-list">
				<?php echo getsubmenu($submenus);?>
			</ul>
			</div>
			
		</div>
		
		<a style="" href="javascript:;" class="btn btn-default toggle-menu">
			<i class="fa fa-angle-left"></i>
			<i class="fa fa-angle-right"></i>
		</a>
		
		<div class="main-content">
			<div class="breadcrumbs" id="breadcrumbs">
				<a id="task-pre" class="task-changebt">←</a>
				<div id="task-content">
				<ul class="macro-component-tab" id="task-content-inner">
					<li class="macro-component-tabitem noclose" app-id="0" app-url="<?php echo U('main/index');?>" app-name="首页">
						<span class="macro-tabs-item-text"><?php echo L('HOME');?></span>
					</li>
				</ul>
				<div style="clear:both;"></div>
				</div>
				<a id="task-next" class="task-changebt">→</a>
			</div>
			
			<div class="page-content" id="content">
				<iframe src="<?php echo U('Main/index');?>" name="firstContent" style="width:100%;height: 100%;" frameborder="0" id="appiframe-0" class="appiframe"></iframe>
			</div>
		</div>
	</div>
	
	<script src="/_1back1/public/js/jquery.js"></script>
	<script src="/_1back1/public/js/wind.js"></script>
	<script src="/_1back1/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
	<script src="/_1back1/public/js/20170905_luoxu_fullscreen.js"></script>
	<script>
		$(".toggle-menu").click(function(){
			var is_menu_frap = $(".left-menu").hasClass('menu-frap');
			if(is_menu_frap){
				$("#sidebar").animate({'width':"189px"});
				$(".toggle-menu").animate({'left':"189px"});
				$(".main-content").animate({'margin-left':"190px"});
				$(".left-menu").removeClass('menu-frap');
				$(".left-menu").addClass('menu-launch');
			}
			else{
				$("#sidebar").animate({'width':"0px"});
				$(".toggle-menu").animate({'left':"0px"});
				$(".main-content").animate({'margin-left':"0px"});
				$(".left-menu").removeClass('menu-launch');
				$(".left-menu").addClass('menu-frap');
			}
		})
	</script>
	<script>
	var ismenumin = $("#sidebar").hasClass("menu-min");
	$(".nav-list").on( "click",function(event) {
		var closest_a = $(event.target).closest("a");
		if (!closest_a || closest_a.length == 0) {
			return
		}
		if (!closest_a.hasClass("dropdown-toggle")) {
			if (ismenumin && "click" == "tap" && closest_a.get(0).parentNode.parentNode == this) {
				var closest_a_menu_text = closest_a.find(".menu-text").get(0);
				if (event.target != closest_a_menu_text && !$.contains(closest_a_menu_text, event.target)) {
					return false
				}
			}
			return
		}
		var closest_a_next = closest_a.next().get(0);
		if (!$(closest_a_next).is(":visible")) {
			var closest_ul = $(closest_a_next.parentNode).closest("ul");
			if (ismenumin && closest_ul.hasClass("nav-list")) {
				return
			}
			closest_ul.find("> .open > .submenu").each(function() {
						if (this != closest_a_next && !$(this.parentNode).hasClass("active")) {
							$(this).slideUp(150).parent().removeClass("open")
						}
			});
		}
		if (ismenumin && $(closest_a_next.parentNode.parentNode).hasClass("nav-list")) {
			return false;
		}
		$(closest_a_next).slideToggle(150).parent().toggleClass("open");
		return false;
	});
	</script>
	<script src="/_1back1/public/js/common.js"></script>
	<script src="/_1back1/admin/themes/simplebootx/Public/assets/js/index.js"></script>
</body>
</html>