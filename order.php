<?php
require_once 'include.php';


try{
	session_start();
	display_order_form();
}catch(Exception $e){
	do_html_header('login error!');
	echo $e->getMessage();
	exit();
}
?>
<?php 
function db_sender(){
	
}
?>

<!-- display order form -->
<?php function display_order_form(){

	$title="新订单";
	do_html_header($title);
	if($title){
		$form="order_form.php";
		display_comman_header($form);
		//connect the package table to retrive package info
		display_order_body(pack_db_connect());
	}
}?>
<!-- display order form -->


<!-- the package sel checkbox -->
<?php 
function checkbox($pack){
	$i=0;
	while($row=mysqli_fetch_array($pack)){
		$id="pack_".$row[6];
		$text[$i]=$row[0]."/".$row[1]."&nbsp&nbsp重量：".$row[2]."磅[".$row[3]."]"."&nbsp&nbsp".$row[5];
		echo "<input type='checkbox' id=$id value=$row[6] onclick=\"return pack_sel($row[6],$row[2])\">$text[$i]<br>";
		$i++;
	}
}
?>

<?php 
function pack_db_connect(){
	$connect=db_connect();
	/*
	 * SELECT delivermethod,note,pack_weight FROM package where cid=$_SESSION["cid"]
	*/
	$query="SELECT delivermethod,tracknumber,pack_weight,pack_date,storage,packagestatus,pack_id FROM package where cid='".$_SESSION["cid"]."'";
	$result=mysqli_query($connect,$query);
	if(!$result){
		throw new Exception("Could not excute query in the order step!");
	}

	else{
		return $result;
		// 		$num=0;
		// 		while($row=mysqli_fetch_array($result)){
		// 			$array[$num]=$row[0]."/".$row[1]."&nbsp&nbsp重量：".$row[2]."磅[".$row[3]."]"."&nbsp&nbsp".$row[5];
		// 			echo $array[$num++];
		// 		}
		// 		return $array;
	}
}
?>




