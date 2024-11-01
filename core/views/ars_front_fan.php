<?php

if (!function_exists('arsocialshare_lite_fan_view')) {
    
    function arsocialshare_lite_fan_view($id = '', $fan_position = '', $is_excerpt = false) {

        global $wpdb, $arsocial_lite_fan, $arsocial_lite;
        $response = array();
        if (empty($id)) {
            $response['message'] = "error";
            $response['body'] = esc_html__('Shortcode ID is empty or Invalid. Please select valid Shortcode', 'arsocial_lite');
            $response = apply_filters('arsocial_lite_fan_view_msg', $response);
            return json_encode($response);
        }
        $counter_data = array();
        $network_default_settings = $arsocial_lite->ARSocialShareFancounterNetworks();

        $html = '';
        $page_id = get_the_ID();

        $post = get_post();
        $post_type = $post->post_type;

        if ($id == 'ars_fan_global_settings') {

            $global_settings = maybe_unserialize(get_option('arslite_fan_display_settings'));
            
            if (empty($global_settings)) {
                $response['message'] = "error";
                $response['body'] = esc_html__('', 'arsocial_lite');
                $response = apply_filters('arsocial_lite_fan_view_msg', $response);
                return json_encode($response);
            }

            if ('' !== get_option('arslite_fan_counter_data_global')) {
                $counter_data = maybe_unserialize(get_option('arslite_fan_counter_data_global'));
            }

            if (empty($counter_data)) {
                $counter_data = $arsocial_lite_fan->ars_update_fan_counter_data($id);
                $counter_data = maybe_unserialize($counter_data);
            }

            $counter_data['total_count'] = 0;

            $shortcode_id = '-100';

            $display_settings = $global_settings['display'];

            /**
             * Sidebar Fan Counter
             */
            $html .= $arsocial_lite->ars_get_enqueue_fonts('fan');

            if (array_key_exists('sidebar', $display_settings) && $fan_position == 'sidebar') {
                $sidebar_settings = $display_settings['sidebar'];
                $exclude_pages = $sidebar_settings['exclude_pages'];
                $display_number_format = $sidebar_settings['no_format'];
                $sidebar_exclude = array();
                $hide_sidebar = false;
                if ($exclude_pages !== '') {
                    $sidebar_exclude = explode(',', $exclude_pages);
                    if (!empty($sidebar_exclude) && in_array($page_id, $sidebar_exclude)) {
                        $hide_sidebar = true;
                    }
                }

                $more_btn_settings = array();
                $more_btn_settings['more_btn'] = $sidebar_settings['more_btn'];
                $more_btn_settings['more_btn_style'] = $sidebar_settings['more_btn_style'];
                $more_btn_settings['more_btn_action'] = $sidebar_settings['more_btn_action'];
                $button_width = $sidebar_settings['button_width'];
                $button_width = 'arslite_' . $button_width . '_fan_button';


                if (!$hide_sidebar) {
                    foreach ($network_default_settings as $network => $network_data) {
                        $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                        $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                        $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                        $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                    }
                    $display_number_format = isset($sidebar_settings['no_format']) ? $sidebar_settings['no_format'] : 'style1';
                    $display_style = $sidebar_settings['skin'];
                    $fan_display_class = 'ars_fan_metro';
                    $sidebar_position = $sidebar_settings['position'];
                    if (!empty($display_style)) {
                        $fan_display_class = 'ars_fan_' . $display_style;
                    }

                    $html .= '<div class="ars_lite_fan_main_wrapper ars_lite_fan_sidebar ars_lite_fan_sidebar_button_wraper ars_lite_sidebar_' . $sidebar_position . ' ' . $fan_display_class . ' ' . $button_width . '" id="ars_lite_fan_sidebar_button_wraper" >';
                    $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                    if (get_option('arslite_global_fancounter_order')) {
                        $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                        if (is_array($sorted_networks) && !empty($sorted_networks)) {
                            $exclude = array('display_number_format', 'display', 'display_style');
                            $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, 'sidebar', $display_number_format);
                        }
                    }
					
                    $html .= '</div>';
                }
            }

            /**
             * Popup Fan Counter
             */
            if (array_key_exists('popup', $display_settings) && $fan_position == 'popup') {
                $popup_settings = $display_settings['popup'];
                $onload_type = $popup_settings['onload_type'];
                $onload_delay = $popup_settings['open_delay'];
                $onload_scroll = $popup_settings['open_scroll'];
                $popup_height = $popup_settings['height'];
                $popup_width = $popup_settings['width'];
                $display_style = $popup_settings['skin'];
                $display_number_format = $popup_settings['no_format'];
                $exclude_popup = $popup_settings['exclude_pages'];
                $button_width = $popup_settings['button_width'];
                $button_width = 'arslite_' . $button_width . '_fan_button';
                $hide_popup = false;
                if ($exclude_popup !== '') {
                    $exclude_popup_ids = explode(',', $exclude_popup);
                    if (!empty($exclude_popup_ids) && in_array($page_id, $exclude_popup_ids)) {
                        $hide_popup = true;
                    }
                }

                $more_btn_settings = array();

                if (!$hide_popup) {
                    foreach ($network_default_settings as $network => $network_data) {
                        $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                        $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                        $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                        $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                    }

                    $fan_display_class = 'ars_fan_metro';
                    if (!empty($display_style)) {
                        $fan_display_class = 'ars_fan_' . $display_style;
                    }
                    $display_close_btn = ($popup_settings['display_close_btn'] === 'yes') ? true : false;
                    $html .= "<div class='arsocial_lite_buttons_container arsocialshare_popup_wrapper arsocial_lite_popup_button_wrapper ars_lite_fan_popup_button_wraper ' id='ars_fan_popup_wrapper' data-is_popup='true' data-popup_open_delay='{$onload_delay}' data-popup_type='popup_{$onload_type}' data-popup_open_scroll='{$onload_scroll}' data-popup_close_button='{$display_close_btn}' data-popup_height='$popup_height' data-popup_width='$popup_width' style='width:{$popup_width}px;height:{$popup_width}px;'>";
                    if ($display_close_btn == true) {
                        $html .= "<div class='arsocialshare_popup_close' id='ars_lite_fan_popup_wrapper_close'><span></span></div>";
                    }

                    $html .= "<div class='ars_lite_fan_main_wrapper $fan_display_class $button_width ars_fan_button_center'>";
                    $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                    if (get_option('arslite_global_fancounter_order')) {
                        $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                        if (is_array($sorted_networks) && !empty($sorted_networks)) {
                            $exclude = array('display_number_format', 'display', 'display_style');
                            $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, 'popup', $display_number_format);
                        }
                    }
                    $html .= "</div>";
                    $html .= "</div>";
                }
            }

            /**
             * Pages Fan Counter
             */
            if (array_key_exists('page', $display_settings) && $fan_position == 'page') {
                $page_settings = $display_settings['page'];
                $display_style = $page_settings['skin'];
                $display_number_format = $page_settings['no_format'];
                $exclude_pages = $page_settings['exclude_pages'];
                $btn_align = $page_settings['btn_alignment'];
                $btn_width = $page_settings['btn_width'];
                $button_width = 'arslite_' . $btn_width . '_fan_button';
                $hide_page = false;
                if ($exclude_pages !== '') {
                    $exclude_pages_id = explode(',', $exclude_pages);
                    if (!empty($exclude_pages_id) && in_array($page_id, $exclude_pages_id)) {
                        $hide_page = true;
                    }
                }


                $more_btn_settings = array();
                $more_btn_settings['more_btn'] = $page_settings['more_btn'];
                $more_btn_settings['more_btn_style'] = $page_settings['more_btn_style'];
                $more_btn_settings['more_btn_action'] = $page_settings['more_btn_action'];

                if (!$hide_page) {

                    foreach ($network_default_settings as $network => $network_data) {
                        $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                        $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                        $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                        $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                    }

                    $fan_display_class = 'ars_fan_metro';
                    if (!empty($display_style)) {
                        $fan_display_class = 'ars_fan_' . $display_style;
                    }

                    $html .= "<div class='ars_lite_fan_main_wrapper ars_fan_button_$btn_align $fan_display_class $button_width'>";
                    $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                    if (get_option('arslite_global_fancounter_order')) {
                        $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                        if (is_array($sorted_networks) && !empty($sorted_networks)) {
                            $exclude = array('display_number_format', 'display', 'display_style');
                            $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, 'page', $display_number_format);
                        }
                    }
					
                    $html .= "</div>";
                }
            }

            /**
             * Post Fan Counter
             */
            if (array_key_exists('post', $display_settings) && $fan_position == 'post') {
                $post_settings = $display_settings['post'];
                $display_style = $post_settings['skin'];
                $display_number_format = $post_settings['no_format'];
                $exclude_post = $post_settings['exclude_pages'];
                $btn_align = $post_settings['btn_alignment'];
                $btn_width = $post_settings['btn_width'];
                if ($is_excerpt == 'true') {
                    $btn_align = 'right';
                }
                $button_width = 'arslite_' . $btn_width . '_fan_button';
                $hide_post = false;
                if ($exclude_post !== '') {
                    $exclude_posts_id = explode(',', $exclude_post);
                    if (!empty($exclude_posts_id) && in_array($page_id, $exclude_posts_id)) {
                        $hide_post = true;
                    }
                }

                $more_btn_settings = array();
                $more_btn_settings['more_btn'] = $post_settings['more_btn'];
                $more_btn_settings['more_btn_style'] = $post_settings['more_btn_style'];
                $more_btn_settings['more_btn_action'] = $post_settings['more_btn_action'];

                if (!$hide_post) {

                    foreach ($network_default_settings as $network => $network_data) {
                        $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                        $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                        $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                        $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                    }

                    $fan_display_class = 'ars_fan_metro';
                    if (!empty($display_style)) {
                        $fan_display_class = 'ars_fan_' . $display_style;
                    }

                    $html .= "<div class='ars_lite_fan_main_wrapper ars_fan_button_$btn_align $fan_display_class $button_width'>";
                    $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                    if (get_option('arslite_global_fancounter_order')) {
                        $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                        if (is_array($sorted_networks) && !empty($sorted_networks)) {
                            $exclude = array('display_number_format', 'display', 'display_style');
                            $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, 'post', $display_number_format);
                        }
                    }
					
                    $html .= "</div>";
                }
            }

            /**
             * Woocommerce Changes
             */
            if (array_key_exists('woocommerce', $display_settings) && $post_type === 'product' && ($fan_position === 'before_product' || $fan_position === 'after_price' || $fan_position === 'after_product')) {
                $woocommerce_settings = $display_settings['woocommerce'];
                $display_style = $woocommerce_settings['skin'];
                $display_number_format = $woocommerce_settings['no_format'];
                $exclude_product = $woocommerce_settings['exclude_pages'];
                $btn_align = $woocommerce_settings['btn_align'];
                $btn_width = $woocommerce_settings['btn_width'];
                $button_width = 'arslite_' . $btn_width . '_fan_button';
                $more_btn_settings = array();
                $more_btn_settings['more_btn'] = $woocommerce_settings['more_btn'];
                $more_btn_settings['more_btn_style'] = $woocommerce_settings['more_btn_style'];
                $more_btn_settings['more_btn_action'] = $woocommerce_settings['more_btn_action'];
                $hide_product = false;
                if ($exclude_product !== '') {
                    $exclude_product_id = explode(',', $exclude_product);
                    if (!empty($exclude_product_id) && in_array($page_id, $exclude_product_id)) {
                        $hide_product = true;
                    }
                }

                if (!$hide_product) {
                    foreach ($network_default_settings as $network => $network_data) {
                        $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                        $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                        $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                        $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                    }

                    $fan_display_class = 'ars_fan_metro';
                    if (!empty($display_style)) {
                        $fan_display_class = 'ars_fan_' . $display_style;
                    }

                    $html .= "<div class='ars_lite_fan_main_wrapper ars_fan_button_$btn_align $fan_display_class $button_width'>";
                    $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                    if (get_option('arslite_global_fancounter_order')) {
                        $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                        if (is_array($sorted_networks) && !empty($sorted_networks)) {
                            $exclude = array('display_number_format', 'display', 'display_style');
                            $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, 'woocommerce', $display_number_format);
                        }
                    }
                    $html .= "</div>";
                }
            }



            /**
             * Fan Bar Fan Counter
             */
            if (array_key_exists('fan_bar', $display_settings) && $fan_position === 'fanbar') {

                    $fan_bar_settings = $display_settings['fan_bar'];
                    $onload_type = $fan_bar_settings['display_on'];

                    $onload_delay = $fan_bar_settings['load_time'];
                    $onload_scroll = $fan_bar_settings['scroll_value'];

                    $fab_bar_top = $fan_bar_settings['top'];
                    $fab_bar_bottom = $fan_bar_settings['bottom'];

                    $display_style = $fan_bar_settings['skin'];
                    $display_number_format = $fan_bar_settings['no_format'];
                    $exclude_fan_bar = $fan_bar_settings['exclude_pages'];

                    $btn_align = $fan_bar_settings['btn_alignment'];
                    $btn_width = $fan_bar_settings['button_width'];

                    $more_btn_settings = array();
                    $more_btn_settings['more_btn'] = $fan_bar_settings['more_btn'];
                    $more_btn_settings['more_btn_style'] = $fan_bar_settings['more_btn_style'];
                    $more_btn_settings['more_btn_action'] = $fan_bar_settings['more_btn_action'];

                    $button_width = 'arslite_' . $btn_width . '_fan_button';
                    $y_point = isset($fan_bar_settings['y_point']) ? $fan_bar_settings['y_point'] : '';
                    $hide_fan_bar = false;
                    if ($exclude_fan_bar !== '') {
                        $exclude_fan_bar = explode(',', $exclude_fan_bar);
                        if (!empty($exclude_fan_bar) && in_array($page_id, $exclude_fan_bar)) {
                            $hide_fan_bar = true;
                        }
                    }

                    if (!$hide_fan_bar) {

                        foreach ($network_default_settings as $network => $network_data) {
                            $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                            $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                            $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                            $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                        }

                        $fan_display_class = 'ars_fan_metro ' . $button_width;
                        if (!empty($display_style)) {
                            $fan_display_class = 'ars_fan_' . $display_style . ' ' . $button_width;
                        }


                        $data_attr = '';
                        $fan_bar_settings_attr = $fan_bar_settings;
                        $fan_bar_settings_attr['enable'] = 'true';
                        $fan_bar_settings_attr['scroll_value'] = (isset($fan_bar_settings['scroll_value']) && !empty($fan_bar_settings['scroll_value'])) ? $fan_bar_settings['scroll_value'] : '50';
                        if (isset($fan_bar_settings_attr) && !empty($fan_bar_settings_attr)) {
                            foreach ($fan_bar_settings_attr as $data_key => $data_val) {
                                $data_attr .= "data-fan_bar_" . $data_key . "='" . $data_val . "' ";
                            }
                        }

                        $fan_bar_style = 'display:none;';

                        if (isset($fab_bar_top) && !empty($fab_bar_top)) {

                            $html .= "<div class='arsocial_lite_buttons_container arslite_fancounter_fan_bar_wrapper arsfancounter_fan_bar_top_wrapper ars_lite_fancounter_fan_topbar_wrapper $button_width' id='arslite_fancounter_fan_bar_wrapper' $data_attr  style='{$fan_bar_style}margin-top:{$y_point}px;'>";
                            $html .= "<div class='ars_lite_fan_main_wrapper ars_fan_button_$btn_align $fan_display_class'>";
                            $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                            if (get_option('arslite_global_fancounter_order')) {
                                $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                                if (is_array($sorted_networks) && !empty($sorted_networks)) {
                                    $exclude = array('display_number_format', 'display', 'display_style');
                                    $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, 'fan_bar', $display_number_format);
                                }
                            }
                            $html .= "</div>";
                            $html .= "</div>";
                        }


                        if (isset($fab_bar_bottom) && !empty($fab_bar_bottom)) {

                            $html .= "<div class='arsocial_lite_buttons_container arslite_fancounter_fan_bar_wrapper arslite_fancounter_fan_bar_bottom_wrapper ars_lite_fancounter_fan_bottombar_wrapper $button_width' id='arslite_fancounter_fan_bar_wrapper' $data_attr  style='$fan_bar_style'>";
                            $html .= "<div class='ars_lite_fan_main_wrapper ars_fan_button_$btn_align $fan_display_class'>";
                            $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                            if (get_option('arslite_global_fancounter_order')) {
                                $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                                if (is_array($sorted_networks) && !empty($sorted_networks)) {
                                    $exclude = array('display_number_format', 'display', 'display_style');
                                    $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, 'fan_bar', $display_number_format);
                                }
                            }
                            $html .= "</div>";
                            $html .= "</div>";
                        }
                    }
            }

            if ($fan_position === 'mobile') {

                $display_number_format = 'style5';

                $button_width = "medium";
                $button_width = 'arslite_' . $button_width . '_fan_button';

                foreach ($network_default_settings as $network => $network_data) {
                    $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                    $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                    $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                    $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                }

                $fan_display_class = isset($display_settings['mobile']['skin']) ? 'ars_fan_' . $display_settings['mobile']['skin'] : 'ars_fan_flat';

                $display_close_btn = true;


                $html .= "<div class='ars_lite_fan_main_wrapper $fan_display_class $button_width ars_fan_button_center'>";
                $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

                if (get_option('arslite_global_fancounter_order')) {
                    $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                    if (is_array($sorted_networks) && !empty($sorted_networks)) {
                        $exclude = array('display_number_format', 'display', 'display_style');
                        $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $global_settings, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, array(), 'popup', $display_number_format);
                    }
                }
                $html .= "</div>";
            }

            if ($fan_position === 'mobile_footer_icons') {

                $display_number_format = 'style5';

                $button_width = "small";
                $button_width = 'arslite_' . $button_width . '_fan_button';

                foreach ($network_default_settings as $network => $network_data) {
                    $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                    $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                    $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $global_settings[$network]['manual_counter']);
                    $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
                }

                $fan_display_class = isset($display_settings['mobile']['skin']) ? 'ars_fan_' . $display_settings['mobile']['skin'] : 'ars_fan_flat';

                $display_close_btn = true;

                if (get_option('arslite_global_fancounter_order')) {
                    $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                    if (is_array($sorted_networks) && !empty($sorted_networks)) {

                        $saved_fan_networks_global = $global_settings;
                        $exclude = array('display_number_format', 'display', 'display_style');

                        $total_active_network = count($saved_fan_networks_global['display']['active_network']);
                        $total_networks = count($sorted_networks);

                        $ars_fan_total_network = '';
                        if ($total_active_network == 3) {
                            $ars_fan_total_network = 'ars_fan_three_network';
                        }
                        if ($total_active_network == 4) {
                            $ars_fan_total_network = 'ars_fan_four_network';
                        }
                        if ($total_active_network > 4) {
                            $ars_fan_total_network = 'ars_fan_more_network';
                        }
                        $html .= "<div class='ars_lite_fan_main_wrapper $fan_display_class $button_width ars_fan_button_center $ars_fan_total_network'>";
                        $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";
                        $n = 1;
                        $include_in_more = array();
                        $html .= "<ul>";
                        $i = 0;
                        foreach ($sorted_networks as $key => $value) {
                            $is_active = $arsocial_lite_fan->arsfan_active_networks($value, $saved_fan_networks_global[$value]);
                            if ($is_active) {
                                $i++;
                            }

                            if (!$is_active) {
                                continue;
                            }
                            $html .= $arsocial_lite_fan->arsocialshare_fan_html($value, $saved_fan_networks_global[$value], $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings);
                            $morebtncls = ($display_settings['mobile']['more_button_style'] === 'plus_icon') ? "socialshare-plus" : "socialshare-dot-3";
                            if ($i >= 4 && $total_active_network != 4) {
                                $html .= "<li class='ars_fan_network-morebtn' style='vertical-align:top;'><a class='arsocial_lite_more_button_icon' id='ars_fan_mobile_more_button_icon' style='cursor:pointer;'><div class='ars_fan_network more_icon'><i class='ars_fan_network_icon $morebtncls'></i></div></a><input type='hidden' id='arsocialshare_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' /></li>";
                                break;
                            }

                            $n++;
                        }
                        $html .= "</ul>";
                    }
                }
                $html .= "</div>";
            }
        } else {

            $fan_table = $wpdb->prefix . 'arsocial_lite_fan';

            $get_fan = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$fan_table` WHERE ID = %d", $id));

            if (empty($get_fan)) {
                $response['message'] = "error";
                $response['body'] = esc_html__('', 'arsocial_lite');
                $response = apply_filters('arsocial_lite_fan_view_msg', $response);
                return json_encode($response);
            }

            $saved_fan_networks_global = maybe_unserialize($get_fan->content);

            $more_btn_settings = array();
            $more_btn_settings['more_btn'] = $saved_fan_networks_global['ars_fan_more_button'];
            $more_btn_settings['more_btn_style'] = $saved_fan_networks_global['ars_fan_more_button_style'];
            $more_btn_settings['more_btn_action'] = $saved_fan_networks_global['ars_fan_more_button_action'];

            $counter_data = maybe_unserialize($get_fan->counter_data);

            $display_style = $get_fan->display_type;

            $shortcode_id = $id;

            if (empty($counter_data)) {
                $counter_data = $arsocial_lite_fan->ars_update_fan_counter_data($id);
                $counter_data = maybe_unserialize($counter_data);
            }

            $counter_data['total_count'] = 0;
            $display_number_format = isset($saved_fan_networks_global['display_number_format']) ? $saved_fan_networks_global['display_number_format'] : 'style1';
            foreach ($network_default_settings as $network => $network_data) {
                $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                $saved_fan_networks_global[$network]['manual_counter'] = isset($saved_fan_networks_global[$network]['manual_counter']) ? $saved_fan_networks_global[$network]['manual_counter'] : 0;

                $counter_data[$network] = $arsocial_lite_fan->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $saved_fan_networks_global[$network]['manual_counter']);
                $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
            }

            $fan_display_class = 'ars_fan_metro';
            if (!empty($display_style)) {
                $fan_display_class = 'ars_fan_' . $display_style;
            }

            $display_settings = $saved_fan_networks_global['display'];

            $button_width = isset($saved_fan_networks_global['ars_btn_width']) ? $saved_fan_networks_global['ars_btn_width'] : '';
            $ars_align = isset($saved_fan_networks_global['ars_btn_align']) ? $saved_fan_networks_global['ars_btn_align'] : '';
            $button_width = 'arslite_' . $button_width . '_fan_button';
            $sidebar_class = '';
            if ($display_settings['display_on'] === 'sidebar') {
                $sidebar_position = $display_settings['sidebar']['position'];
                $sidebar_class = 'ars_lite_fan_sidebar ars_lite_sidebar_' . $sidebar_position;
            }
            $popup_class = '';
            $fan_order = $display_settings['fan_network_order'];
            if ($display_settings['display_on'] === 'popup') {
                $onload_type = $display_settings['popup']['onload_type'];
                $onload_delay = $display_settings['popup']['open_delay'];
                $onload_scroll = $display_settings['popup']['open_scroll'];
                $display_close_btn = $display_settings['popup']['ars_fan_pop_show_close_button'];
                $popup_width = $display_settings['popup']['popup_width'];
                $popup_height = $display_settings['popup']['popup_height'];
                $popup_class = 'ars_fan_button_center';
                $html .= "<div class='arsocial_lite_buttons_container arsocialshare_popup_wrapper arsocial_lite_popup_button_wrapper ars_lite_fan_popup_button_wraper' id='ars_fan_popup_wrapper' data-is_popup='true' data-popup_open_delay='{$onload_delay}' data-popup_type='popup_{$onload_type}' data-popup_open_scroll='{$onload_scroll}' data-popup_close_button='{$display_close_btn}' data-popup_height='$popup_height' data-popup_width='$popup_width' style='width:{$popup_width}px;height:{$popup_width}px;'>";
                if ($display_close_btn !== 'no') {
                    $html .= "<div class='arsocialshare_popup_close' id='ars_lite_fan_popup_wrapper_close'><span></span></div>";
                }
                $more_btn_settings = array();
            }

            if ($display_settings['display_on'] === 'top_bottom_bar') {


                $fan_bar_style = 'display:none;';
                $data_attr = '';
                $fan_bar_settings_attr = array();
                $fan_bar_settings_attr['enable'] = 'true';
                $fan_bar_settings_attr['scroll_value'] = (isset($display_settings['top_bottom_bar']['onscroll_percentage']) && !empty($display_settings['top_bottom_bar']['onscroll_percentage'])) ? $display_settings['top_bottom_bar']['onscroll_percentage'] : '50';
                $fan_bar_settings_attr['load_time'] = (isset($display_settings['top_bottom_bar']['onload_time']) && !empty($display_settings['top_bottom_bar']['onload_time'])) ? $display_settings['top_bottom_bar']['onload_time'] : '';
                $fan_bar_settings_attr['display_on'] = (isset($display_settings['top_bottom_bar']['onload_type']) && !empty($display_settings['top_bottom_bar']['onload_type'])) ? $display_settings['top_bottom_bar']['onload_type'] : '';

                if (isset($fan_bar_settings_attr) && !empty($fan_bar_settings_attr)) {
                    foreach ($fan_bar_settings_attr as $data_key => $data_val) {
                        $data_attr .= "data-fan_bar_" . $data_key . "='" . $data_val . "' ";
                    }
                }

                if (isset($display_settings['top_bottom_bar']['position']) && $display_settings['top_bottom_bar']['position'] == 'bottom_bar') {
                    $html .= "<div class='arslite_fancounter_fan_bar_wrapper arslite_fancounter_fan_bar_bottom_wrapper ars_lite_fancounter_fan_bottombar_wrapper'  id='arslite_fancounter_fan_bar_wrapper' $data_attr  style='$fan_bar_style'>";
                } else {
                    $y_position = isset($display_settings['top_bottom_bar']['y_point']) ? $display_settings['top_bottom_bar']['y_point'] : '0';
                    $html .= "<div class='arslite_fancounter_fan_bar_wrapper arsfancounter_fan_bar_top_wrapper ars_lite_fancounter_fan_topbar_wrapper' id='arslite_fancounter_fan_bar_wrapper' $data_attr  style='{$fan_bar_style}margin-top:{$y_position}px;'>";
                }
            }

            //$sidebar_class = 'ars_lite_fan_sidebar ars_lite_sidebar_' . $sidebar_position;
            $html .= $arsocial_lite->ars_get_enqueue_fonts('fan');
            $html .= '<div class="ars_lite_fan_main_wrapper ' . $button_width . ' ' . $sidebar_class . ' ' . $fan_display_class . ' ' . $ars_align . ' ' . $popup_class . '">';
            $html .= "<input type='hidden' id='arsocialfan_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

            if (!empty($fan_order)) {
                //$sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                $sorted_networks = $fan_order;

                if (is_array($sorted_networks) && !empty($sorted_networks)) {
                    $exclude = array('display_number_format', 'display', 'display_style');
                    $html .= $arsocial_lite_fan->arsocialshare_get_fan_html($sorted_networks, $saved_fan_networks_global, $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_btn_settings, '', $display_number_format);
                }
            }
            $html .= "</div>";

            if ($display_settings['display_on'] === 'popup') {
                $html .= "</div>";
            }
            if ($display_settings['display_on'] === 'top_bottom_bar') {
                $html .= "</div>";
            }
        }

        $response['message'] = "success";
        $response['body'] = $html;

        $response = apply_filters('arsocial_lite_fan_view_msg', $response);

        return json_encode($response);
    }

}
?>