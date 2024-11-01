<?php

class ARSocial_Lite_Form {

    function __construct() {

        /* For All Shortcode */
        add_shortcode('ARSocial_Lite_Share_Main', array($this, 'arsocialshare_shortcode'));

        /* For the shortcode which pass using id */
        add_shortcode('ARSocial_Lite_Share', array($this, 'arsocialshare_shortcode_networks'));

        /* Save ARSocialShare Networks Settings */
        add_action('wp_ajax_arsocial_lite_save_networks', array($this, 'arsocial_lite_save_networks'));

        add_action('wp_ajax_arsocial_lite_delete_network', array($this, 'arsocial_lite_delete_network'));

        add_action('wp_ajax_ars_lite_update_share_counter', array($this, 'arsocial_lite_update_share_counter'));
        add_action('wp_ajax_nopriv_ars_lite_update_share_counter', array($this, 'arsocial_lite_update_share_counter'));

        add_action('wp_ajax_doemail', array($this, 'arsocialshare_do_custom_email'));

        add_action('wp_ajax_nopriv_doemail', array($this, 'arsocialshare_do_custom_email'));

        add_action('wp_ajax_send_mail', array($this, 'arsocialshare_send_mail'));

        add_action('wp_ajax_nopriv_send_mail', array($this, 'arsocialshare_send_mail'));

        add_action('wp_ajax_ars_lite_update_network', array($this, 'arsocial_lite_update_network'));

        add_action('wp_ajax_ars_lite_network_active_deactive', array($this, 'arsocialshare_save_network'));
        add_action('wp_ajax_arsocial_lite_network_update_theme', array($this, 'arsocialshare_network_update_theme'));

        add_action('wp_ajax_ars_lite_savedisplaysettings', array($this, 'arsocialshare_network_save_display_settings'));

        /* Add button on page, post and custom post */
        add_filter('the_content', array($this, 'arsocialshare_filtered_content'));

        /* Add button on post excerpt */
        add_filter('get_the_excerpt', array($this, 'arsocial_lite_filtered_excerpt'));

        /* Add Social Share button after price in woocommerce */
        add_filter('woocommerce_get_price_html', array($this, 'arsocialshare_woocommerce_price_filter'));

        /* Display Social Share Button Before woocommerce Product */
        add_action('woocommerce_before_single_product', array($this, 'arsocialshare_woocommerce_before_single_product'));

        /* Display Social Share Button After woocommerce Product  */
        add_action('woocommerce_after_single_product', array($this, 'arsocialshare_woocommerce_after_single_product'));

        add_action('wp_ajax_arsocial_lite_get_more_networks', array($this, 'arsocial_lite_get_more_networks'));
        add_action('wp_ajax_nopriv_arsocial_lite_get_more_networks', array($this, 'arsocial_lite_get_more_networks'));

        add_action('wp_ajax_arsocial_lite_save_sharing_order', array($this, 'arsocial_lite_save_sharing_order'));

//        add_action('ars_before_share_networks', array($this, 'ars_pinterest_networks_content'), 10, 2);
		
		add_action('admin_init', array($this, 'upgrade_data'));

        add_action( 'wp_ajax_arslite_get_extended_token', array( $this, 'arsocialsharelite_fb_extended_token' ) );

    }

	function upgrade_data() {
        global $arslite_newdbversion;

        if (!isset($arslite_newdbversion) || $arslite_newdbversion == "")
            $arslite_newdbversion = get_option('arslite_version');

        if (version_compare($arslite_newdbversion, '1.4.1', '<')) {
             $path = ARSOCIAL_LITE_VIEWS_DIR . '/upgrade_latest_data.php';
             include($path);

        }
    }
	
    function arsocialshare_shortcode($atts) {
        global $wpdb, $arsocial_lite, $arsocial_lite_forms, $ars_lite_has_total_counter;

        $networks = isset($atts['networks']) ? $atts['networks'] : '';
        if ('' === $networks) {
            return esc_html__('No any network selected', 'arsocial_lite');
        }

        $fromdb = isset($atts['fromdb']) ? $atts['fromdb'] : false;

        $customnames = isset($atts['customnames']) ? $atts['customnames'] : '';
        $network_id = isset($atts['networkid']) ? $atts['networkid'] : '-100';

        $button_style = isset($atts['button_style']) ? $atts['button_style'] : 'name_with_icon';

        $more_btn_after = isset($atts['more_btn']) ? $atts['more_btn'] : '';
        $more_btn_style = isset($atts['more_btn_style']) ? $atts['more_btn_style'] : 'plus_icon';
        $more_btn_action = isset($atts['more_btn_action']) ? $atts['more_btn_action'] : 'display_inline';

        $more_buttons = array();
        $more_buttons['after'] = $more_btn_after;
        $more_buttons['style'] = $more_btn_style;
        $more_buttons['action'] = $more_btn_action;

        $button_width = isset($atts['button_width']) ? $atts['button_width'] : 'medium';

        $type = $is_sidebar = $is_fly_in = $is_popup = $is_display_top = $is_display_bottom = $is_mobile = $is_top_bottom_bar = "";
        $sidebar_attr = $popup_attr = $fly_in_attr = $mobile_attr = array();

        if (isset($atts['is_display_top']) && $atts['is_display_top'] === 'true') {
            $type = $is_display_top = "display_top";
        }
        if (isset($atts['is_display_bottom']) && $atts['is_display_bottom'] === 'true') {
            $type = $is_display_bottom = "display_bottom";
        }

        if (isset($atts['is_sidebar']) && $atts['is_sidebar'] === 'true') {
            $type = $is_sidebar = "sidebar";
            $sidebar_position = $atts['sidebar_position'] ? $atts['sidebar_position'] : "left";
            $sidebar_attr['is_sidebar'] = 'true';
            $sidebar_attr['sidebar_position'] = $sidebar_position;
            $sidebar_attr['sidebar_hover_effect'] = isset($atts['sidebar_hover_effect']) ? $atts['sidebar_hover_effect'] : '';
            if ($fromdb && $sidebar_attr['sidebar_hover_effect'] === '') {
                $sidebar_attr['sidebar_hover_effect'] = $atts['hover_effect'];
            }
            $sidebar_attr['sidebar_button_style'] = isset($atts['sidebar_button_style']) ? $atts['sidebar_button_style'] : $button_style;
            $sidebar_attr['remove_space'] = isset($atts['sidebar_remove_space']) ? $atts['sidebar_remove_space'] : '';
            $button_width = isset($atts['sidebar_button_width']) ? $atts['sidebar_button_width'] : 'medium';
            $more_buttons['after'] = $atts['sidebar_more_button'];
            $more_buttons['style'] = $atts['sidebar_more_button_style'];
            $more_buttons['action'] = $atts['sidebar_more_button_action'];
        }

        if (isset($atts['is_popup']) && $atts['is_popup'] === 'true') {
            $type = $is_popup = "popup";
            $popup_attr['is_popup'] = 'true';

            if ((isset($atts['popup_display_popup_on']) && $atts['popup_display_popup_on'] == 'onscroll')) {
                $atts['popup_onload_type'] = 'popup_onscroll';
                $popup_attr['popup_open_scroll'] = isset($atts['popup_scroll_value']) ? $atts['popup_scroll_value'] : "50";
            } else {
                $atts['popup_onload_type'] = 'popup_onload';
                $popup_attr['popup_open_delay'] = isset($atts['popup_loading_value']) ? $atts['popup_loading_value'] : "";
            }
            $popup_attr['popup_type'] = isset($atts['popup_onload_type']) ? $atts['popup_onload_type'] : "popup_onload";
            $popup_attr['popup_width'] = isset($atts['popup_width']) ? $atts['popup_width'] : "";
            $popup_attr['popup_height'] = isset($atts['popup_height']) ? $atts['popup_height'] : "";
            $popup_attr['popup_close_button'] = isset($atts['popup_close_button']) ? $atts['popup_close_button'] : "";
            $button_width = isset($atts['popup_btn_width']) ? $atts['popup_btn_width'] : 'medium';
            $button_style = isset($atts['popup_btn_style']) ? $atts['popup_btn_style'] : 'name_with_icon';
        }


        if (isset($atts['is_top_bottom_bar']) && $atts['is_top_bottom_bar'] === 'true') {

            $type = $is_top_bottom_bar = "top_bottom_bar";
            $top_bottom_bar_attr = $atts;
            $top_bottom_bar_attr['is_top_bottom_bar'] = 'true';
            if ((isset($atts['top_bottom_bar_display_bar_on']) && $atts['top_bottom_bar_display_bar_on'] == 'onscroll')) {
                $top_bottom_bar_attr['top_bottom_bar_scroll_value'] = $atts['top_bottom_bar_scroll_value'] ? $atts['top_bottom_bar_scroll_value'] : "50";
            } else {
                $top_bottom_bar_attr['top_bottom_bar_loading_value'] = $atts['top_bottom_bar_loading_value'] ? $atts['top_bottom_bar_loading_value'] : "0";
            }
            $button_width = isset($atts['top_bottom_bar_button_width']) ? $atts['top_bottom_bar_button_width'] : 'medium';
            $remove_space = isset($atts['top_bottom_bar_remove_space']) ? $atts['top_bottom_bar_remove_space'] : 'no';
        }


        if (isset($atts['is_mobile']) && $atts['is_mobile'] === 'true') {
            $type = $is_mobile = "mobile";
            $mobile_attr['is_mobile'] = 'true';
            $mobile_attr['mobile_display_type'] = $atts['mobile_display_type'];
        }


        $arsocial_lite->ars_common_enqueue_js_css();
        wp_enqueue_script('ars-lite-share-front-js');


        $theme = isset($atts['theme']) ? $atts['theme'] : '';

        if ($type === 'sidebar' && $theme === 'rolling') {
            wp_enqueue_style('arsocial_lite_theme-default');
        }

        wp_enqueue_style('arsocial_lite_theme-' . $theme);

        $post_id = get_the_ID();

        $total_counter = array();
        $is_total_share = (isset($atts['is_total_share']) && $atts['is_total_share'] === 'yes' ) ? true : false;
        $total_share_label = (isset($atts['total_share_label']) && $atts['total_share_label'] !== '' ) ? $atts['total_share_label'] : 'SHARES';
        $total_count_position = (isset($atts['total_count_position'])) ? $atts['total_count_position'] : 'left';

        if ($is_total_share == true) {
            $ars_lite_has_total_counter = true;
        }

        $total_counter['enable_total_counter'] = $is_total_share;
        $total_counter['total_counter_label'] = $total_share_label;
        $total_counter['total_count_position'] = $total_count_position;

        $number_format = isset($atts['no_format']) ? $atts['no_format'] : '';

        $return_network = '';
        if ($is_sidebar) {
            $return_network .= $this->arsocialshare_normal_buttons($networks, $theme, $fromdb, $customnames, $post_id, $network_id, $button_style, $more_buttons, $button_width, 'sidebar', $sidebar_attr, $atts, $total_counter, $number_format);
        }
        if ($is_fly_in) {
            $return_network .= $this->arsocialshare_normal_buttons($networks, $theme, $fromdb, $customnames, $post_id, $network_id, $button_style, $more_buttons, $button_width, 'fly_in', $fly_in_attr, $atts, $total_counter, $number_format);
        }
        if ($is_popup) {

            $return_network .= $this->arsocialshare_normal_buttons($networks, $theme, $fromdb, $customnames, $post_id, $network_id, $button_style, $more_buttons, $button_width, 'popup', $popup_attr, $atts, $total_counter, $number_format);
        }
        if ($is_mobile) {
            $return_network .= $this->arsocialshare_normal_buttons($networks, $theme, $fromdb, $customnames, $post_id, $network_id, $button_style, $more_buttons, $button_width, 'mobile', $mobile_attr, $atts, $total_counter, $number_format);
        }

        if ($is_display_top || $is_display_bottom) {
            $return_network .= $this->arsocialshare_normal_buttons($networks, $theme, $fromdb, $customnames, $post_id, $network_id, $button_style, $more_buttons, $button_width, 'normal', array(), $atts, $total_counter, $number_format);
        }

        if ($is_top_bottom_bar) {
            $return_network .= $this->arsocialshare_normal_buttons($networks, $theme, $fromdb, $customnames, $post_id, $network_id, $button_style, $more_buttons, $button_width, 'top_bottom_bar', $top_bottom_bar_attr, $atts, $total_counter, $number_format);
        }
        return $return_network;
    }

