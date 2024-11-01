<script type="text/javascript">
    __ARSFanAjaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<?php
global $wpdb, $arsocial_lite, $arsocial_lite_fan;

$social_options = array();
$displays = array();
$defaults = array(
    'facebook' => array(
        'active_fb_fan' => '',
    ),
    'twitter' => array(
        'active_twitter_fan' => '',
    ),
    'linkedin' => array
        (
        'active_linkedin_fan' => '',
    ),
    'display' => array
        (
        'counter_update_time' => '',
        'selected_special_page' => array(
            'selected_pages' => array()
        ),
        'post_excerpt' => Array
            (
            'top' => '',
            'bottom' => '',
            'align' => 'center',
            'exclude' => '',
            'floating' => '',
        ),
    ),
);
$result = get_option('arslite_fan_display_settings', $defaults);
$social_options = maybe_unserialize($result);

$displays = $social_options['display'];


$arsocialshare_fan_counter_update_time = isset($displays['counter_update_time']) ? $displays['counter_update_time'] : '';

$sociallike_tab_option = $arsocial_lite->ARSocialShareDefaultNetworksFanCounter();
$enableNetworks = $arsocial_lite->ars_get_enable_networks();
$fbClassBtn = $fbDisableNotice = $twClassBtn = $twDisableNotice = $liClassBtn = $liDisableNotice = "";
//$fbClassBtn = $fbDisableNotice = $twClassBtn = $twDisableNotice = $liClassBtn = $liDisableNotice = $vkClassBtn = $vkDisableNotice = "";
$fbChecked = checked(isset($social_options['facebook']['active_fb_fan']) ? $social_options['facebook']['active_fb_fan'] : '', 1, false);
if (!in_array('facebook', $enableNetworks)) {
    $fbClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $fbDisableNotice = esc_html__('Please configure facebook api settings in general settings', 'arsocial_lite');
    $social_options['facebook']['active_fb_fan'] = 0;
    $fbChecked = 'disabled="disabled"';
}
$twChecked = checked(isset($social_options['twitter']['active_twitter_fan']) ? $social_options['twitter']['active_twitter_fan'] : '', 1, false);
if (!in_array('twitter', $enableNetworks)) {
    $twClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $twDisableNotice = esc_html__('Please configure twitter api settings in general settings', 'arsocial_lite');
    $social_options['twitter']['active_twitter_fan'] = 0;
    $twChecked = 'disabled="disabled"';
}
$liChecked = checked(isset($social_options['linkedin']['active_linkedin_fan']) ? $social_options['linkedin']['active_linkedin_fan'] : '', 1, false);
if (!in_array('linkedin', $enableNetworks)) {
    $liClassBtn = "ars_disable arsocialshare_disable_tooltip";
    $liDisableNotice = esc_html__('Please configure linkedin api settings in general settings', 'arsocial_lite');
    $social_options['linkedin']['active_linkedin_fan'] = 0;
    $liChecked = 'disabled="disabled"';
}


$is_fb_enable_fan_like = $is_tw_enable_fan_like = $is_ln_enable_like_fan = $is_pin_enable_like_btn  = $is_vk_enable_fan_like = $is_yt_enable_fan_like = $is_insta_enable_fan_like = false;
?>

<div class="success-message" id="success-message">
</div>

<div class="ars_sticky_top_belt" id="ars_sticky_top_belt">
    <div class="arsocialshare_title_wrapper sticky_top_belt">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Fan Counter Configuration', 'arsocial_lite'); ?></label>
    </div>
    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="sticky_belt_loader ars_loader" />
    <button type='button' data-id="sticky_belt" id="save_social_fan_counter_display_settings" class="arsocialshare_save_display_settings"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
</div>

