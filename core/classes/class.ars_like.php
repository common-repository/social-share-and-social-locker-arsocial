<?php

class ARSocial_Lite_LikeForm {

    function __construct() {

        add_shortcode('ARSocial_Lite_Like', array($this, 'arsocial_lite_like_shortcode'));

        add_action('wp_ajax_ars_lite_save_arsocial_like', array($this, 'ars_lite_save_arsocial_like'));

        add_action('wp_ajax_arsocial_lite_remove_like', array($this, 'arsocial_lite_remove_like'));

        /* Add button on page, post and custom post */
        add_filter('the_content', array($this, 'arsocial_lite_like_filtered_content'));

        /* Add button on post excerpt */
        add_filter('get_the_excerpt', array($this, 'arsocial_lite_like_filtered_excerpt'));

        /* Add  button after price in woocommerce */
        add_filter('woocommerce_get_price_html', array($this, 'arsocial_lite_like_woocommerce_price_filter'));

        /* Display Button Before woocommerce Product */
        add_action('woocommerce_before_single_product', array($this, 'arsocial_lite_like_woocommerce_before_single_product'));

        /* Display Button After woocommerce Product  */
        add_action('woocommerce_after_single_product', array($this, 'arsocial_lite_like_woocommerce_after_single_product'));

        add_action('wp_ajax_arsocial_lite_save_like_order', array($this, 'arsocial_lite_save_like_order'));
    }

    function arsocial_lite_like_shortcode($atts) {

        global $arsocial_lite;

        $networks = isset($atts['id']) ? $atts['id'] : '';

        if ('' === $networks) {
            return esc_html__('No any shortcode selected.', 'arsocial_lite');
        }
        $type = isset($atts['type']) ? $atts['type'] : 'normal';


        $arsocial_lite->ars_common_enqueue_js_css();
        wp_enqueue_script('ars-lite-like-front-js');
        $shortcodeContent = '';
        $shortcodeContent .= $arsocial_lite->ars_get_enqueue_fonts('like');

        switch ($type) {
            case 'normal':
                $shortcodeContent .= $this->arsocialshare_like_normal_buttons($networks);
                break;
            default:
                $shortcodeContent .= $this->arsocialshare_like_normal_buttons($networks);
                break;
        }
        return $shortcodeContent;
    }

    function arsocialshare_like_normal_buttons($id) {
        global $arsocial_lite_like;
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_front_like.php')) {
            include ARSOCIAL_LITE_VIEWS_DIR . '/ars_front_like.php';
            $response = arsocial_lite_like_view($id);
            $response = json_decode($response);
            $html = $response->body;
        } else {
            $content = esc_html__('Network is Invalid. Please select valid Network', 'arsocial_lite');
        }

        $inbuild = "";

