<?php
include_once '../po-library/po-database.php';
include_once '../po-library/po-function.php';
function anti_injection($data){
	$filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
	return $filter;
}
$username = anti_injection($_POST['username']);
$email = anti_injection($_POST['email']);
$pass = anti_injection($_POST['password']);
$passmd5 = anti_injection(md5($_POST['password']));
$repass = anti_injection($_POST['re-password']);
if (!ctype_alnum($username) OR !ctype_alnum($pass) OR !ctype_alnum($repass)){
	header('location:register.php?errormsg=1');
}else{
	if(!(preg_match("/^[\.A-z0-9_\-\+]+@((gmail)|(yahoo)|(ymail)|(rocketmail)|(hotmail)|(mail)|(telkom)|(plaza)|(inbox)|(lifedeary)|(aim)|(aol))+.((com)|(co.id)|(edu)|(net))$/", $email))){
		header('location:register.php?errormsg=2');
	}else{
		$table = new PoTable('users');
		$currentEmail = $table->findBy(email, $email);
		$currentEmail = $currentEmail->current();
		if ($currentEmail > 0){
			header('location:register.php?errormsg=3');
		}else{
			if(strlen($pass) >= 6){
				if($pass == $repass){
					$currentUser = $table->findBy(username, $username);
					$currentUser = $currentUser->current();
					if ($currentUser > 0){
						header('location:register.php?errormsg=6');
					}else{
						$tableuser = new PoTable('users');
						$users = $tableuser->findAll('id_user', 'ASC');
						foreach($users as $user){
							$user = $user->id_user;
						}
						$id_user = $user + 1;
						$table = new PoTable('users');
						$table->save(array(
							'id_user' => $id_user,
							'username' => $username,
							'password' => $passmd5,
							'nama_lengkap' => 'Your Name',
							'email' => $email, 
							'no_telp' => '08xxxxxxxxxx',
							'bio' => "No matter how exciting or significant a person''s life is, a poorly written biography will make it seem like a snore. On the other hand, a good biographer can draw insight from an ordinary life-because they recognize that even the most exciting life is an ordinary life! After all, a biography isn''t supposed to be a collection of facts assembled in chronological order; it''s the biographer''s interpretation of how that life was different and important.",
							'userpicture' => '',
							'level' => '3',
							'tgl_daftar' => $tgl_sekarang,
							'blokir' => 'Y',
							'id_session' => $passmd5
						));
						$tableset = new PoTable('setting');
						$currentSet = $tableset->findBy(id_setting, '1');
						$currentSet = $currentSet->current();
						$website_name = $currentSet->website_name;
						$website_url = $currentSet->website_url;
						$website_email = $currentSet->website_email;
						$to	= "$username <$email>";
						$from = "$website_name <$website_email>";
						$subject = "Email Account Activation For $website_name";
						$message = "<html>
							<body>
								Indonesia :<br />
								-----------<br />
								Hi $username,<br />
								Jika anda tidak pernah mendaftarkan akun di $website_name, silahkan untuk menghiraukan email ini.<br />
								Tetapi jika benar Anda telah membuat akun di $website_name, maka silahkan untuk mengklik tautan (link) di bawah ini untuk mengaktifkan akun Anda :<br /><br />
								<a href=\"$website_url/po-adminboard/activation.php?activeuser=$username&key=$passmd5\" title=\"Account Activation\">$website_url/po-adminboard/activation.php?activeuser=$username&key=$passmd5</a><br /><br />
								Setelah link tersebut diklik maka akun Anda telah diaktifkan dan telah terverifikasi, silahkan login dengan data berikut :<br /><br />
								--------------------<br />
								Username : $username<br />
								Password : $pass<br />
								--------------------<br /><br />
								Salam hangat,<br />
								$website_name.<br /><br /><br />
								English :<br />
								-----------<br />
								Hi $username,<br />
								If you have never registered account in $website_name, please to ignore this email.<br />
								But if you really are registered account in $website_name, please to click on a link below to activated yout account :<br /><br />
								<a href=\"$website_url/po-adminboard/activation.php?activeuser=$username&key=$passmd5\" title=\"Account Activation\">$website_url/po-adminboard/activation.php?activeuser=$username&key=$passmd5</a><br /><br />
								Then automatically after you click a link above, your account have registered and verificated, please login with data :<br /><br />
								--------------------<br />
								Username : $username<br />
								Password : $pass<br />
								--------------------<br /><br />
								Warm regards,<br />
								$website_name.
							</body>
						</html>";
						$headers  = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
						$headers .= "From: " . $from . "\r\n";

						mail($to, $subject, $message, $headers);
						header('location:200.php');
					}
				}else{
					header('location:register.php?errormsg=5');
				}
			}else{
				header('location:register.php?errormsg=4');
			}
		}
	}
}
?>