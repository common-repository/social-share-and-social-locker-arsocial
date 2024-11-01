<?php
global $arsocial_lite, $wpdb;
$ars_lite_default_networks = $arsocial_lite->ARSocialShareDefaultNetworks();
$defaultsettings = $arsocial_lite->arsocialshare_default_settings();
$default_settings = $defaultsettings['socialshare'];
$settings = get_option('arslite_settings');
$settings = maybe_unserialize($settings);
$networks = $settings['networks'];
$themes = $settings['theme'];
$arsocialshare_default_no_format = $arsocial_lite->ARSocialShareDefaultNetworksFanCounter();
$default_no_format = $arsocialshare_default_no_format['counter_number_format']['counter_number_format'];

$default_themes = $ars_lite_default_networks['theme'];
$sidebar_themes = $ars_lite_default_networks['sidebar_theme'];
$default_effects = $ars_lite_default_networks['effect'];
$sidebar_effects = $ars_lite_default_networks['sidebar_effect'];
if (!empty($default_themes)) {
    foreach ($default_themes as $theme => $val) {
        wp_enqueue_style('arsocial_lite_theme-' . $theme);
    }
    wp_enqueue_style('arsocial_lite_theme-rolling');
}
$display_order = array();
$new_order = array();

if (!function_exists('is_plugin_active')) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

foreach ($ars_lite_default_networks['networks'] as $key => $value) {
    $display_order[$key] = $value['display_order'];
}

asort($display_order);
$networks_sorted = array();
$ars_lite_default_pro_networks = array();
$ars_lite_default_pro_networks = $ars_lite_default_networks['networks'];
$ars_lite_default_networks = $ars_lite_default_networks['networks'];

if(isset($display_order) && count($display_order)>0){
    foreach ($display_order as $id => $network) {
	$networks_sorted['networks'][$id] = @$networks[$id];
    }
}

ksort($ars_lite_default_networks);

$new_sorted_networks = array();
if (get_option('arslite_global_sharing_order')) {
    $ordered_data = maybe_unserialize(get_option('arslite_global_sharing_order'));
} else {
    $ordered_data = $default_settings['network_order'];
}
if (in_array('dribbble', $ordered_data)) {
    $key = array_search('dribbble', $ordered_data);
    unset($ordered_data[$key]);
}

array_keys($ordered_data);
if (!empty($ordered_data) && is_array($ordered_data)) {
    foreach ($ordered_data as $key => $value) {
        $new_sorted_networks[$value] = $ars_lite_default_networks[$value];
    }
    $ars_lite_default_networks = $new_sorted_networks;
}
?>
<script type="text/javascript">
    function arsocialshare_check_special_page() {
        var ars_special_page;
        ars_special_page = '<?php echo json_encode($arsocial_lite->arsocialshare_wp_special_pages()); ?>';
        return ars_special_page;
    }
</script>
<div style="display:none;">    
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/sidebar_btn_selected.png" />    
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/checkbox_round_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/top_bottom_bar_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/pages_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/posts_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/position_right_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/small_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/medium_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/large_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/floating_bottom_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/floating_top.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/after_price_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/after_product_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/before_product_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_left_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_right_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_center.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_center_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/page_bottom_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/page_top_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_2_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_3_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_1.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_1_selected.png" />    
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/share_btn_selected.png" />    
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/share_point_left_btn_selected.png" />    
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/share_point_right_btn_selected.png" />    
</div>
<input type="hidden" id="arsocialshare_ajaxurl" name="arsocialshare_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>" />
<div class="arsocialshare_main_wrapper">
    <div class="arsocialshare_title_wrapper">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Share Button Configuration', 'arsocial_lite'); ?></label>
    </div>
    <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" /></div>

    <div class="arsocialshare_inner_wrapper" style="padding:0;">
        <div class="arsocialshare_networks_inner_wrapper">

            <?php
            $displaysettings = get_option('arslite_networks_display_setting');
            $displays = array();
            $pro_networks = array();
            if ($displaysettings) {
                $dsettings = maybe_unserialize($displaysettings);
                $dnetworks = $dsettings['networks'];
                $networks_display_name = $dsettings['network_display_name'];
                $displays = isset($dsettings['display']) ? $dsettings['display'] : array();
            }
            $pro_networks = array('facebook', 'twitter', 'linkedin', 'pinterest', 'buffer', 'reddit');
            ?>
            <!-- Lists of Networks to Display -->

            <div class="arsocialshare_title_belt">
                <div class="arsocialshare_title_belt_number">1</div>
                <div class="arsocialshare_belt_title"><?php esc_html_e('Select Networks', 'arsocial_lite'); ?></div>
            </div>

            <span class="ars_error_message" id="arsocialshare_network_error"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
            <div class="arsocialshare_inner_container">
                <div class="ars_network_list_container selected arsocialshare_sharing_share_sortable ars_save_order" id="arsocialshare_sharing_options">
<?php
foreach ($ars_lite_default_networks as $id => $value) {
    $nvalue = isset($networks_display_name[$id]) ? $networks_display_name[$id] : $ars_lite_default_networks[$id];
    $enabled = "";
    $btnClass = (isset($dnetworks) && !empty($dnetworks) && is_array($dnetworks) && in_array($id, $dnetworks)) ? "selected" : "";
    $checked = (isset($dnetworks) && !empty($dnetworks) && is_array($dnetworks) && in_array($id, $dnetworks)) ? "checked='checked'" : "";
    $pro_network = (in_array($id, $pro_networks)) ? true : false;
    ?>
                        <?php if ($pro_network == true) { ?>
                            <div class="arsocialshare_network_buttons  <?php echo $btnClass; ?>" id="arsnetworks_in_position_<?php echo $id; ?>">
                                <input type="hidden" name="ars_network_display_name" id="ars_display_id_<?php echo $id; ?>" value="<?php echo $nvalue['display_name']; ?>"/>
                                <input type="checkbox" name="position_setting_display_networks[]" value="<?php echo $id; ?>" <?php echo $checked; ?> class="arsocialshare_position_setting_network_input" id="arsocialsharenetwork_<?php echo $id; ?>" />
                                <label for="arsocialsharenetwork_<?php echo $id; ?>"><span></span></label>
                                <span class="arsocialshare_network_icon <?php echo $id; ?>"></span>
                                <label class="arsocialshare_network_label ars_share_editable" data-network="ars_display_id_<?php echo $id; ?>" ><?php echo $nvalue['display_name']; ?></label>
                                <span class="arsocialshare_move_icon ui-sortable-handle"></span>
                            </div>
        <?php
    }
}
?>
                </div>
                <!--Disabled Networks-->
                <div class="ars_network_list_container ars_lite_pro_networks selected" id="arsocialshare_sharing_options">
                    <div class="ars_lite_pro_networks_info"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Available in premium version', 'arsocial_lite'); ?> )</span></div>
<?php
foreach ($ars_lite_default_pro_networks as $id => $value) {
    $nvalue = $ars_lite_default_pro_networks[$id];
    $pro_network = (in_array($id, $pro_networks)) ? true : false;
    ?>
                        <?php if ($pro_network == false) { ?>
                            <div class="arsocialshare_network_buttons_disabled" id="arsnetworks_in_position_<?php echo $id; ?>">
                                <input type="hidden" name="ars_network_display_name" id="ars_display_id_<?php echo $id; ?>" value="<?php echo $nvalue['display_name']; ?>"/>
                                <input type="checkbox" name="position_setting_display_networks[]" value="<?php echo $id; ?>" class="arsocialshare_position_setting_network_input" id="arsocialsharenetwork_<?php echo $id; ?>" />
                                <label for="arsocialsharenetwork_<?php echo $id; ?>"><span></span></label>
                                <span class="arsocialshare_network_icon <?php echo $id; ?>"></span>
                                <label class="arsocialshare_network_label" data-network="ars_display_id_<?php echo $id; ?>" ><?php echo $nvalue['display_name']; ?></label>
                                <span class="arsocialshare_move_icon ui-sortable-handle"></span>
                            </div>
        <?php
    }
}
?>
                </div>
            </div>
            <!-- Lists of Networks to Display -->

            <div class="arsocialshare_title_belt">
                <div class="arsocialshare_title_belt_number">2</div>
                <div class="arsocialshare_belt_title"><?php esc_html_e('Sitewide Button Setup', 'arsocial_lite'); ?></div>
            </div>
            <div class="arsocialshare_inner_container">

                <div class="arsocialshare_inner_content_wrapper">
