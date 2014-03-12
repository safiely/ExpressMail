function user_check () {
	var username = document.forms["home_login"]["txtUserName"].value;
	if (username == null || username == "") {
		alert("Please enter the username!");
		return false;
	} else
		return true;
}

function pwd_check() {
	var password = document.forms["home_login"]["txtUserPwd"].value;
	if (password == null || password == "") {
		alert("Please enter the password!");
		return false;
	} else 
		return true;
}

function valid_email()
{
	var x=document.forms["home_login"]["txtUserName"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
		alert("Not a valid e-mail address");
		return false;
	} else
		return true;
}

function fsubmit(obj) {
	if (user_check()) {
		if (valid_email()) {
			if (pwd_check()) {
				obj.submit();
			}
		}
	}
}

function setCookie(cname,cid,exdays) {
	var d = new Date();
	var cvalue = document.getElementById(cid).value;
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname+"="+cvalue+"; "+expires;
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i].trim();
		if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	}
	return "";
}

function checkCookie() {
	var user = getCookie("username");
	var pwd = getCookie("password");
	if (user != "") {
		document.getElementById("txtUserPwd").value.innerHTML="123";
	}
	if (pwd != "") {
		document.getElementById("txtUserName").value.innerHTML="123";
	}
}
