<?php
require_once 'include.php';
require_once 'DB_Connect/db_connection.php';

session_start();
try{
	display_pkg_send();
	$business_num;

}catch(Exception $e){
	do_html_header('Problem');
	echo $e->getMessage();
	exit();
}

function display_pkg_send(){

	$title="会员服务系统";
	do_html_header($title);
	if($title){
	  	$form="asdfasdf.php";
		display_comman_header($form);
		display_pkg_form();
	}
}

function display_pkg_form() {
$conn = db_connect();
$result = $conn->query("select * from package");
?>

<html>
<style type="text/css" media="all">@import url("css/default.css"); </style>
<tr>
								<td height="199">
									<table cellspacing="0" cellpadding="0" width="100%" border="0" >
									    <tbody><tr>
											<td colspan="3" height="10"></td>
										</tr>
										<tr>
											<td height="13"></td>
										</tr>
										
										<tr>
											<td class="da" width="100%" colspan="3" height="30" style="text-indent:26px"><img height="15" src="images/tip_arrow3.jpg" width="15">&nbsp;&nbsp;已发包裹&nbsp;&nbsp;&nbsp;&nbsp;<input name="skey" type="text" id="skey" size="15" maxlength="30" class="pic_border">&nbsp;
											
					<!--  					<select name="pk_areaid_sel" id="pk_areaid_sel" onchange="document.getElementById('pk_areaid').value=this.value;">
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
					-->				
								
								
								
								
								
					 <input type="button" id="bt01" onclick="onStateChange()" class="input_bot" value="搜索"></td>
										</tr>
										
										<tr>
											<td width="15" height="30">&nbsp;</td>
											<td width="12" height="150">&nbsp;</td>
											<td width="*" class="hei" align="left" valign="top">
											
				                                <span id="txtShowContent"></span><table class="hei" id="hiddenTable" cellpadding="2" width="100%" bgcolor="#3ac3a7" border="0" valign="middle" style="display:none">
				                                   <tbody><tr bgcolor="#CCFFCC" height="25">
					                                 <td class="hei" valign="middle" align="center" width="30"><b>序号</b></td>
					                                 <td class="hei" valign="middle" align="center" width="90"><b>业务号</b></td>
					                                 <td class="hei" valign="middle" align="center" width="100"><b>美国快递单号</b></td>
					                                 <td class="hei" valign="middle" align="center" width="100"><b>送达方式</b></td>					                                 
					                                 <td class="hei" valign="middle" align="center" width="90"><b>重量(磅)</b></td>
					                                 <td class="hei" valign="middle" align="center" width="70"><b>入库日期</b></td>
					                                 <td class="hei" valign="middle" align="center" width="70"><b>包裹状态</b></td>
					                                 
					                                 
					                                 
					                                 
					                                 
					                                 <!--<td class="hei" vAlign="middle" align="center" width="80"><b>备注信息</b></td>-->
					                                 
					                                 <!-- <td class="hei" valign="middle" align="center" width="*"><b>我的备注</b></td> -->
					                                  <!-- <td class="hei" valign="middle" align="center" width="130"><b>操作</b></td> --> 
					                                 
				                                  </tr>
				                             
<?php 
	if ($result) {
	$Page_size=5;
	$count = $result->num_rows;
	$page_count = ceil($count/$Page_size);
	$init=1;
	$page_len=7;
	$max_p=$page_count;
	$pages=$page_count;
	$i=1;
	//判断当前页码
	if(empty($_GET['page'])||$_GET['page']<0){
		$page=1;
	}else {
		$page=$_GET['page'];
	}
	$offset=$Page_size*($page-1);
	$result = $conn->query("select * from package limit $offset,$Page_size");
	
	while ($row = $result->fetch_array()){ 
	
?>
				                                 			
	<tr class="row0" bgcolor="#ffffff">
		<td nowrap="" align="center" height="26"><?php echo $i++;?> </td>
		<td nowrap="" align="center" height="26"><b><?php echo $row['bus_number']?></b></td>
		<td nowrap="" align="center" height="26"><?php echo $row['tracknumber']?></td>
		<td nowrap="" align="center" height="26"><?php echo $row['delivermethod']?></td>		
		<td nowrap="" align="center" height="26"><?php echo $row['pack_weight']?></td>
		<td nowrap="" align="middle" height="26"><?php echo $row['pack_date']?></td>
		<td nowrap="" align="center" height="26"><?php echo $row['packagestatus']?></td>
				
		<!-- <td nowrap="" align="center" height="26"></td><td nowrap="" align="center" height="26"><a href="Us_PackageList_Add.aspx?ID=14606">添加备注</a>&nbsp;<a href='javascript:if(confirm("您确认提交此包裹-拍照申请-吗？"))  window.location.href="Us_PackageListPhotoAdd.aspx?action=add&pkid=14606"'>拍照</a>&nbsp;<a href='javascript:if(confirm("您确认提交此包裹-退货申请-吗？"))  window.location.href="Us_PackageListReturnAdd.aspx?action=add&pkid=14606"'>退货</a></td></tr> -->
<?php
	}
	
	$page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数
	$pageoffset = ($page_len-1)/2;//页码个数左右偏移量
	
	$key='<div class="page">';
	$key.="<span>$page/$pages</span> "; //第几页,共几页
	if($page!=1){
		$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1\">第一页</a> "; //第一页
		$key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\">上一页</a>"; //上一页
	}else {
		$key.="第一页 ";//第一页
		$key.="上一页"; //上一页
	}
	if($pages>$page_len){
		//如果当前页小于等于左偏移
		if($page<=$pageoffset){
			$init=1;
			$max_p = $page_len;
		}else{//如果当前页大于左偏移
			//如果当前页码右偏移超出最大分页数
			if($page+$pageoffset>=$pages+1){
				$init = $pages-$page_len+1;
			}else{
				//左右偏移都存在时的计算
				$init = $page-$pageoffset;
				$max_p = $page+$pageoffset;
			}
		}
	}
	for($i=$init;$i<=$max_p;$i++){
		if($i==$page){
			$key.=' <span>'.$i.'</span>';
		} else {
			$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a>";
		}
	}
	if($page!=$pages&&$pages!=0){
		$key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">下一页</a> ";//下一页
		$key.="<a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">最后一页</a>"; //最后一页
	}else {
		$key.="下一页 ";//下一页
		$key.="最后一页"; //最后一页
	}
	$key.='</div>';
	}
?>
				                                  
				                                  <tr height="25" bgcolor="#CCFFCC">
					                                 <td class="hei" valign="middle" align="right" colspan="10">
					                                   <span id="txtShowBar">
					                                   <table>
					                                   <tbody>
					                                   <tr>
					                                   	<td width="100%">&nbsp;<div align="center"><?php echo $key?></div>&nbsp;</td>
					                                   	</tr></tbody></table></span>
					                                 </td>
				                                  </tr>
				                                 </tbody></table>
											    
											</td>
										</tr>
										
									</tbody></table>
								</td>
							</tr>	
</html>
<?php 
}

function search_bus($bus_num) {
	$conn = db_connect();
	$result = $conn->query("select * from package where bus_number ='".$bus_num."'");
	
}

?>
<script type="text/javascript">
	function onStateChange() {

		if (document.getElementById("skey").value) {
			document.getElementById("hiddenTable").setAttribute("style", "display:");
		} else{		
			alert("请输入查询单号-业务号！");
		}
	}
</script>
