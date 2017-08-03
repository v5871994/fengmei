var tiny = {};

tiny.linkBrowser = function(callback){
	var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>';
	var modalobj = util.dialog('请选择链接',["./index.php?c=site&a=entry&&do=cmnlink&m=we7_wmall&callback=selectTinyLinkComplete"],footer,{containerName:'link-container'});
	modalobj.modal({'keyboard': false});
	modalobj.find('.modal-body').css({'height':'300px','overflow-y':'auto' });
	modalobj.modal('show');

	window.selectTinyLinkComplete = function(link){
		if($.isFunction(callback)){
			callback(link);
			modalobj.modal('hide');
		}
	};
};

tiny.selectfan = function(callback) {
	require(['bootstrap'], function($){
		$('#select-fans-modal').remove();
		$(document.body).append($('#select-fans-containter').html());
		var $Modal = $('#select-fans-modal');
		$Modal.modal('show');
		$Modal.find('#keyword').on('keydown', function(e){
			if(e.keyCode == 13) {
				$Modal.find('#search').trigger('click');
				e.preventDefault();
				return;
			}
		});

		$Modal.find('#search').on('click', function(){
			var key = $.trim($Modal.find('#keyword').val());
			if(!key) {
				return false;
			}
			$.post("./index.php?c=site&a=entry&do=cmnfans&m=we7_wmall&op=list", {key: key}, function(data){
				var result = $.parseJSON(data);
				console.dir(result);
				if(result.message.message && result.message.message.length > 0) {
					$Modal.find('.content').data('attachment', result.message.message);
					var gettpl = $('#select-fans-data').html();
					laytpl(gettpl).render(result.message.message, function(html){
						$Modal.find('.content').html(html);
						$Modal.find('.content .btn-primary').off();
						$Modal.find('.content .btn-primary').on('click', function(){
							var fanid = $(this).data('fanid');
							var fan = result.message.data[fanid];
							if($.isFunction(callback)){
								callback(fan);
							}
							$Modal.modal('hide');
						});
					});
				} else {
					$Modal.find('.content #info').html('没有符合条件的粉丝');
				}
			});
		});
	});
}





