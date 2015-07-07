<?php
session_start();
include_once 'po-library/po-database.php';
include_once 'po-library/po-function.php';
$val = new Povalidasi;
if (!$_SESSION['submit']){
	header("location:404.php");
}else{
	if(empty($_POST['email_address'])){
		header("location:404.php");
	}else{
		$tablecari = new PoTable('subscribe');
		$currentCari = $tablecari->numRowBy(email, $_POST['email_address']);
		if ($currentCari > 0){
			header("location:404.php");
		}else{
			$email = $val->validasi($_POST['email_address'],'xss');
			$table = new PoTable('subscribe');
			$table->save(array(
				'email' => $email
			));
			unset($_POST);
			echo "<script language='javascript'>
                window.alert('Succesfully Email Subscribe')
                window.location.href='./';
            </script>";
		}
	}
}
?>