<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
	if (isset($_REQUEST["name"])) {
		include_once '../../../../po-library/po-database.php';
		include_once '../../../../po-library/po-function.php';
		include_once 'PluploadHandler.php';
		PluploadHandler::no_cache_headers();
		PluploadHandler::cors_headers();
		if (!PluploadHandler::handle(array(
			'target_dir' => '../../../../po-content/po-upload/',
			'allow_extensions' => 'jpg,jpeg,gif,png,zip,doc,docx,ppt,pptx,xls,xslx,rar,psd,txt,pdf,mp3,mp4,flv,avi'
		))) {
			die(json_encode(array(
				'OK' => 0, 
				'error' => array(
					'code' => PluploadHandler::get_error_code(),
					'message' => PluploadHandler::get_error_message()
				)
			)));
		} else {
			function po_sanitize_file_name($filename) 
			{
				$special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
				$filename = str_replace($special_chars, '', $filename);
				$filename = preg_replace('/[\s-]+/', '-', $filename);
				$filename = trim($filename, '.-_');
				$filename = strtolower($filename);
				return $filename;
			}
			$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
			$fileType = $_FILES['file']['type'];
			$fileSize = $_FILES['file']['size'];
			$table = new PoTable('media');
			$table->save(array(
				'file_name' => po_sanitize_file_name($fileName),
				'file_type' => $fileType,
				'file_size' => $fileSize,  
				'date' => $tgl_sekarang
			));
			die(json_encode(array('OK' => 1)));
		}
	} else {
		header('location:404.php');
	}
}
?>