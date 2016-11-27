<?php 

class Wpshop_Post
{
	private $view;
	private $post;
	public function __construct()
	{
		global $post;
		$this->post = &$post;
		$this->view = new Wpshop_View();
		if (is_admin())
		{
			add_action('admin_init', array(&$this,'PostMetaBoxInit'));
			
			//включаем дополнительные колонки на странице постов
			function my_column_register( $columns ) {
			  $columns['cost'] = __( 'Цена', 'wp-shop' );
			  $columns['sklad'] = __( 'Кол-во', 'wp-shop' );
			  return $columns;
			}
			add_filter( 'manage_edit-post_columns', 'my_column_register' );

			function my_column_register_sortable( $columns ) {
			  $columns['cost'] = 'cost';
			  $columns['sklad'] = 'sklad';
			  return $columns;
			}
			add_filter( 'manage_edit-post_sortable_columns', 'my_column_register_sortable' );

			function my_column_display( $column_name, $post_id ) {
				if ( 'cost' != $column_name&&'sklad' != $column_name ) return;
				if('cost' == $column_name){
					  $data = get_post_meta($post_id, 'cost_1', true);
					  if ( !$data )
						$data = __( '', 'wp-shop' );
					  echo $data;
				}
				if('sklad' == $column_name){
					  $data1 = get_post_meta($post_id, 'sklad_1', true);
					  if ( !$data1 )
						$data1 = __( '', 'wp-shop' );
					  echo $data1;
				}
			  
			}
			add_action( 'manage_posts_custom_column', 'my_column_display', 10, 2 );
			
			function my_column_orderby( $vars ) {
				if ( isset( $vars['orderby'] ) && 'cost' == $vars['orderby'] ) {
					$vars = array_merge( $vars, array(
					  'meta_key' => 'cost_1',
					  'orderby' => 'meta_value_num' 
					) );
				}
			 
			  return $vars;
			}
			add_filter( 'request', 'my_column_orderby' ); 
			
			add_action( 'bulk_edit_custom_box', 'my_column_quickedit', 10, 2 );
			add_action( 'quick_edit_custom_box', 'my_column_quickedit', 10, 2 );
			function my_column_quickedit( $column_name, $post_type ) {
				static $printNonce = TRUE;
				if ( $printNonce ) {
					$printNonce = FALSE;
					wp_nonce_field( WPSHOP_URL, 'my_column_nonce' );
				}

				?>
				<fieldset class="inline-edit-col-left inline-edit-book">
				  <div class="inline-edit-col column-<?php  echo $column_name ?>">
					<label class="inline-edit-group">
					<?php 
					 switch ( $column_name ) {
					 case 'cost':
						 ?><span class="title"><?php  _e( 'Цена', 'wp-shop' );?></span><input name="cost" type="text" /><?php 
						 break;
					 case 'sklad':
						 ?><span class="title"><?php  _e( 'Кол-во', 'wp-shop' );?></span><input name="sklad" type="text" /><?php 
						 break;
					 }
					?>
					</label>
				  </div>
				</fieldset>
				<?php 
			}
			
			add_action( 'save_post', 'my_column_save_meta' );

			function my_column_save_meta( $post_id ) {
				if ( !current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
				$_POST += array("my_column_nonce" => '');
				if ( !wp_verify_nonce( $_POST["my_column_nonce"],WPSHOP_URL ) )
				{
					return;
				}

				if ( isset( $_REQUEST['cost'] ) ) {
					update_post_meta( $post_id, 'cost_1', $_REQUEST['cost'] );
				}
				if ( isset( $_REQUEST['sklad'] ) ) {
					update_post_meta( $post_id, 'sklad_1', $_REQUEST['sklad'] );
				}
				
			}
			
			function my_enqueue($hook) {
				if( 'edit.php' != $hook )
					return;
				wp_enqueue_script( 'my_custom_script', WPSHOP_URL . '/admin_edit.js',array( 'jquery', 'inline-edit-post' ) );
			}
			add_action( 'admin_enqueue_scripts', 'my_enqueue' );
			
			add_action( 'wp_ajax_my_column_save_bulk_edit', 'my_column_save_bulk_edit' );
			function my_column_save_bulk_edit() {
			   // get our variables
			   $post_ids = ( isset( $_POST[ 'post_ids' ] ) && !empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : array();
			   $cost = ( isset( $_POST[ 'cost' ] ) && !empty( $_POST[ 'cost' ] ) ) ? $_POST[ 'cost' ] : NULL;
			   $sklad = ( isset( $_POST[ 'sklad' ] ) && !empty( $_POST[ 'sklad' ] ) ) ? $_POST[ 'sklad' ] : NULL;
			   // if everything is in order
			   if ( !empty( $post_ids ) && is_array( $post_ids ) && !empty( $cost ) ) {
				  foreach( $post_ids as $post_id ) {
					update_post_meta( $post_id, 'cost_1', $cost );
				  }
			   }
			    if ( !empty( $post_ids ) && is_array( $post_ids ) && !empty( $sklad ) ) {
				  foreach( $post_ids as $post_id ) {
					update_post_meta( $post_id, 'sklad_1', $sklad );
				  }
			   }
			   
			}
		
		}

		add_action('wp_head', array(&$this,"jsInc"));
	}

	public function PostMetaBoxInit()
	{
		if (function_exists('add_meta_box'))
		{
			//add_meta_box('wp-shop-p-metabox','WP-Shop',array(&$this,'PostMetaBoxAction'),'post','normal','high');
		}
	}

	public function PostMetaBoxAction()
	{
		$this->view->goodData = new Wpshop_Good_Data($this->post->ID);
		$this->view->post_id = $this->post->ID;
		$this->view->render("admin/post.metabox.php");
	}

	public function jsInc()
	{
		$this->view->render("js.inc.php");
	}
	
}

?>