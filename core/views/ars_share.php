<?php
$network_id = (isset($_REQUEST['network_id']) && !empty($_REQUEST['network_id'])) ? $_REQUEST['network_id'] : '';
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
$arsocialaction = isset($_REQUEST['arsocialaction']) ? $_REQUEST['arsocialaction'] : '';
if (!empty($default_themes)) {
    foreach ($default_themes as $theme => $val) {
        wp_enqueue_style('arsocial_lite_theme-' . $theme);
    }
    wp_enqueue_style('arsocial_lite_theme-rolling');
}
$display_order = array();
$new_order = array();
$ars_lite_default_pro_networks = array();
$ars_lite_default_pro_networks = $ars_lite_default_networks;

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

$network_settings = $display_settings = array();
if (!empty($network_id)) {
    $table = $arsocial_lite->arslite_networks;
    $results = $wpdb->get_row("SELECT network_id,network_settings,display_settings FROM `$table`  WHERE network_id= '$network_id'");

    $network_settings = maybe_unserialize($results->network_settings);
    $display_settings = maybe_unserialize($results->display_settings);
    $networks_display_name = $network_settings['custom_name'];

    $new_sorted_networks = array();
    if (!empty($network_settings)) {
        $ars_lite_default_networks = array();
        $network_order = (explode(",", $network_settings['sort_order']));
        foreach ($network_order as $value) {
            $ars_lite_default_networks['networks'][$value] = $network_settings['custom_name'][$value];
        }
        $sort_order = implode(',', array_keys($ars_lite_default_networks['networks']));
    }
} else {

    foreach ($ars_lite_default_networks['networks'] as $key => $value) {
        $display_order[$key] = $value['display_order'];
    }

    asort($display_order);
    $networks_sorted = array();

    $ars_lite_default_networks = $ars_lite_default_networks['networks'];
    foreach ($display_order as $id => $network) {
        $networks_sorted['networks'][$id] = @$networks[$id];
    }

    //ksort($ars_lite_default_networks);
    foreach ($ars_lite_default_networks as $key => $value) {
        $ars_lite_default_networks['networks'][$key] = $value['custom_name'];
    }

    $sort_order = implode(',', array_keys($ars_lite_default_networks['networks']));

    $network_settings['enabled_network'] = array();
    $network_settings['custom_name'] = array();
    $display_settings['arsocialshare_display_type'] = 'on_page';

    $display_settings['arsocialshare_sidebar'] = 'left';
    $display_settings['arsocialshare_fly_in_onload_type'] = 'fly_in_onload';
    $display_settings['arsocialshare_fly_position'] = 'left';

    $display_settings['arsocialshare_onload_type'] = 'popup_onload';

    $display_settings['arsocialshare_share_settings_fixed_button_width'] = '';
    $display_settings['arsocialshare_share_settings_full_button_width_desktop'] = '';
    $display_settings['arsocialshare_share_settings_more_button'] = 5;
}
$pro_networks = array();
$pro_networks = array('facebook','twitter','linkedin','pinterest','buffer','reddit');
?>
<div style="display:none;">
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_2_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_3_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_1.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/button_style_1_selected.png" />  
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/floating_bottom_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/floating_top.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/small_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/medium_btn_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/large_btn_selected.png" />    
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/position_right_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_left_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_right_selected.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_center.png" />
    <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/alignment_center_selected.png" />   
