<?php
/**
 * Plugin Name: ARSocial Lite
 * Plugin URI: http://arsocial.arformsplugin.com/
 * Description: ARSocial is all in one plugin to achieve features like Social Share, Social Locker, Like/Follow/Subscribe and Fan Counter.
 * Version: 1.4.1
 * Author: Repute Infosystems
 * Author URI: http://www.reputeinfosystems.com
 * Text Domain: arsocial_lite
 */
/**
 * Define Plugin URL
 * 
 * @since v1.0
 */
if (is_ssl()) {
    define('ARSOCIAL_LITE_URL', str_replace('http://', 'https://', WP_PLUGIN_URL . '/social-share-and-social-locker-arsocial'));
} else {
    define('ARSOCIAL_LITE_URL', WP_PLUGIN_URL . '/social-share-and-social-locker-arsocial');
}

/**
 * Defining CONSTANT Variables and Plugin Textdomain
 * 
 * @since v1.0
 */
define('ARSOCIAL_LITE_DIR', WP_PLUGIN_DIR . '/social-share-and-social-locker-arsocial');
define('ARSOCIAL_LITE_CORE_DIR', ARSOCIAL_LITE_DIR . '/core');
define('ARSOCIAL_LITE_CSS_DIR', ARSOCIAL_LITE_DIR . '/css');
define('ARSOCIAL_LITE_JS_DIR', ARSOCIAL_LITE_DIR . '/js');
define('ARSOCIAL_LITE_INC_DIR', ARSOCIAL_LITE_DIR . '/inc');
define('ARSOCIAL_LITE_IMAGE_DIR', ARSOCIAL_LITE_DIR . '/images');
define('ARSOCIAL_LITE_CSS_URL', ARSOCIAL_LITE_URL . '/css');
define('ARSOCIAL_LITE_SCRIPT_URL', ARSOCIAL_LITE_URL . '/js');
define('ARSOCIAL_LITE_IMAGES_URL', ARSOCIAL_LITE_URL . '/images');
define('ARSOCIAL_LITE_CLASS_DIR', ARSOCIAL_LITE_CORE_DIR . '/classes');
define('ARSOCIAL_LITE_VIEWS_DIR', ARSOCIAL_LITE_CORE_DIR . '/views');
define('ARSOCIAL_LITE_THEME_CSS_DIR', ARSOCIAL_LITE_CSS_DIR . '/themes');
define('ARSOCIAL_LITE_THEME_CSS_URL', ARSOCIAL_LITE_CSS_URL . '/themes');

/**
 * Defining GLOBAL variables
 * 
 * @since v1.0
 */
global $arsocial_lite_version;
$arsocial_lite_version = '1.4.1';

global $arsocial_lite;
$arsocial_lite = new ARSocial_Lite();

global $ars_lite_default_networks;

