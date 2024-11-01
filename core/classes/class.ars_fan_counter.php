<?php

class ARSocial_Lite_Fan {

    function __construct() {

        add_shortcode('ARSocial_Lite_Fan', array($this, 'arsocialshare_fan_counter'));

        add_action('wp_ajax_ars_lite_save_arsocial_fancounter', array($this, 'ars_lite_save_arsocial_fancounter'));

        add_action('ars_lite_fan_count_update_shedule', array($this, 'ars_update_fan_counter_data'));

        add_action('wp_ajax_arsocial_lite_remove_fan', array($this, 'arsocial_lite_remove_fan'));

        /* Add fan counter on page, post and custom post */
        add_filter('the_content', array($this, 'arsocial_lite_fan_filtered_content'));

        /* Add fan counter on post excerpt */
        add_filter('get_the_excerpt', array($this, 'arsocial_lite_fan_filtered_excerpt'));

        /* Add  fan counter after price in woocommerce */
        add_filter('woocommerce_get_price_html', array($this, 'arsocial_lite_fan_woocommerce_price_filter'));

        /* Display Button Before woocommerce Product */
        add_action('woocommerce_before_single_product', array($this, 'arsocial_lite_fan_woocommerce_before_single_product'));

        /* Display Button After woocommerce Product  */
        add_action('woocommerce_after_single_product', array($this, 'arsocial_lite_fan_woocommerce_after_single_product'));

        add_action('wp_ajax_arsocial_lite_save_fan_order', array($this, 'arsocial_lite_save_fan_order'));

        add_action('wp_ajax_ars_lite_fan_get_networks', array($this, 'ars_fan_get_networks'));
        add_action('wp_ajax_nopriv_ars_lite_fan_get_networks', array($this, 'ars_fan_get_networks'));
    }

    function arsocialshare_fan_counter($atts) {

        global $wpdb, $arsocial_lite_fan, $arsocial_lite_forms, $arsocial_lite;

        $networks = isset($atts['id']) ? $atts['id'] : '';
        $fan_position = isset($atts['position']) ? $atts['position'] : '';
        $is_excerpt = isset($atts['is_excerpt']) ? $atts['is_excerpt'] : false;
        if ($networks === '') {
            return esc_html__('No any shortcode selected.', 'arsocial_lite');
        }


        $arsocial_lite->ars_common_enqueue_js_css();
        wp_enqueue_script('ars-lite-fan-counter-js');


        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_front_fan.php')) {
            include ARSOCIAL_LITE_VIEWS_DIR . '/ars_front_fan.php';
            $response = arsocialshare_lite_fan_view($networks, $fan_position, $is_excerpt);
            $response = json_decode($response);
            $html = isset($response->body) ? $response->body : '';
        } else {
            $content = esc_html__('Network is Invalid. Please select valid Network', 'arsocial_lite');
        }

        if ($networks == 'ars_fan_global_settings') {
            $networks = '-100';
        }

        $post_id = get_the_ID();

