<?php

class ARSocial_Lite_Locker {

    function __construct() {

        add_shortcode('ARSocial_Lite_Locker', array($this, 'arsocialshare_locker'));

        add_action('wp_ajax_save_arsocial_lite_locker', array($this, 'save_arsocial_lite_locker'));

        add_action('wp_ajax_save_arsocial_lite_locker_display_settings', array($this, 'save_arsocial_lite_locker_display_settings'));

        add_action('wp_ajax_arsocial_lite_add_fblike', array($this, 'arsocial_locker_arsocial_lite_add_fblike'));
        add_action('wp_ajax_nopriv_arsocial_lite_add_fblike', array($this, 'arsocial_locker_arsocial_lite_add_fblike'));

        add_action('wp_ajax_arsocial_lite_locker_arsocial_add_linkedinuser', array($this, 'arsocial_lite_locker_arsocial_add_linkedinuser'));
        add_action('wp_ajax_nopriv_arsocial_lite_locker_arsocial_add_linkedinuser', array($this, 'arsocial_lite_locker_arsocial_add_linkedinuser'));

        add_action('wp_ajax_arsocial_lite_remove_locker', array($this, 'arsocial_lite_remove_locker'));

        add_action('wp', array($this, 'ars_lite_twitter_login_callback'), 5);

        add_action('wp_ajax_arsocial_lite_twitter_signin', array($this, 'arsocial_locker_add_twitter_user'));
        add_action('wp_ajax_nopriv_arsocial_lite_twitter_signin', array($this, 'arsocial_locker_add_twitter_user'));

        /* Add locker on page, post and custom post */
        add_filter('the_content', array($this, 'arsocial_lite_locker_filtered_content'));

        /* Add locker on post excerpt */
        add_filter('get_the_excerpt', array($this, 'arsocial_lite_filtered_excerpt'));

        add_action('wp_ajax_arsocial_lite_save_locker_order', array($this, 'arsocial_lite_save_locker_order'));
		
    }

    function arsocialshare_locker($atts, $content) {
        global $wpdb, $arsocial_lite;
        $locker_id = isset($atts['id']) ? $atts['id'] : '';

        if ($locker_id === '') {
            return esc_html__('Locker ID is empty or Invalid. Please select valid Locker ID', 'arsocial_lite');
        }


        $arsocial_lite->ars_common_enqueue_js_css();
        wp_enqueue_script('ars-lite-locker-front-js');


        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_front_locker.php')) {

            $last_insert_id = "";
            $post_id = get_the_ID();

            include ARSOCIAL_LITE_VIEWS_DIR . '/ars_front_locker.php';
            $response = arsocial_lite_locker_view($locker_id, $content, $last_insert_id);
            $response = json_decode($response);
            $content = $response->body;
        } else {
            $content = esc_html__('Locker ID is empty or Invalid. Please select valid Locker ID', 'arsocial_lite');
        }

        $inbuild = "";

