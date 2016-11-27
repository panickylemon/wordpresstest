<?php 
/**
 * Здесь расположена система разных корзин
 *
 * @author WP Shop Team
 *
 */

class Wpshop_Page
{
	private $view;
	public function __construct()
	{
		add_action('init', array(&$this,'registerPostType'));
		add_action('init', array(&$this,'registerCustomDelivery'));
		add_action('init', array(&$this,'registerCustomMail'));
    add_action('init', array(&$this,'registerCustomPromo'));
	}

	public function registerPostType()
	{
		/** Создаем специальные taxonomy для способов оплаты */
		$this->createCustomTaxonomy();

		$labels = array();
		$labels['name'] = __('WP Shop Carts', 'wp-shop'); // Основное название типа записи
		$labels['singular_name'] = 'Cart'; // отдельное название записи типа Book
			//'add_new' => 'Добавить новую',
		$labels['add_new_item'] = __('Add new shopping cart', 'wp-shop'); /// Добавить новую корзину
		$labels['edit_item'] = __('Edit your shopping cart', 'wp-shop'); /// Редактировать корзину
		$labels['new_item'] = __('New book', 'wp-shop'); /// Новая книга
		$labels['view_item'] = __('View Book', 'wp-shop'); /// Посмотреть книгу
		$labels['search_items'] = __('Search book', 'wp-shop');  /// Найти книгу
			//'not_found' =>  'Книг не найдено',
		$labels['not_found_in_trash'] = __('No books in your shopping cart', 'wp-shop'); /// В корзине книг не найдено
		$labels['parent_item_colon'] = '';
		$labels['menu_name'] = __('WP Shop Carts', 'wp-shop');

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => 'wpshop_main',
			'query_var' => true,
			'rewrite' => false,
			'capability_type' => 'page',
			//'capabilities'=>array('level_8'),
			'has_archive' => true,
			'hierarchical' => false,
			//'_edit_link'=>false,
			'supports' => array('title','editor','author','thumbnail','comments','custom-fields'),
			'taxonomies' => array('genre'),
		);
		register_post_type('wpshopcarts',$args);
		add_filter('manage_edit-wpshopcarts_columns', array($this,'cartColumns')) ;
		// Добавляем необходимую функция для отображения категорий страниц
		add_action( 'manage_wpshopcarts_posts_custom_column', array($this,'devpress_manage_wpshopcarts_columns'), 10, 2 );
		$this->createCarts();
	}
	
	public function registerCustomDelivery()
	{
		$this->createUserDelTaxonomy();
		$labels = array();
		$labels['name'] = __('WP Shop User Deliveries', 'wp-shop'); // Основное название типа записи
		$labels['singular_name'] = 'Delivery'; // отдельное название записи типа Book
			//'add_new' => 'Добавить новую',
		$labels['add_new_item'] = __('Add new user delivery', 'wp-shop'); /// Добавить новую корзину
		$labels['edit_item'] = __('Edit your delivery', 'wp-shop'); /// Редактировать корзину
		$labels['new_item'] = __('New delivery', 'wp-shop'); /// Новая книга
		$labels['view_item'] = __('View delivery', 'wp-shop'); /// Посмотреть книгу
		$labels['search_items'] = __('Search delivery', 'wp-shop');  /// Найти книгу
			//'not_found' =>  'Книг не найдено',
		$labels['not_found_in_trash'] = __('Not found', 'wp-shop'); /// В корзине книг не найдено
		$labels['parent_item_colon'] = '';
		$labels['menu_name'] = __('WP Shop User Deliveries', 'wp-shop');

		$args = array(
			'labels' => $labels,
			'public' => true,
			//'show_ui' => true,
			'publicly_queryable' => true,
			'capability_type' => 'page',
			'show_in_menu' => 'wpshop_main',
			'has_archive' => true,
			'supports' => array('title','editor','thumbnail','custom-fields'),
			'taxonomies' => array('payment_del')
		);
		register_post_type('wpshop_user_delivery',$args);
		
	}
	
	public function registerCustomMail()
	{
		$this->createMailTaxonomy();
		$labels = array();
		$labels['name'] = __('WP Shop Client Mail', 'wp-shop'); // Основное название типа записи
		$labels['singular_name'] = 'Mail'; // отдельное название записи типа Book
			//'add_new' => 'Добавить новую',
		$labels['add_new_item'] = __('Add new mail', 'wp-shop'); /// Добавить новую корзину
		$labels['edit_item'] = __('Edit your mail', 'wp-shop'); /// Редактировать корзину
		$labels['new_item'] = __('New mail', 'wp-shop'); /// Новая книга
		$labels['view_item'] = __('View mail', 'wp-shop'); /// Посмотреть книгу
		$labels['search_items'] = __('Search mail', 'wp-shop');  /// Найти книгу
			//'not_found' =>  'Книг не найдено',
		$labels['not_found_in_trash'] = __('Not found', 'wp-shop'); /// В корзине книг не найдено
		$labels['parent_item_colon'] = '';
		$labels['menu_name'] = __('WP Shop Mail Constructor', 'wp-shop');

		$args = array(
			'labels' => $labels,
			'public' => true,
			//'show_ui' => true,
			'publicly_queryable' => true,
			'capability_type' => 'page',
			'show_in_menu' => 'wpshop_main',
			'has_archive' => true,
			'supports' => array('title','editor'),
			'taxonomies' => array('mail_type')
		);
		register_post_type('wpshop_client_mail',$args);
		
	}
  
  public function registerCustomPromo()
	{
		$labels = array();
		$labels['name'] = __('WP Shop Promo', 'wp-shop'); // Основное название типа записи
		$labels['singular_name'] = 'Promo'; // отдельное название записи типа Book
			//'add_new' => 'Добавить новую',
		$labels['add_new_item'] = __('Add new promo', 'wp-shop'); /// Добавить новую корзину
		$labels['edit_item'] = __('Edit your promo', 'wp-shop'); /// Редактировать корзину
		$labels['new_item'] = __('New promo', 'wp-shop'); /// Новая книга
		$labels['view_item'] = __('View promo', 'wp-shop'); /// Посмотреть книгу
		$labels['search_items'] = __('Search promo', 'wp-shop');  /// Найти книгу
			//'not_found' =>  'Книг не найдено',
		$labels['not_found_in_trash'] = __('Not found', 'wp-shop'); /// В корзине книг не найдено
		$labels['parent_item_colon'] = '';
		$labels['menu_name'] = __('WP Shop Promo', 'wp-shop');

		$args = array(
			'labels' => $labels,
			'public' => true,
			//'show_ui' => true,
			'publicly_queryable' => true,
			'capability_type' => 'page',
			'show_in_menu' => 'wpshop_main',
			'has_archive' => true,
			'supports' => array('title','editor','custom-fields')
		);
		register_post_type('wpshop_promo',$args);
		
	}

	public function cartColumns()
	{
		return array('cb' => '<input type="checkbox" />',
		'title' => __( 'Payment page', 'wp-shop' ), // Платежная страница
		'genre' => __( 'Payment', 'wp-shop' )); // Платеж
	}

	/**
	 * Функция отвечает за отображения надписи о категории страниц в WP-SHOP Carts
	 */
	public function devpress_manage_wpshopcarts_columns( $column, $post_id )
	{
		global $post;
			switch( $column ) {
				case 'genre' :
					/* Get the genres for the post. */
					$terms = get_the_terms( $post_id, 'genre' );

					/* If terms were found. */
					if ( !empty( $terms ) )
					{
						$out = array();
						/* Loop through each term, linking to the 'edit posts' page for the specific term. */
						foreach ( $terms as $term )
						{
							$out[] = sprintf( '<a href="%s">%s</a>',
								esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'genre' => $term->slug ), 'edit.php' ) ),
								esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'genre', 'display' ) )
							);
						}
						/* Join the terms, separating them with a comma. */
						echo join( ', ', $out );
					}
					/* If no terms were found, output a default message. */
					else
					{
						_e( 'not marked' ); // не помечено
					}
					break;
				default: break;
			}
	}

	public function createCarts()
	{
		$payments = Wpshop_Payment::getInstance()->getPayments();
		$excerpt = array();
    wp_reset_postdata();
		$query = new WP_Query(array ('post_type' => 'wpshopcarts','posts_per_page' => -1 ));

		for ($i = 0; $i < count($query->posts); ++$i)
		{
			$excerpt[] = trim($query->posts[$i]->post_excerpt);
		}

		foreach($payments as $value)
		{
			if(!in_array($value->paymentID, $excerpt))
			{
				$this->createCart($value);
			}
		}
    wp_reset_postdata();
	}

	public function createCart($payment)
	{
		$post = array
		(
			'post_title' => $payment->title,
			'post_content' => "[cart]\n\n<!--cforms name=\"wpshop-{$payment->paymentID}\"-->",
			'post_status' => 'publish',
			'post_type' => 'wpshopcarts',
			'post_excerpt' => $payment->paymentID,
			'post_name' => $payment->paymentID,
			'comment_status'=>'closed',
			'ping_status' => 'closed'
		);
		$id = wp_insert_post($post);
		wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		if ($payment->paymentID == "wm")
		{
			$post = array
			(
				'post_title' => "Ваш платеж через ‘Web-Money’ принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "wm_success",
				'post_name' => "wm_success",
				'comment_status'=> 'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
			$post = array
			(
				'post_title' => "Ваш платеж через ‘Web-Money’ не принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "wm_failed",
				'post_name' => "wm_failed",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		}
		if ($payment->paymentID == "yandex_kassa")
		{
			$post = array
			(
				'post_title' => "Ваш платеж через ‘Yandex касса’ принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "yandex_kassa_success",
				'post_name' => "yandex_kassa_success",
				'comment_status'=> 'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
			$post = array
			(
				'post_title' => "Ваш платеж через ‘Yandex касса’ не принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "yandex_kassa_failed",
				'post_name' => "yandex_kassa_failed",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		}
		if ($payment->paymentID == "robokassa")
		{
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘RoboKassa.ru’ принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "robokassa_success",
				'post_name' => "robokassa_success",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘RoboKassa.ru’ не принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "robokassa_failed",
				'post_name' => "robokassa_failed",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		}
		if ($payment->paymentID == "ek")
		{
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘EK’ принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "ek_success",
				'post_name' => "ek_success",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘EK’ не принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "ek_failed",
				'post_name' => "ek_failed",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		}
		
		if ($payment->paymentID == "paypal")
		{
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘PayPal’ принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "paypal_success",
				'post_name' => "paypal_success",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘PayPal’ не принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "paypal_failed",
				'post_name' => "paypal_failed",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		}
    
    if ($payment->paymentID == "chronopay")
		{
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘Chronopay’ принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "chronopay_success",
				'post_name' => "chronopay_success",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘Chronopay’ не принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "chronopay_failed",
				'post_name' => "chronopay_failed",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		}
    
    if ($payment->paymentID == "simplepay")
		{
			$post = array
			(
				'post_title' => "Ваш платеж через систему `Simplepay` принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "siplepay_success",
				'post_name' => "simplepay_success",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
			$post = array
			(
				'post_title' => "Ваш платеж через систему ‘Simplepay’ не принят",
				'post_content' => "",
				'post_status' => 'publish',
				'post_type' => 'wpshopcarts',
				'post_excerpt' => "simplepay_failed",
				'post_name' => "simplepay_failed",
				'comment_status'=>'closed',
				'ping_status' => 'closed'
			);
			$id = wp_insert_post($post);
			wp_set_object_terms( $id, $payment->paymentID, "genre", false);
		}
	
	}

	public function createCustomTaxonomy()
	{
		// Вполне очевидно, что отображать мэнэджмент для наших таксономий совсем не нужно и остаеться только создать специальные таксономии и страницы для них
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name' => 'Payment categories',
			'singular_name' => 'Payment categories',
			'search_items' => 'Search Genres',
			'all_items' => 'All Genres',
			'parent_item' => 'Parent Genre',
			'parent_item_colon' => 'Parent Genre:',
			'edit_item' => 'Edit Genre',
			'update_item' => 'Update Genre' ,
			'add_new_item' => 'Add New Genre',
			'new_item_name' => 'New Genre Name',
			'menu_name' => 'Payment categories',
		);

		register_taxonomy('genre',array('post'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => false,
		'show_tagcloud' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'genre' ),
		));
		$payments = Wpshop_Payment::getInstance()->getPayments();
		foreach($payments as $payment)
		{
			if (!term_exists($payment->paymentID, "genre"))
			{
				wp_insert_term($payment->name, 'genre', array('slug' => $payment->paymentID));
			}
		}
	}
	
		
	public function createUserDelTaxonomy()
	{
		$labels = array(
			'name' => 'Payments',
			'singular_name' => 'Payment',
			'search_items' => 'Search payments',
			'all_items' => 'All payments',
			'parent_item' => 'Parent payment',
			'parent_item_colon' => 'Parent payment:',
			'edit_item' => 'Edit payment',
			'update_item' => 'Update payment' ,
			'add_new_item' => 'Add New payment',
			'new_item_name' => 'New payment',
			'menu_name' => 'Delivery payment',
		);

		register_taxonomy('payment_del','wpshop_user_delivery', array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		));
		$payments = Wpshop_Payment::getInstance()->getPayments();
		foreach($payments as $payment)
		{
						
			if (!term_exists($payment->paymentID, "payment_del"))
			{
				wp_insert_term($payment->paymentID, 'payment_del', array('slug' => $payment->paymentID));
			}
		}
	}
	
	public function createMailTaxonomy()
	{
		$labels = array(
			'name' => 'Payments',
			'singular_name' => 'Payment',
			'search_items' => 'Search payments',
			'all_items' => 'All payments',
			'parent_item' => 'Parent payment',
			'parent_item_colon' => 'Parent payment:',
			'edit_item' => 'Edit payment',
			'update_item' => 'Update payment' ,
			'add_new_item' => 'Add New payment',
			'new_item_name' => 'New payment',
			'menu_name' => 'Mail payment',
		);

		register_taxonomy('mail_type','wpshop_client_mail', array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		));
		$payments = Wpshop_Payment::getInstance()->getPayments();
		foreach($payments as $payment)
		{
						
			if (!term_exists($payment->paymentID, "mail_type"))
			{
				wp_insert_term($payment->paymentID, 'mail_type', array('slug' => $payment->paymentID));
			}
		}
	}
	
}
