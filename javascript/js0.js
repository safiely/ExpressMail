var isConOpen = false;
var isPayTypeAndShipTypeOpen = false;
var isInvoiceOpen = false;
var isRemarkOpen = false;

var ffAlertTxt = '您的输入含有非法字符，请检查！';
function checkSubmitError(bakValue, obj) {
	if (bakValue != null) {
		if (bakValue.indexOf('error_') == 0) {
			var newd = document.createElement("span");
			newd.name = 'errorInfo';
			newd.style.cssText = 'color:red;';
			if (bakValue.length > 6) {
				bakValue = bakValue.substr(6);
			} else {
				bakValue = '程序发生了未知错误，请再次尝试！';
			}
			newd.innerHTML = bakValue;
			obj.appendChild(newd);
			return false;
		}
		return true;
	}
	return true;
}
function clearSubmitError(obj) {
	if (obj.parentNode.childNodes.length > 0) {
		if (obj.parentNode.lastChild.name == 'errorInfo') {
			obj.parentNode.removeChild(obj.parentNode.lastChild);
		}
	}
}
function fapiao_1() {
	window.document.all.tr_pt.style.display = 'none';
	window.document.all.tr_zzs.style.display = 'none';
	window.document.all.ord_isreceipt.value = "0";
}

function fapiao_2() {
	window.document.all.tr_pt.style.display = '';
	window.document.all.tr_zzs.style.display = 'none';
	window.document.all.ord_isreceipt.value = "1";

}

function fapiao_3() {
	window.document.all.tr_pt.style.display = 'none';
	window.document.all.tr_zzs.style.display = '';
	window.document.all.ord_isreceipt.value = "2";
}

//检查收货人姓名
function check_addressName() {
	removeAlert('addressName_empty');
	removeAlert('addressName_ff');

	var pNode = g('ord_receiver').parentNode;
	if (isEmpty('ord_receiver')) {
		showAlert('�ջ���������Ϊ�գ�', pNode, 'addressName_empty');
		return false;
	}
	if (!is_forbid(g('ord_receiver').value)) {
		showAlert(ffAlertTxt, pNode, 'addressName_ff');
		return false;
	}
	return true;
}

//检查收货人地址ַ
function check_address() {
	removeAlert('address_empty');
	removeAlert('address_ff');

	var pNode = g('ord_address').parentNode;
	if (isEmpty('ord_address')) {
		showAlert('�ջ���ַ����Ϊ�գ�', pNode, 'address_empty');
		return false;
	}
	if (!is_forbid(g('ord_address').value)) {
		showAlert(ffAlertTxt, pNode, 'address_ff');
		return false;
	}
	return true;
}

//检查邮政编码
function check_postcode() {
	removeAlert('postcode_ff');
	if (g('ord_postcode').value != '') {
		var pNode = g('ord_postcode').parentNode;
		var myReg = /(^\s*)\d{6}(\s*$)/;
		if (!myReg.test(g('ord_postcode').value)) {
			showAlert('�ʱ��ʽ����ȷ', pNode, 'postcode_ff');
			return false;
		}
	}
	return true;
}

