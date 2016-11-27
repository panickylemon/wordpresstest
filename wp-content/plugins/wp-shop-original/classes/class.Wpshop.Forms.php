<?php 
/**
 * Класс осбуживает cforms
 *
 * @author WP Shop Team
 * @package WP Shop
 * @version 0.1
 * @changed 2011-08-22
 */

// PayPal - пайпэл :-)
// RoboKassa - Робокасса
// Bank - оплата через сбербанк
// WebMoney - оплата по веб-мани
// Cash - наличные деньги 

class Wpshop_Forms
{
	private static $rightField = "Order";
	private static $instance = null;
	private $_forms;
	private static $dataSent = false;
	
	private function __construct()
	{
		$this->_forms = $this->gettingForms();
	}
	
	public function getRightField()
	{
		return self::$rightField;
	}
	
	/**
	 * Функция проверяет наличие необходимых cforms и в случае отсутсвия необходимой, создает её
	 *
	 */
	public function checkcforms($pays)
	{
		/**
		 *	1. Получаем массив существующих форм cforms
		 *	2. Получаем ID для новой формы на всякий случай
		 *	3. Проходим по массиву необходимых форм и в случае необходимости создаем их!!
		 *	4. Еврика! Всё работает!
		 */
		
		$cformsSettings = get_option('cforms_settings');



		$existsForm = array('forms'=>array(),'newID'=>0);
		
		for ($i = 1; true; ++$i)
		{
			if ($i == 1) $prefix = "";
			else $prefix = $i;
			
			if (isset($cformsSettings['form'.$prefix]))
			{
				$existsForm['forms'][$i] = $cformsSettings['form'.$prefix]["cforms{$prefix}_fname"];
			}
			else
			{
				$existsForm['newID'] = $i;
				break;
			}
		}
		/**
		 * Проверяем наличие формы и в случае необходимости создаем её
		 */
		$changed = false;
		foreach($pays as $pay)
		{
			$formName = "wpshop-{$pay->paymentID}";
			if (!in_array($formName,$existsForm['forms']))
			{
				// Создаем новую форму на основе формы по умолчанию
				$newForm = (array)$cformsSettings['form'];
				foreach($newForm as $fkey => $fvalue)
				{
					unset($newForm[$fkey]);
					$fkey = str_replace("cforms_","cforms{$existsForm['newID']}_",$fkey);
					$newForm[$fkey] = $fvalue;
				}
				
				// Ставим опции формы
				$newForm["cforms{$existsForm['newID']}_fname"] = $formName;
				$newForm["cforms{$existsForm['newID']}_ajax"] = 0;
				$newForm["cforms{$existsForm['newID']}_hide"] = 1;
				$newForm["cforms{$existsForm['newID']}_redirect"] = 0;
				$newForm["cforms{$existsForm['newID']}_emailoff"] = 1;
				
				$newForm["cforms{$existsForm['newID']}_working"] = "Одну минутку пожалуйста ...";
				
				if (isset($pay->textAfterSend))
				{
					$newForm["cforms{$existsForm['newID']}_success"] = $pay->textAfterSend;
				}
				else
				{
					$newForm["cforms{$existsForm['newID']}_success"] = "<h3>Ваш заказ принят!</h3>Наш менеджер свяжется с Вами по контактному телефону для уточнения деталей по Вашему заказу.<h4>Благодарим что воспользовались нашим сервисом!</h4>";
				}
				$newForm["cforms{$existsForm['newID']}_required"] = "(обязательно)";
				$newForm["cforms{$existsForm['newID']}_emailrequired"] = "(корректный e-mail)";
				$newForm["cforms{$existsForm['newID']}_failure"] = "Пожалуйста заполните все обязательные поля!";
				$newForm["cforms{$existsForm['newID']}_email"] = "";
				
				$newForm["cforms{$existsForm['newID']}_popup"] = "yy";
				
				// Берем текущее количество полей в шаблонной форме. Берем в качестве указателя
				$count = &$newForm["cforms{$existsForm['newID']}_count_fields"];
				
				for ($i = 1; $i <= $count; ++$i)
				{
					unset($newForm["cforms{$existsForm['newID']}_count_field_{$i}"]);
				}
				
				$count = 0;
				
				for ($i = 0; $i < count($pay->fields); $i++)
				{
					$j = $i+1;
					$newForm["cforms{$existsForm['newID']}_count_field_{$j}"] = $pay->fields[$i];
				}
				
				$count = count($pay->fields);
				$newForm["cforms{$existsForm['newID']}_submit_text"] = "ГОТОВО";
				
				$cformsSettings["form{$existsForm['newID']}"] = $newForm;
				$cformsSettings['global']['cforms_formcount'] = $existsForm['newID'];
				$changed = true;
				$existsForm['newID']++;
			}
		}
		
		if ($changed)
		{
			update_option("cforms_settings",$cformsSettings);
		}	
	}
	
