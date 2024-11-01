<?php

if (!function_exists('arsocial_lite_locker_view')) {

    function arsocial_lite_locker_view($id = '', $locked_content = '', $last_insert_id = '') {
        global $wpdb, $arsocial_lite_locker, $arsocial_lite;
        $response = array();
        $locker_opts = array();
        $locker_opts['analytics_id'] = $last_insert_id;
        $global_settings = maybe_unserialize(get_option('arslite_global_settings'));
        if ($id === '') {
            $response['message'] = "error";
            $response['body'] = esc_html__('Locker ID is empty or Invalid. Please select valid Locker ID', 'arsocial_lite');
            $response = apply_filters('arsocialsharelocker_view_msg', $response);
            return json_encode($response);
        }


        if ($id == 'global_settings') {
            $get_locker = get_option('arslite_locker_display_settings');
            $settings = maybe_unserialize($get_locker);
            $locker_options = $settings;
            $lockedContainer = '__ARSLOCKER__' . $id;

            update_option('arslite_locked_container_' . $id, $lockedContainer);
            $page_id = get_the_ID();


            if (empty($get_locker)) {
                $response['message'] = "error";
                $response['body'] = esc_html__('', 'arsocial_lite');
                $response = apply_filters('arsocialsharelocker_view_msg', $response);
                return json_encode($response);
            }

            $get_locker = maybe_unserialize($get_locker);

            $locker_type = $get_locker['locker_type'];

            $locker_social = $get_locker['social'];

            $lockername = $get_locker['locker_title'];

            $locker_content = $get_locker['locker_content'];
        } else {
            $locker_table = $wpdb->prefix . 'arsocial_lite_locker';

            $lockedContainer = '__ARSLOCKER__' . $id;

            $get_locker = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$locker_table` WHERE ID = %d", $id));

            update_option('arslite_locked_container_' . $id, $lockedContainer);

            if (empty($get_locker)) {
                $response['message'] = "error";
                $response['body'] = esc_html__('', 'arsocial_lite');
                $response = apply_filters('arsocialsharelocker_view_msg', $response);
                return json_encode($response);
            }

            $locker_type = $get_locker->locker_type;

            $locker_options = maybe_unserialize($get_locker->locker_options);

            $locker_social = $locker_options['social'];

            $lockername = $get_locker->lockername;

            $locker_content = $get_locker->content;
        }

        $locker_opts = array_merge($locker_opts, $locker_social);

        $display_options = isset($locker_options['display']) ? $locker_options['display'] : array();
        $locker_theme = isset($display_options['locker_template']) ? $display_options['locker_template'] : 'default';
        $overlap_mode = isset($display_options['overlap_mode']) ? $display_options['overlap_mode'] : 'full';
        $lockedContainerClass = 'ars_locked_' . $overlap_mode;
        $default_color = $arsocial_lite_locker->ars_locker_default_color();

        $ars_wrapper_bg_color = isset($display_options['arsocialshare_locker_bgcolor']) ? $display_options['arsocialshare_locker_bgcolor'] : $default_color[$locker_theme]['bg_color'];
        $ars_wrapper_textcolor_color = isset($display_options['arsocialshare_locker_textcolor']) ? $display_options['arsocialshare_locker_textcolor'] : $default_color[$locker_theme]['text_color'];


        $locker_view = "";
        $locker_view .= "<input type='hidden' id='ars_page_id' value='" . get_the_id() . "' />";
        $locker_view .= "<input type='hidden' id='ars_locker_id' value='" . $id . "' />";

        $locker_view .= '<style>'  . $arsocial_lite_locker->ars_locker_css($id,$locker_theme,$ars_wrapper_bg_color,$ars_wrapper_textcolor_color) . $lockerCustomcss. ' </style>';

        $locker_view .= $arsocial_lite->ars_get_enqueue_fonts('locker');
        if ($locker_type === 'social_signin') {


            $locker_opts['current_page_url'] = get_permalink();

            $locker_opts['locker_id'] = $id;
            $locker_opts['name'] = $lockername;
            $locker_opts['container'] = $lockedContainer;

            $locker_opts['fb_signin'] = $locker_social['is_fb_signin'];
            $locker_opts['fb_save_email'] = $locker_social['is_fb_save_email'];
            $locker_opts['fb_create_account'] = $locker_social['is_fb_create_account'];

            $locker_opts['twitter_signin'] = $locker_social['is_twitter_signin'];
            $locker_opts['twitter_save_email'] = $locker_social['is_twitter_save_email'];
            $locker_opts['twitter_create_account'] = $locker_social['is_twitter_create_account'];

            $locker_opts['is_linkedin_signin'] = $locker_social['is_linkedin_signin'];
            $locker_opts['is_linkedin_save_email'] = $locker_social['is_linkedin_save_email'];
            $locker_opts['is_linkedin_create_account'] = $locker_social['is_linkedin_create_account'];

            $fb_signin = $locker_social['is_fb_signin'];
            $fb_save_email = $locker_social['is_fb_save_email'];
            $fb_wp_account = $locker_social['is_fb_create_account'];

            $twitter_signin = $locker_social['is_twitter_signin'];
            $twitter_save_email = $locker_social['is_twitter_save_email'];
            $twitter_wp_account = $locker_social['is_twitter_create_account'];

            $linkedin_signin = $locker_social['is_linkedin_signin'];
            $linkedin_save_email = $locker_social['is_linkedin_save_email'];
            $linkedin_wp_account = $locker_social['is_linkedin_create_account'];

            if ($overlap_mode == 'blurring') {
                $ua = $_SERVER['HTTP_USER_AGENT'];
                $browser = $arsocial_lite_locker->getBrowser($ua);
                if (in_array($browser['browser_name'], array('Internet Explorer', 'Microsoft Edge', 'Apple Safari'))) {
                    wp_enqueue_script('ars-locker-front-foggy-js');
                }
            }

            $locker_view .= "<div id='arsocial_lite_locker_{$id}' class='arsocial_lite_locker_main_wrapper arsocial_lite_locker_wrapper arsocial_lite_locker_{$locker_theme}_theme arsocial_lite_locker_overlap_{$overlap_mode} arsocial_lite_locker_{$id}' data-ng-module='arsociallitelocker' data-hidden-el='$lockedContainer'>";

            //$locker_view .= "<div id='ars_ajaxurl' style='display:none'>" . admin_url('admin-ajax.php') . "</div>";
            $locker_view .= "<input type='hidden' id='ars_locker_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";

            $locker_view .= "<div class='arsocial_lite_locker_popup_bg'></div>";

            $locker_view .= "<div id='arsociallocker_popup' class='arsocial_lite_locker_popup arsociallocker_popup'>";
            $locker_view .= "<div class='arsocial_lite_locker_popup_inner'>";
            $locker_view .= "<div class='arsocial_lite_locker_popup_inner_wrapper' id='ars_twitter_outer_wrapper'>";

            $locker_view .= "<div id='arsocial_lite_locker_popup_title' class='arsocial_lite_locker_popup_title arsocial_lite_locker_popup_title'>";
            $locker_view .= $lockername;
            $locker_view .= "</div>";

            $locker_view .= "<div id='arsocial_lite_locker_popup_content' class='arsocial_lite_locker_popup_content arsocial_lite_locker_popup_content'>";
            $locker_view .= $locker_content;
            $locker_view .= "</div>";

            $locker_view .= "<div id='arsocial_lite_locker_button_wrapper' class='arsocialshare_button_outer_wrapper arsocial_lite_locker_button_wrapper1'>";

            $options = array();
            if (isset($locker_social['is_fb_signin']) && $locker_social['is_fb_signin'] == '1') {
                $options[] = 'facebook';
            }
            if (isset($locker_social['is_twitter_signin']) && $locker_social['is_twitter_signin'] == '1') {
                $options[] = 'twitter';
            }
            if (isset($locker_social['is_linkedin_signin']) && $locker_social['is_linkedin_signin'] == '1') {
                $options[] = 'linkedin';
            }
            if (!empty($options) && is_array($options)) {
                foreach ($options as $key => $value) {
                    $locker_view .= $arsocial_lite_locker->arsocialshare_signin_locker_view($value, $id, $locker_social, $global_settings);
                }
            }

            $locker_view .= "</div>";        

            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup_inner_wrapper`-->";
            if ($twitter_signin) {
                $locker_view .= "<input type='hidden' id='twitter_save_email' value='{$locker_opts['twitter_save_email']}' />";
                $locker_view .= "<input type='hidden' id='twitter_create_account' value='{$locker_opts['twitter_create_account']}' />";
                $locker_view .= "<div class='arsocial_lite_locker_popup_inner_wrapper' id='arsocialshare_twitter_email_id_wrapper' style='display:none' data-ng-controller='arsociallitetwitterloginfinalstep'>";

                $locker_view .= "<div id='arsocialshare_twitter_details' style='display:none'></div>";
                $locker_view .= "<div class='arsocial_lite_locker_popup_title'>" . esc_html__('Enter Email ID', ARSOCIALSHARETXTDOMAIN) . "</div>";
                $locker_view .= "<div id='arsocial_lite_locker_popup_content' class='arsocial_lite_locker_popup_content arsocial_lite_locker_popup_content'>";
                $locker_view .= "<input type='text' name='arsocialshare_twitter_signin_email' id='arsocialshare_twitter_signin_email'  style='width:50%;margin-top:10px;' />";
                $locker_view .= "</div>";
                $locker_view .= "<div class='arsocialshare_button_outer_wrapper'>";
                $locker_view .= "<input type='button' id='arsocialshare_twitter_signin_email' name='arsocialshare_twitter_signin' class='arsociallocker_email_button' value='Complete' ng-click='twitter_signin_complete()' />";
                $locker_view .= "</div>";
                $locker_view .= "</div>";
            }

            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup_inner`-->";

            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup`-->";

            $locker_view .= "<div class='arsocialshare_locked_content {$lockedContainerClass}' id='$lockedContainer' style='display:none;'>";
            $locker_view .= do_shortcode($locked_content);
            $locker_view .= "</div>";

            $gs_settings = get_option('arslite_global_settings');
            $settings = maybe_unserialize($gs_settings);

            $locker_view .= "<input type='hidden' name='ars_locker_options' id='ars_locker_options' value='" . json_encode($locker_opts) . "' />";
            $locker_view .= "<input type='hidden' name='ars_global_settings' id='ars_global_settings' value='" . json_encode($settings) . "' />";
            


            $locker_view .= "</div>";

            $response['body'] = $locker_view;
        } else {

            $is_locker_unlocked = get_option('arslite_is_unlocked_' . $id);

            $settings = maybe_unserialize(get_option('arslite_locker_display_settings'));

            if ($is_locker_unlocked) {
                $response['message'] = "success";
                $response['body'] = "<div class='arsocialshare_locked_content' id='$lockedContainer'>" . do_shortcode($locked_content) . "</div>";
                $response = apply_filters('arsocialsharelocker_view_msg', $response);
                return json_encode($response);
            }

            $locker_opts['locker_id'] = $id;
            $locker_opts['name'] = $lockername;
            $locker_opts['container'] = $lockedContainer;
            $locker_opts['current_page_url'] = get_permalink();
            /* Add Bluring Effect */
            if ($overlap_mode == 'blurring') {
                $ua = $_SERVER['HTTP_USER_AGENT'];
                $browser = $arsocial_lite_locker->getBrowser($ua);
                if (in_array($browser['browser_name'], array('Internet Explorer', 'Microsoft Edge', 'Apple Safari'))) {
                    wp_enqueue_script('ars-locker-front-foggy-js');
                }
            }
            $locker_view .= "<div id='arsocial_lite_locker_{$id}' class='arsocial_lite_locker_main_wrapper arsocial_lite_locker_wrapper arsocial_lite_locker_{$locker_theme}_theme arsocial_lite_locker_overlap_{$overlap_mode} arsocial_lite_locker_{$id}' data-ng-module='arsociallitelocker' data-hidden-el='$lockedContainer'>";

            //$locker_view .= "<div id='ars_ajaxurl' style='display:none'>" . admin_url('admin-ajax.php') . "</div>";
            $locker_view .= "<input type='hidden' id='ars_locker_ajaxurl' value='" . admin_url('admin-ajax.php') . "' />";
            $locker_view .= "<div class='arsocial_lite_locker_popup_bg'></div>";
            $locker_view .= "<div id='arsociallocker_popup' class='arsocial_lite_locker_popup arsociallocker_popup'>";

            $locker_view .= "<div class='arsocial_lite_locker_popup_inner'>";
            $locker_view .= "<div class='arsocial_lite_locker_popup_inner_wrapper'>";

            $locker_view .= "<div id='arsocial_lite_locker_popup_title' class='arsocial_lite_locker_popup_title arsocial_lite_locker_popup_title'>";
            $locker_view .= $lockername;
            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup_title`-->";

            $locker_view .= "<div id='arsocial_lite_locker_popup_content' class='arsocial_lite_locker_popup_content arsocial_lite_locker_popup_content'>";
            $locker_view .= $locker_content;
            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup_content`-->";

            $locker_view .= "<div id='arsocial_lite_locker_button_wrapper' class='arsocialshare_button_outer_wrapper arsocial_lite_locker_button_wrapper1'>";
            $currentUrl = get_permalink();
            $locker_opts['fb_like_url'] = (!empty($locker_social['fb_like_url'])) ? $locker_social['fb_like_url'] : $currentUrl;
            $locker_opts['tweet_url'] = (!empty($locker_social['tweet_url'])) ? $locker_social['tweet_url'] : $currentUrl;
            $locker_opts['fb_share_url'] = (!empty($locker_social['fb_share_url'])) ? $locker_social['fb_share_url'] : $currentUrl;
            $locker_opts['linkedin_url_share'] = (!empty($locker_social['linkedin_url_share'])) ? $locker_social['linkedin_url_share'] : $currentUrl;
            $options = array();
            if (isset($locker_social['is_fb_like']) && $locker_social['is_fb_like'] == '1') {
                $options[] = 'facebook_like';
            }
            if (isset($locker_social['is_fb_share']) && $locker_social['is_fb_share'] == '1') {
                $options[] = 'facebook_share';
            }
            if (isset($locker_social['is_linkedin_share']) && $locker_social['is_linkedin_share'] == '1') {
                $options[] = 'linkedin_share';
            }
            if (isset($locker_social['is_tw_locker']) && $locker_social['is_tw_locker'] == '1') {
                $options[] = 'twitter_tweet';
            }
            if (isset($locker_social['is_tw_follow']) && $locker_social['is_tw_follow'] == '1') {
                $options[] = 'twitter_follow';
            }
            if ($id == 'global_settings') {
                $locker_opts['is_tw_locker'] = $locker_social['is_tw_locker'];
                $locker_opts['tw_tweet_url'] = $locker_social['tweet_url'];
                $locker_opts['tw_tweet_txt'] = $locker_social['tweet_txt'];
                $locker_opts['tw_tweet_via'] = $locker_social['tweet_via'];

                $locker_opts['is_fb_share'] = $locker_social['is_fb_share'];
                $locker_opts['fb_share_url'] = $locker_social['fb_share_url'];
                $locker_opts['is_fb_share_counter'] = $locker_social['is_fb_share_counter'];

                $locker_opts['is_tw_follow'] = $locker_social['is_tw_follow'];
                $locker_opts['tw_follow_url'] = $locker_social['tw_follow_url'];
                $locker_opts['show_tw_username'] = $locker_social['show_tw_username'];
                $locker_opts['show_tw_follow_cntr'] = $locker_social['show_tw_follow_cntr'];

                $locker_opts['is_linkedin_share'] = $locker_social['is_linkedin_share'];
                $locker_opts['linkedin_url_share'] = $locker_social['linkedin_url_share'];
                $locker_opts['is_linkedin_share_counter'] = $locker_social['is_linkedin_share_counter'];
            } else {
                
            }
            if (!empty($options)) {
                if (!empty($options) && is_array($options)) {
                    foreach ($options as $key => $value) {
                        $locker_view .= $arsocial_lite_locker->arsocialshare_sharing_locker_view($value, $id, $locker_social, $global_settings, $locker_opts);
                    }
                }
            }



            $locker_view .= "</div>";

            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup_inner_wrapper`-->";

            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup_inner`-->";

            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_popup`-->";

            $locker_view .= "<div class='arsocialshare_locked_content {$lockedContainerClass}' id='$lockedContainer' style='display:none;'>";
            $locker_view .= do_shortcode($locked_content);
            $locker_view .= "</div><!--`END ~ arsocialshare_locked_content`-->";


            $gs_settings = get_option('arslite_global_settings');
            $settings = maybe_unserialize($gs_settings);
            
            $locker_view .= "<input type='hidden' name='ars_locker_options' id='ars_locker_options' value='" . json_encode($locker_opts) . "' />";
            $locker_view .= "<input type='hidden' name='ars_global_settings' id='ars_global_settings' value='" . json_encode($settings) . "' />";


            $locker_view .= "</div><!--`END ~ arsocial_lite_locker_main_wrapper`-->";

            $locker_view = str_replace('<linebreaker>', '<br/>', $locker_view);

            $response['message'] = "success";
            $response['body'] = $locker_view;

            $response = apply_filters('arsocialsharelocker_view_msg', $response);
        }
        return json_encode($response);
    }

}
