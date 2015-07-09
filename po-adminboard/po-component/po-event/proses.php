<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:../../404.php');
}else{
include_once '../../../po-library/po-database.php';
include_once '../../../po-library/po-function.php';

$val = new Povalidasi;
$mod = $_POST['mod'];
$act = $_POST['act'];

// Delete Event
if ($mod=='event' AND $act=='delete'){
	$id = $val->validasi($_POST['id'],'sql');
	$tabledel = new PoTable('event');
	$tabledel->deleteBy('id_event', $id);
	header('location:../../admin.php?mod='.$mod);
}

// Input Event
elseif ($mod=='event' AND $act=='input'){
$title = $val->validasi($_POST['title'],'xss');
$seotitle = seo_title($title);
$start = $val->validasi($_POST['start'],'xss');
$end = $val->validasi($_POST['end'],'xss');
$allday = $val->validasi($_POST['allday'],'xss');
$data = $_POST['content'];
$data = stripslashes($data);
$eutf = htmlspecialchars($data,ENT_QUOTES);
$color = $val->validasi($_POST['color'],'xss');
	$table = new PoTable('event');
	$table->save(array(
		'title' => $title,
		'start' => $start,
		'end' => $end,
		'allday' => $allday,
		'content' => $eutf,
		'seotitle' => $seotitle,
		'color' => $color
	));
	header('location:../../admin.php?mod='.$mod);
}

// Edit Event
elseif ($mod=='event' AND $act=='update'){
$id = $val->validasi($_POST['id'],'sql');
$title = $val->validasi($_POST['title'],'xss');
$seotitle = seo_title($title);
$data = $_POST['content'];
$data = stripslashes($data);
$eutf = htmlspecialchars($data,ENT_QUOTES);
$color = $val->validasi($_POST['color'],'xss');
$active = $val->validasi($_POST['active'],'xss');
	$data = array(
		'title' => $title,
		'content' => $eutf,
		'seotitle' => $seotitle,
		'color' => $color,
		'active' => $active
	);
	$table = new PoTable('event');
	$table->updateBy('id_event', $id, $data);
	header('location:../../admin.php?mod='.$mod);
}

// Edit Event Drag
elseif ($mod=='event' AND $act=='updatedrag'){
$id = $val->validasi($_POST['id'],'sql');
$start = $val->validasi($_POST['start'],'xss');
$end = $val->validasi($_POST['end'],'xss');
$allday = 'true';
	$data = array(
		'start' => $start,
		'end' => $end,
		'allday' => $allday
	);
	$table = new PoTable('event');
	$table->updateBy('id_event', $id, $data);
	header('location:../../admin.php?mod='.$mod);
}
elseif ($mod=='event' AND $act=='uploadgroupevent'){
	$filename = $_FILES['eventfile']['tmp_name'];
	$color    = $val->validasi($_POST['color'],'xss');
	/*
	 * Upload facebook group event
	 */
	for ($i=1; $i <= 12; $i++) { 
		/*
		 * Get event month
		 * Locale : EN
		 */
		$monthlong[$i]  = date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));
		$monthshort[$i] = date("M", mktime(0, 0, 0, $i+1, 0, 0, 0));
	}
	$monthreverselong  = array_flip($monthlong);
	$monthreverseshort = array_flip($monthshort);
	$handle = fopen($filename, "r");
	$result = fread($handle, filesize($filename));
	fclose($handle);
	$stripdash = explode('-----------------------------------------------', $result);
	$x         = 0;
	foreach ($stripdash as $key => $value) {
		// Strip dash between event
		$x++;
		$stripline = explode("\n", $value);
		$y = 0;
		$z = 0;
		foreach ($stripline as $key2 => $value2) {
			// Strip line between entry event
			$y++;
			$value2 = trim($value2);
			if(!empty($value2)){
				$z++;
				if($z == 1){
					// Title always in the first line
					$resultdata[$x]['title']    = $value2;
					$resultdata[$x]['seotitle'] = str_replace('[', '', $value2);
					$resultdata[$x]['seotitle'] = str_replace(']', '', $resultdata[$x]['seotitle']);
					$resultdata[$x]['seotitle'] = str_replace(' - ', ' ', $resultdata[$x]['seotitle']);
					$resultdata[$x]['seotitle'] = str_replace(' ', '-', $resultdata[$x]['seotitle']);
					$resultdata[$x]['seotitle'] = strtolower($resultdata[$x]['seotitle']);
					$resultdata[$x]['seotitle'] = stripslashes(htmlspecialchars($resultdata[$x]['seotitle'],ENT_QUOTES));
				} elseif ($z == 2){
					/*
					 * Second line always be date and time, but may be differ through the date may be all day or time-between or date-between
					 */
					$stripdate                   = explode(' to ', $value2); // Strip date-between date format
					if(count($stripdate) > 1){
						/*
						 * date-between format
						 * Example : Jun 14, 2014 at 09:00 to Jun 15, 2014 at 17:00
						 */
						$stripdatetime[0] = explode(' at ', $stripdate[0]);
						$stripdatetime[1] = explode(' at ', $stripdate[1]);

						$stripday[0] = explode(' ', $stripdatetime[0][0]);
						$stripday[1] = explode(' ', $stripdatetime[1][0]);

						$resultdata[$x]['starttime'] = $stripdatetime[0][1];
						$resultdata[$x]['endtime']   = $stripdatetime[1][1];

						$resultdata[$x]['startdate'] = $stripday[0][2].'-'.$monthreverseshort[$stripday[0][0]].'-'.(int)$stripday[0][1];
						$resultdata[$x]['enddate']   = $stripday[1][2].'-'.$monthreverseshort[$stripday[1][0]].'-'.(int)$stripday[1][1];

						$resultdata[$x]['start']     = $resultdata[$x]['startdate'].' '.$resultdata[$x]['starttime'];
						$resultdata[$x]['end']       = $resultdata[$x]['enddate'].' '.$resultdata[$x]['endtime'];
						$resultdata[$x]['allday']    = 'false';
					}else{
						/*
						 * One-day format
						 * Example : Wednesday, July 16, 2014 at 15:00
						 */
						$stripdatetime = explode(' at ', $value2);
						$stripday      = explode(' ', $stripdatetime[0]);

						$realtime                    = explode(' - ', $stripdatetime[1]);
						$resultdata[$x]['date']      = $stripday[3].'-'.$monthreverselong[$stripday[1]].'-'.(int)$stripday[2];
						if(empty($realtime[0])){
							$resultdata[$x]['allday'] = 'true';
							$resultdata[$x]['start']  = $resultdata[$x]['date'].' 00:00';
							$resultdata[$x]['end']    = $resultdata[$x]['date'].' 00:00';
						}else{
							$resultdata[$x]['allday']    = 'false';
							$resultdata[$x]['starttime'] = $realtime[0];
							$resultdata[$x]['endtime']   = (!empty($realtime[1])) ? $realtime[1] : $realtime[0];
							$resultdata[$x]['start']     = $resultdata[$x]['date'].' '.$resultdata[$x]['starttime'];
							$resultdata[$x]['end']       = $resultdata[$x]['date'].' '.$resultdata[$x]['endtime'];
						}
					}
					$resultdata[$x]['time']      = $value2;
				}
				$data = trim($value);
				$data = stripslashes($data);
				$eutf = htmlspecialchars($data,ENT_QUOTES);

				$resultdata[$x]['content'] = $eutf; //Overall content
			}
		}
	}
	// echo '<pre>';print_r($resultdata);echo '</pre>';exit();
	$copyfile = $dir['con'].'event/success/';
	if(!is_readable($copyfile.$_FILES['eventfile']['name'])){
		$table = new PoTable('event');
		foreach ($resultdata as $key => $value) {
			$table->save(array(
				'title'    => $value['title'],
				'start'    => $value['start'],
				'end'      => $value['end'],
				'allday'   => $value['allday'],
				'content'  => $value['content'],
				'seotitle' => $value['seotitle'],
				'color'    => $color
			));
		}
	}
	move_uploaded_file($_FILES['eventfile']['tmp_name'], $copyfile.$_FILES['eventfile']['name']);
	header('location:../../admin.php?mod='.$mod);
}
}
?>