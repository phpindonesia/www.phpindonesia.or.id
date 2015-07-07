<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:404.php');
}else{
?>
<h2>Edit Menu</h2>
<form method="post" action="po-component/po-menumanager/proses.php?mod=menu&act=save">
	<p>
		<label for="edit-menu-title">Title</label>
		<input type="text" name="title" id="edit-menu-title" value="<?php echo $row[MENU_TITLE]; ?>">
	</p>
	<p>
		<label for="edit-menu-url">URL</label>
		<input type="text" name="url" id="edit-menu-url" value="<?php echo $row[MENU_URL]; ?>">
	</p>
	<p>
		<label for="edit-menu-class">Class</label>
		<input type="text" name="class" id="edit-menu-class" value="<?php echo $row[MENU_CLASS]; ?>">
	</p>
	<input type="hidden" name="menu_id" value="<?php echo $row[MENU_ID]; ?>">
</form>
<?php } ?>