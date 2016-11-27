<?php 
/**
 @todo Найти переменную храняющую в себе слеш для определенной операционной системы
 */
//autoload import script
include WPSHOP_CLASSES_DIR . '/class.Wpshop.Analityc.php';


class Wpshop_Payment_Data
{
	public $paymentID;
	public $name;
	public $fields;
	public $picture;
	/**
	 * Массив имеющий разного рода назначение
	 */
	public $data;
};

class Wpshop_Payment
{
	private static $instance = null;
	public $payments = array();

	private function __construct()
	{

		$i = 0;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "vizit";
		$this->payments[$i]->name = __('Self-delivery', 'wp-shop'); //Самовывоз;
		$this->payments[$i]->title = __('Making order using \'Self-delivery\' goods from our store / office', 'wp-shop'); // Оформление заказа с через ‘самовывоз’ товара из нашего магазина/офиса;
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Visit to our office', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Визит в наш офис</b>
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
                           __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0'); // Комментарий к заказу
		$this->payments[$i]->picture = 'cash.png';

		$i = 1;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "cash";
		$this->payments[$i]->title = __('Making order with cash payment to courier when your goods delivered', 'wp-shop'); // Оформление заказа с оплатой наличными курьеру при получении товара
		$this->payments[$i]->name = __('Cash to courier', 'wp-shop'); // Наличными курьеру
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Cash to courier', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'cur_mpf.png';

		$i = 2;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "post";
		$this->payments[$i]->title =  __("Making order with payment at post-offce before receiving (Cash on delivery)",'wp-shop');  // Оформление заказа с оплатой на почте при получении (Наложенный платеж)
		$this->payments[$i]->name = __('Cash on delivery', 'wp-shop'); //Наложенный платеж
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Post', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'russianpost.png';

		$i = 3;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "wm";
		$this->payments[$i]->title = __('Making order using Web-money payment system', 'wp-shop'); //Оформление заказа с оплатой через систему ‘Web-Money’
		$this->payments[$i]->name = "Web-Money";
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Making order using Web-money payment system', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'wbmoney.png';
		$this->payments[$i]->textAfterSend = '<h3>'.__('To pay your order, click the button above \'Pay WM\'. <br/> After your payment, we will get data of your payment and our manager will contact you to arrange the delivery. <br/> Thank you for using our service!', 'wp-shop').'</h3>'; // Для оплаты Вашего заказа нажмите кнопку выше 'Оплатить WM'.<br/>После совершения Вами оплаты заказа информация передается нам, и наш менеджер обязательно свяжется с Вами для уточнения деталей доставки.<br/>Благодарим, что воспользовались нашим сервисом!

		$i = 4;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "bank";
		$this->payments[$i]->name = __('Cashless payment', 'wp-shop'); // Безналичный расчет
		$this->payments[$i]->title = __('Making order with payment using bank account (Non-cash payment)', 'wp-shop'); // Оформление заказа с оплатой через банк (Безналичный расчет)
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Cashless payment', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'bankoffice.png';

		$i = 5;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "robokassa";
		$this->payments[$i]->name = "RoboKassa";
		$this->payments[$i]->title = __('Making order with payment using ‘RoboKassa.ru’ payment system', 'wp-shop'); // Оформление заказа с оплатой через систему ‘RoboKassa.ru’
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Making order with payment using ‘RoboKassa.ru’ payment system', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'robokassa.gif';
		$this->payments[$i]->merchant = true;
		$this->payments[$i]->textAfterSend = '<h3>'.__('Select the appropriate payment method from the list of the available options and initiate the payment. When we will get payment data, our manager will contact you using your contact number for further details on your order. <br>Thank you for using our service!', 'wp-shop').'</h3>'; // Выберите подходящий Вам способ оплаты из списка имеющихся вариантов и осуществите платеж. Данные по совершенному Вами платежу поступят нашим менеджерам, которые свяжутся с Вами по контактному телефону для уточнения деталей по Вашему заказу.<br> Благодарим, что воспользовались нашим сервисом!

		$i = 6;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "paypal";
		$this->payments[$i]->name = "Pay Pal";
		$this->payments[$i]->title = __('Making order using Pay Pal payment system', 'wp-shop'); //Оформление заказа с оплатой через систему Pay Pal
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Making order with payment using ‘Pay Pal’ payment system', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'paypal.png';
		$this->payments[$i]->textAfterSend = '<h3>'.__('To pay your order, click the button above \'Pay PayPal\'. <br/> After your payment, we will get data of your payment and our manager will contact you to arrange the delivery. <br/> Thank you for using our service!', 'wp-shop').'</h3>';
    
    $i = 10;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "simplepay";
		$this->payments[$i]->name = "Simplepay";
		$this->payments[$i]->title = __('Making order using Simplepay payment system', 'wp-shop'); //Оформление заказа с оплатой через систему Simplepay
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Making order with payment using ‘Pay Pal’ payment system', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'simplepay.png';
		$this->payments[$i]->textAfterSend = '<h3>'.__('To pay your order, click the button above \'Simplepay\'. <br/> After your payment, we will get data of your payment and our manager will contact you to arrange the delivery. <br/> Thank you for using our service!', 'wp-shop').'</h3>';
				
		$i = 7;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "ek";
		$this->payments[$i]->title = __('Making order using Edinaya kassa payment system', 'wp-shop'); //Оформление заказа с оплатой через систему EK
		$this->payments[$i]->name = "Edinaya kassa";
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Making order using Edinaya kassa payment system', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'ek.gif';
		$this->payments[$i]->merchant = true;
		$this->payments[$i]->textAfterSend = '<h3>'.__('To pay your order, click the button above \'Pay EK\'. <br/> After your payment, we will get data of your payment and our manager will contact you to arrange the delivery. <br/> Thank you for using our service!', 'wp-shop').'</h3>';
		
		$i = 8;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "yandex_kassa";
		$this->payments[$i]->title = __('Making order using Yandex kassa payment system', 'wp-shop'); //Оформление заказа с оплатой через систему Yandex
		$this->payments[$i]->name = "Yandex kassa";
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Making order using Yandex kassa payment system', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'yandex kassa.png';
		$this->payments[$i]->merchant = true;
		$this->payments[$i]->textAfterSend = '<h3>'.__('To pay your order, click the button above \'Pay Yandex kassa\'. <br/> After your payment, we will get data of your payment and our manager will contact you to arrange the delivery. <br/> Thank you for using our service!', 'wp-shop').'</h3>';
    
    $i = 9;
		$this->payments[$i] = new Wpshop_Payment_Data();
		$this->payments[$i]->paymentID = "chronopay";
		$this->payments[$i]->name = "Chronopay";
		$this->payments[$i]->title = __('Making order using Chronopay payment system', 'wp-shop'); //Оформление заказа с оплатой через систему Pay Pal
		$this->payments[$i]->fields = array("Order".'$#$hidden$#$0$#$0$#$0$#$0$#$0',
						   __('Order type:', 'wp-shop').' <b>'.__('Making order with payment using ‘Chronopay’ payment system', 'wp-shop').'</b>$#$hidden$#$0$#$0$#$0$#$0$#$0', // Тип заказа: <b>Наличными курьеру
						   __('For making order please fill up the form:', 'wp-shop').'$#$fieldsetstart$#$0$#$0$#$0$#$0$#$0', // Для оформления заказа заполните эту форму:
						   __('Your name', 'wp-shop').'|||||Name$#$textfield$#$1$#$0$#$1$#$0$#$0', // Ваше имя
						   __('Contact phone', 'wp-shop').'|||||Phone$#$textfield$#$1$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('Address', 'wp-shop').'|||||Address$#$textfield$#$0$#$0$#$0$#$0$#$0', // Контактный телефон
						   __('E-mail', 'wp-shop').'$#$textfield$#$0$#$1$#$0$#$0$#$0', // E-mail
						   __('Comment to the order', 'wp-shop').'$#$textarea$#$0$#$0$#$0$#$0$#$0');
		$this->payments[$i]->picture = 'chronopay.png';
		$this->payments[$i]->textAfterSend = '<h3>'.__('To pay your order, click the button above \'Chronopay\'. <br/> After your payment, we will get data of your payment and our manager will contact you to arrange the delivery. <br/> Thank you for using our service!', 'wp-shop').'</h3>';

		add_filter('init', array(&$this,'webMoneyResult'));
		add_filter('init', array(&$this,'YandexResult'));
		add_filter('init', array(&$this,'ChronoResult'));
		add_filter('init', array(&$this,'robokassaResult'));
		add_filter('init', array(&$this,'ekResult'));
		add_filter('init', array(&$this,'paypalResult'));
    add_filter('init', array(&$this,'simplepayResult'));
	}

