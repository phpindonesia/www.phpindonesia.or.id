<?php if ($mod==""){
	header('location:../../404.php');
}else{
	if ($member_register == "Y"){
?>
<!-- 
*******************************************************
	Include Header Template
******************************************************* 
-->
<?php include_once "po-content/$folder/header.php"; ?>


<!-- 
*******************************************************
	Main Content Template
******************************************************* 
-->



<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php include_once "po-content/$folder/footer.php"; ?>
<?php
	}else{
		header('location:404.php');
	}
}
?>