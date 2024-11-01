<?php

class ARSocial_Lite_Counter {

    function __construct() {

        add_action('wp_ajax_ars_lite_update_static_share_counter', array($this, 'ars_lite_update_static_share_counter'));
        add_action('wp_ajax_nopriv_ars_lite_update_static_share_counter', array($this, 'ars_lite_update_static_share_counter'));

        add_filter('arsocial_lite_total_share_counter', array($this, 'arsocialshare_total_share_counter'), 10, 6);
    }

    function ARSocialShareURLParser($url = '') {
        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );
    }

    function ARSocialShareGetFBShareCounter($share_url = '', $page_id, $options = '') {

        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );

        if ($share_url === '') {
            return 'success~0';
        }


        $url       = "https://graph.facebook.com/?id={$share_url}&fields=og_object{engagement}";

        $callfbapi = wp_remote_post($url, $arguments);


        if (is_wp_error($callfbapi)) {
            return 'success~0';
        } else {
            $counters = json_decode($callfbapi['body']);
            $fbcounter = $counters->og_object->engagement->count;
        }

        if (!isset($fbcounter) || $fbcounter == '') {
            $fbcounter = '0';
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_facebook', $fbcounter);
        $json_obj = json_decode(stripslashes_deep($options),true);

        $html = 'success~' . $fbcounter;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = isset($json_obj['no_format']) ? $json_obj['no_format'] : 'style5';
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetRedditShareCounter($share_url = '', $page_id, $options = '') {


        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );

        if ($share_url === '') {
            return 'success~0';
        }

        $url = 'https://www.reddit.com/api/info.json?url=' . $share_url;
        $response = wp_remote_post($url, $arguments);
        if (is_wp_error($response)) {
            return 'success~0';
        } else {
            $body = json_decode($response['body']);
            $redcounter = $body->data->children[0]->data->score;
        }

        if (!isset($redcounter) || $redcounter == '') {
            $redcounter = '0';
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_reddit', $redcounter);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $redcounter;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetBufferShareCounter($share_url = '', $page_id, $options = '') {


        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );

        if ($share_url === '') {
            return 'success~0';
        }

        $url = 'https://api.bufferapp.com/1/links/shares.json?url=' . $share_url;
        $response = wp_remote_post($url, $arguments);

        if (is_wp_error($response)) {
            return 'success~0';
        } else {
            $body = json_decode($response['body']);
            $bcounter = $body->shares;
        }

        if (!isset($bcounter) || $bcounter == '') {
            $bcounter = '0';
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_buffer', $bcounter);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $bcounter;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetOdnoklassnikiShareCounter($share_url = '', $page_id, $options = '') {


        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );

        if ($share_url === '') {
            return 'success~0';
        }
        $okcounter = 0;
        $url = 'http://www.odnoklassniki.ru/dk?st.cmd=extLike&uid=odklcnt0&ref=' . $share_url;
        $response = wp_remote_post($url, $arguments);


        if (is_wp_error($response)) {
            return 'success~0';
        } else {
            try {
                $data = $response['body'];
                preg_match('/^ODKL\.updateCount\(\'odklcnt0\',\'(\d+)\'\);$/i', $data, $shares);
                $okcounter = (int) $shares[1];
            } catch (Exception $e) {
                return 'success~0';
            }
        }

        if (!isset($okcounter) || $okcounter == '') {
            $okcounter = '0';
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_odnoklassniki', $okcounter);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $okcounter;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetMeneameShareCounter($share_url = '', $page_id, $options = '') {


        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );

        if ($share_url === '') {
            return 'success~0';
        }

        $url = 'http://meneame.net/api/url.php?url=' . $share_url;

        $response = wp_remote_post($url, $arguments);

        $data = $response['body'];

        if (is_wp_error($response)) {
            return 'success~0';
        } else {

            $data_lines = explode("\n", trim($data));
            $data_lines = explode(" ", trim($data));
            $mncounter = isset($data_lines[2]) ? $data_lines[2] : '';
        }


        if (!isset($mncounter) || $mncounter == '') {
            $mncounter = '0';
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_meneame', $mncounter);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $mncounter;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetViadeoShareCounter($share_url = '', $page_id, $options = '') {

        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );

        if ($share_url === '') {
            return 'success~0';
        }

        $url = 'https://api.viadeo.com/recommend?url=' . $share_url . '&format=json';

        $response = wp_remote_post($url, $arguments);

        $data = $response['body'];

        if (is_wp_error($response)) {
            return 'success~0';
        } else {
            $res = json_decode($data);
            if ($res->count) {
                $vdcounter = $res->count;
            } else {
                $vdcounter = 0;
            }
        }

        if (!isset($vdcounter) || $vdcounter == '') {
            $vdcounter = '0';
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_viadeo', $vdcounter);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $vdcounter;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetVKShareCounter($share_url = '', $page_id, $options = '') {
        $arguments = array(
            'method' => 'GET',
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => null,
        );
        if ($share_url === '') {
            return 'success~0';
        }

        $url = 'http://vk.com/share.php?act=count&url=' . $share_url . '';

        $response = wp_remote_post($url, $arguments);

        $data = $response['body'];

        if (is_wp_error($response)) {
            return 'success~0';
        } else {
            $data = str_replace('VK.Share.count(', '', $data);
            $data = str_replace(');', '', $data);
            $data = explode(',', $data);
            $vkcounter = trim($data[1]);
        }

        if (!isset($vkcounter) || $vkcounter == '') {
            $vkcounter = 0;
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_vk', $vkcounter);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $vkcounter;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetTwitterShareCounter($url, $page_id) {

        $global_settings = maybe_unserialize(get_option('arslite_global_settings'));

        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=' . $url;
        $requestMethod = 'GET';

        $settings = array(
            'oauth_access_token' => $global_settings['twitter']['twitter_access_token'],
            'oauth_access_token_secret' => $global_settings['twitter']['twitter_access_token_secret'],
            'consumer_key' => $global_settings['twitter']['twitter_api_key'],
            'consumer_secret' => $global_settings['twitter']['twitter_api_secret'],
        );
        require_once (ARSOCIAL_LITE_CLASS_DIR . '/libs/twitter/TwitterAPIExchange.php');
        $twitter = new ARSTwitterAPIExchange($settings);
        $result = $twitter->setGetfield($getfield)
                ->buildOauth($url, $requestMethod)
                ->performRequest();

        $result = json_decode($result);

        if (isset($result->search_metadata->count)) {
            $count = $result->search_metadata->count;
        } else {
            $count = "0";
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_twitter', $count);
        echo 'success~' . $count;
        die();
    }

    function ARSocialShareGetPocketShareCounter($url, $page_id, $options = '') {

        $remote_url = sprintf('https://widgets.getpocket.com/v1/button?align=center&count=vertical&label=pocket&url=%s', urlencode($url));
        $data = wp_remote_get($remote_url);
        $data = wp_remote_retrieve_body($data);
        $shares = array();

        $count = 0;
        
        preg_match('/<em id="cnt">(.*?)<\/em>/s', $data, $shares);
                
        if (count($shares) > 0) {
            $count = $shares[1];
        } else {
            $count = '0';
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_pocket', $count);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $count;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ARSocialShareGetPinterestShareCounter($url, $page_id) {

        $api_url = 'http://api.pinterest.com/v1/urls/count.json?callback%20&url=';

        $check_url = $api_url . $url;

        $data = wp_remote_get($check_url);
        $data = wp_remote_retrieve_body($data);

        $data = str_replace("receiveCount(", "", $data);
        $data = str_replace(")", "", $data);
        $result = json_decode($data);

        if (isset($result->count)) {
            $count = $result->count;
        } else {
            $count = "0";
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_pinterest', $count);
        echo 'success~' . $count;
        die();
    }

    function ARSocialShareGetLinkedinShareCounter($url, $page_id, $options = '') {
        $socialsharecounter = maybe_unserialize(get_option('arslite_counters'));
        $result = wp_remote_get('http://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json');

        $result = wp_remote_retrieve_body($result);

        $result = json_decode($result);

        if (isset($result->count)) {
            $count = $result->count;
        } else {
            $count = "0";
        }

        $page_id = intval($page_id);
        update_post_meta($page_id, 'arscialshare_counter_linkedin', $count);
        $json_obj = json_decode(stripslashes_deep($options),true);
        $html = 'success~' . $count;
        $counter_data = array();
        $total_counter = "";
        if (!empty($json_obj)) {
            $counter_data['total_count_position'] = $json_obj['total_count_position'];
            $saved_value = $json_obj['saved_networks'];
            $networks = explode('|', $json_obj['networks']);
            $number_format = $json_obj['no_format'];
            $total_counter = $this->arsocialshare_total_share_only_counter($saved_value,$networks,$page_id,$number_format);
            $html .= '~'.$total_counter;
        }
        echo $html;
        die();
    }

    function ars_lite_update_static_share_counter() {
        global $wpdb, $blog_id;
        $page_id = isset($_POST["page_id"]) ? $_POST["page_id"] : '';
        $network = isset($_POST["network"]) ? $_POST["network"] : '';
        $page_id = intval($page_id);
        $current_value = get_post_meta($page_id, 'arscialshare_counter_' . $network, true);
        $current_value = intval($current_value) + 1;
        update_post_meta($page_id, 'arscialshare_counter_' . $network, $current_value);
        echo 'success~' . $network . '~' . $current_value;
        die();
    }

    function ARSocialShareXingShareCounter($url, $page_id) {

        $buttonURL = sprintf('https://www.xing-share.com/app/share?op=get_share_button;url=%s;counter=top;lang=en;type=iframe;hovercard_position=2;shape=rectangle', urlencode($url));

        $data = wp_remote_get($buttonURL);
        $data = wp_remote_retrieve_body($data);
        $shares = array();
        $count = 0;
        preg_match('/<span class="xing-count top">(.*?)<\/span>/s', $data, $shares);


        if (count($shares) > 0) {
            $current_result = $shares[1];

            $count = $current_result;
        }

        $page_id = intval($page_id);

        update_post_meta($page_id, 'arscialshare_counter_xing', $count);
        echo 'success~' . $count;
        die();
    }

    function arsocialshare_total_share_only_counter( $saved_value, $networks, $post_id, $number_format) {
        global $arsocial_lite_forms, $arsocial_lite;
        $total_counter = 0;
        $counter_networks = $arsocial_lite->ars_lite_share_networklist_sharecounter();
        if (!empty($networks)) {
            foreach ($networks as $key => $network) {
                if (isset($saved_value[$network]['enable']) && $saved_value[$network]['enable'] && in_array($network, $counter_networks)) {
                    $total_counter = $total_counter + $arsocial_lite_forms->get_counter($network, $post_id);
                }
            }
        }
        $total_counter_formated = $arsocial_lite_forms->ars_share_set_fan_counter($total_counter, $number_format);
        return $total_counter_formated;
    }

    function arsocialshare_total_share_counter($html, $counter_data, $saved_value, $networks, $post_id, $number_format) {
        global $arsocial_lite_forms, $arsocial_lite;
        if (empty($counter_data)) {
            return $html;
        }
        $newhtml = '';

        $total_counter = 0;
        $counter_networks = $arsocial_lite->ars_lite_share_networklist_sharecounter();

        if (!empty($networks)) {
            foreach ($networks as $key => $network) {
                if (isset($saved_value[$network]['enable']) && $saved_value[$network]['enable'] && in_array($network, $counter_networks)) {
                    $total_counter = $total_counter + $arsocial_lite_forms->get_counter($network, $post_id);
                }
            }
        }
        $total_counter_formated = $arsocial_lite_forms->ars_share_set_fan_counter($total_counter, $number_format);
        $counter_label = $counter_data['total_counter_label'];
        $counter_position = $counter_data['total_count_position'];
        $newhtml .= "<div class='arsocialshare_total_counter_wrapper ars_{$counter_position}'>";
        $newhtml .= "<div class='arsocialshare_counter_value ars_animate_counter' data-count='$total_counter_formated' data-format='{$number_format}'>";
        $newhtml .= $total_counter_formated;
        $newhtml .= "</div>";
        $newhtml .= "<div class='arsocialshare_counter_label'>";
        $newhtml .= $counter_label;
        $newhtml .= "</div>";
        $newhtml .= "</div>";
        return $newhtml;
    }
}
?>