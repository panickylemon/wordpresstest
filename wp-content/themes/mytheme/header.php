<html <?php language_attributes(); ?>>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>"/>
	<title>
		<?php
		wp_title('|', true, 'right');
		?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="/wordpresstest/wp-content/themes/mytheme/js/jquery-1.12.0.min.js"></script>
	<?php wp_head(); ?>
	<link href="/wordpresstest/wp-content/themes/mytheme/style/style.css" type="text/css" rel="stylesheet">
	<link href="/wordpresstest/wp-content/themes/mytheme/style/media.css" type="text/css" rel="stylesheet">
	<script src="/wordpresstest/wp-content/themes/mytheme/js/main.js"></script>

</head>

<body <?php body_class(); ?>>
<div class="content">
	<header>
		<div class="nav_wrap">
			<div class="nav">
				<ul class="menu menu_left left">
					<li class="left">
						<div><a href="/wordpresstest/shop/">МАГАЗИН</a></div>
					</li>
					<li class="right">
						<div><a href="/wordpresstest/about/">О БРЕНДЕ</a></div>
					</li>
				</ul>

				<div class="logo">
					<div><a href="/wordpresstest/"><img src="/wordpresstest/wp-content/themes/mytheme/image/Klishe_STAYN_photo.png"
					                              alt="логотип"></a></div>
				</div>

				<ul class="menu menu_right right">
					<li class="left">
						<div><a href="/wordpresstest/gallery/">ГАЛЕРЕЯ</a></div>
					</li>
					<li class="right">
						<div><a href="/wordpresstest/contacts/">КОНТАКТЫ</a></div>
					</li>
				</ul>
				<div class="burger_menu">
					<img src="/wordpresstest/wp-content/themes/mytheme/image/menu.png" alt="меню" id="burger_menu">
				</div>
				<div class="burger_menu_close">
					<img src="/wordpresstest/wp-content/themes/mytheme/image/close.png" alt=" закрыть меню">
				</div>
			</div>
			<div class="nav_mobile">
				<ul class="menu_mobile">
					<li class="">
						<div><a href="#">МАГАЗИН</a></div>
					</li>
					<li class="">
						<div><a href="#">О БРЕНДЕ</a></div>
					</li>
					<li class="">
						<div><a href="#">ГАЛЕРЕЯ</a></div>
					</li>
					<li class="">
						<div><a href="#">КОНТАКТЫ</a></div>
					</li>
				</ul>
			</div>
		</div>
	</header>
