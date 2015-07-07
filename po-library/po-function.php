<?php
include_once "timezone.php";

$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$tgl_skrg = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln = array(1=> "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

function timezoneList(){
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));
    $tempTimezones = array();
    foreach($timezoneIdentifiers as $timezoneIdentifier){
        $currentTimezone = new DateTimeZone($timezoneIdentifier);
        $tempTimezones[] = array(
            'offset' => (int)$currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier
        );
    }
    function sort_list($a, $b){
        return ($a['offset'] == $b['offset']) 
            ? strcmp($a['identifier'], $b['identifier'])
            : $a['offset'] - $b['offset'];
    }
    usort($tempTimezones, "sort_list");
    $timezoneList = array();
    foreach($tempTimezones as $tz){
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
            $tz['identifier'];
    }
    return $timezoneList;
}

class Povalidasi{
	function __construct(){}
	function validasi($str, $tipe){
        switch($tipe){
			default:
			case'sql':
				$d = array('-','/','\\',',','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','%','$','^','&','*','=','?','+');
				$str = str_replace($d, '', $str);
				$str = stripcslashes($str);	
				$str = htmlspecialchars($str);				
				$str = preg_replace('/[^A-Za-z0-9]/','',$str);				
				return intval($str);
			break;
			case'xss':
				$d = array ('\\','#',';','\'','"','[',']','{','}',')','(','|','`','~','!','%','$','^','*','=','?','+');
				$str = str_replace($d, '', $str);
				$str = stripcslashes($str);	
				$str = htmlspecialchars($str);
				return $str;
			break;
		}
	}
	function extension($path) {
		$file = pathinfo($path);
		if(file_exists($file['dirname'].'/'.$file['basename'])){
			return $file['basename'];
		}
	}
}

function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}	

function seo_title($s){
    $c = array (' ');
    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
    $s = str_replace($d, '', $s);
    $s = strtolower(str_replace($c, '-', $s));
    return $s;
}

function UploadImage($fupload_name){
	$vdir_upload = "../../../po-content/po-upload/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

	$im_src = imagecreatefromjpeg($vfile_upload);
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	$dst_width = 390;
	$dst_height = ($dst_width/$src_width)*$src_height;
	$im = imagecreatetruecolor($dst_width,$dst_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
	imagejpeg($im,$vdir_upload . "medium-" . $fupload_name);

	imagedestroy($im_src);
	imagedestroy($im);
}

function UploadUser($fupload_name){
	$vdir_upload = "../../../po-content/po-upload/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

	$im_src = imagecreatefromjpeg($vfile_upload);
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	$dst_width = 512;
	$dst_height = 512;
	$im = imagecreatetruecolor($dst_width,$dst_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
	imagejpeg($im,$vdir_upload . "user-" . $fupload_name);

	imagedestroy($im_src);
	imagedestroy($im);
	unlink("../../../po-content/po-upload/$fupload_name");
}

function UploadBanner($fupload_name, $size){
	$vdir_upload = "../../../po-content/po-banner/";
	$vfile_upload = $vdir_upload . $fupload_name;

	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

	$im_src = imagecreatefromjpeg($vfile_upload);
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	if ($size=='180'){
		$dst_width = 180;
		$dst_height = 180;
		$im = imagecreatetruecolor($dst_width,$dst_height);
		imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		imagejpeg($im,$vdir_upload . "ban-" . $fupload_name, 100);
	}else{
		$dst_width = 480;
		$dst_height = 80;
		$im = imagecreatetruecolor($dst_width,$dst_height);
		imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		imagejpeg($im,$vdir_upload . "ban-" . $fupload_name, 100);
	}

	imagedestroy($im_src);
	imagedestroy($im);
	unlink("../../../po-content/po-banner/$fupload_name");
}

function deleteDir($dirname){
	// Sanity check
    if (!file_exists($dirname)){
        return false;
    }
    // Simple delete for a file
    if (is_file($dirname) || is_link($dirname)){
        return unlink($dirname);
    }
    // Create and iterate stack
    $stack = array($dirname);
    while($entry = array_pop($stack)){
        // Watch for symlinks
        if (is_link($entry)){
            unlink($entry);
            continue;
        }
        // Attempt to remove the directory
        if (@rmdir($entry)){
            continue;
        }
        // Otherwise add it to the stack
        $stack[] = $entry;
        $dh = opendir($entry);
        while(false !== $child = readdir($dh)){
            // Ignore pointers
            if ($child === '.' || $child === '..') {
                continue;
            }
            // Unlink files and add directories to stack
            $child = $entry . DIRECTORY_SEPARATOR . $child;
            if (is_dir($child) && !is_link($child)) {
                $stack[] = $child;
            } else {
                unlink($child);
            }
        }
        closedir($dh);
    }
    return true;
}

function addhttp($url){
    if (!preg_match("@^[hf]tt?ps?://@", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}

function autolink($str){
	$str = eregi_replace("([[:space:]])((f|ht)tps?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $str); //http
	$str = eregi_replace("([[:space:]])(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $str); // www.
	$str = eregi_replace("([[:space:]])([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","\\1<a href=\"mailto:\\2\">\\2</a>", $str); // mail
	$str = eregi_replace("^((f|ht)tp:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $str); //http
	$str = eregi_replace("^(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"http://\\1\" target=\"_blank\">\\1</a>", $str); // www.
	$str = eregi_replace("^([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $str); // mail
	return $str;
}

function cuthighlight($option, $data, $long){
	$content = $data;
	if ($option == "post"){
		$content = html_entity_decode($content);
		$content = strip_tags($content);
		$content = substr($content,0,$long);
		$content = substr($content,0,strrpos($content," "));
	}else{
		$content = substr($content,0,$long);
	}
	return $content;
}

class Paging{
	function cariPosisi($batas){
		if(empty($_GET['page'])){
			$posisi=0;
			$_GET['page']=1;
		}else{
			$posisi = ($_GET['page']-1) * $batas;
		}
		return $posisi;
	}

	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	function navHalaman($halaman_aktif, $jmlhalaman, $website_url, $mod, $title, $num){
		$link_halaman = "";

		if($halaman_aktif > 1){
			$prev = $halaman_aktif-1;
			$link_halaman .= "<li><a href='$website_url/$mod/$title/$prev'>Prev</a></li>";
		}else{
			$link_halaman .= "<li class='disabled'><a>Prev</a></li>";
		}

		if($num == "1"){
			$angka = ($halaman_aktif > 3 ? "<li class='disabled'><a>...</a></li>" : " ");
			for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
				if ($i < 1)
				continue;
				$angka .= "<li><a href='$website_url/$mod/$title/$i'>$i</a></li>";
			}
			$angka .= "<li class='active'><a>$halaman_aktif</a></li>";
			for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
				if($i > $jmlhalaman)
				break;
				$angka .= "<li><a href='$website_url/$mod/$title/$i'>$i</a></li>";
			}
			$angka .= ($halaman_aktif+2<$jmlhalaman ? "<li class='disabled'><a>...</a></li><li><a href='$website_url/$mod/$title/$jmlhalaman'>$jmlhalaman</a></li>" : " ");
			$link_halaman .= "$angka";
		}

		if($halaman_aktif < $jmlhalaman){
			$next = $halaman_aktif+1;
			$link_halaman .= "<li><a href='$website_url/$mod/$title/$next'>Next</a></li>";
		}else{
			$link_halaman .= "<li class='disabled'><a>Next</a></li>";
		}
		return $link_halaman;
	}
}
?>