</div>
<div class="arsocialshare_main_wrapper">
    <div class="arsocialshare_title_wrapper">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Share Button Configuration', 'arsocial_lite'); ?></label>
    </div>
    <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" /></div>   

    <div class="arsocialshare_inner_wrapper" style="padding:0;">
        <div class="arsocialshare_networks_inner_wrapper">
            <form name="ars_share_shortcode_generator_frm" id="ars_share_shortcode_generator_frm">
                <input type="hidden" id="arsocialshare_ajaxurl" name="arsocialshare_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>" />
                <input type="hidden" id="network_id" name="network_id" value="<?php echo ($arsocialaction !== 'duplicate') ? $network_id : ''; ?>" />
                <input type="hidden" id="sort_order" name="sort_order" value="<?php echo $sort_order; ?>" />
                <input type="hidden" id="arsocialshare_action" name="arsocialshare_action" value="" />

                <div class="arsocialshare_network_wrapper" id="arsocialshare_position_settings" style="display:block;">
                    <div class="arsocialshare_title_belt">
                        <div class="arsocialshare_title_belt_number">1</div>
                        <div class="arsocialshare_belt_title"><?php esc_html_e('Select Position Where You Want To Display Share Buttons', 'arsocial_lite'); ?></div>
                    </div>
                    <div class="arsocialshare_inner_container" style="padding:30px 5px 25px 30px;">    
                        <label class="arsocialshare_inner_container_box two_col ars_shortcode_radio_position <?php echo ($display_settings['arsocialshare_display_type'] === 'on_page') ? 'selected' : ''; ?>">
                            <div class="arsocialshare_container_box_title_belt">
                                <input type="radio" name="arsocialshare_display_type" <?php checked($display_settings['arsocialshare_display_type'], 'on_page'); ?> value="on_page" id="arsocialshare_enable_on_page" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" data-id="enable_on_page_btns" data-type="radio" />
                                <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_on_page"><span></span>&nbsp;&nbsp;<?php esc_html_e('Pages', 'arsocial_lite'); ?></label>
                            </div>
                        </label>
                        <?php
                        $isSidebarEnable = false;
                        $sidebar_checked = $page_checked = $popup_checked = $top_bottom_hide_show_checked = "";
                        $hide_button_style = '';
                        if (isset($display_settings['arsocialshare_display_type']) && $display_settings['arsocialshare_display_type'] == 'on_page') {
                            $page_checked = "display : block;";
                        }
                        if (isset($display_settings['arsocialshare_display_type']) && $display_settings['arsocialshare_display_type'] == 'sidebar') {
                            $sidebar_checked = "display : block;";
                            $isSidebarEnable = true;
                            $hide_button_style = 'display:none;';
                        }
                        if (isset($display_settings['arsocialshare_display_type']) && $display_settings['arsocialshare_display_type'] == 'popup') {
                            $popup_checked = "display : block;";
                        }
                        if (isset($display_settings['arsocialshare_display_type']) && $display_settings['arsocialshare_display_type'] == 'top_bottom_bar') {
                            $top_bottom_hide_show_checked = "display : block;";
                        }
                        ?>

                        <label class="arsocialshare_inner_container_box two_col ars_shortcode_radio_position <?php echo ($display_settings['arsocialshare_display_type'] === 'sidebar') ? 'selected' : ''; ?>">
                            <div class="arsocialshare_container_box_title_belt">
                                <input type="radio" name="arsocialshare_display_type" value="sidebar" id="arsocialshare_enable_sidebar" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" <?php checked($display_settings['arsocialshare_display_type'], 'sidebar'); ?> data-id="enable_sidebar_btns" data-type="radio" />
                                <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_sidebar"><span></span>&nbsp;&nbsp;<?php esc_html_e('Sidebar', 'arsocial_lite'); ?></label>
                            </div>
                        </label>

                        <label class="arsocialshare_inner_container_box two_col inner_btn_option ars_shortcode_radio_position <?php echo ($display_settings['arsocialshare_display_type'] === 'top_bottom_bar') ? 'selected' : ''; ?>">
                            <div class="arsocialshare_container_box_title_belt">
                                <input type="radio" name="arsocialshare_display_type" value="top_bottom_bar" id="arsocialshare_enable_top_bottom_bar" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" <?php checked($display_settings['arsocialshare_display_type'], 'top_bottom_bar'); ?> data-id="top_bottom_bar" data-type="radio" />
                                <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_top_bottom_bar"><span></span>&nbsp;&nbsp;<?php esc_html_e('Top / Bottom Bar', 'arsocial_lite'); ?></label>
                            </div>
                        </label>

                        <label class="arsocialshare_inner_container_box two_col inner_btn_option arsocial_lite_position_shortcode_restricted <?php echo ($display_settings['arsocialshare_display_type'] === 'popup') ? 'selected' : ''; ?>"> 
                            <div class="arsocialshare_container_box_title_belt">
                                <input type="radio" name="arsocialshare_display_type" value="popup" id="arsocialshare_enable_popup" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" data-id="enable_popup" data-type="radio" <?php checked($display_settings['arsocialshare_display_type'], 'popup'); ?>   />
                                <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_popup"><span></span>&nbsp;&nbsp;<?php esc_html_e('Popup', 'arsocial_lite'); ?></label>&nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                            </div>


                        </label>
                    </div>
                </div>
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">2</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Networks', 'arsocial_lite'); ?></div>
                </div>
                <span class="ars_error_message" id="arsocialshare_network_error"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
                <div class="arsocialshare_inner_container">
                    <div class="ars_network_list_container selected arsocialshare_sharing_share_sortable ui-sortable" id="arsocialshare_sharing_options">
                        <?php
                        foreach ($ars_lite_default_networks['networks'] as $id => $value) {
                            //$enabled = "arsocialshare_enbaled_network";
                            $btnClass = (isset($network_settings['enabled_network']) && in_array($id, $network_settings['enabled_network'])) ? "selected" : "";
                            $checked = (isset($network_settings['enabled_network']) && in_array($id, $network_settings['enabled_network'])) ? "checked='checked'" : "";
                            $pro_network = (in_array($id, $pro_networks)) ? true : false;
                            ?>
                        <?php if($pro_network == true) { ?>
                            <div id="<?php echo $id; ?>" class="arsocialshare_network_buttons <?php echo $btnClass; ?>">
                                <input type="checkbox" name="position_setting_display_networks[]" value="<?php echo $id; ?>" <?php echo $checked; ?> class="arsocialshare_position_setting_network_input" id="arsocialsharenetwork_<?php echo $id; ?>" />
                                <label for="arsocialsharenetwork_<?php echo $id; ?>"><span></span></label>
                                <input type="hidden" name="ars_network_display_name[<?php echo $id; ?>]" id="ars_display_id_<?php echo $id; ?>" value="<?php echo $value; ?>"/>
                                <span class="arsocialshare_network_icon <?php echo $id; ?>"></span>
                                <label class="arsocialshare_network_label ars_share_editable" data-network="ars_display_id_<?php echo $id; ?>" ><?php echo $value ?></label>
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
                        foreach ($ars_lite_default_pro_networks['networks'] as $id => $value) {
                            $pro_network = (in_array($id, $pro_networks)) ? true : false;
                            ?>
                        <?php if($pro_network == false) { ?>
                            <div id="<?php echo $id; ?>" class="arsocialshare_network_buttons_disabled arsocialshare_pro_network_buttons">
                                <input type="checkbox" name="position_setting_display_networks[]" value="<?php echo $id; ?>" class="arsocialshare_position_setting_network_input" id="arsocialsharenetwork_<?php echo $id; ?>" />
                                <label for="arsocialsharenetwork_<?php echo $id; ?>"><span></span></label>
                                <input type="hidden" name="ars_network_display_name[<?php echo $id; ?>]" id="ars_display_id_<?php echo $id; ?>" value="<?php echo $value['display_name']; ?>"/>
                                <span class="arsocialshare_network_icon <?php echo $id; ?>"></span>
                                <label class="arsocialshare_network_label" data-network="ars_display_id_<?php echo $id; ?>" ><?php echo $value['display_name'] ?></label>
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
                    <div class="arsocialshare_title_belt_number">3</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Template & Style', 'arsocial_lite'); ?></div>
                </div>

                <div class="arsocialshare_inner_container">

                    <div class="arsocialshare_inner_content_wrapper" style="padding-top:25px;">

                        <div class="arsocialshare_option_container ars_column">

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $skin = isset($display_settings['arsocialshare_share_settings_skins']) ? $display_settings['arsocialshare_share_settings_skins'] : 'lite_default';
                                    $allThemes = array_merge($default_themes, $sidebar_themes);
                                    ?>
                                    <select name="arsocialshare_share_settings_skins" id="arsocialshare_gs_skins" class="arsocialshare_dropdown ars_lite_pro_options" data-type="generate_shortcode">
                                        <?php
                                        foreach ($allThemes as $gs_theme => $label) {
                                            $optClass = "ars_share_all_theme {$gs_theme}";
                                            $optStyle = "";
                                            if (in_array($gs_theme, array_keys($sidebar_themes))) {
                                                $optClass .= " ars_share_sidebar_theme";
                                                if (!$isSidebarEnable && $gs_theme == 'rolling') {
                                                    $optStyle .= "display:none;";
                                                }
                                            } else {
                                                if ($isSidebarEnable) {
                                                    $optStyle .= "display:none;";
                                                }
                                            }
                                            ?>
                                            <option <?php selected($skin, $gs_theme); ?> value="<?php echo $gs_theme; ?>" class="<?php echo $optClass; ?>" style="<?php echo $optStyle; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="arsocialshare_inner_option_label more_templates_label" ><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                            </div>

                            <?php
                            $button_style = isset($display_settings['arsocialshare_share_button_style']) ? $display_settings['arsocialshare_share_button_style'] : 'name_with_icon';
                            $button_style_css = $nwi_button_style_css = '';
                            if ($isSidebarEnable) {
                                $button_style_css = "display:none;";
                                $button_style = 'icon_without_name';
                            }
                            if ($skin == 'rounded') {
                                $nwi_button_style_css = "display:none;";
                                $button_style = 'icon_without_name';
                            }
                            ?>
                            <div class="arsocialshare_option_row ars_share_no_sidebar_option" id='ars_button_style' style="<?php echo $button_style_css; ?> <?php echo $nwi_button_style_css . $hide_button_style; ?>">
                                <input type="radio" name="arsocialshare_share_button_style" value="name_with_icon" <?php checked($button_style, 'name_with_icon'); ?> class="arsocialshare_gs_button_style ars_hide_checkbox" id="arsocialshare_top_bottom_btn_name_with_icon" data-type="generate_shortcode"/>
                                <input type="radio" name="arsocialshare_share_button_style" value="name_without_icon" <?php checked($button_style, 'name_without_icon'); ?> class="arsocialshare_gs_button_style ars_hide_checkbox" id="arsocialshare_top_bottom_btn_name_without_icon" data-type="generate_shortcode"/>
                                <input type="radio" name="arsocialshare_share_button_style" value="icon_without_name" <?php checked($button_style, 'icon_without_name'); ?> class="arsocialshare_gs_button_style ars_hide_checkbox" id="arsocialshare_top_bottom_btn_icon_without_name" data-type="generate_shortcode"/>
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Style', 'arsocial_lite'); ?>:</div>
                                <div class="arsocialshare_option_input">
                                    <div class='arsocialshare_inner_option_box arsocialshare_top_bottom_btn_style <?php echo ($button_style === 'name_with_icon') ? 'selected' : ''; ?>' id="arsocialshare_top_bottom_btn_name_with_icon_img" data-value="name_with_icon" onclick="ars_select_radio_img('arsocialshare_top_bottom_btn_name_with_icon', 'arsocialshare_top_bottom_btn_style')">
                                        <span class="arsocialshare_inner_option_icon name_with_icon"></span>
                                    </div>
                                    <div class='arsocialshare_inner_option_box arsocialshare_top_bottom_btn_style <?php echo ($button_style === 'name_without_icon') ? 'selected' : ''; ?>' id="arsocialshare_top_bottom_btn_name_without_icon_img" data-value="name_without_icon" onclick="ars_select_radio_img('arsocialshare_top_bottom_btn_name_without_icon', 'arsocialshare_top_bottom_btn_style')">
                                        <span class="arsocialshare_inner_option_icon name_without_icon"></span>
                                    </div>
                                    <div class='arsShareSidebarBtnStyle arsocialshare_inner_option_box arsocialshare_top_bottom_btn_style <?php echo ($button_style === 'icon_without_name') ? 'selected' : ''; ?>' id="arsocialshare_top_bottom_btn_icon_without_name_img" data-value="icon_without_name" onclick="ars_select_radio_img('arsocialshare_top_bottom_btn_icon_without_name', 'arsocialshare_top_bottom_btn_style')">
                                        <span class="arsocialshare_inner_option_icon icon_without_name"></span>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $hovereffect = isset($display_settings['arsocialshare_share_hover_effect']) ? $display_settings['arsocialshare_share_hover_effect'] : 'effect1';
                            $hover_effect_attr = '';
                            if ($skin == 'rolling') {
                                $hover_effect_attr = 'disabled="disabled"';
                            }
                            ?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hover Animation', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocialshare_share_hover_effect" id="arsocialshare_gs_hover_effect" class="arsocialshare_dropdown" data-type="generate_shortcode" <?php echo $hover_effect_attr; ?>>
                                        <?php
                                        foreach ($default_effects as $gs_effects => $label) {
                                            //$sidebar_effects
                                            $EoptClass = "ars_share_all_effects {$gs_effects}";
                                            $EoptStyle = "";
                                            if ($isSidebarEnable) {
                                                $EoptStyle = "display:none;";
                                            }
                                            if (in_array($gs_effects, array_keys($sidebar_effects))) {
                                                $EoptClass .= " ars_share_sidebar_effects";
                                                $EoptStyle .= "{$sidebar_checked}";
                                            }
                                            ?>
                                            <option <?php selected($hovereffect, $gs_effects); ?> value="<?php echo $gs_effects; ?>" class="<?php echo $EoptClass; ?>" style="<?php echo $EoptStyle; ?>"><?php echo $label['display_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Remove Space From Buttons', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $remove_space = isset($display_settings['arsocialshare_share_remove_space']) ? $display_settings['arsocialshare_share_remove_space'] : 'no';
                                    ?><input type="hidden" name="arsocialshare_share_remove_space" id="arsocialshare_gs_remove_space" value="<?php echo $remove_space; ?>" data-type="generate_shortcode" />
                                    <div class="arsocialshare_switch <?php echo ($remove_space === 'yes') ? 'selected' : ''; ?>" data-id="arsocialshare_gs_remove_space">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show" id="ars_share_alignment" style="display:none;<?php echo $page_checked . $top_bottom_hide_show_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $topbottom_btn_align = isset($display_settings['ars_btn_align']) ? $display_settings['ars_btn_align'] : 'ars_align_center';
                                    ?>
                                    <input type="radio" name="ars_btn_align" id="ars_top_bottom_btn_left" <?php checked($topbottom_btn_align, 'ars_align_left'); ?> value="ars_align_left" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                    <input type="radio" name="ars_btn_align" id="ars_top_bottom_btn_center" <?php checked($topbottom_btn_align, 'ars_align_center'); ?> value="ars_align_center" class="ars_hide_checkbox ars_top_bottom_btn_align_input"  />
                                    <input type="radio" name="ars_btn_align" id="ars_top_bottom_btn_right" <?php checked($topbottom_btn_align, 'ars_align_right'); ?> value="ars_align_right" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'ars_align_left') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_top_bottom_btn_left', 'ars_top_bottom_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'ars_align_center') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_top_bottom_btn_center', 'ars_top_bottom_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'ars_align_right') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_top_bottom_btn_right', 'ars_top_bottom_btn_align');">
                                        <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show" style="display:none;<?php echo $top_bottom_hide_show_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $top_bar_checked = "";
                                    $bottom_bar_checked = "";
                                    if (isset($display_settings['arsocialshare_top_bar']) && $display_settings['arsocialshare_top_bar'] == 'top_bar') {
                                        $top_bar_checked = "checked='checked'";
                                    }
                                    if (isset($display_settings['arsocialshare_top_bar']) && $display_settings['arsocialshare_top_bar'] == 'bottom_bar') {
                                        $bottom_bar_checked = "checked='checked'";
                                    }
                                    if ($top_bar_checked == '' && $bottom_bar_checked == '') {
                                        $top_bar_checked = "checked='checked'";
                                    }
                                    ?>
                                    <input type="radio" name="arsocialshare_top_bar" value="top_bar" data-on="top_bar" <?php echo $top_bar_checked; ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_top" />
                                    <input type="radio" name="arsocialshare_top_bar" value="bottom_bar" <?php echo $bottom_bar_checked; ?> data-on="bottom_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_bottom" />
                                    <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($top_bar_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_radio_img('arsocialshare_buttons_on_top', 'arsocialshare_bar_position');" id="arsocialshare_buttons_on_top_img" data-value="top">
                                        <span class="arsocialshare_inner_option_icon top_bar"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($bottom_bar_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_radio_img('arsocialshare_buttons_on_bottom', 'arsocialshare_bar_position');" id="arsocialshare_buttons_on_bottom_img" data-value="right">
                                        <span class="arsocialshare_inner_option_icon bottom_bar"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row" id="ars_lite_sidebar_position" style="display:none;<?php echo $sidebar_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $sidebar_position = (isset($display_settings['arsocialshare_sidebar']) && !empty($display_settings['arsocialshare_sidebar'])) ? $display_settings['arsocialshare_sidebar'] : "left";
                                    ?>
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

                            <?php
                            $enable_total_counter = (isset($display_settings['enable_total_counter']) && !empty($display_settings['enable_total_counter'])) ? $display_settings['enable_total_counter'] : "no";
                            ?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Total Share Count', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_show_total_share" id="arsocialshare_show_total_share" value="<?php echo $enable_total_counter; ?>" />
                                    <div class="arsocialshare_switch <?php echo ($enable_total_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_show_total_share">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $total_counter_label = isset($display_settings['arsocial_total_share_label']) ? $display_settings['arsocial_total_share_label'] : 'SHARES';
                            ?>
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Label', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" id="arsocialshare_total_share_label" name="arsocialshare_total_share_label" class="arsocialshare_input_box" value="<?php echo $total_counter_label; ?>" />
                                </div>
                            </div>
                            <?php
                            $total_counter_position = isset($display_settings['total_counter_position']) ? $display_settings['total_counter_position'] : '';
                            ?>
                            <div class="arsocialshare_option_row" id="arsocial_counter_position_wrapper" style="<?php echo ($display_settings['arsocialshare_display_type'] == 'sidebar') ? 'display:none;' : ''; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Total Share Counter Position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select name="arsocial_total_counter_position" id="arsocial_total_counter_position" class="arsocialshare_dropdown">
                                        <option value="left" <?php selected($total_counter_position, 'left'); ?>><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right" <?php selected($total_counter_position, 'right'); ?>><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <select id='arsocialshare_display_number_format' name='arsocialshare_display_number_format' class="arsocialshare_dropdown">
                                        <?php
                                        $counter_number_format = $default_no_format;
                                        $ars_sidebar_no_format = isset($display_settings['no_format']) ? $display_settings['no_format'] : 'style5';
                                        foreach ($counter_number_format as $key => $value) {
                                            ?>
                                            <option <?php selected($ars_sidebar_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Counter', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php $show_counter = isset($display_settings['arsocialshare_share_show_count']) ? $display_settings['arsocialshare_share_show_count'] : 'no'; ?>
                                    <input type="hidden" name="arsocialshare_share_show_count" id="arsocialshare_gs_show_count" value="<?php echo $show_counter; ?>" data-type="generate_shortcode" />
                                    <div class="arsocialshare_switch <?php echo ($show_counter === 'yes' ) ? 'selected' : ''; ?>" id="show_counter" data-id="arsocialshare_gs_show_count">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $btn_style = isset($display_settings['arsocialshare_share_button_width']) ? $display_settings['arsocialshare_share_button_width'] : 'medium';
                            $sidebar_btn_hide = ($skin == 'rolling') ? 'display: none;' : '';
                            ?>
                            <div class="arsocialshare_option_row ars_lite_sidebar_btn_width_options" style="<?php echo $sidebar_btn_hide; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Button Size', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="radio" name="arsocialshare_share_button_width" id="ars_top_bottom_btn_small" <?php checked($btn_style, 'small'); ?> value="small" class="ars_hide_checkbox ars_gs_btn_width_input" />
                                    <input type="radio" name="arsocialshare_share_button_width" id="ars_top_bottom_btn_medium" <?php checked($btn_style, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_gs_btn_width_input"  />
                                    <input type="radio" name="arsocialshare_share_button_width" id="ars_top_bottom_btn_large" <?php checked($btn_style, 'large'); ?> value="large" class="ars_hide_checkbox ars_gs_btn_width_input" />
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width <?php echo ($btn_style === 'small') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_top_bottom_btn_small', 'ars_top_bottom_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width <?php echo ($btn_style === 'medium') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_top_bottom_btn_medium', 'ars_top_bottom_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_inner_option_box ars_top_bottom_btn_width <?php echo ($btn_style === 'large') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_top_bottom_btn_large', 'ars_top_bottom_btn_width')">
                                        <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                        <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row" id="ars_more_button" style="<?php echo ($popup_checked !== '') ? 'display:none;' : ''; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" class="arsocialshare_input_box" name="arsocialshare_share_settings_more_button" id="arsocialshare_top_bottom_bar_more_button" value="<?php echo isset($display_settings['arsocialshare_share_settings_more_button']) ? $display_settings['arsocialshare_share_settings_more_button'] : '5'; ?>" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_row" id="ars_more_button_style" style="<?php echo ($popup_checked !== '') ? 'display:none;' : ''; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $morebtnstyle = isset($display_settings['arsocialshare_share_more_button_style']) ? $display_settings['arsocialshare_share_more_button_style'] : 'plus_icon';
                                    ?>
                                    <select name="arsocialshare_share_more_button_style" id="arsocialshare_topbottom_more_button_style" class="arsocialshare_dropdown">
                                        <option <?php selected($morebtnstyle, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option <?php selected($morebtnstyle, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row" id="ars_more_button_action" style="<?php echo ($popup_checked !== '') ? 'display:none;' : ''; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $morebtnaction = isset($display_settings['arsocialshare_share_more_button_action']) ? $display_settings['arsocialshare_share_more_button_action'] : 'display_popup';
                                    ?>
                                    <select name="arsocialshare_share_more_button_action" id="arsocialshare_topbottom_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                        <option <?php selected($morebtnaction, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                        <option <?php selected($morebtnaction, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Hide On Mobile', 'arsocial_lite'); ?> &nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                                <div class="arsocialshare_option_input">
                                    <input type="hidden" name="arsocialshare_mobile_hide" id="arsocialshare_mobile_hide" value="no" />
                                    <div class="arsocialshare_switch arsocial_lite_restrict_shortcode_mobile" id="hide_on_mobile" data-id="arsocialshare_mobile_hide">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_popup_hide_show" style="display:none;<?php echo $popup_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Show Close Button', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php $is_close_button = isset($display_settings['arsocialshare_pop_show_close_button']) ? $display_settings['arsocialshare_pop_show_close_button'] : 'yes'; ?>
                                    <input type="hidden" name="arsocialshare_pop_show_close_button" id="arsocialshare_show_close_button" value="<?php echo $is_close_button ?>" />
                                    <div class="arsocialshare_switch <?php echo ($is_close_button === 'yes' ) ? 'selected' : ''; ?>" id="hide_on_mobile" data-id="arsocialshare_show_close_button">
                                        <div class="arsocialshare_switch_options">
                                            <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                            <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                        </div>
                                        <div class="arsocialshare_switch_button"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show" id="ars_top_bottombar_displaybar" style="display:none;<?php echo $top_bottom_hide_show_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $display_bar_on = isset($display_settings['arsocialshare_top_bottom_bar_display_on']) ? $display_settings['arsocialshare_top_bottom_bar_display_on'] : 'onload';
                                    ?>
                                    <select class="arsocialshare_dropdown" name="arsocialshare_top_bottom_bar_display_on" id="arsocialshare_top_bottom_bar_display_on">
                                        <option <?php selected($display_bar_on, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                        <option <?php selected($display_bar_on, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <?php
                            $display_bar_on_onload_show = $display_bar_on_onscroll_show = '';
                            if ($display_bar_on == 'onload' && $display_settings['arsocialshare_display_type'] == 'top_bottom_bar') {
                                $display_bar_on_onload_show = 'display : block;';
                            } else if ($display_bar_on == 'onscroll' && $display_settings['arsocialshare_display_type'] == 'top_bottom_bar') {
                                $display_bar_on_onscroll_show = 'display : block;';
                            }
                            ?>
                            <div class="arsocialshare_option_row ars_popup_hide_show" style="display:none;<?php echo $popup_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <?php
                                    $display_popup = isset($display_settings['arsocialshare_onload_type']) ? $display_settings['arsocialshare_onload_type'] : 'onload';
                                    ?>
                                    <select class="arsocialshare_dropdown" name="arsocialshare_onload_type" id="arsocialshare_popup_display_on">
                                        <option <?php selected($display_popup, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                        <option <?php selected($display_popup, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <?php
                            $display_popup_on_onload_show = $display_popup_on_onscroll_show = '';
                            if ($display_popup == 'onload' && $display_settings['arsocialshare_display_type'] == 'popup') {
                                $display_popup_on_onload_show = 'display : block;';
                            } else if ($display_popup == 'onscroll' && $display_settings['arsocialshare_display_type'] == 'popup') {
                                $display_popup_on_onscroll_show = 'display : block;';
                            }
                            ?>
                            <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option <?php echo ($display_popup === 'onload' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_load_wrapper" style="display:none;<?php echo $display_popup_on_onload_show; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n seconds', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_open_delay" id="arsocialshare_popup_onload_time" class="arsocialshare_input_box" value="<?php echo isset($display_settings['arsocialshare_open_delay']) ? $display_settings['arsocialshare_open_delay'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option <?php echo ($display_popup === 'onscroll' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_scroll_wrapper" style="display:none;<?php echo $display_popup_on_onscroll_show; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n % of scroll', 'arsocial_lite') ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_open_scroll" id="arsocialshare_popup_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($display_settings['arsocialshare_open_scroll']) ? $display_settings['arsocialshare_open_scroll'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option" style="display:none;<?php echo $popup_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Popup Height', 'arsocial_lite') ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="popup_height" id="arsocialshare_popup_height" class="arsocialshare_input_box" value="<?php echo isset($display_settings['popup_height']) ? $display_settings['popup_height'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> px </span>
                                </div>
                                <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto height.', 'arsocial_lite'); ?></span>
                            </div>

                            <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option" style="display:none;<?php echo $popup_checked; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Popup Width', 'arsocial_lite') ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="popup_width" id="arsocialshare_popup_width" class="arsocialshare_input_box" value="<?php echo isset($display_settings['popup_width']) ? $display_settings['popup_width'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> px </span>
                                </div>
                                <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto width.', 'arsocial_lite'); ?></span>
                            </div>

                            <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onload') ? 'selected' : ''; ?>" id="arsocialshare_on_load_wrapper" style="display:none;<?php echo $display_bar_on_onload_show; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n seconds', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_top_bottom_bar_onload_time" id="arsocialshare_top_bottom_bar_onload_time" class="arsocialshare_input_box" value="<?php echo isset($display_settings['arsocialshare_top_bottom_bar_onload_time']) ? $display_settings['arsocialshare_top_bottom_bar_onload_time'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onscroll') ? 'selected' : ''; ?>" id="arsocialshare_on_scroll_wrapper" style="display:none;<?php echo $display_bar_on_onscroll_show; ?>">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n % of scroll', 'arsocial_lite') ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name="arsocialshare_top_bottom_bar_onscroll_percentage" id="arsocialshare_top_bottom_bar_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($display_settings['arsocialshare_top_bottom_bar_onscroll_percentage']) ? $display_settings['arsocialshare_top_bottom_bar_onscroll_percentage'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show arsocialshare_display_bar_option" style="<?php echo ($display_settings['arsocialshare_display_type'] == 'top_bottom_bar') ? 'display:block;' : 'display:none;'; ?>" id="arsocialshare_bar_y_position">
                                <div class="arsocialshare_option_label"><?php esc_html_e('Display Top Bar after Y position', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input">
                                    <input type="text" name='arsocialshare_top_bottom_bar_y_position' id='arsocialshare_top_bottom_bar_y_position' class='arsocialshare_input_box' value='<?php echo isset($display_settings['arsocialshare_top_bottom_bar_y_position']) ? $display_settings['arsocialshare_top_bottom_bar_y_position'] : ''; ?>' /><span class='arsocialshare_network_note' style="left:5px;top:8px;"> px </span>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_option_container ars_column ars_no_border">
                            <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" />-->
                            <div class="ars_template_preview_container" id="arsocialshare_top_bottom_theme_preview" style="margin-top:-15px;display:none;<?php echo $page_checked . $popup_checked . $top_bottom_hide_show_checked; ?>">
                                <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $skin; ?>_theme arseffect_<?php echo $hovereffect; ?> <?php echo ($remove_space == 'yes') ? 'ars_remove_space' : ''; ?>">
                                    <div class='arsocialshare_button facebook ars_<?php echo $button_style; ?> arsocial_lite_facebook_wrapper ars_<?php echo $btn_style; ?>_btn' id='arsocialshare_facebook_btn' data-network="facebook">
                                        <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $skin; ?>_theme_icon socialshare-facebook'></span>
                                        <label class='arsocialshare_network_name'>Facebook</label>
                                        <span class='arsocialshare_counter arsocialshare_facebook_counter arsocialshare_counter_show_<?php echo $show_counter; ?>' id='arsocialshare_facebook_counter'>0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ars_template_preview_container ars_lite_sidebar_template_preview_container" id="arsocialshare_sidebar_theme_preview" style="margin-top:-15px;display:none;<?php echo $sidebar_checked; ?>">
                                <div class="arsocial_lite_buttons_container arsocialshare_fly_button_wrapper arsocial_lite_sidebar_button_wrapper  ars_<?php echo $sidebar_position; ?>_button">
                                    <div class="arsocialshare_buttons_wrapper arsocialshare_<?php echo $skin; ?>_theme arseffect_<?php echo $hovereffect; ?> <?php echo ($remove_space == 'yes') ? 'ars_remove_space' : ''; ?>">
                                        <?php foreach (array('facebook') as $sn): ?>
                                            <div class='arsocialshare_button <?php echo $sn; ?> ars_<?php echo $button_style; ?> arsocialshare_<?php echo $sn; ?>_wrapper ars_<?php echo $btn_style; ?>_btn' id='arsocialshare_<?php echo $sn; ?>_btn' data-network="<?php echo $sn; ?>">
                                                <span class='arsocialshare_network_btn_icon arsocialshare_<?php echo $skin; ?>_theme_icon socialshare-<?php echo $sn; ?>'></span>
                                                <label class='arsocialshare_network_name'><?php echo ucfirst($sn); ?></label>
                                                <span class='arsocialshare_counter arsocialshare_<?php echo $sn; ?>_counter arsocialshare_counter_show_<?php echo $show_counter; ?>' id='arsocialshare_<?php echo $sn; ?>_counter'>0</span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="arsocialshare_clear">&nbsp;</div>

                    </div>

                </div>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">4</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Custom CSS', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                </div>

                <div class="ars_network_list_container selected" style="width:100%;">
                    <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%; padding-top:0;  ">
                        <div class="arsocialshare_option_row" style="padding-bottom: 0px;">
                            <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Enter Custom CSS', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input arsocial_lite_custom_css_shortcode_restricted" style="width: 88%;">
                                <div class="arshare_opt_checkbox_row">
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                        <textarea name="arsocialshare_share_customcss" id="arsocialshare_share_customcss" class="ars_display_option_input" style="width:700px;height:200px;padding:5px 10px !important;" readonly="readonly"></textarea>
                                    </div>
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%; margin-top:10px; ">
                                        <span class='arsocial_lite_locker_note' style="width: 100%;">
                                            <?php echo "eg: .arsocial_lite_share_button_wrapper { background-color: #d1d1d1; }"; ?>
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

            </form>
        </div>
    </div>
    <div class="arsocial_lite_share_button_wrapper">
        <div class="ars_save_loader_bottom">&nbsp;
            <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
        </div>
        <button value="true" style="margin:15px 0px 0px 15px;" class="arsocialshare_save_display_settings" id="ars_share_shortcode_generator_btn" name="ars_share_shortcode_generator_btn" type="button"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
        <button value="true" class="arsocialshare_save_display_settings cancel_button bottom_button" id="ars_cancel_button" name="ars_cancel_button" type="button" onclick="location.href = '<?php echo admin_url('admin.php?page=arsocial-lite-shortcode-generator'); ?>'"><?php esc_html_e('Cancel', 'arsocial_lite'); ?></button>
    </div>
</div>
<div class="success-message" id="success-message">
</div>

<div class="ars_sticky_top_belt" id="ars_sticky_top_belt">
    <div class="arsocialshare_title_wrapper" style="margin-left: 13%;margin-top: 3%;">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Share Button Configuration', 'arsocial_lite'); ?></label>
    </div>
    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="sticky_belt_loader" />
    <div class="ars_share_wrapper" title="<?php esc_html_e('Click to copy', 'arsocial_lite'); ?>" style="<?php echo ($network_id !== '' && $arsocialaction !== 'duplicate') ? '' : 'display:none;' ?>" >
        <div class="ars_copied" style="position:absolute;top:7px;display:none;"><?php esc_html_e('Copied', 'arsocial_lite'); ?></div>
        <div class="ars_share_shortcode" id="ars_share_shortcode" data-code="[ARSocial_Lite_Share id=<?php echo $network_id; ?>]">
            [ARSocial_Lite_Share id=<?php echo $network_id; ?>]
        </div>
    </div>
    <button value="true" class="arsocialshare_save_display_settings shortcode_generator" id="ars_share_shortcode_generator_btn" name="ars_share_shortcode_generator_btn" type="button"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
    <button value="true" class="arsocialshare_save_display_settings cancel_button" id="ars_cancel_button" name="ars_cancel_button" type="button" onclick="location.href = '<?php echo admin_url('admin.php?page=arsocial-lite-shortcode-generator'); ?>'"><?php esc_html_e('Cancel', 'arsocial_lite'); ?></button>
</div>

<div class="ars_lite_upgrade_modal" id="ars_lite_pro_shortcode_premium_notice" style="display:none;">
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