<?php 
function display_order_body($pack){
	?>
<SCRIPT
	type=text/javascript src="javascript/order.js"></SCRIPT>
<tr>
	<td style="dispaly: none"><input name="user_info" type="hidden"
		id="user_firstname" value=<?php echo $_SESSION['firstname']?>> <input
		name="user_info" type="hidden" id="user_lastname"
		value=<?php echo $_SESSION['lastname']?>> <input name="user_info"
		type="hidden" id="phone" value=<?php echo $_SESSION['phone']?>>
	</td>
</tr>
<tr>
	<td height="199" valign="top">
		<table cellspacing="0" cellpadding="0" width="100%" border="0">

			<tbody>
				<tr>
					<td height="23" colspan="2"></td>
				</tr>
				<tr>

					<td class="da" width="593" colspan="2" height="30"
						style="text-indent: 26px"><img height="15"
						src="images/tip_arrow3.jpg" width="15">&nbsp;&nbsp;创建新业务</td>
				</tr>
				<tr>
					<td width="20" height="30">&nbsp;</td>

					<td width="*" class="hei" align="left" valign="top">


						<table width="100%" border="0" cellspacing="0" cellpadding="5"
							class="hei">
							<tbody>


								<tr height="30">
									<td class="da" height="30" colspan="2">业务号：<font color="green"><b><span
												id="bs_no">待创建</span> </b> </font> &nbsp;&nbsp;<span
										id="bs_state_lab"></span>
									</td>
								</tr>



								<tr height="30">
									<td class="da" height="30" colspan="2" bgcolor="#ebf2fc">
										第一步：选择已入库的美国包裹（若包裹尚未到达仓库可预先虚拟录入包裹信息）&nbsp;&nbsp;&nbsp;</td>
								</tr>

								<tr height="30">
									<td class="da" height="50" style="border: solid 2px #1e93e3"
										background="images/bg.jpg">

										<table width="100%" border="0" cellspacing="0"
											class="allborder" cellpadding="5">
											<tbody>
												<tr>
													<td width="45%" valign="top" style="display: none">
														<div id="selpackageshow">暂无已选包裹</div> <input
														name="pack_all" type="hidden" id="pack_all"> <input
														name="yw_packagesel_edit" type="hidden"
														id="yw_packagesel_edit">
													</td>
													<td width="45%" valign="top"><?php 
													checkbox($pack);
													?>
													</td>
													<!--                                                                     <td width="90%" bgcolor="#f7f7f7" valign="top"> -->
													<!--                                                                         <iframe name="kuaidi100" id="kuaidi100" frameborder="no" src="Us_YundanSelPackage.aspx?bs_isedit=add&amp;pk_areaid=5&amp;seluser=02089&amp;bsno=" height="150" border="0" width="100%" scrolling="auto"> </iframe> -->
													<!--                                                                     </td> -->
												</tr>

												<tr>
													<td height="10" class="da3" colspan="2"><b>已选包裹总重: </b> <input
														type="text" id="pack_weight" name="pack_weight" size="6"
														value="0.00" style="color: red; font-weight: bold"
														class="input_none" readonly=""
														onkeyup="if(isNaN(value))execCommand('undo')"
														onafterpaste="if(isNaN(value))execCommand('undo')">磅

														&nbsp;&nbsp;<span id="tw_package_willprice"><font
															color="red">本业务总费用预估 0 美元，为不影响发货速度，请确保账户余额充足。</font> </span><br>
														<br> <input name="user_yw_fee" type="hidden"
														id="user_yw_fee" value="0"> <input name="bs_real_fee"
														type="hidden" id="bs_real_fee" value="0">
													</td>
												</tr>

											</tbody>
										</table>


									</td>
								</tr>

								<tr>
									<td colspan="2" height="5"></td>
								</tr>

								<tr height="30">
									<td class="da" height="30" colspan="2" bgcolor="#ebf2fc">
										第二步：请选择业务要求，然后填写运单信息&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr height="30">
									<td class="da" height="50">
										<table width="100%" border="0" cellspacing="0"
											class="allborder" cellpadding="0">
											<tbody>
												<tr height="35">

													<td nowrap="" align="left" width="100%"><input type="radio"
														name="bx_type_radio" value="0"
														onclick="return setboxtype('0')">原箱转运&nbsp;&nbsp; <input
														type="radio" name="bx_type_radio" value="1"
														onclick="return setboxtype('1')">合箱转运&nbsp;&nbsp; <input
														type="radio" name="bx_type_radio" value="2"
														onclick="return setboxtype('2')">分箱转运&nbsp;&nbsp;&nbsp;&nbsp;
														<!-- 												<td   type="hidden"> --> <!-- 														创建运单数量：<select name="bs_boxnum" id="bs_boxnum" -->
														<!-- 														disabled="disabled" --> <!-- 														onchange="setydtype(document.getElementById('bs_type').value);"> -->
														<!-- 															<option selected="selected" value="0">0</option> -->
														<!-- 															<option value="1">1</option> --> <!-- 															<option value="2">2</option> -->
														<!-- 															<option value="3">3</option> --> <!-- 															<option value="4">4</option> -->
														<!-- 															<option value="5">5</option> --> <!-- 															<option value="6">6</option> -->
														<!-- 															<option value="7">7</option> --> <!-- 															<option value="8">8</option> -->
														<!-- 															<option value="9">9</option> --> <!-- 															<option value="10">10</option> -->
														<!-- 													</select>&nbsp;&nbsp;一个运单对应一个箱子 --> <input
														name="bx_type" type="hidden" id="bx_type">
														&nbsp;&nbsp;&nbsp;&nbsp;<font color="red"><label
															id="bs_fee_lab"></label> </font>
													</td>
												</tr>

												<tr height="35" style="display: none;" id="text">
													<td nowrap="" align="left" width="100%" class="da"
														style="border: solid 1px #5f5f5f;"><br> &nbsp;&nbsp;&nbsp;<font
														color="red">运单物品名称填写规则必读：</font><br> <br>
														1、物品名称必须写详细。比如：不能笼统地写：衣服，鞋子，保健品，等等。必须写出具体名称：外套，裤子，皮鞋，皮靴，维生素等等。<br>
														<br> 2、如果有多样商品，请在第一栏按以下格式写：外套2，皮鞋2，维生素5….,
														后面数量栏写整个包裹的总数量，价值写总价值。忽略多余的物品栏。<br> <br>
													</td>
												</tr>



												<tr height="35" id="top" style="display: none">

													<td nowrap="" align="left" width="100%">
														<table width="965" border="0" cellspacing="10"
															class="allborder" cellpadding="0">

															<tbody>
																<tr id="trbill_0" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_blue.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/0.jpg"></td>
																									<td width="305" align="left" height="34">
																									<a href="db_sender.php" name="sender_address_0">保存发件人</a>
																									<input
																										class="input_button" type="button"
																										name="bt_sendaddress_0" value="保存发件人"
																										onclick=<?php db_sender();?>> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_0" value="选择发件人"
																										onclick="select_SendAddress('0');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_0"
																										value="新建收货地址" onclick="input_Address('0');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_0" value="选择收货地址"
																										onclick="select_Address_Idc('0');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_0" value="选择身份证"
																										onclick="selIDC('0');"> <label
																										id="yd_idccardID_text_0"
																										name="yd_idccardID_text_0"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>



																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_0"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_0"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_0"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_0"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_0"></label>&nbsp;<label
																										id="address_tel2_0"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_0"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_0"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_0"></label>&nbsp;<label
																														id="address_area_0"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_0"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_0"
																										id="bl_billdel_0"
																										onchange="bl_billdel_fuc('0',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_0"
																										type="hidden" id="yd_sendaddressID_0"> <input
																										name="yd_addressID_0" type="hidden"
																										id="yd_addressID_0"> <input
																										name="yd_idccardID_0" type="hidden"
																										id="yd_idccardID_0" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_0">待创建</span> </font><span
																										id="bl_state_show_0"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_0"
																										id="bl_deliverywaysel_0"
																										onchange="deliverywaysel_fuc('0',this.value);setfeebyweight('0');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_0"
																										type="hidden" id="bl_deliveryway_0"><span
																										id="bl_koufei_show_0"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_0" type="checkbox"
																										id="bl_isservicefee_0" disabled="disabled"><input
																										name="bl_servicefee_0" type="text"
																										id="bl_servicefee_0"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_0" value="0"
																										onclick="getservice_fuc('0');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_0"
																										value="1" onclick="getservice_fuc('0');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_0"
																										value="2" onclick="getservice_fuc('0');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_0"
																										value="3" onclick="getservice_fuc('0');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_0"
																										value="4" onclick="getservice_fuc('0');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_0" type="hidden"
																										id="bl_service_0">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_0_0"
																														onkeyup="get_bl_proname_value('0');"
																														name="bl_pro_name_0_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_0_0" name="bl_pro_num_0_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_0_0"
																														name="bl_pro_dvalue_0_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_0_1"
																														onkeyup="get_bl_proname_value('0');"
																														name="bl_pro_name_0_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_0_1"
																														name="bl_pro_num_0_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_0_1"
																														name="bl_pro_dvalue_0_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_0_2"
																														onkeyup="get_bl_proname_value('0');"
																														name="bl_pro_name_0_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_0_2"
																														name="bl_pro_num_0_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_0_2"
																														name="bl_pro_dvalue_0_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_0_3"
																														onkeyup="get_bl_proname_value('0');"
																														name="bl_pro_name_0_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_0_3"
																														name="bl_pro_num_0_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_0_3"
																														name="bl_pro_dvalue_0_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_0_4"
																														onkeyup="get_bl_proname_value('0');"
																														name="bl_pro_name_0_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_0_4"
																														name="bl_pro_num_0_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_0_4"
																														name="bl_pro_dvalue_0_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('0');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_0"
																											id="bl_proname_0"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>

																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_0"
																																		type="text" id="bl_declarevalue_0"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_0"
																																		type="text" id="bl_insurancesum_0"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('0');setfeebyweight('0');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_0"
																																		type="text" id="bl_insurance_0"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_0"
																																		type="text" id="bl_weight_0"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('0');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_0" type="text"
																																		id="bl_fee_0" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_0"
																																						type="checkbox" id="bl_issetbox_0"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_0"
																																						type="text" id="bl_issetboxfee_0"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_0"
																															id="bl_remark_0"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_0" type="checkbox"
																														id="bl_remarkred_0" style="display: none"
																														onclick="bl_remark_fuc('0');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_0"
																															id="bl_remark_co_0"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_0">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_1" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_blue.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/1.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_1" value="新建发件人"
																										onclick="input_SendAddress('1')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_1" value="选择发件人"
																										onclick="select_SendAddress('1');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_1"
																										value="新建收货地址" onclick="input_Address('1');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_1" value="选择收货地址"
																										onclick="select_Address_Idc('1');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_1" value="选择身份证"
																										onclick="selIDC('1');"> <label
																										id="yd_idccardID_text_1"
																										name="yd_idccardID_text_1"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_1"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_1"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_1"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_1"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_1"></label>&nbsp;<label
																										id="address_tel2_1"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_1"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_1"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_1"></label>&nbsp;<label
																														id="address_area_1"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_1"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_1"
																										id="bl_billdel_1"
																										onchange="bl_billdel_fuc('1',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_1"
																										type="hidden" id="yd_sendaddressID_1"> <input
																										name="yd_addressID_1" type="hidden"
																										id="yd_addressID_1"> <input
																										name="yd_idccardID_1" type="hidden"
																										id="yd_idccardID_1" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_1">待创建</span> </font><span
																										id="bl_state_show_1"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_1"
																										id="bl_deliverywaysel_1"
																										onchange="deliverywaysel_fuc('1',this.value);setfeebyweight('1');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_1"
																										type="hidden" id="bl_deliveryway_1"><span
																										id="bl_koufei_show_1"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_1" type="checkbox"
																										id="bl_isservicefee_1" disabled="disabled"><input
																										name="bl_servicefee_1" type="text"
																										id="bl_servicefee_1"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_1" value="0"
																										onclick="getservice_fuc('1');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_1"
																										value="1" onclick="getservice_fuc('1');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_1"
																										value="2" onclick="getservice_fuc('1');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_1"
																										value="3" onclick="getservice_fuc('1');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_1"
																										value="4" onclick="getservice_fuc('1');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_1" type="hidden"
																										id="bl_service_1">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_1_0"
																														onkeyup="get_bl_proname_value('1');"
																														name="bl_pro_name_1_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_1_0" name="bl_pro_num_1_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_1_0"
																														name="bl_pro_dvalue_1_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_1_1"
																														onkeyup="get_bl_proname_value('1');"
																														name="bl_pro_name_1_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_1_1"
																														name="bl_pro_num_1_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_1_1"
																														name="bl_pro_dvalue_1_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_1_2"
																														onkeyup="get_bl_proname_value('1');"
																														name="bl_pro_name_1_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_1_2"
																														name="bl_pro_num_1_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_1_2"
																														name="bl_pro_dvalue_1_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_1_3"
																														onkeyup="get_bl_proname_value('1');"
																														name="bl_pro_name_1_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_1_3"
																														name="bl_pro_num_1_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_1_3"
																														name="bl_pro_dvalue_1_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_1_4"
																														onkeyup="get_bl_proname_value('1');"
																														name="bl_pro_name_1_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_1_4"
																														name="bl_pro_num_1_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_1_4"
																														name="bl_pro_dvalue_1_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('1');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_1"
																											id="bl_proname_1"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_1"
																																		type="text" id="bl_declarevalue_1"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_1"
																																		type="text" id="bl_insurancesum_1"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('1');setfeebyweight('1');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_1"
																																		type="text" id="bl_insurance_1"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_1"
																																		type="text" id="bl_weight_1"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('1');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_1" type="text"
																																		id="bl_fee_1" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_1"
																																						type="checkbox" id="bl_issetbox_1"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_1"
																																						type="text" id="bl_issetboxfee_1"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_1"
																															id="bl_remark_1"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_1" type="checkbox"
																														id="bl_remarkred_1" style="display: none"
																														onclick="bl_remark_fuc('1');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>

																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_1"
																															id="bl_remark_co_1"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_1">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_2" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_blue.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/2.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_2" value="新建发件人"
																										onclick="input_SendAddress('2')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_2" value="选择发件人"
																										onclick="select_SendAddress('2');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_2"
																										value="新建收货地址" onclick="input_Address('2');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_2" value="选择收货地址"
																										onclick="select_Address_Idc('2');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_2" value="选择身份证"
																										onclick="selIDC('2');"> <label
																										id="yd_idccardID_text_2"
																										name="yd_idccardID_text_2"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_2"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_2"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_2"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_2"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_2"></label>&nbsp;<label
																										id="address_tel2_2"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_2"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_2"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_2"></label>&nbsp;<label
																														id="address_area_2"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_2"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_2"
																										id="bl_billdel_2"
																										onchange="bl_billdel_fuc('2',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_2"
																										type="hidden" id="yd_sendaddressID_2"> <input
																										name="yd_addressID_2" type="hidden"
																										id="yd_addressID_2"> <input
																										name="yd_idccardID_2" type="hidden"
																										id="yd_idccardID_2" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_2">待创建</span> </font><span
																										id="bl_state_show_2"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_2"
																										id="bl_deliverywaysel_2"
																										onchange="deliverywaysel_fuc('2',this.value);setfeebyweight('2');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_2"
																										type="hidden" id="bl_deliveryway_2"><span
																										id="bl_koufei_show_2"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_2" type="checkbox"
																										id="bl_isservicefee_2" disabled="disabled"><input
																										name="bl_servicefee_2" type="text"
																										id="bl_servicefee_2"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_2" value="0"
																										onclick="getservice_fuc('2');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_2"
																										value="1" onclick="getservice_fuc('2');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_2"
																										value="2" onclick="getservice_fuc('2');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_2"
																										value="3" onclick="getservice_fuc('2');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_2"
																										value="4" onclick="getservice_fuc('2');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_2" type="hidden"
																										id="bl_service_2">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_2_0"
																														onkeyup="get_bl_proname_value('2');"
																														name="bl_pro_name_2_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_2_0" name="bl_pro_num_2_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_2_0"
																														name="bl_pro_dvalue_2_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_2_1"
																														onkeyup="get_bl_proname_value('2');"
																														name="bl_pro_name_2_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_2_1"
																														name="bl_pro_num_2_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_2_1"
																														name="bl_pro_dvalue_2_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_2_2"
																														onkeyup="get_bl_proname_value('2');"
																														name="bl_pro_name_2_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_2_2"
																														name="bl_pro_num_2_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_2_2"
																														name="bl_pro_dvalue_2_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_2_3"
																														onkeyup="get_bl_proname_value('2');"
																														name="bl_pro_name_2_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_2_3"
																														name="bl_pro_num_2_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_2_3"
																														name="bl_pro_dvalue_2_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_2_4"
																														onkeyup="get_bl_proname_value('2');"
																														name="bl_pro_name_2_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_2_4"
																														name="bl_pro_num_2_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_2_4"
																														name="bl_pro_dvalue_2_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('2');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_2"
																											id="bl_proname_2"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_2"
																																		type="text" id="bl_declarevalue_2"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_2"
																																		type="text" id="bl_insurancesum_2"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('2');setfeebyweight('2');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_2"
																																		type="text" id="bl_insurance_2"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_2"
																																		type="text" id="bl_weight_2"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('2');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_2" type="text"
																																		id="bl_fee_2" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_2"
																																						type="checkbox" id="bl_issetbox_2"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_2"
																																						type="text" id="bl_issetboxfee_2"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_2"
																															id="bl_remark_2"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_2" type="checkbox"
																														id="bl_remarkred_2" style="display: none"
																														onclick="bl_remark_fuc('2');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_2"
																															id="bl_remark_co_2"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_2">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_3" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_yellow.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/3.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_3" value="新建发件人"
																										onclick="input_SendAddress('3')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_3" value="选择发件人"
																										onclick="select_SendAddress('3');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_3"
																										value="新建收货地址" onclick="input_Address('3');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_3" value="选择收货地址"
																										onclick="select_Address_Idc('3');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_3" value="选择身份证"
																										onclick="selIDC('3');"> <label
																										id="yd_idccardID_text_3"
																										name="yd_idccardID_text_3"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_3"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_3"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_3"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_3"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_3"></label>&nbsp;<label
																										id="address_tel2_3"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_3"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_3"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_3"></label>&nbsp;<label
																														id="address_area_3"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_3"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_3"
																										id="bl_billdel_3"
																										onchange="bl_billdel_fuc('3',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_3"
																										type="hidden" id="yd_sendaddressID_3"> <input
																										name="yd_addressID_3" type="hidden"
																										id="yd_addressID_3"> <input
																										name="yd_idccardID_3" type="hidden"
																										id="yd_idccardID_3" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_3">待创建</span> </font><span
																										id="bl_state_show_3"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_3"
																										id="bl_deliverywaysel_3"
																										onchange="deliverywaysel_fuc('3',this.value);setfeebyweight('3');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_3"
																										type="hidden" id="bl_deliveryway_3"><span
																										id="bl_koufei_show_3"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_3" type="checkbox"
																										id="bl_isservicefee_3" disabled="disabled"><input
																										name="bl_servicefee_3" type="text"
																										id="bl_servicefee_3"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_3" value="0"
																										onclick="getservice_fuc('3');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_3"
																										value="1" onclick="getservice_fuc('3');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_3"
																										value="2" onclick="getservice_fuc('3');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_3"
																										value="3" onclick="getservice_fuc('3');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_3"
																										value="4" onclick="getservice_fuc('3');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_3" type="hidden"
																										id="bl_service_3">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_3_0"
																														onkeyup="get_bl_proname_value('3');"
																														name="bl_pro_name_3_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_3_0" name="bl_pro_num_3_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_3_0"
																														name="bl_pro_dvalue_3_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_3_1"
																														onkeyup="get_bl_proname_value('3');"
																														name="bl_pro_name_3_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_3_1"
																														name="bl_pro_num_3_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_3_1"
																														name="bl_pro_dvalue_3_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_3_2"
																														onkeyup="get_bl_proname_value('3');"
																														name="bl_pro_name_3_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_3_2"
																														name="bl_pro_num_3_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_3_2"
																														name="bl_pro_dvalue_3_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_3_3"
																														onkeyup="get_bl_proname_value('3');"
																														name="bl_pro_name_3_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_3_3"
																														name="bl_pro_num_3_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_3_3"
																														name="bl_pro_dvalue_3_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_3_4"
																														onkeyup="get_bl_proname_value('3');"
																														name="bl_pro_name_3_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_3_4"
																														name="bl_pro_num_3_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_3_4"
																														name="bl_pro_dvalue_3_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('3');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_3"
																											id="bl_proname_3"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_3"
																																		type="text" id="bl_declarevalue_3"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_3"
																																		type="text" id="bl_insurancesum_3"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('3');setfeebyweight('3');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_3"
																																		type="text" id="bl_insurance_3"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_3"
																																		type="text" id="bl_weight_3"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('3');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_3" type="text"
																																		id="bl_fee_3" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_3"
																																						type="checkbox" id="bl_issetbox_3"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_3"
																																						type="text" id="bl_issetboxfee_3"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_3"
																															id="bl_remark_3"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_3" type="checkbox"
																														id="bl_remarkred_3" style="display: none"
																														onclick="bl_remark_fuc('3');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_3"
																															id="bl_remark_co_3"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_3">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_4" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_blue.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/4.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_4" value="新建发件人"
																										onclick="input_SendAddress('4')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_4" value="选择发件人"
																										onclick="select_SendAddress('4');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_4"
																										value="新建收货地址" onclick="input_Address('4');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_4" value="选择收货地址"
																										onclick="select_Address_Idc('4');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_4" value="选择身份证"
																										onclick="selIDC('4');"> <label
																										id="yd_idccardID_text_4"
																										name="yd_idccardID_text_4"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_4"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_4"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_4"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_4"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_4"></label>&nbsp;<label
																										id="address_tel2_4"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_4"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_4"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_4"></label>&nbsp;<label
																														id="address_area_4"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_4"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_4"
																										id="bl_billdel_4"
																										onchange="bl_billdel_fuc('4',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_4"
																										type="hidden" id="yd_sendaddressID_4"> <input
																										name="yd_addressID_4" type="hidden"
																										id="yd_addressID_4"> <input
																										name="yd_idccardID_4" type="hidden"
																										id="yd_idccardID_4" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_4">待创建</span> </font><span
																										id="bl_state_show_4"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_4"
																										id="bl_deliverywaysel_4"
																										onchange="deliverywaysel_fuc('4',this.value);setfeebyweight('4');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_4"
																										type="hidden" id="bl_deliveryway_4"><span
																										id="bl_koufei_show_4"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_4" type="checkbox"
																										id="bl_isservicefee_4" disabled="disabled"><input
																										name="bl_servicefee_4" type="text"
																										id="bl_servicefee_4"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_4" value="0"
																										onclick="getservice_fuc('4');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_4"
																										value="1" onclick="getservice_fuc('4');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_4"
																										value="2" onclick="getservice_fuc('4');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_4"
																										value="3" onclick="getservice_fuc('4');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_4"
																										value="4" onclick="getservice_fuc('4');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_4" type="hidden"
																										id="bl_service_4">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_4_0"
																														onkeyup="get_bl_proname_value('4');"
																														name="bl_pro_name_4_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_4_0" name="bl_pro_num_4_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_4_0"
																														name="bl_pro_dvalue_4_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_4_1"
																														onkeyup="get_bl_proname_value('4');"
																														name="bl_pro_name_4_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_4_1"
																														name="bl_pro_num_4_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_4_1"
																														name="bl_pro_dvalue_4_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_4_2"
																														onkeyup="get_bl_proname_value('4');"
																														name="bl_pro_name_4_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_4_2"
																														name="bl_pro_num_4_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_4_2"
																														name="bl_pro_dvalue_4_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_4_3"
																														onkeyup="get_bl_proname_value('4');"
																														name="bl_pro_name_4_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_4_3"
																														name="bl_pro_num_4_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_4_3"
																														name="bl_pro_dvalue_4_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_4_4"
																														onkeyup="get_bl_proname_value('4');"
																														name="bl_pro_name_4_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_4_4"
																														name="bl_pro_num_4_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_4_4"
																														name="bl_pro_dvalue_4_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('4');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_4"
																											id="bl_proname_4"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_4"
																																		type="text" id="bl_declarevalue_4"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_4"
																																		type="text" id="bl_insurancesum_4"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('4');setfeebyweight('4');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_4"
																																		type="text" id="bl_insurance_4"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_4"
																																		type="text" id="bl_weight_4"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('4');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_4" type="text"
																																		id="bl_fee_4" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_4"
																																						type="checkbox" id="bl_issetbox_4"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_4"
																																						type="text" id="bl_issetboxfee_4"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_4"
																															id="bl_remark_4"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_4" type="checkbox"
																														id="bl_remarkred_4" style="display: none"
																														onclick="bl_remark_fuc('4');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_4"
																															id="bl_remark_co_4"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_4">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_5" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_yellow.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/5.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_5" value="新建发件人"
																										onclick="input_SendAddress('5')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_5" value="选择发件人"
																										onclick="select_SendAddress('5');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_5"
																										value="新建收货地址" onclick="input_Address('5');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_5" value="选择收货地址"
																										onclick="select_Address_Idc('5');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_5" value="选择身份证"
																										onclick="selIDC('5');"> <label
																										id="yd_idccardID_text_5"
																										name="yd_idccardID_text_5"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_5"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_5"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_5"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_5"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_5"></label>&nbsp;<label
																										id="address_tel2_5"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_5"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_5"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_5"></label>&nbsp;<label
																														id="address_area_5"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_5"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_5"
																										id="bl_billdel_5"
																										onchange="bl_billdel_fuc('5',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_5"
																										type="hidden" id="yd_sendaddressID_5"> <input
																										name="yd_addressID_5" type="hidden"
																										id="yd_addressID_5"> <input
																										name="yd_idccardID_5" type="hidden"
																										id="yd_idccardID_5" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_5">待创建</span> </font><span
																										id="bl_state_show_5"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_5"
																										id="bl_deliverywaysel_5"
																										onchange="deliverywaysel_fuc('5',this.value);setfeebyweight('5');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_5"
																										type="hidden" id="bl_deliveryway_5"><span
																										id="bl_koufei_show_5"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_5" type="checkbox"
																										id="bl_isservicefee_5" disabled="disabled"><input
																										name="bl_servicefee_5" type="text"
																										id="bl_servicefee_5"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_5" value="0"
																										onclick="getservice_fuc('5');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_5"
																										value="1" onclick="getservice_fuc('5');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_5"
																										value="2" onclick="getservice_fuc('5');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_5"
																										value="3" onclick="getservice_fuc('5');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_5"
																										value="4" onclick="getservice_fuc('5');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_5" type="hidden"
																										id="bl_service_5">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_5_0"
																														onkeyup="get_bl_proname_value('5');"
																														name="bl_pro_name_5_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_5_0" name="bl_pro_num_5_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_5_0"
																														name="bl_pro_dvalue_5_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_5_1"
																														onkeyup="get_bl_proname_value('5');"
																														name="bl_pro_name_5_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_5_1"
																														name="bl_pro_num_5_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_5_1"
																														name="bl_pro_dvalue_5_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_5_2"
																														onkeyup="get_bl_proname_value('5');"
																														name="bl_pro_name_5_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_5_2"
																														name="bl_pro_num_5_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_5_2"
																														name="bl_pro_dvalue_5_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_5_3"
																														onkeyup="get_bl_proname_value('5');"
																														name="bl_pro_name_5_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_5_3"
																														name="bl_pro_num_5_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_5_3"
																														name="bl_pro_dvalue_5_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_5_4"
																														onkeyup="get_bl_proname_value('5');"
																														name="bl_pro_name_5_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_5_4"
																														name="bl_pro_num_5_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_5_4"
																														name="bl_pro_dvalue_5_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('5');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_5"
																											id="bl_proname_5"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_5"
																																		type="text" id="bl_declarevalue_5"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_5"
																																		type="text" id="bl_insurancesum_5"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('5');setfeebyweight('5');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_5"
																																		type="text" id="bl_insurance_5"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_5"
																																		type="text" id="bl_weight_5"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('5');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_5" type="text"
																																		id="bl_fee_5" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_5"
																																						type="checkbox" id="bl_issetbox_5"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_5"
																																						type="text" id="bl_issetboxfee_5"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_5"
																															id="bl_remark_5"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_5" type="checkbox"
																														id="bl_remarkred_5" style="display: none"
																														onclick="bl_remark_fuc('5');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_5"
																															id="bl_remark_co_5"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_5">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_6" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_blue.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/6.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_6" value="新建发件人"
																										onclick="input_SendAddress('6')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_6" value="选择发件人"
																										onclick="select_SendAddress('6');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_6"
																										value="新建收货地址" onclick="input_Address('6');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_6" value="选择收货地址"
																										onclick="select_Address_Idc('6');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_6" value="选择身份证"
																										onclick="selIDC('6');"> <label
																										id="yd_idccardID_text_6"
																										name="yd_idccardID_text_6"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_6"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_6"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_6"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_6"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_6"></label>&nbsp;<label
																										id="address_tel2_6"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_6"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_6"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_6"></label>&nbsp;<label
																														id="address_area_6"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_6"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_6"
																										id="bl_billdel_6"
																										onchange="bl_billdel_fuc('6',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_6"
																										type="hidden" id="yd_sendaddressID_6"> <input
																										name="yd_addressID_6" type="hidden"
																										id="yd_addressID_6"> <input
																										name="yd_idccardID_6" type="hidden"
																										id="yd_idccardID_6" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_6">待创建</span> </font><span
																										id="bl_state_show_6"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_6"
																										id="bl_deliverywaysel_6"
																										onchange="deliverywaysel_fuc('6',this.value);setfeebyweight('6');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_6"
																										type="hidden" id="bl_deliveryway_6"><span
																										id="bl_koufei_show_6"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_6" type="checkbox"
																										id="bl_isservicefee_6" disabled="disabled"><input
																										name="bl_servicefee_6" type="text"
																										id="bl_servicefee_6"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_6" value="0"
																										onclick="getservice_fuc('6');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_6"
																										value="1" onclick="getservice_fuc('6');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_6"
																										value="2" onclick="getservice_fuc('6');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_6"
																										value="3" onclick="getservice_fuc('6');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_6"
																										value="4" onclick="getservice_fuc('6');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_6" type="hidden"
																										id="bl_service_6">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_6_0"
																														onkeyup="get_bl_proname_value('6');"
																														name="bl_pro_name_6_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_6_0" name="bl_pro_num_6_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_6_0"
																														name="bl_pro_dvalue_6_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_6_1"
																														onkeyup="get_bl_proname_value('6');"
																														name="bl_pro_name_6_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_6_1"
																														name="bl_pro_num_6_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_6_1"
																														name="bl_pro_dvalue_6_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_6_2"
																														onkeyup="get_bl_proname_value('6');"
																														name="bl_pro_name_6_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_6_2"
																														name="bl_pro_num_6_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_6_2"
																														name="bl_pro_dvalue_6_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_6_3"
																														onkeyup="get_bl_proname_value('6');"
																														name="bl_pro_name_6_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_6_3"
																														name="bl_pro_num_6_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_6_3"
																														name="bl_pro_dvalue_6_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_6_4"
																														onkeyup="get_bl_proname_value('6');"
																														name="bl_pro_name_6_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_6_4"
																														name="bl_pro_num_6_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_6_4"
																														name="bl_pro_dvalue_6_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('6');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_6"
																											id="bl_proname_6"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_6"
																																		type="text" id="bl_declarevalue_6"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_6"
																																		type="text" id="bl_insurancesum_6"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('6');setfeebyweight('6');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_6"
																																		type="text" id="bl_insurance_6"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_6"
																																		type="text" id="bl_weight_6"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('6');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_6" type="text"
																																		id="bl_fee_6" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_6"
																																						type="checkbox" id="bl_issetbox_6"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_6"
																																						type="text" id="bl_issetboxfee_6"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_6"
																															id="bl_remark_6"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_6" type="checkbox"
																														id="bl_remarkred_6" style="display: none"
																														onclick="bl_remark_fuc('6');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_6"
																															id="bl_remark_co_6"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_6">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_7" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_yellow.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/7.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_7" value="新建发件人"
																										onclick="input_SendAddress('7')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_7" value="选择发件人"
																										onclick="select_SendAddress('7');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_7"
																										value="新建收货地址" onclick="input_Address('7');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_7" value="选择收货地址"
																										onclick="select_Address_Idc('7');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_7" value="选择身份证"
																										onclick="selIDC('7');"> <label
																										id="yd_idccardID_text_7"
																										name="yd_idccardID_text_7"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_7"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_7"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_7"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_7"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_7"></label>&nbsp;<label
																										id="address_tel2_7"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_7"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_7"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_7"></label>&nbsp;<label
																														id="address_area_7"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_7"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_7"
																										id="bl_billdel_7"
																										onchange="bl_billdel_fuc('7',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_7"
																										type="hidden" id="yd_sendaddressID_7"> <input
																										name="yd_addressID_7" type="hidden"
																										id="yd_addressID_7"> <input
																										name="yd_idccardID_7" type="hidden"
																										id="yd_idccardID_7" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_7">待创建</span> </font><span
																										id="bl_state_show_7"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_7"
																										id="bl_deliverywaysel_7"
																										onchange="deliverywaysel_fuc('7',this.value);setfeebyweight('7');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_7"
																										type="hidden" id="bl_deliveryway_7"><span
																										id="bl_koufei_show_7"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_7" type="checkbox"
																										id="bl_isservicefee_7" disabled="disabled"><input
																										name="bl_servicefee_7" type="text"
																										id="bl_servicefee_7"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_7" value="0"
																										onclick="getservice_fuc('7');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_7"
																										value="1" onclick="getservice_fuc('7');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_7"
																										value="2" onclick="getservice_fuc('7');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_7"
																										value="3" onclick="getservice_fuc('7');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_7"
																										value="4" onclick="getservice_fuc('7');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_7" type="hidden"
																										id="bl_service_7">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_7_0"
																														onkeyup="get_bl_proname_value('7');"
																														name="bl_pro_name_7_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_7_0" name="bl_pro_num_7_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_7_0"
																														name="bl_pro_dvalue_7_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_7_1"
																														onkeyup="get_bl_proname_value('7');"
																														name="bl_pro_name_7_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_7_1"
																														name="bl_pro_num_7_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_7_1"
																														name="bl_pro_dvalue_7_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_7_2"
																														onkeyup="get_bl_proname_value('7');"
																														name="bl_pro_name_7_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_7_2"
																														name="bl_pro_num_7_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_7_2"
																														name="bl_pro_dvalue_7_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_7_3"
																														onkeyup="get_bl_proname_value('7');"
																														name="bl_pro_name_7_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_7_3"
																														name="bl_pro_num_7_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_7_3"
																														name="bl_pro_dvalue_7_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_7_4"
																														onkeyup="get_bl_proname_value('7');"
																														name="bl_pro_name_7_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_7_4"
																														name="bl_pro_num_7_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_7_4"
																														name="bl_pro_dvalue_7_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('7');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_7"
																											id="bl_proname_7"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_7"
																																		type="text" id="bl_declarevalue_7"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_7"
																																		type="text" id="bl_insurancesum_7"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('7');setfeebyweight('7');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_7"
																																		type="text" id="bl_insurance_7"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_7"
																																		type="text" id="bl_weight_7"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('7');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_7" type="text"
																																		id="bl_fee_7" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>

																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_7"
																																						type="checkbox" id="bl_issetbox_7"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_7"
																																						type="text" id="bl_issetboxfee_7"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_7"
																															id="bl_remark_7"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_7" type="checkbox"
																														id="bl_remarkred_7" style="display: none"
																														onclick="bl_remark_fuc('7');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_7"
																															id="bl_remark_co_7"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_7">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_8" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_blue.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/8.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_8" value="新建发件人"
																										onclick="input_SendAddress('8')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_8" value="选择发件人"
																										onclick="select_SendAddress('8');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_8"
																										value="新建收货地址" onclick="input_Address('8');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_8" value="选择收货地址"
																										onclick="select_Address_Idc('8');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_8" value="选择身份证"
																										onclick="selIDC('8');"> <label
																										id="yd_idccardID_text_8"
																										name="yd_idccardID_text_8"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_8"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_8"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_8"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_8"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_8"></label>&nbsp;<label
																										id="address_tel2_8"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_8"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_8"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_8"></label>&nbsp;<label
																														id="address_area_8"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_8"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_8"
																										id="bl_billdel_8"
																										onchange="bl_billdel_fuc('8',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_8"
																										type="hidden" id="yd_sendaddressID_8"> <input
																										name="yd_addressID_8" type="hidden"
																										id="yd_addressID_8"> <input
																										name="yd_idccardID_8" type="hidden"
																										id="yd_idccardID_8" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_8">待创建</span> </font><span
																										id="bl_state_show_8"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_8"
																										id="bl_deliverywaysel_8"
																										onchange="deliverywaysel_fuc('8',this.value);setfeebyweight('8');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_8"
																										type="hidden" id="bl_deliveryway_8"><span
																										id="bl_koufei_show_8"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_8" type="checkbox"
																										id="bl_isservicefee_8" disabled="disabled"><input
																										name="bl_servicefee_8" type="text"
																										id="bl_servicefee_8"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_8" value="0"
																										onclick="getservice_fuc('8');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_8"
																										value="1" onclick="getservice_fuc('8');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_8"
																										value="2" onclick="getservice_fuc('8');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_8"
																										value="3" onclick="getservice_fuc('8');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_8"
																										value="4" onclick="getservice_fuc('8');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_8" type="hidden"
																										id="bl_service_8">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_8_0"
																														onkeyup="get_bl_proname_value('8');"
																														name="bl_pro_name_8_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_8_0" name="bl_pro_num_8_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_8_0"
																														name="bl_pro_dvalue_8_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_8_1"
																														onkeyup="get_bl_proname_value('8');"
																														name="bl_pro_name_8_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_8_1"
																														name="bl_pro_num_8_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_8_1"
																														name="bl_pro_dvalue_8_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_8_2"
																														onkeyup="get_bl_proname_value('8');"
																														name="bl_pro_name_8_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_8_2"
																														name="bl_pro_num_8_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_8_2"
																														name="bl_pro_dvalue_8_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_8_3"
																														onkeyup="get_bl_proname_value('8');"
																														name="bl_pro_name_8_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_8_3"
																														name="bl_pro_num_8_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_8_3"
																														name="bl_pro_dvalue_8_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_8_4"
																														onkeyup="get_bl_proname_value('8');"
																														name="bl_pro_name_8_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_8_4"
																														name="bl_pro_num_8_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_8_4"
																														name="bl_pro_dvalue_8_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('8');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_8"
																											id="bl_proname_8"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_8"
																																		type="text" id="bl_declarevalue_8"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_8"
																																		type="text" id="bl_insurancesum_8"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('8');setfeebyweight('8');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_8"
																																		type="text" id="bl_insurance_8"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_8"
																																		type="text" id="bl_weight_8"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('8');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_8" type="text"
																																		id="bl_fee_8" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>
																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_8"
																																						type="checkbox" id="bl_issetbox_8"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_8"
																																						type="text" id="bl_issetboxfee_8"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_8"
																															id="bl_remark_8"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_8" type="checkbox"
																														id="bl_remarkred_8" style="display: none"
																														onclick="bl_remark_fuc('8');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_8"
																															id="bl_remark_co_8"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_8">
																	<td height="5"></td>
																</tr>

																<tr id="trbill_9" style="display: none;">
																	<td width="945" height="460" valign="top"
																		background="images/bg_yellow.jpg">
																		<table width="100%" border="0" cellspacing="0"
																			cellpadding="5" class="tablebill">
																			<tbody>
																				<tr>
																					<td height="34" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="90"><img src="images/9.jpg"></td>
																									<td width="305" align="left" height="34"><input
																										class="input_button" type="button"
																										name="bt_sendaddress_9" value="新建发件人"
																										onclick="input_SendAddress('9')"> <input
																										class="input_button" type="button"
																										name="bt_sendaddress_sel_9" value="选择发件人"
																										onclick="select_SendAddress('9');">
																									</td>
																									<td width="*"><input class="input_button"
																										type="button" name="bt_address_9"
																										value="新建收货地址" onclick="input_Address('9');">
																										<input class="input_button" type="button"
																										name="bt_address_sel_9" value="选择收货地址"
																										onclick="select_Address_Idc('9');"> <input
																										class="input_button" type="button"
																										name="bt_idcard_sel_9" value="选择身份证"
																										onclick="selIDC('9');"> <label
																										id="yd_idccardID_text_9"
																										name="yd_idccardID_text_9"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_name_9"></label>
																									</td>
																									<td width="98"></td>
																									<td width="285"><label id="address_name_9"></label>
																									</td>
																									<td width="84"></td>
																									<td width="*"><label id="address_code_9"></label>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293"><label id="sendaddress_tel_9"></label>
																									</td>
																									<td width="98"></td>
																									<td width="*"><label id="address_tel_9"></label>&nbsp;<label
																										id="address_tel2_9"></label></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>

																				<tr>
																					<td height="30" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="92"></td>
																									<td width="293">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="sendaddress_address_9"></label></td>
																												</tr>
																												<tr>
																													<td height="30"><label
																														id="sendaddress_code_9"></label></td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="98"></td>
																									<td width="*">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="30" colspan="2"><label
																														id="address_province_9"></label>&nbsp;<label
																														id="address_area_9"></label></td>
																												</tr>
																												<tr>
																													<td height="60" class="tablebill_line"
																														valign="top"
																														style="word-wrap: break-word; word-break: break-all;"><label
																														id="address_address_9"></label></td>

																													<td width="2"></td>
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
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0">
																							<tbody>
																								<tr>
																									<td width="7"></td>
																									<td width="170"><select name="bl_billdel_9"
																										id="bl_billdel_9"
																										onchange="bl_billdel_fuc('9',this.value); ">
																											<option value="0">本运单正常</option>
																											<option selected="selected" value="1">本运单删除</option>
																									</select> <input name="yd_sendaddressID_9"
																										type="hidden" id="yd_sendaddressID_9"> <input
																										name="yd_addressID_9" type="hidden"
																										id="yd_addressID_9"> <input
																										name="yd_idccardID_9" type="hidden"
																										id="yd_idccardID_9" value="">
																									</td>
																									<td width="208"><font style="font-size: 15px;"><span
																											id="bl_no_9">待创建</span> </font><span
																										id="bl_state_show_9"></span>
																									</td>
																									<td width="100"></td>
																									<td width="*"><select
																										name="bl_deliverywaysel_9"
																										id="bl_deliverywaysel_9"
																										onchange="deliverywaysel_fuc('9',this.value);setfeebyweight('9');willprice_fuc();">
																											<option value="">请选择</option>
																											<option value="4">ID发货新张特价</option>
																											<option value="10">非ID普通类</option>
																											<option value="11">非ID特殊类</option>
																									</select> <input name="bl_deliveryway_9"
																										type="hidden" id="bl_deliveryway_9"><span
																										id="bl_koufei_show_9"></span>&nbsp; 免服务费<input
																										name="bl_isservicefee_9" type="checkbox"
																										id="bl_isservicefee_9" disabled="disabled"><input
																										name="bl_servicefee_9" type="text"
																										id="bl_servicefee_9"
																										onkeyup="if(isNaN(value))execCommand('undo');"
																										value="0.00" maxlength="8" class="input_none"
																										onafterpaste="if(isNaN(value))execCommand('undo')"
																										style="color: green; font-weight: bold;"
																										size="4" readonly="">美元</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td height="38" valign="bottom">
																						<table width="100%" border="0" cellspacing="0"
																							cellpadding="0" class="tabletext">
																							<tbody>
																								<tr>
																									<td height="24"></td>
																									<td></td>
																									<td><input type="checkbox"
																										name="bl_service_sel_9" value="0"
																										onclick="getservice_fuc('9');"><b>取出发票</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_9"
																										value="1" onclick="getservice_fuc('9');"><b>加固物品</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_9"
																										value="2" onclick="getservice_fuc('9');"><b>去除广告杂志</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_9"
																										value="3" onclick="getservice_fuc('9');"><b>丢弃鞋盒</b>&nbsp;&nbsp;

																										<input type="checkbox" name="bl_service_sel_9"
																										value="4" onclick="getservice_fuc('9');"><b>加套外箱</b>&nbsp;&nbsp;

																										<input name="bl_service_9" type="hidden"
																										id="bl_service_9">
																									</td>
																								</tr>
																								<tr>
																									<td width="8"></td>
																									<td width="391">

																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td colspan="4" height="4"></td>
																												</tr>
																												<tr height="25">
																													<td width="206" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_name_9_0"
																														onkeyup="get_bl_proname_value('9');"
																														name="bl_pro_name_9_0"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td width="38" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_num_9_0" name="bl_pro_num_9_0"
																														class="input_bottom" maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="134" align="center"
																														valign="bottom"><input type="text"
																														id="bl_pro_dvalue_9_0"
																														name="bl_pro_dvalue_9_0"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_9_1"
																														onkeyup="get_bl_proname_value('9');"
																														name="bl_pro_name_9_1"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_9_1"
																														name="bl_pro_num_9_1" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_9_1"
																														name="bl_pro_dvalue_9_1"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_9_2"
																														onkeyup="get_bl_proname_value('9');"
																														name="bl_pro_name_9_2"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_9_2"
																														name="bl_pro_num_9_2" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_9_2"
																														name="bl_pro_dvalue_9_2"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_9_3"
																														onkeyup="get_bl_proname_value('9');"
																														name="bl_pro_name_9_3"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_9_3"
																														name="bl_pro_num_9_3" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_9_3"
																														name="bl_pro_dvalue_9_3"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>


																												<tr height="25">
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_name_9_4"
																														onkeyup="get_bl_proname_value('9');"
																														name="bl_pro_name_9_4"
																														class="input_bottom" maxlength="100"
																														style="width: 200px; height: 22px;"
																														value=""></td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_num_9_4"
																														name="bl_pro_num_9_4" class="input_bottom"
																														maxlength="5"
																														style="width: 35px; height: 22px;"
																														value="0"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td align="center" valign="bottom"><input
																														type="text" id="bl_pro_dvalue_9_4"
																														name="bl_pro_dvalue_9_4"
																														class="input_bottom" maxlength="8"
																														style="width: 128px; height: 22px;"
																														value="0.00"
																														onkeyup="if(isNaN(value)) execCommand('undo');get_bl_proname_value('9');"
																														onafterpaste="if(isNaN(value))execCommand('undo')">
																													</td>
																													<td width="*"></td>
																												</tr>
																											</tbody>
																										</table> <textarea name="bl_proname_9"
																											id="bl_proname_9"
																											style="width: 377px; height: 131px; border: 0px; overflow-y: auto; display: none;"></textarea>
																									</td>

																									<td width="*" valign="top">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="87" valign="top">
																														<table width="100%" border="0"
																															cellspacing="0" cellpadding="0">
																															<tbody>
																																<tr>
																																	<td height="8"></td>
																																</tr>
																																<tr height="25">
																																	<td width="115">申报价值(美元)</td>
																																	<td width="100">总保额(美元)</td>
																																	<td width="100">保险费(美元)</td>
																																	<td width="100">运单重量(磅)</td>
																																	<td width="*">快递费(美元)</td>
																																</tr>
																																<tr height="30">
																																	<td><input name="bl_declarevalue_9"
																																		type="text" id="bl_declarevalue_9"
																																		readonly="" class="input_none"
																																		maxlength="10"
																																		style="color: green; font-weight: bold; width: 97px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value)) execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurancesum_9"
																																		type="text" id="bl_insurancesum_9"
																																		class="input_bottom" maxlength="8"
																																		style="width: 81px;" value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setinsurance('9');setfeebyweight('9');willprice_fuc();"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_insurance_9"
																																		type="text" id="bl_insurance_9"
																																		readonly="" class="input_none"
																																		maxlength="8" value="0.00"
																																		style="color: green; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_weight_9"
																																		type="text" id="bl_weight_9"
																																		class="input_none" readonly=""
																																		maxlength="8" style="width: 81px;"
																																		value="0.00"
																																		onkeyup="if(isNaN(value))execCommand('undo');setfeebyweight('9');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																	<td><input name="bl_fee_9" type="text"
																																		id="bl_fee_9" class="input_none"
																																		readonly="" maxlength="8" value="0.00"
																																		style="color: Red; font-weight: bold; width: 81px;"
																																		onkeyup="if(isNaN(value))execCommand('undo');"
																																		onafterpaste="if(isNaN(value))execCommand('undo')">
																																	</td>
																																</tr>
																																<tr height="23">
																																	<td colspan="5">
																																		<table width="100%" border="0"
																																			cellspacing="0" cellpadding="0">
																																			<tbody>
																																				<tr>
																																					<td width="85"></td>
																																					<td bgcolor="#daff80" width="102"></td>
																																					<td bgcolor="#daff80" align="right"><input
																																						name="bl_issetbox_9"
																																						type="checkbox" id="bl_issetbox_9"><font
																																						color="green">是否需要有偿打包</font></td>
																																					<td width="5"></td>
																																					<td bgcolor="#daff80">有偿打包费：<input
																																						name="bl_issetboxfee_9"
																																						type="text" id="bl_issetboxfee_9"
																																						onkeyup="if(isNaN(value))execCommand('undo');"
																																						value="0.00" maxlength="8"
																																						class="input_none"
																																						onafterpaste="if(isNaN(value))execCommand('undo')"
																																						style="color: green; font-weight: bold;"
																																						size="7" readonly="">美元
																																					</td>
																																					<td width="10"></td>
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
																													<td><textarea name="bl_remark_9"
																															id="bl_remark_9"
																															style="width: 524px; height: 44px; border: 0px; overflow-y: auto;"></textarea><input
																														name="bl_remarkred_9" type="checkbox"
																														id="bl_remarkred_9" style="display: none"
																														onclick="bl_remark_fuc('9');">
																													</td>
																												</tr>
																											</tbody>
																										</table>

																									</td>
																								</tr>
																								<tr>
																									<td colspan="3">
																										<table width="100%" border="0" cellspacing="0"
																											cellpadding="0">
																											<tbody>
																												<tr>
																													<td height="18"></td>
																												</tr>
																												<tr>
																													<td width="100"></td>
																													<td><textarea name="bl_remark_co_9"
																															id="bl_remark_co_9"
																															style="width: 820px; height: 22px; border: 0px; overflow-y: auto;"
																															readonly=""></textarea></td>
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
																	</td>
																</tr>


																<tr id="tr_tip_9">
																	<td height="0"></td>
																</tr>









															</tbody>
														</table>
													</td>
												</tr>



												<tr height="20">
													<td nowrap="" align="left"><input type="submit"
														name="SendData" value="确定" id="SendData" class="input_bot"
														style="width: 100px; height: 30px; font-size: 14px;"> <input
														name="action" type="hidden" id="action" value="add"> <input
														name="cookieuser" type="hidden" id="cookieuser" value="0">


														<input name="delivery_isvip_hidden" type="hidden"
														id="delivery_isvip_hidden" value="0"> <input
														name="init_default_sendaddress_id_hidden" type="hidden"
														id="init_default_sendaddress_id_hidden" value="4443"> <input
														name="init_default_address_id_hidden" type="hidden"
														id="init_default_address_id_hidden"> <input
														name="ja_isfreeservice_hidden" type="hidden"
														id="ja_isfreeservice_hidden" value="0">
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





<script>
                                                                                                                
//编辑业务物品内容
for (proname_i=0;proname_i<10 ;proname_i++ )
{
    if(document.getElementById('bl_proname_'+proname_i)!=null)
    {
        if(document.getElementById('bl_proname_'+proname_i).value!="")
        {
            var line_Array = document.getElementById('bl_proname_'+proname_i).value.split("~");
            
            for(line_Array_i = 0;line_Array_i < line_Array.length-1;line_Array_i++)
            {   
                document.getElementById("bl_pro_name_"+proname_i+"_"+line_Array_i).value = line_Array[line_Array_i].split("^")[0];
                
                document.getElementById("bl_pro_num_"+proname_i+"_"+line_Array_i).value = line_Array[line_Array_i].split("^")[1];
                
                document.getElementById("bl_pro_dvalue_"+proname_i+"_"+line_Array_i).value = line_Array[line_Array_i].split("^")[2];
            }
        }
                      
    }
}              
                                                                                                                function replacevalue(tempstr)
                                                                                                                {
                                                                                                                    var returnvalue = tempstr;
                                                                                                                    
                                                                                                                    returnvalue =  returnvalue.replace(/\^/g,"");
                                                                                                                    
                                                                                                                    returnvalue =  returnvalue.replace(/~/g,"");
                                                                                                                    
                                                                                                                    return returnvalue;
                                                                                                                }
                                                                                                                
                                                                                                                
                                                                                                                //是否是大于0的数字
                                                                                                                function isVaildValue(tempstr)
                                                                                                                {
                                                                                                                    var returnvalue = true;
                                                                                                                    
                                                                                                                    if(!isNaN(tempstr))
                                                                                                                    {
                                                                                                                        returnvalue = true;
                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                        returnvalue = false;
                                                                                                                    }
                                                                                                                    
                                                                                                                    if(returnvalue)
                                                                                                                    {
                                                                                                                        if(parseFloat(tempstr)>0)
                                                                                                                        {
                                                                                                                            returnvalue = true;
                                                                                                                        }
                                                                                                                        else
                                                                                                                        {
                                                                                                                            returnvalue = false;
                                                                                                                        }
                                                                                                                    }
                                                                                                                    
                                                                                                                    return returnvalue;
                                                                                                                }
                                                                                                                
                                                                                                                function get_bl_proname_value(tempbillnum)
                                                                                                                {
                                                                                                                    var tempvalue = "";
                                                                                                                    
                                                                                                                    var temp_bl_declarevalue = 0;
                                                                                                                    
                                                                                                                    if(replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_0").value)!="" && isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_0").value)) && isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_0").value)))
                                                                                                                    {
                                                                                                                        tempvalue = tempvalue + replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_0").value) + "^" + replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_0").value) + "^" + replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_0").value) + "~";
                                                                                                                        
                                                                                                                        temp_bl_declarevalue = parseFloat(temp_bl_declarevalue) + parseFloat(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_0").value));
                                                                                                                    }
                                                                                                                    
                                                                                                                    if(replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_1").value)!="" && isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_1").value)) && isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_1").value)))
                                                                                                                    {
                                                                                                                        tempvalue = tempvalue + replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_1").value) + "^" + replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_1").value) + "^" + replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_1").value) + "~";
                                                                                                                    
                                                                                                                        temp_bl_declarevalue = parseFloat(temp_bl_declarevalue) + parseFloat(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_1").value));
                                                                                                                    }
                                                                                                                    
                                                                                                                    if(replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_2").value)!="" && isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_2").value)) && isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_2").value)))
                                                                                                                    {
                                                                                                                        tempvalue = tempvalue + replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_2").value) + "^" + replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_2").value) + "^" + replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_2").value) + "~";
                                                                                                                    
                                                                                                                        temp_bl_declarevalue = parseFloat(temp_bl_declarevalue) + parseFloat(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_2").value));
                                                                                                                    }
                                                                                                                    
                                                                                                                    if(replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_3").value)!="" && isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_3").value)) && isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_3").value)))
                                                                                                                    {
                                                                                                                        tempvalue = tempvalue + replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_3").value) + "^" + replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_3").value) + "^" + replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_3").value) + "~";
                                                                                                                    
                                                                                                                        temp_bl_declarevalue = parseFloat(temp_bl_declarevalue) + parseFloat(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_3").value));
                                                                                                                    }
                                                                                                                    
                                                                                                                    if(replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_4").value)!="" && isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_4").value)) && isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_4").value)))
                                                                                                                    {
                                                                                                                        tempvalue = tempvalue + replacevalue(document.getElementById("bl_pro_name_"+tempbillnum+"_4").value) + "^" + replacevalue(document.getElementById("bl_pro_num_"+tempbillnum+"_4").value) + "^" + replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_4").value) + "~";
                                                                                                                    
                                                                                                                        temp_bl_declarevalue = parseFloat(temp_bl_declarevalue) + parseFloat(replacevalue(document.getElementById("bl_pro_dvalue_"+tempbillnum+"_4").value));
                                                                                                                    }
                                                                                                                    
                                                                                                                    document.getElementById("bl_proname_"+tempbillnum).value = tempvalue;
                                                                                                                    
                                                                                                                     //计算本单总申报价值
                                                                                                                    //document.getElementById("bl_declarevalue_"+tempbillnum).value = changeTwoDecimal(temp_bl_declarevalue);
                                                                                                                    
                                                                                                                }


                                                                                                            </script>

