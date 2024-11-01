<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'woocommerce_product_tabs', 'new_product_tab' );
function new_product_tab( $tabs ) {
		global $post;
		$var = get_post_meta($post->ID, 'unlimited_tabs', true);
		$jsonData = stripslashes(html_entity_decode($var));
		$data_array = json_decode($jsonData, true );


		foreach ($data_array as $key=>$value) {
				$tabs['ultimate_tab'.$key] = array(
									'title' 							=> base64_decode($value['wpgog_unlimited_tabs_title']),
									'priority' 						=> 50+$key,
									'callback' 						=> 'wpgog_new_product_tab_content',
									'callback_parameters' =>  $key
				);
		}
		return $tabs;
}

function wpgog_new_product_tab_content( $name,$tab_arr ) {
		global $post;
	 	$var 			= get_post_meta($post->ID, 'unlimited_tabs', true);
	 	$jsonData = stripslashes(html_entity_decode($var));
		$data_array = json_decode($jsonData, true );
		echo stripslashes( base64_decode($data_array[$tab_arr['callback_parameters']]['wpgog_unlimited_tabs']) );
}
