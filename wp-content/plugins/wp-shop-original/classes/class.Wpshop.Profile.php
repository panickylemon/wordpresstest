<?php 

class Wpshop_Profile
{
	public $view;
	public function __construct() {
		$this->view = new Wpshop_View();
		
	}

	public function install() {
		$this->createRoles();		
	}

	public function manageCustomerPage() {

	}

	public function createRoles() {
		add_role('Customer', 'Customer');
		add_role('Merchant', 'Merchant');
		
		$roleEditor = get_role('editor');
		$administrator = get_role('administrator');

		$role = get_role('Customer');
		// Add custome roles
		$role->add_cap( 'read' ); 
		$role = get_role( 'Merchant' );	
		
		foreach($roleEditor->capabilities as $cap=>$value) {
			$role->add_cap( $cap );	
		}
		$role->add_cap( 'Customer' );		
		$user = wp_get_current_user();
		$role = array_shift($user->roles);
		
		if ($role == "Customer"||$role =="administrator"||$role =="Merchant") {
			add_filter('user_contactmethods',array(&$this,'customer_contactmethod'));
			add_action('personal_options', array(&$this,'customerProfilePage'));
			add_action('wp_dashboard_setup',array(&$this,'customerDashboard'));
		}

	}
	
	public static function isCurrentUserCustomer() {
		global $current_user;
		return array_key_exists("Customer",$current_user->caps);
	}

	public function customerDashboard() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);			
	}

	public function customer_contactmethod( $contactmethods ) {
				
		$contactmethods['phone'] = __('Phone','wp-shop');
		$contactmethods['address'] = __('Address','wp-shop');
		$contactmethods['company_name'] = __('Company name','wp-shop');
		$contactmethods['description'] = __('Description','wp-shop');
		
		unset($contactmethods['jabber']);
		unset($contactmethods['yim']);
		unset($contactmethods['aim']);
		return $contactmethods;
	}

	public function customerProfilePage($user) {
?>
<script type="text/javascript">
	jQuery(function($) {
		$('table').has('textarea[name="description"]').find('tr:first').remove();
		var value = $('[name="description"]').val();
		$('[name="description"]').parent().html("<textarea name='description'>"+value+"</textarea>");
	});
</script>
<?php 
	}

}




