<?php 

class Wpshop_Ajax
{
	public function __construct()
	{
		if ($_POST['wpshop-ajax'] == "save-post-data")
		{
			$Good_Data = new Wpshop_Good_Data($_POST['post_id']);
			$Good_Data->setCosts($_POST);
		}
		
		if ($_POST['wpshop-ajax'] == "delete-post-cost")
		{
			$Good_Data = new Wpshop_Good_Data($_POST['post_id']);
			$Good_Data->deleteCost($_POST);
		}
		
		if ($_POST['wpshop-ajax'] == "get-cform-fields")
		{
			$cforms = Wpshop_Forms::getInstance()->getForms();
			foreach($cforms as $cform)
			{
				if ($cform['name'] == $_POST['cform_name'])
				{
					echo json_encode($cform);
				}
			}
		}
		
	}
}