<script>
function setinsurance(tempbillnum)
{
    var temp_bl_deliveryway = document.getElementById('bl_deliveryway_'+tempbillnum).value;
    
    var temp_bl_insurancesum = document.getElementById('bl_insurancesum_'+tempbillnum).value;
    
    var temp_sel_insurance = 2;
    
    if(temp_bl_deliveryway!="")
    {
        for (stype_i=0;stype_i<sendtype_Array.length ;stype_i++ )
        {
            if(sendtype_Array[stype_i][0]==temp_bl_deliveryway)
            {                  
                temp_sel_insurance = sendtype_Array[stype_i][5];                                                                      
                break;
            }
        }
        document.getElementById("bl_insurance_"+tempbillnum).value = changeTwoDecimal((parseFloat(temp_bl_insurancesum) * parseFloat(temp_sel_insurance))/100);
    
    }
    else
    {
        alert("请选择本运单发货方式！");
        return false;
    }
    return true;
}


                                                                        function bl_billdel_fuc(tempbillnum,temp_value)
                                                                        {
                                                                            if(document.getElementById('bl_koufei_show_'+tempbillnum).innerHTML=="" || document.getElementById('bl_koufei_show_'+tempbillnum).innerHTML=="<FONT color=red>已扣费：0 美元</FONT>")
                                                                            {
                                                                                if(temp_value=='1')
                                                                                {
                                                                                    if(confirm('您确定此行运单在本次最后操作中删除吗？')) 
                                                                                    {
                                                                                        return true;
                                                                                    } 
                                                                                    else 
                                                                                    {
                                                                                        document.getElementById('bl_billdel_'+tempbillnum).value='0';
                                                                                    } 
                                                                                } 
                                                                            }
                                                                            else
                                                                            {
                                                                                alert("已经扣费的运单无法删除！删除失败");
                                                                                document.getElementById('bl_billdel_'+tempbillnum).value='0';
                                                                                return false;
                                                                            }
                                                                        }
                                                                        </script>

