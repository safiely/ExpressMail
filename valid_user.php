<?php

require_once 'include.php';

session_start();
try{
	display_member_init();

}catch(Exception $e){
	do_html_header('Problem');
	echo $e->getMessage();
	exit();
}
?>


<!-- display member init login page -->
<?php 
function display_member_init(){

	$title="会员服务系统";
	do_html_header($title);
	if($title){
	  	$form="Us_Index.aspx";
		display_comman_header($form);
		display_member_body();
	}

}
?>
<!-- display member init login page -->


<?php function display_member_body(){

	?>
<tr>
	<td height="199">
		<table cellspacing="0" cellpadding="0" width="100%" border="0">
			<tbody>



				<tr>
					<td height="6"></td>
				</tr>
				<tr>
					<td width="22" height="36">&nbsp;</td>
					<td class="da" width="593" colspan="2"><img height="15"
						src="images/tip_arrow3.jpg" width="15">&nbsp;&nbsp;会员专区</td>
				</tr>
				<tr>
					<td width="20" height="30">&nbsp;</td>

					<td width="100%" class="hei" align="left" valign="top">
						<table cellspacing="0" cellpadding="10" width="100%" border="0"
							bgcolor="#e5ffbd" style="display: none">
							<tbody>
								<tr>
									<td class="da" width="100%" colspan="2"><font color="red">新系统必读</font>
									</td>
								</tr>
								<tr>
									<td><a href="images/001.doc">新系统发货方式及运费说明</a>
									</td>
								</tr>

							</tbody>



						</table> <br>

						<table cellspacing="0" cellpadding="10" width="100%" border="0"
							bgcolor="#e5ffbd">

							<tbody>



								<tr>
									<td class="da" width="100%" colspan="2">会员信息</td>
								</tr>

								<tr>
									<td width="50%">邮件地址：<?php echo $_SESSION['email']?>&nbsp;&nbsp;上次登录：2014/2/5
										14:36:07
									</td>
									<td width="50%">客户编号：<b><?php echo $_SESSION['cid']?> </b>&nbsp;&nbsp;<span
										id="service_qq"></span>
									</td>
								</tr>

								<tr>
									<td width="50%">账户余额：<font color="red"><b>0.00</b> 美元 </font>&nbsp;
										&nbsp;
									</td>
									<td width="50%"><span id="chongzhilab">充值总额：<font color="red"><b>0.00</b>
										</font> 美元&nbsp; &nbsp;后台员工代充：<font color="red"><b>0.00</b> </font>
											美元
									</span>
									</td>
								</tr>

								<tr>
									<td widt h="50%"><span id="packagelab">到库包裹：<a
											href="Us_PackageList.aspx"><b><font color="#4a4a4a">4 个</font>
											</b> </a>&nbsp; &nbsp;已发包裹：<a
											href="Us_PackageListUpdate.aspx"><b><font color="#4a4a4a">0 个</font>
											</b> </a>



									</span>
									</td>
									<td width="50%"><span id="chongzhilab0">支付宝充值：<font color="red"><b>0.00</b>
										</font> 美元&nbsp;&nbsp;Paypal在线：<font color="red"><b>0.00</b> </font>
											美元&nbsp;&nbsp;信用卡：<font color="red"><b>0.00</b> </font> 美元
									</span>
									</td>
								</tr>

								<tr>
									<td width="50%"><span id="yundanlab">待反馈业务：<a
											href="Us_Mybusiness_Manage.aspx?bs_state=0"><b><font
													color="#4a4a4a">0 个</font> </b> </a>&nbsp; &nbsp;全部业务：<a
											href="Us_Mybusiness_Manage.aspx"><b><font color="#4a4a4a">0 个</font>
											</b> </a>&nbsp; &nbsp;全部运单：<a href="Us_Mybill_Manage.aspx"><b><font
													color="#4a4a4a">0 个</font> </b> </a>



									</span>
									</td>
									<td width="50%">消费总额：<font color="green"><b>0.00</b> </font>
										美元&nbsp;&nbsp;<img src="image/suggest_right.gif"><a
										href="Us_Balance_Index.aspx">在线冲值</a>
									</td>
								</tr>

							</tbody>



						</table> <br>
						<table cellspacing="0" cellpadding="10" width="100%" border="0"> <br>
						<table cellspacing="0" cellpadding="10" width="100%" border="0"
							bgcolor="#eaf3ff" style="display: none;">

							<tbody>



								<tr>
									<td class="da" width="100%" colspan="2"><span id="linker">联系方式：tel：630-445-1555&nbsp;&nbsp;
											QQ：1714113120 </span>
									</td>
								</tr>
							</tbody>



						</table>

					</td>
				</tr>

			</tbody>



		</table>
	</td>
</tr>



<tr>
	<td height="20" bgcolor="#ffffff"></td>
</tr>
<tr>

	<td bgcolor="#ffffff" valign="middle">
		<table width="100%" border="0" align="center" cellpadding="0"
			cellspacing="0">
			<tbody>



				<tr>
					<td width="10">&nbsp;</td>
					<td width="100%" height="70" bgcolor="#f4f4f4" valign="middle">
						<div align="center" class="hui">君安快递&nbsp;&nbsp; Copyright 2012
							www.junanex.com, All Rights Reserved</div>
					</td>

				</tr>
			</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</form>
</body>
<?php 
	}?>