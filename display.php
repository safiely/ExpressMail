<?php 
function do_html_header($title){
	?>
<html>
<head>
<title><?php echo $title?>
</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="Keywords">
<meta name="Description">
<meta name="author" content="王大锤">
<link type="text/css" rel="stylesheet" href="./css/default.css"></link>
</head>
<?php 
}
?>



<?php function display_comman_header($form){

	?>
<body topmargin="0" leftmargin="0">
	<form name="form1" method="post" action=<?php echo $form?> id="form1">
		<div>
			<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE"
				value="/wEPDwUJNjA4ODQ0OTIxD2QWAgIDD2QWDmYPZBYOZg8PFgIeBFRleHQFHDIwMTTlubQwMuaciDA15pelICDmmJ/mnJ/kuIlkZAIBDw8WAh8ABRDnjovovrAg5oKo5aW977yBZGQCAg8WAh4HVmlzaWJsZWhkAgMPFgIfAWhkAgQPFgIfAWhkAgUPDxYCHwAFATBkZAIGDxYCHgZoZWlnaHQFATRkAgMPDxYCHwAFgwHlhYXlgLzmgLvpop3vvJo8Zm9udCBjb2xvcj1yZWQ+PGI+MC4wMDwvYj48L2ZvbnQ+IOe+juWFgyZuYnNwOyAmbmJzcDvlkI7lj7DlkZjlt6Xku6PlhYXvvJo8Zm9udCBjb2xvcj1yZWQ+PGI+MC4wMDwvYj48L2ZvbnQ+IOe+juWFg2RkAgQPDxYCHwAFxwHliLDlupPljIXoo7nvvJo8YSBocmVmPSdVc19QYWNrYWdlTGlzdC5hc3B4Jz48Yj48Zm9udCBjb2xvcj0nIzRhNGE0YSc+NCDkuKo8L2ZvbnQ+PC9iPjwvYT4mbmJzcDsgJm5ic3A75bey5Y+R5YyF6KO577yaPGEgaHJlZj0nVXNfUGFja2FnZUxpc3RVcGRhdGUuYXNweCc+PGI+PGZvbnQgY29sb3I9JyM0YTRhNGEnPjAg5LiqPC9mb250PjwvYj48L2E+ZGQCBQ8PFgIfAAXAAeaUr+S7mOWuneWFheWAvO+8mjxmb250IGNvbG9yPXJlZD48Yj4wLjAwPC9iPjwvZm9udD4g576O5YWDJm5ic3A7Jm5ic3A7UGF5cGFs5Zyo57q/77yaPGZvbnQgY29sb3I9cmVkPjxiPjAuMDA8L2I+PC9mb250PiDnvo7lhYMmbmJzcDsmbmJzcDvkv6HnlKjljaHvvJo8Zm9udCBjb2xvcj1yZWQ+PGI+MC4wMDwvYj48L2ZvbnQ+IOe+juWFg2RkAgYPDxYCHwAFxALlvoXlj43ppojkuJrliqHvvJo8YSBocmVmPSdVc19NeWJ1c2luZXNzX01hbmFnZS5hc3B4P2JzX3N0YXRlPTAnPjxiPjxmb250IGNvbG9yPScjNGE0YTRhJz4wIOS4qjwvZm9udD48L2I+PC9hPiZuYnNwOyAmbmJzcDvlhajpg6jkuJrliqHvvJo8YSBocmVmPSdVc19NeWJ1c2luZXNzX01hbmFnZS5hc3B4Jz48Yj48Zm9udCBjb2xvcj0nIzRhNGE0YSc+MCDkuKo8L2ZvbnQ+PC9iPjwvYT4mbmJzcDsgJm5ic3A75YWo6YOo6L+Q5Y2V77yaPGEgaHJlZj0nVXNfTXliaWxsX01hbmFnZS5hc3B4Jz48Yj48Zm9udCBjb2xvcj0nIzRhNGE0YSc+MCDkuKo8L2ZvbnQ+PC9iPjwvYT5kZAIHDw8WAh8ABacTPFA+PEZPTlQgc3R5bGU9IkZPTlQtU0laRTogMTRweDsgQ09MT1I6ICMwMDAwZmYiPjxTVFJPTkcgc3R5bGU9IkNPTE9SOiAiPuWQm+WuieacrOmDqOW6k+aIvzwvU1RST05HPjwvRk9OVD48L1A+DTxicj48UCBzdHlsZT0iTElORS1IRUlHSFQ6IDEiPjxGT05UIHN0eWxlPSJGT05ULVNJWkU6IDEzcHg7IENPTE9SOiAjMDAwMDAwIj48U1RST05HIHN0eWxlPSJDT0xPUjogIj48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+TmFtZTog5L2g55qE5ZCN5a2XIDxGT05UIHN0eWxlPSJGT05ULVNJWkU6IDEzcHg7IENPTE9SOiAjZmYwMDAwIj7vvIsg5LqU5L2N5pWw5a6i5oi357yW5Y+3PC9GT05UPjwvRk9OVD48L1NUUk9ORz48L0ZPTlQ+PC9QPg08YnI+PFAgc3R5bGU9IkxJTkUtSEVJR0hUOiAxIj48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+PFNUUk9ORyBzdHlsZT0iQ09MT1I6ICI+QWRkcmVzczogNDc5IFcuIEZ1bGxlcnRvbiBBdmU8L1NUUk9ORz48L0ZPTlQ+PC9QPg08YnI+PFAgc3R5bGU9IkxJTkUtSEVJR0hUOiAxIj48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+PFNUUk9ORyBzdHlsZT0iQ09MT1I6ICI+Q2l0eTogRWxtaHVyc3QsIDwvU1RST05HPjwvRk9OVD48L1A+DTxicj48UCBzdHlsZT0iTElORS1IRUlHSFQ6IDEiPjxGT05UIHN0eWxlPSJGT05ULVNJWkU6IDEzcHg7IENPTE9SOiAjMDAwMDAwIj48U1RST05HIHN0eWxlPSJDT0xPUjogIj5TdGF0ZTogSUw8L1NUUk9ORz48L0ZPTlQ+PC9QPg08YnI+PFAgc3R5bGU9IkxJTkUtSEVJR0hUOiAxIj48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+PFNUUk9ORyBzdHlsZT0iQ09MT1I6ICI+Wmlw77yaNjAxMjY8L1NUUk9ORz48L0ZPTlQ+PC9QPg08YnI+PFAgc3R5bGU9IkxJTkUtSEVJR0hUOiAxIj48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+PFNUUk9ORyBzdHlsZT0iQ09MT1I6ICI+VEVMOiA2MzAtNDQ1LTE1NTU8L1NUUk9ORz48L0ZPTlQ+PC9QPg08YnI+PFA+PEZPTlQgc3R5bGU9IkNPTE9SOiAjZmYwMDAwIj48U1RST05HPu+8iOS6lOS9jeaVsOWtl+eahOWuouaIt+e8luWPt+WPr+S7peWHuueOsOWcqOWQjeWtl+WQjumdouaIluiAheWcsOWdgOagj+esrOS6jOagj++8iTwvU1RST05HPjwvRk9OVD48L1A+DTxicj48UD48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxNHB4OyBDT0xPUjogIzAwMDBmZiI+PFNUUk9ORyBzdHlsZT0iQ09MT1I6ICI+5YWN56iO5beeREXlupPmiL88L1NUUk9ORz48L0ZPTlQ+PC9QPg08YnI+PFAgc3R5bGU9IkxJTkUtSEVJR0hUOiAxIj48U1RST05HPjxGT05UIHN0eWxlPSJGT05ULVNJWkU6IDEzcHg7IENPTE9SOiAjMDAwMDAwIj5OYW1lOiDkvaDnmoTlkI3lrZcgPEZPTlQgc3R5bGU9IkZPTlQtU0laRTogMTNweDsgQ09MT1I6ICNmZjAwMDAiPu+8iyDkupTkvY3mlbDlrqLmiLfnvJblj7c8L0ZPTlQ+PC9GT05UPjwvU1RST05HPjwvUD4NPGJyPjxQIHN0eWxlPSJMSU5FLUhFSUdIVDogMSI+PFNUUk9ORz48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+QWRkcmVzczogMTIwMCBJbnRlcmNoYW5nZSBCTFZEPC9GT05UPjwvU1RST05HPjwvUD4NPGJyPjxQIHN0eWxlPSJMSU5FLUhFSUdIVDogMSI+PFNUUk9ORz48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+QWRkcmVzcyAy77yaIFN1aXRlIEEgPC9GT05UPjwvU1RST05HPjwvUD4NPGJyPjxQIHN0eWxlPSJMSU5FLUhFSUdIVDogMSI+PFNUUk9ORz48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+Q2l0eTogTmV3YXJrPC9GT05UPjwvU1RST05HPjwvUD4NPGJyPjxQIHN0eWxlPSJMSU5FLUhFSUdIVDogMSI+PFNUUk9ORz48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+U3RhdGXvvJpERTwvRk9OVD48L1NUUk9ORz48L1A+DTxicj48UCBzdHlsZT0iTElORS1IRUlHSFQ6IDEiPjxTVFJPTkc+PEZPTlQgc3R5bGU9IkZPTlQtU0laRTogMTNweDsgQ09MT1I6ICMwMDAwMDAiPlppcO+8mjE5NzExPC9GT05UPjwvU1RST05HPjwvUD4NPGJyPjxQIHN0eWxlPSJMSU5FLUhFSUdIVDogMSI+PFNUUk9ORz48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4Ij48Rk9OVCBzdHlsZT0iRk9OVC1TSVpFOiAxM3B4OyBDT0xPUjogIzAwMDAwMCI+VEVMOjwvRk9OVD4gMzAyLTM2OTkzNjk8QlI+PC9QPjwvRk9OVD48L1NUUk9ORz4NPGJyPjxQPjxGT05UIHN0eWxlPSJDT0xPUjogI2ZmMDAwMCI+PFNUUk9ORyBzdHlsZT0iQ09MT1I6ICI+77yI5LqU5L2N5pWw5a2X55qE5a6i5oi357yW5Y+35Y+v5Lul5Ye6546w5Zyo5ZCN5a2X5ZCO6Z2i5oiW6ICF5Zyw5Z2A5qCP56ys5LqM5qCP77yJPC9TVFJPTkc+PC9GT05UPjwvUD5kZAIIDw8WAh8ABUDogZTns7vmlrnlvI/vvJp0ZWzvvJo2MzAtNDQ1LTE1NTUmbmJzcDsmbmJzcDsgICBRUe+8mjE3MTQxMTMxMjAgZGRk4KPUYVCG2EwWjXJyLstKXyzAfus=">
		</div>

		<div>
			<table cellspacing="0" cellpadding="0" width="100%" border="0"
				bgcolor="#ffffff">
				<tbody>
					<tr>
						<td valign="top" width="200">
							<table width="200" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td>
											<table width="200" border="0" cellspacing="0" cellpadding="0"
												background="images/dll_0.jpg">
												<tbody>
													<tr>
														<td height="85" align="center" valign="bottom"><img
															src="images/junanlogo.jpg">
														</td>
													</tr>
													<tr>
														<td height="30"><div align="center">
																<span class="dan"><span id="Us_Left_ShowCurTime"><?php date_default_timezone_set('America/Chicago'); echo date("F j, Y, g:i a");?></span> </span>
															</div>
														</td>
													</tr>
													<tr>
														<td height="35" class="da">
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td height="10"></td>
																	</tr>
																	<tr>
																		<td height="45" width="100%" class="da" align="center"
																			style="text-indent: 25px;"><span
																			id="Us_Left_User_NameStr"><?php 
																			$name=$_SESSION['chinesename'];
																			echo $name;?> 您好！</span>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td>
															<table border="0" cellpadding="0" cellspacing="0">

																<tbody>
																	<tr>
																		<td width="25"></td>
																		<td height="39" align="center" class="da"
																			valign="bottom"><a href="valid_user.php"
																			class="DefaultA"><font class="da">管理首页</font> </a>&nbsp;&nbsp;<a
																			href="User/logout.php" class="DefaultA"><font
																				class="da">退出帐户</font> </a>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="25" class="hei" valign="top"></td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td height="31" class="da">
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td width="45"></td>
																		<td class="da" valign="bottom">包裹中心</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td>
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td width="45"></td>
																		<td height="28" class="hei"><div align="left">
																				<a href="pack_record_form.php" class="MainLeft">自助录入包裹</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td height="1" colspan="2"></td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="28" class="hei"><div align="left">
																				<a href="pkg_update.php" class="MainLeft">更新包裹信息</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td height="3" colspan="2"></td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="28" class="hei"><div align="left">
																				<a href="pkg_check.php" class="MainLeft">包裹状态查询</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="30" class="hei"><div align="left">
																				<a href="Us_PackageListReturn.aspx" class="MainLeft">退货管理</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="28" class="hei"><div align="left">
																				<a href="Us_PackageListPhoto.aspx" class="MainLeft">包裹拍照</a>
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>

													<tr>
														<td height="35" class="da">
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td height="10"></td>
																	</tr>
																	<tr>
																		<td width="45"></td>
																		<td class="da" valign="bottom">业务-运单-管理</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td height="5"></td>
													</tr>
													<tr>
														<td>
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td width="45"></td>
																		<td height="30" class="hei"><div align="left">
																				<a href="order.php" class="MainLeft">创建普通业务</a>
																			</div>
																		</td>
																	</tr>






																	<tr>
																		<td width="40"></td>
																		<td height="28" class="hei"><div align="left">
																				<a href="Us_Mybill_Manage.aspx" class="MainLeft"><b>全部运单管理</b>
																				</a>
																			</div>
																		</td>
																	</tr>

																	<tr>
																		<td width="40"></td>
																		<td height="28" class="hei"><div align="left">
																				<a href="Us_Mybusiness_Manage.aspx" class="MainLeft">全部业务管理</a>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td width="40"></td>
																		<td height="28" class="hei"><div align="left">
																				<a href="Us_Mybusiness_Manage.aspx?bs_state=0"
																					class="MainLeft">待反馈的业务</a>[<span
																					id="Us_Left_bs_num_lab">0</span>]
																			</div>
																		</td>
																	</tr>

																</tbody>
															</table>
														</td>
													</tr>

													<tr>
														<td id="Us_Left_td_middle" height="4"></td>

													</tr>

													<tr>
														<td height="35" class="da">
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td height="13"></td>
																	</tr>
																	<tr>
																		<td width="45"></td>
																		<td class="da" valign="bottom">账户信息</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td height="5"></td>
													</tr>
													<tr>
														<td>
															<table border="0" cellpadding="0" cellspacing="0">

																<tbody>
																	<tr>
																		<td width="45"></td>
																		<td height="27" class="hei"><a
																			href="Us_EditMyInfo.aspx" class="MainLeft">我的信息</a>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="24" class="hei"><a
																			href="Us_ModifyPwd.aspx" class="MainLeft">修改密码</a>
																		</td>
																	</tr>

																	<tr>
																		<td></td>
																		<td height="26" class="hei"><a
																			href="Us_ManageAddress.aspx" class="MainLeft">收货地址</a>
																		</td>
																	</tr>

																	<tr>
																		<td></td>
																		<td height="26" class="hei"><a href="Us_IDcards.aspx"
																			class="MainLeft">身份证管理</a>
																		</td>
																	</tr>

																	<tr style="display: none">
																		<td></td>
																		<td height="28" class="hei"><a
																			href="Us_ManageSendAddress.aspx" class="MainLeft">发件人地址</a>
																		</td>
																	</tr>

																	<tr style="display: none">
																		<td></td>
																		<td height="26" class="hei"><a
																			href="Us_ManageCreditcard.aspx" class="MainLeft">信用卡登记簿</a>
																		</td>
																	</tr>

																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td height="3"></td>
													</tr>
													<tr>
														<td height="40" class="da">
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td height="15"></td>
																	</tr>
																	<tr>
																		<td width="45"></td>
																		<td class="da" valign="bottom">财务管理</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>

													<tr>
														<td>
															<table border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr>
																		<td height="3"></td>
																	</tr>
																	<tr>
																		<td width="45"></td>
																		<td height="28" class="hei"><a
																			href="Us_Balance_Index.aspx" class="MainLeft">余额充值</a>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="30" class="hei"><a
																			href="Us_RechargeList.aspx" class="MainLeft">充值记录</a>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="28" class="hei"><a
																			href="Us_DebitList.aspx" class="MainLeft">消费记录</a>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="26" class="hei"><a
																			href="Us_Reconciliation.aspx" class="MainLeft">电子账单</a>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td height="26" class="hei"><a
																			href="Us_MentionApply.aspx" class="MainLeft">申请提现</a>
																		</td>
																	</tr>

																	<tr>
																		<td></td>
																		<td height="26" class="hei"><a
																			href="Us_Compensation.aspx" class="MainLeft">申请赔偿</a>
																		</td>
																	</tr>



																	<tr>
																		<td></td>
																		<td height="26" class="hei"><a href="Us_Message.aspx"
																			class="MainLeft">站内提醒</a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>

													<tr>
														<td height="12"></td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>

									<tr>
										<td height="24" width="252" background="images/hp1_1_r2.jpg"></td>
									</tr>
								</tbody>
							</table>
						</td>
						<td valign="top" width="*"><map name="top_images">
								<area shape="RECT" coords="28,14,81,32" class="DefaultA"
									href="javascript:window.external.AddFavorite('http://www.junanex.com','君安快递')"
									target="_self">
								<area shape="RECT" coords="108,14,162,32" class="DefaultA"
									onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.junanex.com');"
									href="#" target="_self">
							</map>
							<table cellspacing="0" cellpadding="0" width="100%" border="0">


								<tbody>
									<tr>
										<td height="2"></td>
									</tr>
									<tr>
										<td height="56" colspan="2">
											<table width="100%" border="0" cellspacing="0"
												cellpadding="0">
												<tbody>
													<tr>
														<td width="17" height="56"><img src="images/n0.png"
															width="17" height="56" border="0">
														</td>
														<td width="100%" background="images/n1.jpg"></td>
														<td width="200" height="56"><img src="images/n2.jpg"
															width="200" height="56" border="0" usemap="#top_images">
														</td>
													</tr>
												</tbody>
											</table>

										</td>
									</tr>

									<tr>
										<td height="44" colspan="2" bgcolor="#00aa4a" valign="middle">

											<table>
												<tbody>
													<tr>
														<td height="5"></td>
													</tr>
													<tr>
														<td width="10"></td>
														<td align="left" width="100"><a href="index.html"
															class="title22_wenzi" target="_blank">首 页</a>
														</td>
														<td width="10"></td>
														<td align="left" width="100"><a href="/news/news_7_1.html"
															class="title22_wenzi" target="_blank">网站公告</a>
														</td>
														<td width="10"></td>
														<td align="left" width="100"><a href="/news/sitehelp.html"
															class="title22_wenzi" target="_blank">常见问题</a>
														</td>
														<td width="10"></td>
														<td align="left" width="100"><a href="/userguide.html"
															class="title22_wenzi" target="_blank">发货流程</a>
														</td>
														<td width="10"></td>
														<td align="left" width="100"><a href="/contact.html"
															class="title22_wenzi" target="_blank">联系我们</a>
														</td>
														<td width="20"></td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<?php 
}?>