//检查联系电话
function check_phone() {
	removeAlert('phone_empty');
	removeAlert('phone_ff');

	var pNode = g('ord_phone').parentNode;
	if (isEmpty('ord_phone')) {
		showAlert('��ϵ�绰����Ϊ�գ�', pNode, 'phone_empty');
		return false;
	}
	var myReg = /((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/;
	if (!myReg.test(g('ord_phone').value)) {
		showAlert('��ϵ�绰��ʽ����ȷ', pNode, 'phone_ff');
		return false;
	}
	return true;
}
//检查手机号
function check_message() {
	removeAlert('message_ff');
	if (g('ord_telphone').value != '') {
		var pNode = g('ord_telphone').parentNode;
		var myReg = /(^\s*)(((\(\d{3}\))|(\d{3}\-))?13\d{9}|15[7689031542]\d{8})(\s*$)/;
		if (!myReg.test(g('ord_telphone').value)) {
			showAlert('�ֻ�Ÿ�ʽ����ȷ', pNode, 'message_ff');
			return false;
		}
	}
	return true;
}
//检查Email
function check_email() {
	var iSign = 'email';
	removeAlert(iSign + '_ff');
	if (g('ord_' + iSign).value != '') {
		var pNode = g('ord_' + iSign).parentNode;
		var myReg = /(^\s*)\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*(\s*$)/;
		if (!myReg.test(g('ord_' + iSign).value)) {
			showAlert('�����ʼ���ʽ����ȷ', pNode, iSign + '_ff');
			return false;
		}
	}
	return true;
}

//确认订单检查
function Order_sub_check() {
	var res = true;
	if (!check_addressName()) {
		res = false;
	}
	if (!check_address()) {
		res = false;
	}
	if (!check_postcode()) {
		res = false;
	}
	if (!check_phone()) {
		res = false;
	}
	if (!check_message()) {
		res = false;
	}
	if (!check_email()) {
		res = false;
	}

	if (!check_transport_area()) {
		res = false;
	}

	return res;
}
function Order_check() {
	document.getElementById("tr_transportfundshow").style.display = '';
	if (Order_sub_check()) {
		document.getElementById("bt_submit").click();
	}
}

//检查物流配送地区
function check_transport_area() {
	removeAlert('sel_transport_area_id_empty');
	removeAlert('sel_transport_area_ide_ff');

	var pNode = g('sel_transport_area_id').parentNode;
	if (g('sel_transport_area_id').value == '0') {
		showAlert('��ѡ���������͵���', pNode, 'sel_transport_area_id_empty');
		return false;
	}
	if (!is_forbid(g('sel_transport_area_id').value)) {
		showAlert(ffAlertTxt, pNode, 'sel_transport_area_id_ff');
		return false;
	}
	return true;
}

//用户注册检查Email
function check_email_userreg() {
	// var iSign='txtUserEmail';
	var iSign = 'txtUserName';
	removeAlert(iSign + '_ff');
	if (g(iSign).value != '') {
		var pNode = g(iSign).parentNode;
		var myReg = /(^\s*)\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*(\s*$)/;
		if (!myReg.test(g(iSign).value)) {
			showAlert('�����ʼ���ʽ����ȷ', pNode, iSign + '_ff');
			return false;
		}
	}
	return true;
}

function check_pwd1_userreg() {
	removeAlert('txtUserPwd_empty');
	removeAlert('txtUserPwd_ff');

	var pNode = g('txtUserPwd').parentNode;
	if (g('txtUserPwd').value.length < 6) {
		showAlert('������Ҫ���ڵ���6λ��', pNode, 'txtUserPwd_empty');
		return false;
	}
	if (!is_forbid(g('txtUserPwd').value)) {
		showAlert(ffAlertTxt, pNode, 'txtUserPwd_ff');
		return false;
	}
	return true;
}

function check_pwd2_userreg() {
	removeAlert('txtUserPwd_2_empty');
	removeAlert('txtUserPwd_2_ff');

	var pNode = g('txtUserPwd_2').parentNode;
	if (g('txtUserPwd').value != g('txtUserPwd_2').value) {
		showAlert('������������벻һ�£�', pNode, 'txtUserPwd_2_empty');
		return false;
	}
	if (!is_forbid(g('txtUserPwd_2').value)) {
		showAlert(ffAlertTxt, pNode, 'txtUserPwd_2_ff');
		return false;
	}
	return true;
}

function check_username_userreg() {
	removeAlert('txtUserName_empty');
	removeAlert('txtUserName_ff');

	var pNode = g('txtUserName').parentNode;
	if (g('txtUserName').value.length < 6) {
		showAlert('�����ʼ���Ҫ���ڵ���6λ��', pNode, 'txtUserName_empty');
		return false;
	}
	// if(!is_forbid(g('txtUserName').value)){showAlert(ffAlertTxt,pNode,'txtUserName_ff');return
	// false;}
	return true;
}

//确认订单检查
function userreg_sub_check() {
	var res = true;
	if (!check_email_userreg()) {
		res = false;
	}
	if (!check_pwd1_userreg()) {
		res = false;
	}
	if (!check_pwd2_userreg()) {
		res = false;
	}
	if (!check_username_userreg()) {
		res = false;
	}

	return res;
}

function userreg_sub() {
	reginfostr = "";
	if (userreg_sub_check()) {
		if (document.getElementById("txtCoName").value == "") {
			alert("Please enter your firstname!");
			document.getElementById("txtCoName").focus();
		} else {
			if (document.getElementById("txtReceiverName").value == "") {
				alert("please enter your lastname!");
				document.getElementById("txtReceiverName").focus();
				return false;
			} else {
				if (document.getElementById("hz_realname").value == "") {
					alert("��������������");
					document.getElementById("hz_realname").focus();
					return false;
				} else {
					if (document.getElementById("txtTelPhone").value == "") {
						alert("�������ֻ����");
						document.getElementById("txtTelPhone").focus();
						return false;
					} else {
						// if(document.getElementById("txtUserCode").value=="")
						// {
						// alert("��������֤��");
						// document.getElementById("txtUserCode").focus();
						// return false;
						// }
						// else
						// {
						return document.getElementById("reg_form").submit();
						// }
					}
				}
			}
		}
	}
	if (reginfostr != "") {
		alert(reginfostr);
	}
}

function sel_transport_area(area_id, basic_weight, fixed_postage, per_weight,
		per_postage, basic_weight_1, per_weight_1, per_postage_1) {

	document.getElementById("tr_transportfundshow").style.display = '';

	var profullweigth_tag = parseFloat(document.getElementById("profullweigth").value);
	var profullprice_tag = parseFloat(document
			.getElementById("profullprice_lab").value);
	var transportprice_tag = 0;

	if (basic_weight == "0" || fixed_postage == "0" || per_weight == "0"
			|| per_postage == "0") {
		transportprice_tag = 0;
	} else {

		basic_weight = parseFloat(basic_weight);
		fixed_postage = parseFloat(fixed_postage);
		per_weight = parseFloat(per_weight);
		per_postage = parseFloat(per_postage);

		basic_weight_1 = parseFloat(basic_weight_1);
		per_weight_1 = parseFloat(per_weight_1);
		per_postage_1 = parseFloat(per_postage_1);

		if (basic_weight_1 > 0) {
			if (basic_weight > profullweigth_tag) {
				transportprice_tag = fixed_postage;
			} else {
				if (profullweigth_tag < basic_weight_1) {
					transportprice_tag = fixed_postage
							+ (profullweigth_tag - basic_weight) * per_postage
							/ per_weight;
				} else {
					transportprice_tag = fixed_postage
							+ (basic_weight_1 - basic_weight) * per_postage
							/ per_weight + (profullweigth_tag - basic_weight_1)
							* per_postage_1 / per_weight_1;
				}
			}
		} else {
			if (basic_weight > profullweigth_tag) {
				transportprice_tag = fixed_postage;
			} else {
				transportprice_tag = fixed_postage
						+ (profullweigth_tag - basic_weight) * per_postage
						/ per_weight;

			}
		}

	}

	document.getElementById("transportprice_tag").value = transportprice_tag;

	document.getElementById("ord_transportfund").innerHTML = "<font color=red><b>��"
			+ transportprice_tag
			+ "Ԫ</b></font>&nbsp;&nbsp;&nbsp;������Ʒ��������"
			+ profullweigth_tag / 1000 + "���� &nbsp;����˷������飬��ȷ�϶�������ϵ����";
	if (document.getElementById("user_point_check").checked) {
		var p_userponit = parseInt(document.getElementById("user_point_hd").value);
		document.getElementById("ordertj").innerHTML = "<b>��Ʒ�۸�:</b><font color=red><b>��"
				+ profullprice_tag
				+ "</b></font> + <b>�����˷�:</b><font color=red><b>��"
				+ transportprice_tag
				+ "</b></font> - <b>��Ա��֣�</b><font color=green><b>"
				+ p_userponit
				+ "</b></font> = <font color=red><b>��"
				+ (parseFloat(profullprice_tag)
						+ parseFloat(transportprice_tag) - parseInt(p_userponit))
				+ "Ԫ</b></font>";
	} else {
		document.getElementById("ordertj").innerHTML = "<b>��Ʒ�۸�:</b><font color=red><b>��"
				+ profullprice_tag
				+ "</b></font> + <b>�����˷�:</b><font color=red><b>��"
				+ transportprice_tag
				+ "</b></font> = <font color=red><b>��"
				+ (parseFloat(profullprice_tag) + parseFloat(transportprice_tag))
				+ "Ԫ</b></font>";
	}
	document.getElementById("sel_transport_area_id").value = area_id;
	check_transport_area();

}

function ord_userpoint() {
	var p_transportprice = "";
	var p_price = "";
	var p_userponit = "";

	p_price = parseFloat(document.getElementById("profullprice_lab").value);
	p_transportprice = parseFloat(document.getElementById("transportprice_tag").value);
	p_userponit = parseInt(document.getElementById("user_point_hd").value);

	// alert(p_price);
	// alert(p_transportprice);
	// alert(p_userponit);
	if (p_transportprice == -1) {
		alert("����ѡ�����͵���");
		document.getElementById("user_point_check").checked = false;
		return false;
	}

	if (document.getElementById("user_point_check").checked) {
		if (p_userponit > 0) {
			document.getElementById("ordertj").innerHTML = "<b>��Ʒ�۸�:</b><font color=red><b>��"
					+ p_price
					+ "</b></font> + <b>�����˷�:</b><font color=red><b>��"
					+ p_transportprice
					+ "</b></font> - <b>��Ա��֣�</b><font color=green><b>"
					+ p_userponit
					+ "</b></font> = <font color=red><b>��"
					+ (parseFloat(p_price) + parseFloat(p_transportprice) - parseInt(p_userponit))
					+ "Ԫ</b></font>";
		} else {
			alert("����ʱ�޻�ֿ���");
			document.getElementById("user_point_check").checked = false;
			return false;
		}
	} else {
		document.getElementById("user_point_check").checked = false;
		document.getElementById("ordertj").innerHTML = "<b>��Ʒ�۸�:</b><font color=red><b>��"
				+ p_price
				+ "</b></font> + <b>�����˷�:</b><font color=red><b>��"
				+ p_transportprice
				+ "</b></font> = <font color=red><b>��"
				+ (parseFloat(p_price) + parseFloat(p_transportprice))
				+ "Ԫ</b></font>";

	}

}

//特殊字符串
function isText(s) {
	if (s.length < 1) {
		window.alert("��������Ϣ��");
		return false;
	}
	var regu = "'$%&=;?";
	if (!SpecialString(s, regu)) {
		alert("��ʹ�ù淶���֣����ú��������ַ�'$%&=;? ");
		return false;
	} else {
		return true;
	}
}

function isText0(s, msg) {
	if (s.length < 1) {
		window.alert(msg + "����Ϊ�գ�");
		return false;
	}
	var regu = "'$%&=;?";
	if (!SpecialString(s, regu)) {
		alert(msg + "�в��ú��������ַ�'$%&=;? ");
		return false;
	} else {
		return true;
	}
}

function SpecialString(string, compare) {
	var i;
	for (i = 0; i < string.length; i++) {
		if (compare.indexOf(string.charAt(i)) != -1) {
			return false;
			break;
		}
	}
	return true;
}

//是否为整数
function checkNUM(NUM) {
	var NUM = NUM;
	var i, j, strTemp;
	strTemp = "0123456789";
	if (NUM.length == 0)
		return 0
	for (i = 0; i < NUM.length; i++) {
		if (NUM.charAt(0) == 0)
			return 0;
		j = strTemp.indexOf(NUM.charAt(i));
		if (j == -1) {
			// ˵�����ַ�������
			return 0;
		} else {
			return 1;
		}
	}
	// ˵��������
}

//是否为金额
function isMoney(s) {

	if (isNaN(s)) {
		window.alert("��������Ч�Ľ���23.78��");
		return false;
	} else {
		return true;
	}

	/*
	 * var regu = "^[0-9]+[\.][0-9]{0,2}$"; var re = new RegExp(regu); if
	 * (re.test(s)) { return true; } else { window.alert ("��������Ч�Ľ���23.78��");
	 * return false; }
	 */

}

function isMoney0(s, msg) {

	if (isNaN(s)) {
		window.alert(msg + "��������Ч�Ľ���23.78��");
		return false;
	} else {
		return true;
	}
	/*
	 * var regu = "^[0-9]+[\.][0-9]{0,2}$"; var re = new RegExp(regu); if
	 * (re.test(s)) { return true; } else { window.alert
	 * (msg+"��������Ч�Ľ���23.78��"); return false; }
	 */
}

//是否为数字
function isWeight(s) {

	if (isNaN(s)) {
		window.alert("��������Ч����������23.78��");
		return false;
	} else {
		return true;
	}
	/*
	 * var regu = "^[0-9]+[\.][0-9]{0,2}$"; var re = new RegExp(regu); if
	 * (re.test(s)) { return true; } else { window.alert ("��������Ч����������23.78��");
	 * return false; }
	 */

}

//是否为电话
function isTel(s) {
	var s = s;
	var i, j, x, strTemp;
	strTemp = "0123456789-";
	if (s.length == 0) {
		x = 0;
	}

	for (i = 0; i < s.length; i++) {
		j = strTemp.indexOf(s.charAt(i));
		if (j == -1) {
			x = 0;
		}
	}
	if (x == 0) {
		return 0;
	} else {
		return 1;
	}
}

//只能输入数字 有小数点
function SingleInput() {
	if (event.shiftKey)
		event.returnValue = false;
	if (!((event.keyCode >= 48 && event.keyCode <= 57)
			|| (event.keyCode >= 96 && event.keyCode <= 105)
			|| (event.keyCode == 8) || (event.keyCode == 110)
			|| (event.keyCode == 190) || (event.keyCode == 9)))
		event.returnValue = false;
	// onBlur="if(!/^[0-9]+(.[0-9]{1,2})?$/.test(this.value))
	// alert(this.value);"
	// onkeyPress="javascript:alert(window.event.keyCode);"
}

//只能输入正整数
function IsInt(s, msg) {
	var regu = /^[0-9]*[1-9][0-9]*$/;
	var re = new RegExp(regu);
	if (re.test(s)) {
		return true;
	} else {
		window.alert(msg + "����������������");
		return false;
	}
}

//只能输入正整数
function IsSelInt(s, msg) {
	var regu = /^[0-9]*[1-9][0-9]*$/;
	var re = new RegExp(regu);
	if (re.test(s)) {
		return true;
	} else {
		window.alert("��ѡ��" + msg);
		return false;
	}
}

function changeTwoDecimal(x) {
	var f_x = parseFloat(x);
	if (isNaN(f_x)) {

		return false;
	}
	var f_x = Math.round(x * 100) / 100;
	return f_x;
}
