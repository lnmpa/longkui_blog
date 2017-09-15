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
<link rel="stylesheet" href="/_1back1/public/js/zTree/css/metroStyle/metroStyle.css" type="text/css">
<script src="/_1back1/public/js/zTree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/_1back1/public/js/zTree/js/jquery.ztree.excheck.js"></script>
<script type="text/javascript" src="/_1back1/public/js/zTree/js/jquery.ztree.exedit.js"></script>
<script type="text/javascript">
	var setting = {
		edit: {
			enable: true,
			showRemoveBtn: false,
			showRenameBtn: false
		},
		view: {
			dblClickExpand: false
		},
		callback: {
			onRightClick: OnRightClick,
			beforeDrag: beforeDrag,
			beforeDrop: beforeDrop,
			onDrop: onDrop
		}
	};
	
	var zNodes = <?php echo ($treeData); ?>;
	
    function OnRightClick(event, treeId, treeNode){
        if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
            zTree.cancelSelectedNode();
            showRMenu("root", event.clientX, event.clientY);
        }
        else{
			if (treeNode && !treeNode.noR) {
                zTree.selectNode(treeNode);
                showRMenu("node", event.clientX, event.clientY);
            }
		}
    }
    
	function beforeDrag(treeId, treeNodes) {
		for (var i=0,l=treeNodes.length; i<l; i++) {
			if (treeNodes[i].drag === false) {
				return false;
			}
		}
		return true;
	}
	
	function beforeDrop(treeId, treeNodes, targetNode, moveType) {
		return targetNode ? targetNode.drop !== false : true;
	}
	
	function onDrop(event, treeId, treeNodes, targetNode, moveType){
		var pid = 0;
		if(treeNodes[0].getParentNode()){
			pid = treeNodes[0].getParentNode().cid;
		}
		$.post("<?php echo U('SheetCate/status');?>",{id:treeNodes[0].cid,type:"pid",value:pid},function(data){
			//console.log(data.info);
		})
		var nodes = zTree.transformToArray(zTree.getNodes());
		var idarr = [];
		for (var i = 0; i < nodes.length; i++){
			idarr[i] = nodes[i].cid;
		};
		$.post("<?php echo U('SheetCate/sort_order');?>",{listorders:idarr},function(data){
			//console.log(data.info);
		})
	}
	
    function showRMenu(type, x, y){
        $("#rMenu ul").show();
        if (type == "root") {
            $("#m_del").hide();
            $("#m_edit").hide();
            $("#m_field").hide();
        }
        else {
            $("#m_del").show();
            $("#m_edit").show();
            $("#m_field").show();
        }
        rMenu.css({
            "top": y + "px",
            "left": x + "px",
            "visibility": "visible"
        });
        
        $("body").bind("mousedown", onBodyMouseDown);
    }
    
    function hideRMenu(){
        if (rMenu) 
            rMenu.css({
                "visibility": "hidden"
            });
        $("body").unbind("mousedown", onBodyMouseDown);
    }
    
    function onBodyMouseDown(event){
        if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length > 0)) {
            rMenu.css({
                "visibility": "hidden"
            });
        }
    }
    
    function addTreeNode(){
        hideRMenu();
		nodes = zTree.getSelectedNodes(),
		treeNode = nodes[0];
		var content = '<label>表单名称：</label><input class="form-control" style="width:200px;" id="cate_name" type="text" value="新加表单" />';
		content += '<label>表单模版：</label><select class="form-control" style="width:200px;" id="tmpl"><option value="0">=请选择=</option><?php echo ($tmplSelect); ?></select>';
		Wind.use("artDialog",function(){
			art.dialog({
                title: "新加表单",
                icon: '',
		        lock: true,
		        fixed: true,
		        background:"#CCCCCC",
		        opacity:0,
                content: content,
                okVal: "确认",
                ok: function () {
					var cate_name = $("#cate_name").val();
					if(cate_name == '' || cate_name == null || typeof(cate_name) == 'undefind'){
						art.dialog({
                            content: "请填写表单名称",
                            icon: 'warning',
                            ok: function () {
                                return true;
                            }
                        });
						return false;
					}
					var tmpl = $("#tmpl").val();
					var pid = 0;
					if (treeNode) {
						pid = treeNode.cid;
			        }
					top.$loading.show();
					$.post("<?php echo U('SheetCate/add');?>",{name:cate_name,pid:pid,tmpl:tmpl},function(data){
						top.$loading.hide();
						var newNode = {
				            name: cate_name,
							cid:data.id,
							click:data.click,
							target:"<?php echo CONTROLLER_NAME;?>_iframe_content"
				        };
						if (treeNode) {
							newNode.checked = zTree.getSelectedNodes()[0].checked;
			            	zTree.addNodes(zTree.getSelectedNodes()[0], newNode);
				        }
				        else {
				            zTree.addNodes(null, newNode);
				        }
						art.dialog({
                            content: "添加成功",
                            icon: 'succeed',
                            ok: function () {
                                return true;
                            }
                        });
					})
					return true;
                },
                cancelVal: '取消',
                cancel: true
            });
		})
    }
    
	function editTreeNode(){
        hideRMenu();
		nodes = zTree.getSelectedNodes(),
		treeNode = nodes[0];
		var content = '<input class="form-control" style="width:200px;" id="cate_name" type="text" value="'+treeNode.name+'" />';
		Wind.use("artDialog",function(){
			art.dialog({
                title: "表单名称",
                icon: '',
		        lock: true,
		        fixed: true,
		        background:"#CCCCCC",
		        opacity:0,
                content: content,
                okVal: "确认",
                ok: function () {
					var cate_name = $("#cate_name").val();
					if(cate_name == '' || cate_name == null || typeof(cate_name) == 'undefind'){
						art.dialog({
                            content: "请填写表单名称",
                            icon: 'warning',
                            ok: function () {
                                return true;
                            }
                        });
						return false;
					}
					$.post("<?php echo U('SheetCate/status');?>",{id:treeNode.cid,type:"name",value:cate_name},function(data){
						treeNode.name = cate_name;
						zTree.updateNode(treeNode);
					})
                },
                cancelVal: '取消',
                cancel: true
            });
		})
    }
	
    function removeTreeNode(){
        hideRMenu();
        var nodes = zTree.getSelectedNodes();
		
		var msg = "将删除该表单以及它的所有子表单，是否删除？";
		Wind.use('artDialog', function () {
			art.dialog({
                title: false,
                icon: 'question',
                content: msg ? msg : '确定要删除吗？',
                okVal: "确定",
                ok: function () {
                    if (nodes && nodes.length > 0) {
			            zTree.removeNode(nodes[0]);
						$.post("<?php echo U('SheetCate/delete');?>",{id:nodes[0].cid},function(data){
							console.log(data.info);
						})
			        }
                },
                cancelVal: '取消',
                cancel: true
            });
		});
    }
	
	function editTreeNodeField(){
		hideRMenu();
        var nodes = zTree.getSelectedNodes();
		treeNode = nodes[0];
		var href = "<?php echo U('SheetCate/design');?>?id=" + treeNode.cid;
		Wind.use("artDialog","iframeTools",function(){
	        art.dialog.open(href, {
		        title: "设计表单",
		        id: "design",
		        width: '750px',
		        height: '500px',
		        lock: true,
		        fixed: true,
		        background:"#CCCCCC",
		        opacity:0,
		        ok: function(){
		            var iframewindow = this.iframe.contentWindow;
					var form = iframewindow.$(".form-horizontal");
					form.submit();
					return false;
		        },
		        cancel: true
		    });
	    });
		return false;
	}
	
    var zTree, rMenu;
    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTree = $.fn.zTree.getZTreeObj("treeDemo");
        rMenu = $("#rMenu");
		
		zTree.setting.edit.drag.isCopy = false;
		zTree.setting.edit.drag.isMove = true;
		zTree.setting.edit.drag.prev = true;
		zTree.setting.edit.drag.inner = true;
		zTree.setting.edit.drag.next = true;
    });
	
	function changeUrl(url){
		$('#content-iframe').attr('src',url);
	}
