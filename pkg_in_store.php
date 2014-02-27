<?php
require_once 'valid_user.php';

session_start();
try{
	display_pkg_in_store();

}catch(Exception $e){
	do_html_header('Problem');
	echo $e->getMessage();
	exit();
}
?>

<?php 
function display_pkg_in_store(){

	$title="会员服务系统";
	do_html_header($title);
	if($title){
	  	$form="pkg_status.php";
		display_comman_header($form);
		display_pkg_form();
	}
}
?>

<?php 
function display_pkg_form() {
?>
<tr>
								<td height="199">
									<table cellspacing="0" cellpadding="0" width="100%" border="0">
									    <tbody><tr>
											<td colspan="3" height="10"></td>
										</tr>
										<tr>
											<td height="13"></td>
										</tr>
										
										<tr>
											<td class="da" width="100%" colspan="3" height="30" style="text-indent:26px"><img height="15" src="image/tip_arrow3.jpg" width="15">&nbsp;&nbsp;已发包裹&nbsp;&nbsp;&nbsp;&nbsp;<input name="skey" type="text" id="skey" size="15" maxlength="30" class="pic_border">&nbsp;
											
											<select name="pk_areaid_sel" id="pk_areaid_sel" onchange="document.getElementById('pk_areaid').value=this.value;">
                                                              <option value="">仓库名称</option>
                                                              <option value="5">君安仓库</option><option value="8">免税州DE</option><option value="7">免税州OR</option>
                                                          </select><input name="pk_areaid" type="hidden" id="pk_areaid">
                    <script>
                        if(document.getElementById("pk_areaid").value!="")
                        {
                            document.getElementById("pk_areaid_sel").value = document.getElementById("pk_areaid").value;
                        }
                      
                      </script>入库日期从<input name="pk_cometime" type="text" id="pk_cometime" onclick="SelectDate(document.getElementById('pk_cometime'),'yyyy-MM-dd',0,0)" readonly="" maxlength="10" class="pic_border" size="10">
							<img style="MARGIN: 1px; CURSOR: hand" onclick="SelectDate(document.getElementById('pk_cometime'),'yyyy-MM-dd',0,0)" height="15" src="image/calendar.gif" width="16">至
								
								<input name="pk_cometime_last" type="text" id="pk_cometime_last" onclick="SelectDate(document.getElementById('pk_cometime_last'),'yyyy-MM-dd',0,0)" readonly="" maxlength="10" size="10" class="pic_border">
							<img style="MARGIN: 1px; CURSOR: hand" onclick="SelectDate(document.getElementById('pk_cometime_last'),'yyyy-MM-dd',0,0)" height="15" src="../users/image/calendar.gif" width="16">
								
								 &nbsp;
                    <select name="pk_cometime_month" id="pk_cometime_month" style="font-weight:bold;">
	<option value="">入库月份</option>
	<option value="1">一月</option>
	<option value="2">二月</option>
	<option value="3">三月</option>
	<option value="4">四月</option>
	<option value="5">五月</option>
	<option value="6">六月</option>
	<option value="7">七月</option>
	<option value="8">八月</option>
	<option value="9">九月</option>
	<option value="10">十月</option>
	<option value="11">十一月</option>
	<option value="12">十二月</option>
</select>
								
								
								
								
								
								
								 <input type="button" id="bt01" onclick="window.location.href='Us_PackageListUpdate.aspx?pk_areaid='+document.getElementById('pk_areaid').value+'&amp;pk_cometime='+document.getElementById('pk_cometime').value+'&amp;pk_cometime_last='+document.getElementById('pk_cometime_last').value+'&amp;pk_cometime_month='+document.getElementById('pk_cometime_month').value+'&amp;skey='+document.getElementById('skey').value;" class="input_bot" value="搜索"></td>
										</tr>
										
										<tr>
											<td width="15" height="30">&nbsp;</td>
											<td width="12" height="150">&nbsp;</td>
											<td width="*" class="hei" align="left" valign="top">
											
				                                <span id="txtShowContent"></span><table class="hei" cellspacing="1" cellpadding="2" width="100%" bgcolor="#3ac3a7" border="0" valign="middle">
				                                   <tbody><tr bgcolor="#CCFFCC" height="25">
					                                 <td class="hei" valign="middle" align="center" width="30"><b>序号</b></td>
					                                 <td class="hei" valign="middle" align="center" width="100"><b>送达方式</b></td>
					                                 <td class="hei" valign="middle" align="center" width="100"><b>美国快递单号</b></td>
					                                 <td class="hei" valign="middle" align="center" width="90"><b>重量(磅)</b></td>
					                                 <td class="hei" valign="middle" align="center" width="70"><b>仓库名称</b></td>
					                                 
					                                 <td class="hei" valign="middle" align="center" width="70"><b>入库日期</b></td>
					                                 
					                                 <td class="hei" valign="middle" align="center" width="90"><b>业务号</b></td>
					                                 
					                                 <!--<td class="hei" vAlign="middle" align="center" width="80"><b>备注信息</b></td>-->
					                                 
					                                 <td class="hei" valign="middle" align="center" width="*"><b>我的备注</b></td>
					                                   <td class="hei" valign="middle" align="center" width="130"><b>操作</b></td>
					                                 
				                                  </tr>
				                                  <tr class="row0" bgcolor="#ffffff"><td nowrap="" align="center" height="26">1 </td><td nowrap="" align="center" height="26">亲自送到库房</td><td nowrap="" align="center" height="26">123</td><td nowrap="" align="center" height="26">1</td><td nowrap="" align="center" height="26">君安仓库</td><td nowrap="" align="middle" height="26">2013/9/12</td><td nowrap="" align="center" height="26"><a href="Us_Mybusiness_Add.aspx?ID=8802"><b>JA2013912039</b></a></td><td nowrap="" align="center" height="26"></td><td nowrap="" align="center" height="26"><a href="Us_PackageList_Add.aspx?ID=14606">添加备注</a>&nbsp;<a href='javascript:if(confirm("您确认提交此包裹-拍照申请-吗？"))  window.location.href="Us_PackageListPhotoAdd.aspx?action=add&pkid=14606"'>拍照</a>&nbsp;<a href='javascript:if(confirm("您确认提交此包裹-退货申请-吗？"))  window.location.href="Us_PackageListReturnAdd.aspx?action=add&pkid=14606"'>退货</a></td></tr>
				                                  <tr height="25" bgcolor="#CCFFCC">
					                                 <td class="hei" valign="middle" align="right" colspan="10">
					                                   <span id="txtShowBar"><table><tbody><tr><td width="100%">&nbsp;<a href="Us_PackageListUpdate.aspx?CurrentPage=1"><b>1</b></a>&nbsp;</td></tr></tbody></table></span>
					                                 </td>
				                                  </tr>
				                                 </tbody></table>
											    
											</td>
										</tr>
										
									</tbody></table>
								</td>
							</tr>	

<?php 
}
?>