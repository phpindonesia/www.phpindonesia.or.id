<?php
session_start();
include_once 'po-library/po-database.php';
include_once 'po-library/po-function.php';
$val = new Povalidasi;
if (!$_SESSION['submit']){
	header("location:404.php");
}else{
	if(empty($_POST['name_contact']) || empty($_POST['email_contact']) || empty($_POST['subject_contact']) || empty($_POST['message_contact'])){
		header("location:404.php");
	}else{
		$name_contact = $val->validasi($_POST['name_contact'],'xss');
		$email_contact = $val->validasi($_POST['email_contact'],'xss');
		$subject_contact = $val->validasi($_POST['subject_contact'],'xss');
		$message_contact = $val->validasi($_POST['message_contact'],'xss');
		$message = "<html>
			<body>
				Name : $name_contact<br />
				Email : $email_contact<br />
				Message : $message_contact<br /><br />
				Send Date : $hari_ini, $tgl_skrg-$bln_sekarang-$thn_sekarang ($jam_sekarang WIB)
			</body>
			</html>";
		$table = new PoTable('contact');
		$table->save(array(
			'name_contact' => $name_contact,
			'email_contact' => $email_contact,
			'subjek_contact' => $subject_contact, 
			'message_contact' => $message
		));
		unset($_POST);
		echo "<script language='javascript'>
            window.alert('Succesfully Send Message')
            window.location.href='contact';
        </script>";
	}
}
?>