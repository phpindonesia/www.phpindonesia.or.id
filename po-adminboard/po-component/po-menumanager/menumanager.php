<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
include 'po-component/po-menumanager/includes/config.php';
include 'po-component/po-menumanager/includes/functions.php';
switch($_GET[act]){
  default:
	$tablemenu = new PoTable('menu_group');
	$menus = $tablemenu->numRow();
	if ($menus != "0"){
		/**
		 * PoController
		 * This is the base class for all controllers
		 * Every controller will extend this class
		 */
		class PoController {
			protected $db;

			/**
			 * Constructor. Initialize database connection
			 */
			public function __construct() {
				include 'po-component/po-menumanager/includes/db.php';
				$this->db = new DB;
				$this->db->Connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
			}

			/**
			 * Includes the view file and display the data
			 *
			 * @param string $view_file
			 * @param array $data
			 */
			protected function view($view_file, $data = '') {
				if (is_array($data)) {
					extract($data);
				}
				$file = 'po-component/po-menumanager/templates/' . $view_file . '.php';
				if (file_exists($file)) {
					include $file;
				} else {
					die("Cannot include $view_file");
				}
			}
		}
		/**
		 * default controller & method
		 */
		$controller = 'menu';
		$method = 'menumanager';

		/**
		 * url structure: index.php?act=controller.method
		 */
		if (isset($_GET['act'])) {
			$act = explode('.', $_GET['act']);
			$controller = $act[0];
			if (isset($act[1])) {
				$method = $act[1];
			}
		}

		$controller_file = 'po-component/po-menumanager/modules/' . $controller . '.php';
		if (file_exists($controller_file)) {
			include $controller_file;
			$Class_name = ucfirst($controller);
			$instance = new $Class_name;
			if (!is_callable(array($instance, $method))) {
				die("Cannot call method $method");
			}
			$instance->$method();
		} else {
			$controller_file = 'po-component/po-menumanager/modules/menu.php';
			include $controller_file;
			$instance = new Menu;
			$instance->menumanager();
		}
		break;
	}else{
		$table = new PoTable('menu_group');
		$table->save(array(
			'id' => '1',
			'title' => 'Main Menu'
		));
		/**
		 * PoController
		 * This is the base class for all controllers
		 * Every controller will extend this class
		 */
		class PoController {
			protected $db;

			/**
			 * Constructor. Initialize database connection
			 */
			public function __construct() {
				include 'po-component/po-menumanager/includes/db.php';
				$this->db = new DB;
				$this->db->Connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
			}

			/**
			 * Includes the view file and display the data
			 *
			 * @param string $view_file
			 * @param array $data
			 */
			protected function view($view_file, $data = '') {
				if (is_array($data)) {
					extract($data);
				}
				$file = 'po-component/po-menumanager/templates/' . $view_file . '.php';
				if (file_exists($file)) {
					include $file;
				} else {
					die("Cannot include $view_file");
				}
			}
		}
		/**
		 * default controller & method
		 */
		$controller = 'menu';
		$method = 'menumanager';

		/**
		 * url structure: index.php?act=controller.method
		 */
		if (isset($_GET['act'])) {
			$act = explode('.', $_GET['act']);
			$controller = $act[0];
			if (isset($act[1])) {
				$method = $act[1];
			}
		}

		$controller_file = 'po-component/po-menumanager/modules/' . $controller . '.php';
		if (file_exists($controller_file)) {
			include $controller_file;
			$Class_name = ucfirst($controller);
			$instance = new $Class_name;
			if (!is_callable(array($instance, $method))) {
				die("Cannot call method $method");
			}
			$instance->$method();
		} else {
			$controller_file = 'po-component/po-menumanager/modules/menu.php';
			include $controller_file;
			$instance = new Menu;
			$instance->menumanager();
		}
	}
	break;
}
/* End of index.php */
}
?>