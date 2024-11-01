<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ars_lite_upgrade_to_premium_menu()
{
    global $arsocial_lite;
    $page_hook = add_submenu_page('arsocial_lite', __('Upgrade to Premium', 'arsocial_lite'),__('Upgrade to Premium', 'arsocial_lite'), 'arsocial_lite_manage',$arsocial_lite->socialshare_upgrade_to_premium_slug, 'ars_lite_upgrade_to_premium' );
    add_action('load-' . $page_hook , 'ars_lite_upgrade_ob_start');
}
add_action('admin_menu', 'ars_lite_upgrade_to_premium_menu','28');

function ars_lite_upgrade_ob_start() {
    ob_start();
}

function ars_lite_upgrade_to_premium()
{
    global $arsocial_lite_version;
    wp_redirect('http://arsocial.arformsplugin.com/premium/upgrade_to_premium.php?rdt=t1&arp_version='.$arsocial_lite_version.'&ars_request_version='.get_bloginfo('version'), 301);
    exit();
}

function ars_lite_upgrade_to_premium_menu_js()
{
    ?>
    <script type="text/javascript">
    	jQuery(document).ready(function ($) {
            $('a[href="admin.php?page=arsocial-lite-upgrade-to-premium"]').on('click', function () {
        		$(this).attr('target', '_blank');
            });
        });
    </script>
    
    <?php 
}
add_action( 'admin_footer', 'ars_lite_upgrade_to_premium_menu_js');
?>