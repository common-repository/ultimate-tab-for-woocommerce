<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


// WooCommerce Tab Add
add_filter( 'woocommerce_product_data_tabs', 'wogog_unlimited_tabs' );
function wogog_unlimited_tabs($tabs){
    $tabs['reward'] = array(
        'label'     => __('Unlimited Tabs', 'ultimate-tab-for-woocommerce'),
        'target'    => 'unlimited_tabs',
    );
    return $tabs;
}


add_action( 'woocommerce_product_data_panels', 'wpgog_unlimited_tab_content' );
function wpgog_unlimited_tab_content($post_id){

		global $post;
    $var 					= get_post_meta($post->ID, 'unlimited_tabs', true);
		$jsonData 		= stripslashes(html_entity_decode($var));
    $data_array 	= json_decode($jsonData, true );
    ?>

    <div id='unlimited_tabs' class='panel woocommerce_options_panel'>
        <?php
        $display        = 'block';
        $meta_count     = count( $data_array );
        if ( $meta_count > 0 ){ $display = 'none'; }

        echo  "<div class='unlimited_tab_group' style='display:" . $display . ";'>";
            echo "<div class='unlimited_tab_field_copy'>";
								echo '<p class="form-field">';
										echo '<label>'.__("Tab Title","ultimate-tab-for-woocommerce").'</label>';
										echo '<input name="wpgog_unlimited_tabs_title[]" class="shorts" id="wpgog_unlimited_tabs_title[]" placeholder="'.__("Tab Title","ultimate-tab-for-woocommerce").'" value="">';
								echo '</p>';
								echo '<p class="form-field">';
										echo '<label>'.__("Tab Description","ultimate-tab-for-woocommerce").'</label>';
										echo '<textarea class="short" name="wpgog_unlimited_tabs[]" id="wpgog_unlimited_tabs[]" placeholder="'.__( "Tab Description" , "ultimate-tab-for-woocommerce" ).'"></textarea>';
								echo '</p>';
								echo '<input name="remove_unlimited_tabs" type="button" class="button tagadd removeUnlimitedTabs" value="' . __('- Remove', 'ultimate-tab-for-woocommerce') . '" />';
						echo "</div>";
        echo "</div>";


        /*
        * Print with value of Reward System
        */
        if ($meta_count > 0) {
            if (is_array($data_array) && !empty($data_array)) {
                foreach ($data_array as $k => $v) {
                    echo "<div class='unlimited_tab_group'>";
                        echo "<div class='unlimited_tab_field_copy'>";
														echo '<p class="form-field">';
																echo '<label>'.__("Tab Title","ultimate-tab-for-woocommerce").'</label>';
																echo '<input name="wpgog_unlimited_tabs_title[]" class="shorts" id="wpgog_unlimited_tabs_title[]" placeholder="'.__("Tab Title","ultimate-tab-for-woocommerce").'" value="'.stripslashes(base64_decode($v["wpgog_unlimited_tabs_title"])).'">';
														echo '</p>';
														echo '<p class="form-field">';
																echo '<label>'.__("Tab Description","ultimate-tab-for-woocommerce").'</label>';
																echo '<textarea class="short" name="wpgog_unlimited_tabs[]" id="wpgog_unlimited_tabs[]" placeholder="'.__( "Tab Description" , "ultimate-tab-for-woocommerce" ).'">'.stripslashes(base64_decode($v["wpgog_unlimited_tabs"])).'</textarea>';
														echo '</p>';
														echo '<input name="remove_unlimited_tabs" type="button" class="button tagadd removeUnlimitedTabs" value="' . __('- Remove', 'ultimate-tab-for-woocommerce') . '" />';
												echo "</div>";
                    echo "</div>";
                }
            }
        }
        ?>
        <input name="save" type="button" class="button button-primary tagadd" id="addunlimitedtabs" value="<?php _e('+ Add Another Tab', 'ultimate-tab-for-woocommerce'); ?>">
    </div>

    <?php
}


// Repeatable Data Save
add_action( 'woocommerce_process_product_meta', 'wpgog_unlimited_tab_field_save' );
function wpgog_unlimited_tab_field_save($post_id){
    if( isset( $_POST['wpgog_unlimited_tabs_title'] ) ){
        if (!empty($_POST['wpgog_unlimited_tabs_title'])) {
            $unlimited_tabs_title = $_POST['wpgog_unlimited_tabs_title'];
            $unlimited_tabs = '';
            if( isset($_POST['wpgog_unlimited_tabs']) ){ $unlimited_tabs =  $_POST['wpgog_unlimited_tabs']; }
            $data = array();
            for ($i = 0; $i <  count($unlimited_tabs_title); $i++) {
                if (!empty($unlimited_tabs_title[$i])) {
										$datas = new stdClass();
										$datas->wpgog_unlimited_tabs_title = base64_encode($unlimited_tabs_title[$i]);
										$datas->wpgog_unlimited_tabs = base64_encode($unlimited_tabs[$i]);
                    $data[] = $datas;
                }
            }
            $data_json = json_encode( $data );
            update_post_meta( $post_id, 'unlimited_tabs', $data_json );
        }
    }
}
