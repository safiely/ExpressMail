function log_chk() {
	if (document.getElementById("txtUserName").value == "") {
		alert("请输入邮箱地址！");
		document.getElementById("txtUserName").focus();
		return false;
	}

	if (document.getElementById("txtUserPwd").value == "") {
		alert("请输入密码！");
		document.getElementById("txtUserPwd").focus();
		return false;
	}

//	if (document.getElementById("txtUserCode").value == "") {
//		alert("请输入验证码！");
//		document.getElementById("txtUserCode").focus();
//		return false;
//	}

	document.getElementById("log_form").action = "/Users/login_check.php"
			+ returnurl;
	document.getElementById("log_form").submit();
}

function log_ent_mail() {

	if (event.keyCode == 13) {
		document.getElementById("txtUserPwd").focus();
		return false;
	}
}
function log_ent_pwd() {
	if (event.keyCode == 13) {
		document.getElementById("txtUserCode").focus();
	}
}

function log_ent() {
	if (event.keyCode == 13) {
		log_chk();
	}
}

function hz_setCookie(c_name, value, expiredays) {
	var exdate = new Date()
	exdate.setDate(exdate.getDate() + expiredays)
	document.cookie = c_name + "=" + escape(value)
			+ ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString())
}

function hz_getCookie(c_name) {
	if (document.cookie.length > 0) {
		c_start = document.cookie.indexOf(c_name + "=")
		if (c_start != -1) {
			c_start = c_start + c_name.length + 1
			c_end = document.cookie.indexOf(";", c_start)
			if (c_end == -1)
				c_end = document.cookie.length
			return unescape(document.cookie.substring(c_start, c_end))
		}
	}
	return ""
}

function reloadcode() {
	if (document.getElementById('getcodenum') != null) {
		document.getElementById('getcodenum').src = '/VerifyCode?id='
				+ Math.random();
	}
}