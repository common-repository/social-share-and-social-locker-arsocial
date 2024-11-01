<?php
global $wpdb, $arsocial_lite;

$shortcode = isset($_REQUEST['shortcode']) ? $_REQUEST['shortcode'] : '';
$arsocialaction = isset($_REQUEST['arsocialaction']) ? $_REQUEST['arsocialaction'] : '';
$action = '';

?>

<?php if ($shortcode === '') { ?>

    <?php
    $table_share = $arsocial_lite->arslite_networks;
    $like_table = $arsocial_lite->arslite_like;
    $fan_table = $arsocial_lite->arslite_fan;
    $table_locker = $arsocial_lite->arslite_locker;


    $results = $wpdb->get_results("SELECT network_id as ID,last_updated_date as updated_date,created_date,network_settings  FROM `$table_share`");

    $results_like = $wpdb->get_results("SELECT ID,updated_date,created_date,content FROM `$like_table`");
    $results_fan = $wpdb->get_results("SELECT ID,updated_date,created_date,content FROM `$fan_table`");
    $results_locker = $wpdb->get_results("SELECT ID,updated_date,created_date,locker_options FROM `$table_locker`");


    $final_array = array();
    $i = 1;
    $sorted_array = array();
    foreach ($results as $key => $value) {
        $options = maybe_unserialize($value->network_settings);
        $final_array[$i]['id'] = $value->ID;
        $final_array[$i]['network'] = 'share';
        $final_array[$i]['updated_date'] = $value->updated_date;
        $final_array[$i]['created_date'] = $value->created_date;
        $sorted_array[$i] = $value->created_date;
        $final_array[$i]['shortcode'] = '[ARSocial_Lite_Share id=' . $value->ID . ']';
        $final_array[$i]['edit_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=share&network_id=' . $value->ID);
        $final_array[$i]['delete_function'] = 'arsocial_lite_delete_network(' . $value->ID . ',' . $i . ')';
        $final_array[$i]['shortcode_type'] = 'Social Share';
        $final_array[$i]['css_class'] = 'ars_social_share_shortcode_type';
        $final_array[$i]['selected_network'] = isset($options['enabled_network']) ? $options['enabled_network'] : array();
        $final_array[$i]['duplicate_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=share&network_id=' . $value->ID . '&arsocialaction=duplicate');
        $i++;
    }
    foreach ($results_like as $key => $value) {
        $options = maybe_unserialize($value->content);
        $final_array[$i]['selected_network'] = array_unique(isset($options['display']['selected_network']) ? $options['display']['selected_network'] : array());
        $final_array[$i]['id'] = $value->ID;
        $final_array[$i]['network'] = 'like';
        $final_array[$i]['updated_date'] = $value->updated_date;
        $final_array[$i]['created_date'] = $value->created_date;
        $sorted_array[$i] = $value->created_date;
        $final_array[$i]['shortcode'] = '[ARSocial_Lite_Like id=' . $value->ID . ']';
        $final_array[$i]['edit_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=like&arsocialaction=edit-like&network_id=' . $value->ID);
        $final_array[$i]['delete_function'] = 'arsocial_del_like(' . $value->ID . ',' . $i . ')';
        $final_array[$i]['shortcode_type'] = 'Social Like';
        $final_array[$i]['css_class'] = 'ars_social_like_shortcode_type';
        $final_array[$i]['duplicate_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=like&network_id=' . $value->ID . '&arsocialaction=duplicate');
        $i++;
    }
    foreach ($results_fan as $key => $value) {
        $options = maybe_unserialize($value->content);
        $final_array[$i]['selected_network'] = array_unique(isset($options['display']['active_network']) ? $options['display']['active_network'] : array());
        $final_array[$i]['id'] = $value->ID;
        $final_array[$i]['network'] = 'fan';
        $final_array[$i]['updated_date'] = $value->updated_date;
        $final_array[$i]['created_date'] = $value->created_date;
        $sorted_array[$i] = $value->created_date;
        $final_array[$i]['shortcode'] = '[ARSocial_Lite_Fan id=' . $value->ID . ']';
        $final_array[$i]['edit_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=fan&arsocialaction=edit-fan&network_id=' . $value->ID);
        $final_array[$i]['delete_function'] = 'arsocial_del_fan(' . $value->ID . ',' . $i . ')';
        $final_array[$i]['shortcode_type'] = 'Fan Counter';
        $final_array[$i]['css_class'] = 'ars_social_fan_shortcode_type';
        $final_array[$i]['duplicate_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=fan&network_id=' . $value->ID . '&arsocialaction=duplicate');
        $i++;
    }
    foreach ($results_locker as $key => $value) {
        $options = maybe_unserialize($value->locker_options);
        $final_array[$i]['selected_network'] = array_unique(isset($options['display']['selected_network']) ? $options['display']['selected_network'] : array());
        $final_array[$i]['id'] = $value->ID;
        $final_array[$i]['network'] = 'locker';
        $final_array[$i]['updated_date'] = $value->updated_date;
        $final_array[$i]['created_date'] = $value->created_date;
        $sorted_array[$i] = $value->created_date;
        $final_array[$i]['shortcode'] = '[ARSocial_Lite_Locker id=' . $value->ID . '][/ARSocial_Lite_Locker]';
        $final_array[$i]['edit_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=locker&arsocialaction=edit-locker&network_id=' . $value->ID);
        $final_array[$i]['delete_function'] = 'arsocial_del_locker(' . $value->ID . ',' . $i . ')';
        $final_array[$i]['shortcode_type'] = 'Social Locker';
        $final_array[$i]['css_class'] = 'ars_social_locker_shortcode_type';
        $final_array[$i]['duplicate_url'] = admin_url('admin.php?page=arsocial-lite-shortcode-generator&shortcode=locker&network_id=' . $value->ID . '&arsocialaction=duplicate');
        $i++;
    }

    arsort($sorted_array);
    $new_final_array = array();
    $x = 1;
    if (!empty($sorted_array) && is_array($sorted_array)) {
        foreach ($sorted_array as $key => $value) {
            $new_final_array[$x] = $final_array[$key];
            $shortcode_type = $final_array[$key]['shortcode_type'];
            if ($shortcode_type === 'Social Share') {
                $new_final_array[$x]['delete_function'] = 'arsocial_lite_delete_network(' . $new_final_array[$x]['id'] . ',' . $x . ')';
            }
            if ($shortcode_type === 'Fan Counter') {
                $new_final_array[$x]['delete_function'] = 'arsocial_del_fan(' . $new_final_array[$x]['id'] . ',' . $x . ')';
            }
            if ($shortcode_type === 'Social Like') {
                $new_final_array[$x]['delete_function'] = 'arsocial_del_like(' . $new_final_array[$x]['id'] . ',' . $x . ')';
            }         
            if ($shortcode_type === 'Social Locker') {
                $new_final_array[$x]['delete_function'] = 'arsocial_del_locker(' . $new_final_array[$x]['id'] . ',' . $x . ')';
            }
            $x++;
        }
    }
    ?>
    <div style="display:none;">    
        <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/share_shortcode_selected.png" />
        <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/locker_selected.png" />
        <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_follow_selected.png" />
        <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/fan_counter_selected.png" />
        <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/copy_hover.png" />
        <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/edit_hover.png" />
        <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/delete_hover.png" />
    </div>
    <div class="arsocialshare_main_wrapper">
        <div class="arsocialshare_title_wrapper">
            <label class="arsocialshare_page_title"><?php esc_html_e('Manage Shortcodes ( Share, Like/Follow/Subscribe, Locker & Fan Counter )', 'arsocial_lite'); ?></label>
        </div>
        <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>"target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" /></div>   

        <input type="hidden" name='ars_ajaxurl' id='ars_ajaxurl' value='<?php echo admin_url('admin-ajax.php'); ?>' />

        <div class="arsocialshare_inner_wrapper">
            <div class="arsocialshare_action_button">
                <button type="button" id="ars_shortcode_generator_btn"  class="ars_generate_new_shortcode arsocialshare_save_display_settings" value="true"><?php esc_html_e('Generate Shortcode', 'arsocial_lite'); ?></button>
            </div>

        </div>

        <div class="arsocialshare_networks">
            <div class="arsocialshare_network_listing_wrapper" style="width:100%;border-radius: 4px;">
                <div class="arsocialshare_network_inner_wrapper" style="margin-bottom:10px;">
                    <div class="arsocialshare_network_list_heading_shortcode">

                        <div class="arsocialshare_network_selected_theme"><?php esc_html_e('Shortcode Type', 'arsocial_lite') ?></div>
                        <div class="arsocialshare_selected_network"><?php esc_html_e('Selected Networks', 'arsocial_lite') ?></div>
                        <div class="arsocialshare_network_shortcode"><?php esc_html_e('Shortcode', 'arsocial_lite') ?></div>
                        <div class="arsocialshare_network_created_date"><?php esc_html_e('Created Date', 'arsocial_lite') ?></div>                                
                        <div class="arsocialshare_network_last_do_action"><?php esc_html_e('Action', 'arsocial_lite') ?></div>
                    </div>
                    <?php
                    if (empty($new_final_array)) {
                        ?><div  class="arsocialshare_network_list_row" style="text-align:center;"><?php esc_html_e('No Any Shortcode Created', 'arsocial_lite'); ?></div><?php
                    }
                    $n = 1;
                    $row = 0;
                    $page_id = 1;
                    echo '<div class="container" data-page-id=1>';
                    foreach ($new_final_array as $key => $result) {
                        $n++;
                        $row++;
                        $class = (($n + 1) % 2 == 0 ) ? "ars_even_row" : "ars_odd_row";
                        if ($row > 10) {
                            $row = 0;
                            $page_id++;
                            echo '</div>';
                            echo '<div class="container" data-page-id="' . $page_id . '" style="display:none;">';
                        }
                        ?>
                        <div id="ars_network_row_<?php echo $key; ?>" class="arsocialshare_network_list_row <?php echo $class; ?>" >
                            <div class="arsocialshare_network_selected_theme"><button class="shortcode_type <?php echo $result['css_class']; ?>" disabled style="cursor : auto;"> <?php echo $result['shortcode_type']; ?></button></div>
                            <div class="arsocialshare_selected_network"> 
                                <?php
                                if (!empty($result['selected_network'])) {
                                    $i = 1;
                                    foreach ($result['selected_network'] as $test => $value) {
                                        $i++;
                                        if ($i <= 8) {
                                            echo '<span class="arsocialshare_network_icon ' . $value . '"></span>';
                                        } else {
                                            
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="arsocialshare_network_shortcode" style="position:relative;">
                                <div class="ars_copied" style="position:absolute;display: none;"><?php esc_html_e('Copied', 'arsocial_lite') ?></div>
                                <div style="width:100%;position:absolute;border:none;margin: 0;padding: 0;">
                                    <div class="arsocialshare_network_shortcode_text" id='arsocialshare_network_shortcode_text' ><?php echo $result['shortcode']; ?></div>
                                    <div title="Click To Copy" data-code='<?php echo $result['shortcode']; ?>' class="arsocialshare_copy_shortcode arsocialshare_shortcode_tooltip" style="margin-left:-20px;cursor:pointer;"></div>
                                </div>
                            </div>
                            <?php
                            $date_format = get_option('date_format');
                            //                            $time_format = get_option('time_format');
                            ?>
                            <div class="arsocialshare_network_created_date"><?php echo date($date_format, strtotime($result['created_date'])); ?></div>

                            <div class="arsocialshare_network_last_do_action">
                                <a  href="<?php echo $result['edit_url']; ?>"><div class="arsocialshare_do_action_edit arsocialshare_shortcode_tooltip" data-title="<?php esc_html_e('Edit', 'arsocial_lite'); ?>" title="<?php esc_html_e('Edit', 'arsocial_lite'); ?>"></div></a>
        <!--                                <a href="javascript:<?php echo $result['delete_function']; ?>" data-row-id="<?php echo $key; ?>"></a>-->
                                <div class="arsocialshare_do_action_delete arsocialshare_shortcode_tooltip" data-title="<?php esc_html_e('Delete', 'arsocial_lite'); ?>" title="<?php esc_html_e('Delete', 'arsocial_lite'); ?>" data-row-id="<?php echo $key; ?>"></div>
                                <div style="display:none;" id="delete_container_<?php echo $key; ?>" class="ars_delete_container" >
                                    <div class="delete_column_arrow"></div>
                                    <div class="ars_delete_shortcode_text"><?php esc_html_e('Are you sure want to delete this setup?', 'arsocial_lite'); ?></div>
                                    <div style="float:left;width:100%;border:none !important;">
                                        <button onclick="<?php echo $result['delete_function']; ?>" class="arsocialshare_save_display_settings delete_button" style="width:80px;height: 35px !important;float: left;margin-left: 30px;">
                                            <?php esc_html_e('ok', 'arsocial_lite'); ?>
                                        </button>
                                        <button onclick="ars_hide_delete_alert(<?php echo $key; ?>)" class="arsocialshare_save_display_settings delete_button" style="width:80px;height: 35px !important;float: left;margin-left: 10px;">
                                            <?php esc_html_e('Cancel', 'arsocial_lite'); ?>
                                        </button>
                                    </div>
                                </div>
                                <a href="<?php echo $result['duplicate_url']; ?>" style="margin-left:10px;display:inline-block;" ><div class="arsocialshare_do_action_duplicate arsocialshare_shortcode_tooltip" data-title="<?php esc_html_e('Duplicate', 'arsocial_lite'); ?>" title="<?php esc_html_e('Duplicate', 'arsocial_lite'); ?>"></div></a>
                            </div>
                        </div>
                        <?php
                    }
                    //container
                    echo '</div>';
                    ?>
                    <div class="arsocialshare_network_list_heading_shortcode pagination" style="margin-top:0px;">
                        <div class="ars_pagination">
                            <?php
                            if ($page_id > 1) {
                                echo '<div class="ars_page" data-id="1">';
                                echo '<<';
                                echo '</div>';
                                for ($i = 1; $i <= $page_id; $i++) {
                                    echo '<div class="ars_page" data-id="' . $i . '">';
                                    echo $i;
                                    echo '</div>';
                                }
                                echo '<div class="ars_page" data-id="' . $page_id . '">';
                                echo '>>';
                                echo '</div>';
                                ?>
                                <div class="current_page" id='current_page'>
                                    1
                                </div>
                                <div>
                                    of
                                </div>
                                <div class="last_page" id='last_page'>
                                    <?php echo $page_id; ?>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else if ($shortcode == 'share') {
    if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share.php')) {
        include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share.php');
    }
} else if ($shortcode == 'locker') {
    if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker.php')) {
        include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker.php');
    }
} else if ($shortcode == 'like') {
    if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_like.php')) {
        include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_like.php');
    }
} else if ($shortcode == 'fan') {
    if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_counter.php')) {
        include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_counter.php');
    }
}
?>



<div class = "ars_share_custom_css_info" id = "ars_shortcode_generator_popup" style="height:285px;width:580px;overflow-y: hidden;display: none;margin-top: -10%;margin-left: -5%;">
    <div class="ars_share_custom_css_info_top_belt">
        <div class="ars_share_custom_css_info_title" id="ars_share_custom_css_info_title"><?php esc_html_e('Select Shortcode Type', 'arsocial_lite'); ?></div>
        <div class="ars_share_custom_css_info_close" id="ars_shortcode_generator_popup_close"></div>
    </div>
    <div class="arsocialshare_popup_shortcode_generator_main_wrapper">
        <div class="ars_shortcode_type_col">
            <div class="ars_shortcode_type_row" id="ars_shortcode_share" data-id="ars_shortcode_share">
                <input type="radio" name="ars_shortcode_type" checked="checked" value="share" class="ars_shortcode_type_input" id="ars_shortcode_share"  style="opacity:0"/>
            </div>
            <div class="ars_shortcode_type_row" id="ars_shortcode_locker" data-id="ars_shortcode_locker">
                <input type="radio" name="ars_shortcode_type" value="locker"  class="ars_shortcode_type_input" id="ars_shortcode_locker" style="opacity:0" />
            </div>
            <div class="ars_shortcode_type_row" id="ars_shortcode_like_follow_subscribe" data-id="ars_shortcode_like_follow_subscribe">
                <input type="radio" name="ars_shortcode_type" value="like_follow_subscribe" class="ars_shortcode_type_input" id="ars_shortcode_like_follow_subscribe" style="opacity:0;" />
            </div>
            <div class="ars_shortcode_type_row" id="ars_shortcode_fan_counter" data-id="ars_shortcode_fan_counter">
                <input type="radio" name="ars_shortcode_type" value="fan_counter" class="ars_shortcode_type_input" id="ars_shortcode_fan_counter" style="opacity:0;"/>
            </div>
        </div>

        <div class="ars_shortcode_type_col">
            <button value="true" class="ars_shortcode_generator arsocialshare_save_display_settings float_right" onclick="ars_select_shortcode_type();" type="button"><?php esc_html_e('Submit', 'arsocial_lite') ?></button>
        </div>

    </div>
</div>

<div class="ars_lite_upgrade_modal" id="ars_lite_locker_shortcode_premium_notice" style="display:none;">
    <div class="upgrade_modal_top_belt">
        <div class="logo" style="text-align:center;"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_update_logo.png" /></div>
        <div id="nav_style_close" class="close_button b-close"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_upgrade_close_img.png" /></div>
    </div>
    <div class="upgrade_title"><?php esc_html_e('Upgrade To Premium Version.', 'arsocial_lite'); ?></div>
    <div class="upgrade_message"><?php esc_html_e('To unlock this Feature, Buy Premium Version for $20.00 Only.', 'arsocial_lite'); ?></div>
    <div class="upgrade_modal_btn">
        <button id="pro_upgrade_button"  type="button" class="buy_now_button"><?php esc_html_e('Buy Now', 'arsocial_lite'); ?></button>
        <button id="pro_upgrade_cancel_button"  class="learn_more_button" type="button"><?php esc_html_e('Learn More', 'arsocial_lite'); ?></button>
                 <input type="hidden" name="ars_version" id="ars_version" value="<?php global $arsocial_lite_version; echo $arsocial_lite_version;?>" />
        				<input type="hidden" name="ars_request_version" id="ars_request_version" value="<?php echo get_bloginfo('version');?>" />
    </div>
</div>   


<script>
    jQuery(document).on('click', '.ars_page', function () {
	console.log(jQuery(this).attr('data-id'));
	jQuery('.container:visible').hide();
	jQuery('[data-page-id=' + jQuery(this).attr('data-id') + ']').show();
	jQuery('#current_page').html(jQuery(this).attr('data-id'));
    });
</script>