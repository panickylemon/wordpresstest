
<?php function striped_sidebar() {

	$args = array(
		'id'            => 'sidebar-left',
		'name'          => __( 'Sidebar', 'striped' ),
		'description'   => __( 'Left Sidebar', 'striped' ),
		'class'         => 'striped-widget',
		'before_title'  => '<header><h2 class="widgettitle">',
		'after_title'   => '</h2></header>',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	);
	register_sidebar( $args );

}

add_action( 'widgets_init', 'striped_sidebar' );?>