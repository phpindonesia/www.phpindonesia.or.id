<?php
include_once '../po-library/po-database.php';
function anti_injection($data){
	$filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
	return $filter;
}
$emailforgot = anti_injection($_POST['email']);
if (!(preg_match("/^([0-9a-zA-Z]+[-._+&amp;])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$/", $emailforgot))){
	header('location:404.php');
}else{
	$table = new PoTable('users');
	$currentUser = $table->findBy(email, $emailforgot);
	$currentUser = $currentUser->current();
		if ($currentUser > 0){
			$forgotkey = md5(microtime() . $_SERVER['REMOTE_ADDR'] . '#$&^%$#' . mt_rand());
			$data = array(
				'forget_key' => $forgotkey
			);
			$table->updateBy('email', $emailforgot, $data);
			
			$tableset = new PoTable('setting');
			$currentSet = $tableset->findBy(id_setting, '1');
			$currentSet = $currentSet->current();
			$website_name = $currentSet->website_name;
			$website_url = $currentSet->website_url;
			$website_email = $currentSet->website_email;
			$username = $currentUser->username;
			$nama_lengkap = $currentUser->nama_lengkap;

			$to	= "$nama_lengkap <$emailforgot>";
			$from = "$website_name <$website_email>";
			$subject = "Forgot Password For $website_name";
			$message = "<html>
				<body>
					Indonesia :<br />
					-----------<br />
					Hi $nama_lengkap,<br />
					Jika anda tidak pernah meminta pesan informasi tentang lupa password di $website_name, silahkan untuk menghiraukan email ini.<br />
					Tetapi jika anda memang yang meminta pesan informasi ini, maka silahkan untuk mengklik tautan (link) di bawah ini :<br /><br />
					<a href=\"$website_url/po-adminboard/recover.php?forgetuser=$username&forgetkey=$forgotkey\" title=\"Recover Password\">$website_url/po-adminboard/recover.php?forgetuser=$username&forgetkey=$forgotkey</a><br /><br />
					Kemudian secara otomatis setelah anda mengklik tautan (link) di atas, password anda akan diganti menjadi password default yaitu : <b>123456</b>.<br />
					Silahkan untuk login dengan password tersebut kemudian ganti password default ini dengan password yang lebih aman.<br /><br />
					Salam hangat,<br />
					$website_name.<br /><br /><br />
					English :<br />
					-----------<br />
					Hi $nama_lengkap,<br />
					If you have never requested message information about forgotten password in $website_name, please to ignore this email.<br />
					But if you really are asking for messages of this information, then please to click on a link below :<br /><br />
					<a href=\"$website_url/po-adminboard/recover.php?forgetuser=$username&forgetkey=$forgotkey\" title=\"Recover Password\">$website_url/po-adminboard/recover.php?forgetuser=$username&forgetkey=$forgotkey</a><br /><br />
					Then automatically after you click a link above, your password will be changed to the default password is : <b>123456</b>.<br />
					Please to log in with the password and then change the default password to a more secure password.<br /><br />
					Warm regards,<br />
					$website_name.
				</body>
			</html>";
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			$headers .= "From: " . $from . "\r\n";

			mail($to, $subject, $message, $headers);
			header('location:200.php');
		}else{
			header('location:404.php');
		}
}
?>