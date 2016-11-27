<?php 

class Wpshop_Utils
{
	/**
	 * @param string $type может принимать следующие значени€ en и ru
	 * @param string строка в формате en или ru
	 * @return string ¬озвращает дату в нужном формате, либо ¬ызывает Exeption, если преобразование прошло безуспешно
	 */
	public static function checkDate($type,$dateString)
	{
		$currentFormat = '';
		$tmp = array();
		
		if (preg_match("/^(\d+)\.(\d+)\.(\d+)$/",$dateString,$tmp))
		{
			$currentFormat = 'ru';
		}
		else if (preg_match("/^(\d+)\-(\d+)\-(\d+)$/",$dateString,$tmp))
		{
			$currentFormat = 'en';
		}
		
		
		if ($type == $currentFormat)
		{
			return $dateString;
		}
		if ($currentFormat == '')
		{
			throw new Exception();
		}
		
		$newString = '';
		if ($type=="ru")
		{
			$newString = "{$tmp[3]}.{$tmp[2]}.{$tmp[1]}";	
		}
		
		if ($type == "en")
		{
			$newString = "{$tmp[3]}-{$tmp[2]}-{$tmp[1]}";
		}
		
		if ($newString != '')
		{
			return $newString;
		}
		else
		{
			throw new Exception();
		}	
	}
}
