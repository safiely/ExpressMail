<?php
require_once 'include.php';
try{
	session_start();
	display_package_record();
}
catch(Exception $e){
	do_html_header('pacakge_record_error!');
	echo $e->getMessage();
	exit();
}
?>


<!-- display 自助录入包裹页面 -->
<?php 
function display_package_record(){
	$title="自助录入包裹";
	do_html_header($title);

	if($title){
		$form="pack2store.php";
		display_comman_header($form);
		display_package_body();
	}
}
?>
<!-- display 自助录入包裹页面 -->



<?php function display_package_body(){

	?>


<tr>
	<td height="199">
		<table cellspacing="0" cellpadding="0" width="100%" border="0">

			<tbody>

				<tr>
					<td height="23" colspan="3"></td>
				</tr>
				<tr>

					<td class="da" width="593" colspan="3" height="30"
						style="text-indent: 26px"><img height="15"
						src="images/tip_arrow3.jpg" width="15">&nbsp;&nbsp;<span
						id="PageTitle_main">自助录入包裹</span>&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td width="15" height="30">&nbsp;</td>
					<td width="10" height="150">&nbsp;</td>
					<td width="*" class="hei" align="left">

						<table width="100%" border="0" cellspacing="0" cellpadding="0"
							class="hei">
							<tbody>
								<tr height="30">
									<td class="hei" height="30">仓库名称：</td>
									<td><select name="pk_areaid_sel" id="pk_areaid_sel"
										onchange="document.getElementById('pk_areaid').value=this.value;">
											<option value="">请选择仓库</option>
											<option value="1">君安仓库</option>

											<option value="2">免税州DE</option>

											<option value="3">免税州OR</option>
									</select> <input name="pk_areaid" type="hidden" id="pk_areaid">
									</td>
								</tr>
								<script>
                                                    if(document.getElementById("pk_areaid").value!="")
                                                    {
                                                        document.getElementById("pk_areaid_sel").value = document.getElementById("pk_areaid").value;
                                                    }
                                                  
                                                  </script>
								<tr height="30">
									<td class="hei" width="120" height="30">包裹送达方式：</td>
									<td><select id="pk_expresssel" name="pk_expresssel"
										tabindex="1"
										onchange="document.getElementById('pk_express').value=this.value;auotweight();">

											<option value="亲自送到库房">亲自送到库房</option>
											<option value="上门取货">上门取货</option>
											<option value="UPS">UPS</option>
											<option value="FEDEX">FEDEX</option>
											<option value="USPS">USPS</option>
											<option value="DHL">DHL</option>
											<option value="ESENDA">ESENDA</option>
											<option value="EMS">EMS</option>
											<option value="ONTRAC">ONTRAC</option>
											<option value="其他">其他</option>
									</select> <input name="pk_express" type="hidden"
										id="pk_express" value="亲自送到库房">
									</td>
								</tr>
								<script>
                                                        if(document.getElementById("pk_express").value!="")
                                                        {
                                                            document.getElementById("pk_expresssel").value = document.getElementById("pk_express").value;
                                                        }
                                                        
                                                        function auotweight()
                                                        {
                                                            if(document.getElementById("pk_express").value=="亲自送到库房"||document.getElementById("pk_express").value=="上门取货")
                                                            {
                                                                document.getElementById("pk_weight").value = "0.00";
                                                            }
                                                            else
                                                            {
                                                                document.getElementById("pk_weight").value = "1.00";
                                                            }
                                                        }
                                                    </script>


								<tr height="30">
									<td class="hei">美国快递单号：</td>
									<td><input name="pk_expressno" type="text" id="pk_expressno"
										maxlength="50" tabindex="2" size="20" class="pic_border">&nbsp;&nbsp;或自编包裹号&nbsp;&nbsp;<font
										color="red">请务必填写正确的美国快递单号</font>
									</td>
								</tr>



								<tr height="30">
									<td class="hei">包裹重量：</td>
									<td><input name="pk_weight" type="text" id="pk_weight"
										maxlength="8" size="10" tabindex="3" value="1.00"
										class="pic_border"
										onkeyup="if(isNaN(value))execCommand('undo')"
										onafterpaste="if(isNaN(value))execCommand('undo')">
										磅&nbsp;&nbsp;此项可保持默认&nbsp;</td>

								</tr>






								<script>
                                                        function selcometime()
                                                        {
                                                            if(document.getElementById('pk_iscome').value=="0")
                                                            {
                                                                document.getElementById('tr_cometime').style.display = "none";
                                                            }
                                                            else
                                                            {
                                                                document.getElementById('tr_cometime').style.display = "";
                                                            }
                                                        }
                                                        
                                                        if(document.getElementById('pk_iscome').value=="1")
                                                        {
                                                            document.getElementById('tr_cometime').style.display = "";
                                                            
                                                            obj   =   document.getElementsByName('pk_iscome_sel');  
                                                            for   (i=0;i<obj.length;i++)
                                                            {      
                                                                if(obj[i].value=="1")
                                                                {
                                                                   obj[i].checked = true;
                                                                }      
                                                            }     
                                                        }
                                                        
                                                    </script>

								<tr>
									<td>货物申报：</td>
									<td width="200" colspan="3">
										<table border="1" cellspacing="10" cellpadding="0"
											align="left">
											<tbody>
												<tr>
													<td>物品名称</td>
													<td>数量</td>
													<td>总价</td>
												</tr>
												<tr>
													<td><input name="item1_name" type="text" id="pk_item1"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item1_num" type="text" id="pk_item1"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item1_price" type="text" id="pk_item1"
														maxlength="50" tabindex="2" size="20" border="0"
														class="pic_border"></td>
												</tr>
												<tr>
													<td><input name="item2_name" type="text" id="pk_item2_name"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item2_num" type="text" id="pk_item2_num"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item2_price" type="text"
														id="pk_item2_price" maxlength="50" tabindex="2" size="20"
														border="0" class="pic_border"></td>
												</tr>
												<tr>
													<td><input name="item3_name" type="text" id="pk_item3_name"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item3_num" type="text" id="pk_item3_num"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item3_price" type="text"
														id="pk_item3_price" maxlength="50" tabindex="2" size="20"
														border="0" class="pic_border"></td>
												</tr>
												<tr>
													<td><input name="item4_name" type="text" id="pk_item4_name"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item4_num" type="text" id="pk_item4_num"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item4_price" type="text"
														id="pk_item4_price" maxlength="50" tabindex="2" size="20"
														border="0" class="pic_border"></td>
												</tr>
												<tr>
													<td><input name="item5_name" type="text" id="pk_item5_name"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item5_num" type="text" id="pk_item5_num"
														maxlength="200" tabindex="2" size="20" border="0"
														class="pic_border"></td>
													<td><input name="item5_price" type="text"
														id="pk_item5_price" maxlength="50" tabindex="2" size="20"
														border="0" class="pic_border"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr height="10"></tr>
								<tr height="30">
									<td class="hei" valign="middle">我的包裹备注：</td>
									<td><textarea name="pk_remark_user" id="pk_remark_user"
											maxlength="500" class="pic_border" rows="10" cols="70"></textarea>
									</td>
								</tr>

								<tr height="30">
									<td width="80"></td>
									<td><input class="input_bot" type="reset" name="" value="取 消"
										onclick="window.history.go(-1);"> <input type="submit"
										name="SendData" value="保 存" id="SendData" class="input_bot"><input
										name="ID" type="hidden" id="ID"><input name="action"
										type="hidden" id="action" value="add">
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
<?php 
}?>