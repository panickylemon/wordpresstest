<?php
/*
Plugin Name: Attachment Pages Redirect
Plugin URI: 
Description: Makes attachment pages redirects (301) to post parent if any. If not, redirects (302) to home page.
Author: Samuel Aguilera
Version: 1.0
Author URI: http://www.samuelaguilera.com
*/

/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License version 3 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

	function sar_attachment_redirect() {  
		global $post;
		if ( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent != 0) ) {
			wp_redirect(get_permalink($post->post_parent), 301); // permanent redirect to post/page where image or document was uploaded
			exit;
		} elseif ( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent < 1) ) {   // for some reason it doesnt works checking for 0, so checking lower than 1 instead...
			wp_redirect(get_bloginfo('wpurl'), 302); // temp redirect to home for image or document not associated to any post/page
			exit;       
    }
	}

add_action('template_redirect', 'sar_attachment_redirect',1);

?>