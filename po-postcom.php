<?php
session_start();
include_once 'po-library/po-database.php';
include_once 'po-library/po-function.php';
$val = new Povalidasi;
if (!$_SESSION['submit']){
	header("location:404.php");
}else{
	require_once('po-library/recaptchalib.php');
	$secret = "6LckEgETAAAAAHqx4VFD4zNL96P9UEikD8BHfT28";
	$reCaptcha = new ReCaptcha($secret);
	if($_POST["g-recaptcha-response"]){
		$resp = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}
	if ($resp != null && $resp->success) {
		if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['url']) || empty($_POST['comment'])){
			header("location:404.php");
		}else{
			$id = $val->validasi($_POST['id'],'sql');
			$seotitle = $val->validasi($_POST['seotitle'],'xss');
			$name = $val->validasi($_POST['name'],'xss');
			$email = $val->validasi($_POST['email'],'xss');
			$url = $val->validasi($_POST['url'],'xss');
			$comment = $val->validasi($_POST['comment'],'xss');
			$split_text = explode(" ",$comment);
			$split_count = count($split_text);
			$max = 57;
			for($i = 0; $i <= $split_count; $i++){
				if(strlen($split_text[$i]) >= $max){
					for($j = 0; $j <= strlen($split_text[$i]); $j++){
						$char[$j] = substr($split_text[$i],$j,1);
						if(($j % $max == 0) && ($j != 0)){
							$v_text .= $char[$j] . ' ';
						}else{
							$v_text .= $char[$j];
						}
					}
				}else{
					$v_text .= " " . $split_text[$i] . " ";
				}
			}

			$table = new PoTable('comment');
			$table->save(array(
				'id_post' => $id,
				'name' => $name,
				'email' => $email,
				'url' => $url, 
				'comment' => $v_text,
				'date' => $tgl_sekarang,
				'time' => $jam_sekarang
			));
			unset($_POST);
			echo "<script language='javascript'>
                window.alert('Succesfully Post Comment')
                window.location.href='detailpost/$seotitle';
            </script>";
		}
	}else{
		header("location:404.php");
	}
}
?>