<script type="text/javascript">
    __ARSFanAjaxURL = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<?php
global $wpdb, $arsocial_lite, $arsocial_lite_fan;
$action = isset($_REQUEST['arsocialaction']) ? $_REQUEST['arsocialaction'] : 'new-fan';

$fan_id = isset($_REQUEST['network_id']) ? $_REQUEST['network_id'] : '';
$fan_name = '';
$fan_content = '';
$social_options = array();
$displays = array('page' => 'page');
$arsocialshare_fan_counter_update_time = '';
if ($action !== '' && ($action === 'edit-fan' || $action === 'duplicate' ) && $fan_id !== '') {
    $table = $wpdb->prefix . 'arsocial_lite_fan';
    $fan = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$table` WHERE ID = %d", $fan_id));
    $fan = $fan[0];
    $fan_content = $fan->content;
    $social_options = maybe_unserialize($fan_content);
    $arsocialshare_fan_counter_update_time = $fan->update_time;
    $ars_fan_display_style = $fan->display_type;
    $displays = $social_options['display'];
}
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

$displays['fan_network_order'] = isset($displays['fan_network_order']) ? $displays['fan_network_order'] : array();

$is_fb_enable_fan_like = $is_tw_enable_fan_like = $is_ln_enable_like_fan = $is_pin_enable_like_btn  = $is_vk_enable_fan_like = $is_yt_enable_fan_like = $is_insta_enable_fan_like = false;
?>
<div class="success-message" id="success-message">
</div>

<div class="ars_sticky_top_belt" id="ars_sticky_top_belt">
    <div class="arsocialshare_title_wrapper sticky_top_belt">
        <label class="arsocialshare_page_title"><?php esc_html_e('Social Fan Counter Configuration', 'arsocial_lite'); ?></label>
    </div>
    <img src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="sticky_belt_loader" />
    <div class="ars_share_wrapper" title="<?php esc_html_e('Click to copy', 'arsocial_lite'); ?>" style="<?php echo ($fan_id !== '' && $action !== 'duplicate' ) ? '' : 'display:none;' ?>" >
        <div class="ars_copied" style="position:absolute;top:7px;display:none;"><?php esc_html_e('Copied', 'arsocial_lite'); ?></div>
        <div class="ars_share_shortcode" id="ars_share_shortcode" data-code="[ARSocial_Lite_Fan id=<?php echo $fan_id; ?>]">
            [ARSocial_Lite_Fan id=<?php echo $fan_id; ?>]
        </div>
    </div>
    <button type='button' id="save_social_fan_counter" data-id="sticky_belt" class="arsocialshare_save_display_settings shortcode_generator"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>
    <button value="true" class="arsocialshare_save_display_settings cancel_button" id="ars_cancel_button" name="ars_cancel_button" type="button" onclick="location.href = '<?php echo admin_url('admin.php?page=arsocial-lite-shortcode-generator'); ?>'"><?php esc_html_e('Cancel', 'arsocial_lite'); ?></button>
</div>
<form name="arsocialshare_fancounter" method="post" id="arsocialshare_fancounter" onsubmit="return false;">
    <div class="arsocialshare_main_wrapper">
        <div class="arsocialshare_title_wrapper">
            <label class="arsocialshare_page_title"><?php esc_html_e('Social Fan Counter Configuration', 'arsocial_lite'); ?></label>
        </div>
        <div class="documentation_link" id="documentation_link"><a href="<?php echo ARSOCIAL_LITE_URL . '/documentation/#arsocialshare_networks'; ?>" target="_blank"><span class="arsocialshare_network_btn_icon arsocialshare_default_theme_icon socialshare-support"></span> <?php esc_html_e('Need help?', 'arsocial_lite'); ?></a>&nbsp;&nbsp;<img src="<?php echo ARSOCIAL_LITE_URL; ?>/images/dot.png" height="10" width="10" onclick="javascript:OpenInNewTab('<?php echo ARSOCIAL_LITE_URL; ?>/documentation/assets/sysinfo.php');" /></div>
        <input type="hidden" name='arsfan_ajaxurl' id='arsfan_ajaxurl' value='<?php echo admin_url('admin-ajax.php'); ?>' />
        <input type='hidden' name='arsocial_fan_action' value="<?php echo $action; ?>" />
        <input type='hidden' name='fan_id' value='<?php echo $fan_id; ?>' />
        <input type="hidden" name="arsocialshare_fancounter_order" id="arsocialshare_fancounter_order" value='<?php echo json_encode(maybe_unserialize(isset($displays['fan_network_order']) ? $displays['fan_network_order'] : array())); ?>' />

        <div class="arsocialshare_inner_wrapper" style="padding:0">
            <div class="arsocialshare_networks_inner_wrapper">  

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">1</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e(' Select Position Where You Want To Display Fan Counter', 'arsocial_lite'); ?></div>
                </div>

                <div class="arsocialshare_inner_container" style="padding:30px 5px 25px 30px;">
                    <?php
                    $page_hide_show = '';
                    $page_checked = "";

                    if (is_array($displays) && array_key_exists('page', $displays)) {
                        $page_checked = "checked='checked'";
                        $page_hide_show = "display:block;";
                    }
                    ?>

                    <label class="arsocialshare_inner_container_box two_col ars_shortcode_radio_position <?php echo ($page_checked !== '' ) ? 'selected' : ''; ?>">
                        <div class="arsocialshare_container_box_title_belt">
                            <input type="radio" name="arsocialshare_enable_fan_on" value="page" id="arsocialshare_fan_enable_page" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" <?php echo $page_checked; ?> data-id="enable_sidebar_btns" /><label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_fan_enable_page"><span></span>&nbsp;&nbsp;<?php esc_html_e('Pages', 'arsocial_lite'); ?></label>
                        </div>
                    </label>
                    <?php
                    $sidebar_checked = $sidebar_hide_show = "";
                    $sidebar_options = "display:none;";

                    if (is_array($displays) && array_key_exists('sidebar', $displays)) {
                        $sidebar_checked = "checked='checked'";
                        $sidebar_options = "";
                        $sidebar_hide_show = "display:block;";
                    } else {
                        $displays['sidebar'] = array(
                            'position' => '',
                        );
                    }
                    ?>

                    <label class="arsocialshare_inner_container_box two_col ars_shortcode_radio_position <?php echo ($sidebar_checked !== '' ) ? 'selected' : ''; ?>">
                        <div class="arsocialshare_container_box_title_belt">
                            <input type="radio" name="arsocialshare_enable_fan_on" value="sidebar" id="arsocialshare_fan_enable_sidebar" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" <?php echo $sidebar_checked; ?> data-id="enable_sidebar_btns" /><label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_fan_enable_sidebar"><span></span>&nbsp;&nbsp;<?php esc_html_e('Sidebar', 'arsocial_lite'); ?></label>
                        </div>

                    </label>

                    <?php
                    $ds_checked = $fly_in_is_close_checked = $top_bottom_hide_show = "";
                    $ds_options = $fly_in_onscroll_display = $fly_in_onload_display = "display:none;";

                    if (is_array($displays) && array_key_exists('top_bottom_bar', $displays)) {
                        $ds_checked = "checked='checked'";
                        $top_bottom_hide_show = "display:block;";
                        $ds_options = "";
                    }
                    ?>

                    <label class="arsocialshare_inner_container_box two_col inner_btn_option ars_shortcode_radio_position <?php echo ($ds_checked !== '' ) ? $ds_checked : ''; ?>">
                        <div class="arsocialshare_container_box_title_belt">
                            <input type="radio" name="arsocialshare_enable_fan_on" value="top_bottom_bar" id="arsocialshare_enable_fly_in" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" <?php echo $ds_checked; ?> data-id="enable_fly_in_btns" /><label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_fly_in"><span></span>&nbsp;&nbsp;<?php esc_html_e('Top / Bottom Bar', 'arsocial_lite'); ?></label>
                        </div>

                    </label>

                    <?php
// popup
                    $pop_checked = $is_close_checked = $popup_hide_show = "";
                    $pop_options = $onload_display = $onscroll_display = "display:none;";

                    if (is_array($displays) && array_key_exists('popup', $displays)) {
                        $pop_checked = "checked='checked'";
                        $popup_hide_show = "display:block;";
                        $pop_options = "";
                    }

                    if (isset($displays['popup']) && is_array($displays['popup'])) {
                        
                    } else {
                        $displays['popup'] = array(
                            'onload_type' => '',
                            'open_delay' => '0',
                            'open_scroll' => '50',
                            'onload_type' => '',
                            'popup_width' => '',
                            'popup_height' => '',
                        );
                    }
                    ?>

                    <label class="arsocialshare_inner_container_box two_col inner_btn_option arsocial_lite_position_shortcode_restricted <?php echo ($pop_checked !== '' ) ? 'selected' : ''; ?>">
                        <div class="arsocialshare_container_box_title_belt">
                            <input type="radio" name="arsocialshare_enable_fan_on" value="popup" id="arsocialshare_enable_popup" class="ars_display_option_input arsocialshare_radio_input ars_hide_radio" data-id="enable_popup" <?php echo $pop_checked; ?>  />
                            <label class="arsocialshare_container_box_title arsocialshare_radio_input_lable" for="arsocialshare_enable_popup"><span></span>&nbsp;&nbsp;<?php esc_html_e('Popup', 'arsocial_lite'); ?></label>&nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span>
                        </div>
                    </label>
                </div>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">2</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Networks', 'arsocial_lite'); ?></div>
                </div>
                <span class="ars_error_message" id="arsocialshare_fan_network_error"><?php esc_html_e('Please select atleast one network.', 'arsocial_lite'); ?></span>
                <div class="arsocialshare_inner_container arsocialshare_fancounter_settings arsocialshare_sharing_sortable" id="arsocialshare_fan_counter" style="padding:30px 5px 25px 30px;" >
                    <div class="arsocialshare_social_box <?php echo $fbClassBtn; ?>" title=" <?php echo $fbDisableNotice; ?>" id="facebook" data-listing-order="1">
                        <input type="hidden" name="arsocialshare_fancounter_networks[]" value="facebook" class="arsocialshare_fan_networks" />
                        <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'facebook');" class="arsocialshare_fan_network_input" name='active_fb_fan' id='active_fb_fan' value='1' <?php echo $fbChecked; ?> />
                        <label for="active_fb_fan"><span></span></label>
                        <div class="arsocialshare_network_icon facebook"></div>
                        <div class="arsocialshare_social_box_title">
                            <label for="active_fb_fan"><?php esc_html_e('Facebook', 'arsocial_lite'); ?></label>
                        </div>
                        <span class="arsocialshare_move_icon"></span>
                        <div class="arsocialshare_box_container" id="arsocialshare_box_facebook_container" style="display: none;<?php
                        if (isset($social_options['facebook']['active_fb_fan']) ? $social_options['facebook']['active_fb_fan'] : '' == 1) {
                            echo 'display:block';
                        }
                        ?>  ">
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile Id', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_url' value="<?php echo isset($social_options['facebook']['fb_fan_url']) ? $social_options['facebook']['fb_fan_url'] : ''; ?>" name='arsocialshare_fb_fan_url' style="width:90%;" />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile Type', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>

                                    <select id='arsocialshare_fb_fan_account_type' class="arsocialshare_dropdown" name='arsocialshare_fb_fan_account_type' style="width:90%;">
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
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_access_token' value="<?php echo isset($social_options['facebook']['fb_fan_access_token']) ? $social_options['facebook']['fb_fan_access_token'] : ''; ?>" name='arsocialshare_fb_fan_access_token' style="width:90%;" />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Manual Counter', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_manual_counter' value="<?php echo isset($social_options['facebook']['manual_counter']) ? $social_options['facebook']['manual_counter'] : ''; ?>" name='arsocialshare_fb_fan_manual_counter' style="width:90%;"/>
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Fan Text', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_fb_fan_text' value="<?php echo isset($social_options['facebook']['fan_text']) ? $social_options['facebook']['fan_text'] : 'FANS'; ?>" name='arsocialshare_fb_fan_text' style="width:90%;"/>
                                </div>
                            </div>
                            <div class="arsocialshare_box_row arsocialshare_row_margin" id="fb_like_btn_wrapper" style="<?php echo (isset($social_options['facebook']['account_type']) && $social_options['facebook']['account_type'] === 'page') ? '' : 'display:none;'; ?>">
                                <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Enable Like Button', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type="checkbox" id="enable_fb_like" class="arsocialshare_fan_network_input" <?php isset($social_options['facebook']['enable_like_btn']) ? checked($social_options['facebook']['enable_like_btn'], 1) : ''; ?> value="1" name="enable_fb_like" /><label for="enable_fb_like"><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                </div>
                            </div>
                            <?php
                            $is_fb_enable_fan_like = ( isset($social_options['facebook']['active_fb_fan']) && $social_options['facebook']['active_fb_fan'] == 1 && isset($social_options['facebook']['enable_like_btn']) && $social_options['facebook']['enable_like_btn'] == 1 && isset($social_options['facebook']['account_type']) && $social_options['facebook']['account_type'] === 'page' ) ? true : false;
                            ?>
                        </div>
                    </div>

                    <div class="arsocialshare_social_box <?php echo $twClassBtn; ?>" title=" <?php echo $twDisableNotice; ?>" id="twitter" data-listing-order="2">
                        <input type="hidden" name="arsocialshare_fancounter_networks[]" value="twitter" class="arsocialshare_fan_networks" />
                        <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'twitter');" class="arsocialshare_fan_network_input" name='active_twitter_fan' id='active_twitter_fan' value='1' <?php echo $twChecked; ?> />
                        <label for="active_twitter_fan"><span></span></label>
                        <div class="arsocialshare_network_icon twitter"></div>
                        <div class="arsocialshare_social_box_title">
                            <label for="active_twitter_fan"><?php esc_html_e('Twitter', 'arsocial_lite'); ?></label>
                        </div>
                        <span class="arsocialshare_move_icon"></span>
                        <div class="arsocialshare_box_container" id="arsocialshare_box_twitter_container" style="display: none;<?php
                        if (isset($social_options['twitter']['active_twitter_fan']) ? $social_options['twitter']['active_twitter_fan'] : '' == 1) {
                            echo 'display:block';
                        }
                        ?>">
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Username', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_username' value="<?php echo isset($social_options['twitter']['twitter_fan_username']) ? $social_options['twitter']['twitter_fan_username'] : ''; ?>" name='arsocialshare_twitter_fan_username' style="width:90%;" />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Consumer Key', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_consumer_key' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_key']) ? $social_options['twitter']['twitter_fan_consumer_key'] : ''; ?>" name='arsocialshare_twitter_fan_consumer_key' style="width:90%;" />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Consumer Secret', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_consumer_secret' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_secret']) ? $social_options['twitter']['twitter_fan_consumer_secret'] : ''; ?>" name='arsocialshare_twitter_fan_consumer_secret' style="width:90%;" />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_access_token' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_access_token']) ? $social_options['twitter']['twitter_fan_consumer_access_token'] : ''; ?>" name='arsocialshare_twitter_access_token' style='width:90%;' />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token Secret', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_token_secret' value="<?php echo isset($social_options['twitter']['twitter_fan_consumer_access_token_secret']) ? $social_options['twitter']['twitter_fan_consumer_access_token_secret'] : ''; ?>" name='arsocialshare_twitter_token_secret' style='width:90%;' />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Manual Counter', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_twiiter_fan_manual_counter' value="<?php echo isset($social_options['twitter']['manual_counter']) ? $social_options['twitter']['manual_counter'] : ''; ?>" name='arsocialshare_twitter_fan_manual_counter' style="width:90%;"/>
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Fan Text', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_twitter_fan_text' value="<?php echo isset($social_options['twitter']['fan_text']) ? $social_options['twitter']['fan_text'] : 'FOLLOWERS'; ?>" name='arsocialshare_twitter_fan_text' style="width:90%;"/>
                                </div>
                            </div>
                            <div class="arsocialshare_box_row arsocialshare_row_margin">
                                <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Enable Follow Button', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_box_input">
                                    <input type="checkbox" class="arsocialshare_fan_network_input" id="enable_tw_follow" <?php isset($social_options['twitter']['enable_like_btn']) ? checked($social_options['twitter']['enable_like_btn'], 1) : ''; ?> value="1" name="enable_tw_follow" />
                                    <label for="enable_tw_follow"><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                </div>
                            </div>
                            <?php
                            $is_tw_enable_fan_like = ( isset($social_options['twitter']['active_twitter_fan']) && $social_options['twitter']['active_twitter_fan'] == 1 && isset($social_options['twitter']['enable_like_btn']) && $social_options['twitter']['enable_like_btn'] == 1) ? true : false;
                            ?>
                        </div>
                    </div>

                    <div class="arsocialshare_social_box <?php echo $liClassBtn; ?>" title=" <?php echo $liDisableNotice; ?>" id="linkedin" data-listing-order="4">
                        <input type="hidden" name="arsocialshare_fancounter_networks[]" value="linkedin" class="arsocialshare_fan_networks" />
                        <input type='checkbox' class="arsocialshare_fan_network_input" onclick="ars_fan_counter_active_deactive(this, 'linkedin');" name='active_linkedin_fan' id='active_linkedin_fan' value='1' <?php echo $liChecked; ?> />
                        <label for="active_linkedin_fan"><span></span></label>
                        <div class="arsocialshare_network_icon linkedin"></div>
                        <div class="arsocialshare_social_box_title">
                            <label for="active_linkedin_fan"><?php esc_html_e('Linkedin', 'arsocial_lite'); ?></label>
                        </div>
                        <span class="arsocialshare_move_icon"></span>
                        <div class="arsocialshare_box_container" id="arsocialshare_box_linkedin_container" style="display: none;<?php
                        if (isset($social_options['linkedin']['active_linkedin_fan']) ? $social_options['linkedin']['active_linkedin_fan'] : '' == 1) {
                            echo 'display:block';
                        }
                        ?>">
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile URL/Page URL', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_url' value="<?php echo isset($social_options['linkedin']['linkedin_fan_url']) ? $social_options['linkedin']['linkedin_fan_url'] : ''; ?>" name='arsocialshare_linkedin_fan_url' style="width:90%;" />&nbsp;<span class="arsocialshare_tooltip" title="<?php esc_html_e('Set an URL of Linked IN Company page or profile .', 'arsocial_lite'); ?>">(?)</span>
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Access Token', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_access_token' value="<?php echo isset($social_options['linkedin']['linkedin_fan_access_token']) ? $social_options['linkedin']['linkedin_fan_access_token'] : ''; ?>" name='arsocialshare_linkedin_fan_access_token' style="width:90%;" />
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Profile Type', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>

                                    <select id='arsocialshare_ln_fan_account_type' class="arsocialshare_dropdown" name='arsocialshare_linkedin_fan_account_type' style="width:90%;">
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
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Manual Counter', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_manual_counter' value="<?php echo isset($social_options['linkedin']['manual_counter']) ? $social_options['linkedin']['manual_counter'] : ''; ?>" name='arsocialshare_linkedin_fan_manual_counter' style="width:90%;"/>
                                </div>
                            </div>
                            <div class='arsocialshare_box_row arsocialshare_row_margin'>
                                <div class='arsocialshare_box_label arsocialshare_label_margin'><?php esc_html_e('Fan Text', 'arsocial_lite'); ?></div>
                                <div class='arsocialshare_box_input'>
                                    <input type='text' class='arsocialshare_input_box' id='arsocialshare_linkedin_fan_text' value="<?php echo isset($social_options['linkedin']['fan_text']) ? $social_options['linkedin']['fan_text'] : 'FOLLOWERS'; ?>" name='arsocialshare_linkedin_fan_text' style="width:90%;"/>
                                </div>
                            </div>
                            <div class="arsocialshare_box_row arsocialshare_row_margin" id="ars_fan_linkedin_like_btn_wrapper" style="<?php echo (isset($social_options['linkedin']['account_type']) && $social_options['linkedin']['account_type'] === 'page' ) ? '' : 'display:none;'; ?>">
                                <div class="arsocialshare_box_label arsocialshare_label_margin"><?php esc_html_e('Enable follow Button', 'arsocial_lite'); ?></div>
                                <div class="arsocialshare_box_input">
                                    <input type="checkbox" name="enable_IN_follow" id="enable_IN_follow" value="1" class="arsocialshare_fan_network_input" <?php isset($social_options['linkedin']['enable_like_btn']) ? checked($social_options['linkedin']['enable_like_btn'], 1) : ''; ?> /><label for="enable_IN_follow"><span></span><?php esc_html_e('Yes', 'arsocial_lite'); ?></label>
                                </div>
                            </div>
                            <div class="arsocialshare_box_row arsocialshare_row_margin" id="ars_fan_linkedin_id_wrapper" style="<?php echo (isset($social_options['linkedin']['account_type']) && $social_options['linkedin']['account_type'] === 'page' && isset($social_options['linkedin']['enable_like_btn']) && $social_options['linkedin']['enable_like_btn'] == 1 ) ? '' : 'display:none;'; ?>">
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
                <div class="arsocialshare_inner_container arsocialshare_fancounter_settings" id="arsocialshare_fan_counter" style="padding:0px 5px 25px 30px;" >
                    <div class="ars_lite_pro_networks_info"><span class='ars_lite_pro_version_info'>( <?php esc_html_e('Available in premium version', 'arsocial_lite'); ?> )</span></div>
                    <div class="arsocialshare_social_box_disabled" id="pinterest" data-listing-order="5">
                        <input type="hidden" name="arsocialshare_fancounter_networks[]" value="pinterest" class="arsocialshare_fan_networks" />
                        <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'pinterest');" class="arsocialshare_fan_network_input" name='active_pinterest_fan' id='active_pinterest_fan' value='1' />
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
                        <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'instagram');" class="arsocialshare_fan_network_input" name='active_instagram_fan' id='active_instagram_fan' value='1'  />
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
                        <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'dribbble');" class="arsocialshare_fan_network_input" name='active_dribbble_fan' id='active_dribbble_fan' value='1' />
                        <label for="active_dribbble_fan"><span></span></label>
                        <div class="arsocialshare_network_icon dribbble"></div>
                        <div class="arsocialshare_social_box_title">
                            <label for="active_dribbble_fan"><?php esc_html_e('Dribbble', 'arsocial_lite'); ?></label>
                        </div>

                    </div>

                    <div class="arsocialshare_social_box_disabled <?php // echo $vkClassBtn; ?>" title=" <?php // echo $vkDisableNotice; ?>" id="vk" data-listing-order="10">
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
                        <input type='checkbox' onclick="ars_fan_counter_active_deactive(this, 'foursquare');" class="arsocialshare_fan_network_input" name='active_foursquare_fan' id='active_foursquare_fan' value='1'  />
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
                <?php
                $enable_fan_like_position = false;
                if ($is_fb_enable_fan_like || $is_tw_enable_fan_like || $is_ln_enable_fan_like || $is_pin_enable_like_btn || $is_yt_enable_fan_like || $is_insta_enable_fan_like) {
                    $enable_fan_like_position = true;
                }
                ?>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">3</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Select Template & Style', 'arsocial_lite'); ?></div>
                </div>

                <div class='arsocialshare_inner_container' style="padding:30px 5px 25px 30px;">

                    <?php
                    $display_style = $sociallike_tab_option['display_style']['display_style'];
                    $ars_fan_display_style = isset($social_options['display_style']) ? $social_options['display_style'] : 'metro';
                    ?>
                    <div class="arsocialshare_option_container ars_column">
                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Select Template', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <select name="arsocialfan_display_style" class="arsocialshare_dropdown ars_lite_pro_options" id="arsocialfan_display_style_select">
                                    <?php foreach ($display_style as $key => $value) { ?>
                                        <option <?php selected($ars_fan_display_style, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="arsocialshare_inner_option_label more_templates_label" ><?php esc_html_e('(More templates are available in pro version)', 'arsocial_lite'); ?></label>
                        </div>

                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Number Format', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <select id='arsocialshare_display_number_format' name='arsocialshare_display_number_format' class="arsocialshare_dropdown">
                                    <?php
                                    $counter_number_format = $sociallike_tab_option['counter_number_format']['counter_number_format'];
                                    $social_options['display_number_format'] = isset($social_options['display_number_format']) ? $social_options['display_number_format'] : 'style1';
                                    foreach ($counter_number_format as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php
                                        if ($key == $social_options['display_number_format']) {
                                            echo 'selected';
                                        }
                                        ?> > <?php echo $value; ?> </option>
                                            <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show " id="ars_share_alignment" style="display:none;<?php echo $page_hide_show . $top_bottom_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Alignment', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <?php
                                $topbottom_btn_align = isset($social_options['ars_btn_align']) ? $social_options['ars_btn_align'] : 'ars_align_center';
                                ?>
                                <input type="radio" name="ars_btn_align" id="ars_top_bottom_btn_left" <?php checked($topbottom_btn_align, 'ars_align_left'); ?> value="ars_align_left" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                <input type="radio" name="ars_btn_align" id="ars_top_bottom_btn_center" <?php checked($topbottom_btn_align, 'ars_align_center'); ?> value="ars_align_center" class="ars_hide_checkbox ars_top_bottom_btn_align_input"  />
                                <input type="radio" name="ars_btn_align" id="ars_top_bottom_btn_right" <?php checked($topbottom_btn_align, 'ars_align_right'); ?> value="ars_align_right" class="ars_hide_checkbox ars_top_bottom_btn_align_input" />
                                <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'ars_align_left') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_left_img" data-value="left" onclick="ars_select_radio_img('ars_top_bottom_btn_left', 'ars_top_bottom_btn_align');">
                                    <span class="arsocialshare_inner_option_icon button_align_left"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'ars_align_center') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_center_img" data-value="medium" onclick="ars_select_radio_img('ars_top_bottom_btn_center', 'ars_top_bottom_btn_align');">
                                    <span class="arsocialshare_inner_option_icon button_align_center"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Center', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_inner_option_box ars_top_bottom_btn_align <?php echo ($topbottom_btn_align === 'ars_align_right') ? 'selected' : ''; ?>" id="ars_top_bottom_btn_right_img" data-value="large" onclick="ars_select_radio_img('ars_top_bottom_btn_right', 'ars_top_bottom_btn_align');">
                                    <span class="arsocialshare_inner_option_icon button_align_right"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show" id="ars_top_bottombar_displaybar" style="display:none;<?php echo $top_bottom_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <?php
                                $display_bar_on = isset($displays['top_bottom_bar']['onload_type']) ? $displays['top_bottom_bar']['onload_type'] : 'onload';
                                ?>
                                <select class="arsocialshare_dropdown" name="arsocialshare_top_bottom_bar_display_on" id="arsocialshare_top_bottom_bar_display_on">
                                    <option <?php selected($display_bar_on, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                    <option <?php selected($display_bar_on, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_popup_hide_show" style="display:none;<?php echo $popup_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <?php
                                $display_popup = isset($displays['popup']['onload_type']) ? $displays['popup']['onload_type'] : 'onload';
                                ?>
                                <select class="arsocialshare_dropdown" name="arsocialshare_popup_display_on" id="arsocialshare_popup_display_on">
                                    <option <?php selected($display_popup, 'onload'); ?> value="onload"><?php esc_html_e('On Load', 'arsocial_lite'); ?></option>
                                    <option <?php selected($display_popup, 'onscroll'); ?> value="onscroll"><?php esc_html_e('On Scroll', 'arsocial_lite'); ?></option>
                                </select>
                            </div>
                        </div>
                        <?php
                        $popup_onload_desplay = $popup_onscroll_desplay = '';
                        if ($display_popup == 'onload' && $pop_checked != '') {
                            $popup_onload_desplay = 'display:block;';
                        } else if ($display_popup = 'onscroll' && $pop_checked != '') {
                            $popup_onscroll_desplay = 'display:block;';
                        }
                        ?>
                        <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option <?php echo ($display_popup === 'onload' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_load_wrapper" style="display:none;<?php echo $popup_onload_desplay; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n seconds', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="text" name="arsocialshare_popup_onload_time" id="arsocialshare_popup_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['open_delay']) ? $displays['popup']['open_delay'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option <?php echo ($display_popup === 'onscroll' ) ? 'selected' : ''; ?>" id="arsocialshare_popup_on_scroll_wrapper" style="display:none;<?php echo $popup_onscroll_desplay; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Display Popup After n % of scroll', 'arsocial_lite') ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="text" name="arsocialshare_popup_onscroll_percentage" id="arsocialshare_popup_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['open_scroll']) ? $displays['popup']['open_scroll'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option" style="display:none;<?php echo $popup_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Popup Height', 'arsocial_lite') ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="text" name="arsocialshare_popup_height" id="arsocialshare_popup_height" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['popup_height']) ? $displays['popup']['popup_height'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> px </span>
                            </div>
                            <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto height.', 'arsocial_lite'); ?></span>
                        </div>

                        <div class="arsocialshare_option_row ars_popup_hide_show arsocialshare_display_bar_option" style="display:none;<?php echo $popup_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Popup Width', 'arsocial_lite') ?></div>
                            <div class="arsocialshare_option_input">

                                <input type="text" name="arsocialshare_popup_width" id="arsocialshare_popup_width" class="arsocialshare_input_box" value="<?php echo isset($displays['popup']['popup_width']) ? $displays['popup']['popup_width'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> px </span>
                            </div>
                            <span class="ars_speical_note"><?php esc_html_e('Leave blank for auto width.', 'arsocial_lite'); ?></span>
                        </div>

                        <?php
                        $ars_onload_show = $ars_onscroll_show = '';
                        if ($display_bar_on == 'onload' && $ds_checked != '') {
                            $ars_onload_show = 'display:block;';
                        } else if ($display_bar_on == 'onscroll' && $ds_checked != '') {
                            $ars_onscroll_show = 'display:block;';
                        }
                        ?>
                        <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show arsocialshare_display_bar_option <?php echo ($display_bar_on === 'onload') ? 'selected' : ''; ?>" id="arsocialshare_on_load_wrapper" style="display:none;<?php echo $ars_onload_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n seconds', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="text" name="arsocialshare_top_bottom_bar_onload_time" id="arsocialshare_top_bottom_bar_onload_time" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['onload_time']) ? $displays['top_bottom_bar']['onload_time'] : '0'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"><?php esc_html_e('seconds', 'arsocial_lite'); ?></span>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row arsocialshare_display_bar_option ars_dipsplay_bar_hide_show <?php echo ($display_bar_on === 'onscroll') ? 'selected' : ''; ?>" id="arsocialshare_on_scroll_wrapper" style="display:none;<?php echo $ars_onscroll_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Display Bar After n % of scroll', 'arsocial_lite') ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="text" name="arsocialshare_top_bottom_bar_onscroll_percentage" id="arsocialshare_top_bottom_bar_onscroll_percentage" class="arsocialshare_input_box" value="<?php echo isset($displays['top_bottom_bar']['onscroll_percentage']) ? $displays['top_bottom_bar']['onscroll_percentage'] : '50'; ?>" /><span class="arsocialshare_network_note" style="left:5px; top:8px;"> % </span>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_dipsplay_bar_hide_show" id="ars_position_top_bottom_bar_position" style="<?php echo (is_array($displays) && array_key_exists('top_bottom_bar', $displays)) ? 'display:block;' : 'display:none;'; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Start top bar from Y Position', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="text" class="arsocialshare_input_box" name="ars_fan_top_bar_y_position" id="ars_fan_top_bar_y_position" value="<?php echo isset($displays['top_bottom_bar']['y_point']) ? $displays['top_bottom_bar']['y_point'] : ''; ?>" /><span class="arsocialshare_network_note" style="left:5px;top:5px;"> px </span>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row" id='ars_position_top_bottom_bar' style="display:none;<?php echo $top_bottom_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <?php
                                $top_bar_checked = "";
                                $bottom_bar_checked = "";

                                $top_bottom_position = (isset($displays['top_bottom_bar']['position']) && !empty($displays['top_bottom_bar']['position'])) ? $displays['top_bottom_bar']['position'] : 'top_bar';
                                ?>
                                <input type="radio" name="arsocialshare_top_bar" value="top_bar" data-on="top_bar" <?php checked($top_bottom_position, 'top_bar') ?> class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_top" />
                                <input type="radio" name="arsocialshare_top_bar" value="bottom_bar" <?php checked($top_bottom_position, 'bottom_bar') ?>  data-on="bottom_bar" class="arsocialshare_display_networks_on ars_hide_checkbox" id="arsocialshare_buttons_on_bottom" />
                                <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($top_bottom_position == 'top_bar' ) ? "selected" : ""; ?>" onclick="ars_select_radio_img('arsocialshare_buttons_on_top', 'arsocialshare_bar_position');" id="arsocialshare_buttons_on_top_img" data-value="top">
                                    <span class="arsocialshare_inner_option_icon top_bar"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Top', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_inner_option_box arsocialshare_bar_position <?php echo ($top_bottom_position == 'bottom_bar' ) ? "selected" : ""; ?>" onclick="ars_select_radio_img('arsocialshare_buttons_on_bottom', 'arsocialshare_bar_position');" id="arsocialshare_buttons_on_bottom_img" data-value="right">
                                    <span class="arsocialshare_inner_option_icon bottom_bar"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row" id="ars_lite_sidebar_position" style="display:none;<?php echo $sidebar_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Position', 'arsocial_lite'); ?></div>
                            <?php $sidebar_position = (isset($displays['sidebar']['position']) && !empty($displays['sidebar']['position'])) ? $displays['sidebar']['position'] : 'left' ?>
                            <div class="arsocialshare_option_input">
                                <input type="radio" name="arsocialshare_sidebar" value="left" data-on="sidebar_left" <?php checked($sidebar_position, 'left'); ?> class="ars_fan_sidebar_position_radio_gs ars_hide_checkbox" id="arsocialshare_sidebar_buttons_on_left" />
                                <input type="radio" name="arsocialshare_sidebar" value="right" data-on="sidebar_right" <?php checked($sidebar_position, 'right'); ?> class="ars_fan_sidebar_position_radio_gs ars_hide_checkbox" id="arsocialshare_sidebar_buttons_on_right" />
                                <div class="arsocialshare_inner_option_box arsocialshare_sidebar_position <?php echo ($sidebar_position === 'left') ? "selected" : ""; ?>" id="arsocialshare_sidebar_buttons_on_left_img" data-value="left" onclick="ars_select_radio_img('arsocialshare_sidebar_buttons_on_left', 'arsocialshare_sidebar_position')">
                                    <span class="arsocialshare_inner_option_icon sidebar_left"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Left', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_inner_option_box arsocialshare_sidebar_position <?php echo ($sidebar_position === 'right') ? "selected" : ""; ?>" id="arsocialshare_sidebar_buttons_on_right_img" data-value="right" onclick="ars_select_radio_img('arsocialshare_sidebar_buttons_on_right', 'arsocialshare_sidebar_position')">
                                    <span class="arsocialshare_inner_option_icon sidebar_right"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Right', 'arsocial_lite'); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="arsocialshare_option_container ars_column ars_no_border" style="padding-left:25px;">
                        <?php $ars_btn_width = isset($social_options['ars_btn_width']) ? $social_options['ars_btn_width'] : 'small'; ?>
                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Button Width', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="radio" name="ars_btn_width" id="ars_lite_sidebar_btn_small" value="small" class="ars_hide_checkbox ars_fan_btn_width_input_gs" <?php checked($ars_btn_width, 'small'); ?> />
                                <input type="radio" name="ars_btn_width" id="ars_lite_sidebar_btn_medium" value="medium" class="ars_hide_checkbox ars_fan_btn_width_input_gs" <?php checked($ars_btn_width, 'medium'); ?>   />
                                <input type="radio" name="ars_btn_width" id="ars_lite_sidebar_btn_large" value="large" class="ars_hide_checkbox ars_fan_btn_width_input_gs" <?php checked($ars_btn_width, 'large'); ?>/>
                                <div class="arsocialshare_inner_option_box ars_lite_sidebar_btn_width <?php echo ($ars_btn_width === 'small') ? 'selected' : ''; ?>" id="ars_lite_sidebar_btn_small_img" data-value="small" onclick="ars_select_radio_img('ars_lite_sidebar_btn_small', 'ars_lite_sidebar_btn_width')">
                                    <span class="arsocialshare_inner_option_icon button_width_small"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Small', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_inner_option_box ars_lite_sidebar_btn_width <?php echo ($ars_btn_width === 'medium') ? 'selected' : ''; ?>" id="ars_lite_sidebar_btn_medium_img" data-value="medium" onclick="ars_select_radio_img('ars_lite_sidebar_btn_medium', 'ars_lite_sidebar_btn_width')">
                                    <span class="arsocialshare_inner_option_icon button_width_medium"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Medium', 'arsocial_lite'); ?></label>
                                </div>
                                <div class="arsocialshare_inner_option_box ars_lite_sidebar_btn_width <?php echo ($ars_btn_width === 'large') ? 'selected' : ''; ?>" id="ars_lite_sidebar_btn_large_img" data-value="large" onclick="ars_select_radio_img('ars_lite_sidebar_btn_large', 'ars_lite_sidebar_btn_width')">
                                    <span class="arsocialshare_inner_option_icon button_width_large"></span>
                                    <label class="arsocialshare_inner_option_label ars_bottom_label"><?php esc_html_e('Large', 'arsocial_lite'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row" id="fc_more_button" style="<?php echo ($pop_checked !== '' ) ? 'display:none' : ''; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('More Button After', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <input type="text" name="arsocialshare_more_button" class="arsocialshare_input_box" id="arsocialshare_sidebar_more_button" value="<?php echo isset($social_options['arsocialshare_more_button']) ? $social_options['arsocialshare_more_button'] : '5' ?>" />
                            </div>
                        </div>

                        <div class="arsocialshare_option_row" id="fc_more_button_style" style="<?php echo ($pop_checked !== '' ) ? 'display:none' : ''; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('More Button Style', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <select name="arsocialshare_sidebar_more_button_style" id="arsocialshare_sidebar_more_button_style" class="arsocialshare_dropdown">
                                    <?php $more_button_style = isset($social_options['arsocialshare_sidebar_more_button_style']) ? $social_options['arsocialshare_sidebar_more_button_style'] : 'plus_icon'; ?>
                                    <option value="plus_icon" <?php selected($more_button_style, 'plus_icon'); ?>><?php esc_html_e('Plus icon', 'arsocial_lite'); ?></option>
                                    <option value="dot_icon" <?php selected($more_button_style, 'dot_icon'); ?>><?php esc_html_e('Dot icon', 'arsocial_lite'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row" id="fc_more_button_action" style="<?php echo ($pop_checked !== '' ) ? 'display:none' : ''; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('More Button action', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <?php
                                $more_button_action = isset($social_options['arsocialshare_more_button_action']) ? $social_options['arsocialshare_more_button_action'] : 'display_inline';
                                ?>
                                <select name="arsocialshare_more_button_action" id="arsocialshare_sidebar_more_button_action" class="arsocialshare_dropdown" style="width:245px;">
                                    <option value="display_inline" <?php selected($more_button_action, 'display_inline'); ?>><?php esc_html_e('All networks after more button', 'arsocial_lite'); ?></option>
                                    <option value="display_popup" <?php selected($more_button_action, 'display_popup'); ?>><?php esc_html_e('All networks in Popup', 'arsocial_lite'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Hide On Mobile', 'arsocial_lite'); ?>&nbsp;&nbsp;<span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                            <div class="arsocialshare_option_input">
                                <input type="hidden" name="arsocialshare_mobile_hide" id="arsocialshare_mobile_hide" value="no" />
                                <div class="arsocialshare_switch arsocial_lite_restrict_shortcode_mobile" id="hide_on_mobile" data-id="arsocialshare_mobile_hide">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_popup_hide_show" style="display:none;<?php echo $popup_hide_show; ?>">
                            <div class="arsocialshare_option_label"><?php esc_html_e('Show Close Button', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <?php $is_close_button = isset($displays['popup']['ars_fan_pop_show_close_button']) ? $displays['popup']['ars_fan_pop_show_close_button'] : 'yes'; ?>
                                <input type="hidden" name="ars_fan_pop_show_close_button" id="ars_fan_pop_show_close_button" value="<?php echo $is_close_button; ?>" />
                                <div class="arsocialshare_switch <?php echo ( $is_close_button === 'yes' ) ? 'selected' : ''; ?>" id="ars_fan_pop_show_close_button" data-id="ars_fan_pop_show_close_button">
                                    <div class="arsocialshare_switch_options">
                                        <div class="arsocialshare_switch_label" data-action="true" data-value="yes"><?php esc_html_e('Yes', 'arsocial_lite'); ?></div>
                                        <div class="arsocialshare_switch_label" data-action="false" data-value="no"><?php esc_html_e('No', 'arsocial_lite'); ?></div>
                                    </div>
                                    <div class="arsocialshare_switch_button"></div>
                                </div>
                            </div>
                        </div>

                        <div class="arsocialshare_option_row ars_fan_button_position_wrapper" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>" >
                            <div class="arsocialshare_option_label"><?php esc_html_e('Like / Follow Button Position', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input">
                                <?php $arsfan_like_follow_btn_position = isset($social_options['ars_fan_like_follow_btn_position']) ? $social_options['ars_fan_like_follow_btn_position'] : 'top'; ?>
                                <select name="arsfan_like_follow_position" id="arsfan_like_follow_position" class="arsocialshare_dropdown">
                                    <option <?php selected($arsfan_like_follow_btn_position, 'top'); ?> value="top"><?php esc_html_e('Top', 'arsocial_lite'); ?></option>
                                    <option <?php selected($arsfan_like_follow_btn_position, 'bottom'); ?> value="bottom"><?php esc_html_e('Bottom', 'arsocial_lite'); ?></option>
                                    <option <?php selected($arsfan_like_follow_btn_position, 'left'); ?> value="left"><?php esc_html_e('Left', 'arsocial_lite'); ?></option>
                                    <option <?php selected($arsfan_like_follow_btn_position, 'right'); ?> value="right"><?php esc_html_e('Right', 'arsocial_lite'); ?></option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="arsocialshare_option_container ars_column ars_no_border">
                        <div class="ars_template_preview_container ars_fan_btn_preview" id="ars_fan_counter_preview" style="margin-top:-15px;">
                            <div class="arsocialshare_fan_preview_container ars_fan_counter_main_preview arslite_<?php echo $ars_btn_width; ?>_fan_button" id="ars_fan_counter_main_preview" style="display:none;<?php echo $page_hide_show . $top_bottom_hide_show . $popup_hide_show; ?>">
                                <?php foreach ($display_style as $key => $value): ?>
                                    <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($ars_fan_display_style == $key) ? 'display:block;' : ''; ?>">
                                        <ul>
                                            <li class="ars_fan_network-facebook">
                                                <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
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
                            <div class="arsocialshare_fan_preview_container ars_fan_counter_sidebar_preview ars_<?php echo $ars_btn_width; ?>_fan_button ars_<?php echo $sidebar_position; ?>_buttons" id="ars_fan_counter_sidebar_preview_gs" style="display:none;<?php echo $sidebar_hide_show; ?>">
                                <?php foreach ($display_style as $key => $value): ?>
                                    <div class="ars_fan_preview_block ars_lite_fan_main_wrapper ars_fan_<?php echo $key; ?>" style="<?php echo ($ars_fan_display_style == $key) ? 'display:block;' : ''; ?>">
                                        <ul>
                                            <li class="ars_fan_network-facebook">
                                                <div class="ars_fan_like_wrapper ars_<?php echo $arsfan_like_follow_btn_position; ?>" style="<?php echo ( $enable_fan_like_position ) ? "" : "display:none;" ?>">
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
                </div>

                <div class="arsocialshare_title_belt">
                    <div class="arsocialshare_title_belt_number">5</div>
                    <div class="arsocialshare_belt_title"><?php esc_html_e('Custom CSS', 'arsocial_lite'); ?> <span class='ars_lite_pro_version_info'>( <?php esc_html_e('Pro Version', 'arsocial_lite'); ?> )</span></div>
                </div>

                <div class="ars_network_list_container selected" style="width:100%;">
                    <div class="arsocialshare_option_container ars_column ars_no_border" style="width:100%; padding-top:0;  ">
                        <div class="arsocialshare_option_row" style="padding-bottom: 0px;">
                            <div class="arsocialshare_option_label" style="width: 12%; line-height: 25px;"><?php esc_html_e('Enter Custom CSS', 'arsocial_lite'); ?></div>
                            <div class="arsocialshare_option_input arsocial_lite_custom_css_shortcode_restricted" style="width: 88%;">
                                <div class="arshare_opt_checkbox_row">
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%">
                                        <textarea style="width:700px;height:200px;padding:5px 10px !important;" name="arsocialshare_fan_customcss" id="arsocialshare_fan_customcss" class="ars_display_option_input" readonly="readonly"></textarea>
                                    </div>
                                    <div class="arsocialshare_opt_inner_input_wrapper" style="width: 100%; margin-top:10px; ">
                                        <span class='arsocial_lite_locker_note' style="width: 100%;">
                                            <?php echo "eg: .arsocial_lite_fan_top_button { background-color: #d1d1d1; }"; ?>
                                        </span>
                                        <span class='arsocial_lite_locker_note' style="float:left;">
                                            <?php esc_html_e('For CSS Class information related to fan counters,', 'arsocial_lite'); ?>
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
        <div class="arsocial_lite_share_button_wrapper">
            <div class="ars_save_loader_bottom">&nbsp;
                <img  src="<?php echo ARSOCIAL_LITE_IMAGES_URL . '/loader.gif' ?>" class="arsocialshare_save_loader" />
            </div>
            <button type='button' id="save_social_fan_counter" style="margin:15px 0px 0px 15px;" class="arsocialshare_save_display_settings"><?php esc_html_e('Save', 'arsocial_lite'); ?></button>

            <button value="true" class="arsocialshare_save_display_settings cancel_button bottom_button" id="ars_cancel_button" name="ars_cancel_button" type="button" onclick="location.href = '<?php echo admin_url('admin.php?page=arsocial-lite-shortcode-generator'); ?>'"><?php esc_html_e('Cancel', 'arsocial_lite'); ?></button>

        </div>
    </div>
</form>

<div class="ars_lite_upgrade_modal" id="ars_lite_pro_shortcode_premium_notice" style="display:none;">
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