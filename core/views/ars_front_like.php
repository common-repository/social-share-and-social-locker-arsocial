<?php

if (!function_exists('arsocial_lite_like_view')) {

    function arsocial_lite_like_view($id = '') {
        global $wpdb, $arsocial_lite_like;
        $response = array();
        if (empty($id)) {
            $response['message'] = "error";
            $response['body'] = esc_html__('Network ID is empty or Invalid. Please select valid Network', 'arsocial_lite');
            $response = apply_filters('arsocial_lite_like_view_msg', $response);
            return json_encode($response);
        }


        $like_table = $wpdb->prefix . 'arsocial_lite_like';
        $get_like = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$like_table` WHERE ID = %d", $id));

        if (empty($get_like)) {
            $response['message'] = "error";
            $response['body'] = esc_html__('', 'arsocial_lite');
            $response = apply_filters('arsocial_lite_like_view_msg', $response);
            return json_encode($response);
        }

        $saved_like_networks_global = maybe_unserialize($get_like->content);

        $display_option = isset($saved_like_networks_global['display']) ? $saved_like_networks_global['display'] : array();

        $load_native_buttons = isset($display_option['load_native_btn']) ? $display_option['load_native_btn'] : false;

        $load_native_buttons = ($load_native_buttons == 'yes') ? true : false;

        $btn_width = isset($display_option['btn_width']) ? $display_option['btn_width'] : '';
        $nativeClass = '';
        if ($load_native_buttons == '1') {
            $load_native_skin = isset($display_option['skin']) ? $display_option['skin'] : 'skin3';
        }
        $nativeClass = '';
        if ($load_native_buttons) {
            $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
        } else {
            $nativeClass = 'ars_like_' . $btn_width;
        }
        $html = '';
        $settings = array();
        $html .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";

        $gs_settings = get_option('arslite_global_settings');
        if ($gs_settings !== '') {
            $gs_settings = maybe_unserialize($gs_settings);
        }

        if ($saved_like_networks_global !== '') {
            $settings = maybe_unserialize($saved_like_networks_global);
        }

        $html .= "<input type='hidden' name='ars_global_like_settings' id='ars_global_like_settings' value='" . json_encode($gs_settings) . "' />";
        $html .= "<input type='hidden' name='ars_like_shortcode_settings' id='ars_like_shortcode_settings' value='" . json_encode($settings) . "' />";
        


        /* Sorting Networks */

        $sorted_fan_option = $display_option['network_order'];
        $new_sorted_fan_networks = array();
        if (!empty($sorted_fan_option) && is_array($sorted_fan_option)) {
            foreach ($sorted_fan_option as $key => $network) {
                $new_sorted_fan_networks[$network] = @$saved_like_networks_global[$network];
            }
            $new_sorted_fan_networks['display'] = $saved_like_networks_global['display'];
        }

        $post = get_post();
        $post_type = $post->post_type;

        $display_type = isset($display_option['display_type']) ? $display_option['display_type'] : 'page';
        $button_align = isset($display_option['align']) ? $display_option['align'] : 'ars_align_center';
        $btn_width = isset($display_option['btn_width']) ? $display_option['btn_width'] : 'small';

        if ($display_type == 'page') {
            $html .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_{$button_align} arsociallike_page_button'  id='arsociallike_page_button'>";
            $html .= $arsocial_lite_like->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_buttons);
            $html .= '</div>';
        } else if ($display_type == 'popup') {
            $popup = 'true';
            $popup_option = isset($display_option['popup']) ? $display_option['popup'] : array();
            $popup_type = isset($popup_option['display_popup']) ? $popup_option['display_popup'] : 'onload';

            $popup_open_delay = isset($popup_option['onload_time']) ? $popup_option['onload_time'] : '0';
            $popup_open_scroll = isset($popup_option['onscroll_percentage']) ? $popup_option['onscroll_percentage'] : '50';
            $popup_width = isset($popup_option['popup_width']) ? $popup_option['popup_width'] : '500';
            $popup_height = isset($popup_option['popup_height']) ? $popup_option['popup_height'] : '500';
            $popup_button_width = isset($popup_option['btn_width']) ? $popup_option['btn_width'] : '';
            $popup_is_close_button = (isset($popup_option['is_close_button']) && $popup_option['is_close_button'] == 'yes' ) ? 'true' : 'false';



            $popup_style = '';
            if (isset($popup_width) && !empty($popup_width)) {
                $popup_style .= "width: " . $popup_width . "px;";
            }
            if (isset($popup_height) && !empty($popup_height)) {
                $popup_style .= " height: " . $popup_height . "px;";
            }

            if ($popup_type == 'onload') {
                $html .= "<div class = 'arsocial_lite_like_popup_wrapper arsocial_lite_like_popup_button_wrapper arsocial_lite_popup_button_wrapper {$nativeClass}' id = 'arsocial_lite_like_popup_wrapper' style = '" . $popup_style . "' data-is_popup = '$popup' data-popup_type = '$popup_type' data-popup_open_delay = '$popup_open_delay' data-popup_width = '$popup_width' data-popup_height = '$popup_height' data-popup_close_button = '$popup_is_close_button'>";
                $html .="<div class='arsocial_lite_like_ars_align_center arsocialshare_network_like_button_settings'>";
            }
            if ($popup_type == 'onscroll') {
                $html .= "<div class = 'arsocial_lite_like_popup_wrapper arsocial_lite_like_popup_button_wrapper arsocial_lite_popup_button_wrapper {$nativeClass}' id = 'arsocial_lite_like_popup_wrapper' style = '" . $popup_style . "' data-is_popup = '$popup' data-popup_type = '$popup_type' data-popup_open_scroll = '$popup_open_scroll' data-popup_width = '$popup_width' data-popup_height = '$popup_height' data-popup_close_button = '$popup_is_close_button'>";
                $html .="<div class='arsocial_lite_like_ars_align_center arsocialshare_network_like_button_settings'>";
            }
            if (isset($popup_is_close_button) && $popup_is_close_button == 'true') {
                $html .= "<div class = 'arsocialshare_popup_close' id = 'arsocial_lite_like_popup_wrapper_close'><span></span></div>";
            }

            $html .= $arsocial_lite_like->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_buttons);

            $html .= '</div>';
            $html .= '</div>';
        } else if ($display_type == 'top_bottom_bar') {
            $top_bottom_bar = 'true';

            $top_bottom_bar_option = isset($display_option['top_bottom_bar']) ? $display_option['top_bottom_bar'] : array();

            $top_bottom_bar_type = isset($top_bottom_bar_option['display_bar']) ? $top_bottom_bar_option['display_bar'] : 'onload';
            $top_bottom_position = (isset($top_bottom_bar_option['position']) && !empty($top_bottom_bar_option['position'])) ? $top_bottom_bar_option['position'] : '';


            $top_bottom_bar_option['onload_time'] = isset($top_bottom_bar_option['onload_time']) ? $top_bottom_bar_option['onload_time'] : '0';
            $top_bottom_bar_option['onscroll_percentage'] = isset($top_bottom_bar_option['onscroll_percentage']) ? $top_bottom_bar_option['onscroll_percentage'] : '50';
            $top_bottom_bar_option['enable'] = 'true';

            $y_point = isset($top_bottom_bar_option['y_point']) ? $top_bottom_bar_option['y_point'] : '0';

            $data_attr = '';
            if (isset($top_bottom_bar_option) && !empty($top_bottom_bar_option)) {
                foreach ($top_bottom_bar_option as $data_key => $data_val) {
                    $data_attr .= "data-top_bottom_bar_" . $data_key . "='" . $data_val . "' ";
                }
            }

            $top_bottom_bar_style = 'display:none;';

            if ($top_bottom_position == 'top_bar') {
                $html .= "<div class='arsocial_lite_like_top_bottom_bar_wrapper arsocial_lite_like_top_bar_wrapper arsocial_lite_like_topbar_wrapper arsocialshare_network_like_button_settings arsocial_lite_like_{$button_align}' id='arsocial_lite_like_top_bottom_bar_wrapper' style = '" . $top_bottom_bar_style . "margin-top:{$y_point}px;' $data_attr >";
                $html .= $arsocial_lite_like->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_buttons);
                $html .= '</div>';
            }

            if ($top_bottom_position == 'bottom_bar') {
                $html .= "<div class='arsocial_lite_like_top_bottom_bar_wrapper arsocial_lite_like_bottom_bar_wrapper arsocial_lite_like_bottombar_wrapper arsocialshare_network_like_button_settings arsocial_lite_like_{$button_align}' id='arsocial_lite_like_top_bottom_bar_wrapper' style = '" . $top_bottom_bar_style . "' $data_attr >";
                $html .= $arsocial_lite_like->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_buttons);
                $html .= '</div>';
            }
        }

        $html .='</div>';

        $response['message'] = "success";
        $response['body'] = $html;

        $response = apply_filters('arsocial_lite_locker_view_msg', $response);


        return json_encode($response);
    }

}
?>