<?php
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
        include 'po-adminboard/po-component/po-menumanager/includes/db.php';
        $this->db = new DB;
        $this->db->Connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME, DATABASE_PORT);
        include 'po-adminboard/po-component/po-menumanager/includes/tree.php';
    }
    /**
     * Get menu from database, and generate html nested list
     *
     * @param int $group_id
     * @param string $attr
     * @return string
     */
    function popoji_menu($group_id, $attr = '', $attrs = '', $attrss = '', $opt = '') {
        $tree    = new Tree;
        $sql     = sprintf('SELECT * FROM %s WHERE group_id = %s ORDER BY %s, %s', MENU_TABLE, $group_id, MENU_PARENT, MENU_POSITION);
        $menu    = $this->db->GetAll($sql);
        $str     = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $strlink = preg_replace("/\/index\.php$/", "", $str);
        foreach ($menu as $row) {
            $httpdtc  = substr($row[MENU_URL], 0, 7);
            $httpdtcs = substr($row[MENU_URL], 0, 8);
            if ($row[MENU_PARENT] == 0) {
                if ($row[MENU_CLASS] == "") {
                    if ($httpdtc == "http://" OR $httpdtcs == "https://") {
                        $label = '<a href="' . $row[MENU_URL] . '">';
                    } else {
                        $label = '<a href="' . $strlink . '/' . $row[MENU_URL] . '">';
                    }
                } else {
                    if ($httpdtc == "http://" OR $httpdtcs == "https://") {
                        $label = '<a ' . $attrs . ' href="' . $row[MENU_URL] . '">';
                    } else {
                        $label = '<a ' . $attrs . ' href="' . $strlink . '/' . $row[MENU_URL] . '">';
                    }
                }
            } else {
                if ($row[MENU_CLASS] == "") {
                    if ($httpdtc == "http://" OR $httpdtcs == "https://") {
                        $label = '<a href="' . $row[MENU_URL] . '">';
                    } else {
                        $label = '<a href="' . $strlink . '/' . $row[MENU_URL] . '">';
                    }
                } else {
                    if ($httpdtc == "http://" OR $httpdtcs == "https://") {
                        $label = '<a ' . $attrs . ' href="' . $row[MENU_URL] . '">';
                    } else {
                        $label = '<a ' . $attrs . ' href="' . $strlink . '/' . $row[MENU_URL] . '">';
                    }
                }
            }
            $label .= $row[MENU_TITLE];
            $label .= '</a>';
            $li_attr = '';
            if ($row[MENU_CLASS]) {
                $li_attr = ' class="' . $row[MENU_CLASS] . '"';
            }
            $tree->add_row($row[MENU_ID], $row[MENU_PARENT], $li_attr, $label);
        }
        $menu = $tree->generate_list($attr, $attrss, $opt);
        return $menu;
    }
}
?>