<script>
                            
                            function setbillshow(boxnumstr)
                            {
                                for (box_i=0;box_i<10 ;box_i++ )
                                {
                                    if(document.getElementById('trbill_'+box_i)!=null)
                                    {
                                        document.getElementById('trbill_'+box_i).style.display = "none";
                                        document.getElementById('bl_billdel_'+box_i).value="1";
                                        
                                        document.getElementById('tr_tip_'+box_i).style.display = "none";
                                    }
                                }
                                
                                for (box_i=0;box_i<boxnumstr ;box_i++ )
                                {
                                    document.getElementById('trbill_'+box_i).style.display = "";
                                    document.getElementById('bl_billdel_'+box_i).value="0";
                                    
                                    document.getElementById('tr_tip_'+box_i).style.display = "";
                                }
                            }
                            function setydtype(tempvalue)
                            {
                                if(document.getElementById('yw_packagesel').value!="")
                                {
                                    if(tempvalue=="1" && document.getElementById('yw_packagesel').value.split(",").length<3)
                                    {
                                        alert("合箱至少需要选择二个包裹！");
                                        
                                        var temp_bs_type_radio = document.getElementsByName("bs_type_radio");
                                        
                                        for (temp_i=0;temp_i<temp_bs_type_radio.length ;temp_i++ )
                                        {
                                            if(temp_bs_type_radio[temp_i].value == document.getElementById('bs_type').value)
                                            {
                                                temp_bs_type_radio[temp_i].checked = true;
                                                break;
                                            }
                                        }
                                        return false;   
                                    }
                                    
                                    if(tempvalue=="0"&& document.getElementById('yw_packagesel').value.split(",").length>2)
                                    {
                                        alert("原箱转运只能选择一个包裹！");
                                        
                                        var temp_bs_type_radio = document.getElementsByName("bs_type_radio");
                                        
                                        for (temp_i=0;temp_i<temp_bs_type_radio.length ;temp_i++ )
                                        {
                                            if(temp_bs_type_radio[temp_i].value == document.getElementById('bs_type').value)
                                            {
                                                temp_bs_type_radio[temp_i].checked = true;
                                                break;
                                            }
                                        }
                                        return false;   
                                    }
                                    
                                    document.getElementById('bs_type').value = tempvalue;
                                    
                                    if(tempvalue=="2")
                                    {
                                        document.getElementById('bs_boxnum').disabled = false;
                                        
                                        if(parseInt(document.getElementById('bs_boxnum').value)<2)
                                        {
                                            document.getElementById('bs_boxnum').value="2";
                                        }
                                    }
                                    else
                                    {
                                        document.getElementById('bs_boxnum').disabled = true;
                                        
                                        document.getElementById('bs_boxnum').value="1";
                                    }
                                    
                                    setbillshow(document.getElementById('bs_boxnum').value);
                                    
                                    document.getElementById('trbill_top').style.display = "";
                                    
                                    setfeepage();
                                    
                                    document.getElementById('tr_text').style.display = "";
                                }
                                else
                                {
                                    alert("请先选择包裹！");
                                    return false;                           
                                }
                            }
                           </script>






