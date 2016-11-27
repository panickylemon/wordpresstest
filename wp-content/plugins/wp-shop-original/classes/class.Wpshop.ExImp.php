<?php 
class Wpshop_ExImp
{
	private $view;
	public function __construct()
	{
		$this->view = new Wpshop_View();
		add_action('admin_menu', array(&$this,'adminMenu'));

		if (isset($_POST['submit_wpshop_export']) )
		{
			$this->exportXML();
			exit();
		}
		
		if (isset($_POST['submit_wpshop_export_order']) )
		{
			$this->exportOrderXML();
			exit();
		}
	}

	public function adminMenu()
	{
		wp_enqueue_script('jdf',WPSHOP_URL . "/jdf.js",array('jquery-ui-sortable'));
		add_submenu_page("wpshop_main", __('WP Shop Export/Import', 'wp-shop'), __('WP Shop Export/Import', 'wp-shop'), "activate_plugins", "wpshop_export-import",array(&$this,"adminPageAction"));
	}

	public function adminPageAction()
	{
		global $wpdb;
		if ( isset($_POST['submit_wpshop_import']) && is_uploaded_file($_FILES['import']['tmp_name']) )
		{
			$this->importXML($_FILES['import']['tmp_name']);
		}

		$this->view->postColumns = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->posts}");
		$this->view->metaKeys = $wpdb->get_results("SELECT meta_key FROM {$wpdb->postmeta} GROUP BY meta_key ORDER BY meta_key");
		$this->view->render("admin/export-import.php");
	}

	public function exportXML()
	{
		global $wpdb;

		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="'.$_SERVER['HTTP_HOST'].'.xml"');
		header('Content-Type: text/xml; charset=utf-8');

		while(@ob_get_clean());

		echo "<?php xml version=\"1.0\" encoding=\"utf-8\"?>\n<posts>\n";

		$result = array('ID' => array());

		$type = array();

		$sql = "SELECT ID";
		if (isset($_POST['fieldName']))
		{
			foreach ($_POST['fieldName'] as $key => $value)
			{
				if ($_POST['fieldType'][$key] == 0)
				{
					$sql .= ", `{$value}`";
					$type[$value] = 1;
				}
				else
				{
					$type[$value] = 2;
				}
				$result[$value] = array();
			}
		}

		//$sql .= " FROM {$wpdb->posts} WHERE post_type <> 'revision' AND post_type <> 'draft' AND post_type <> 'inherit'";
		$sql .= " FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish'";
 
		$posts = $wpdb->get_results($sql);

		foreach ($posts as $post)
		{
			foreach ($post as $key => $value)
			{
				$result[$key][] = $value;
			}
		}

		foreach($result as $field =>$key)
		{
			if ($key[0] == 1)
			{
				foreach($result['ID'] as $r)
				{
					if ($r != 0)
					{
						$result[$field][] = $field;
					}
				}
			}
		}

		foreach($result['ID'] as $key =>$value)
		{
			echo "<post>";
			if (isset($_POST['include_cat']) && $_POST['include_cat']==1)
			{
				$categories = wp_get_post_categories($result['ID'][$key]);
				echo "\t<category>";
				echo get_cat_name(current($categories));
				echo "</category>\n";
			}
			if (isset($_POST['include_tag']) && $_POST['include_tag']==1)
			{
				$tags = wp_get_post_tags($result['ID'][$key]);

				echo "\t<tag>";
				echo current($tags)->name;
				echo "</tag>\n";
			}
			foreach($result as $q => $w)
			{
				if ($type[$q] == 2)
				{
					$z = get_post_meta($result['ID'][$key], $q, true);
				}
				else
				{
					$z = $result[$q][$key];
				}

				if (!($q == "ID"))
				{
					$z = "<![CDATA[$z]]>";
				}
				echo "\t<{$q}>{$z}</{$q}>\n";
			}
			echo "</post>\r";
		}
		echo "</posts>\n";
	}

	public function importXML($filename)
	{
		global $wpdb;
		$f1 = current(wp_upload_dir()) . "/" . basename($filename);

		copy($filename,$f1);
		$fp = fopen($f1, 'r');

		$doing_entry = false;
		$posts = array();
		if ($fp)
		{
			while ( !feof($fp) )
			{
				$importline = rtrim(fgets($fp));
				if ( false !== strpos($importline, '<post>') )
				{
					$post = '';
					$doing_entry = true;
					continue;
				}
				if ( false !== strpos($importline, '</post>') )
				{
					$doing_entry = false;
					$posts[] = $post;
					continue;
				}
				if ( $doing_entry )
				{
					$post .= $importline . "\n";
				}
			}
			fclose($fp);
		}
		$posts_columns = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->posts}");
		$updated = 0;
		foreach($posts as $value)
		{
			$data = array();
			$post = array();
			if (preg_match_all('|<(.+?)><!\[CDATA\[(.*?)\]\]></.+?>|s', $value, $m1) ||
				preg_match_all('|<(.+?)>(.*?)</.+?>|s', $value, $m1) )
			{
				foreach ($m1[1] as $n => $key)
				{
					if ($key == "category") continue;
					if ($key == "tag") continue;
					$data[$key] = html_entity_decode($m1[2][$n]);
					flush();
				}
			}
			reset($posts_columns);
			foreach ($posts_columns as $col)
			{
				if ( isset($data[$col->Field]) )
				{
					if ($col->Field == "ID")
					{
						$ID	= $data[$col->Field];
					}
					else
					{
						$post[$col->Field] = "{$col->Field} = '{$data[$col->Field]}'";
					}
					unset($data[$col->Field]);
					flush();
				}
			}

			if (count($post)>0)
			{
				$wpdb->query("UPDATE {$wpdb->posts} SET ".implode(',',$post)." WHERE ID = {$ID}");
			}
			unset($post);

			if (count($data))
			{
				foreach ($data as $key => $value)
				{
					update_post_meta($ID, $key, $value);}
			}
			unset($data);
			$updated++;
			echo "{$updated}. {$ID} - updated<br>";
			flush();
		}
	}
	
	public function exportOrderXML()
	{
		global $wpdb;

		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="'.$_SERVER['HTTP_HOST'].'_orders.xml"');
		header('Content-Type: text/xml; charset=utf-8');

		while(@ob_get_clean());

		echo "<?php xml version=\"1.0\" encoding=\"utf-8\"?>\n<orders>\n";

		$sql = "SELECT * FROM `{$wpdb->prefix}wpshop_orders` WHERE 1";
		if ( $res = $wpdb->get_results($sql))  {
			foreach ($res as $row) {
				$status ='';
				if ($row->order_status == 0){$status = 'Новый';}
				if ($row->order_status == 1){$status = 'Оплачено';}
				if ($row->order_status == 2){$status = 'Отменено';}
				if ($row->order_status == 3){$status = 'В обработке';}
				if ($row->order_status == 4){$status = 'Доставлено';}
				if ($row->order_status == 5){$status = 'Архив';}
				
				print "\t".'<order order_id="'.$row->order_id.'" client_email="'.$row->client_email.'" client_name="'.$row->client_name.'" status="'.$status.'"  order_payment="'.$row->order_payment.'" order_promo="'.$row->order_promo.'">'."\n";
				
				$items_sql = "SELECT * FROM `{$wpdb->prefix}wpshop_ordered` WHERE `ordered_pid`={$row->order_id}";
				$items = $wpdb->get_results($items_sql);
				
				foreach ($items as $item) {
					$name = '';
					$name = str_replace(array("\'",'\"'),'"',$item->ordered_name);
          $name = htmlspecialchars($name, ENT_QUOTES);
					print "\t\t".'<offer offer_id="'.$item->ordered_page_id.'" offer_name="'.$name.'" offer_cost="'.$item->ordered_cost.'" offer_count="'.$item->ordered_count.'" offer_key="'.$item->ordered_key.'"></offer>'."\n";
				}
				echo "\t".'</order>'."\n";
			}
		}
		

		echo "</orders>\n";
	}
}