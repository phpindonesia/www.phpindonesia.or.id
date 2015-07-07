<?php
class Menu extends PoController {

	/**
	 * Show menu manager
	 */
	public function menumanager() {
		$group_id = 1;
		if (isset($_GET['group_id'])) {
			$group_id = (int)$_GET['group_id'];
		}
		$cari_id = $this->num_row($group_id);
		if ($cari_id > 0){
			$menu = $this->get_menu($group_id);
			$data['menu_ul'] = '<ul id="easymm"></ul>';
			if ($menu) {

				include 'po-component/po-menumanager/includes/tree.php';
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
		}else{
			$menu = $this->get_menu('1');
			$data['menu_ul'] = '<ul id="easymm"></ul>';
			if ($menu) {

				include 'po-component/po-menumanager/includes/tree.php';
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
			$data['group_id'] = '1';
			$data['group_title'] = $this->get_menu_group_title('1');
			$data['menu_groups'] = $this->get_menu_groups();
			$this->view('menu', $data);
		}
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

	private function num_row($id) {
		$sql = sprintf(
			'SELECT * FROM %s WHERE %s = %s',
			MENUGROUP_TABLE,
			MENUGROUP_ID,
			$id
		);
		return $this->db->NumRow($sql);
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
?>