<script>
                                                
                                                
                                                function deliverywaysel_fuc(tempselnum,tempvalue)
                                                {
                                                    document.getElementById('bl_deliveryway_'+tempselnum).value=tempvalue;
                                                }
                                                
                                                function getservice_fuc(tempselnum)
                                                {
                                                    var tempgetservice = document.getElementsByName("bl_service_sel_"+tempselnum);
                                                    
                                                    var tempstr = "";
                                                    for(var i = 0; i < tempgetservice.length; i++)
                                                    {
                                                        if(tempgetservice[i].checked == true)
                                                        {
                                                           tempstr += tempgetservice[i].value+",";
                                                        }
                                                    }
                                                                        
                                                    if(tempstr.length>0)
                                                    {
                                                        tempstr = tempstr.substring(0,tempstr.length-1);
                                                    }
                                                    
                                                    document.getElementById('bl_service_'+tempselnum).value = tempstr;
                                                    
                                                }
                                                
                                                
                                              </script>

<script>
                                                                   
                                                                   

                                                                    
                                                                    function select_SendAddress(tempbillnum) {

                                                                    var   sFeatures   = "dialogHeight:350px;dialogWidth:950px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnsendaddress=window.showModalDialog( "Us_Alert.asp?isuser=1&url=Us_YundanSelSendAddress&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&cursendaddressselid="+document.getElementById("yd_sendaddressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnsendaddress!=null)
                                                                        {
                                                                            document.getElementById("sendaddress_name_"+tempbillnum).innerHTML=returnsendaddress[0];
                                                                            document.getElementById("sendaddress_tel_"+tempbillnum).innerHTML=returnsendaddress[1];
                                                                            document.getElementById("sendaddress_address_"+tempbillnum).innerHTML=returnsendaddress[2];
                                                                            document.getElementById("sendaddress_code_"+tempbillnum).innerHTML=returnsendaddress[3];
                                                                            document.getElementById("yd_sendaddressID_"+tempbillnum).value=returnsendaddress[4];
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                                    function input_Address(tempbillnum) {

                                                                    var   sFeatures   = "dialogHeight:300px;dialogWidth:700px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnaddress=window.showModalDialog( "Us_Alert.asp?isuser=1&url=Us_YundanSelAddressAdd&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&curaddressselid="+document.getElementById("yd_addressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnaddress!=null)
                                                                        {
                                                                            document.getElementById("address_name_"+tempbillnum).innerHTML=returnaddress[0];
                                                                            document.getElementById("address_province_"+tempbillnum).innerHTML=returnaddress[1];
                                                                            document.getElementById("address_area_"+tempbillnum).innerHTML=returnaddress[2];
                                                                            document.getElementById("address_tel_"+tempbillnum).innerHTML=returnaddress[3];
                                                                            document.getElementById("address_tel2_"+tempbillnum).innerHTML=returnaddress[4];
                                                                            document.getElementById("address_address_"+tempbillnum).innerHTML=returnaddress[5];
                                                                            document.getElementById("address_code_"+tempbillnum).innerHTML=returnaddress[6];
                                                                            
                                                                            document.getElementById("yd_addressID_"+tempbillnum).value=returnaddress[7];
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                                    function select_Address(tempbillnum) {

                                                                    var   sFeatures   = "dialogHeight:350px;dialogWidth:950px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnaddress=window.showModalDialog( "Us_Alert.asp?isuser=1&url=Us_YundanSelAddress&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&curaddressselid="+document.getElementById("yd_addressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnaddress!=null)
                                                                        {
                                                                            document.getElementById("address_name_"+tempbillnum).innerHTML=returnaddress[0];
                                                                            document.getElementById("address_province_"+tempbillnum).innerHTML=returnaddress[1];
                                                                            document.getElementById("address_area_"+tempbillnum).innerHTML=returnaddress[2];
                                                                            document.getElementById("address_tel_"+tempbillnum).innerHTML=returnaddress[3];
                                                                            document.getElementById("address_tel2_"+tempbillnum).innerHTML=returnaddress[4];
                                                                            document.getElementById("address_address_"+tempbillnum).innerHTML=returnaddress[5];
                                                                            document.getElementById("address_code_"+tempbillnum).innerHTML=returnaddress[6];
                                                                            
                                                                            document.getElementById("yd_addressID_"+tempbillnum).value=returnaddress[7];
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                                    //地址和身份证联合选择
                                                                    function select_Address_Idc(tempbillnum) {

                                                                    var   sFeatures   = "dialogHeight:350px;dialogWidth:950px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnaddress=window.showModalDialog( "Us_Alert.asp?isuser=1&url=Us_YundanSelAddress&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&curaddressselid="+document.getElementById("yd_addressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnaddress!=null)
                                                                        {
                                                                            document.getElementById("address_name_"+tempbillnum).innerHTML=returnaddress[0];
                                                                            document.getElementById("address_province_"+tempbillnum).innerHTML=returnaddress[1];
                                                                            document.getElementById("address_area_"+tempbillnum).innerHTML=returnaddress[2];
                                                                            document.getElementById("address_tel_"+tempbillnum).innerHTML=returnaddress[3];
                                                                            document.getElementById("address_tel2_"+tempbillnum).innerHTML=returnaddress[4];
                                                                            document.getElementById("address_address_"+tempbillnum).innerHTML=returnaddress[5];
                                                                            document.getElementById("address_code_"+tempbillnum).innerHTML=returnaddress[6];
                                                                            
                                                                            document.getElementById("yd_addressID_"+tempbillnum).value=returnaddress[7];
                                                                            
                                                                            if(returnaddress[8]!="" && returnaddress[9]!="" && returnaddress[9]!="0")
                                                                            {
                                                                                document.getElementById("yd_idccardID_text_"+tempbillnum).innerHTML=returnaddress[8];
                                                                                            
                                                                                document.getElementById("yd_idccardID_"+tempbillnum).value=returnaddress[9];
                                                                            }
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                                    
                                                                    function selIDC(tempbillnum) {
                                                                    
                                                                        var   sFeatures   = "dialogHeight:350px;dialogWidth:950px;dialogTop:10px;dialogLeft:10px;help:no;status:yes;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                        
                                                                        var returnIdcCard=window.showModalDialog( "Us_Alert.asp?isuser=1&url=Us_YundanSelIDCard&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&curidccardselid="+document.getElementById("yd_idccardID_"+tempbillnum).value, " ",sFeatures);
                                                                                    
                                                                        if(returnIdcCard!=null)
                                                                        {
                                                                            document.getElementById("yd_idccardID_text_"+tempbillnum).innerHTML=returnIdcCard[0];
                                                                                            
                                                                            document.getElementById("yd_idccardID_"+tempbillnum).value=returnIdcCard[1];
                                                                        }
                                                                    }
                                                                    
                                                                    
                                                                   
                                                                   function inputSendAddress(tempbillnum) {
                                                                   
                                                                    var   sFeatures   = "dialogHeight:250px;dialogWidth:690px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnsendaddress=window.showModalDialog( "Us_Alert.asp?url=Us_YundanSelSendAddressAdd&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&cursendaddressselid="+document.getElementById("yd_sendaddressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnsendaddress!=null)
                                                                        {
                                                                            document.getElementById("sendaddress_show_"+tempbillnum).innerHTML=returnsendaddress[0];
                                                                            document.getElementById("yd_sendaddressID_"+tempbillnum).value=returnsendaddress[1];
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                                    function selectSendAddress(tempbillnum) {

                                                                    var   sFeatures   = "dialogHeight:350px;dialogWidth:950px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnsendaddress=window.showModalDialog( "Us_Alert.asp?url=Us_YundanSelSendAddress&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&cursendaddressselid="+document.getElementById("yd_sendaddressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnsendaddress!=null)
                                                                        {
                                                                            document.getElementById("sendaddress_show_"+tempbillnum).innerHTML=returnsendaddress[0];
                                                                            document.getElementById("yd_sendaddressID_"+tempbillnum).value=returnsendaddress[1];
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                </script>

<script>
                                                                   
                                                                   function inputAddress(tempbillnum) {

                                                                    var   sFeatures   = "dialogHeight:300px;dialogWidth:700px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnaddress=window.showModalDialog( "Us_Alert.asp?url=Us_YundanSelAddressAdd&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&curaddressselid="+document.getElementById("yd_addressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnaddress!=null)
                                                                        {
                                                                            document.getElementById("address_show_"+tempbillnum).innerHTML=returnaddress[0];
                                                                            document.getElementById("yd_addressID_"+tempbillnum).value=returnaddress[1];
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                                    function selectAddress(tempbillnum) {

                                                                    var   sFeatures   = "dialogHeight:350px;dialogWidth:950px;dialogTop:10px;dialogLeft:10px;help:no;status:no;scroll:auto;resizable:yes;dialogHide:1 " ;
                                                                    var returnaddress=window.showModalDialog( "Us_Alert.asp?url=Us_YundanSelAddress&seluserno=02089&blno="+ document.getElementById("bl_no_"+tempbillnum).innerHTML +"&curaddressselid="+document.getElementById("yd_addressID_"+tempbillnum).value, " ",sFeatures);
                                                                    
                                                                        if(returnaddress!=null)
                                                                        {
                                                                            document.getElementById("address_show_"+tempbillnum).innerHTML=returnaddress[0];
                                                                            document.getElementById("yd_addressID_"+tempbillnum).value=returnaddress[1];
                                                                        }
                                                                       
                                                                    }
                                                                    
                                                                    
                                                                    
                                                                    
                                                </script>

<script>
                                                    function bl_remark_fuc(tempbillnum)
                                                    {
                                                        if(document.getElementById('bl_remark_co_'+tempbillnum).style.color=="red")
                                                        {
                                                            document.getElementById('bl_remark_co_'+tempbillnum).style.color="#000000";
                                                            document.getElementById('bl_remark_co_'+tempbillnum).style.fontWeight="";
                                                        }
                                                        else
                                                        {
                                                            document.getElementById('bl_remark_co_'+tempbillnum).style.color="red";
                                                            document.getElementById('bl_remark_co_'+tempbillnum).style.fontWeight="bold";
                                                        }
                                                    }


function checkForm(){
    
    if(document.getElementById('yw_packagesel').value=="")
    {
        alert("请选择包裹！");
	    return false;
    }
    
    if(document.getElementById('bs_type').value=="")
    {
        alert("请选择业务要求！");
	    return false;
    }
    
    var realbillnum = 0;
    
    for (tr_i=0;tr_i<10 ;tr_i++ )
    {
         if(document.getElementById('trbill_'+tr_i)!=null)
         {
            if(document.getElementById('trbill_'+tr_i).style.display != "none" && document.getElementById('bl_billdel_'+tr_i).value=="0")
            {
                if(document.getElementById('bl_deliveryway_'+tr_i).value=="")
                {
                    alert("第"+ (parseInt(tr_i)+1) +"个运单：发货方式不能为空！");
                    document.getElementById('bl_deliverywaysel_'+tr_i).focus();
	                return false;
	                break;
                }
                
                if(document.getElementById('action').value=="edit")
                {
                    if(document.getElementById('yd_sendaddressID_'+tr_i).value=="" || document.getElementById('yd_sendaddressID_'+tr_i).value=="0")
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：发件人地址不能为空！");
                        document.getElementById('bl_servicefee_'+tr_i).focus();
	                    return false;
                    }
                    
                    if(document.getElementById('yd_addressID_'+tr_i).value=="" || document.getElementById('yd_addressID_'+tr_i).value=="0")
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：收货人地址不能为空！");
                        document.getElementById('bl_servicefee_'+tr_i).focus();
	                    return false;
                    }
                }
                else
                {
                    if(document.getElementById("sendaddress_name_"+tr_i).innerHTML=="")
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：发件人不能为空！且您没有设置默认发件人");
                        document.getElementById('bt_sendaddress_sel_'+tr_i).focus();
	                    return false;
                    }
                    
                    if(document.getElementById("address_name_"+tr_i).innerHTML=="")
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：收货地址不能为空！且您没有设置默认收获地址");
                        document.getElementById('bt_address_sel_'+tr_i).focus();
	                    return false;
                    }
                }
                
                //验证物品内容
                
                if(replacevalue(document.getElementById("bl_pro_name_"+tr_i+"_0").value)!="")
                {
                    if(!isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tr_i+"_0").value)) || !isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tr_i+"_0").value)) )
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：运单内物品数量和总价必须大于0！");
                        document.getElementById("bl_pro_name_"+tr_i+"_0").focus();
	                    return false;
                    }
                }
                
                if(replacevalue(document.getElementById("bl_pro_name_"+tr_i+"_1").value)!="")
                {
                    if(!isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tr_i+"_1").value)) || !isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tr_i+"_1").value)) )
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：运单内物品数量和总价必须大于0！");
                        document.getElementById("bl_pro_name_"+tr_i+"_1").focus();
	                    return false;
                    }
                }
                
                if(replacevalue(document.getElementById("bl_pro_name_"+tr_i+"_2").value)!="")
                {
                    if(!isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tr_i+"_2").value)) || !isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tr_i+"_2").value)) )
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：运单内物品数量和总价必须大于0！");
                        document.getElementById("bl_pro_name_"+tr_i+"_2").focus();
	                    return false;
                    }
                }
                
                if(replacevalue(document.getElementById("bl_pro_name_"+tr_i+"_3").value)!="")
                {
                    if(!isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tr_i+"_3").value)) || !isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tr_i+"_3").value)) )
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：运单内物品数量和总价必须大于0！");
                        document.getElementById("bl_pro_name_"+tr_i+"_3").focus();
	                    return false;
                    }
                }
                
                if(replacevalue(document.getElementById("bl_pro_name_"+tr_i+"_4").value)!="")
                {
                    if(!isVaildValue(replacevalue(document.getElementById("bl_pro_num_"+tr_i+"_4").value)) || !isVaildValue(replacevalue(document.getElementById("bl_pro_dvalue_"+tr_i+"_4").value)) )
                    {
                        alert("第"+ (parseInt(tr_i)+1) +"个运单：运单内物品数量和总价必须大于0！");
                        document.getElementById("bl_pro_name_"+tr_i+"_4").focus();
	                    return false;
                    }
                }
                
                
                if(document.getElementById('bl_proname_'+tr_i).value=="")
                {
                    alert("第"+ (parseInt(tr_i)+1) +"个运单：运单内物品名称不能为空！");
                    document.getElementById("bl_pro_name_"+tr_i+"_0").focus();
	                return false;
                }
                
                
                
                realbillnum++;
                
            }
         }
    }
    

    
    if(!parseInt(realbillnum)>0)
    {
        alert("本次业务最少需要产生一个运单！");
        return false;
    }
    else
    {
        if(parseInt(realbillnum)<2 && document.getElementById('bs_type').value=="2")
        {
            
            alert("分箱转运业务最少需要产生二个运单！");
            return false;
        }
    }
    
    document.getElementById('bs_boxnum').disabled = false;
    document.getElementById('bs_boxnum').value = realbillnum;//真正箱子数
    
    for (tr_i=0;tr_i<10 ;tr_i++ )
    {
         if(document.getElementById('trbill_'+tr_i)!=null)
         {
            if(document.getElementById('trbill_'+tr_i).style.display != "none" && document.getElementById('bl_billdel_'+tr_i).value=="0")
            {
                document.getElementById('bl_isservicefee_'+tr_i).disabled = false;
            }
         }
    }
    
    return true;
}
                                                </script>


<script>


 

 
 function issigndata()
 {
    if(confirm("您确定签收本业务吗？"))
    {
        return true;
    }
    else
    {
        return false;
    }
 }
}
 
</script>
<script
	type="text/javascript" async="" src="http://back.5ihaitao.com/cnzz.js"></script>
<script
	type="text/javascript" async="" src="http://back.5ihaitao.com/cnzz.js"></script>
<script type="text/javascript">var vglnk = {api_url: '//api.viglink.com/api', key: '084c74521c465af0d8f08b63422103cc'};</script>
<script
	type="text/javascript" async=""
	src="http://cdn.viglink.com/api/vglnk.js"></script>
<script type="text/javascript">var vglnk = {api_url: '//api.viglink.com/api', key: '084c74521c465af0d8f08b63422103cc'};</script>
<script
	type="text/javascript" async=""
	src="http://cdn.viglink.com/api/vglnk.js"></script>
</body>
</html>
<?php 
}
?>