        return $html;
        die();
    }

    function get_permalink() {
        return get_permalink();
    }

    function get_page_title() {
        return get_the_title();
    }

    function ars_lite_save_arsocial_like() {
        global $wpdb, $arsocial_lite_like, $arsocial_lite;
        $values = json_decode(stripslashes_deep($_POST['filtered_data']), true);

        $response = array();
        $like_options = array();

        $selected_network = array();
        $network_order = isset($values['arsocialshare_like_network']) ? $values['arsocialshare_like_network'] : '';

        $active_fb_like = isset($values['active_fb_like']) ? $values['active_fb_like'] : false;
        if ($active_fb_like == 1) {
            array_push($selected_network, 'facebook');
        }
        $arsocialshare_fb_like_url = isset($values['arsocialshare_fb_like_url']) ? $values['arsocialshare_fb_like_url'] : '';
        $fb_button_width = isset($values['arsocialshare_fb_like_button_width']) ? $values['arsocialshare_fb_like_button_width'] : '';
        $fb_button_layout = isset($values['arsocialshare_fb_like_button_layout']) ? $values['arsocialshare_fb_like_button_layout'] : '';
        $fb_button_action_type = isset($values['arsocialshare_fb_like_button_action_type']) ? $values['arsocialshare_fb_like_button_action_type'] : '';
        $fb_button_show_friend_face = isset($values['arsocialshare_fb_like_button_show_friend_face']) ? $values['arsocialshare_fb_like_button_show_friend_face'] : '';
        $fb_button_colorscheme = isset($values['arsocialshare_fb_like_button_colorscheme']) ? $values['arsocialshare_fb_like_button_colorscheme'] : '';
        $fb_button_language = isset($values['arsocialshare_fb_like_button_language']) ? $values['arsocialshare_fb_like_button_language'] : '';

        $like_options['facebook']['is_fb_like'] = $active_fb_like;
        $like_options['facebook']['fb_like_url'] = $arsocialshare_fb_like_url;
        $like_options['facebook']['fb_button_width'] = $fb_button_width;
        $like_options['facebook']['fb_button_layout'] = $fb_button_layout;
        $like_options['facebook']['fb_button_action_type'] = $fb_button_action_type;
        $like_options['facebook']['fb_button_show_friend_face'] = $fb_button_show_friend_face;
        $like_options['facebook']['facebook_like_button_colorscheme'] = $fb_button_colorscheme;
        $like_options['facebook']['facebook_like_button_language'] = $fb_button_language;

        $active_twitter_like = isset($values['active_twitter_like']) ? $values['active_twitter_like'] : '';
        if ($active_twitter_like == 1) {
            array_push($selected_network, 'twitter');
        }
        $twitter_like_url = isset($values['arsocialshare_twitter_like_url']) ? $values['arsocialshare_twitter_like_url'] : '';
        $twitter_like_show_username = isset($values['arsocialshare_twitter_show_username']) ? $values['arsocialshare_twitter_show_username'] : '';
        $twitter_like_large_button = isset($values['arsocialshare_twitter_large_button']) ? $values['arsocialshare_twitter_large_button'] : '';
        $twitter_like_opt_out_tailoring = isset($values['arsocialshare_twitter_opt_out_tailoring']) ? $values['arsocialshare_twitter_opt_out_tailoring'] : '';
        $twitter_language = isset($values['arsocialshare_twitter_like_button_language']) ? $values['arsocialshare_twitter_like_button_language'] : '';

        $like_options['twitter']['is_twitter_like'] = $active_twitter_like;
        $like_options['twitter']['twitter_like_url'] = $twitter_like_url;
        $like_options['twitter']['twitter_show_username'] = $twitter_like_show_username;
        $like_options['twitter']['twitter_large_button'] = $twitter_like_large_button;
        $like_options['twitter']['twitter_opt_out_tailoring'] = $twitter_like_opt_out_tailoring;
        $like_options['twitter']['twitter_button_language'] = $twitter_language;

        $active_fb_follow_like = isset($values['like_fb_follow_active']) ? $values['like_fb_follow_active'] : '';
        if ($active_fb_follow_like == 1) {
            array_push($selected_network, 'facebook');
        }
        $arsocialshare_fb_follow_like_url = isset($values['arsocialshare_fb_follow_like_url']) ? $values['arsocialshare_fb_follow_like_url'] : '';
        $fb_follow_button_width = isset($values['arsocialshare_fb_follow_like_button_width']) ? $values['arsocialshare_fb_follow_like_button_width'] : '';
        $fb_follow_button_height = isset($values['arsocialshare_fb_follow_like_button_height']) ? $values['arsocialshare_fb_follow_like_button_height'] : '';
        $fb_follow_button_layout = isset($values['arsocialshare_fb_follow_like_button_layout']) ? $values['arsocialshare_fb_follow_like_button_layout'] : '';
        $fb_follow_button_show_friend_face = isset($values['arsocialshare_fb_follow_button_show_friend_face']) ? $values['arsocialshare_fb_follow_button_show_friend_face'] : '';
        $fb_follow_follow_button_colorscheme = isset($values['arsocialshare_fb_follow_like_button_colorscheme']) ? $values['arsocialshare_fb_follow_like_button_colorscheme'] : '';
        $fb_follow_follow_button_language = isset($values['arsocialshare_fb_follow_button_language']) ? $values['arsocialshare_fb_follow_button_language'] : '';

        $like_action = isset($values['arsocial_like_action']) ? $values['arsocial_like_action'] : '';
        $display_option = array();

        if ($like_action != 'ars_like_global_display_settings') {

            $display_option['selected_network'] = $selected_network;
            $display_option['network_order'] = $network_order;

            $enable_like_on = (isset($values['arsocialshare_like_enable_on']) && $values['arsocialshare_like_enable_on'] !== '') ? $values['arsocialshare_like_enable_on'] : 'page';

            $display_option['display_type'] = $enable_like_on;
            $display_option['skin'] = (isset($values['ars_like_skins']) && $values['ars_like_skins'] !== '') ? $values['ars_like_skins'] : '';
            $display_option['load_native_btn'] = (isset($values['ars_load_native_btn']) && $values['ars_load_native_btn'] !== '') ? $values['ars_load_native_btn'] : '';
            $display_option['btn_width'] = (isset($values['ars_btn_width']) && $values['ars_btn_width'] !== '') ? $values['ars_btn_width'] : '';
            $display_option['align'] = (isset($values['ars_pages_align']) && $values['ars_pages_align'] !== '') ? $values['ars_pages_align'] : '';

            if ($enable_like_on == 'page') {
                $display_option['page'] = 'page';
            }

            if ($enable_like_on == 'sidebar') {
                $like_sidebar = (isset($values['arsocialshare_sidebar']) && $values['arsocialshare_sidebar'] !== '' ) ? $values['arsocialshare_sidebar'] : '';
                $display_option['sidebar']['position'] = $like_sidebar;
            }


            if ($enable_like_on == 'top_bottom_bar') {
                $display_option['top_bottom_bar']['display_bar'] = isset($values['arsocialshare_top_bottom_bar_display_on']) ? $values['arsocialshare_top_bottom_bar_display_on'] : "";
                $display_option['top_bottom_bar']['onload_time'] = isset($values['arsocialshare_top_bottom_bar_onload_time']) ? $values['arsocialshare_top_bottom_bar_onload_time'] : "";
                $display_option['top_bottom_bar']['onscroll_percentage'] = isset($values['arsocialshare_top_bottom_bar_onscroll_percentage']) ? $values['arsocialshare_top_bottom_bar_onscroll_percentage'] : "";
                $display_option['top_bottom_bar']['position'] = isset($values['arsocialshare_top_bar']) ? $values['arsocialshare_top_bar'] : "";
                $display_option['top_bottom_bar']['y_point'] = isset($values['arsocialshare_top_bottom_bar_y_position']) ? $values['arsocialshare_top_bottom_bar_y_position'] : '';
            }


            if ($enable_like_on == 'popup') {
                $display_option['popup']['display_popup'] = (isset($values['arsocialshare_popup_display_on'])) ? $values['arsocialshare_popup_display_on'] : '';
                $display_option['popup']['is_close_button'] = (isset($values['arsocialshare_pop_show_close_button'])) ? $values['arsocialshare_pop_show_close_button'] : "";
                $display_option['popup']['onload_time'] = isset($values['arsocialshare_popup_onload_time']) ? $values['arsocialshare_popup_onload_time'] : '';
                $display_option['popup']['onscroll_percentage'] = isset($values['arsocialshare_popup_onscroll_percentage']) ? $values['arsocialshare_popup_onscroll_percentage'] : '';
                $display_option['popup']['popup_width'] = isset($values['arsocialshare_popup_width']) ? $values['arsocialshare_popup_width'] : '';
                $display_option['popup']['popup_height'] = isset($values['arsocialshare_popup_height']) ? $values['arsocialshare_popup_height'] : '';
            }
        }


        $display_type = '';

        $like_id = isset($values['like_id']) ? $values['like_id'] : '';
        $created_date = $updated_date = current_time('mysql');
        $response = array();
        $response['message'] = 'success';
        $like_options['display'] = $display_option;
        $options = maybe_serialize($like_options);
        $table = $wpdb->prefix . 'arsocial_lite_like';
        if ($like_action === 'new-like' || $like_action === 'duplicate') {

            $insert = $wpdb->prepare("INSERT INTO `$table` (content,display_type,created_date,updated_date) VALUES (%s,%s,%s,%s)", $options, $display_type, $created_date, $updated_date);
            if ($wpdb->query($insert)) {
                $response['message'] = 'success';
                $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
                $response['id'] = $wpdb->insert_id;
                $response['action'] = 'new_like';
            } else {
                
            }
        } else if ($like_action === 'edit-like') {
            $update = $wpdb->prepare("UPDATE `$table` SET content = %s, display_type = %s, updated_date = %s WHERE ID = %d", $options, $display_type, $updated_date, $like_id);

            if ($wpdb->query($update)) {
                $response['message'] = 'success';
                $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
                $response['id'] = $like_id;
                $response['action'] = 'edit_like';
            } else {
                
            }
        } else if ($like_action === 'ars_like_global_display_settings') {

            /* for all post pages,special pages and cpt */
            $display_option = array();

            $display_option['selected_network'] = $selected_network;
            $network_order = (isset($values['arsocialshare_like_network']) && $values['arsocialshare_like_network'] !== '') ? $values['arsocialshare_like_network'] : '';
            update_option('arslite_global_like_order', $network_order);
            $enable_pages = (isset($values['arsocialshare_enable_pages']) && $values['arsocialshare_enable_pages'] !== '') ? $values['arsocialshare_enable_pages'] : '';
            if (!empty($enable_pages)) {

                $display_option['page']['enable'] = 'true';
                $display_option['page']['skin'] = (isset($values['arsocial_lite_like_page_skins']) && $values['arsocial_lite_like_page_skins'] !== '' ) ? $values['arsocial_lite_like_page_skins'] : '';

                $display_option['page']['top'] = (isset($values['arsocialshare_page_top']) && $values['arsocialshare_page_top'] !== '' ) ? $values['arsocialshare_page_top'] : '';
                $display_option['page']['bottom'] = (isset($values['arsocialshare_page_bottom']) && $values['arsocialshare_page_bottom'] !== '' ) ? $values['arsocialshare_page_bottom'] : '';
                $display_option['page']['floating'] = (isset($values['arsocialfan_page_enable_floating']) && $values['arsocialfan_page_enable_floating'] !== '' ) ? $values['arsocialfan_page_enable_floating'] : '';
                $display_option['page']['align'] = (isset($values['ars_pages_align']) && $values['ars_pages_align'] !== '' ) ? $values['ars_pages_align'] : '';

                $display_option['page']['load_native_btn'] = (isset($values['ars_page_load_native_btn']) && $values['ars_page_load_native_btn'] !== '' ) ? $values['ars_page_load_native_btn'] : '';
                $display_option['page']['btn_width'] = (isset($values['ars_pages_btn_width']) && $values['ars_pages_btn_width'] !== '' ) ? $values['ars_pages_btn_width'] : '';
                $display_option['page']['exclude'] = (isset($values['ars_page_excludes']) && $values['ars_page_excludes'] !== '' ) ? $values['ars_page_excludes'] : '';

                $display_option['page']['archive_pages'] = (isset($values['ars_page_spacial_archive']) && $values['ars_page_spacial_archive'] !== '' ) ? $values['ars_page_spacial_archive'] : '';
                $display_option['page']['search_result'] = (isset($values['ars_page_spacial_search']) && $values['ars_page_spacial_search'] !== '' ) ? $values['ars_page_spacial_search'] : '';
                $display_option['page']['category_pages'] = (isset($values['ars_page_spacial_category']) && $values['ars_page_spacial_category'] !== '' ) ? $values['ars_page_spacial_category'] : '';
                $display_option['page']['author_pages'] = (isset($values['ars_page_spacial_author']) && $values['ars_page_spacial_author'] !== '' ) ? $values['ars_page_spacial_author'] : '';
                $display_option['page']['attachment_pages'] = (isset($values['ars_page_spacial_attachment']) && $values['ars_page_spacial_attachment'] !== '' ) ? $values['ars_page_spacial_attachment'] : '';
            }

            $enable_posts = (isset($values['arsocialshare_enable_posts']) && $values['arsocialshare_enable_posts'] !== '') ? $values['arsocialshare_enable_posts'] : '';
            if (!empty($enable_posts)) {
                $display_option['post']['enable'] = 'true';
                $display_option['post']['skin'] = (isset($values['ars_post_skin']) && $values['ars_post_skin'] !== '' ) ? $values['ars_post_skin'] : '';

                $display_option['post']['top'] = (isset($values['ars_post_top']) && $values['ars_post_top'] !== '' ) ? $values['ars_post_top'] : '';
                $display_option['post']['bottom'] = (isset($values['ars_post_bottom']) && $values['ars_post_bottom'] !== '' ) ? $values['ars_post_bottom'] : '';
                $display_option['post']['floating'] = (isset($values['arsocialshare_posts_enable_floating']) && $values['arsocialshare_posts_enable_floating'] !== '' ) ? $values['arsocialshare_posts_enable_floating'] : '';
                $display_option['post']['align'] = (isset($values['ars_posts_align']) && $values['ars_posts_align'] !== '' ) ? $values['ars_posts_align'] : '';

                $display_option['post']['load_native_btn'] = (isset($values['ars_post_load_native_btn']) && $values['ars_post_load_native_btn'] !== '' ) ? $values['ars_post_load_native_btn'] : '';
                $display_option['post']['btn_width'] = (isset($values['ars_posts_btn_width']) && $values['ars_posts_btn_width'] !== '' ) ? $values['ars_posts_btn_width'] : '';
                $display_option['post']['post_excerpt'] = (isset($values['arsocialshare_enable_post_excerpt']) && $values['arsocialshare_enable_post_excerpt'] !== '' ) ? $values['arsocialshare_enable_post_excerpt'] : '';
                $display_option['post']['exclude_pages'] = (isset($values['arsocialshare_post_excludes']) && $values['arsocialshare_post_excludes'] !== '' ) ? $values['arsocialshare_post_excludes'] : '';
            }

            /* for woo commerce */
            if (isset($values['ars_is_woocommerce']) && $values['ars_is_woocommerce'] == 'yes') {
                $display_option['woocommerce']['enable'] = $values['ars_is_woocommerce'];
                $display_option['woocommerce']['skin'] = isset($values['arsocial_lite_like_woocommerce_skins']) ? $values['arsocial_lite_like_woocommerce_skins'] : '';
                $display_option['woocommerce']['after_price'] = isset($values['arsocialshare_woocommerce_after_price']) ? $values['arsocialshare_woocommerce_after_price'] : '';
                $display_option['woocommerce']['before_product'] = isset($values['arsocialshare_woocommerce_before_product']) ? $values['arsocialshare_woocommerce_before_product'] : '';
                $display_option['woocommerce']['after_product'] = isset($values['arsocialshare_woocommerce_after_product']) ? $values['arsocialshare_woocommerce_after_product'] : '';
                $display_option['woocommerce']['btn_align'] = isset($values['ars_woocommerce_btn_align']) ? $values['ars_woocommerce_btn_align'] : '';
                $display_option['woocommerce']['load_native_btn'] = isset($values['ars_woocommerce_load_native_btn']) ? $values['ars_woocommerce_load_native_btn'] : '';
                $display_option['woocommerce']['btn_width'] = isset($values['ars_woocommerce_btn_width']) ? $values['ars_woocommerce_btn_width'] : '';
                $display_option['woocommerce']['exclude_pages'] = isset($values['arsocialshare_woocommerce_excludes']) ? $values['arsocialshare_woocommerce_excludes'] : '';
            }

            $enable_sidebar = (isset($values['ars_enable_sidebar']) && $values['ars_enable_sidebar'] !== '') ? $values['ars_enable_sidebar'] : '';
            if (!empty($enable_sidebar)) {
                $display_option['sidebar']['enable'] = 'true';
                $display_option['sidebar']['skin'] = (isset($values['ars_lite_sidebar_skin']) && $values['ars_lite_sidebar_skin'] !== '' ) ? $values['ars_lite_sidebar_skin'] : '';
                $display_option['sidebar']['position'] = (isset($values['ars_lite_sidebar_position']) && $values['ars_lite_sidebar_position'] !== '' ) ? $values['ars_lite_sidebar_position'] : '';
                $display_option['sidebar']['load_native_btn'] = (isset($values['ars_lite_sidebar_load_native_btn']) && $values['ars_lite_sidebar_load_native_btn'] !== '' ) ? $values['ars_lite_sidebar_load_native_btn'] : '';
                $display_option['sidebar']['btn_width'] = (isset($values['ars_lite_sidebar_btn_width']) && $values['ars_lite_sidebar_btn_width'] !== '' ) ? $values['ars_lite_sidebar_btn_width'] : '';
                $display_option['sidebar']['exclude_pages'] = (isset($values['arsocialshare_page_excludes_sidebar']) && $values['arsocialshare_page_excludes_sidebar'] !== '' ) ? $values['arsocialshare_page_excludes_sidebar'] : '';
            }

            $enable_top_bottom_bar = (isset($values['arsocialshare_enable_top_bottom_bar']) && $values['arsocialshare_enable_top_bottom_bar'] !== '') ? $values['arsocialshare_enable_top_bottom_bar'] : '';
            if (!empty($enable_top_bottom_bar)) {
                $display_option['top_bottom_bar']['enable'] = 'true';
                $display_option['top_bottom_bar']['skin'] = (isset($values['ars_top_bottom_skins']) && $values['ars_top_bottom_skins'] !== '' ) ? $values['ars_top_bottom_skins'] : '';

                $display_option['top_bottom_bar']['top'] = (isset($values['arsocialshare_top_bar']) && $values['arsocialshare_top_bar'] !== '' ) ? $values['arsocialshare_top_bar'] : '';
                $display_option['top_bottom_bar']['bottom'] = (isset($values['arsocialshare_bottom_bar']) && $values['arsocialshare_bottom_bar'] !== '' ) ? $values['arsocialshare_bottom_bar'] : '';


                $display_option['top_bottom_bar']['display_bar'] = (isset($values['ars_top_bottom_display_bar']) && $values['ars_top_bottom_display_bar'] !== '' ) ? $values['ars_top_bottom_display_bar'] : '';

                $display_option['top_bottom_bar']['onload_time'] = (isset($values['ars_top_bottom_bar_onload_time']) && $values['ars_top_bottom_bar_onload_time'] !== '' ) ? $values['ars_top_bottom_bar_onload_time'] : '';
                $display_option['top_bottom_bar']['onscroll_percentage'] = (isset($values['ars_top_bottom_bar_onscroll_percentage']) && $values['ars_top_bottom_bar_onscroll_percentage'] !== '' ) ? $values['ars_top_bottom_bar_onscroll_percentage'] : '';
                $display_option['top_bottom_bar']['load_native_btn'] = (isset($values['ars_top_bottom_bar_load_native_btn']) && $values['ars_top_bottom_bar_load_native_btn'] !== '' ) ? $values['ars_top_bottom_bar_load_native_btn'] : '';
                $display_option['top_bottom_bar']['btn_width'] = (isset($values['ars_top_bottom_bar_btn_width']) && $values['ars_top_bottom_bar_btn_width'] !== '' ) ? $values['ars_top_bottom_bar_btn_width'] : '';
                $display_option['top_bottom_bar']['align'] = (isset($values['ars_top_bottom_bar_align']) && $values['ars_top_bottom_bar_align'] !== '' ) ? $values['ars_top_bottom_bar_align'] : '';
                $display_option['top_bottom_bar']['exclude_pages'] = (isset($values['arsocialshare_page_excludes_topbottom_bar']) && $values['arsocialshare_page_excludes_topbottom_bar'] !== '' ) ? $values['arsocialshare_page_excludes_topbottom_bar'] : '';
                $display_option['top_bottom_bar']['y_point'] = isset($values['arslike_bar_y_position']) ? $values['arslike_bar_y_position'] : '';
            }


            $enable_popup = (isset($values['arsocialshare_enable_popup']) && $values['arsocialshare_enable_popup'] !== '') ? $values['arsocialshare_enable_popup'] : '';
            if (!empty($enable_popup)) {

                $display_option['popup']['enable'] = 'true';
                $display_option['popup']['skin'] = (isset($values['ars_popup_skins']) && $values['ars_popup_skins'] !== '' ) ? $values['ars_popup_skins'] : '';
                $display_option['popup']['display_popup'] = (isset($values['ars_display_popup']) && $values['ars_display_popup'] !== '' ) ? $values['ars_display_popup'] : '';

                $display_option['popup']['onload_time'] = (isset($values['ars_popup_onload_time']) && $values['ars_popup_onload_time'] !== '' ) ? $values['ars_popup_onload_time'] : '';
                $display_option['popup']['onscroll_percentage'] = (isset($values['ars_popup_onscroll_percentage']) && $values['ars_popup_onscroll_percentage'] !== '' ) ? $values['ars_popup_onscroll_percentage'] : '';
                $display_option['popup']['load_native_btn'] = (isset($values['ars_popup_load_native_btn']) && $values['ars_popup_load_native_btn'] !== '' ) ? $values['ars_popup_load_native_btn'] : '';

                $display_option['popup']['btn_width'] = (isset($values['ars_popup_btn_width']) && $values['ars_popup_btn_width'] !== '' ) ? $values['ars_popup_btn_width'] : '';
                $display_option['popup']['is_close_button'] = (isset($values['ars_popup_close_button'])) ? $values['ars_popup_close_button'] : "";
                $display_option['popup']['popup_width'] = (isset($values['ars_popup_width']) && $values['ars_popup_width'] !== '' ) ? $values['ars_popup_width'] : '';
                $display_option['popup']['popup_height'] = (isset($values['ars_popup_height']) && $values['ars_popup_height'] !== '' ) ? $values['ars_popup_height'] : '';
                $display_option['popup']['exclude_pages'] = (isset($values['arsocialshare_page_excludes_popup']) && $values['arsocialshare_page_excludes_popup'] !== '' ) ? $values['arsocialshare_page_excludes_popup'] : '';
            }

            $enable_mobile = (isset($values['arsocialshare_enable_mobile'])) ? $values['arsocialshare_enable_mobile'] : '';

            if ($enable_mobile != '') {
                $display_option['mobile']['disply_type'] = isset($values['arsocialshare_display_mobile']) ? $values['arsocialshare_display_mobile'] : '';
                $display_option['mobile']['skin'] = isset($values['ars_mobile_skins']) ? $values['ars_mobile_skins'] : '';
                $display_option['mobile']['more_button_style'] = isset($values['arsocialshare_mobile_more_button_style']) ? $values['arsocialshare_mobile_more_button_style'] : '';
                $display_option['mobile']['bar_label'] = isset($values['arsocialshare_mobile_bottom_bar_label']) ? $values['arsocialshare_mobile_bottom_bar_label'] : '';
                $display_option['mobile']['button_position'] = isset($values['arsocialshare_mobile_more_button_position']) ? $values['arsocialshare_mobile_more_button_position'] : '';
            }

            $display_option['hide_mobile']['enable_mobile_hide_top'] = (isset($values['arsocialshare_mobile_hide_top'])) ? $values['arsocialshare_mobile_hide_top'] : '';
            $display_option['hide_mobile']['enable_mobile_hide_bottom'] = (isset($values['arsocialshare_mobile_hide_bottom'])) ? $values['arsocialshare_mobile_hide_bottom'] : '';
            $display_option['hide_mobile']['enable_mobile_hide_top_bottom_bar'] = (isset($values['enable_mobile_hide_top_bottom_bar'])) ? $values['enable_mobile_hide_top_bottom_bar'] : '';
            $display_option['hide_mobile']['enable_mobile_hide_onload'] = (isset($values['arsocialshare_mobile_hide_onload'])) ? $values['arsocialshare_mobile_hide_onload'] : '';


            $like_options['display'] = $display_option;

            $like_options = maybe_serialize($like_options);

            update_option('arslite_like_display_settings', $like_options);

            $response['message'] = 'success';
            $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
        }

        $response = apply_filters('arsocia_lite_like_save_msg_filter', $response);
        echo json_encode($response);
        die();
    }

    function arsocial_lite_remove_like() {
        $like_id = isset($_POST['like_id']) ? $_POST['like_id'] : '';

        $response = array();
        if ($like_id === '') {
            $response['result'] = "error";
            $response['code'] = "404";
            $response['message'] = esc_html__('Please Select valid setup id.', 'arsocial_lite');
        } else {
            global $wpdb,$arsocial_lite;
            $table = $arsocial_lite->arslite_like;
            $data = array('ID' => $like_id);
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

    /**
     * Function to add social like buttons on page content, post content, custom post content
     */
    function arsocial_lite_like_filtered_content($content) {
        if (is_admin() || !is_singular()) {
            return $content;
        }

        global $arsocial_lite;
        $settings = maybe_unserialize(get_option('arslite_like_display_settings'));
        $post_id = get_the_ID();
        $post_type = get_post_type();
        $changed_content = "";

        if ($post_id === '') {
            return $content;
        } else if (empty($settings)) {
            return $content;
        } else if (empty($settings['display'])) {
            return $content;
        }

        $display_setting = isset($settings['display']) ? $settings['display'] : array();

        $gs_settings = get_option('arslite_global_settings');
        $settings_global = maybe_unserialize($gs_settings);
        $settings_encode = json_encode($settings_global);

        $saved_like_networks_global = $settings;

        if (get_option('arslite_global_like_order')) {
            $sorted_fan_option = maybe_unserialize(get_option('arslite_global_like_order'));
            $new_sorted_fan_networks = array();
            if (!empty($sorted_fan_option) && is_array($sorted_fan_option)) {
                foreach ($sorted_fan_option as $key => $network) {
                    $new_sorted_fan_networks[$network] = @$saved_like_networks_global[$network];
                }
                $new_sorted_fan_networks['display'] = $saved_like_networks_global['display'];
            }
        }

        $css_js_enqued = FALSE;
        $hide_option = isset($display_setting['hide_mobile']) ? $display_setting['hide_mobile'] : array();
        $hide_top = isset($hide_option['enable_mobile_hide_top']) ? $hide_option['enable_mobile_hide_top'] : false;
        $hide_bottom = isset($hide_option['enable_mobile_hide_bottom']) ? $hide_option['enable_mobile_hide_bottom'] : false;
        $hide_floating = isset($hide_option['enable_mobile_hide_floating']) ? $hide_option['enable_mobile_hide_floating'] : false;
        $hide_sidebar = isset($hide_option['enable_mobile_hide_sidebar']) ? $hide_option['enable_mobile_hide_sidebar'] : false;
        $hide_flyin = isset($hide_option['enable_mobile_hide_flyin']) ? $hide_option['enable_mobile_hide_flyin'] : false;

        $hide_onload = isset($hide_option['enable_mobile_hide_onload']) ? $hide_option['enable_mobile_hide_onload'] : false;
        $hide_top_bottom_bar = isset($hide_option['enable_mobile_hide_top_bottom_bar']) ? $hide_option['enable_mobile_hide_top_bottom_bar'] : false;

        /* For Page */
        if (isset($settings['display']['page']['enable']) && $settings['display']['page']['enable'] == true && $post_type == 'page') {
            /* exclude pages */
            $exclude_post_id = array();
            $exclude_post_id = isset($settings['display']['page']['exclude']) ? $settings['display']['page']['exclude'] : array();
            $exclude_post_id = explode(',', $settings['display']['page']['exclude']);

            if (in_array($post_id, $exclude_post_id)) {
                $changed_content .= $content;
            } else {

                $arsocial_lite->ars_common_enqueue_js_css();
                wp_enqueue_script('ars-lite-like-front-js');
                $css_js_enqued = true;
                $page_option = isset($display_setting['page']) ? $display_setting['page'] : array();
                $display_top = isset($page_option['top']) ? $page_option['top'] : false;
                $display_bottom = isset($page_option['bottom']) ? $page_option['bottom'] : '';
                $display_float = isset($page_option['floating']) ? $page_option['floating'] : '';
                $button_align = isset($page_option['align']) ? $page_option['align'] : "center";
                $btn_width = isset($page_option['btn_width']) ? $page_option['btn_width'] : "small";
                $load_native_button = isset($page_option['load_native_btn']) ? $page_option['load_native_btn'] : "";
                $load_native_skin = isset($page_option['skin']) ? $page_option['skin'] : "skin3";
                $load_native_button = ($load_native_button == 'yes') ? true : false;
                $nativeClass = '';
                
                if ($load_native_button) {
                    $nativeClass = 'ars_like_' . $btn_width . ' ars_native_skin3';
                } else {
                    $nativeClass = 'ars_like_' . $btn_width;
                }
                if ($display_top) {

                    if ($hide_top && wp_is_mobile()) {

                    } else {

                        $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
                        $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_top_button  arsocial_lite_like_{$button_align}' id='arsocial_lite_like_top_button'>";

                        $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

                    $changed_content .= '</div>';
                    $changed_content .= '</div>';
               }
            }

                $changed_content .=$content;

                if ($display_bottom) {
                        if ($hide_bottom && wp_is_mobile()) {
                        //hide in mobile
                    } else {
                        $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
                        $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_bottom_button  arsocial_lite_like_{$button_align}' id='arsocial_lite_like_bottom_button '>";

                        $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

                        $changed_content .= '</div>';
                        $changed_content .= '</div>';
                    }

                }
            }
        }
        /* for page */

        /* for post */
        if (isset($settings['display']['post']['enable']) && $settings['display']['post']['enable'] == true && $post_type == 'post') {
            /* exclude pages */
            $exclude_post_id = array();
            $exclude_post_id = isset($settings['display']['post']['exclude_pages']) ? $settings['display']['post']['exclude_pages'] : array();
            $exclude_post_id = explode(',', $settings['display']['post']['exclude_pages']);
            if (in_array($post_id, $exclude_post_id)) {
                $changed_content .= $content;
            } else {
                if (!$css_js_enqued) {
                    $arsocial_lite->ars_common_enqueue_js_css();
                    wp_enqueue_script('ars-lite-like-front-js');
                    $css_js_enqued = true;
                }
                $post_option = isset($display_setting['post']) ? $display_setting['post'] : array();
                $display_top = isset($post_option['top']) ? $post_option['top'] : false;
                $display_bottom = isset($post_option['bottom']) ? $post_option['bottom'] : '';
                $display_float = isset($post_option['floating']) ? $post_option['floating'] : '';
                $button_align = isset($post_option['align']) ? $post_option['align'] : "center";
                $btn_width = isset($post_option['btn_width']) ? $post_option['btn_width'] : "small";
                $load_native_button = isset($post_option['load_native_btn']) ? $post_option['load_native_btn'] : "";
                $load_native_skin = isset($post_option['skin']) ? $post_option['skin'] : "skin3";
                $load_native_button = ($load_native_button == 'yes') ? true : false;
                $nativeClass = '';
                if ($load_native_button) {
                    $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
                } else {
                    $nativeClass = 'ars_like_' . $btn_width;
                }

                if ($display_top) {
                    if ($hide_top && wp_is_mobile()) {
                        //hide in mobile
                    } else {
                        $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
                        $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_top_button  arsocial_lite_like_{$button_align}' data-enable-floating='$display_float' id='arsocial_lite_like_top_button'>";

                        $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

                    $changed_content .= '</div>';
                    $changed_content .= '</div>';
                }
            }

                $changed_content .=$content;

                if ($display_bottom) {
                    if ($hide_bottom && wp_is_mobile()) {
                        //hide in mobile
                    } else {
//
                        $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
                        $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_bottom_button  arsocial_lite_like_{$button_align}' id='arsocial_lite_like_bottom_button '>";

                        $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

                        $changed_content .= '</div>';
                        $changed_content .= '</div>';
                    }

                }
            }
        }
        /* for post */

        /* for popup */
        if (isset($settings['display']['popup']['enable']) && $settings['display']['popup']['enable'] == true) {
            if ($hide_onload && wp_is_mobile()) {
                //hide in mobile
            } else {
                $exclude_post_id = array();
                $exclude_post_id = isset($settings['display']['popup']['exclude_pages']) ? $settings['display']['popup']['exclude_pages'] : array();
                $exclude_post_id = explode(',', $exclude_post_id);
                if (in_array($post_id, $exclude_post_id)) {
                    $changed_content .= '';
                } else {
                    if (!$css_js_enqued) {
                        $arsocial_lite->ars_common_enqueue_js_css();
                        wp_enqueue_script('ars-lite-like-front-js');
                        $css_js_enqued = true;
                    }

                    $popup = 'true';
                    $popup_option = isset($display_setting['popup']) ? $display_setting['popup'] : array();
                    $popup_type = isset($popup_option['display_popup']) ? $popup_option['display_popup'] : 'onload';

                    $popup_open_delay = isset($popup_option['onload_time']) ? $popup_option['onload_time'] : '0';
                    $popup_open_scroll = isset($popup_option['onscroll_percentage']) ? $popup_option['onscroll_percentage'] : '50%';
                    $popup_width = isset($popup_option['popup_width']) ? $popup_option['popup_width'] : '';
                    $popup_height = isset($popup_option['popup_height']) ? $popup_option['popup_height'] : '';
                    $popup_button_width = isset($popup_option['btn_width']) ? $popup_option['btn_width'] : '';
                    $popup_is_close_button = (isset($popup_option['is_close_button']) && $popup_option['is_close_button'] == 'yes' ) ? 'true' : 'false';
                    $load_native_button = isset($popup_option['load_native_btn']) ? $popup_option['load_native_btn'] : "";
                    $load_native_skin = isset($popup_option['skin']) ? $popup_option['skin'] : "default";
                    $load_native_button = ($load_native_button == 'yes') ? true : false;
                    $btn_width = isset($popup_option['btn_width']) ? $popup_option['btn_width'] : "small";
                    $nativeClass = '';
                    if ($load_native_button) {
                        $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
                    } else {
                        $nativeClass = 'ars_like_' . $btn_width;
                    }


                    $popup_style = '';
                    if (isset($popup_width) && !empty($popup_width)) {
                        $popup_style .= "width: " . $popup_width . "px;";
                    }
                    if (isset($popup_height) && !empty($popup_height)) {
                        $popup_style .= " height: " . $popup_height . "px;";
                    }

                    $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike' style='display:none;'>";
                    if ($popup_type == 'onload') {
                        $changed_content .= "<div class = 'arsocial_lite_like_popup_wrapper arsocial_lite_like_popup_button_wrapper arsocial_lite_popup_button_wrapper {$nativeClass} ' id = 'arsocial_lite_like_popup_wrapper' style = '" . $popup_style . "' data-is_popup = '$popup' data-popup_type = '$popup_type' data-popup_open_delay = '$popup_open_delay' data-popup_width = '$popup_width' data-popup_height = '$popup_height' data-popup_close_button = '$popup_is_close_button'>";
                        $changed_content .="<div class='arsocial_lite_like_ars_align_center arsocialshare_network_like_button_settings'>";
                    }
                    if ($popup_type == 'onscroll') {
                        $changed_content .= "<div class = 'arsocial_lite_like_popup_wrapper arsocial_lite_like_popup_button_wrapper arsocial_lite_popup_button_wrapper {$nativeClass}' id = 'arsocial_lite_like_popup_wrapper' style = '" . $popup_style . "' data-is_popup = '$popup' data-popup_type = '$popup_type' data-popup_open_scroll = '$popup_open_scroll' data-popup_width = '$popup_width' data-popup_height = '$popup_height' data-popup_close_button = '$popup_is_close_button'>";
                        $changed_content .="<div class='arsocial_lite_like_ars_align_center arsocialshare_network_like_button_settings'>";
                    }
                    if (isset($popup_is_close_button) && $popup_is_close_button == 'true') {
                        $changed_content .= "<div class = 'arsocialshare_popup_close' id = 'arsocial_lite_like_popup_wrapper_close'><span></span></div>";
                    }

                    $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

                    $changed_content .= '</div>';
                    $changed_content .= '</div>';
                    $changed_content .= '</div>';
                }
            }
        }
        /* for popup */

        /* Top Bottom Bar */
        if (isset($settings['display']['top_bottom_bar']['enable']) && $settings['display']['top_bottom_bar']['enable'] == true) {

            if (!$css_js_enqued) {
                $arsocial_lite->ars_common_enqueue_js_css();
                wp_enqueue_script('ars-lite-like-front-js');
                $css_js_enqued = true;
            }
             if ($hide_top_bottom_bar && wp_is_mobile()) {
                //hide in mobile
            } else {

                $exclude_post_id = array();
                $exclude_post_id = isset($settings['display']['top_bottom_bar']['exclude_pages']) ? $settings['display']['top_bottom_bar']['exclude_pages'] : array();
                $exclude_post_id = explode(',', $exclude_post_id);
                if (in_array($post_id, $exclude_post_id)) {
                    $changed_content .= '';
                } else {

                    $top_bottom_bar = 'true';
                    $top_bottom_bar_option = isset($display_setting['top_bottom_bar']) ? $display_setting['top_bottom_bar'] : array();

                    $top_bottom_bar_type = isset($top_bottom_bar_option['display_bar']) ? $top_bottom_bar_option['display_bar'] : 'onload';
                    $button_align = isset($top_bottom_bar_option['align']) ? $top_bottom_bar_option['align'] : 'center';
                    $top_bottom_bar_top = (isset($top_bottom_bar_option['top']) && !empty($top_bottom_bar_option['top'])) ? $top_bottom_bar_option['top'] : '';
                    $top_bottom_bar_bottom = (isset($top_bottom_bar_option['bottom']) && !empty($top_bottom_bar_option['bottom'])) ? $top_bottom_bar_option['bottom'] : '';

                    $load_native_button = isset($top_bottom_bar_option['load_native_btn']) ? $top_bottom_bar_option['load_native_btn'] : "";
                    $load_native_button = ($load_native_button == 'yes') ? true : false;
                    $load_native_skin = isset($top_bottom_bar_option['skin']) ? $top_bottom_bar_option['skin'] : "default";
                    $btn_width = isset($top_bottom_bar_option['btn_width']) ? $top_bottom_bar_option['btn_width'] : "small";
                    $y_position = isset($top_bottom_bar_option['y_point']) ? $top_bottom_bar_option['y_point'] : '0';
                    $nativeClass = '';
                    if ($load_native_button) {
                        $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
                    } else {
                        $nativeClass = 'ars_like_' . $btn_width;
                    }



                    $top_bottom_bar_option['onload_time'] = isset($top_bottom_bar_option['onload_time']) ? $top_bottom_bar_option['onload_time'] : '0';
                    $top_bottom_bar_option['onscroll_percentage'] = isset($top_bottom_bar_option['onscroll_percentage']) ? $top_bottom_bar_option['onscroll_percentage'] : '50';

                    $data_attr = '';
                    if (isset($top_bottom_bar_option) && !empty($top_bottom_bar_option)) {
                        foreach ($top_bottom_bar_option as $data_key => $data_val) {
                            $data_attr .= "data-top_bottom_bar_" . $data_key . "='" . $data_val . "' ";
                        }
                    }

                    $top_bottom_bar_style = 'display:none;';
                    $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";

                if ($top_bottom_bar_top) {
                    $changed_content .= "<div class='arsocial_lite_like_top_bottom_bar_wrapper arsocial_lite_like_top_bar_wrapper  arsocialshare_network_like_button_settings arsocial_lite_like_ars_align_{$button_align} arsocial_lite_like_topbar_wrapper' id='arsocial_lite_like_top_bottom_bar_wrapper' style = '" . $top_bottom_bar_style . "margin-top:{$y_position}px;' $data_attr >";
                    $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);
                    $changed_content .= '</div>';
                }

                if ($top_bottom_bar_bottom) {
                    $changed_content .= "<div class='arsocial_lite_like_top_bottom_bar_wrapper arsocial_lite_like_bottom_bar_wrapper  arsocialshare_network_like_button_settings arsocial_lite_like_ars_align_{$button_align} arsocial_lite_like_bottombar_wrapper' id='arsocial_lite_like_top_bottom_bar_wrapper' style = '" . $top_bottom_bar_style . "' $data_attr >";
                    $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);
                    $changed_content .= '</div>';
                }


                    $changed_content .= '</div>';
                }
            }
        }
        /* Top Bottom Bar */

        /* For Display on Custom Position mobile */
        if (wp_is_mobile() && isset($display_setting['mobile'])) {
            if (!$css_js_enqued) {
                $arsocial_lite->ars_common_enqueue_js_css();
                wp_enqueue_script('ars-lite-like-front-js');
                $css_js_enqued = true;
            }

            $popup = 'true';

            $load_native_skin = isset($display_setting['mobile']['skin']) ? $display_setting['mobile']['skin'] : "skin3";
            $load_native_button = true;
            $btn_width = "medium";
            $nativeClass = '';
            if ($load_native_button) {
                $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
            } else {
                $nativeClass = 'ars_like_' . $btn_width;
            }

            $popup_style = '';
            if (isset($popup_width) && !empty($popup_width)) {
                $popup_style .= "width: " . $popup_width . "px;";
            }
            if (isset($popup_height) && !empty($popup_height)) {
                $popup_style .= " height: " . $popup_height . "px;";
            }

            $disply_type = (isset($display_setting['mobile']['disply_type']) && !empty($display_setting['mobile']['disply_type'])) ? $display_setting['mobile']['disply_type'] : '';

            if ($disply_type == 'share_button_bar') {
                $changed_content .= "<div class='arsocial_lite_share_button_bar_wrapper' id='arsocialshare_like_button_bar_wrapper' style=''>";
                $changed_content .= "<img src='" . ARSOCIAL_LITE_IMAGES_URL . "/like_icon.png'>";
                $changed_content .= isset($display_setting['mobile']['bar_label']) ? $display_setting['mobile']['bar_label'] : '';
                $changed_content .= "</div>";
            }

            if ($disply_type == 'share_point') {
                $display_type = isset($display_setting['mobile']['button_position']) ? 'share_' . $display_setting['mobile']['button_position'] . '_point' : 'share_left_point';
                $changed_content .= "<div class='arsocialshare_share_point_wrapper " . $display_type . "' id='arsocialshare_like_point_wrapper' style=''>";
                $changed_content .= "<img src='" . ARSOCIAL_LITE_IMAGES_URL . "/like_icon.png'>";
                $changed_content .= "</div>";
            }


            if ($disply_type == 'share_footer_icons') {

                $nativeClass = 'ars_like_small ars_native_' . $load_native_skin;
                $total_enable_network = sizeof($new_sorted_fan_networks['display']['selected_network']);
                $like_mobile_css_class = '';
                if ($total_enable_network == 1) {
                    $like_mobile_css_class = 'ars_one_like_button';
                }
                if ($total_enable_network == 2) {
                    $like_mobile_css_class = 'ars_two_like_button';
                }

                $changed_content .= "<div class='arsocial_like_footer_icons $like_mobile_css_class' id='arsocialshare_like_footer_icons' style=''>";
                $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
                $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_bottom_button  arsocial_lite_like_left' id='arsocial_lite_like_bottom_button '>";
                $i = 1;
                $total_enable_network = sizeof($new_sorted_fan_networks['display']['selected_network']);

                foreach ($new_sorted_fan_networks as $key => $network) {
                    if ($i <= 2 || $total_enable_network == 2) {
                        $changed_content .= $this->arsocialshare_like_html($key, $network, $load_native_button);
                    }
                    $i++;
                }
                if ($total_enable_network > 2) {
                    $changed_content .='<div class="arsocialshare_like_wraper ars_like_more_button native_button_parent" id="arsocial_lite_like_mobile_more_wraper">';
                    if ($display_setting['mobile']['more_button_style'] == 'plus_icon') {
                        $changed_content .= '<i class="ars_fan_network_icon socialshare-plus"></i>';
                    }
                    if ($display_setting['mobile']['more_button_style'] == 'dot_icon') {
                        $changed_content .= '<i class="ars_fan_network_icon socialshare-dot-3"></i>';
                    }
                    $changed_content .='</div>';
                }
                $changed_content .= "</div>";
                $changed_content .= "</div>";
                $changed_content .= "</div>";
            }

            $changed_content .= "<div class='arsocialshare_mobile_wrapper' id='arsocial_like_mobile_wrapper' style='display:none;' >";
            $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass} arsocial_lite_like_ars_align_center arsocialshare_network_like_button_settings' data-ng-module='arsociallitelike' style=''>";
            $changed_content .= "<div class='arsocialshare_mobile_close' id='arsocialshare_mobile_close'><span><img src='" . ARSOCIAL_LITE_IMAGES_URL . "/ars_close.png'></span></div>";

            $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

            $changed_content.= "</div>";
            $changed_content.= "</div>";
        }

        if (!array_key_exists($post_type, $settings['display'])) {
            $changed_content .= $content;
        }
        if ((isset($settings['display']['page']['enable']) && $settings['display']['page']['enable'] == true) || (isset($settings['display']['post']['enable']) && $settings['display']['post']['enable'] == true) || (isset($settings['display']['popup']['enable']) && $settings['display']['popup']['enable'] == true) || (isset($settings['display']['top_bottom_bar']['enable']) && $settings['display']['top_bottom_bar']['enable'] == true) || (isset($display_setting['mobile']) && wp_is_mobile())) {

            $settings = maybe_unserialize($settings);
            
            $changed_content .= "<input type='hidden' name='ars_global_like_settings' id='ars_global_like_settings' value='" . $settings_encode . "' />";
            $changed_content .= "<input type='hidden' name='ars_like_shortcode_settings' id='ars_like_shortcode_settings' value='" . json_encode($settings) . "' />";
            
        }

        $changed_content .= $arsocial_lite->ars_get_enqueue_fonts('like');
        return $changed_content;
    }

    /**
     * Function for add social  like button on post excerpt.
     * 
     * @since v1.0
     */
    function arsocial_lite_like_filtered_excerpt($content) {
        if (is_admin()) {
            return $content;
        }

        global $arsocial_lite;
        $settings = maybe_unserialize(get_option('arslite_like_display_settings'));
        $post_id = get_the_ID();
        $post_type = get_post_type();
        $changed_content = "";

        if ($post_id === '') {
            return $content;
        } else if (empty($settings)) {
            return $content;
        } else if (empty($settings['display'])) {
            return $content;
        }

        $display_setting = isset($settings['display']) ? $settings['display'] : array();

        $gs_settings = get_option('arslite_global_settings');
        $settings_global = maybe_unserialize($gs_settings);
        $settings_encode = json_encode($settings_global);

        $saved_like_networks_global = $settings;

        $settings = maybe_unserialize($settings);
        
        $changed_content .= "<input type='hidden' name='ars_global_like_settings' id='ars_global_like_settings' value='" . $settings_encode . "' />";
        $changed_content .= "<input type='hidden' name='ars_like_shortcode_settings' id='ars_like_shortcode_settings' value='" . json_encode($settings) . "' />";
        

        if (get_option('arslite_global_like_order')) {
            $sorted_fan_option = maybe_unserialize(get_option('arslite_global_like_order'));
            $new_sorted_fan_networks = array();
            if (!empty($sorted_fan_option) && is_array($sorted_fan_option)) {
                foreach ($sorted_fan_option as $key => $network) {
                    $new_sorted_fan_networks[$network] = @$saved_like_networks_global[$network];
                }
                $new_sorted_fan_networks['display'] = $saved_like_networks_global['display'];
            }
        }

        if (isset($settings['display']['post']['enable']) && $settings['display']['post']['enable'] == true && $post_type == 'post' && isset($settings['display']['post']['post_excerpt']) && $settings['display']['post']['post_excerpt'] == 'yes') {
            /* exclude pages */
            $exclude_post_id = array();
            if (isset($settings['display']['post']['exclude_pages'])) {
                $exclude_post_id = explode(',', $settings['display']['post']['exclude_pages']);
                if (in_array($post_id, $exclude_post_id)) {
                    return $content;
                }
            }

            $post_option = isset($display_setting['post']) ? $display_setting['post'] : array();
            $enable_on_post_exerpt = isset($post_option['post_excerpt']) ? $post_option['post_excerpt'] : false;
            $display_bottom = isset($post_option['bottom']) ? $post_option['bottom'] : '';

            $button_align = 'ars_align_right';
            $load_native_button = isset($post_option['load_native_btn']) ? $post_option['load_native_btn'] : "";
            $load_native_skin = isset($post_option['skin']) ? $post_option['skin'] : "default";
            $load_native_button = ($load_native_button == 'yes') ? true : false;
            $btn_width = isset($post_option['btn_width']) ? $post_option['btn_width'] : "small";
            $nativeClass = '';
            if ($load_native_button) {
                $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
            } else {
                $nativeClass = 'ars_like_' . $btn_width;
            }

            $changed_content .=$content;
            if ($enable_on_post_exerpt) {

                $arsocial_lite->ars_common_enqueue_js_css();
                wp_enqueue_script('ars-lite-like-front-js');

                $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
                $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_bottom_button  arsocial_lite_like_{$button_align}' id='arsocial_lite_like_bottom_button '>";

                $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

                $changed_content .= '</div>';
                $changed_content .= '</div>';
            }
        } else {
            $changed_content .=$content;
        }


        return $changed_content;
    }

    /**
     * Function for add social  like button after product price
     * 
     * @since v1.0
     */
    function arsocial_lite_like_woocommerce_price_filter($price) {
        if (is_admin()) {
            return $price;
        }
        global $arsocial_lite;
        $settings = maybe_unserialize(get_option('arslite_like_display_settings'));
        $post_id = get_the_ID();
        $post_type = get_post_type();
        $changed_content = "";

        if ($post_id === '') {
            return $price;
        } else if (empty($settings)) {
            return $price;
        } else if (empty($settings['display'])) {
            return $price;
        } else if (empty($settings['display']['woocommerce'])) {
            return $price;
        } else if ($settings['display']['woocommerce']['after_price'] == '') {
            return $price;
        }

        $display_setting = isset($settings['display']) ? $settings['display'] : array();

        $gs_settings = get_option('arslite_global_settings');
        $settings_global = maybe_unserialize($gs_settings);
        $settings_encode = json_encode($settings_global);

        $settings = maybe_unserialize($settings);
        
        $changed_content .= "<input type='hidden' name='ars_global_like_settings' id='ars_global_like_settings' value='" . $settings_encode . "' />";
        $changed_content .= "<input type='hidden' name='ars_like_shortcode_settings' id='ars_like_shortcode_settings' value='" . json_encode($settings) . "' />";
        

        $saved_like_networks_global = $settings;

        if (get_option('arslite_global_like_order')) {
            $sorted_fan_option = maybe_unserialize(get_option('arslite_global_like_order'));
            $new_sorted_fan_networks = array();
            if (!empty($sorted_fan_option) && is_array($sorted_fan_option)) {
                foreach ($sorted_fan_option as $key => $network) {
                    $new_sorted_fan_networks[$network] = @$saved_like_networks_global[$network];
                }
                $new_sorted_fan_networks['display'] = $saved_like_networks_global['display'];
            }
        }


        if (isset($display_setting['woocommerce']) && isset($display_setting['woocommerce']['after_price']) && $display_setting['woocommerce']['after_price'] != '') {
            if (isset($settings['display']['woocommerce']['exclude_pages'])) {
                $exclude_post_id = explode(',', $settings['display']['woocommerce']['exclude_pages']);
                if (in_array($post_id, $exclude_post_id)) {
                    return $price;
                }
            }
            $arsocial_lite->ars_common_enqueue_js_css();
            wp_enqueue_script('ars-lite-like-front-js');
            $woocommerce_option = isset($display_setting['woocommerce']) ? $display_setting['woocommerce'] : array();
            $button_align = isset($woocommerce_option['btn_align']) ? $woocommerce_option['btn_align'] : "center";
            $load_native_button = isset($woocommerce_option['load_native_btn']) ? $woocommerce_option['load_native_btn'] : "";
            $load_native_skin = isset($woocommerce_option['skin']) ? $woocommerce_option['skin'] : "default";
            $btn_width = isset($woocommerce_option['btn_width']) ? $woocommerce_option['btn_width'] : "small";
            $load_native_button = ($load_native_button == 'yes') ? true : false;

            $nativeClass = '';
            if ($load_native_button) {
                $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
            } else {
                $nativeClass = 'ars_like_' . $btn_width;
            }
            $changed_content .= $price;
            $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
            $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_button_after_price arsocial_lite_like_{$button_align} ' id='arsocial_lite_like_button_after_price'>";

            $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

            $changed_content .= '</div>';
            $changed_content .= '</div>';
        }

        return $changed_content;
    }

    /**
     * Function for add social  like button before product
     * 
     * @since v1.0
     */
    function arsocial_lite_like_woocommerce_before_single_product() {
        global $arsocial_lite;
        $settings = maybe_unserialize(get_option('arslite_like_display_settings'));
        $post_id = get_the_ID();
        $post_type = get_post_type();
        $changed_content = "";

        if ($post_id === '') {
            return '';
        } else if (empty($settings)) {
            return '';
        } else if (empty($settings['display'])) {
            return '';
        } else if (empty($settings['display']['woocommerce'])) {
            return '';
        } else if (isset($settings['display']['woocommerce']['before_product']) && $settings['display']['woocommerce']['before_product'] == '') {
            return '';
        }

        $display_setting = isset($settings['display']) ? $settings['display'] : array();

        $gs_settings = get_option('arslite_global_settings');
        $settings_global = maybe_unserialize($gs_settings);
        $settings_encode = json_encode($settings_global);

        $changed_content .= "<input type='hidden' name='ars_global_like_settings' id='ars_global_like_settings' value='" . $settings_encode . "' />";

        $saved_like_networks_global = $settings;

        if (get_option('arslite_global_like_order')) {
            $sorted_fan_option = maybe_unserialize(get_option('arslite_global_like_order'));
            $new_sorted_fan_networks = array();
            if (!empty($sorted_fan_option) && is_array($sorted_fan_option)) {
                foreach ($sorted_fan_option as $key => $network) {
                    $new_sorted_fan_networks[$network] = @$saved_like_networks_global[$network];
                }
                $new_sorted_fan_networks['display'] = $saved_like_networks_global['display'];
            }
        }

        $arsocial_lite->ars_common_enqueue_js_css();
        wp_enqueue_script('ars-lite-like-front-js');


        if (isset($display_setting['woocommerce']) && isset($display_setting['woocommerce']['before_product']) && $display_setting['woocommerce']['before_product'] != '') {
            if (isset($settings['display']['woocommerce']['exclude_pages'])) {
                $exclude_post_id = explode(',', $settings['display']['woocommerce']['exclude_pages']);
                if (in_array($post_id, $exclude_post_id)) {
                    return '';
                }
            }

            $arsocial_lite->ars_common_enqueue_js_css();
            wp_enqueue_script('ars-lite-like-front-js');

            $woocommerce_option = isset($display_setting['woocommerce']) ? $display_setting['woocommerce'] : array();
            $button_align = isset($woocommerce_option['btn_align']) ? $woocommerce_option['btn_align'] : "center";
            $load_native_button = isset($woocommerce_option['load_native_btn']) ? $woocommerce_option['load_native_btn'] : "";
            $load_native_skin = isset($woocommerce_option['skin']) ? $woocommerce_option['skin'] : "default";
            $btn_width = isset($woocommerce_option['btn_width']) ? $woocommerce_option['btn_width'] : "small";
            $load_native_button = ($load_native_button == 'yes') ? true : false;
            $nativeClass = '';
            if ($load_native_button) {
                $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
            } else {
                $nativeClass = 'ars_like_' . $btn_width;
            }
            $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
            $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_button_before_product arsocial_lite_like_{$button_align} '  id='arsocial_lite_like_button_before_product'>";

            $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

            $changed_content .= '</div>';
            $changed_content .= '</div>';
        }
        echo $changed_content;
    }

    /**
     * Function for add social  like button after product 
     * 
     * @since v1.0
     */
    function arsocial_lite_like_woocommerce_after_single_product() {
        global $arsocial_lite;
        $settings = maybe_unserialize(get_option('arslite_like_display_settings'));
        $post_id = get_the_ID();
        $post_type = get_post_type();
        $changed_content = "";

        if ($post_id === '') {
            return '';
        } else if (empty($settings)) {
            return '';
        } else if (empty($settings['display'])) {
            return '';
        } else if (empty($settings['display']['woocommerce'])) {
            return '';
        } else if (isset($settings['display']['woocommerce']['before_product']) && $settings['display']['woocommerce']['after_product'] == '') {
            return '';
        }

        $display_setting = isset($settings['display']) ? $settings['display'] : array();

        $gs_settings = get_option('arslite_global_settings');
        $settings_global = maybe_unserialize($gs_settings);
        $settings_encode = json_encode($settings_global);

        $settings = maybe_unserialize($settings);

        $changed_content .= "<input type='hidden' name='ars_global_like_settings' id='ars_global_like_settings' value='" . $settings_encode . "' />";
        $changed_content .= "<input type='hidden' name='ars_like_shortcode_settings' id='ars_like_shortcode_settings' value='" . json_encode($settings) . "' />";
        

        $saved_like_networks_global = $settings;

        if (get_option('arslite_global_like_order')) {
            $sorted_fan_option = maybe_unserialize(get_option('arslite_global_like_order'));
            $new_sorted_fan_networks = array();
            if (!empty($sorted_fan_option) && is_array($sorted_fan_option)) {
                foreach ($sorted_fan_option as $key => $network) {
                    $new_sorted_fan_networks[$network] = @$saved_like_networks_global[$network];
                }
                $new_sorted_fan_networks['display'] = $saved_like_networks_global['display'];
            }
        }

        $arsocial_lite->ars_common_enqueue_js_css();
        wp_enqueue_script('ars-lite-like-front-js');


        if (isset($display_setting['woocommerce']) && isset($display_setting['woocommerce']['after_product']) && $display_setting['woocommerce']['after_product'] != '') {
            $exclude_post_id = array();
            $exclude_post_id = isset($settings['display']['woocommerce']['exclude_pages']) ? $settings['display']['woocommerce']['exclude_pages'] : array();
            $exclude_post_id = explode(',', $exclude_post_id);
            if (in_array($post_id, $exclude_post_id)) {
                return '';
            } else {

                $woocommerce_option = isset($display_setting['woocommerce']) ? $display_setting['woocommerce'] : array();
                $button_align = isset($woocommerce_option['btn_align']) ? $woocommerce_option['btn_align'] : "center";
                $load_native_button = isset($woocommerce_option['load_native_btn']) ? $woocommerce_option['load_native_btn'] : "";
                $btn_width = isset($woocommerce_option['btn_width']) ? $woocommerce_option['btn_width'] : "";
                $load_native_skin = isset($woocommerce_option['skin']) ? $woocommerce_option['skin'] : "default";
                $load_native_button = ($load_native_button == 'yes') ? true : false;
                $nativeClass = '';
                if ($load_native_button) {
                    $nativeClass = 'ars_like_' . $btn_width . ' ars_native_' . $load_native_skin;
                } else {
                    $nativeClass = 'ars_like_' . $btn_width;
                }
                $changed_content .= "<div class='arsocial_lite_like_button arsocial_lite_like_button_wrapper {$nativeClass}' data-ng-module='arsociallitelike'>";
                $changed_content .= "<div class='arsocialshare_network_like_button_settings arsocial_lite_like_button_after_product arsocial_lite_like_{$button_align}' id='arsocial_lite_like_button_after_product'>";

                $changed_content .= $this->arsocialshare_get_like_html($new_sorted_fan_networks, $load_native_button);

                $changed_content .= '</div>';
                $changed_content .= '</div>';
            }
        }

        echo $changed_content;
    }

    function arsocial_lite_save_like_order() {
        $network_position = isset($_POST['arsocialshare_like_network']) ? $_POST['arsocialshare_like_network'] : '';

        if (is_array($network_position) && !empty($network_position)) {
            $positions = maybe_serialize($network_position);
            update_option('arslite_global_like_order', $positions);
        }
        die();
    }

    function arsocialshare_get_like_html($social_networks = array(), $load_native_buttons) {
        $likeHtml = "";
        if (!empty($social_networks)) {
            foreach ($social_networks as $key => $options) {
                if ($key !== 'display') {
                    $likeHtml .= $this->arsocialshare_like_html($key, $options, $load_native_buttons);
                }
            }
        }
        return $likeHtml;
    }

    function arsocialshare_like_html($network = '', $options = array(), $load_native_buttons) {
        if ($network == '' || empty($options)) {
            return '';
        }
        $isDisplay = false;
        $likeBtnHtml = $mainLikeBtn = $network_name = '';
        switch ($network) {
            case 'facebook':
                if ($options['is_fb_like']) {
                    $isDisplay = true;
                    $network_name = 'facebook';
                    $mainLikeBtn .= '<div data-ng-controller="arsociallitelikefb"></div>';
                    $mainLikeBtn .= '<div data-arslite-fb-like-button>';
                    $mainLikeBtn .= '<div id="fb-root"></div><div class="fb-like" data-href="' . $options['fb_like_url'] . '" data-layout="' . $options['fb_button_layout'] . '" data-action="' . $options['fb_button_action_type'] . '" data-show-faces="' . $options['fb_button_show_friend_face'] . '" data-width="' . $options['fb_button_width'] . '" data-share="false" data-colorscheme="' . $options['facebook_like_button_colorscheme'] . '"></div>';
                    $mainLikeBtn .= '</div>';
                }
                break;
            case 'twitter':
                if ($options['is_twitter_like']) {
                    $network_name = 'twitter';
                    if ($options['twitter_large_button']) {
                        $saved_like_button_type = 'large';
                    } else {
                        $saved_like_button_type = '';
                    }
                    if (isset($options['twitter_show_username'])) {
                        $options['twitter_show_username'] = $options['twitter_show_username'];
                    } else {
                        $options['twitter_show_username'] = false;
                    }
                    $isDisplay = true;
                    $mainLikeBtn .= '<div data-ng-controller="arsocialliteliketwitter"></div>';
                    $mainLikeBtn .= '<div data-arslite-twitter-like-button>';
                    $mainLikeBtn .= '<a href="https://twitter.com/' . $options['twitter_like_url'] . '" class="twitter-follow-button"';
                    $mainLikeBtn .= ($options['twitter_show_username']) ? ' data-show-screen-name="true"' : ' data-show-screen-name="false"';
                    $mainLikeBtn .= (isset($options['twitter_button_language']) && $options['twitter_button_language'] != 'automatic') ? 'data-lang="' . $options['twitter_button_language'] . '"' : '';
                    $mainLikeBtn .= ' data-show-count="false" data-size="' . $saved_like_button_type . '"';
                    $mainLikeBtn .= ($options['twitter_show_username']) ? ' data-dnt="true"' : ' data-dnt="false"';
                    $mainLikeBtn .= '></a>';
                    $mainLikeBtn .= '</div>';
                }
                break;
            default:
                break;
        }
        if ($isDisplay) {
            $native_parent_class = $native_class = '';
            if ($load_native_buttons) {
                $native_parent_class = 'native_button_parent ars_native_parent_' . $network;
                $native_class = 'native_button ars_native_' . $network;
            }

            $likeBtnHtml.= '<div id="arsocial_lite_like_' . $network . '_wraper" class="arsocialshare_like_wraper arsocial_lite_like_' . $network . '_wraper ' . $native_parent_class . '">';
            $likeBtnHtml.= '<div class="ars_btn_container">';
            if ($load_native_buttons) {
                $likeBtnHtml.= '<div id="arsocial_lite_like_native_' . $network . '_wrapper" class="arsocialshare_like_native_wrapper arsocial_lite_like_native_' . $network . '_wrapper ' . $native_class . '">';
                $likeBtnHtml.= '<span id="arsocial_lite_like_native_' . $network . '_icon" class="arsocialshare_native_button_icon arsocial_lite_like_native_' . $network . '_icon ' . $native_class . ' socialshare-' . $network . '"></span>';
                $likeBtnHtml.='<span id="arsocial_lite_like_native_' . $network . '_label" class ="arsocialshare_like_native_label arsocial_lite_like_native_' . $network . '_label">' . $network_name . '</span >';
                $likeBtnHtml.= '</div>';
            }
            $likeBtnHtml.= '<div id="arsocial_lite_like_api_button_' . $network . '" class="arsocialshare_like_button_wrapper arsocial_lite_like_api_button_' . $network . '">' . $mainLikeBtn . '</div>';
            $likeBtnHtml.= '</div>';
            $likeBtnHtml.= '</div>';
        }
        return $likeBtnHtml;
    }

    function arsocialshare_like_networks_after_sorting($network = '', $options = array(), $load_native_buttons) {
        if ($network == '' || empty($options)) {
            return '';
        }

        $html = "";
        $native_parent_class = $native_class = '';
        if ($load_native_buttons) {
            $native_parent_class = 'native_button_parent ars_native_parent_' . $network;
            $native_class = 'native_button ars_native_' . $network;
        }

        switch ($network) {
            case 'facebook':
                if ($options['is_fb_like']) {
                    $html.= '<div id="arsocial_lite_like_facebook_wraper" class="arsocialshare_like_wraper arsocial_lite_like_facebook_wraper ' . $native_parent_class . '">';
                    $html.= '<div data-ng-controller="arsociallitelikefb"></div>';
                    $html.= '<div class="ars_btn_container" data-fb-like-button>';
                    if ($load_native_buttons) {
                        $html.= '<div id="arsocial_lite_like_native_facebook_wrapper" class="arsocialshare_like_native_wrapper arsocial_lite_like_native_facebook_wrapper ' . $native_class . '">';
                        $html.= '<span id="arsocial_lite_like_native_facebook_icon" class="arsocialshare_native_button_icon arsocial_lite_like_native_facebook_icon ' . $native_class . ' socialshare-facebook"></span>';
                        $html.='<span id="arsocial_lite_like_native_facebook_label" class ="arsocialshare_like_native_label arsocial_lite_like_native_facebook_label">facebook</span >';
                        $html.= '</div>';
                    }
                    $html.= '<div id="arsocial_lite_like_api_button_facebook" class="arsocialshare_like_button_wrapper arsocial_lite_like_api_button_facebook">';
                    $html.= '<div id="fb-root"></div><div class="fb-like" data-href="' . $options['fb_like_url'] . '" data-layout="' . $options['fb_button_layout'] . '" data-action="' . $options['fb_button_action_type'] . '" data-show-faces="' . $options['fb_button_show_friend_face'] . '" data-width="' . $options['fb_button_width'] . '" data-share="false" data-colorscheme="' . $options['facebook_like_button_colorscheme'] . '"></div>';
                    $html.= '</div>';
                    $html.= '</div>';
                    $html.= '</div>';
                }
                break;
            case 'twitter':
                if ($options['is_twitter_like']) {
                    $html.= '<div id="arsocial_lite_like_twitter_wraper" class="arsocialshare_like_wraper arsocial_lite_like_twitter_wraper ' . $native_parent_class . '">';
                    $html.= '<div data-ng-controller="arsocialliteliketwitter"></div>';
                    $html.= '<div class="ars_btn_container" data-twitter-like-button>';
                    if ($load_native_buttons) {
                        $html.= '<div id="arsocial_lite_like_native_twitter_wrapper" class="arsocialshare_like_native_wrapper arsocial_lite_like_native_twitter_wrapper ' . $native_class . '">';
                        $html.= '<span id="arsocial_lite_like_native_twitter_icon" class="arsocialshare_native_button_icon arsocial_lite_like_native_twitter_icon ' . $native_class . ' socialshare-twitter"></span>';
                        $html.='<span id="arsocial_lite_like_native_twitter_label" class ="arsocialshare_like_native_label arsocial_lite_like_native_twitter_label">twitter</span >';
                        $html.= '</div>';
                    }

                    if ($options['twitter_large_button']) {
                        $saved_like_button_type = 'large';
                    } else {
                        $saved_like_button_type = '';
                    }
                    if (isset($options['twitter_show_username'])) {
                        $options['twitter_show_username'] = $options['twitter_show_username'];
                    } else {
                        $options['twitter_show_username'] = false;
                    }

                    $html.= '<div id="arsocial_lite_like_api_button_twitter" class="arsocialshare_like_button_wrapper arsocial_lite_like_api_button_twitter">';
                    if ($options['is_twitter_like']) {
                        $html.= '<a href="https://twitter.com/' . $options['twitter_like_url'] . '" class="twitter-follow-button"';
                        if ($options['twitter_show_username']) {
                            $html.=' data-show-screen-name="true"';
                        } else {
                            $html.=' data-show-screen-name="false"';
                        }
                        if (isset($options['twitter_button_language']) && $options['twitter_button_language'] != 'automatic') {
                            $html.='data-lang="' . $options['twitter_button_language'] . '"';
                        }
                        $html.=' data-show-count="false" data-size="' . $saved_like_button_type . '"';
                        if ($options['twitter_opt_out_tailoring']) {
                            $html.=' data-dnt="true"';
                        } else {
                            $html.=' data-dnt="false"';
                        }
                        $html.= '></a>';
                        $html.= '</div>';
                    }
                    $html.= '</div>';
                    $html.= '</div>';
                }
                break;
            default:
                $html .= "";
                break;
        }

        return $html;
    }

}

?>