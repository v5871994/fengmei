var mu = {};

mu.confirm = function(obj, option, callback_confirm, callback_cancel) {
	if(typeof option == 'string'){
		option = {tips : option};
	}
	option = $.extend({tips:'确认删除?', placement:'left'}, option);
	obj.popover({
		'html':true,
		'placement': option.placement,
		'trigger': 'manual',
		'title': '',
		'content':'<span> '+ option.tips +' </span> <a class="btn btn-primary confirm">确定</a> <a class="btn btn-default cancel">取消</a>'
	});
	obj.popover('show');
	var confirm = obj.next().find('a.confirm');
	var cancel = obj.next().find('a.cancel');
	cancel.off('click').on('click', function(){
		obj.popover('hide');
		obj.next().remove();
		if(typeof callback_cancel == 'function') {
			callback_cancel();
		}
	});
	confirm.off('click').on('click', function(){
		obj.popover('hide');
		obj.next().remove();
		if(typeof callback_confirm == 'function') {
			callback_confirm();
		}
	});
	return false;
}

