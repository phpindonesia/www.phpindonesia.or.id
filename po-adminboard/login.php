<?php
include_once '../po-library/po-database.php';
function anti_injection($data){
	$filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
	return $filter;
}
$mod = $_POST['mod'];
$act = $_POST['act'];
if ($mod=='login' AND $act=='searchlocktype'){
    $username = anti_injection($_POST['username']);
    $table = new PoTable('users');
    $currentUser = $table->findByAnd(username, $username, blokir, "N");
    $currentUser = $currentUser->current();
    echo $currentUser->locktype;
} elseif ($mod=='login' AND $act=='proclogin') {
    $username = anti_injection($_POST['username']);
    $pass = anti_injection(md5($_POST['password']));
    if (!ctype_alnum($username) OR !ctype_alnum($pass)){
        header('location:index.php?errormsg=1');
    }else{
        $table = new PoTable('users');
        $currentUser = $table->findByLogin(username, $username, password, $pass, blokir, "N");
        $currentUser = $currentUser->current();
        if ($currentUser > 0){
            session_start();
            include_once "timeout.php";
            $_SESSION['iduser'] = $currentUser->id_user;
            $_SESSION['namauser'] = $currentUser->username;
            $_SESSION['namalengkap'] = $currentUser->nama_lengkap;
            $_SESSION['passuser'] = $currentUser->password;
            $_SESSION['leveluser'] = $currentUser->level;
            $_SESSION['login'] = 1;
            timer();
            $sid_lama = session_id();
            session_regenerate_id();
            $sid_baru = session_id();
            $sesi = array(
                'id_session' => $sid_baru
            );
            $table->updateBy('username', $username, $sesi);
            header('location:admin.php?mod=home');
        }else{
            header('location:index.php?errormsg=2');
        }
    }
}
?>