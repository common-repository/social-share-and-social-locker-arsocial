<?php
$analytics = isset($_REQUEST['analytics']) ? $_REQUEST['analytics'] : 'share';
$share_css = $fan_css = $locker_css = 'selected';
if ($analytics == 'share') {
    $fan_css = $locker_css = '';
}
if ($analytics == 'fan') {
    $share_css = $locker_css = '';
    if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_analytics.php')) {
        include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_fan_analytics.php');
    }
    return;
}

if ($analytics == 'locker') {
    $share_css = $fan_css = '';
    if (file_exists(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker_analytics.php')) {
        include(ARSOCIAL_LITE_VIEWS_DIR . '/ars_locker_analytics.php');
    }
    return;
}

?>
<div class="arsocialshare_main_wrapper">
    <div class="arsocialshare_title_wrapper">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Analytics', 'arsocial_lite'); ?></label>
    </div>
    <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL;?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL;?>/documentation/assets/sysinfo.php');" /></div>

    <div class="arsocialshare_inner_wrapper">
        <input type="hidden" id="arsocialshare_ajaxurl" name="arsocialshare_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>" />
        <ul class="arsocialshare_analytics_tab" id="arsocial_analytics">
            <li class="arsocialshare_analytics_tab_item <?php echo $share_css; ?>" data-id="arsocialshare_share"><?php esc_html_e('Share Analytics', 'arsocial_lite'); ?></li>
            <li class="arsocialshare_analytics_tab_item <?php echo $fan_css; ?>" data-id="arsocialshare_fan"><?php esc_html_e('Fan Counter Analytics', 'arsocial_lite'); ?></li>
            <li class="arsocialshare_analytics_tab_item <?php echo $locker_css; ?>" data-id="arsocialshare_locker"><?php esc_html_e('Locker Analytics', 'arsocial_lite'); ?></li>
        </ul>
        <div class="arsocialshare_networks_inner_wrapper" style="margin-top:-1px;border:none;border-top: 1px solid #d1d1d1;">

            <div class="arsocialshare_networks">
                <div class="arsocialshare_network_wrapper_need_to_remove arsocialshare_analytics_none" id="arsocialshare_analytics_none">
                    
                    <div class="ars_lite_upgrade_modal" id="ars_lite_analytics_premium_notice" >
                        <div class="upgrade_modal_top_belt">
                            <div class="logo" style="text-align:center;"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_update_logo.png" /></div>
                            <!--<div id="nav_style_close" class="close_button b-close"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_upgrade_close_img.png" /></div>-->
                        </div>
                        <div class="upgrade_title"><?php esc_html_e('Upgrade To Premium Version.', 'arsocial_lite'); ?></div>
                        <div class="upgrade_message"><?php esc_html_e('To unlock this Feature, Buy Premium Version for $20.00 Only.', 'arsocial_lite'); ?></div>
                        <div class="upgrade_modal_btn">
                            <button id="pro_upgrade_button_ana"  type="button" class="buy_now_button"><?php esc_html_e('Buy Now', 'arsocial_lite'); ?></button>
                            <button id="pro_upgrade_cancel_button_ana"  class="learn_more_button" type="button">Learn More</button>
                                    <input type="hidden" name="ars_version" id="ars_version" value="<?php global $arsocial_lite_version; echo $arsocial_lite_version;?>" />
        				<input type="hidden" name="ars_request_version" id="ars_request_version" value="<?php echo get_bloginfo('version');?>" />
                        </div>
                    </div>   
                    
                </div>

            </div>
        </div>
    </div>
</div>