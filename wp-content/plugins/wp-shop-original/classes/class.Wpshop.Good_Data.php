<?php 

class Wpshop_Good_Data_Costs
{
	public $id = 0;
	public $name = "";
	public $cost = 0;
	public $count = 0;
};

class Wpshop_Good_Data
{
	private $costs = array();
	private $post_id = 0;
	private $prop = "";
	private $yml_pic = "";
	private $ShortText = "";
	function __construct($post_id)
	{
		$this->post_id = $post_id;
		$this->prop = get_post_meta($post_id,"prop",true);
		$this->yml_pic = get_post_meta($post_id,"yml_pic",true);
		$this->ShortText = get_post_meta($post_id,"shorttext",true);
		$this->gettingCosts();
	}
	
	public function getShortText()
	{
		return $this->ShortText;
	}
	
	public function getYmlPic()
	{
		return $this->yml_pic;
	}
	
	public function getProp()
	{
		return $this->prop;
	}
	
	private function gettingCosts()
	{
		$this->costs = array();
		$metas = get_post_custom($this->post_id);
		foreach($metas as $meta_name => $meta_value)
		{
			$tmp = array();
			if (preg_match("/cost_(\d+)/",$meta_name,$tmp))
			{
				$r = &$this->costs[];
				$r = new Wpshop_Good_Data_Costs();
				$r->id = $tmp[1];
				if (isset($metas["name_".$tmp[1]]) && is_array($metas["name_".$tmp[1]]))
				{
					$r->name = current($metas["name_".$tmp[1]]);
				}
				else
				{
					$r->name = "A";
				}
				$r->cost = current($meta_value);
				
				if (isset($metas["sklad_".$tmp[1]]) && is_array($metas["name_".$tmp[1]]))
				{
					$r->count = current($metas["sklad_".$tmp[1]]);
				}
        else
				{
					/** @todo Спросить у Саши, что делать в случае, если не указан склад";*/
					$r->count = 1;
				}
       
			}
		}		
	}
	
	public function getCosts()
	{
		return $this->costs;
	}
	
	public function setCosts($data)
	{
		foreach($data['wpshop-meta-cost'] as $value)
		{
			add_post_meta($this->post_id, $value['name']['meta_name'], $value['name']['meta_value'], true) || update_post_meta($this->post_id, $value['name']['meta_name'],$value['name']['meta_value']);
			add_post_meta($this->post_id, $value['cost']['meta_name'], $value['cost']['meta_value'], true) || update_post_meta($this->post_id, $value['cost']['meta_name'],$value['cost']['meta_value']);
			add_post_meta($this->post_id, $value['count']['meta_name'], $value['count']['meta_value'], true) || update_post_meta($this->post_id, $value['count']['meta_name'],$value['count']['meta_value']);
     }
		
		add_post_meta($this->post_id, 'prop', $data['wpshop-prop'], true) || update_post_meta($this->post_id, 'prop', $data['wpshop-prop']);
		add_post_meta($this->post_id, 'yml_pic', $data['wpshop-yml_pic'], true) || update_post_meta($this->post_id, 'yml_pic', $data['wpshop-yml_pic']);
		add_post_meta($this->post_id, 'shorttext', $data['wpshop-shorttext'], true) || update_post_meta($this->post_id, 'shorttext', $data['wpshop-shorttext']);
		
		
		
		$this->gettingCosts();
	}
	
	public function deleteCost($data)
	{
		foreach($data['wpshop-meta-cost'] as $value)
		{
			delete_post_meta($this->post_id, $value['name']['meta_name'], $value['name']['meta_value']);
			delete_post_meta($this->post_id, $value['cost']['meta_name'], $value['cost']['meta_value']);
			delete_post_meta($this->post_id, $value['count']['meta_name'], $value['count']['meta_value']);
    }
		$this->gettingCosts();
	}
}