<form name="arsocialshare_fan_display_settings" method="post" id="arsocialshare_fan_display_settings" onsubmit="return false;">
    <div class="arsocialshare_main_wrapper">
        <div class="arsocialshare_title_wrapper">

            <label class="arsocialshare_page_title"><?php esc_html_e('Social Fan Counter Configuration', 'arsocial_lite'); ?></label>

            <input type="hidden" name='arsfan_ajaxurl' id='arsfan_ajaxurl' value='<?php echo admin_url('admin-ajax.php'); ?>' />
            <input type='hidden' name='arsocial_fan_action' id="arsocial_fan_action" value="global_display_settings" />
            <input type="hidden" name="arsocialshare_fancounter_order" id="arsocialshare_fancounter_order" value='<?php echo json_encode(maybe_unserialize(get_option('arslite_global_fancounter_order'))); ?>' />
        </div>
        <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" /></div>

        <div class="arsocialshare_inner_wrapper" style="padding:0">
            <div class="arsocialshare_networks_inner_wrapper">  

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">1</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Networks', 'arsocial_lite'); ?></div>
                </div>
                <span class="ars_error_message" id="arsocialshare_fan_network_error"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
                <div class="arsocialshare_inner_container">
                    <div class="ars_network_list_container selected arsocialshare_fancounter_settings arsocialshare_sharing_sortable ars_save_order" id="arsocialshare_fan_counter">
                        <div class="arsocialshare_social_box <?php echo $fbClassBtn; ?>" title="<?php echo $fbDisableNotice; ?>" id="facebook" data-listing-order="1">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="facebook" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'facebook');" class="arsocialshare_fan_network_input" name='active_fb_fan' id='active_fb_fan' value='1' <?php echo $fbChecked; ?> />
                            <label for="active_fb_fan"><span></span></label>
                            <div class="arsocialshare_network_icon facebook"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_fb_fan"><?php esc_html_e('Facebook', 'arsocial_lite'); ?></label>
                            </div>
                            <span class="arsocialshare_move_icon"></span>
                            <?php
                            $fb_options = "display:none;";
                            if ($social_options['facebook']['active_fb_fan'] == 1) {
                                $fb_options = "";
                            }
                            ?>
                            <div class="arsocialshare_box_container" id="arsocialshare_box_facebook_container" style="<?php echo $fb_options; ?>">
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile Id', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_url' value="<?php echo isset($social_options['facebook']['fb_fan_url']) ? $social_options['facebook']['fb_fan_url'] : ''; ?>" name='arsocialshare_fb_fan_url' style="width:90%;" />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile Type', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>

                                        <select id='arsocialshare_fb_fan_account_type' name='arsocialshare_fb_fan_account_type' class="arsocialshare_dropdown" style="width:90%;">
                                            <?php
                                            $fb_account_type = $sociallike_tab_option['facebook']['account_type'];
                                            $social_options['facebook']['account_type'] = isset($social_options['facebook']['account_type']) ? $social_options['facebook']['account_type'] : 'page';
                                            foreach ($fb_account_type as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php
                                                if ($key == $social_options['facebook']['account_type']) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo $value; ?> </option>
                                                    <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_access_token' value="<?php echo isset($social_options['facebook']['fb_fan_access_token']) ? $social_options['facebook']['fb_fan_access_token'] : ''; ?>" name='arsocialshare_fb_fan_access_token' style="width:90%;" />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Manual Counter', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_manual_counter' value="<?php echo isset($social_options['facebook']['manual_counter']) ? $social_options['facebook']['manual_counter'] : ''; ?>" name='arsocialshare_fb_fan_manual_counter' style="width:90%;"/>
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Fan Text', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_text' value="<?php echo isset($social_options['facebook']['fan_text']) ? $social_options['facebook']['fan_text'] : 'FANS'; ?>" name='arsocialshare_fb_fan_text' style="width:90%;"/>
                                    </div>
                                </div>
                                <div class="arsocialshare_box_row arsocialshare_row_margin" id="fb_like_btn_wrapper" style="<?php echo (isset($social_options['facebook']['account_type']) && $social_options['facebook']['account_type'] === 'page') ? '' : 'display:none;'; ?>">
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Enable Like Button on Hover', 'arsocial_lite'); ?></div>
                                    <div class='arsocialshare_box_input'>
                                        <input type="checkbox" id="enable_fb_like" class="arsocialshare_fan_network_input" <?php isset($social_options['facebook']['enable_like_btn']) ? checked($social_options['facebook']['enable_like_btn'], 1) : ''; ?> value="1" name="enable_fb_like" /><label for="enable_fb_like"><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                                <?php
                                $is_fb_enable_fan_like = ( isset($social_options['facebook']['active_fb_fan']) && $social_options['facebook']['active_fb_fan'] == 1 && isset($social_options['facebook']['enable_like_btn']) && $social_options['facebook']['enable_like_btn'] == 1 && isset($social_options['facebook']['account_type']) && $social_options['facebook']['account_type'] === 'page' ) ? true : false;
                                ?>
                            </div>
                        </div>

                        <div class="arsocialshare_social_box <?php echo $twClassBtn; ?>" title="<?php echo $twDisableNotice; ?>" id="twitter" data-listing-order="2">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="twitter" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'twitter');" class="arsocialshare_fan_network_input" name='active_twitter_fan' id='active_twitter_fan' value='1' <?php echo $twChecked; ?> />
                            <label for="active_twitter_fan"><span></span></label>
                            <div class="arsocialshare_network_icon twitter"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_twitter_fan"><?php esc_html_e('Twitter', 'arsocial_lite'); ?></label>
                            </div>
                            <span class="arsocialshare_move_icon"></span>
                            <?php
                            $twitter_opt = "display:none";
                            if ($social_options['twitter']['active_twitter_fan'] == 1) {
                                $twitter_opt = "";
                            }
                            ?>
                            <div class="arsocialshare_box_container" id="arsocialshare_box_twitter_container" style="<?php echo $twitter_opt; ?>">
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Username', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_username' value="<?php echo isset($social_options['twitter']['twitter_fan_username']) ? $social_options['twitter']['twitter_fan_username'] : ''; ?>" name='arsocialshare_twitter_fan_username' style="width:90%;" />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Consumer Key', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_consumer_key' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_key']) ? $social_options['twitter']['twitter_fan_consumer_key'] : ''; ?>" name='arsocialshare_twitter_fan_consumer_key' style="width:90%;" />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Consumer Secret', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_consumer_secret' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_secret']) ? $social_options['twitter']['twitter_fan_consumer_secret'] : ''; ?>" name='arsocialshare_twitter_fan_consumer_secret' style="width:90%;" />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_access_token' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_access_token']) ? $social_options['twitter']['twitter_fan_consumer_access_token'] : ''; ?>" name='arsocialshare_twitter_access_token' style='width:90%;' />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token Secret', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_token_secret' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_access_token_secret']) ? $social_options['twitter']['twitter_fan_consumer_access_token_secret'] : ''; ?>" name='arsocialshare_twitter_token_secret' style='width:90%;' />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Manual Counter', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_twiiter_fan_manual_counter' value="<?php echo isset($social_options['twitter']['manual_counter']) ? $social_options['twitter']['manual_counter'] : ''; ?>" name='arsocialshare_twitter_fan_manual_counter' style="width:90%;"/>
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Fan Text', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_text' value="<?php echo isset($social_options['twitter']['fan_text']) ? $social_options['twitter']['fan_text'] : 'FOLLOWERS'; ?>" name='arsocialshare_twitter_fan_text' style="width:90%;"/>
                                    </div>
                                </div>
                                <div class="arsocialshare_box_row arsocialshare_row_margin">
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Enable Follow Button on Hover', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_box_input">
                                        <input type="checkbox" class="arsocialshare_fan_network_input" id="enable_tw_follow" <?php isset($social_options['twitter']['enable_like_btn']) ? checked($social_options['twitter']['enable_like_btn'], 1) : ''; ?> value="1" name="enable_tw_follow" />
                                        <label for="enable_tw_follow"><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                                <?php
                                $is_tw_enable_fan_like = (isset($social_options['twitter']['active_twitter_fan']) && $social_options['twitter']['active_twitter_fan'] == 1 && isset($social_options['twitter']['enable_like_btn']) && $social_options['twitter']['enable_like_btn'] == 1) ? true : false;
                                ?>
                            </div>
                        </div>

                        <div class="arsocialshare_social_box <?php echo $liClassBtn; ?>" title="<?php echo $liDisableNotice; ?>" id="linkedin" data-listing-order="4">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="linkedin" class="arsocialshare_fan_networks" />
                            <input type='checkbox'  onclick="ars_fan_counter_active_deactive(this, 'linkedin');" class="arsocialshare_fan_network_input" name='active_linkedin_fan' id='active_linkedin_fan' value='1' <?php echo $liChecked; ?> />
                            <label for="active_linkedin_fan"><span></span></label>
                            <div class="arsocialshare_network_icon linkedin"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_linkedin_fan"><?php esc_html_e('Linkedin', 'arsocial_lite'); ?></label>
                            </div>
                            <span class="arsocialshare_move_icon"></span>
                            <?php
                            $linkedin_opt = "display:none;";
                            if ($social_options['linkedin']['active_linkedin_fan'] == 1) {
                                $linkedin_opt = "display:block;";
                            }
                            ?>
                            <div class="arsocialshare_box_container" id="arsocialshare_box_linkedin_container" style="<?php echo $linkedin_opt; ?>">
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile ID/Page URL', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_url' value="<?php echo isset($social_options['linkedin']['linkedin_fan_url']) ? $social_options['linkedin']['linkedin_fan_url'] : ''; ?>" name='arsocialshare_linkedin_fan_url' style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL of Linked IN Company page or ID of profile .', 'arsocial_lite'); ?>">(?)</span>
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_access_token' value="<?php echo isset($social_options['linkedin']['linkedin_fan_access_token']) ? $social_options['linkedin']['linkedin_fan_access_token'] : ''; ?>" name='arsocialshare_linkedin_fan_access_token' style="width:90%;" />
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile Type', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>

                                        <select id='arsocialshare_ln_fan_account_type' name='arsocialshare_linkedin_fan_account_type' class="arsocialshare_dropdown" style="width:90%;">
                                            <?php
                                            $linkedin_account_type = $sociallike_tab_option['linkedin']['account_type'];
                                            $social_options['linkedin']['account_type'] = isset($social_options['linkedin']['account_type']) ? $social_options['linkedin']['account_type'] : 'page';
                                            foreach ($linkedin_account_type as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php
                                                if ($key == $social_options['linkedin']['account_type']) {
                                                    echo 'selected';
                                                }
                                                ?> > <?php echo $value; ?> </option>
                                                    <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Manual Counter', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_manual_counter' value="<?php echo isset($social_options['linkedin']['manual_counter']) ? $social_options['linkedin']['manual_counter'] : ''; ?>" name='arsocialshare_linkedin_fan_manual_counter' style="width:90%;"/>
                                    </div>
                                </div>
                                <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                    <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Fan Text', 'arsocial_lite'); ?> </div>
                                    <div class='arsocialshare_box_input'>
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_text' value="<?php echo isset($social_options['linkedin']['fan_text']) ? $social_options['linkedin']['fan_text'] : 'FOLLOWERS'; ?>" name='arsocialshare_linkedin_fan_text' style="width:90%;"/>
                                    </div>
                                </div>
                                <div class="arsocialshare_box_row arsocialshare_row_margin" id="ars_fan_linkedin_like_btn_wrapper" style="<?php echo ($social_options['linkedin']['account_type'] === 'page' ) ? '' : 'display:none;'; ?>">
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Enable follow Button on Hover', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_box_input">
                                        <input type="checkbox" name="enable_IN_follow" id="enable_IN_follow" value="1" class="arsocialshare_fan_network_input" <?php isset($social_options['linkedin']['enable_like_btn']) ? checked($social_options['linkedin']['enable_like_btn'], 1) : ''; ?> /><label for="enable_IN_follow"><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>
                                <div class="arsocialshare_box_row arsocialshare_row_margin" id="ars_fan_linkedin_id_wrapper" style="<?php echo ($social_options['linkedin']['account_type'] === 'page' && isset($social_options['linkedin']['enable_like_btn']) && $social_options['linkedin']['enable_like_btn'] ) ? '' : 'display:none;'; ?>" >
                                    <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Enter Company ID', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_box_input">
                                        <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_company_id' value="<?php echo isset($social_options['linkedin']['company_id']) ? $social_options['linkedin']['company_id'] : ''; ?>" name='arsocialshare_linkedin_fan_company_id' style="width:90%;"/>
                                    </div>
                                </div>
                                <?php
                                $is_ln_enable_fan_like = ( isset($social_options['linkedin']['active_linkedin_fan']) && $social_options['linkedin']['active_linkedin_fan'] == 1 && isset($social_options['linkedin']['account_type']) && $social_options['linkedin']['account_type'] === 'page' && isset($social_options['linkedin']['enable_like_btn']) && $social_options['linkedin']['enable_like_btn'] == 1 ) ? true : false;
                                ?>  
                            </div>
                        </div>

                        <div class='arsocialshare_box_clear'></div>

                    </div>
                    <!-- Disabled Networks -->
                    <div class="ars_network_list_container selected arsocialshare_fancounter_settings ars_lite_pro_networks" id="arsocialshare_fan_counter">
                        <div class="ars_lite_pro_networks_info"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Available in premium version', 'arsocial_lite'); ?> )</span></div>
                        <div class="arsocialshare_social_box_disabled" id="pinterest" data-listing-order="5">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="pinterest" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'pinterest');" class="arsocialshare_fan_network_input" name='active_pinterest_fan' id='active_pinterest_fan' value='1' <?php // checked(isset($social_options['pinterest']['active_pinterest_fan']) ? $social_options['pinterest']['active_pinterest_fan'] : '', 1); ?> />
                            <label for="active_pinterest_fan"><span></span></label>
                            <div class="arsocialshare_network_icon pinterest"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_pinterest_fan"><?php esc_html_e('Pinterest', 'arsocial_lite'); ?></label>
                            </div>

                        </div>

                        <div class="arsocialshare_social_box_disabled" id="vimeo" data-listing-order="6">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="vimeo" class="arsocialshare_fan_networks" />
                            <input type='checkbox' name='active_vimeo_fan' class="arsocialshare_fan_network_input" onclick="ars_fan_counter_active_deactive(this, 'vimeo');" id='active_vimeo_fan' value='1' />
                            <label for="active_vimeo_fan"><span></span></label>
                            <div class="arsocialshare_network_icon vimeo"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_vimeo_fan"><?php esc_html_e('Vimeo', 'arsocial_lite'); ?></label>
                            </div>

                        </div>

                        <div class="arsocialshare_social_box_disabled" id="instagram" data-listing-order="7">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="instagram" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'instagram');" class="arsocialshare_fan_network_input" name='active_instagram_fan' id='active_instagram_fan' value='1' />
                            <label for="active_instagram_fan"><span></span></label>
                            <div class="arsocialshare_network_icon instagram"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_instagram_fan"><?php esc_html_e('Instagram', 'arsocial_lite'); ?></label>
                            </div>

                        </div>

                        <div class="arsocialshare_social_box_disabled" id="youtube" data-listing-order="8">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="youtube" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'youtube');" class="arsocialshare_fan_network_input" name='active_youtube_fan' id='active_youtube_fan' value='1' />
                            <label for="active_youtube_fan"><span></span></label>
                            <div class="arsocialshare_network_icon youtube"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_youtube_fan"><?php esc_html_e('Youtube', 'arsocial_lite'); ?></label>
                            </div>

                        </div>

                        <div class="arsocialshare_box_clear"></div>

                        <div class="arsocialshare_social_box_disabled" id="dribbble" data-listing-order="9">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="dribbble" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'dribbble');" class="arsocialshare_fan_network_input" name='active_dribbble_fan' id='active_dribbble_fan' value='1'/>
                            <label for="active_dribbble_fan"><span></span></label>
                            <div class="arsocialshare_network_icon dribbble"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_dribbble_fan"><?php esc_html_e('Dribbble', 'arsocial_lite'); ?></label>
                            </div>

                        </div>

                        <div class="arsocialshare_social_box_disabled " title="" id="vk" data-listing-order="10">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="vk" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'vk');" class="arsocialshare_fan_network_input" name='active_vk_fan' id='active_vk_fan' value='1' />
                            <label for="active_vk_fan"><span></span></label>
                            <div class="arsocialshare_network_icon vk"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_vk_fan"><?php esc_html_e('VK', 'arsocial_lite'); ?></label>
                            </div>

                        </div>

                        <div class="arsocialshare_social_box_disabled" id="foursquare" data-listing-order="11">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="foursquare" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'foursquare');" class="arsocialshare_fan_network_input" name='active_foursquare_fan' id='active_foursquare_fan' value='1' />
                            <label for="active_foursquare_fan"><span></span></label>
                            <div class="arsocialshare_network_icon foursquare"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_foursquare_fan"><?php esc_html_e('Foursquare', 'arsocial_lite'); ?></label>
                            </div>

                        </div>

                        <div class="arsocialshare_social_box_disabled" id="github" data-listing-order="12">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="github" class="arsocialshare_fan_networks" />
                            <input type='checkbox'  onclick="ars_fan_counter_active_deactive(this, 'github');" class="arsocialshare_fan_network_input" name='active_github_fan' id='active_github_fan' value='1' />
                            <label for="active_github_fan"><span></span></label>
                            <div class="arsocialshare_network_icon github"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_github_fan"><?php esc_html_e('Github', 'arsocial_lite'); ?></label>
                            </div>
                        </div>

                        <div class="arsocialshare_box_clear"></div>

                        <div class="arsocialshare_social_box_disabled" id="soundcloud" data-listing-order="14">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="soundcloud" class="arsocialshare_fan_networks" />
                            <input type='checkbox'  onclick="ars_fan_counter_active_deactive(this, 'soundcloud');" class="arsocialshare_fan_network_input" name='active_soundcloud_fan' id='active_soundcloud_fan' value='1' />
                            <label for="active_soundcloud_fan"><span></span></label>
                            <div class="arsocialshare_network_icon soundcloud"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_soundcloud_fan"><?php esc_html_e('Soundcloud', 'arsocial_lite'); ?></label>
                            </div>
                        </div>

                        <div class="arsocialshare_social_box_disabled" id="flickr" data-listing-order="16">
                            <input type="hidden" name="arsocialshare_fancounter_networks[]" value="flickr" class="arsocialshare_fan_networks" />
                            <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'flickr');" class="arsocialshare_fan_network_input" name='active_flickr_fan' id='active_flickr_fan' value='1' />
                            <label for="active_flickr_fan"><span></span></label>
                            <div class="arsocialshare_network_icon flickr"></div>
                            <div class="arsocialshare_social_box_title">
                                <label for="active_flickr_fan"><?php esc_html_e('Flickr', 'arsocial_lite'); ?></label>
                            </div>
                        </div>

                        <div class="arsocialshare_box_clear"></div>
                        
                    </div>
                </div>

                <?php
                $enable_fan_like_position = false;
                if ($is_fb_enable_fan_like || $is_tw_enable_fan_like || $is_ln_enable_fan_like || $is_pin_enable_like_btn  || $is_yt_enable_fan_like || $is_insta_enable_fan_like) {
                    $enable_fan_like_position = true;
                }
                ?>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">2</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Sitewide Button Setup', 'arsocial_lite'); ?></div>
                </div>

                <div class='arsocialshare_inner_container'>
                    <div class="arsocialshare_inner_content_wrapper">
                        <?php
                        $enable_sidebar = "";
                        $enable_fan_bar = "";
                        $enable_popup = "";
                        if (isset($displays) && array_key_exists('sidebar', $displays)) {
                            $enable_sidebar = "checked='checked'";
                        }
                        if (isset($displays) && array_key_exists('fan_bar', $displays)) {
                            $enable_fan_bar = "checked='checked'";
                        }
                        if (isset($displays) && array_key_exists('popup', $displays)) {
                            $enable_popup = "checked='checked'";
                        }
                        ?>
                        <input type="checkbox" name="arsocialshare_enable_sidebar" value="sidebar" id="arsocialshare_enable_sidebar" <?php echo $enable_sidebar; ?> class="ars_display_option_input ars_hide_checkbox" />
                        <input type="checkbox" name="arsocialshare_enable_top_bottom_bar" value="top_bottom_bar" id="arsocialshare_enable_top_bottom_bar" <?php echo $enable_fan_bar; ?> class="ars_display_option_input ars_hide_checkbox" />
                        <input type="checkbox" name="arsocialshare_enable_popup" value="popup" id="arsocialshare_enable_popup" <?php echo $enable_popup; ?> class="ars_display_option_input ars_hide_checkbox" />
                        <div class="arsocialshare_inner_container_main">
                            <div class="arsocialshare_option_box sidebar_icon <?php echo ($enable_sidebar !== '' ) ? "selected" : ''; ?>" data-id="arsocialshare_enable_sidebar" data-opt-id="arsocialshare_sidebar">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                            <div class="arsocialshare_option_box top_bottom_bar_icon <?php echo ($enable_fan_bar !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_top_bottom_bar" data-opt-id="arsocialshare_top_bottom_bar">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                            <div class="arsocialshare_option_box popup_icon <?php echo ($enable_popup !== '' ) ? "selected" : ""; ?>" data-id="arsocialshare_enable_popup" data-opt-id="arsocialshare_popup">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                        </div>
                        <div class="ars_network_list_container <?php echo ( $enable_sidebar !== '' ) ? "selected" : ''; ?>" id="arsocialshare_sidebar">
                        <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img style="margin-top:0px;" src="<?php echo ARSOCIAL_LITE_URL; ?>/images/sidebar_styling_settings.png" /></div>
                             <div class="arsfontsize25"><?php esc_html_e('Sidebar Styling Settings', 'arsocial_lite'); ?></div>
                        </div>

                            <?php
                            $display_style = $sociallike_tab_option['display_style']['display_style'];
                            unset($display_style['color_icons']);
                            $arsfan_display_sidebar_skin = isset($displays['sidebar']['skin']) ? $displays['sidebar']['skin'] : 'metro';
                            ?>
                            <div class="arsocialshare_option_container ars_column arsmarginleft10">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select name="arsocialfan_display_style_sidebar" class="arsocialshare_dropdown ars_lite_pro_options" id="arsocialfan_display_style_sidebar">
                                            <?php foreach ($display_style as $key => $value) { ?>
                                                <option <?php selected($arsfan_display_sidebar_skin, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select id='arsfan_sidebar_display_number_format' name='arsfan_sidebar_display_number_format' class="arsocialshare_dropdown">
                                            <?php
                                            $counter_number_format = $sociallike_tab_option['counter_number_format']['counter_number_format'];
                                            $fan_sidebar_no_format = isset($displays['sidebar']['no_format']) ? $displays['sidebar']['no_format'] : 'style1';
                                            foreach ($counter_number_format as $key => $value) {
                                                ?>
                                                <option <?php selected($fan_sidebar_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_sidebar_position = isset($displays['sidebar']['position']) ? $displays['sidebar']['position'] : 'left';
                                        ?>
                                        <input type="radio" name="ars_fan_sidebar_position" value="left" data-on="left" <?php checked($arsfan_sidebar_position, 'left'); ?> class="ars_fan_sidebar_position_radio ars_hide_checkbox" id="arsfan_sidebar_buttons_on_left" />
                                        <input type="radio" name="ars_fan_sidebar_position" value="right" data-on="right" <?php checked($arsfan_sidebar_position, 'right'); ?> class="ars_fan_sidebar_position_radio ars_hide_checkbox" id="arsfan_sidebar_buttons_on_right" />
                                        <div class="arsocialshare_inner_option_box arsfan_sidebar_position <?php echo ($arsfan_sidebar_position === 'left') ? 'selected' : ''; ?>" id="arsfan_sidebar_buttons_on_left_img" data-value="left" onclick="ars_select_radio_img('arsfan_sidebar_buttons_on_left', 'arsfan_sidebar_position');">
                                            <span class="arsocialshare_inner_option_icon sidebar_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsfan_sidebar_position <?php echo ($arsfan_sidebar_position === 'right') ? 'selected' : ''; ?>" id="arsfan_sidebar_buttons_on_right_img" data-value="right" onclick="ars_select_radio_img('arsfan_sidebar_buttons_on_right', 'arsfan_sidebar_position');">
                                            <span class="arsocialshare_inner_option_icon sidebar_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_button_position_wrapper" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>" >
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Like / Follow Button Position', 'arsocial_lite'); ?><br/>(<?php esc_html_e('on hover', 'arsocial_lite'); ?>)</div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_sidebar_like_follow_btn_position = isset($displays['sidebar']['like_follow_btn_position']) ? $displays['sidebar']['like_follow_btn_position'] : 'top'; ?>
                                        <select name="arsfan_sidebar_like_follow_position" id="arsfan_sidebar_like_follow_position" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_sidebar_like_follow_btn_position, 'top'); ?> value="top"><?php esc_html_e('Top', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_sidebar_like_follow_btn_position, 'bottom'); ?> value="bottom"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_sidebar_like_follow_btn_position, 'left'); ?> value="left"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_sidebar_like_follow_btn_position, 'right'); ?> value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_sidebar_btn_width = isset($displays['sidebar']['button_width']) ? $displays['sidebar']['button_width'] : "small";
                                        ?>
                                        <input type="radio" name="arsfan_sidebar_btn_width" id="arsfan_sidebar_btn_small" <?php checked($arsfan_sidebar_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_fan_sidebar_btn_width_input" />
                                        <input type="radio" name="arsfan_sidebar_btn_width" id="arsfan_sidebar_btn_medium" <?php checked($arsfan_sidebar_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_fan_sidebar_btn_width_input"  />
                                        <input type="radio" name="arsfan_sidebar_btn_width" id="arsfan_sidebar_btn_large" <?php checked($arsfan_sidebar_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_fan_sidebar_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box arsfan_sidebar_btn_width <?php echo ($arsfan_sidebar_btn_width === 'small') ? 'selected' : ''; ?>" id="arsfan_sidebar_btn_small_img" data-value="small" onclick="ars_select_radio_img('arsfan_sidebar_btn_small', 'arsfan_sidebar_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsfan_sidebar_btn_width <?php echo ($arsfan_sidebar_btn_width === 'medium') ? 'selected' : ''; ?>" id="arsfan_sidebar_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('arsfan_sidebar_btn_medium', 'arsfan_sidebar_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsfan_sidebar_btn_width <?php echo ($arsfan_sidebar_btn_width === 'large') ? 'selected' : ''; ?>" id="arsfan_sidebar_btn_large_img" data-value="large" onclick="ars_select_radio_img('arsfan_sidebar_btn_large', 'arsfan_sidebar_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_sidebar_more_btn = isset($displays['sidebar']['more_btn']) ? $displays['sidebar']['more_btn'] : '5';
                                        ?>
                                        <input type="text" name="arsfan_sidebar_more_button" class="arsocialshare_input_box" id="arsfan_sidebar_more_button" value="<?php echo $arsfan_sidebar_more_btn; ?>" />
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_sidebar_more_btn_style = isset($displays['sidebar']['more_btn_style']) ? $displays['sidebar']['more_btn_style'] : 'plus_icon';
                                        ?>
                                        <select name="arsfan_sidebar_more_button_style" id="arsfan_sidebar_more_button_style" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_sidebar_more_btn_style, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_sidebar_more_btn_style, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_sidebar_more_btn_action = isset($displays['sidebar']['more_btn_action']) ? $displays['sidebar']['more_btn_action'] : 'display_popup';
                                        ?>
                                        <select name="arsfan_sidebar_more_button_action" id="arsfan_sidebar_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                            <option <?php selected($arsfan_sidebar_more_btn_action, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_sidebar_more_btn_action, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                                <div class="ars_template_preview_container ars_fan_btn_preview" style="margin-top:-15px;">
                                    <div class="arsocialshare_fan_preview_container ars_fan_counter_sidebar_preview arslite_<?php echo $arsfan_sidebar_btn_width; ?>_fan_button ars_<?php echo $arsfan_sidebar_position; ?>_buttons" id="ars_fan_counter_sidebar_preview">
                                        <?php foreach ($display_style as $key => $value): ?>
                                            <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($arsfan_display_sidebar_skin == $key) ? 'display:block;' : ''; ?>">
                                                <ul>
                                                    <li class="ars_fan_network-facebook">
                                                        <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_sidebar_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                                            <div class="ars_fan_like_inner_wrapper">
                                                                <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)">
                                                            <div class="ars_fan_network"><i class="ars_fan_network_icon socialshare-facebook facebook"></i><span class="ars_fan_value">175k</span><span class="ars_fan_label"><?php esc_html_e('Fans', 'arsocial_lite'); ?></span></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_page_excludes_sidebar" id="arsocialshare_page_excludes_sidebar" value="<?php echo isset($displays['sidebar']['exclude_pages']) ? $displays['sidebar']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                        </div>

                        <div class="ars_network_list_container <?php echo ( $enable_fan_bar !== '' ) ? "selected" : ""; ?>" id="arsocialshare_top_bottom_bar">
                            <div class="arsocialshare_option_title">
                                <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/top_bottom_bar_styling_setting.png" /></div>
                                <div class="arsfontsize25"><?php esc_html_e('Top/Bottom Bar Styling Settings', 'arsocial_lite'); ?></div>
                            </div>

                            <?php
                            $display_style = $sociallike_tab_option['display_style']['display_style'];
                            $arsfan_display_bar_skin = isset($displays['fan_bar']['skin']) ? $displays['fan_bar']['skin'] : 'metro';
                            ?>
                            <div class="arsocialshare_option_container ars_column arsmarginleft10">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select name="arsocialfan_display_style_bar" class="arsocialshare_dropdown ars_lite_pro_options" id="arsocialfan_display_style_bar">
                                            <?php foreach ($display_style as $key => $value) { ?>
                                                <option <?php selected($arsfan_display_bar_skin, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select id='arsfan_bar_display_number_format' name='arsfan_bar_display_number_format' class="arsocialshare_dropdown">
                                            <?php
                                            $counter_number_format = $sociallike_tab_option['counter_number_format']['counter_number_format'];
                                            $arsfan_bar_no_format = isset($displays['fan_bar']['no_format']) ? $displays['fan_bar']['no_format'] : 'style1';
                                            foreach ($counter_number_format as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php selected($arsfan_bar_no_format, $key) ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $top_bar_checked = "";
                                        $bottom_bar_checked = "";
                                        if (isset($displays['fan_bar']['top']) && $displays['fan_bar']['top'] == true) {
                                            $top_bar_checked = "checked='checked'";
                                        }
                                        if (isset($displays['fan_bar']['bottom']) && $displays['fan_bar']['bottom'] == true) {
                                            $bottom_bar_checked = "checked='checked'";
                                        }
                                        if ($top_bar_checked == '' && $bottom_bar_checked == '') {
                                            $top_bar_checked = "checked='checked'";
                                        }
                                        ?>
                                        <input type="radio" name="arsfan_bar_top" value="true" data-on="top_bar" <?php echo $top_bar_checked; ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsfan_buttons_on_top" />
                                        <input type="radio" name="arsfan_bar_bottom" value="true" <?php echo $bottom_bar_checked; ?> data-on="bottom_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsfan_buttons_on_bottom" />
                                        <div class="arsocialshare_inner_option_box arsfan_bar_position <?php echo ($top_bar_checked !== '' ) ? "selected" : ""; ?>" id="arsfan_buttons_on_top_img" data-value="top" onclick="ars_select_checkbox_img('arsfan_buttons_on_top', '', '');">
                                            <span class="arsocialshare_inner_option_icon top_bar"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsfan_bar_position <?php echo ($bottom_bar_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('arsfan_buttons_on_bottom', '', '');" id="arsfan_buttons_on_bottom_img" data-value="right">
                                            <span class="arsocialshare_inner_option_icon bottom_bar"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar', 'arsocial_lite'); ?></div>
                                    <?php $arsfan_display_bar_on = isset($displays['fan_bar']['display_on']) ? $displays['fan_bar']['display_on'] : 'onload'; ?>
                                    <div class="arsocialshare_option_input">
                                        <select class="arsocialshare_dropdown" id="ars_fan_display_bar" name="ars_fan_display_bar">
                                            <option <?php selected($arsfan_display_bar_on, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_display_bar_on, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_display_bar_option <?php echo ($arsfan_display_bar_on === 'onload') ? 'selected' : ''; ?>" id="ars_fan_on_load_wrapper">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n seconds', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_onload_time = isset($displays['fan_bar']['load_time']) ? $displays['fan_bar']['load_time'] : '0';
                                        ?>
                                        <input type="text" name="ars_fan_bar_onload_time" id="ars_fan_bar_onload_time" class="arsocialshare_input_box" value="<?php echo $arsfan_onload_time; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_display_bar_option <?php echo ($arsfan_display_bar_on === 'onscroll') ? 'selected' : ''; ?>" id="ars_fan_on_scroll_wrapper">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n % of scroll', 'arsocial_lite') ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_onscroll_value = isset($displays['fan_bar']['scroll_value']) ? $displays['fan_bar']['scroll_value'] : '50';
                                        ?>
                                        <input type="text" name="ars_fan_bar_onscroll_percentage" id="ars_fan_bar_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo $arsfan_onscroll_value; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"> <?php esc_html_e('Start Top Bar from Y position', 'arsocial_lite'); ?> </div>
                                    <div class="arsocialshare_option_input">
                                        <input type="text" name="arsfan_bar_y_position" id="arsfan_bar_y_position" class="arsocialshare_input_box" value="<?php echo isset($displays['fan_bar']['y_point']) ? $displays['fan_bar']['y_point'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px;top:8px;"> px </span>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_bar_btn_width = isset($displays['fan_bar']['button_width']) ? $displays['fan_bar']['button_width'] : 'small';
                                        ?>
                                        <input type="radio" name="ars_fan_bar_btn_width" id="ars_fan_bar_btn_small" value="small" <?php checked($arsfan_bar_btn_width, 'small'); ?> class="ars_hide_checkbox ars_fan_bar_btn_width_input" />
                                        <input type="radio" name="ars_fan_bar_btn_width" id="ars_fan_bar_btn_medium" value="medium" <?php checked($arsfan_bar_btn_width, 'medium'); ?> class="ars_hide_checkbox ars_fan_bar_btn_width_input"  />
                                        <input type="radio" name="ars_fan_bar_btn_width" id="ars_fan_bar_btn_large" value="large" <?php checked($arsfan_bar_btn_width, 'large'); ?> class="ars_hide_checkbox ars_fan_bar_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box ars_fan_bar_btn_width <?php echo ($arsfan_bar_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_fan_bar_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_fan_bar_btn_small', 'ars_fan_bar_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_fan_bar_btn_width <?php echo ($arsfan_bar_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_fan_bar_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_fan_bar_btn_medium', 'ars_fan_bar_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_fan_bar_btn_width <?php echo ($arsfan_bar_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_fan_bar_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_fan_bar_btn_large', 'ars_fan_bar_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_bar_more_btn = isset($displays['fan_bar']['more_btn']) ? $displays['fan_bar']['more_btn'] : '5';
                                        ?>
                                        <input type="text" name="arsfan_bar_more_button" class="arsocialshare_input_box" id="arsfan_bar_more_button" value="<?php echo $arsfan_bar_more_btn; ?>" />
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_bar_more_btn_style = isset($displays['fan_bar']['more_btn_style']) ? $displays['fan_bar']['more_btn_style'] : 'plus_icon'; ?>
                                        <select name="ars_fan_bar_more_button_style" id="ars_fan_bar_more_button_style" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_bar_more_btn_style, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_bar_more_btn_style, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $ars_fan_bar_more_btn_action = isset($displays['fan_bar']['more_btn_action']) ? $displays['fan_bar']['more_btn_action'] : 'display_popup';
                                        ?>
                                        <select name="ars_fan_bar_more_button_action" id="ars_fan_bar_more_button_action" class="arsocialshare_dropdown">
                                            <option <?php selected($ars_fan_bar_more_btn_action, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                            <option <?php selected($ars_fan_bar_more_btn_action, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $ars_fanbar_btn_align = isset($displays['fan_bar']['btn_alignment']) ? $displays['fan_bar']['btn_alignment'] : 'center';
                                        ?>
                                        <input type="radio" name="ars_fanbar_btn_align" id="ars_fan_bar_btn_left" <?php checked($ars_fanbar_btn_align, 'left'); ?> value="left" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                        <input type="radio" name="ars_fanbar_btn_align" id="ars_fan_bar_btn_center" <?php checked($ars_fanbar_btn_align, 'center'); ?> value="center" class="ars_hide_checkbox ars_top_bottom_btn_align_input"  />
                                        <input type="radio" name="ars_fanbar_btn_align" id="ars_fan_bar_btn_right" <?php checked($ars_fanbar_btn_align, 'right'); ?> value="right" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                        <div class="arsocialshare_inner_option_box ars_fan_bar_btn_align <?php echo ($ars_fanbar_btn_align === 'left') ? 'selected' : ''; ?>" id="ars_fan_bar_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_fan_bar_btn_left', 'ars_fan_bar_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_fan_bar_btn_align <?php echo ($ars_fanbar_btn_align === 'center') ? 'selected' : ''; ?>" id="ars_fan_bar_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_fan_bar_btn_center', 'ars_fan_bar_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_fan_bar_btn_align <?php echo ($ars_fanbar_btn_align === 'right') ? 'selected' : ''; ?>" id="ars_fan_bar_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_fan_bar_btn_right', 'ars_fan_bar_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="arsocialshare_option_row ars_fan_button_position_wrapper" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Like / Follow Button Position', 'arsocial_lite'); ?><br/>(<?php esc_html_e('on hover', 'arsocial_lite'); ?>)</div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_fan_bar_like_follow_btn_position = isset($displays['fan_bar']['like_follow_btn_position']) ? $displays['fan_bar']['like_follow_btn_position'] : 'top'; ?>
                                        <select name="arsfan_fan_bar_like_follow_position" id="arsfan_fan_bar_like_follow_position" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_fan_bar_like_follow_btn_position, 'top'); ?> value="top"><?php esc_html_e('Top', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_fan_bar_like_follow_btn_position, 'bottom'); ?> value="bottom"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_fan_bar_like_follow_btn_position, 'left'); ?> value="left"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_fan_bar_like_follow_btn_position, 'right'); ?> value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                                <div class="ars_template_preview_container ars_fan_btn_preview" style="margin-top:-15px;">
                                    <div class="arsocialshare_fan_preview_container ars_fan_counter_main_preview arslite_<?php echo $arsfan_bar_btn_width; ?>_fan_button" id="ars_fan_counter_top_bottom_preview">
                                        <?php foreach ($display_style as $key => $value): ?>
                                            <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($arsfan_display_bar_skin == $key) ? 'display:block;' : ''; ?>">
                                                <ul>
                                                    <li class="ars_fan_network-facebook">
                                                        <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_fan_bar_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                                            <div class="ars_fan_like_inner_wrapper">
                                                                <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)">
                                                            <div class="ars_fan_network"><i class="ars_fan_network_icon socialshare-facebook facebook"></i><span class="ars_fan_value">175k</span><span class="ars_fan_label"><?php esc_html_e('Fans', 'arsocial_lite'); ?></span></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_page_excludes_fan_bar" id="arsocialshare_page_excludes_fan_bar" value="<?php echo isset($displays['fan_bar']['exclude_pages']) ? $displays['fan_bar']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>

                        </div>

                        <div class="ars_network_list_container <?php echo ($enable_popup !== '' ) ? "selected" : ""; ?>" id="arsocialshare_popup">
                            <div class="arsocialshare_option_title">
                                <?php esc_html_e('Popup Styling Settings', 'arsocial_lite'); ?>
                            </div>

                            <?php
                            $display_style = $sociallike_tab_option['display_style']['display_style'];
                            $ars_fan_popup_skin = isset($displays['popup']['skin']) ? $displays['popup']['skin'] : 'metro';
                            ?>
                            <div class="arsocialshare_option_container ars_column">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select name="arsocialfan_popup_skin" class="arsocialshare_dropdown" id="arsocialfan_popup_skin">
                                            <?php foreach ($display_style as $key => $value) { ?>
                                                <option <?php selected($ars_fan_popup_skin, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select id='ars_fan_popup_number_format' name='ars_fan_popup_number_format' class="arsocialshare_dropdown">
                                            <?php
                                            $counter_number_format = $sociallike_tab_option['counter_number_format']['counter_number_format'];
                                            $arsfan_popup_no_format = isset($displays['popup']['no_format']) ? $displays['popup']['no_format'] : 'style1';
                                            foreach ($counter_number_format as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php selected($arsfan_popup_no_format, $key); ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_display_popup = isset($displays['popup']['onload_type']) ? $displays['popup']['onload_type'] : 'onload'; ?>
                                        <select class="arsocialshare_dropdown" id="ars_fan_display_popup" name="ars_fan_display_popup">
                                            <option <?php selected($arsfan_display_popup, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_display_popup, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_display_popup_option <?php echo ($arsfan_display_popup === 'onload') ? 'selected' : ''; ?>" id="ars_fan_popup_on_load_wrapper">
                                    <?php
                                    $arsfan_popup_onload_time = isset($displays['popup']['open_delay']) ? $displays['popup']['open_delay'] : '0';
                                    ?>
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n seconds', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <input type="text" name="ars_fan_popup_onload_time" id="ars_fan_popup_onload_time" class="arsocialshare_input_box" value="<?php echo $arsfan_popup_onload_time; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_display_popup_option <?php echo ($arsfan_display_popup === 'onscroll') ? 'selected' : ''; ?>" id="ars_fan_popup_on_scroll_wrapper">
                                    <?php
                                    $arsfan_popup_open_scroll = isset($displays['popup']['open_scroll']) ? $displays['popup']['open_scroll'] : '50';
                                    ?>
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n % of scroll', 'arsocial_lite') ?></div>
                                    <div class="arsocialshare_option_input">
                                        <input type="text" name="ars_fan_popup_bar_onscroll_percentage" id="ars_fan_popup_bar_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo $arsfan_popup_open_scroll; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_button_position_wrapper" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Like / Follow Button Position', 'arsocial_lite'); ?><br/>(<?php esc_html_e('on hover', 'arsocial_lite'); ?>)</div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_popup_like_follow_btn_position = isset($displays['popup']['like_follow_btn_position']) ? $displays['popup']['like_follow_btn_position'] : 'top'; ?>
                                        <select name="arsfan_popup_like_follow_position" id="arsfan_popup_like_follow_position" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_popup_like_follow_btn_position, 'top'); ?> value="top"><?php esc_html_e('Top', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_popup_like_follow_btn_position, 'bottom'); ?> value="bottom"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_popup_like_follow_btn_position, 'left'); ?> value="left"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_popup_like_follow_btn_position, 'right'); ?> value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_btn_width = isset($displays['popup']['button_width']) ? $displays['popup']['button_width'] : "small"; ?>
                                        <input type="radio" name="ars_popup_btn_width" id="ars_popup_btn_small" <?php checked($popup_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_fan_popup_btn_width_input" />
                                        <input type="radio" name="ars_popup_btn_width" id="ars_popup_btn_medium" <?php checked($popup_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_fan_popup_btn_width_input"  />
                                        <input type="radio" name="ars_popup_btn_width" id="ars_popup_btn_large" <?php checked($popup_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_fan_popup_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ($popup_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_popup_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_popup_btn_small', 'ars_popup_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ($popup_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_popup_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_popup_btn_medium', 'ars_popup_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_popup_btn_width <?php echo ($popup_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_popup_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_popup_btn_large', 'ars_popup_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Popup Height', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_height = isset($displays['popup']['height']) ? $displays['popup']['height'] : ''; ?>
                                        <input type="text" name="ars_fan_popup_height" class="arsocialshare_input_box" id="ars_fan_popup_height" value="<?php echo $popup_height; ?>" />
                                    </div>
                                    <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto height.', 'arsocial_lite'); ?></span>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Popup Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_width = isset($displays['popup']['width']) ? $displays['popup']['width'] : ''; ?>
                                        <input type="text" name="ars_fan_popup_width" class="arsocialshare_input_box" id="ars_fan_popup_width" value="<?php echo $popup_width; ?>" />
                                    </div>
                                    <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto width.', 'arsocial_lite'); ?></span>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Display Close Button', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $popup_close_btn = isset($displays['popup']['display_close_btn']) ? $displays['popup']['display_close_btn'] : 'yes'; ?>
                                        <input type="hidden" name="arsocialshare_popup_close_btn" id="arsocialshare_popup_close_btn" value="<?php echo $popup_close_btn; ?>" />
                                        <div class="arsocialshare_switch <?php echo ( $popup_close_btn === 'yes' ) ? 'selected' : ''; ?>" data-id="arsocialshare_popup_close_btn">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="arsocialshare_option_container ars_column ars_no_border">

                                <div class="ars_template_preview_container ars_fan_btn_preview" style="margin-top:-15px;">
                                    <div class="arsocialshare_fan_preview_container ars_fan_counter_main_preview arslite_<?php echo $popup_btn_width; ?>_fan_button" id="ars_fan_counter_popup_preview">
                                        <?php foreach ($display_style as $key => $value): ?>
                                            <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($ars_fan_popup_skin == $key) ? 'display:block;' : ''; ?>">
                                                <ul>
                                                    <li class="ars_fan_network-facebook">
                                                        <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_popup_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                                            <div class="ars_fan_like_inner_wrapper">
                                                                <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)">
                                                            <div class="ars_fan_network"><i class="ars_fan_network_icon socialshare-facebook facebook"></i><span class="ars_fan_value">175k</span><span class="ars_fan_label"><?php esc_html_e('Fans', 'arsocial_lite'); ?></span></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_page_excludes_popup" id="arsocialshare_page_excludes_popup" value="<?php echo isset($displays['popup']['exclude_pages']) ? $displays['popup']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">3</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Sectionwise Button Setup', 'arsocial_lite'); ?></div>
                </div>
                <span class="ars_error_message" id="arsocialshare_fan_network_position_error"><?php esc_html_e('Please select atleast one position.', 'arsocial_lite'); ?></span>
                <div class="arsocialshare_inner_container">
                    <div class="arsocialshare_inner_content_wrapper">
                        <div class="arsocialshare_inner_container_main">
                            <?php
                            $enable_pages = "";
                            $enable_posts = "";
                            if (isset($displays) && array_key_exists('page', $displays)) {
                                $enable_pages = "checked='checked'";
                            }
                            if (isset($displays) && array_key_exists('post', $displays)) {
                                $enable_posts = "checked='checked'";
                            }
                            ?>
                            <input type="checkbox" name="arsfan_enable_pages" value="pages" id="arsocialshare_enable_pages" <?php echo $enable_pages; ?> class="ars_display_option_input ars_hide_checkbox" />
                            <input type="checkbox" name="arsfan_enable_posts" value="posts" id="arsocialshare_enable_posts" <?php echo $enable_posts; ?> class="ars_display_option_input ars_hide_checkbox" />
                            <div class="arsocialshare_option_box page_icon <?php echo ( $enable_pages !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_pages" data-opt-id="ars_fan_pages" data-mob-page-id="fan">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                            <div class="arsocialshare_option_box post_icon <?php echo ( $enable_posts !== '' ) ? 'selected' : ''; ?>" data-id="arsocialshare_enable_posts" data-opt-id="ars_fan_posts" data-mob-page-id="fan">
                                <div class="arsocialshare_option_checkbox"><span></span></div>
                            </div>
                        </div>

                        <div class="ars_network_list_container <?php echo ($enable_pages !== '' ) ? 'selected' : ''; ?> " id="ars_fan_pages">
                            <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/page_setting.png" /></div>
                            <div class="arsfontsize25"><?php esc_html_e('Page Settings', 'arsocial_lite'); ?></div>
                            </div>

                            <?php
                            $display_style = $sociallike_tab_option['display_style']['display_style'];
                            $arsfan_page_skin = isset($displays['page']['skin']) ? $displays['page']['skin'] : 'metro';
                            ?>
                            <div class="arsocialshare_option_container ars_column arsmarginleft10">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select name="arsfan_page_skin" class="arsocialshare_dropdown ars_lite_pro_options" id="arsfan_page_skin">
                                            <?php foreach ($display_style as $key => $value) { ?>
                                                <option <?php selected($arsfan_page_skin, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select id='arsfan_page_number_format' name='arsfan_page_number_format' class="arsocialshare_dropdown">
                                            <?php
                                            $counter_number_format = $sociallike_tab_option['counter_number_format']['counter_number_format'];
                                            $arsfan_page_no_format = isset($displays['page']['no_format']) ? $displays['page']['no_format'] : 'style1';
                                            foreach ($counter_number_format as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php selected($arsfan_page_no_format, $key); ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $page_top_checked = "";
                                        $page_bottom_checked = "";
                                        if (isset($displays['page']['top']) && $displays['page']['top'] == true) {
                                            $page_top_checked = "checked='checked'";
                                        }
                                        if (isset($displays['page']['bottom']) && $displays['page']['bottom'] == true) {
                                            $page_bottom_checked = "checked='checked'";
                                        }
                                        if ($page_top_checked == '' && $page_bottom_checked == '') {
                                            $page_top_checked = "checked='checked'";
                                        }
                                        ?>
                                        <input type="radio" name="ars_fan_page_position_top" value="top" data-on="top" <?php echo $page_top_checked; ?> class="arsocialshare_display_networks_on ars_hide_checkbox ars_fan_pages_top" id="ars_fan_pages_buttons_on_top" />
                                        <input type="radio" name="ars_fan_page_position_bottom" value="bottom" <?php echo $page_bottom_checked; ?> data-on="bar" class="arsocialshare_display_networks_on ars_hide_checkbox ars_fan_pages_bottom" id="ars_fan_pages_buttons_on_bottom" />
                                        <div class="arsocialshare_inner_option_box arsocialshare_pages_position <?php echo ($page_top_checked !== '') ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('ars_fan_pages_buttons_on_top', 'arsocialshare_enable_pages', 'fan');" id="ars_fan_pages_buttons_on_top_img" data-value="top">
                                            <span class="arsocialshare_inner_option_icon pages_top"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_pages_position <?php echo ($page_bottom_checked !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('ars_fan_pages_buttons_on_bottom', 'arsocialshare_enable_pages', 'fan');" id="ars_fan_pages_buttons_on_bottom_img" data-value="bottom">
                                            <span class="arsocialshare_inner_option_icon pages_bottom"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $page_btn_align = isset($displays['page']['btn_alignment']) ? $displays['page']['btn_alignment'] : 'center';
                                        ?>
                                        <input type="radio" name="ars_page_btn_align" id="ars_page_btn_left" <?php checked($page_btn_align, 'left'); ?> value="left" class="ars_hide_checkbox ars_pages_btn_align_input" />
                                        <input type="radio" name="ars_page_btn_align" id="ars_page_btn_center" <?php checked($page_btn_align, 'center'); ?> value="center" class="ars_hide_checkbox ars_pages_btn_align_input"  />
                                        <input type="radio" name="ars_page_btn_align" id="ars_page_btn_right" <?php checked($page_btn_align, 'right'); ?> value="right" class="ars_hide_checkbox ars_pages_btn_align_input" />
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($page_btn_align === 'left') ? 'selected' : ''; ?>" id="ars_page_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_page_btn_left', 'ars_pages_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($page_btn_align === 'center') ? 'selected' : ''; ?>" id="ars_page_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_page_btn_center', 'ars_pages_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_align <?php echo ($page_btn_align === 'right') ? 'selected' : ''; ?>" id="ars_page_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_page_btn_right', 'ars_pages_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">


                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_pages_btn_width = isset($displays['page']['btn_width']) ? $displays['page']['btn_width'] : 'medium';
                                        ?>
                                        <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_small" value="small" <?php checked($arsfan_pages_btn_width, 'small'); ?> class="ars_hide_checkbox ars_fan_page_btn_width_input" />
                                        <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_medium" value="medium" <?php checked($arsfan_pages_btn_width, 'medium'); ?> class="ars_hide_checkbox ars_fan_page_btn_width_input"  />
                                        <input type="radio" name="ars_pages_btn_width" id="ars_pages_btn_large" value="large" <?php checked($arsfan_pages_btn_width, 'large'); ?> class="ars_hide_checkbox ars_fan_page_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $arsfan_pages_btn_width === 'small' ) ? 'selected' : ''; ?>" id="ars_pages_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_pages_btn_small', 'ars_pages_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $arsfan_pages_btn_width === 'medium' ) ? 'selected' : ''; ?>" id="ars_pages_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_pages_btn_medium', 'ars_pages_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_pages_btn_width <?php echo ( $arsfan_pages_btn_width === 'large' ) ? 'selected' : ''; ?>" id="ars_pages_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_pages_btn_large', 'ars_pages_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_page_more_btn = isset($displays['page']['more_btn']) ? $displays['page']['more_btn'] : '5'; ?>
                                        <input type="text" name="arsfan_more_button" class="arsocialshare_input_box" id="arsfan_more_button" value="<?php echo $arsfan_page_more_btn; ?>" />
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arfan_more_btn_style = isset($displays['page']['more_btn_style']) ? $displays['page']['more_btn_style'] : 'plus_icon'; ?>
                                        <select name="arsfan_page_more_button_style" id="arsfan_page_more_button_style" class="arsocialshare_dropdown">
                                            <option <?php selected($arfan_more_btn_style, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arfan_more_btn_style, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_page_more_btn_action = isset($displays['page']['more_btn_action']) ? $displays['page']['more_btn_action'] : 'display_popup'; ?>
                                        <select name="arsfan_pages_more_btn_action" id="arsfan_pages_more_btn_action" class="arsocialshare_dropdown" style="width:245px;">
                                            <option value="display_inline" <?php selected($arsfan_page_more_btn_action, 'display_inline'); ?> ><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                            <option value="display_popup" <?php selected($arsfan_page_more_btn_action, 'display_popup'); ?>><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_button_position_wrapper" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Like / Follow Button Position', 'arsocial_lite'); ?><br/>(<?php esc_html_e('on hover', 'arsocial_lite'); ?>)</div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_page_like_follow_btn_position = isset($displays['page']['like_follow_btn_position']) ? $displays['page']['like_follow_btn_position'] : 'top'; ?>
                                        <select name="arsfan_pages_like_follow_position" id="arsfan_pages_like_follow_position" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_page_like_follow_btn_position, 'top'); ?> value="top"><?php esc_html_e('Top', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_page_like_follow_btn_position, 'bottom'); ?> value="bottom"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_page_like_follow_btn_position, 'left'); ?> value="left"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_page_like_follow_btn_position, 'right'); ?> value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                                <div class="ars_template_preview_container ars_fan_btn_preview" style="margin-top:-15px;">
                                    <div class="arsocialshare_fan_preview_container ars_fan_counter_main_preview arslite_<?php echo $arsfan_pages_btn_width; ?>_fan_button" id="ars_fan_counter_pages_preview">
                                        <?php foreach ($display_style as $key => $value): ?>
                                            <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($arsfan_page_skin == $key) ? 'display:block;' : ''; ?>">
                                                <ul>
                                                    <li class="ars_fan_network-facebook">
                                                        <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_page_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                                            <div class="ars_fan_like_inner_wrapper">
                                                                <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)">
                                                            <div class="ars_fan_network"><i class="ars_fan_network_icon socialshare-facebook facebook"></i><span class="ars_fan_value">175k</span><span class="ars_fan_label"><?php esc_html_e('Fans', 'arsocial_lite'); ?></span></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <?php $arsfan_page_exclude = isset($displays['page']['exclude_pages']) ? $displays['page']['exclude_pages'] : ''; ?>
                                    <input type="text" name="arsfan_page_exclude" id="arsfan_page_exclude" value="<?php echo $arsfan_page_exclude; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>


                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Pages', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated page id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                        </div>

                        <div class="ars_network_list_container <?php echo ($enable_posts !== '' ) ? 'selected' : ''; ?>" id="ars_fan_posts">
                            <div class="arsocialshare_option_title">
                            <div class="arsocial_option_title_img_div"><img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/post_setting.png" /></div>
                            <div class="arsfontsize25"><?php esc_html_e('Post Settings', 'arsocial_lite'); ?></div>
                            </div>
                            <?php
                            $display_style = $sociallike_tab_option['display_style']['display_style'];
                            $arsfan_post_skin = isset($displays['post']['skin']) ? $displays['post']['skin'] : 'metro';
                            ?>
                            <div class="arsocialshare_option_container ars_column arsmarginleft10">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select name="arsfan_post_skin" class="arsocialshare_dropdown ars_lite_pro_options" id="arsfan_post_skin">
                                            <?php foreach ($display_style as $key => $value) { ?>
                                                <option <?php selected($arsfan_post_skin, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select id='ars_posts_no_format' name='ars_posts_no_format' class="arsocialshare_dropdown">
                                            <?php
                                            $counter_number_format = $sociallike_tab_option['counter_number_format']['counter_number_format'];
                                            $arsfan_post_no_format = isset($displays['post']['no_format']) ? $displays['post']['no_format'] : '';

                                            foreach ($counter_number_format as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php selected($arsfan_post_no_format, $key); ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $posts_top = "";
                                        $posts_bottom = "";
                                        if (isset($displays['post']['top']) && $displays['post']['top'] === 'top') {
                                            $posts_top = "checked='checked'";
                                        }
                                        if (isset($displays['post']['bottom']) && $displays['post']['bottom'] === 'bottom') {
                                            $posts_bottom = "checked='checked'";
                                        }
                                        if ($posts_top == '' && $posts_bottom == '') {
                                            $posts_top = "checked='checked'";
                                        }
                                        ?>
                                        <input type="radio" name="arsfan_post_position_top" value="top" data-on="top_bar" <?php echo $posts_top; ?> class="arsocialshare_display_networks_on ars_hide_checkbox ars_fan_posts_top" id="ars_fan_posts_buttons_on_top" />
                                        <input type="radio" name="arsfan_post_position_bottom" value="bottom" <?php echo $posts_bottom; ?> data-on="bottom_bar" class="arsocialshare_display_networks_on ars_hide_checkbox ars_fan_posts_bottom" id="ars_fan_posts_buttons_on_bottom" />
                                        <div class="arsocialshare_inner_option_box arsocialshare_posts_position <?php echo ($posts_top !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('ars_fan_posts_buttons_on_top', 'arsocialshare_enable_posts', 'fan');" id="ars_fan_posts_buttons_on_top_img" data-value="top">
                                            <span class="arsocialshare_inner_option_icon posts_top"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_posts_position <?php echo ($posts_bottom !== '' ) ? "selected" : ""; ?>" onclick="ars_select_checkbox_img('ars_fan_posts_buttons_on_bottom', 'arsocialshare_enable_posts', 'fan');" id="ars_fan_posts_buttons_on_bottom_img" data-value="right">
                                            <span class="arsocialshare_inner_option_icon posts_bottom"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_update_btn_align = isset($displays['post']['btn_alignment']) ? $displays['post']['btn_alignment'] : 'center';
                                        ?>
                                        <input type="radio" name="ars_posts_btn_align" id="ars_posts_btn_left" <?php checked($arsfan_update_btn_align, 'left'); ?> value="left" class="ars_hide_checkbox ars_posts_btn_align_input" />
                                        <input type="radio" name="ars_posts_btn_align" id="ars_posts_btn_center" <?php checked($arsfan_update_btn_align, 'center'); ?> value="center" class="ars_hide_checkbox ars_posts_btn_align_input"  />
                                        <input type="radio" name="ars_posts_btn_align" id="ars_posts_btn_right" <?php checked($arsfan_update_btn_align, 'right'); ?> value="right" class="ars_hide_checkbox ars_posts_btn_align_input" />
                                        <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($arsfan_update_btn_align === 'left') ? 'selected' : ''; ?>" id="ars_posts_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_posts_btn_left', 'ars_top_bottom_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($arsfan_update_btn_align === 'center') ? 'selected' : ''; ?>" id="ars_posts_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_posts_btn_center', 'ars_top_bottom_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($arsfan_update_btn_align === 'right') ? 'selected' : ''; ?>" id="ars_posts_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_posts_btn_right', 'ars_top_bottom_btn_align');">
                                            <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_button_position_wrapper" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Like / Follow Button Position', 'arsocial_lite'); ?><br/>(<?php esc_html_e('on hover', 'arsocial_lite'); ?>)</div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_post_like_follow_btn_position = isset($displays['post']['like_follow_btn_position']) ? $displays['post']['like_follow_btn_position'] : 'top'; ?>
                                        <select name="arsfan_posts_like_follow_position" id="arsfan_posts_like_follow_position" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_post_like_follow_btn_position, 'top'); ?> value="top"><?php esc_html_e('Top', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_post_like_follow_btn_position, 'bottom'); ?> value="bottom"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_post_like_follow_btn_position, 'left'); ?> value="left"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_post_like_follow_btn_position, 'right'); ?> value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_posts_btn_width = isset($displays['post']['btn_width']) ? $displays['post']['btn_width'] : 'medium';
                                        ?>
                                        <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_small" <?php checked($arsfan_posts_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_fan_post_btn_width_input" />
                                        <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_medium" <?php checked($arsfan_posts_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_fan_post_btn_width_input"  />
                                        <input type="radio" name="ars_posts_btn_width" id="ars_posts_btn_large" <?php checked($arsfan_posts_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_fan_post_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ($arsfan_posts_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_posts_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_posts_btn_small', 'ars_posts_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ($arsfan_posts_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_posts_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_posts_btn_medium', 'ars_posts_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_posts_btn_width <?php echo ($arsfan_posts_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_posts_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_posts_btn_large', 'ars_posts_btn_width')">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_post_more_btn = isset($displays['post']['more_btn']) ? $displays['post']['more_btn'] : '5';
                                        ?>
                                        <input type="text" name="arsocialshare_posts_more_button" class="arsocialshare_input_box" id="arsocialshare_posts_more_button" value="<?php echo $arsfan_post_more_btn; ?>" />
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $ars_fan_posts_more_btn_style = isset($displays['post']['more_btn_style']) ? $displays['post']['more_btn_style'] : 'plus_icon';
                                        ?>
                                        <select name="arsocialshare_posts_more_button_style" id="arsocialshare_posts_more_button_style" class="arsocialshare_dropdown">
                                            <option <?php selected($ars_fan_posts_more_btn_style, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                            <option <?php selected($ars_fan_posts_more_btn_style, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arfan_posts_more_btn_action = isset($displays['post']['more_btn_action']) ? $displays['post']['more_btn_action'] : 'display_popup';
                                        ?>
                                        <select name="arsocialshare_posts_more_button_action" id="arsocialshare_posts_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                            <option <?php selected($arfan_posts_more_btn_action, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arfan_posts_more_btn_action, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Enable Social Icons on Post Excerpt', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $enable_post_excerpt = isset($displays['post']['excerpt']) ? $displays['post']['excerpt'] : 'no';
                                        ?>
                                        <input type="hidden" name="ars_fan_enable_post_excerpt" id="ars_fan_enable_post_excerpt" value="<?php echo $enable_post_excerpt; ?>" />
                                        <div class="arsocialshare_switch <?php echo ($enable_post_excerpt === 'yes' ) ? 'selected' : ''; ?>" data-id="ars_fan_enable_post_excerpt">
                                            <div class="arsocialshare_switch_options">
                                                <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                                <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                            </div>
                                            <div class="arsocialshare_switch_button"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" style="margin-top:-15px;" />-->
                                <div class="ars_template_preview_container ars_fan_btn_preview" style="margin-top:-15px;">
                                    <div class="arsocialshare_fan_preview_container ars_fan_counter_main_preview arslite_<?php echo $arsfan_posts_btn_width; ?>_fan_button" id="ars_fan_counter_posts_preview">
                                        <?php foreach ($display_style as $key => $value): ?>
                                            <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($arsfan_post_skin == $key) ? 'display:block;' : ''; ?>">
                                                <ul>
                                                    <li class="ars_fan_network-facebook">
                                                        <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_post_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                                            <div class="ars_fan_like_inner_wrapper">
                                                                <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)">
                                                            <div class="ars_fan_network"><i class="ars_fan_network_icon socialshare-facebook facebook"></i><span class="ars_fan_value">175k</span><span class="ars_fan_label"><?php esc_html_e('Fans', 'arsocial_lite'); ?></span></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_posts_excludes" id="arsocialshare_posts_excludes" value="<?php echo isset($displays['post']['exclude_pages']) ? $displays['post']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Posts', 'arsocial_lite'); ?></div>

                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated post id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                            <div class="arsocial_lite_locker_row_seperator"></div>
                            <div class="arsocialshare_clear">&nbsp;</div>
                        </div>
                    </div>
                </div>

                <?php
                $no = 4;
                if (is_plugin_active('woocommerce/woocommerce.php')) {
                    ?>
                                                                                                                        <!--<input type="hidden" name="ars_enable_woocommerce" id="ars_enable_woocommerce" value="enable_woocommerce" /> -->
                    <div class="arsocialshare_title_belt">
                        <div class="arsocialshare_title_belt_number"><?php echo $no; ?></div>
                        <div class="arsocialshare_belt_title"><?php esc_html_e('Woocommerce Settings', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                    </div>
                    <div class="ars_network_list_container selected arsocial_lite_global_section_restricted" id="arsocialshare_woocommerce" style="padding-top:10px;">
                        <div class="disable_all_click_event">

                        <div id="ars_fan_woocommerce" class="selected">
                            <div class="arsocialshare_option_container ars_column">
                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select name="ars_fan_woocommerce_skins" id="ars_fan_woocommerce_skins" class="arsocialshare_dropdown ars_lite_pro_options">
                                            <?php
                                            $woocommerce_skin = isset($displays['woocommerce']['skin']) ? $displays['woocommerce']['skin'] : 'metro';
                                            $display_style = $sociallike_tab_option['display_style']['display_style'];
                                            foreach ($display_style as $value => $label) {
                                                ?>
                                                <option <?php selected($woocommerce_skin, $value); ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <label class="arsocialshare_inner_option_label more_templates_label"><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <select id='arsfan_woocommerce_number_format' name='arsfan_woocommerce_number_format' class="arsocialshare_dropdown">
                                            <?php
                                            $counter_number_format = $sociallike_tab_option['counter_number_format']['counter_number_format'];
                                            $fan_woocommerce_no_format = isset($displays['woocommerce']['no_format']) ? $displays['woocommerce']['no_format'] : 'style1';
                                            foreach ($counter_number_format as $key => $value) {
                                                ?>
                                                <option <?php selected($fan_woocommerce_no_format, $key); ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $ars_woocommerce_before_product = "";
                                        $ars_woocommerce_after_product = "";
                                        $ars_woocommerce_after_price = "";
                                        if (isset($displays['woocommerce']['before_product']) && $displays['woocommerce']['before_product'] === 'before_product') {
                                            $ars_woocommerce_before_product = "checked='checked'";
                                        }
                                        if (isset($displays['woocommerce']['after_product']) && $displays['woocommerce']['after_product'] === 'after_product') {
                                            $ars_woocommerce_after_product = "checked='checked'";
                                        }
                                        if (isset($displays['woocommerce']['after_price']) && $displays['woocommerce']['after_price'] === 'after_price') {
                                            $ars_woocommerce_after_price = "checked='checked'";
                                        }
                                        if ($ars_woocommerce_before_product == '' && $ars_woocommerce_after_product == '' && $ars_woocommerce_after_price == '') {
                                            $ars_woocommerce_after_product = "checked='checked'";
                                        }
                                        ?>
                                        <input type="radio" name="ars_fan_woocommerce_before_product" value="before_product" <?php echo $ars_woocommerce_before_product; ?> data-on="before_product" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_woocommerce_buttons_before_product" />
                                        <input type="radio" name="ars_fan_woocommerce_after_product" value="after_product" <?php echo $ars_woocommerce_after_product; ?> data-on="after_product" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_woocommerce_buttons_after_product" />
                                        <input type="radio" name="ars_fan_woocommerce_after_price" value="after_price" <?php echo $ars_woocommerce_after_price; ?> data-on="after_price" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_woocommerce_buttons_after_price" />

                                        <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($ars_woocommerce_before_product != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_before_product_img" data-value="left" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_before_product', '', '');">
                                            <span class="arsocialshare_inner_option_icon woocommerce_before_product"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('Before Product', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($ars_woocommerce_after_product != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_after_product_img" data-value="right" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_after_product', '', '');">
                                            <span class="arsocialshare_inner_option_icon woocommerce_after_product"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('After Product', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box arsocialshare_woocommerce_position <?php echo ($ars_woocommerce_after_price != '') ? 'selected' : ''; ?>" id="arsocialshare_woocommerce_buttons_after_price_img" data-value="right" onclick="ars_select_checkbox_img('arsocialshare_woocommerce_buttons_after_price', '', '');">
                                            <span class="arsocialshare_inner_option_icon woocommerce_after_price"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label" style="line-height:normal;"><?php esc_html_e('After Price', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $ars_woocommerce_btn_align = isset($displays['woocommerce']['btn_align']) ? $displays['woocommerce']['btn_align'] : 'center';
                                        ?>
                                        <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_left" <?php checked($ars_woocommerce_btn_align, 'left'); ?> value="left" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                        <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_center" <?php checked($ars_woocommerce_btn_align, 'center'); ?> value="center" class="ars_hide_checkbox ars_top_bottom_btn_align_input"  />
                                        <input type="radio" name="ars_woocommerce_btn_align" id="ars_woocommerce_align_right" <?php checked($ars_woocommerce_btn_align, 'right'); ?> value="right" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ( $ars_woocommerce_btn_align === 'left' ) ? 'selected' : ''; ?>" id="ars_woocommerce_align_left_img" onclick="ars_select_radio_img('ars_woocommerce_align_left', 'ars_woocommerce_btn_align');" data-value="left">
                                            <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ( $ars_woocommerce_btn_align === 'center' ) ? 'selected' : ''; ?>" id="ars_woocommerce_align_center_img" onclick="ars_select_radio_img('ars_woocommerce_align_center', 'ars_woocommerce_btn_align');" data-value="center">
                                            <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_align <?php echo ( $ars_woocommerce_btn_align === 'right' ) ? 'selected' : ''; ?>" id="ars_woocommerce_align_right_img" onclick="ars_select_radio_img('ars_woocommerce_align_right', 'ars_woocommerce_btn_align');" data-value="right">
                                            <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $woocommerce_btn_width = isset($displays['woocommerce']['btn_width']) ? $displays['woocommerce']['btn_width'] : 'small';
                                        ?>
                                        <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_small" <?php checked($woocommerce_btn_width, 'small'); ?> value="small" class="ars_hide_checkbox ars_fan_woocommerce_btn_width_input" />
                                        <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_medium" <?php checked($woocommerce_btn_width, 'medium'); ?> value="medium" class="ars_hide_checkbox ars_fan_woocommerce_btn_width_input"  />
                                        <input type="radio" name="ars_woocommerce_btn_width" id="ars_woocommerce_btn_large" <?php checked($woocommerce_btn_width, 'large'); ?> value="large" class="ars_hide_checkbox ars_fan_woocommerce_btn_width_input" />
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ( $woocommerce_btn_width === 'small' ) ? 'selected' : ''; ?>" id="ars_woocommerce_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_woocommerce_btn_small', 'ars_woocommerce_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width" <?php echo ( $woocommerce_btn_width === 'medium' ) ? 'selected' : ''; ?> id="ars_woocommerce_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_woocommerce_btn_medium', 'ars_woocommerce_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                        </div>
                                        <div class="arsocialshare_inner_option_box ars_woocommerce_btn_width <?php echo ( $woocommerce_btn_width === 'large' ) ? 'selected' : ''; ?>" id="ars_woocommerce_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_woocommerce_btn_large', 'ars_woocommerce_btn_width');">
                                            <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                            <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_woocommerce_more_btn = isset($displays['woocommerce']['more_btn']) ? $displays['woocommerce']['more_btn'] : '5'; ?>
                                        <input type="text" class="arsocialshare_input_box" name="arsocialshare_woocommerce_more_button" id="arsocialshare_woocommerce_more_button" value="<?php echo $arsfan_woocommerce_more_btn; ?>" />
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php
                                        $arsfan_woocommerce_more_btn_style = isset($displays['woocommerce']['more_btn_style']) ? $displays['woocommerce']['more_btn_style'] : 'plus_icon';
                                        ?>
                                        <select name="arsocialshare_woocommerce_more_button_style" id="arsocialshare_woocommerce_more_button_style" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_woocommerce_more_btn_style, 'plus_icon'); ?> value="plus_icon"><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_woocommerce_more_btn_style, 'dot_icon'); ?> value="dot_icon"><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_woocommerce_more_btn_action = isset($displays['woocommerce']['more_btn_action']) ? $displays['woocommerce']['more_btn_action'] : 'display_popup'; ?>
                                        <select name="arsocialshare_woocommerce_more_button_action" id="arsocialshare_woocommerce_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                            <option <?php selected($arsfan_woocommerce_more_btn_action, 'display_inline'); ?> value="display_inline"><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_woocommerce_more_btn_action, 'display_popup'); ?> value="display_popup"><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="arsocialshare_option_row ars_fan_button_position_wrapper" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                    <div class="arsocialshare_option_label"><?php esc_html_e('Like / Follow Button Position', 'arsocial_lite'); ?><br/>(<?php esc_html_e('on hover', 'arsocial_lite'); ?>)</div>
                                    <div class="arsocialshare_option_input">
                                        <?php $arsfan_woocommerce_like_follow_btn_position = isset($displays['woocommerce']['like_follow_btn_position']) ? $displays['woocommerce']['like_follow_btn_position'] : 'top'; ?>
                                        <select name="arsfan_woocommerce_like_follow_position" id="arsfan_woocommerce_like_follow_position" class="arsocialshare_dropdown">
                                            <option <?php selected($arsfan_woocommerce_like_follow_btn_position, 'top'); ?> value="top"><?php esc_html_e('Top', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_woocommerce_like_follow_btn_position, 'bottom'); ?> value="bottom"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_woocommerce_like_follow_btn_position, 'left'); ?> value="left"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                            <option <?php selected($arsfan_woocommerce_like_follow_btn_position, 'right'); ?> value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="arsocialshare_option_container ars_column ars_no_border">
                                <!--<img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/preview_box_img.png" />-->
                                <div class="ars_template_preview_container ars_fan_btn_preview" style="margin-top:-15px;">
                                    <div class="arsocialshare_fan_preview_container ars_fan_counter_main_preview arslite_<?php echo $woocommerce_btn_width; ?>_fan_button" id="ars_fan_counter_woocommerce_preview">
                                        <?php foreach ($display_style as $key => $value): ?>
                                            <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($woocommerce_skin == $key) ? 'display:block;' : ''; ?>">
                                                <ul>
                                                    <li class="ars_fan_network-facebook">
                                                        <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_woocommerce_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
                                                            <div class="ars_fan_like_inner_wrapper">
                                                                <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/like_btn_facebook.png" alt="facebook">
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0)">
                                                            <div class="ars_fan_network"><i class="ars_fan_network_icon socialshare-facebook facebook"></i><span class="ars_fan_value">175k</span><span class="ars_fan_label"><?php esc_html_e('Fans', 'arsocial_lite'); ?></span></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="arsocialshare_option_container" style="margin-top:20px;">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;"><?php esc_html_e('Exclude Products', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input" style="padding-top:6px;">
                                    <input type="text" name="arsocialshare_page_excludes_woocommerce" id="arsocialshare_page_excludes_woocommerce" value="<?php echo isset($displays['woocommerce']['exclude_pages']) ? $displays['woocommerce']['exclude_pages'] : ''; ?>" class="arsocialshare_input_box" style="width:540px;" />
                                </div>
                            </div>

                            <div class="arsocialshare_option_container">
                                <div class="arsocialshare_social_label" style="padding-right:10px;text-align:left;width:auto;color:#ffffff;"><?php esc_html_e('Exclude Products', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_social_input arsocialshare_halp_text" style="line-height:normal;width:540px;"><?php esc_html_e('Enter comma seperated prduct id where you do not want to display buttons.', 'arsocial_lite'); ?></div>
                            </div>

                        </div>
                        </div>
                    </div>
                    <?php
                    $no++;
                }
                ?>
                <!-- 18-02-2016 -->
                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number"><?php
                        echo $no;
                        $no++;
                        ?></div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Mobile Display Settings', 'arsocial_lite'); ?> </div>
                </div>


                <div class="ars_network_list_container selected" style="width:100%;">

                    <div class="arsocialshare_option_container ars_no_border" style="width:100%; padding-top:0;  ">
                        <?php
                        // mobile
                        $mobile_checked = "";
                        $mobile_options = "display:none;";

                        if (is_array($displays) && array_key_exists('mobile', $displays)) {
                            $mobile_checked = "checked='checked'";
                            $mobile_options = "display:block;";
                        }

                        $arsfan_display_mobile_skin = isset($displays['mobile']['skin']) ? $displays['mobile']['skin'] : 'metro';
                        ?>
                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label" style="width: 12%;"><?php echo esc_html__('Display on Custom Position', 'arsocial_lite'); ?> </div>
                            <div class="arsocialshare_option_input" style="width: 88%;">
                                <input type="radio" name="arsocialshare_enable_mobile" id="arsocialshare_enable_mobile" class="ars_display_option_input ars_hide_checkbox" value="<?php echo ($mobile_checked != '' ) ? 'mobile' : ''; ?>" <?php echo ($mobile_checked != '') ? "checked='checked'" : ''; ?> />
                                <div class="arsocialshare_switch <?php echo ($mobile_checked != '' && $mobile_checked != 'no') ? "selected" : ""; ?>" data-id="arsocialshare_enable_mobile">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="mobile"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>

                        <div id="ars_mobile_position" style="<?php echo $mobile_options; ?>">

                            <div class="arsocialshare_option_row">
                                <div class="arsocialshare_option_label" style="width:12%;"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_option_input ars_mobile_skin">
                                    
                                    <input type='hidden' id='arsocialfan_display_style_mobile' name = 'arsocialfan_display_style_mobile' value=' <?php echo $arsfan_display_mobile_skin; ?>' /> 
                                    <dl style="" data-id="arsocialfan_display_style_mobile" data-name="arsocialfan_display_style_mobile" class="arsocialshare_selectbox">
                                        <dt>
                                        <span>
                                            <?php echo $display_style[$arsfan_display_mobile_skin]; ?>
                                        </span>
                                        <input type="text" class="ars_autocomplete" value="<?php echo $display_style[$arsfan_display_mobile_skin]; ?>" style="display:none;">
                                        <div style="" class="socialshare-angle-down ars_angle_dropdown"></div>
                                        </dt>
                                        <dd>
                                            <ul style="display:none" data-id='arsocialfan_display_style_mobile'>
                                                <?php
                                                unset($display_style['round_color_icons']);
                                                unset($display_style['modern']);
                                                unset($display_style['color_icons']);
                                                unset($display_style['grey_icons']);
                                                unset($display_style['outline_color_icons']);
                                                foreach ($display_style as $key => $value) {
                                                    ?>
                                                    <li id='<?php echo $key ?>' label='<?php echo $value; ?>' data-value='<?php echo $key; ?>' style="" class="ars_mobile_template_fan">
                                                        <img src='<?php echo ARSOCIAL_LITE_IMAGES_URL . '/' . $key . '_dropdown_icon.png' ?>' />
                                                        <div style='margin-top:5px;'>
                                                            <?php echo $value; ?>
                                                        </div>
                                                    </li>

                                                <?php } ?>
                                            </ul>
                                        </dd>
                                    </dl>    
                                </div>
                            </div>

                            <div class="arsocialshare_option_row"  >
                                <div class="arsocialshare_option_label" style="width: 12%; line-height:50px;" ><?php esc_html_e('Position Type', 'arsocial_lite'); ?> </div>
                                <div class="arsocialshare_option_input" style="width: 88%;">
                                    <div class="arsocialshare_position_image arsocialshare_display_on_mobile <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_footer_icons') ? "selected" : ""; ?>" id="arsocialshare_share_button_bar_footer_icons_img" onclick="ars_select_radio_img('arsocialshare_share_button_bar_footer_icons', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_footer_icons'>
                                        <input type="radio" name="arsocialshare_display_mobile"  value="share_footer_icons" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_button_bar_footer_icons" />
                                        <span class="arsocialshare_position_image_icon_footer_icons"></span>
                                        <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Footer Icons', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_position_image arsocialshare_display_on_mobile" id="arsocialshare_share_button_bar_type_img" onclick="ars_select_radio_img('arsocialshare_share_button_bar_type', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_footer_bar'>
                                        <input type="radio" name="arsocialshare_display_mobile"  value="share_button_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_button_bar_type" />
                                        <span class="arsocialshare_fan_position_image_icon_footer_bar"></span>
                                        <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Footer Bar', 'arsocial_lite'); ?></label>
                                        <span class='ars_lite_pro_version_info_label'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                    </div>
                                    <div class="arsocialshare_position_image arsocialshare_display_on_mobile" id="arsocialshare_share_left_point_type_img" onclick="ars_select_radio_img('arsocialshare_share_left_point_type', 'arsocialshare_display_on_mobile');" data-id='arsshare_mobile_side_buttons'>
                                        <input type="radio" name="arsocialshare_display_mobile" value="share_point" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_share_left_point_type" />
                                        <span class="arsocialshare_fan_position_image_icon_left_point"></span>
                                        <label class="arsocialshare_opt_inner_label ars_bottom_label"><?php esc_html_e('Side Buttons', 'arsocial_lite'); ?></label>
                                        <span class='ars_lite_pro_version_info_label'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                                    </div>

                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_footer_icons') ? 'block' : 'none'; ?>" id='arsshare_mobile_footer_icons'>
                                <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?> </div>
                                <?php
                                $mobile_more_btn_style = (isset($displays['mobile']['more_button_style']) && !empty($displays['mobile']['more_button_style'])) ? $displays['mobile']['more_button_style'] : "plus_icon";
                                ?>

                                <div class="arsocialshare_option_input ars_mobile_skin">
                                    <select name="arsocialshare_mobile_more_button_style" id="arsocialshare_mobile_more_button_style" class="arsocialshare_dropdown">
                                        <option value="plus_icon" <?php selected($mobile_more_btn_style, 'plus_icon'); ?>><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                        <option value="dot_icon" <?php selected($mobile_more_btn_style, 'dot_icon'); ?>><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_button_bar') ? 'block' : 'none'; ?>" id='arsshare_mobile_footer_bar'>
                                <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('Footer Bar Label', 'arsocial_lite'); ?> </div>
                                <div class="arsocialshare_option_input ars_mobile_skin">
                                    <?php 
                                    $mobile_more_btn_after = 'Fan Counter'; ?>
                                    <input type="text" name="arsocialshare_mobile_bottom_bar_label" class="arsocialshare_input_box" id="arsocialshare_mobile_bottom_bar_label" value="<?php echo $mobile_more_btn_after; ?>" readonly="readonly" />
                                </div>
                            </div>                    
                            <div class="arsocialshare_option_row ars_mobile_position_custom" style="display: <?php echo (isset($displays['mobile']['disply_type']) && $displays['mobile']['disply_type'] == 'share_point') ? 'block' : 'none'; ?>" id='arsshare_mobile_side_buttons'>
                                <div class="arsocialshare_option_label" style="width: 12%;"><?php esc_html_e('Select Button Position', 'arsocial_lite'); ?> </div>
                                <div class="arsocialshare_option_input ars_mobile_skin">
                                   
                                    <select name="arsocialshare_mobile_more_button_position" id="arsocialshare_mobile_more_button_position" class="arsocialshare_dropdown">
                                        <option value="left" selected="selected"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                        <option value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_litemargintop30">
                            <div class="arsocialshare_option_label" style="width: 12%; line-height:40px;"><?php esc_html_e('Hide on Mobile', 'arsocial_lite'); ?> </div>
                            <div class="arsocialshare_option_input" style="width: 88%; line-height:30px;">
                                <div class="arshare_opt_checkbox_row">
                                    <div class="arsocialshare_opt_inner_input_wrapper">
                                        <input type="checkbox" name="arsocialshare_mobile_hide_top" value="1" id="arsocialshare_mobile_hide_top" class="ars_display_option_input"  data-id="enable_mobile_hide_top" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_top']) ? $displays['hide_mobile']['enable_mobile_hide_top'] : '', 1); ?> />
                                        <label for="arsocialshare_mobile_hide_top" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Top Position', 'arsocial_lite'); ?></label>
                                    </div>
                                    <div class="arsocialshare_opt_inner_input_wrapper">
                                        <input type="checkbox" name="arsocialshare_mobile_hide_bottom" value="1" id="arsocialshare_mobile_hide_bottom" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_bottom']) ? $displays['hide_mobile']['enable_mobile_hide_bottom'] : '', 1); ?> data-id="enable_mobile_hide_bottom" />
                                        <label for="arsocialshare_mobile_hide_bottom" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Bottom Position', 'arsocial_lite'); ?></label>
                                    </div>

                                    <div class="arsocialshare_opt_inner_input_wrapper">
                                        <input type="checkbox" name="arsocialshare_mobile_hide_sidebar" value="1" id="arsocialshare_mobile_hide_sidebar" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_sidebar']) ? $displays['hide_mobile']['enable_mobile_hide_sidebar'] : '', 1); ?> data-id="enable_mobile_hide_sidebar" />
                                        <label for="arsocialshare_mobile_hide_sidebar" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Sidebar', 'arsocial_lite'); ?></label>
                                    </div>
                                </div>

                                <div class="arshare_opt_checkbox_row" style="line-height:normal;">
                                    <div class="arsocialshare_opt_inner_input_wrapper">
                                        <input type="checkbox" name="enable_mobile_hide_top_bottom_bar" value="1" id="enable_mobile_hide_top_bottom_bar" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_top_bottom_bar']) ? $displays['hide_mobile']['enable_mobile_hide_top_bottom_bar'] : '', 1); ?> data-id="enable_mobile_hide_top_bottom_bar" />
                                        <label for="enable_mobile_hide_top_bottom_bar" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Top/Bottom Bar', 'arsocial_lite'); ?></label>
                                    </div>

                                    <div class="arsocialshare_opt_inner_input_wrapper arsocial_lite_global_section_restricted">
                                        <div class="disable_all_click_event">
                                        <input type="checkbox" name="arsocialshare_mobile_hide_onload" value="1" id="enable_mobile_hide_onload" class="ars_display_option_input" <?php checked(isset($displays['hide_mobile']['enable_mobile_hide_onload']) ? $displays['hide_mobile']['enable_mobile_hide_onload'] : '', 1); ?> data-id="enable_mobile_hide_onload" />
                                        <label for="enable_mobile_hide_onload" class="arsocialshare_opt_inner_label_checkbox"><span></span><?php esc_html_e('Hide Popup', 'arsocial_lite'); ?></label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number"><?php
                        echo $no;
                        $no++;
                        ?></div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Custom CSS', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                </div>

                <div class="ars_network_list_container selected" style="width:100%;">
                    <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%; padding-top:0;  ">
                        <div class="arsocialshare_option_row" style="padding-bottom: 0px;">
                            <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Enter Custom CSS', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input arsocial_lite_custom_css_global_restricted" style="width: 88%;">
                                <div class="arshare_opt_checkbox_row">
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                        <textarea style="width:700px;height:200px;padding:5px 10px !important;" name="arsocialshare_fan_customcss" id="arsocialshare_fan_customcss" class="ars_display_option_input"></textarea>
                                    </div>
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%; margin-top:10px; ">
                                        <span class='arsocial_lite_locker_note' style="width: 100%;">
                                            <?php echo "eg: .arsocial_lite_fan_top_button { background-color: #d1d1d1; }"; ?>
                                        </span>
                                        <span class='arsocial_lite_locker_note' style="float:left;">
                                            <?php esc_html_e('For CSS Class information related to Fan Counter,', 'arsocial_lite'); ?>
                                        </span>
                                        <div class="ars_custom_css_info_link arsocial_lite_locker_note" style="float: left;cursor: pointer;"><b>&nbsp;<?php esc_html_e('Please Click Here', 'arsocial_lite'); ?></b></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="arsocial_lite_share_button_wrapper">
        <button type='button' style="margin:15px 0px 0px 80px;" id="save_social_fan_counter_display_settings" class="arsocialshare_save_display_settings"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
        <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
    </div>
</form>
<div class="ars_lite_upgrade_modal" id="ars_lite_pro_global_premium_notice" style="display:none;">
    <div class="upgrade_modal_top_belt">
        <div class="logo" style="text-align:center;"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_update_logo.png" /></div>
        <div id="nav_style_close" class="close_button b-close"><img src="<?php echo ARSOCIAL_LITE_IMAGES_URL; ?>/arsocial_upgrade_close_img.png" /></div>
    </div>
    <div class="upgrade_title"><?php esc_html_e('Upgrade To Premium Version.', 'arsocial_lite'); ?></div>
    <div class="upgrade_message"><?php esc_html_e('To unlock this Feature, Buy Premium Version for $20.00 Only.', 'arsocial_lite'); ?></div>
    <div class="upgrade_modal_btn">
        <button id="pro_upgrade_button"  type="button" class="buy_now_button"><?php esc_html_e('Buy Now', 'arsocial_lite'); ?></button>
        <button id="pro_upgrade_cancel_button"  class="learn_more_button" type="button"><?php esc_html_e('Learn More', 'arsocial_lite'); ?></button>
        <input type="hidden" name="ars_version" id="ars_version" value="<?php global $arsocial_lite_version; echo $arsocial_lite_version;?>" />
        <input type="hidden" name="ars_request_version" id="ars_request_version" value="<?php echo get_bloginfo('version');?>" />
    </div>
</div>