        return $html;
        die();
    }

    function ars_update_fan_counter_data($id) {
        global $wpdb, $arsocial_lite_fan;
        if ($id == '') {
            return;
        }

        if ($id == 'ars_fan_global_settings') {
            $saved_fan_networks_global = maybe_unserialize(get_option('arslite_fan_display_settings'));
        } else {

            $fan_table = $wpdb->prefix . 'arsocial_lite_fan';

            $get_fan = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$fan_table` WHERE ID = %d", $id));

            $saved_fan_networks_global = maybe_unserialize($get_fan->content);
        }

        $counter_data = array();
        /* Facebook */
        $saved_fan_networks = isset($saved_fan_networks_global['facebook']) ? $saved_fan_networks_global['facebook'] : '';
        if (isset($saved_fan_networks['active_fb_fan']) && $saved_fan_networks['active_fb_fan'] == 1) {
            /* For Page */
            if (isset($saved_fan_networks['account_type']) && $saved_fan_networks['account_type'] == 'page') {
                if (isset($saved_fan_networks['fb_fan_access_token']) && isset($saved_fan_networks['fb_fan_url'])) {
                    $counter_data['facebook'] = $this->ars_facebook_page_fan($saved_fan_networks['fb_fan_url'], $saved_fan_networks['fb_fan_access_token']);
                }
            }
            /* For Profile */ else if (isset($saved_fan_networks['account_type']) && $saved_fan_networks['account_type'] == 'profile') {
                if (isset($saved_fan_networks['fb_fan_access_token'])) {
                    $counter_data['facebook'] = $this->ars_facebook_profile_fan($saved_fan_networks['fb_fan_access_token']);
                }
            }
        }
        /* Facebook Ends */

        /* twitter start */
        $saved_fan_networks = isset($saved_fan_networks_global['twitter']) ? $saved_fan_networks_global['twitter'] : '';
        if (isset($saved_fan_networks['active_twitter_fan']) && $saved_fan_networks['active_twitter_fan'] == 1) {
            if (isset($saved_fan_networks['twitter_fan_username']) && isset($saved_fan_networks['twitter_fan_consumer_key']) && isset($saved_fan_networks['twitter_fan_consumer_secret']) && isset($saved_fan_networks['twitter_fan_consumer_access_token']) && isset($saved_fan_networks['twitter_fan_consumer_access_token_secret'])) {
                $counter_data['twitter'] = $this->ars_twitter_fan($saved_fan_networks);
            }
        }
        /* twitter end */

        /* LinkedIn Start */
        $saved_fan_networks = isset($saved_fan_networks_global['linkedin']) ? $saved_fan_networks_global['linkedin'] : '';
        if (isset($saved_fan_networks['active_linkedin_fan']) && $saved_fan_networks['active_linkedin_fan'] == 1) {
            /* For Page */

            if (isset($saved_fan_networks['account_type']) && $saved_fan_networks['account_type'] == 'page') {
                if (isset($saved_fan_networks['linkedin_fan_url'])) {
                    $counter_data['linkedin'] = $this->ars_linkedin_page_fan($saved_fan_networks);
                }
            }
            /* For Profile */ else if (isset($saved_fan_networks['account_type']) && $saved_fan_networks['account_type'] == 'profile') {
                if (isset($saved_fan_networks['linkedin_fan_url']) && isset($saved_fan_networks['linkedin_fan_access_token'])) {
                    $counter_data['linkedin'] = $this->ars_linkedin_profile_fan($saved_fan_networks);
                }
            }
        }

        $options = maybe_serialize($counter_data);
        $table = $wpdb->prefix . 'arsocial_lite_fan';
        $update = $wpdb->prepare("UPDATE `$table` SET counter_data = %s WHERE ID = %d", $options, $id);
        $wpdb->query($update);

        return $counter_data;
        die();
    }

    function ars_facebook_page_fan($profile, $access_token) {
        global $ars_lite_fb_api_url, $ars_lite_fb_api_version;

        $request = wp_remote_get($ars_lite_fb_api_url . $ars_lite_fb_api_version . '/' . $profile . '?fields=likes&&access_token=' . $access_token);
        if (false == $request) {
            return null;
        }

        $response = json_decode(wp_remote_retrieve_body($request), true);

        if (isset($response ['likes'])) {
            return $response ['likes'];
        }
    }

    function ars_facebook_profile_fan($access_token) {
        global $ars_lite_fb_api_url, $ars_lite_fb_api_version;

        $request = wp_remote_get($ars_lite_fb_api_url . $ars_lite_fb_api_version . '/me/friends?access_token=' . $access_token);
        if (false == $request) {
            return null;
        }

        $response = json_decode(wp_remote_retrieve_body($request), true);

        if (isset($response ['summary'])) {
            return $response ['summary'] ['total_count'];
        }
    }

    function ars_twitter_fan($data) {

        if (!class_exists('TwitterOAuth')) {
            require_once (ARSOCIAL_LITE_CLASS_DIR . '/libs/twitter/twitteroauth.php');
        }
        $api = new TwitterOAuth($data['twitter_fan_consumer_key'], $data['twitter_fan_consumer_secret'], $data['twitter_fan_consumer_access_token'], $data['twitter_fan_consumer_access_token_secret']);


        $response = $api->get('users/lookup', array('screen_name' => trim($data['twitter_fan_username'])));

        if (isset($response->errors)) {
            return null;
        }

        if (isset($response [0]) && is_array($response [0])) {
            return $response [0] ['followers_count'];
        }

        if (isset($response [0]->followers_count)) {
            return $response [0]->followers_count;
        }
    }

    function ars_linkedin_page_fan($data) {
        $url = $data['linkedin_fan_url'];
        $account_type = $data['account_type'];
        $token = $data['linkedin_fan_access_token'];

        if (empty($url) || empty($account_type) || empty($token)) {
            return 0;
        }

        $args = array(
            'headers' => array('Authorization' => sprintf('Bearer %s', $token))
        );
        $get_request = wp_remote_get($url, array('timeout' => 18, 'sslverify' => false));
        $request = wp_remote_retrieve_body($get_request);

        $html = $request;
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        $data = $xpath->evaluate('string(//p[@class="followers-count"])');
        $result = (int) preg_replace('/[^0-9.]+/', '', $data);
        return $result;
    }

    function ars_linkedin_profile_fan($data) {
        global $ars_lite_linkedin_api_url, $ars_lite_linkedin_api_version;
        $url = $data['linkedin_fan_url'];
        $account_type = $data['account_type'];
        $token = $data['linkedin_fan_access_token'];

        if (empty($url) || empty($account_type) || empty($token)) {
            return 0;
        }

        $args = array(
            'headers' => array('Authorization' => sprintf('Bearer %s', $token))
        );

        $response = wp_remote_get($ars_lite_linkedin_api_url . $ars_lite_linkedin_api_version . '/people/~:(num-connections)?format=json', $args);

        if (is_wp_error($response))
            return 0;

        $result = json_decode(wp_remote_retrieve_body($response), true);

        if (!$result || !isset($result['numConnections']))
            return 0;

        return $result['numConnections'];
    }

    function ars_lite_save_arsocial_fancounter() {

        global $wpdb, $arsocial_lite_fan, $arsocial_lite;
        $values = json_decode(stripslashes_deep($_POST['filtered_data']), true);

        $response = array();
        $fan_options = array();
        $selected_network = array();
        /* facebook */
        $is_fb_fan = isset($values['active_fb_fan']) ? $values['active_fb_fan'] : '';
        if ($is_fb_fan == 1) {
            array_push($selected_network, 'facebook');
        }
        $fb_fan_url = isset($values['arsocialshare_fb_fan_url']) ? $values['arsocialshare_fb_fan_url'] : '';
        $fb_fan_account_type = isset($values['arsocialshare_fb_fan_account_type']) ? $values['arsocialshare_fb_fan_account_type'] : '';
        $fb_fan_access_token = isset($values['arsocialshare_fb_fan_access_token']) ? $values['arsocialshare_fb_fan_access_token'] : '';
        $fb_fan_manual_counter = isset($values['arsocialshare_fb_fan_manual_counter']) ? $values['arsocialshare_fb_fan_manual_counter'] : '';
        $fb_fan_text = isset($values['arsocialshare_fb_fan_text']) ? $values['arsocialshare_fb_fan_text'] : '';
        $fb_like_btn = isset($values['enable_fb_like']) ? $values['enable_fb_like'] : '';

        $fan_options['facebook']['active_fb_fan'] = $is_fb_fan;
        $fan_options['facebook']['fb_fan_url'] = $fb_fan_url;
        $fan_options['facebook']['account_type'] = $fb_fan_account_type;
        $fan_options['facebook']['fb_fan_access_token'] = $fb_fan_access_token;
        $fan_options['facebook']['manual_counter'] = $fb_fan_manual_counter;
        $fan_options['facebook']['fan_text'] = $fb_fan_text;
        $fan_options['facebook']['enable_like_btn'] = $fb_like_btn;
        /* facebook */

        /* twitter */
        $is_twitter_fan = isset($values['active_twitter_fan']) ? $values['active_twitter_fan'] : '';
        if ($is_twitter_fan == 1) {
            array_push($selected_network, 'twitter');
        }
        $twitter_fan_username = isset($values['arsocialshare_twitter_fan_username']) ? $values['arsocialshare_twitter_fan_username'] : '';
        $twitter_fan_consumer_key = isset($values['arsocialshare_twitter_fan_consumer_key']) ? $values['arsocialshare_twitter_fan_consumer_key'] : '';
        $twitter_fan_consumer_secret = isset($values['arsocialshare_twitter_fan_consumer_secret']) ? $values['arsocialshare_twitter_fan_consumer_secret'] : '';
        $twitter_fan_consumer_access_token = isset($values['arsocialshare_twitter_access_token']) ? $values['arsocialshare_twitter_access_token'] : '';
        $twitter_fan_consumer_token_secret = isset($values['arsocialshare_twitter_token_secret']) ? $values['arsocialshare_twitter_token_secret'] : '';
        $twitter_fan_manual_counter = isset($values['arsocialshare_twitter_fan_manual_counter']) ? $values['arsocialshare_twitter_fan_manual_counter'] : '';
        $twitter_fan_text = isset($values['arsocialshare_twitter_fan_text']) ? $values['arsocialshare_twitter_fan_text'] : '';
        $twitter_follow_btn = isset($values['enable_tw_follow']) ? $values['enable_tw_follow'] : '';

        $fan_options['twitter']['active_twitter_fan'] = $is_twitter_fan;
        $fan_options['twitter']['twitter_fan_username'] = $twitter_fan_username;
        $fan_options['twitter']['twitter_fan_consumer_key'] = $twitter_fan_consumer_key;
        $fan_options['twitter']['twitter_fan_consumer_secret'] = $twitter_fan_consumer_secret;
        $fan_options['twitter']['twitter_fan_consumer_access_token'] = $twitter_fan_consumer_access_token;
        $fan_options['twitter']['twitter_fan_consumer_access_token_secret'] = $twitter_fan_consumer_token_secret;
        $fan_options['twitter']['manual_counter'] = $twitter_fan_manual_counter;
        $fan_options['twitter']['fan_text'] = $twitter_fan_text;
        $fan_options['twitter']['enable_like_btn'] = $twitter_follow_btn;
        /* twitter */

        /* LInked IN start */
        $active_linkedin_fan = isset($values['active_linkedin_fan']) ? $values['active_linkedin_fan'] : '';
        if ($active_linkedin_fan == 1) {
            array_push($selected_network, 'linkedin');
        }
        $linkedin_fan_url = isset($values['arsocialshare_linkedin_fan_url']) ? $values['arsocialshare_linkedin_fan_url'] : '';
        $linkedin_fan_access_token = isset($values['arsocialshare_linkedin_fan_access_token']) ? $values['arsocialshare_linkedin_fan_access_token'] : '';
        $linkedin_fan_account_type = isset($values['arsocialshare_linkedin_fan_account_type']) ? $values['arsocialshare_linkedin_fan_account_type'] : '';
        $linkedin_fan_manual_counter = isset($values['arsocialshare_linkedin_fan_manual_counter']) ? $values['arsocialshare_linkedin_fan_manual_counter'] : '';
        $linkedin_fan_text = isset($values['arsocialshare_linkedin_fan_text']) ? $values['arsocialshare_linkedin_fan_text'] : '';
        $linkedin_follow_btn = isset($values['enable_IN_follow']) ? $values['enable_IN_follow'] : '';
        $linkedin_company_id = isset($values['arsocialshare_linkedin_fan_company_id']) ? $values['arsocialshare_linkedin_fan_company_id'] : '';

        $fan_options['linkedin']['active_linkedin_fan'] = $active_linkedin_fan;
        $fan_options['linkedin']['linkedin_fan_url'] = $linkedin_fan_url;
        $fan_options['linkedin']['linkedin_fan_access_token'] = $linkedin_fan_access_token;
        $fan_options['linkedin']['account_type'] = $linkedin_fan_account_type;
        $fan_options['linkedin']['manual_counter'] = $linkedin_fan_manual_counter;
        $fan_options['linkedin']['fan_text'] = $linkedin_fan_text;
        $fan_options['linkedin']['enable_like_btn'] = $linkedin_follow_btn;
        $fan_options['linkedin']['company_id'] = $linkedin_company_id;

        $display_option['active_network'] = $selected_network;
        $enable_on = (isset($values['arsocialshare_enable_fan_on']) && $values['arsocialshare_enable_fan_on'] !== '') ? $values['arsocialshare_enable_fan_on'] : 'page';
        $display_option['display_on'] = $enable_on;
        $display_type = isset($values['arsocialfan_display_style']) ? $values['arsocialfan_display_style'] : '';
        $fan_options['display_style'] = $display_type;
        $display_number_format = isset($values['arsocialshare_display_number_format']) ? $values['arsocialshare_display_number_format'] : '';
        $fan_options['display_number_format'] = $display_number_format;
        $fan_options['ars_btn_width'] = $display_number_format;

        $counter_update_time = isset($values['arsocialshare_fan_counter_update_time']) ? $values['arsocialshare_fan_counter_update_time'] : '';
        $fan_options['ars_btn_width'] = isset($values['ars_btn_width']) ? $values['ars_btn_width'] : '';
        $fan_options['ars_fan_more_button'] = isset($values['arsocialshare_more_button']) ? $values['arsocialshare_more_button'] : '';
        $fan_options['ars_fan_more_button_style'] = isset($values['arsocialshare_sidebar_more_button_style']) ? $values['arsocialshare_sidebar_more_button_style'] : '';
        $fan_options['ars_fan_more_button_action'] = isset($values['arsocialshare_more_button_action']) ? $values['arsocialshare_more_button_action'] : '';
        $fan_options['ars_btn_align'] = isset($values['ars_btn_align']) ? $values['ars_btn_align'] : '';

        $fan_options['ars_fan_like_follow_btn_position'] = isset($values['arsfan_like_follow_position']) ? $values['arsfan_like_follow_position'] : '';

        if ($enable_on == 'page') {
            $display_option['page'] = array();
        }



        if ($enable_on == 'sidebar') {
            $fan_sidebar = (isset($values['arsocialshare_sidebar']) && $values['arsocialshare_sidebar'] !== '' ) ? $values['arsocialshare_sidebar'] : '';
            $display_option['sidebar']['position'] = $fan_sidebar;
        }


        if ($enable_on == 'top_bottom_bar') {
            $display_option['top_bottom_bar']['onload_type'] = isset($values['arsocialshare_top_bottom_bar_display_on']) ? $values['arsocialshare_top_bottom_bar_display_on'] : "";
            $display_option['top_bottom_bar']['onscroll_percentage'] = isset($values['arsocialshare_top_bottom_bar_onscroll_percentage']) ? $values['arsocialshare_top_bottom_bar_onscroll_percentage'] : "";
            $display_option['top_bottom_bar']['onload_time'] = isset($values['arsocialshare_top_bottom_bar_onload_time']) ? $values['arsocialshare_top_bottom_bar_onload_time'] : "";
            $display_option['top_bottom_bar']['position'] = isset($values['arsocialshare_top_bar']) ? $values['arsocialshare_top_bar'] : "";
            $display_option['top_bottom_bar']['y_point'] = isset($values['ars_fan_top_bar_y_position']) ? $values['ars_fan_top_bar_y_position'] : '';
        }


        if ($enable_on == 'popup') {
            $display_option['popup']['onload_type'] = (isset($values['arsocialshare_popup_display_on'])) ? $values['arsocialshare_popup_display_on'] : '';
            $display_option['popup']['open_delay'] = isset($values['arsocialshare_popup_onload_time']) ? $values['arsocialshare_popup_onload_time'] : '';
            $display_option['popup']['open_scroll'] = isset($values['arsocialshare_popup_onscroll_percentage']) ? $values['arsocialshare_popup_onscroll_percentage'] : '';
            $display_option['popup']['popup_width'] = isset($values['arsocialshare_popup_width']) ? $values['arsocialshare_popup_width'] : '';
            $display_option['popup']['popup_height'] = isset($values['arsocialshare_popup_height']) ? $values['arsocialshare_popup_height'] : '';
            $display_option['popup']['ars_fan_pop_show_close_button'] = isset($values['ars_fan_pop_show_close_button']) ? $values['ars_fan_pop_show_close_button'] : '';
        }

        $display_option['fan_network_order'] = $values['arsocialshare_fancounter_networks'];
        $fan_options['display'] = $display_option;


        $fan_action = isset($values['arsocial_fan_action']) ? $values['arsocial_fan_action'] : '';
        $fan_id = isset($values['fan_id']) ? $values['fan_id'] : '';
        $created_date = $updated_date = current_time('mysql');

        $response = array();
        $response['message'] = 'success';
        $options = maybe_serialize($fan_options);
        $table = $wpdb->prefix . 'arsocial_lite_fan';
        if ($fan_action === 'new-fan' || $fan_action === 'duplicate') {

            $insert = $wpdb->prepare("INSERT INTO `$table` (content,display_type,update_time,created_date,updated_date) VALUES (%s,%s,%s,%s,%s)", $options, $display_type, $counter_update_time, $created_date, $updated_date);
            if ($wpdb->query($insert)) {
                $response['message'] = 'success';
                $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
                $response['id'] = $wpdb->insert_id;
                $response['action'] = 'new_fan';
            } else {
                
            }
        } else if ($fan_action === 'edit-fan') {
            $update = $wpdb->prepare("UPDATE `$table` SET content = %s, display_type = %s,update_time= %s, updated_date = %s WHERE ID = %d", $options, @$display_type, $counter_update_time, $updated_date, $fan_id);

            if ($wpdb->query($update)) {
                $response['message'] = 'success';
                $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
                $response['id'] = $fan_id;
                $response['action'] = 'edit_fan';
            } else {
                
            }
        } else if ($fan_action === 'global_display_settings') {

            /* for all post pages,special pages and cpt */

            $display_option = array();
            $display_option['active_network'] = $selected_network;
            $network_order = (isset($values['arsocialshare_fancounter_networks']) && $values['arsocialshare_fancounter_networks'] !== '') ? $values['arsocialshare_fancounter_networks'] : '';
            update_option('arslite_global_fancounter_order', $network_order);

            $enable_pages = (isset($values['arsfan_enable_pages']) && $values['arsfan_enable_pages'] !== '' ) ? $values['arsfan_enable_pages'] : '';

            $enable_posts = (isset($values['arsfan_enable_posts']) && $values['arsfan_enable_posts'] !== '' ) ? $values['arsfan_enable_posts'] : '';

            $enable_woocommerce = (isset($values['ars_enable_woocommerce']) && $values['ars_enable_woocommerce'] !== '' ) ? $values['ars_enable_woocommerce'] : '';

            if ($enable_pages !== '') {
                $display_option['page'] = array();
                $display_option['page']['skin'] = isset($values['arsfan_page_skin']) ? $values['arsfan_page_skin'] : 'metro';
                $display_option['page']['no_format'] = isset($values['arsfan_page_number_format']) ? $values['arsfan_page_number_format'] : 'style1';
                $display_option['page']['top'] = ( isset($values['ars_fan_page_position_top']) && $values['ars_fan_page_position_top'] === 'top' ) ? true : false;
                $display_option['page']['bottom'] = ( isset($values['ars_fan_page_position_bottom']) && $values['ars_fan_page_position_bottom'] === 'bottom' ) ? true : false;
                $display_option['page']['update_data'] = isset($values['ars_fan_pages_update_data']) ? $values['ars_fan_pages_update_data'] : '';
                $display_option['page']['btn_alignment'] = isset($values['ars_page_btn_align']) ? $values['ars_page_btn_align'] : '';
                $display_option['page']['btn_width'] = isset($values['ars_pages_btn_width']) ? $values['ars_pages_btn_width'] : 'medium';
                $display_option['page']['more_btn'] = isset($values['arsfan_more_button']) ? $values['arsfan_more_button'] : '';
                $display_option['page']['more_btn_style'] = isset($values['arsfan_page_more_button_style']) ? $values['arsfan_page_more_button_style'] : '';
                $display_option['page']['more_btn_action'] = isset($values['arsfan_pages_more_btn_action']) ? $values['arsfan_pages_more_btn_action'] : '';
                $display_option['page']['like_follow_btn_position'] = isset($values['arsfan_pages_like_follow_position']) ? $values['arsfan_pages_like_follow_position'] : '';
                $display_option['page']['exclude_pages'] = isset($values['arsfan_page_exclude']) ? $values['arsfan_page_exclude'] : '';
            }

            if ($enable_posts !== '') {
                $display_option['post'] = array();
                $display_option['post']['skin'] = isset($values['arsfan_post_skin']) ? $values['arsfan_post_skin'] : '';
                $display_option['post']['no_format'] = isset($values['ars_posts_no_format']) ? $values['ars_posts_no_format'] : '';
                $display_option['post']['top'] = isset($values['arsfan_post_position_top']) ? $values['arsfan_post_position_top'] : '';
                $display_option['post']['bottom'] = isset($values['arsfan_post_position_bottom']) ? $values['arsfan_post_position_bottom'] : '';
                $display_option['post']['update_data'] = isset($values['arsfan_posts_update_data']) ? $values['arsfan_posts_update_data'] : '';
                $display_option['post']['btn_alignment'] = isset($values['ars_posts_btn_align']) ? $values['ars_posts_btn_align'] : '';
                $display_option['post']['btn_width'] = isset($values['ars_posts_btn_width']) ? $values['ars_posts_btn_width'] : '';
                $display_option['post']['more_btn'] = isset($values['arsocialshare_posts_more_button']) ? $values['arsocialshare_posts_more_button'] : '';
                $display_option['post']['more_btn_style'] = isset($values['arsocialshare_posts_more_button_style']) ? $values['arsocialshare_posts_more_button_style'] : '';
                $display_option['post']['more_btn_action'] = isset($values['arsocialshare_posts_more_button_action']) ? $values['arsocialshare_posts_more_button_action'] : '';
                $display_option['post']['excerpt'] = isset($values['ars_fan_enable_post_excerpt']) ? $values['ars_fan_enable_post_excerpt'] : '';
                $display_option['post']['like_follow_btn_position'] = isset($values['arsfan_posts_like_follow_position']) ? $values['arsfan_posts_like_follow_position'] : '';
                $display_option['post']['exclude_pages'] = isset($values['arsocialshare_posts_excludes']) ? $values['arsocialshare_posts_excludes'] : '';
            }

            if ($enable_woocommerce !== '' && $enable_woocommerce !== 'no') {
                $display_option['woocommerce'] = array();
                $display_option['woocommerce']['skin'] = isset($values['ars_fan_woocommerce_skins']) ? $values['ars_fan_woocommerce_skins'] : '';
                $display_option['woocommerce']['after_price'] = isset($values['ars_fan_woocommerce_after_price']) ? $values['ars_fan_woocommerce_after_price'] : '';
                $display_option['woocommerce']['before_product'] = isset($values['ars_fan_woocommerce_before_product']) ? $values['ars_fan_woocommerce_before_product'] : '';
                $display_option['woocommerce']['after_product'] = isset($values['ars_fan_woocommerce_after_product']) ? $values['ars_fan_woocommerce_after_product'] : '';
                $display_option['woocommerce']['no_format'] = isset($values['arsfan_woocommerce_number_format']) ? $values['arsfan_woocommerce_number_format'] : '';
                $display_option['woocommerce']['update_data'] = isset($values['arsfan_woocommerce_update_data']) ? $values['arsfan_woocommerce_update_data'] : '';
                $display_option['woocommerce']['btn_align'] = isset($values['ars_woocommerce_btn_align']) ? $values['ars_woocommerce_btn_align'] : '';
                $display_option['woocommerce']['btn_width'] = isset($values['ars_woocommerce_btn_width']) ? $values['ars_woocommerce_btn_width'] : '';
                $display_option['woocommerce']['more_btn'] = isset($values['arsocialshare_woocommerce_more_button']) ? $values['arsocialshare_woocommerce_more_button'] : '';
                $display_option['woocommerce']['more_btn_style'] = isset($values['arsocialshare_woocommerce_more_button_style']) ? $values['arsocialshare_woocommerce_more_button_style'] : '';
                $display_option['woocommerce']['more_btn_action'] = isset($values['arsocialshare_woocommerce_more_button_action']) ? $values['arsocialshare_woocommerce_more_button_action'] : '';
                $display_option['woocommerce']['exclude_pages'] = isset($values['arsocialshare_page_excludes_woocommerce']) ? addslashes($values['arsocialshare_page_excludes_woocommerce']) : '';
                $display_option['woocommerce']['like_follow_btn_position'] = isset($values['arsfan_woocommerce_like_follow_position']) ? $values['arsfan_woocommerce_like_follow_position'] : '';
            }

            $enable_sidebar = (isset($values['arsocialshare_enable_sidebar']) && $values['arsocialshare_enable_sidebar'] !== '') ? $values['arsocialshare_enable_sidebar'] : '';

            if ($enable_sidebar !== '') {
                $display_option['sidebar'] = array();
                $display_option['sidebar']['skin'] = isset($values['arsocialfan_display_style_sidebar']) ? $values['arsocialfan_display_style_sidebar'] : 'metro';
                $display_option['sidebar']['no_format'] = isset($values['arsfan_sidebar_display_number_format']) ? $values['arsfan_sidebar_display_number_format'] : 'style1';
                $display_option['sidebar']['position'] = isset($values['ars_fan_sidebar_position']) ? $values['ars_fan_sidebar_position'] : '';
                $display_option['sidebar']['update_data'] = isset($values['ars_fan_sidebar_counter_update_time']) ? $values['ars_fan_sidebar_counter_update_time'] : '';
                $display_option['sidebar']['button_width'] = isset($values['arsfan_sidebar_btn_width']) ? $values['arsfan_sidebar_btn_width'] : '';
                $display_option['sidebar']['more_btn'] = isset($values['arsfan_sidebar_more_button']) ? $values['arsfan_sidebar_more_button'] : '';
                $display_option['sidebar']['more_btn_style'] = isset($values['arsfan_sidebar_more_button_style']) ? $values['arsfan_sidebar_more_button_style'] : '';
                $display_option['sidebar']['more_btn_action'] = isset($values['arsfan_sidebar_more_button_action']) ? $values['arsfan_sidebar_more_button_action'] : '';
                $display_option['sidebar']['like_follow_btn_position'] = isset($values['arsfan_sidebar_like_follow_position']) ? $values['arsfan_sidebar_like_follow_position'] : '';
                $display_option['sidebar']['exclude_pages'] = isset($values['arsocialshare_page_excludes_sidebar']) ? $values['arsocialshare_page_excludes_sidebar'] : '';
            }

            $enable_bar = (isset($values['arsocialshare_enable_top_bottom_bar']) && $values['arsocialshare_enable_top_bottom_bar'] !== '' ) ? $values['arsocialshare_enable_top_bottom_bar'] : '';
            if ($enable_bar !== '') {
                $display_option['fan_bar'] = array();
                $display_option['fan_bar']['skin'] = isset($values['arsocialfan_display_style_bar']) ? $values['arsocialfan_display_style_bar'] : 'metro';
                $display_option['fan_bar']['no_format'] = isset($values['arsfan_bar_display_number_format']) ? $values['arsfan_bar_display_number_format'] : 'style1';
                $display_option['fan_bar']['top'] = isset($values['arsfan_bar_top']) ? $values['arsfan_bar_top'] : '';
                $display_option['fan_bar']['bottom'] = isset($values['arsfan_bar_bottom']) ? $values['arsfan_bar_bottom'] : '';
                $display_option['fan_bar']['update_data'] = isset($values['arsfan_bar_counter_update_time']) ? $values['arsfan_bar_counter_update_time'] : '';
                $display_option['fan_bar']['display_on'] = isset($values['ars_fan_display_bar']) ? $values['ars_fan_display_bar'] : '';
                $display_option['fan_bar']['load_time'] = isset($values['ars_fan_bar_onload_time']) ? $values['ars_fan_bar_onload_time'] : '';
                $display_option['fan_bar']['scroll_value'] = isset($values['ars_fan_bar_onscroll_percentage']) ? $values['ars_fan_bar_onscroll_percentage'] : '';
                $display_option['fan_bar']['button_width'] = isset($values['ars_fan_bar_btn_width']) ? $values['ars_fan_bar_btn_width'] : '';
                $display_option['fan_bar']['more_btn'] = isset($values['arsfan_bar_more_button']) ? $values['arsfan_bar_more_button'] : '';
                $display_option['fan_bar']['more_btn_style'] = isset($values['ars_fan_bar_more_button_style']) ? $values['ars_fan_bar_more_button_style'] : '';
                $display_option['fan_bar']['more_btn_action'] = isset($values['ars_fan_bar_more_button_action']) ? $values['ars_fan_bar_more_button_action'] : '';
                $display_option['fan_bar']['btn_alignment'] = isset($values['ars_fanbar_btn_align']) ? $values['ars_fanbar_btn_align'] : 'center';
                $display_option['fan_bar']['exclude_pages'] = isset($values['arsocialshare_page_excludes_fan_bar']) ? $values['arsocialshare_page_excludes_fan_bar'] : '';
                $display_option['fan_bar']['y_point'] = isset($values['arsfan_bar_y_position']) ? $values['arsfan_bar_y_position'] : '';
                $display_option['fan_bar']['like_follow_btn_position'] = isset($values['arsfan_fan_bar_like_follow_position']) ? $values['arsfan_fan_bar_like_follow_position'] : '';
            }

            $enable_popup = (isset($values['arsocialshare_enable_popup'])) ? $values['arsocialshare_enable_popup'] : '';

            if ($enable_popup !== '') {
                $display_option['popup'] = array();
                $display_option['popup']['skin'] = isset($values['arsocialfan_popup_skin']) ? $values['arsocialfan_popup_skin'] : 'metro';
                $display_option['popup']['no_format'] = isset($values['ars_fan_popup_number_format']) ? $values['ars_fan_popup_number_format'] : 'style1';
                $display_option['popup']['update_data'] = isset($values['ars_fan_popup_update_time']) ? $values['ars_fan_popup_update_time'] : '';
                $display_option['popup']['onload_type'] = (isset($values['ars_fan_display_popup'])) ? $values['ars_fan_display_popup'] : '';
                $display_option['popup']['open_delay'] = isset($values['ars_fan_popup_onload_time']) ? $values['ars_fan_popup_onload_time'] : '';
                $display_option['popup']['open_scroll'] = isset($values['ars_fan_popup_bar_onscroll_percentage']) ? $values['ars_fan_popup_bar_onscroll_percentage'] : '';
                $display_option['popup']['button_width'] = isset($values['ars_popup_btn_width']) ? $values['ars_popup_btn_width'] : '';
                $display_option['popup']['height'] = isset($values['ars_fan_popup_height']) ? $values['ars_fan_popup_height'] : '';
                $display_option['popup']['width'] = isset($values['ars_fan_popup_width']) ? $values['ars_fan_popup_width'] : '';
                $display_option['popup']['display_close_btn'] = isset($values['arsocialshare_popup_close_btn']) ? $values['arsocialshare_popup_close_btn'] : '';
                $display_option['popup']['exclude_pages'] = isset($values['arsocialshare_page_excludes_popup']) ? $values['arsocialshare_page_excludes_popup'] : '';
                $display_option['popup']['like_follow_btn_position'] = isset($values['arsfan_popup_like_follow_position']) ? $values['arsfan_popup_like_follow_position'] : '';
            }

            $enable_mobile = (isset($values['arsocialshare_enable_mobile'])) ? $values['arsocialshare_enable_mobile'] : '';

            if ($enable_mobile != '') {
                $display_option['mobile']['disply_type'] = isset($values['arsocialshare_display_mobile']) ? $values['arsocialshare_display_mobile'] : '';

                $display_option['mobile']['skin'] = isset($values['arsocialfan_display_style_mobile']) ? $values['arsocialfan_display_style_mobile'] : '';
                $display_option['mobile']['more_button_style'] = isset($values['arsocialshare_mobile_more_button_style']) ? $values['arsocialshare_mobile_more_button_style'] : '';
                $display_option['mobile']['bar_label'] = isset($values['arsocialshare_mobile_bottom_bar_label']) ? $values['arsocialshare_mobile_bottom_bar_label'] : '';
                $display_option['mobile']['button_position'] = isset($values['arsocialshare_mobile_more_button_position']) ? $values['arsocialshare_mobile_more_button_position'] : '';
            }

            $display_option['hide_mobile']['enable_mobile_hide_top'] = (isset($values['arsocialshare_mobile_hide_top'])) ? $values['arsocialshare_mobile_hide_top'] : '';
            $display_option['hide_mobile']['enable_mobile_hide_bottom'] = (isset($values['arsocialshare_mobile_hide_bottom'])) ? $values['arsocialshare_mobile_hide_bottom'] : '';
            $display_option['hide_mobile']['enable_mobile_hide_sidebar'] = (isset($values['arsocialshare_mobile_hide_sidebar'])) ? $values['arsocialshare_mobile_hide_sidebar'] : '';
            $display_option['hide_mobile']['enable_mobile_hide_top_bottom_bar'] = (isset($values['enable_mobile_hide_top_bottom_bar'])) ? $values['enable_mobile_hide_top_bottom_bar'] : '';
            $display_option['hide_mobile']['enable_mobile_hide_onload'] = (isset($values['arsocialshare_mobile_hide_onload'])) ? $values['arsocialshare_mobile_hide_onload'] : '';

            $fan_options['display'] = $display_option;

            $fan_options['display_style'] = $display_type;

            $fan_options = maybe_serialize($fan_options);

            update_option('arslite_fan_display_settings', $fan_options);

            $response['message'] = 'success';
            $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
        }

        $response = apply_filters('arsocial_lite_fan_save_msg_filter', $response);
        echo json_encode($response);
        die();
    }

    function arsocial_lite_remove_fan() {
        $fan_id = isset($_POST['fan_id']) ? $_POST['fan_id'] : '';

        $response = array();
        if ($fan_id === '') {
            $response['result'] = "error";
            $response['code'] = "404";
            $response['message'] = esc_html__('Please Select valid setup id.', 'arsocial_lite');
        } else {
            global $wpdb,$arsocial_lite;
            $table = $arsocial_lite->arslite_fan;
            $data = array('ID' => $fan_id);
            if ($wpdb->delete($table, $data)) {
                $response['result'] = "success";
                $response['code'] = "200";
                $response['message'] = esc_html__('Setup has been deleted successfully.', 'arsocial_lite');
            } else {
                $response['result'] = "error";
                $response['code'] = "404";
                $response['message'] = esc_html__('Could not delete setup.', 'arsocial_lite');
            }
        }
        echo json_encode($response);
        exit;
    }

    function ARSocialShareLoadLiveData($force_load = false, $id = '') {
        global $wpdb;
        $table = $wpdb->prefix . 'arsocial_lite_fan';
        $query = $wpdb->get_results("SELECT * FROM `$table`");
        if ($force_load === true) {
            return;
        }
        //arsocial_lite_global_settings
        $options = maybe_unserialize(get_option('arslite_global_settings'));
        $updated_time = $options['fan_counter_update_data'];
        $current_time = time();
        if ($query) {
            foreach ($query as $key => $result) {
                global $arsocial_lite_fan;
                $id = $result->ID;
                //$updated_time = $result->update_time;
                $last_updated_time = get_option('wp_arslite_time');
                $last_run_cron = get_option('arslite_fancounter_cron_' . $id);
                if ($last_run_cron == '') {
                    $last_run_cron = time();
                    update_option('arslite_fancounter_cron_' . $id, $last_run_cron);
                    $last_run_cron = get_option('arslite_fancounter_cron_' . $id);
                }
                $cache_lifetime = date('Y-m-d h:i:s', $current_time);
                $updated_datetime = date('Y-m-d h:i:s', $last_run_cron);
                $date1 = new DateTime($current_datetime);
                $date2 = new DateTime($updated_datetime);
                $diff = $date1->diff($date2);
                $minutes = $diff->i;

                if ($last_updated_time > 0 && $last_updated_time !== '') {
                    if ($minutes >= $updated_time) {
                        $this->ars_update_fan_counter_data($id);
                        update_option('arslite_fancounter_cron_' . $id, time());
                    }
                }
            }
        }
        $global_settings = 'ars_fan_global_settings';
        if ($global_settings === 'ars_fan_global_settings') {
            $settings = maybe_unserialize(get_option('arslite_fan_display_settings'));
            $display_settings  = !empty( $settings['display'] ) ? $settings['display'] : '';
            //$updated_time = $update_time;
            $last_updated_time = get_option('wp_arslite_time');
            $last_run_cron = get_option('arslite_fancounter_cron_' . $global_settings);
            if ($last_run_cron == '') {
                $last_run_cron = time();
                update_option('arslite_fancounter_cron_' . $global_settings, $last_run_cron);
                $last_run_cron = get_option('arslite_fancounter_cron_' . $global_settings);
            }
            $cache_lifetime = date('Y-m-d h:i:s', $current_time);
            $updated_datetime = date('Y-m-d h:i:s', $last_run_cron);
            $date1 = new DateTime($current_datetime);
            $date2 = new DateTime($updated_datetime);
            $diff = $date1->diff($date2);
            $minutes = $diff->i;
            if ($last_updated_time > 0 && $last_updated_time !== '') {
                if ($minutes >= $updated_time) {
                    $this->ars_update_fan_counter_data($global_settings);
                    update_option('arslite_fancounter_cron_' . $global_settings, time());
                }
            }
        }
    }

    function ARSocialShareGetCacheLifeTime($id = '') {
        if ($id == '') {
            return 0;
        }
    }

    /**
     * Function to add social fan counter on page content, post content, custom post content
     */
    function arsocial_lite_fan_filtered_content($content) {
        if (is_admin() || !is_singular()) {
            return $content;
        }
        $gs_settings = get_option('arslite_global_settings');
        $settings_global = maybe_unserialize($gs_settings);
        $settings_encode = json_encode($settings_global);
        $settings = maybe_unserialize(get_option('arslite_fan_display_settings'));

        $is_custom_css_add = false;

        $changed_content = "";
        
        $changed_content .= "<input type='hidden' name='ars_global_fan_settings' id='ars_global_fan_settings' value='" . $settings_encode . "' />";
                
        $post_id = get_the_ID();

        if ($post_id === '') {
            return $content;
        } else {
            if (empty($settings)) {
                return $content;
            } else {
                if (empty($settings['display'])) {
                    return $content;
                } else {

                    $post_type = get_post_type($post_id);

                    $display_settings = $settings['display'];
                    $hide_options = $display_settings['hide_mobile'];

                    /* Sidebar Change */

                    if (!empty($display_settings) && array_key_exists('sidebar', $display_settings)) {
                        if (wp_is_mobile() && $hide_options['enable_mobile_hide_sidebar']) {

                        } else {

                            $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=sidebar]";
                            $changed_content .= do_shortcode($shortcode_content);
                        }
                    }
                    /* Sidebar Change */

                    /* Popup Change */
                    if (!empty($display_settings) && array_key_exists('popup', $display_settings)) {
                        if (wp_is_mobile() && $hide_options['enable_mobile_hide_onload']) {

                        } else {
                            $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=popup]";
                            $changed_content .= do_shortcode($shortcode_content);
                        }
                    }
                    /* Popup Change */

                    if (!empty($display_settings) && array_key_exists('fan_bar', $display_settings)) {
                        if (wp_is_mobile() && $hide_options['enable_mobile_hide_top_bottom_bar']) {

                        } else {
                            $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=fanbar]";
                            $changed_content .= do_shortcode($shortcode_content);
                        }
                    }

                    /* Page & Post Change */
                    if (!empty($display_settings) && array_key_exists($post_type, $display_settings)) {

                        $exclude_post_id = array();
                        $settings['display'][$post_type]['exclude_pages'] = isset($settings['display'][$post_type]['exclude_pages']) ? $settings['display'][$post_type]['exclude_pages'] : array();
                        $exclude_post_id = explode(',', $settings['display'][$post_type]['exclude_pages']);
                        if (in_array($post_id, $exclude_post_id)) {
                            $changed_content .= $content;
                        } else {
                            $set_opt = $display_settings[$post_type];
                            $display_top = isset($set_opt['top']) ? $set_opt['top'] : '';
                            $display_bottom = isset($set_opt['bottom']) ? $set_opt['bottom'] : '';

                            if ($hide_options['enable_mobile_hide_top'] && wp_is_mobile()) {
                                // Hide on Mobile
                            } else {

                                if ($display_top) {
                                    $changed_content .='<div class="arsocial_lite_fan_top_button" id="arsocial_lite_fan_top_button">';
                                    $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=" . $post_type . "]";
                                    $changed_content .= do_shortcode($shortcode_content);
                                    $changed_content .='</div>';
                                }
                            }

                            $changed_content .= $content;
                            if ($hide_options['enable_mobile_hide_bottom'] && wp_is_mobile()) {
                                // Hide on Mobile
                            } else {
                                if ($display_bottom) {
                                    $changed_content .='<div class="arsocial_lite_fan_bottom_button" id="arsocial_lite_fan_bottom_button">';
                                    $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=" . $post_type . "]";
                                    $changed_content .= do_shortcode($shortcode_content);
                                    $changed_content .='</div>';
                                }
                            }
                        }
                    }
                    if (isset($settings['display']['mobile']) && wp_is_mobile()) {
                        $display_type = (isset($settings['display']['mobile']['disply_type']) && !empty($settings['display']['mobile']['disply_type'])) ? $settings['display']['mobile']['disply_type'] : '';
                        if ($display_type === 'share_button_bar') {
                            $changed_content .= "<div class='arsocialshare_share_button_bar_wrapper' id='arsocialshare_fan_button_bar_wrapper' style=''>";
                            $changed_content .= "<img src='" . ARSOCIALSHAREIMAGESURL . "/fan_counter_icon.png'>";
                            $changed_content .= isset($settings['display']['mobile']['bar_label']) ? $settings['display']['mobile']['bar_label'] : '';
                            $changed_content .= "</div>";
                        }

                        if ($display_type == 'share_point') {
                            $disply_type = isset($settings['display']['mobile']['button_position']) ? 'share_' . $settings['display']['mobile']['button_position'] . '_point' : 'share_left_point';
                            $changed_content .= "<div class='arsocialshare_share_point_wrapper " . $disply_type . "' id='arsocialshare_fan_point_wrapper' style=''>";
                            $changed_content .= "<img src='" . ARSOCIALSHAREIMAGESURL . "/fan_counter_icon.png'>";
                            $changed_content .= "</div>";
                        }

                        if ($display_type == 'share_footer_icons') {

                            $changed_content .= "<div class='arsocial_fan_footer_icons' id='arsocialshare_fan_footer_icons' style=''>";
                            $shortcode_content = "[ARSocial_Lite_Fan id='ars_fan_global_settings' position='mobile_footer_icons']";
                            $changed_content .= do_shortcode($shortcode_content);

                            $changed_content.= "</div>";
                        }

                        $changed_content .= "<div class='arsocialshare_mobile_wrapper' id='arsocial_fan_mobile_wrapper' style='display:none;' >";

                        $changed_content .= "<div class='arsocialshare_mobile_close' id='arsocialshare_mobile_close'><span><img src='" . ARSOCIAL_LITE_IMAGES_URL . "/ars_close.png'></span></div>";

                        $shortcode_content = "[ARSocial_Lite_Fan id='ars_fan_global_settings' position='mobile']";
                        $changed_content .= do_shortcode($shortcode_content);

                        $changed_content.= "</div>";
                    }

                    if (!array_key_exists($post_type, $settings['display'])) {
                        $changed_content .= $content;
                    }
                    /* Page & Post Change */
                }
            }
        }

        if ($changed_content === '') {
            $changed_content = $content;
        }

        return $changed_content;
    }

    /**
     * Function for add social  fan button on post excerpt.
     * 
     * @since v1.0
     */
    function arsocial_lite_fan_filtered_excerpt($excerpt) {
        if (is_admin()) {
            return $excerpt;
        }
        $settings = maybe_unserialize(get_option('arslite_fan_display_settings'));

        $is_custom_css_add = false;

        $changed_content = "";
        $post_id = get_the_ID();

        if ($post_id === '') {
            return $excerpt;
        } else {
            if (empty($settings)) {
                return $excerpt;
            } else {
                if (empty($settings)) {
                    return $excerpt;
                } else {
                    if (isset($settings['display']['post']) && $settings['display']['post']['excerpt'] === 'no') {
                        return $excerpt;
                    }
                    $post_type = get_post_type($post_id);
                    $exclude_post_id = array();
                    if (isset($settings['display']['post']['exclude_pages'])) {
                        $exclude_post_id = explode(',', $settings['display']['post']['exclude_pages']);

                        if (in_array($post_id, $exclude_post_id)) {
                            return $excerpt;
                        }
                    }

                    $display_settings = $settings['display'];

                    if (array_key_exists('post', $display_settings)) {
                        $set_opt = $display_settings['post'];
                        $display_top = '';
                        $display_bottom = '1';
                        $display_float = isset($set_opt['floating']) ? $set_opt['floating'] : '';
                        $button_align = "right";
                        $changed_content .= $excerpt;
                        if ($display_bottom) {

                            $changed_content .= "<div class='arsocialshare_network_fan_button_settings arsocial_lite_fan_bottom_button' id='arsocial_lite_fan_bottom_button'>";
                            $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=post is_excerpt='true']";
                            $changed_content .= do_shortcode($shortcode_content);
                            $changed_content .= "</div>";
                        }
                    } else {
                        $changed_content .= $excerpt;
                    }
                }
            }
        }

        return $changed_content;
    }

    /**
     * Function for add social  fan button after product price
     * 
     * @since v1.0
     */
    function arsocial_lite_fan_woocommerce_price_filter($price) {
        if (is_admin()) {
            return $price;
        }
        $settings = maybe_unserialize(get_option('arslite_fan_display_settings'));

        $display = $settings['display'];

        $changed_content = "";
        if (empty($display)) {
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
            if (isset($display['woocommerce']['after_price']) && $display['woocommerce']['after_price'] && array_key_exists('woocommerce', $display)) {

                $changed_content .= $price;
                $changed_content .= "<br/>";
                $changed_content .= "<div class='arsocialshare_network_fan_button_settings arsocialshare_align_left arsocialfan_button_after_price' id='arsocialfan_button_after_price'>";
                $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=after_price]";
                $changed_content .= do_shortcode($shortcode_content);
                $changed_content .= "</div>";
            } else {
                return $price;
            }
        }

        return $changed_content;
    }

    /**
     * Function for add social  fan button before product
     * 
     * @since v1.0
     */
    function arsocial_lite_fan_woocommerce_before_single_product() {
        $settings = maybe_unserialize(get_option('arslite_fan_display_settings'));
        $isadminbarvisible = (is_admin_bar_showing()) ? "wp_bar_visible" : "";

        $display = $settings['display'];
        $display_float = isset($display['woocommerce']['wc_floating']) ? $display['woocommerce']['wc_floating'] : '';
        $button_align = isset($display['woocommerce']['align']) ? $display['woocommerce']['align'] : '';
        $enable_float = ( $display_float ) ? true : false;
        $changed_content = "";
        if (empty($display)) {
            echo "";
        } else {
            $post_id = get_the_ID();
            $exclude_post_id = array();
            if (isset($settings['display']['woocommerce']['exclude'])) {
                $exclude_post_id = explode(',', $settings['display']['woocommerce']['exclude']);
                if (in_array($post_id, $exclude_post_id)) {
                    return '';
                }
            }
            if (isset($display['woocommerce']['before_product']) && $display['woocommerce']['before_product'] && array_key_exists('woocommerce', $display)) {

                $changed_content .= "<div class='arsocialshare_network_fan_button_settings arsocialshare_align_{$button_align} {$isadminbarvisible} arsocialfan_button_before_product' data-enable-floating='$enable_float' id='arsocialfan_button_before_product'>";
                $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=before_product]";
                $changed_content .= do_shortcode($shortcode_content);
                $changed_content .= "</div>";
            } else {
                echo "";
            }
        }

        echo $changed_content;
    }

    /**
     * Function for add social  fan button after product 
     * 
     * @since v1.0
     */
    function arsocial_lite_fan_woocommerce_after_single_product() {
        $settings = maybe_unserialize(get_option('arslite_fan_display_settings'));
        $isadminbarvisible = (is_admin_bar_showing()) ? "wp_bar_visible" : "";

        $display = $settings['display'];

        $display_float = isset($display['woocommerce']['wc_floating']) ? $display['woocommerce']['wc_floating'] : '';
        $enable_float = ( $display_float ) ? true : false;

        $button_align = isset($display['woocommerce']['align']) ? $display['woocommerce']['align'] : '';

        $changed_content = "";
        if (empty($display)) {
            $changed_content = "";
        } else {
            $post_id = get_the_ID();
            $exclude_post_id = array();
            if (isset($settings['display']['woocommerce']['exclude'])) {
                $exclude_post_id = explode(',', $settings['display']['woocommerce']['exclude']);
                if (in_array($post_id, $exclude_post_id)) {
                    return '';
                }
            }

            if (isset($display['woocommerce']['after_product']) && $display['woocommerce']['after_product'] && array_key_exists('woocommerce', $display)) {

                $enable_float = ( $display_float ) ? "ars_sticky_bottom_belt" : "";
                $changed_content .= "<div class='arsocialshare_network_fan_button_settings arsocialshare_align_{$button_align} {$isadminbarvisible} {$enable_float} arsocialfan_button_after_product' id='arsocialfan_button_after_product'>";
                $shortcode_content = "[ARSocial_Lite_Fan id=ars_fan_global_settings position=after_product]";
                $changed_content .= do_shortcode($shortcode_content);
                $changed_content .= "</div>";
            } else {
                $changed_content = "";
            }
        }

        echo $changed_content;
    }

    function ars_fan_set_fan_counter($counter, $format, $manual_value) {
        $counter = isset($counter) ? $counter : 0;
        $counter = $this->change_current_formated_counter_to_value($counter);
        $format = isset($format) ? $format : 'style1';
        $manual_value = isset($manual_value) ? $manual_value : 0;
        $manual_value = $this->change_current_formated_counter_to_value($manual_value);

        if ($manual_value > $counter) {
            $counter = $manual_value;
        }

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

    function ars_count_letter_conversion($counter) {
        $decPlace = pow(10, 1);

        $abbr = array('k', 'm', 'b', 't');

        for ($i = (count($abbr) - 1); $i >= 0; $i--) {

            $size = pow(10, (($i + 1) * 3));

            if ($size <= $counter) {

                $counter = (round(($counter * $decPlace) / $size)) / $decPlace;
                if (($counter == 1000) && ($i < (count($abbr) - 1))) {
                    $counter = 1;
                    $i++;
                }


                $counter = $counter . $abbr[$i];
                break;
            }
        }

        return $counter;
    }

    function change_current_formated_counter_to_value($counter) {

        if (strpos(strtolower($counter), 'k')) {
            $counter = (intval($counter) * 1000);
        }

        if (strpos(strtolower($counter), 'm')) {

            $counter = (intval($counter) * 1000000);
        }

        return $counter;
    }

    function arsocial_lite_save_fan_order() {
        $network_position = isset($_POST['arsocialshare_fan_network']) ? $_POST['arsocialshare_fan_network'] : '';

        if (is_array($network_position) && !empty($network_position)) {
            $positions = maybe_serialize($network_position);
            update_option('arslite_global_fancounter_order', $positions);
        }
        die();
    }

    function arsocialshare_get_fan_html($sorted_networks = array(), $saved_fan_networks_global = array(), $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $more_buttons = array(), $display_from = 'post', $no_format = 'style1') {
        $fanHtml = "<ul>";
        $total_networks = count($sorted_networks);
        $n = 1;
        $include_in_more = array();
        $post_type = get_post_type($page_id);

        $display_settings = isset($saved_fan_networks_global['display'][$post_type]) ? $saved_fan_networks_global['display'][$post_type] : @$saved_fan_networks_global['display'][$display_from];

        if ($shortcode_id > 0) {
            $display_settings = isset($saved_fan_networks_global) ? $saved_fan_networks_global : array();
        }

        foreach ($sorted_networks as $key => $value) {
            $is_active = $this->arsfan_active_networks($value, $saved_fan_networks_global[$value]);
            if (!$is_active) {
                continue;
            }
            $fanHtml .= $this->arsocialshare_fan_html($value, $saved_fan_networks_global[$value], $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, false, '', $display_settings);
            array_push($include_in_more, $value);
            if (!empty($more_buttons) && $more_buttons['more_btn'] !== '' && $more_buttons['more_btn'] > 0) {
                if ($n == $more_buttons['more_btn'] && $total_networks > $more_buttons['more_btn']) {

                    $morebtncls = ($more_buttons['more_btn_style'] === 'plus_icon') ? "socialshare-plus" : "socialshare-dot-3";
                    $random_no = rand(1000, 9999);


                    if ($more_buttons['more_btn_action'] === 'display_inline') {
                        foreach ($sorted_networks as $key => $value) {
                            $is_active = $this->arsfan_active_networks($value, $saved_fan_networks_global[$value]);
                            if (!$is_active) {
                                continue;
                            }
                            if (!in_array($value, $include_in_more)) {

                                $shorturl = get_permalink();

                                $fanHtml .= $this->arsocialshare_fan_html($value, $saved_fan_networks_global[$value], $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, true, $random_no, $display_settings);
                            }
                        }
                    }
                    $fanHtml .= "<li class='ars_fan_network-morebtn' style='vertical-align:top;'><a class='arsocial_lite_more_button_icon' id='ars_lite_fan_more_button_icon' data-action='{$more_buttons['more_btn_action']}' data-counter-format='{$no_format}' data-skin='{$fan_display_class}' data-display-from='{$display_from}' data-page-id='{$page_id}' data-network-id='{$shortcode_id}' data-exclude='" . json_encode($include_in_more) . "' data-on={$random_no} data-all-networks='" . json_encode($sorted_networks) . "'  style='cursor:pointer;'><div class='ars_fan_network more_icon'><i class='ars_fan_network_icon $morebtncls'></i></div></a><input type='hidden' id='arsocialshare_admin_ajaxurl' value='" . admin_url('admin-ajax.php') . "' /></li>";
                    break;
                }
            }
            $n++;
        }
        $fanHtml .= "</ul>";
        return $fanHtml;
    }

    function arsocialshare_fan_html($networks = '', $options = array(), $shortcode_id, $page_id, $fan_display_class, $counter_data, $network_default_settings, $is_hidden = false, $random_no = '', $display_settings = array()) {
        $html = '';
        if (empty($options) || $networks === '') {
            return $html;
        }

        $isDisplay = false;
        $html = '';
        $link_attr = '';
        $like_btn_html = '';

        switch ($networks) {
            case 'facebook':
                if (isset($options['active_fb_fan']) && $options['active_fb_fan'] == 1) {
                    $isDisplay = true;
                    $link_attr = 'data-network="facebook" data-page-id="' . $page_id . '" data-network-id="' . $shortcode_id . '" target="_blank" href="' . $network_default_settings['facebook']['network_url'] . $options['fb_fan_url'] . '"';
                }
                break;
            case 'twitter':
                if (isset($options['active_twitter_fan']) && $options['active_twitter_fan'] == 1) {
                    $isDisplay = true;
                    $link_attr = 'data-network="twitter" data-page-id="' . $page_id . '" data-network-id="' . $shortcode_id . '" target="_blank" href="' . $network_default_settings['twitter']['network_url'] . $options['twitter_fan_username'] . '"';
                }
                break;
            case 'linkedin':
                if (isset($options['active_linkedin_fan']) && $options['active_linkedin_fan'] == 1) {
                    $isDisplay = true;
                    $link_attr = ' data-network="linkedin" data-page-id="' . $page_id . '" data-network-id="' . $shortcode_id . '" target="_blank" href="' . $options['linkedin_fan_url'] . '" ';
                }
                break;
            default:
                $html .= '';
                break;
        }
        if ($isDisplay) {
            $fan_text = $options['fan_text'];
            $network_count = $counter_data[$networks];
            $hidden_cls = "";
            $data_on = "";
            if ($is_hidden) {
                $hidden_cls = " ars_fan_hidden_buttons ";
                $data_on = " data-on='$random_no' ";
            }

            if (isset($options['enable_like_btn']) && $options['enable_like_btn']) {
                $position = isset($display_settings['like_follow_btn_position']) ? $display_settings['like_follow_btn_position'] : 'top';

                if ($shortcode_id > 0) {
                    $position = isset($display_settings['ars_fan_like_follow_btn_position']) ? $display_settings['ars_fan_like_follow_btn_position'] : 'top';
                }

                $like_btn_html .= "<div class='ars_fan_like_wrapper ars_{$position}' data-ng-module='arsociallitefanlike'>";
                if ($networks === 'facebook') {
                    $like_btn_html .= "<div class='ars_fan_like_inner_wrapper' data-ng-controller='arsociallitefanlikefb'></div>";
                    //$network_default_settings['facebook']['network_url'] . $options['fb_fan_url']
                    $like_btn_html .= "<div data-fb-like-button>";
                    $like_btn_html .= "<div id='fb-root'></div><div class='fb-like' data-href='" . $network_default_settings['facebook']['network_url'] . $options['fb_fan_url'] . "' data-layout='button' data-action='like' data-show-faces='false' data-share='false'></div>";
                    $like_btn_html .= "</div>";
                }
                if ($networks === 'twitter') {
                    $like_btn_html .= "<div class='ars_fan_like_inner_wrapper' data-ng-controller='arsociallitefanliketwitter'>";
                    $like_btn_html .= "<div style='position:relative;top:7px;' data-twitter-like-button>";

                    $like_btn_html .= "<a href='https://twitter.com/" . $options['twitter_fan_username'] . "' class='twitter-follow-button' data-show-screen-name='false' data-show-count='false'></a> ";
                    $like_btn_html .= "</div></div>";
                }
                if ($networks === 'linkedin') {
                    $company_id = $options['company_id'];
                    $like_btn_html .= "<div data-linkedin-fan-button>";
                    $like_btn_html .= "<script src='//platform.linkedin.com/in.js' type='text/javascript'>lang: en_US</script><script type='IN/FollowCompany' data-id='{$company_id}'></script>";
                    $like_btn_html .= "</div>";
                }
                if ($networks === 'pinterest') {
                    $like_btn_html .= "<div style='position:relative;top:2px;' arsocial-fan-pinterestfollow>";
                    $like_btn_html .= "<div data-ng-controller='arsociallitefanpinterestfollow'></div>";
                    $like_btn_html .= "<a data-pin-do='buttonFollow' href='" . $network_default_settings['pinterest']['network_url'] . $options['pinterest_fan_username'] . "'>" . $options['pinterest_fan_username'] . "</a>";
                    $like_btn_html .= "</div>";
                }
                if ($networks === 'instagram') {
                    $like_btn_html .= "<div instagram-like-button>";
                    $like_btn_html .= "<div data-ng-controller='arsociallitelikeinstagram' ></div>";
                    $like_btn_html .='<a style="cursor:pointer;left:2px;position:relative;top:7px;width:80px;" class="ars_instagram_follow" onclick=window.open("https://www.instagram.com/' . $options['instagram_fan_username'] . '/?ref=badge","_blank","width=500,height=500") class="ig-b- ig-b-24"><img src="' . ARSOCIAL_LITE_IMAGES_URL . '/instagram_follow_button.png"></a>';
                    $like_btn_html .= "</div>";
                }
                if ($networks === 'youtube') {
                    $like_btn_html .= '<div style="padding-left:8px;" youtube-like-button>';
                    $like_btn_html .= '<div data-ng-controller="arsociallitelikeyoutube"></div>';
                    $like_btn_html .= '<div class="g-ytsubscribe"';
                    $like_btn_html .= 'data-channelid="' . $options['youtube_fan_username'] . '"';
                    $like_btn_html .= 'data-layout="default" data-theme="default" data-count="hidden" ';
                    $like_btn_html .= '></div>';
                    $like_btn_html .= '</div>';
                }
                
                $like_btn_html .= "</div>";
            }

            if ($networks === 'facebook' && $options['account_type'] !== 'page') {
                $like_btn_html = '';
            }
            if ($networks === 'youtube' && $options['account_type'] !== 'channel') {
                $like_btn_html = '';
            }

            $html .="<li class='ars_fan_network-{$networks} {$hidden_cls} $fan_display_class' $data_on>";
            $html .= $like_btn_html;
            $html .= "<a class='ars_fan_network_link' {$link_attr}>";
            $html .= "<div id='arsocial_lite_fan_{$networks}_wraper' class='ars_fan_network arsocial_lite_fan_{$networks}_wraper'>";
            $html .= "<i class='ars_fan_network_icon arsocial_lite_fan_{$networks}_icon socialshare-{$networks} {$networks}'></i>";

            $html .= "<span id='arsocial_lite_fan_{$networks}_value' class='ars_fan_value arsocial_lite_fan_{$networks}_value'>{$network_count}</span>";
            $html .="<span id='arsocial_lite_fan_{$networks}_label' class='ars_fan_label arsocial_lite_fan_{$networks}_label'>{$fan_text}</span>";
            $html .= "</div>";
            $html .= "</a>";
            $html .="</li>";
        }
        return $html;
    }

    function arsfan_active_networks($network, $network_option) {
        $is_active = false;
        switch ($network) {
            case 'facebook':
                $is_active = ($network_option['active_fb_fan'] == 1 ) ? true : false;
                break;
            case 'twitter':
                $is_active = ($network_option['active_twitter_fan'] == 1 ) ? true : false;
                break;
            case 'linkedin':
                $is_active = ($network_option['active_linkedin_fan'] == 1 ) ? true : false;
                break;
            default:
                $is_active = false;
                break;
        }
        return $is_active;
    }

    function ars_fan_get_networks() {
        global $wpdb, $arsocial_lite;
        $network_id = isset($_POST['network_id']) ? $_POST['network_id'] : '-100';
        $skin = isset($_POST['skin']) ? $_POST['skin'] : 'ars_fan_metro';
        $from = isset($_POST['post_type']) ? $_POST['post_type'] : 'post';
        $page_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $display_format = isset($_POST['display_format']) ? $_POST['display_format'] : 'style1';
        $html = '';
        $network_default_settings = $arsocial_lite->ARSocialShareFancounterNetworks();
        if ($network_id === '-100') {
            $global_settings = maybe_unserialize(get_option('arslite_fan_display_settings'));
            if ('' !== get_option('arslite_fan_counter_data_global')) {
                $counter_data = maybe_unserialize(get_option('arslite_fan_counter_data_global'));
            }

            if (empty($counter_data)) {
                $counter_data = $this->ars_update_fan_counter_data('ars_fan_global_settings');
                $counter_data = maybe_unserialize($counter_data);
            }

            $counter_data['total_count'] = 0;

            foreach ($network_default_settings as $network => $network_data) {
                $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                $global_settings[$network]['manual_counter'] = isset($global_settings[$network]['manual_counter']) ? $global_settings[$network]['manual_counter'] : 0;

                $counter_data[$network] = $this->ars_fan_set_fan_counter($counter_data[$network], $display_format, $global_settings[$network]['manual_counter']);
                $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
            }

            $html .= "<div class='arsocial_lite_more_network_model' id='arsfan_more_network_model'>";
            $html .= "<div class='arsocialshare_more_networks_inner_wrapper'>";
            $html .= "<div class='arsocialshare_more_networks_top_belt'>";
            $html .= "<div class='arsocial_lite_model_close_btn' id='ars_fan_model'></div>";
            $html .= "</div>";
            $html .= "<div class='arsocialshare_model_share_button_wrapper' style='background:#ffffff'>";
            $html .= "<div class='ars_lite_fan_main_wrapper {$skin}'>";
            if (get_option('arslite_global_fancounter_order')) {
                $sorted_networks = maybe_unserialize(get_option('arslite_global_fancounter_order'));
                $more_btn_settings = array();
                if (is_array($sorted_networks) && !empty($sorted_networks)) {
                    $exclude = array('display_number_format', 'display', 'display_style');
                    $html .= $this->arsocialshare_get_fan_html($sorted_networks, $global_settings, $network_id, $page_id, $skin, $counter_data, $network_default_settings, $more_btn_settings, $from);
                }
            }
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
        } else {
            $fan_table = $wpdb->prefix . 'arsocial_lite_fan';

            $get_fan = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$fan_table` WHERE ID = %d", $network_id));
            $saved_fan_networks_global = maybe_unserialize($get_fan->content);

            $counter_data = maybe_unserialize($get_fan->counter_data);

            $display_style = $get_fan->display_type;

            $shortcode_id = $network_id;

            if (empty($counter_data)) {
                $counter_data = $this->ars_update_fan_counter_data($id);
                $counter_data = maybe_unserialize($counter_data);
            }

            $counter_data['total_count'] = 0;

            $display_number_format = isset($saved_fan_networks_global['display_number_format']) ? $saved_fan_networks_global['display_number_format'] : 'style1';
            foreach ($network_default_settings as $network => $network_data) {
                $counter_data[$network] = isset($counter_data[$network]) ? $counter_data[$network] : 0;
                $saved_fan_networks_global[$network]['manual_counter'] = isset($saved_fan_networks_global[$network]['manual_counter']) ? $saved_fan_networks_global[$network]['manual_counter'] : 0;

                $counter_data[$network] = $this->ars_fan_set_fan_counter($counter_data[$network], $display_number_format, $saved_fan_networks_global[$network]['manual_counter']);
                $counter_data['total_count'] = $counter_data['total_count'] + $counter_data[$network];
            }

            $html .= "<div class='arsocial_lite_more_network_model' id='arsfan_more_network_model'>";
            $html .= "<div class='arsocialshare_more_networks_inner_wrapper'>";

            $html .= "<div class='arsocialshare_more_networks_top_belt'>";
            $html .= "<div class='arsocial_lite_model_close_btn' id='ars_fan_model'></div>";
            $html .= "</div>";
            $html .= "<div class='arsocialshare_model_share_button_wrapper' style='background:#ffffff'>";
            $html .= "<div class='ars_lite_fan_main_wrapper {$skin}'>";

            if (!empty($saved_fan_networks_global['display']['fan_network_order'])) {
                $sorted_networks = $saved_fan_networks_global['display']['fan_network_order'];
                $more_btn_settings = array();
                if (is_array($sorted_networks) && !empty($sorted_networks)) {
                    $exclude = array('display_number_format', 'display', 'display_style');
                    $html .= $this->arsocialshare_get_fan_html($sorted_networks, $saved_fan_networks_global, $network_id, $page_id, $skin, $counter_data, $network_default_settings, $more_btn_settings, $from);
                }
            }
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
        }
        echo json_encode(array('content' => stripslashes($html)));
        die();
    }

}

?>