</script>
<style>
.main-iframe{min-height: 100%;padding: 0;margin-top: 0;margin-right: 0;margin-left: 220px;}
.cate-iframe{position:absolute;top:0;left:0;}
div#rMenu {position:absolute;visibility:hidden;top:0;background-color: #ffffff;text-align: left;}
</style>
</head>
<body>
<div class="cate-iframe" id="cate-iframe">
	<ul id="treeDemo" class="ztree" style="border:none;background:none;padding: 20px 20px 0px;"></ul>
</div>
<div id="rMenu">
	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
		<li id="m_add" onclick="addTreeNode();"><a href="#">增加表单</a></li>
		<li id="m_edit" onclick="editTreeNode();"><a href="#">修改表单名称</a></li>
		<li id="m_field" onclick="editTreeNodeField();"><a href="#">设计表单</a></li>
		<li id="m_format" onclick="formatTreeNodeField();"><a href="#">格式化表单</a></li>
		<li id="m_del" onclick="removeTreeNode();"><a href="#">删除表单</a></li>
	</ul>
</div>
<div class="main-iframe">
	<div class="page-iframe">
		<iframe src="<?php echo U('Sheet/index');?>" name="<?php echo CONTROLLER_NAME;?>_iframe_content" style="width:100%;height: 100%;" frameborder="0"  id="content-iframe" class="appiframe"></iframe>
	</div>
</div>
</body>
<script>
$(function(){
	$content=$("#content-iframe");
	$cate=$("#cate-iframe");
	var headerheight=4;
	$content.height($(window).height()-headerheight);
	$cate.height($(window).height()-headerheight);
	$(window).resize(function(){
		$content.height($(window).height()-headerheight);
		$cate.height($(window).height()-headerheight);
	});
})
</script>
</html>