	/**
	 * обыкновенный синглетон)
	 */
	public function getInstance()
	{
		if (self::$instance==null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @deprecated
	 */
	public function getSingleton()
	{
		return self::getInstance();
	}

	/**
	 * Возвращает доступные формы оплаты
	 *
	 * @return Array
	 */
	public function getPayments()
	{
		return $this->payments;
	}
	/**
	 *
	 */
	public function getPaymentByID($id)
	{
		foreach($this->payments as $key => $value)
		{
			if ($value->paymentID == $id) return $this->payments[$key];
		}
		return null;
	}

	public function webMoneyResult()
	{
		if (isset($_GET['wmResult']))
		{
			Wpshop_Orders::setStatus($_GET['order_id'],1);
			echo "YES";
			exit;
		}

	}

	public function robokassaResult()
	{
		if (isset($_GET['robokassaResult']))
		{
			$robokassa = get_option("wpshop.payments.robokassa");

			// регистрационная информация (пароль #2)
			// registration info (password #2)
			$mrh_pass2 = $robokassa['pass2'];

			//установка текущего времени
			//current date
			$tm=getdate(time()+9*3600);
			$date="{$tm['year']}-{$tm['mon']}-{$tm['mday']} {$tm['hours']}:{$tm['minutes']}:{$tm['seconds']}";

			// чтение параметров
			// read parameters
			$out_summ = $_REQUEST["OutSum"];
			$inv_id = $_REQUEST["InvId"];
			$shp_item = $_REQUEST["Shp_item"];
			$crc = $_REQUEST["SignatureValue"];

			$crc = strtoupper($crc);

			$my_crc = strtoupper(md5("{$out_summ}:{$inv_id}:{$mrh_pass2}:Shp_item={$shp_item}"));

			// проверка корректности подписи
			// check signature
			if ($my_crc !=$crc)
			{
			  echo "bad sign\n";
			  exit();
			}
			// признак успешно проведенной операции
			// success
			echo "OK$inv_id\n";
			Wpshop_Orders::setStatus($inv_id,1);
			exit();
		}
	}
	public function ymlRequest()
	{
		if (isset($_GET['wpshop_yml']))
		{
			global $wpdb;
			ob_end_clean();
			ob_start();
			include WPSHOP_DIR ."/views/wm.redirect.php";
			echo ob_get_clean();
			exit;
		}
	}
  
  public function ChronoResult() {
    if ($_POST['transaction_type']=='Purchase'&&isset($_POST["cs1"])){
		if (isset($_POST["order_id"])){
			$status_order = Wpshop_Orders::getStatus_order($_POST["order_id"]);
			if ($status_order[0]->order_status==0){
				header_remove(); 	
				print "200 OK";
				global $wpdb;
				$wpdb->query("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='".$_POST["cs1"]."'");
				Wpshop_Orders::setStatus($_POST["order_id"],1);
				exit;
			}else{
				print "200 OK";
				exit;
			}
		}else{
			print "200 OK";
			global $wpdb;
			$wpdb->query("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='".$_POST["cs1"]."'");
		}
	} 
}	

public function simplepayResult() {
  $REQUEST_PARAMS  = array();
		
  
		if(!empty($_POST['sp_xml'])){
			$xml = $_POST['sp_xml'];
			// надо распарсить XML в массив	
			$dom = new DOMDocument;
      $dom->loadXML($xml);
      $parsed_xml = $s = simplexml_import_dom($dom);
		
      $as_array = (array) $parsed_xml;
  	
			$REQUEST_PARAMS = array_filter($as_array);
		}
		else if(!empty($_GET['sp_sig'])) $REQUEST_PARAMS = $_GET;
		else if(!empty($_POST['sp_sig'])) $REQUEST_PARAMS = $_POST;
		$status_order = Wpshop_Orders::getStatus_order($REQUEST_PARAMS["sp_order_id"]);			
	
		if ($REQUEST_PARAMS&&$status_order[0]->order_status==0) {
      // теперь нужно ответить SimplePay
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><response/>');
			$xml->addChild('sp_salt', $REQUEST_PARAMS['sp_salt']);
			$xml->addChild('sp_status', 'ok');
			
			if($REQUEST_PARAMS['sp_result'] == 1){
        $desk = "Оплата принята";
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='".$REQUEST_PARAMS["sp_user_params"]."'");
					
				Wpshop_Orders::setStatus($REQUEST_PARAMS["sp_order_id"],1);
        $xml->addChild('sp_description', "Оплата принята");
      }else{
        $desk = "Платеж отменен";
        $xml->addChild('sp_description', "Платеж отменен");
        Wpshop_Orders::setStatus($REQUEST_PARAMS["sp_order_id"],2);
      }
      
      $opts = get_option("wpshop.payments.simplepay");  
      $res_array = array();
      $res_array['sp_salt'] = $REQUEST_PARAMS['sp_salt'];
      $res_array['sp_description'] = $desk;
      $res_array['sp_status'] = 'ok';
      ksort($res_array);
      array_push ($res_array, $opts['secure']);
      $sign = join(';', $res_array);
      
			$xml->addChild('sp_sig', md5(';'.$sign));
			
			header_remove(); 
			header('Content-type: text/xml');
			print $xml->asXML();
      exit;
    }
} 


  
	public function ekResult()
	{
		$status_order = Wpshop_Orders::getStatus_order($_POST["WMI_PAYMENT_NO"]);
			
		 if (isset($_POST['WMI_ORDER_STATE'])&&$status_order[0]->order_status==0&&isset($_POST["SESSION_USER"]))
			{ 
					// Функция, которая возвращает результат в Единую кассу

					function print_answer($result, $description,$res)
					{
					  print "WMI_RESULT=" . strtoupper($result) . "&";
					  print "WMI_DESCRIPTION=" .urlencode($description);
            if ($res){
              global $wpdb;
              $wpdb->query("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='".$_POST["SESSION_USER"]."'");
              Wpshop_Orders::setStatus($_POST["WMI_PAYMENT_NO"],1);
            }
					  exit();
					}

					if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED")
					  {
						// TODO: Пометить заказ, как «Оплаченный» в системе учета магазина

						print_answer("Ok", "Заказ #" . $_POST["WMI_PAYMENT_NO"] . " оплачен!",true);
            
					  }
					  else
					  {
						// Случилось что-то странное, пришло неизвестное состояние заказа

						print_answer("Retry", "Неверное состояние ". $_POST["WMI_ORDER_STATE"],false);
					  }
			
			}
		
	}
	
	public function paypalResult(){
		if (isset($_POST['mc_gross'])){ 
			$req = 'cmd=_notify-validate';
			// read the data send by PayPal
			foreach ($_POST as $key => $value) {
				$value = urlencode(stripslashes($value));
				$req .= "&$key=$value";
			}
		
			$email = get_option("wpshop.payments.paypal");  
			// post back to PayPal system to validate
			if($email['test']==true){$curl = curl_init("https://www.sandbox.paypal.com/cgi-bin/webscr");}
			if($email['test']==false){$curl = curl_init("https://www.paypal.com/cgi-bin/webscr");}
		
			if ($curl == FALSE) {
				error_log('curl_not_accessed');
			}
			curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $req);

			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);

			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
			if($email['test']==true){
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
			} 
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: wp-shop'));
			$response = curl_exec ($curl); 
			curl_close ($curl); 

			$payment_status = $_POST['payment_status'];
			$payment_amount = $_POST['mc_gross'];
			$receiverEmail = $_POST['business'];
			
			$order = new Wpshop_Order($_POST["invoice"]);
			$full_price = $order->getTotalSum();
			
			$email_saler = $email['email'];
			$tokens = explode("\r\n\r\n", trim($response));
			$res = trim(end($tokens));
			if (!$res) {
				// HTTP ERROR 
			} else {
				if (strcmp ($res, "VERIFIED") == 0) {
					// PAYMENT VALID
					if ($payment_amount==$full_price&&$email_saler==$receiverEmail) {
						global $wpdb;
						$wpdb->query("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='".$_POST["custom"]."'");
						Wpshop_Orders::setStatus($_POST["invoice"],1);
					}
				} else if (strcmp ($res, "INVALID") == 0) {
					error_log('payment not valid');
					// PAYMENT INVALID
				}
			}
		}
	}		
	
