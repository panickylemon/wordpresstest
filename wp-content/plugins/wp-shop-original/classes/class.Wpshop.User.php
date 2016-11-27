<?php 

class Wpshop_User
{
	private $view;
	public function __construct()
	{	
		$this->view = new Wpshop_View();
		add_action('admin_menu', array(&$this,'userAdminMenu'));
	}
	
	public function userAdminMenu()
	{
		//add_submenu_page("wpshop_main", "WP Shop Profile", "WP Shop Profile", "read", "wpshop_userpage",array(&$this,"userProfileAction"));
	}
	
	public function userProfileAction()
	{
		$this->view->render("admin/user.profile.php");
	}
}