	public static function getInstance()
	{
		if (empty(self::$instance))
		{
			self::$instance = new Wpshop_Forms();
		}
		return self::$instance;
	}
	
	/**
	 * Возвращает доступные cforms.
	 *
	 * @return array Возвращает доступные формы cforms в ассоциативном массиве. Все индексы (форм и полей) соответсвуют индексам в настройках cforms.
	 */
	public function getForms()
	{
		return $this->_forms;
	}
	
	
	/**
	 * Возвращает доступные cforms.
	 *
	 * @return array Возвращает доступные формы cforms в ассоциативном массиве. Все индексы (форм и полей) соответсвуют индексам в настройках cforms.
	 */
	private function gettingForms()
	{
		$cforms = array();
		$cformsSettings = get_option('cforms_settings');
		$FORMCOUNT = $cformsSettings['global']['cforms_formcount'];
		for ($i = 1; $i <= $FORMCOUNT; $i++) {
			$j   = ( $i > 1 )?$i:'';
			$FORM = array();
			$right = false;
			$FORM['name'] = $cformsSettings['form'.$j]['cforms'.$j.'_fname'];
			
			$FORM['id'] = $j;
			
			$fieldcount = $cformsSettings['form'.$j]['cforms'.$j.'_count_fields'];
			for($k = 1; $k <= $fieldcount; ++$k)
			{
				$FORM['fields'][$k]['name'] = current(explode("|",current(explode("$#",$cformsSettings['form'.$j]['cforms'.$j.'_count_field_'.$k]))));
				$f = explode("|",current(explode("$#",$cformsSettings['form'.$j]['cforms'.$j.'_count_field_'.$k])));
				
				if (empty($f[5]))
				{
					$t = explode("$#",$cformsSettings['form'.$j]['cforms'.$j.'_count_field_'.$k]);
					$FORM['fields'][$k]['type'] = $t[1];
				}
				else
				{
					$FORM['fields'][$k]['type'] = $f[5];
				}
				$FORM['fields'][$k]['postName'] = "cf{$j}_field_{$k}";
				$FORM['fields'][$k]['id'] = $k;
				
				if ($FORM['fields'][$k]['name'] == $this->getRightField())
				{
					$right = true;
					$FORM['fields'][$k]['order'] = true;
				}
				else
				{
					$FORM['fields'][$k]['order'] = false;
				}
				$field_params = explode("$#",$cformsSettings['form'.$j]['cforms'.$j.'_count_field_'.$k]);
				if ($field_params[3] == '$1')
				{
					$FORM['fields'][$k]['email'] = true;
				}
				else
				{
					$FORM['fields'][$k]['email'] = false;
				}
			}
			if ($right)
			{
				$cforms[$FORM['id']] = $FORM;
			}
		}
		return $cforms;
	}
	
	/**
	 * Указывает отправленны ли данные или нет.
	 * Функция работает независимо от имени формы.
	 * 
	 * @return boolean
	 */
	public static function isDataSend()
	{
		return self::$dataSent;
	}
	
	public static function setDataSend()
	{
		self::$dataSent = true;
	}
	
	/**
	 * Получаем ID формы, по её названию
	 * 
	 * @return integer
	 */
	public function getFormByName($formName) {	
		foreach($this->_forms as $value) {
			if ($value['name'] == $formName) return $value;
		}
		return null;
	}
	
	public function getDefaultForm() {
		return "wpshop-vizit";
	}
}
