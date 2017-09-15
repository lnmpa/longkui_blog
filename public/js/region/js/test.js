(function($){
	
	var defaults = {
		name:'插件',
		version:"1.0"
	}
	
	var showName = function(obj,name){
		$(obj).html(function(){
			return name;
		});
	}
	
	$.fn.region = function(options){
		var options = $.fn.extend(defaults,options);
		return this.each(function(){
			showName(this,options.name);
		})
	}
	
})(jQuery)