        return $content;
    }
    	
    function save_arsocial_lite_locker() {
        global $wpdb, $arsocial_lite;
        $values = json_decode(stripslashes_deep($_POST['filtered_data']), true);
        $locker_action = isset($values['arsocial_locker_action']) ? $values['arsocial_locker_action'] : '';
        $response = array();
        if ($locker_action === '') {
            $response['message'] = 'error';
            $response['body'] = esc_html__('Something went wrong while save locker', 'arsocial_lite');
        } else {
            $locker_id = isset($values['locker_id']) ? $values['locker_id'] : '';
            $locker_title = isset($values['arsocial_lite_locker_title']) ? $values['arsocial_lite_locker_title'] : '';
            $locker_content = isset($values['arsocial_lite_locker_content']) ? $values['arsocial_lite_locker_content'] : '';
            $locker_type = isset($values['locker_type']) ? $values['locker_type'] : '';
            $selected_network = array();
            $is_fb_locker = isset($values['active_fb_locker']) ? $values['active_fb_locker'] : 0;
            if ($is_fb_locker == 1) {
                array_push($selected_network, 'facebook');
            }
            $fb_like_url = isset($values['arsocialshare_fb_like_url']) ? $values['arsocialshare_fb_like_url'] : '';
            $is_fb_counter = isset($values['is_fb_counter']) ? $values['is_fb_counter'] : 0;

            $is_tw_locker = isset($values['active_tw_locker']) ? $values['active_tw_locker'] : 0;
            if ($is_tw_locker == 1) {
                array_push($selected_network, 'twitter');
            }
            $tweet_url = isset($values['arsocialshare_tw_tweet_url']) ? $values['arsocialshare_tw_tweet_url'] : '';
            $tweet_text = isset($values['arsocial_locker_tweet_text']) ? $values['arsocial_locker_tweet_text'] : '';
            $tweet_via = isset($values['arsocialshare_tw_tweet_via']) ? $values['arsocialshare_tw_tweet_via'] : '';

            $is_fb_share = isset($values['is_fb_share']) ? $values['is_fb_share'] : '';
            if ($is_fb_share == 1) {
                array_push($selected_network, 'facebook');
            }
            $fb_share_url = isset($values['fb_share_url']) ? $values['fb_share_url'] : '';
            $fb_share_count = isset($values['is_fb_share_counter']) ? $values['is_fb_share_counter'] : '';

            $is_tw_follow = isset($values['is_tw_follow']) ? $values['is_tw_follow'] : '';
            if ($is_tw_follow == 1) {
                array_push($selected_network, 'twitter');
            }
            $tw_follow_url = isset($values['tw_follow_url']) ? $values['tw_follow_url'] : '';
            $tw_show_uname = isset($values['show_tw_username']) ? $values['show_tw_username'] : '';
            $show_tw_follow_cntr = isset($values['show_tw_follow_cntr']) ? $values['show_tw_follow_cntr'] : '';

            $is_linkedin_share = isset($values['is_linkedin_share']) ? $values['is_linkedin_share'] : '';
            if ($is_linkedin_share == 1) {
                array_push($selected_network, 'linkedin');
            }
            $linkedin_url_share = isset($values['linkedin_url_share']) ? $values['linkedin_url_share'] : '';
            $is_linkedin_share_counter = isset($values['is_linkedin_share_counter']) ? $values['is_linkedin_share_counter'] : '';

            $is_fb_signin_locker = isset($values['active_fb_signin_locker']) ? $values['active_fb_signin_locker'] : '';
            if ($is_fb_signin_locker == 1) {
                array_push($selected_network, 'facebook');
            }
            $fb_signin_save_mail = isset($values['active_fb_signin_save_email']) ? $values['active_fb_signin_save_email'] : '';
            $fb_create_wp_account = isset($values['fb_signin_create_wp_account']) ? $values['fb_signin_create_wp_account'] : '';

            $is_twitter_signin_locker = isset($values['active_twitter_signin_locker']) ? $values['active_twitter_signin_locker'] : '';
            if ($is_twitter_signin_locker == 1) {
                array_push($selected_network, 'twitter');
            }
            $twitter_signin_save_mail = isset($values['active_twitter_signin_save_email']) ? $values['active_twitter_signin_save_email'] : '';
            $twitter_create_wp_account = isset($values['twitter_signin_create_wp_account']) ? $values['twitter_signin_create_wp_account'] : '';

            $is_linkedin_signin_locker = isset($values['is_linkedin_signin']) ? $values['is_linkedin_signin'] : '';
            if ($is_linkedin_signin_locker == 1) {
                array_push($selected_network, 'linkedin');
            }
            $linkedin_signin_save_mail = isset($values['active_linkedin_signin_save_email']) ? $values['active_linkedin_signin_save_email'] : '';
            $linkedin_create_wp_account = isset($values['linkedin_signin_create_wp_account']) ? $values['linkedin_signin_create_wp_account'] : '';

            $locker_options = array();
            $display_option = array();
            $display_option['selected_network'] = $selected_network;
            $display_option['arsocial_lite_locker_share_networks'] = $values['arsocial_lite_locker_share_networks'];
            $display_option['arsocial_lite_locker_signin_networks'] = $values['arsocial_lite_locker_signin_networks'];
            $locker_options['social'] = array();

            $locker_options['social']['is_fb_like'] = $is_fb_locker;
            $locker_options['social']['fb_like_url'] = $fb_like_url;
            $locker_options['social']['is_fb_counter'] = $is_fb_counter;

            $locker_options['social']['is_tw_locker'] = $is_tw_locker;
            $locker_options['social']['tweet_url'] = $tweet_url;
            $locker_options['social']['tweet_txt'] = $tweet_text;
            $locker_options['social']['tweet_via'] = $tweet_via;

            $locker_options['social']['is_fb_share'] = $is_fb_share;
            $locker_options['social']['fb_share_url'] = $fb_share_url;
            $locker_options['social']['is_fb_share_counter'] = $fb_share_count;

            $locker_options['social']['is_tw_follow'] = $is_tw_follow;
            $locker_options['social']['tw_follow_url'] = $tw_follow_url;
            $locker_options['social']['show_tw_username'] = $tw_show_uname;
            $locker_options['social']['show_tw_follow_cntr'] = $show_tw_follow_cntr;

            $locker_options['social']['is_linkedin_share'] = $is_linkedin_share;
            $locker_options['social']['linkedin_url_share'] = $linkedin_url_share;
            $locker_options['social']['is_linkedin_share_counter'] = $is_linkedin_share_counter;

            $locker_options['social']['is_fb_signin'] = $is_fb_signin_locker;
            $locker_options['social']['is_fb_save_email'] = $fb_signin_save_mail;
            $locker_options['social']['is_fb_create_account'] = $fb_create_wp_account;

            $locker_options['social']['is_twitter_signin'] = $is_twitter_signin_locker;
            $locker_options['social']['is_twitter_save_email'] = $twitter_signin_save_mail;
            $locker_options['social']['is_twitter_create_account'] = $twitter_create_wp_account;

            $locker_options['social']['is_linkedin_signin'] = $is_linkedin_signin_locker;
            $locker_options['social']['is_linkedin_save_email'] = $linkedin_signin_save_mail;
            $locker_options['social']['is_linkedin_create_account'] = $linkedin_create_wp_account;

            $locker_options['display'] = $display_option;

            $locker_options['display']['locker_template'] = isset($values['arsocialshare_global_locker_templates']) ? $values['arsocialshare_global_locker_templates'] : 'default';
            $locker_options['display']['overlap_mode'] = isset($values['arsocial_lite_locker_overlap_mode']) ? $values['arsocial_lite_locker_overlap_mode'] : 'default';
            $bg_color = isset($values['arsocialshare_locker_bgcolor']) ? $values['arsocialshare_locker_bgcolor'] : '';
            $text_color = isset($values['arsocialshare_locker_textcolor']) ? $values['arsocialshare_locker_textcolor'] : '';
            $locker_options['display']['arsocialshare_locker_bgcolor'] = $bg_color;
            $locker_options['display']['arsocialshare_locker_textcolor'] = $text_color;


            $locker_options['advanced'] = array();

            $created_date = $updated_date = current_time('mysql');
            $response['message'] = 'success';
            $options = maybe_serialize($locker_options);
            $table = $wpdb->prefix . 'arsocial_lite_locker';
            if ($locker_action === 'new-locker' || $locker_action === 'duplicate') {
                $insert = $wpdb->prepare("INSERT INTO `$table` (lockername,content,locker_type,locker_options,created_date,updated_date) VALUES (%s,%s,%s,%s,%s,%s)", $locker_title, $locker_content, $locker_type, $options, $created_date, $updated_date);
                if ($wpdb->query($insert)) {
                    $response['message'] = 'success';
                    $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
                    $response['id'] = $wpdb->insert_id;
                    $response['action'] = 'new_locker';
                } else {
                    
                }
            } else if ($locker_action === 'edit-locker') {
                $update = $wpdb->prepare("UPDATE `$table` SET lockername = %s, content = %s, locker_type = %s, locker_options = %s, updated_date = %s WHERE ID = %d", $locker_title, $locker_content, $locker_type, $options, $updated_date, $locker_id);
                if ($wpdb->query($update)) {
                    $response['message'] = 'success';
                    $response['body'] = esc_html__('Settings Saved Successfully.', 'arsocial_lite');
                    $response['id'] = $locker_id;
                    $response['action'] = 'edit_locker';
                } else {
                    
                }
            }
        }
        $response = apply_filters('arsocial_lite_locker_save_msg_filter', $response);

        echo json_encode($response);
        die();
    }

    function arsocial_locker_arsocial_lite_add_fblike() {
        $container = isset($_POST['container']) ? $_POST['container'] : '';
        $locker_id = isset($_POST['locker_id']) ? $_POST['locker_id'] : 0;
        $unlocked_using = isset($_POST['unlocked_using']) ? $_POST['unlocked_using'] : '';
        $url = isset($_POST['page_url']) ? $_POST['page_url'] : '';
        $page_id = url_to_postid($url);
        global $wpdb, $arsocial_lite_forms;

//        if (!(extension_loaded('geoip'))) {
//            $file_url = ARSOCIAL_LITE_INC_DIR . "/GeoIP.dat";
//
//            @include(ARSOCIAL_LITE_INC_DIR . '/geoip.inc');
//            $gi = geoip_open($file_url, GEOIP_STANDARD);
//            $country_name = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);
//        } else {
//            $country_name = "";
//        }

//        $d = date("Y/m/d H:i:s");
//
//        $brow = $_SERVER['HTTP_USER_AGENT'];
//
//        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
//
//        $ip = $_SERVER['REMOTE_ADDR'];
//
//        $ses_id = session_id();
//
//        $browser = $arsocial_lite_forms->getBrowser($brow);
//
//        $table = $wpdb->prefix . 'arsocial_lite_locker_analytics';
//
//        $res = $wpdb->query($wpdb->prepare("INSERT INTO " . $table . " (locker_id,unlocked_using,browser_name,browser_version,page_id,ip_address,country,session_id,entry_date ) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)", $locker_id, $unlocked_using, $browser['browser_name'], $browser['version'], $page_id, $ip, $country_name, $ses_id, $d));

        $table = $wpdb->prefix . 'arsocial_lite_locker';

        $query = $wpdb->prepare("SELECT locker_type, locker_options FROM `$table` WHERE ID = %d", $locker_id);

        $row = $wpdb->get_row($query);
        if ($row) {

            $locker_type = $row->locker_type;
            $locker_opts = maybe_unserialize($row->locker_options);
            $social_opts = $locker_opts['social'];
            if ($locker_type === 'social_signin') {
                $fb_email = isset($_POST['fbemail']) ? $_POST['fbemail'] : '';
                if ($fb_email !== '') {
                    if ($social_opts['is_fb_create_account']) {
                        $message = $this->arsocialshare_create_user_from_social_login($fb_email);
                        echo $message;
                        die();
                    } else {
                        echo json_encode(array('message' => 'success'));
                    }
                } else {
                    echo json_encode(array('message' => 'error'));
                    die();
                }
            }
        } else {
            if ($locker_id === 'global_settings') {
                $get_locker = get_option('arslite_locker_display_settings');
                $settings = maybe_unserialize($get_locker);
                if (!empty($settings['batch_lock'])) {
                    if (isset($settings['batch_lock']['is_element_lock']) && !empty($settings['batch_lock']['is_element_lock'])) {
                        update_option('arslite_locker_global_settings_element_unlocked_' . $page_id, $settings['batch_lock']['class_elements']);
                    }
                }
            }
            echo json_encode(array('message' => 'success'));
            die();
        }
        die();
    }

    function arsocial_lite_locker_arsocial_add_linkedinuser() {
        global $wpdb, $arsocial_lite_forms;

        $container = $_POST['container'];
        $locker_id = $_POST['locker_id'];
        $unlocked_using = 'linkedin_signin';
        $url = isset($_POST['page_url']) ? $_POST['page_url'] : '';
        $page_id = url_to_postid($url);

//        if (!(extension_loaded('geoip'))) {
//            $file_url = ARSOCIAL_LITE_INC_DIR . "/GeoIP.dat";
//
//            @include(ARSOCIAL_LITE_INC_DIR . '/geoip.inc');
//            $gi = geoip_open($file_url, GEOIP_STANDARD);
//            $country_name = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);
//        } else {
//            $country_name = "";
//        }

//        $d = date("Y/m/d H:i:s");
//
//        $brow = $_SERVER['HTTP_USER_AGENT'];
//
//        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
//
//        $ip = $_SERVER['REMOTE_ADDR'];
//
//        $ses_id = session_id();
//
//        $browser = $arsocial_lite_forms->getBrowser($brow);
//
//        $table = $wpdb->prefix . 'arsocial_lite_locker_analytics';
//
//        $res = $wpdb->query($wpdb->prepare("INSERT INTO " . $table . " (locker_id,unlocked_using,browser_name,browser_version,page_id,ip_address,country,session_id,entry_date ) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)", $locker_id, $unlocked_using, $browser['browser_name'], $browser['version'], $page_id, $ip, $country_name, $ses_id, $d));

        $table = $wpdb->prefix . 'arsocial_lite_locker';

        $query = $wpdb->prepare("SELECT locker_type, locker_options FROM `$table` WHERE ID = %d", $locker_id);

        $row = $wpdb->get_row($query);
        $locker_type = $row->locker_type;
        $locker_opts = maybe_unserialize($row->locker_options);
        $social_opts = $locker_opts['social'];
        if ($locker_type === 'social_signin') {
            $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
            if ($user_email !== '') {
                if ($social_opts['is_linkedin_create_account']) {
                    $response = $this->arsocialshare_create_user_from_social_login($user_email);
                    echo $response;
                    die();
                } else {
                    echo json_encode(array('message' => 'success'));
                    die();
                }
            } else {
                if ($locker_id === 'global_settings') {
                    $get_locker = get_option('arslite_locker_display_settings');
                    $settings = maybe_unserialize($get_locker);
                    if (!empty($settings['batch_lock'])) {
                        if ($settings['batch_lock']['is_element_lock']) {
                            $page_id = get_the_ID();
                            update_option('arslite_locker_global_settings_element_unlocked_' . $page_id, $settings['batch_lock']['class_elements']);
                        }
                    }
                }
                echo json_encode(array('message' => 'error'));
                die();
            }
        } else {
            return json_encode(array('message' => 'success'));
        }

        die();
    }

    function arsocial_lite_remove_locker() {
        $locker_id = isset($_POST['locker_id']) ? $_POST['locker_id'] : '';
        $response = array();
        if ($locker_id === '') {
            $response['result'] = "error";
            $response['code'] = "404";
            $response['message'] = esc_html__('Please Select valid locker id.', 'arsocial_lite');
        } else {
            global $wpdb,$arsocial_lite;
            $table = $arsocial_lite->arslite_locker;
            $data = array('ID' => $locker_id);
            if ($wpdb->delete($table, $data)) {
                $response['result'] = "success";
                $response['code'] = "200";
                $response['message'] = esc_html__('Locker has been deleted successfully.', 'arsocial_lite');
            } else {
                $response['result'] = "error";
                $response['code'] = "404";
                $response['message'] = esc_html__('Could not delete locker.', 'arsocial_lite');
            }
        }
        echo json_encode($response);
        exit;
    }

    function arsocial_lite_locker_twitter_signin($data) {

        global $wpdb, $arsocial_lite_forms;

        $locker_id = $data['locker_id'];
        $unlocked_using = 'twitter_signin';
        $page_id = '';


        $table = $wpdb->prefix . 'arsocial_lite_locker';

        $query = $wpdb->prepare("SELECT locker_type, locker_options FROM `$table` WHERE ID = %d", $locker_id);

        $row = $wpdb->get_row($query);

        $locker_type = $row->locker_type;
        $locker_opts = maybe_unserialize($row->locker_options);
        $social_opts = $locker_opts['social'];
        if ($locker_type === 'social_signin') {
            if ($social_opts['is_twitter_create_account']) {
                $username = $_POST['user_login'];
                if (username_exists($username)) {
                    return json_encode(array('message' => esc_html__('user already exists', 'arsocial_lite')));
                    die();
                } else {
                    $password = wp_generate_password(10, false);
                    $user_id = wp_create_user($username, $password, $fb_email);
                    $credential = array();
                    $credential['user_login'] = $username;
                    $credential['user_password'] = $password;
                    $credential['remember'] = false;
                    $user = wp_signon($credential, false);
                    return json_encode(array('message' => 'success', 'userid' => $user_id));
                    die();
                }
            } else {
                if ($locker_id === 'global_settings') {
                    $get_locker = get_option('arslite_locker_display_settings');
                    $settings = maybe_unserialize($get_locker);
                    if (!empty($settings['batch_lock'])) {
                        if ($settings['batch_lock']['is_element_lock']) {
                            $page_id = get_the_ID();
                            update_option('arslite_locker_global_settings_element_unlocked_' . $page_id, $settings['batch_lock']['class_elements']);
                        }
                    }
                }
                return json_encode(array('message' => 'success'));
            }
        } else {
            return json_encode(array('message' => 'success'));
        }
    }

    function ars_lite_twitter_login_callback() {
        global $wpdb;
        $global_settings = maybe_unserialize(get_option('arslite_global_settings'));

        if (isset($_REQUEST['oauth_verifier'])) {

            if (in_array('ars_twitter_signin', $_REQUEST)) {
                $post_data = array();
                require_once (ARSOCIAL_LITE_CLASS_DIR . '/libs/twitter/twitteroauth.php');

                $twitteroauth = new TwitterOAuth($global_settings['twitter']['twitter_api_key'], $global_settings['twitter']['twitter_api_secret'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token

                $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
                $_SESSION['access_token'] = $access_token;
// Let's get the user's info
                $user_info = $twitteroauth->get('account/verify_credentials');

                if (isset($user_info->error)) {
                    echo "<script>alert('" . esc_html__('There is an error while connecting twitter, Please try again later.', 'arsocial_lite') . "');window.close();</script>";
                    exit;
                } else {
                    $full_name = explode(' ', $user_info->name);
                    $post_data = array(
                        'action' => 'arsocial_lite_locker_twitter_signin',
                        'id' => $user_info->id,
                        'user_login' => $user_info->screen_name,
                        'first_name' => $full_name[0],
                        'last_name' => $full_name[1],
                        'display_name' => $user_info->name,
                        'oauth_verifier' => $_GET['oauth_verifier'],
                        'locker_id' => $_GET['locker_id']
                    );
                    if ($user_info->default_profile_image != '1') {
                        $post_data['picture'] = $user_info->profile_image_url;
                    }

                    $slc_return = $this->arsocial_lite_locker_twitter_signin($post_data);
                }
//Unset Session Details.
                unset($_SESSION['customer_key']);
                unset($_SESSION['customer_secret']);
                unset($_SESSION['access_token']);
                echo "<script>window.opener.document.getElementById('arsocialshare_twitter_details').innerHTML = '" . base64_encode(json_encode($post_data)) . "'; window.close();</script>";
            }
        }
        return;
    }

    function arsocialshare_create_user_from_social_login($email_id = '') {
        if (email_exists($email_id)) {
            return json_encode(array('message' => esc_html__('email already exists', 'arsocial_lite')));
            die();
        } else {
            $usernm = $email_id;
            if (username_exists($usernm)) {
                return json_encode(array('message' => esc_html__('user already exists', 'arsocial_lite')));
                die();
            } else {
                $password = wp_generate_password(10, false);
                $user_id = wp_create_user($usernm, $password, $email_id);
                $credential = array();
                $credential['user_login'] = $usernm;
                $credential['user_password'] = $password;
                $credential['remember'] = false;
                $user = wp_signon($credential, false);
                return json_encode(array('message' => 'success', 'userid' => $user_id));
                die();
            }
        }
    }

    function arsocial_locker_add_twitter_user() {
        $emailid = isset($_POST['emailid']) ? $_POST['emailid'] : '';
        $twitterlog = isset($_POST['twitterlog']) ? $_POST['twitterlog'] : '';
        $response = array();
        $postdata = file_get_contents("php://input");
        $postdata = json_decode($postdata);

        $emailid = isset($postdata->emailid) ? $postdata->emailid : '';
        $twitterlog = isset($postdata->twitterlog) ? $postdata->twitterlog : '';
        $createaccount = isset($postdata->createaccount) ? $postdata->createaccount : '';
        if ($emailid === '' || $twitterlog === '') {
            $response['message'] = 'error';
            $response['body'] = esc_html__('Couldn\'t login with twitter. Please try again.', 'arsocial_lite');
        } else {
            $twitterlog = base64_decode($twitterlog);
            $twitterdata = json_decode($twitterlog);

            if ($createaccount) {
                if (email_exists($emailid)) {
                    $response['message'] = esc_html__('email already exists.', 'arsocial_lite');
                } else {
                    $usernm = $emailid;
                    if (username_exists($usernm)) {
                        $response['message'] = esc_html__('user already exists', 'arsocial_lite');
                        die();
                    } else {
                        $password = wp_generate_password(10, false);
                        $user_id = wp_create_user($usernm, $password, $emailid);
                        $credential = array();
                        $credential['user_login'] = $usernm;
                        $credential['user_password'] = $password;
                        $credential['remember'] = false;
                        $user = wp_signon($credential, false);
                        $response['message'] = 'success';
                        $response['userid'] = $user_id;
                        die();
                    }
                }
            } else {
                /* Code for save email */
                if ($locker_id === 'global_settings') {
                    $get_locker = get_option('arslite_locker_display_settings');
                    $settings = maybe_unserialize($get_locker);
                    if (!empty($settings['batch_lock'])) {
                        if ($settings['batch_lock']['is_element_lock']) {
                            $page_id = get_the_ID();
                            update_option('arslite_locker_global_settings_element_unlocked_' . $page_id, $settings['batch_lock']['class_elements']);
                        }
                    }
                }
                $response['message'] = 'success';
            }
        }
        echo json_encode($response);
        die();
    }

    function save_arsocial_lite_locker_display_settings() {
        global $wpdb, $arsocial_lite;

        $values = json_decode(stripslashes_deep($_POST['filtered_data']), true);

        $locker_options = array();

        $locker_title = isset($values['arsocial_lite_locker_title']) ? $values['arsocial_lite_locker_title'] : '';
        $locker_content = isset($values['arsocial_lite_locker_content']) ? $values['arsocial_lite_locker_content'] : '';
        $locker_type = isset($values['locker_type']) ? $values['locker_type'] : '';

        $locker_options['locker_type'] = $locker_type;
        $locker_options['locker_content'] = $locker_content;
        $locker_options['locker_title'] = $locker_title;

        $is_fb_locker = isset($values['active_fb_locker']) ? $values['active_fb_locker'] : 0;
        $fb_like_url = isset($values['arsocialshare_fb_like_url']) ? $values['arsocialshare_fb_like_url'] : '';
        $is_fb_counter = isset($values['is_fb_counter']) ? $values['is_fb_counter'] : 0;

        $locker_options['social']['is_fb_like'] = $is_fb_locker;
        $locker_options['social']['fb_like_url'] = $fb_like_url;
        $locker_options['social']['is_fb_counter'] = $is_fb_counter;

        $is_tw_locker = isset($values['active_tw_locker']) ? $values['active_tw_locker'] : 0;
        $tweet_url = isset($values['arsocialshare_tw_tweet_url']) ? $values['arsocialshare_tw_tweet_url'] : '';
        $tweet_text = isset($values['arsocial_locker_tweet_text']) ? $values['arsocial_locker_tweet_text'] : '';
        $tweet_via = isset($values['arsocialshare_tw_tweet_via']) ? $values['arsocialshare_tw_tweet_via'] : '';

        $locker_options['social']['is_tw_locker'] = $is_tw_locker;
        $locker_options['social']['tweet_url'] = $tweet_url;
        $locker_options['social']['tweet_txt'] = $tweet_text;
        $locker_options['social']['tweet_via'] = $tweet_via;

        $is_fb_share = isset($values['is_fb_share']) ? $values['is_fb_share'] : 0;
        $fb_share_url = isset($values['fb_share_url']) ? $values['fb_share_url'] : '';
        $fb_share_count = isset($values['is_fb_share_counter']) ? $values['is_fb_share_counter'] : '';

        $locker_options['social']['is_fb_share'] = $is_fb_share;
        $locker_options['social']['fb_share_url'] = $fb_share_url;
        $locker_options['social']['is_fb_share_counter'] = $fb_share_count;

        $is_tw_follow = isset($values['is_tw_follow']) ? $values['is_tw_follow'] : 0;
        $tw_follow_url = isset($values['tw_follow_url']) ? $values['tw_follow_url'] : '';
        $tw_show_uname = isset($values['show_tw_username']) ? $values['show_tw_username'] : '';
        $show_tw_follow_cntr = isset($values['show_tw_follow_cntr']) ? $values['show_tw_follow_cntr'] : '';

        $locker_options['social']['is_tw_follow'] = $is_tw_follow;
        $locker_options['social']['tw_follow_url'] = $tw_follow_url;
        $locker_options['social']['show_tw_username'] = $tw_show_uname;
        $locker_options['social']['show_tw_follow_cntr'] = $show_tw_follow_cntr;

        $is_linkedin_share = isset($values['is_linkedin_share']) ? $values['is_linkedin_share'] : 0;
        $linkedin_url_share = isset($values['linkedin_url_share']) ? $values['linkedin_url_share'] : '';
        $is_linkedin_share_counter = isset($values['is_linkedin_share_counter']) ? $values['is_linkedin_share_counter'] : '';

        $locker_options['social']['is_linkedin_share'] = $is_linkedin_share;
        $locker_options['social']['linkedin_url_share'] = $linkedin_url_share;
        $locker_options['social']['is_linkedin_share_counter'] = $is_linkedin_share_counter;

        $is_fb_signin_locker = isset($values['active_fb_signin_locker']) ? $values['active_fb_signin_locker'] : '';
        $fb_signin_save_mail = isset($values['active_fb_signin_save_email']) ? $values['active_fb_signin_save_email'] : '';
        $fb_create_wp_account = isset($values['fb_signin_create_wp_account']) ? $values['fb_signin_create_wp_account'] : '';



        $locker_options['social']['is_fb_signin'] = $is_fb_signin_locker;
        $locker_options['social']['is_fb_save_email'] = $fb_signin_save_mail;
        $locker_options['social']['is_fb_create_account'] = $fb_create_wp_account;

        $is_twitter_signin_locker = isset($values['active_twitter_signin_locker']) ? $values['active_twitter_signin_locker'] : 0;
        $twitter_signin_save_mail = isset($values['active_twitter_signin_save_email']) ? $values['active_twitter_signin_save_email'] : '';
        $twitter_create_wp_account = isset($values['twitter_signin_create_wp_account']) ? $values['twitter_signin_create_wp_account'] : '';



        $locker_options['social']['is_twitter_signin'] = $is_twitter_signin_locker;
        $locker_options['social']['is_twitter_save_email'] = $twitter_signin_save_mail;
        $locker_options['social']['is_twitter_create_account'] = $twitter_create_wp_account;

        //$is_linkedin_signin_locker = isset($values['active_linkedin_signin_locker']) ? $values['active_linkedin_signin_locker'] : 0;
        $is_linkedin_signin_locker = isset($values['is_linkedin_signin']) ? $values['is_linkedin_signin'] : 0;
        $linkedin_signin_save_mail = isset($values['active_linkedin_signin_save_email']) ? $values['active_linkedin_signin_save_email'] : '';
        $linkedin_create_wp_account = isset($values['linkedin_signin_create_wp_account']) ? $values['linkedin_signin_create_wp_account'] : '';

        $locker_options['social']['is_linkedin_signin'] = $is_linkedin_signin_locker;
        $locker_options['social']['is_linkedin_save_email'] = $linkedin_signin_save_mail;
        $locker_options['social']['is_linkedin_create_account'] = $linkedin_create_wp_account;

        $is_paragraph_lock = isset($values['arsocialshare_display_lock_paragraph']) ? $values['arsocialshare_display_lock_paragraph'] : '';
        $paragraph_to_skip = isset($values['arsocialshare_paragraph_lock_number']) ? $values['arsocialshare_paragraph_lock_number'] : 1;

        $is_element_lock = isset($values['arsocialshare_display_lock_element']) ? $values['arsocialshare_display_lock_element'] : '';
        $elements_to_lock = isset($values['arsocialshare_element_lock_classes']) ? $values['arsocialshare_element_lock_classes'] : '';

        $is_category_lock = isset($values['arsocialshare_display_lock_category']) ? $values['arsocialshare_display_lock_category'] : '';
        $categories_to_lock = isset($values['arsocialshare_element_lock_categories']) ? implode(',', $values['arsocialshare_element_lock_categories']) : '';

        $is_tag_lock = isset($values['arsocialshare_display_lock_tag']) ? $values['arsocialshare_display_lock_tag'] : '';
        $tags_to_lock = isset($values['arsocialshare_element_lock_tags']) ? $values['arsocialshare_element_lock_tags'] : '';

        if ($is_paragraph_lock && $is_paragraph_lock != '') {
            $locker_options['batch_lock']['is_paragraph_lock'] = true;
            $locker_options['batch_lock']['skip_paragraph'] = $paragraph_to_skip;
        }

        if ($is_element_lock && $is_element_lock != '') {
            $locker_options['batch_lock']['is_element_lock'] = true;
            $locker_options['batch_lock']['class_elements'] = $elements_to_lock;
        }

        if ($is_category_lock && $is_category_lock !== '') {
            $locker_options['batch_lock']['is_category_lock'] = true;
            $locker_options['batch_lock']['categories'] = $categories_to_lock;
        }

        if ($is_tag_lock && $is_tag_lock !== '') {
            $locker_options['batch_lock']['is_tag_lock'] = true;
            $locker_options['batch_lock']['tags'] = $tags_to_lock;
        }


        $display_option = array();
        $display_option['locker_template'] = isset($values['arsocialshare_global_locker_templates']) ? $values['arsocialshare_global_locker_templates'] : 'default';
        $display_option['overlap_mode'] = isset($values['arsocial_lite_locker_overlap_mode']) ? $values['arsocial_lite_locker_overlap_mode'] : 'full';
        $bg_color = isset($values['arsocialshare_locker_bgcolor']) ? $values['arsocialshare_locker_bgcolor'] : '';
        $text_color = isset($values['arsocialshare_locker_textcolor']) ? $values['arsocialshare_locker_textcolor'] : '';
        $display_option['arsocialshare_locker_bgcolor'] = $bg_color;
        $display_option['arsocialshare_locker_textcolor'] = $text_color;

        $enable_pages = (isset($values['arsocialshare_enable_pages']) && $values['arsocialshare_enable_pages'] !== '') ? $values['arsocialshare_enable_pages'] : '';
        if (!empty($enable_pages)) {
            $display_option['pages']['enable'] = 'true';
            $display_option['pages']['exclude'] = (isset($values['arsocialshare_display_locker_page_exclude']) && $values['arsocialshare_display_locker_page_exclude'] !== '' ) ? $values['arsocialshare_display_locker_page_exclude'] : '';
        }

        $enable_posts = (isset($values['arsocialshare_enable_posts']) && $values['arsocialshare_enable_posts'] !== '') ? $values['arsocialshare_enable_posts'] : '';
        if (!empty($enable_posts)) {
            $display_option['posts']['enable'] = 'true';
            $display_option['posts']['excerpt'] = (isset($values['arsocialshare_enable_post_excerpt']) && $values['arsocialshare_enable_post_excerpt'] !== '' ) ? $values['arsocialshare_enable_post_excerpt'] : '';
            $display_option['posts']['exclude'] = (isset($values['arsocialshare_posts_excludes']) && $values['arsocialshare_posts_excludes'] !== '' ) ? $values['arsocialshare_posts_excludes'] : '';
        }

        /* for special pages */
        $special_pages = $arsocial_lite->arsocialshare_wp_special_pages();
        $display_option['selected_special_page']['selected_pages'] = array();
        foreach ($special_pages as $key => $value) {
            if (isset($values['arsocialshare_display_fan_special_page_' . $key])) {
                array_push($display_option['selected_special_page']['selected_pages'], $key);
            }
        }

        $locker_options['display'] = $display_option;

        $locker_options = maybe_serialize($locker_options);

        update_option('arslite_locker_display_settings', $locker_options);

        echo json_encode(array('message' => esc_html__('Settings Saved Successfully', 'arsocial_lite')));
        die();
    }

    function arsocial_lite_locker_filtered_content($content) {
        if (is_admin() || !is_singular()) {
            return $content;
        }

        $settings = maybe_unserialize(get_option('arslite_locker_display_settings'));

        $changed_content = "";

        $post_id = get_the_ID();

        if ($post_id === '') {
            return $content;
        } else {
            if (empty($settings)) {
                return $content;
            } else {
                if (empty($settings['social']) && empty($settings['display'])) {
                    return $content;
                } else {

                    $post_type = get_post_type($post_id);
                    $exclude_post_id = array();
                    if (isset($settings['display']['posts']) || isset($settings['display']['pages'])) {
                        if ($post_type == 'page' && isset($settings['display']['pages'])) {
                            $exclude_post_id = explode(',', $settings['display']['pages']['exclude']);
                        }
                        if ($post_type == 'post' && isset($settings['display']['posts'])) {
                            $exclude_post_id = explode(',', $settings['display']['posts']['exclude']);
                        }
                        if (in_array($post_id, $exclude_post_id)) {
                            return $content;
                        }
                    }

                    $display_settings = $settings['display'];
                    $batch_lock = isset($settings['batch_lock']) ? $settings['batch_lock'] : array();
                    $isPageLocker = ($post_type == 'page' && array_key_exists('pages', $display_settings)) ? true : false;
                    $isPostLocker = ($post_type == 'post' && array_key_exists('posts', $display_settings)) ? true : false;

                    if ($isPageLocker || $isPostLocker) {
                        $paragraph_lock = isset($batch_lock['is_paragraph_lock']) ? $batch_lock['is_paragraph_lock'] : false;
                        $skipNumber = isset($batch_lock['skip_paragraph']) ? $batch_lock['skip_paragraph'] : '';
                        $element_lock = isset($batch_lock['is_element_lock']) ? $batch_lock['is_element_lock'] : false;
                        $elements = isset($batch_lock['class_elements']) ? $batch_lock['class_elements'] : '';
                        $category_lock = isset($batch_lock['is_category_lock']) ? $batch_lock['is_category_lock'] : false;
                        $categories_to_lock = isset($batch_lock['categories']) ? explode(',', $batch_lock['categories']) : array();
                        $tag_lock = isset($batch_lock['is_tag_lock']) ? $batch_lock['is_tag_lock'] : '';
                        $tags_to_lock = isset($batch_lock['tags']) ? explode(',', $batch_lock['tags']) : array();
                        $hidden_content = "";
                        $lockerFlag = false;
                        $is_tag_or_category_lock = false;

                        if ($category_lock) {
                            $current_page_categories = array();
                            $x = 0;
                            foreach (get_the_category() as $key => $value) {
                                $current_page_categories[$x] = $value->term_id;
                                $x++;
                            }
                            $result = array_intersect($current_page_categories, $categories_to_lock);
                            if (count($result) > 0) {
                                $lockerFlag = true;
                                $hidden_content = $content;
                                $is_tag_or_category_lock = true;
                            }
                        }
                        if ($tag_lock) {
                            $current_post_tags = array();
                            $post_id = get_the_ID();
                            $post_tags = wp_get_post_tags($post_id);
                            $x = 0;
                            foreach ($post_tags as $post_tag) {
                                $current_post_tags[$x] = $post_tag->name;
                                $x++;
                            }
                            $result = array_intersect($current_post_tags, $tags_to_lock);
                            if (count($result) > 0) {
                                $lockerFlag = true;
                                $hidden_content = $content;
                                $is_tag_or_category_lock = true;
                            }
                        }

                        if ($paragraph_lock && ($is_tag_or_category_lock == false)) {
                            if (!empty($skipNumber) && $skipNumber > 0) {
                                $counter = 0;
                                $offset = 0;
                                while (preg_match('/[^\s]+((<\/p>)|(\n\r){2,}|(\r\n){2,}|(\n){2,}|(\r){2,})/i', $content, $matches, PREG_OFFSET_CAPTURE, $offset)) {
                                    $counter++;
                                    $offset = $matches[0][1] + strlen($matches[0][0]);
                                    if ($counter == $skipNumber) {
                                        $beforeShortcode = substr($content, 0, $offset);
                                        $insideShortcode = substr($content, $offset);

                                        $changed_content .= $beforeShortcode;
                                        $hidden_content .= $insideShortcode;
                                        $lockerFlag = true;
                                        break;
                                    }
                                }
                            }
                        }
                        $count = 0;
                        if ($element_lock && ($is_tag_or_category_lock == false)) {
                            $elements = explode(',', $elements);
                            if (!empty($elements)) {
                                //$lockerFlag = true;
                                $changed_content .= "<style type='text/css'>";
                                $count = 0;
                                foreach ($elements as $key => $element) {
                                    preg_match_all("/(class)\=(\'|\")({$element})(\"|\')/", $content, $matches);

                                    if (isset($matches[3]) && count($matches[3]) > 0) {
                                        $count++;
                                    }
                                    $classname = trim($element);
                                    $changed_content .= ".{$classname}{";
                                    $changed_content .= "display:none;";
                                    $changed_content .= "}";
                                }

                                if ($count > 0) {
                                    $lockerFlag = true;
                                }
                                $changed_content .= "</style>";
                            }
                        }

                        if ($element_lock == true && ($count > 0) && $paragraph_lock == false && $is_tag_or_category_lock == false) {
                            $changed_content .= $content;
                        }

                        if ($lockerFlag) {
                            $changed_content .= "<div class='arsocial_lite_locker_settings'>";
                            $shortcode_content = "[ARSocial_Lite_Locker id=global_settings]{$hidden_content}[/ARSocial_Lite_Locker]";
                            $changed_content .= do_shortcode($shortcode_content);
                            $changed_content .= "</div>";
                            $changed_content .= "<input type='hidden' name='ars_batch_lock_opts' id='ars_batch_lock_opts' value='" . json_encode($batch_lock) . "' />";
                        } else {
                            $changed_content .= $content;
                        }
                    } else {
                        $changed_content .= $content;
                    }
                }
            }
        }

        return $changed_content;
    }

    function arsGetTagsWithClass($tag = '', $class = '', $content = '') {
        $tagContents = array();
        $dom = new DOMDocument;
        @$dom->loadHTML($content);
        $tags = $dom->getElementsByTagName($tag);
        foreach ($tags as $div) {
            if ($div->hasAttribute('class') && strpos($div->getAttribute('class'), $class) !== false) {
                $tagContents[] = $div->nodeValue;
            }
        }
        return $tagContents;
    }

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

    function arsocial_lite_filtered_excerpt($content) {
        return $content;
    }

    function arsocial_lite_save_locker_order() {
        $type = isset($_POST['type']) ? $_POST['type'] : 'share';

        $options = isset($_POST['arsocial_lite_locker_share_network']) ? $_POST['arsocial_lite_locker_share_network'] : array();
        $options_signin = isset($_POST['arsocial_lite_locker_signin_network']) ? $_POST['arsocial_lite_locker_signin_network'] : array();

        if ((isset($options) && !empty($options)) || (isset($options_signin) && !empty($options_signin))) {
            if ($type === 'share') {
                $positions = maybe_serialize($options);
                update_option('arslite_sharing_locker_order', $positions);
            }
            if ($type === 'signin') {
                $positions = maybe_serialize($options_signin);
                update_option('arslite_signin_locker_order', $positions);
            }
        }

        die();
    }

    function arsocialshare_signin_locker_view($value = '', $id = '', $locker_social = array(), $global_settings = array()) {
        $locker_view = '';
        if ($value === '' || $id === '' || empty($locker_social) || empty($global_settings)) {
            return $locker_view;
        }

        switch ($value) {
            case 'facebook':
                if ($locker_social['is_fb_signin']) {

                    $locker_view.= '<div class="ars_locker_native_btn_wrapper ars_locker_native_facebook_wrapper">';
                    $locker_view.= '<span class="ars_native_button_icon socialshare-facebook"></span>';
                    $locker_view.= '<span class ="ars_native_label ars_native_facebook_label">' . esc_html__('Login', 'arsocial_lite') . '</span>';
                    $locker_view.= '</div>';

                    $locker_view .= "<div id='arsocial_lite_locker_signin_facebook_button' class='arsocial_lite_locker_button_wrapper arsocialshore_locker_fb_login_wrapper arsocial_lite_locker_signin_facebook_button' data-ng-controller='arsociallitelockerfblogin'><div class='arsocial_lite_locker_btn_inner_wrapper'><div class='arsocialshare_social_btn' data-id='ars_locker_{$id}' fblogin>";
                    $locker_view .= "<div class='facebook-custom-login-button' ng-click='arsocialshare_fb_login()'>&nbsp;</div>";
                    $locker_view .= "</div></div></div>";
                }
                break;
            case 'twitter':
                if ($locker_social['is_twitter_signin']) {
                    require_once (ARSOCIAL_LITE_CLASS_DIR . '/libs/twitter/twitteroauth.php');

                    @define('TWITTER_CONSUMER_KEY', $global_settings['twitter']['twitter_api_key']);
                    @define('TWITTER_CONSUMER_SECRET', $global_settings['twitter']['twitter_api_secret']);
                    $CALLBACK_URL = home_url() . '?locker_id=' . $id . '&ars_twitter=ars_twitter_signin';
                    @define('TWITTER_OAUTH_CALLBACK', $CALLBACK_URL);

                    if (TWITTER_CONSUMER_KEY && TWITTER_CONSUMER_SECRET) {
                        $Twitter = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);

                        $request_token = $Twitter->getRequestToken(TWITTER_OAUTH_CALLBACK);

                        $_SESSION['oauth_token'] = isset($request_token['oauth_token']) ? $request_token['oauth_token'] : '';
                        $_SESSION['oauth_token_secret'] = isset($request_token['oauth_token_secret']) ? $request_token['oauth_token_secret'] : '';

                        $auth_url = $Twitter->getAuthorizeURL($request_token['oauth_token']);

                        $locker_view.= '<div class="ars_locker_native_btn_wrapper ars_locker_native_twitter_wrapper">';
                        $locker_view.= '<span class="ars_native_button_icon socialshare-twitter"></span>';
                        $locker_view.= '<span class ="ars_native_label ars_native_twitter_label">' . esc_html__('Sign in', 'arsocial_lite') . '</span>';
                        $locker_view.= '</div>';

                        $locker_view .= "<div id='arsocial_lite_locker_signin_twitter_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_twitter_login_wrapper arsocial_lite_locker_signin_twitter_button' data-ng-controller='arsociallitelockertwitterlogin'><div class='arsocial_lite_locker_btn_inner_wrapper'><div class='arsocialshare_social_btn' data-id='ars_locker_{$id}' twitterlogin>";
                        $locker_view .= "<div class='twitter-custom-login-button' data-url='" . $auth_url . "' ng-click='arsocialshare_twitter_login(\"" . $auth_url . "\")' style='display:block;'>&nbsp</div>";
                        $locker_view .= "</div></div></div>";
                    }
                }
                break;
                case 'linkedin':
                    $label = isset( $locker_social['linkedin_signin_button_label'] ) ? $locker_social['linkedin_signin_button_label'] : esc_html__( 'Sign in', 'arsocial_lite' );
                    if ( $locker_social['is_linkedin_signin'] ) {
    
                        $general_options = get_option( 'arsocial_lite_global_settings' );
                        $gs_options      = maybe_unserialize( $general_options );
    
                        $client_id     = base64_encode( $gs_options['linkedin']['linkedin_api_key'] );
                        $client_secret = base64_encode( $gs_options['linkedin']['linkedin_client_secret'] );
    
                        $locker_view  .= '<div class="ars_locker_native_btn_wrapper ars_locker_native_linkedin_wrapper">';
                        $locker_view  .= '<span class="ars_native_button_icon socialshare-linkedin"></span>';
                        $locker_view  .= '<span class ="ars_native_label ars_native_linkedin_label">' . $label . '</span>';
                        $locker_view  .= '</div>';
                        $random_string = ars_generate_random_string( 8 );
                        $locker_view  .= '<input type="hidden" id="linkedin_access_token_' . $random_string . '"  />';
                        $locker_view  .= '<input type="hidden" id="linkedin_redirect_uri_' . $random_string . '" value="' . home_url() . '?action=ars_linkedin_callback' . '" />';
                        $locker_view  .= "<div id='arsociallocker_signin_linkedin_button' class='arsocialshare_locker_button_wrapper arsocialshore_locker_linkedin_login_wrapper arsociallocker_signin_linkedin_button' data-ng-controller='arsociallockerlinkedinlogin'><div class='arsocialshare_locker_btn_inner_wrapper'><div id='ars_locker_{$id}' data-linkedinlogin>";
                        $locker_view  .= "<div class='linkedin-custom-login-button' data-ng-click='arsocialshare_linked_login(\"$client_id\",\"$client_secret\",\"$random_string\")' style=''>&nbsp;</div>";
                        $locker_view  .= '</div>';
                        $locker_view  .= '</div>';
                        $locker_view  .= '</div>';
                    }
                    break;
            case 'email':
                break;
        }
        if (!empty($locker_view)) {
            $locker_view = '<div class="ars_locker_btn_container ars_locker_btn_container_signin"><div class="ars_locker_btn_wrapper">' . $locker_view . '</div></div>';
        }
        return $locker_view;
    }

    function arsocialshare_sharing_locker_view($value, $id, $locker_social, $global_settings, $locker_opts) {
        $locker_view = '';
        if ($value === '' || $id === '' || empty($locker_social) || empty($global_settings)) {
            return $locker_view;
        }
        $currentUrl = get_permalink();
        switch ($value) {
            case 'facebook_like':
                if ($locker_social['is_fb_like']) {
                    $btn_layout = ($locker_social['is_fb_counter']) ? 'button_count' : 'button';

                    $locker_view.= '<div class="ars_locker_native_btn_wrapper ars_locker_native_facebook_wrapper">';
                    $locker_view.= '<span class="ars_native_button_icon socialshare-facebook"></span>';
                    $locker_view.= '<span class ="ars_native_label ars_native_facebook_label">' . esc_html__('Like', 'arsocial_lite') . '</span>';
                    $locker_view.= '</div>';

                    $locker_view .= "<div id='arsocial_lite_locker_share_facebook_like_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_fb_wrapper arsocial_lite_locker_share_facebook_like_button' data-ng-controller='arsociallitelockerfb'><div class='arsocial_lite_locker_btn_inner_wrapper'><div data-id='ars_locker_{$id}' class='arsocialshare_social_btn' data-fblike>";
                    $locker_social['fb_like_url'] = (!empty($locker_social['fb_like_url'])) ? $locker_social['fb_like_url'] : $currentUrl;
                    $locker_view .= "<div class='fb-like' data-href='{$locker_social['fb_like_url']}' data-layout='{$btn_layout}' data-action='like' data-show-faces='false' data-share='false'>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div></div>";
                }
                break;
            case 'twitter_tweet':
                if ($locker_social['is_tw_locker']) {
                    $locker_view.= '<div class="ars_locker_native_btn_wrapper ars_locker_native_twitter_wrapper">';
                    $locker_view.= '<span class="ars_native_button_icon socialshare-twitter"></span>';
                    $locker_view.= '<span class ="ars_native_label ars_native_twitter_label">' . esc_html__('Tweet', 'arsocial_lite') . '</span>';
                    $locker_view.= '</div>';

                    $locker_view .= "<div id='arsocial_lite_locker_share_twitter_tweet_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_tw_wrapper arsocial_lite_locker_share_twitter_tweet_button' data-ng-controller='arsociallitelockertw'><div class='arsocial_lite_locker_btn_inner_wrapper'><div data-id='ars_locker_{$id}' class='arsocialshare_social_btn' data-twtweet>";
                    $locker_view .= "<a href='https://twitter.com/share' class='twitter-share-button' ";
                    $locker_social['tweet_url'] = (!empty($locker_social['tweet_url'])) ? $locker_social['tweet_url'] : $currentUrl;
                    $locker_view .= " data-url='{$locker_social['tweet_url']}'";
                    if ($locker_social['tweet_txt'] !== '') {
                        $locker_view .= " data-text='{$locker_social['tweet_txt']}'";
                    } else {
                        $locker_view .= " data-text='" . get_the_title() . ' ' . get_permalink() . "'";
                    }
                    if ($locker_social['tweet_via'] !== '') {
                        $locker_view .= " data-via='{$locker_social['tweet_via']}'";
                    }
                    $locker_view .= " >Tweet</a>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                }
                break;
            case 'facebook_share':
                if ($locker_social['is_fb_share']) {
                    $layout = ($locker_social['is_fb_share_counter'] == 1) ? 'button_count' : 'button';
                    $locker_view.= '<div class="ars_locker_native_btn_wrapper ars_locker_native_facebook_wrapper">';
                    $locker_view.= '<span class="ars_native_button_icon socialshare-facebook"></span>';
                    $locker_view.= '<span class ="ars_native_label ars_native_facebook_label">' . esc_html__('Share', 'arsocial_lite') . '</span>';
                    $locker_view.= '</div>';
                    $locker_view .= "<div id='arsocial_lite_locker_share_facebook_share_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_fbshare_wrapper arsocial_lite_locker_share_facebook_share_button' data-ng-controller='arsociallitelockerfbshare'>";
                    $locker_view .= "<div class='arsocial_lite_locker_btn_inner_wrapper'>";
                    $locker_view .= "<div class='arsocialshare_social_btn' data-id='ars_locker_{$id}' fb-share>";
                    $locker_social['fb_share_url'] = (!empty($locker_social['fb_share_url'])) ? $locker_social['fb_share_url'] : $currentUrl;
//                    $locker_view .= "<div class='fb-share-button' data-href='{$locker_social['fb_share_url']}' data-layout='{$layout}' data-action='like' data-show-faces='false' data-share='false'>";

                    $locker_view .="<div class='fb-share-button' data-href='{$locker_social['fb_share_url']}' data-layout='{$layout}' data-size='small' data-mobile-iframe='true'><a class='fb-xfbml-parse-ignore' target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=" . urlencode((!empty($locker_social['fb_share_url'])) ? $locker_social['fb_share_url'] : $currentUrl) . "'>Share</a></div>";
//                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                }
                break;
            case 'twitter_follow':
                if ($locker_social['is_tw_follow'] && !empty($locker_social['tw_follow_url'])) {

                    $locker_view.= '<div class="ars_locker_native_btn_wrapper ars_locker_native_twitter_wrapper">';
                    $locker_view.= '<span class="ars_native_button_icon socialshare-twitter"></span>';
                    $locker_view.= '<span class ="ars_native_label ars_native_twitter_label">' . esc_html__('Follow', 'arsocial_lite') . '</span>';
                    $locker_view.= '</div>';
                    $locker_view .= "<div id='arsocial_lite_locker_share_twitter_follow_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_tw_follow_wrapper arsocial_lite_locker_share_twitter_follow_button' data-ng-controller='arsociallitelockertwfollow'><div class='arsocial_lite_locker_btn_inner_wrapper'><div class='arsocialshare_social_btn' data-id='ars_locker_{$id}' tw-follow>";
                    $locker_view .= "<a href='https://twitter.com/{$locker_social['tw_follow_url']}' class='twitter-follow-button' ";
                    if (!$locker_social['show_tw_username']) {
                        $locker_view .= " data-show-screen-name='false'";
                    }
                    if ($locker_social['show_tw_follow_cntr']) {
                        $locker_view .= " data-show-count='true' ";
                    } else {
                        $locker_view .= " data-show-count='false' ";
                    }

                    $locker_view .= " >Follow ";
                    $username = str_replace('https://twitter.com/', '', $locker_social['tw_follow_url']);
                    $username = str_replace('http://twitter.com/', '', $locker_social['tw_follow_url']);
                    $locker_view .= "@$username";
                    $locker_view .= "</a></div></div></div>";
                }
                break;
            case 'linkedin_share':
                if ($locker_social['is_linkedin_share']) {
                    $locker_view .= "<script type='text/javascript' src='//platform.linkedin.com/in.js'>\n"
                            . "api_key:{$global_settings['linkedin']['linkedin_api_key']}\n"
                            . "authorize:true\n"
                            . "</script>";

                    $locker_view.= '<div class="ars_locker_native_btn_wrapper ars_locker_native_linkedin_wrapper">';
                    $locker_view.= '<span class="ars_native_button_icon socialshare-linkedin"></span>';
                    $locker_view.= '<span class ="ars_native_label ars_native_linkedin_label">Linkedin</span>';
                    $locker_view.= '</div>';

                    $locker_view .= "<div id='arsocial_lite_locker_share_linkedin_share_button' class='arsocial_lite_locker_button_wrapper arsocial_lite_locker_linkedin_wrapper arsocial_lite_locker_share_linkedin_share_button' data-ng-controller='arsociallitelockerlinkedinshare'>";
                    $locker_view .= "<div class='arsocial_lite_locker_btn_inner_wrapper'>";
                    $locker_view .= "<div class='arsocialshare_social_btn' data-id='ars_locker_{$id}' in-share>";
                    $locker_social['linkedin_url_share'] = (!empty($locker_social['linkedin_url_share'])) ? $locker_social['linkedin_url_share'] : $currentUrl;
                    $locker_view .= "<div class='linkedin-custom-share-button' data-href='{$locker_social['linkedin_url_share']}' ng-click='linkedinshareclick(\"" . $locker_social['linkedin_url_share'] . "\")'>&nbsp</div>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                    $locker_view .= "</div>";
                }
                break;
            default:
                $locker_view .= '';
                break;
        }
        if (!empty($locker_view)) {
            $locker_view = '<div class="ars_locker_btn_container"><div class="ars_locker_btn_wrapper">' . $locker_view . '</div></div>';
        }
        return $locker_view;
    }

    function ars_locker_css($id, $locker_theme, $ars_wrapper_bg_color, $ars_wrapper_textcolor_color) {
        $return = '';
        switch ($locker_theme) {
            case 'default':

                $return .= '.arsocial_lite_locker_' . $id . '.arsocial_lite_locker_main_wrapper.arsocial_lite_locker_default_theme .arsocial_lite_locker_popup_inner{background-color : ' . $ars_wrapper_bg_color . '; }';

                $return .= '.arsocial_lite_locker_' . $id . '.arsocial_lite_locker_main_wrapper.arsocial_lite_locker_default_theme .arsocial_lite_locker_popup_title,.arsocial_lite_locker_' . $id . '.arsocial_lite_locker_main_wrapper .arsocial_lite_locker_popup_content{color : ' . $ars_wrapper_textcolor_color . '; }';
                break;
            case 'glass':
                $bgcolor = $this->hex2rgb($ars_wrapper_bg_color);

                $new_color = "rgba({$bgcolor['red']},{$bgcolor['green']},{$bgcolor['blue']},0.6)";
                $new_color_outer = "rgba({$bgcolor['red']},{$bgcolor['green']},{$bgcolor['blue']},0.2)";

                $return .= '.arsocial_lite_locker_' . $id . '.arsocial_lite_locker_main_wrapper.arsocial_lite_locker_glass_theme .arsocial_lite_locker_popup_inner{background-color : ' . $new_color_outer . '; }';
                $return .= '.arsocial_lite_locker_' . $id . '.arsocial_lite_locker_main_wrapper.arsocial_lite_locker_glass_theme .arsocial_lite_locker_popup_inner_wrapper{background-color : ' . $new_color . '; }';

                $return .= '.arsocial_lite_locker_' . $id . '.arsocial_lite_locker_main_wrapper.arsocial_lite_locker_glass_theme .arsocial_lite_locker_popup_title,.arsocial_lite_locker_' . $id . '.arsocial_lite_locker_main_wrapper .arsocial_lite_locker_popup_content{color : ' . $ars_wrapper_textcolor_color . '; }';
                break;
        }
        return $return;
    }

    function hex2rgb($colour) {

        if (isset($colour[0]) && $colour[0] == '#') {
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
    function ars_locker_default_color() {
        $ruturn_array = array();
        $ruturn_array = apply_filters('ars_locker_default_color', array(
            'default' => array(
                'bg_color' => '#f5f6f9',
                'text_color' => '#1a1a1a',
                'button_color' => '#c5c5c5',
                'gradient_start_color' => '#c9c9c9',
                'gradient_end_color' => '#c9c9c9',
            ),
            'zip' => array(
                'bg_color' => '#ffffff',
                'text_color' => '#1a1a1a',
                'button_color' => '#c5c5c5',
                'gradient_start_color' => '#c9c9c9',
                'gradient_end_color' => '#c9c9c9',
            ),
            'clean' => array(
                'bg_color' => '#f6fbfd',
                'text_color' => '#373c74',
                'button_color' => '#1db8ff',
                'gradient_start_color' => '#c9c9c9',
                'gradient_end_color' => '#c9c9c9',
            ),
            'glass' => array(
                'bg_color' => '#fafafa',
                'text_color' => '#1a1a1a',
                'button_color' => '#c5c5c5',
                'gradient_start_color' => '#c9c9c9',
                'gradient_end_color' => '#c9c9c9',
            ),
            'secret' => array(
                'bg_color' => '#f7f7f7',
                'text_color' => '#1a1a1a',
                'button_color' => '#c5c5c5',
                'gradient_start_color' => '#c9c9c9',
                'gradient_end_color' => '#c9c9c9',
            ),
            'gradient' => array(
                'bg_color' => '#c5c5c5',
                'text_color' => '#c5c5c5',
                'button_color' => '#c5c5c5',
                'gradient_start_color' => '#252d88',
                'gradient_end_color' => '#425db6',
            ),
            'flat' => array(
                'bg_color' => '#ffffff',
                'text_color' => '#1a1a1a',
                'button_color' => '#c5c5c5',
                'gradient_start_color' => '#c9c9c9',
                'gradient_end_color' => '#c9c9c9',
            ),
                )
        );
        return $ruturn_array;
    }
}

?>