	public function YandexResult()
	{	
		if ($_POST['action'] == 'checkOrder'){ 
			$yandex_set = get_option("wpshop.payments.yandex_kassa");
			$hash= md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$yandex_set['shopPassword']);
			if (strtolower($hash) != strtolower($_POST['md5'])) {
					$code = 1;
				} else {
					global $wpdb;
					$order = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wpshop_orders WHERE order_id = '.(int)$_POST['orderNumber']);
					if (!$order) {
						$code = 200;
					} else {
						$code = 0;
					}
			} 
			header_remove(); 	
			include WPSHOP_DIR ."/views/response_xml.php";
			exit;
		}
		
		if ($_POST['action'] == 'paymentAviso'){ 
			$yandex_set = get_option("wpshop.payments.yandex_kassa");
			$hash= md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$yandex_set['shopPassword']);
			if (strtolower($hash) != strtolower($_POST['md5'])) {
					$code = 1;
			} else {
					global $wpdb;
					$order = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'wpshop_orders WHERE order_id = '.(int)$_POST['orderNumber']);
					if (!$order) {
						$code = 200;
					} else {
						$code = 0;
					}
			} 
			if ($code == 0){
				global $wpdb;
				$wpdb->query("DELETE FROM {$wpdb->prefix}wpshop_selected_items WHERE selected_items_session_id='".$_POST["custom"]."'");
				Wpshop_Orders::setStatus($_POST["orderNumber"],1);
			}
			header_remove(); 	
			include WPSHOP_DIR ."/views/aviso_response_xml.php";
			exit;
		}
	}
}