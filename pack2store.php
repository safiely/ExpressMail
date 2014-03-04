<?php
require_once('valid_user.php');



try{
	session_start();
	$pk_areaid=$_POST["pk_areaid"];
	$pk_express=$_POST["pk_express"];
	$pk_expressno=$_POST["pk_expressno"];
	$pk_weight=$_POST["pk_weight"];
	$pk_remark_user=$_POST["pk_remark_user"];
	$connect=db_connect();
	/*
	 *
	* INSERT INTO `package`(`pack_id`, `cid`, `pack_date`, `storage`, `delivermethod`, `tracknumber`, `note`, `pack_weight`, `item1_name`, `item1_num`, `item1_price`, `item2_name`, `item2_num`, `item2_price`, `item3_name`, `item3_num`, `item3_price`, `item4_name`, `item4_num`, `item4_price`, `item5_name`, `item5_num`, `item5_price`, `packagestatus`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],[value-15],[value-16],[value-17],[value-18],[value-19],[value-20],[value-21],[value-22],[value-23],[value-24])
	*/
	//INSERT INTO `package`(`customerid`, `storage`, `delivermethod`, `note`) VALUES ([$_SESSION['cid']],[$pk_areaid],[$pk_express],[$pk_remark_user])
	//$query="INSERT into package (cid,storage,delivermethod,note,pack_weight,item1_name,item1_num,item1_price,item2_name,item2_num,item2_price,item3_name,item3_num,item3_price,item4_name,item4_num,item4_price,item5_name,item5_num,item5_price) values ('".$_SESSION['cid']."','".$_POST['pk_areaid']."','".$_POST['pk_express']."','".$_POST['pk_remark_user']."','".$_POST["pk_weight"]."','".$_POST['item1_name']."','".$_POST['item1_num']."','".$_POST['item1_price']."','".$_POST['item2_name']."','".$_POST['item2_num']."','".$_POST['item2_price']."','".$_POST['item3_name']."','".$_POST['item3_num']."','".$_POST['item3_price']."','".$_POST['item4_name']."','".$_POST['item4_num']."','".$_POST['item4_price']."','".$_POST['item5_name']."','".$_POST['item5_num']."','".$_POST['item5_price'].")";

	
	
	//检查是否是已存在美国单号   有问题： 数字就能判断相同包裹号， 但字母就不行
	$query="SELECT cid from package where tracknumber='"."$pk_expressno"."'";
	$result=mysqli_query($connect,$query);
	if($result->num_rows>0){
		do_html_header("已经存在的美国包裹号!");
		echo "<script type=\"text/javascript\"> alert(\"已经存在的美国包裹号!\")</script>";
		display_member_init();
	}

	else{
		$query="INSERT into package (cid,pack_date,bus_number,delivermethod,tracknumber,note,pack_weight,item1_name,item1_num,item1_price,item2_name,item2_num,item2_price,item3_name,item3_num,item3_price,item4_name,item4_num,item4_price,item5_name,item5_num,item5_price,packagestatus) values ('".$_SESSION['cid']."','".date("Y-m-d")."','".$_SESSION['cid']."XXX".$row['cid'].date("mydHis")."','".$_POST['pk_express']."','".$_POST["pk_expressno"]."','".$_POST["pk_remark_user"]."','".$_POST["pk_weight"]."','".$_POST['item1_name']."','".$_POST['item1_num']."','".$_POST['item1_price']."','".$_POST['item2_name']."','".$_POST['item2_num']."','".$_POST['item2_price']."','".$_POST['item3_name']."','".$_POST['item3_num']."','".$_POST['item3_price']."','".$_POST['item4_name']."','".$_POST['item4_num']."','".$_POST['item4_price']."','".$_POST['item5_name']."','".$_POST['item5_num']."','".$_POST['item5_price']."','"."处理中..."."')";
		$result=mysqli_query($connect,$query);

		if(!$result){
			throw new Exception("Could not excute query when inserting package!");
		}

		//add check form complete code
		else{
			do_html_header("包裹已被录入，正在处理中。。。");
			echo "<script type=\"text/javascript\"> alert(\"包裹已被录入，正在处理中。。。\")</script>";
			display_member_init();
		}
	}

}catch(Exception $e){
	do_html_header('Problem');
	echo $e->getMessage();
	exit();
}
?>