global $arsocial_lite_forms;
if (file_exists(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_share.php')) {
    include ARSOCIAL_LITE_CLASS_DIR . '/class.ars_share.php';
    $arsocial_lite_forms = new ARSocial_Lite_Form();
}

global $arsocial_lite_counter;
if (file_exists(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_counter.php')) {
    include ARSOCIAL_LITE_CLASS_DIR . '/class.ars_counter.php';
    $arsocial_lite_counter = new ARSocial_Lite_Counter();
}

global $arsocial_lite_locker;
if (file_exists(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_locker.php')) {
    include(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_locker.php');
    $arsocial_lite_locker = new ARSocial_Lite_Locker();
}

global $arsocial_lite_like;
if (file_exists(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_like.php')) {
    include(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_like.php');
    $arsocial_lite_like = new ARSocial_Lite_LikeForm();
}

global $arsocial_lite_fan;
if (file_exists(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_fan_counter.php')) {
    include(ARSOCIAL_LITE_CLASS_DIR . '/class.ars_fan_counter.php');
    $arsocial_lite_fan = new ARSocial_Lite_Fan();
}

global $arsocial_lite_api_url, $arsocial_lite_plugin_slug, $wp_version, $ars_lite_has_total_counter;
$ars_lite_has_total_counter = false;

/**
 * Set Google Font URL.
 */
global $ars_lite_googlefontbaseurl;
if (is_ssl()) {
    $ars_lite_googlefontbaseurl = "https://fonts.googleapis.com/css?family=";
} else {
    $ars_lite_googlefontbaseurl = "http://fonts.googleapis.com/css?family=";
}

/**
 * Define Global Variables for Facebook API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_fb_api_url, $ars_lite_fb_api_version;

$ars_lite_fb_api_url = 'https://graph.facebook.com/';
$ars_lite_fb_api_version = 'v8.0';

/**
 * Define Global Variables for Linkedin API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_linkedin_api_url, $ars_lite_linkedin_api_version;

$ars_lite_linkedin_api_url = 'https://api.linkedin.com/';
$ars_lite_linkedin_api_version = 'v1';

/**
 * Define Global Variables for Instagram API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_instagram_api_url, $ars_lite_instagram_api_version;
$ars_lite_instagram_api_url = 'https://api.instagram.com/';
$ars_lite_instagram_api_version = 'v1';



/**
 * Define Global Variables for Youtube API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_youtube_api_url, $ars_lite_youtube_api_version;
$ars_lite_youtube_api_url = 'https://www.googleapis.com/youtube/';
$ars_lite_youtube_api_version = 'v3';

/**
 * Define Global Variables for Dribbble API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_dribbble_api_url, $ars_lite_dribbble_api_version;
$ars_lite_dribbble_api_url = 'https://api.dribbble.com/';
$ars_lite_dribbble_api_version = 'v1';

/**
 * Define Global Variables for VK API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_vk_api_url;
$ars_lite_vk_api_url = 'https://api.vk.com/';

/**
 * Define Global Variables for Foursquare API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_foursquare_api_url, $ars_lite_foursquare_api_version;
$ars_lite_foursquare_api_url = 'https://api.foursquare.com/';
$ars_lite_foursquare_api_version = 'v2';

/**
 * Define Global Variables for Github API URL
 * 
 * @since v1.0
 */
global $ars_lite_github_api_url;
$ars_lite_github_api_url = 'https://api.github.com/';

/**
 * Define Global Variables for Pinterst API URL
 * 
 * @since v1.0
 */
global $ars_lite_pinterest_api_url, $ars_lite_pinterest_api_version;
$ars_lite_pinterest_api_url = 'https://api.pinterest.com/';
$ars_lite_pinterest_api_version = 'v1';

/**
 * Define Global Variables for SoundCloud API URL 
 * 
 * @since v1.0
 */
global $ars_lite_soundcloud_api_url;
$ars_lite_soundcloud_api_url = 'http://api.soundcloud.com/';

/**
 * Define Global Variables for flickr API URL 
 * 
 * @since v1.0
 */
global $ars_lite_flickr_api_url;
$ars_lite_flickr_api_url = 'https://api.flickr.com/';

/**
 * Define Global Variables for Bitly API URL and version
 * 
 * @since v1.0
 */
global $ars_lite_bitly_api_url, $ars_lite_bitly_api_version;
$ars_lite_bitly_api_url = 'https://api-ssl.bitly.com/';
$ars_lite_bitly_api_version = 'v3';


/**
 * Define Global Variables for Vimeo API URL & Version
 * 
 * @since v1.0
 */
global $ars_lite_vimeo_api_url, $ars_lite_vimeo_api_url_chanel, $ars_lite_vimeo_api_version;
$ars_lite_vimeo_api_url = 'https://api.vimeo.com';
$ars_lite_vimeo_api_url_chanel = 'http://vimeo.com/api/';
$ars_lite_vimeo_api_version = 'v2';

global $ars_lite_is_plugin_debug;
$ars_lite_is_plugin_debug = 0;

/**
 * ARSocial Lite Main Class
 * 
 * @since v1.0
 */
class ARSocial_Lite {

    var $socialshare_main_page_slug = "arsocial_lite";
    var $socialshare_setting_page_slug = "arsocial-lite-display-settings";
    var $socialshare_shortcode_page_slug = "arsocial-lite-shortcode-generator";
    var $socialshare_locker_page_slug = "arsocial-lite-social-locker";
    var $socialshare_global_setting_page_slug = "arsocial-lite-global-settings";
    var $socialshare_like_page_slug = "arsocial-lite-like";
    var $socialshare_fan_counter_slug = "arsocial-lite-fan-counter";
    var $socialshare_display_setting_page_slug = "arsocial-lite-share-display-setting";
    var $socialshare_analytics_page_slug = "arsocial-lite-share-analytics";
    var $socialshare_locker_display_setting_page_slug = "arsocial-lite-locker-display-setting";
    var $socialshare_like_display_setting_page_slug = "arsocial-lite-like-display-setting";
    var $socialshare_fan_display_setting_page_slug = "arsocial-lite-fan-display-setting";
    var $socialshare_social_locker_analytics_slug = "arsocial-lite-locker-analytics";
    var $socialshare_social_fan_analytics_slug = "arsocial-lite-fan-analytics";
    var $socialshare_upgrade_to_premium_slug = "arsocial-lite-upgrade-to-premium";

    var $arslite_fan;
    var $arslite_like;
    var $arslite_locker;
    var $arslite_networks;
    /**
     * ARSocailShare Plugin Main Class Constructor
     * 
     * @since v1.0
     */
    function __construct() {
        global $wpdb;
        $this->arslite_networks = $wpdb->prefix . "arsocial_lite_networks";
        $this->arslite_locker       = $wpdb->prefix . "arsocial_lite_locker";
        $this->arslite_like         = $wpdb->prefix . "arsocial_lite_like";
        $this->arslite_fan          = $wpdb->prefix . "arsocial_lite_fan";


        register_activation_hook(__FILE__, array('ARSocial_Lite', 'ARSocial_Lite_Installer'));
        register_uninstall_hook(__FILE__, array('ARSocial_Lite', 'ARSocial_Lite_Uninstaller'));
        register_activation_hook(__FILE__, array('ARSocial_Lite', 'arsocial_lite_check_network_activation'));

        add_action('admin_init', array($this, 'ARSocial_Lite_CheckDB'));
        add_action('plugins_loaded', array($this, 'ARSocial_Lite_Load_TextDomain'));
        add_action('admin_menu', array($this, 'ARSocial_Lite_Menu'));
        add_filter('admin_footer_text', array($this, 'ARSocial_Lite_Remove_Footer'));
        add_filter('update_footer', array($this, 'ARSocial_Lite_Remove_Footer_Version'), '1234');
        add_action('admin_head', array($this, 'ARSocial_Lite_Remove_Notice'), 10000);
        add_action('init', array($this, 'arsocial_lite_settings'));
        add_action( 'init', array( $this, 'arsocialsharelite_linkedin_authorization' ) );
        add_action('arsocial_lite_show_networks', array($this, 'ARSocial_Lite_Plugin_Display_Networks'));
        add_action('arsocial_lite_display_sharing_settings', array($this, 'ARSocial_Lite_Plugin_Display_Sharing_Settings'));
        add_action('arsocial_lite_show_settings', array($this, 'ARSocial_Lite_Plugin_Display_Settings'));
        add_action('arsocial_lite_show_shortcode', array($this, 'ARSocial_Lite_Plugin_Shortcode_Generator'));

        add_action('arsocial_lite_locker_page', array($this, 'ARSocial_Lite_Plugin_Social_Locker'));
        add_action('arsocial_lite_display_locker_settings', array($this, 'ARSocial_Lite_Plugin_Social_Locker_Display_Settings'));
        add_action('arsocial_lite_display_like_settings', array($this, 'ARSocial_Lite_Plugin_Social_Like_Display_Settings'));
        add_action('arsocial_lite_display_fan_settings', array($this, 'ARSocial_Lite_Plugin_Social_Fan_Display_Settings'));
        add_action('arsocial_lite_like_page', array($this, 'ARSocialSharePluginSocialLike'));
        add_action('arsocial_lite_fan_counter', array($this, 'ARSocialSharePluginSocialFanCounter'));
        add_action('arsocial_lite_share_analytics', array($this, 'ARSocial_Lite_Share_Analytics'));
        add_action('arsocial_lite_global_settings', array($this, 'ARSocialSharePluginSettings'));
        add_action('arsocial_lite_locker_analytics', array($this, 'ARSocial_Lite_Locker_Analytics'));
        add_action('arsocial_lite_fan_analytics', array($this, 'ARSocial_Lite_Fan_Analytics'));
        add_action('arsocial_lite_upgrade_to_premium', array($this, 'ARSocial_Lite_Upgrade_To_Premium'));

        add_action('admin_enqueue_scripts', array($this, 'ARSocial_Lite_Admin_CSS'), 10);
        add_action('admin_enqueue_scripts', array($this, 'ARSocial_Lite_Admin_JS'), 10);

        add_action('wp_head', array($this, 'ARSocial_Lite_Front_CSS'), 1);
        add_action('wp_head', array($this, 'ARSocial_Lite_Front_JS'), 1);


        add_action('wp_head', array($this, 'ars_lite_enqueue_js_css'), 1, 1);
        add_action('wp_head', array($this, 'ARSocial_Lite_Front_Assets'), 1, 0);

        add_filter('cron_schedules', array($this, 'arsocial_lite_set_schedule_interval'));

        add_action('plugins_loaded', array($this, 'arsocial_lite_set_schedule'));
        add_action('arsocial_lite_load_cache', array($this, 'arsocial_lite_load_cache'));

        add_action('admin_head', array($this, 'ars_lite_menu_css'));

        add_action('wp_footer', array($this, 'ars_lite_footer_js_css'));

        if( !function_exists('is_plugin_active') ){
            require(ABSPATH.'/wp-admin/includes/plugin.php');
        }
        
        if( is_plugin_active('wp-rocket/wp-rocket.php') && !is_admin() ){
    	   add_filter('script_loader_tag', array($this, 'ars_prevent_rocket_loader_script'), 10, 2);
        }
    	
    	add_action('user_register',array($this,'ars_add_capabilities_to_new_user'));
    }
    
     /**
     * User Capability after adding New user
     */
    function ars_add_capabilities_to_new_user($user_id){
	
    	if( $user_id == '' ){
    	    return;
    	}
    	if( user_can($user_id,'administrator')){

    	    $arsshare_role = $this->ARSocialShareCapabilities();
    	   
    	    $userObj = new WP_User($user_id);
    	    foreach ($arsshare_role as $arsrole => $arsroledescription){
    		$userObj->add_cap($arsrole);
    	    }
    	    unset($arsrole);
    	    unset($arsroles);
    	    unset($arsroledescription);
    	}
    }
    
    function ars_prevent_rocket_loader_script($tag, $handle) {

        $script = htmlspecialchars($tag);
        $pattern2 = '/\/(wp\-content\/plugins\/social\-share\-and\-social\-locker\-arsocial)|(wp\-includes\/js)/';
        preg_match($pattern2,$script,$match_script);

        if( !isset($match_script[0]) || $match_script[0] == '' ){
            return $tag;
        }

        $pattern = '/(.*?)(data\-cfasync\=)(.*?)/';
        preg_match_all($pattern, $tag, $matches);
        if (!is_array($matches)) {
            return str_replace(' src', ' data-cfasync="false" src', $tag);
        } else if (!empty($matches) && !empty($matches[2]) && !empty($matches[2][0]) && strtolower(trim($matches[2][0])) != 'data-cfasync=') {
            return str_replace(' src', ' data-cfasync="false" src', $tag);
        } else if (!empty($matches) && empty($matches[2])) {
            return str_replace(' src', ' data-cfasync="false" src', $tag);
        } else {
            return $tag;
        }
    }
    
    /**
     * ARSocial Lite Plugin Installer
     * 
     * @since v1.0
     */
    public static function ARSocial_Lite_Installer() {
        global $wpdb, $arsocial_lite, $arsocial_lite_version;
        $arsociallite_version = get_option('arslite_version');
        if (!isset($arsociallite_version) || $arsociallite_version == '') {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            update_option('arslite_version', $arsocial_lite_version);

            $arsocial_lite->ARSocialShareInstallDefaultSettings();

            $arsocial_lite->ARSocialShareDefaultLikeOption();

            $charset_collate = '';

            if ($wpdb->has_cap('collation')) {

                if (!empty($wpdb->charset))
                    $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

                if (!empty($wpdb->collate))
                    $charset_collate .= " COLLATE $wpdb->collate";
            }

            /**
             * Creating Table for Social Lite
             * 
             * @since v1.0
             */
            $network_table = $arsocial_lite->arslite_networks;

            $network_table_query = "CREATE TABLE IF NOT EXISTS `$network_table` (
                `network_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                `network_settings` LONGTEXT NOT NULL ,
                `display_settings` TEXT NOT NULL ,
                `created_date` DATETIME NOT NULL ,
                `last_updated_date` DATETIME NOT NULL
            ){$charset_collate}";

            dbDelta($network_table_query);

            $table = $arsocial_lite->arslite_locker;

            /**
             * Creating Table for Social Locker.
             * 
             * @since v1.0
             */
            $query = "CREATE TABLE IF NOT EXISTS `$table` (
                `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `lockername` varchar(255) NOT NULL,
                `content` longtext NOT NULL,
                `locker_type` varchar(20) NOT NULL,
                `locker_options` longtext NOT NULL,
                `created_date` datetime NOT NULL,
                `updated_date` datetime NOT NULL
            ){$charset_collate}";

            dbDelta($query);

            $like_table = $arsocial_lite->arslite_like;

            /**
             * Creating Table for Like Shortcode.
             * 
             * @since v1.0
             */
            $like_query = "CREATE TABLE IF NOT EXISTS `$like_table` (
                `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `content` longtext NOT NULL,
                `display_type` varchar(20) NOT NULL,
                `created_date` datetime NOT NULL,
                `updated_date` datetime NOT NULL
            ){$charset_collate}";

            dbDelta($like_query);

            $fan_table = $arsocial_lite->arslite_fan;
            /**
             * Creating Table for Fan Counter.
             * 
             * @since v1.0
             */
            $fan_query = "CREATE TABLE IF NOT EXISTS `$fan_table` (
                `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `content` longtext NOT NULL,
                `display_type` varchar(20) NOT NULL,
                `update_time` varchar(5) NOT NULL,
                `counter_data` longtext NOT NULL,
                `created_date` datetime NOT NULL,
                `updated_date` datetime NOT NULL
            ){$charset_collate}";

            dbDelta($fan_query);
        }
	
	$args = array(
            'role' => 'administrator',
            'fields' => 'id'
        );
        $users = get_users($args);
        if( count($users) > 0 ){
            foreach($users as $key => $user_id ){
                
		  $arsshare_role = $arsocial_lite->ARSocialShareCapabilities();
		
                $userObj = new WP_User($user_id);
                foreach ($arsshare_role as $arsrole => $arsroledescription){
                    $userObj->add_cap($arsrole);
                }
                unset($arsrole);
                unset($arsroles);
                unset($arsroledescription);
            }
        }
    }

    function ars_lite_menu_css() {
        ?>
        <style type="text/css">
            #adminmenu #toplevel_page_arsocial_lite .wp-menu-image img{
                padding-top:5px;
            }
            #adminmenu #toplevel_page_arsocial_lite .wp-submenu li:last-child a{
                color:#6bbc5b !important;
            }
            #adminmenu #toplevel_page_arsocial_lite .wp-submenu li:last-child a:hover,
            #adminmenu #toplevel_page_arsocial_lite .wp-submenu li:last-child a:focus{
                color:#7ad368 !important;
            }
        </style>
        <?php

    }

    public static function arsocial_lite_check_network_activation($network_wide) {
        if (!$network_wide)
            return;

        deactivate_plugins(plugin_basename(__FILE__), TRUE, TRUE);

        header('Location: ' . network_admin_url('plugins.php?deactivate=true'));
        exit;
    }

    /**
     * ARSocial Lite Plugin Unsinstaller
     * 
     * @since v1.0
     */
    public static function ARSocial_Lite_Uninstaller() {
        global $wpdb,$arsocial_lite;

        if (is_multisite()) {
            $blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);
            if ($blogs) {
                foreach ($blogs as $blog) {
                    switch_to_blog($blog['blog_id']);

                    $network_table = $arsocial_lite->arslite_networks;

                    $table = $arsocial_lite->arslite_locker;
                    $like_table = $arsocial_lite->arslite_like;
                    $fan_table = $arsocial_lite->arslite_fan;

                    $wpdb->query("DROP TABLE IF EXISTS $network_table");
                    $wpdb->query("DROP TABLE IF EXISTS $table");
                    $wpdb->query("DROP TABLE IF EXISTS $like_table");
                    $wpdb->query("DROP TABLE IF EXISTS $fan_table");

                    delete_option('arslite_selected_theme');
                    delete_option('arslite_version');
                    delete_option('arslite_like');
                    delete_option('wp_arslite_time');
                    delete_option('arslite_fancounter_cron_ars_fan_global_settings');

                    delete_option('arslite_settings');
                    delete_option('arslite_locker_display_settings');
                    delete_option('arslite_like_display_settings');
                    delete_option('arslite_global_settings');
                    delete_option('arslite_fan_display_settings');

                    delete_option('arslite_networks_display_setting');
                    delete_option('arslite_sharing_locker_order');
                    delete_option('arslite_update_token');
                    delete_option('arslite_global_sharing_order');
                    delete_option('arslite_fan_counter_data_global');
                    delete_option('arslite_global_like_order');


                    $wpdb->query("DELETE FROM " . $wpdb->options . " WHERE option_name LIKE '%arslite%'");
                }
                restore_current_blog();
            }
        } else {

            $network_table = $arsocial_lite->arslite_networks;

            $table = $arsocial_lite->arslite_locker;
            $like_table = $arsocial_lite->arslite_like;
            $fan_table = $arsocial_lite->arslite_fan;

            $wpdb->query("DROP TABLE IF EXISTS $network_table");
            $wpdb->query("DROP TABLE IF EXISTS $table");
            $wpdb->query("DROP TABLE IF EXISTS $like_table");
            $wpdb->query("DROP TABLE IF EXISTS $fan_table");

            delete_option('arslite_selected_theme');
            delete_option('arslite_version');
            delete_option('arslite_settings');
            delete_option('arslite_like');
            delete_option('wp_arslite_time');
            delete_option('arslite_fancounter_cron_ars_fan_global_settings');

            delete_option('arslite_settings');

            delete_option('arslite_locker_display_settings');
            delete_option('arslite_like_display_settings');
            delete_option('arslite_global_settings');
            delete_option('arslite_fan_display_settings');

            delete_option('arslite_networks_display_setting');
            delete_option('arslite_sharing_locker_order');
            delete_option('arslite_update_token');
            delete_option('arslite_global_sharing_order');
            delete_option('arslite_fan_counter_data_global');
            delete_option('arslite_global_like_order');

            $wpdb->query("DELETE FROM " . $wpdb->options . " WHERE option_name LIKE '%arslite%'");
        }
    }

    /**
     * ARSocial Lite Check DB Version
     * 
     * @since v1.0
     */
    public static function ARSocial_Lite_CheckDB() {
        global $arsocial_lite;
        $arsocialshare_plugin_version = get_option('arslite_version');
        if (!isset($arsocialshare_plugin_version) || $arsocialshare_plugin_version == '' || is_multisite()) {
            $arsocial_lite->ARSocial_Lite_Installer();
        }
    }

    /**
     * ARSocial Lite Load Plugin TextDomain
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Load_TextDomain() {
        load_plugin_textdomain('arsocial_lite', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * ARSocial Lite Plugin Get Free Menu Position
     * 
     * @since v1.0
     */
    function arsocialshare_get_free_menu_position($start, $increment = 0.1) {
        foreach ($GLOBALS['menu'] as $key => $menu) {
            $menus_positions[] = floatval($key);
        }
        if (!in_array($start, $menus_positions)) {
            $start = strval($start);
            return $start;
        } else {
            $start += $increment;
        }

        while (in_array($start, $menus_positions)) {
            $start += $increment;
        }
        $start = strval($start);
        return $start;
    }

    /**
     * ARSocial Lite Defining Capabilities
     * 
     * @since v1.0
     */
    function ARSocialShareCapabilities() {
        $cap = array(
            'arsocial_lite_manage' => esc_html__('Manage Social Share Networks', 'arsocial_lite'),
            'arsocia_lite_liike_manage' => esc_html__('Manage Social Like Networks', 'arsocial_lite'),
            'arsocial_lite_fan_manage' => esc_html__('Manage Social Fan Counter Networks', 'arsocial_lite'),
            'arsocial_lite_locker_manage' => esc_html__('Manage Social Locker', 'arsocial_lite'),
            'arsocial_lite_manage_shortcode' => esc_html__('Add, Update and Delete Shortcode of Social Share, Like, Fan Counter and Locker', 'arsocial_lite'),
            'arsocial_lite_analytics' => esc_html__('View Analytics of Social Share, Like, Fan counter and Locker', 'arsocial_lite'),
            'arsocial_lite_settings' => esc_html__('Manage Global Settings like Social Configuration, Email Configuration etc', 'arsocial_lite')
        );

        return $cap;
    }

    /**
     * ARSocial Lite Plugin Menu
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Menu() {
        global $arsocial_lite;
        
        $menu_position = $this->arsocialshare_get_free_menu_position(26.1, 1);

        add_menu_page('ARSocialLite', 'ARSocial Lite', 'arsocial_lite_manage', $this->socialshare_main_page_slug, array($this, 'arsocialshareroute'), ARSOCIAL_LITE_IMAGES_URL . '/logo_24X24.png', $menu_position);
        add_submenu_page('arsocial_lite', 'Social Share Buttons', 'Social Share Buttons', 'arsocial_lite_manage', $this->socialshare_main_page_slug, array($this, 'arsocialshareroute'));
        add_submenu_page('arsocial_lite', 'Social Locker', 'Social Locker', 'arsocial_lite_locker_manage', $this->socialshare_locker_display_setting_page_slug, array($this, 'arsocialshareroute'));
        add_submenu_page('arsocial_lite', 'Social Like Buttons', 'Social Like Buttons', 'arsocia_lite_liike_manage', $this->socialshare_like_display_setting_page_slug, array($this, 'arsocialshareroute'));
        add_submenu_page('arsocial_lite', 'Social Fan Counter', 'Social Fan Counter', 'arsocial_lite_fan_manage', $this->socialshare_fan_display_setting_page_slug, array($this, 'arsocialshareroute'));
        add_submenu_page('arsocial_lite', 'Generate Shortcode', 'Generate Shortcode', 'arsocial_lite_manage_shortcode', $this->socialshare_shortcode_page_slug, array($this, 'arsocialshareroute'));
        add_submenu_page('arsocial_lite', 'Social Analytics', 'Social Analytics', 'arsocial_lite_analytics', $this->socialshare_analytics_page_slug, array($this, 'arsocialshareroute'));
        add_submenu_page('arsocial_lite', 'General Settings', 'General Settings', 'arsocial_lite_settings', $this->socialshare_global_setting_page_slug, array($this, 'arsocialshareroute'));
        $this->ARSocial_Lite_Upgrade_To_Premium();
    }

    function ARSocial_Lite_Upgrade_To_Premium() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_upgrade_to_premium.php'))
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_upgrade_to_premium.php');
    }

    /**
     * ARSocialShare Plugin Route Function
     * 
     * @since v1.0
     */
    function arsocialshareroute() {

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_main_page_slug) {
            do_action('arsocial_lite_show_networks');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_display_setting_page_slug) {
            do_action('arsocial_lite_display_sharing_settings');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_setting_page_slug) {
            do_action('arsocial_lite_show_settings');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_shortcode_page_slug) {
            do_action('arsocial_lite_show_shortcode');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_locker_page_slug) {
            do_action('arsocial_lite_locker_page');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_social_locker_analytics_slug) {
            do_action('arsocial_lite_locker_analytics');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_social_fan_analytics_slug) {
            do_action('arsocial_lite_fan_analytics');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_global_setting_page_slug) {
            do_action('arsocial_lite_global_settings');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_like_page_slug) {
            do_action('arsocial_lite_like_page');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_fan_counter_slug) {
            do_action('arsocial_lite_fan_counter');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_analytics_page_slug) {
            do_action('arsocial_lite_share_analytics');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_locker_display_setting_page_slug) {
            do_action('arsocial_lite_display_locker_settings');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_like_display_setting_page_slug) {
            do_action('arsocial_lite_display_like_settings');
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_fan_display_setting_page_slug) {
            do_action('arsocial_lite_display_fan_settings');
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == $this->socialshare_upgrade_to_premium_slug) {
            do_action('arsocial_lite_upgrade_to_premium');
        }
    }

    /**
     * ARSocial Lite Plugin Enqueue Admin CSS
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Admin_CSS() {
        global $arsocial_lite_version;
        wp_register_style('arsocial_lite_admin_css', ARSOCIAL_LITE_CSS_URL . '/arsocialshare.css', array(), $arsocial_lite_version);
        wp_register_style('arsocial_lite_effects_css', ARSOCIAL_LITE_CSS_URL . '/arsocialshare_effects.css', array(), $arsocial_lite_version);
        wp_register_style('arsocial_lite_font_icon_css', ARSOCIAL_LITE_CSS_URL . '/arsocialshareicons.css', array(), $arsocial_lite_version);
        wp_register_style('tipso', ARSOCIAL_LITE_CSS_URL . '/tipso.min.css', array(), $arsocial_lite_version);

        wp_register_style('arsocial_lite_socicon_admin_css', ARSOCIAL_LITE_CSS_URL . '/arsocialshareicons.css', array(), $arsocial_lite_version);

        wp_register_style('chosen', ARSOCIAL_LITE_CSS_URL . '/chosen.min.css', array(), $arsocial_lite_version);
        wp_register_style('colpick', ARSOCIAL_LITE_CSS_URL . '/colpick.css', array(), $arsocial_lite_version);


        if (isset($_REQUEST['page']) && ($_REQUEST['page'] === $this->socialshare_main_page_slug || $_REQUEST['page'] === $this->socialshare_setting_page_slug || $_REQUEST['page'] === $this->socialshare_shortcode_page_slug || $_REQUEST['page'] === $this->socialshare_locker_page_slug || $_REQUEST['page'] === $this->socialshare_global_setting_page_slug || $_REQUEST['page'] === $this->socialshare_like_page_slug || $_REQUEST['page'] === $this->socialshare_fan_counter_slug || $_REQUEST['page'] === $this->socialshare_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_analytics_page_slug || $_REQUEST['page'] === $this->socialshare_locker_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_like_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_fan_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_social_locker_analytics_slug || $_REQUEST['page'] === $this->socialshare_social_fan_analytics_slug )) {

            wp_enqueue_style('arsocial_lite_admin_css');
            wp_enqueue_style('arsocial_lite_font_icon_css');
            wp_enqueue_style('tipso');
            wp_enqueue_style('arsocial_lite_socicon_admin_css');
        }

        if (isset($_REQUEST['page']) && $_REQUEST['page'] === $this->socialshare_locker_display_setting_page_slug) {
            wp_enqueue_style('chosen');
        }
        wp_enqueue_style('arsocial_lite_effects_css');
        if (isset($_REQUEST['page']) && in_array($_REQUEST['page'], array($this->socialshare_main_page_slug, $this->socialshare_shortcode_page_slug))) {

            wp_register_style('arsocial_lite_theme-lite_square', ARSOCIAL_LITE_THEME_CSS_URL . '/arsocialshare_lite_theme-square.css', array(), $arsocial_lite_version);
            wp_register_style('arsocial_lite_theme-lite_default', ARSOCIAL_LITE_THEME_CSS_URL . '/arsocialshare_lite_theme-default.css', array(), $arsocial_lite_version);
        }

        if (isset($_REQUEST['page']) && ($_REQUEST['page'] === $this->socialshare_main_page_slug)) {
            wp_enqueue_style('wp-color-picker');
        }

        if (isset($_REQUEST['page']) && in_array($_REQUEST['page'], array($this->socialshare_locker_display_setting_page_slug, $this->socialshare_shortcode_page_slug, $this->socialshare_locker_page_slug))) {
            wp_enqueue_style('colpick');
        }
    }

    /**
     * ARSocialShare Plugin Enqueue Admin JavaScript
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Admin_JS() {
        global $arsocial_lite_version;
        wp_register_script('arsocial_lite_admin_js', ARSOCIAL_LITE_SCRIPT_URL . '/arsocialshare.js', array(), $arsocial_lite_version);
        wp_register_script('tipso', ARSOCIAL_LITE_SCRIPT_URL . '/tipso.min.js', array(), $arsocial_lite_version);

        wp_register_script('jeditable', ARSOCIAL_LITE_SCRIPT_URL . '/jeditable.min.js', array(), $arsocial_lite_version);
        wp_register_script('bpopup', ARSOCIAL_LITE_SCRIPT_URL . '/jquery.bpopup.min.js', array(), $arsocial_lite_version);
        wp_register_script('foggy', ARSOCIAL_LITE_SCRIPT_URL . '/jquery.foggy.min.js', array(), $arsocial_lite_version);
        wp_register_script('chosen', ARSOCIAL_LITE_SCRIPT_URL . '/chosen.jquery.min.js', array(), $arsocial_lite_version);
        wp_register_script('colpick', ARSOCIAL_LITE_SCRIPT_URL . '/colpick.js', array(), $arsocial_lite_version);
        if (isset($_REQUEST['page']) && ( $_REQUEST['page'] === $this->socialshare_main_page_slug || $_REQUEST['page'] === $this->socialshare_setting_page_slug || $_REQUEST['page'] === $this->socialshare_shortcode_page_slug || $_REQUEST['page'] === $this->socialshare_locker_page_slug || $_REQUEST['page'] === $this->socialshare_global_setting_page_slug || $_REQUEST['page'] === $this->socialshare_like_page_slug || $_REQUEST['page'] === $this->socialshare_fan_counter_slug || $_REQUEST['page'] === $this->socialshare_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_analytics_page_slug || $_REQUEST['page'] === $this->socialshare_locker_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_like_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_fan_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_social_locker_analytics_slug || $_REQUEST['page'] === $this->socialshare_social_fan_analytics_slug )) {

            wp_enqueue_script('arsocial_lite_admin_js');

            wp_enqueue_script('jquery');

            wp_enqueue_script('tipso');

            wp_enqueue_script('sack');

            wp_enqueue_script('bpopup');
        }

        if (isset($_REQUEST['page']) && in_array($_REQUEST['page'], array($this->socialshare_locker_display_setting_page_slug, $this->socialshare_shortcode_page_slug, $this->socialshare_locker_page_slug))) {
            wp_enqueue_script('foggy');
            wp_enqueue_script('colpick');
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] === $this->socialshare_locker_display_setting_page_slug) {
            wp_enqueue_script('chosen');
        }

        if (isset($_REQUEST['page']) && ($_REQUEST['page'] === $this->socialshare_main_page_slug || $_REQUEST['page'] === $this->socialshare_like_display_setting_page_slug || $_REQUEST['page'] === $this->socialshare_fan_display_setting_page_slug || $_REQUEST['page'] == $this->socialshare_shortcode_page_slug)) {
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('jquery-ui-sortable');
        }

        if (isset($_REQUEST['page']) && ($_REQUEST['page'] === $this->socialshare_main_page_slug || $_REQUEST['page'] === $this->socialshare_shortcode_page_slug )) {
            wp_enqueue_script('jeditable');
        }

        if (isset($_REQUEST['page']) && ($_REQUEST['page'] === $this->socialshare_main_page_slug)) {
            wp_enqueue_script('arsocial_lite_admin_js_colpick', plugins_url('js/ars_colpick.js', __FILE__), array('wp-color-picker'), $arsocial_lite_version, true);
        }

        $translated_text = "
            var __ARS_AJAX_ERROR = '" . addslashes( esc_html__( 'Ajax error while saving', 'arsocial_lite' ) ) . "';
            var __ARS_PLZ_SELECT = '" . addslashes( esc_html__( 'Please Select', 'arsocial_lite' ) ) . "';
            var __ARS_NETWORK_SAVE_ERROR = '" . addslashes( esc_html__( 'Ajax error while saving networks.', 'arsocial_lite' ) ) . "';
            var __ARS_INVALID_LOCKER = '" . addslashes( esc_html__( 'Invalid Locker.', 'arsocial_lite' ) ) . "';
            var __ARS_INVALID_SHORTCODE = '" . addslashes( esc_html__( 'Invalid Shortcode.', 'arsocial_lite' ) ) . "';
            var __ARS_SELECT_ACTION = '" . addslashes( esc_html__( 'Please select action to perform', 'arsocial_lite' ) ) . "';
            ";
        wp_add_inline_script( 'arsocial_lite_admin_js', $translated_text );
    }

    /**
     * ARSocialShare Plugin Remove Admin side notice
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Remove_Notice() {
        if (isset($_GET) and ( isset($_GET['page']) and preg_match('/arsocial_lite*/', $_GET['page']))) {
            remove_all_actions('network_admin_notices', 10000);
            remove_all_actions('user_admin_notices', 10000);
            remove_all_actions('admin_notices', 10000);
            remove_all_actions('all_admin_notices', 10000);
            remove_action('admin_notices', 'update_nag', 3);
        }
    }

    /**
     * ARSocialShare Plugin Remove Footer Thank You Text
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Remove_Footer() {
        echo '<span id="footer-thankyou"></span>';
    }

    /**
     * ARSocialShare Plugin Remove Footer Version
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Remove_Footer_Version() {
        return ' ';
    }

    /**
     * ARSocialShare Plugin Default Networks
     * 
     * @since v1.0
     */
    function ARSocialShareNetworks() {
        $socialsharenetwork = apply_filters('arsocial_lite_default_networks', array(
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'pinterest' => 'Pinterest',
            'linkedin' => 'Linkedin'
        ));

        return $socialsharenetwork;
    }

    /**
     * ARSocialShare Plugin Settings
     * 
     * @since v1.0
     */
    function arsocial_lite_settings() {
        global $arsocial_lite, $ars_lite_default_networks;
        $ars_lite_default_networks = $this->ARSocialShareNetworks();
    }

    /**
     * ARSocialShare Plugin Social Networks Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Plugin_Display_Networks() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share_setting.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share_setting.php');
        }
    }

    function ARSocial_Lite_Plugin_Display_Sharing_Settings() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share_setting.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share_setting.php');
        }
    }

    /**
     * ARSocialShare Plugin Display Settings Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Plugin_Display_Settings() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_setting.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_setting.php');
        }
    }

    /**
     * ARSocialShare Plugin Shortcode Generator Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Plugin_Shortcode_Generator() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_shortcode.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_shortcode.php');
        }
    }

    /**
     * ARSocialShare Plugin Social Content Like Display Settings Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Plugin_Social_Like_Display_Settings() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_like_setting.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_like_setting.php');
        }
    }

    /**
     * ARSocialShare Plugin Social Content Fan Counter Display Settings Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Plugin_Social_Fan_Display_Settings() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_counter_setting.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_counter_setting.php');
        }
    }

    /**
     * ARSocialShare Plugin Social Content Locker Display Settings Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Plugin_Social_Locker_Display_Settings() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker_setting.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker_setting.php');
        }
    }

    /**
     * ARSocialShare Plugin Social Content Locker Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Plugin_Social_Locker() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker.php');
        }
    }

    /**
     * ARSocialShare Plugin Global Setting Page
     * 
     * @since v1.0
     */
    function ARSocialSharePluginSettings() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_global_setting.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_global_setting.php');
        }
    }

    /**
     * ARSocialShare Plugin Locker Analytics Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Locker_Analytics() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker_analytics.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker_analytics.php');
        }
    }

    /**
     * ARSocialShare Plugin Locker Analytics Page
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Fan_Analytics() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_analytics.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_analytics.php');
        }
    }

    /**
     * ARSocialShare Plugin Social Like Page
     * 
     * @since v1.0
     */
    function ARSocialSharePluginSocialLike() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_like.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_like.php');
        }
    }

    function ARSocialSharePluginSocialFanCounter() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_counter.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_counter.php');
        }
    }

    function ARSocial_Lite_Share_Analytics() {
        if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share_analytics.php')) {
            include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_share_analytics.php');
        }
    }

    /**
     * ARSocialShare Plugin Install Default Settings
     * 
     * @since v1.0
     */
    function ARSocialShareInstallDefaultSettings() {
        $settings = array();
        $settings['networks'] = array();
        $settings['networks']['facebook'] = array(
            'enable' => true,
            'display_name' => 'Facebook',
            'display_order' => 0,
            'custom_name' => 'Facebook',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['twitter'] = array(
            'enable' => true,
            'display_name' => 'Twitter',
            'display_order' => 1,
            'custom_name' => 'Twitter',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['linkedin'] = array(
            'enable' => true,
            'display_name' => 'LinkedIn',
            'display_order' => 3,
            'custom_name' => 'LinkedIn',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['pinterest'] = array(
            'enable' => true,
            'display_name' => 'Pinterest',
            'display_order' => 4,
            'custom_name' => 'Pinterest',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['mix'] = array(
            'enable'        => true,
            'display_name'  => 'Mix',
            'display_order' => 6,
            'custom_name'   => 'Mix',
            'plateform'     => array(
                'desktop',
                'mobile',
            ),
        );
        $settings['networks']['reddit'] = array(
            'enable' => true,
            'display_name' => 'Reddit',
            'display_order' => 8,
            'custom_name' => 'Reddit',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['buffer'] = array(
            'enable' => true,
            'display_name' => 'Buffer',
            'display_order' => 9,
            'custom_name' => 'Buffer',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['pocket'] = array(
            'enable' => true,
            'display_name' => 'Pocket',
            'display_order' => 10,
            'custom_name' => 'Pocket',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['xing'] = array(
            'enable' => true,
            'display_name' => 'Xing',
            'display_order' => 11,
            'custom_name' => 'Xing',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['odnoklassniki'] = array(
            'enable' => true,
            'display_name' => 'Odnoklassniki',
            'display_order' => 12,
            'custom_name' => 'Odnoklassniki',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['meneame'] = array(
            'enable' => true,
            'display_name' => 'Meneame',
            'display_order' => 13,
            'custom_name' => 'Meneame',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['blogger'] = array(
            'enable' => true,
            'display_name' => 'Blogger',
            'display_order' => 14,
            'custom_name' => 'Blogger',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['amazon'] = array(
            'enable' => true,
            'display_name' => 'Amazon',
            'display_order' => 15,
            'custom_name' => 'Amazon',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['hackernews'] = array(
            'enable' => true,
            'display_name' => 'Hacker News',
            'display_order' => 16,
            'custom_name' => 'Hacker News',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['evernote'] = array(
            'enable' => true,
            'display_name' => 'Evernote',
            'display_order' => 17,
            'custom_name' => 'Evernote',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['myspace'] = array(
            'enable' => true,
            'display_name' => 'MySpace',
            'display_order' => 18,
            'custom_name' => 'MySpace',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['viadeo'] = array(
            'enable' => true,
            'display_name' => 'Viadeo',
            'display_order' => 19,
            'custom_name' => 'Viadeo',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['flipboard'] = array(
            'enable' => true,
            'display_name' => 'Flipboard',
            'display_order' => 20,
            'custom_name' => 'Flipboard',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['yummly'] = array(
            'enable' => true,
            'display_name' => 'Yummly',
            'display_order' => 21,
            'custom_name' => 'Yummly',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['whatsapp'] = array(
            'enable' => true,
            'display_name' => 'Whatsapp',
            'display_order' => 22,
            'custom_name' => 'Whatspp',
            'plateform' => array(
                'mobile'
            )
        );
        $settings['networks']['box'] = array(
            'enable' => true,
            'display_name' => 'Box',
            'display_order' => 23,
            'custom_name' => 'Box',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['gmail'] = array(
            'enable' => true,
            'display_name' => 'Gmail',
            'display_order' => 26,
            'custom_name' => 'Gmail',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['yahoo'] = array(
            'enable' => true,
            'display_name' => 'Yahoo',
            'display_order' => 27,
            'custom_name' => 'Yahoo',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['aol'] = array(
            'enable' => true,
            'display_name' => 'AOL',
            'display_order' => 28,
            'custom_name' => 'AOL',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['email'] = array(
            'enable' => true,
            'display_name' => 'Email',
            'display_order' => 29,
            'custom_name' => 'Email',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['vk'] = array(
            'enable' => true,
            'display_name' => 'VK',
            'display_order' => 30,
            'custom_name' => 'VK',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['arsprint'] = array(
            'enable' => true,
            'display_name' => 'Print',
            'display_order' => 31,
            'custom_name' => 'Print',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );

        $settings['theme'] = array();
        $settings['theme']['default'] = array(
            'enable' => true,
            'display_name' => 'Default'
        );

        $settings['theme']['rounded'] = array(
            'enable' => true,
            'display_name' => 'Rounded'
        );

        $settings['theme']['bordered'] = array(
            'enable' => true,
            'display_name' => 'Bordered'
        );

        $settings['theme']['flat_rounded'] = array(
            'enable' => true,
            'display_name' => 'Rounded Flat'
        );

        $settings = apply_filters('arsocial_lite_share_default_settings', $settings);

        $arsettings = maybe_serialize($settings);

        update_option('arslite_settings', $arsettings);
        update_option('arslite_selected_theme', 'default');
    }

    /**
     * Function for Default Networks
     * 
     * @since v1.0
     */
    function ARSocialShareDefaultNetworks() {
        $settings = array();
        $settings['networks'] = array();
        $settings['networks']['facebook'] = array(
            'enable' => true,
            'display_name' => 'Facebook',
            'display_order' => 0,
            'custom_name' => 'Facebook',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['twitter'] = array(
            'enable' => true,
            'display_name' => 'Twitter',
            'display_order' => 1,
            'custom_name' => 'Twitter',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['linkedin'] = array(
            'enable' => true,
            'display_name' => 'LinkedIn',
            'display_order' => 3,
            'custom_name' => 'LinkedIn',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['pinterest'] = array(
            'enable' => true,
            'display_name' => 'Pinterest',
            'display_order' => 4,
            'custom_name' => 'Pinterest',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['mix']           = array(
            'enable'        => true,
            'display_name'  => 'Mix',
            'display_order' => 6,
            'custom_name'   => 'Mix',
            'plateform'     => array(
                'desktop',
                'mobile',
            ),
        );
        $settings['networks']['reddit'] = array(
            'enable' => true,
            'display_name' => 'Reddit',
            'display_order' => 8,
            'custom_name' => 'Reddit',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['buffer'] = array(
            'enable' => true,
            'display_name' => 'Buffer',
            'display_order' => 9,
            'custom_name' => 'Buffer',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['pocket'] = array(
            'enable' => true,
            'display_name' => 'Pocket',
            'display_order' => 10,
            'custom_name' => 'Pocket',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['xing'] = array(
            'enable' => true,
            'display_name' => 'Xing',
            'display_order' => 11,
            'custom_name' => 'Xing',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['odnoklassniki'] = array(
            'enable' => true,
            'display_name' => 'Odnoklassniki',
            'display_order' => 12,
            'custom_name' => 'Odnoklassniki',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['meneame'] = array(
            'enable' => true,
            'display_name' => 'Meneame',
            'display_order' => 13,
            'custom_name' => 'Meneame',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['blogger'] = array(
            'enable' => true,
            'display_name' => 'Blogger',
            'display_order' => 14,
            'custom_name' => 'Blogger',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['amazon'] = array(
            'enable' => true,
            'display_name' => 'Amazon',
            'display_order' => 15,
            'custom_name' => 'Amazon',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['hackernews'] = array(
            'enable' => true,
            'display_name' => 'Hacker News',
            'display_order' => 16,
            'custom_name' => 'Hacker News',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['evernote'] = array(
            'enable' => true,
            'display_name' => 'Evernote',
            'display_order' => 17,
            'custom_name' => 'Evernote',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['myspace'] = array(
            'enable' => true,
            'display_name' => 'MySpace',
            'display_order' => 18,
            'custom_name' => 'MySpace',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['viadeo'] = array(
            'enable' => true,
            'display_name' => 'Viadeo',
            'display_order' => 19,
            'custom_name' => 'Viadeo',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['flipboard'] = array(
            'enable' => true,
            'display_name' => 'Flipboard',
            'display_order' => 20,
            'custom_name' => 'Flipboard',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['yummly'] = array(
            'enable' => true,
            'display_name' => 'Yummly',
            'display_order' => 21,
            'custom_name' => 'Yummly',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['whatsapp'] = array(
            'enable' => true,
            'display_name' => 'Whatsapp',
            'display_order' => 22,
            'custom_name' => 'Whatspp',
            'plateform' => array(
                'mobile'
            )
        );
        $settings['networks']['box'] = array(
            'enable' => true,
            'display_name' => 'Box',
            'display_order' => 23,
            'custom_name' => 'Box',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['gmail'] = array(
            'enable' => true,
            'display_name' => 'Gmail',
            'display_order' => 26,
            'custom_name' => 'Gmail',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );

        $settings['networks']['yahoo'] = array(
            'enable' => true,
            'display_name' => 'Yahoo',
            'display_order' => 27,
            'custom_name' => 'Yahoo',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['aol'] = array(
            'enable' => true,
            'display_name' => 'AOL',
            'display_order' => 28,
            'custom_name' => 'AOL',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['email'] = array(
            'enable' => true,
            'display_name' => 'Email',
            'display_order' => 29,
            'custom_name' => 'Email',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['vk'] = array(
            'enable' => true,
            'display_name' => 'VK',
            'display_order' => 30,
            'custom_name' => 'VK',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );
        $settings['networks']['arsprint'] = array(
            'enable' => true,
            'display_name' => 'Print',
            'display_order' => 31,
            'custom_name' => 'Print',
            'plateform' => array(
                'desktop',
                'mobile'
            )
        );

        $settings['networks']['sms'] = array(
            'enable' => true,
            'display_name' => 'SMS',
            'display_order' => 32,
            'custom_name' => 'SMS',
            'plateform' => array(
                'mobile'
            )
        );
        $settings['networks']['viber'] = array(
            'enable' => true,
            'display_name' => 'Viber',
            'display_order' => 33,
            'custom_name' => 'Viber',
            'plateform' => array(
                'mobile'
            )
        );

        /* Share Button Themes */
        $tdefault = array('enable' => true, 'display_name' => 'Flat');
        $trounded = array('enable' => true, 'display_name' => 'Circle');
        $tbordered = array('enable' => true, 'display_name' => 'Bordered');
        $tflat_rounded = array('enable' => true, 'display_name' => 'Rounded');
        $tblank_round = array('enable' => true, 'display_name' => 'Modern');
        $tsquare = array('enable' => true, 'display_name' => 'Classic');
        $trolling = array('enable' => true, 'display_name' => 'Rolling');

        $settings['theme'] = array(
            'lite_default' => $tdefault,
            'lite_square' => $tsquare,
        );
        /* Sidebar Themes */
        $settings['sidebar_theme'] = array(
            'lite_default' => $tdefault,
            'lite_square' => $tsquare,
        );

        /* Effects */
        $effect1 = array('enable' => true, 'display_name' => 'Rotate');
        $effect2 = array('enable' => true, 'display_name' => 'Fade');
        $effect3 = array('enable' => true, 'display_name' => 'Move up');
        $pulse = array('enable' => true, 'display_name' => 'Pulse');
        $pop = array('enable' => true, 'display_name' => 'Pop');
        $wobble_h = array('enable' => true, 'display_name' => 'Shake1');
        $wobble_v = array('enable' => true, 'display_name' => 'Shake2');
        $buzz_out = array('enable' => true, 'display_name' => 'Buzz Out');

        $settings['effect'] = array(
            'effect1' => $effect1,
            'effect2' => $effect2,
            'effect3' => $effect3,
            'pulse' => $pulse,
            'pop' => $pop,
            'wobble_h' => $wobble_h,
            'wobble_v' => $wobble_v,
            'buzz_out' => $buzz_out,
        );
        /* Sidebar Effects */
        $settings['sidebar_effect'] = array(
            'effect1' => $effect1,
            'effect2' => $effect2,
            'pulse' => $pulse,
            'pop' => $pop,
            'buzz_out' => $buzz_out,
        );

        $settings = apply_filters('arsocial_lite_share_default_settings', $settings);

        return $settings;
    }

    /**
     * Function for Default Themes for Social Locker
     * 
     * @since v1.0
     */
    function ARSocialShareLockerThemes() {

        $arsociallocker_themes = apply_filters('arsocial_lite_locker_theme', array(
            'Default' => array(
                'value' => 'default',
            ),
            
            'Glass' => array(
                'value' => 'glass',
            ),
        ));

        return $arsociallocker_themes;
    }

    /**
     * Function for Default Networks For Fan Counter
     * 
     * @since v1.0
     */
    function ARSocialShareFancounterNetworks() {

        $settings = array();
        $settings = array(
            'facebook' => array(
                'display_name' => 'Facebook',
                'network_url' => 'https://www.facebook.com/'
            ),
            'twitter' => array(
                'display_name' => 'Twitter',
                'network_url' => 'https://www.twitter.com/'
            ),
            'linkedin' => array(
                'display_name' => 'Linkedin',
                'network_url' => 'https://www.linkedin.com/profile/view?id='
            ),
            'pinterest' => array(
                'display_name' => 'Pinterest',
                'network_url' => 'https://www.pinterest.com/'
            ),
            'vimeo' => array(
                'display_name' => 'Vimeo',
                'network_url' => 'https://www.vimeo.com/'
            ),
            'instagram' => array(
                'display_name' => 'Instagram',
                'network_url' => 'https://www.instagram.com/'
            ),
            'youtube' => array(
                'display_name' => 'Youtube',
                'network_url' => 'https://www.youtube.com/'
            ),
            'dribbble' => array(
                'display_name' => 'Dribbble',
                'network_url' => 'https://www.dribbble.com/'
            ),
            'vk' => array(
                'display_name' => 'VKontake',
                'network_url' => 'https://www.vk.com/'
            ),
            'foursquare' => array(
                'display_name' => 'Foursquare',
                'network_url' => 'https://foursquare.com/user/'
            ),
            'github' => array(
                'display_name' => 'Github',
                'network_url' => 'https://www.github.com/'
            ),
            'soundcloud' => array(
                'display_name' => 'SoundCloud',
                'network_url' => 'https://soundcloud.com/'
            ),
            'flickr' => array(
                'display_name' => 'flickr',
                'network_url' => 'https://www.flickr.com/groups/'
            ),
        );

        $settings = apply_filters('arsocial_lite_fan_counter_network', $settings);

        return $settings;
    }

    /**
     * Function for Default Networks Options For Fan Counter
     * 
     * @since v1.0
     */
    function ARSocialShareDefaultNetworksFanCounter() {

        $settings = array();
        $settings['facebook'] = array(
            'account_type' => array(
                'page' => esc_html__('Page', 'arsocial_lite'),
                'profile' => esc_html__('User Profile', 'arsocial_lite'),
            )
        );

        $settings['linkedin'] = array(
            'account_type' => array(
                'page' => esc_html__('Company Page', 'arsocial_lite'),
                'profile' => esc_html__('User Profile', 'arsocial_lite'),
            )
        );

        $settings['vimeo'] = array(
            'account_type' => array(
                'channel' => esc_html__('Channel', 'arsocial_lite'),
                'user' => esc_html__('User', 'arsocial_lite'),
            )
        );

        $settings['youtube'] = array(
            'account_type' => array(
                'channel' => esc_html__('Channel', 'arsocial_lite'),
                'user' => esc_html__('User', 'arsocial_lite'),
            )
        );

        $settings['vk'] = array(
            'account_type' => array(
                'community' => esc_html__('Community', 'arsocial_lite'),
                'profile' => esc_html__('Profile', 'arsocial_lite'),
            )
        );

        $settings['display_style'] = array(
            'display_style' => array(
                'metro' => esc_html__('Flat', 'arsocial_lite'),
                'flat' => esc_html__('Classic', 'arsocial_lite'),
            )
        );

        $settings['counter_number_format'] = array(
            'counter_number_format' => array(
                'style1' => esc_html__('1000, 10000', 'arsocial_lite'),
                'style2' => esc_html__('1.000, 10.000', 'arsocial_lite'),
                'style3' => esc_html__('1,000, 10,000', 'arsocial_lite'),
                'style4' => esc_html__('1 000, 10 000', 'arsocial_lite'),
                'style5' => esc_html__('1k, 10k, 100k, 1m', 'arsocial_lite'),
            )
        );


        $settings = apply_filters('arsocial_lite_fan_counter_setting', $settings);

        return $settings;
    }

    /**
     * Function for Default Networks Like Option
     * 
     * @since v1.0
     */
    function ARSocialShareDefaultLikeNetworks() {
        $like_network = array();
        $like_network = array(
            'facebook' => array(
                'facebook_button_layout' => array(
                    'standard' => esc_html__('Standard', 'arsocial_lite'),
                    'box_count' => esc_html__('Box Count', 'arsocial_lite'),
                    'button_count' => esc_html__('Button Count', 'arsocial_lite'),
                    'button' => esc_html__('Button', 'arsocial_lite')
                ),
                'facebook_like_button_action_type' => array(
                    'like' => esc_html__('Like', 'arsocial_lite'),
                    'recommend' => esc_html__('Recommend', 'arsocial_lite'),
                    'recommend' => esc_html__('Recommend', 'arsocial_lite')
                ),
                'facebook_like_button_colorscheme' => array(
                    'light' => esc_html__('Light', 'arsocial_lite'),
                    'dark' => esc_html__('Dark', 'arsocial_lite'),
                )
            ),
            'twitter' => array(
                'language' => array(
                    "automatic" => esc_html__('Automatic', 'arsocial_lite'),
                    "fr" => esc_html__('French', 'arsocial_lite'),
                    "en" => esc_html__('English', 'arsocial_lite'),
                    "ar" => esc_html__('Arabic', 'arsocial_lite'),
                    "ja" => esc_html__('Japanese', 'arsocial_lite'),
                    "es" => esc_html__('Spanish', 'arsocial_lite'),
                    "de" => esc_html__('German', 'arsocial_lite'),
                    "it" => esc_html__('Italian', 'arsocial_lite'),
                    "id" => esc_html__('Indonesian', 'arsocial_lite'),
                    "pt" => esc_html__('Portuguese', 'arsocial_lite'),
                    "ko" => esc_html__('Korean', 'arsocial_lite'),
                    "tr" => esc_html__('Turkish', 'arsocial_lite'),
                    "ru" => esc_html__('Russian', 'arsocial_lite'),
                    "nl" => esc_html__('Dutch', 'arsocial_lite'),
                    "fil" => esc_html__('Filipino', 'arsocial_lite'),
                    "msa" => esc_html__('Malay', 'arsocial_lite'),
                    "zh-tw" => esc_html__('Traditional Chinese', 'arsocial_lite'),
                    "zh-cn" => esc_html__('Simplified Chinese', 'arsocial_lite'),
                    "hi" => esc_html__('Hindi', 'arsocial_lite'),
                    "no" => esc_html__('Norwegian', 'arsocial_lite'),
                    "sv" => esc_html__('Swedish', 'arsocial_lite'),
                    "fi" => esc_html__('Finnish', 'arsocial_lite'),
                    "da" => esc_html__('Danish', 'arsocial_lite'),
                    "pl" => esc_html__('Polish', 'arsocial_lite'),
                    "hu" => esc_html__('Hungarian', 'arsocial_lite'),
                    "fa" => esc_html__('Farsi', 'arsocial_lite'),
                    "he" => esc_html__('Hebrew', 'arsocial_lite'),
                    "ur" => esc_html__('Urdu', 'arsocial_lite'),
                    "th" => esc_html__('Thai', 'arsocial_lite')
                ),
            ),
            'youtube' => array(
                'youtube_like_button_layout' => array(
                    'dafault' => esc_html__('Dafault', 'arsocial_lite'),
                    'full' => esc_html__('Full', 'arsocial_lite')
                ),
                'youtube_like_button_theme' => array(
                    'dafault' => esc_html__('Dafault', 'arsocial_lite'),
                    'dark' => esc_html__('Dark', 'arsocial_lite')
                ),
                'youtube_like_button_subscriber_count' => array(
                    'dafault' => esc_html__('Dafault', 'arsocial_lite'),
                    'hidden' => esc_html__('Hidden', 'arsocial_lite')
                ),
                'youtube_like_button_subscribe_using' => array(
                    'id' => esc_html__('Channel Id', 'arsocial_lite'),
                    'name' => esc_html__('Channel Name', 'arsocial_lite'),
                )
            ),
            'pinterest' => array(
                'pinterest_like_button_color' => array(
                    'red' => esc_html__('Red', 'arsocial_lite'),
                    'gray' => esc_html__('Gray', 'arsocial_lite'),
                    'white' => esc_html__('White', 'arsocial_lite'),
                ),
                'pinterest_like_button_count_position' => array(
                    'not_shown' => esc_html__('Not Shown', 'arsocial_lite'),
                    'above' => esc_html__('Above the Button', 'arsocial_lite'),
                    'beside' => esc_html__('Beside the Button', 'arsocial_lite'),
                ),
                'pinterest_like_button_language' => array(
                    'en' => esc_html__('English', 'arsocial_lite'),
                    'ja' => esc_html__('Japanese', 'arsocial_lite'),
                )
            ),
            'vk' => array(
                'vk_like_button_name' => array(
                    'normal' => esc_html__('Like', 'arsocial_lite'),
                    'verb' => esc_html__('This is interesting', 'arsocial_lite'),
                ),
                'vk_like_button_layout' => array(
                    'button' => esc_html__('Button with mini counter', 'arsocial_lite'),
                    'full' => esc_html__('Button with text counter', 'arsocial_lite'),
                    'mini' => esc_html__('Mini button', 'arsocial_lite'),
                    'vertical' => esc_html__('Mini button with counter at the top', 'arsocial_lite'),
                )
            ),
            'instagram' => array(
                'instagram_like_button_size' => array(
                    'small' => esc_html__('Small', 'arsocial_lite'),
                    'medium' => esc_html__('Medium', 'arsocial_lite'),
                    'large' => esc_html__('Large', 'arsocial_lite'),
                ),
            ),
            'linkedin' => array('linkedin_counter_position' => array(
                    'right' => esc_html__('Horizontal', 'arsocial_lite'),
                    'none' => esc_html__('No Count', 'arsocial_lite'),
                )
            ),
            'viadeo' => array(
                'viadeo_button_type' => array(
                    'default' => esc_html__('Default', 'arsocial_lite'),
                    'small' => esc_html__('Button', 'arsocial_lite'),
                    'inlay' => esc_html__('Integrated', 'arsocial_lite'),
                ),
            ),
            'flipboard' => array(
                'flipboard_button_size' => array(
                    's' => esc_html__('Small', 'arsocial_lite'),
                    'm' => esc_html__('Medium', 'arsocial_lite'),
                    'l' => esc_html__('Large', 'arsocial_lite'),
                ),
                'flipboard_button_background_color' => array(
                    'b' => esc_html__('Black', 'arsocial_lite'),
                    'r' => esc_html__('Red', 'arsocial_lite'),
                    'w' => esc_html__('White', 'arsocial_lite'),
                ),
                'flipboard_button_style' => array(
                    'sw' => 'http://cdn.flipboard.com/badges/flipboard_sbsw.png',
                    'st' => 'http://cdn.flipboard.com/badges/flipboard_sbst.png',
                    'rw' => 'http://cdn.flipboard.com/badges/flipboard_sbrw.png',
                    'rt' => 'http://cdn.flipboard.com/badges/flipboard_sbrt.png',
                ),
            ),
            'flickr' => array(
                'flickr_button_color' => array(
                    'white' => esc_html__('White', 'arsocial_lite'),
                    'black' => esc_html__('Black', 'arsocial_lite')
                ),
                'flickr_button_style' => array(
                    'im-on-flickr' => esc_html__('I am on flickr', 'arsocial_lite'),
                    'see-my-photos' => esc_html__('See my photos', 'arsocial_lite'),
                    'flickr' => esc_html__('Flickr', 'arsocial_lite'),
                    'large-chiclet' => esc_html__('Large Chiclet', 'arsocial_lite'),
                    'small-chiclet' => esc_html__('Small Chiclet', 'arsocial_lite'),
                    'small-circle' => esc_html__('Circle', 'arsocial_lite'),
                )
            )
        );
        $like_network = apply_filters('arsocial_lite_default_like_networks', $like_network);
        return $like_network;
    }

    /**
     * Function for Default Options for Like,Follow And Subscribe 
     * 
     * @since v1.0
     */
    function ARSocialShareDefaultLikeOption() {
        global $arsocial_lite_like, $arsocial_lite;
        $like_options = array();

        $like_options = array(
            'facebook' => array(
                'is_fb_like' => true,
                'fb_like_url' => 'www.reputeinfosystems.com',
                'fb_button_width' => '',
                'fb_button_layout' => 'button',
                'fb_button_action_type' => 'like',
                'fb_button_show_friend_face' => true,
                'facebook_like_button_colorscheme' => 'light'
            ),
            'twitter' => array(
                'is_twitter_like' => true,
                'twitter_like_url' => 'reputeinfo',
                'twitter_show_username' => true,
                'twitter_large_button' => '',
                'twitter_opt_out_tailoring' => ''
            ),
            'youtube' => array(
                'is_youtube_like' => true,
                'is_youtube_id' => 'UCLGFoC_TNqXW2VrNF-O3oTA',
                'youtube_like_lauout' => 'dafault',
                'youtube_like_theme' => 'default',
                'youtube_like_subscriber_count' => 'default',
                'youtube_like_button_subscribe_using' => 'id'
            ),
            'pinterest' => array(
                'is_pinterest_like' => true,
                'pinterest_like_url' => '',
                'pinterest_like_custom_image_url' => '',
                'is_pinterest_round' => '',
                'is_pinterest_large' => true,
                'pinterest_like_discription' => '',
                'pinterest_like_color' => 'red',
                'pinterest_like_count_position' => 'not_shown',
                'pinterest_like_image' => '',
            ),
            'pinterest_follow' => array(
                'is_pinterest_follow' => true,
                'pinterest_follow_url' => '',
                'pinterest_follow_name' => '',
            ),
            'vk' => array(
                'is_vk_like' => true,
                'vk_button_layout' => '',
                'vk_button_name' => 'normal',
                'vk_button_url' => 'button',
            ),
            'instagram' => array(
                'is_instagram_like' => true,
                'instagram_like_username' => 'reputeinfo',
            ),
            'linkedin' => array(
                'is_linkedin_like' => true,
                'linkedin_like_username' => '3544407',
                'linkedin_counter_position' => 'none',
            ),
            'viadeo' => array(
                'is_viadeo_like' => true,
                'viadeo_like_url' => '',
                'viadeo_button_type' => 'default',
            ),
            'flipboard' => array(
                'is_flipboard_like' => true,
                'flipboard_like_username' => '',
                'flipboard_button_color' => 'b',
                'flipboard_button_style' => 'sw',
                'flipboard_button_size' => 's',
            ),
            'flickr' => array(
                'is_flickr_like' => true,
                'flickr_like_username' => '',
                'flickr_button_color' => 'white',
                'flickr_button_style' => 'flickr',
                'flickr_button_height' => '30',
                'flickr_button_weight' => '80',
            ),
        );
        $like_options = apply_filters('arsocial_lite_default_like_networks_options', $like_options);
    }

    function ars_linkedin_language_array() {
        $ars_lite_linkedin_language_array = array();
        $ars_lite_linkedin_language_array = apply_filters('ars_lite_linkedin_language_array', array(
            "en_US" => esc_html__('English', 'arsocial_lite'),
            "ar_AE" => esc_html__('Arabic', 'arsocial_lite'),
            "zh_CN" => esc_html__('Chinese - Simplified', 'arsocial_lite'),
            "zh_TW" => esc_html__('Chinese - Traditional', 'arsocial_lite'),
            "cs_CZ" => esc_html__('Czech', 'arsocial_lite'),
            "da_DK" => esc_html__('Danish', 'arsocial_lite'),
            "nl_NL" => esc_html__('Dutch', 'arsocial_lite'),
            "fr_FR" => esc_html__('French', 'arsocial_lite'),
            "de_DE" => esc_html__('German', 'arsocial_lite'),
            "in_ID" => esc_html__('Indonesian', 'arsocial_lite'),
            "it_IT" => esc_html__('Italian', 'arsocial_lite'),
            "ja_JP" => esc_html__('Japanese', 'arsocial_lite'),
            "ko_KR" => esc_html__('Korean', 'arsocial_lite'),
            "ms_MY" => esc_html__('Malay', 'arsocial_lite'),
            "no_NO" => esc_html__('Norwegian', 'arsocial_lite'),
            "pl_PL" => esc_html__('Polish', 'arsocial_lite'),
            "pt_BR" => esc_html__('Portuguese', 'arsocial_lite'),
            "ro_RO" => esc_html__('Romanian', 'arsocial_lite'),
            "ru_RU" => esc_html__('Russian', 'arsocial_lite'),
            "es_ES" => esc_html__('Spanish', 'arsocial_lite'),
            "sv_SE" => esc_html__('Swedish', 'arsocial_lite'),
            "tl_PH" => esc_html__('Tagalog', 'arsocial_lite'),
            "th_TH" => esc_html__('Thai', 'arsocial_lite'),
            "tr_TR" => esc_html__('Turkish', 'arsocial_lite'),
        ));

        return $ars_lite_linkedin_language_array;
    }

    function ars_facebook_language_array() {
        $ars_lite_facebook_language_array = array();
        $ars_lite_facebook_language_array = apply_filters('ars_lite_facebook_language_array', array(
            'af_ZA' => esc_html__('Afrikaans', 'arsocial_lite'),
            'ak_GH' => esc_html__('Akan', 'arsocial_lite'),
            'am_ET' => esc_html__('Amharic', 'arsocial_lite'),
            'ar_AR' => esc_html__('Arabic', 'arsocial_lite'),
            'as_IN' => esc_html__('Assamese', 'arsocial_lite'),
            'ay_BO' => esc_html__('Aymara', 'arsocial_lite'),
            'az_AZ' => esc_html__('Azerbaijani', 'arsocial_lite'),
            'be_BY' => esc_html__('Belarusian', 'arsocial_lite'),
            'bg_BG' => esc_html__('Bulgarian', 'arsocial_lite'),
            'bn_IN' => esc_html__('Bengali', 'arsocial_lite'),
            'br_FR' => esc_html__('Breton', 'arsocial_lite'),
            'bs_BA' => esc_html__('Bosnian', 'arsocial_lite'),
            'ca_ES' => esc_html__('Catalan', 'arsocial_lite'),
            'cb_IQ' => esc_html__('Sorani Kurdish', 'arsocial_lite'),
            'ck_US' => esc_html__('Cherokee', 'arsocial_lite'),
            'co_FR' => esc_html__('Corsican', 'arsocial_lite'),
            'cs_CZ' => esc_html__('Czech', 'arsocial_lite'),
            'cx_PH' => esc_html__('Cebuano', 'arsocial_lite'),
            'cy_GB' => esc_html__('Welsh', 'arsocial_lite'),
            'da_DK' => esc_html__('Danish', 'arsocial_lite'),
            'de_DE' => esc_html__('German', 'arsocial_lite'),
            'el_GR' => esc_html__('Greek', 'arsocial_lite'),
            'en_GB' => esc_html__('English (UK)', 'arsocial_lite'),
            'en_IN' => esc_html__('English (India)', 'arsocial_lite'),
            'en_PI' => esc_html__('English (Pirate)', 'arsocial_lite'),
            'en_UD' => esc_html__('English (Upside Down)', 'arsocial_lite'),
            'en_US' => esc_html__('English (US)', 'arsocial_lite'),
            'eo_EO' => esc_html__('Esperanto', 'arsocial_lite'),
            'es_CL' => esc_html__('Spanish (Chile)', 'arsocial_lite'),
            'es_CO' => esc_html__('Spanish (Colombia)', 'arsocial_lite'),
            'es_ES' => esc_html__('Spanish (Spain)', 'arsocial_lite'),
            'es_LA' => esc_html__('Spanish', 'arsocial_lite'),
            'es_MX' => esc_html__('Spanish (Mexico)', 'arsocial_lite'),
            'es_VE' => esc_html__('Spanish (Venezuela)', 'arsocial_lite'),
            'et_EE' => esc_html__('Estonian', 'arsocial_lite'),
            'eu_ES' => esc_html__('Basque', 'arsocial_lite'),
            'fa_IR' => esc_html__('Persian', 'arsocial_lite'),
            'fb_LT' => esc_html__('Leet Speak', 'arsocial_lite'),
            'ff_NG' => esc_html__('Fulah', 'arsocial_lite'),
            'fi_FI' => esc_html__('Finnish', 'arsocial_lite'),
            'fo_FO' => esc_html__('Faroese', 'arsocial_lite'),
            'fr_CA' => esc_html__('French (Canada)', 'arsocial_lite'),
            'fr_FR' => esc_html__('French (France)', 'arsocial_lite'),
            'fy_NL' => esc_html__('Frisian', 'arsocial_lite'),
            'ga_IE' => esc_html__('Irish', 'arsocial_lite'),
            'gl_ES' => esc_html__('Galician', 'arsocial_lite'),
            'gn_PY' => esc_html__('Guarani', 'arsocial_lite'),
            'gu_IN' => esc_html__('Gujarati', 'arsocial_lite'),
            'gx_GR' => esc_html__('Classical Greek', 'arsocial_lite'),
            'ha_NG' => esc_html__('Hausa', 'arsocial_lite'),
            'ha_NG' => esc_html__('Hausa', 'arsocial_lite'),
            'he_IL' => esc_html__('Hebrew', 'arsocial_lite'),
            'hi_IN' => esc_html__('Hindi', 'arsocial_lite'),
            'hr_HR' => esc_html__('Croatian', 'arsocial_lite'),
            'hu_HU' => esc_html__('Hungarian', 'arsocial_lite'),
            'id_ID' => esc_html__('Indonesian', 'arsocial_lite'),
            'ig_NG' => esc_html__('Igbo', 'arsocial_lite'),
            'is_IS' => esc_html__('Icelandic', 'arsocial_lite'),
            'it_IT' => esc_html__('Italian', 'arsocial_lite'),
            'ja_JP' => esc_html__('Japanese', 'arsocial_lite'),
            'ja_KS' => esc_html__('Japanese (Kansai)', 'arsocial_lite'),
            'jv_ID' => esc_html__('Javanese', 'arsocial_lite'),
            'ka_GE' => esc_html__('Georgian', 'arsocial_lite'),
            'km_KH' => esc_html__('Khmer', 'arsocial_lite'),
            'kn_IN' => esc_html__('Kannada', 'arsocial_lite'),
            'ko_KR' => esc_html__('Korean', 'arsocial_lite'),
            'ku_TR' => esc_html__('Kurdish (Kurmanji)', 'arsocial_lite'),
            'ky_KG' => esc_html__('Kyrgyz', 'arsocial_lite'),
            'la_VA' => esc_html__('Latin', 'arsocial_lite'),
            'lg_UG' => esc_html__('Ganda', 'arsocial_lite'),
            'li_NL' => esc_html__('Limburgish', 'arsocial_lite'),
            'ln_CD' => esc_html__('Lingala', 'arsocial_lite'),
            'lo_LA' => esc_html__('Lao', 'arsocial_lite'),
            'lt_LT' => esc_html__('Lithuanian', 'arsocial_lite'),
            'lv_LV' => esc_html__('Latvian', 'arsocial_lite'),
            'mg_MG' => esc_html__('Malagasy', 'arsocial_lite'),
            'mi_NZ' => esc_html__('Maori', 'arsocial_lite'),
            'mk_MK' => esc_html__('Macedonian', 'arsocial_lite'),
            'ml_IN' => esc_html__('Malayalam', 'arsocial_lite'),
            'mn_MN' => esc_html__('Mongolian', 'arsocial_lite'),
            'mr_IN' => esc_html__('Marathi', 'arsocial_lite'),
            'ms_MY' => esc_html__('Malay', 'arsocial_lite'),
            'mt_MT' => esc_html__('Maltese', 'arsocial_lite'),
            'my_MM' => esc_html__('Burmese', 'arsocial_lite'),
            'nb_NO' => esc_html__('Norwegian (bokmal)', 'arsocial_lite'),
            'nd_ZW' => esc_html__('Ndebele', 'arsocial_lite'),
            'ne_NP' => esc_html__('Nepali', 'arsocial_lite'),
            'nl_BE' => esc_html__('Dutch (België)', 'arsocial_lite'),
            'nl_NL' => esc_html__('Dutch', 'arsocial_lite'),
            'nn_NO' => esc_html__('Norwegian (nynorsk)', 'arsocial_lite'),
            'ny_MW' => esc_html__('Chewa', 'arsocial_lite'),
            'or_IN' => esc_html__('Oriya', 'arsocial_lite'),
            'pa_IN' => esc_html__('Punjabi', 'arsocial_lite'),
            'pl_PL' => esc_html__('Polish', 'arsocial_lite'),
            'ps_AF' => esc_html__('Pashto', 'arsocial_lite'),
            'pt_BR' => esc_html__('Portuguese (Brazil)', 'arsocial_lite'),
            'pt_PT' => esc_html__('Portuguese (Portugal)', 'arsocial_lite'),
            'qu_PE' => esc_html__('Quechua', 'arsocial_lite'),
            'rm_CH' => esc_html__('Romansh', 'arsocial_lite'),
            'ro_RO' => esc_html__('Romanian', 'arsocial_lite'),
            'ru_RU' => esc_html__('Russian', 'arsocial_lite'),
            'rw_RW' => esc_html__('Kinyarwanda', 'arsocial_lite'),
            'sa_IN' => esc_html__('Sanskrit', 'arsocial_lite'),
            'sc_IT' => esc_html__('Sardinian', 'arsocial_lite'),
            'se_NO' => esc_html__('Northern Sámi', 'arsocial_lite'),
            'si_LK' => esc_html__('Sinhala', 'arsocial_lite'),
            'sk_SK' => esc_html__('Slovak', 'arsocial_lite'),
            'sl_SI' => esc_html__('Slovenian', 'arsocial_lite'),
            'sn_ZW' => esc_html__('Shona', 'arsocial_lite'),
            'so_SO' => esc_html__('Somali', 'arsocial_lite'),
            'sq_AL' => esc_html__('Albanian', 'arsocial_lite'),
            'sr_RS' => esc_html__('Serbian', 'arsocial_lite'),
            'sv_SE' => esc_html__('Swedish', 'arsocial_lite'),
            'sw_KE' => esc_html__('Swahili', 'arsocial_lite'),
            'sy_SY' => esc_html__('Syriac', 'arsocial_lite'),
            'sz_PL' => esc_html__('Silesian', 'arsocial_lite'),
            'ta_IN' => esc_html__('Tamil', 'arsocial_lite'),
            'te_IN' => esc_html__('Telugu', 'arsocial_lite'),
            'tg_TJ' => esc_html__('Tajik', 'arsocial_lite'),
            'th_TH' => esc_html__('Thai', 'arsocial_lite'),
            'tk_TM' => esc_html__('Turkmen', 'arsocial_lite'),
            'tl_PH' => esc_html__('Filipino', 'arsocial_lite'),
            'tl_ST' => esc_html__('Klingon', 'arsocial_lite'),
            'tr_TR' => esc_html__('Turkish', 'arsocial_lite'),
            'tt_RU' => esc_html__('Tatar', 'arsocial_lite'),
            'tz_MA' => esc_html__('Tamazight', 'arsocial_lite'),
            'uk_UA' => esc_html__('Ukrainian', 'arsocial_lite'),
            'ur_PK' => esc_html__('Urdu', 'arsocial_lite'),
            'uz_UZ' => esc_html__('Uzbek', 'arsocial_lite'),
            'vi_VN' => esc_html__('Vietnamese', 'arsocial_lite'),
            'wo_SN' => esc_html__('Wolof', 'arsocial_lite'),
            'xh_ZA' => esc_html__('Xhosa', 'arsocial_lite'),
            'yi_DE' => esc_html__('Yiddish', 'arsocial_lite'),
            'yo_NG' => esc_html__('Yoruba', 'arsocial_lite'),
            'zh_CN' => esc_html__('Simplified Chinese (China)', 'arsocial_lite'),
            'zh_HK' => esc_html__('Traditional Chinese (Hong Kong)', 'arsocial_lite'),
            'zh_TW' => esc_html__('Traditional Chinese (Taiwan)', 'arsocial_lite'),
            'zu_ZA' => esc_html__('Zulu', 'arsocial_lite'),
            'zz_TR' => esc_html__('Zazaki', 'arsocial_lite'),
        ));

        return $ars_lite_facebook_language_array;
    }

    function ars_twitter_language_array() {
        $twitter_lang = array(
            "automatic" => esc_html__('Automatic', 'arsocial_lite'),
            "fr" => esc_html__('French', 'arsocial_lite'),
            "en" => esc_html__('English', 'arsocial_lite'),
            "ar" => esc_html__('Arabic', 'arsocial_lite'),
            "ja" => esc_html__('Japanese', 'arsocial_lite'),
            "es" => esc_html__('Spanish', 'arsocial_lite'),
            "de" => esc_html__('German', 'arsocial_lite'),
            "it" => esc_html__('Italian', 'arsocial_lite'),
            "id" => esc_html__('Indonesian', 'arsocial_lite'),
            "pt" => esc_html__('Portuguese', 'arsocial_lite'),
            "ko" => esc_html__('Korean', 'arsocial_lite'),
            "tr" => esc_html__('Turkish', 'arsocial_lite'),
            "ru" => esc_html__('Russian', 'arsocial_lite'),
            "nl" => esc_html__('Dutch', 'arsocial_lite'),
            "fil" => esc_html__('Filipino', 'arsocial_lite'),
            "msa" => esc_html__('Malay', 'arsocial_lite'),
            "zh-tw" => esc_html__('Traditional Chinese', 'arsocial_lite'),
            "zh-cn" => esc_html__('Simplified Chinese', 'arsocial_lite'),
            "hi" => esc_html__('Hindi', 'arsocial_lite'),
            "no" => esc_html__('Norwegian', 'arsocial_lite'),
            "sv" => esc_html__('Swedish', 'arsocial_lite'),
            "fi" => esc_html__('Finnish', 'arsocial_lite'),
            "da" => esc_html__('Danish', 'arsocial_lite'),
            "pl" => esc_html__('Polish', 'arsocial_lite'),
            "hu" => esc_html__('Hungarian', 'arsocial_lite'),
            "fa" => esc_html__('Farsi', 'arsocial_lite'),
            "he" => esc_html__('Hebrew', 'arsocial_lite'),
            "ur" => esc_html__('Urdu', 'arsocial_lite'),
            "th" => esc_html__('Thai', 'arsocial_lite')
        );

        return apply_filters('arsocial_lite_twitter_languages', $twitter_lang);
    }

    /**
     * Enqueueing Front Styles
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Front_CSS() {
        if (!is_admin()) {
            global $arsocial_lite_version;
            wp_register_style('arsocial_lite_front_css', ARSOCIAL_LITE_CSS_URL . '/arsocialshare_front.css', array(), $arsocial_lite_version);
            wp_register_style('arsocial_lite_effects_css', ARSOCIAL_LITE_CSS_URL . '/arsocialshare_effects.css', array(), $arsocial_lite_version);

            wp_register_style('arsocial_lite_socicon_css', ARSOCIAL_LITE_CSS_URL . '/arsocialshareicons.css', array(), $arsocial_lite_version);

            wp_register_style('arsocial_lite_theme-lite_square', ARSOCIAL_LITE_THEME_CSS_URL . '/arsocialshare_lite_theme-square.css', array(), $arsocial_lite_version);
            wp_register_style('arsocial_lite_theme-lite_default', ARSOCIAL_LITE_THEME_CSS_URL . '/arsocialshare_lite_theme-default.css', array(), $arsocial_lite_version);
        }
    }

    /**
     * Enqueueing Front Scripts
     * 
     * @since v1.0
     */
    function ARSocial_Lite_Front_JS() {

        if (!is_admin()) {
            global $arsocial_lite_version;
            wp_register_script('ars-lite-common-front-js', ARSOCIAL_LITE_SCRIPT_URL . '/ars_common_front.js', array(), $arsocial_lite_version);
            wp_register_script('ars-lite-share-front-js', ARSOCIAL_LITE_SCRIPT_URL . '/ars_share_front.js', array(), $arsocial_lite_version);
            wp_register_script('ars-lite-like-front-js', ARSOCIAL_LITE_SCRIPT_URL . '/ars_like_front.js', array(), $arsocial_lite_version);
            wp_register_script('ars-lite-fan-counter-js', ARSOCIAL_LITE_SCRIPT_URL . '/ars_fan_counter_front.js', array(), $arsocial_lite_version);

            wp_register_script('angular', ARSOCIAL_LITE_SCRIPT_URL . '/angular.min.js', array(), $arsocial_lite_version);
            
            wp_register_script('ars-lite-locker-front-js', ARSOCIAL_LITE_SCRIPT_URL . '/ars_locker_front.js', array(), $arsocial_lite_version);
            wp_register_script('foggy', ARSOCIAL_LITE_SCRIPT_URL . '/jquery.foggy.min.js', array(), $arsocial_lite_version);

            
            wp_register_script('bpopup', ARSOCIAL_LITE_SCRIPT_URL . '/jquery.bpopup.min.js', array(), $arsocial_lite_version);
        }
    }

    function ars_lite_enqueue_js_css() {

        global $post;

        $ars_common_js_css = false;
        $ars_share_js_css = false;
        $ars_like_js_css = false;
        $ars_fan_js_css = false;
        $ars_locker_js_css = false;

        $post_content = isset($post->post_content) ? $post->post_content : '';

        // ARSocial_Lite_Share
        $parts = @explode("[ARSocial_Lite_Share", $post_content);
        if (is_array($parts) && key_exists(1, $parts)) {
            $myidpart = @explode("id=", $parts[1]);
            if (isset($myidpart) && key_exists(1, $myidpart)) {
                $myid = @explode("]", $myidpart[1]);
            }
        }

        if (!is_admin()) {
            global $wp_query;
            $posts = $wp_query->posts;

            $pattern = '\[(\[?)(ARSocial_Lite_Share)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
            $frm_ids = array();
            if (is_array($posts)) {
                foreach ($posts as $post) {
                    if (preg_match_all('/' . $pattern . '/s', $post->post_content, $matches) && array_key_exists(2, $matches) && in_array('ARSocial_Lite_Share', $matches[2])) {
                        $frm_ids[] = $matches;
                        //break;	
                    }
                }
                $formids = array();
                if (is_array($frm_ids) && count($frm_ids) > 0) {

                    foreach ($frm_ids as $mat) {

                        if (is_array($mat) and count($mat) > 0) {
                            foreach ($mat as $k => $v) {

                                foreach ($v as $key => $val) {
                                    $parts = explode("id=", $val);
                                    if ($parts > 0 && isset($parts[1])) {

                                        if (stripos(@$parts[1], ']') !== false) {
                                            $partsnew = explode("]", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else if (stripos(@$parts[1], ' ') !== false) {

                                            $partsnew = explode(" ", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else {
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $newvalarr = array();
            if (isset($formids) and is_array($formids) && count($formids) > 0) {
                foreach ($formids as $newkey => $newval) {
                    $newval = str_replace('"', '', $newval);
                    $newval = str_replace("'", "", $newval);
                    if (stripos($newval, ' ') !== false) {
                        $partsnew = explode(" ", $newval);
                        $newvalarr[] = $partsnew[0];
                    } else
                        $newvalarr[] = $newval;
                }
            }

            if (isset($newvalarr) && !empty($newvalarr)) {
                $ars_common_js_css = true;
                $ars_share_js_css = true;
            }
        }

        //ARSocial_Lite_Like 
        $parts = @explode("[ARSocial_Lite_Like", $post_content);
        if (is_array($parts) && key_exists(1, $parts)) {
            $myidpart = @explode("id=", $parts[1]);
            if (isset($myidpart) && key_exists(1, $myidpart)) {
                $myid = @explode("]", $myidpart[1]);
            }
        }

        if (!is_admin()) {
            global $wp_query;
            $posts = $wp_query->posts;
            $pattern = '\[(\[?)(ARSocial_Lite_Like)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
            $frm_ids = array();
            if (is_array($posts)) {
                foreach ($posts as $post) {
                    if (preg_match_all('/' . $pattern . '/s', $post->post_content, $matches) && array_key_exists(2, $matches) && (in_array('ARSocial_Lite_Like', $matches[2]))) {
                        $frm_ids[] = $matches;
                        //break;	
                    }
                }
                $formids = array();
                if (is_array($frm_ids) && count($frm_ids) > 0) {

                    foreach ($frm_ids as $mat) {

                        if (is_array($mat) and count($mat) > 0) {
                            foreach ($mat as $k => $v) {

                                foreach ($v as $key => $val) {
                                    $parts = explode("id=", $val);
                                    if ($parts > 0 && isset($parts[1])) {

                                        if (stripos(@$parts[1], ']') !== false) {
                                            $partsnew = explode("]", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else if (stripos(@$parts[1], ' ') !== false) {

                                            $partsnew = explode(" ", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else {
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $newvalarr = array();
            if (isset($formids) and is_array($formids) && count($formids) > 0) {
                foreach ($formids as $newkey => $newval) {
                    $newval = str_replace('"', '', $newval);
                    $newval = str_replace("'", "", $newval);
                    if (stripos($newval, ' ') !== false) {
                        $partsnew = explode(" ", $newval);
                        $newvalarr[] = $partsnew[0];
                    } else
                        $newvalarr[] = $newval;
                }
            }

            if (isset($newvalarr) && !empty($newvalarr)) {
                $ars_common_js_css = true;
                $ars_like_js_css = true;
            }
        }

        //ARSocial_Lite_Fan 
        $parts = @explode("[ARSocial_Lite_Fan", $post_content);
        if (is_array($parts) && key_exists(1, $parts)) {
            $myidpart = @explode("id=", $parts[1]);
            if (isset($myidpart) && key_exists(1, $myidpart)) {
                $myid = @explode("]", $myidpart[1]);
            }
        }

        if (!is_admin()) {
            global $wp_query;
            $posts = $wp_query->posts;
            $pattern = '\[(\[?)(ARSocial_Lite_Fan)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
            $frm_ids = array();
            if (is_array($posts)) {
                foreach ($posts as $post) {
                    if (preg_match_all('/' . $pattern . '/s', $post->post_content, $matches) && array_key_exists(2, $matches) && (in_array('ARSocial_Lite_Fan', $matches[2]) )) {
                        $frm_ids[] = $matches;
                    }
                }
                $formids = array();
                if (is_array($frm_ids) && count($frm_ids) > 0) {

                    foreach ($frm_ids as $mat) {

                        if (is_array($mat) and count($mat) > 0) {
                            foreach ($mat as $k => $v) {

                                foreach ($v as $key => $val) {
                                    $parts = explode("id=", $val);
                                    if ($parts > 0 && isset($parts[1])) {

                                        if (stripos(@$parts[1], ']') !== false) {
                                            $partsnew = explode("]", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else if (stripos(@$parts[1], ' ') !== false) {

                                            $partsnew = explode(" ", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else {
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $newvalarr = array();
            if (isset($formids) and is_array($formids) && count($formids) > 0) {
                foreach ($formids as $newkey => $newval) {
                    $newval = str_replace('"', '', $newval);
                    $newval = str_replace("'", "", $newval);
                    if (stripos($newval, ' ') !== false) {
                        $partsnew = explode(" ", $newval);
                        $newvalarr[] = $partsnew[0];
                    } else
                        $newvalarr[] = $newval;
                }
            }
            if (isset($newvalarr) && !empty($newvalarr)) {
                $ars_common_js_css = true;
                $ars_fan_js_css = true;
            }
        }



        //ARSocial_Lite_Locker  
        $parts = @explode("[ARSocial_Lite_Locker", $post_content);
        if (is_array($parts) && key_exists(1, $parts)) {
            $myidpart = @explode("id=", $parts[1]);
            if (isset($myidpart) && key_exists(1, $myidpart)) {
                $myid = @explode("]", $myidpart[1]);
            }
        }

        if (!is_admin()) {
            global $wp_query;
            $posts = $wp_query->posts;
            $pattern = '\[(\[?)(ARSocial_Lite_Locker)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
            $frm_ids = array();
            if (is_array($posts)) {
                foreach ($posts as $post) {
                    if (preg_match_all('/' . $pattern . '/s', $post->post_content, $matches) && array_key_exists(2, $matches) && (in_array('ARSocial_Lite_Locker', $matches[2]))) {
                        $frm_ids[] = $matches;
                        //break;	
                    }
                }
                $formids = array();
                if (is_array($frm_ids) && count($frm_ids) > 0) {

                    foreach ($frm_ids as $mat) {

                        if (is_array($mat) and count($mat) > 0) {
                            foreach ($mat as $k => $v) {

                                foreach ($v as $key => $val) {
                                    $parts = explode("id=", $val);
                                    if ($parts > 0 && isset($parts[1])) {

                                        if (stripos(@$parts[1], ']') !== false) {
                                            $partsnew = explode("]", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else if (stripos(@$parts[1], ' ') !== false) {

                                            $partsnew = explode(" ", $parts[1]);
                                            $formids[] = $partsnew[0];
                                        } else {
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $newvalarr = array();
            if (isset($formids) and is_array($formids) && count($formids) > 0) {
                foreach ($formids as $newkey => $newval) {
                    $newval = str_replace('"', '', $newval);
                    $newval = str_replace("'", "", $newval);
                    if (stripos($newval, ' ') !== false) {
                        $partsnew = explode(" ", $newval);
                        $newvalarr[] = $partsnew[0];
                    } else
                        $newvalarr[] = $newval;
                }
            }


            if (isset($newvalarr) && !empty($newvalarr)) {
                $ars_common_js_css = true;

                $ars_locker_js_css = true;

                global $arsocial_lite_locker;
                $ua = $_SERVER['HTTP_USER_AGENT'];
                $browser = $arsocial_lite_locker->getBrowser($ua);
                if (in_array($browser['browser_name'], array('Internet Explorer', 'Apple Safari'))) {
                    wp_enqueue_script('foggy');
                }
            }
        }

        if ($ars_common_js_css) {
            $this->ars_common_enqueue_js_css();
        }

        if ($ars_share_js_css) {
            wp_enqueue_script('ars-lite-share-front-js');
        }

        if ($ars_like_js_css) {
            wp_enqueue_script('ars-lite-like-front-js');
        }

        if ($ars_fan_js_css) {
            wp_enqueue_script('ars-lite-fan-counter-js');
        }
        if ($ars_locker_js_css) {
            wp_enqueue_script('ars-lite-locker-front-js');
        }
    }

    function ARSocial_Lite_Front_Assets() {
        global $post, $arsocial_lite_locker;
        global $post;
        $ars_locker_status = false;
        $ars_common_js_css = false;
        $options = get_option('arslite_global_settings');
        $gs_options = maybe_unserialize($options);
        $share_assets = isset($gs_options['global_share_assets']) ? $gs_options['global_share_assets'] : 0;
        $like_assets = isset($gs_options['global_like_assets']) ? $gs_options['global_like_assets'] : 0;
        $fan_assets = isset($gs_options['global_fan_assets']) ? $gs_options['global_fan_assets'] : 0;

        $locker_assets = isset($gs_options['global_locker_assets']) ? $gs_options['global_locker_assets'] : 0;
        if ($share_assets == '1') {
            $ars_common_js_css = true;
            wp_enqueue_script('ars-lite-share-front-js');

            wp_enqueue_style('arsocial_lite_theme-lite_default');
            wp_enqueue_style('arsocial_lite_theme-rounded');
            wp_enqueue_style('arsocial_lite_theme-bordered');
            wp_enqueue_style('arsocial_lite_theme-flat_rounded');
            wp_enqueue_style('arsocial_lite_theme-blank_round');
            wp_enqueue_style('arsocial_lite_theme-lite_square');
            wp_enqueue_style('arsocial_lite_theme-rolling');
        }
        if ($like_assets == '1') {
            $ars_common_js_css = true;
            wp_enqueue_script('ars-lite-like-front-js');
        }
        if ($fan_assets == '1') {
            $ars_common_js_css = true;
            wp_enqueue_script('ars-lite-fan-counter-js');
        }
        if ($locker_assets == '1') {
            $ars_common_js_css = true;
            $ars_locker_status = true;
        }
        if ($ars_common_js_css) {
            $this->ars_common_enqueue_js_css();
            if($ars_locker_status)
            {
                wp_enqueue_script('ars-lite-locker-front-js');
                $ua = $_SERVER['HTTP_USER_AGENT'];
                $browser = $arsocial_lite_locker->getBrowser($ua);
                if (in_array($browser['browser_name'], array('Internet Explorer', 'Apple Safari'))) {
                    wp_enqueue_script('foggy');
                }
            }
        }
    }

    function ars_common_enqueue_js_css() {
        wp_enqueue_script('angular');
        wp_enqueue_script('jquery');
        wp_enqueue_script('ars-lite-common-front-js');

        wp_enqueue_script('bpopup');

        wp_enqueue_style('arsocial_lite_front_css');
        wp_enqueue_style('arsocial_lite_effects_css');
        wp_enqueue_style('arsocial_lite_socicon_css');
    }

    /**
     * Wordpress Special Pages Lists for Social Networks Display Settings
     * 
     * @since v1.0
     */
    function arsocialshare_wp_special_pages() {
        $special_pages = apply_filters('arsocial_lite_wp_special_page', array(
            'archive' => array(
                'name' => 'Archive',
                'enable' => true,
                'pattern' => 'archive'
            ),
            'search_result' => array(
                'name' => 'Search Result',
                'enable' => true,
                'pattern' => 'search-result'
            ),
            '404' => array(
                'name' => '404',
                'enable' => true,
                'pattern' => '404'
            ),
            'category' => array(
                'name' => 'Category',
                'enable' => true,
                'pattern' => 'category'
            ),
            'author' => array(
                'name' => 'Author',
                'enable' => true,
                'pattern' => 'author'
            ),
            'attachment' => array(
                'name' => 'Attachment',
                'enable' => true,
                'pattern' => 'attachment'
            ),
            'taxonomy' => array(
                'name' => 'Taxonomy',
                'enable' => true,
                'pattern' => 'taxonomy'
            )
        ));

        return $special_pages;
    }

    /**
     * 
     * Function of lists of custom posts type which are excluded from display settings.
     * 
     * @since v1.0
     */
    function arsocial_lite_exclude_cpt_ds() {
        $excluded_cpt = apply_filters('arsocial_lite_exclude_cpt_ds', array(
            'product'
        ));

        return $excluded_cpt;
    }

    function arsocial_lite_set_schedule_interval() {
        $intervals['minute'] = array(
            'interval' => 60,
            'display' => 'Once Minute'
        );
        return $intervals;
    }

    function arsocial_lite_set_schedule() {
        $timestamp = wp_next_scheduled('arsocial_lite_load_cache');
        if ($timestamp == false) {
            wp_schedule_event(time(), 'minute', 'arsocial_lite_load_cache');
        }
    }

    function arsocial_lite_load_cache() {
        global $arsocial_lite_fan;
        update_option('wp_arslite_time', time());
        $arsocial_lite_fan->ARSocialShareLoadLiveData();
    }

    /**
     * Function of lists network which have api for url share counter
     * @since v1.0
     */
    function ars_lite_share_networklist_sharecounter() {
        $ars_lite_share_networklist_sharecounter = apply_filters('ars_lite_share_networklist_sharecounter', array(
            'linkedin',
            'mix',
            'reddit',
            'buffer',
            'pocket',
            'xing',
            'odnoklassniki',
            'meneame',
            'vk',
            'viadeo',
        ));

        return $ars_lite_share_networklist_sharecounter;
    }

    /**
     * ARSocialShare Default Settings
     * 
     * @since v1.0
     */
    function arsocialshare_default_settings() {
        $default_options = apply_filters('arsocial_lite_share_default_settings', array(
            'socialshare' => array(
                'network_order' => array(
                    'facebook', 'twitter', 'linkedin', 'pinterest', 'buffer', 'amazon', 'flipboard', 'vk', 'box', 'evernote', 'blogger', 'pocket', 'meneame', 'mix', 'hackernews', 'yummly', 'xing', 'myspace', 'aol', 'reddit', 'odnoklassniki', 'viadeo', 'email', 'yahoo', 'gmail', 'whatsapp', 'arsprint'
                ),
                'styling_options' => array(
                    'skin' => 'default',
                    'button_style' => 'name_with_icon',
                    'hover_effect' => 'effect1',
                    'remove_space' => 'no',
                    'button_width' => 'automatic',
                    'more_button_after' => '5',
                    'more_button_style' => 'plus_icon',
                    'more_button_action' => 'display_popup',
                    'show_counter' => 'yes',
                )
            )
        ));
        return $default_options;
    }

    function ars_get_enable_networks() {
        $global_settings = get_option('arslite_global_settings', array());
        $global_settings = maybe_unserialize($global_settings);
        $enableNetworks = array();
        if (isset($global_settings['facebook']['app_id']) && !empty($global_settings['facebook']['app_id'])) {
            $enableNetworks['facebook'] = 'facebook';
        }

        if ( isset( $global_settings['linkedin'] ) ) {
			$linkedin_client_id     = isset( $global_settings['linkedin']['linkedin_api_key'] ) ? $global_settings['linkedin']['linkedin_api_key'] : '';
			$linkedin_client_secret = isset( $global_settings['linkedin']['linkedin_client_secret'] ) ? $global_settings['linkedin']['linkedin_client_secret'] : '';
			if ( $linkedin_client_id != '' && $linkedin_client_secret != '' ) {
				$enableNetworks['linkedin']    = 'linkedin';
				$enableNetworksApi['linkedin'] = $global_settings['linkedin'];
			}
		}
		
        if (isset($global_settings['twitter'])) {
            $twitter_api_key = (isset($global_settings['twitter']['twitter_api_key']) && !empty($global_settings['twitter']['twitter_api_key'])) ? true : false;
            $twitter_api_secret = (isset($global_settings['twitter']['twitter_api_secret']) && !empty($global_settings['twitter']['twitter_api_secret'])) ? true : false;
            $twitter_access_token = (isset($global_settings['twitter']['twitter_access_token']) && !empty($global_settings['twitter']['twitter_access_token'])) ? true : false;
            $twitter_access_token_secret = (isset($global_settings['twitter']['twitter_access_token_secret']) && !empty($global_settings['twitter']['twitter_access_token_secret'])) ? true : false;
            if ($twitter_api_key && $twitter_api_secret && $twitter_access_token && $twitter_access_token_secret) {
                $enableNetworks['twitter'] = 'twitter';
            }
        }
        return $enableNetworks;
    }

    /**
     * For Global Fonts
     */
    function ars_get_enqueue_fonts($type = '') {
        global $ars_lite_googlefontbaseurl;
        $arsCustomCss = "";
        if (!empty($type)) {
            $arsFonts = $this->ars_get_fonts();
            $options = get_option('arslite_global_settings');
            $gs_options = maybe_unserialize($options);
            $share_fonts = isset($gs_options['share_fonts']) ? $gs_options['share_fonts'] : 'Helvetica';
            $like_fonts = isset($gs_options['like_fonts']) ? $gs_options['like_fonts'] : 'Helvetica';
            $fan_fonts = isset($gs_options['fan_fonts']) ? $gs_options['fan_fonts'] : 'Helvetica';
            $locker_fonts = isset($gs_options['locker_fonts']) ? $gs_options['locker_fonts'] : 'Helvetica';
            $googleFonts = array();
            if (isset($arsFonts['google']['fonts']) && !empty($arsFonts['google']['fonts'])) {
                switch ($type) {
                    case 'share':
                        if (in_array($share_fonts, $arsFonts['google']['fonts'])) {

                            $arsCustomCss .= '<link rel="stylesheet" type="text/css" href="' . $ars_lite_googlefontbaseurl . str_replace(' ', '+', $share_fonts) . '" />';
                            $arsCustomCss .= "<style>.arsocial_lite_buttons_container, .arsocialshare_buttons_wrapper{font-family: '{$share_fonts}' !important;}</style>";
                        }
                        break;
                    case 'like':
                        if (in_array($like_fonts, $arsFonts['google']['fonts'])) {

                            $arsCustomCss .= '<link rel="stylesheet" type="text/css" href="' . $ars_lite_googlefontbaseurl . str_replace(' ', '+', $like_fonts) . '" />';
                            $arsCustomCss .= "<style>.arsocial_lite_like_button_wrapper, .arsocial_lite_like_popup_wrapper, .arsociallike_fly_in_wrapper{font-family: '{$like_fonts}' !important;}</style>";
                        }
                        break;
                    case 'fan':
                        if (in_array($fan_fonts, $arsFonts['google']['fonts'])) {

                            $arsCustomCss .= '<link rel="stylesheet" type="text/css" href="' . $ars_lite_googlefontbaseurl . str_replace(' ', '+', $fan_fonts) . '" />';
                            $arsCustomCss .= "<style>.ars_lite_fan_main_wrapper{font-family: '{$fan_fonts}' !important;}</style>";
                        }
                        break;
                    case 'locker':
                        if (in_array($locker_fonts, $arsFonts['google']['fonts'])) {

                            $arsCustomCss .= '<link rel="stylesheet" type="text/css" href="' . $ars_lite_googlefontbaseurl . str_replace(' ', '+', $locker_fonts) . '" />';
                            $arsCustomCss .= "<style>.arsocial_lite_locker_popup, .arsociallocker_popup{font-family: '{$locker_fonts}' !important;}</style>";
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        return $arsCustomCss;
    }

    function ars_get_fonts() {
        global $ars_lite_googlefontbaseurl;
        $googleFonts = array("ABeeZee", "Abel", "Abril Fatface", "Aclonica", "Acme", "Actor", "Adamina", "Advent Pro", "Aguafina Script", "Akronim", "Aladin", "Aldrich", "Alef", "Alegreya", "Alegreya SC", "Alegreya Sans", "Alegreya Sans SC", "Alex Brush", "Alfa Slab One", "Alice", "Alike", "Alike Angular", "Allan", "Allerta", "Allerta Stencil", "Allura", "Almendra", "Almendra Display", "Almendra SC", "Amarante", "Amaranth", "Amatic SC", "Amethysta", "Amiri", "Amita", "Anaheim", "Andada", "Andika", "Angkor", "Annie Use Your Telescope", "Anonymous Pro", "Antic", "Antic Didone", "Antic Slab", "Anton", "Arapey", "Arbutus", "Arbutus Slab", "Architects Daughter", "Archivo Black", "Archivo Narrow", "Arimo", "Arizonia", "Armata", "Artifika", "Arvo", "Arya", "Asap", "Asar", "Asset", "Astloch", "Asul", "Atomic Age", "Aubrey", "Audiowide", "Autour One", "Average", "Average Sans", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre", "Averia Serif Libre", "Bad Script", "Balthazar", "Bangers", "Basic", "Battambang", "Baumans", "Bayon", "Belgrano", "Belleza", "BenchNine", "Bentham", "Berkshire Swash", "Bevan", "Bigelow Rules", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Biryani", "Bitter", "Black Ops One", "Bokor", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC", "Brawler", "Bree Serif", "Bubblegum Sans", "Bubbler One", "Buda", "Buenard", "Butcherman", "Butterfly Kids", "Cabin", "Cabin Condensed", "Cabin Sketch", "Caesar Dressing", "Cagliostro", "Calligraffitti", "Cambay", "Cambo", "Candal", "Cantarell", "Cantata One", "Cantora One", "Capriola", "Cardo", "Carme", "Carrois Gothic", "Carrois Gothic SC", "Carter One", "Catamaran", "Caudex", "Caveat", "Caveat Brush", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chau Philomene One", "Chela One", "Chelsea Market", "Chenla", "Cherry Cream Soda", "Cherry Swash", "Chewy", "Chicle", "Chivo", "Chonburi", "Cinzel", "Cinzel Decorative", "Clicker Script", "Coda", "Coda Caption", "Codystar", "Combo", "Comfortaa", "Coming Soon", "Concert One", "Condiment", "Content", "Contrail One", "Convergence", "Cookie", "Copse", "Corben", "Courgette", "Cousine", "Coustard", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crete Round", "Crimson Text", "Croissant One", "Crushed", "Cuprum", "Cutive", "Cutive Mono", "Damion", "Dancing Script", "Dangrek", "Dawning of a New Day", "Days One", "Dekko", "Delius", "Delius Swash Caps", "Delius Unicase", "Della Respira", "Denk One", "Devonshire", "Dhurjati", "Didact Gothic", "Diplomata", "Diplomata SC", "Domine", "Donegal One", "Doppio One", "Dorsa", "Dosis", "Dr Sugiyama", "Droid Sans", "Droid Sans Mono", "Droid Serif", "Duru Sans", "Dynalight", "EB Garamond", "Eagle Lake", "Eater", "Economica", "Eczar", "Ek Mukta", "Electrolize", "Elsie", "Elsie Swash Caps", "Emblema One", "Emilys Candy", "Engagement", "Englebert", "Enriqueta", "Erica One", "Esteban", "Euphoria Script", "Ewert", "Exo", "Exo 2", "Expletus Sans", "Fanwood Text", "Fascinate", "Fascinate Inline", "Faster One", "Fasthand", "Fauna One", "Federant", "Federo", "Felipa", "Fenix", "Finger Paint", "Fira Mono", "Fira Sans", "Fjalla One", "Fjord One", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky", "Forum", "Francois One", "Freckle Face", "Fredericka the Great", "Fredoka One", "Freehand", "Fresca", "Frijole", "Fruktur", "Fugaz One", "GFS Didot", "GFS Neohellenic", "Gabriela", "Gafata", "Galdeano", "Galindo", "Gentium Basic", "Gentium Book Basic", "Geo", "Geostar", "Geostar Fill", "Germania One", "Gidugu", "Gilda Display", "Give You Glory", "Glass Antiqua", "Glegoo", "Gloria Hallelujah", "Goblin One", "Gochi Hand", "Gorditas", "Goudy Bookletter 1911", "Graduate", "Grand Hotel", "Gravitas One", "Great Vibes", "Griffy", "Gruppo", "Gudea", "Gurajada", "Habibi", "Halant", "Hammersmith One", "Hanalei", "Hanalei Fill", "Handlee", "Hanuman", "Happy Monkey", "Headland One", "Henny Penny", "Herr Von Muellerhoff", "Hind", "Hind Siliguri", "Hind Vadodara", "Holtwood One SC", "Homemade Apple", "Homenaje", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica
 SC", "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Iceberg", "Iceland", "Imprima", "Inconsolata", "Inder", "Indie Flower", "Inika", "Inknut Antiqua", "Irish Grover", "Istok Web", "Italiana", "Italianno", "Itim", "Jacques Francois", "Jacques Francois Shadow", "Jaldi", "Jim Nightshade", "Jockey One", "Jolly Lodger", "Josefin Sans", "Josefin Slab", "Joti One", "Judson", "Julee", "Julius Sans One", "Junge", "Jura", "Just Another Hand", "Just Me Again Down Here", "Kadwa", "Kalam", "Kameron", "Kantumruy", "Karla", "Karma", "Kaushan Script", "Kavoon", "Kdam Thmor", "Keania One", "Kelly Slab", "Kenia", "Khand", "Khmer", "Khula", "Kite One", "Knewave", "Kotta One", "Koulen", "Kranky", "Kreon", "Kristi", "Krona One", "Kurale", "La Belle Aurore", "Laila", "Lakki Reddy", "Lancelot", "Lateef", "Lato", "League Script", "Leckerli One", "Ledger", "Lekton", "Lemon", "Libre Baskerville", "Life Savers", "Lilita One", "Lily Script One", "Limelight", "Linden Hill", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid", "Lora", "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Lusitana", "Lustria", "Macondo", "Macondo Swash Caps", "Magra", "Maiden Orange", "Mako", "Mallanna", "Mandali", "Marcellus", "Marcellus SC", "Marck Script", "Margarine", "Marko One", "Marmelad", "Martel", "Martel Sans", "Marvel", "Mate", "Mate SC", "Maven Pro", "McLaren", "Meddon", "MedievalSharp", "Medula One", "Megrim", "Meie Script", "Merienda", "Merienda One", "Merriweather", "Merriweather Sans", "Metal", "Metal Mania", "Metamorphous", "Metrophobic", "Michroma", "Milonga", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modak", "Modern Antiqua", "Molengo", "Molle", "Monda", "Monofett", "Monoton", "Monsieur La Doulaise", "Montaga", "Montez", "Montserrat", "Montserrat Alternates", "Montserrat Subrayada", "Moul", "Moulpali", "Mountains of Christmas", "Mouse Memoirs", "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Muli", "Mystery Quest", "NTR", "Neucha", "Neuton", "New Rocker", "News Cycle", "Niconne", "Nixie One", "Nobile", "Nokora", "Norican", "Nosifer", "Nothing You Could Do", "Noticia Text", "Noto Sans", "Noto Serif", "Nova Cut", "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Numans", "Nunito", "Odor Mean Chey", "Offside", "Old Standard TT", "Oldenburg", "Oleo Script", "Oleo Script Swash Caps", "Open Sans", "Open Sans Condensed", "Oranienbaum", "Orbitron", "Oregano", "Orienta", "Original Surfer", "Oswald", "Over the Rainbow", "Overlock", "Overlock SC", "Ovo", "Oxygen", "Oxygen Mono", "PT Mono", "PT Sans", "PT Sans Caption", "PT Sans Narrow", "PT Serif", "PT Serif Caption", "Pacifico", "Palanquin", "Palanquin Dark", "Paprika", "Parisienne", "Passero One", "Passion One", "Pathway Gothic One", "Patrick Hand", "Patrick Hand SC", "Patua One", "Paytone One", "Peddana", "Peralta", "Permanent Marker", "Petit Formal Script", "Petrona", "Philosopher", "Piedra", "Pinyon Script", "Pirata One", "Plaster", "Play", "Playball", "Playfair Display", "Playfair Display SC", "Podkova", "Poiret One", "Poller One", "Poly", "Pompiere", "Pontano Sans", "Poppins", "Port Lligat Sans", "Port Lligat Slab", "Pragati Narrow", "Prata", "Preahvihear", "Press Start 2P", "Princess Sofia", "Prociono", "Prosto One", "Puritan", "Purple Purse", "Quando", "Quantico", "Quattrocento", "Quattrocento Sans", "Questrial", "Quicksand", "Quintessential", "Qwigley", "Racing Sans One", "Radley", "Rajdhani", "Raleway", "Raleway Dots", "Ramabhadra", "Ramaraja", "Rambla", "Rammetto One", "Ranchers", "Rancho", "Ranga", "Rationale", "Ravi Prakash", "Redressed", "Reenie Beanie", "Revalia", "Rhodium Libre", "Ribeye", "Ribeye Marrow", "Righteous", "Risque", "Roboto", "Roboto Condensed", "Roboto Mono", "Roboto Slab", "Rochester", "Rock Salt", "Rokkitt", "Romanesco", "Ropa Sans", "Rosario", "Rosarivo", "Rouge Script", "Rozha One", "Rubik", "Rubik Mon
o One", "Rubik One", "Ruda", "Rufina", "Ruge Boogie", "Ruluko", "Rum Raisin", "Ruslan Display", "Russo One", "Ruthie", "Rye", "Sacramento", "Sahitya", "Sail", "Salsa", "Sanchez", "Sancreek", "Sansita One", "Sarala", "Sarina", "Sarpanch", "Satisfy", "Scada", "Schoolbell", "Seaweed Script", "Sevillana", "Seymour One", "Shadows Into Light", "Shadows Into Light Two", "Shanti", "Share", "Share Tech", "Share Tech Mono", "Shojumaru", "Short Stack", "Siemreap", "Sigmar One", "Signika", "Signika Negative", "Simonetta", "Sintony", "Sirin Stencil", "Six Caps", "Skranji", "Slabo 13px", "Slabo 27px", "Slackey", "Smokum", "Smythe", "Sniglet", "Snippet", "Snowburst One", "Sofadi One", "Sofia", "Sonsie One", "Sorts Mill Goudy", "Source Code Pro", "Source Sans Pro", "Source Serif Pro", "Special Elite", "Spicy Rice", "Spinnaker", "Spirax", "Squada One", "Sree Krushnadevaraya", "Stalemate", "Stalinist One", "Stardos Stencil", "Stint Ultra Condensed", "Stint Ultra Expanded", "Stoke", "Strait", "Sue Ellen Francisco", "Sumana", "Sunshiney", "Supermercado One", "Sura", "Suranna", "Suravaram", "Suwannaphum", "Swanky and Moo Moo", "Syncopate", "Tangerine", "Taprom", "Tauri", "Teko", "Telex", "Tenali Ramakrishna", "Tenor Sans", "Text Me One", "The Girl Next Door", "Tienne", "Tillana", "Timmana", "Tinos", "Titan One", "Titillium Web", "Trade Winds", "Trocchi", "Trochut", "Trykker", "Tulpen One", "Ubuntu", "Ubuntu Condensed", "Ubuntu Mono", "Ultra", "Uncial Antiqua", "Underdog", "Unica One", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "Unna", "VT323", "Vampiro One", "Varela", "Varela Round", "Vast Shadow", "Vesper Libre", "Vibur", "Vidaloka", "Viga", "Voces", "Volkhov", "Vollkorn", "Voltaire", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat", "Warnes", "Wellfleet", "Wendy One", "Wire One", "Work Sans", "Yanone Kaffeesatz", "Yantramanav", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada"
        );

        $defaultFonts = array('Arial', 'Helvetica', 'sans-serif', 'Lucida Grande', 'Lucida Sans Unicode', 'Tahoma', 'Times New Roman', 'Courier New', 'Verdana', 'Geneva', 'Courier', 'Monospace', 'Times', 'Open Sans Semibold', 'Open Sans Bold');

        $fonts = array(
            'default' => array('label' => 'Default Fonts', 'fonts' => array()),
            'google' => array('label' => 'Google Fonts', 'fonts' => array()),
        );
        foreach ($defaultFonts as $font) {
            $fonts['default']['fonts'][$font] = $font;
        }
        foreach ($googleFonts as $font) {
            $fonts['google']['fonts'][$font] = $font;
        }
        return $fonts;
    }

    function ars_lite_footer_js_css() {
        global $ars_lite_has_total_counter, $arsocial_lite_version;

        wp_register_script('animate_number', ARSOCIAL_LITE_SCRIPT_URL . '/jquery.animateNumber.js', array(), $arsocial_lite_version);
        if ($ars_lite_has_total_counter) {
            wp_enqueue_script('animate_number');
        }
    }

    function arsocialsharelite_linkedin_authorization() {

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'ars_linkedin_callback' && isset( $_GET['code'] ) && $_GET['code'] != '' ) {

			$response_code = $_GET['code'];

			$access_token_url = 'https://www.linkedin.com/oauth/v2/accessToken';

			$options    = get_option( 'arsocial_lite_global_settings');
			$gs_options = maybe_unserialize( $options );

			$api_params = array(
				'grant_type'    => 'authorization_code',
				'code'          => $response_code,
				'redirect_uri'  => home_url() . '?action=' . $_GET['action'],
				'client_id'     => $gs_options['linkedin']['linkedin_api_key'],
				'client_secret' => $gs_options['linkedin']['linkedin_client_secret'],
			);

			$response = wp_remote_post(
				$access_token_url,
				array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				)
			);

			if ( isset( $response['response'] ) && $response['response']['code'] == '200' && isset( $response['body'] ) ) {
				$response_body = json_decode( $response['body'], true );

				$access_token = $response_body['access_token'];
				$expire_time  = $response_body['expires_in'];

				?>
					<script type="text/javascript">
						var field_id = window.opener.linkedInAuthClick;
						if( window.opener.document.getElementById('active_linkedin_fan') != null ){
							window.opener.document.getElementById('arsocialshare_linkedin_fan_access_token').value = '<?php echo $access_token; ?>';
						} else {
							window.opener.document.getElementById('linkedin_access_token_'+field_id).value = '<?php echo $access_token; ?>';
						}
						window.close();
					</script>
				<?php
			}

			die;

		}

	}


}
?>