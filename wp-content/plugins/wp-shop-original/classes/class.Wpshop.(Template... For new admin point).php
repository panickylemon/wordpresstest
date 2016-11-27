<?php 

class Wpshop_ExImp
{
	private $view;
	public function __construct()
	{	
		$this->view = new Wpshop_View();
		add_action('admin_menu', array(&$this,'adminMenu'));
	}
	
	public function adminMenu()
	{
		add_submenu_page("wpshop_main", "WP Shop Profile", "WP Shop Profile", "read", "wpshop_userpage",array(&$this,"adminPageAction"));
	}
	
	public function adminPageAction()
	{
		//$this->view->render("admin/user.profile.php");
	}
}