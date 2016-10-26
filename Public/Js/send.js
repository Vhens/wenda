$(function () {
	$( '#sel-cate' ).click( function () {
		dialog($( '#category' ));
	} );

	$( 'textarea[name=content]' ).keyup( function () {
		var content = $( this ).val();
		//调用check函数取得当前字数
		var lengths = check(content);
		//最大允许输入50字个
		if (lengths[0] >= 50) {
			$( this ).val(content.substring(0, Math.ceil(lengths[1])));
		}
		var num = 50 - Math.ceil(lengths[0]);
		var msg = num < 0 ? 0 : num;
		//当前字数同步到显示提示
		$( '#num' ).html( msg );
	} );

	var opt = $( 'select[name=reward] option' );
	for (var i = 0; i < opt.length; i++) {
		if (opt.eq(i).val() > point) {
			opt.eq(i).attr('disabled', 'disabled');
		}
	}


	//选择分类
	var cateID = 0;
	$( 'select[name=cate-one]' ).change( function () {
		var obj = $( this );

		if (obj.index() < 3) {
			var pid = obj.val();
			$.getJSON(getCate, {pid : pid}, function (data) {
				if (data) {
					var option = '';
					$.each(data, function (i, k) {
						option += '<option value="' + k.id + '">' + k.name + '</option>';
					});
					obj.next().html(option).show();
				}
			}, 'json');
		}

		cateID = obj.val();
	} );

	$( '#ok' ).click( function () {
		if (!cateID) {
			alert('请选择一个分类');
			return;
		}
		$( 'input[name=cid]' ).val(cateID);
		$( '.close-window' ).click();
	} );

	$( '.send-btn' ).click( function () {
		var cons = $( 'textarea[name=content]' );
		if (cons.val() == '') {
			alert('请输入提问内容');
			cons.focus();
			return false;
		}

		if (!cateID) {
			alert('请选择一个分类');
			return false;
		}

		if (!on) {
			$( '.login' ).click();
			return false;
		}
	} );

});


/**
 * 统计字数
 * @param  字符串
 * @return 数组[当前字数, 最大字数]
 */
function check (str) {
	var num = [0, 50];
	for (var i=0; i<str.length; i++) {
		//字符串不是中文时
		if (str.charCodeAt(i) >= 0 && str.charCodeAt(i) <= 255){
			num[0] = num[0] + 0.5;//当前字数增加0.5个
			num[1] = num[1] + 0.5;//最大输入字数增加0.5个
		} else {//字符串是中文时
			num[0]++;//当前字数增加1个
		}
	}
	return num;
}