    function arsocialshare_shortcode_networks($atts) {
        global $wpdb,$arsocial_lite;
        $id = isset($atts['id']) ? $atts['id'] : '';
        if ('' === $id) {
            return esc_html__('Invalid Network ID', 'arsocial_lite');
        }
        $table = $arsocial_lite->arslite_networks;
        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$table` WHERE network_id = %d", $id));
        if (empty($result)) {
            return esc_html__('', 'arsocial_lite');
        }

        $networks = maybe_unserialize($result->network_settings);
        $display_settings = maybe_unserialize($result->display_settings);

        $display_type = isset($display_settings['arsocialshare_display_type']) ? $display_settings['arsocialshare_display_type'] : 'on_page';
        $more_btn_after = isset($display_settings['arsocialshare_share_settings_more_button']) ? $display_settings['arsocialshare_share_settings_more_button'] : '0';
        $more_btn_style = isset($display_settings['arsocialshare_share_more_button_style']) ? $display_settings['arsocialshare_share_more_button_style'] : 'plus_icon';
        $more_btn_action = isset($display_settings['arsocialshare_share_more_button_action']) ? $display_settings['arsocialshare_share_more_button_action'] : 'display_inline';

        $button_witdh_type = isset($display_settings['arsocialshare_share_button_width']) ? $display_settings['arsocialshare_share_button_width'] : 'automatic';
        $fixed_btn_width = (isset($display_settings['arsocialshare_share_settings_fixed_button_width']) && $display_settings['arsocialshare_share_settings_fixed_button_width'] !== '') ? $display_settings['arsocialshare_share_settings_fixed_button_width'] : "0";
        $full_button_width = (isset($display_settings['arsocialshare_share_settings_full_button_width_desktop']) && $display_settings['arsocialshare_share_settings_full_button_width_desktop'] !== '') ? $display_settings['arsocialshare_share_settings_full_button_width_desktop'] : "0";

        $button_skin = isset($display_settings['arsocialshare_share_settings_skins']) ? $display_settings['arsocialshare_share_settings_skins'] : 'default';
        $button_style = isset($display_settings['arsocialshare_share_button_style']) ? $display_settings['arsocialshare_share_button_style'] : 'name_with_icon';
        $show_counter = isset($display_settings['arsocialshare_share_show_count']) ? $display_settings['arsocialshare_share_show_count'] : '';
        $hover_effect = isset($display_settings['arsocialshare_share_hover_effect']) ? $display_settings['arsocialshare_share_hover_effect'] : '';

        $remove_space = isset($display_settings['arsocialshare_share_remove_space']) ? $display_settings['arsocialshare_share_remove_space'] : 'no';
        $ars_btn_align = isset($display_settings['ars_btn_align']) ? $display_settings['ars_btn_align'] : 'center';
        $ars_btn_align = explode('_', $ars_btn_align);
        $shortcode_argument = '';

        $enable_total_count = isset($display_settings['enable_total_counter']) ? $display_settings['enable_total_counter'] : false;
        $total_count_label = isset($display_settings['arsocial_total_share_label']) ? $display_settings['arsocial_total_share_label'] : 'SHARES';
        $total_count_position = isset($display_settings['total_counter_position']) ? $display_settings['total_counter_position'] : 'left';

        $number_format = isset($display_settings['no_format']) ? $display_settings['no_format'] : '';

        switch ($display_type) {
            case 'on_page':
                if (wp_is_mobile() && isset($display_settings['arsocialshare_mobile_hide']) && $display_settings['arsocialshare_mobile_hide'] == 'yes') {
                    return;
                }
                break;

            case 'sidebar':
                $sidebar_position = isset($display_settings['arsocialshare_sidebar']) ? $display_settings['arsocialshare_sidebar'] : '';
                $total_count_position = 'top';
                if (wp_is_mobile() && isset($display_settings['arsocialshare_mobile_hide']) && $display_settings['arsocialshare_mobile_hide'] == 'yes') {
                    return;
                }
                $shortcode_argument = " is_sidebar='true' sidebar_position='$sidebar_position' sidebar_remove_space='$remove_space' sidebar_hover_effect='$hover_effect' sidebar_button_width='$button_witdh_type' sidebar_more_button='$more_btn_after' sidebar_more_button_style='$more_btn_style' sidebar_more_button_action='$more_btn_action' ";
                break;
            case 'fly_in':
                $fly_in = 'true';
                $fly_in_position = isset($display_settings['arsocialshare_fly_position']) ? $display_settings['arsocialshare_fly_position'] : '';
                $fly_in_type = isset($display_settings['arsocialshare_fly_in_onload_type']) ? $display_settings['arsocialshare_fly_in_onload_type'] : '';
                $fly_in_open_delay = isset($display_settings['arsocialshare_fly_in_open_delay']) ? $display_settings['arsocialshare_fly_in_open_delay'] : '';
                $fly_in_open_scroll = isset($display_settings['arsocialshare_fly_in_open_scroll']) ? $display_settings['arsocialshare_fly_in_open_scroll'] : '';
                $fly_in_width = isset($display_settings['fly_in_width']) ? $display_settings['fly_in_width'] : '';
                $fly_in_height = isset($display_settings['fly_in_height']) ? $display_settings['fly_in_height'] : '';
                $fly_in_is_close_button = isset($display_settings['arsocialshare_fly_in_is_close']) ? 'true' : 'false';
                if (wp_is_mobile() && isset($display_settings['arsocialshare_mobile_hide']) && $display_settings['arsocialshare_mobile_hide'] == 'yes') {
                    break;
                } else {
                    $shortcode_argument = " is_fly_in='$fly_in' fly_in_position='$fly_in_position' fly_in_type='$fly_in_type'  fly_in_open_scroll='$fly_in_open_scroll'  fly_in_width='$fly_in_width' fly_in_height='$fly_in_height' fly_in_close_button='$fly_in_is_close_button'";
                    if ($fly_in_type == 'fly_in_onload') {
                        $shortcode_argument = " is_fly_in='$fly_in' fly_in_position='$fly_in_position' fly_in_type='$fly_in_type' fly_in_open_delay='$fly_in_open_delay'   fly_in_width='$fly_in_width' fly_in_height='$fly_in_height' fly_in_close_button='$fly_in_is_close_button'";
                    }
                }
                break;

            case 'popup':
                $popup = 'true';
                $popup_type = isset($display_settings['arsocialshare_onload_type']) ? $display_settings['arsocialshare_onload_type'] : '';

                $popup_open_delay = isset($display_settings['arsocialshare_open_delay']) ? $display_settings['arsocialshare_open_delay'] : '';
                $popup_open_scroll = isset($display_settings['arsocialshare_open_scroll']) ? $display_settings['arsocialshare_open_scroll'] : '';
                $popup_width = isset($display_settings['popup_width']) ? $display_settings['popup_width'] : '';
                $popup_height = isset($display_settings['popup_height']) ? $display_settings['popup_height'] : '';
                $popup_is_close_button = isset($display_settings['arsocialshare_pop_show_close_button']) && $display_settings['arsocialshare_pop_show_close_button'] == 'yes' ? 'yes' : 'no';
                if (wp_is_mobile() && isset($display_settings['arsocialshare_mobile_hide']) && $display_settings['arsocialshare_mobile_hide'] == 'yes') {
                    return;
                } else {
                    $shortcode_argument = " is_popup='$popup' popup_display_popup_on=$popup_type popup_open_delay='$popup_open_delay'  popup_width='$popup_width' popup_height='$popup_height' popup_close_button='$popup_is_close_button' popup_hover_effect='$hover_effect' popup_remove_space='$remove_space' popup_btn_style='$button_style' popup_btn_width='$button_witdh_type'";
                    $popup_custom_css = isset($display_settings['arsocialshare_custom_css']) ? $display_settings['arsocialshare_custom_css'] : '';
                    if ($popup_type == 'onscroll') {
                        $shortcode_argument = " is_popup='$popup' popup_display_popup_on=$popup_type  popup_scroll_value='$popup_open_scroll' popup_width='$popup_width' popup_height='$popup_height' popup_close_button='$popup_is_close_button' popup_hover_effect='$hover_effect' popup_remove_space='$remove_space' popup_btn_width='$button_witdh_type' popup_btn_style='$button_style'";
                    }
                }
                break;
            case 'top_bottom_bar':

                $top_bottom_bar = 'true';
                $top_bottom_bar_type = isset($display_settings['arsocialshare_top_bottom_bar_display_on']) ? $display_settings['arsocialshare_top_bottom_bar_display_on'] : '';
                $top_bottom_bar_open_delay = isset($display_settings['arsocialshare_top_bottom_bar_onload_time']) ? $display_settings['arsocialshare_top_bottom_bar_onload_time'] : '';
                $top_bottom_bar_open_scroll = isset($display_settings['arsocialshare_top_bottom_bar_onscroll_percentage']) ? $display_settings['arsocialshare_top_bottom_bar_onscroll_percentage'] : '';
                $top_bottom_bar_y_position = isset($display_settings['arsocialshare_top_bottom_bar_y_position']) ? $display_settings['arsocialshare_top_bottom_bar_y_position'] : 0;
                $is_top_bar = '';
                $is_bottom_bar = '';
                if (isset($display_settings['arsocialshare_top_bar']) && $display_settings['arsocialshare_top_bar'] == 'bottom_bar') {
                    $is_bottom_bar = '1';
                } else {
                    $is_top_bar = '1';
                }
                if (wp_is_mobile() && isset($display_settings['arsocialshare_mobile_hide']) && $display_settings['arsocialshare_mobile_hide'] == 'yes') {
                    return;
                } else {
                    if (isset($display_settings['arsocialshare_top_bar']) && $display_settings['arsocialshare_top_bar'] == 'bottom_bar') {
                        $shortcode_argument = " is_top_bottom_bar='$top_bottom_bar' display_bottom='1' top_bottom_bar_display_bar_on='$top_bottom_bar_type' top_bottom_bar_scroll_value='$top_bottom_bar_open_scroll'  top_bottom_bar_loading_value='$top_bottom_bar_open_delay' top_bottom_bar_btn_alignment='$ars_btn_align[2]' top_bottom_bar_remove_space='$remove_space' top_bottom_bar_hover_effect='$hover_effect' top_bottom_bar_button_style='$button_style' top_bottom_bar_button_width='$button_witdh_type'";
                    } else {
                        $shortcode_argument = " is_top_bottom_bar='$top_bottom_bar' display_top='1' top_bottom_bar_display_bar_on='$top_bottom_bar_type' top_bottom_bar_scroll_value='$top_bottom_bar_open_scroll' top_bottom_bar_loading_value='$top_bottom_bar_open_delay' top_bottom_bar_y_point='{$top_bottom_bar_y_position}' top_bottom_bar_btn_alignment='$ars_btn_align[2]' top_bottom_bar_remove_space='$remove_space' top_bottom_bar_hover_effect='$hover_effect' top_bottom_bar_button_style='$button_style' top_bottom_bar_button_width='$button_witdh_type'";
                    }
                }

                break;
        }

        $customnames = $networks['custom_name'];
        $cstmnames = "";
        if (!empty($customnames) && is_array($customnames)) {
            foreach ($customnames as $key => $name) {
                $cstmnames .= $key . '||' . $name . '|~|';
            }
        }
        $cstmnames = rtrim($cstmnames, '|~|');

        $networks = implode('|', $networks['enabled_network']);

        $shortcode = "[ARSocial_Lite_Share_Main networks={$networks} theme=" . $display_settings['arsocialshare_share_settings_skins'] . " fromdb=true customnames='{$cstmnames}' networkid='{$id}' remove_space='{$remove_space}' is_total_share='{$enable_total_count}' total_share_label='{$total_count_label}' total_count_position='{$total_count_position}' no_format='{$number_format}' ";

        if ($display_type == 'on_page') {
            $shortcode .= " is_display_top='true' ";
        }

        $shortcode .= " theme=$button_skin button_style=$button_style show_counter='{$show_counter}' hover_effect='{$hover_effect}'";
        $shortcode .= " more_btn=$more_btn_after more_btn_style=$more_btn_style more_btn_action=$more_btn_action";
        $shortcode .= " button_width=$button_witdh_type fixed_btn_width=$fixed_btn_width full_button_width=$full_button_width";
        $shortcode .= $shortcode_argument;

        $shortcode .= "]";

        $return_content = '';

        $return_content .= '<div class="arsocial_lite_share_button_wrapper arsocialshare_network_button_settings arsocialshare_align_' . $ars_btn_align[2] . '  arsocialshare_button_'.$display_type.'" id="arsocial_lite_share_button_wrapper">';
        $return_content .= do_shortcode($shortcode);
        $return_content .= '</div>';

        return $return_content;
    }

    function arsocialshare_normal_buttons($networks, $theme, $fromdb, $customnames, $post_id, $network_id, $button_style, $more_buttons = array(), $button_width = 'medium', $type, $attr = array(), $shortcodeArgs = array(), $total_counter = array(), $number_format = 'style5') {
        global $arsocial_lite_counter, $arsocial_lite;

        $networks = rtrim($networks, '|');
        $networks = explode('|', $networks);
        $counter_networks = $arsocial_lite->ars_lite_share_networklist_sharecounter();
        if ($fromdb) {
            $default_networks = $arsocial_lite->ARSocialShareDefaultNetworks();
            $ars_lite_default_networks = $default_networks['networks'];
            $saved_networks = maybe_unserialize(get_option('arslite_settings'));
            $saved_networks = $saved_networks['networks'];
            $custom_names = explode('|~|', $customnames);
            $customnm = array();
            foreach ($custom_names as $cnm => $cnms) {
                $name = explode('||', $cnms);
                $customnm[$name[0]] = $name[1];
            }

            $dbnetworks = array();
            foreach ($networks as $key => $network) {
                $newsavednetworks[$network]['enable'] = 1;
                $newsavednetworks[$network]['custom_name'] = $customnm[$network];
                $newsavednetworks[$network]['plateform'] = $ars_lite_default_networks[$network]['plateform'];
            }
            $saved_networks = $newsavednetworks;
        } else {

            $saved_networks = maybe_unserialize(get_option('arslite_settings'));
            $networks_option = maybe_unserialize(get_option('arslite_networks_display_setting'));
            $networks_option = $networks_option['network_display_name'];
            foreach ($networks as $key => $network) {
                $newsavednetworks[$network]['enable'] = 1;
                $newsavednetworks[$network]['custom_name'] = (isset($networks_option[$network]['display_name']) && $networks_option[$network]['display_name']) ? $networks_option[$network]['display_name'] : $saved_networks['networks'][$network]['custom_name'];
                $newsavednetworks[$network]['plateform'] = @$saved_networks['networks'][$network]['plateform'];
            }
            $saved_networks = $newsavednetworks;
        }

        $data_custom_names = array();
        foreach ($saved_networks as $key => $value) {
            $data_custom_names[$key] = $value['custom_name'];
        }

        if ($theme === '' || empty($theme) || $theme === NULL) {
            $theme = get_option('arslite_selected_theme');
        }

        $hover_effect = isset($shortcodeArgs['hover_effect']) ? $shortcodeArgs['hover_effect'] : '';
        $remove_space = (isset($shortcodeArgs['remove_space']) && $shortcodeArgs['remove_space'] == 'yes') ? 'ars_remove_space' : '';
        $show_counter = isset($shortcodeArgs['show_counter']) ? $shortcodeArgs['show_counter'] : 'yes';

        //JD
        $html = $closeBtn = '';
        $data_class = '';
        $data_attr = '';
        if (isset($attr) && !empty($attr)) {
            foreach ($attr as $data_key => $data_val) {
                $data_attr .= "data-" . $data_key . "='" . $data_val . "' ";
            }
        }

        if ($type == 'sidebar') {
            $hover_effect = isset($shortcodeArgs['sidebar_hover_effect']) ? $shortcodeArgs['sidebar_hover_effect'] : '';
            $button_style = isset($shortcodeArgs['sidebar_button_style']) ? $shortcodeArgs['sidebar_button_style'] : $button_style;
            $position = isset($shortcodeArgs['sidebar_position']) ? $shortcodeArgs['sidebar_position'] : 'left';
            $data_class = "arsocial_lite_sidebar_button_wrapper  ars_{$position}_button";
            $data_attr = " id='arsocial_lite_sidebar_button_wrapper' " . $data_attr;
            $closeBtn .= "<div class='arsocialshare_fly_button_toggle_switch toggle_on'></div>";
            $remove_space = (isset($shortcodeArgs['sidebar_remove_space']) && $shortcodeArgs['sidebar_remove_space'] === 'yes' ) ? 'ars_remove_space' : '';
        }

        if ($type == 'popup') {
            $hover_effect = isset($shortcodeArgs['popup_hover_effect']) ? $shortcodeArgs['popup_hover_effect'] : '';
            $button_style = isset($shortcodeArgs['popup_button_style']) ? $shortcodeArgs['popup_button_style'] : $button_style;
            $popup_style = '';
            if (isset($attr['popup_width']) && !empty($attr['popup_width'])) {
                $popup_style .= "width:" . $attr['popup_width'] . "px;";
            }
            if (isset($attr['popup_height']) && !empty($attr['popup_height'])) {
                $popup_style .= " height:" . $attr['popup_height'] . "px;";
            }
            $data_class = "arsocialshare_popup_wrapper arsocial_lite_popup_button_wrapper";
            $data_attr = " id='arsocialshare_popup_wrapper' " . $data_attr . " style='{$popup_style}'";
            if (isset($attr['popup_close_button']) && $attr['popup_close_button'] === 'yes') {
                $closeBtn = "<div class='arsocialshare_popup_close' id='arsocial_lite_popup_wrapper_close'><span></span></div>";
            }

            $remove_space = (isset($shortcodeArgs['popup_remove_space']) && $shortcodeArgs['popup_remove_space'] === 'yes' ) ? 'ars_remove_space' : '';

            $more_buttons = array();
        }
        $networkid = $network_id;
        $global_settings = maybe_unserialize(get_option('arslite_global_settings'));
        $html .= $arsocial_lite->ars_get_enqueue_fonts('share');
        if ($type == 'mobile') {
            $button_style = 'icon_without_name';
            if (isset($attr['mobile_display_type']) && $attr['mobile_display_type'] == 'share_button_bar') {
                $html .= "<div class='arsocial_lite_share_button_bar_wrapper' id='arsocial_lite_share_button_bar_wrapper'  " . $data_attr . "  style=''>";
                $html .= "<img src='" . ARSOCIAL_LITE_IMAGES_URL . "/ars_share_icon.png' style='opacity:1'>";
                $html .= $shortcodeArgs['mobile_bottom_bar_label'];
                $html .= "</div>";
            }
            if (isset($attr['mobile_display_type']) && $attr['mobile_display_type'] == 'share_footer_icons') {
                $html .= "<div class='arsocialshare_footer_icons'>";
                $html .= "<div class='arsocial_lite_buttons_container {$data_class}' {$data_attr} >";
                $html .= "<div class='arsocialshare_buttons_wrapper arsocialshare_{$theme}_theme arseffect_{$hover_effect} {$remove_space}' style='margin:0;'>";
                $n = 1;
                $total_network = sizeof($networks);
                $ars_width_class = 'ars_more_than_six';
                if ($total_network == '1') {
                    $ars_width_class = 'ars_one_button';
                } else if ($total_network == '2') {
                    $ars_width_class = 'ars_two_button';
                } else if ($total_network == '3') {
                    $ars_width_class = 'ars_three_button';
                } else if ($total_network == '4') {
                    $ars_width_class = 'ars_four_button';
                } else if ($total_network == '5') {
                    $ars_width_class = 'ars_five_button';
                } else if ($total_network == '6') {
                    $ars_width_class = 'ars_six_button';
                }
                $i = 1;
                foreach ($networks as $key => $network) {
                    if ($i <= 5 || $total_network == 6) {
                        if (isset($saved_networks[$network]['enable']) && $saved_networks[$network]['enable']) {
                            $network_api_url = $this->arsocialshare_url($network);
                            $media_url = $this->get_media_url($post_id);

                            $shorturl = $this->get_permalink();

                            if (@in_array('desktop', $saved_networks[$network]['plateform'])) {
                                $html .= "<div class='arsocialshare_button $network ars_$button_style arsocial_lite_{$network}_wrapper ars_large_btn $ars_width_class' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' onclick='javascript:arsocialshare_window(\"{$network_api_url}\",\"{$shorturl}\",\"{$this->get_page_title()}\",\"{$network}\",\"{$post_id}\",\"{$media_url}\",jQuery(this))'>";
                                $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$theme}_theme_icon arsocial_lite_{$network}_icon socialshare-{$network}' id='arsocial_lite_{$network}_icon'></span>";
                                $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";
                                if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                                    $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                                } else {
                                    $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                                }
                                $html .= "</div>";
                            } else {
                                if (wp_is_mobile()) {
                                    $html .= "<div class='arsocialshare_button {$network} ars_$button_style arsocial_lite_{$network}_wrapper ars_large_btn $ars_width_class' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' >";
                                    $html .= "<a href='" . $this->get_share_url($network) . "'>";
                                    $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$theme}_theme_icon arsocial_lite_{$network}_icon socialshare-{$network}'></span>";
                                    $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";

                                    if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                                        $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                                    } else {
                                        $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                                    }
                                    $html .= "</a>";
                                    $html .= "</div>";
                                }
                            }
                        }
                    }
                    $n++;
                    $i++;
                }
                if ($total_network > 6) {
                    $html .= "<div class='arsocial_lite_more_button_icon $button_style ars_large_btn $ars_width_class' id='arsocialshare_mobile_button_icon'>";
                    $morebtncls = ($shortcodeArgs['mobile_more_button_type'] === 'plus_icon') ? "socialshare-plus" : "socialshare-dot-3";
                    $html .= "<span class='arsocial_lite_more_btn_icon $morebtncls'></span>";
                    $html .= "</div>";
                }
                $html .= "</div>";
                $html .= "</div>";
                $html .= "</div>";
                if ($total_network > 6) {
                    $html .="<div id='arsocialshare_mobile_wrapper' class='arsocialshare_mobile_wrapper' " . $data_attr . ">";

                    $html .= "<div class='arsocialshare_mobile_close' id='arsocialshare_mobile_close'><span><img src='" . ARSOCIAL_LITE_IMAGES_URL . "/ars_close.png'></span></div>";
                    $html .= "<div class='arsocial_lite_buttons_container {$data_class}' {$data_attr} >";
                    $html .= "<div class='arsocialshare_buttons_wrapper arsocialshare_{$theme}_theme arseffect_{$hover_effect}' style='margin:0;'>";
                    foreach ($networks as $key => $network) {

                        if (isset($saved_networks[$network]['enable']) && $saved_networks[$network]['enable']) {
                            $network_api_url = $this->arsocialshare_url($network);
                            $media_url = $this->get_media_url($post_id);
                                
                            $shorturl = $this->get_permalink();

                            if (@in_array('desktop', $saved_networks[$network]['plateform'])) {
                                $html .= "<div class='arsocialshare_button $network ars_$button_style arsocial_lite_{$network}_wrapper ars_large_btn $ars_width_class' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' onclick='javascript:arsocialshare_window(\"{$network_api_url}\",\"{$shorturl}\",\"{$this->get_page_title()}\",\"{$network}\",\"{$post_id}\",\"{$media_url}\",jQuery(this))'>";
                                $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$theme}_theme_icon arsocial_lite_{$network}_icon socialshare-{$network}' id='arsocial_lite_{$network}_icon'></span>";
                                $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";
                                if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                                    $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                                } else {
                                    $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                                }
                                $html .= "</div>";
                            } else {
                                if (!wp_is_mobile()) {
                                    $n = $n - 2;
                                }
                                if (wp_is_mobile()) {
                                    $html .= "<div class='arsocialshare_button {$network} ars_$button_style arsocial_lite_{$network}_wrapper ars_large_btn $ars_width_class' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' >";
                                    $html .= "<a href='" . $this->get_share_url($network) . "'>";
                                    $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$theme}_theme_icon arsocial_lite_{$network}_icon socialshare-{$network}'></span>";
                                    $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";

                                    if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                                        $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                                    } else {
                                        $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                                    }
                                    $html .= "</a>";
                                    $html .= "</div>";
                                }
                            }
                        }
                    }
                    $n++;
                    $html .= "</div>";
                    $html .= "</div>";
                    $html .= "</div>";
                }
                return $html;
            }

            if (isset($attr['mobile_display_type']) && ($attr['mobile_display_type'] == 'share_point')) {
                $html .= "<div class='arsocialshare_share_point_wrapper share_" . $shortcodeArgs['mobile_share_point_position'] . "_point' id='arsocialshare_share_point_wrapper' " . $data_attr . "  style=''>";
                $html .= "<img src='" . ARSOCIAL_LITE_IMAGES_URL . "/ars_share_icon.png'>";
                $html .= "</div>";
            }
            if (isset($attr['mobile_display_type']) && $attr['mobile_display_type'] != 'share_footer_icons') {
                $data_class = "arsocialshare_mobile_wrapper";
                $data_attr = " id='arsocialshare_mobile_wrapper' " . $data_attr . "";
                $closeBtn = "<div class='arsocialshare_mobile_close' id='arsocialshare_mobile_close'><span><img src='" . ARSOCIAL_LITE_IMAGES_URL . "/close_icon.png'></span></div>";
                $remove_space = 'yes';
            }
        }

        if ($type == 'top_bottom_bar') {

            $y_point = isset($shortcodeArgs['top_bottom_bar_y_point']) ? $shortcodeArgs['top_bottom_bar_y_point'] : '0';
            $hover_effect = isset($shortcodeArgs['top_bottom_bar_hover_effect']) ? $shortcodeArgs['top_bottom_bar_hover_effect'] : '';
            $button_style = isset($shortcodeArgs['top_bottom_bar_button_style']) ? $shortcodeArgs['top_bottom_bar_button_style'] : '';

            $top_bottom_bar_style = 'display:none;';
            $top_class = '';
            $bottom_class = '';
            $top_bottom_id = '';
            $y_point_class = '';
            if (isset($shortcodeArgs['display_bottom']) && !empty($shortcodeArgs['display_bottom'])) {
                $bottom_class = 'arsocialshare_bottom_bar_wrapper arsocial_lite_bottombar_wrapper';
                $top_bottom_id = 'arsocial_lite_share_top_bottom_bar_wrapper';
            }

            if (isset($shortcodeArgs['display_top']) && !empty($shortcodeArgs['display_top'])) {
                $top_class = ' arsocialshare_top_bar_wrapper arsocial_lite_topbar_wrapper ';
                $top_bottom_id = 'arsocial_lite_share_top_bottom_bar_wrapper';
                $y_point_class = 'margin-top:' . $y_point . 'px;';
            }

            $data_class = "arsocial_lite_share_top_bottom_bar_wrapper $bottom_class $top_class";
            $remove_space = (isset($shortcodeArgs['top_bottom_bar_remove_space']) && $shortcodeArgs['top_bottom_bar_remove_space'] === 'yes' ) ? 'ars_remove_space' : '';
            $data_attr = " id='$top_bottom_id' " . $data_attr . " style='{$top_bottom_bar_style}{$y_point_class}'";
        }

        $html .= $arsocial_lite->ars_get_enqueue_fonts('share');

        $html .= "<div class='arsocial_lite_buttons_container {$data_class}' {$data_attr} >";
        $html .= $closeBtn;


        $options = array_merge($shortcodeArgs, array('saved_networks' => $saved_networks));
        
        $html .= "<input type='hidden' name= 'arsocialshare_options' id='arsocialshare_options' value='" . json_encode($options) . "' />";
        $html .= "<div class='arsocialshare_buttons_wrapper arsocialshare_{$theme}_theme arseffect_{$hover_effect} {$remove_space}' data-options='" . json_encode($options) . "'>";
        $html .= "<div id='arsocialshare_pocket_button'></div>";
        $html .= "<input type='hidden' id='arsocialshare_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";
        $html .= "<input type='hidden' id='arsocialshare_user_ip_address' value='" . $_SERVER['REMOTE_ADDR'] . "' />";
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $networkid = $network_id;
        if (!isset($saved_networks['arsprint']) && !empty($saved_networks['print'])) {
            $saved_networks['arsprint'] = $saved_networks['print'];
            unset($saved_networks['print']);
        } else {
            $saved_networks['arsprint']['plateform'] = array('desktop', 'mobile');
        }
        $global_settings = maybe_unserialize(get_option('arslite_global_settings'));
        $n = 1;
        $include_in_more = array();
        $btn_width = 'ars_' . $button_width . '_btn';

        if ($total_counter['enable_total_counter'] && ($total_counter['total_count_position'] === 'left' || $total_counter['total_count_position'] === 'top' )) {
            $html .= apply_filters('arsocial_lite_total_share_counter', $html, $total_counter, $saved_networks, $networks, $post_id, $number_format);
        }
        if (!wp_is_mobile()) {
            foreach ($networks as $key => $network) {
                if (is_array($saved_networks[$network]['plateform'])) {
                    if (!in_array('desktop', $saved_networks[$network]['plateform'])) {
                        unset($networks[$key]);
                    }
                }
            }
        }

        foreach ($networks as $key => $network) {
            if (isset($saved_networks[$network]['enable']) && $saved_networks[$network]['enable']) {
                $network_api_url = $this->arsocialshare_url($network);
                $media_url = $this->get_media_url($post_id);
                    
                $shorturl = $this->get_permalink();

                if (@in_array('desktop', $saved_networks[$network]['plateform'])) {
                    $html .= "<div class='arsocialshare_button $network ars_$button_style arsocial_lite_{$network}_wrapper $btn_width' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' onclick='javascript:arsocialshare_window(\"{$network_api_url}\",\"{$shorturl}\",\"{$this->get_page_title()}\",\"{$network}\",\"{$post_id}\",\"{$media_url}\",jQuery(this))'>";
                    $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$theme}_theme_icon arsocial_lite_{$network}_icon socialshare-{$network}' id='arsocial_lite_{$network}_icon'></span>";
                    $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";
                    if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                        $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                    } else {
                        $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                    }
                    $html .= "</div>";
                } else {
                    if (wp_is_mobile()) {
                        $html .= "<div class='arsocialshare_button {$network} $btn_width ars_$button_style arsocial_lite_{$network}_wrapper $btn_width' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' >";
                        $html .= "<a href='" . $this->get_share_url($network) . "'>";
                        $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$theme}_theme_icon arsocial_lite_{$network}_icon socialshare-{$network}'></span>";
                        $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";

                        if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                            $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                        } else {
                            $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                        }
                        $html .= "</a>";
                        $html .= "</div>";
                    }
                }

                array_push($include_in_more, $network);
                if (!empty($more_buttons)) {
                    if ($more_buttons !== '' && $more_buttons['after'] > 0) {
                        if ($n == $more_buttons['after'] && count($networks) > $more_buttons['after']) {
                            $random_no = rand(1000, 9999);
                            if ($more_buttons['action'] === 'display_inline') {
                                foreach ($networks as $key => $network) {
                                    if (!in_array($network, $include_in_more)) {
                                        $network_api_url = $this->arsocialshare_url($network);
                                        $media_url = $this->get_media_url($post_id);

                                        $shorturl = $this->get_permalink();

                                        if (@in_array('desktop', $saved_networks[$network]['plateform'])) {
                                            $html .= "<div class='arsocialshare_button $network ars_$button_style arsocialshare_hidden_buttons arsocial_lite_{$network}_wrapper $btn_width' data-no='{$random_no}' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' onclick='javascript:arsocialshare_window(\"{$network_api_url}\",\"{$shorturl}\",\"{$this->get_page_title()}\",\"{$network}\",\"{$post_id}\",\"{$media_url}\",jQuery(this))'>";
                                            $html .= "<input type='hidden' id='arsocialshare_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";
                                            $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$theme}_theme_icon socialshare-{$network} arsocial_lite_{$network}_icon' id='arsocial_lite_{$network}_icon'></span>";
                                            $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";

                                            if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                                                $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                                            } else {
                                                $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                                            }
                                            $html .= "</div>";
                                        } else {
                                            if ($this->isMobile($user_agent)) {
                                                $html .= "<div class='arsocialshare_button $network arsocialshare_hidden_buttons ars_$button_style arsocial_lite_{$network}_wrapper $btn_width' data-no='{$random_no}' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$networkid}' >";
                                                $html .= "<a href='" . $this->get_share_url($network) . "'>";
                                                $html .= "<span class='arsocialshare_default_theme_icon socialshare-{$network} arsocial_lite_{$network}_icon' id='arsocial_lite_{$network}_icon'></span>";
                                                $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>{$saved_networks[$network]['custom_name']}</label>";
                                                if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                                                    $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                                                } else {
                                                    $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                                                }
                                                $html .= "</a>";
                                                $html .= "</div>";
                                            }
                                        }
                                    }
                                }
                            }
                            $html .= "<div class='arsocial_lite_more_button_icon $button_style $btn_width' id='arsocial_lite_more_button_icon' data-skin='{$theme}' data-no='{$random_no}' data-action='{$more_buttons['action']}' data-button-width='{$button_width}' data-type='{$type}' data-show-counter='{$show_counter}' data-page-id='{$post_id}' data-network-id='{$network_id}' data-button-style='{$button_style}' data-effect='{$hover_effect}' data-exclude='" . json_encode($include_in_more) . "' data-all-networks='" . json_encode($networks) . "' data-custom_names='" . json_encode($data_custom_names) . "' data-number-format='{$number_format}'>";

                            $morebtncls = ($more_buttons['style'] === 'plus_icon') ? "socialshare-plus" : "socialshare-dot-3";
                            $html .= "<span class='arsocial_lite_more_btn_icon $morebtncls'></span>";
                            $html .= "</div>";
                            break;
                        }
                    }
                }
            }
            $n++;
        }

        if ($total_counter['enable_total_counter'] && $total_counter['total_count_position'] === 'right') {
            $html .= apply_filters('arsocial_lite_total_share_counter', $html, $total_counter, $saved_networks, $networks, $post_id, $number_format);
        }

        do_action('ars_after_share_networks', $networks, array('post_id' => $post_id, 'theme' => $theme));
        $html .= "</div>";
        $html .= "</div>";

        return $html;
    }

    function ars_generate_shorturl($url_for_share, $network, $type, $post_id = 0) {
        global $wpdb, $arsocial_lite;

        if ($type == 'none') {
            return $url_for_share;
        }

        $global_options = maybe_unserialize(get_option('arslite_global_settings'));

        $bitly_username = isset($global_options['bitly']['bitly_username']) ? $global_options['bitly']['bitly_username'] : '';

        $bitly_apikey = isset($global_options['bitly']['bitly_api_key']) ? $global_options['bitly']['bitly_api_key'] : '';


        switch ($type) {
            case 'wordpress':
                $url_for_share = wp_get_shortlink($post_id);
                break;
            case 'bitly':
                $url_for_share = $this->ars_get_bitly_shorturl($url_for_share, $bitly_apikey);
                break;
            case 'none':
                $url_for_share = $url_for_share;
                break;
            default :
                $url_for_share = $url_for_share;
                break;
        }

        return $url_for_share;
    }

    function ars_get_bitly_shorturl($url_for_share, $bitly_apikey) {
        global $ars_lite_bitly_api_url, $ars_lite_bitly_api_version;
        if ($url_for_share == '') {
            return;
        }
        if ($bitly_apikey == '') {
            return $url_for_share;
        }
        $params = http_build_query(
                array(
                    'longUrl' => $url_for_share,
                    'access_token' => $bitly_apikey,
                    'format' => 'json',
                )
        );

        $response = wp_remote_post($ars_lite_bitly_api_url . $ars_lite_bitly_api_version . "/shorten?$params", array(
            'method' => 'GET',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        ));

        $bitly_short_url = $url_for_share;
        if (!is_wp_error($response)) {

            $json = json_decode(wp_remote_retrieve_body($response));

            if (isset($json->data->url)) {

                $bitly_short_url = $json->data->url;
            }
        }

        return $bitly_short_url;
    }

    function get_share_url($network) {
        $url = '';
        switch ($network) {
            case 'whatsapp':
                $url = "whatsapp://send?text=" . urlencode(get_permalink());
                break;
        }
        return $url;
    }
	

    function arsocialshare_url($network) {
        $url = '';
        switch ($network) {
            case 'facebook':
                $url = 'https://www.facebook.com/sharer/sharer.php';
                break;
            case 'twitter':
                $url = 'https://twitter.com/intent/tweet';
                break;
            case 'linkedin':
                $url = 'https://www.linkedin.com/cws/share';
                break;
            case 'pinterest':
                $url = 'https://www.pinterest.com/pin/create/bookmarklet?pinFave=1';
                break;
            case 'mix':
                $url = 'http://www.mix.com/add';
                break;
            case 'reddit':
                $url = 'http://www.reddit.com/submit';
                break;
            case 'buffer':
                $url = 'https://buffer.com/add';
                break;
            case 'pocket':
                $url = 'https://getpocket.com/save';
                break;
            case 'odnoklassniki':
                $url = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare';
                break;
            case 'meneame':
                $url = 'http://www.addtoany.com/add_to/meneame';
                break;
            case 'blogger':
                $url = 'http://www.blogger.com/blog_this.pyra?t';
                break;
            case 'amazon':
                $url = 'http://www.amazon.com/gp/wishlist/static-add';
                break;
            case 'hackernews':
                $url = 'https://news.ycombinator.com/submitlink';
                break;
            case 'evernote':
                $url = 'https://www.evernote.com/clip.action';
                break;
            case 'myspace':
                $url = 'https://myspace.com/post';
                break;
            case 'viadeo':
                $url = 'http://www.viadeo.com/shareit/share/';
                break;
            case 'flipboard':
                $url = 'https://share.flipboard.com/bookmarklet/popout?v=2';
                break;
            case 'yummly':
                $url = 'http://www.yummly.com/urb/verify';
                break;
            case 'box':
                $url = 'https://www.box.com/api/1.0/import';
                break;
            case 'gmail':
                $url = 'https://mail.google.com/mail/u/0/?view=cm&fs=1';
                break;
            case 'yahoo':
                $url = 'http://compose.mail.yahoo.com/';
                break;
            case 'aol':
                $url = 'https://mail.aol.com/webmail-std/en-in/composemessage';
                break;
            case 'email':
                $url = admin_url('admin-ajax.php');
                break;
            case 'vk':
                $url = "https://vk.com/share.php";
                break;
            case 'xing':
                $url = "https://www.xing.com/social_plugins/share";
                break;
        }
        return $url;
    }

    function get_permalink() {
        return get_permalink();
    }

    function get_page_title() {
        return get_the_title();
    }

    function get_counter($network, $post_id) {
        $current_value = get_post_meta($post_id, 'arscialshare_counter_' . $network, true);
        if (isset($current_value)) {
            return intval($current_value);
        } else {
            return 0;
        }
    }

    function arsocial_lite_update_share_counter() {
        global $arsocial_lite_counter;
        $socialsharecounter = get_option('arslite_counters');
        $url = $_POST['share_url'];
        $ip = isset($_POST['ip']) ? $_POST['ip'] : '';
        $network = $_POST['network'];
        $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : '';
        $options = isset($_POST['ars_options']) ? $_POST['ars_options'] : "";
        $counter = 0;
        switch ($network) {
            case 'facebook':
                $counter = $arsocial_lite_counter->ARSocialShareGetFBShareCounter($url, $page_id, $options);
                break;
            case 'twitter':
                $counter = $arsocial_lite_counter->ARSocialShareGetTwitterShareCounter($url, $page_id);
                break;
            case 'linkedin':
                $counter = $arsocial_lite_counter->ARSocialShareGetLinkedinShareCounter($url, $page_id, $options);
                break;
            case 'pinterest':
                $counter = $arsocial_lite_counter->ARSocialShareGetPinterestShareCounter($url, $page_id);
                break;
            case 'reddit':
                $counter = $arsocial_lite_counter->ARSocialShareGetRedditShareCounter($url, $page_id, $options);
                break;
            case 'buffer':
                $counter = $arsocial_lite_counter->ARSocialShareGetBufferShareCounter($url, $page_id, $options);
                break;
            case 'pocket':
                $counter = $arsocial_lite_counter->ARSocialShareGetPocketShareCounter($url, $page_id, $options);
                break;
            case 'xing':
                $counter = $arsocial_lite_counter->ARSocialShareXingShareCounter($url, $page_id, $options);
                break;
            case 'odnoklassniki':
                $counter = $arsocial_lite_counter->ARSocialShareGetOdnoklassnikiShareCounter($url, $page_id, $options);
                break;
            case 'meneame':
                $counter = $arsocial_lite_counter->ARSocialShareGetMeneameShareCounter($url, $page_id, $options);
                break;

            case 'vk':
                $counter = $arsocial_lite_counter->ARSocialShareGetVKShareCounter($url, $page_id, $options);
                break;
            case 'viadeo':
                $counter = $arsocial_lite_counter->ARSocialShareGetViadeoShareCounter($url, $page_id, $options);
        }
        echo $counter;
        die();
    }

    function isMobile($user_agent = '') {
        if ($user_agent === '') {
            return false;
        }

        $pattern = "/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i";
        $pattern2 = "/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i";

        if (preg_match($pattern, $user_agent) || preg_match($pattern2, $user_agent)) {
            return true;
        } else {
            return false;
        }
    }

    function arsocialshare_do_custom_email() {

        $body = isset($_POST['share_url']) ? $_POST['share_url'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';

        $global_settings = maybe_unserialize(get_option('arslite_global_settings'));

        $email_settings = $global_settings['email'];

        $mail_method = $email_settings['email_method'];
        $mail_operate = $email_settings['operate_email'];

        $response = array();
        $response['method'] = $mail_method;
        $response['operate'] = $mail_operate;
        echo json_encode($response);
        die();
    }

    function arsocialshare_send_mail() {
        $to = isset($_POST['recipient_email']) ? $_POST['recipient_email'] : '';
        $from = isset($_POST['sender_email']) ? $_POST['sender_email'] : '';
        $subject = isset($_POST['mail_subject']) ? $_POST['mail_subject'] : '';
        $message = isset($_POST['mail_body']) ? $_POST['mail_body'] : '';

        if ($to === '') {
            echo json_encode(array('result' => 'error', 'message' => esc_html__('invalid receipent email', 'arsocial_lite')));
            die();
        }

        if ($from === '') {
            echo json_encode(array('result' => 'error', 'message' => esc_html__('invalid sender email', 'arsocial_lite')));
            die();
        }

        $options = get_option('arslite_global_settings');
        $gs_options = maybe_unserialize($options);

        $method = $gs_options['email']['email_method'];
        $site_title = get_option('blogname');
        $headers = "From: {$site_title} <{$from}> \r\n";
        $headers .= " Content-Type: text/html; \r\n";
        if ('wp_method' === $method) {
            if (wp_mail($to, $subject, $message, $headers)) {
                echo json_encode(array('result' => 'success', 'message' => esc_html__('message sent.', 'arsocial_lite')));
            } else {
                echo json_encode(array('result' => 'error', 'message' => esc_html__('message could not sent.', 'arsocial_lite')));
            }
        } else {
            if (mail($to, $subject, $message, $headers)) {
                echo json_encode(array('result' => 'success', 'message' =>  esc_html__('message sent.', 'arsocial_lite')));
            } else {
                echo json_encode(array('result' => 'error', 'message' => esc_html__('message could not sent.', 'arsocial_lite')));
            }
        }
        die();
    }

    function arsocial_lite_update_network() {
        $network = isset($_POST['network']) ? $_POST['network'] : '';
        $value = isset($_POST['value']) ? $_POST['value'] : '';
        $response = array();
        if ($network === '' || $value === '') {
            $response['result'] = "error";
            $response['code'] = "404";
            $response['message'] = esc_html__("Please Enter Network", 'arsocial_lite');
        } else {
            $default_settings = maybe_unserialize(get_option('arslite_settings'));
            $default_networks = $default_settings['networks'];
            $default_networks[$network]['custom_name'] = $value;
            $default_settings['networks'] = $default_networks;
            $settings = maybe_serialize($default_settings);
            update_option('arslite_settings', $settings);
            $response['result'] = 'success';
            $response['code'] = "200";
            $response['message'] = esc_html__("Network Updated Successfully", 'arsocial_lite');
        }
        echo json_encode($response);
        die();
    }

    function arsocialshare_save_network() {
        $data = isset($_POST['data']) ? $_POST['data'] : '';
        $todo = isset($_POST['todo']) ? $_POST['todo'] : '';
        $active_networks = '';
        $deactive_networks = '';
        $response = array();
        if ($data === '' || $todo === '') {
            $response['result'] = "error";
            $response['code'] = "404";
            $response['message'] = esc_html__('Could not update network', 'arsocial_lite');
        } else {
            $values = json_decode(stripslashes_deep($data));
            $default_settings = maybe_unserialize(get_option('arslite_settings'));
            $default_networks = $default_settings['networks'];
            $selected_networks = $values->active;
            $deselected_networks = $values->deactive;
            if ($todo === 'ars_network_deactive') {
                if (!empty($selected_networks) && count($selected_networks) > 0) {
                    foreach ($selected_networks as $key => $networks) {
                        $default_settings['networks'][$networks]['enable'] = 0;
                    }
                }
                $response['result'] = 'success';
                $response['code'] = '200';
                $response['message'] = esc_html__('Selected Network(s) successfully deactivated.', 'arsocial_lite');
            }
            if ($todo === 'ars_network_active') {
                if (!empty($selected_networks) && count($selected_networks) > 0) {
                    foreach ($selected_networks as $key => $networks) {
                        $default_settings['networks'][$networks]['enable'] = 1;
                    }
                }
                if (!empty($deselected_networks) && count($deselected_networks) > 0) {
                    foreach ($deselected_networks as $key => $networks) {
                        $default_settings['networks'][$networks]['enable'] = 0;
                    }
                }
                $response['result'] = 'success';
                $response['code'] = '200';
                $response['message'] = esc_html__('Selected Network(s) successfully activated.', 'arsocial_lite');
            }
            update_option('arslite_settings', maybe_serialize($default_settings));
        }
        echo json_encode($response);
        die();
    }

    function arsocialshare_network_update_theme() {
        $theme = isset($_POST['theme']) ? $_POST['theme'] : 'default';
        update_option('arslite_selected_theme', $theme);
        $response['code'] = "200";
        $response['message'] = "success";
        $response['body'] = esc_html__('Theme Updated successfully', 'arsocial_lite');
        echo json_encode($response);
        die();
    }

    /**
     * Function for save display Settings.
     * 
     * @since v1.0
     */
    function arsocialshare_network_save_display_settings() {
        global $wpdb;

        $options = isset($_POST['options']) ? $_POST['options'] : '';

        $opts = json_decode(stripslashes_deep($options), true);

        $settings = array();

        $networks = $opts['networks'];
        $networks_display_name = $opts['network_display_name'];

        $displayopt = $opts['displaysettings'];

        $settings['networks'] = $networks;
        $settings['display'] = $displayopt;
        $settings['network_display_name'] = $networks_display_name;

        update_option('arslite_networks_display_setting', maybe_serialize($settings));

        echo json_encode(array(esc_html__('Settings Saved Successfully.', 'arsocial_lite')));

        die();
    }

    /**
     * Function to add social buttons on page content, post content, custom post content
     */
    function arsocialshare_filtered_content($content) {
        global $post;
        $settings = maybe_unserialize(get_option('arslite_networks_display_setting'));
        if (isset($settings) && !empty($settings['networks'])) {
            $content = $this->arsocial_media_sharing($content, $settings);
        }

        if (is_admin() || !is_singular()) {
            return $content;
        }


        $changed_content = "";

        $post_id = get_the_ID();
        if ($post_id === '') {
            return $content;
        } else {
            if (empty($settings)) {
                return $content;
            } else {
                if (empty($settings['networks'])) {
                    return $content;
                } else {
                    $changed_content = $this->ars_get_filter_content($post_id, $content, $settings);
                }
            }

            return $changed_content;
        }
    }

    /**
     * Function for add social button on post excerpt.
     * 
     * @since v1.0
     */
    function arsocial_lite_filtered_excerpt($excerpt) {
        if (is_admin()) {
            return $excerpt;
        }

        $settings = maybe_unserialize(get_option('arslite_networks_display_setting'));
        if (isset($settings) && !empty($settings['networks'])) {
            $excerpt = $this->arsocial_media_sharing($excerpt, $settings);
        }


        $changed_content = "";
        $post_id = get_the_ID();

        $is_custom_css_add = false;
        if ($post_id === '') {
            return $excerpt;
        } else {
            if (empty($settings)) {
                return $excerpt;
            } else {
                if (empty($settings['networks'])) {
                    return $excerpt;
                } else {

                    $post_type = get_post_type($post_id);
                    $exclude_post_id = array();

                    if (isset($settings['display']['post']['exclude_pages'])) {
                        $exclude_post_id = explode(',', $settings['display']['post']['exclude_pages']);
                        if (in_array($post_id, $exclude_post_id)) {
                            return $excerpt;
                        }
                    }

                    $display_settings = isset($settings['display']['post']) ? $settings['display']['post'] : '';
                    if (empty($display_settings)) {
                        return $excerpt;
                    }
                    $btn_width = (isset($display_settings['btn_width'])) ? $display_settings['btn_width'] : '';
                    $button_skin = isset($display_settings['skin']) ? $display_settings['skin'] : 'default';
                    $button_style = isset($display_settings['btn_style']) ? $display_settings['btn_style'] : 'name_with_icon';
                    $hover_effect = isset($display_settings['hover_effect']) ? $display_settings['hover_effect'] : '';
                    $remove_space = (isset($display_settings['remove_space'])) ? $display_settings['remove_space'] : 'no';

                    $more_btn_after = isset($display_settings['more_btn']) ? $display_settings['more_btn'] : '0';
                    $more_btn_style = isset($display_settings['more_btn_style']) ? $display_settings['more_btn_style'] : 'plus_icon';
                    $more_btn_action = isset($display_settings['more_btn_act']) ? $display_settings['more_btn_act'] : 'display_inline';

                    $show_counter = (isset($display_settings['show_counter'])) ? $display_settings['show_counter'] : '';
                    $enable_total_counter = isset($display_settings['enable_total_counter']) ? $display_settings['enable_total_counter'] : false;
                    $total_share_label = isset($display_settings['arsocial_total_share_label']) ? $display_settings['arsocial_total_share_label'] : 'SHARES';
                    $total_share_position = isset($display_settings['total_counter_position']) ? $display_settings['total_counter_position'] : 'left';
                    $no_format = isset($display_settings['no_format']) ? $display_settings['no_format'] : 'style5';

                    if (isset($display_settings['excerpt']) && $display_settings['excerpt'] !== 'no') {
                        $display_bottom = '1';
                        $button_align = "right";

                        $display_float = (isset($display_settings['floating']) && $display_settings['floating'] === 'yes') ? $display_settings['floating'] : '';
                        $changed_content .= $excerpt;

                            $enable_float = ( $display_float ) ? "ars_sticky_bottom_belt" : "";

                            $changed_content .= "<div class='arsocialshare_network_button_settings arsocial_lite_bottom_button  arsocialshare_align_{$button_align} {$enable_float}' id='arsocial_lite_bottom_button '>";
                            $shortcode_content = "[ARSocial_Lite_Share_Main networks='";
                            $shortcode_content .= implode('|', $settings['networks']);

                            $shortcode_content .= "' theme='$button_skin' button_style='$button_style' hover_effect='{$hover_effect}' remove_space='{$remove_space}'";
                            $shortcode_content .= " more_btn='$more_btn_after' more_btn_style='$more_btn_style' more_btn_action='$more_btn_action' show_counter='$show_counter'";
                            $shortcode_content .= " is_display_bottom='true' is_total_share='{$enable_total_counter}' total_share_label='{$total_share_label}' total_count_position='{$total_share_position}' no_format='{$no_format}' button_width=$btn_width";
                            $shortcode_content .= "]";
                            $changed_content .= do_shortcode($shortcode_content);
                            $changed_content .= "</div>";
                    } else {
                        $changed_content .= $excerpt;
                    }
                }
            }
        }
        return $changed_content;
    }

    /**
     * Function to check if current page is special page.
     * 
     * @since v1.0
     */
    function arsocialshare_check_special_page($special_page_settings = array()) {

        $is_special_page = false;

        if (empty($special_page_settings)) {
            return $is_special_page;
        }

        $selected_pages = $special_page_settings['selected_pages'];

        /* Check if page is category archive page */
        if (is_category() && in_array('category', $selected_pages)) {
            $is_special_page = true;
        } else if (is_archive() && in_array('archive', $selected_pages)) {
            $is_special_page = true;
        } else if (is_404() && in_array('404', $selected_pages)) {
            $is_special_page = true;
        } else if (is_author() && in_array('author', $selected_pages)) {
            $is_special_page = true;
        } else if (is_search() && in_array('search_result', $selected_pages)) {
            $is_special_page = true;
        } else if (is_attachment() && in_array('attachment', $selected_pages)) {
            $is_special_page = true;
        } else if (is_tax() && in_array('taxonomy', $selected_pages)) {
            $is_special_page = true;
        } else {
            $is_special_page = false;
        }

        return $is_special_page;
    }

    function arsocialshare_woocommerce_price_filter($price) {
        if (is_admin()) {
            return $price;
        }
        $settings = maybe_unserialize(get_option('arslite_networks_display_setting'));
        $networks = $settings['networks'];
        $display = isset( $settings['display']['woocommerce'] ) ? $settings['display']['woocommerce'] : '';

        $changed_content = "";
        if (empty($networks)) {
            return $price;
        } else {
            $post_id = get_the_ID();
            $exclude_post_id = array();
            if (isset($settings['display']['woocommerce']['exclude_pages'])) {
                $exclude_post_id = explode(',', $settings['display']['woocommerce']['exclude_pages']);
                if (in_array($post_id, $exclude_post_id)) {
                    return $price;
                }
            }

            $button_skin = isset($display['skin']) ? $display['skin'] : 'default';
            $button_style = isset($display['btn_style']) ? $display['btn_style'] : 'name_with_icon';
            $more_btn_after = isset($display['more_btn']) ? $display['more_btn'] : '0';
            $more_btn_style = isset($display['more_btn_style']) ? $display['more_btn_style'] : 'plus_icon';
            $more_btn_action = isset($display['more_btn_act']) ? $display['more_btn_act'] : 'display_popup';
            $show_counter = (isset($display['show_counter'])) ? $display['show_counter'] : '';
            $hover_effect = (isset($display['hover_effect'])) ? $display['hover_effect'] : '';
            $button_align = (isset($display['btn_align'])) ? $display['btn_align'] : '';
            $btn_width = (isset($display['btn_width'])) ? $display['btn_width'] : '';
            $remove_space = (isset($display['remove_space'])) ? $display['remove_space'] : 'no';

            $enable_total_counter = isset($display['enable_total_counter']) ? $display['enable_total_counter'] : false;
            $total_share_label = isset($display['arsocial_total_share_label']) ? $display['arsocial_total_share_label'] : 'SHARES';
            $total_share_position = isset($display['total_counter_position']) ? $display['total_counter_position'] : 'left';
            $no_format = isset($display['no_format']) ? $display['no_format'] : 'style5';

            if (isset($display['after_price']) && $display['after_price'] && array_key_exists('woocommerce', $settings['display']) && $display['enable'] == 'yes') {
                $changed_content = '<style>' . $settings['display']['arsocialshare_custom_css'] . '</style>';
                $changed_content .= $price;
                $changed_content .= "<br/>";
                $changed_content .= "<div class='arsocialshare_network_button_settings arsocialshare_button_after_price arsocialshare_align_$button_align' id='arsocialshare_button_after_price $btn_width'>";
                $shortcode_content = "[ARSocial_Lite_Share_Main networks=";
                $shortcode_content .= implode('|', $settings['networks']);
                //$shortcode_content .= " is_fly=$fly_btn fly_position=fly_{$fly_btn_position} ";
                $shortcode_content .= " theme=$button_skin button_style=$button_style hover_effect='{$hover_effect}'";
                $shortcode_content .= " more_btn=$more_btn_after more_btn_style=$more_btn_style more_btn_action=$more_btn_action show_counter=$show_counter remove_space='$remove_space' is_total_share='{$enable_total_counter}' total_share_label='{$total_share_label}' total_count_position='{$total_share_position}' no_format='{$no_format}' ";
                $shortcode_content .= " is_display_top=true button_width=$btn_width]";
                $changed_content .= do_shortcode($shortcode_content);
                $changed_content .= "</div>";
            } else {
                return $price;
            }
        }

        return $changed_content;
    }

    function arsocialshare_woocommerce_before_single_product() {
        $settings = maybe_unserialize(get_option('arslite_networks_display_setting'));
        $isadminbarvisible = (is_admin_bar_showing()) ? "wp_bar_visible" : "";
        $networks = $settings['networks'];
        $display = isset( $settings['display']['woocommerce'] ) ? $settings['display']['woocommerce'] : '';

        $button_skin = isset($display['skin']) ? $display['skin'] : 'default';
        $button_style = isset($display['btn_style']) ? $display['btn_style'] : 'name_with_icon';
        $more_btn_after = isset($display['more_btn']) ? $display['more_btn'] : '0';
        $more_btn_style = isset($display['more_btn_style']) ? $display['more_btn_style'] : 'plus_icon';
        $more_btn_action = isset($display['more_btn_act']) ? $display['more_btn_act'] : 'display_popup';
        $button_align = (isset($display['btn_align'])) ? $display['btn_align'] : '';

        $button_align = isset($display['btn_align']) ? $display['btn_align'] : '';
        $enable_float = isset($display_float) ? true : false;
        $show_counter = (isset($display['show_counter'])) ? $display['show_counter'] : '';
        $hover_effect = (isset($display['hover_effect'])) ? $display['hover_effect'] : '';
        $button_width = (isset($display['btn_width'])) ? $display['btn_width'] : '';
        $remove_space = (isset($display['remove_space'])) ? $display['remove_space'] : '';

        $enable_total_counter = isset($display['enable_total_counter']) ? $display['enable_total_counter'] : false;
        $total_share_label = isset($display['arsocial_total_share_label']) ? $display['arsocial_total_share_label'] : 'SHARES';
        $total_share_position = isset($display['total_counter_position']) ? $display['total_counter_position'] : 'left';
        $no_format = isset($display['no_format']) ? $display['no_format'] : 'style5';

        $changed_content = "";
        if (empty($networks)) {
            echo "";
        } else {
            $post_id = get_the_ID();
            $exclude_post_id = array();
            if (isset($settings['display']['woocommerce']['exclude_pages'])) {
                $exclude_post_id = explode(',', $settings['display']['woocommerce']['exclude_pages']);
                if (in_array($post_id, $exclude_post_id)) {
                    return '';
                }
            }
            if (isset($display['before_product']) && $display['before_product'] && array_key_exists('woocommerce', $settings['display']) && $display['enable'] == 'yes') {

                    $isadminbarvisible = (is_admin_bar_showing()) ? "wp_bar_visible" : "";

                        $enable_float = isset($display_float) ? true : false;

                    $changed_content = '<style>' . $settings['display']['arsocialshare_custom_css'] . '</style>';

                    $changed_content .= "<div class='arsocialshare_network_button_settings arsocialshare_button_before_product arsocialshare_align_{$button_align} {$isadminbarvisible}' data-enable-floating='$enable_float' id='arsocialshare_button_before_product'>";
                    $shortcode_content = "[ARSocial_Lite_Share_Main networks=";
                    $shortcode_content .= implode('|', $settings['networks']);
//                    $shortcode_content .= " is_fly=$fly_btn fly_position=fly_{$fly_btn_position} ";
                    $shortcode_content .= " theme=$button_skin button_style=$button_style hover_effect='{$hover_effect}'";
                    $shortcode_content .= " more_btn=$more_btn_after more_btn_style=$more_btn_style more_btn_action=$more_btn_action";
                    $shortcode_content .= " is_display_top=true show_counter=$show_counter button_width=$button_width remove_space='{$remove_space}' is_total_share='{$enable_total_counter}' total_share_label='{$total_share_label}' total_count_position='{$total_share_position}' no_format='{$no_format}']";
                    $changed_content .= do_shortcode($shortcode_content);
                    $changed_content .= "</div>";

            } else {
                echo "";
            }
        }

        echo $changed_content;
    }

    function arsocialshare_woocommerce_after_single_product() {
        $settings = maybe_unserialize(get_option('arslite_networks_display_setting'));
        $isadminbarvisible = (is_admin_bar_showing()) ? "wp_bar_visible" : "";
        $networks = $settings['networks'];
        $display = isset( $settings['display']['woocommerce'] ) ? $settings['display']['woocommerce'] : '';

        $button_skin = isset($display['skin']) ? $display['skin'] : 'default';
        $button_style = isset($display['btn_style']) ? $display['btn_style'] : 'name_with_icon';
        $more_btn_after = isset($display['more_btn']) ? $display['more_btn'] : '0';
        $more_btn_style = isset($display['more_btn_style']) ? $display['more_btn_style'] : 'plus_icon';
        $more_btn_action = isset($display['more_btn_act']) ? $display['more_btn_act'] : 'display_inline';
        $hover_effect = (isset($display['hover_effect'])) ? $display['hover_effect'] : '';
        $enable_float = isset($display_float) ? true : false;

        $button_align = isset($display['btn_align']) ? $display['btn_align'] : '';
        $show_counter = (isset($display['show_counter'])) ? $display['show_counter'] : '';
        $button_width = (isset($display['btn_width'])) ? $display['btn_width'] : '';
        $remove_space = isset($display['remove_space']) ? $display['remove_space'] : 'no';

        $enable_total_counter = isset($display['enable_total_counter']) ? $display['enable_total_counter'] : false;
        $total_share_label = isset($display['arsocial_total_share_label']) ? $display['arsocial_total_share_label'] : 'SHARES';
        $total_share_position = isset($display['total_counter_position']) ? $display['total_counter_position'] : 'left';
        $no_format = isset($display['no_format']) ? $display['no_format'] : 'style5';

        $changed_content = "";
        if (empty($networks)) {
            $changed_content = "";
        } else {

            $mobile_display = isset($settings['display']['hide_mobile']) ? $settings['display']['hide_mobile'] : array();
            $post_id = get_the_ID();
            $exclude_post_id = array();
            if (isset($settings['display']['woocommerce']['exclude_pages'])) {
                $exclude_post_id = explode(',', $settings['display']['woocommerce']['exclude_pages']);
                if (in_array($post_id, $exclude_post_id)) {
                    return '';
                }
            }
            if (isset($display['after_product']) && $display['after_product'] && array_key_exists('woocommerce', $settings['display']) && $display['enable'] == 'yes') {
               if (wp_is_mobile() && isset($mobile_display['enable_mobile_hide_floating']) && $mobile_display['enable_mobile_hide_floating'] == 1) {
                    $enable_float = "";
                } else {
                    $enable_float = isset($display_float) ? "ars_sticky_bottom_belt" : "";
               }
               if (wp_is_mobile() && isset($mobile_display['enable_mobile_hide_bottom']) && $mobile_display['enable_mobile_hide_bottom'] == 1 || wp_is_mobile() && isset($mobile_display['enable_mobile_hide_sidebar']) && $mobile_display['enable_mobile_hide_sidebar']) {
                    $changed_content .= '';
                } else {

                    $changed_content = '<style>' . $settings['display']['arsocialshare_custom_css'] . '</style>';
                    $changed_content .= "<div class='arsocialshare_network_button_settings arsocialshare_button_after_product arsocialshare_align_{$button_align} {$isadminbarvisible} {$enable_float}' id='arsocialshare_button_after_product'>";
                    $shortcode_content = "[ARSocial_Lite_Share_Main networks=";
                    $shortcode_content .= implode('|', $settings['networks']);
                    $shortcode_content .= " theme=$button_skin button_style=$button_style hover_effect='{$hover_effect}'";
                    $shortcode_content .= " more_btn=$more_btn_after more_btn_style=$more_btn_style more_btn_action=$more_btn_action";
                    $shortcode_content .= " is_display_bottom=true show_counter=$show_counter button_width='$button_width' remove_space='$remove_space' is_total_share='{$enable_total_counter}' total_share_label='{$total_share_label}' total_count_position='{$total_share_position}' no_format='{$no_format}' ]";

                    $changed_content .= do_shortcode($shortcode_content);
                    $changed_content .= "</div>";
              }
            } else {
                $changed_content = "";
            }
        }

        echo $changed_content;
    }

    function arsocial_lite_save_networks() {
        global $wpdb,$arsocial_lite;
        $table = $arsocial_lite->arslite_networks;
        $formdata = '';


        $network_id = (isset($_POST['network_id']) && !empty($_POST['network_id'])) ? $_POST['network_id'] : '';


        $network_settings = array();
        $enabled_data = (isset($_POST['position_setting_display_networks']) && !empty($_POST['position_setting_display_networks'])) ? $_POST['position_setting_display_networks'] : "";
        if (!empty($enabled_data) && is_array($enabled_data)) {
            foreach ($enabled_data as $key => $network) {
                $network_settings['enabled_network'][] = $network;
            }
        }
        $network_settings['custom_name'] = isset($_POST['ars_network_display_name']) && !empty($_POST['ars_network_display_name']) ? $_POST['ars_network_display_name'] : "";

        $network_settings['sort_order'] = isset($_POST['sort_order']) && !empty($_POST['sort_order']) ? $_POST['sort_order'] : "";


        $display_settings = array();

        $display_settings['arsocialshare_share_settings_skins'] = (isset($_POST['arsocialshare_share_settings_skins']) && !empty($_POST['arsocialshare_share_settings_skins'])) ? $_POST['arsocialshare_share_settings_skins'] : '';
        $display_settings['arsocialshare_share_button_style'] = (isset($_POST['arsocialshare_share_button_style']) && !empty($_POST['arsocialshare_share_button_style'])) ? $_POST['arsocialshare_share_button_style'] : '';

        $display_settings['arsocialshare_share_hover_effect'] = (isset($_POST['arsocialshare_share_hover_effect']) && !empty($_POST['arsocialshare_share_hover_effect'])) ? $_POST['arsocialshare_share_hover_effect'] : '';

        $display_settings['arsocialshare_share_settings_more_button'] = (isset($_POST['arsocialshare_share_settings_more_button']) && !empty($_POST['arsocialshare_share_settings_more_button'])) ? $_POST['arsocialshare_share_settings_more_button'] : '';

        $display_settings['arsocialshare_share_more_button_style'] = (isset($_POST['arsocialshare_share_more_button_style']) && !empty($_POST['arsocialshare_share_more_button_style'])) ? $_POST['arsocialshare_share_more_button_style'] : '';
        $display_settings['arsocialshare_share_more_button_action'] = (isset($_POST['arsocialshare_share_more_button_action']) && !empty($_POST['arsocialshare_share_more_button_action'])) ? $_POST['arsocialshare_share_more_button_action'] : '';

        $display_settings['arsocialshare_share_remove_space'] = (isset($_POST['arsocialshare_share_remove_space']) && !empty($_POST['arsocialshare_share_remove_space'])) ? $_POST['arsocialshare_share_remove_space'] : '';
        $display_settings['arsocialshare_share_show_count'] = (isset($_POST['arsocialshare_share_show_count']) && !empty($_POST['arsocialshare_share_show_count'])) ? $_POST['arsocialshare_share_show_count'] : '';

        $display_settings['arsocialshare_share_button_width'] = (isset($_POST['arsocialshare_share_button_width']) && !empty($_POST['arsocialshare_share_button_width'])) ? $_POST['arsocialshare_share_button_width'] : '';

        $display_settings['arsocialshare_share_settings_fixed_button_width'] = (isset($_POST['arsocialshare_share_settings_fixed_button_width']) && !empty($_POST['arsocialshare_share_settings_fixed_button_width'])) ? $_POST['arsocialshare_share_settings_fixed_button_width'] : '';
        $display_settings['arsocialshare_share_settings_full_button_width_desktop'] = (isset($_POST['arsocialshare_share_settings_full_button_width_desktop']) && !empty($_POST['arsocialshare_share_settings_full_button_width_desktop'])) ? $_POST['arsocialshare_share_settings_full_button_width_desktop'] : '';
        $display_settings['ars_btn_align'] = (isset($_POST['ars_btn_align']) && !empty($_POST['ars_btn_align'])) ? $_POST['ars_btn_align'] : '';


        $display_settings['arsocialshare_display_type'] = (isset($_POST['arsocialshare_display_type']) && !empty($_POST['arsocialshare_display_type'])) ? $_POST['arsocialshare_display_type'] : '';

        $display_settings['enable_total_counter'] = (isset($_POST['arsocialshare_show_total_share'])) ? $_POST['arsocialshare_show_total_share'] : '';
        $display_settings['arsocial_total_share_label'] = isset($_POST['arsocialshare_total_share_label']) ? $_POST['arsocialshare_total_share_label'] : '';
        $display_settings['total_counter_position'] = isset($_POST['arsocial_total_counter_position']) ? $_POST['arsocial_total_counter_position'] : 'left';

        $display_settings['no_format'] = isset($_POST['arsocialshare_display_number_format']) ? $_POST['arsocialshare_display_number_format'] : 'style5';

        if ($display_settings['arsocialshare_display_type'] == 'sidebar') {
            $display_settings['arsocialshare_sidebar'] = (isset($_POST['arsocialshare_sidebar']) && !empty($_POST['arsocialshare_sidebar'])) ? $_POST['arsocialshare_sidebar'] : 'left';
        } elseif ($display_settings['arsocialshare_display_type'] == 'top_bottom_bar') {

            $display_settings['arsocialshare_top_bar'] = (isset($_POST['arsocialshare_top_bar']) && !empty($_POST['arsocialshare_top_bar'])) ? $_POST['arsocialshare_top_bar'] : '';
            $display_settings['arsocialshare_top_bottom_bar_display_on'] = (isset($_POST['arsocialshare_top_bottom_bar_display_on']) && !empty($_POST['arsocialshare_top_bottom_bar_display_on'])) ? $_POST['arsocialshare_top_bottom_bar_display_on'] : '';
            $display_settings['arsocialshare_top_bottom_bar_onload_time'] = (isset($_POST['arsocialshare_top_bottom_bar_onload_time']) && !empty($_POST['arsocialshare_top_bottom_bar_onload_time'])) ? $_POST['arsocialshare_top_bottom_bar_onload_time'] : '';
            $display_settings['arsocialshare_top_bottom_bar_onscroll_percentage'] = (isset($_POST['arsocialshare_top_bottom_bar_onscroll_percentage']) && !empty($_POST['arsocialshare_top_bottom_bar_onscroll_percentage'])) ? $_POST['arsocialshare_top_bottom_bar_onscroll_percentage'] : '';
            $display_settings['arsocialshare_top_bottom_bar_y_position'] = isset($_POST['arsocialshare_top_bottom_bar_y_position']) ? $_POST['arsocialshare_top_bottom_bar_y_position'] : '';
        } elseif ($display_settings['arsocialshare_display_type'] == 'popup') {

            $display_settings['arsocialshare_onload_type'] = (isset($_POST['arsocialshare_onload_type']) && !empty($_POST['arsocialshare_onload_type'])) ? $_POST['arsocialshare_onload_type'] : '';

            $display_settings['arsocialshare_open_delay'] = (isset($_POST['arsocialshare_open_delay']) && !empty($_POST['arsocialshare_open_delay'])) ? $_POST['arsocialshare_open_delay'] : '';
            $display_settings['arsocialshare_open_scroll'] = (isset($_POST['arsocialshare_open_scroll']) && !empty($_POST['arsocialshare_open_scroll'])) ? $_POST['arsocialshare_open_scroll'] : '';


            $display_settings['popup_width'] = (isset($_POST['popup_width']) && !empty($_POST['popup_width'])) ? $_POST['popup_width'] : '';
            $display_settings['popup_height'] = (isset($_POST['popup_height']) && !empty($_POST['popup_height'])) ? $_POST['popup_height'] : '';
            $display_settings['arsocialshare_pop_show_close_button'] = (isset($_POST['arsocialshare_pop_show_close_button']) && !empty($_POST['arsocialshare_pop_show_close_button'])) ? $_POST['arsocialshare_pop_show_close_button'] : '';
        }

        $created_date = current_time('mysql');
        $updated_date = current_time('mysql');

        if (empty($network_id)) {

            $query = $wpdb->prepare("INSERT INTO `$table` (`network_settings`,`display_settings`,`created_date`,`last_updated_date`) VALUES (%s,%s,%s,%s)", maybe_serialize($network_settings), maybe_serialize($display_settings), $created_date, $updated_date);
            if ($wpdb->query($query)) {
                $id = $wpdb->insert_id;
                echo json_encode(array('message' => 'success', 'body' => esc_html__('Settings Saved Successfully.', 'arsocial_lite'), 'id' => $id, 'action' => 'new'));
            } else {
                echo json_encode(array('message' => 'error', 'body' => esc_html__('Couldn\'t save network', 'arsocial_lite'), 'action' => 'new'));
            }
        } else {

            $query = $wpdb->prepare("UPDATE `$table` SET network_settings = '" . maybe_serialize($network_settings) . "', display_settings = '" . maybe_serialize($display_settings) . "', last_updated_date='" . $updated_date . "' WHERE network_id = %d", $network_id);

            if ($wpdb->query($query)) {
                echo json_encode(array('message' => 'success', 'body' => esc_html__('Settings Saved Successfully.', 'arsocial_lite'), 'id' => $network_id, 'action' => 'edit'));
            } else {
                echo json_encode(array('message' => 'error', 'body' => esc_html__('Couldn\'t save network', 'arsocial_lite'), 'action' => 'edit'));
            }
        }

        die();
    }

    function arsocial_lite_delete_network() {
        global $wpdb,$arsocial_lite;
        $network_id = isset($_POST['network_id']) ? $_POST['network_id'] : '';
        $data = array('network_id' => $network_id);
        $table = $arsocial_lite->arslite_networks;
        if ($wpdb->delete($table, $data)) {
            echo json_encode(array('message' => 'success', 'body' => esc_html__('Network Deleted Successfully', 'arsocial_lite')));
        } else {
            echo json_encode(array('message' => 'error', 'body' => esc_html__('Couldn\'t delete network', 'arsocial_lite')));
        }
        die();
    }

    /**
     * Browser Detection
     * Return Browser And Version
     */
    function getBrowser($user_agent) {
        $u_agent = $user_agent;
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";


        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        $ub = '';
        if ($platform != 'Unknown') {

            if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            } elseif (preg_match('/Firefox/i', $u_agent)) {
                $bname = 'Mozilla Firefox';
                $ub = "Firefox";
            } elseif (preg_match('/Opera/i', $u_agent)) {
                $bname = 'Opera';
                $ub = "Opera";
            } elseif (preg_match('/OPR/i', $u_agent)) {
                $bname = 'Opera';
                $ub = "OPR";
            } elseif (preg_match('/Netscape/i', $u_agent)) {
                $bname = 'Netscape';
                $ub = "Netscape";
            } elseif (strpos($user_agent, 'Trident') !== FALSE) { //For Supporting IE 11
                $bname = 'Internet Explorer';
                $ub = "Trident";
            } else if (preg_match('/Edge/i', $u_agent)) {
                $bname = 'Microsoft Edge';
                $ub = "Edge";
            } else if (preg_match('/OPR/i', $u_agent)) {
                $bname = 'Opera';
                $ub = "Opera";
            } elseif (preg_match('/Chrome/i', $u_agent)) {
                $bname = 'Google Chrome';
                $ub = "Chrome";
            } elseif (preg_match('/Safari/i', $u_agent)) {
                $bname = 'Apple Safari';
                $ub = "Safari";
            }
        }
        $known = array('Version', $ub, 'other');

        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!@preg_match_all($pattern, $u_agent, $matches)) {
            
        }


        $i = count($matches['browser']);
        if ($i != 1) {

            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        if ($ub == "Trident") {
            $version = "11";
        }


        if ($version == null || $version == "") {
            $version = "?";
        }
        return array('browser_name' => $bname, 'version' => $version);
    }

    function arsocial_lite_get_more_networks() {
        global $wpdb, $arsocial_lite;

        $ars_lite_default_networks = $arsocial_lite->ARSocialShareDefaultNetworks();
        $ars_lite_default_networks = $ars_lite_default_networks['networks'];
        $skin = isset($_POST['theme']) ? $_POST['theme'] : 'default';
        $show_counter = isset($_POST['counter']) ? $_POST['counter'] : 'yes';
        $hover_effect = isset($options['display']['hover_effect']) ? $options['display']['hover_effect'] : '';
        $remove_space = (isset($options['display']['remove_space']) && $options['display']['remove_space'] == 'yes') ? 'ars_remove_space' : '';
        $display_type = isset($_POST['display_from']) ? $_POST['display_from'] : 'page';
        $button_style = isset($_POST['button_style']) ? $_POST['button_style'] : 'name_with_icon';
        $button_width = isset($_POST['button_width']) ? $_POST['button_width'] : 'medium';
        $btn_width = 'ars_' . $button_width . '_btn';
        $custom_names = isset($_POST['custom_names']) ? json_decode(stripslashes_deep($_POST['custom_names']), true) : array();

        if ($display_type === 'sidebar') {
            $button_style = 'name_with_icon';
        }
        if ($display_type === 'sidebar' && $skin === 'rolling') {
            $skin = 'default';
        }
        $btn_style = 'ars_' . $button_style;
        $hover_effect = isset($_POST['effect']) ? $_POST['effect'] : 'effect1';
        $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $network_id = isset($_POST['network_id']) ? $_POST['network_id'] : '-100';
        $number_format = isset($_POST['number_format']) ? $_POST['number_format'] : '';
        if ($network_id === '-100') {
            $options = maybe_unserialize(get_option('arslite_networks_display_setting'));
            $networks = $options['networks'];
        } else {
            $data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}arsocial_lite_networks WHERE network_id = {$network_id}");
            $options = maybe_unserialize($data->network_settings);
            $networks = $options['enabled_network'];
        }

        $response = array();
        $html = "";
        $global_settings = maybe_unserialize(get_option('arslite_global_settings'));
        if (count($networks) > 0 && is_array($networks) && !empty($networks)) {
            $response['status'] = true;
            $html .= "<div class='arsocial_lite_more_network_model' id='arsocial_lite_more_network_model'>";
            $html .= "<div class='arsocialshare_more_networks_inner_wrapper'>";
            $html .= "<div class='arsocialshare_more_networks_top_belt'>";
            $html .= "<div class='arsocial_lite_model_close_btn'></div>";
            $html .= "</div>";
            $html .= "<div class='arsocialshare_model_share_button_wrapper'>";
            $html .= "<div class='arsocialshare_buttons_wrapper arsocialshare_" . $skin . "_theme arseffect_{$hover_effect} {$remove_space}'>";

            $counter_networks = $arsocial_lite->ars_lite_share_networklist_sharecounter();

            foreach ($networks as $key => $network) {

                $shorturl = get_permalink($post_id);

                if (@in_array('desktop', $ars_lite_default_networks[$network]['plateform'])) {
                    $html .= "<div class='arsocialshare_button {$btn_style} {$network} arsocial_lite_{$network}_wrapper $btn_width' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='$post_id' data-network-id='$network_id' onclick='javascript:arsocialshare_window(\"{$this->arsocialshare_url($network)}\",\"" . $shorturl . "\",\"" . get_the_title($post_id) . "\",\"{$network}\",\"{$post_id}\" ,\"{$this->get_media_url($post_id)}\",jQuery(this))'>";
                    $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_" . $skin . "_theme_icon socialshare-{$network} arsocial_lite_{$network}_icon'></span>";
                    $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label'>" . @$custom_names[$network] . "</label>";
                    if ($show_counter === 'yes' && in_array($network, $counter_networks)) {
                        $html .= "<div class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</div>";
                    } else {
                        $html .= "<div style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></div>";
                    }
                    $html .= "</div>";
                } else {
                    if (wp_is_mobile() && @in_array('mobile', $ars_lite_default_networks[$network]['plateform'])) {
                        $html .= "<div class='arsocialshare_button {$network} $btn_width ars_$button_style arsocial_lite_{$network}_wrapper' id='arsocialshare_{$network}_btn' data-network='{$network}' data-page-id='{$post_id}' data-network-id='{$network_id}' >";
                        $html .= "<a href='" . $this->get_share_url($network) . "'>";
                        $html .= "<span class='arsocialshare_network_btn_icon arsocialshare_{$skin}_theme_icon arsocial_lite_{$network}_icon socialshare-{$network}'></span>";
                        $html .= "<label class='arsocialshare_network_name arsocial_lite_{$network}_label' id='arsocial_lite_{$network}_label'>" . @$custom_names[$network] . "</label>";

                        if (in_array($network, $counter_networks) && $show_counter == 'yes') {
                            $html .= "<span class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'>" . $this->ars_share_set_fan_counter($this->get_counter($network, $post_id), $number_format) . "</span>";
                        } else {
                            $html .= "<span style='display:none;' class='arsocialshare_counter arsocial_lite_{$network}_counter' id='arsocial_lite_{$network}_counter'></span>";
                        }
                        $html .= "</a>";
                        $html .= "</div>";
                    }
                }
            }
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
            $response['content'] = $html;
        } else {
            $response['status'] = false;
        }
        echo json_encode($response);
        die();
    }

    function arsocial_lite_save_sharing_order() {
        $network_position = isset($_POST['arsnetworks_in_position']) ? $_POST['arsnetworks_in_position'] : '';

        if (is_array($network_position) && !empty($network_position)) {
            $positions = maybe_serialize($network_position);
            update_option('arslite_global_sharing_order', $positions);
        }
        die();
    }

    function ars_get_filter_content($post_id, $content, $settings) {
        $changed_content = "";
        $post_type = get_post_type($post_id);
        $display_settings = $settings['display'];
        $mobile_display = isset($display_settings['hide_mobile']) ? $display_settings['hide_mobile'] : array();
        $more_btn_after = isset($display_settings['more_button']['after']) ? $display_settings['more_button']['after'] : '0';
        $more_btn_style = isset($display_settings['more_button']['style']) ? $display_settings['more_button']['style'] : 'plus_icon';
        $more_btn_action = isset($display_settings['more_button']['action']) ? $display_settings['more_button']['action'] : 'display_inline';
        $button_witdh_type = isset($display_settings['button_width']) ? $display_settings['button_width'] : 'automatic';
        $fixed_btn_width = (isset($display_settings['fixed_button_width']) && $display_settings['fixed_button_width'] !== '') ? $display_settings['fixed_button_width'] : "0";
        $full_button_width = (isset($display_settings['full_button_width']) && $display_settings['full_button_width'] !== '') ? $display_settings['full_button_width'] : "0";
        $button_skin = isset($display_settings['skin']) ? $display_settings['skin'] : 'default';
        $button_style = isset($display_settings['button_style']) ? $display_settings['button_style'] : 'name_with_icon';
        $hover_effect = isset($display_settings['hover_effect']) ? $display_settings['hover_effect'] : '';
        $remove_space = (isset($display_settings['remove_space'])) ? $display_settings['remove_space'] : '';
        $show_counter = (isset($display_settings['show_counter'])) ? $display_settings['show_counter'] : '';
        /**
         * Sidebar Options
         */
        $sidebar = 'false';
        $sidebarOptions = isset($display_settings['sidebar']) ? $display_settings['sidebar'] : array();
        $exclude_post_id_sidebar = array();
        $sidebarOptions['exclude_pages'] = isset($sidebarOptions['exclude_pages']) ? $sidebarOptions['exclude_pages'] : '';
        if ($sidebarOptions['exclude_pages'] !== '') {
            $exclude_post_id_sidebar = explode(',', $sidebarOptions['exclude_pages']);
        }
        if (!empty($exclude_post_id_sidebar) && in_array($post_id, $exclude_post_id_sidebar)) {
            
        } else {
            $sidebar = isset($display_settings['sidebar']) ? 'true' : 'false';
            $sidebarOptions['button_style'] = isset($sidebarOptions['button_style']) ? $sidebarOptions['button_style'] : 'name_with_icon';
            $sidebarOptions['hover_effect'] = isset($sidebarOptions['hover_effect']) ? $sidebarOptions['hover_effect'] : $hover_effect;
            $sidebarOptions['button_width'] = isset($sidebarOptions['button_width']) ? $sidebarOptions['button_width'] : 'medium';
            $sidebarOptions['exclude_pages'] = isset($sidebarOptions['exclude_pages']) ? $sidebarOptions['exclude_pages'] : '';
            $sidebar_argument = " is_sidebar='$sidebar'";
            $exclude_post_id_sidebar = array();
            if ($sidebarOptions['exclude_pages'] !== '') {
                $exclude_post_id_sidebar = explode(',', $sidebarOptions['exclude_pages']);
            }
            if (isset($sidebarOptions) && !empty($sidebarOptions)) {
                foreach ($sidebarOptions as $s_key => $s_val) {
                    $sidebar_argument .= " sidebar_{$s_key}='{$s_val}'";
                }
            }
        }

        /**
         * Popup Options
         */
        $popup = isset($display_settings['popup']) ? 'true' : 'false';
        $popupOptions = isset($display_settings['popup']) ? $display_settings['popup'] : array();

        $popupOptions['display_popup_on'] = isset($popupOptions['display_popup_on']) ? $popupOptions['display_popup_on'] : '';

        $popupOptions['is_close_button'] = isset($popupOptions['enable_close']) ? $popupOptions['enable_close'] : 'false';
        $popupOptions['close_button'] = isset($popupOptions['enable_close']) ? $popupOptions['enable_close'] : 'false';
        $popupOptions['button_style'] = isset($popupOptions['btn_style']) ? $popupOptions['btn_style'] : 'name_with_icon';
        $popupOptions['hover_effect'] = isset($popupOptions['hover_effect']) ? $popupOptions['hover_effect'] : $hover_effect;
        $popupOptions['width'] = isset($popupOptions['width']) ? $popupOptions['width'] : '';
        $popupOptions['height'] = isset($popupOptions['height']) ? $popupOptions['height'] : '';
        $popupOptions['button_width'] = isset($popupOptions['button_width']) ? $popupOptions['button_width'] : 'automatic';

        $popup_argument = " is_popup='$popup'";

        $popupOptions['exclude_pages'] = isset($popupOptions['exclude_pages']) ? $popupOptions['exclude_pages'] : '';
        $exclude_post_id_popup = array();
        if ($popupOptions['exclude_pages'] !== '') {
            $exclude_post_id_popup = explode(',', $popupOptions['exclude_pages']);
        }

            if (isset($popupOptions) && !empty($popupOptions)) {
                if (!empty($exclude_post_id_popup) && in_array($post_id, $exclude_post_id_popup)) {
                    $popup = 'false';
                }
                foreach ($popupOptions as $s_key => $s_val) {
                    $popup_argument .= " popup_{$s_key}='{$s_val}'";
                }
            }

        $is_custom_css_add = false;

        /**
         * Mobile Options
         */
        $mobile_argument = $mobile = '';
        $mobile_hide_top = $mobile_hide_bottom = $mobile_hide_floating = $mobile_hide_sidebar = $mobile_hide_flyin = $mobile_hide_popup = false;
        if (wp_is_mobile()) {
            $mobile = isset($display_settings['mobile']) ? 'true' : 'false';
            $mobile_button_skin = isset($display_settings['mobile']['skin']) ? $display_settings['mobile']['skin'] : '';
            $mobile_display_type = isset($display_settings['mobile']['disply_type']) ? $display_settings['mobile']['disply_type'] : '';
            $mobile_more_button_type = isset($display_settings['mobile']['more_button_style']) ? $display_settings['mobile']['more_button_style'] : '';
            $mobile_bottom_bar_label = isset($display_settings['mobile']['bar_label']) ? $display_settings['mobile']['bar_label'] : '';
            $mobile_share_point_position = isset($display_settings['mobile']['button_position']) ? $display_settings['mobile']['button_position'] : '';
            $mobile_argument = " is_mobile='{$mobile}' mobile_display_type='{$mobile_display_type}' mobile_more_button_type='{$mobile_more_button_type}' mobile_bottom_bar_label='{$mobile_bottom_bar_label}' mobile_share_point_position='{$mobile_share_point_position}'";

            $mobile_hide_top = isset($mobile_display['enable_mobile_hide_top']) ? true : false;
            $mobile_hide_bottom = isset($mobile_display['enable_mobile_hide_bottom']) ? true : false;
            $mobile_hide_floating = isset($mobile_display['enable_mobile_hide_floating']) ? true : false;
            $mobile_hide_sidebar = isset($mobile_display['enable_mobile_hide_sidebar']) ? true : false;
            $mobile_hide_flyin = isset($mobile_display['enable_mobile_hide_flyin']) ? true : false;
            $mobile_hide_popup = isset($mobile_display['enable_mobile_hide_onload']) ? true : false;
        }


        /**
         * Top bottom bar Options
         */
        $top_bottom_bar = isset($display_settings['top_bottom_bar']) ? 'true' : 'false';

        $top_bottom_bar_options = isset($display_settings['top_bottom_bar']) ? $display_settings['top_bottom_bar'] : array();
        $top_bottom_bar_options['button_style'] = isset($top_bottom_bar_options['button_style']) ? $top_bottom_bar_options['button_style'] : 'name_with_icon';
        $top_bottom_bar_options['hover_effect'] = isset($top_bottom_bar_options['hover_effect']) ? $top_bottom_bar_options['hover_effect'] : 'effect1';
        $top_bottom_bar_options['button_width'] = isset($top_bottom_bar_options['button_width']) ? $top_bottom_bar_options['button_width'] : 'ars_top_bottom_btn_medium';
        $top_bottom_bar_options['exclude_pages'] = isset($top_bottom_bar_options['exclude_pages']) ? $top_bottom_bar_options['exclude_pages'] : '';

        $top_bottom_bar_argument = " is_top_bottom_bar='$top_bottom_bar'";

        $exclude_post_id_top_bottom_bar = array();
        if ($top_bottom_bar_options['exclude_pages'] !== '') {
            $exclude_post_id_top_bottom_bar = explode(',', $top_bottom_bar_options['exclude_pages']);
        }
        if (isset($top_bottom_bar_options) && !empty($top_bottom_bar_options)) {
            if (!empty($exclude_post_id_top_bottom_bar) && in_array($post_id, $exclude_post_id_top_bottom_bar)) {
                $top_bottom_bar = 'false';
            }
            foreach ($top_bottom_bar_options as $s_key => $s_val) {
                $top_bottom_bar_argument .= " top_bottom_bar_{$s_key}='{$s_val}'";
            }
        }


        // SITE WIDE OPTIONS $fly_in == 'true' ||
        if ($sidebar == 'true' || $top_bottom_bar == 'true' || $mobile == 'true') {

            if ($sidebar == 'true') {

                $is_total_shares = isset($sidebarOptions['enable_total_counter']) ? $sidebarOptions['enable_total_counter'] : false;
                $total_share_label = isset($sidebarOptions['arsocial_total_share_label']) ? $sidebarOptions['arsocial_total_share_label'] : '';
                $total_count_position = 'top';

                $is_custom_css_add = true;
                $sidebarposition = isset($sidebarOptions['position']) ? $sidebarOptions['position'] : 'left';

                $button_skin = isset($sidebarOptions['skin']) ? $sidebarOptions['skin'] : 'default';
                //$remove_space = isset($sidebarOptions['remove_space']) ? $sidebarOptions['remove_space'] : 'yes';
                $more_btn_after = isset($sidebarOptions['more_button']) ? $sidebarOptions['more_button'] : '5';
                $more_btn_style = isset($sidebarOptions['more_btn_style']) ? $sidebarOptions['more_btn_style'] : 'plus_icon';
                $more_btn_action = isset($sidebarOptions['more_btn_action']) ? $sidebarOptions['more_btn_action'] : 'display_popup';
                $show_counter = isset($sidebarOptions['show_counter']) ? $sidebarOptions['show_counter'] : '0';

                $no_format = isset($sidebarOptions['no_format']) ? $sidebarOptions['no_format'] : 'style5';

                $changed_content .= "<div class='arsocialshare_network_button_settings arsocialshare_button_sidebar  arsocialshare_align_{$sidebarposition}'>";
                $shortcode_content = "[ARSocial_Lite_Share_Main networks=";
                $shortcode_content .= implode('|', $settings['networks']);
                if (!$mobile_hide_sidebar) {
                    $shortcode_content .= $sidebar_argument;
                }



                $sidebar_remove_space = (isset($sidebarOptions['remove_space']) && $sidebarOptions['remove_space'] === 'yes' ) ? 'yes' : 'no';

                $shortcode_content .= " theme='{$button_skin}' sidebar_remove_space='{$sidebar_remove_space}' more_btn='{$more_btn_after}' more_btn_style='{$more_btn_style}' more_btn_action='{$more_btn_action}' show_counter='{$show_counter}' is_total_share='{$is_total_shares}' total_share_label='{$total_share_label}' total_count_position='{$total_count_position}' no_format='{$no_format}' ";

                $shortcode_content .= "]";

                $changed_content .= do_shortcode($shortcode_content);
                $changed_content .= "</div>";
            }

            /* 26-02-2016 */

            if ($mobile == 'true') {
                $is_custom_css_add = true;
                $sidebarposition = isset($sidebarOptions['position']) ? $sidebarOptions['position'] : 'left';
                $button_skin = $mobile_button_skin;
                $remove_space = 'yes';
                $show_counter = isset($popupOptions['show_counter']) ? $popupOptions['show_counter'] : '0';

                $changed_content .= "<div class='arsocialshare_network_button_settings'>";
                $shortcode_content = "[ARSocial_Lite_Share_Main networks=";
                $shortcode_content .= implode('|', $settings['networks']);
                if ($mobile == 'true') {
                    $shortcode_content .= $mobile_argument;
                }
                $shortcode_content .= " theme='{$mobile_button_skin}' remove_space='yes' show_counter='{$show_counter}' ";
                if ($mobile == 'true') {
                    $shortcode_content .= " button_style='{$button_style}'";
                    $shortcode_content .= " button_width='medium' show_counter='{$show_counter}'";
                }
                $shortcode_content .= "]";
                $changed_content .= do_shortcode($shortcode_content);
                $changed_content .= "</div>";
            }

            if ($top_bottom_bar == 'true') {
                $is_custom_css_add = true;

                if (wp_is_mobile() && isset($display_settings['hide_mobile']['enable_mobile_hide_top_bottom_bar']) && !empty($display_settings['hide_mobile']['enable_mobile_hide_top_bottom_bar'])) {
                    
                } else {
                    $top_bottom_bar_position = isset($top_bottom_bar_options['btn_alignment']) ? $top_bottom_bar_options['btn_alignment'] : 'left';
                    $button_skin = isset($top_bottom_bar_options['skin']) ? $top_bottom_bar_options['skin'] : 'default';
                    $bar_remove_space = isset($top_bottom_bar_options['bar_remove_space']) ? $top_bottom_bar_options['bar_remove_space'] : 'no';
                    $more_btn_after = isset($top_bottom_bar_options['more_button']) ? $top_bottom_bar_options['more_button'] : '5';
                    $more_btn_style = isset($top_bottom_bar_options['more_btn_style']) ? $top_bottom_bar_options['more_btn_style'] : 'plus_icon';
                    $more_btn_action = isset($top_bottom_bar_options['more_btn_action']) ? $top_bottom_bar_options['more_btn_action'] : 'display_popup';
                    $show_counter = isset($top_bottom_bar_options['show_counter']) ? $top_bottom_bar_options['show_counter'] : '0';

                    $is_total_shares = isset($top_bottom_bar_options['enable_total_counter']) ? $top_bottom_bar_options['enable_total_counter'] : false;
                    $total_share_label = isset($top_bottom_bar_options['arsocial_total_share_label']) ? $top_bottom_bar_options['arsocial_total_share_label'] : '';
                    $total_count_position = isset($top_bottom_bar_options['total_counter_position']) ? $top_bottom_bar_options['total_counter_position'] : 'left';

                    $no_format = isset($top_bottom_bar_options['no_format']) ? $top_bottom_bar_options['no_format'] : 'style5';

                    if (isset($top_bottom_bar_options['top']) && !empty($top_bottom_bar_options['top'])) {
                        $changed_content .= "<div class='arsocialshare_network_button_settings arsocialshare_align_{$top_bottom_bar_position}'>";
                        $shortcode_content = "[ARSocial_Lite_Share_Main networks=";
                        $shortcode_content .= implode('|', $settings['networks']);

                            $shortcode_content .= $top_bottom_bar_argument;

                        $shortcode_content .= " theme='{$button_skin}' bar_remove_space='{$bar_remove_space}' more_btn='{$more_btn_after}' more_btn_style='{$more_btn_style}' more_btn_action='{$more_btn_action}' show_counter='{$show_counter}' is_total_share='{$is_total_shares}' total_share_label='{$total_share_label}' total_count_position='{$total_count_position}' no_format='{$no_format}' ";
                        $shortcode_content .= " display_top='1'";
                        $shortcode_content .= "]";
                        $changed_content .= do_shortcode($shortcode_content);
                        $changed_content .= "</div>";
                    }

                    if (isset($top_bottom_bar_options['bottom']) && !empty($top_bottom_bar_options['bottom'])) {
                        $changed_content .= "<div class='arsocialshare_network_button_settings arsocialshare_align_{$top_bottom_bar_position}'>";
                        $shortcode_content = "[ARSocial_Lite_Share_Main networks=";
                        $shortcode_content .= implode('|', $settings['networks']);

                            $shortcode_content .= $top_bottom_bar_argument;

                        $shortcode_content .= " theme='{$button_skin}' bar_remove_space='{$bar_remove_space}' more_btn='{$more_btn_after}' more_btn_style='{$more_btn_style}' more_btn_action='{$more_btn_action}' show_counter='{$show_counter}' is_total_share='{$is_total_shares}' total_share_label='{$total_share_label}' total_count_position='{$total_count_position}' no_format='{$no_format}' ";
                        $shortcode_content .= " display_bottom='1'";
                        $shortcode_content .= "]";
                        $changed_content .= do_shortcode($shortcode_content);
                        $changed_content .= "</div>";
                    }
                }
            }

            /* 26-02-2016 */
        }

        if (array_key_exists($post_type, $display_settings)) {
            $set_opt = $display_settings[$post_type];

            $exclude_pages = (isset($set_opt['exclude_pages']) && $set_opt['exclude_pages'] !== '') ? $set_opt['exclude_pages'] : '';
            $exclude_page_ids = array();
            $exclude_page_ids = explode(',', $exclude_pages);

            if (in_array($post_id, $exclude_page_ids)) {
                $changed_content .= $content;
            } else {
                $display_top = (isset($set_opt['top']) && $set_opt['top']) ? true : false;
                $display_bottom = (isset($set_opt['bottom']) && $set_opt['bottom'] ) ? true : false;
                $display_float = (isset($set_opt['floating']) && $set_opt['floating'] !== 'no' ) ? true : false;
                $remove_space = (isset($set_opt['remove_space']) && $set_opt['remove_space'] === 'yes' ) ? 'yes' : 'no';
                $button_align = isset($set_opt['btn_align']) ? $set_opt['btn_align'] : "center";
                $button_skin = isset($set_opt['skin']) ? $set_opt['skin'] : 'default';
                $hover_effect = isset($set_opt['hover_effect']) ? $set_opt['hover_effect'] : 'effect1';
                $button_style = isset($set_opt['btn_style']) ? $set_opt['btn_style'] : 'name_with_icon';
                $button_width = isset($set_opt['btn_width']) ? $set_opt['btn_width'] : 'medium';
                $show_page_counter = (isset($set_opt['show_counter']) && $set_opt['show_counter'] !== 'no' ) ? $set_opt['show_counter'] : 'no';
                $more_btn_after = isset($set_opt['more_btn']) ? $set_opt['more_btn'] : '0';
                $more_btn_style = isset($set_opt['more_btn_style']) ? $set_opt['more_btn_style'] : 'plus_icon';
                $more_btn_action = isset($set_opt['more_btn_act']) ? $set_opt['more_btn_act'] : 'display_popup';

                if ($post_type == 'post') {
                    $button_align = explode('_', $button_align);
                    $button_align = $button_align[2];
                }

                $is_total_shares = isset($set_opt['enable_total_counter']) ? $set_opt['enable_total_counter'] : false;
                $total_share_label = isset($set_opt['arsocial_total_share_label']) ? $set_opt['arsocial_total_share_label'] : '';
                $total_count_position = isset($set_opt['total_counter_position']) ? $set_opt['total_counter_position'] : 'left';

                $no_format = isset($set_opt['no_format']) ? $set_opt['no_format'] : 'style5';

                $mainShortcodeArgs = " networks='" . implode('|', $settings['networks']) . "' theme='{$button_skin}' button_style='{$button_style}' hover_effect='{$hover_effect}' remove_space='{$remove_space}' more_btn='{$more_btn_after}' more_btn_style='{$more_btn_style}' more_btn_action='{$more_btn_action}' button_width='{$button_width}' fixed_btn_width='{$fixed_btn_width}' full_button_width='{$full_button_width}' show_counter='{$show_page_counter}' is_total_share='{$is_total_shares}' total_share_label='{$total_share_label}' total_count_position='{$total_count_position}' no_format='{$no_format}' ";
                if ($display_top) {
                    $is_custom_css_add = true;
                    $isadminbarvisible = (is_admin_bar_showing()) ? "wp_bar_visible" : "";

                        $enable_float = ($display_float) ? true : false;

                    $changed_content .= "<div class='arsocialshare_network_button_settings arsocial_lite_top_button arsocialshare_align_{$button_align} {$isadminbarvisible}' data-enable-floating='$enable_float' id='arsocial_lite_top_button'>";
                    $shortcode_content = "[ARSocial_Lite_Share_Main is_display_top='true' {$mainShortcodeArgs} ]";
                    $changed_content .= do_shortcode($shortcode_content);
                    $changed_content .= "</div>";
                }
                $changed_content .= $content;
                if ($display_bottom) {

                        $enable_float = ($display_float) ? "ars_sticky_bottom_belt" : "";
                    
                    $changed_content .= "<div class='arsocialshare_network_button_settings arsocial_lite_bottom_button  arsocialshare_align_{$button_align} {$enable_float}' id='arsocial_lite_bottom_button '>";
                    $shortcode_content = "[ARSocial_Lite_Share_Main is_display_bottom='true' {$mainShortcodeArgs} ]";
                    $changed_content .= do_shortcode($shortcode_content);
                    $changed_content .= "</div>";
                }
            }
        } else {
            $changed_content .= $content;
        }
        if ($is_custom_css_add) {
            $changed_content .= '<style>';
            $changed_content .= isset($display_settings['arsocialshare_custom_css']) ? $display_settings['arsocialshare_custom_css'] : '';
            $changed_content .= '</style>';
        }
        return $changed_content;
    }


    function get_media_url($post_id) {

        $media_image = '';
        if (!empty($post_id)) {
            $media_image = wp_get_attachment_url(get_post_thumbnail_id($post_id));
        }
        if (empty($media_image)) {
            $post_content = get_post_field('post_content', $post_id);
            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
            if (isset($matches[1]) && !empty($matches[1])) {
                $media_image = $matches[1][0];
            }
        }
        return $media_image;
    }

    function ars_share_set_fan_counter($counter, $format) {
        $counter = isset($counter) ? $counter : 0;
        $counter = $this->change_current_formated_counter_to_value($counter);

        $format = isset($format) ? $format : 'style1';

        switch ($format) {
            case 'style1':
                $counter = number_format($counter, 0, '', '');
                break;
            case 'style2':
                $counter = number_format($counter, 0, '', '.');
                break;
            case 'style3':
                $counter = number_format($counter, 0, '', ',');
                break;
            case 'style4':
                $counter = number_format($counter, 0, '', ' ');
                break;
            case 'style5':
                $counter = $this->ars_count_letter_conversion($counter);
                break;
        }

        return $counter;
    }

    function ars_count_letter_conversion($number) {

        $decPlace = pow(10, 1);

        $abbr = array('k', 'm', 'b', 't');

        for ($i = (count($abbr) - 1); $i >= 0; $i--) {

            $size = pow(10, (($i + 1) * 3));

            if ($size <= $number) {

                $number = (round(($number * $decPlace) / $size)) / $decPlace;
                if (($number == 1000) && ($i < (count($abbr) - 1))) {
                    $number = 1;
                    $i++;
                }


                $number = $number . $abbr[$i];
                break;
            }
        }

        return $number;
    }

    function change_current_formated_counter_to_value($counter) {

        if (strpos(strtolower($counter), 'k')) {
            $counter = (intval($counter) * 1000);
        }

        if (strpos(strtolower($counter), 'm')) {
            $counter = (intval($counter) * 1000000);
        }

        if (strpos(strtolower($counter), 'b')) {
            $counter = (intval($counter) * 1000000000);
        }
        return $counter;
    }

    function arsocial_media_sharing($content, $settings) {
        global $arsocial_lite;
        if (is_array($settings)) {
            if (!array_key_exists('media', $settings['display'])) {
                return $content;
            }
        }

        $media_settings = $settings['display']['media'];

        $theme = isset($media_settings['skin']) ? $media_settings['skin'] : '';

        $position = $media_settings['position'];
        $hover_effect = $media_settings['hover_effect'];
        $networks = implode('|', $settings['networks']);
        $more_button = $media_settings['more_btn'];
        $more_button_style = $media_settings['more_btn_style'];
        $more_button_action = $media_settings['more_btn_act'];
        $disable_height = isset($media_settings['disable_height']) ? $media_settings['disable_height'] : '';
        $disable_width = isset($media_settings['disable_width']) ? $media_settings['disable_width'] : '';
        $media_settings['background_color_enable'] = isset($media_settings['background_color_enable']) ? $media_settings['background_color_enable'] : 'no';
        $div = '';
        if ($media_settings['background_color_enable'] == 'yes') {
            $color = isset($media_settings['background_color']) ? $media_settings['background_color'] : '#ededed';
            $opacity = isset($media_settings['background_opacity']) ? $media_settings['background_opacity'] : '0.5';
            $color = $this->hex2rgb($color);
            $new_color = 'rgba(' . $color["red"] . ',' . $color["green"] . ',' . $color["blue"] . ',' . $opacity . ')';
            $div .='<style>.arsocialshare_media_share_inner_wrapper{background-color : ' . $new_color . '}</style>';
        }

        $shortcode_content = "[ARSocial_Lite_Share_Main networks='{$networks}' theme='{$theme}' button_style='icon_without_name' hover_effect='{$hover_effect}' remove_space='no' more_btn='{$more_button}' more_btn_style='{$more_button_style}' more_btn_action='{$more_button_action}' button_width='small' show_counter='no' is_display_top='true']";

        $div .= "<div class='arsocialshare_media_share_wrapper $position $hover_effect theme_$theme'>";
        $div .= "<div class='arsocialshare_media_share_inner_wrapper $position'>";
        $div .= do_shortcode($shortcode_content);
        $div .= "</div>";
        $div .= "</div>";

        if (trim($content) !== '') {
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();

            $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
            $new_div = $dom->createElement('div');
            $new_div->setAttribute('class', 'arsocialshare_media_wrapper');
            $ImageList = $dom->getElementsByTagName('img');

            if (!empty($ImageList)) {
                foreach ($ImageList as $key => $Image) {
                    $image_width = (int) $Image->getAttribute('width');
                    $image_height = (int) $Image->getAttribute('height');
                    $new_div->setAttribute('style', 'height:' . $image_height . 'px;width:' . $image_width . 'px;');
                    if ($image_width >= $disable_width && $image_height >= $disable_height) {
                        if ($Image->parentNode->nodeName === 'a') {
                            $class_names = $Image->parentNode->getAttribute('class');
                            $Image->parentNode->setAttribute('class', $class_names . ' arsocialshare_media_wrapper');
                            $Image->parentNode->setAttribute('style', 'height:' . $image_height . 'px;width:' . $image_width . 'px;');
                        } else {
                            $new_div_clone = $new_div->cloneNode();
                            $Image->parentNode->replaceChild($new_div_clone, $Image);
                            $new_div_clone->appendChild($Image);
                        }
                    }
                }
            }
            $content = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace(array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
        }

        return $content . $div;
    }

    function hex2rgb($colour) {

        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list( $r, $g, $b ) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list( $r, $g, $b ) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('red' => $r, 'green' => $g, 'blue' => $b);
    }

    function arsocialsharelite_fb_extended_token( $app_id = '', $app_secret = '', $access_token = '' ) {
		$extended_token = '';
		$app_id         = $_REQUEST['fb_app_id'];
		$app_secret     = $_REQUEST['fb_app_secret'];
		$access_token   = $_REQUEST['fb_access_token'];
		if ( $access_token == '' || $app_id == '' || $app_secret == '' ) {
			echo json_encode(
				array(
					'error'   => true,
					'message' => esc_html__(
						'Please check your facebook details',
						'arsocial_lite'
					),
				)
			);
		} else {
			$url       = "https://graph.facebook.com/oauth/access_token?client_id={$app_id}&client_secret={$app_secret}&grant_type=fb_exchange_token&fb_exchange_token={$access_token}";
			$arguments = array(
				'method'      => 'GET',
				'timeout'     => 120,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(
					'Content-Type' => 'application/json',
				),
				'body'        => null,
			);

			$response = wp_remote_post( $url, $arguments );

			$obj = $response['body'];

			if ( preg_match( '/(access_token)/i', $obj ) ) {
				$obj = json_decode( $obj );
				if ( json_last_error() == JSON_ERROR_NONE ) {
					$access_token = $obj->access_token;
					$expiry       = current_time( 'timestamp' ) + $obj->expires_in;
				} else {
					$token        = explode( '&', $obj );
					$exp_token    = $token[0];
					$token_expiry = $token[1];
					$ac_token     = explode( '=', $exp_token );
					$access_token = $ac_token[1];
					$token_exp    = explode( '=', $token_expiry );
					$expiry       = current_time( 'timestamp' ) + $token_exp[1];
				}
				
				$expiry_formatted = date( get_option( 'date_format' ), $expiry );
				
				echo json_encode(
					array(
						'error'            => false,
						'access_token'     => $access_token,
						'expiry'           => $expiry,
						'formatted_expiry' => $expiry_formatted,
					)
				);
			} else {
				$obj        = json_decode( $obj );
				$error_code = $obj->error->code;

				switch ( $error_code ) {
					case 190:
						echo json_encode(
							array(
								'error'   => true,
								'message' => esc_html__(
									'Your access token is expired, Please issue new one.',
									'arsocial_lite'
								),
							)
						);
						break;
					case 101:
						echo json_encode(
							array(
								'error'   => true,
								'message' => esc_html__(
									'Invalid Application ID',
									'arsocial_lite'
								),
							)
						);
						break;
					case 1:
						echo json_encode(
							array(
								'error'   => true,
								'message' => esc_html__(
									'Invalid Application Secret',
									'arsocial_lite'
								),
							)
						);
						break;
					default:
						echo json_encode(
							array(
								'error'   => true,
								'message' => esc_html__(
									'Please check your facebook details',
									'arsocial_lite'
								),
							)
						);
						break;
				}
			}
		}
		die();
	}



}

?>