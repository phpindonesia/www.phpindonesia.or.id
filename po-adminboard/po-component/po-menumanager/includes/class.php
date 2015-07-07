<?php
class Menu {

	protected $db;

	/**
	 * Constructor. Initialize database connection
	 */

	public function __construct() {
		include '../../po-component/po-menumanager/includes/db.php';
		$this->db = new DB;
		$this->db->Connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
	}

	protected function view($view_file, $data = '') {
		if (is_array($data)) {
			extract($data);
		}
		$file = '../../po-component/po-menumanager/templates/' . $view_file . '.php';
		if (file_exists($file)) {
			include $file;
		} else {
			die("Cannot include $view_file");
		}
	}

	/**
	 * Show menu manager
	 */
	public function menumanager() {
		$group_id = 1;
		if (isset($_GET['group_id'])) {
			$group_id = (int)$_GET['group_id'];
		}
		$menu = $this->get_menu($group_id);
		$data['menu_ul'] = '<ul id="easymm"></ul>';
		if ($menu) {

			include '../../po-component/po-menumanager/includes/tree.php';
			$tree = new Tree;

			foreach ($menu as $row) {
				$tree->add_row(
					$row[MENU_ID],
					$row[MENU_PARENT],
					' id="menu-'.$row[MENU_ID].'" class="sortable"',
					$this->get_label($row)
				);
			}

			$data['menu_ul'] = $tree->generate_list('id="easymm"');
		}
		$data['group_id'] = $group_id;
		$data['group_title'] = $this->get_menu_group_title($group_id);
		$data['menu_groups'] = $this->get_menu_groups();
		$this->view('menu', $data);
	}

