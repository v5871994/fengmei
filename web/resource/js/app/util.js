(function(window) {
	var util = {};
	util.tomedia = function(src, forcelocal){
		if(src.indexOf('http://') == 0 || src.indexOf('https://') == 0 || src.indexOf('./resource') == 0) {
			return src;
		} else if(src.indexOf('./addons') == 0) {
			var url=window.document.location.href; 
			var pathName = window.document.location.pathname; 
			var pos = url.indexOf(pathName); 
			var host = url.substring(0,pos);
			if (src.substr(0,1)=='.') {
				src=src.substr(1);
			}
			return host + src;
		} else {
			if(!forcelocal) {
				return window.sysinfo.attachurl + src;
			} else {
				return window.sysinfo.attachurl_local + src;
			}
		}
	};
	util.clip = function(elm, str) {
		if(elm.clip) {
			return;
		}
		require(['jquery.zclip'], function(){
			$(elm).zclip({
				path: './resource/components/zclip/ZeroClipboard.swf',
				copy: str,
				afterCopy: function(){
					var obj = $('<em> &nbsp; <span class="label label-success"><i class="fa fa-check-circle"></i> 澶嶅埗鎴愬姛</span></em>');
					var enext = $(elm).next().html();
					if (!enext || enext.indexOf('&nbsp; <span class="label label-success"><i class="fa fa-check-circle"></i> 澶嶅埗鎴愬姛</span>')<0) {
						$(elm).after(obj);
					}
					setTimeout(function(){
						obj.remove();
					}, 2000);
				}
			});
			elm.clip = true;
		});
	};
	
	util.colorpicker = function(elm, callback) {
		require(['colorpicker'], function(){
			$(elm).spectrum({
				className : "colorpicker",
				showInput: true,
				showInitial: true,
				showPalette: true,
				maxPaletteSize: 10,
				preferredFormat: "hex",
				change: function(color) {
					if($.isFunction(callback)) {
						callback(color);
					}
				},
				palette: [
					["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", "rgb(153, 153, 153)","rgb(183, 183, 183)",
					"rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(239, 239, 239)", "rgb(243, 243, 243)", "rgb(255, 255, 255)"],
					["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
					"rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
					["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
					"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
					"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
					"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
					"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
					"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
					"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
					"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
					"rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
					"rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",
					"rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
					"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
				]
			});
		});
	}
	
	util.uploadMultiPictures = function(callback, options){
		
		var opts = {
			type :'image',
			tabs : {
				'upload' : 'active',
				'browser' : '',
				'crawler' : ''
			},
			path : '',
			direct : false,
			multi : true,
			dest_dir : ''
		};
		
		opts = $.extend({}, opts, options);
		
		require(['jquery', 'fileUploader'], function($, fileUploader){
			fileUploader.show(function(images){
				if(images.length > 0){
					for (i in images) {
						images[i].filename = images[i].attachment;
					}
					if($.isFunction(callback)){
						callback(images);
					}
				}
			}, opts);
		});
	}
	
	util.editor = function(elm, callback){
		if(elm==undefined){
			return;
		}
		var id = elm.id;
		if(!id) {
			id = 'editor-' + Math.random();
			elm.id = id;
		}
		if(!elm.editor) {
			require(['editor'], function(){
				var editor = tinyMCE.createEditor(id, {
					plugins: [
						"advlist autolink lists link image multiimage charmap print preview hr anchor pagebreak",
						"searchreplace wordcount visualblocks visualchars code fullscreen",
						"insertdatetime media nonbreaking save table contextmenu directionality",
						"emoticons template paste textcolor"
					],
					toolbar1: "undo redo | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview fullscreen",
					toolbar2: "code print | styleselect fontsizeselect link image multiimage media emoticons ",
					language: 'zh_CN',
					paste_webkit_styles: 'all',
					paste_preprocess: function(plugin, args) {
						args.content = args.content.replace(/!important/g, '');
					},
					fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
					menubar: false
				});
				elm.editor = editor;
				editor.render();
				if($.isFunction(callback)) {
					callback(elm, editor);
				}
			});
		}
		return {
			getContent : function(){
				if(elm.editor) {
					return elm.editor.getContent();
				} else {
					return '';
				}
			}
		};
	};
	
	// target dom 瀵硅薄
	util.emotion = function(elm, target, callback) {
		require(['jquery.caret', 'bootstrap', 'css!../../components/emotions/emotions.css'],function($){
			$(function() {
				var emotions_html = '<table class="emotions" cellspacing="0" cellpadding="0"><tbody><tr><td><div class="eItem" style="background-position:0px 0;" data-title="寰瑧" data-code="::)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/0.gif"></div></td><td><div class="eItem" style="background-position:-24px 0;" data-title="鎾囧槾" data-code="::~" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/1.gif"></div></td><td><div class="eItem" style="background-position:-48px 0;" data-title="鑹�" data-code="::B" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/2.gif"></div></td><td><div class="eItem" style="background-position:-72px 0;" data-title="鍙戝憜" data-code="::|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/3.gif"></div></td><td><div class="eItem" style="background-position:-96px 0;" data-title="寰楁剰" data-code=":8-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/4.gif"></div></td><td><div class="eItem" style="background-position:-120px 0;" data-title="娴佹唱" data-code="::<" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/5.gif"></div></td><td><div class="eItem" style="background-position:-144px 0;" data-title="瀹崇緸" data-code="::$" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/6.gif"></div></td><td><div class="eItem" style="background-position:-168px 0;" data-title="闂槾" data-code="::X" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/7.gif"></div></td><td><div class="eItem" style="background-position:-192px 0;" data-title="鐫�" data-code="::Z" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/8.gif"></div></td><td><div class="eItem" style="background-position:-216px 0;" data-title="澶у摥" data-code="::\'(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/9.gif"></div></td><td><div class="eItem" style="background-position:-240px 0;" data-title="灏村艾" data-code="::-|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/10.gif"></div></td><td><div class="eItem" style="background-position:-264px 0;" data-title="鍙戞€�" data-code="::@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/11.gif"></div></td><td><div class="eItem" style="background-position:-288px 0;" data-title="璋冪毊" data-code="::P" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/12.gif"></div></td><td><div class="eItem" style="background-position:-312px 0;" data-title="鍛茬墮" data-code="::D" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/13.gif"></div></td><td><div class="eItem" style="background-position:-336px 0;" data-title="鎯婅" data-code="::O" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/14.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-360px 0;" data-title="闅捐繃" data-code="::(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/15.gif"></div></td><td><div class="eItem" style="background-position:-384px 0;" data-title="閰�" data-code="::+" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/16.gif"></div></td><td><div class="eItem" style="background-position:-408px 0;" data-title="鍐锋睏" data-code=":--b" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/17.gif"></div></td><td><div class="eItem" style="background-position:-432px 0;" data-title="鎶撶媯" data-code="::Q" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/18.gif"></div></td><td><div class="eItem" style="background-position:-456px 0;" data-title="鍚�" data-code="::T" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/19.gif"></div></td><td><div class="eItem" style="background-position:-480px 0;" data-title="鍋风瑧" data-code=":,@P" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/20.gif"></div></td><td><div class="eItem" style="background-position:-504px 0;" data-title="鍙埍" data-code=":,@-D" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/21.gif"></div></td><td><div class="eItem" style="background-position:-528px 0;" data-title="鐧界溂" data-code="::d" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/22.gif"></div></td><td><div class="eItem" style="background-position:-552px 0;" data-title="鍌叉參" data-code=":,@o" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/23.gif"></div></td><td><div class="eItem" style="background-position:-576px 0;" data-title="楗ラタ" data-code="::g" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/24.gif"></div></td><td><div class="eItem" style="background-position:-600px 0;" data-title="鍥�" data-code=":|-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/25.gif"></div></td><td><div class="eItem" style="background-position:-624px 0;" data-title="鎯婃亹" data-code="::!" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/26.gif"></div></td><td><div class="eItem" style="background-position:-648px 0;" data-title="娴佹睏" data-code="::L" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/27.gif"></div></td><td><div class="eItem" style="background-position:-672px 0;" data-title="鎲ㄧ瑧" data-code="::>" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/28.gif"></div></td><td><div class="eItem" style="background-position:-696px 0;" data-title="澶у叺" data-code="::,@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/29.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-720px 0;" data-title="濂嬫枟" data-code=":,@f" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/30.gif"></div></td><td><div class="eItem" style="background-position:-744px 0;" data-title="鍜掗獋" data-code="::-S" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/31.gif"></div></td><td><div class="eItem" style="background-position:-768px 0;" data-title="鐤戦棶" data-code=":?" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/32.gif"></div></td><td><div class="eItem" style="background-position:-792px 0;" data-title="鍢�" data-code=":,@x" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/33.gif"></div></td><td><div class="eItem" style="background-position:-816px 0;" data-title="鏅�" data-code=":,@@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/34.gif"></div></td><td><div class="eItem" style="background-position:-840px 0;" data-title="鎶樼（" data-code="::8" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/35.gif"></div></td><td><div class="eItem" style="background-position:-864px 0;" data-title="琛�" data-code=":,@!" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/36.gif"></div></td><td><div class="eItem" style="background-position:-888px 0;" data-title="楠烽珔" data-code=":!!!" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/37.gif"></div></td><td><div class="eItem" style="background-position:-912px 0;" data-title="鏁叉墦" data-code=":xx" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/38.gif"></div></td><td><div class="eItem" style="background-position:-936px 0;" data-title="鍐嶈" data-code=":bye" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/39.gif"></div></td><td><div class="eItem" style="background-position:-960px 0;" data-title="鎿︽睏" data-code=":wipe" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/40.gif"></div></td><td><div class="eItem" style="background-position:-984px 0;" data-title="鎶犻蓟" data-code=":dig" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/41.gif"></div></td><td><div class="eItem" style="background-position:-1008px 0;" data-title="榧撴帉" data-code=":handclap" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/42.gif"></div></td><td><div class="eItem" style="background-position:-1032px 0;" data-title="绯楀ぇ浜�" data-code=":&-(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/43.gif"></div></td><td><div class="eItem" style="background-position:-1056px 0;" data-title="鍧忕瑧" data-code=":B-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/44.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1080px 0;" data-title="宸﹀摷鍝�" data-code=":<@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/45.gif"></div></td><td><div class="eItem" style="background-position:-1104px 0;" data-title="鍙冲摷鍝�" data-code=":@>" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/46.gif"></div></td><td><div class="eItem" style="background-position:-1128px 0;" data-title="鍝堟瑺" data-code="::-O" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/47.gif"></div></td><td><div class="eItem" style="background-position:-1152px 0;" data-title="閯欒" data-code=":>-|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/48.gif"></div></td><td><div class="eItem" style="background-position:-1176px 0;" data-title="濮斿眻" data-code=":P-(" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/49.gif"></div></td><td><div class="eItem" style="background-position:-1200px 0;" data-title="蹇摥浜�" data-code="::\'|" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/50.gif"></div></td><td><div class="eItem" style="background-position:-1224px 0;" data-title="闃撮櫓" data-code=":X-)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/51.gif"></div></td><td><div class="eItem" style="background-position:-1248px 0;" data-title="浜蹭翰" data-code="::*" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/52.gif"></div></td><td><div class="eItem" style="background-position:-1272px 0;" data-title="鍚�" data-code=":@x" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/53.gif"></div></td><td><div class="eItem" style="background-position:-1296px 0;" data-title="鍙€�" data-code=":8*" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/54.gif"></div></td><td><div class="eItem" style="background-position:-1320px 0;" data-title="鑿滃垁" data-code=":pd" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/55.gif"></div></td><td><div class="eItem" style="background-position:-1344px 0;" data-title="瑗跨摐" data-code=":<W>" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/56.gif"></div></td><td><div class="eItem" style="background-position:-1368px 0;" data-title="鍟ら厭" data-code=":beer" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/57.gif"></div></td><td><div class="eItem" style="background-position:-1392px 0;" data-title="绡悆" data-code=":basketb" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/58.gif"></div></td><td><div class="eItem" style="background-position:-1416px 0;" data-title="涔掍箵" data-code=":oo" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/59.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1440px 0;" data-title="鍜栧暋" data-code=":coffee" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/60.gif"></div></td><td><div class="eItem" style="background-position:-1464px 0;" data-title="楗�" data-code=":eat" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/61.gif"></div></td><td><div class="eItem" style="background-position:-1488px 0;" data-title="鐚ご" data-code=":pig" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/62.gif"></div></td><td><div class="eItem" style="background-position:-1512px 0;" data-title="鐜懓" data-code=":rose" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/63.gif"></div></td><td><div class="eItem" style="background-position:-1536px 0;" data-title="鍑嬭阿" data-code=":fade" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/64.gif"></div></td><td><div class="eItem" style="background-position:-1560px 0;" data-title="绀虹埍" data-code=":showlove" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/65.gif"></div></td><td><div class="eItem" style="background-position:-1584px 0;" data-title="鐖卞績" data-code=":heart" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/66.gif"></div></td><td><div class="eItem" style="background-position:-1608px 0;" data-title="蹇冪" data-code=":break" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/67.gif"></div></td><td><div class="eItem" style="background-position:-1632px 0;" data-title="铔嬬硶" data-code=":cake" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/68.gif"></div></td><td><div class="eItem" style="background-position:-1656px 0;" data-title="闂數" data-code=":li" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/69.gif"></div></td><td><div class="eItem" style="background-position:-1680px 0;" data-title="鐐稿脊" data-code=":bome" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/70.gif"></div></td><td><div class="eItem" style="background-position:-1704px 0;" data-title="鍒€" data-code=":kn" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/71.gif"></div></td><td><div class="eItem" style="background-position:-1728px 0;" data-title="瓒崇悆" data-code=":footb" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/72.gif"></div></td><td><div class="eItem" style="background-position:-1752px 0;" data-title="鐡㈣櫕" data-code=":ladybug" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/73.gif"></div></td><td><div class="eItem" style="background-position:-1776px 0;" data-title="渚夸究" data-code=":shit" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/74.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1800px 0;" data-title="鏈堜寒" data-code=":moon" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/75.gif"></div></td><td><div class="eItem" style="background-position:-1824px 0;" data-title="澶槼" data-code=":sun" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/76.gif"></div></td><td><div class="eItem" style="background-position:-1848px 0;" data-title="绀肩墿" data-code=":gift" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/77.gif"></div></td><td><div class="eItem" style="background-position:-1872px 0;" data-title="鎷ユ姳" data-code=":hug" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/78.gif"></div></td><td><div class="eItem" style="background-position:-1896px 0;" data-title="寮�" data-code=":strong" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/79.gif"></div></td><td><div class="eItem" style="background-position:-1920px 0;" data-title="寮�" data-code=":weak" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/80.gif"></div></td><td><div class="eItem" style="background-position:-1944px 0;" data-title="鎻℃墜" data-code=":share" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/81.gif"></div></td><td><div class="eItem" style="background-position:-1968px 0;" data-title="鑳滃埄" data-code=":v" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/82.gif"></div></td><td><div class="eItem" style="background-position:-1992px 0;" data-title="鎶辨嫵" data-code=":@)" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/83.gif"></div></td><td><div class="eItem" style="background-position:-2016px 0;" data-title="鍕惧紩" data-code=":jj" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/84.gif"></div></td><td><div class="eItem" style="background-position:-2040px 0;" data-title="鎷冲ご" data-code=":@@" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/85.gif"></div></td><td><div class="eItem" style="background-position:-2064px 0;" data-title="宸姴" data-code=":bad" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/86.gif"></div></td><td><div class="eItem" style="background-position:-2088px 0;" data-title="鐖变綘" data-code=":lvu" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/87.gif"></div></td><td><div class="eItem" style="background-position:-2112px 0;" data-title="NO" data-code=":no" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/88.gif"></div></td><td><div class="eItem" style="background-position:-2136px 0;" data-title="OK" data-code=":ok" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/89.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-2160px 0;" data-title="鐖辨儏" data-code=":love" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/90.gif"></div></td><td><div class="eItem" style="background-position:-2184px 0;" data-title="椋炲惢" data-code=":<L>" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/91.gif"></div></td><td><div class="eItem" style="background-position:-2208px 0;" data-title="璺宠烦" data-code=":jump" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/92.gif"></div></td><td><div class="eItem" style="background-position:-2232px 0;" data-title="鍙戞姈" data-code=":shake" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/93.gif"></div></td><td><div class="eItem" style="background-position:-2256px 0;" data-title="鎬勭伀" data-code=":<O>" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/94.gif"></div></td><td><div class="eItem" style="background-position:-2280px 0;" data-title="杞湀" data-code=":circle" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/95.gif"></div></td><td><div class="eItem" style="background-position:-2304px 0;" data-title="纾曞ご" data-code=":kotow" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/96.gif"></div></td><td><div class="eItem" style="background-position:-2328px 0;" data-title="鍥炲ご" data-code=":turn" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/97.gif"></div></td><td><div class="eItem" style="background-position:-2352px 0;" data-title="璺崇怀" data-code=":skip" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/98.gif"></div></td><td><div class="eItem" style="background-position:-2376px 0;" data-title="鎸ユ墜" data-code=":oY" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/99.gif"></div></td><td><div class="eItem" style="background-position:-2400px 0;" data-title="婵€鍔�" data-code=":#-0" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/100.gif"></div></td><td><div class="eItem" style="background-position:-2424px 0;" data-title="琛楄垶" data-code=":hiphot" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/101.gif"></div></td><td><div class="eItem" style="background-position:-2448px 0;" data-title="鐚惢" data-code=":kiss" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/102.gif"></div></td><td><div class="eItem" style="background-position:-2472px 0;" data-title="宸﹀お鏋�" data-code=":<&" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/103.gif"></div></td><td><div class="eItem" style="background-position:-2496px 0;" data-title="鍙冲お鏋�" data-code=":&>" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/104.gif"></div></td></tr></tbody></table><div class="emotionsGif" style=""></div>';
				$(elm).popover({
					html: true,
					content: emotions_html,
					placement:"bottom"
				});
				$(elm).one('shown.bs.popover', function(){
					$(elm).next().mouseleave(function(){
						$(elm).popover('hide');
					});
					$(elm).next().delegate(".eItem", "mouseover", function(){
						var emo_img = '<img src="'+$(this).attr("data-gifurl")+'" alt="mo-'+$(this).attr("data-title")+'" />';
						var emo_txt = '/'+$(this).attr("data-code");
						$(elm).next().find(".emotionsGif").html(emo_img);
					});
					$(elm).next().delegate(".eItem", "click", function(){
						$(target).setCaret();
						var emo_txt = '/'+$(this).attr("data-code");
						$(target).insertAtCaret(emo_txt);
						$(elm).popover('hide');
						if($.isFunction(callback)) {
							callback(emo_txt, elm, target);
						}
					});
				});
			});
		});
	};

	util.loading = function() {
		var loadingid = 'modal-loading';
		var modalobj = $('#' + loadingid);
		if(modalobj.length == 0) {
			$(document.body).append('<div id="' + loadingid + '" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>');
			modalobj = $('#' + loadingid);
			html = 
				'<div class="modal-dialog">'+
				'	<div style="text-align:center; background-color: transparent;">'+
				'		<img style="width:48px; height:48px; margin-top:100px;" src="../attachment/images/global/loading.gif" title="姝ｅ湪鍔姏鍔犺浇...">'+
				'	</div>'+
				'</div>';
			modalobj.html(html);
		}
		modalobj.modal('show');
		modalobj.next().css('z-index', 999999);
		return modalobj;
	};
	
	util.loaded = function(){
		var loadingid = 'modal-loading';
		var modalobj = $('#' + loadingid);
		if(modalobj.length > 0){
			modalobj.modal('hide');
		}
	}
	
	util.dialog = function(title, content, footer, options) {
		if(!options) {
			options = {};
		}
		if(!options.containerName) {
			options.containerName = 'modal-message';
		}
		var modalobj = $('#' + options.containerName);
		if(modalobj.length == 0) {
			$(document.body).append('<div id="' + options.containerName + '" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>');
			modalobj = $('#' + options.containerName);
		}
		html = 
			'<div class="modal-dialog">'+
			'	<div class="modal-content">';
		if(title) {
			html +=
			'<div class="modal-header">'+
			'	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">脳</button>'+
			'	<h3>' + title + '</h3>'+
			'</div>';
		}
		if(content) {
			if(!$.isArray(content)) {
				html += '<div class="modal-body">'+ content + '</div>';
			} else {
				html += '<div class="modal-body">姝ｅ湪鍔犺浇涓�</div>';
			}
		}
		if(footer) {
			html +=
			'<div class="modal-footer">'+ footer + '</div>';
		}
		html += '	</div></div>';
		modalobj.html(html);
		if(content && $.isArray(content)) {
			var embed = function(c) {
				modalobj.find('.modal-body').html(c);
			};
			if(content.length == 2) {
				$.post(content[0], content[1]).success(embed);
			} else {
				$.get(content[0]).success(embed);
			}
		}
		return modalobj;
	};
	
	util.message = function(msg, redirect, type){
		if(!redirect && !type){
			type = 'info';
		}
		if($.inArray(type, ['success', 'error', 'info', 'warning']) == -1) {
			type = '';
		}
		if(type == '') {
			type = redirect == '' ? 'error' : 'success';
		}
		
		var icons = {
			success : 'check-circle',
			error :'times-circle',
			info : 'info-circle',
			warning : 'exclamation-triangle'
		};
		var p = '';
		if(redirect && redirect.length > 0){
			if(redirect == 'back'){
				p = '<p>[<a href="javascript:;" onclick="history.go(-1)">杩斿洖涓婁竴椤�</a>] &nbsp; [<a href="./?refresh">鍥為椤�</a>]</p>';
			}else{
				p = '<p><a href="' + redirect + '" target="main" data-dismiss="modal" aria-hidden="true">濡傛灉浣犵殑娴忚鍣ㄥ湪 <span id="timeout"></span> 绉掑悗娌℃湁鑷姩璺宠浆锛岃鐐瑰嚮姝ら摼鎺�</a></p>';
			}
		}
		var content = 
			'			<i class="pull-left fa fa-4x fa-'+icons[type]+'"></i>'+
			'			<div class="pull-left"><p>'+ msg +'</p>' +
			p +
			'			</div>'+
			'			<div class="clearfix"></div>';
		var footer = 
			'			<button type="button" class="btn btn-default" data-dismiss="modal">纭</button>';
		var modalobj = util.dialog('绯荤粺鎻愮ず', content, footer, {'containerName' : 'modal-message'});
		modalobj.find('.modal-content').addClass('alert alert-'+type);
		if(redirect) {
			var timer = '';
			timeout = 3;
			modalobj.find("#timeout").html(timeout);
			modalobj.on('show.bs.modal', function(){doredirect();});
			modalobj.on('hide.bs.modal', function(){timeout = 0;doredirect(); });
			modalobj.on('hidden.bs.modal', function(){modalobj.remove();});
			function doredirect() {
				timer = setTimeout(function(){
					if (timeout <= 0) {
						modalobj.modal('hide');
						clearTimeout(timer);
						window.location.href = redirect;
						return;
					} else {
						timeout--;
						modalobj.find("#timeout").html(timeout);
						doredirect();
					}
				}, 1000);
			}
		}
		modalobj.modal('show');
		return modalobj;
	};
	
	util.map = function(val, callback){
		require(['map'], function(BMap){
			if(!val) {
				val = {};
			}
			if(!val.lng) {
				val.lng = 116.403851;
			}
			if(!val.lat) {
				val.lat = 39.915177;
			}
			var point = new BMap.Point(val.lng, val.lat);
			var geo = new BMap.Geocoder();

			var modalobj = $('#map-dialog');
			if(modalobj.length == 0) {
				var content =
					'<div class="form-group">' +
						'<div class="input-group">' +
							'<input type="text" class="form-control" placeholder="璇疯緭鍏ュ湴鍧€鏉ョ洿鎺ユ煡鎵剧浉鍏充綅缃�">' +
							'<div class="input-group-btn">' +
								'<button class="btn btn-default"><i class="icon-search"></i> 鎼滅储</button>' +
							'</div>' +
						'</div>' +
					'</div>' +
					'<div id="map-container" style="height:400px;"></div>';
				var footer =
					'<button type="button" class="btn btn-default" data-dismiss="modal">鍙栨秷</button>' +
					'<button type="button" class="btn btn-primary">纭</button>';
				modalobj = util.dialog('璇烽€夋嫨鍦扮偣', content, footer, {containerName : 'map-dialog'});
				modalobj.find('.modal-dialog').css('width', '80%');
				modalobj.modal({'keyboard': false});
				
				map = util.map.instance = new BMap.Map('map-container');
				map.centerAndZoom(point, 12);
				map.enableScrollWheelZoom();
				map.enableDragging();
				map.enableContinuousZoom();
				map.addControl(new BMap.NavigationControl());
				map.addControl(new BMap.OverviewMapControl());
				marker = util.map.marker = new BMap.Marker(point);
				marker.setLabel(new BMap.Label('璇锋偍绉诲姩姝ゆ爣璁帮紝閫夋嫨鎮ㄧ殑鍧愭爣锛�', {'offset': new BMap.Size(10,-20)}));
				map.addOverlay(marker);
				marker.enableDragging();
				marker.addEventListener('dragend', function(e){
					var point = marker.getPosition();
					geo.getLocation(point, function(address){
						modalobj.find('.input-group :text').val(address.address);
					});
				});
				function searchAddress(address) {
					geo.getPoint(address, function(point){
						map.panTo(point);
						marker.setPosition(point);
						marker.setAnimation(BMAP_ANIMATION_BOUNCE);
						setTimeout(function(){marker.setAnimation(null)}, 3600);
					});
				}
				modalobj.find('.input-group :text').keydown(function(e){
					if(e.keyCode == 13) {
						var kw = $(this).val();
						searchAddress(kw);
					}
				});
				modalobj.find('.input-group button').click(function(){
					var kw = $(this).parent().prev().val();
					searchAddress(kw);
				});
			}
			modalobj.off('shown.bs.modal');
			modalobj.on('shown.bs.modal', function(){
				marker.setPosition(point);
				map.panTo(marker.getPosition());
			});
			
			modalobj.find('button.btn-primary').off('click');
			modalobj.find('button.btn-primary').on('click', function(){
				if($.isFunction(callback)) {
					var point = util.map.marker.getPosition();
					geo.getLocation(point, function(address){
						var val = {lng: point.lng, lat: point.lat, label: address.address};
						callback(val);
					});
				}
				modalobj.modal('hide');
			});
			modalobj.modal('show');
		});
	}; // end of map
	
	util.iconBrowser = function(callback){
		var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">鍙栨秷</button>';
		var modalobj = util.dialog('璇烽€夋嫨鍥炬爣',['./index.php?c=utility&a=icon&callback=selectIconComplete'],footer,{containerName:'icon-container'});
		modalobj.modal({'keyboard': false});
		modalobj.find('.modal-dialog').css({'width':'70%'});
		modalobj.find('.modal-body').css({'height':'70%','overflow-y':'scroll'});
		modalobj.modal('show');

		window.selectIconComplete = function(ico){
			if($.isFunction(callback)){
				callback(ico);
				modalobj.modal('hide');
			}
		};
	}; // end of icon dialog
	
	util.emojiBrowser = function(callback){
		var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">鍙栨秷</button>';
		var modalobj = util.dialog('璇烽€夋嫨琛ㄦ儏',['./index.php?c=utility&a=emoji&callback=selectEmojiComplete'],footer,{containerName:'icon-container'});
		modalobj.modal({'keyboard': false});
		modalobj.find('.modal-dialog').css({'width':'70%'});
		modalobj.find('.modal-body').css({'height':'70%','overflow-y':'scroll'});
		modalobj.modal('show');

		window.selectEmojiComplete = function(emoji){
			if($.isFunction(callback)){
				callback(emoji);
				modalobj.modal('hide');
			}
		};
	}; // end of emoji dialog
	
	util.linkBrowser = function(callback){
		var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">鍙栨秷</button>';
		var modalobj = util.dialog('璇烽€夋嫨閾炬帴',['./index.php?c=utility&a=link&callback=selectLinkComplete'],footer,{containerName:'link-container'});
		modalobj.modal({'keyboard': false});
		modalobj.find('.modal-body').css({'height':'300px','overflow-y':'auto' });
		modalobj.modal('show');
		
		window.selectLinkComplete = function(link){
			if($.isFunction(callback)){
				callback(link);
				modalobj.modal('hide');
			}
		};
	}; // end of icon dialog
	
	/**
	 * val : image 鍊�;
	 * callback: 鍥炶皟鍑芥暟
	 * base64options: base64(json($options))
	 * options: {tabs: {'browser': 'active', 'upload': '', 'remote': ''}
	 **/
	util.image = function(val, callback, base64options, options) {
		var opts = {
			type :'image',
			direct : false,
			multiple : false,
			path : val,
			dest_dir : '',
			global : false,
			thumb : false,
			width : 0
		};

		opts = $.extend({}, opts, options);
		opts.type = 'image';

		require(['jquery', 'fileUploader'], function($, fileUploader){
			fileUploader.show(function(images){
				if(images){
					if($.isFunction(callback)){
						callback(images);
					}
				}
			}, opts);
		});
	}; // end of image

	util.wechat_image = function(val, callback, options) {
		var opts = {
			type :'image',
			direct : false,
			multiple : false,
			acid : 0,
			path : val,
			dest_dir : ''
		};
		opts = $.extend({}, opts, options);
		require(['jquery', 'wechatFileUploader'], function($, wechatFileUploader){
			wechatFileUploader.show(function(images){
				if(images){
					if($.isFunction(callback)){
						callback(images);
					}
				}
			}, opts);
		});
	};

	util.audio = function(val, callback, base64options, options) {
		var opts = {
			type :'audio',
			direct : false,
			multiple : false,
			path : '',
			dest_dir : ''
		};
		if(val){
			opts.path = val;
		}
		
		opts = $.extend({}, opts, options);
		opts.type = 'audio';
		
		require(['jquery', 'fileUploader'], function($, fileUploader){
			fileUploader.show(function(audios){
				if(audios){
					if($.isFunction(callback)){
						callback(audios);
					}
				}
			}, opts);
		});
		
	}; // end of audio
	
	/*
		鎵撳紑杩滅▼鍦板潃
		@params string url 鐩爣杩滅▼鍦板潃
		@params string title 鎵撳紑绐楀彛鏍囬锛屼负绌哄垯涓嶆樉绀烘爣棰樸€傚彲鍦ㄨ繑鍥炵殑HTML瀹氫箟<button type="button" class="close" data-dismiss="modal" aria-hidden="true">脳</button>鎺у埗鍏抽棴
		@params object options 鎵撳紑绐楀彛鐨勫睘鎬ч厤缃紝鍙€夐」backdrop,show,keyboard,remote,width,height銆傚叿浣撳弬鑰僢ootcss妯℃€佸璇濇鐨刼ptions璇存槑
		@params object events 绐楀彛鐨勪竴浜涘洖璋冧簨浠讹紝鍙€夐」show,shown,hide,hidden,confirm銆傚洖璋冨嚱鏁扮涓€涓弬鏁板璇濇JQ瀵硅薄銆傚叿浣撳弬鑰僢ootcss妯℃€佸璇濇鐨刼n璇存槑.

		@demo ajaxshow('url', 'title', {'show' : true}, {'hidden' : function(obj) {obj.remove();}});
	*/
	util.ajaxshow = function(url, title, options, events) {

		var defaultoptions = {'show' : true};
		var defaultevents = {};
		var option = $.extend({}, defaultoptions, options);
		var events = $.extend({}, defaultevents, events);

		var footer = (typeof events['confirm'] == 'function' ? '<a href="#" class="btn btn-primary confirm">纭畾</a>' : '') + '<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">鍏抽棴</a><iframe id="_formtarget" style="display:none;" name="_formtarget"></iframe>';
		var modalobj = util.dialog(title, '姝ｅ湪鍔犺浇涓�', footer, {'containerName' : 'modal-panel-ajax'});

		if (typeof option['width'] != 'undeinfed' && option['width'] > 0) {
			modalobj.find('.modal-dialog').css({'width' : option['width']});
		}

		if (events) {
			for (i in events) {
				if (typeof events[i] == 'function') {
					modalobj.on(i, events[i]);
				}
			}
		}
		modalobj.find('.modal-body').load(url, function(){
			$('form.ajaxfrom').each(function(){
				$(this).attr('action', $(this).attr('action') + '&isajax=1&target=formtarget');
				$(this).attr('target', '_formtarget');
			})
		});
		modalobj.on('hidden.bs.modal', function(){modalobj.remove();});
		if (typeof events['confirm'] == 'function') {
			modalobj.find('.confirm', modalobj).on('click', events['confirm']);
		}
		return modalobj.modal(option);
	}; //end of ajaxshow

	util.cookie = {
		'prefix' : '',
		// 淇濆瓨 Cookie
		'set' : function(name, value, seconds) {
			expires = new Date();
			expires.setTime(expires.getTime() + (1000 * seconds));
			document.cookie = this.name(name) + "=" + escape(value) + "; expires=" + expires.toGMTString() + "; path=/";
		},
		// 鑾峰彇 Cookie
		'get' : function(name) {
			cookie_name = this.name(name) + "=";
			cookie_length = document.cookie.length;
			cookie_begin = 0;
			while (cookie_begin < cookie_length)
			{
				value_begin = cookie_begin + cookie_name.length;
				if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
				{
					var value_end = document.cookie.indexOf ( ";", value_begin);
					if (value_end == -1)
					{
						value_end = cookie_length;
					}
					return unescape(document.cookie.substring(value_begin, value_end));
				}
				cookie_begin = document.cookie.indexOf ( " ", cookie_begin) + 1;
				if (cookie_begin == 0)
				{
					break;
				}
			}
			return null;
		},
		// 娓呴櫎 Cookie
		'del' : function(name) {
			var expireNow = new Date();
			document.cookie = this.name(name) + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT" + "; path=/";
		},
		'name' : function(name) {
			return this.prefix + name;
		}
	};//end cookie

	util.wechat_audio = function(val, callback, options) {
		var opts = {
			type :'voice',
			direct : false,
			multiple : false,
			path : '',
			dest_dir : ''
		};
		if(val){
			opts.path = val;
		}
		opts = $.extend({}, opts, options);
		require(['jquery', 'wechatFileUploader'], function($, wechatFileUploader){
			wechatFileUploader.show(function(audios){
				if(audios){
					if($.isFunction(callback)){
						callback(audios);
					}
				}
			}, opts);
		});
	};
	if (typeof define === "function" && define.amd) {
		define(['bootstrap'], function(){
			return util;
		});
	} else {
		window.util = util;
	}
})(window);