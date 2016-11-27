<?php 
/**
 * 
 * @author WP Shop Team
 */
class Wpshop_View extends stdClass
{
	public function render($file)
	{
		// сначала проверяем папку темы
		$path = WPSHOP_THEME_TEMPLATE_DIR."/{$file}";
		if (file_exists($path))
		{
			include $path;	
		}
		else {
			$path = WPSHOP_VIEWS_DIR."/{$file}";
			if (file_exists($path))
			{
				include $path;	
			}
		}
	}
}