<?php
$sidebar_checked = "";
$topbottombar_checked = "";
$popup_checked = "";
$media_checked = "";
if (is_array($displays) && array_key_exists('sidebar', $displays)) {
    $sidebar_checked = "checked='checked'";
}
if (is_array($displays) && array_key_exists('top_bottom_bar', $displays)) {
    $topbottombar_checked = "checked='checked'";
}
if (is_array($displays) && array_key_exists('popup', $displays)) {
    $popup_checked = "checked='checked'";
}
if (is_array($displays) && array_key_exists('media', $displays)) {
    $media_checked = "checked='checked'";
}
?>
                    <input type="checkbox" name="arsocialshare_enable_sidebar" value="sidebar" id="arsocialshare_enable_sidebar" <?php echo $sidebar_checked; ?> class="ars_display_option_input ars_hide_checkbox" />
                    <input type="checkbox" name="arsocialshare_enable_top_bottom_bar" value="top_bottom_bar" id="arsocialshare_enable_top_bottom_bar" <?php echo $topbottombar_checked ?> class="ars_display_option_input ars_hide_checkbox" />
                    <input type="checkbox" name="arsocialshare_enable_popup" value="popup" id="arsocialshare_enable_popup" <?php echo $popup_checked ?> class="ars_display_option_input ars_hide_checkbox" />
                    <input type="checkbox" name="arsocialshare_enable_media" value="media" id="arsocialshare_enable_media" <?php echo $media_checked ?> class="ars_display_option_input ars_hide_checkbox" />
                    <div class="arsocialshare_inner_container_main">
                        <div class="arsocialshare_option_box sidebar_icon <?php echo ($sidebar_checked !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_sidebar" data-opt-id="arsocialshare_sidebar">
                            <div class="arsocialshare_option_checkbox"><span></span></div>
                        </div>
                        <div class="arsocialshare_option_box top_bottom_bar_icon <?php echo ($topbottombar_checked !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_top_bottom_bar" data-opt-id="arsocialshare_top_bottom_bar">
                            <div class="arsocialshare_option_checkbox"><span></span></div>
                        </div>
                        <div class="arsocialshare_option_box popup_icon <?php echo ($popup_checked !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_popup" data-opt-id="arsocialshare_popup">
                            <div class="arsocialshare_option_checkbox"><span></span></div>
                        </div>
                        <div class="arsocialshare_option_box media_icon <?php echo ($media_checked !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_media" data-opt-id="arsocialshare_media">
                            <div class="arsocialshare_option_checkbox"><span></span></div>
                        </div>
                    </div>
                    <div class="ars_network_list_container <?php echo ($sidebar_checked !== '' ) ? "selected" : ""; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_sidebar">
                        <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img style="margin-top:0px;" src="<?php echo ARSOCIAL_LITE_URL; ?>/images/sidebar_styling_settings.png" /></div>
                             <div class="arsfontsize25"><?php esc_html_e('Sidebar Styling Settings', 'arsocial_lite'); ?></div>
                        </div>

                        <div class="arsocialshare_option_container ars_column arsmarginleft10">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $sidebar_skin = (isset($displays['sidebar']['skin']) && !empty($displays['sidebar']['skin'])) ? $displays['sidebar']['skin'] : "lite_default"; ?>
                                    <select name="arsocialshare_sidebar_skins" id="arsocialshare_sidebar_skins" class="arsocialshare_dropdown ars_lite_pro_options">
                                    <?php
                                    foreach ($sidebar_themes as $value => $label) {
                                        ?>
                                            <option <?php selected($sidebar_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            <label class="arsocialshare_inner_option_label more_templates_label" ><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $sidebar_position = (isset($displays['sidebar']['position']) && !empty($displays['sidebar']['position'])) ? $displays['sidebar']['position'] : "left"; ?>
                                    <input type="radio" name="arsocialshare_sidebar" value="left" data-on="left" <?php checked($sidebar_position, 'left'); ?> class="arsocialshare_display_networks_on ars_hide_checkbox arsocialshare_sidebar_buttons_position" id="arsocialshare_sidebar_buttons_on_left" />
                                    <input type="radio" name="arsocialshare_sidebar" value="right" data-on="right" <?php checked($sidebar_position, 'right'); ?> class="arsocialshare_display_networks_on ars_hide_checkbox arsocialshare_sidebar_buttons_position" id="arsocialshare_sidebar_buttons_on_right" />
                                    <div class="arsocialshare_inner_option_box arsocialshare_sidebar_position <?php echo ($sidebar_position === 'left') ? "selected" : ""; ?>" id="arsocialshare_sidebar_buttons_on_left_img" data-value="left" onclick="ars_select_radio_img('arsocialshare_sidebar_buttons_on_left', 'arsocialshare_sidebar_position')">
                                        <span class="arsocialshare_inner_option_icon sidebar_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box arsocialshare_sidebar_position <?php echo ($sidebar_position === 'right') ? "selected" : ""; ?>" id="arsocialshare_sidebar_buttons_on_right_img" data-value="right" onclick="ars_select_radio_img('arsocialshare_sidebar_buttons_on_right', 'arsocialshare_sidebar_position')">
                                        <span class="arsocialshare_inner_option_icon sidebar_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

<?php $sidebar_button_style = (isset($displays['sidebar']['button_style']) && !empty($displays['sidebar']['button_style'])) ? $displays['sidebar']['button_style'] : "icon_without_name"; ?>
                            <input type="hidden" name="arsocialshare_sidebar_button_style" value="icon_without_name" class="ars_hide_checkbox arsocialshare_sidebar_button_style" id="arsocialshare_sidebar_btn_icon_without_name" />

<?php
$sidebar_hover_effect = isset($displays['sidebar']['hover_effect']) ? $displays['sidebar']['hover_effect'] : 'effect1';
$sidebar_hover_effect_attr = '';
if ($sidebar_skin == 'rolling') {
    $sidebar_hover_effect_attr = 'disabled="disabled"';
}
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_sidebar_hover_effect" id="arsocialshare_sidebar_hover_effect" class="arsocialshare_dropdown" <?php echo $sidebar_hover_effect_attr; ?>>
<?php
foreach ($sidebar_effects as $value => $label) {
    ?><option <?php selected($sidebar_hover_effect, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option><?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Remove Space Between Buttons', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$sidebar_remove_space = (isset($displays['sidebar']['remove_space']) && !empty($displays['sidebar']['remove_space'])) ? $displays['sidebar']['remove_space'] : "no";
?>
                                    <input type="hidden" name="arsocialshare_sidebar_remove_space" id="arsocialshare_sidebar_remove_space" value="<?php echo $sidebar_remove_space; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($sidebar_remove_space === 'yes') ? "selected" : ""; ?>" data-id="arsocialshare_sidebar_remove_space">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

<?php
$sidebar_show_total_counter = isset($displays['sidebar']['enable_total_counter']) ? $displays['sidebar']['enable_total_counter'] : 'no';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Total Share Count', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_sidebar_show_total_share" id="arsocialshare_sidebar_show_total_share" value="<?php echo $sidebar_show_total_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($sidebar_show_total_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_sidebar_show_total_share">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
<?php
$sidebar_show_total_counter_label = isset($displays['sidebar']['arsocial_total_share_label']) ? $displays['sidebar']['arsocial_total_share_label'] : 'SHARES';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Label', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" id="arsocialshare_sidebar_total_share_label" name="arsocialshare_sidebar_total_share_label" class="arsocialshare_input_box" value="<?php echo $sidebar_show_total_counter_label; ?>" />
                                </div>
                            </div>


                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $sidebar_show_counter = (isset($displays['sidebar']['show_counter']) && !empty($displays['sidebar']['show_counter'])) ? $displays['sidebar']['show_counter'] : "yes"; ?>
                                    <input type="hidden" name="arsocialshare_sidebar_show_count" id="arsocialshare_sidebar_show_count" value="<?php echo $sidebar_show_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($sidebar_show_counter === 'yes') ? "selected" : ""; ?>" id="show_counter" data-id="arsocialshare_sidebar_show_count">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id='arsfan_sidebar_display_number_format' name='arsfan_sidebar_display_number_format' class="arsocialshare_dropdown">
<?php
$counter_number_format = $default_no_format;
$ars_sidebar_no_format = isset($displays['sidebar']['no_format']) ? $displays['sidebar']['no_format'] : 'style5';
foreach ($counter_number_format as $key => $value) {
    ?>
                                            <option <?php selected($ars_sidebar_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

<?php
$sidebar_btn_width = isset($displays['sidebar']['button_width']) ? $displays['sidebar']['button_width'] : 'medium';
$sidebar_btn_hide = ($sidebar_skin == 'rolling') ? 'display: none;' : '';
?>
                            <div class="arsocialshare_option_row ars_lite_sidebar_btn_width_options" style="<?php echo $sidebar_btn_hide; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Size', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="radio" name="ars_lite_sidebar_btn_width" id="ars_lite_sidebar_btn_small" <?php echo checked($sidebar_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_share_sidebar_btn_width_input" />
                                    <input type="radio" name="ars_lite_sidebar_btn_width" id="ars_lite_sidebar_btn_medium" <?php echo checked($sidebar_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_share_sidebar_btn_width_input"  />
                                    <input type="radio" name="ars_lite_sidebar_btn_width" id="ars_lite_sidebar_btn_large" <?php echo checked($sidebar_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_share_sidebar_btn_width_input" />
                                    <div class="arsocialshare_inner_option_box ars_lite_sidebar_btn_width <?php echo ($sidebar_btn_width === 'small') ? "selected" : ""; ?>" id="ars_lite_sidebar_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_lite_sidebar_btn_small', 'ars_lite_sidebar_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_lite_sidebar_btn_width <?php echo ($sidebar_btn_width === 'medium') ? "selected" : ""; ?>" id="ars_lite_sidebar_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_lite_sidebar_btn_medium', 'ars_lite_sidebar_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_lite_sidebar_btn_width <?php echo ($sidebar_btn_width === 'large') ? "selected" : ""; ?>" id="ars_lite_sidebar_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_lite_sidebar_btn_large', 'ars_lite_sidebar_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $more_btn_after = (isset($displays['more_button']['after']) && !empty($displays['more_button']['after'])) ? $displays['more_button']['after'] : $default_settings['styling_options']['more_button_after']; ?>
                                    <input type="text" name="arsocialshare_sidebar_more_button" class="arsocialshare_input_box" id="arsocialshare_sidebar_more_button" value="<?php echo $more_btn_after; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
<?php
$more_btn_style = (isset($displays['sidebar']['more_button_style']) && !empty($displays['sidebar']['more_button_style'])) ? $displays['sidebar']['more_button_style'] : "plus_icon";
?>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_sidebar_more_button_style" id="arsocialshare_sidebar_more_button_style" class="arsocialshare_dropdown">
                                        <option value="plus_icon" <?php selected($more_btn_style, 'plus_icon'); ?>><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option value="dot_icon" <?php selected($more_btn_style, 'dot_icon'); ?>><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
<?php $more_btn_action = (isset($displays['sidebar']['more_button_action']) && !empty($displays['sidebar']['more_button_action'])) ? $displays['sidebar']['more_button_action'] : $default_settings['styling_options']['more_button_action']; ?>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_sidebar_more_button_action" id="arsocialshare_sidebar_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                        <option <?php selected($more_btn_action, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                        <option <?php selected($more_btn_action, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                            <div class="ars_template_preview_container ars_lite_sidebar_template_preview_container" id="arsocialshare_sidebar_theme_preview" style="margin-top:-15px;">
                                <div class="arsocial_lite_buttons_container arsocialshare_fly_button_wrapper arsocial_lite_sidebar_button_wrapper ars_<?php echo $sidebar_position; ?>_button">
                                    <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $sidebar_skin; ?>_theme arseffect_<?php echo $sidebar_hover_effect; ?> <?php echo ($sidebar_remove_space == 'yes') ? 'ars_remove_space' : ''; ?>">
<?php foreach (array('facebook') as $sn): ?>
                                            <div class='arsocialshare_button <?php echo $sn; ?> ars_<?php echo $sidebar_button_style; ?> arsocialshare_<?php echo $sn; ?>_wrapper ars_<?php echo $sidebar_btn_width; ?>_btn' id='arsocialshare_<?php echo $sn; ?>_btn' data-network="<?php echo $sn; ?>">
                                                <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $sidebar_skin; ?>_theme_icon socialshare-<?php echo $sn; ?>'></span>
                                                <label class='arsocialshare_network_name'><?php echo ucfirst($sn); ?></label>
                                                <span class='arsocialshare_counter arsocialshare_<?php echo $sn; ?>_counter arsocialshare_counter_show_<?php echo $sidebar_show_counter; ?>' id='arsocialshare_<?php echo $sn; ?>_counter'>0</span>
                                            </div>
<?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_container" style="margin-top:20px;">
                            <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input" style="padding-top:6px;">
                                <input type="text" name="arsocialshare_sidebar_excludes_pages" id="arsocialshare_sidebar_excludes_pages" value="<?php echo isset($displays['sidebar']['exclude_pages']) ? $displays['sidebar']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                            </div>
                        </div>

                        <div class="arsocialshare_option_container">
                            <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                        </div>

                        <div class="arsocial_lite_locker_row_seperator"></div>
                    </div>
                    <div class="ars_network_list_container <?php echo ($topbottombar_checked !== '' ) ? "selected" : ""; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_top_bottom_bar">
                        <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/top_bottom_bar_styling_setting.png" /></div>
                            <div class="arsfontsize25"><?php esc_html_e('Top/Bottom Bar Styling Settings', 'arsocial_lite'); ?></div>
                        </div>
                        <div class="arsocialshare_option_container ars_column arsmarginleft10">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_top_bottom_skins" id="arsocialshare_top_bottom_skins" class="arsocialshare_dropdown ars_lite_pro_options">
<?php
$top_bottom_skin = isset($displays['top_bottom_bar']['skin']) ? $displays['top_bottom_bar']['skin'] : 'lite_default';
foreach ($default_themes as $value => $label) {
    ?>
                                            <option <?php selected($top_bottom_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$top_bar_checked = "";
$bottom_bar_checked = "";
if (isset($displays['top_bottom_bar']['top']) && $displays['top_bottom_bar']['top'] == true) {
    $top_bar_checked = "checked='checked'";
}
if (isset($displays['top_bottom_bar']['bottom']) && $displays['top_bottom_bar']['bottom'] == true) {
    $bottom_bar_checked = "checked='checked'";
}
if ($top_bar_checked == '' && $bottom_bar_checked == '') {
    $top_bar_checked = "checked='checked'";
}
?>
                                    <input type="radio" name="arsocialshare_top_bar" value="top_bar" data-on="top_bar" <?php echo $top_bar_checked; ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_top" />
                                    <input type="radio" name="arsocialshare_bottom_bar" value="bottom_bar" <?php echo $bottom_bar_checked; ?> data-on="bottom_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_bottom" />
                                    <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($top_bar_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('arsocialshare_buttons_on_top', '', '');" id="arsocialshare_buttons_on_top_img" data-value="top">
                                        <span class="arsocialshare_inner_option_icon top_bar"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($bottom_bar_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('arsocialshare_buttons_on_bottom', '', '');" id="arsocialshare_buttons_on_bottom_img" data-value="right">
                                        <span class="arsocialshare_inner_option_icon bottom_bar"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>
<?php
$top_bottom_button_style = isset($displays['top_bottom_bar']['button_style']) ? $displays['top_bottom_bar']['button_style'] : 'name_with_icon';
$nwi_tb_button_style_css = '';
if ($top_bottom_skin == 'rounded') {
    $nwi_tb_button_style_css = "display:none;";
    $top_bottom_button_style = 'icon_without_name';
}
?>
                            <div class="arsocialshare_option_row ars_top_bottom_button_style_opts" style="<?php echo $nwi_tb_button_style_css; ?>">

                                <input type="radio" name="arsocialshare_top_bottom_bar_button_style" value="name_with_icon" <?php checked($top_bottom_button_style, 'name_with_icon'); ?> class="arsocialshare_top_bottom_button_style ars_hide_checkbox" id="arsocialshare_top_bottom_btn_name_with_icon" />
                                <input type="radio" name="arsocialshare_top_bottom_bar_button_style" value="name_without_icon" <?php checked($top_bottom_button_style, 'name_without_icon'); ?> class="arsocialshare_top_bottom_button_style ars_hide_checkbox" id="arsocialshare_top_bottom_btn_name_without_icon" />
                                <input type="radio" name="arsocialshare_top_bottom_bar_button_style" value="icon_without_name" <?php checked($top_bottom_button_style, 'icon_without_name'); ?> class="arsocialshare_top_bottom_button_style ars_hide_checkbox" id="arsocialshare_top_bottom_btn_icon_without_name" />
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <div class='arsocialshare_inner_option_box arsocialshare_top_bottom_btn_style <?php echo ($top_bottom_button_style === 'name_with_icon') ? 'selected' : ''; ?>' id="arsocialshare_top_bottom_btn_name_with_icon_img" data-value="name_with_icon" onclick="ars_select_radio_img('arsocialshare_top_bottom_btn_name_with_icon', 'arsocialshare_top_bottom_btn_style')">
                                        <span class="arsocialshare_inner_option_icon name_with_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_top_bottom_btn_style <?php echo ($top_bottom_button_style === 'name_without_icon') ? 'selected' : ''; ?>' id="arsocialshare_top_bottom_btn_name_without_icon_img" data-value="name_without_icon" onclick="ars_select_radio_img('arsocialshare_top_bottom_btn_name_without_icon', 'arsocialshare_top_bottom_btn_style')">
                                        <span class="arsocialshare_inner_option_icon name_without_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_top_bottom_btn_style <?php echo ($top_bottom_button_style === 'icon_without_name') ? 'selected' : ''; ?>' id="arsocialshare_top_bottom_btn_icon_without_name_img" data-value="icon_without_name" onclick="ars_select_radio_img('arsocialshare_top_bottom_btn_icon_without_name', 'arsocialshare_top_bottom_btn_style')">
                                        <span class="arsocialshare_inner_option_icon icon_without_name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_global_share_hover_effect" id="arsocialshare_top_bottom_hover_effect" class="arsocialshare_dropdown">
<?php
$top_bottom_hovereffect = isset($displays['top_bottom_bar']['hover_effect']) ? $displays['top_bottom_bar']['hover_effect'] : 'effect1';
foreach ($default_effects as $value => $label) {
    ?>
                                            <option <?php selected($top_bottom_hovereffect, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Remove Space From Buttons', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $top_bottom_removespace = isset($displays['top_bottom_bar']['remove_space']) ? $displays['top_bottom_bar']['remove_space'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_top_bottom_remove_space" id="arsocialshare_top_bottom_remove_space" value="<?php echo $top_bottom_removespace; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($top_bottom_removespace === 'yes') ? 'selected' : ''; ?>" data-id="arsocialshare_top_bottom_remove_space">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$display_bar_on = isset($displays['top_bottom_bar']['display_bar_on']) ? $displays['top_bottom_bar']['display_bar_on'] : 'onload';
?>
                                    <select class="arsocialshare_dropdown" name="arsocialshare_top_bottom_bar_display_on" id="arsocialshare_top_bottom_bar_display_on">
                                        <option <?php selected($display_bar_on, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                        <option <?php selected($display_bar_on, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onload') ? 'selected' : ''; ?>" id="arsocialshare_on_load_wrapper">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n seconds', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_top_bottom_bar_onload_time" id="arsocialshare_top_bottom_bar_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['loading_value']) ? $displays['top_bottom_bar']['loading_value'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onscroll') ? 'selected' : ''; ?>" id="arsocialshare_on_scroll_wrapper">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n % of scroll', 'arsocial_lite') ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_top_bottom_bar_onscroll_percentage" id="arsocialshare_top_bottom_bar_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['scroll_value']) ? $displays['top_bottom_bar']['scroll_value'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row" id="arsocialshare_bar_top_y_point">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Start Top bar from Y position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_top_bar_y_point" id="arsocialshare_top_bar_y_point" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['y_point']) ? $displays['top_bottom_bar']['y_point'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px;top:8px;">px</span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $top_bottom_show_counter = isset($displays['top_bottom_bar']['show_counter']) ? $displays['top_bottom_bar']['show_counter'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_top_bottom_show_count" id="arsocialshare_top_bottom_show_count" value="<?php echo $top_bottom_show_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($top_bottom_show_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_top_bottom_show_count">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id='ars_bar_display_number_format' name='ars_bar_display_number_format' class="arsocialshare_dropdown">
<?php
$counter_number_format = $default_no_format;
$ars_top_bottom_bar_no_format = isset($displays['top_bottom_bar']['no_format']) ? $displays['top_bottom_bar']['no_format'] : 'style5';
foreach ($counter_number_format as $key => $value) {
    ?>
                                            <option <?php selected($ars_top_bottom_bar_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Size', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $top_bottom_btn_width = isset($displays['top_bottom_bar']['button_width']) ? $displays['top_bottom_bar']['button_width'] : 'medium'; ?>
                                    <input type="radio" name="ars_top_bottom_btn_width" id="ars_top_bottom_btn_small" <?php checked($top_bottom_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_share_top_bottom_btn_width_input" />
                                    <input type="radio" name="ars_top_bottom_btn_width" id="ars_top_bottom_btn_medium" <?php checked($top_bottom_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_share_top_bottom_btn_width_input"  />
                                    <input type="radio" name="ars_top_bottom_btn_width" id="ars_top_bottom_btn_large" <?php checked($top_bottom_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_share_top_bottom_btn_width_input" />
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width <?php echo ($top_bottom_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_top_bottom_btn_small', 'ars_top_bottom_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width <?php echo ($top_bottom_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_top_bottom_btn_medium', 'ars_top_bottom_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width <?php echo ($top_bottom_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_top_bottom_btn_large', 'ars_top_bottom_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_top_bottom_bar_more_button" id="arsocialshare_top_bottom_bar_more_button" value="<?php echo isset($displays['top_bottom_bar']['more_button']) ? $displays['top_bottom_bar']['more_button'] : '5'; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$morebtnstyle = isset($dipslays['top_bottom_bar']['more_btn_style']) ? $displays['top_bottom_bar']['more_btn_style'] : 'plus_icon';
?>
                                    <select name="arsocialshare_topbottom_more_button_style" id="arsocialshare_topbottom_more_button_style" class="arsocialshare_dropdown">
                                        <option <?php selected($morebtnstyle, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option <?php selected($morebtnstyle, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$morebtnaction = isset($displays['top_bottom_bar']['more_btn_action']) ? $displays['top_bottom_bar']['more_btn_action'] : 'display_popup';
?>
                                    <select name="arsocialshare_topbottom_more_button_action" id="arsocialshare_topbottom_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                        <option <?php selected($morebtnaction, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                        <option <?php selected($morebtnaction, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$topbottom_btn_align = isset($displays['top_bottom_bar']['btn_alignment']) ? $displays['top_bottom_bar']['btn_alignment'] : 'center';
?>
                                    <input type="radio" name="ars_top_bottom_btn_align" id="ars_top_bottom_btn_left" <?php checked($topbottom_btn_align, 'left'); ?> value="left" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                    <input type="radio" name="ars_top_bottom_btn_align" id="ars_top_bottom_btn_center" <?php checked($topbottom_btn_align, 'center'); ?> value="center" class="ars_hide_checkbox ars_top_bottom_btn_align_input"  />
                                    <input type="radio" name="ars_top_bottom_btn_align" id="ars_top_bottom_btn_right" <?php checked($topbottom_btn_align, 'right'); ?> value="right" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'left') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_top_bottom_btn_left', 'ars_top_bottom_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'center') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_center_img" data-value="center" onclick="ars_select_radio_img('ars_top_bottom_btn_center', 'ars_top_bottom_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'right') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_right_img" data-value="right" onclick="ars_select_radio_img('ars_top_bottom_btn_right', 'ars_top_bottom_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

<?php
$bar_show_total_counter = isset($displays['top_bottom_bar']['enable_total_counter']) ? $displays['top_bottom_bar']['enable_total_counter'] : 'no';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Total Share Count', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_bar_show_total_share" id="arsocialshare_bar_show_total_share" value="<?php echo $bar_show_total_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($bar_show_total_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_bar_show_total_share">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
<?php
$bar_show_total_counter_label = isset($displays['top_bottom_bar']['arsocial_total_share_label']) ? $displays['top_bottom_bar']['arsocial_total_share_label'] : 'SHARES';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Label', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" id="arsocialshare_bar_total_share_label" name="arsocialshare_bar_total_share_label" class="arsocialshare_input_box" value="<?php echo $bar_show_total_counter_label; ?>" />
                                </div>
                            </div>
<?php
$bar_show_total_counter_position = isset($displays['top_bottom_bar']['total_counter_position']) ? $displays['top_bottom_bar']['total_counter_position'] : '';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocial_bar_total_counter_position" id="arsocial_bar_total_counter_position" class="arsocialshare_dropdown">
                                        <option value="left" <?php selected($bar_show_total_counter_position, 'left'); ?>><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right" <?php selected($bar_show_total_counter_position, 'right'); ?>><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                            <div class="ars_template_preview_container" id="arsocialshare_top_bottom_theme_preview" style="margin-top:-15px;">
                                <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $top_bottom_skin; ?>_theme arseffect_<?php echo $top_bottom_hovereffect; ?> <?php echo ($top_bottom_removespace == 'yes') ? 'ars_remove_space' : ''; ?>">
                                    <div class='arsocialshare_button facebook ars_<?php echo $top_bottom_button_style; ?> arsocial_lite_facebook_wrapper ars_<?php echo $top_bottom_btn_width; ?>_btn' id='arsocialshare_facebook_btn' data-network="facebook">
                                        <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $top_bottom_skin; ?>_theme_icon socialshare-facebook'></span>
                                        <label class='arsocialshare_network_name'>Facebook</label>
                                        <span class='arsocialshare_counter arsocialshare_facebook_counter arsocialshare_counter_show_<?php echo $top_bottom_show_counter; ?>' id='arsocialshare_facebook_counter'>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_container" style="margin-top:20px;">
                            <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input" style="padding-top:6px;">
                                <input type="text" name="arsocialshare_topbottom_excludes_pages" id="arsocialshare_topbottom_excludes_pages" value="<?php echo isset($displays['top_bottom_bar']['exclude_pages']) ? $displays['top_bottom_bar']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                            </div>
                        </div>

                        <div class="arsocialshare_option_container">
                            <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                        </div>

                        <div class="arsocial_lite_locker_row_seperator"></div>

                    </div>

                    <div class="ars_network_list_container <?php echo ($popup_checked !== '' ) ? "selected" : ""; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_popup">
                        <div class="arsocialshare_option_title">
<?php esc_html_e('Popup Styling Settings', 'arsocial_lite'); ?>
                        </div>
                        <div class="arsocialshare_option_container ars_column">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_popup_settings_skins" id="arsocialshare_popup_settings_skins" class="arsocialshare_dropdown">
<?php
$popup_skin = isset($displays['popup']['skin']) ? $displays['popup']['skin'] : 'lite_default';
foreach ($default_themes as $value => $label) {
    ?>
                                            <option <?php selected($popup_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

<?php
$popup_btn_style = isset($displays['popup']['btn_style']) ? $displays['popup']['btn_style'] : "name_with_icon";
$nwi_pop_button_style_css = '';
if ($popup_skin == 'rounded') {
    $nwi_pop_button_style_css = "display:none;";
    $popup_btn_style = 'icon_without_name';
}
?>
                            <div class="arsocialshare_option_row ars_popup_button_style_opts" style="<?php echo $nwi_pop_button_style_css; ?>">

                                <input type="radio" name="arsocialshare_popup_button_style" value="name_with_icon" <?php checked($popup_btn_style, 'name_with_icon'); ?> class="arsocialshare_popup_button_style ars_hide_checkbox" id="arsocialshare_popup_btn_name_with_icon" />
                                <input type="radio" name="arsocialshare_popup_button_style" value="name_without_icon" <?php checked($popup_btn_style, 'name_without_icon'); ?> class="ars_hide_checkbox arsocialshare_popup_button_style" id="arsocialshare_popup_btn_name_without_icon" />
                                <input type="radio" name="arsocialshare_popup_button_style" value="icon_without_name" <?php checked($popup_btn_style, 'icon_without_name'); ?> class="ars_hide_checkbox arsocialshare_popup_button_style" id="arsocialshare_popup_btn_icon_without_name" />

                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <div class='arsocialshare_inner_option_box arsocialshare_popup_btn_style <?php echo ($popup_btn_style === 'name_with_icon') ? 'selected' : ''; ?>' id="arsocialshare_popup_btn_name_with_icon_img" data-value="name_with_icon" onclick="ars_select_radio_img('arsocialshare_popup_btn_name_with_icon', 'arsocialshare_popup_btn_style');" >
                                        <span class="arsocialshare_inner_option_icon name_with_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_popup_btn_style <?php echo ($popup_btn_style === 'name_without_icon') ? 'selected' : ''; ?>' id="arsocialshare_popup_btn_name_without_icon_img" data-value="name_without_icon" onclick="ars_select_radio_img('arsocialshare_popup_btn_name_without_icon', 'arsocialshare_popup_btn_style');" >
                                        <span class="arsocialshare_inner_option_icon name_without_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_popup_btn_style <?php echo ($popup_btn_style === 'icon_without_name') ? 'selected' : ''; ?>' id="arsocialshare_popup_btn_icon_without_name_img" data-value="icon_without_name"  onclick="ars_select_radio_img('arsocialshare_popup_btn_icon_without_name', 'arsocialshare_popup_btn_style');">
                                        <span class="arsocialshare_inner_option_icon icon_without_name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_popup_hover_effect" id="arsocialshare_popup_hover_effect" class="arsocialshare_dropdown">
<?php
$popup_hover_effect = isset($displays['popup']['hover_effect']) ? $displays['popup']['hover_effect'] : 'effect1';
foreach ($default_effects as $value => $label) {
    ?>
                                            <option <?php selected($popup_hover_effect, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$display_popup = isset($displays['popup']['display_popup_on']) ? $displays['popup']['display_popup_on'] : 'onload';
?>
                                    <select class="arsocialshare_dropdown" name="arsocialshare_popup_display_on" id="arsocialshare_popup_display_on">
                                        <option <?php selected($display_popup, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                        <option <?php selected($display_popup, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row arsocialshare_display_popup_option <?php echo ($display_popup === 'onload' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_load_wrapper">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n seconds', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_popup_onload_time" id="arsocialshare_popup_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['loading_value']) ? $displays['popup']['loading_value'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row arsocialshare_display_popup_option <?php echo ($display_popup === 'onscroll' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_scroll_wrapper">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n % of scroll', 'arsocial_lite') ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_popup_onscroll_percentage" id="arsocialshare_popup_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['scroll_value']) ? $displays['popup']['scroll_value'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                </div>
                            </div>

<?php
$popup_show_total_counter = isset($displays['popup']['enable_total_counter']) ? $displays['popup']['enable_total_counter'] : 'no';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Total Share Count', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_popup_show_total_share" id="arsocialshare_popup_show_total_share" value="<?php echo $popup_show_total_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($popup_show_total_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_popup_show_total_share">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
<?php
$popup_show_total_counter_label = isset($displays['popup']['arsocial_total_share_label']) ? $displays['popup']['arsocial_total_share_label'] : 'SHARES';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Label', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" id="arsocialshare_popup_total_share_label" name="arsocialshare_popup_total_share_label" class="arsocialshare_input_box" value="<?php echo $popup_show_total_counter_label; ?>" />
                                </div>
                            </div>
<?php
$popup_show_total_counter_position = isset($displays['popup']['total_counter_position']) ? $displays['popup']['total_counter_position'] : '';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocial_popup_total_counter_position" id="arsocial_popup_total_counter_position" class="arsocialshare_dropdown">
                                        <option value="left" <?php selected($popup_show_total_counter_position, 'left'); ?>><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right" <?php selected($popup_show_total_counter_position, 'right'); ?>><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $popup_show_counter = (isset($displays['popup']['show_counter'])) ? $displays['popup']['show_counter'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_popup_show_count" id="arsocialshare_popup_show_count" value="<?php echo $popup_show_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($popup_show_counter === 'yes') ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_popup_show_count">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id='ars_popup_display_number_format' name='ars_popup_display_number_format' class="arsocialshare_dropdown">
<?php
$counter_number_format = $default_no_format;
$ars_popop_bar_no_format = isset($displays['popop']['no_format']) ? $displays['popop']['no_format'] : 'style5';
foreach ($counter_number_format as $key => $value) {
    ?>
                                            <option <?php selected($ars_popop_bar_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Size', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$popup_btn_width = isset($displays['popup']['btn_width']) ? $displays['popup']['btn_width'] : 'medium';
?>
                                    <input type="radio" name="ars_popup_btn_width" id="ars_popup_btn_small" value="small" <?php checked($popup_btn_width, 'small'); ?> class="ars_hide_checkbox ars_share_popup_btn_width_input" />
                                    <input type="radio" name="ars_popup_btn_width" id="ars_popup_btn_medium" value="medium" <?php checked($popup_btn_width, 'medium'); ?> class="ars_hide_checkbox ars_share_popup_btn_width_input"  />
                                    <input type="radio" name="ars_popup_btn_width" id="ars_popup_btn_large" value="large" <?php checked($popup_btn_width, 'large'); ?> class="ars_hide_checkbox ars_share_popup_btn_width_input" />
                                    <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ( $popup_btn_width === 'small' ) ? 'selected' : ''; ?>" id="ars_popup_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_popup_btn_small', 'ars_popup_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ( $popup_btn_width === 'medium' ) ? 'selected' : ''; ?>" id="ars_popup_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_popup_btn_medium', 'ars_popup_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ( $popup_btn_width === 'large' ) ? 'selected' : ''; ?>" id="ars_popup_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_popup_btn_large', 'ars_popup_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Close Button', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$is_close_button = isset($displays['popup']['enable_close']) ? $displays['popup']['enable_close'] : 'yes';
?>
                                    <input type="hidden" name="arsocialshare_popup_enable_close" id="arsocialshare_popup_enable_close" value="<?php echo $is_close_button ?>" />

                                    <div class="arsocialshare_switch <?php echo ($is_close_button === 'yes') ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_popup_enable_close">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Width', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="ars_popup_width" id="ars_popup_width" value="<?php echo isset($displays['popup']['width']) ? $displays['popup']['width'] : '' ?>" class="arsocialshare_input_box" />
                                </div>
                                <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto width.', 'arsocial_lite') ?></span>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Height', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="ars_popup_height" id="ars_popup_height" value="<?php echo isset($displays['popup']['height']) ? $displays['popup']['height'] : '' ?>" class="arsocialshare_input_box" />
                                </div>
                                <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto height.', 'arsocial_lite') ?></span>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Remove Space From Buttons', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">                                    <input type="hidden" name="arsocialshare_popup_remove_space" id="arsocialshare_popup_remove_space" value="<?php echo isset($displays['popup']['remove_space']) ? $displays['popup']['remove_space'] : 'no'; ?>" />
<?php $popup_removespace = isset($displays['popup']['remove_space']) ? $displays['popup']['remove_space'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_popup_remove_space" id="arsocialshare_popup_remove_space" value="<?php echo $popup_removespace; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($popup_removespace === 'yes' ) ? 'selected' : ''; ?>" data-id="arsocialshare_popup_remove_space">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_blank_img.png" style="margin-top:-15px;" />-->
                            <div class="ars_template_preview_container" id="arsocialshare_popup_theme_preview" style="margin-top:-15px;">
                                <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $popup_skin; ?>_theme arseffect_<?php echo $popup_hover_effect; ?> <?php echo ($popup_removespace == 'yes') ? 'ars_remove_space' : ''; ?>">
                                    <div class='arsocialshare_button facebook ars_<?php echo $popup_btn_style; ?> arsocial_lite_facebook_wrapper ars_<?php echo $popup_btn_width; ?>_btn' id='arsocialshare_facebook_btn' data-network="facebook">
                                        <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $popup_skin; ?>_theme_icon socialshare-facebook'></span>
                                        <label class='arsocialshare_network_name'>Facebook</label>
                                        <span class='arsocialshare_counter arsocialshare_facebook_counter arsocialshare_counter_show_<?php echo $popup_show_counter; ?>' id='arsocialshare_facebook_counter'>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_container" style="margin-top:20px;">
                            <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input" style="padding-top:6px;">
                                <input type="text" name="arsocialshare_popup_excludes_pages" id="arsocialshare_popup_excludes_pages" value="<?php echo isset($displays['popup']['exclude_pages']) ? $displays['popup']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                            </div>
                        </div>

                        <div class="arsocialshare_option_container">
                            <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                        </div>
                    </div>
                    <div class="ars_network_list_container <?php echo ($media_checked !== '' ) ? "selected" : ""; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_media">
                        <div class="arsocialshare_option_title">
<?php esc_html_e('Media Settings', 'arsocial_lite'); ?>
                        </div>
                        <div class="arsocialshare_option_container ars_column">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id="arsocialshare_media_skins" class="arsocialshare_dropdown" name="arsocialshare_media_skins">
<?php
$media_skin = isset($displays['media']['skin']) ? $displays['media']['skin'] : 'lite_default';
foreach ($default_themes as $value => $label) {
    if ($value === 'bordered')
        continue;
    ?>
                                            <option <?php selected($media_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$media_position = isset($displays['media']['position']) ? $displays['media']['position'] : 'top_left';
?>
                                    <input type="radio" name="arsocial_media_position" id="ars_media_top_left" <?php checked($media_position, 'top_left'); ?> value="top_left" class="ars_hide_checkbox ars_media_position" />
                                    <input type="radio" name="arsocial_media_position" id="ars_media_top_right" <?php checked($media_position, 'top_right'); ?> value="top_right" class="ars_hide_checkbox ars_media_position"  />
                                    <input type="radio" name="arsocial_media_position" id="ars_media_center" <?php checked($media_position, 'center'); ?> value="center" class="ars_hide_checkbox ars_media_position" />
                                    <input type="radio" name="arsocial_media_position" id="ars_media_bottom_left" <?php checked($media_position, 'bottom_left'); ?> value="bottom_left" class="ars_hide_checkbox ars_media_position" />
                                    <input type="radio" name="arsocial_media_position" id="ars_media_bottom_right" <?php checked($media_position, 'bottom_right'); ?> value="bottom_right" class="ars_hide_checkbox ars_media_position" />
                                    <div class="arsocialshare_inner_option_box ars_media_position <?php echo ($media_position === 'top_left') ? 'selected' : ''; ?>" id="ars_media_top_left_img" data-value="left" onclick="ars_select_radio_img('ars_media_top_left', 'ars_media_position');">
                                        <span class="arsocialshare_inner_option_icon media_position_top_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_media_position <?php echo ($media_position === 'top_right') ? 'selected' : ''; ?>" id="ars_media_top_right_img" data-value="top_right" onclick="ars_select_radio_img('ars_media_top_right', 'ars_media_position');">
                                        <span class="arsocialshare_inner_option_icon media_position_top_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top Right', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_media_position <?php echo ($media_position === 'center') ? 'selected' : ''; ?>" id="ars_media_center_img" data-value="center" onclick="ars_select_radio_img('ars_media_center', 'ars_media_position');">
                                        <span class="arsocialshare_inner_option_icon media_position_center"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div style="float: left; width: 100%; clear: both; height: 0px; margin-top: 24px;">&nbsp;</div>
                                    <div class="arsocialshare_inner_option_box ars_media_position <?php echo ($media_position === 'bottom_left') ? 'selected' : ''; ?>" id="ars_media_bottom_left_img" data-value="bottom_left" onclick="ars_select_radio_img('ars_media_bottom_left', 'ars_media_position');">
                                        <span class="arsocialshare_inner_option_icon media_position_bottom_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_media_position <?php echo ($media_position === 'bottom_right') ? 'selected' : ''; ?>" id="ars_media_bottom_right_img" data-value="bottom_right" onclick="ars_select_radio_img('ars_media_bottom_right', 'ars_media_position');">
                                        <span class="arsocialshare_inner_option_icon media_position_bottom_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom Right', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_media_hover_effect" id="arsocialshare_media_hover_effect" class="arsocialshare_dropdown">
<?php
$media_hover_effect = isset($displays['media']['hover_effect']) ? $displays['media']['hover_effect'] : 'effect1';
foreach ($default_effects as $value => $label) {
    ?>
                                            <option <?php selected($media_hover_effect, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Disable Button Under x Height', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_media_disable_height" id="arsocialshare_media_disable_height" value="<?php echo isset($displays['media']['disable_height']) ? $displays['media']['disable_height'] : '150'; ?>" />
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Disable Button Under x Width', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_media_disable_width" id="arsocialshare_media_disable_width" value="<?php echo isset($displays['media']['disable_width']) ? $displays['media']['disable_width'] : '150'; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_media_more_button" id="arsocialshare_media_more_button" value="<?php echo isset($displays['media']['more_btn']) ? $displays['media']['more_btn'] : '5'; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$media_more_btn_style = isset($displays['media']['more_btn_style']) ? $displays['media']['more_btn_style'] : 'plus_icon';
?>
                                    <select name="arsocialshare_media_more_button_style" id="arsocialshare_media_more_button_style" class="arsocialshare_dropdown">
                                        <option <?php selected($media_more_btn_style, 'plus_icon') ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option <?php selected($media_more_btn_style, 'dot_icon') ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$media_more_btn_act = isset($displays['media']['more_btn_act']) ? $displays['media']['more_btn_act'] : 'display_popup';
?>
                                    <select name="arsocialshare_media_more_button_action" id="arsocialshare_media_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                        <option <?php selected($media_more_btn_act, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                        <option <?php selected($media_more_btn_act, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
<?php
$media_show_background = isset($displays['media']['background_color_enable']) ? $displays['media']['background_color_enable'] : 'no';
?>
                                <div class="arsocialshare_option_label"><?php esc_html_e('Enable Background Color', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocial_lite_media_background_color_enable" id="arsocial_lite_media_background_color_enable" value="<?php echo $media_show_background; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($media_show_background === 'yes' ) ? 'selected' : ''; ?>" id="ars_media_background_color" data-id="arsocial_lite_media_background_color_enable">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Background Color', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocial_lite_media_background_color" id="arsocial_lite_media_background_color" value="<?php echo isset($displays['media']['background_color']) ? $displays['media']['background_color'] : '#ededed'; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Opacity', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$media_background_opacity = isset($displays['media']['background_opacity']) ? $displays['media']['background_opacity'] : '0.50';
?>
                                    <select name="arsocialshare_media_background_opacity" id="arsocialshare_media_background_opacity" class="arsocialshare_dropdown" style="width:245px;">
                                    <?php
                                    $column_opacity = array(1, 0.90, 0.80, 0.70, 0.60, 0.50, 0.40, 0.30, 0.20, 0.10);

                                    foreach ($column_opacity as $value) {
                                        ?>
                                            <option <?php selected($media_background_opacity, $value); ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <div class="ars_template_preview_container" id="ars_media_preview_container" style="margin-top:-15px;">
                                <div class="arsocialshare_media_wrapper" style="width:200px;height:140px;float:none;margin:-40px auto 0;">
                                    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/media_placeholder.png'; ?>" width="200" height="140" />
                                    <div class="arsocialshare_media_share_wrapper <?php echo $media_position; ?>">
                                        <div class="arsocialshare_media_share_inner_wrapper <?php echo $media_position; ?>">
                                            <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $media_skin; ?>_theme arseffect_<?php echo $media_hover_effect; ?>">
                                                <div id="arsocialshare_facebook_btn" class="arsocialshare_button facebook  arsocial_lite_facebook_wrapper ars_icon_without_name ars_small_btn"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-facebook"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="arsocialshare_title_belt">
                <div class="arsocialshare_title_belt_number">3</div>
                <div class="arsocialshare_belt_title"><?php esc_html_e('Sectionwise Button Setup', 'arsocial_lite'); ?></div>
            </div>
            <!-- Lists of Settings of Pages Types -->
            <span class="ars_error_message" id="arsocialshare_network_position_error"><?php esc_html_e('Please select atleast one position.', 'arsocial_lite'); ?></span>

            <div class="arsocialshare_inner_container">

                <div class="arsocialshare_inner_content_wrapper">
<?php
$pages_selected = "";
$posts_selected = "";
if (is_array($displays) && array_key_exists('page', $displays)) {
    $pages_selected = "checked='checked'";
}
if (is_array($displays) && array_key_exists('post', $displays)) {
    $posts_selected = "checked='checked'";
}
?>
                    <input type="checkbox" name="arsocialshare_enable_pages" value="page" id="arsocialshare_enable_pages" <?php echo $pages_selected; ?> class="ars_display_option_input ars_hide_checkbox" />
                    <input type="checkbox" name="arsocialshare_enable_posts" value="post" id="arsocialshare_enable_posts" <?php echo $posts_selected; ?> class="ars_display_option_input ars_hide_checkbox" />
                    <div class="arsocialshare_inner_container_main">
                        <div class="arsocialshare_option_box page_icon <?php echo ($pages_selected !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_pages" data-opt-id="arsocialshare_pages" data-mob-page-id="share">
                            <div class="arsocialshare_option_checkbox"><span></span></div>
                        </div>
                        <div class="arsocialshare_option_box post_icon <?php echo ($posts_selected !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_posts" data-opt-id="arsocialshare_posts" data-mob-page-id="share">
                            <div class="arsocialshare_option_checkbox"><span></span></div>
                        </div>
                    </div>

                    <div class="ars_network_list_container <?php echo ($pages_selected !== '' ) ? 'selected' : ''; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_pages">
                    <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/page_setting.png" /></div>
                            <div class="arsfontsize25"><?php esc_html_e('Page Settings', 'arsocial_lite'); ?></div>
                        </div>
                        <div class="arsocialshare_option_container ars_column arsmarginleft10">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_page_settings_skins" id="arsocialshare_page_settings_skins" class="arsocialshare_dropdown ars_lite_pro_options">
<?php
$page_skin = isset($displays['page']['skin']) ? $displays['page']['skin'] : 'lite_default';
foreach ($default_themes as $value => $label) {
    ?>
                                            <option <?php selected($page_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$page_top_position_checked = "";
$page_bottom_position_checked = "";
if (isset($displays['page']['top']) && $displays['page']['top'] == true) {
    $page_top_position_checked = "checked='checked'";
}
if (isset($displays['page']['bottom']) && $displays['page']['bottom'] == true) {
    $page_bottom_position_checked = "checked='checked'";
}

if ($page_top_position_checked == '' && $page_bottom_position_checked == '') {
    $page_top_position_checked = "checked='checked'";
}
?>

                                    <input type="radio" name="arsocialshare_pages_top_position" value="top" data-on="top_bar" <?php echo $page_top_position_checked; ?> class="arsocialshare_display_networks_pages_on ars_hide_checkbox ars_share_posts_top" id="arsocialshare_pages_buttons_on_top" />
                                    <input type="radio" name="arsocialshare_pages_bottom_position" value="bottom" <?php echo $page_bottom_position_checked; ?> data-on="bottom" class="arsocialshare_display_networks_pages_on ars_hide_checkbox ars_share_posts_bottom" id="arsocialshare_pages_buttons_on_bottom" />

                                    <div class="arsocialshare_inner_option_box arsocialshare_pages_position <?php echo ($page_top_position_checked != '') ? 'selected' : ''; ?>" id="arsocialshare_pages_buttons_on_top_img" data-value="ars_top" onclick="ars_select_checkbox_img('arsocialshare_pages_buttons_on_top', 'arsocialshare_enable_pages', 'share');">

                                        <span class="arsocialshare_inner_option_icon pages_top"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box arsocialshare_pages_position <?php echo ($page_bottom_position_checked != '') ? 'selected' : ''; ?>" id="arsocialshare_pages_buttons_on_bottom_img" data-value="ars_bottom" onclick="ars_select_checkbox_img('arsocialshare_pages_buttons_on_bottom', 'arsocialshare_enable_pages', 'share');">
                                        <span class="arsocialshare_inner_option_icon pages_bottom"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

<?php
$pages_btn_style = isset($displays['page']['btn_style']) ? $displays['page']['btn_style'] : 'name_with_icon';
$nwi_pages_button_style_css = '';
if ($page_skin == 'rounded') {
    $nwi_pages_button_style_css = "display:none;";
    $pages_btn_style = 'icon_without_name';
}
?>

                            <div class="arsocialshare_option_row ars_pages_button_style_opts" style="<?php echo $nwi_pages_button_style_css; ?>">

                                <input type="radio" name="arsocialshare_pages_button_style" value="name_with_icon" <?php checked($pages_btn_style, 'name_with_icon'); ?> class="arsocialshare_pages_button_style ars_hide_checkbox" id="arsocialshare_pages_btn_name_with_icon" />
                                <input type="radio" name="arsocialshare_pages_button_style" value="name_without_icon" <?php checked($pages_btn_style, 'name_without_icon'); ?> class="ars_hide_checkbox arsocialshare_pages_button_style" id="arsocialshare_pages_btn_name_without_icon" />
                                <input type="radio" name="arsocialshare_pages_button_style" value="icon_without_name" <?php checked($pages_btn_style, 'icon_without_name'); ?> class="ars_hide_checkbox arsocialshare_pages_button_style" id="arsocialshare_pages_btn_icon_without_name" />

                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <div class='arsocialshare_inner_option_box arsocialshare_pages_btn_style <?php echo ($pages_btn_style === 'name_with_icon') ? 'selected' : ''; ?>' id="arsocialshare_pages_btn_name_with_icon_img" data-value="name_with_icon" onclick="ars_select_radio_img('arsocialshare_pages_btn_name_with_icon', 'arsocialshare_pages_btn_style');">
                                        <span class="arsocialshare_inner_option_icon name_with_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_pages_btn_style <?php echo ($pages_btn_style === 'name_without_icon') ? 'selected' : ''; ?>' id="arsocialshare_pages_btn_name_without_icon_img" data-value="name_without_icon" onclick="ars_select_radio_img('arsocialshare_pages_btn_name_without_icon', 'arsocialshare_pages_btn_style');" >
                                        <span class="arsocialshare_inner_option_icon name_without_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_pages_btn_style <?php echo ($pages_btn_style === 'icon_without_name') ? "selected" : ""; ?>' id="arsocialshare_pages_btn_icon_without_name_img" data-value="icon_without_name" onclick="ars_select_radio_img('arsocialshare_pages_btn_icon_without_name', 'arsocialshare_pages_btn_style');">
                                        <span class="arsocialshare_inner_option_icon icon_without_name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_pages_hover_effect" id="arsocialshare_pages_hover_effect" class="arsocialshare_dropdown">
<?php
$page_hover_effect = isset($displays['page']['hover_effect']) ? $displays['page']['hover_effect'] : 'effect1';
foreach ($default_effects as $value => $label) {
    ?>
                                            <option <?php selected($page_hover_effect, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Remove Space From Buttons', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $page_removespace = isset($displays['page']['remove_space']) ? $displays['page']['remove_space'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_pages_remove_space" id="arsocialshare_pages_remove_space" value="<?php echo $page_removespace; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($page_removespace === 'yes') ? 'selected' : ''; ?>" data-id="arsocialshare_pages_remove_space">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

<?php
$page_show_total_counter = isset($displays['page']['enable_total_counter']) ? $displays['page']['enable_total_counter'] : 'no';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Total Share Count', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_pages_show_total_share" id="arsocialshare_pages_show_total_share" value="<?php echo $page_show_total_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($page_show_total_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_pages_show_total_share">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
<?php
$page_show_total_counter_label = isset($displays['page']['arsocial_total_share_label']) ? $displays['page']['arsocial_total_share_label'] : 'SHARES';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Label', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" id="arsocialshare_pages_total_share_label" name="arsocialshare_pages_total_share_label" class="arsocialshare_input_box" value="<?php echo $page_show_total_counter_label; ?>" />
                                </div>
                            </div>
<?php
$page_show_total_counter_position = isset($displays['page']['total_counter_position']) ? $displays['page']['total_counter_position'] : '';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocial_page_total_counter_position" id="arsocial_page_total_counter_position" class="arsocialshare_dropdown">
                                        <option value="left" <?php selected($page_show_total_counter_position, 'left'); ?>><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right" <?php selected($page_show_total_counter_position, 'right'); ?>><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                            <div class="arsocialshare_option_row">
<?php
$page_show_counter = isset($displays['page']['show_counter']) ? $displays['page']['show_counter'] : 'no';
?>
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_pages_show_count" id="arsocialshare_pages_show_count" value="<?php echo $page_show_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($page_show_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_pages_show_count">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id='arsfan_page_display_number_format' name='arsfan_page_display_number_format' class="arsocialshare_dropdown">
<?php
$counter_number_format = $default_no_format;
$ars_page_no_format = isset($displays['page']['no_format']) ? $displays['page']['no_format'] : 'style1';
foreach ($counter_number_format as $key => $value) {
    ?>
                                            <option <?php selected($ars_page_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$pages_btn_align = isset($displays['page']['btn_align']) ? $displays['page']['btn_align'] : 'center';
?>
                                    <input type="radio" name="ars_pages_btn_align" id="ars_pages_btn_left" <?php checked($pages_btn_align, 'left'); ?> value="left" class="ars_hide_checkbox ars_pages_btn_align_input" />
                                    <input type="radio" name="ars_pages_btn_align" id="ars_pages_btn_center" <?php checked($pages_btn_align, 'center'); ?> value="center" class="ars_hide_checkbox ars_pages_btn_align_input"  />
                                    <input type="radio" name="ars_pages_btn_align" id="ars_pages_btn_right" <?php checked($pages_btn_align, 'right'); ?> value="right" class="ars_hide_checkbox ars_pages_btn_align_input" />
                                    <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($pages_btn_align === 'left') ? 'selected' : ''; ?>" id="ars_pages_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_pages_btn_left', 'ars_pages_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($pages_btn_align === 'center') ? 'selected' : ''; ?>" id="ars_pages_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_pages_btn_center', 'ars_pages_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($pages_btn_align === 'right') ? 'selected' : ''; ?>" id="ars_pages_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_pages_btn_right', 'ars_pages_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Size', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$pages_btn_width = isset($displays['page']['btn_width']) ? $displays['page']['btn_width'] : 'medium';
?>
                                    <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_small" <?php checked($pages_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_share_pages_btn_width_input" />
                                    <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_medium" <?php checked($pages_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_share_pages_btn_width_input"  />
                                    <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_large" <?php checked($pages_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_share_pages_btn_width_input" />
                                    <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $pages_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_pages_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_pages_btn_small', 'ars_pages_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $pages_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_pages_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_pages_btn_medium', 'ars_pages_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $pages_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_pages_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_pages_btn_large', 'ars_pages_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_pages_more_button" id="arsocialshare_pages_more_button" value="<?php echo isset($displays['page']['more_btn']) ? $displays['page']['more_btn'] : '5'; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$page_more_btn_style = isset($displays['page']['more_btn_style']) ? $displays['page']['more_btn_style'] : 'plus_icon';
?>
                                    <select name="arsocialshare_pages_more_button_style" id="arsocialshare_pages_more_button_style" class="arsocialshare_dropdown">
                                        <option <?php selected($page_more_btn_style, 'plus_icon') ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option <?php selected($page_more_btn_style, 'dot_icon') ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$page_more_btn_act = isset($displays['page']['more_btn_act']) ? $displays['page']['more_btn_act'] : 'display_popup';
?>
                                    <select name="arsocialshare_pages_more_button_action" id="arsocialshare_pages_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                        <option <?php selected($page_more_btn_act, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                        <option <?php selected($page_more_btn_act, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                            <div class="ars_template_preview_container" id="arsocialshare_pages_theme_preview" style="margin-top:-15px;">
                                <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $page_skin; ?>_theme arseffect_<?php echo $page_hover_effect; ?> <?php echo ($page_removespace == 'yes') ? 'ars_remove_space' : ''; ?>">
                                    <div class='arsocialshare_button facebook ars_<?php echo $pages_btn_style; ?> arsocial_lite_facebook_wrapper ars_<?php echo $pages_btn_width; ?>_btn' id='arsocialshare_facebook_btn' data-network="facebook">
                                        <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $page_skin; ?>_theme_icon socialshare-facebook'></span>
                                        <label class='arsocialshare_network_name'>Facebook</label>
                                        <span class='arsocialshare_counter arsocialshare_facebook_counter arsocialshare_counter_show_<?php echo $page_show_counter; ?>' id='arsocialshare_facebook_counter'>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_container" style="margin-top:20px;">
                            <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input" style="padding-top:6px;">
                                <input type="text" name="arsocialshare_page_excludes" id="arsocialshare_page_excludes" value="<?php echo isset($displays['page']['exclude_pages']) ? $displays['page']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                            </div>
                        </div>


                        <div class="arsocialshare_option_container">
                            <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                        </div>

                        <div class="arsocialshare_clear">&nbsp;</div>
                        <div class="arsocial_lite_locker_row_seperator"></div>
                        <div class="arsocialshare_clear">&nbsp;</div>
                    </div>

                    <div class="ars_network_list_container <?php echo ( $posts_selected !== '' ) ? 'selected' : ''; ?>" style="padding-top:0px !important;padding-bottom:0 !important;" id="arsocialshare_posts">
                    <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/post_setting.png" /></div>
                            <div class="arsfontsize25"><?php esc_html_e('Post Settings', 'arsocial_lite'); ?></div>
                        </div>

                        <div class="arsocialshare_option_container ars_column arsmarginleft10">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_post_settings_skins" id="arsocialshare_post_settings_skins" class="arsocialshare_dropdown ars_lite_pro_options">
<?php
$post_skin = isset($displays['post']['skin']) ? $displays['post']['skin'] : 'lite_default';
foreach ($default_themes as $value => $label) {
    ?>
                                            <option <?php selected($post_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$post_top_position_checked = "";
$post_bottom_position_checked = "";
if (isset($displays['post']['top']) && $displays['post']['top'] == true) {
    $post_top_position_checked = "checked='checked'";
}
if (isset($displays['post']['bottom']) && $displays['post']['bottom'] == true) {
    $post_bottom_position_checked = "checked='checked'";
}

if ($post_top_position_checked == "" && $post_bottom_position_checked == "") {
    $post_top_position_checked = "checked='checked'";
}
?>

                                    <input type="radio" name="arsocialshare_posts_top_position" value="top" data-on="top_bar" <?php echo $post_top_position_checked; ?> class="arsocialshare_display_networks_posts_on ars_hide_checkbox ars_share_posts_top" id="arsocialshare_posts_buttons_on_top" />
                                    <input type="radio" name="arsocialshare_posts_bottom_position" value="bottom" <?php echo $post_bottom_position_checked; ?> data-on="bottom" class="arsocialshare_display_networks_posts_on ars_hide_checkbox ars_share_posts_bottom" id="arsocialshare_posts_buttons_on_bottom" />

                                    <div class="arsocialshare_inner_option_box arsocialshare_posts_position <?php echo ($post_top_position_checked != '') ? 'selected' : ''; ?>" id="arsocialshare_posts_buttons_on_top_img" data-value="ars_top" onclick="ars_select_checkbox_img('arsocialshare_posts_buttons_on_top', 'arsocialshare_enable_posts', 'share');">
                                        <span class="arsocialshare_inner_option_icon posts_top"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box arsocialshare_posts_position <?php echo ($post_bottom_position_checked != '') ? 'selected' : ''; ?>" id="arsocialshare_posts_buttons_on_bottom_img" data-value="ars_bottom" onclick="ars_select_checkbox_img('arsocialshare_posts_buttons_on_bottom', 'arsocialshare_enable_posts', 'share');">
                                        <span class="arsocialshare_inner_option_icon posts_bottom"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>
<?php
$posts_btn_style = isset($displays['post']['btn_style']) ? $displays['post']['btn_style'] : 'name_with_icon';
$nwi_posts_button_style_css = '';
if ($post_skin == 'rounded') {
    $nwi_posts_button_style_css = "display:none;";
    $posts_btn_style = 'icon_without_name';
}
?>
                            <div class="arsocialshare_option_row ars_posts_button_style_opts" style="<?php echo $nwi_posts_button_style_css; ?>">

                                <input type="radio" name="arsocialshare_posts_button_style" value="name_with_icon" <?php checked($posts_btn_style, 'name_with_icon'); ?> class="arsocialshare_posts_button_style ars_hide_checkbox" id="arsocialshare_posts_btn_name_with_icon" />
                                <input type="radio" name="arsocialshare_posts_button_style" value="name_without_icon" <?php checked($posts_btn_style, 'name_without_icon'); ?> class="ars_hide_checkbox arsocialshare_posts_button_style" id="arsocialshare_posts_btn_name_without_icon" />
                                <input type="radio" name="arsocialshare_posts_button_style" value="icon_without_name" <?php checked($posts_btn_style, 'icon_without_name'); ?> class="ars_hide_checkbox arsocialshare_posts_button_style" id="arsocialshare_posts_btn_icon_without_name" />

                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <div class='arsocialshare_inner_option_box arsocialshare_posts_btn_style <?php echo ($posts_btn_style === 'name_with_icon') ? 'selected' : ''; ?>' id="arsocialshare_posts_btn_name_with_icon_img" data-value="name_with_icon" onclick="ars_select_radio_img('arsocialshare_posts_btn_name_with_icon', 'arsocialshare_posts_btn_style');">
                                        <span class="arsocialshare_inner_option_icon name_with_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_posts_btn_style <?php echo ($posts_btn_style === 'name_without_icon') ? 'selected' : ''; ?>' id="arsocialshare_posts_btn_name_without_icon_img" data-value="name_without_icon" onclick="ars_select_radio_img('arsocialshare_posts_btn_name_without_icon', 'arsocialshare_posts_btn_style');" >
                                        <span class="arsocialshare_inner_option_icon name_without_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_posts_btn_style <?php echo ($posts_btn_style === 'icon_without_name') ? "selected" : ""; ?>' id="arsocialshare_posts_btn_icon_without_name_img" data-value="icon_without_name" onclick="ars_select_radio_img('arsocialshare_posts_btn_icon_without_name', 'arsocialshare_posts_btn_style');">
                                        <span class="arsocialshare_inner_option_icon icon_without_name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_posts_hover_effect" id="arsocialshare_posts_hover_effect" class="arsocialshare_dropdown">
<?php
$post_hover_effect = isset($displays['post']['hover_effect']) ? $displays['post']['hover_effect'] : 'effect1';
foreach ($default_effects as $value => $label) {
    ?>
                                            <option <?php selected($post_hover_effect, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Remove Space From Buttons', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php $post_removespace = isset($displays['post']['remove_space']) ? $displays['post']['remove_space'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_posts_remove_space" id="arsocialshare_posts_remove_space" value="<?php echo $post_removespace; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($post_removespace === 'yes') ? 'selected' : ''; ?>" data-id="arsocialshare_posts_remove_space">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

<?php
$post_show_total_counter = isset($displays['post']['enable_total_counter']) ? $displays['post']['enable_total_counter'] : 'no';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Total Share Count', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_posts_show_total_share" id="arsocialshare_posts_show_total_share" value="<?php echo $post_show_total_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($post_show_total_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_posts_show_total_share">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
<?php
$post_show_total_counter_label = isset($displays['post']['arsocial_total_share_label']) ? $displays['post']['arsocial_total_share_label'] : 'SHARES';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Label', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" id="arsocialshare_posts_total_share_label" name="arsocialshare_posts_total_share_label" class="arsocialshare_input_box" value="<?php echo $post_show_total_counter_label; ?>" />
                                </div>
                            </div>
<?php
$post_show_total_counter_position = isset($displays['post']['total_counter_position']) ? $displays['post']['total_counter_position'] : '';
?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocial_post_total_counter_position" id="arsocial_post_total_counter_position" class="arsocialshare_dropdown">
                                        <option value="left" <?php selected($post_show_total_counter_position, 'left'); ?>><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right" <?php selected($page_show_total_counter_position, 'right'); ?>><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                            <div class="arsocialshare_option_row">
<?php
$post_show_counter = isset($displays['post']['show_counter']) ? $displays['post']['show_counter'] : 'no';
?>
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_posts_show_count" id="arsocialshare_posts_show_count" value="<?php echo $post_show_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($post_show_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_posts_show_count">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id='arsfan_post_display_number_format' name='arsfan_post_display_number_format' class="arsocialshare_dropdown">
<?php
$counter_number_format = $default_no_format;
$ars_post_no_format = isset($displays['post']['no_format']) ? $displays['post']['no_format'] : 'style5';
foreach ($counter_number_format as $key => $value) {
    ?>
                                            <option <?php selected($ars_post_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$posts_btn_align = isset($displays['post']['btn_align']) ? $displays['post']['btn_align'] : 'ars_align_center';
?>
                                    <input type="radio" name="ars_posts_btn_align" id="ars_posts_btn_left" <?php checked($posts_btn_align, 'ars_align_left'); ?> value="ars_align_left" class="ars_hide_checkbox ars_posts_btn_align_input" />
                                    <input type="radio" name="ars_posts_btn_align" id="ars_posts_btn_center" <?php checked($posts_btn_align, 'ars_align_center'); ?> value="ars_align_center" class="ars_hide_checkbox ars_posts_btn_align_input"  />
                                    <input type="radio" name="ars_posts_btn_align" id="ars_posts_btn_right" <?php checked($posts_btn_align, 'ars_align_right'); ?> value="ars_align_right" class="ars_hide_checkbox ars_posts_btn_align_input" />
                                    <div class="arsocialshare_inner_option_box ars_posts_btn_align <?php echo ($posts_btn_align === 'ars_align_left') ? 'selected' : ''; ?>" id="ars_posts_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_posts_btn_left', 'ars_posts_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_posts_btn_align <?php echo ($posts_btn_align === 'ars_align_center') ? 'selected' : ''; ?>" id="ars_posts_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_posts_btn_center', 'ars_posts_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_posts_btn_align <?php echo ($posts_btn_align === 'ars_align_right') ? 'selected' : ''; ?>" id="ars_posts_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_posts_btn_right', 'ars_posts_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Size', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$posts_btn_width = isset($displays['post']['btn_width']) ? $displays['post']['btn_width'] : 'medium';
?>
                                    <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_small" <?php checked($posts_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_share_posts_btn_width_input" />
                                    <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_medium" <?php checked($posts_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_share_posts_btn_width_input"  />
                                    <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_large" <?php checked($posts_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_share_posts_btn_width_input" />
                                    <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ( $posts_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_posts_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_posts_btn_small', 'ars_posts_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ( $posts_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_posts_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_posts_btn_medium', 'ars_posts_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ( $posts_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_posts_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_posts_btn_large', 'ars_posts_btn_width');">
                                        <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_posts_more_button" id="arsocialshare_posts_more_button" value="<?php echo isset($displays['post']['more_btn']) ? $displays['post']['more_btn'] : '5'; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$post_more_btn_style = isset($displays['post']['more_btn_style']) ? $displays['post']['more_btn_style'] : 'plus_icon';
?>
                                    <select name="arsocialshare_posts_more_button_style" id="arsocialshare_posts_more_button_style" class="arsocialshare_dropdown">
                                        <option <?php selected($post_more_btn_style, 'plus_icon') ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option <?php selected($post_more_btn_style, 'dot_icon') ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$post_more_btn_act = isset($displays['post']['more_btn_act']) ? $displays['post']['more_btn_act'] : 'display_popup';
?>
                                    <select name="arsocialshare_posts_more_button_action" id="arsocialshare_posts_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                        <option <?php selected($post_more_btn_act, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                        <option <?php selected($post_more_btn_act, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Enable Social Icons on Post Excerpt', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
<?php
$enable_post_excerpt = isset($displays['post']['excerpt']) ? $displays['post']['excerpt'] : 'no';
?>
                                    <input type="hidden" name="arsocialshare_enable_post_excerpt" id="arsocialshare_enable_post_excerpt" value="<?php echo $enable_post_excerpt; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($enable_post_excerpt === 'yes' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_post_excerpt">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                            <div class="ars_template_preview_container" id="arsocialshare_posts_theme_preview" style="margin-top:-15px;">
                                <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $post_skin; ?>_theme arseffect_<?php echo $post_hover_effect; ?> <?php echo ($post_removespace == 'yes') ? 'ars_remove_space' : ''; ?>">
                                    <div class='arsocialshare_button facebook ars_<?php echo $posts_btn_style; ?> arsocial_lite_facebook_wrapper ars_<?php echo $posts_btn_width; ?>_btn' id='arsocialshare_facebook_btn' data-network="facebook">
                                        <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $post_skin; ?>_theme_icon socialshare-facebook'></span>
                                        <label class='arsocialshare_network_name'>Facebook</label>
                                        <span class='arsocialshare_counter arsocialshare_facebook_counter arsocialshare_counter_show_<?php echo $page_show_counter; ?>' id='arsocialshare_facebook_counter'>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_container" style="margin-top:20px;">
                            <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input" style="padding-top:6px;">
                                <input type="text" name="arsocialshare_excludes_posts" id="arsocialshare_excludes_posts" value="<?php echo isset($displays['post']['exclude_pages']) ? $displays['post']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                            </div>
                        </div>

                        <div class="arsocialshare_option_container">
                            <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated post id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                        </div>

                        <div class="arsocialshare_clear">&nbsp;</div>
                        <div class="arsocial_lite_locker_row_seperator"></div>
                        <div class="arsocialshare_clear">&nbsp;</div>
                    </div>

                </div>
            </div>

<?php
$no = 4;
if (is_plugin_active('woocommerce/woocommerce.php')) {
    ?>
                <input type="checkbox" name="arsocialshare_woocommerce" checked="checked" class="ars_display_option_input ars_hide_checkbox" value="woocommerce" />
                <input type="hidden" value="1" id="arsocialshare_is_woocommerce" />
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number"><?php echo $no; ?></div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Woocommerce Settings', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                </div>
                <div class="ars_network_list_container selected arsocial_lite_global_section_restricted" id="arsocialshare_woocommerce">
                <div class="disable_all_click_event">

                    <div id="ars_share_woocommerce" class="selected">

                        <div class="arsocialshare_option_container ars_column">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_woocommerce_skins" id="arsocialshare_woocommerce_skins" class="arsocialshare_dropdown ars_lite_pro_options">
    <?php
    $woocommerce_skin = isset($displays['woocommerce']['skin']) ? $displays['woocommerce']['skin'] : 'lite_default';
    foreach ($default_themes as $value => $label) {
        ?>
                                            <option <?php selected($woocommerce_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
    <?php
    $woocommerce_after_price_position_checked = "";
    $woocommerce_before_product_position_checked = "";
    $woocommerce_after_product_position_checked = "";

    if (isset($displays['woocommerce']['after_price']) && $displays['woocommerce']['after_price'] == true) {
        $woocommerce_after_price_position_checked = "checked='checked'";
    }
    if (isset($displays['woocommerce']['before_product']) && $displays['woocommerce']['before_product'] == true) {
        $woocommerce_before_product_position_checked = "checked='checked'";
    }
    if (isset($displays['woocommerce']['after_product']) && $displays['woocommerce']['after_product'] == true) {
        $woocommerce_after_product_position_checked = "checked='checked'";
    }
    if ($woocommerce_after_price_position_checked == '' && $woocommerce_before_product_position_checked == '' && $woocommerce_after_product_position_checked == '') {
        $woocommerce_after_product_position_checked = "checked='checked'";
    }
    ?>
                                    <input type="radio" name="arsocialshare_woocommerce_buttons_after_price" value="after_price" data-on="after_price" <?php echo $woocommerce_after_price_position_checked; ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_woocommerce_buttons_after_price" />
                                    <input type="radio" name="arsocialshare_woocommerce_buttons_before_product" value="before_product" <?php echo $woocommerce_before_product_position_checked; ?> data-on="before_product" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_woocommerce_buttons_before_product" />
                                    <input type="radio" name="arsocialshare_woocommerce_buttons_after_product" value="after_product" <?php echo $woocommerce_after_product_position_checked; ?> data-on="after_product" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_woocommerce_buttons_after_product" />


                                    <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($woocommerce_after_price_position_checked != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_after_price_img" data-value="left" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_after_price', '', '');">
                                        <span class="arsocialshare_inner_option_icon woocommerce_after_price"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('After Price', 'arsocial_lite'); ?></label>
                                    </div>

                                    <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($woocommerce_after_product_position_checked != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_after_product_img" data-value="right" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_after_product', '', '');" >
                                        <span class="arsocialshare_inner_option_icon woocommerce_after_product"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('After Product', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($woocommerce_before_product_position_checked != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_before_product_img" data-value="right" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_before_product', '', '');" >
                                        <span class="arsocialshare_inner_option_icon woocommerce_before_product"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('Before Product', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

    <?php
    $woocommerce_button_style = isset($displays['woocommerce']['btn_style']) ? $displays['woocommerce']['btn_style'] : 'name_with_icon';
    $nwi_wooc_button_style_css = '';
    if ($woocommerce_skin == 'rounded') {
        $nwi_wooc_button_style_css = "display:none;";
        $woocommerce_button_style = 'icon_without_name';
    }
    ?>
                            <div class="arsocialshare_option_row ars_woocom_button_style_opts" style="<?php echo $nwi_wooc_button_style_css; ?>">

                                <input type="radio" name="arsocialshare_woocommerce_button_style" value="name_with_icon" <?php checked($woocommerce_button_style, 'name_with_icon'); ?> class="arsocialshare_woocommerce_button_style ars_hide_checkbox" id="arsocialshare_woocommerce_btn_name_with_icon" />
                                <input type="radio" name="arsocialshare_woocommerce_button_style" value="name_without_icon" <?php checked($woocommerce_button_style, 'name_without_icon'); ?> class="ars_hide_checkbox arsocialshare_woocommerce_button_style" id="arsocialshare_woocommerce_btn_name_without_icon" />
                                <input type="radio" name="arsocialshare_woocommerce_button_style" value="icon_without_name" <?php checked($woocommerce_button_style, 'icon_without_name'); ?> class="ars_hide_checkbox arsocialshare_woocommerce_button_style" id="arsocialshare_woocommerce_btn_icon_without_name" />

                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <div class='arsocialshare_inner_option_box arsocialshare_woocommerce_btn_style <?php echo ($woocommerce_button_style === 'name_with_icon') ? "selected" : ""; ?>' id="arsocialshare_woocommerce_btn_name_with_icon_img" onclick="ars_select_radio_img('arsocialshare_woocommerce_btn_name_with_icon', 'arsocialshare_woocommerce_btn_style');" data-value="name_with_icon">
                                        <span class="arsocialshare_inner_option_icon name_with_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_woocommerce_btn_style <?php echo ($woocommerce_button_style === 'name_without_icon') ? "selected" : ""; ?>' id="arsocialshare_woocommerce_btn_name_without_icon_img" data-value="name_without_icon" onclick="ars_select_radio_img('arsocialshare_woocommerce_btn_name_without_icon', 'arsocialshare_woocommerce_btn_style');" >
                                        <span class="arsocialshare_inner_option_icon name_without_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_woocommerce_btn_style <?php echo ($woocommerce_button_style === 'icon_without_name') ? "selected" : ""; ?>' id="arsocialshare_woocommerce_btn_icon_without_name_img" onclick="ars_select_radio_img('arsocialshare_woocommerce_btn_icon_without_name', 'arsocialshare_woocommerce_btn_style');" data-value="icon_without_name">
                                        <span class="arsocialshare_inner_option_icon icon_without_name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
    <?php $woocommerce_hover_effect = isset($displays['woocommerce']['hover_effect']) ? $displays['woocommerce']['hover_effect'] : ''; ?>
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_woocommerce_hover_effect" id="arsocialshare_woocommerce_hover_effect" class="arsocialshare_dropdown">
    <?php
    foreach ($default_effects as $value => $label) {
        ?>
                                            <option <?php selected($woocommerce_hover_effect, $value); ?> value="<?php echo $value; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Remove Space From Buttons', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
    <?php $woocommerce_remove_space = isset($displays['woocommerce']['remove_space']) ? $displays['woocommerce']['remove_space'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_woocommerce_remove_space" id="arsocialshare_woocommerce_remove_space" value="<?php echo $woocommerce_remove_space; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($woocommerce_remove_space === 'yes') ? 'selected' : ''; ?>" data-id="arsocialshare_woocommerce_remove_space">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
    <?php
    $woocommerce_btn_align = isset($displays['woocommerce']['btn_align']) ? $displays['woocommerce']['btn_align'] : 'center';
    ?>
                                    <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_left" <?php checked($woocommerce_btn_align, 'left'); ?> value="left" class="ars_hide_checkbox ars_woocommerce_btn_align_input" />
                                    <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_center" <?php checked($woocommerce_btn_align, 'center'); ?> value="center" class="ars_hide_checkbox ars_woocommerce_btn_align_input"  />
                                    <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_right" <?php checked($woocommerce_btn_align, 'right'); ?> value="right" class="ars_hide_checkbox ars_woocommerce_btn_align_input" />
                                    <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ($woocommerce_btn_align === 'left') ? 'selected' : ''; ?>" id="ars_woocommerce_align_left_img" data-value="left" onclick="ars_select_radio_img('ars_woocommerce_align_left', 'ars_woocommerce_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ($woocommerce_btn_align === 'center') ? 'selected' : ''; ?>" id="ars_woocommerce_align_center_img" onclick="ars_select_radio_img('ars_woocommerce_align_center', 'ars_woocommerce_btn_align');" data-value="medium">
                                        <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ($woocommerce_btn_align === 'right') ? 'selected' : ''; ?>" id="ars_woocommerce_align_right_img" onclick="ars_select_radio_img('ars_woocommerce_align_right', 'ars_woocommerce_btn_align');" data-value="large">
                                        <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
    <?php $woocommerce_counter = isset($displays['woocommerce']['show_counter']) ? $displays['woocommerce']['show_counter'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_woocommerce_show_count" id="arsocialshare_woocommerce_show_count" value="<?php echo $woocommerce_counter ?>" />
                                    <div class="arsocialshare_switch <?php echo ( $woocommerce_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_woocommerce_show_count">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Size', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
    <?php $woocommerce_btn_width = isset($displays['woocommerce']['btn_width']) ? $displays['woocommerce']['btn_width'] : 'medium'; ?>
                                    <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_small" <?php checked($woocommerce_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_share_woocommerce_btn_width_input" />
                                    <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_medium" <?php checked($woocommerce_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_share_woocommerce_btn_width_input"  />
                                    <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_large" <?php checked($woocommerce_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_share_woocommerce_btn_width_input" />
                                    <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ($woocommerce_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_woocommerce_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_woocommerce_btn_small', 'ars_woocommerce_btn_width');" >
                                        <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ($woocommerce_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_woocommerce_btn_medium_img" onclick="ars_select_radio_img('ars_woocommerce_btn_medium', 'ars_woocommerce_btn_width');" data-value="medium">
                                        <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ($woocommerce_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_woocommerce_btn_large_img" onclick="ars_select_radio_img('ars_woocommerce_btn_large', 'ars_woocommerce_btn_width');" data-value="large">
                                        <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_woocommerce_more_button" id="arsocialshare_woocommerce_more_button" value="<?php echo isset($displays['woocommerce']['more_btn']) ? $displays['woocommerce']['more_btn'] : '5'; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
    <?php
    $woocommerce_more_btn_style = isset($displays['woocommerce']['more_btn_style']) ? $displays['woocommerce']['more_btn_style'] : 'plus_icon';
    ?>
                                    <select name="arsocialshare_woocommerce_button_style_more_btn" id="arsocialshare_woocommerce_button_style_more_btn" class="arsocialshare_dropdown">
                                        <option <?php selected($woocommerce_more_btn_style, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option <?php selected($woocommerce_more_btn_style, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
    <?php $woocommerce_more_btn_act = isset($displays['woocommerce']['more_btn_act']) ? $displays['woocommerce']['more_btn_act'] : 'display_popup'; ?>
                                    <select name="arsocialshare_woocommerce_more_button_action" id="arsocialshare_woocommerce_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                        <option <?php selected($woocommerce_more_btn_act, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                        <option <?php selected($woocommerce_more_btn_act, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

    <?php
    $woocommerce_show_total_counter = isset($displays['woocommerce']['enable_total_counter']) ? $displays['woocommerce']['enable_total_counter'] : 'no';
    ?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Total Share Count', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_woocommerce_show_total_share" id="arsocialshare_woocommerce_show_total_share" value="<?php echo $woocommerce_show_total_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($woocommerce_show_total_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_woocommerce_show_total_share">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
    <?php
    $woocommerce_show_total_counter_label = isset($displays['woocommerce']['arsocial_total_share_label']) ? $displays['woocommerce']['arsocial_total_share_label'] : 'SHARES';
    ?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Label', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" id="arsocialshare_woocommerce_total_share_label" name="arsocialshare_woocommerce_total_share_label" class="arsocialshare_input_box" value="<?php echo $woocommerce_show_total_counter_label; ?>" />
                                </div>
                            </div>
    <?php
    $woocommerce_show_total_counter_position = isset($displays['woocommerce']['total_counter_position']) ? $displays['woocommerce']['total_counter_position'] : '';
    ?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocial_woocommerce_total_counter_position" id="arsocial_woocommerce_total_counter_position" class="arsocialshare_dropdown">
                                        <option value="left" <?php selected($woocommerce_show_total_counter_position, 'left'); ?>><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right" <?php selected($woocommerce_show_total_counter_position, 'right'); ?>><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id='ars_woocommerce_display_number_format' name='ars_woocommerce_display_number_format' class="arsocialshare_dropdown">
    <?php
    $counter_number_format = $default_no_format;
    $ars_woocommerce_no_format = isset($displays['woocommerce']['no_format']) ? $displays['woocommerce']['no_format'] : 'style5';
    foreach ($counter_number_format as $key => $value) {
        ?>
                                            <option <?php selected($ars_woocommerce_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" />-->
                            <div class="ars_template_preview_container" id="arsocialshare_woocommerce_theme_preview" style="margin-top:-15px;">
                                <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $woocommerce_skin; ?>_theme arseffect_<?php echo $woocommerce_hover_effect; ?> <?php echo ($woocommerce_remove_space == 'yes') ? 'ars_remove_space' : ''; ?>">
                                    <div class='arsocialshare_button facebook ars_<?php echo $woocommerce_button_style; ?> arsocial_lite_facebook_wrapper ars_<?php
                                    echo $woocommerce_btn_width;
                                    ;
                                        ?>_btn' id='arsocialshare_facebook_btn' data-network="facebook">
                                        <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $woocommerce_skin; ?>_theme_icon socialshare-facebook'></span>
                                        <label class='arsocialshare_network_name'>Facebook</label>
                                        <span class='arsocialshare_counter arsocialshare_facebook_counter arsocialshare_counter_show_<?php echo $woocommerce_counter; ?>' id='arsocialshare_facebook_counter'>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="arsocialshare_option_container" style="margin-top:20px;">
                            <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Products', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_social_input" style="padding-top:6px;">
                                <input type="text" name="arsocialshare_woocommerce_excludes_product" id="arsocialshare_woocommerce_excludes_product" value="<?php echo isset($displays['woocommerce']['exclude_pages']) ? $displays['woocommerce']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                            </div>
                        </div>

                        <div class="arsocialshare_option_container">
                            <div class="arsocialshare_social_label" style="padding-right:15px;text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Product', 'arsocial_lite'); ?>:</div>
                            <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated product id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                        </div>
                    </div>
                    </div>
                </div>
    <?php
    $no++;
}
?>



            <div class="arsocialshare_title_belt">
                <div class="arsocialshare_title_belt_number"><?php
            echo $no;
            $no++;
?></div>
                <div class="arsocialshare_belt_title"><?php esc_html_e('Mobile Display Settings', 'arsocial_lite'); ?></div>
            </div>


            <div class="ars_network_list_container selected" style="width:100%;">

                <div class="arsocialshare_option_container ars_no_border " style="width:100%; padding-top:0;  ">
<?php
$mobile_checked = "";
$mobile_options = "display:none;";

if (is_array($displays) && array_key_exists('mobile', $displays)) {
    $mobile_checked = "checked='checked'";
    $mobile_options = "";
}
$mobile_skin = isset($displays['mobile']['skin']) ? $displays['mobile']['skin'] : 'lite_default';
?>
                    <div class="arsocialshare_option_row">
                        <div class="arsocialshare_option_label" style="width: 12%;"><?php echo esc_html__('Display on Custom Position', 'arsocial_lite'); ?> </div>
                        <div class="arsocialshare_option_input" style="width: 88%;">
                            <input type="radio" name="arsocialshare_enable_mobile" id="arsocialshare_enable_mobile" class="ars_display_option_input ars_hide_checkbox" value="<?php echo ($mobile_checked != '' ) ? 'mobile' : ''; ?>" <?php echo ($mobile_checked != '') ? "checked='checked'" : ''; ?> />
                            <div class="arsocialshare_switch <?php echo ($mobile_checked != '' && $mobile_checked != 'no') ? "selected" : ""; ?>" data-id="arsocialshare_enable_mobile">
                                <div class="arsocialshare_switch_options">
                                    <div class="arsocialshare_switch_label" data-action="true" data-value="mobile"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                </div>
                                <div class="arsocialshare_switch_button"></div>
                            </div>
                        </div>
                    </div>

                    <div id="ars_mobile_position" style="<?php echo $mobile_options; ?>">
                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label" style="width: 12%;"><?php echo esc_html__('Select Template', 'arsocial_lite'); ?> </div>
                            <div class="arsocialshare_option_input ars_mobile_skin">

                                <input type='hidden' id='arsocialshare_mobile_settings_skins' name = 'arsocialshare_mobile_settings_skins' value='<?php echo $mobile_skin; ?>' /> 
                                <dl style="" data-id="arsocialshare_mobile_settings_skins" data-name="arsocialshare_mobile_settings_skins" class="arsocialshare_selectbox">
                                    <dt>
                                    <span>
<?php
echo $default_themes[$mobile_skin]['display_name'];
?>
                                    </span>
                                    <input type="text" class="ars_autocomplete" value="<?php echo $default_themes[$mobile_skin]['display_name']; ?>" style="display:none;">
                                    <div style="" class="socialshare-angle-down ars_angle_dropdown"></div>
                                    </dt>
                                    <dd>
                                        <ul style="display:none" data-id='arsocialshare_mobile_settings_skins'>
<?php
unset($default_themes['bordered']);
unset($default_themes['rounded']);
unset($default_themes['flat_rounded']);
unset($default_themes['blank_round']);
foreach ($default_themes as $key => $value) {
    ?>
                                                <li id='<?php echo $key ?>' label='<?php echo $value['display_name']; ?>' data-value='<?php echo $key; ?>'  class="ars_mobile_template">
                                                    <img src='<?php echo ARSOCIAL_LITE_IMAGES_URL . '/' . $key . '_dropdown_icon.png' ?>' />
                                                    <div>
    <?php echo $value['display_name']; ?>
                                                    </div>
                                                </li>

<?php } ?>
                                        </ul>
                                    </dd>
                                </dl>    
                            </div>
                        </div>
                        <div class="arsocialshare_option_row"  >
                            <div class="arsocialshare_option_label" style="width: 12%; line-height:50px;" ><?php esc_html_e('Position Type', 'arsocial_lite'); ?> </div>
                            <div class="arsocialshare_option_input" style="width: 88%;">
                                <div class="arsocialshare_position_image arsocialshare_display_on_mobile <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_footer_icons') ? "selected" : ""; ?>" id="arsocialshare_share_button_bar_footer_icons_img" onclick="ars_select_radio_img('arsocialshare_share_button_bar_footer_icons', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_footer_icons'>
                                    <input type="radio" name="arsocialshare_display_mobile"  value="share_footer_icons" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_button_bar_footer_icons" <?php isset($displays['mobile']) ?  checked($displays['mobile']['disply_type'], 'share_footer_icons') : ''; ?>/>
                                    <span class="arsocialshare_position_image_icon_footer_icons"></span>
                                    <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Footer Icons', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_position_image arsocialshare_display_on_mobile arsocial_lite_global_section_restricted" id="arsocialshare_share_button_bar_type_img" onclick="ars_select_radio_img('arsocialshare_share_button_bar_type', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_footer_bar'>
                                    <input type="radio" name="arsocialshare_display_mobile"  value="share_button_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_button_bar_type" />
                                    <span class="arsocialshare_position_image_icon_footer_bar"></span>
                                    <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Footer Bar', 'arsocial_lite'); ?> </label>
                                    <span class='ars_lite_pro_version_info_label'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>

                                </div>
                                <div class="arsocialshare_position_image arsocialshare_display_on_mobile arsocial_lite_global_section_restricted" id="arsocialshare_share_left_point_type_img" onclick="ars_select_radio_img('arsocialshare_share_left_point_type', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_side_buttons'>
                                    <input type="radio" name="arsocialshare_display_mobile" value="share_point" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_left_point_type" />
                                    <span class="arsocialshare_position_image_icon_left_point"></span>
                                    <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Side Buttons', 'arsocial_lite'); ?> </label>
                                    <span class='ars_lite_pro_version_info_label'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                </div>

                                <div class="arsocialshare_position_image arsocialshare_display_on_mobile <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_fixed_footer_bar') ? "selected" : ""; ?>" id="arsocialshare_share_fixed_footer_bar_type_img" onclick="ars_select_radio_img('arsocialshare_share_fixed_footer_bar_type', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_footer_bar'>
                                    <input type="radio" name="arsocialshare_display_mobile" value="share_fixed_footer_bar"  class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_fixed_footer_bar_type" />
                                    <span class="arsocialshare_share_fixed_footer_bar_point"></span>
                                    <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Footer Bar Buttons', 'arsocial_lite'); ?> </label>
                                    <span class='ars_lite_pro_version_info_label'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                </div>

                            </div>
                        </div>
                        <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_footer_icons') ? 'block' : 'none'; ?>" id='arsshare_mobile_footer_icons'>
                            <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?> </div>
                            <?php
                            $mobile_more_btn_style = (isset($displays['mobile']['more_button_style']) && !empty($displays['mobile']['more_button_style'])) ? $displays['mobile']['more_button_style'] : "plus_icon";
                            ?>

                            <div class="arsocialshare_option_input ars_mobile_skin">
                                <select name="arsocialshare_mobile_more_button_style" id="arsocialshare_mobile_more_button_style" class="arsocialshare_dropdown">
                                    <option value="plus_icon" <?php selected($mobile_more_btn_style, 'plus_icon'); ?>><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                    <option value="dot_icon" <?php selected($mobile_more_btn_style, 'dot_icon'); ?>><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_button_bar') ? 'block' : 'none'; ?>" id='arsshare_mobile_footer_bar'>
                            <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('Footer Bar Label', 'arsocial_lite'); ?> </div>
                            <div class="arsocialshare_option_input ars_mobile_skin">
<?php $mobile_more_btn_after = 'Share'; ?>
                                <input type="text" name="arsocialshare_mobile_bottom_bar_label" class="arsocialshare_input_box" id="arsocialshare_mobile_bottom_bar_label" value="<?php echo $mobile_more_btn_after; ?>" readonly="readonly" />
                            </div>
                        </div>                    
                        <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_point') ? 'block' : 'none'; ?>" id='arsshare_mobile_side_buttons'>
                            <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('Select Button Position', 'arsocial_lite'); ?> </div>
                            <div class="arsocialshare_option_input ars_mobile_skin">
                                <select name="arsocialshare_mobile_more_button_position" id="arsocialshare_mobile_more_button_position" class="arsocialshare_dropdown">
                                    <option value="left" selected="selected"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                    <option value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="arsocialshare_option_row ars_litemargintop30">
                        <div class="arsocialshare_option_label" style="width: 12%; line-height:40px;"><?php esc_html_e('Hide on Mobile', 'arsocial_lite'); ?> </div>
                        <div class="arsocialshare_option_input" style="width: 88%; line-height:30px;" >
                            <div class="arshare_opt_checkbox_row">
                                <div class="arsocialshare_opt_inner_input_wrapper">
                                    <input type="checkbox" name="arsocialshare_mobile_hide_top" value="mobile_hide" id="arsocialshare_mobile_hide_top" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_top']) ? $displays['hide_mobile']['enable_mobile_hide_top'] : '', 1); ?> data-id="enable_mobile_hide_top" />
                                    <label for="arsocialshare_mobile_hide_top" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Top Position', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_opt_inner_input_wrapper">
                                    <input type="checkbox" name="arsocialshare_mobile_hide_bottom" value="mobile_hide" id="arsocialshare_mobile_hide_bottom" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_bottom']) ? $displays['hide_mobile']['enable_mobile_hide_bottom'] : '', 1); ?> data-id="enable_mobile_hide_bottom" />
                                    <label for="arsocialshare_mobile_hide_bottom" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Bottom Position', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_opt_inner_input_wrapper">
                                    <input type="checkbox" name="arsocialshare_mobile_hide_sidebar" value="mobile_hide" id="arsocialshare_mobile_hide_sidebar" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_sidebar']) ? $displays['hide_mobile']['enable_mobile_hide_sidebar'] : '', 1); ?> data-id="enable_mobile_hide_sidebar" />
                                    <label for="arsocialshare_mobile_hide_sidebar" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Sidebar', 'arsocial_lite'); ?></label>
                                </div>
                            </div>

                            <div class="arshare_opt_checkbox_row" style="line-height:normal;">
                                <div class="arsocialshare_opt_inner_input_wrapper">
                                    <input type="checkbox" name="arsocialshare_mobile_hide_top_bottom_bar" value="mobile_hide" id="enable_mobile_hide_top_bottom_bar" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_top_bottom_bar']) ? $displays['hide_mobile']['enable_mobile_hide_top_bottom_bar'] : '', 1); ?> data-id="enable_mobile_hide_top_bottom_bar" />
                                    <label for="enable_mobile_hide_top_bottom_bar" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Top Bottom Bar', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_opt_inner_input_wrapper arsocial_lite_global_section_restricted">
                                    <div class="disable_all_click_event">
                                    <input type="checkbox" name="arsocialshare_mobile_hide_onload" value="mobile_hide" id="enable_mobile_hide_onload" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_onload']) ? $displays['hide_mobile']['enable_mobile_hide_onload'] : '', 1); ?> data-id="enable_mobile_hide_onload" />
                                    <label for="enable_mobile_hide_onload" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Popup', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="arsocialshare_title_belt">
                <div class="arsocialshare_title_belt_number"><?php
echo $no;
$no++;
?></div>
                <div class="arsocialshare_belt_title"><?php esc_html_e('Custom CSS', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
            </div>

            <div class="ars_network_list_container selected" style="width:100%;">
                <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%; padding-top:0;  ">
                    <div class="arsocialshare_option_row" style="padding-bottom: 0px;">
                        <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Enter Custom CSS', 'arsocial_lite'); ?></div>
                        <div class="arsocialshare_option_input arsocial_lite_custom_css_global_restricted" style="width: 88%;">
                            <div class="arshare_opt_checkbox_row">
                                <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                    <textarea name="arsocialshare_share_customcss" id="arsocialshare_share_customcss" class="ars_display_option_input" style="width:700px;height:200px;padding:5px 10px !important;" readonly="readonly"></textarea>
                                </div>
                                <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%; margin-top:10px; ">
                                    <span class='arsocial_lite_locker_note' style="width: 100%;">
<?php echo "eg: .arsocial_lite_top_button { background-color: #d1d1d1; }"; ?>
                                    </span>
                                    <span class='arsocial_lite_locker_note' style="float:left;">
<?php esc_html_e('For CSS Class information related to sharing buttons,', 'arsocial_lite'); ?>
                                    </span>
                                    <div class="ars_custom_css_info_link arsocial_lite_locker_note" style="float: left;cursor: pointer;"><b>&nbsp;<?php esc_html_e('Please Click Here', 'arsocial_lite'); ?></b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="arsocial_lite_share_button_wrapper">
        <button value="true" style="margin:15px 0px 0px 60px;" class="arsocialshare_save_display_settings" id="update_arsocialshare_position_settings" name="update_arsocialshare_position_settings" type="button"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
        <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
    </div>

</div>

<div class="success-message" id="success-message">
</div>

<div class="ars_sticky_top_belt" id="ars_sticky_top_belt">
    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="sticky_belt_loader ars_loader" />
    <button value="true" class="arsocialshare_save_display_settings" id="update_arsocialshare_position_settings" data-id="sticky_belt" name="update_arsocialshare_position_settings" type="button"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
    <div class="arsocialshare_title_wrapper sticky_top_belt">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Share Button Configuration', 'arsocial_lite'); ?></label>
    </div>
</div>
<div class="ars_lite_upgrade_modal" id="ars_lite_pro_global_premium_notice" style="display:none;">
    <div class="upgrade_modal_top_belt">
        <div class="logo" style="text-align:center;"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_update_logo.png" /></div>
        <div id="nav_style_close" class="close_button b-close"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_upgrade_close_img.png" /></div>
    </div>
    <div class="upgrade_title"><?php esc_html_e('Upgrade To Premium Version.', 'arsocial_lite'); ?></div>
    <div class="upgrade_message"><?php esc_html_e('To unlock this Feature, Buy Premium Version for $20.00 Only.', 'arsocial_lite'); ?></div>
    <div class="upgrade_modal_btn">
        <button id="pro_upgrade_button"  type="button" class="buy_now_button"><?php esc_html_e('Buy Now', 'arsocial_lite'); ?></button>
        <button id="pro_upgrade_cancel_button"  class="learn_more_button" type="button"><?php esc_html_e('Learn More', 'arsocial_lite'); ?></button>
        <input type="hidden" name="ars_version" id="ars_version" value="<?php global $arsocial_lite_version;
                                        echo $arsocial_lite_version; ?>" />
        <input type="hidden" name="ars_request_version" id="ars_request_version" value="<?php echo get_bloginfo('version'); ?>" />
    </div>
</div>        