	/**
	 * Add menu action
	 * For use with ajax
	 * Return json data
	 */
	public function add() {
		if (isset($_POST['title'])) {
			$data[MENU_TITLE] = trim($_POST['title']);
			if (!empty($data[MENU_TITLE])) {
				$data[MENU_URL] = $_POST['url'];
				$data[MENU_CLASS] = $_POST['class'];
				$data[MENU_GROUP] = $_POST['group_id'];
				$data[MENU_POSITION] = $this->get_last_position($_POST['group_id']) + 1;
				if ($this->db->insert(MENU_TABLE, $data)) {
					$data[MENU_ID] = $this->db->Insert_ID();
					$response['status'] = 1;
					$li_id = 'menu-'.$data[MENU_ID];
					$response['li'] = '<li id="'.$li_id.'" class="sortable">'.$this->get_label($data).'</li>';
					$response['li_id'] = $li_id;
				} else {
					$response['status'] = 2;
					$response['msg'] = 'Add menu error.';
				}
			} else {
				$response['status'] = 3;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}

	/**
	 * Show edit menu form
	 */
	public function edit() {
		if (isset($_GET['id'])) {
			$id = (int)$_GET['id'];
			$data['row'] = $this->get_row($id);
			$this->view('menu_edit', $data);
		}
	}

	/**
	 * Save menu
	 * Action for edit menu
	 * return json data
	 */
	public function save() {
		if (isset($_POST['title'])) {
			$data[MENU_TITLE] = trim($_POST['title']);
			if (!empty($data[MENU_TITLE])) {
				$data[MENU_ID] = $_POST['menu_id'];
				$data[MENU_URL] = $_POST['url'];
				$data[MENU_CLASS] = $_POST['class'];
				if ($this->db->update(MENU_TABLE, $data, MENU_ID . ' = ' . $data[MENU_ID])) {
					$response['status'] = 1;
					$d['title'] = $data[MENU_TITLE];
					$d['url'] = $data[MENU_URL];
					$d['klass'] = $data[MENU_CLASS]; //klass instead of class because of an error in js
					$response['menu'] = $d;
				} else {
					$response['status'] = 2;
					$response['msg'] = 'Edit menu error.';
				}
			} else {
				$response['status'] = 3;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}

	/**
	 * Delete menu action
	 * Also delete all submenus under current menu
	 * return json data
	 */
	public function delete() {
		if (isset($_POST['id'])) {
			$id = (int)$_POST['id'];

			$this->get_descendants($id);
			if (!empty($this->ids)) {
				$ids = implode(', ', $this->ids);
				$id = "$id, $ids";
			}

			$sql = sprintf('DELETE FROM %s WHERE %s IN (%s)', MENU_TABLE, MENU_ID, $id);
			$delete = $this->db->Execute($sql);
			if ($delete) {
				$response['success'] = true;
			} else {
				$response['success'] = false;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}

	/**
	 * Save menu position
	 */
	public function save_position() {
		if (isset($_POST['easymm'])) {
			$easymm = $_POST['easymm'];
			$this->update_position(0, $easymm);
		}
	}

	/**
	 * Recursive function for save menu position
	 */
	private function update_position($parent, $children) {
		$i = 1;
		foreach ($children as $k => $v) {
			$id = (int)$children[$k]['id'];
			$data[MENU_PARENT] = $parent;
			$data[MENU_POSITION] = $i;
			$this->db->update(MENU_TABLE, $data, MENU_ID . ' = ' . $id);
			if (isset($children[$k]['children'][0])) {
				$this->update_position($id, $children[$k]['children']);
			}
			$i++;
		}
	}

	/**
	 * Get items from menu table
	 *
	 * @param int $group_id
	 * @return array
	 */
	private function get_menu($group_id) {
		$sql = sprintf(
			'SELECT * FROM %s WHERE %s = %s ORDER BY %s, %s',
			MENU_TABLE,
			MENU_GROUP,
			$group_id,
			MENU_PARENT,
			MENU_POSITION
		);
		return $this->db->GetAll($sql);
	}

	/**
	 * Get one item from menu table
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	private function get_row($id) {
		$sql = sprintf(
			'SELECT * FROM %s WHERE %s = %s',
			MENU_TABLE,
			MENU_ID,
			$id
		);
		return $this->db->GetRow($sql);
	}

	/**
	 * Recursive method
	 * Get all descendant ids from current id
	 * save to $this->ids
	 *
	 * @param int $id
	 */
	private function get_descendants($id) {
		$sql = sprintf(
			'SELECT %s FROM %s WHERE %s = %s',
			MENU_ID,
			MENU_TABLE,
			MENU_PARENT,
			$id
		);
		$data = $this->db->GetCol($sql);

		if (!empty($data)) {
			foreach ($data as $v) {
				$this->ids[] = $v;
				$this->get_descendants($v);
			}
		}
	}

	/**
	 * Get the highest position number
	 *
	 * @param int $group_id
	 * @return string
	 */
	private function get_last_position($group_id) {
		$sql = sprintf(
			'SELECT MAX(%s) FROM %s WHERE %s = %s',
			MENU_POSITION,
			MENU_TABLE,
			MENU_GROUP,
			$group_id
		);
		return $this->db->GetOne($sql);
	}

	/**
	 * Get all items in menu group table
	 *
	 * @return array
	 */
	private function get_menu_groups() {
		$sql = sprintf(
			'SELECT %s, %s FROM %s',
			MENUGROUP_ID,
			MENUGROUP_TITLE,
			MENUGROUP_TABLE
		);
		return $this->db->GetAssoc($sql);
	}

	/**
	 * Get menu group title
	 *
	 * @param int $group_id
	 * @return string
	 */
	private function get_menu_group_title($group_id) {
		$sql = sprintf(
			'SELECT %s FROM %s WHERE %s = %s',
			MENUGROUP_TITLE,
			MENUGROUP_TABLE,
			MENUGROUP_ID,
			$group_id
		);
		return $this->db->GetOne($sql);
	}

	/**
	 * Get label for list item in menu manager
	 * this is the content inside each <li>
	 *
	 * @param array $row
	 * @return string
	 */
	private function get_label($row) {
		$label =
			'<div class="ns-row">' .
				'<div class="ns-title">'.$row[MENU_TITLE].'</div>' .
				'<div class="ns-url">'.$row[MENU_URL].'</div>' .
				'<div class="ns-class">'.$row[MENU_CLASS].'</div>' .
				'<div class="ns-actions">' .
					'<a href="#" class="edit-menu" title="Edit Menu">' .
						'<img src="images/menu/edit.png" alt="Edit">' .
					'</a>' .
					'<a href="#" class="delete-menu">' .
						'<img src="images/menu/cross.png" alt="Delete">' .
					'</a>' .
					'<input type="hidden" name="menu_id" value="'.$row[MENU_ID].'">' .
				'</div>' .
			'</div>';
		return $label;
	}
}

/* End of menu.php */


/**
 * Controller for all menu group actions
 * (add/edit/delete) group menu
 */
class Menu_group {

	protected $db;

	/**
	 * Constructor. Initialize database connection
	 */

	public function __construct() {
		include '../../po-component/po-menumanager/includes/db.php';
		$this->db = new DB;
		$this->db->Connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
	}

	protected function view($view_file, $data = '') {
		if (is_array($data)) {
			extract($data);
		}
		$file = '../../po-component/po-menumanager/templates/' . $view_file . '.php';
		if (file_exists($file)) {
			include $file;
		} else {
			die("Cannot include $view_file");
		}
	}

	/**
	 * Add menu group action
	 * or
	 * Show add menu group form
	 */
	public function add() {
		if (isset($_POST['title'])) {
			$data[MENUGROUP_TITLE] = trim($_POST['title']);
			if (!empty($data[MENUGROUP_TITLE])) {
				if ($this->db->insert(MENUGROUP_TABLE, $data)) {
					$response['status'] = 1;
					$response['id'] = $this->db->Insert_ID();
				} else {
					$response['status'] = 2;
					$response['msg'] = 'Add menu group error.';
				}
			} else {
				$response['status'] = 3;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		} else {
			$this->view('menu_group_add');
		}
	}

	/**
	 * Edit menu group action
	 */
	public function edit() {
		if (isset($_POST['title'])) {
			$id = (int)$_POST['id'];
			$data[MENUGROUP_TITLE] = trim($_POST['title']);
			$response['success'] = false;
			if ($this->db->update(MENUGROUP_TABLE, $data, MENUGROUP_ID . ' = ' . $id)) {
				$response['success'] = true;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}

	/**
	 * Delete menu group action
	 * This will also delete all menus under this group
	 */
	public function delete() {
		if (isset($_POST['id'])) {
			$id = (int)$_POST['id'];
			if ($id == 1) {
				$response['success'] = false;
				$response['msg'] = 'Cannot delete Group ID = 1';
			} else {
				$sql = sprintf('DELETE FROM %s WHERE %s = %s', MENUGROUP_TABLE, MENUGROUP_ID, $id);
				$delete = $this->db->Execute($sql);
				if ($delete) {
					$sql = sprintf('DELETE FROM %s WHERE %s IN (%s)', MENU_TABLE, MENU_GROUP, $id);
					$this->db->Execute($sql);
					$response['success'] = true;
				} else {
					$response['success'] = false;
				}
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}
}

/* End of menu_group.php */
?>